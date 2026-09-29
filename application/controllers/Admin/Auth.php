<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Admin Login Screen & Verification
     */
    public function login() {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('admin_logged_in')) {
            redirect('admin/dashboard');
            return;
        }

        $data['page_title'] = 'Log HARDWARE - Admin Login';
        $data['error'] = $this->session->flashdata('error');

        // Handle POST Authentication
        if ($this->input->method(TRUE) === 'POST') {
            $this->form_validation->set_rules('email', 'Email / Staff ID', 'trim|required|valid_email');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');

            if ($this->form_validation->run() === FALSE) {
                $data['error'] = validation_errors(' ', ' ');
            } else {
                $email = $this->input->post('email', TRUE);
                $password = $this->input->post('password', TRUE);

                $admin = $this->Admin_model->verify_login($email, $password);

                if ($admin) {
                    // Create secure CodeIgniter session
                    $session_data = array(
                        'admin_logged_in' => TRUE,
                        'admin_id'        => $admin->id,
                        'admin_name'      => $admin->name,
                        'admin_email'     => $admin->email,
                        'admin_role'      => $admin->role
                    );
                    $this->session->set_userdata($session_data);

                    // Redirect to intended URL or dashboard
                    $redirect_url = $this->session->userdata('redirect_url') ?: 'admin/dashboard';
                    $this->session->unset_userdata('redirect_url');
                    
                    redirect($redirect_url);
                    return;
                } else {
                    $data['error'] = 'Invalid email/staff ID or master password. Please verify your credentials.';
                }
            }
        }

        $this->load->view('admin/login', $data);
    }

    /**
     * Admin Logout
     */
    public function logout() {
        $this->session->unset_userdata(array('admin_logged_in', 'admin_id', 'admin_name', 'admin_email', 'admin_role'));
        $this->session->sess_destroy();
        redirect('admin/login');
    }
}

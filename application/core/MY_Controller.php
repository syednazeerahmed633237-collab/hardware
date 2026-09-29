<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Application Controller
 */
class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
}

/**
 * Admin Base Controller with session authentication guard
 */
class Admin_Controller extends MY_Controller {

    protected $admin_user = null;

    public function __construct() {
        parent::__construct();

        // Check if admin is logged in
        if (!$this->session->userdata('admin_logged_in')) {
            // Save intended target URL if GET request
            if ($this->input->method(TRUE) === 'GET') {
                $this->session->set_userdata('redirect_url', current_url());
            }
            $this->session->set_flashdata('error', 'Please authenticate to access the admin portal.');
            redirect('admin/login');
            exit;
        }

        $this->admin_user = (object) array(
            'id'    => $this->session->userdata('admin_id'),
            'name'  => $this->session->userdata('admin_name'),
            'email' => $this->session->userdata('admin_email'),
            'role'  => $this->session->userdata('admin_role')
        );
    }
}

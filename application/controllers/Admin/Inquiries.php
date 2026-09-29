<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiries extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Orders & Inquiries list
     */
    public function index() {
        $status = $this->input->get('status', TRUE) ?: 'all';
        $data['page_title'] = 'Orders & Inquiries - Admin Portal';
        $data['admin_user'] = $this->admin_user;
        $data['inquiries'] = $this->Inquiry_model->get_all(50, 0, $status);
        $data['total_inquiries'] = $this->Inquiry_model->count_all();
        $data['current_status'] = $status;

        $this->load->view('admin/inquiries', $data);
    }

    /**
     * Update inquiry status
     */
    public function update_status($id) {
        $status = $this->input->post('status', TRUE);
        if (in_array($status, array('new', 'in_progress', 'completed', 'cancelled'))) {
            $this->Inquiry_model->update_status((int)$id, $status);
            $this->session->set_flashdata('success', 'Inquiry status updated.');
        }
        redirect('admin/inquiries');
    }
}

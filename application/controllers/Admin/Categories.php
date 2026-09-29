<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Categories list & management
     */
    public function index() {
        $data['page_title'] = 'Categories - Admin Portal';
        $data['admin_user'] = $this->admin_user;
        $data['categories'] = $this->Category_model->get_all();

        if ($this->input->method(TRUE) === 'POST') {
            $this->form_validation->set_rules('name', 'Category Name', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('slug', 'Slug', 'trim|required|max_length[100]');

            if ($this->form_validation->run() === TRUE) {
                $category_data = array(
                    'name'        => $this->input->post('name', TRUE),
                    'slug'        => url_title($this->input->post('slug', TRUE), '-', TRUE),
                    'description' => $this->input->post('description', TRUE),
                    'icon'        => $this->input->post('icon', TRUE) ?: 'inventory_2',
                    'status'      => $this->input->post('status', TRUE) ?: 'active'
                );

                $this->Category_model->insert($category_data);
                $this->session->set_flashdata('success', 'Category added successfully!');
                redirect('admin/categories');
                return;
            } else {
                $this->session->set_flashdata('error', validation_errors(' ', ' '));
            }
        }

        $this->load->view('admin/categories', $data);
    }
}

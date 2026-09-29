<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Admin Dashboard - Real-time metrics & Product Management
     */
    public function index() {
        $search = $this->input->get('q', TRUE);
        $category_id = $this->input->get('category_id', TRUE);
        $status = $this->input->get('status', TRUE);

        $filters = array(
            'status'      => ($status && $status !== 'all') ? $status : 'all',
            'search'      => $search,
            'category_id' => $category_id
        );

        $data['page_title'] = 'Admin Dashboard - Log HARDWARE';
        $data['admin_user'] = $this->admin_user;
        
        // Real-time Database KPI Metrics
        $data['metrics'] = $this->Product_model->get_dashboard_metrics();
        $data['total_inquiries'] = $this->Inquiry_model->count_all();
        $data['new_inquiries'] = $this->Inquiry_model->count_all('new');
        
        // Products and Categories
        $data['products'] = $this->Product_model->get_all($filters, 50, 0);
        $data['categories'] = $this->Category_model->get_all();
        $data['recent_inquiries'] = $this->Inquiry_model->get_all(5, 0);
        
        $data['current_filters'] = array(
            'q'           => $search,
            'category_id' => $category_id,
            'status'      => $status
        );

        $this->load->view('admin/dashboard', $data);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Storefront Landing Page
     */
    public function index() {
        $data['page_title'] = 'Log HARDWARE - Official Spare Parts & Appliance Store';
        $data['meta_description'] = 'Authorized wholesale & retail supply for Air Conditioners, Washing Machines, Refrigerators, Microwave Ovens and Water Purifiers spare parts.';
        
        // Dynamic Categories from DB
        $data['categories'] = $this->Category_model->get_all('active');
        
        // Featured Products
        $data['featured_products'] = $this->Product_model->get_featured(4);
        
        // Latest Products
        $data['latest_products'] = $this->Product_model->get_latest(8);
        
        // Dynamic Brands for filter/search
        $data['brands'] = $this->Product_model->get_brands();

        $this->load->view('frontend/home', $data);
    }
}

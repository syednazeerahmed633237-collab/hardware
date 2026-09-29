<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * All Products Catalog
     */
    public function index() {
        $search = $this->input->get('q', TRUE);
        $category = $this->input->get('category', TRUE);
        $brand = $this->input->get('brand', TRUE);
        $availability = $this->input->get('availability', TRUE);
        $sort = $this->input->get('sort', TRUE) ?: 'newest';
        $page = (int)$this->input->get('page', TRUE) ?: 1;

        $limit = 12;
        $offset = ($page - 1) * $limit;

        $filters = array(
            'status'        => 'active',
            'search'        => $search,
            'category_slug' => $category,
            'brand'         => $brand,
            'availability'  => $availability,
            'sort'          => $sort
        );

        $total_rows = $this->Product_model->count_filtered($filters);
        $products = $this->Product_model->get_all($filters, $limit, $offset);

        // Pagination setup
        $this->load->library('pagination');
        $config['base_url'] = site_url('products');
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $limit;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';
        $config['reuse_query_string'] = TRUE;
        $config['use_page_numbers'] = TRUE;

        // Clean pagination markup
        $config['full_tag_open'] = '<div class="flex items-center gap-1.5">';
        $config['full_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<span class="px-3.5 py-1.5 rounded bg-[#c2652a] text-white font-medium text-sm">';
        $config['cur_tag_close'] = '</span>';
        $config['num_tag_open'] = '<span class="px-3.5 py-1.5 rounded border border-[#d8d0c8] text-[#3a302a] hover:bg-[#eae2da] transition-colors text-sm">';
        $config['num_tag_close'] = '</span>';
        $config['prev_tag_open'] = '<span class="px-3 py-1.5 rounded border border-[#d8d0c8] text-[#3a302a] hover:bg-[#eae2da] transition-colors text-sm flex items-center">';
        $config['prev_tag_close'] = '</span>';
        $config['next_tag_open'] = '<span class="px-3 py-1.5 rounded border border-[#d8d0c8] text-[#3a302a] hover:bg-[#eae2da] transition-colors text-sm flex items-center">';
        $config['next_tag_close'] = '</span>';

        $this->pagination->initialize($config);

        $data['page_title'] = 'All Products & Spare Parts Catalog - Log HARDWARE';
        $data['meta_description'] = 'Search and filter genuine OEM spare parts, replacement components, and hardware modules for all appliance categories.';
        $data['products'] = $products;
        $data['total_count'] = $total_rows;
        $data['categories'] = $this->Category_model->get_all('active');
        $data['brands'] = $this->Product_model->get_brands();
        $data['pagination'] = $this->pagination->create_links();
        $data['current_filters'] = array(
            'q'            => $search,
            'category'     => $category,
            'brand'        => $brand,
            'availability' => $availability,
            'sort'         => $sort,
            'page'         => $page
        );

        $this->load->view('frontend/products', $data);
    }

    /**
     * Category Shortcut Route
     */
    public function category($slug) {
        $_GET['category'] = $slug;
        $this->index();
    }

    /**
     * Product Detail Page
     */
    public function detail($id) {
        $product = $this->Product_model->get_by_id((int)$id);
        if (!$product || $product->status !== 'active') {
            show_404();
            return;
        }

        $data['page_title'] = $product->product_name . ' - Log HARDWARE';
        $data['product'] = $product;
        $data['specs'] = json_decode($product->specs, true) ?: array();
        $data['related_products'] = $this->Product_model->get_all(array(
            'status'      => 'active',
            'category_id' => $product->category_id
        ), 4);
        $data['categories'] = $this->Category_model->get_all('active');

        $this->load->view('frontend/product_detail', $data);
    }

    /**
     * AJAX Realtime Filter and Search Endpoint
     */
    public function filter_ajax() {
        if (!$this->input->is_ajax_request() && $this->input->get('ajax') != 1) {
            // allow fallback for standard queries
        }

        $search = $this->input->get('q', TRUE);
        $category = $this->input->get('category', TRUE);
        $brand = $this->input->get('brand', TRUE);
        $availability = $this->input->get('availability', TRUE);
        $sort = $this->input->get('sort', TRUE) ?: 'newest';

        $filters = array(
            'status'        => 'active',
            'search'        => $search,
            'category_slug' => ($category === 'all' ? '' : $category),
            'brand'         => ($brand === 'all' ? '' : $brand),
            'availability'  => ($availability === 'all' ? '' : $availability),
            'sort'          => $sort
        );

        $products = $this->Product_model->get_all($filters, 50, 0);
        $total_count = $this->Product_model->count_filtered($filters);

        // Format products for JSON response
        $results = array();
        foreach ($products as $p) {
            $specs = json_decode($p->specs, true) ?: array();
            $results[] = array(
                'id'            => $p->id,
                'title'         => $p->product_name,
                'category'      => $p->category_name,
                'brand'         => $p->brand,
                'size'          => $p->size,
                'sku'           => $p->sku,
                'price'         => '₹' . number_format($p->price, 0),
                'price_raw'     => (float)$p->price,
                'inStock'       => ($p->stock_quantity > 0),
                'stockCount'    => (int)$p->stock_quantity,
                'image'         => base_url('uploads/products/' . ($p->image ?: 'default.png')),
                'detail_url'    => site_url('products/' . $p->id),
                'specs'         => $specs,
                'description'   => $p->description
            );
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'status'       => 'success',
                'total'        => $total_count,
                'products'     => $results
            )));
    }

    /**
     * Submit Product Inquiry / Technician Quote
     */
    public function inquire() {
        $this->form_validation->set_rules('customer_name', 'Full Name', 'trim|required|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('customer_phone', 'Phone Number', 'trim|required|min_length[7]|max_length[20]');
        $this->form_validation->set_rules('customer_email', 'Email Address', 'trim|valid_email|max_length[150]');
        $this->form_validation->set_rules('message', 'Message / Requirements', 'trim|required|min_length[5]');

        if ($this->form_validation->run() === FALSE) {
            if ($this->input->is_ajax_request()) {
                $this->output->set_content_type('application/json')->set_output(json_encode(array(
                    'status' => 'error',
                    'errors' => validation_errors()
                )));
                return;
            }
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER['HTTP_REFERER'] ?: 'products');
            return;
        }

        $inquiry_data = array(
            'product_id'     => $this->input->post('product_id') ? (int)$this->input->post('product_id') : null,
            'customer_name'   => $this->input->post('customer_name', TRUE),
            'customer_phone'  => $this->input->post('customer_phone', TRUE),
            'customer_email'  => $this->input->post('customer_email', TRUE),
            'message'         => $this->input->post('message', TRUE),
            'status'          => 'new'
        );

        $id = $this->Inquiry_model->insert($inquiry_data);

        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'status'  => 'success',
                'message' => 'Thank you! Your inquiry has been sent. Our team will contact you shortly.'
            )));
            return;
        }

        $this->session->set_flashdata('success', 'Your inquiry has been submitted successfully! We will connect via WhatsApp / Phone.');
        redirect($_SERVER['HTTP_REFERER'] ?: 'products');
    }
}

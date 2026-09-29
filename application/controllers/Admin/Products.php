<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends Admin_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Product inventory management list
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

        $data['page_title'] = 'Inventory & Products - Admin Portal';
        $data['admin_user'] = $this->admin_user;
        $data['products'] = $this->Product_model->get_all($filters, 100, 0);
        $data['categories'] = $this->Category_model->get_all();
        $data['metrics'] = $this->Product_model->get_dashboard_metrics();

        $this->load->view('admin/products', $data);
    }

    /**
     * Add Product with secure file upload
     */
    public function add() {
        $data['page_title'] = 'Add New Product - Admin Portal';
        $data['admin_user'] = $this->admin_user;
        $data['categories'] = $this->Category_model->get_all();

        if ($this->input->method(TRUE) === 'POST') {
            $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|min_length[3]|max_length[200]');
            $this->form_validation->set_rules('sku', 'SKU', 'trim|required|is_unique[products.sku]');
            $this->form_validation->set_rules('category_id', 'Category', 'trim|required|numeric');
            $this->form_validation->set_rules('brand', 'Brand', 'trim|required');
            $this->form_validation->set_rules('price', 'Wholesale/Retail Price', 'trim|required|numeric');
            $this->form_validation->set_rules('stock_quantity', 'Stock Quantity', 'trim|required|integer');

            if ($this->form_validation->run() === TRUE) {
                $image_filename = 'default.png';

                // Handle file upload if present
                if (!empty($_FILES['image']['name'])) {
                    $upload_config = array(
                        'upload_path'   => './uploads/products/',
                        'allowed_types' => 'jpg|jpeg|png|webp|svg',
                        'max_size'      => 5120, // 5MB
                        'encrypt_name'  => TRUE,
                        'remove_spaces' => TRUE
                    );

                    $this->load->library('upload', $upload_config);

                    if ($this->upload->do_upload('image')) {
                        $upload_data = $this->upload->data();
                        $image_filename = $upload_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                        $this->load->view('admin/add_product', $data);
                        return;
                    }
                }

                // Handle specifications array into JSON
                $specs = array();
                $spec_keys = $this->input->post('spec_key');
                $spec_vals = $this->input->post('spec_val');
                if (is_array($spec_keys) && is_array($spec_vals)) {
                    for ($i = 0; $i < count($spec_keys); $i++) {
                        $k = trim($spec_keys[$i]);
                        $v = trim($spec_vals[$i]);
                        if (!empty($k) && !empty($v)) {
                            $specs[$k] = $v;
                        }
                    }
                }

                $product_data = array(
                    'product_name'   => $this->input->post('product_name', TRUE),
                    'sku'            => strtoupper(trim($this->input->post('sku', TRUE))),
                    'category_id'    => (int)$this->input->post('category_id', TRUE),
                    'brand'          => $this->input->post('brand', TRUE),
                    'size'           => $this->input->post('size', TRUE) ?: 'Standard',
                    'description'    => $this->input->post('description', TRUE),
                    'specs'          => json_encode($specs),
                    'price'          => (float)$this->input->post('price', TRUE),
                    'original_price' => $this->input->post('original_price') ? (float)$this->input->post('original_price') : null,
                    'stock_quantity' => (int)$this->input->post('stock_quantity', TRUE),
                    'image'          => $image_filename,
                    'is_featured'    => $this->input->post('is_featured') ? 1 : 0,
                    'status'         => $this->input->post('status', TRUE) ?: 'active'
                );

                $new_id = $this->Product_model->insert($product_data);

                $this->session->set_flashdata('success', 'Product "' . $product_data['product_name'] . '" added to catalog successfully!');
                redirect('admin/dashboard');
                return;
            } else {
                $this->session->set_flashdata('error', validation_errors(' ', ' '));
            }
        }

        $this->load->view('admin/add_product', $data);
    }

    /**
     * Edit Product with optional image update
     */
    public function edit($id) {
        $product = $this->Product_model->get_by_id((int)$id);
        if (!$product) {
            $this->session->set_flashdata('error', 'Product not found.');
            redirect('admin/dashboard');
            return;
        }

        $data['page_title'] = 'Edit Product #' . $product->id . ' - Admin Portal';
        $data['admin_user'] = $this->admin_user;
        $data['product'] = $product;
        $data['categories'] = $this->Category_model->get_all();
        $data['specs'] = json_decode($product->specs, true) ?: array();

        if ($this->input->method(TRUE) === 'POST') {
            $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|min_length[3]|max_length[200]');
            
            // Check SKU unique only if changed
            if ($this->input->post('sku') !== $product->sku) {
                $this->form_validation->set_rules('sku', 'SKU', 'trim|required|is_unique[products.sku]');
            }

            $this->form_validation->set_rules('category_id', 'Category', 'trim|required|numeric');
            $this->form_validation->set_rules('brand', 'Brand', 'trim|required');
            $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
            $this->form_validation->set_rules('stock_quantity', 'Stock Quantity', 'trim|required|integer');

            if ($this->form_validation->run() === TRUE) {
                $image_filename = $product->image;

                // Handle image upload if new image chosen
                if (!empty($_FILES['image']['name'])) {
                    $upload_config = array(
                        'upload_path'   => './uploads/products/',
                        'allowed_types' => 'jpg|jpeg|png|webp|svg',
                        'max_size'      => 5120,
                        'encrypt_name'  => TRUE,
                        'remove_spaces' => TRUE
                    );

                    $this->load->library('upload', $upload_config);

                    if ($this->upload->do_upload('image')) {
                        $upload_data = $this->upload->data();
                        $image_filename = $upload_data['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                        $this->load->view('admin/edit_product', $data);
                        return;
                    }
                }

                // Specs array to JSON
                $specs = array();
                $spec_keys = $this->input->post('spec_key');
                $spec_vals = $this->input->post('spec_val');
                if (is_array($spec_keys) && is_array($spec_vals)) {
                    for ($i = 0; $i < count($spec_keys); $i++) {
                        $k = trim($spec_keys[$i]);
                        $v = trim($spec_vals[$i]);
                        if (!empty($k) && !empty($v)) {
                            $specs[$k] = $v;
                        }
                    }
                }

                $update_data = array(
                    'product_name'   => $this->input->post('product_name', TRUE),
                    'sku'            => strtoupper(trim($this->input->post('sku', TRUE))),
                    'category_id'    => (int)$this->input->post('category_id', TRUE),
                    'brand'          => $this->input->post('brand', TRUE),
                    'size'           => $this->input->post('size', TRUE) ?: 'Standard',
                    'description'    => $this->input->post('description', TRUE),
                    'specs'          => json_encode($specs),
                    'price'          => (float)$this->input->post('price', TRUE),
                    'original_price' => $this->input->post('original_price') ? (float)$this->input->post('original_price') : null,
                    'stock_quantity' => (int)$this->input->post('stock_quantity', TRUE),
                    'image'          => $image_filename,
                    'is_featured'    => $this->input->post('is_featured') ? 1 : 0,
                    'status'         => $this->input->post('status', TRUE) ?: 'active'
                );

                $this->Product_model->update($id, $update_data);

                $this->session->set_flashdata('success', 'Product details updated successfully!');
                redirect('admin/dashboard');
                return;
            } else {
                $this->session->set_flashdata('error', validation_errors(' ', ' '));
            }
        }

        $this->load->view('admin/edit_product', $data);
    }

    /**
     * Delete Product with confirmation
     */
    public function delete($id) {
        $product = $this->Product_model->get_by_id((int)$id);
        if ($product) {
            $this->Product_model->delete($id);
            $this->session->set_flashdata('success', 'Product #' . $id . ' (' . $product->product_name . ') deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Product not found.');
        }
        redirect('admin/dashboard');
    }

    /**
     * Toggle product status (active/inactive)
     */
    public function toggle_status($id) {
        $new_status = $this->Product_model->toggle_status((int)$id);
        if ($this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'status' => 'success',
                'new_status' => $new_status
            )));
            return;
        }
        $this->session->set_flashdata('success', 'Product status toggled to ' . $new_status);
        redirect('admin/dashboard');
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    protected $table = 'products';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Build base query with join to categories
     */
    private function _build_query($filters = array()) {
        $this->db->select('products.*, categories.name as category_name, categories.slug as category_slug');
        $this->db->from($this->table);
        $this->db->join('categories', 'categories.id = products.category_id', 'left');

        // Status filter (default active for frontend unless explicitly set to null/all)
        if (isset($filters['status']) && $filters['status'] !== 'all') {
            $this->db->where('products.status', $filters['status']);
        }

        // Category filter (by ID or Slug)
        if (!empty($filters['category_id'])) {
            $this->db->where('products.category_id', $filters['category_id']);
        }
        if (!empty($filters['category_slug'])) {
            $this->db->where('categories.slug', $filters['category_slug']);
        }

        // Search query (by product name, SKU, brand, appliance model or description)
        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $this->db->group_start();
            $this->db->like('products.product_name', $search);
            $this->db->or_like('products.sku', $search);
            $this->db->or_like('products.brand', $search);
            $this->db->or_like('products.description', $search);
            $this->db->or_like('products.size', $search);
            $this->db->or_like('categories.name', $search);
            $this->db->group_end();
        }

        // Brand filter
        if (!empty($filters['brand']) && $filters['brand'] !== 'all') {
            $this->db->like('products.brand', $filters['brand']);
        }

        // Availability filter
        if (isset($filters['availability'])) {
            if ($filters['availability'] === 'in_stock') {
                $this->db->where('products.stock_quantity >', 0);
            } elseif ($filters['availability'] === 'out_of_stock') {
                $this->db->where('products.stock_quantity', 0);
            } elseif ($filters['availability'] === 'low_stock') {
                $this->db->where('products.stock_quantity >', 0);
                $this->db->where('products.stock_quantity <=', 10);
            }
        }

        // Featured filter
        if (!empty($filters['is_featured'])) {
            $this->db->where('products.is_featured', 1);
        }

        // Sorting
        $sort = isset($filters['sort']) ? $filters['sort'] : 'newest';
        switch ($sort) {
            case 'price_low':
                $this->db->order_by('products.price', 'ASC');
                break;
            case 'price_high':
                $this->db->order_by('products.price', 'DESC');
                break;
            case 'name_asc':
                $this->db->order_by('products.product_name', 'ASC');
                break;
            case 'popular':
                $this->db->order_by('products.is_featured', 'DESC');
                $this->db->order_by('products.stock_quantity', 'DESC');
                break;
            case 'newest':
            default:
                $this->db->order_by('products.id', 'DESC');
                break;
        }
    }

    /**
     * Get products with pagination and filters
     */
    public function get_all($filters = array(), $limit = null, $offset = null) {
        $this->_build_query($filters);

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }

    /**
     * Count products matching filters
     */
    public function count_filtered($filters = array()) {
        $this->_build_query($filters);
        return $this->db->count_all_results();
    }

    /**
     * Get single product by ID
     */
    public function get_by_id($id) {
        $this->db->select('products.*, categories.name as category_name, categories.slug as category_slug');
        $this->db->from($this->table);
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        $this->db->where('products.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Get featured products for homepage
     */
    public function get_featured($limit = 4) {
        return $this->get_all(array('status' => 'active', 'is_featured' => 1), $limit);
    }

    /**
     * Get latest active products
     */
    public function get_latest($limit = 8) {
        return $this->get_all(array('status' => 'active'), $limit);
    }

    /**
     * Insert new product
     */
    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update product
     */
    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Delete product
     */
    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }

    /**
     * Toggle product status
     */
    public function toggle_status($id) {
        $product = $this->get_by_id($id);
        if ($product) {
            $new_status = ($product->status === 'active') ? 'inactive' : 'active';
            $this->update($id, array('status' => $new_status));
            return $new_status;
        }
        return false;
    }

    /**
     * Get all unique brand names from products
     */
    public function get_brands() {
        $query = $this->db->select('brand')->where('status', 'active')->get($this->table)->result();
        $brands = array();
        foreach ($query as $row) {
            $parts = explode(',', $row->brand);
            foreach ($parts as $p) {
                $trimmed = trim($p);
                if (!empty($trimmed) && !in_array($trimmed, $brands)) {
                    $brands[] = $trimmed;
                }
            }
        }
        sort($brands);
        return $brands;
    }

    /**
     * Get live dashboard KPI counts
     */
    public function get_dashboard_metrics() {
        // Total products count
        $total_products = $this->db->count_all($this->table);

        // Active products with stock > 0
        $active_inventory = $this->db->where('status', 'active')
                                     ->where('stock_quantity >', 0)
                                     ->count_all_results($this->table);

        // Low stock products (between 1 and 10)
        $low_stock = $this->db->where('status', 'active')
                              ->where('stock_quantity >', 0)
                              ->where('stock_quantity <=', 10)
                              ->count_all_results($this->table);

        // Out of stock products
        $out_of_stock = $this->db->where('stock_quantity', 0)
                                 ->count_all_results($this->table);

        // Total stock units sum
        $query_sum = $this->db->select_sum('stock_quantity')->get($this->table)->row();
        $total_units = $query_sum->stock_quantity ? (int)$query_sum->stock_quantity : 0;

        return (object) array(
            'total_products'   => $total_products,
            'active_inventory' => $active_inventory,
            'low_stock'        => $low_stock,
            'out_of_stock'     => $out_of_stock,
            'total_units'      => $total_units
        );
    }
}

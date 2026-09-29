<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    protected $table = 'categories';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all categories with product count
     */
    public function get_all($status = null) {
        $this->db->select('categories.*, COUNT(products.id) as product_count');
        $this->db->from($this->table);
        $this->db->join('products', 'products.category_id = categories.id AND products.status = "active"', 'left');
        
        if ($status !== null) {
            $this->db->where('categories.status', $status);
        }
        
        $this->db->group_by('categories.id');
        $this->db->order_by('categories.id', 'ASC');
        return $this->db->get()->result();
    }

    /**
     * Get single category by ID
     */
    public function get_by_id($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    /**
     * Get category by slug
     */
    public function get_by_slug($slug) {
        return $this->db->where('slug', $slug)->get($this->table)->row();
    }

    /**
     * Insert category
     */
    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update category
     */
    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    /**
     * Delete category
     */
    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }

    /**
     * Count total categories
     */
    public function count_all() {
        return $this->db->count_all($this->table);
    }
}

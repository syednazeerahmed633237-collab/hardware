<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiry_model extends CI_Model {

    protected $table = 'inquiries';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all customer inquiries with product details
     */
    public function get_all($limit = null, $offset = null, $status = null) {
        $this->db->select('inquiries.*, products.product_name, products.sku, products.price, products.image');
        $this->db->from($this->table);
        $this->db->join('products', 'products.id = inquiries.product_id', 'left');

        if ($status !== null && $status !== 'all') {
            $this->db->where('inquiries.status', $status);
        }

        $this->db->order_by('inquiries.id', 'DESC');

        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result();
    }

    /**
     * Count inquiries
     */
    public function count_all($status = null) {
        if ($status !== null && $status !== 'all') {
            $this->db->where('status', $status);
        }
        return $this->db->count_all_results($this->table);
    }

    /**
     * Get single inquiry by ID
     */
    public function get_by_id($id) {
        $this->db->select('inquiries.*, products.product_name, products.sku, products.price, products.image');
        $this->db->from($this->table);
        $this->db->join('products', 'products.id = inquiries.product_id', 'left');
        $this->db->where('inquiries.id', $id);
        return $this->db->get()->row();
    }

    /**
     * Insert inquiry
     */
    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * Update inquiry status
     */
    public function update_status($id, $status) {
        return $this->db->where('id', $id)->update($this->table, array('status' => $status));
    }

    /**
     * Delete inquiry
     */
    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }
}

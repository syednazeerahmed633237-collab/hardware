<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    protected $table = 'admins';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get admin by email
     */
    public function get_by_email($email) {
        return $this->db->where('email', $email)
                        ->where('status', 'active')
                        ->get($this->table)
                        ->row();
    }

    /**
     * Verify login credentials securely with password_verify
     */
    public function verify_login($email, $password) {
        $admin = $this->get_by_email($email);
        if ($admin) {
            if (password_verify($password, $admin->password)) {
                return $admin;
            }
        }
        return false;
    }

    /**
     * Get admin by ID
     */
    public function get_by_id($id) {
        return $this->db->where('id', $id)
                        ->get($this->table)
                        ->row();
    }

    /**
     * Update admin record
     */
    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $id)->update($this->table, $data);
    }
}

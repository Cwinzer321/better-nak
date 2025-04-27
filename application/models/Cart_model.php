<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function getCart($user_id) {
        $this->db->select('c.*, p.name, p.price, p.image');
        $this->db->from('carts c');
        $this->db->join('products p', 'c.product_id = p.id');
        $this->db->where('c.user_id', $user_id);
        $this->db->where('c.status', 'active');
        return $this->db->get()->result_array();
    }
}

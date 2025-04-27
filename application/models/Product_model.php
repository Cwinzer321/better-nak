<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends Base_model {
    
    protected $table = 'products';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_all_products($limit = null, $offset = null, $filters = []) {
        $this->db->select('products.*, categories.name as category_name, users.name as seller_name');
        $this->db->from('products');
        $this->db->join('categories', 'products.category_id = categories.id', 'left');
        $this->db->join('users', 'products.seller_id = users.id', 'left');
        $this->db->where('products.status', 'active');
        
        // Apply filters
        if (!empty($filters)) {
            if (isset($filters['category_id'])) {
                $this->db->where('products.category_id', $filters['category_id']);
            }
            
            if (isset($filters['type'])) {
                $this->db->where('products.type', $filters['type']);
            }
            
            if (isset($filters['search'])) {
                $this->db->group_start();
                $this->db->like('products.name', $filters['search']);
                $this->db->or_like('products.description', $filters['search']);
                $this->db->group_end();
            }
            
            if (isset($filters['seller_id'])) {
                $this->db->where('products.seller_id', $filters['seller_id']);
            }
        }
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result_array();
    }
    
    public function get_product_with_details($id) {
        $this->db->select('products.*, categories.name as category_name, users.name as seller_name, users.business_name, users.business_address');
        $this->db->from('products');
        $this->db->join('categories', 'products.category_id = categories.id', 'left');
        $this->db->join('users', 'products.seller_id = users.id', 'left');
        $this->db->where('products.id', $id);
        
        return $this->db->get()->row_array();
    }
    
    public function get_product_reviews($product_id) {
        $this->db->select('reviews.*, users.name, users.photo');
        $this->db->from('reviews');
        $this->db->join('users', 'reviews.user_id = users.id', 'left');
        $this->db->where('reviews.product_id', $product_id);
        $this->db->order_by('reviews.created_at', 'DESC');
        
        return $this->db->get()->result_array();
    }
}
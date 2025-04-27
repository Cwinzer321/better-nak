<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends Base_model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all users
     * 
     * @return array List of users
     */
    public function get_all_users() {
        return $this->db->get('users')->result();
    }

    /**
     * Toggle user status between active and suspended
     * 
     * @param int $user_id User ID
     * @return bool Success or failure
     */
    public function toggle_user_status($user_id) {
        $this->db->set('status', 'IF(status = "active", "suspended", "active")', false);
        $this->db->where('id', $user_id);
        return $this->db->update('users');
    }

    /**
     * Count all products
     * 
     * @return int Number of products
     */
    public function count_all_products() {
        return $this->db->count_all('products');
    }

    /**
     * Get recent users
     * 
     * @param int $limit Number of users to retrieve
     * @return array List of recent users
     */
    public function get_recent_users($limit = 5) {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('users', $limit)->result();
    }

    /**
     * Get all products with pagination
     * 
     * @param int $limit Number of products per page
     * @param int $offset Pagination offset
     * @return array List of products with seller details
     */
    public function get_all_products($limit = null, $offset = 0)
    {
        $this->db->select('products.*, users.name as seller_name, users.business_name');
        $this->db->from('products');
        $this->db->join('users', 'users.id = products.seller_id');
        $this->db->order_by('products.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Get dashboard statistics
     * 
     * @return array Statistics data
     */
    public function get_dashboard_stats() {
        $stats = [];
        
        // Total users
        $this->db->where('status', 'active');
        $stats['total_users'] = $this->db->count_all_results('users');
        
        // Total sellers
        $this->db->where('role', 'seller');
        $this->db->where('status', 'active');
        $stats['total_sellers'] = $this->db->count_all_results('users');
        
        // Total products
        $this->db->where('status', 'active');
        $stats['total_products'] = $this->db->count_all_results('products');
        
        // Total orders
        $stats['total_orders'] = $this->db->count_all_results('orders');
        
        // Revenue
        $this->db->select_sum('total_amount');
        $this->db->where('status !=', 'cancelled');
        $query = $this->db->get('orders');
        $stats['total_revenue'] = $query->row()->total_amount ?? 0;
        
        return $stats;
    }
}
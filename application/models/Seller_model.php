<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seller_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get seller settings
     * 
     * @param int $seller_id The seller's user ID
     * @return array Seller settings
     */
    public function get_seller_settings($seller_id) {
        // Since there's no seller_settings table in the database,
        // we'll create a default structure based on seller_details
        $this->db->where('user_id', $seller_id);
        $seller_details = $this->db->get('seller_details')->row_array();
        
        // If no settings exist yet, return defaults
        if (!$seller_details) {
            return [
                'notification_email' => 1,
                'notification_app' => 1,
                'user_id' => $seller_id
            ];
        }
        
        // Return settings based on seller_details
        return [
            'notification_email' => 1, // Default to enabled
            'notification_app' => 1,   // Default to enabled
            'verification_status' => $seller_details['verification_status'],
            'description' => $seller_details['description'],
            'certificate' => $seller_details['certificate'],
            'user_id' => $seller_id
        ];
    }
    
    /**
     * Update seller settings
     * 
     * @param int $seller_id The seller's user ID
     * @param array $data Settings data to update
     * @return bool Success or failure
     */
    public function update_settings($seller_id, $data) {
        // Since there's no seller_settings table, we'll update the seller_details
        $this->db->where('user_id', $seller_id);
        $exists = $this->db->get('seller_details')->row();
        
        if ($exists) {
            // Update existing seller details
            $this->db->where('user_id', $seller_id);
            return $this->db->update('seller_details', [
                'description' => isset($data['description']) ? $data['description'] : $exists->description
            ]);
        } else {
            // Create new seller details
            return $this->db->insert('seller_details', [
                'user_id' => $seller_id,
                'description' => isset($data['description']) ? $data['description'] : '',
                'verification_status' => 'pending'
            ]);
        }
    }
    
    /**
     * Get all verified sellers
     * 
     * @return array List of verified sellers
     */
    public function get_verified_sellers() {
        $this->db->select('users.*, seller_details.description');
        $this->db->from('users');
        $this->db->join('seller_details', 'users.id = seller_details.user_id');
        $this->db->where('users.role', 'seller');
        $this->db->where('users.status', 'active');
        $this->db->where('seller_details.verification_status', 'verified');
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Get seller statistics
     * 
     * @param int $seller_id The seller's user ID
     * @return array Seller statistics
     */
    public function get_seller_stats($seller_id) {
        // Get total products
        $this->db->where('seller_id', $seller_id);
        $total_products = $this->db->count_all_results('products');
        
        // Get total sales
        $this->db->select('SUM(order_items.price * order_items.quantity) as total');
        $this->db->from('orders');
        $this->db->join('order_items', 'orders.id = order_items.order_id');
        $this->db->join('products', 'order_items.product_id = products.id');
        $this->db->where('products.seller_id', $seller_id);
        $this->db->where('orders.status !=', 'cancelled');
        $sales = $this->db->get()->row();
        $total_sales = $sales ? $sales->total : 0;
        
        // Get total orders
        $this->db->select('COUNT(DISTINCT orders.id) as total');
        $this->db->from('orders');
        $this->db->join('order_items', 'orders.id = order_items.order_id');
        $this->db->join('products', 'order_items.product_id = products.id');
        $this->db->where('products.seller_id', $seller_id);
        $orders = $this->db->get()->row();
        $total_orders = $orders ? $orders->total : 0;
        
        return [
            'total_products' => $total_products,
            'total_sales' => $total_sales,
            'total_orders' => $total_orders
        ];
    }
}

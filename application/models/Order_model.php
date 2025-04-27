<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends Base_model {
    
    protected $table = 'orders';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get order with all items and customer details
     * 
     * @param int $order_id The order ID
     * @param int $seller_id The seller's user ID (for verification)
     * @return array|null Order details with items
     */
    public function get_order_with_items($order_id, $seller_id)
    {
        // Get order details
        $this->db->select('orders.*, users.name as customer_name, users.phone, users.address');
        $this->db->from('orders');
        $this->db->join('users', 'orders.user_id = users.id');
        $this->db->where('orders.id', $order_id);
        $order = $this->db->get()->row_array();
        
        if (!$order) {
            return null;
        }
        
        // Get order items that belong to this seller
        $this->db->select('order_items.*, products.name as product_name, products.image');
        $this->db->from('order_items');
        $this->db->join('products', 'order_items.product_id = products.id');
        $this->db->where('order_items.order_id', $order_id);
        $this->db->where('products.seller_id', $seller_id);
        $items = $this->db->get()->result_array();
        
        // If no items found for this seller, return null
        if (empty($items)) {
            return null;
        }
        
        $order['items'] = $items;
        
        // Calculate total for this seller's items
        $seller_total = 0;
        foreach ($items as $item) {
            $seller_total += $item['price'] * $item['quantity'];
        }
        $order['seller_total'] = $seller_total;
        
        return $order;
    }
    
    /**
     * Get orders for a seller
     * 
     * @param int $seller_id The seller's user ID
     * @return array List of orders
     */
    public function get_seller_orders($seller_id)
    {
        $this->db->select('orders.*, users.name as customer_name, COUNT(order_items.id) as item_count, SUM(order_items.subtotal) as seller_total');
        $this->db->from('orders');
        $this->db->join('users', 'orders.user_id = users.id');
        $this->db->join('order_items', 'orders.id = order_items.order_id');
        $this->db->join('products', 'order_items.product_id = products.id');
        $this->db->where('products.seller_id', $seller_id);
        $this->db->group_by('orders.id');
        $this->db->order_by('orders.order_date', 'DESC');
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Check if an order belongs to a seller
     * 
     * @param int $order_id The order ID
     * @param int $seller_id The seller's user ID
     * @return bool True if the order has items from this seller
     */
    public function is_order_belongs_to_seller($order_id, $seller_id)
    {
        $this->db->select('COUNT(*) as count');
        $this->db->from('order_items');
        $this->db->join('products', 'order_items.product_id = products.id');
        $this->db->where('order_items.order_id', $order_id);
        $this->db->where('products.seller_id', $seller_id);
        
        $result = $this->db->get()->row();
        return ($result && $result->count > 0);
    }
    
    /**
     * Update order status
     * 
     * @param int $order_id The order ID
     * @param string $status New status (processing, shipped, completed)
     * @return bool Success or failure
     */
    public function update_order_status($order_id, $status)
    {
        $allowed_statuses = ['pending', 'paid', 'processing', 'shipped', 'completed', 'cancelled'];
        
        if (!in_array($status, $allowed_statuses)) {
            return false;
        }
        
        $this->db->where('id', $order_id);
        return $this->db->update('orders', [
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Get sales report for a seller
     * 
     * @param int $seller_id The seller's user ID
     * @param string $date_range Date range (today, this_week, this_month, etc.)
     * @return array Sales report data
     */
    public function get_sales_report($seller_id, $date_range = 'this_month')
    {
        // Set date filters based on range
        $start_date = null;
        $end_date = date('Y-m-d 23:59:59');
        
        switch ($date_range) {
            case 'today':
                $start_date = date('Y-m-d 00:00:00');
                break;
            case 'this_week':
                $start_date = date('Y-m-d 00:00:00', strtotime('monday this week'));
                break;
            case 'this_month':
                $start_date = date('Y-m-01 00:00:00');
                break;
            case 'this_year':
                $start_date = date('Y-01-01 00:00:00');
                break;
            case 'last_month':
                $start_date = date('Y-m-01 00:00:00', strtotime('first day of last month'));
                $end_date = date('Y-m-t 23:59:59', strtotime('last day of last month'));
                break;
            case 'last_year':
                $start_date = date('Y-01-01 00:00:00', strtotime('-1 year'));
                $end_date = date('Y-12-31 23:59:59', strtotime('-1 year'));
                break;
            case 'custom':
                // Custom date range should be handled separately
                break;
        }
        
        // Get sales data
        $this->db->select('SUM(order_items.subtotal) as total_sales, COUNT(DISTINCT orders.id) as order_count');
        $this->db->from('orders');
        $this->db->join('order_items', 'orders.id = order_items.order_id');
        $this->db->join('products', 'order_items.product_id = products.id');
        $this->db->where('products.seller_id', $seller_id);
        $this->db->where('orders.status !=', 'cancelled');
        
        if ($start_date) {
            $this->db->where('orders.order_date >=', $start_date);
        }
        
        if ($end_date) {
            $this->db->where('orders.order_date <=', $end_date);
        }
        
        $summary = $this->db->get()->row_array();
        
        // Get top products
        $this->db->select('products.id, products.name, SUM(order_items.quantity) as total_qty, SUM(order_items.subtotal) as total_amount');
        $this->db->from('order_items');
        $this->db->join('products', 'order_items.product_id = products.id');
        $this->db->join('orders', 'order_items.order_id = orders.id');
        $this->db->where('products.seller_id', $seller_id);
        $this->db->where('orders.status !=', 'cancelled');
        
        if ($start_date) {
            $this->db->where('orders.order_date >=', $start_date);
        }
        
        if ($end_date) {
            $this->db->where('orders.order_date <=', $end_date);
        }
        
        $this->db->group_by('products.id');
        $this->db->order_by('total_amount', 'DESC');
        $this->db->limit(5);
        
        $top_products = $this->db->get()->result_array();
        
        return [
            'summary' => $summary,
            'top_products' => $top_products,
            'start_date' => $start_date,
            'end_date' => $end_date
        ];
    }
    
    /**
     * Create a new order
     * 
     * @param array $order_data Order data
     * @param array $items Order items
     * @return int|bool Order ID or false on failure
     */
    public function create_order($order_data, $items)
    {
        $this->db->trans_start();
        
        // Insert order
        $this->db->insert('orders', $order_data);
        $order_id = $this->db->insert_id();
        
        // Insert order items
        foreach ($items as $item) {
            $item_data = [
                'order_id' => $order_id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity']
            ];
            
            $this->db->insert('order_items', $item_data);
        }
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        
        return $order_id;
    }
    
    /**
     * Count orders for a specific seller
     * 
     * @param int $seller_id The seller's user ID
     * @return int Number of orders
     */
    public function count_seller_orders($seller_id)
    {
        $this->db->select('COUNT(DISTINCT orders.id) as order_count');
        $this->db->from('orders');
        $this->db->join('order_items', 'orders.id = order_items.order_id');
        $this->db->join('products', 'order_items.product_id = products.id');
        $this->db->where('products.seller_id', $seller_id);
        
        $result = $this->db->get()->row();
        return $result ? $result->order_count : 0;
    }
    
    /**
     * Count pending orders for a seller
     * 
     * @param int $seller_id The seller's user ID
     * @return int Number of pending orders
     */
    public function count_pending_orders($seller_id)
    {
        $this->db->select('COUNT(DISTINCT orders.id) as pending_count');
        $this->db->from('orders');
        $this->db->join('order_items', 'orders.id = order_items.order_id');
        $this->db->join('products', 'order_items.product_id = products.id');
        $this->db->where('products.seller_id', $seller_id);
        $this->db->where('orders.status', 'pending');
        
        $result = $this->db->get()->row();
        return $result ? $result->pending_count : 0;
    }
    
    /**
     * Get total revenue for a seller
     * 
     * @param int $seller_id The seller's user ID
     * @return float Total revenue amount
     */
    public function get_seller_revenue($seller_id)
    {
        $this->db->select_sum('order_items.subtotal');
        $this->db->from('orders');
        $this->db->join('order_items', 'orders.id = order_items.order_id');
        $this->db->join('products', 'order_items.product_id = products.id');
        $this->db->where('products.seller_id', $seller_id);
        $this->db->where_in('orders.status', ['completed', 'shipped', 'paid']);
        
        $result = $this->db->get()->row();
        return $result ? $result->subtotal : 0;
    }
    
    /**
     * Get recent orders for a seller
     * 
     * @param int $seller_id The seller's user ID
     * @param int $limit Number of orders to retrieve
     * @return array List of recent orders
     */
    public function get_recent_orders($seller_id, $limit = 5)
    {
        $this->db->select('orders.*, users.name as customer_name, COUNT(order_items.id) as item_count, SUM(order_items.subtotal) as seller_total');
        $this->db->from('orders');
        $this->db->join('users', 'orders.user_id = users.id');
        $this->db->join('order_items', 'orders.id = order_items.order_id');
        $this->db->join('products', 'order_items.product_id = products.id');
        $this->db->where('products.seller_id', $seller_id);
        $this->db->group_by('orders.id');
        $this->db->order_by('orders.order_date', 'DESC');
        $this->db->limit($limit);
        
        return $this->db->get()->result_array();
    }
}

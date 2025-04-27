<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends Base_model {
    
    protected $table = 'products';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all products with pagination
     * 
     * @param int $limit Number of products per page
     * @param int $offset Pagination offset
     * @param array $filters Optional filters (category, price range, etc.)
     * @return array List of products
     */
    public function get_products($limit = null, $offset = 0, $filters = []) {
        $this->db->select('products.*, categories.name as category_name, users.name as seller_name');
        $this->db->from('products');
        $this->db->join('categories', 'products.category_id = categories.id', 'left');
        $this->db->join('users', 'products.seller_id = users.id', 'left');
        $this->db->where('products.status', 'active');
        
        // Apply filters if provided
        if (!empty($filters)) {
            if (isset($filters['category_id']) && $filters['category_id']) {
                $this->db->where('products.category_id', $filters['category_id']);
            }
            
            if (isset($filters['min_price']) && $filters['min_price']) {
                $this->db->where('products.price >=', $filters['min_price']);
            }
            
            if (isset($filters['max_price']) && $filters['max_price']) {
                $this->db->where('products.price <=', $filters['max_price']);
            }
            
            if (isset($filters['search']) && $filters['search']) {
                $this->db->like('products.name', $filters['search']);
            }
        }
        
        $this->db->order_by('products.created_at', 'DESC');
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Get product by ID
     * 
     * @param int $product_id The product ID
     * @return array Product details
     */
    public function get_product_by_id($product_id) {
        $this->db->select('products.*, categories.name as category_name, users.name as seller_name, users.business_name');
        $this->db->from('products');
        $this->db->join('categories', 'products.category_id = categories.id', 'left');
        $this->db->join('users', 'products.seller_id = users.id', 'left');
        $this->db->where('products.id', $product_id);
        
        return $this->db->get()->row_array();
    }
    
    /**
     * Count all active products
     * 
     * @return int Total number of products
     */
    public function count_products() {
        $this->db->where('status', 'active');
        return $this->db->count_all_results('products');
    }
    
    /**
     * Get total number of products
     * 
     * @return int Total number of products
     */
    public function get_total_products() {
        $this->db->where('status', 'active');
        return $this->db->count_all_results('products');
    }
    
    /**
     * Save new product
     * 
     * @param array $data Product data
     * @return bool Success or failure
     */
    public function save_product($data) {
        return $this->db->insert('products', $data);
    }
    
    /**
     * Update existing product
     * 
     * @param int $product_id The product ID
     * @param array $data Updated product data
     * @param int $seller_id The seller's user ID (for verification)
     * @return bool Success or failure
     */
    public function update_product($product_id, $data, $seller_id) {
        $this->db->where('id', $product_id);
        $this->db->where('seller_id', $seller_id);
        return $this->db->update('products', $data);
    }
    
    /**
     * Delete product
     * 
     * @param int $product_id The product ID
     * @param int $seller_id The seller's user ID (for verification)
     * @return bool Success or failure
     */
    public function delete_product($product_id, $seller_id) {
        $this->db->where('id', $product_id);
        $this->db->where('seller_id', $seller_id);
        return $this->db->delete('products');
    }
    
    /**
     * Get all categories for dropdown
     * 
     * @return array List of categories
     */
    public function get_kategori_options() {
        $this->db->select('id, name, type');
        $this->db->from('categories');
        $this->db->order_by('name', 'ASC');
        
        $categories = $this->db->get()->result_array();
        return $categories;
    }
    
    /**
     * Check if a review belongs to a seller's product
     * 
     * @param int $review_id The review ID
     * @param int $seller_id The seller's user ID
     * @return bool True if the review is for this seller's product
     */
    public function is_review_belongs_to_seller($review_id, $seller_id)
    {
        $this->db->select('COUNT(*) as count');
        $this->db->from('reviews');
        $this->db->join('products', 'reviews.product_id = products.id');
        $this->db->where('reviews.id', $review_id);
        $this->db->where('products.seller_id', $seller_id);
        
        $result = $this->db->get()->row();
        return ($result && $result->count > 0);
    }
    
    /**
     * Add a reply to a product review
     * 
     * @param int $review_id The review ID
     * @param string $reply The reply text
     * @param int $seller_id The seller's user ID
     * @return bool Success or failure
     */
    public function add_review_reply($review_id, $reply, $seller_id)
    {
        // First verify that the review belongs to this seller's product
        if (!$this->is_review_belongs_to_seller($review_id, $seller_id)) {
            return false;
        }
        
        $this->db->where('id', $review_id);
        return $this->db->update('reviews', [
            'seller_reply' => $reply,
            'reply_date' => date('Y-m-d H:i:s')
        ]);
    }
    
    /**
     * Get all reviews for a seller's products
     * 
     * @param int $seller_id The seller's user ID
     * @return array List of reviews with product and user details
     */
    public function get_seller_product_reviews($seller_id)
    {
        $this->db->select('reviews.*, products.name as product_name, users.name as user_name');
        $this->db->from('reviews');
        $this->db->join('products', 'reviews.product_id = products.id');
        $this->db->join('users', 'reviews.user_id = users.id');
        $this->db->where('products.seller_id', $seller_id);
        $this->db->order_by('reviews.created_at', 'DESC');
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Count products by seller ID
     * 
     * @param int $seller_id The seller's user ID
     * @return int Number of products
     */
    public function count_seller_products($seller_id) {
        $this->db->where('seller_id', $seller_id);
        $this->db->where('status', 'active');
        return $this->db->count_all_results('products');
    }
    
    /**
     * Get all products for a specific seller
     * 
     * @param int $seller_id The seller's user ID
     * @return array List of products
     */
    public function get_produk_by_seller($seller_id)
    {
        $this->db->select('products.*, categories.name as category_name');
        $this->db->from('products');
        $this->db->join('categories', 'products.category_id = categories.id', 'left');
        $this->db->where('products.seller_id', $seller_id);
        $this->db->order_by('products.created_at', 'DESC');
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Get categories filtered by product type
     * 
     * @param string $jenis_produk Product type (hewan_ternak or produk_turunan)
     * @return array List of categories
     */
    public function get_kategori_by_jenis($jenis_produk)
    {
        $this->db->select('id, name');
        $this->db->from('categories');
        $this->db->where('jenis_produk', $jenis_produk);
        $this->db->order_by('name', 'ASC');
        
        return $this->db->get()->result_array();
    }
}

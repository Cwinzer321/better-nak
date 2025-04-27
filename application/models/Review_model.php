<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review_model extends Base_model {
    
    protected $table = 'reviews';
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get reviews for a specific product
     * 
     * @param int $product_id Product ID
     * @param int $limit Limit number of reviews
     * @return array List of reviews with user details
     */
    public function get_product_reviews($product_id, $limit = null) {
        $this->db->select('reviews.*, users.name, users.photo as profile_picture');
        $this->db->from('reviews');
        $this->db->join('users', 'reviews.user_id = users.id');
        $this->db->where('reviews.product_id', $product_id);
        $this->db->order_by('reviews.created_at', 'DESC');
        
        if ($limit !== null) {
            $this->db->limit($limit);
        }
        
        return $this->db->get()->result_array();
    }
    
    /**
     * Get average rating for a product
     * 
     * @param int $product_id Product ID
     * @return float Average rating
     */
    public function get_product_rating($product_id) {
        $this->db->select_avg('rating');
        $this->db->where('product_id', $product_id);
        $result = $this->db->get('reviews')->row();
        
        return $result ? round($result->rating, 1) : 0;
    }
    
    /**
     * Add a new review
     * 
     * @param array $data Review data
     * @return int|bool Review ID or false on failure
     */
    public function add_review($data) {
        return $this->insert($data);
    }
    
    /**
     * Get reviews by user
     * 
     * @param int $user_id User ID
     * @return array List of reviews with product details
     */
    public function get_user_reviews($user_id) {
        $this->db->select('reviews.*, products.name as product_name, products.image');
        $this->db->from('reviews');
        $this->db->join('products', 'reviews.product_id = products.id');
        $this->db->where('reviews.user_id', $user_id);
        $this->db->order_by('reviews.created_at', 'DESC');
        
        return $this->db->get()->result_array();
    }
}

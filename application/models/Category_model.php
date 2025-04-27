<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category_model extends Base_model
{

    protected $table = 'categories';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get all categories
     * 
     * @return array List of categories
     */
    public function get_all_categories()
    {
        $this->db->order_by('name', 'ASC');
        return $this->db->get('categories')->result_array();
    }

    /**
     * Get categories with product count
     * 
     * @return array List of categories with product count
     */
    public function get_categories_with_count()
    {
        $this->db->select('categories.*, COUNT(products.id) as product_count');
        $this->db->from('categories');
        $this->db->join('products', 'categories.id = products.category_id', 'left');
        $this->db->where('products.status', 'active');
        $this->db->group_by('categories.id');
        $this->db->order_by('categories.name', 'ASC');

        return $this->db->get()->result_array();
    }

    /**
     * Get category by ID
     * 
     * @param int $category_id Category ID
     * @return array Category details
     */
    public function get_category($category_id)
    {
        return $this->db->get_where('categories', ['id' => $category_id])->row_array();
    }
}

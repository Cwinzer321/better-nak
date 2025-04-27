<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testimonial_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_testimonials() {
        $this->db->select('testimonials.*, users.name as user_name');
        $this->db->from('testimonials');
        $this->db->join('users', 'testimonials.user_id = users.id');
        $this->db->where('testimonials.status', 'approved');
        $this->db->order_by('testimonials.created_at', 'DESC');
        return $this->db->get()->result_array();
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_model extends CI_Model {
    
    protected $table = 'categories';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_all() {
        return $this->db->get('kategori')->result_array();
    }

    public function get_with_count() {
        $this->db->select('kategori.*, COUNT(produk.id) as jumlah_produk');
        $this->db->from('kategori');
        $this->db->join('produk', 'kategori.id = produk.kategori_id', 'left');
        $this->db->group_by('kategori.id');
        return $this->db->get()->result_array();
    }
    
    public function get_by_id($id) {
        return $this->db->get_where('kategori', ['id' => $id])->row_array();
    }

    public function get_all_categories() {
        $this->db->order_by('nama_kategori', 'ASC');  // Changed from 'name' to 'nama_kategori'
        return $this->db->get('categories')->result_array();
    }
}
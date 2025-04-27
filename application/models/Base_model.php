<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base_model extends CI_Model {
    
    protected $table;
    protected $primary_key = 'id';
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_all() {
        return $this->db->get($this->table)->result_array();
    }
    
    public function get_by_id($id) {
        return $this->db->get_where($this->table, [$this->primary_key => $id])->row_array();
    }
    
    public function insert($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
    
    public function update($id, $data) {
        return $this->db->update($this->table, $data, [$this->primary_key => $id]);
    }
    
    public function delete($id) {
        return $this->db->delete($this->table, [$this->primary_key => $id]);
    }
    
    public function count_all() {
        return $this->db->count_all($this->table);
    }
}
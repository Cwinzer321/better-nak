<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Model Class
 * 
 * A base model that provides common functionality for all models
 */
class Base_model extends CI_Model {
    
    /**
     * Table name for this model
     *
     * @var string
     */
    protected $table;
    
    /**
     * Primary key field name
     *
     * @var string
     */
    protected $primary_key = 'id';
    
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Get all records
     *
     * @param array $where Where conditions
     * @param string $order_by Order by field
     * @param string $order Order direction (asc/desc)
     * @param int $limit Limit results
     * @param int $offset Offset for pagination
     * @return array
     */
    public function get_all($where = null, $order_by = null, $order = 'asc', $limit = null, $offset = 0) {
        if ($where) {
            $this->db->where($where);
        }
        
        if ($order_by) {
            $this->db->order_by($order_by, $order);
        }
        
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get($this->table)->result_array();
    }
    
    /**
     * Get a single record by ID
     *
     * @param int $id Record ID
     * @return array|null
     */
    public function get_by_id($id) {
        $this->db->where($this->primary_key, $id);
        return $this->db->get($this->table)->row_array();
    }
    
    /**
     * Get a single record by custom field
     *
     * @param string $field Field name
     * @param mixed $value Field value
     * @return array|null
     */
    public function get_by_field($field, $value) {
        $this->db->where($field, $value);
        return $this->db->get($this->table)->row_array();
    }
    
    /**
     * Insert a new record
     *
     * @param array $data Data to insert
     * @return int|bool Inserted ID or false
     */
    public function insert($data) {
        $this->db->insert($this->table, $data);
        return ($this->db->affected_rows() > 0) ? $this->db->insert_id() : false;
    }
    
    /**
     * Update a record
     *
     * @param int $id Record ID
     * @param array $data Data to update
     * @return bool Success or failure
     */
    public function update($id, $data) {
        $this->db->where($this->primary_key, $id);
        $this->db->update($this->table, $data);
        return ($this->db->affected_rows() > 0);
    }
    
    /**
     * Delete a record
     *
     * @param int $id Record ID
     * @return bool Success or failure
     */
    public function delete($id) {
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->table);
        return ($this->db->affected_rows() > 0);
    }
    
    /**
     * Count records
     *
     * @param array $where Where conditions
     * @return int
     */
    public function count($where = null) {
        if ($where) {
            $this->db->where($where);
        }
        
        return $this->db->count_all_results($this->table);
    }
}
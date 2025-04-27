<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all() {
        $this->db->where('status', 'active');
        $this->db->order_by('id', 'DESC');
        return $this->db->get('products')->result_array();
    }

    public function get($id) {
        $query = $this->db->get_where('products', array('id' => $id));
        return $query->row_array();
    }

    public function create_product($data) {
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path'] = './uploads/products/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, true);
            }

            if ($this->upload->do_upload('image')) {
                $upload_data = $this->upload->data();
                $data['image'] = $upload_data['file_name'];
            }
        }
        
        return $this->db->insert('products', $data);
    }

    public function get_latest($limit) {
        $this->db->where('status', 'active');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('products')->result_array();
    }

    public function update_product($id) {
        $data = array(
            'name' => $this->input->post('name'),
            'price' => $this->input->post('price'),
            'description' => $this->input->post('description')
        );

        // Handle image update if new image is uploaded
        if (!empty($_FILES['image']['name'])) {
            $data['image'] = $this->upload_data['file_name'];
            
            // Delete old image if exists
            $old_product = $this->get($id);
            if ($old_product && $old_product['image']) {
                $old_image = FCPATH . 'uploads/products/' . $old_product['image'];
                if (file_exists($old_image)) {
                    unlink($old_image);
                }
            }
        }

        $this->db->where('id', $id);
        return $this->db->update('products', $data);
    }

    public function delete_product($id) {
        $this->db->where('product_id', $id);
        $order_items = $this->db->get('order_items')->num_rows();

        if ($order_items > 0) {
            $this->db->where('id', $id);
            return $this->db->update('products', array('status' => 'inactive'));
        } else {
            $product = $this->get($id);
            if ($product && $product['image']) {
                $image_path = FCPATH . 'uploads/products/' . $product['image'];
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
            return $this->db->delete('products', array('id' => $id));
        }
    }
}
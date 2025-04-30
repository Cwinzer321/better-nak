<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product_model extends CI_Model
{
    private $table = 'products';

    public function get_all()
    {
        $this->db->select('products.*, categories.category_name');
        $this->db->from($this->table);
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        $this->db->order_by('products.created_at', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->select('products.*, categories.category_name');
        $this->db->from($this->table);
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        $this->db->where('products.id', $id);
        return $this->db->get()->row_array();
    }

    public function create($data)
    {
        // Add image handling like in update method
        if (isset($_FILES['gambar']) && !empty($_FILES['gambar']['name'])) {
            $this->load->library('upload');
            $config['upload_path'] = './uploads/products/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('gambar')) {
                $upload_data = $this->upload->data();
                $data['image'] = $upload_data['file_name'];
            } else {
                // Handle upload error
                return false;
            }
        }
        
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $clean_data = [
            'name' => htmlspecialchars($data['nama_produk'], TRUE),
            'price' => $data['harga'],
            'stock' => $data['stok'],
            'description' => htmlspecialchars($data['deskripsi'] ?? '', TRUE),
            'category_id' => $data['kategori_id'],
            'type' => $data['jenis_produk'] === 'hewan_ternak' ? 'livestock' : 'product',
            'weight' => $data['berat'] ?? null,
            'age' => $data['umur'] ?? null,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        // Handle image update if provided
        if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
            // Get current product to check for existing image
            $current_product = $this->get_by_id($id);
            
            // Load upload library
            $this->load->library('upload');
            $config['upload_path'] = './uploads/products/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size'] = 2048; // 2048KB = 2MB
            $config['encrypt_name'] = TRUE;
            $this->upload->initialize($config);
            
            if ($this->upload->do_upload('image')) {
                $upload_data = $this->upload->data();
                $clean_data['image'] = $upload_data['file_name'];
                
                // Delete old image if exists
                if (!empty($current_product['image'])) {
                    $old_image_path = './uploads/products/' . $current_product['image'];
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
            }
        }
        
        $this->db->where('id', $id);
        return $this->db->update($this->table, $clean_data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function get_categories()
    {
        $this->db->select('id, category_name');
        $this->db->from('categories');
        $this->db->order_by('category_name', 'ASC');
        return $this->db->get()->result_array();
    }
}

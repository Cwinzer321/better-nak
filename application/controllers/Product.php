<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property session $session
 * @property input $input
 * @property Product_model $Product_model
 * @property form_validation $form_validation
 * @property db $db
 * @property upload $upload
 * @property create $create
 */
class Product extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['products'] = $this->Product_model->get_all();
        $this->load->view('products/index', $data);
    }

    public function create()
    {
        $this->form_validation->set_rules('name', 'Nama', 'trim|required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('price', 'Harga', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('stock', 'Stok', 'required|integer|greater_than_equal_to[0]');
        $this->form_validation->set_rules('category_id', 'Kategori', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('description', 'Deskripsi', 'trim|max_length[500]');
        $this->form_validation->set_error_delimiters('<small class="text-danger">', '</small>');

        if ($this->form_validation->run() === FALSE) {
            $data['categories'] = $this->Product_model->get_categories();
            $this->load->view('products/create', $data);
        } else {
            // Check if image was uploaded
            $has_image = isset($_FILES['image']) && !empty($_FILES['image']['name']);
            
            if ($has_image) {
                $upload_response = $this->_upload_image();
                $image_filename = $upload_response['status'] ? $upload_response['file_name'] : null;
                
                if (!$upload_response['status']) {
                    $this->session->set_flashdata('error', 'Error upload gambar: '.$upload_response['message']);
                    redirect('product');
                    return;
                }
            } else {
                $image_filename = null;
            }
            
            $data = [
                'name' => htmlspecialchars($this->input->post('name', TRUE)),
                'price' => $this->input->post('price', TRUE),
                'stock' => $this->input->post('stock', TRUE),
                'description' => htmlspecialchars($this->input->post('description', TRUE)),
                'category_id' => $this->input->post('category_id', TRUE),
                'image' => $image_filename,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $insert_id = $this->Product_model->create($data);
            if ($insert_id) {
                $this->session->set_flashdata('success', 'Produk berhasil ditambahkan dengan ID '.$insert_id);
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data produk. Silakan coba lagi.');
            }
            
            redirect('product');
        }
    }

    private function _upload_image()
    {
        $config['upload_path'] = './uploads/products/';
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('image')) {
            return [
                'status' => false,
                'message' => $this->upload->display_errors('', '')
            ];
        } else {
            return [
                'status' => true,
                'file_name' => $this->upload->data('file_name')
            ];
        }
    }

    // Add this to Product_model
    public function get_categories()
    {
        $this->db->order_by('category_name', 'ASC');
        return $this->db->get('categories')->result_array();
    }

    public function edit($id)
    {
        $data['product'] = $this->Product_model->get_by_id($id);
        $this->load->view('products/edit', $data);
    }

    public function update($id)
    {
        $this->form_validation->set_rules('name', 'Nama', 'required');
        $this->form_validation->set_rules('price', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('stock', 'Stok', 'required|integer');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
        } else {
            $this->Product_model->update($id, $this->input->post());
            redirect('product');
        }
    }

    public function delete($id)
    {
        // Get product details before deletion to access the image filename
        $product = $this->Product_model->get_by_id($id);
        
        if (!$product) {
            $this->session->set_flashdata('error', 'Produk tidak ditemukan.');
            redirect('product');
            return;
        }
        
        // Delete the product from database
        $deleted = $this->Product_model->delete($id);
        
        if ($deleted) {
            // Delete associated image if exists
            if (!empty($product['image'])) {
                $image_path = './uploads/products/' . $product['image'];
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
            }
            
            $this->session->set_flashdata('success', 'Produk berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus produk.');
        }
        
        redirect('product');
    }
}

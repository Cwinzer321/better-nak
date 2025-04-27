<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(['url', 'form', 'my_helper']);
        $this->load->library(['cart', 'form_validation']);
        $this->load->model(['product_model', 'order_model']);
    }

    public function index() {
        $data['title'] = 'Selamat Datang di Better-nak';
        $data['description'] = 'Penjualan Ternak Terpercaya dan Transparan';
        $data['latest_products'] = $this->product_model->get_latest(4);
        $data['total_orders'] = $this->order_model->count_orders();
        
        $this->load->view('templates/header', $data);
        $this->load->view('welcome_message', $data);
        $this->load->view('templates/footer');
    }

    public function create() {
        $data['title'] = 'Create New Product';

        $config['upload_path'] = './uploads/products/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        // Create upload directory if it doesn't exist
        if (!is_dir('uploads/products')) {
            mkdir('./uploads/products', 0777, true);
        }

        $this->form_validation->set_rules('name', 'Product Name', 'required|trim');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('products/create', $data);
            $this->load->view('templates/footer');
        } else {
            if (!$this->upload->do_upload('image')) {
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
                redirect('welcome/create');
            } else {
                $upload_data = $this->upload->data();
                $product_data = array(
                    'name' => $this->input->post('name'),
                    'price' => $this->input->post('price'),
                    'description' => $this->input->post('description'),
                    'image' => $upload_data['file_name']
                );
                $this->product_model->create_product($product_data);
                $this->session->set_flashdata('success', 'Product created successfully');
                redirect('products');
            }
        }
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('order_model');
        $this->load->helper(['url', 'form', 'string', 'my_helper']);
        $this->load->library(['form_validation', 'cart']);
    }

    public function index() {
        $data['title'] = 'Products List';
        $data['products'] = $this->product_model->get_all();
        
        $this->load->view('templates/header', $data);
        $this->load->view('products/list', $data);
        $this->load->view('templates/footer');
    }

    public function add_to_cart($product_id) {
        $product = $this->product_model->get($product_id);
        
        if ($product) {
            $data = array(
                'id'    => $product['id'],
                'qty'   => 1,
                'price' => $product['price'],
                'name'  => $product['name']
            );
            
            $this->cart->insert($data);
            $this->session->set_flashdata('success', 'Product added to cart successfully');
        } else {
            $this->session->set_flashdata('error', 'Product not found');
        }
        
        redirect('products/cart');
    }

    public function cart() {
        $data['title'] = 'Shopping Cart';
        
        $this->load->view('templates/header', $data);
        $this->load->view('products/cart', $data);
        $this->load->view('templates/footer');
    }

    public function checkout() {
        if ($this->cart->total_items() == 0) {
            $this->session->set_flashdata('error', 'Your cart is empty');
            redirect('products');
        }

        $this->load->helper('string');
        $order_data = array(
            'order_number' => 'ORD-' . date('Ymd') . '-' . random_string('numeric', 4),
            'order_date' => date('Y-m-d H:i:s'),
            'total_amount' => $this->cart->total(),
            'status' => 'pending'
        );

        $order_id = $this->order_model->create($order_data);

        foreach ($this->cart->contents() as $item) {
            $order_item = array(
                'order_id' => $order_id,
                'product_id' => $item['id'],
                'quantity' => $item['qty'],
                'price' => $item['price']
            );
            $this->order_model->add_order_item($order_item);
        }

        $this->cart->destroy();
        $this->session->set_flashdata('success', 'Order placed successfully!');
        redirect('products/invoice/' . $order_id);
    }

    public function invoice($order_id) {
        $data['title'] = 'Invoice';
        $data['order'] = $this->order_model->get_order($order_id);
        $data['items'] = $this->order_model->get_order_items($order_id);
        
        if (!$data['order']) {
            $this->session->set_flashdata('error', 'Invoice not found');
            redirect('products');
        }
        
        $this->load->view('products/invoice', $data);
    }

    public function edit($id) {
        $data['title'] = 'Edit Product';
        $data['product'] = $this->product_model->get($id);
        
        if(empty($data['product'])) {
            $this->session->set_flashdata('error', 'Product not found');
            redirect('products');
        }

        $this->form_validation->set_rules('name', 'Product Name', 'required|trim');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('description', 'Description', 'required|trim');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', $data);
            $this->load->view('products/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $this->product_model->update_product($id);
            $this->session->set_flashdata('success', 'Product updated successfully');
            redirect('products');
        }
    }

    public function delete($id) {
        if ($this->product_model->delete_product($id)) {
            $this->session->set_flashdata('success', 'Produk berhasil dihapus/dinonaktifkan');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus produk');
        }
        redirect('products');
    }
}
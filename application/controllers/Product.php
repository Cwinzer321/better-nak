<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property session $session
 * @property Product_model $Product_model
 * @property form_validation $form_validation
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
        $this->form_validation->set_rules('name', 'Nama', 'required');
        $this->form_validation->set_rules('price', 'Harga', 'required|numeric');
        $this->form_validation->set_rules('stock', 'Stok', 'required|integer');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('products/create');
        } else {
            $this->Product_model->create($this->input->post());
            redirect('product');
        }
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
        $this->Product_model->delete($id);
        redirect('product');
    }
}

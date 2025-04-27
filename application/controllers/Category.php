<?php
class Category extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Category_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['categories'] = $this->Category_model->get_all();
        $this->load->view('categories/index', $data);
    }

    public function create()
    {
        $this->form_validation->set_rules('name', 'Nama Kategori', 'required');
        $this->form_validation->set_rules('type', 'Jenis', 'required|in_list[livestock,product]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('categories/create');
        } else {
            $this->Category_model->create($this->input->post());
            redirect('category');
        }
    }

    public function edit($id)
    {
        $data['category'] = $this->Category_model->get_by_id($id);
        $this->load->view('categories/edit', $data);
    }

    public function update($id)
    {
        $this->form_validation->set_rules('name', 'Nama Kategori', 'required');
        $this->form_validation->set_rules('type', 'Jenis', 'required|in_list[livestock,product]');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
        } else {
            $this->Category_model->update($id, $this->input->post());
            redirect('category');
        }
    }

    public function delete($id)
    {
        $this->Category_model->delete($id);
        redirect('category');
    }
}

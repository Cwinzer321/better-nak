<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property Kategori_model $Kategori_model
 */
class Kategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kategori_model'); // Add this line
    }

    public function index()
    {
        $data['kategori'] = $this->Kategori_model->get_all();
        $this->load->view('kategori/index', $data);
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property Produk_model $Produk_model
 * @property Category_model $Category_model
 * @property pagination $pagination
 * @property uri $uri
 */
class Shop extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(['User_model', 'Cart_model', 'Notification_model', 'Produk_model']);
	}

	public function index()
	{
		$this->load->library('pagination');
		$config['base_url'] = site_url('shop');
		$config['total_rows'] = $this->Produk_model->count_products();
		$config['per_page'] = 12;
		$config['uri_segment'] = 2;

		$this->pagination->initialize($config);

		$data['page'] = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		$data['products'] = $this->Produk_model->get_products($config['per_page'], $data['page']);
		$data['pagination'] = $this->pagination->create_links();
		$data['categories'] = $this->Category_model->get_categories_with_count();
		$data['total_products'] = $this->Produk_model->get_total_products();
		$this->load->view('shop/index', $data);
	}
}

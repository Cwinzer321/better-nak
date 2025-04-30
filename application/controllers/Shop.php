<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property Produk_model $Produk_model
 * @property Category_model $Category_model
 * @property pagination $pagination
 * @property uri $uri
 * @property input $input
 */
class Shop extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model([
			'User_model', 
			'Cart_model', 
			'Notification_model', 
			'Produk_model',
			'Category_model'  // Add this line
		]);
	}

	public function index()
	{
		$this->load->library('pagination');
		$data = [];
		
		// Get filter parameters first
		$category_id = $this->input->get('category_id');
		$search = $this->input->get('search');

		// Configure pagination
		$config['base_url'] = site_url('shop');
		$config['per_page'] = 12;
		$config['uri_segment'] = 2;
		$config['reuse_query_string'] = true;
		
		// Get total rows and products
		$config['total_rows'] = $this->Produk_model->count_products($category_id, $search);
		$this->pagination->initialize($config);

		$data['page'] = $this->uri->segment(2) ?? 0;
		
		// Get products with pagination
		$data['products'] = $this->Produk_model->get_products(
			$config['per_page'],
			$data['page'],
			$category_id,
			$search
		);

		// Get categories
		$data['categories'] = $this->Category_model->get_all_categories();
		$data['pagination'] = $this->pagination->create_links();
		
		$this->load->view('shop/index', $data);
	}
}

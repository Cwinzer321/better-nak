<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property Produk_model $Produk_model
 */
class Shopdetail extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->model('Cart_model');
		$this->load->model('Notification_model');
		$this->load->model('Produk_model');  // Move model loading to constructor
	}

	public function index($id_produk = null)
	{
		try {
			// Validate product ID
			if(!$id_produk || !is_numeric($id_produk)) {
				throw new Exception('Invalid product ID');
			}
			
			// Get product data
			$data['product'] = $this->Produk_model->get_product_by_id($id_produk);
			
			if(empty($data['product'])) {
				show_404();
			}
			
			$this->load->view('shop-detail/index', $data);
			
		} catch (Exception $e) {
			log_message('error', 'Shopdetail error: '.$e->getMessage());
			show_404();
		}
	}
}

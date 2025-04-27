<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property session $session
 * @property Cart_model $Cart_model
 * @property input $input
 * @property Produk_model $Produk_model
 */
class Cart extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(['Notification_model', 'Cart_model', 'Produk_model']);
		$this->load->library('cart');
	}

	public function get_cart_count()
	{
		$user_id = $this->session->userdata('user_id');
		$count = $this->Cart_model->getCartCount($user_id);
		header('Content-Type: application/json');
		echo json_encode(['count' => $count]);
	}

	public function index()
	{
		$user_id = $this->session->userdata('user_id');
		$data['shipping_rate'] = 0;
		$data['shipping_destination'] = '';
		$data['cart_items'] = $this->Cart_model->getCart($user_id);
		$this->load->view('cart/index', $data);
	}

	public function add()
	{
		$product_id = $this->input->post('product_id');
		$quantity = (int) $this->input->post('quantity');

		$product = $this->Produk_model->get_product_by_id($product_id);

		if (!$product || $quantity < 1) {
			$this->session->set_flashdata('error', 'Produk tidak valid');
			redirect($_SERVER['HTTP_REFERER']);
		}

		if ($this->Cart_model->check_stock($product_id, $quantity)) {
			// Tambahkan produk ke keranjang (langsung ke DB)
			$user_id = $this->session->userdata('user_id');
			$this->Cart_model->add_to_cart_db($user_id, $product_id, $quantity);
			$this->session->set_flashdata('success', 'Produk berhasil ditambahkan ke keranjang');
			redirect('cart/index');
		} else {
			$this->session->set_flashdata('error', 'Stok tidak mencukupi');
		}

		redirect($_SERVER['HTTP_REFERER']);
	}

	public function save()
	{
		if (!$this->session->userdata('logged_in')) {
			show_error('Unauthorized', 401);
		}

		$user_id = $this->session->userdata('user_id');
		if (!$user_id) {
			show_error('User ID tidak valid', 400);
		}

		$cart_items = $this->Cart_model->contents($user_id);
		if (empty($cart_items)) {
			show_error('Keranjang belanja kosong', 400);
		}

		if ($this->Cart_model->save_cart($user_id, $cart_items)) {
			echo json_encode(['status' => 'success']);
		} else {
			show_error('Gagal menyimpan keranjang', 500);
		}
	}
}

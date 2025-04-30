<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property session $session
 * @property User_model $User_model
 * @property Cart_model $Cart_model
 * @property Produk_model $Produk_model
 * @property Testimonial_model $Testimonial_model
 */

class Beranda extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('date');
        $this->load->model(['Notification_model', 'User_model', 'Cart_model', 'Produk_model', 'Testimonial_model']);
    }
    public function index() {
        $this->load->helper('date');
        $data = [];

        if ($this->session->userdata('logged_in')) {
            $data['profile_picture'] = $this->User_model->get_profile_picture($this->session->userdata('user_id'));
            if ($this->session->userdata('logged_in')) {
                $data['cart_items'] = $this->Cart_model->getCart($this->session->userdata('user_id'));
            }
        }

        // In your Beranda controller's index method:
        $data['products'] = $this->Produk_model->get_products();
        $data['testimonials'] = $this->Testimonial_model->get_testimonials();
        $this->load->view('beranda/index', $data);
    }
}

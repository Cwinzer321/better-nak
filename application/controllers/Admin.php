<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property session $session
 * @property Admin_model $Admin_model
 * @property User_model $User_model
 */
class Admin extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model(['User_model', 'Admin_model']);
        $this->_check_auth();
    }

    private function _check_auth() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('auth');
        }
    }

    public function dashboard() {
        $data = [
            'total_users' => $this->User_model->count_users(),
            'total_sellers' => $this->User_model->count_users('seller'),
            'total_products' => $this->Admin_model->count_all_products(),
            'recent_users' => $this->Admin_model->get_recent_users(5)
        ];
        $this->load->view('admin/dashboard', $data);
    }

    // User Management
    public function manage_users() {
        $data['users'] = $this->Admin_model->get_all_users();
        $this->load->view('admin/users/list', $data);
    }

    public function toggle_user_status($user_id) {
        $this->Admin_model->toggle_user_status($user_id);
        redirect('admin/manage_users');
    }

    // Product Management
    public function manage_products() {
        $data['products'] = $this->Admin_model->get_all_products();
        $this->load->view('admin/products/list', $data);
    }
}
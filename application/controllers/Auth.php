<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property session $session
 * @property form_validation $form_validation
 * @property Auth_model $Auth_model
 * @property input $input
 * @property User_model $User_model
 */
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library(['form_validation', 'session']);
    }

    // Common login for all roles
    public function login()
    {
        // If user is already logged in, redirect to appropriate dashboard
        if ($this->session->userdata('logged_in')) {
            $this->_redirect_by_role($this->session->userdata('role'));
        }

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run()) {
            $user = $this->User_model->check_credentials(
                $this->input->post('email'),
                $this->input->post('password')
            );

            if ($user) {
                $this->session->set_userdata([
                    'logged_in' => true,
                    'user_id' => $user->id,
                    'role' => $user->role,
                    'email' => $user->email,
                    'name' => $user->name
                ]);

                $this->_redirect_by_role($user->role);
            } else {
                $this->session->set_flashdata('error', 'Email atau password salah');
                redirect('auth/login');
            }
        }
        $this->load->view('auth/login');
    }

    // Registration selection page
    public function pilih()
    {
        // If user is already logged in, redirect to appropriate dashboard
        if ($this->session->userdata('logged_in')) {
            $this->_redirect_by_role($this->session->userdata('role'));
        }

        $this->load->view('auth/pilih');
    }

    // Registration handlers
    public function register_customer()
    {
        $this->_register_user('customer', 'auth/register_customer');
    }

    public function register_seller()
    {
        $this->_register_user('seller', 'auth/register_seller');
    }

    public function register_admin()
    {
        // Verify admin code first
        if (!$this->_validate_admin_code()) {
            $this->session->set_flashdata('error', 'Kode admin tidak valid');
            redirect('auth/pilih');
        }
        $this->_register_user('admin', 'auth/register_admin');
    }

    private function _register_user($role, $view)
    {
        // If user is already logged in, redirect to appropriate dashboard
        if ($this->session->userdata('logged_in')) {
            $this->_redirect_by_role($this->session->userdata('role'));
        }

        // Common validation rules for all users
        $this->form_validation->set_rules('nama', 'Username', 'required|trim|min_length[3]|max_length[50]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
            'is_unique' => 'Email ini sudah terdaftar!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]', [
            'min_length' => 'Password terlalu pendek! Minimal 6 karakter'
        ]);
        $this->form_validation->set_rules('password2', 'Konfirmasi Password', 'required|trim|matches[password1]', [
            'matches' => 'Konfirmasi password tidak sama!'
        ]);

        // Additional validation rules for sellers
        if ($role === 'seller') {
            $this->form_validation->set_rules('notelp', 'Nomor Telepon', 'required|trim|numeric|min_length[10]|max_length[13]');
            $this->form_validation->set_rules('nama_toko', 'Nama Peternakan', 'required|trim|min_length[3]');
            $this->form_validation->set_rules('alamat_toko', 'Alamat Peternakan', 'required|trim|min_length[10]');
            $this->form_validation->set_rules('no_dana', 'Nomor Dana', 'required|trim|numeric|min_length[10]|max_length[13]');
        }

        if ($this->form_validation->run()) {
            $user_data = [
                'name' => $this->input->post('nama'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role' => $role,
                'status' => 'active'
            ];

            // Additional data for sellers
            if ($role === 'seller') {
                $user_data['phone'] = $this->input->post('notelp');
                $user_data['farm_name'] = $this->input->post('nama_toko');
                $user_data['farm_address'] = $this->input->post('alamat_toko');
                $user_data['dana_number'] = $this->input->post('no_dana');
            }

            if ($this->User_model->create_user($user_data)) {
                // In your registration success handler:
                $this->session->set_flashdata('success_register', 'Registrasi penjual berhasil! Silakan login');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
            }
        }
        $this->load->view($view);
    }

    private function _validate_admin_code()
    {
        $submitted_code = $this->input->post('admin_code');
        $valid_code = 'SECRET_CODE'; // Store this in config/constants.php
        return $submitted_code === $valid_code;
    }

    private function _redirect_by_role($role)
    {
        switch ($role) {
            case 'admin':
                redirect('admin/dashboard');
                break;
            case 'seller':
                redirect('seller/dashboard');
                break;
            default:
                redirect('beranda');
                break;
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('beranda');
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * @property session $session
 * @property User_model $User_model
 * @property upload $upload
 */
class Profile extends CI_Controller
{

	public function index()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('auth');
		}

		$this->load->model('User_model');
		$id_user = $this->session->userdata('id_user');
		$user = $this->User_model->getUserById($id_user);

		if (!$user) {
			// Jika user tidak ditemukan, hapus session dan arahkan ke login
			$this->session->sess_destroy();
			redirect('auth');
		}

		$data['user'] = $user;
		$this->load->view('profile/index', $data);
	}

	public function update_profile()
	{
		$this->load->model('User_model');

		$config['upload_path'] = './uploads/profile_pictures/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size'] = 2048;
		$config['file_name'] = 'profile_' . $this->session->userdata('id_user');

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('profile_picture')) {
			$error = $this->upload->display_errors();
			$this->session->set_flashdata('error', $error);
			redirect('profile');  // Added redirect for error case
		} else {
			$data = array('upload_data' => $this->upload->data());
			$filename = $data['upload_data']['file_name'];
			$this->User_model->update_profile_picture($this->session->userdata('id_user'), $filename);
			$this->session->set_flashdata('success', 'Foto profil berhasil diperbarui');
			redirect('beranda');  // Existing success redirect
		}
	}

	public function delete_profile_picture()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('auth');
		}

		$this->load->model('User_model');
		$id_user = $this->session->userdata('id_user');
		$user = $this->User_model->getUserById($id_user);

		if (!empty($user['profile_picture'])) {
			$file_path = './uploads/profile_pictures/' . $user['profile_picture'];
			if (file_exists($file_path)) {
				unlink($file_path);
			}
			$this->User_model->update_profile_picture($id_user, null);
			$this->session->set_flashdata('success', 'Foto profil berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Tidak ada foto profil untuk dihapus.');
		}

		redirect('profile');
	}

	public function delete_profile()
	{
		if (!$this->session->userdata('logged_in')) {
			redirect('auth');
		}

		$this->load->model('User_model');
		$id_user = $this->session->userdata('id_user');
		$this->User_model->delete_user($id_user);
		$this->session->sess_destroy();
		redirect('auth');
	}
}

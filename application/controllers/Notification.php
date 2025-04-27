<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property session $session
 * @property Notification_model $Notification_model
 */
class Notification extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notification_model');
        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    public function index()
    {
        $data['notifications'] = $this->Notification_model->getNotifications(
            $this->session->userdata('user_id'),
            20
        );
        $this->load->view('templates/header');
        $this->load->view('notification/index', $data);
        $this->load->view('templates/footer');
    }

    public function mark_all_read()
    {
        $this->Notification_model->markAllRead(
            $this->session->userdata('user_id')
        );
        redirect($_SERVER['HTTP_REFERER']);
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Aboutus extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['User_model', 'Cart_model', 'Notification_model']);
    }

    public function index()
    {
        $this->load->view('about-us/index');
    }
}

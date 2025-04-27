<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Testimonial extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Testimonial_model');
	}

	public function index()
	{
		$this->load->view('testimonial/index');
	}
}

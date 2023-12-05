<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model');
		if (!$this->Auth_model->current_user()) {
			redirect('login/logout');
		}
	}
	public function index()
	{
		$data['user'] = $this->Auth_model->current_user();
		$this->load->view('home', $data);
	}
}

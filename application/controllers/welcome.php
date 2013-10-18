<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index()	{
		$this->load->library('form_validation');
		// UI
		$data = array();
		$this->load->view('welcome_message', $data);
	}
}


<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Login_Controller_Hybrid {

	public function __construct() {
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function index() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		parent::index();
		redirect('/');
	}

}
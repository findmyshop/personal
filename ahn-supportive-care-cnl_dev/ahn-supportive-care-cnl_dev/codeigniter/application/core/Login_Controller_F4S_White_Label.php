<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_Controller_F4S_White_Label extends Login_Controller {

	public function __construct() {
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function admin() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->template_library
			->set_title('Dashboard')
			->set_module('Users')
			->set_using_angularjs(TRUE, 'userApp')
			->set_timeout_check_interval(60)
			->build('login/login_index', $this->_data, 'login/login_header', 'login/login_admin');
	}

	public function index() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');
		redirect('/');
	}

}
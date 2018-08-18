<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Login_Controller_Hybrid {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		parent::index();
		redirect('/');
	}

}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Login_Controller_Military_Training {

	public function __construct() {
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

}
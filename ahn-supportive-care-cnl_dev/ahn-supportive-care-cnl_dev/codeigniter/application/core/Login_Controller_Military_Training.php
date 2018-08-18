<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_Controller_Military_Training extends Login_Controller_Training {
	public function __construct() {
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

}
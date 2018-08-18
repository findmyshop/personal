<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller_Clinical_Trials {

	public function __construct() {
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function users() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		if(is_admin()) {
			parent::users();
		} else {
			redirect('admin');
		}
	}

	public function activity_logs() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		if(!is_site_admin()) {
			parent::activity_logs();
		} else {
			redirect('admin');
		}
	}
}

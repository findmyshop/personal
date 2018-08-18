<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller_Clinical_Trials {

	public function __construct() {
		parent::__construct();

		$this->_data['mr_project_filter'] = array(
			'all'	=> 'All',
			'pra'	=> 'PRA',
			'prb'	=> 'PRB',
			'prc'	=> 'PRC'
		);

		// this serves no purpose other than to change the encrypted session data stored in the cookie.  needed to satisfy a Pfizer "security" audit finding
		$this->session->set_userdata('timestamp', now());

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function activity_logs() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->template_library
			->set_title("Dashboard")
			->set_module('Activity')
			->set_using_angularjs(TRUE, 'userApp')
			->set_timeout_check_interval(60)
			->build('admin/admin_index', $this->_data, 'admin/admin_header', 'admin/admin_activity_logs');
	}

	public function index() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->template_library
			->set_title("Dashboard")
			->set_module('Users')
			->set_using_angularjs(TRUE, 'userApp')
			->set_timeout_check_interval(60)
			->build('admin/admin_index', $this->_data, 'admin/admin_header', 'admin/admin_dashboard');
	}

	public function users() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		if(is_admin()) {
			parent::users();
		} else {
			redirect('admin');
		}
	}

}

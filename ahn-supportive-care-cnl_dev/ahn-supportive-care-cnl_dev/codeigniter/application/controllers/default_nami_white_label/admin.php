<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller_Nami_White_Label {

	public function __construct() {
		parent::__construct();

		$this->_data['mr_project_filter'] = array(
			'all'												=> 'All',
			'nami_white_label_demo_asl'	=> 'Demo ASL',
			'nami_white_label_demo_eng'	=> 'Demo English'
		);

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

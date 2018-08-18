<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Disclaimer extends MY_Controller
{
	private $account_id = FALSE;
	private $default_course = FALSE;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('course_model');
		$this->account_id = $this->session->userdata('account_id');

		if(($this->default_course = $this->course_model->get_active_course($this->account_id)) === FALSE)
		{
			die('error - an active course was not found. Please report this problem to your system administrator.');
		}

		if (is_admin() || !empty($this->default_course['disclaimer_accepted']))
		{
			redirect('/');
		}

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function ajax_angular_accept_disclaimer()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
				'status'		=> 'success',
				'message'		 => '',
				'rid' => $this->default_course['after_disclaimer']
		);

		// for those not seeking accreditation
		if ($this->default_course ['accreditation_type_id'] == -1)
		{
			echo json_encode($this->_data);
			return;
		}

		$this->course_model->accept_disclaimer($this->account_id, $this->default_course['accreditation_type_id']);

		echo json_encode($this->_data);
		return;
	}

	public function ajax_angular_load_active_course()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
				'status'		=> 'success',
				'message'		 => '',
		);
		$this->_data['active_course'] = $this->default_course;
		echo json_encode($this->_data);
	}

	public function index()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$project_title = $this->property_model->get_title(MR_PROJECT);

		$this->template_library
		->set_title($project_title)
		->set_module('Disclosure')
		->set_using_angularjs(TRUE, 'trainingDisclaimerApp')
		->set_timeout_check_interval(60)
		->build('disclaimer/disclaimer_index', $this->_data, 'disclaimer/disclaimer_header', 'disclaimer/disclaimer_base');
	}
}
?>
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base_Certification extends MY_Controller {

	private $account_id = FALSE;
	private $default_course = FALSE;

	public function __construct() {
		parent::__construct();
		$this->load->model('course_model');
		$this->load->model('address_model');

		$this->account_id = $this->session->userdata('account_id');

		$this->default_course = $this->course_model->get_active_course($this->account_id);

		// for those not seeking accreditation
		if ($this->default_course['accreditation_type_id'] == -1) {
			redirect('/admin/user');
		}

		if (is_admin() /*|| !empty($this->default_course['certificate_page_accepted'])*/) {
			redirect('/');
		}

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function ajax_angular_accept_certificate() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
				'status'		=> 'success',
				'message'		 => '',
				'return_id' => $this->default_course['after_certification'],
				'default_course' => $this->default_course
		);

		// for those with no accreditation type set
		if ($this->default_course['accreditation_type_id'] == -1) {
			echo json_encode($this->_data);
			return;
		}

		if(is_admin() || !empty($this->default_course['certificate_page_accepted'])) {
			echo json_encode($this->_data);
			return;
		}

		$this->course_model->accept_certificate($this->account_id, $this->default_course['course_id'], $this->default_course['accreditation_type_id']);
		$this->course_model->complete_active_course($this->account_id);
		echo json_encode($this->_data);
		return;
	}

	public function ajax_barf_certificate() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
				'status'	=> 'success',
				'message'		=> ''
		);

		$this->_data['return_id'] = $this->default_course['after_certification'];
		$this->_data['user'] = $this->user_model->get_sbirt_user($this->account_id);
		$this->_data['states'] = $this->address_model->get_states();
		$this->_data['countries'] = $this->address_model->get_countries(FALSE, TRUE);
		$this->_data['country_name'] = $this->address_model->get_country_name($this->_data['user']['country_id']);
		$this->_data['state_abbreviation'] = $this->address_model->get_state_abbreviation($this->_data['user']['state_id']);
		$this->_data['active_course'] = $this->default_course;

		if (!empty($this->_data['active_course']['course_id'])) {
			$this->_data['content_knowlege_test_stats'] = $this->course_model->get_content_knowlege_test_stats(
					$this->_data['active_course']['user_id'],
					$this->_data['active_course']['course_id'],
					$this->_data['active_course']['current_iteration']
			);
		} else {
			$this->_data['content_knowlege_test_stats'] = array();
		}

		echo json_encode($this->_data);
		return;
	}

	public function ajax_barf_old_certificate() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
				'status'	=> 'success',
				'message'		=> ''
		);

		$postdata = file_get_contents("php://input");
		$course_data = json_decode($postdata);

		$the_course = $this->course_model->get_user_course($this->account_id, $course_data->course_id, $course_data->current_iteration);
		$this->_data['barfed_user'] = $this->user_model->get_training_user($this->account_id);
		$this->_data['barfed_course'] = $the_course;
		$this->_data['barfed_course']['accreditation_type_id'] = $this->user_model->get_user_accreditation_type_id($this->account_id);
		$this->_data['barfed_course']['accreditation_type'] = $this->user_model->get_accreditation_type_name($this->_data['barfed_course']['accreditation_type_id']);
		$this->_data['barfed_course']['course_name'] = $this->course_model->get_course_name($course_data->course_id);
		$this->_data['states'] = $this->address_model->get_states();
		$this->_data['countries'] = $this->address_model->get_countries(FALSE, TRUE);
		$this->_data['country_name'] = $this->address_model->get_country_name($this->_data['barfed_user']['country_id']);
		$this->_data['state_abbreviation'] = $this->address_model->get_state_abbreviation($this->_data['barfed_user']['state_id']);

		if(!empty($this->_data['barfed_course']['course_id'])) {
			$this->_data['barfed_content_knowlege_test_stats'] = $this->course_model->get_content_knowlege_test_stats(
					$this->_data['barfed_course']['user_id'],
					$this->_data['barfed_course']['course_id'],
					$this->_data['barfed_course']['current_iteration'],
					FALSE
			);
		} else {
			$this->_data['barfed_content_knowlege_test_stats'] = array();
		}

		echo json_encode($this->_data);
		return;
	}

	public function ajax_angular_update_user_address() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
				'status'		=> 'success',
				'message'		 => ''
		);

		// get post data
		$postdata = file_get_contents("php://input");
		$postvars = $this->_data['user'] = json_decode($postdata);
		$this->user_model->update_user_address(
				$this->account_id,
				1, /* mailing address */
				$postvars->user->address_1,
				$postvars->user->address_2,
				$postvars->user->city,
				$postvars->user->state_id,
				$postvars->user->province,
				$postvars->user->zip,
				$postvars->user->country_id
		);

		echo json_encode($this->_data);
	}

	public function ajax_angular_load_active_course() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
				'status'		=> 'success',
				'message'		 => '',
		);

		$this->_data['active_course'] = $this->default_course;
		$this->_data['user'] = $this->user_model->get_sbirt_user($this->account_id);
		$this->_data['states'] = $this->address_model->get_states();
		$this->_data['countries'] = $this->address_model->get_countries(FALSE, TRUE);
		$this->_data['country_name'] = $this->address_model->get_country_name($this->_data['user']['country_id']);
		$this->_data['state_abbreviation'] = $this->address_model->get_state_abbreviation($this->_data['user']['state_id']);

		if(!empty($this->_data['active_course']['course_id'])) {
			//pp($this->_data['active_course']);
			$this->_data['content_knowlege_test_stats'] = $this->course_model->get_content_knowlege_test_stats(
					$this->_data['active_course']['user_id'],
					$this->_data['active_course']['course_id'],
					$this->_data['active_course']['current_iteration']
			);
		} else {
			$this->_data['content_knowlege_test_stats'] = array();
		}

		echo json_encode($this->_data);
	}

	public function index() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$project_title = $this->property_model->get_title(MR_PROJECT);

		$this->template_library
		->set_title($project_title)
		->set_module('Certification')
		->set_using_angularjs(TRUE, 'sbirtCertificationApp')
		->set_timeout_check_interval(60)
		->build('certification/certification_index', $this->_data, 'certification/certification_header', 'certification/certification_base');
	}
}

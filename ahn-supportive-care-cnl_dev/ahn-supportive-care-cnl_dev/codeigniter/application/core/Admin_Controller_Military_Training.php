<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller_Military_Training extends Admin_Controller_Training {

	public function __construct() {
		parent::__construct();
		$this->load->model('military_course_model');

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function ajax_angular_activate_course() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
				'status'		=> 'success',
				'message'		 => '',
		);

		$postdata = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata);
		$course_id = $postdata_decoded->course_id;

		$this->_data['course'] = $this->military_course_model->activate_course($this->account_id, $course_id);
		$iteration = $this->_data['course']['current_iteration'];
		/* Return to Flow ID */
		$this->_data['last_id'] = $this->military_course_model->get_last_response_id($this->account_id, $course_id, $iteration);

		echo json_encode($this->_data);
		return;
	}

	public function ajax_angular_add_user() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
				'status'		=> 'success',
				'message'		 => '',
				'user'			=> array()
		);

		// get post data
		$postdata = file_get_contents("php://input");
		$new_user = $this->_data['user'] = json_decode($postdata);

		if(!$this->_perform_user_validation('add', $new_user)) {
			return;
		}

		// generate user name
		$username = $this->user_model->generate_username($_POST['first_name'], $_POST['middle_initial'], $_POST['last_name']);

		if (!($user_id = $this->user_model->insert_sbirt_user(
				$_POST['pay_grade_id'],
				$_POST['first_name'],
				$_POST['middle_initial'],
				$_POST['last_name'],
				$_POST['department_id'],
				$_POST['dod_number'],
				$_POST['role_id'],
				$_POST['accreditation_type_id'],
				$_POST['treatment_facility_id'],
				$username,
				$_POST['user_type_id'],
				$_POST['email'],
				$_POST['password'],
				$_POST['address_1'],
				$_POST['address_2'],
				$_POST['city'],
				$_POST['state_id'],
				$_POST['province'],
				$_POST['zip'],
				$_POST['country_id'],
				$_POST['login_enabled']
		))) {
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Error updating user';
			echo json_encode($this->_data);
			return;
		}

		$this->military_course_model->initialize_course_assignment_upon_registraton($user_id);
		$this->military_course_model->initialize_user_certificate($user_id);
		$_POST = array();
		$this->_data['user']->username = $username;
		echo json_encode($this->_data);
		return;
	}

	public function ajax_angular_default_course() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
				'status'		=> 'success',
				'message'		 => '',
				'user'			=> FALSE
		);

		$default_course = $this->military_course_model->get_active_course($this->account_id);
		$this->_data['all_courses'] = $this->military_course_model->get_user_courses($this->account_id);
		$this->_data['all_user_courses_and_iterations'] = $this->military_course_model->get_user_courses_and_iterations($this->account_id);

		if(!empty($default_course)) {
			$course_activity = $this->military_course_model->get_user_course_activity($this->account_id, $default_course);
			$course_stats = $this->military_course_model->get_course_stats($default_course);
			$this->_data['active_course'] = !empty($default_course) ? $default_course : array();
			$this->_data['course_stats'] = !empty($course_stats) ? $course_stats : array();
			$this->_data['course_activity'] = !empty($course_activity) ? $course_activity : array();
			$this->_data['return_id'] = !empty($default_course) ? $default_course['after_certification'] : 'null';

			/* Return to Flow ID */
			$iteration = $this->_data['active_course']['current_iteration'];
			$course_id = $this->_data['active_course']['course_id'];
			$last_id = $this->military_course_model->get_last_response_id($this->account_id, $course_id, $iteration);
			if ($last_id != false){
				$this->_data['last_id'] = '/#/START/'.$last_id;
			} else {
				$this->_data['last_id'] = '/';
			}
		}

		echo json_encode($this->_data);
	}

	public function ajax_angular_edit_user() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
				'status'		=> 'success',
				'message'		 => '',
				'user'			=> array()
		);

		$postdata = file_get_contents("php://input");
		$user = $this->_data['user'] = json_decode($postdata);

		if(!$this->_perform_user_validation('edit', $user)) {
			return;
		}

		$previous_user_course_id = $this->military_course_model->get_active_course_id($_POST['id']);
		$current_user_course_id = $this->military_course_model->get_course_id_given_role($_POST['role_id']);

		if(!$this->user_model->update_sbirt_user(
				$_POST['id'],
				$_POST['pay_grade_id'],
				$_POST['first_name'],
				$_POST['middle_initial'],
				$_POST['last_name'],
				$_POST['department_id'],
				$_POST['dod_number'],
				$_POST['role_id'],
				$_POST['accreditation_type_id'],
				$_POST['treatment_facility_id'],
				$_POST['user_type_id'],
				$_POST['email'],
				$_POST['password'],
				$_POST['address_1'],
				$_POST['address_2'],
				$_POST['city'],
				$_POST['state_id'],
				$_POST['province'],
				$_POST['zip'],
				$_POST['country_id'],
				$_POST['login_enabled']
		)) {
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Error updating user';
			echo json_encode($this->_data);
			return;
		}

		if(!empty($previous_user_course_id) && !empty($current_user_course_id) && $previous_user_course_id != $current_user_course_id) {
			$this->military_course_model->deactivate_course($_POST['id'], $previous_user_course_id);
			$this->military_course_model->activate_course($_POST['id'], $current_user_course_id);
		}

		$_POST = array();
		echo json_encode($this->_data);
		return;
	}

	public function ajax_angular_export_accreditor_report() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$data = array(
			'status'	=> 'success',
			'message' => '',
			'file'		=> FALSE
		);

		if(!is_admin() && !is_site_admin()) {
			$data['status'] = 'failure';
			$data['message'] = 'You do not have access';
			echo json_encode($data);
			return;
		}

		$postdata = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata, TRUE);

		$start_date = !empty($postdata_decoded['start_date']) ? $postdata_decoded['start_date'] : NULL;
		$end_date = !empty($postdata_decoded['end_date']) ? $postdata_decoded['end_date'] : NULL;
		$accreditation_type_id = ($postdata_decoded['accreditation_type_id'] != -1) ? $postdata_decoded['accreditation_type_id'] : NULL;

		$filename = 'accreditation_export_'.$this->account_id.'_'.date("Y-m-d_H-i-s").'.csv';
		$filepath = FCPATH.'tmp/'.$filename;
		$data['file'] = $filename;

		$status = FALSE;

		try {
			$this->load->library('military_course_library');
			$status = $this->military_course_library->write_accreditation_report_to_csv($accreditation_type_id, $start_date, $end_date, $filepath);
			$this->action_model->insert(Action_model::ACTION_TYPE_ACCREDITATION_REPORTS_CSV_EXPORT);
		} catch(Exception $e) {
			$data['status']	= 'failure';
			$data['message'] = $e->getMessage();
			echo json_encode($data);
			return;
		}

		if($status === FALSE) {
			$data['status'] = 'failure';
			$data['message'] = 'No Records Returned... Aborting Download';
			echo json_encode($data);
			return;
		}

		echo json_encode($data);
	}

	public function ajax_angular_export_user_answers() {
		$data = array(
			'status'	=> 'success',
			'message' => '',
			'file'		=> FALSE
		);

		if(!is_admin() && !is_site_admin()) {
			$data['status'] = 'failure';
			$data['message'] = 'You do not have access';
			echo json_encode($data);
			return;
		}

		$postdata = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata);

		$search = $postdata_decoded->search;
		$department_id = ($postdata_decoded->department_id != -1) ? $postdata_decoded->department_id	: NULL;
		$treatment_facility_id = ($postdata_decoded->treatment_facility_id != -1) ? $postdata_decoded->treatment_facility_id : NULL;
		$role_id = ($postdata_decoded->role_id != -1) ? $postdata_decoded->role_id : NULL;
		$filename = 'user_answers_export_'.$this->account_id.'_'.date("Y-m-d_H-i-s").'.csv';
		$filepath = FCPATH.'tmp/'.$filename;
		$data['file'] = $filename;

		$status = FALSE;

		try {
			$this->load->library('military_course_library');
			$status = $this->military_course_library->write_user_answers_to_csv($search, $department_id, $treatment_facility_id, $role_id, $filepath);
			$this->action_model->insert(Action_model::ACTION_TYPE_ANSWERS_CSV_EXPORT);
		} catch(Exception $e) {
			$data['status']	= 'failure';
			$data['message'] = $e->getMessage();
			echo json_encode($data);
			return;
		}

		if($status === FALSE) {
			$data['status'] = 'failure';
			$data['message'] = 'No Records Returned... Aborting Download';
			echo json_encode($data);
			return;
		}

		echo json_encode($data);
	}

	public function ajax_angular_export_user_courses() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$data = array(
			'status'	=> 'success',
			'message' => '',
			'file'		=> FALSE
		);

		if(!is_admin() && !is_site_admin()) {
			$data['status'] = 'failure';
			$data['message'] = 'You do not have access';
			echo json_encode($data);
			return;
		}

		$postdata = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata);

		$search = $postdata_decoded->search;

		$uncompleted = ($postdata_decoded->uncompleted  != -1) ? ((bool) $postdata_decoded->uncompleted) : NULL;
		$not_passed = ($postdata_decoded->not_passed != -1) ? ((bool) $postdata_decoded->not_passed) : NULL;
		$no_cert = ($postdata_decoded->no_cert != -1) ? ((bool) $postdata_decoded->no_cert) : NULL;
		$department_id = ($postdata_decoded->department_id != -1) ? $postdata_decoded->department_id	: NULL;
		$treatment_facility_id = ($postdata_decoded->treatment_facility_id != -1) ? $postdata_decoded->treatment_facility_id : NULL;
		$role_id = ($postdata_decoded->role_id != -1) ? $postdata_decoded->role_id : NULL;
		$get_detailed_report = ($postdata_decoded->get_detailed_report) ? 1 : 0;
		$filename = 'user_courses_export_'.$this->account_id.'_'.date("Y-m-d_H-i-s").'.csv';
		$filepath = FCPATH.'tmp/'.$filename;
		$data['file'] = $filename;

		$status = FALSE;

		try {
			$this->load->library('military_course_library');

			if($get_detailed_report) {
				$status = $this->military_course_library->write_raw_courses_to_csv($search, $department_id, $treatment_facility_id, $role_id, $filepath);
				$this->action_model->insert(Action_model::ACTION_TYPE_DETAILED_REPORTS_CSV_EXPORT);
			} else {
				$status = $this->military_course_library->write_user_courses_to_csv(FALSE, FALSE, $search, $uncompleted, $not_passed, $no_cert, $department_id, $treatment_facility_id, $role_id, $filepath);
				$this->action_model->insert(Action_model::ACTION_TYPE_REPORTS_CSV_EXPORT);
			}
		} catch(Exception $e) {
			$data['status']	= 'failure';
			$data['message'] = $e->getMessage();
			echo json_encode($data);
			return;
		}

		if($status === FALSE) {
			$data['status'] = 'failure';
			$data['message'] = 'No Records Returned... Aborting Download';
			echo json_encode($data);
			return;
		}

		echo json_encode($data);
	}

	public function ajax_angular_export_users() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$data = array(
			'status'	=> 'success',
			'message' => '',
			'file'		=> FALSE
		);

		if(!is_admin() && !is_site_admin()) {
			$data['status'] = 'failure';
			$data['message'] = 'You do not have access';
			echo json_encode($data);
			return;
		}

		$postdata = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata);

		$search = $postdata_decoded->search;

		$organizations = $this->organization_model->get_organizations_summary(FALSE, PROPERTY_ORGANIZATION_ID);
		$users = $this->user_model->get_sbirt_users($this->user_type, $organizations[0]["id"], $search, NULL, NULL, TRUE);

		if(empty($users)) {
			$data['status'] = 'failure';
			$data['message'] = 'No records returned...aborting upload';
			echo json_encode($data);
			return;
		}

		$filename = 'users_export_'.$this->account_id.'_'.date("Y-m-d_H-i-s").'.csv';
		$filepath = FCPATH.'tmp/'.$filename;
		$data['file'] = $filename;

		if(!file_put_contents($filepath, $users)) {
			$data['status'] = 'failure';
			$data['message'] = 'Failed to open output file: ' . $filename;
			echo json_encode($data);
			return;
		}

		$this->action_model->insert(Action_model::ACTION_TYPE_USERS_CSV_EXPORT);
		echo json_encode($data);
	}

	public function ajax_angular_get_course_detail() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
				'status'		=> 'success',
				'message'		 => '',
				'user'			=> FALSE
		);

		$postdata = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata);
		$course_id = $postdata_decoded->course_id;
		$current_iteration = $postdata_decoded->current_iteration;
		$user_id = isset($postdata_decoded->user_id) ? $postdata_decoded->user_id : $this->account_id;

		$this->_data['course_activity'] = $this->military_course_model->get_user_course_activity_friendly($user_id, $course_id, $current_iteration);
		$this->_data['tests_summary'] = $this->military_course_model->get_user_tests_for_course_iteration($user_id, $course_id, $current_iteration);

		echo json_encode($this->_data);
	}

	public function ajax_angular_get_course_statistics() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->load->model('statistics_model');

		$data = array(
				'status'	=> 'success',
				'message'	=> '',
		);

		if(!is_admin() && !is_site_admin()) {
			$data['status'] = 'failure';
			$data['message'] = 'You do not have access';
			echo json_encode($data);
			return;
		}

		$postdata = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata, TRUE);

		$start_date = $postdata_decoded['start_date'];
		$end_date = $postdata_decoded['end_date'];
		$accreditation_type_id = ($postdata_decoded['accreditation_type_id'] != -1) ? $postdata_decoded['accreditation_type_id'] : NULL;
		$department_id = ($postdata_decoded['department_id'] != -1) ? $postdata_decoded['department_id'] : NULL;
		$treatment_facility_id = ($postdata_decoded['treatment_facility_id'] != -1) ? $postdata_decoded['treatment_facility_id'] : NULL;
		$role_id = ($postdata_decoded['role_id'] != -1) ? $postdata_decoded['role_id'] : NULL;
		$data['statistics'] = $this->statistics_model->get_statistics($start_date, $end_date, $accreditation_type_id, $department_id, $treatment_facility_id, $role_id);
		echo json_encode($data);
	}

	public function ajax_angular_get_dropdown_filter_data() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$data = array(
			'status'	=> 'success',
			'message'	=> '',
		);

		$this->load->model('accreditation_type_model');
		$this->load->model('department_model');

		$data['accreditation_types'] = $this->accreditation_type_model->get_accreditation_types();
		$data['departments'] = $this->department_model->get_departments(PROPERTY_ORGANIZATION_ID);
		$data['treatment_facilities'] = $this->user_model->get_treatment_facilities();
		$data['roles'] = $this->user_model->get_roles();

		echo json_encode($data);
	}

	public function ajax_angular_get_user() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
				'status'		=> 'success',
				'message'		 => '',
				'user'			=> FALSE
		);

		if(!is_admin() && !is_site_admin()) {
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'You do not have access';
			echo json_encode($this->_data);
			return;
		}

		$postdata = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata);

		$user_id = $postdata_decoded->user_id;
		$this->_data['user'] = $this->user_model->get_sbirt_user($user_id);
		echo json_encode($this->_data);
	}

	public function ajax_angular_get_user_courses() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
				'status'		=> 'success',
				'message'		 => '',
				'user_courses'	=> array()
		);

		if(!is_admin() && !is_site_admin()) {
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'You do not have access';
			echo json_encode($this->_data);
			return;
		}

		$postdata = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata);

		$search = $postdata_decoded->search;
		$uncompleted = ($postdata_decoded->uncompleted  != -1) ? ((bool) $postdata_decoded->uncompleted) : NULL;
		$not_passed = ($postdata_decoded->not_passed != -1) ? ((bool) $postdata_decoded->not_passed) : NULL;
		$no_cert = ($postdata_decoded->no_cert != -1) ? ((bool) $postdata_decoded->no_cert) : NULL;
		$department_id = ($postdata_decoded->department_id != -1) ? $postdata_decoded->department_id	: NULL;
		$treatment_facility_id = ($postdata_decoded->treatment_facility_id != -1) ? $postdata_decoded->treatment_facility_id : NULL;
		$role_id = ($postdata_decoded->role_id != -1) ? $postdata_decoded->role_id : NULL;
		$offset = $postdata_decoded->offset;
		$limit = $postdata_decoded->limit;
		$this->_data['user_courses'] = $this->military_course_model->get_user_courses(FALSE, FALSE, $search, $uncompleted, $not_passed, $no_cert, $department_id, $treatment_facility_id, $role_id, $limit, $offset);

		echo json_encode($this->_data);
	}

	public function ajax_angular_get_users() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
				'status'		=> 'success',
				'message'		 => '',
				'users'			 => array(),
				'user_types'	=> array(),
		);

		if(!is_admin() && !is_site_admin()) {
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'You do not have access';
			echo json_encode($this->_data);
			return;
		}

		$postdata = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata);
		$search = $postdata_decoded->search;
		$limit = $postdata_decoded->limit;
		$offset = $postdata_decoded->offset;

		$this->load->model('accreditation_type_model');
		$this->load->model('department_model');

		$this->_data['organizations'] = $this->organization_model->get_organizations_summary(FALSE, PROPERTY_ORGANIZATION_ID);
		$this->_data['users'] = $this->user_model->get_sbirt_users($this->user_type, $this->_data['organizations'][0]["id"], $search, $limit, $offset);
		$this->_data['user_types'] = $this->user_model->get_sbirt_user_types($this->user_type, 1);
		$this->_data['accreditation_types'] = $this->accreditation_type_model->get_accreditation_types();
		$this->_data['roles'] = $this->user_model->get_roles();
		$this->_data['treatment_facilities'] = $this->user_model->get_treatment_facilities();
		$this->_data['departments'] = $this->department_model->get_departments(PROPERTY_ORGANIZATION_ID);
		$this->_data['pay_grades'] = $this->user_model->get_pay_grades();
		$this->_data['states'] = $this->address_model->get_states();
		$this->_data['countries'] = $this->address_model->get_countries(FALSE, TRUE);

		echo json_encode($this->_data);
	}

	public function ajax_angular_pause_course() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
				'status'		=> 'success',
				'message'		 => '',
				'user'			=> FALSE
		);

		$postdata = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata);
		$course_id = $postdata_decoded->course_id;

		$this->_data['course'] = $this->military_course_model->deactivate_course($this->account_id, $course_id);

		$default_course = $this->military_course_model->get_active_course($this->account_id);

		if(!empty($default_course)) {
			$course_activity = $this->military_course_model->get_user_course_activity($this->account_id, $default_course);
			$course_stats = $this->military_course_model->get_course_stats($default_course);
		}

		$this->_data['default_course'] = !empty($default_course) ? $default_course : 'No default course';
		$this->_data['course_stats'] = !empty($course_stats) ? $course_stats : 'No course stats';
		$this->_data['course_activity'] = !empty($course_activity) ? $course_activity : 'No course activity';
		$this->_data['all_courses'] = $this->military_course_model->get_user_courses($this->account_id);

		echo json_encode($this->_data);
	}

	private function _perform_user_validation($mode, $user) {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		if($mode == 'edit') {
			$_POST['id'] = $this->db->escape_str($user->id);
		}

		$_POST['pay_grade_id']					= $this->db->escape_str($this->user_model->get_pay_grade($user->pay_grade_id) ? $user->pay_grade_id: '');
		$_POST['first_name']						= $this->db->escape_str($user->first_name);
		$_POST['middle_initial']				= $this->db->escape_str($user->middle_initial);
		$_POST['last_name']							= $this->db->escape_str($user->last_name);
		$_POST['department_id']					= $this->db->escape_str($user->department_id);
		$_POST['dod_number']						= $this->db->escape_str($user->dod_number);
		$_POST['role_id']								= $this->db->escape_str($user->role_id);
		$_POST['accreditation_type_id'] = $this->db->escape_str($user->accreditation_type_id);
		$_POST['treatment_facility_id'] = $this->db->escape_str(($user->treatment_facility_id > 0) ? $user->treatment_facility_id : 0);
		$_POST['user_type_id']					= $this->db->escape_str($user->user_type_id);
		$_POST['email']									= $this->db->escape_str($user->email_address);
		$_POST['password']							= $this->db->escape_str(isset($user->password) ? $user->password : '');
		$_POST['confirm_password']			= $this->db->escape_str(isset($user->confirm_password) ? $user->confirm_password : '');
		$_POST['address_1']							= $this->db->escape_str($user->address_1);
		$_POST['address_2']							= $this->db->escape_str($user->address_2);
		$_POST['city']									= $this->db->escape_str($user->city);
		$_POST['state_id']							= $this->db->escape_str($user->state_id);
		$_POST['province']							= $this->db->escape_str($user->province);
		$_POST['zip']										= $this->db->escape_str($user->zip);
		$_POST['country_id']						= $this->db->escape_str($user->country_id);
		$_POST['login_enabled']					= $this->db->escape_str($user->login_enabled);

		// pp($_POST);

		// set up validation rules

		$this->load->library('form_validation');

		if($user->user_type_id != 1) {
			$this->form_validation->set_rules('pay_grade_id', 'Pay Grade', 'trim|required|is_natural_no_zero|xss_clean');
			$this->form_validation->set_rules('dod_number', 'DOD Number', 'required|trim|min_length[10]|max_length[10]|numeric|xss_clean');
			$this->form_validation->set_rules('role_id', 'Role', 'trim|required|is_natural_no_zero|xss_clean');
			$this->form_validation->set_rules('accreditation_type_id', 'Desired Accreditation', 'required|is_natural_no_zero|xss_clean');
			$this->form_validation->set_rules('treatment_facility_id', 'Treatment Facility', 'is_natural|xss_clean');
			$this->form_validation->set_rules('address_1', 'Address 1', 'required|trim|min_length[3]|xss_clean');
			$this->form_validation->set_rules('city', 'City', 'required|trim|min_length[3]|xss_clean');
			$this->form_validation->set_rules('zip', 'Zip Code', 'required|trim|min_length[5]|max_length[10]|alpha_dash|xss_clean');
			$this->form_validation->set_rules('country_id', 'Country', 'required|trim|is_natural_no_zero|xss_clean');

			if($user->country_id == 230) {
				$this->form_validation->set_rules('state_id', 'State', 'required|trim|is_natural_no_zero|xss_clean');
			} else {
				$this->form_validation->set_rules('province', 'Province', 'required|trim|min_length[3]|max_length[64]|xss_clean');
			}
		} else {
			$_POST['pay_grade_id'] = -1;
			$_POST['dod_number'] = -1;
			$_POST['role_id'] = -1;
			$_POST['accreditation_type_id'] = -1;
			$_POST['treatment_facility_id'] = -1;
			$_POST['address_1'] = '';
			$_POST['address_2'] = '';
			$_POST['city'] = '';
			$_POST['state_id'] = '';
			$_POST['province'] = '';
			$_POST['zip'] = '';
			$_POST['country_id'] = -1;
		}

		$this->form_validation->set_rules('user_type_id', 'User Type', 'required|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('department_id', 'Branch', 'required|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim|min_length[1]|max_length[45]|xss_clean');
		$this->form_validation->set_rules('middle_initial', 'Middle Initial', 'trim|min_length[0]|max_length[1]|alpha|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|min_length[1]|max_length[45]|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|xss_clean');
		$this->form_validation->set_rules('login_enabled', 'Login Enabled', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_message('is_natural_no_zero', '%s Not Selected');

		if($mode == 'add') {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_is_valid_password_check[1]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		} elseif (($mode == 'edit') && ((!empty($user->password)) || (!empty($user->confirm_password)))) {
			$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_is_valid_password_check[1]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		}

		// run validation
		if($this->form_validation->run() === FALSE) {
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = validation_errors();
			echo json_encode($this->_data);
			return FALSE;
		}

		if($mode == 'edit') {
			// Check if the user being edited exists
			if(!($orig_user = $this->user_model->get_user($_POST['id']))) {
				$_POST = array();
				$this->_data['status'] = 'failure';
				$this->_data['message'] = 'User cannot be updated at this point in time.';
				echo json_encode($this->_data);
				return FALSE;
			}

			if (($this->account_id == $_POST['id']) && ($orig_user['user_type_id'] != $_POST['user_type_id'])) {
				$_POST = array();
				$this->_data['status'] = 'failure';
				$this->_data['message'] = 'You cannot change your user type.';
				echo json_encode($this->_data);
				return FALSE;
			}
		}

		$this->load->model('department_model');

		// make sure a valid department was passed
		if(!$this->department_model->get_department(PROPERTY_ORGANIZATION_ID, $user->department_id)) {
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Invalid department submitted';
			echo json_encode($this->_data);
			return FALSE;
		}

		return TRUE;
	}

}

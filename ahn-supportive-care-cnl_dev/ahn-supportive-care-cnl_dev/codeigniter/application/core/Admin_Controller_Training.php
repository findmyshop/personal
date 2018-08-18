<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller_Training extends Admin_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->model('course_model');

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

		$this->_data['course'] = $this->course_model->activate_course($this->account_id, $course_id);
		$iteration = $this->_data['course']['current_iteration'];
		/* Return to Flow ID */
		$this->_data['last_id'] = $this->course_model->get_last_response_id($this->account_id, $course_id, $iteration);

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

		if (!($user_id = $this->user_model->insert_training_user(
				$_POST['first_name'],
				$_POST['middle_initial'],
				$_POST['last_name'],
				$_POST['email'],
				$_POST['address_1'],
				$_POST['address_2'],
				$_POST['city'],
				$_POST['state_id'],
				$_POST['zip'],
				$_POST['country_id'],
				$_POST['password'],
				$_POST['login_enabled'],
				$_POST['user_type_id'],
				$_POST['role_id'],
				$_POST['accreditation_type_id']
		))) {
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Error updating user';
			echo json_encode($this->_data);
			return;
		}

		$this->course_model->initialize_course_assignment_upon_registraton($user_id);
		$this->course_model->initialize_user_certificate($user_id);
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

		$default_course = $this->course_model->get_active_course($this->account_id);
		$this->_data['all_courses'] = $this->course_model->get_user_courses($this->account_id);
		$this->_data['all_user_courses_and_iterations'] = $this->course_model->get_user_courses_and_iterations($this->account_id);

		if(!empty($default_course)) {
			$course_activity = $this->course_model->get_user_course_activity($this->account_id, $default_course);
			$course_stats = $this->course_model->get_course_stats($default_course);
			$this->_data['active_course'] = !empty($default_course) ? $default_course : array();
			$this->_data['course_stats'] = !empty($course_stats) ? $course_stats : array();
			$this->_data['course_activity'] = !empty($course_activity) ? $course_activity : array();
			$this->_data['return_id'] = !empty($default_course) ? $default_course['after_certification'] : 'null';

			/* Return to Flow ID */
			$iteration = $this->_data['active_course']['current_iteration'];
			$course_id = $this->_data['active_course']['course_id'];
			$last_id = $this->course_model->get_last_response_id($this->account_id, $course_id, $iteration);
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

		if(!$this->user_model->update_training_user(
				$_POST['user_id'],
				$_POST['first_name'],
				$_POST['middle_initial'],
				$_POST['last_name'],
				$_POST['address_1'],
				$_POST['address_2'],
				$_POST['city'],
				$_POST['state_id'],
				$_POST['zip'],
				$_POST['country_id'],
				$_POST['password'],
				$_POST['login_enabled'],
				$_POST['accreditation_type_id']
		)) {
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Error updating user';
			echo json_encode($this->_data);
			return;
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
			$this->load->library('course_library');
			$status = $this->course_library->write_accreditation_report_to_csv($accreditation_type_id, $start_date, $end_date, $filepath);
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
		$course_id = ($postdata_decoded->course_id != -1) ? $postdata_decoded->course_id : NULL;
		$role_id = ($postdata_decoded->role_id != -1) ? $postdata_decoded->role_id : NULL;
		$filename = 'user_answers_export_'.$this->account_id.'_'.date("Y-m-d_H-i-s").'.csv';
		$filepath = FCPATH.'tmp/'.$filename;
		$data['file'] = $filename;

		$status = FALSE;

		try {
			$this->load->library('course_library');
			$status = $this->course_library->write_user_answers_to_csv($search, $course_id, $role_id, $filepath);
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
		$course_id = ($postdata_decoded->course_id != -1) ? $postdata_decoded->course_id : NULL;
		$role_id = ($postdata_decoded->role_id != -1) ? $postdata_decoded->role_id : NULL;
		$get_detailed_report = ($postdata_decoded->get_detailed_report) ? 1 : 0;
		$filename = 'user_courses_export_'.$this->account_id.'_'.date("Y-m-d_H-i-s").'.csv';
		$filepath = FCPATH.'tmp/'.$filename;
		$data['file'] = $filename;

		$status = FALSE;

		try {
			$this->load->library('course_library');

			if($get_detailed_report) {
				$status = $this->course_library->write_raw_courses_to_csv($search, $course_id, $role_id, $filepath);
				$this->action_model->insert(Action_model::ACTION_TYPE_DETAILED_REPORTS_CSV_EXPORT);
			} else {
				$status = $this->course_library->write_user_courses_to_csv(FALSE, FALSE, $search, $uncompleted, $not_passed, $no_cert, $course_id, $role_id, $filepath);
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

		$this->_data['course_activity'] = $this->course_model->get_user_course_activity_friendly($user_id, $course_id, $current_iteration);
		$this->_data['tests_summary'] = $this->course_model->get_user_tests_for_course_iteration($user_id, $course_id, $current_iteration);

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
		$department_id = NULL;
		$treatment_facility_id = NULL;
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

		$data['accreditation_types'] = $this->accreditation_type_model->get_accreditation_types();
		$data['roles'] = $this->user_model->get_roles();
		$data['courses'] = $this->course_model->get_courses();

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
		$this->_data['user'] = $this->user_model->get_training_user($user_id);
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
		$course_id = ($postdata_decoded->course_id != -1) ? $postdata_decoded->course_id : NULL;
		$role_id = ($postdata_decoded->role_id != -1) ? $postdata_decoded->role_id : NULL;
		$offset = $postdata_decoded->offset;
		$limit = $postdata_decoded->limit;
		$this->_data['user_courses'] = $this->course_model->get_user_courses(FALSE, FALSE, $search, $uncompleted, $not_passed, $no_cert, $course_id, $role_id, $limit, $offset);

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
		$this->_data['users'] = $this->user_model->get_training_users($this->user_type, $this->_data['organizations'][0]["id"], $search, $limit, $offset);
		$this->_data['user_types'] = $this->user_model->get_sbirt_user_types($this->user_type, 1);
		$this->_data['accreditation_types'] = $this->accreditation_type_model->get_accreditation_types();
		$this->_data['roles'] = $this->user_model->get_roles();
		$this->_data['states'] = $this->address_model->get_states();

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

		$this->_data['course'] = $this->course_model->deactivate_course($this->account_id, $course_id);

		$default_course = $this->course_model->get_active_course($this->account_id);

		if(!empty($default_course)) {
			$course_activity = $this->course_model->get_user_course_activity($this->account_id, $default_course);
			$course_stats = $this->course_model->get_course_stats($default_course);
		}

		$this->_data['default_course'] = !empty($default_course) ? $default_course : 'No default course';
		$this->_data['course_stats'] = !empty($course_stats) ? $course_stats : 'No course stats';
		$this->_data['course_activity'] = !empty($course_activity) ? $course_activity : 'No course activity';
		$this->_data['all_courses'] = $this->course_model->get_user_courses($this->account_id);

		echo json_encode($this->_data);
	}

	private function _perform_user_validation($mode, $user) {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		if($mode == 'edit') {
			$_POST['user_id'] = $this->db->escape_str($user->id);
		}

		$_POST['first_name']						= $this->db->escape_str($user->first_name);
		$_POST['middle_initial']				= $this->db->escape_str($user->middle_initial);
		$_POST['last_name']							= $this->db->escape_str($user->last_name);
		$_POST['email']									= $this->db->escape_str($user->email_address);
		$_POST['address_1']							= $this->db->escape_str($user->address_1);
		$_POST['address_2']							= $this->db->escape_str($user->address_2);
		$_POST['city']									= $this->db->escape_str($user->city);
		$_POST['state_id']							= $this->db->escape_str($user->state_id);
		$_POST['zip']										= $this->db->escape_str($user->zip);
		$_POST['country_id']						= $this->db->escape_str($user->country_id);
		$_POST['password']							= $this->db->escape_str(isset($user->password) ? $user->password : '');
		$_POST['confirm_password']			= $this->db->escape_str(isset($user->confirm_password) ? $user->confirm_password : '');
		$_POST['login_enabled']					= $this->db->escape_str($user->login_enabled);
		$_POST['user_type_id']					= $this->db->escape_str($user->user_type_id);
		$_POST['role_id']								= $this->db->escape_str($user->role_id);
		$_POST['accreditation_type_id'] = $this->db->escape_str($user->accreditation_type_id);

		// set up validation rules

		$this->load->library('form_validation');

		if($user->user_type_id != 1 && $user->user_type_id != 2) {
			$this->form_validation->set_rules('role_id', 'Role', 'trim|required|is_natural_no_zero|xss_clean');
			$this->form_validation->set_rules('accreditation_type_id', 'Desired Accreditation', 'required|is_natural_no_zero|xss_clean');
			$this->form_validation->set_rules('address_1', 'Address 1', 'required|trim|min_length[3]|xss_clean');
			$this->form_validation->set_rules('city', 'City', 'required|trim|min_length[3]|xss_clean');
			$this->form_validation->set_rules('zip', 'Zip Code', 'required|trim|min_length[5]|max_length[10]|alpha_dash|xss_clean');
			$this->form_validation->set_rules('country_id', 'Country', 'required|trim|is_natural_no_zero|xss_clean');
			$this->form_validation->set_rules('state_id', 'State', 'required|trim|is_natural_no_zero|xss_clean');
		} else {
			$_POST['role_id'] = -1;
			$_POST['accreditation_type_id'] = -1;
			$_POST['address_1'] = '';
			$_POST['address_2'] = '';
			$_POST['city'] = '';
			$_POST['state_id'] = '';
			$_POST['zip'] = '';
			$_POST['country_id'] = -1;
		}

		$this->form_validation->set_rules('user_type_id', 'User Type', 'required|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim|min_length[1]|max_length[45]|xss_clean');
		$this->form_validation->set_rules('middle_initial', 'Middle Initial', 'trim|min_length[0]|max_length[1]|alpha|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|min_length[1]|max_length[45]|xss_clean');
		$this->form_validation->set_rules('login_enabled', 'Login Enabled', 'trim|required|is_natural|xss_clean');
		$this->form_validation->set_message('is_natural_no_zero', '%s Not Selected');

		if($mode == 'add') {
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[255]|is_unique[master_users.email]|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_is_valid_password_check[1]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
		} elseif ($mode == 'edit') {
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[255]|xss_clean');
			if(!empty($user->password) || !empty($user->confirm_password)) {
				$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_is_valid_password_check[1]');
				$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
			}
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
			if(!($orig_user = $this->user_model->get_user($_POST['user_id']))) {
				$_POST = array();
				$this->_data['status'] = 'failure';
				$this->_data['message'] = 'User cannot be updated at this point in time.';
				echo json_encode($this->_data);
				return FALSE;
			}

			if (($this->account_id == $_POST['user_id']) && ($orig_user['user_type_id'] != $_POST['user_type_id'])) {
				$_POST = array();
				$this->_data['status'] = 'failure';
				$this->_data['message'] = 'You cannot change your user type.';
				echo json_encode($this->_data);
				return FALSE;
			}
		}

		return TRUE;
	}

	public function actions() {
		if(!is_admin()) {
			log_error(__FILE__, __LINE__, __METHOD__, 'Unauthorized request for actions page');
			show_error('You are not authorized to view this page.', '401', 'Unauthorized Access');
		}

		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->template_library
			->set_title("Dashboard")
			->set_module('Admin Actions')
			->set_using_angularjs(TRUE, 'trainingDashboardApp')
			->set_timeout_check_interval(60)
			->build('admin/admin_index', $this->_data, 'admin/admin_header', 'admin/admin_actions');
	}

	public function activity_logs() {
		if(!is_admin()) {
			log_error(__FILE__, __LINE__, __METHOD__, 'Unauthorized request for activity logs page');
			show_error('You are not authorized to view this page.', '401', 'Unauthorized Access');
		}

		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->template_library
		->set_title("Dashboard")
		->set_module('Activity')
		->set_using_angularjs(TRUE, 'trainingDashboardApp')
		->set_timeout_check_interval(60)
		->build('admin/admin_index', $this->_data, 'admin/admin_header', 'admin/admin_activity_logs');
	}

	public function index() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		if(is_admin() || is_site_admin()) {
			redirect('admin/reports');
		}

		$this->template_library
			->set_title("User Dashboard")
			->set_module('User')
			->set_using_angularjs(TRUE, 'trainingDashboardApp')
			->set_timeout_check_interval(60)
			->build('admin/admin_index', $this->_data, 'admin/admin_header', 'admin/admin_user');
	}

	public function reports() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->template_library
			->set_title("Reports Dashboard")
			->set_module('Reports')
			->set_using_angularjs(TRUE, 'trainingReportsApp')
			->set_timeout_check_interval(60)
			->build('admin/admin_index', $this->_data, 'admin/admin_header', 'admin/admin_reports');
	}

	public function statistics() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

			if(MR_PROJECT === 'dod') {
				$this->_data['courses'] = array('alcohol_sbirt_one_hour', 'alcohol_sbirt_three_hour');
				$this->_data['course_dropdowns'] = array(
					'alcohol_sbirt_one_hour_course' => 'AlcoholSBIRT 1 Hour Course',
					'alcohol_sbirt_three_hour_course' => 'AlcoholSBIRT 3 Hour Course'
				);
			}
			else if(MR_PROJECT === 'rush') {
				$this->_data['courses'] = array('alcohol_sbirt_one_hour', 'sbirt_coach_three_hour');
				$this->_data['course_dropdowns'] = array(
					'alcohol_sbirt_one_hour_course' => 'AlcoholSBIRT 1 Hour Course',
					'sbirt_coach_three_hour_course' => 'SBIRTCoach 3 Hour Course'
				);
			} else if(MR_PROJECT === 'sbirt') {
				$this->_data['courses'] = array('alcohol_sbirt_one_hour', 'alcohol_sbirt_three_hour', 'sbirt_coach_three_hour');
				$this->_data['course_dropdowns'] = array(
					'alcohol_sbirt_one_hour_course' => 'AlcoholSBIRT 1 Hour Course',
					'alcohol_sbirt_three_hour_course' => 'AlcoholSBIRT 3 Hour Course',
					'sbirt_coach_three_hour_course' => 'SBIRTCoach 3 Hour Course',
				);
			} else {
				show_404();
			}

		$this->template_library
			->set_title('Statistics')
			->set_module('Statistics')
			->set_using_angularjs(TRUE, 'trainingStatisticsApp')
			->set_timeout_check_interval(60)
			->build('admin/admin_index', $this->_data, 'admin/admin_header', 'admin/admin_statistics');
	}

	public function user() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->template_library
			->set_title("User Dashboard")
			->set_module('User')
			->set_using_angularjs(TRUE, 'trainingDashboardApp')
			->set_timeout_check_interval(60)
			->build('admin/admin_index', $this->_data, 'admin/admin_header', 'admin/admin_user');
	}

	public function users() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->template_library
			->set_title("Dashboard")
			->set_module('Users')
			->set_using_angularjs(TRUE, 'trainingDashboardApp')
			->set_timeout_check_interval(60)
			->build('admin/admin_index', $this->_data, 'admin/admin_header', 'admin/admin_users');
	}
}
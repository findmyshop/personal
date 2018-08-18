	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends MY_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('course_model');

		if(!feature_enabled('registration')) {
			show_error('Registration Closed.  If you are interested in licensing AlcoholSBIRT for your organization, contact sales@medrespond.com', '401', 'Unauthorized Access');
			die;
		}

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
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
		$this->_data['username'] = $username;

		$user_id = $this->user_model->insert_sbirt_user(
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
		);

		$this->auth_library->login_by_id($user_id);
		$this->course_model->initialize_course_assignment_upon_registraton($user_id);
		$this->course_model->initialize_user_certificate($user_id);
		$this->_data['default_course'] = $this->course_model->get_active_course($user_id);
		$this->send_registration_email(
			$_POST['email'],
			$_POST['first_name'],
			$_POST['last_name'],
			$username,
			!empty($this->_data['default_course']['course_name']) ? $this->_data['default_course']['course_name'] : ''
		);

		$_POST = array();
		echo json_encode($this->_data);
		return;
	}

	public function ajax_angular_get_select_control_data() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->load->model('accreditation_type_model');
		$this->load->model('department_model');

		$this->_data = array(
			'status'		=> 'success',
			'message'		 => '',
		);

		// get post data
		$postdata = file_get_contents("php://input");
		$decoded_postdata = $this->_data['user'] = json_decode($postdata);

		$prepend_select_prompt = empty($decoded_postdata->prepend_select_prompt) ? FALSE : TRUE;

		if(!$prepend_select_prompt) {
			$this->_data['user_types'] = $this->user_model->get_sbirt_user_types(4, 1);
			$this->_data['accreditation_types'] = $this->accreditation_type_model->get_accreditation_types();
			$this->_data['roles'] = $this->user_model->get_roles();
			$this->_data['treatment_facilities'] = $this->user_model->get_treatment_facilities();
			$this->_data['departments'] = $this->department_model->get_departments(PROPERTY_ORGANIZATION_ID, 1);
			$this->_data['pay_grades'] = $this->user_model->get_pay_grades();
			$this->_data['states'] = $this->address_model->get_states();
			$this->_data['countries'] = $this->address_model->get_countries(FALSE, TRUE);
		} else {
			$this->_data['user_types'] = $this->user_model->get_sbirt_user_types(4, 1);
			$this->_data['accreditation_types'] = array_merge(array(0 => array('id' => -1, 'accreditation_type' => '-- Select Accreditation --')), $this->accreditation_type_model->get_accreditation_types());
			$this->_data['roles'] = array_merge(array(0 => array('id' => -1, 'role_name' => '-- Select Role --')), $this->user_model->get_roles());
			$this->_data['treatment_facilities'] = array_merge(array(0 => array('id' => -1, 'department_name' => '-- Select Treatment Facility --')), $this->user_model->get_treatment_facilities());
			$this->_data['departments'] = array_merge(array(0 => array('id' => -1, 'department_name' => '-- Select Branch or Service Market --')), $this->department_model->get_departments(PROPERTY_ORGANIZATION_ID, 1));
			$this->_data['pay_grades'] = array_merge(array(0 => array('id' => -1, 'pay_grade_name' => '-- Select Pay Grade --')), $this->user_model->get_pay_grades());
			$this->_data['states'] = array_merge(array(0 => array('id' => -1, 'state.abbreviation' => '-- Select State --')), $this->address_model->get_states());
			$this->_data['countries'] = array_merge(array(0 => array('countryid' => -1, 'name' => '-- Select Country --')), $this->address_model->get_countries(FALSE, TRUE));
		}

		echo json_encode($this->_data);
	}

	public function index() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		if(is_logged_in()) {
			redirect('/');
		}

		$project_title = $this->property_model->get_title(MR_PROJECT);

		$this->template_library
		->set_title($project_title)
		->set_module('Registration')
		->set_using_angularjs(TRUE, 'trainingRegistrationApp')
		->set_timeout_check_interval(60)
		->build('register/register_index', $this->_data, 'register/register_header', 'register/register_base');
	}

	private function _perform_user_validation($mode, $user) {
		if($mode == 'edit') {
			$_POST['id'] = $user->id;
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
		$_POST['address_2']							= $this->db->escape_str(isset($user->address_2) ? $user->address_2 : '');
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
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|xss_clean|is_unique[master_users.email]');
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
		if($this->form_validation->run() == FALSE) {
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

			if(($this->account_id == $_POST['id']) && ($orig_user['user_type_id'] != $_POST['user_type_id'])) {
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

	public function send_registration_email($email, $first_name, $last_name, $username, $course_name) {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$links = $this->config->load('links');

		$data = array(
			'email'			=> $email,
			'first_name'	=> $first_name,
			'last_name'		=> $last_name,
			'username'		=> $username,
			'course_name' => $course_name,
			'links'			=> $links
		);

		$message = $this->load->view('default_training/email/user_email_registration', $data, TRUE);

		$config = array(
				'mailtype'	=>	'html',
				'proto'		=>	'mail'
		);

		$this->postmark->initialize($config);

		$this->postmark->from('support@medrespond.com');
		$this->postmark->to(urldecode($email), $first_name . ' ' . $last_name);
		$this->postmark->subject('AlcoholSBIRT Training - Registration Acknowledgement');
		$this->postmark->message($message);
		$this->postmark->send();
		$this->postmark->clear();
	}

}
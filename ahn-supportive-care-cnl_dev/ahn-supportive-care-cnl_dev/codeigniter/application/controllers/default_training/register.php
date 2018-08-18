	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('course_model');

		if(!feature_enabled('registration')) {
			show_error('Registration Closed.  If you are interested in licensing SBIRT for your organization, contact sales@medrespond.com', '401', 'Unauthorized Access');
			die;
		}

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function ajax_angular_get_registration_form_data() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$data = array(
			'status'	=> 'success',
			'message'	=> '',
		);

		$this->load->model('accreditation_type_model');
		$this->load->model('department_model');

		$data['accreditation_types'] = array_merge(array(0 => array('id' => -1, 'accreditation_type' => '-- Select Accreditation --')), $this->accreditation_type_model->get_accreditation_types());
		$data['roles'] = array_merge(array(0 => array('id' => -1, 'role_name' => '-- Select Course --')), $this->user_model->get_roles());
		$data['states'] = array_merge(array(0 => array('id' => -1, 'abbreviation' => '-- Select State --')), $this->address_model->get_states());
		$data['countries'] = array_merge(array(0 => array('country_id' => -1, 'name' => '-- Select Country --')), $this->address_model->get_countries(FALSE, TRUE));

		echo json_encode($data);
	}

	public function ajax_angular_register() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$response = array(
			'status'	=> 'success',
			'message'	=> ''
		);

		$_POST = json_decode(file_get_contents("php://input"), TRUE);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('role_id', 'Role', 'trim|required|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('accreditation_type_id', 'Desired Accreditation', 'required|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|min_length[3]|max_length[45]|alpha_dash');
		$this->form_validation->set_rules('middle_initial', 'Middle Initial', 'trim|min_length[0]|max_length[1]|alpha|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|min_length[3]|max_length[45]|alpha_dash');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|xss_clean|is_unique[master_users.email]');
		$this->form_validation->set_rules('address_line_1', 'Address Line 1', 'required|trim|min_length[3]|xss_clean');
		$this->form_validation->set_rules('address_line_2', 'Address Line 2', 'trim|min_length[3]|xss_clean');
		$this->form_validation->set_rules('city', 'City', 'required|trim|min_length[3]|xss_clean');
		$this->form_validation->set_rules('state_id', 'State', 'required|trim|is_natural_no_zero|xss_clean');
		$this->form_validation->set_rules('zip_code', 'Zip Code', 'required|trim|min_length[5]|max_length[10]|alpha_dash|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|callback_is_valid_password_check[1]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');

		if($this->form_validation->run() === FALSE) {
			$response['status'] = 'failure';
			$response['message'] = validation_errors();
			echo json_encode($response);
			return FALSE;
		}

		$user_id = $this->user_model->insert_training_user(
			$_POST['first_name'],
			$_POST['middle_initial'],
			$_POST['last_name'],
			$_POST['email'],
			$_POST['address_line_1'],
			$_POST['address_line_2'],
			$_POST['city'],
			$_POST['state_id'],
			$_POST['zip_code'],
			$_POST['country_id'],
			$_POST['password'],
			1, // login_enabled
			4, // user_type_id,
			$_POST['role_id'],
			$_POST['accreditation_type_id']
		);

		$this->auth_library->login_by_id($user_id);
		$this->course_model->initialize_course_assignment_upon_registraton($user_id);
		$this->course_model->initialize_user_certificate($user_id);
		$course = $this->course_model->get_active_course($user_id);
		$this->send_registration_email(
			$_POST['email'],
			$_POST['first_name'],
			$_POST['last_name'],
			$_POST['email'],
			!empty($course['course_name']) ? $course['course_name'] : ''
		);

		echo json_encode($response);
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
		$this->postmark->subject($course_name . ' - Registration Acknowledgement');
		$this->postmark->message($message);
		$this->postmark->send();
		$this->postmark->clear();
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
}
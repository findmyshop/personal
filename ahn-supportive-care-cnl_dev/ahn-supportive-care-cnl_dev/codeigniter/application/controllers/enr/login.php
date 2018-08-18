<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Login_Controller_Clinical_Trials {

	public function __construct() {
		parent::__construct();

		$this->load->model('user_experience_state_map_model');
		$this->load->library('enersource_library');

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function index() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');
		parent::index();
	}

	public function disabled() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$project_title = $this->property_model->get_title(MR_PROJECT);

			$this->template_library
				->set_title('Title')
				->set_module('Register')
				->set_using_angularjs(TRUE, 'registrationApp')
				->set_timeout_check_interval(60)
				->build('login/login_index', $this->_data, 'login/login_header', 'login/login_disabled');
	}

	public function register() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$project_title = $this->property_model->get_title(MR_PROJECT);

		$this->template_library
			->set_title($project_title)
			->set_module('Register')
			->set_using_angularjs(TRUE, 'registrationApp')
			->set_timeout_check_interval(60)
			->build('login/login_index', $this->_data, 'login/login_header', 'login/login_register');
	}

	public function ajax_email_login() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$email = $this->input->post('email');
		/* First check CAPTCHA against Google Servers */
		if (LOGIN_CAPTCHA){
			$captcha = $this->input->post('captcha');
			if (!$this->auth_library->check_captcha($captcha)){
				$this->_data = array("status" => "failure",
														 "message" => $this->auth_library->get_message());
				echo json_encode($this->_data);
				return;
			}
		}

		/* Try to auth via Email */
		if (!$this->auth_library->login_by_email($email)){
			$this->_data = array("status" => "failure",
													 "message" => $this->auth_library->get_message());
		}else{
			$this->_set_is_customer_session_data();
			$this->_data = array("status" => "success",
													 "message" => $this->auth_library->get_message());
		}
		echo json_encode($this->_data);
	}

	public function ajax_register() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->load->model('user_model');
		$this->load->library('form_validation');

		$postdata = file_get_contents("php://input");
		$postdata = json_decode($postdata, TRUE);

		$_POST['is_customer'] = $postdata['is_customer'];
		$_POST['customer_type'] = ($_POST['is_customer'] == 1) ? $postdata['customer_type'] : NULL;
		$_POST['postal_code'] = $postdata['postal_code'];
		$_POST['email'] = $postdata['email'];
		$_POST['captcha'] = $postdata['captcha'];


		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[255]|is_unique[master_users.email]|xss_clean');
		$this->form_validation->set_rules('postal_code', 'Postal Code', 'required|trim|to_upper|callback_is_valid_canadian_postal_code|xss_clean');
		$this->form_validation->set_rules('captcha', 'Captcha', 'required|trim|xss_clean');


		if ($this->form_validation->run() == FALSE) {
			$this->_data['status'] = 'failure';
			$this->_data['message'] = validation_errors();
			echo json_encode($this->_data);
			return FALSE;
		}

		/* Check CAPTCHA against Google Servers */
		if (LOGIN_CAPTCHA){
			$captcha = $this->input->post('captcha');
			if (!$this->auth_library->check_captcha($captcha)){
				$this->_data = array("status" => "failure",
														 "message" => $this->auth_library->get_message());
				echo json_encode($this->_data);
				return;
			}
		}

		$organization_id = $this->organization_model->get_organization_id_by_property_name(MR_PROJECT);
		$user_type_id = $this->user_model->get_user_type_id('user');

		$user_id = $this->enersource_library->insert_user(
			'', // first_name
			'', // last_name
			$organization_id,
			$user_type_id,
			$_POST['email'],
			NULL, // phone
			NULL,
			NULL,
			NULL,
			NULL,
			$_POST['postal_code'],
			NULL,
			$_POST['is_customer'],
			$_POST['customer_type'],
			1
		);

		if (!$this->auth_library->login_by_email($_POST['email'])) {
			log_error(__FILE__, __LINE__, __METHOD__, 'Failed logging in after creating account for user_id = ' . $user_id);
			$this->_data = array("status" => "failure",
													 "message" => $this->auth_library->get_message());
		}else{
			$this->_set_is_customer_session_data();
			$this->_data = array("status" => "success",
													 "message" => "Account Created");
		}

		log_info(__FILE__, __LINE__, __METHOD__, 'Successfull login after creating account for user_id = ' . $user_id);
		echo json_encode($this->_data);
	}

	public function is_valid_canadian_postal_code($str) {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');
		$str = strtoupper(str_replace(' ', '', $str));

		// http://stackoverflow.com/questions/1146202/canadian-postal-code-validation
		$regex = '/[ABCEGHJKLMNPRSTVXY][0-9][ABCEGHJKLMNPRSTVWXYZ][0-9][ABCEGHJKLMNPRSTVWXYZ][0-9]/';

		if(preg_match($regex, $str) > 0) {
			return $str;
		}

		$this->form_validation->set_message('is_valid_canadian_postal_code', 'The Postal Code field must contain a valid Canadian Postal Code.');
		return FALSE;
	}

	private function _set_is_customer_session_data() {
		if($user_id = $this->session->userdata('account_id')) {
			if($user = $this->enersource_library->get_user($user_id)) {
				if($user['is_customer']) {
					$this->session->set_userdata('is_customer', TRUE);
					return TRUE;
				} else {
					$this->session->set_userdata('is_customer', FALSE);
					return FALSE;
				}
			}
		}

		$this->session->set_userdata('is_customer', FALSE);
		return FALSE;
	}

}

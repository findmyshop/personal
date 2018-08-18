<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_Controller extends MY_Controller
{
	public function __construct(){
		parent::__construct();
		$this->_data = array();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function ajax_create_user($organization_id = FALSE)
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->load->library('form_validation');

		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[45]|alpha_dash|is_unique[master_users.username]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[45]');
		if ($this->form_validation->run() == FALSE)
		{
			$_POST = array();
			ajax_status_failure(validation_errors());
			return;
		}

		$user_type_id = $this->user_model->get_user_type_id('user');

		if ($organization_id)
		{
			$organization_id = $this->db->escape_str($organization_id);
		}
		else
		{
			$organization_id = $this->organization_model->get_organization_id_by_property_name(MR_PROJECT);
		}

		$this->user_model->insert_user(
			'',	 // First name
			'',	 // Last name
			$_POST['username'],
			$organization_id,
			$user_type_id,
			'',	 // Email
			$_POST['password'],
			'1'	 // Login enabled
		);

		if (!$this->auth_library->ajax_login_user())
		{
			ajax_status_failure($this->auth_library->get_message());
		}

		$_POST = array();
		$this->_data = array("status" => "success",
												 "message" => "Account Created");
		ajax_status_success($this->_data);
	}

	public function ajax_forgot_password()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$_POST['email'] = $this->input->post('email');

		if (empty($_POST['email']))
		{
			$_POST = array();
			ajax_status_failure('email address not found');
			return;
		}

		$this->load->library('form_validation');

		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

		if ($this->form_validation->run() == FALSE)
		{
			$_POST = array();
			ajax_status_failure(validation_errors());
			return;
		}

		$user = $this->user_model->get_user_by_email($_POST['email']);

		if (empty($user))
		{
			$_POST = array();
			ajax_status_failure('email address not found');
			return;
		}

		$user_password_reset = $this->user_model->insert_user_password_reset($user['id']);
		$this->send_reset_password_email($_POST['email'], $user_password_reset['hash'], $user);
		$_POST = array();
		$this->_data = array("status" => "success",
													"message" => "Password Reset");
		ajax_status_success($this->_data);
	}
	public function ajax_is_logged_in()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		if (!is_logged_in())
		{
			ajax_status_failure('User not logged in', $this->_data);
		}
		else
		{
			ajax_status_success($this->_data);
		}
	}

	public function ajax_login()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		if(!$this->auth_library->ajax_login_user())
		{
			ajax_status_failure($this->auth_library->get_message());
		}
		else
		{
			ajax_status_success();
		}
	}

	public function register()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		if (is_logged_in() && !is_anonymous_guest_user()) {
			redirect('/');
		}

		$project_title = $this->property_model->get_title(MR_PROJECT);

		$this->template_library
			->set_title($project_title)
			->set_module('Register')
			->set_using_angularjs(TRUE, 'userApp')
			->set_timeout_check_interval(60)
			->build('login/login_index', $this->_data, 'login/login_header', 'login/login_register');
	}

	public function ajax_logout()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');
		$this->session->unset_userdata('account_id');
		$this->session->unset_userdata('user_type');
		ajax_status_success();
	}

	public function ajax_reset_password()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');
		$_POST['hash'] = $this->input->post('hash');
		$_POST['password'] = $this->input->post('password');
		$_POST['confirm_password'] = $this->input->post('confirm_password');

		$user_password_reset = $this->user_model->get_user_password_reset_by_hash($_POST['hash']);

		if (empty($user_password_reset))
		{
			$_POST = array();
			ajax_status_failure('Forgetten password link is expired');
			return;
		}

		$user_id = $user_password_reset['user_id'];

		$user = $this->user_model->get_user($user_id);

		if (empty($user))
		{
			$_POST = array();
			ajax_status_failure('Unable to locate user');
			return;
		}

		$this->load->library('form_validation');

		if (!empty($_POST['password']))
		{
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[45]');
		}
		if (!empty($_POST['confirm_password']))
		{
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[6]|max_length[45]|matches[password]');
		}

		if ($this->form_validation->run() == FALSE)
		{
			$_POST = array();
			ajax_status_failure(validation_errors());
			return;
		}

		$this->user_model->deactivate_user_password_reset($user_id, $_POST['hash']);
		$this->user_model->reset_password($user_id, $_POST['password']);

		$_POST = array();

		ajax_status_success($this->_data);
	}

	public function index()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		if (is_logged_in() && !is_anonymous_guest_user()){
			redirect('/');
		}

		$project_title = $this->property_model->get_title(MR_PROJECT);
		$this->_data['users'] = $this->user_model->get_users();

		$this->template_library
			->set_title($project_title)
			->set_module('Login')
			->set_using_angularjs(TRUE, 'userApp')
			->set_timeout_check_interval(60)
			->build('login/login_index', $this->_data, 'login/login_header', 'login/login_base');
	}

	public function login_by_username($username)
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		if(!LOGIN_BY_USERNAME_ENABLED) {
			redirect('/login');
		}

		if(!$this->auth_library->login_by_username($username)) {
			redirect('/login');
		}

		redirect('/');
	}

	public function forgot_password()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		if (is_logged_in() && !is_anonymous_guest_user()) {
			redirect('/');
		}
		$this->_data = array();
		$project_title = $this->property_model->get_title(MR_PROJECT);

		$this->template_library
			->set_title($project_title)
			->set_module('Forgot Password')
			->set_using_angularjs(TRUE, 'userApp')
			->set_timeout_check_interval(60)
			->build('login/login_index', $this->_data, 'login/login_header', 'login/login_forgot_password');
	}

	public function logout()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->session->unset_userdata('account_id');
		$this->session->unset_userdata('user_type');
		redirect('login');
	}

	public function reset_password()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		if (is_logged_in() && !is_anonymous_guest_user()) {
			redirect('/');
		}

		$project_title = $this->property_model->get_title(MR_PROJECT);

		$this->template_library
			->set_title($project_title)
			->set_module('Reset Password')
			->set_using_angularjs(TRUE, 'userApp')
			->set_timeout_check_interval(60)
			->build('login/login_index', $this->_data, 'login/login_header', 'login/login_reset_password');
	}

	public function password_reset_link($hash)
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data['user_password_reset'] = $this->user_model->get_user_password_reset_by_hash($hash);

		if (empty($this->_data['user_password_reset']))
		{
			die('Hash not found - invalid request');
		}

		$user_id = $this->_data['user_password_reset']['user_id'];

		$this->_data['user'] = $this->user_model->get_user($user_id);

		if (empty($this->_data['user']))
		{
			die('User not found');
		}

		$project_title = $this->property_model->get_title(MR_PROJECT);

		$this->template_library
			->set_title($project_title)
			->set_module('Reset Password')
			->set_using_angularjs(TRUE, 'userApp')
			->set_timeout_check_interval(60)
			->build('login/login_index', $this->_data, 'login/login_header', 'login/login_reset_password');
	}

	private function send_reset_password_email($email, $hash, $user) {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$links = $this->config->load('links');
		$message = $this->load->view('default/email/user_email_password_reset', array('email' => $email, 'hash' => $hash, 'user' => $user, 'links' => $links), TRUE);

		$config = array(
			'mailtype'	=>	'html',
			'proto'		=>	'mail'
		);

		$this->postmark->initialize($config);

		$this->postmark->from('support@medrespond.com');
		$this->postmark->to($email, $user['first_name'] . ' ' . $user['last_name']);
		$this->postmark->subject('Medrespond - Password Reset');
		$this->postmark->message($message);
		$this->postmark->send();
		$this->postmark->clear();

	}
	public function ajax_set_session_speaker() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');
		$this->load->model('session_speaker_selection_model');
		$this->session_speaker_selection_model->insert(PROPERTY_ID, $this->session->userdata('session_id'), $_POST['value']);
		$this->session->set_userdata('speaker', $_POST['value']);
		$this->_data['status'] = 'success';
		$this->_data['message'] = $this->session->userdata('speaker');
		echo json_encode($this->_data);
		return;
	}
}

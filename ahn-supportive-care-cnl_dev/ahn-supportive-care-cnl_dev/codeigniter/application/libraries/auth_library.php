<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_library
{
	private $CI							 = FALSE;		 // CodeIgniter Global Instance
	private $message					 = "";

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->model('user_authentication_attempts_model');

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function ajax_login_user()
	{
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$username = $this->CI->input->post('username');
		$password = $this->CI->input->post('password');
		$this->message = '';

		if (empty($username))
		{
			$this->message = 'Please supply a username.';
			return FALSE;
		}
		else
		{
			if($this->CI->user_authentication_attempts_model->is_locked_out($username))
			{
				$this->message = "This account is temporarily locked.";
				return FALSE;
			}

			// Login with user id
			if (!($user = $this->CI->user_model->get_user_given_login_credentials($username, $password)))
			{
				$this->CI->user_authentication_attempts_model->insert_failure($username);
				$this->message = "Invalid username or password entered.";
				return FALSE;
			}

			$user_type_name = $this->CI->user_model->get_user_type_name($user['user_type_id']);

			if(!feature_enabled('authentication', $user_type_name)) {
				$this->message = 'Logins have been disabled for your user type. If you are interested in licensing SBIRT for your organization, contact sales@medrespond.com.';
				return FALSE;
			}

			if($user['login_enabled'] != 1)
			{
				$this->message = "This account has been disabled.";
				return FALSE;
			}

			if($user['active'] != 1)
			{
				$this->message = 'This account was removed.';
				return FALSE;
			}

			if(!ALLOW_MULTIPLE_CONCURRENT_USER_SESSIONS) {
				$this->delete_user_session($user['id']);
			}

			$this->CI->session->set_userdata('account_id', $user['id']);
			$this->CI->session->set_userdata('username', $user['username']);
			$this->CI->session->set_userdata('user_type', $user_type_name);
			$video_settings = $this->CI->user_model->get_video_settings($user['id']);
			$this->CI->session->set_userdata('video_player', $video_settings['video_player']);
			$this->CI->session->set_userdata('video_bit_rate', $video_settings['video_bit_rate']);
			$this->CI->session->set_userdata('show_asl_videos', $video_settings['show_asl_videos']);
			$this->CI->user_authentication_attempts_model->insert_success($username);
			$this->CI->medrespond_ip_addresses_model->insert($user['id'], $user['username'], $this->CI->input->ip_address());
			return TRUE;
		}
	}

	public function delete_user_session($user_id)
	{
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$user_id = trim($user_id);

		if(!empty($user_id) && is_numeric($user_id))
		{
			$this->CI->db
				->like('user_data', 's:10:"account_id";s:'.strlen($user_id).':"'.$user_id.'"')
				->delete($this->CI->config->item('sess_table_name'));
		}
	}

	public function get_message()
	{
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');
		return $this->message;
	}

	public function is_logged_in()
	{
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		if(($account_id = $this->CI->session->userdata('account_id')) !== FALSE)
		{
			return TRUE;
		}

		return FALSE;
	}

	public function is_anonymous_guest_user()
	{
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		if(!is_logged_in())
		{
			return FALSE;
		}

		if(strcasecmp($this->CI->session->userdata('username'), ANONYMOUS_GUEST_USERNAME) === 0)
		{
			return TRUE;
		}

		return FALSE;
	}

	public function login_anonymous_guest_user() {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		if(!USER_AUTHENTICATION_REQUIRED) {
			if(HAS_MULTIPLE_ANONYMOUS_GUEST_USERS && is_logged_in() && is_simple_user()) {
				$this->logout(FALSE);
			}

			if(!is_logged_in()) {
				if(!($user = $this->CI->user_model->get_user_by_username(ANONYMOUS_GUEST_USERNAME)))
				{
					die('No record found in master_users for ANONYMOUS_GUEST_USERNAME');
				}

				$this->CI->session->set_userdata('account_id', $user['id']);
				$this->CI->session->set_userdata('username', ANONYMOUS_GUEST_USERNAME);
				$this->CI->session->set_userdata('user_type', $this->CI->user_model->get_user_type_name($user['user_type_id']));
				$video_settings = $this->CI->user_model->get_video_settings($user['id']);
				$this->CI->session->set_userdata('video_player', $video_settings['video_player']);
				$this->CI->session->set_userdata('video_bit_rate', $video_settings['video_bit_rate']);
				$this->CI->session->set_userdata('show_asl_videos', $video_settings['show_asl_videos']);
			}
		}
	}

	public function login_by_id($account_id)
	{
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		if (!($user = $this->CI->user_model->get_user_account($account_id)))
		{
			return FALSE;
		}

		$this->CI->session->set_userdata('account_id', $user['id']);
		$this->CI->session->set_userdata('username', $user['username']);
		$this->CI->session->set_userdata('user_type', $this->CI->user_model->get_user_type_name($user['user_type_id']));
		$video_settings = $this->CI->user_model->get_video_settings($user['id']);
		$this->CI->session->set_userdata('video_player', $video_settings['video_player']);
		$this->CI->session->set_userdata('video_bit_rate', $video_settings['video_bit_rate']);
		$this->CI->session->set_userdata('show_asl_videos', $video_settings['show_asl_videos']);

		return TRUE;
	}

	public function login_by_username($username)
	{
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$this->CI->session->sess_destroy();

		if(!LOGIN_BY_USERNAME_ENABLED || !($user = $this->CI->user_model->get_user_by_username($username)))
		{
			return FALSE;
		}

		$this->CI->session->sess_create();
		$this->CI->session->sess_expiration = (60*60*24*365*2);
		$this->CI->session->set_userdata('account_id', $user['id']);
		$this->CI->session->set_userdata('username', $user['username']);
		$this->CI->session->set_userdata('user_type', $this->CI->user_model->get_user_type_name($user['user_type_id']));
		$video_settings = $this->CI->user_model->get_video_settings($user['id']);
		$this->CI->session->set_userdata('video_player', $video_settings['video_player']);
		$this->CI->session->set_userdata('video_bit_rate', $video_settings['video_bit_rate']);
		$this->CI->session->set_userdata('show_asl_videos', $video_settings['show_asl_videos']);

		return TRUE;
	}

	public function check_captcha($captcha) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$this->message = '';
		if(!$captcha){
			$this->message = "Please check the CAPTCHA box to prove that you are human.";
			return FALSE;
		}else{
			$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LdyhQwTAAAAAIkn3QxVhtMG5xBTB0DIb5IPODdf&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
			$response_decoded = json_decode($response, TRUE);
			if($response_decoded['success'] == false){
				$this->message = "Invalid Captcha";
				return FALSE;
			}else{
				$this->message = "";
				return TRUE;
			}
		}
	}
	/* Currently used for ENS */
	public function login_by_email($email) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$this->CI->session->sess_destroy();
		$this->message = '';
		if (!LOGIN_BY_EMAIL_ENABLED) {
			$this->message = "Email logins are not enabled for this site.";
			return FALSE;
		}
		if (!($user = $this->CI->user_model->get_user_by_email($email))){
			$this->message = "Please supply the email you used to sign up for this site.";
			return FALSE;
		}else{
			if($user['user_type_id'] != 4) {
				$this->message = 'Admins must login at ' . site_url() . str_replace('/', '', MR_DIRECTORY) . '/login/admin';
				return FALSE;
			}
			if($user['login_enabled'] != 1) {
				$this->message = "This account has been disabled.";
				return FALSE;
			}
			if($user['active'] != 1) {
				$this->message = 'This account was removed.';
				return FALSE;
			}
			if(!ALLOW_MULTIPLE_CONCURRENT_USER_SESSIONS) {
				$this->delete_user_session($user['id']);
			}
		}

		$this->CI->session->sess_create();
		$this->CI->session->sess_expiration = (60*60*24*365*2);
		$this->CI->session->set_userdata('account_id', $user['id']);
		$this->CI->session->set_userdata('username', $user['username']);
		$this->CI->session->set_userdata('user_type', $this->CI->user_model->get_user_type_name($user['user_type_id']));
		$video_settings = $this->CI->user_model->get_video_settings($user['id']);
		$this->CI->session->set_userdata('video_player', $video_settings['video_player']);
		$this->CI->session->set_userdata('video_bit_rate', $video_settings['video_bit_rate']);
		$this->CI->session->set_userdata('show_asl_videos', $video_settings['show_asl_videos']);

		return TRUE;
	}

	public function logout($echo = TRUE)
	{
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$this->CI->session->unset_userdata('account_id');
		$this->CI->session->unset_userdata('username');
		$this->CI->session->unset_userdata('user_type');
		$this->CI->session->unset_userdata('video_player');
		$this->CI->session->unset_userdata('video_bit_rate');
		$this->CI->session->unset_userdata('show_asl_videos');

		if($echo) {
			echo $this->_json_success('user logged out');
		}
	}

	private function _json_failed($message)
	{
		$a = array(
			'status'	=> 'failed',
			'message'	 => $message
		);

		return json_encode($a);
	}

	private function _json_success($message, $location = FALSE)
	{
		$a = array(
			'status'	=> 'success',
			'message'	 => $message
		);

		if ($location != FALSE)
		{
			$a['location'] = $location;
		}

		return json_encode($a);
	}
}

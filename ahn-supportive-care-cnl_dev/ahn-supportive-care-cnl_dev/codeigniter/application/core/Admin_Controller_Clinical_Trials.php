<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller_Clinical_Trials extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function ajax_angular_edit_user()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
				'status'		=> 'success',
				'message'		 => '',
				'user'			=> array()
		);

		$postdata = file_get_contents("php://input");
		$user = $this->_data['user'] = json_decode($postdata);

		$_POST['id'] = $user->id;
		$_POST['first_name'] = $user->first_name;
		$_POST['last_name'] = $user->last_name;
		$_POST['username'] = $user->username;
		$_POST['organization_id'] = $user->organization_id;
		$_POST['user_type_id'] = $user->user_type_id;
		$_POST['email'] = $user->email;
		$_POST['password'] = isset($user->password) ? $user->password : '';
		$_POST['confirm_password'] = isset($user->confirm_password) ? $user->confirm_password : '';
		$_POST['login_enabled'] = $user->login_enabled;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'User ID', 'trim|required|is_natural');
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|min_length[3]|max_length[45]|alpha_dash');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|min_length[3]|max_length[45]|alpha_dash');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[255]');
		$this->form_validation->set_rules('organization_id', 'Organization Name', 'required|is_natural');
		$this->form_validation->set_rules('user_type_id', 'User Type', 'required|is_natural');
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|callback_is_valid_password_check[0]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|matches[password]');
		$this->form_validation->set_rules('login_enabled', 'Login Enabled', 'trim|required|is_natural');

		if ($this->form_validation->run() == FALSE)
		{
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = validation_errors();
			log_info(__FILE__, __LINE__, __METHOD__, 'Form validation errors while attempting to edit user_id = ' . $user->id);
			echo json_encode($this->_data);
			return;
		}

		// Check if the user being edited exists
		if (!($orig_user = $this->user_model->get_user($_POST['id'])))
		{
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'User cannot be updated at this point in time.';
			log_error(__FILE__, __LINE__, __METHOD__, 'Could not find user_id = ' . $user->id . ' to edit');
			echo json_encode($this->_data);
			return;
		}

		if (($this->account_id == $_POST['id']) && ($orig_user['user_type_id'] != $_POST['user_type_id']))
		{
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'You cannot change your user type.';
			log_info(__FILE__, __LINE__, __METHOD__, 'Attempted to change own user_type_id');
			echo json_encode($this->_data);
			return;
		}

		if (!$this->user_model->update_user(
				$_POST['id'],
				$_POST['first_name'],
				$_POST['last_name'],
				$_POST['username'],
				$_POST['organization_id'],
				$_POST['user_type_id'],
				$_POST['email'],
				$_POST['password'],
				$_POST['login_enabled']
		))
		{
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Error updating user';
			log_error(__FILE__, __LINE__, __METHOD__, 'Unable to edit user_id = ' . $user->id);
			echo json_encode($this->_data);
			return;
		}

		log_info(__FILE__, __LINE__, __METHOD__, 'Successfully edited user_id = ' . $user->id);
		echo json_encode($this->_data);
		return;
	}
}
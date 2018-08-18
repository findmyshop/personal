<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller_Clinical_Trials {

	public function __construct() {
		parent::__construct();

		if(!is_admin() && !is_site_admin()) {
			redirect('/');
		}

		$this->load->library('enersource_library');

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function ajax_angular_add_user() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'		=> 'success',
			'message'		 => '',
			'user'			=> array()
		);

		$postdata = file_get_contents("php://input");
		$user = $this->_data['user'] = json_decode($postdata, TRUE);

		$_POST['first_name'] = $user['first_name'];
		$_POST['last_name'] = $user['last_name'];
		$_POST['organization_id'] = $user['organization_id'];
		$_POST['user_type_id'] = $user['user_type_id'];
		$_POST['email'] = $user['email'];
		$_POST['phone'] = !empty($user['phone']) ? $user['phone'] : $user['phone'];
		$_POST['address_line_1'] = !empty($user['address_line_1']) ? $user['address_line_1'] : NULL;
		$_POST['address_line_2'] = !empty($user['address_line_2']) ? $user['address_line_2'] : NULL;
		$_POST['municipality'] = !empty($user['municipality']) ? $user['municipality'] : NULL;
		$_POST['province_id'] = !empty($user['province_id']) ? $user['province_id'] : NULL;
		$_POST['postal_code'] = !empty($user['postal_code']) ? $user['postal_code'] : NULL;
		$_POST['customer_number'] = ($user['user_type_id'] == 4 && $user['is_customer'] == 1) ? $user['customer_number'] : NULL;
		$_POST['is_customer'] = ($_POST['user_type_id'] == 4) ? $user['is_customer'] : 0;
		$_POST['customer_type'] = ($_POST['user_type_id'] == 4 && $_POST['is_customer'] == 1 && !empty($user['customer_type'])) ? $user['customer_type'] : NULL;
		$_POST['login_enabled'] = $user['login_enabled'];
		$_POST['password'] = !empty($user['password']) ? $user['password'] : NULL;
		$_POST['confirm_password'] = !empty($user['confirm_password']) ? $user['confirm_password'] : NULL;

		$this->load->library('form_validation');

		$this->form_validation->set_rules('organization_id', 'Organization', 'required|is_natural');
		$this->form_validation->set_rules('user_type_id', 'User Type', 'required|is_natural');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|max_length[255]|is_unique[master_users.email]');
		$this->form_validation->set_rules('login_enabled', 'Login Enabled', 'trim|required|is_natural');
		$this->form_validation->set_rules('is_customer', 'Is Customer', 'trim|greater_than[-1]|less_than[2]');

		// passwords are required for admin and site admin accounts
		if($_POST['user_type_id'] <= 2) {
			$this->form_validation->set_rules('password', 'Password', 'trim|callback_is_valid_password_check[1]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|matches[password]');
		}

		if($_POST['user_type_id'] == 4) {
			if($_POST['is_customer'] == 1) {
				$this->form_validation->set_rules('customer_type', 'Customer Type', 'trim|required|max_length[63]|xss_clean');
				$this->form_validation->set_rules('customer_number', 'Enersource Account #', 'trim|required|exact_length[10]|alpha_numeric|is_unique[master_users.customer_number]');
				$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[3]|max_length[45]|alpha_dash');
				$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[3]|max_length[45]|alpha_dash');
				//$this->form_validation->set_rules('phone', 'Phone Number', 'trim|callback_is_valid_phone_number|xss_clean');
				//$this->form_validation->set_rules('address_line_1', 'Address Line 1', 'trim|to_upper|max_length[255]|xss_clean');
				//$this->form_validation->set_rules('address_line_2', 'Address Line 2', 'trim|to_upper|max_length[255]|xss_clean');
				//$this->form_validation->set_rules('municipality', 'Municipality', 'trim|to_upper|max_length[255]|xss_clean');
				//$this->form_validation->set_rules('province_id', 'Province', 'trim|is_natural_no_zero|xss_clean');
			}

			$this->form_validation->set_rules('postal_code', 'Postal Code', 'trim|required|to_upper|callback_is_valid_canadian_postal_code|xss_clean');
		}

		if($this->form_validation->run() == FALSE) {
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = validation_errors();
			log_info(__FILE__, __LINE__, __METHOD__, 'Form validation errors');
			echo json_encode($this->_data);
			return;
		}

		$user_id = $this->enersource_library->insert_user(
			$_POST['first_name'],
			$_POST['last_name'],
			$_POST['organization_id'],
			$_POST['user_type_id'],
			$_POST['email'],
			$_POST['phone'],
			$_POST['address_line_1'],
			$_POST['address_line_2'],
			$_POST['municipality'],
			$_POST['province_id'],
			$_POST['postal_code'],
			$_POST['customer_number'],
			$_POST['is_customer'],
			$_POST['customer_type'],
			$_POST['login_enabled'],
			$_POST['password']
		);

		if($user_id === FALSE) {
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Unable to create an account for user: ' . $_POST['email'] . '.';
			log_error(__FILE__, __LINE__, __METHOD__, 'Unable to create an account for user: ' . $_POST['email']);
			echo json_encode($this->_data);
			return;
		}

		$this->_data['message'] = 'An account was successfully created for user: ' . $_POST['email'] . '.';

		log_info(__FILE__, __LINE__, __METHOD__, 'Successfully inserted user_id = ' . $user_id);
		echo json_encode($this->_data);
		return;
	}

	public function ajax_angular_edit_user() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'		=> 'success',
			'message'		 => '',
			'user'			=> array()
		);

		$postdata = file_get_contents("php://input");
		$user = json_decode($postdata, TRUE);

		$_POST['id'] = $user['id'];
		$_POST['first_name'] = $user['first_name'];
		$_POST['last_name'] = $user['last_name'];
		$_POST['organization_id'] = $user['organization_id'];
		$_POST['user_type_id'] = $user['user_type_id'];
		$_POST['phone'] = !empty($user['phone']) ? $user['phone'] : NULL;
		$_POST['address_line_1'] = !empty($user['address_line_1']) ? $user['address_line_1'] : NULL;
		$_POST['address_line_2'] = !empty($user['address_line_2']) ? $user['address_line_2'] : NULL;
		$_POST['municipality'] = !empty($user['municipality']) ? $user['municipality'] : NULL;
		$_POST['province_id'] = !empty($user['province_id']) ? $user['province_id'] : NULL;
		$_POST['postal_code'] = !empty($user['postal_code']) ? $user['postal_code'] : NULL;
		$_POST['customer_number'] = ($user['user_type_id'] == 4 && $user['is_customer'] == 1) ? $user['customer_number'] : NULL;
		$_POST['is_customer'] = ($_POST['user_type_id'] == 4) ? $user['is_customer'] : 0;
		$_POST['customer_type'] = ($_POST['user_type_id'] == 4 && $_POST['is_customer'] == 1 && !empty($user['customer_type'])) ? $user['customer_type'] : NULL;
		$_POST['login_enabled'] = $user['login_enabled'];
		$_POST['password'] = !empty($user['password']) ? $user['password'] : NULL;
		$_POST['confirm_password'] = !empty($user['confirm_password']) ? $user['confirm_password'] : NULL;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('id', 'User ID', 'trim|required|is_natural');
		$this->form_validation->set_rules('organization_id', 'Organization Name', 'required|is_natural');
		$this->form_validation->set_rules('login_enabled', 'Login Enabled', 'trim|required|is_natural');

		// passwords are required for admin and site admin accounts
		if($_POST['user_type_id'] <= 2) {
			$this->form_validation->set_rules('password', 'Password', 'trim|callback_is_valid_password_check[0]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|matches[password]');
		}

		if($_POST['user_type_id'] == 4) {
			if($_POST['is_customer'] == 1) {
				$this->form_validation->set_rules('customer_type', 'Customer Type', 'trim|max_length[63]|xss_clean');
				$this->form_validation->set_rules('customer_number', 'Enersource Account #', 'trim|exact_length[10]|alpha_numeric');
				$this->form_validation->set_rules('first_name', 'First Name', 'trim|min_length[3]|max_length[45]|alpha_dash');
				$this->form_validation->set_rules('last_name', 'Last Name', 'trim|min_length[3]|max_length[45]|alpha_dash');
				//$this->form_validation->set_rules('phone', 'Phone Number', 'trim|callback_is_valid_phone_number|xss_clean');
				//$this->form_validation->set_rules('address_line_1', 'Address Line 1', 'trim|to_upper|max_length[255]|xss_clean');
				//$this->form_validation->set_rules('address_line_2', 'Address Line 2', 'trim|to_upper|max_length[255]|xss_clean');
				//$this->form_validation->set_rules('municipality', 'Municipality', 'trim|to_upper|max_length[255]|xss_clean');
				//$this->form_validation->set_rules('province_id', 'Province', 'trim|is_natural_no_zero|xss_clean');
			}

			$this->form_validation->set_rules('postal_code', 'Postal Code', 'required|trim|to_upper|callback_is_valid_canadian_postal_code|xss_clean');
		}

		if($this->form_validation->run() == FALSE) {
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = validation_errors();
			log_info(__FILE__, __LINE__, __METHOD__, 'Form validation errors');
			echo json_encode($this->_data);
			return;
		}

		// Check if the user being edited exists
		if(!($orig_user = $this->user_model->get_user($_POST['id']))) {
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'User cannot be updated at this point in time.';
			log_error(__FILE__, __LINE__, __METHOD__, 'Could not find user_id = ' . $user['id'] . ' to edit');
			echo json_encode($this->_data);
			return;
		}

		if(($this->account_id == $_POST['id']) && ($orig_user['user_type_id'] != $_POST['user_type_id'])) {
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'You cannot change your user type.';
			log_info(__FILE__, __LINE__, __METHOD__, 'Attempted to change own user_type_id');
			echo json_encode($this->_data);
			return;
		}

		if(!$this->enersource_library->update_user(
			$_POST['id'],
			$_POST['first_name'],
			$_POST['last_name'],
			$_POST['organization_id'],
			$_POST['phone'],
			$_POST['address_line_1'],
			$_POST['address_line_2'],
			$_POST['municipality'],
			$_POST['province_id'],
			$_POST['postal_code'],
			$_POST['customer_number'],
			$_POST['is_customer'],
			$_POST['customer_type'],
			$orig_user['entered_contest'],
			$_POST['login_enabled'],
			$_POST['password']
		))
		{
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Error updating user';
			log_error(__FILE__, __LINE__, __METHOD__, 'Unable to edit user_id = ' . $user['id']);
			echo json_encode($this->_data);
			return;
		}

		$_POST = array();
		echo json_encode($this->_data);
		return;
	}

	public function ajax_angular_export_survey_logs() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$data = array(
			'status'	=> 'success',
			'message'	=> '',
			'file'		=> ''
		);

		$filename = 'survey_logs_'.$this->account_id.'_'.date("Y-m-d_H-i-s").'.csv';
		$filepath = FCPATH.'tmp/'.$filename;
		$data['file'] = $filename;

		$status = FALSE;

		try {
			$status = $this->enersource_library->write_survey_logs_to_csv($filepath);
		} catch(Exception $e) {
			$data['status']	= 'failure';
			$data['message'] = $e->getMessage();
			log_error(__FILE__, __LINE__, __METHOD__, 'Unable to write csv file | error = ' . $data['message']);
			echo json_encode($data);
			return;
		}

		if($status === FALSE) {
			$data['status'] = 'failure';
			$data['message'] = 'No Records Returned... Aborting Download';
			log_info(__FILE__, __LINE__, __METHOD__, 'No records returned.  Aborting survey logs csv export');
			echo json_encode($data);
			return;
		}

		log_info(__FILE__, __LINE__, __METHOD__, 'Request successful');
		echo json_encode($data);
	}

	public function ajax_angular_get_users()	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'		=> 'success',
			'message'		 => '',
			'users'			 => array(),
			'user_types'	=> array(),
		);

		$postdata = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata);

		$search = $postdata_decoded->search;
		$organization_hierarchy_level_elements_filter = isset($postdata_decoded->organization_hierarchy_level_elements_filter) ? $postdata_decoded->organization_hierarchy_level_elements_filter : array();

		if(is_site_admin()) {
			$this->_data['users'] = $this->enersource_library->get_users($this->user_type, PROPERTY_ORGANIZATION_ID, $search, $organization_hierarchy_level_elements_filter);
		} else {
			$this->_data['users'] = $this->enersource_library->get_users($this->user_type, FALSE, $search, $organization_hierarchy_level_elements_filter);
		}

		$this->_data['user_types'] = $this->user_model->get_user_types($this->user_type, 1);
		$this->load->model('organization_hierarchy_model');
		$this->_data['users_organization_hierarchy_level_elements_map_entries'] = $this->organization_hierarchy_model->get_users_organization_hierarchy_level_element_map_entries();

		echo json_encode($this->_data);
	}

	public function ajax_angular_get_provinces() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		echo json_encode(array(
			'status'	=>	'success',
			'message'	=> '',
			'provinces'	=> $this->enersource_library->get_provinces()
		));
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

	public function is_valid_phone_number($str) {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		if(empty($str)) {
			return TRUE;
		}

		$regex = '/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/';
		if(preg_match($regex, $str) > 0) {
			return TRUE;
		}

		$this->form_validation->set_message('is_valid_phone_number', 'The Phone number must be in the format xxx-xxx-xxxx.');
		return FALSE;
	}

}

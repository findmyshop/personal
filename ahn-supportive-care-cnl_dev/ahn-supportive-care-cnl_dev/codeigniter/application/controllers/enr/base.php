<?php
/* This mess is a result what happens when a project gets planned with no
acknowledgement of how previous projects worked. Quickness becomes prioritized
before organization and the code base suffers. */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends Base_Controller_Clinical_Trials {

	public function __construct() {
		parent::__construct();
		$this->load->library('enersource_library');
		$this->load->model('user_experience_state_map_model');

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	/**
	 * We override the default load_response here.	We do some stuff with it.
	 */
	public function ajax_angular_load_response() {
		/* We're going to hook the parent */
		$this->_is_hooked = true;
		parent::ajax_angular_load_response();

		log_info(__FILE__, __LINE__, __METHOD__, 'Request for response_id = ' . $this->_data["response"]["id"]);

		/* Make sure we have a response to begin with */
		if (!$this->_data["response"]){
			return;
		}

		/* Those three sections that lead to a different place if stuff is complete */
		if ($this->enersource_library->user_has_completed_optional_sections($this->account_id)){
			switch ($this->_data["response"]["id"]){
				case "enr0468" :
					$this->_data["response"]["video_controls"]["next_id"] = 'enr0701';
					break;
				case "enr0563" :
					$this->_data["response"]["video_controls"]["next_id"] = 'enr0701';
					break;
				case "enr0603" :
					$this->_data["response"]["video_controls"]["next_id"] = 'enr0701';
					break;
				default :
					break;
			}
		}

		/* If you're NOT a customer or the contest is disabled, no draw form for you! */
		if($this->_data["response"]["id"] === 'enr1402' && (!$this->enersource_library->is_customer($this->account_id) || !feature_enabled('contest', $this->session->userdata('user_type')))) {
			$this->_data["response"]["video_controls"]["done_id"] = 'fun0000';
		}

		/* Complete a response ID */
		if ($this->_data["action_type"] == ACTION_DONE) {
			switch ($this->_data["response"]["id"]){
				case "enr0369" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr0301', 'passed');
					break;
				case "enr0468" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr0401', 'passed');
					break;
				case "enr0806" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr0804', 'passed');
					break;
				case "enr0914" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr0912', 'passed');
					break;
				case "enr0563" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr0501', 'passed');
					break;
				case "enr0603" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr0601', 'passed');
					break;
				case "enr1022" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr1020', 'passed');
					break;
				case "enr1303" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr1129', 'passed');
					break;
				default :
					break;
			}
		}

		/* Long Term Plan completion */
			switch ($this->initial_response){
				case "enr1026" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr1024', 'passed');
					break;
				case "enr1129" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr1026', 'passed');
					break;
				case "enr1307" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr1305', 'passed');
					break;
				case "enr0912" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr0810', 'passed');
					break;
				case "enr1020" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr0918', 'passed');
					break;
				/* 11 QUESTIONS */
				case "enr0808" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr0806', 'passed');
					break;
				case "enr0810" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr0808', 'passed');
					break;
				case "enr0916" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr0914', 'passed');
					break;
				case "enr0918" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr0916', 'passed');
					break;
				case "enr1024" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr1022', 'passed');
					break;
				case "enr1401" :
					$this->enersource_library->update_user_course_activity($this->account_id, 'enr1307', 'passed');
					break;
			}

		/* Specific State-Altering response IDs */
		if ($this->user_experience_state_map_model->get_by_user($this->account_id) == FALSE){
			$this->user_experience_state_map_model->insert($this->account_id);
		}
		if ($this->_data["action_type"] == ACTION_DONE &&
				$this->user_experience_state_map_model->get_by_user($this->account_id) != "TEST_COMPLETED"
			 ){
			switch ($this->_data["response"]["id"]){
				case "enr0369" :
					$this->user_experience_state_map_model->update($this->account_id,"RELIABILITY_COMPLETED");
					break;
				case "enr0806" :
					$this->user_experience_state_map_model->update($this->account_id,"TEST_IN_PROGRESS");
					break;
				case "fun0000" :
					if (!$this->enersource_library->is_customer($this->account_id)){
						$this->user_experience_state_map_model->update($this->account_id,"TEST_COMPLETED");
						$this->enersource_library->complete_user_course($this->account_id);
					}
					break;
				case "enr4002" :
					if ($this->enersource_library->is_customer($this->account_id)){
						$this->user_experience_state_map_model->update($this->account_id,"TEST_COMPLETED");
						$this->enersource_library->complete_user_course($this->account_id);
					}
					break;
				default :
				break;
			}
		}

		/* If they're trying to get back in to the questions area after they've completed the test */
		if ($this->user_experience_state_map_model->get_by_user($this->account_id) == "TEST_COMPLETED" &&
				$this->_data["response"]["id"] == "enr0703"
			 ){
			$this->_data["response"]["video_controls"]["next_id"] = '';
		}

		/* Finished with the program and you are a customer, you get a text video back instead of a welcome message on returning */
		if ($this->user_experience_state_map_model->get_by_user($this->account_id) == "TEST_COMPLETED" &&
				$this->_data['returning_user'] == 'true' &&
				$this->enersource_library->is_customer($this->account_id)
			 ){
			$this->_data['response'] = $this->index_library->get_response('enr4004');
			//$this->_data['response']['video_name'] = 'enr4004';
			//$this->_data['response']['id'] = 'enr4004';
		}


		/* Overwrite the left rail */
		$this->_data['current_left_rail'] = 'main-'.$this->user_experience_state_map_model->get_by_user($this->account_id);
		// Get left rail
		if (!($left_rail = $this->_data['left_rail'] =
					$this->index_library->get_left_rail_content(MR_PROJECT, $this->_data['current_left_rail']))) {
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Error loading left rail';
			echo json_encode($this->_data);
			return;
		}

		/* Tests Logic */
		if (isset($this->_data["response"]['type'])){
			if ($this->_data["response"]['type'] == "test") {
				$this->_data['test'] = $this->enersource_library->get_load_response_test_data($this->_data["response"]["id"]);
			}
		}

		/* When to remember a users place */
		if ($this->_data["action_type"] == ACTION_RELATED ||
				$this->_data["action_type"] == ACTION_Q ||
				$this->_data["response"]["id"] == "enr3001" ||
				$this->_data["response"]["id"] == "enr3010"
				){
			$this->_data['returning_user'] = 'true';
			$this->skip_response_save = true;
		}


		if (($this->_data['returning_user'] == 'false') &&
				($this->skip_response_save == false)) {
			$this->user_model->update_last_user_state($this->account_id, $this->org_id, $this->initial_response, $this->_data['current_left_rail']);
		}

		/* Get all user activity */
		$uc = $this->enersource_library->get_user_course_activity($this->account_id);
		//$this->_data["uc"] = $uc;
		/* Look through rail */
		foreach ($this->_data["left_rail"] as &$rail) {
			foreach ($rail["responses"] as &$g){
				foreach ($g as &$r){
					foreach ($uc as &$c){
						if ($r["id"] == $c["response_id"]){
							$r["status"] = $c["status"];
						}
					}
				}
			}
		}

		/* User Progress */
		$this->_data["response"]["user_progress"] = $this->enersource_library->user_progress($this->account_id);

		/* When finished, set all ask controls to analyze */
		if ($this->user_experience_state_map_model->get_by_user($this->account_id) == "TEST_COMPLETED"){
			$this->_data["response"]["ask_controls"]["hidden"] = "false";
		}

		/* Barf */
		echo json_encode($this->_data);
		$this->_is_hooked = false;
	}

	public function ajax_angular_get_contest_form_data() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$response = array(
			'status'		=> 'success',
			'message'		=> '',
			'user'			=> array(),
			'provinces'	=> array()
		);

		$user = $this->user_model->get_user($this->account_id);
		$provinces = $this->enersource_library->get_provinces();

		if(empty($user) || empty($provinces)) {
			$response['status'] = 'failure';
			$response['message'] = 'Unable to load contest form data.';
		}

		$response['user'] = $user;
		$response['provinces'] = $provinces;

		echo json_encode($response);
	}

	public function ajax_angular_submit_contest_entry() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'		=> 'success',
			'message'		 => 'Congratulations! You\'ve been entered in the draw!'
		);

		$postdata = file_get_contents("php://input");
		$user = json_decode($postdata, TRUE);
		$_POST['terms_accepted'] = !empty($user['terms_accepted']) ? $user['terms_accepted'] : 0;
		$_POST['customer_type'] = !empty($user['customer_type']) ? $user['customer_type'] : NULL;
		$_POST['first_name'] = !empty($user['first_name']) ? $user['first_name'] : $user['first_name'];
		$_POST['last_name'] = !empty($user['last_name']) ? $user['last_name'] : $user['last_name'];
		$_POST['customer_number'] = !empty($user['customer_number']) ? $user['customer_number'] : NULL;
		//$_POST['phone'] = !empty($user['phone']) ? $user['phone'] : $user['phone'];
		//$_POST['address_line_1'] = !empty($user['address_line_1']) ? $user['address_line_1'] : NULL;
		//$_POST['address_line_2'] = !empty($user['address_line_2']) ? $user['address_line_2'] : NULL;
		//$_POST['municipality'] = !empty($user['municipality']) ? $user['municipality'] : NULL;
		//$_POST['province_id'] = !empty($user['province_id']) ? $user['province_id'] : NULL;
		//$_POST['postal_code'] = !empty($user['postal_code']) ? $user['postal_code'] : NULL;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('terms_accepted', 'Accept Terms', 'required|xss_clean');
		$this->form_validation->set_rules('customer_type', 'Customer Type', 'required|trim|max_length[63]|xss_clean');
		$this->form_validation->set_rules('first_name', 'First Name', 'required|trim|min_length[1]|max_length[45]|xss_clean');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|min_length[1]|max_length[45]|xss_clean');
		$this->form_validation->set_rules('customer_number', 'Enersource Account #', 'trim|exact_length[10]|alpha_numeric');
		//$this->form_validation->set_rules('phone', 'Phone Number', 'required|trim|callback_is_valid_phone_number|xss_clean');
		//$this->form_validation->set_rules('address_line_1', 'Address Line 1', 'required|trim|to_upper|max_length[255]|xss_clean');
		//$this->form_validation->set_rules('address_line_2', 'Address Line 2', 'trim|to_upper|max_length[255]|xss_clean');
		//$this->form_validation->set_rules('municipality', 'Municipality', 'required|trim|to_upper|max_length[255]|xss_clean');
		//$this->form_validation->set_rules('province_id', 'Province', 'required|trim|is_natural_no_zero|xss_clean');
		//$this->form_validation->set_rules('postal_code', 'Postal Code', 'required|trim|to_upper|callback_is_valid_canadian_postal_code|xss_clean');


		if($this->form_validation->run() == FALSE) {
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = validation_errors();
			log_info(__FILE__, __LINE__, __METHOD__, 'Form validation errors');
			echo json_encode($this->_data);
			return;
		}

		if(!$this->enersource_library->update_user(
			$this->account_id,
			$_POST['first_name'],
			$_POST['last_name'],
			$this->organization_model->get_org_id_by_user_id($this->account_id),
			NULL, //phone
			NULL, //address 1
			NULL, //address 2
			NULL, //municipality
			NULL, //province_id
			NULL, //postal_code
			$_POST['customer_number'],
			1,
			$_POST['customer_type'],
			1,
			1,
			NULL
		))
		{
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Error submitting contest entry.';
			log_error(__FILE__, __LINE__, __METHOD__, 'Failure submitting contest entry for user_id = ' . $this->account_id);
			echo json_encode($this->_data);
			return;
		}

		$_POST = array();
		echo json_encode($this->_data);
		return;
	}

	public function ajax_angular_submit_comment() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$response = array(
			'status'	=> 'success',
			'message' => ''
		);

		$postdata = file_get_contents("php://input");
		$postdata = json_decode($postdata, TRUE);

		if(empty($postdata['answer'])) {
			echo json_encode(array(
				'status'	=> 'failure',
				'message'	=> 'Please enter a comment before submitting.'
			));
			return;
		}

		if(!$this->enersource_library->insert_user_test_activity($this->account_id, $postdata['test_key'], $postdata['answer'])) {
			$response = array(
				'status'	=> 'failure',
				'message'	=> 'Error submitting answer.  Failed to insert activity.'
			);
		}

		echo json_encode($response);
	}

	public function ajax_angular_submit_multiple_choice() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$response = array(
			'status'	=> 'success',
			'message' => ''
		);

		$postdata = file_get_contents("php://input");
		$postdata = json_decode($postdata, TRUE);

		if(empty($postdata['answer'])) {
			echo json_encode(array(
				'status'	=> 'failure',
				'message'	=> 'Please select an answer before submitting.'
			));
			return;
		}

		if(!$this->enersource_library->insert_user_test_activity($this->account_id, $postdata['test_key'], $postdata['answer'])) {
			$response = array(
				'status'	=> 'failure',
				'message'	=> 'Error submitting answer.  Failed to insert activity.'
			);

			log_error(__FILE__, __LINE__, __METHOD__, 'Failed to insert test activity');
		}

		echo json_encode($response);
	}

	public function index() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		// do not allow admins and site_admins to enter the experience
		if(is_admin() || is_site_admin()) {
			log_info(__FILE__, __LINE__, __METHOD__, 'Unauthorized request to enter the experience');
			redirect('admin');
		}

		$this->_data['user'] = $this->user_model->get_user($this->account_id);
		parent::index();
	}

}

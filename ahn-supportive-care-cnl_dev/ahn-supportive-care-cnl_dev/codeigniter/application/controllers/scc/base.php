<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends Base_Controller_Hybrid {

	public function __construct() {
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function ajax_angular_get_my_answers() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		// Trying to keep this functionality encapsulated in the Supportive_care class so just adding this bit of hard-coding
		$responses = array("scc147", "scc148", "scc149", "scc150", "scc151", "scc152", "scc153", "scc161", "scc162", "scc163", "scc164", "scc165", "scc166");

		$this->_data = array(
			'status'			 => 'success',
			'message'			 => ''
		);

		$this->session_id = $this->session->userdata('session_id');

		$answers = array();
		foreach ($responses as $response_id)
		{
			$log = $this->log_model->get_most_recent_log_by_session_id($this->session_id, $response_id, ACTION_LOG);
			if ($log)
			{
				// We're going to get the content of the response because the question is a title of the response
				// rather than the actual question
				$question = $this->index_library->get_question_content($response_id, MR_PROJECT);
				if ($question)
				{
					$answers[$question] = $log['input_question'];
				}
			}
		}

		$this->_data['my_answers'] = $answers;

		echo json_encode($this->_data);
	}

	public function ajax_angular_log_user_input() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'			 => 'success',
			'message'			 => 'Your answer has been logged. Please go to next question.',
			'response'	 => array()
		);

		$postdata_string = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata_string, TRUE);

		if (!isset($postdata_decoded['current_response'])){
			log_message('error', 'DEV-ERROR: A current response ID was not received when logging user input');
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'There was an error when logging your answer.';
			echo json_encode($this->_data);
			return;
		}

		if (!isset($postdata_decoded['user_input_question'])){
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'You must provide an answer';
			echo json_encode($this->_data);
			return;
		}



		// Log action
		$this->log_model->insert_activity_log(
			ACTION_LOG,
			$postdata_decoded['user_input_question'],
			MR_CASE_NAME,
			$postdata_decoded['current_response'],
			'',			// Response ID
			'',			// Response Question
			'',			// Response type
			$postdata_decoded['show_asl_video']
		);
		echo json_encode($this->_data);
	}

	public function ajax_angular_log_feedback_input() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'			 => 'success',
			'message'			 => '',
			'response'	 => array()
		);

		$postdata_string = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata_string, TRUE);

		if (!isset($postdata_decoded['answers']))
		{
			log_message('error', 'DEV-ERROR: Did not receive an array of feedback answers to log in learn.ajax_angular_log_feedback_input()');
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Invalid arguments';
			echo json_encode($this->_data);
			return;
		}

		$answers = $postdata_decoded['answers'];
		// Check if we get the right amount of answers from the survey.
		// This $answers variable comes from the AngularJS.cookieStore which
		// saves a null as the first element so we're checking for six answers but use a length of 7
		if (sizeof($answers) != 7)
		{
			log_message('error', 'DEV-ERROR: Feedback answers array does not contain enough elements.');
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Error logging feedback';
			echo json_encode($this->_data);
			return;
		}

		// Log action
		$success = $this->log_model->insert_feedback_log(
			$this->org_id,
			$answers[1],
			$answers[2],
			$answers[3],
			$answers[4],
			$answers[5],
			$answers[6]
		);

		if (!$success)
		{
			log_message('error', 'DEV-ERROR: Error inserting feedback log into database. Received FALSE from log_model->insert_feedback_log()');
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Error inserting feedback into database';
			echo json_encode($this->_data);
			return;
		}

		echo json_encode($this->_data);
	}
	public function ajax_angular_consult_information() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'			 => 'success',
			'message'			 => 'Your consultation request has been sent successfully.',
			'response'	 => array()
		);

		$postdata_string = file_get_contents("php://input");
		$decoded_postdata = json_decode($postdata_string);
		$consult_information = $decoded_postdata->consult_information;
		$current_response = $decoded_postdata->current_response;

		$_POST['patient'] = isset($consult_information->patient) ? $consult_information->patient : '';
		$_POST['location'] = isset($consult_information->location) ? $consult_information->location : '';
		$_POST['address'] = isset($consult_information->address) ? $consult_information->address : '';
		$_POST['topic'] = isset($consult_information->topic) ? $consult_information->topic : '';
		$_POST['name'] = isset($consult_information->name) ? $consult_information->name : '';
		$_POST['relationship'] = isset($consult_information->relationship) ? $consult_information->relationship : '';
		$_POST['phone'] = isset($consult_information->phone) ? $consult_information->phone : '';
		$_POST['email'] = isset($consult_information->phone) ? $consult_information->phone : 'N/A';
		$_POST['privacy'] = isset($consult_information->privacy) ? 'Yes' : 'No';
		if (isset($consult_information->privacy)) {
			$this->_data['message'] .= ' We will follow up as soon as possible.';
		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('patient', 'Patient', 'required');
		$this->form_validation->set_rules('location', 'Location', 'required');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('topic', 'Topic', 'required');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('relationship', 'Relationship', 'required');
		$this->form_validation->set_rules('phone', 'Phone', 'required');
		//$this->form_validation->set_rules('email', 'Email', 'required');
		//$this->form_validation->set_rules('privacy', 'Privacy', 'required');

		if ($this->form_validation->run() == FALSE) {
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = validation_errors();
			log_info(__FILE__, __LINE__, __METHOD__, 'Form validation errors');
			echo json_encode($this->_data);
			return;
		}

		$this->load->library('contact_library');

		$user = $this->user_model->get_user($this->session->userdata('account_id'));
		$username = $user['username'];
		$user_id = $user['id'];

		$browser_name = $this->agent->browser();
		$version_array = explode('.', $this->agent->version());
		$browser = $browser_name . ' ' . $version_array[0];

		$this->contact_library->request_consult($user_id, $username, $_POST, $browser, $current_response);

		echo json_encode($this->_data);
	}

}

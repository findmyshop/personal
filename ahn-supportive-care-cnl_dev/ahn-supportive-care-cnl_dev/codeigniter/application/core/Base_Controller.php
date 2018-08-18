<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base_Controller extends MY_Controller {
	protected $account_id = FALSE;
	protected $user_type = FALSE;
	protected $current_flow_attempt = NULL;

	public function __construct(){
		parent::__construct();
		$this->_data = array();
		$this->account_id = $this->session->userdata('account_id');
		$this->user_type = $this->session->userdata('user_type');
		$this->org_id = $this->organization_model->get_organization_id_by_property_name(MR_PROJECT);

		if(LOG_FLOW_ATTEMPTS) {
			$this->current_flow_attempt = $this->log_model->get_current_flow_attempt();
		}

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function ajax_angular_bug_report() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'			 => 'success',
			'message' => 'Your inquiry has been submitted!',
			'response'	 => array()
		);

		$postdata_string = file_get_contents("php://input");
		$decoded_postdata = json_decode($postdata_string);
		$bug_information = $decoded_postdata->bug_information;
		$current_response = $decoded_postdata->current_response;

		$_POST['email'] = isset($bug_information->email) ? $bug_information->email : '';
		$_POST['report'] = isset($bug_information->report) ? $bug_information->report : '';
		/* get privacy setting */
		$_POST['privacy'] = isset($bug_information->privacy) ? 'Yes' : 'No';
		if (isset($bug_information->privacy)){
			$this->_data['message'] = 'Your inquiry has been submitted! We will follow up as soon as possible.';
		}
		/* get the ping */
		$_POST['video_ping'] = isset($bug_information->video_ping) ? $bug_information->video_ping : '';

		/* get the last popup message */
		$_POST['last_message'] = isset($bug_information->last_message) ? $bug_information->last_message : '';

		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('report', 'Description', 'trim|required|max_length[500]');
		//$this->form_validation->set_rules('privacy', 'Privacy', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = validation_errors();
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

		$this->contact_library->send_bug_report(array(
			'user_id' => $user_id,
			'username' => $username,
			'email' => $_POST['email'],
			'browser' => $browser,
			'current_response' => $current_response,
			'report' => $_POST['report'],
			'privacy' => $_POST['privacy'],
			'video_ping' => $_POST['video_ping'],
			'last_message' => $_POST['last_message']
		));

		echo json_encode($this->_data);
	}
	
	public function ajax_angular_question_feedback() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'			 => 'success',
			'message' => 'Your inquiry has been submitted!',
			'response'	 => array()
		);

		$postdata_string = file_get_contents("php://input");
		$decoded_postdata = json_decode($postdata_string);
		$question_feedback = $decoded_postdata->question_feedback;

		$_POST['email'] = isset($question_feedback->email) ? $question_feedback->email : '';
		$_POST['question'] = isset($question_feedback->question) ? $question_feedback->question : '';
		/* get privacy setting */
		$_POST['terms_accepted'] = isset($question_feedback->terms_accepted) ? 'Yes' : 'No';
		if (isset($question_feedback->terms_accepted)){
			if ($question_feedback->terms_accepted == false){
				$this->_data['status'] = 'failure';
				$this->_data['message'] = 'You must check the box below to agree to be contacted.';
				echo json_encode($this->_data);
				return;
			}
			$this->_data['message'] = 'Your inquiry has been submitted! We will follow up as soon as possible.';

		}

		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('question', 'Question', 'trim|required|max_length[500]');

		if ($this->form_validation->run() == FALSE)
		{
			$_POST = array();
			$this->_data['status'] = 'failure';
			$this->_data['message'] = validation_errors();
			echo json_encode($this->_data);
			return;
		}
		$this->load->library('contact_library');
		$this->contact_library->send_question_feedback(array('question' => $_POST['question'],
																										'email' => $_POST['email']
																									));
		echo json_encode($this->_data);
	}

	public function ajax_angular_call_analyzer()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'			 => 'success',
			'message'			 => '',
			'response'	 => array()
		);

		$postdata_string = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata_string, TRUE);

		if (!isset($postdata_decoded['current_response']))
		{
			$postdata_decoded['current_response'] = 'null';
			log_message('error', 'DEV-ERROR: Did not receive a current response ID when calling the analyzer');
		}
		$this->current_response = $postdata_decoded['current_response'];
		if (!isset($postdata_decoded['input_question']))
		{
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'You must provide input question';
			echo json_encode($this->_data);
			return;
		}else{
			$this->_data["cached_input_question"] = $postdata_decoded['input_question'];
			/* Log question asked */
			$this->user_model->update_user_attr($this->account_id,'questions_asked',1);
		}

		if (isset($postdata_decoded['case_name'])){
			if ($postdata_decoded['case_name'] != ''){
				$case_name = $postdata_decoded['case_name'];
			}else{
				$case_name = MR_CASE_NAME;
			}
		}else{
			$case_name = MR_CASE_NAME;
		}

		if(strlen($postdata_decoded['input_question']) > MR_ASK_LENGTH) {
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'A question cannot exceed 200 characters';
			echo json_encode($this->_data);
			return;
		}

		$this->load->library('preprocessor_library');
/*
		if(feature_enabled('preprocessor_clause_segmenter') && $this->preprocessor_library->str_contains_multiple_clauses($postdata_decoded['input_question'])) {
			if(feature_enabled('preprocessor_clause_segmenter_error_message')) {
				$this->_data['status'] = 'failure';
				$this->_data['message'] = 'Your input contained more than one question. Please input only one question at a time.';
				echo json_encode($this->_data);
				return;
			}
		}
*/
		$input_question = $postdata_decoded['input_question'];

		$this->_data['input_question_disambiguated'] = NULL;

		if(feature_enabled('preprocessor_clause_segmenter') && feature_enabled('preprocessor_disambiguator')) {
			$preprocessor_data = $this->preprocessor_library->call_preprocessor($input_question);
			$input_question = $preprocessor_data['disambiguated_string'];
			$this->_data['input_question_disambiguated'] = $input_question;

			if(feature_enabled('preprocessor_clause_segmenter_error_message') && count($preprocessor_data['clause_segments']) > 1) {
				$this->_data['status'] = 'failure';
				$this->_data['message'] = 'Your input contained more than one question. Please input only one question at a time.';
				echo json_encode($this->_data);
				return;
			}

		} else if(feature_enabled('preprocessor_clause_segmenter')) {
			$clause_segments = $this->preprocessor_library->call_preprocessor_clause_segmenter($input_question);

			if(feature_enabled('preprocessor_clause_segmenter_error_message') && count($clause_segments) > 1) {
				$this->_data['status'] = 'failure';
				$this->_data['message'] = 'Your input contained more than one question. Please input only one question at a time.';
				echo json_encode($this->_data);
				return;
			}
		} else if(feature_enabled('preprocessor_disambiguator')) {
			$input_question = $this->preprocessor_library->call_preprocessor_disambiguator($input_question);
			$this->_data['input_question_disambiguated'] = $input_question;
		}

		// The analyzer library will talk to the Analyzer API to get a resposne ID
		// then call the index library to get the response info
		$response = $this->analyzer_library->get_response($input_question, $case_name, $postdata_decoded['current_response'], $postdata_decoded['ask_controls']);
		if ($response["status"] != "success") {
			echo json_encode($response);
			return;
		}

		$this->_data['response'] = $response;
		$this->_data['returning_user'] = 'false';

		$left_rail_to_load = $this->get_next_left_rail_based_on_user_state($response);

		// Get left rail
		if (!($left_rail = $this->_data['left_rail'] = $this->index_library->get_left_rail_content(MR_PROJECT, $left_rail_to_load)))
		{
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Error loading left rail';
			echo json_encode($this->_data);
			return;
		}
		$this->_data['current_left_rail'] = $left_rail_to_load;

		/* Log responses given */
		$this->user_model->update_user_attr($this->account_id,'responses_given',1);
		if (!isset($this->_is_hooked)){
			echo json_encode($this->_data);
		}
	}

	public function ajax_angular_load_all_resources()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'			 => 'success',
			'message'			 => '',
			'response'	 => array()
		);

		if (!($this->_data['resources'] = $this->index_library->get_resources(MR_PROJECT)))
		{
			log_message('error', 'DEV-ERROR: index_library->get_resources failed');
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Error loading resources';
			echo json_encode($this->_data);
			return;
		}

		echo json_encode($this->_data);
	}

	public function ajax_angular_load_left_rail()
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'			 => 'success',
			'message'			 => '',
			'debug' => '',
			'response'	 => array()
		);

		$postdata_string = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata_string, TRUE);

		if (!($left_rail = $this->_data['left_rail'] = $this->index_library->get_left_rail_content(MR_PROJECT, $postdata_decoded['left_rail_id'])))
		{
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Error loading left rail';
			echo json_encode($this->_data);
			return;
		}
		$this->_data['current_left_rail'] = $postdata_decoded['left_rail_id'];

		echo json_encode($this->_data);
	}

	public function ajax_angular_load_response() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$postdata_string = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata_string, TRUE);
		$this->initial_response = $postdata_decoded['response_id'];
		$this->skip_response_save = $postdata_decoded['skip_last_response_save'];

		if (isset($postdata_decoded['current_response'])) {
			$this->current_response = $postdata_decoded['current_response'];
		}else{
			$this->current_response = 'null';
		}

		if (!isset($postdata_decoded['input_question'])) {
			$postdata_decoded['input_question'] = '';
		}
		if (!isset($postdata_decoded['response_type'])){
			$postdata_decoded['response_type'] = '';
		}

		/* Only update user data if they've switched video quality on us */
		if ($this->session->userdata('video_bit_rate') !== $postdata_decoded['video_bit_rate']){
			$this->session->set_userdata('video_bit_rate',$postdata_decoded['video_bit_rate']);
		}
		$this->_data['video_bit_rate'] = $this->session->userdata('video_bit_rate');

		if ($this->session->userdata('show_asl_video') !== $postdata_decoded['show_asl_video']){
			$this->session->set_userdata('show_asl_video',$postdata_decoded['show_asl_video']);
		}
		$this->_data['show_asl_video'] = $this->session->userdata('show_asl_video');

		if (isset($postdata_decoded['logged_case_name'])) {
			$this->logged_case_name = $postdata_decoded['logged_case_name'];
		}else{
			$this->logged_case_name = MR_CASE_NAME;
		}

		/* If a response ID is given then get that response
		otherwise just get the initial response */
		if (isset($postdata_decoded['response_id'])) {
			$this->_data['returning_user'] = 'false';
			if ($response = $this->_data['response'] = $this->index_library->get_response($postdata_decoded['response_id'])) {
				$this->_data['response']['attempt'] = $this->log_model->get_most_recent_flow_response_attempt($response['id']) + 1;
				$left_rail_to_load = $this->get_next_left_rail_based_on_user_state($response);
				// Get left rail
				if (!($left_rail = $this->_data['left_rail'] = $this->index_library->get_left_rail_content(MR_PROJECT, $left_rail_to_load))) {
					$this->_data['status'] = 'failure';
					$this->_data['message'] = 'Error loading left rail';
					echo json_encode($this->_data);
					return;
				}
				$this->_data['current_left_rail'] = $left_rail_to_load;
			} else {
				$this->_data['status'] = 'failure';
				$this->_data['message'] = 'Error loading response.';
				$this->_data['debug'] = 'Error loading response from index.xml';
				echo json_encode($this->_data);
				return;
			}
			// Determine action made by user by looking at UI variable 'type'
			$action_type = ACTION_OTHER;
			if (isset($postdata_decoded['type'])) {
				if ($postdata_decoded['type'] == 'LRQ') {
					$action_type = ACTION_LEFT_RAIL;
				}else if ($postdata_decoded['type'] == 'NEXT') {
					$action_type = ACTION_NEXT;
				}else if ($postdata_decoded['type'] == 'DONE') {
					$action_type = ACTION_DONE;
				}else if ($postdata_decoded['type'] == 'PREVIOUS') {
					$action_type = ACTION_PREV;
				}else if ($postdata_decoded['type'] == 'REPEAT') {
					$action_type = ACTION_REPEAT;
				}else if ($postdata_decoded['type'] == 'RELATED') {
					$action_type = ACTION_RELATED;
				}else if ($postdata_decoded['type'] == 'MA') {
					$action_type = ACTION_MA;
				}else if ($postdata_decoded['type'] == 'Q'){
					$action_type = ACTION_Q;
				}else if ($postdata_decoded['type'] == 'A'){
					$action_type = ACTION_A;
				}else if ($postdata_decoded['type'] == 'RETURN'){
					$action_type = ACTION_RETURNING_USER;
				}else if ($postdata_decoded['type'] == 'R'){ // Rating
					$action_type = ACTION_R;
				}
			}
			if ($action_type){
				$this->_data["action_type"] = $action_type;
			}
		} else {
			//	Check if this user has never logged in before or is not logged in
			if (!is_logged_in() || $this->log_model->user_activity_count($this->account_id) == 0) {
				/* New user initial response */
				$_is_new_user = TRUE;
				$this->_data['returning_user'] = 'false';
			} else {
				/* Welcome back response */
				$_is_new_user = FALSE;
				$this->_data['returning_user'] = 'true';
			}
			/* For SBIRTS, we rely on the default_course URL in the DB, otherwise, we grab the welcome
			 * Id from the database.
			 */

			$user_state = $this->user_model->get_last_user_state($this->account_id, $this->org_id);

			if (isset($this->default_course["url"])){
				$last_id = $user_state['last_response'];
				/* Check if theres a Last Id for this course/iteration in user_course_activity in the DB */
				$last_id = $this->course_model->get_last_response_id($this->account_id, $this->default_course['course_id'], $this->default_course['current_iteration']);
				if ($last_id){
					$this->initial_response = $last_id;
				}else{
					/* No last id, default to the default URL for this rid */
					$this->initial_response = $this->default_course['after_disclaimer'];
				}
			}else{
				$user_state = $this->user_model->get_last_user_state($this->account_id, $this->org_id);
				$this->initial_response = $this->property_model->get_welcome_response_id(MR_PROJECT, $postdata_decoded['decision_flow_site'], $_is_new_user);
			}

			if ($response = $this->_data['response'] = $this->index_library->get_response($this->initial_response)) {
				$this->_data['response']['attempt'] = $this->log_model->get_most_recent_flow_response_attempt($response['id']) + 1;

				// Get left rail
				if (!($left_rail = $this->_data['left_rail'] =
							$this->index_library->get_left_rail_content(MR_PROJECT, $response['left_rail']['id']))) {
					$this->_data['status'] = 'failure';
					$this->_data['message'] = 'Error loading left rail';
					echo json_encode($this->_data);
					return;
				}
				$this->_data['current_left_rail'] = $response['left_rail']['id'];

				$this->_data["action_type"] = ACTION_START;
			} else {
				$this->_data['status'] = 'failure';
				$this->_data['message'] = 'Error loading response.';
				echo json_encode($this->_data);
				return;
			}
		}
		/* Optional set the speaker */
		if (MR_HAS_SPEAKER){
			if ($this->session->userdata('speaker')){
				$this->_data['status'] = 'success';
			}else{
				$this->_data['status'] = 'failure';
				$this->_data['hard_redirect'] = '/'.MR_DIRECTORY.'login?m=speaker';
			}
		}


		$this->_data['speaker'] = $this->session->userdata('speaker');
		$this->_data['status'] = 'success';

		/* Update where user left off */
		if (is_logged_in() && ($this->_data['returning_user'] == 'false') && ($this->skip_response_save == false) && !$this->property_model->is_welcome_back_response_id(MR_PROJECT, $response['id'])) {
			/* To be safe (FOR GUEST LOGINS) only hit the DB when not hooked */
			if (!isset($this->_is_hooked)){
				$this->user_model->update_last_user_state($this->account_id, $this->org_id, $this->initial_response, 'main');
			}else if(($action_type === 'NEXT') || ($action_type == 'Next')){
				$this->user_model->update_last_user_state($this->account_id, $this->org_id, $this->initial_response, 'main');
			}
			/* Cookie that shit (for anonymous logins) */
			if (!USER_AUTHENTICATION_REQUIRED){
				$this->session->set_userdata('last_rid',$this->initial_response);
			}
		}
		/* If this class has been inherited Barf our data */
		if (!isset($this->_is_hooked)){
			echo json_encode($this->_data);
		}

		$this->log_model->insert_activity_log(
			$this->_data["action_type"],
			$postdata_decoded['input_question'],
			$postdata_decoded['input_question_disambiguated'],
			$this->logged_case_name,
			$this->current_response,
			$response['id'],
			$response['name'],
			$postdata_decoded['response_type'],
			$postdata_decoded['show_asl_video'],
			$this->current_flow_attempt
		);
	}
	public function ajax_angular_load_returning_user_state() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'			 => 'success',
			'message'			 => '',
			'response'	 => array()
		);

		$postdata_string = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata_string, TRUE);

		if (!isset($postdata_decoded['current_response'])) {
			$postdata_decoded['current_response'] = 'null';
		}

		$user_state = $this->user_model->get_last_user_state($this->account_id, $this->org_id);

		/* Get Response from DB */
		if (!($response = $this->_data['response'] = $this->index_library->get_response($user_state['last_response']))) {
			/* If cookie does not exist, try WELCOME ID */
			if (!$this->session->userdata('last_rid')){
				$response = $this->_data['response'] = $this->index_library->get_response($this->property_model->get_welcome_response_id(MR_PROJECT, true, false));
			/* If cookie exists use cookie */
			}else{
				$response = $this->_data['response'] = $this->index_library->get_response($this->session->userdata('last_rid'));
			}
		}

		// Load left rail
		if (!($left_rail = $this->_data['left_rail'] = $this->index_library->get_left_rail_content(MR_PROJECT, $user_state['last_left_rail']))) {
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Error loading left rail from previous user state.';
			$this->_data['debug'] = 'Error loading left rail from returning user state.';
			echo json_encode($this->_data);
			return;
		}
		$this->_data['current_left_rail'] = $user_state['last_left_rail'];

		$this->_data['returning_user'] = 'false';

		echo json_encode($this->_data);
	}

	public function ajax_rate_response() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'			 => 'success',
			'message'			 => ''
		);
		$postdata_string = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata_string, TRUE);

		$this->log_model->insert_activity_log(
			"Rating",
			$postdata_decoded['input_question'],
			$postdata_decoded['input_question_disambiguated'],
			MR_CASE_NAME,
			$postdata_decoded['current_response'],
			$postdata_decoded['response_id'],
			$postdata_decoded['response_question'],
			$postdata_decoded['response_type'],
			$postdata_decoded['show_asl_video'],
			$this->current_flow_attempt
		);
		echo json_encode($this->_data);
	}

	public function download() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$directory = $this->uri->segment(3);
		$user_download_name = $this->uri->segment(4);
		$server_filename = $this->uri->segment(5);
		$server_file_path = FCPATH.$directory.'/'.$server_filename;

		// Download file to user's desktop
		if (file_exists($server_file_path))
		{
			// IE specific stuff
			if(ini_get('zlib.output_compression'))
			{
				ini_set('zlib.output_compression', 'Off');
			}

			// get the file mime
			$this->load->helper('file');
			$mime = get_mime_by_extension($server_file_path);

			// Build the headers
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($server_file_path)).' GMT');
			header('Cache-Control: private', false);
			header('Content-Type: '.$mime);
			header('Content-Disposition: attachment; filename="'.basename($user_download_name.'.pdf').'"');
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: '.filesize($server_file_path));
			header('Connection: close');
			readfile($server_file_path);

			// Delete file if it is in the tmp directory
			if ($directory === 'tmp' && MR_PROJECT !== 'dod')
			{
				$success = unlink($server_file_path);
				if (!$success)
				{
					log_message('error', 'DEV-ERROR: Not able to delete PDF file: ' . $server_file_path);
				}
			}

			exit();
		}
		else
		{
			log_message('error', 'DEV-ERROR: Could not find file to download in supportive care controller: '.$server_file_path);
			show_404($server_file_path, 'Exported PDF file not found.');
		}
	}

	public function ajax_angular_print_answers() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'			 => 'success',
			'message'			 => ''
		);

		$postdata_string = file_get_contents("php://input");
		$answers = json_decode($postdata_string, TRUE);

		$this->load->library('pdf_library');
		$pdf_filename = $this->pdf_library->print_answers($answers, $this->account_id);

		$this->_data['file'] = $pdf_filename;

		echo json_encode($this->_data);
	}

	public function ajax_angular_update_user_attr() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'		=> 'success',
			'message'		 => ''
		);

		$_POST['id'] = $this->account_id;
		$_POST['command'] = $this->input->post('command');
		$_POST['value'] = $this->input->post('value');

		if (!$this->user_model->update_user_attr($_POST['id'],$_POST['command'],$_POST['value'])){
			$this->_data['status'] = 'failure';
			$this->_data['message'] = 'Error updating user attributes';
			echo json_encode($this->_data);
			return;
		}

		$_POST = array();
		echo json_encode($this->_data);
		return;
	}

	public function index() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		/* Restrict Admins in this scenario to the DB only */
		if (!USER_AUTHENTICATION_REQUIRED && MR_HAS_SPEAKER && is_logged_in() && !is_anonymous_guest_user()) {
			redirect('admin');
		/* If there isn't a speaker, we want to log them out and redirect to login */
		} else if (MR_HAS_SPEAKER) {
			if (!$this->session->userdata('speaker')) {
				$this->session->unset_userdata('account_id');
				$this->session->unset_userdata('user_type');
				redirect('login');
			}
		}

		$project_title = $this->property_model->get_title(MR_PROJECT);

		$this->template_library
			->set_title($project_title)
			->set_module('Home')
			->set_using_angularjs(TRUE, 'userApp')
			->set_timeout_check_interval(60)
			->build('base/base_index', $this->_data, 'base/base_header', 'base/base_content');
	}

	private function get_next_left_rail_based_on_user_state($response) {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$left_rail_to_load = $response['left_rail']['id'];
		// Save user state if the user is signed in
		if (is_logged_in())
		{
			$user_state = $this->user_model->get_last_user_state($this->account_id, $this->org_id);

			// If the response dictates that the left rail changes to something not main,
			// change it and save it in the user state.
			// Otherwise, load the user's previous left rail state.
			if ($response['left_rail']['id'] != 'main')
			{
				$left_rail_to_save_in_user_state = $response['left_rail']['id'];
			}
			else
			{
				$left_rail_to_load = $user_state['last_left_rail'];
				$left_rail_to_save_in_user_state = FALSE;
			}

		}
		return $left_rail_to_load;
	}

	public function ajax_test_indexes() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$case_name = $this->input->post('case_name');
		$input_question = $this->input->post('input_question');
		$original_response = $this->input->post('original_response');

		$this->_data = $this->analyzer_library->analyze($input_question, $case_name);

		$this->_data->original_response = $original_response;


		echo json_encode($this->_data);
	}

	public function sitemap(){
		if (DYNAMIC_META_TAGS){
			echo 'arf';
		}else{
			show_404();
		}
	}


}

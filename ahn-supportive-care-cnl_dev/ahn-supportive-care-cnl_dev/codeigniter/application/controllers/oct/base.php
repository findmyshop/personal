<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends Base_Controller_Hybrid {

	public function __construct() {
		parent::__construct();
		$this->load->library('oct_library');
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

        // redirect from oct001 to oct003 automatically 4 seconds after the video plays
        if($this->_data['response']['id'] === 'oct001') {
            $this->_data['hard_redirect'] = '/#/NEXT/oct003';
            $this->_data['hard_redirect_timeout'] = 88000;
        }


		/* Make sure we have a response to begin with */
		if (!$this->_data["response"]){
			return;
		}

		$this->_data['response']['show_feedback_button'] = !$this->oct_library->session_feedback_logs_submitted();

		if (isset($this->_data["response"]['type'])){
			if ($this->_data["response"]['type'] == "test") {
				$this->_data['test'] = $this->oct_library->get_load_response_test_data($this->_data["response"]["id"]);
			}
		}

		/* When to remember a users place */
		if ($this->_data["action_type"] == ACTION_RELATED ||
				$this->_data["action_type"] == ACTION_LEFT_RAIL ||
				$this->_data["action_type"] == ACTION_Q ||
				$this->_data["response"]['id'] == 'offtopic' ||
				$this->_data["response"]['id'] == 'shame' ||
				$this->_data["response"]['id'] == 'multianswer'
				){
			$this->_data["response"]['ask_controls']['hidden'] = 'false';
			$this->_data["response"]['video_controls']['hidden'] = 'true';
			$this->_data["response"]['video_controls']['next_id'] = '';
			$this->_data["response"]['video_controls']['previous_id'] = '';
			$this->_data['returning_user'] = 'true';
			$this->skip_response_save = true;
		}

		/* Barf */
		echo json_encode($this->_data);
		$this->_is_hooked = false;
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

		if(!$this->oct_library->insert_feedback_log_item($postdata['test_key'], $postdata['answer'])) {
			$response = array(
				'status'	=> 'failure',
				'message'	=> 'Error submitting answer.'
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

		if(!$this->oct_library->insert_feedback_log_item($postdata['test_key'], $postdata['answer'])) {
			$response = array(
				'status'	=> 'failure',
				'message'	=> 'Error submitting answer.'
			);

			log_error(__FILE__, __LINE__, __METHOD__, 'Failed to insert test activity');
		}

		echo json_encode($response);
	}
}

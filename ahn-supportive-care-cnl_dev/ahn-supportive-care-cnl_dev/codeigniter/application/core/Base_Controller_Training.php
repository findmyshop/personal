<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base_Controller_Training extends Base_Controller
{
	protected $default_course = false;

	public function __construct() {
		parent::__construct();
		$this->load->model('braintree_transactions_model');
		$this->load->model('course_model');

		if($this->account_id) {
			if(!$this->default_course = $this->course_model->get_active_course($this->account_id)) {
					if(is_admin() || is_site_admin()) {
						redirect('admin/reports');
					} else {
						redirect('admin');
					}
			}
		}

		if(USER_PAYMENT_REQUIRED && !$this->braintree_transactions_model->user_paid_for_course($this->account_id, $this->default_course['course_id'])) {
			redirect('payments');
		}

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function ajax_get_current_course() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		echo json_encode(array("status" => "success", "message" => $this->course_model->get_active_course($this->account_id)));
	}

	public function ajax_complete_course() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'			 => 'success',
			'message'			 => 'Course updated.',
		);
		$this->_data['return_id'] = $this->default_course['after_certification'];
		$this->course_model->complete_active_course($this->account_id);
		redirect('admin/ajax_angular_default_course');
		return;
	}

	public function ajax_get_test() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$graded_questions = $this->course_model->get_active_test_graded_questions($user_test);
	}

	public function ajax_submit_test() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_data = array(
			'status'			 => 'info'
		);
		$slog_id = $this->log_model->get_last_log_id();
		$postdata_string = file_get_contents("php://input");
		$postdata_decoded = json_decode($postdata_string, TRUE);
		$answers = $postdata_decoded["data"];
		$test_key = $postdata_decoded["test"]["key"];
		$test_name = $postdata_decoded["test"]["test_name"];
		$course_element = $this->course_model->get_course_element_info($test_key);
		$course_iteration = $this->default_course['current_iteration'];

		$is_complete = true;
		/* Check that test is complete */
		if (isset($answers) && count($answers) > 0){
			foreach ($answers as $key => $value) {
				if ($key != 0 && $value == ''){
					$is_complete = false;
					$this->_data["first_blank_answer"] = $key;
					break;
				}
			}
		}else{
			$is_complete = false;
			$this->_data["first_blank_answer"] = 1;
		}

		if ($is_complete){
			$user_test = $this->course_model->initialize_user_test($this->account_id, $this->default_course['course_id'], $course_iteration, $test_key);

			if (!$user_test){
				echo json_encode(array("status" => "failure","message" => "User test does not exist."));
				return;
			}
			/* Populate user test answers */
			foreach ($answers as $key => $value) {
				$this->course_model->insert_user_test_activity($user_test, $key, $value, $slog_id);
			}

			/* Get Test Stats */
			$test_stats = $this->course_model->get_test_stats($this->account_id, $this->default_course, $user_test);


			/* Score Test Stats */
			$test_score = (int) (((float) $test_stats['correct_answers_submitted'] / (float) $test_stats['questions_answered']) * 100.0);
			$this->course_model->update_user_test($user_test['id'], 'score', $test_score);

			/* Get Test Stats */
			$test_stats = $this->course_model->get_test_stats($this->account_id, $this->default_course, $user_test);

			if ($test_stats['eligible_to_be_marked_passed'] > 0 || $test_stats["total_points"] < 1  ){
				$this->course_model->update_user_test($user_test['id'], 'has_passed', TRUE);

				if($test_key === 'dod_1hr_post_test_content' || $test_key === 'dod_3hr_post_test_content')
				{
					$this->course_model->update_user_course($this->default_course, 'has_passed', TRUE);
				}

			}else{
				$this->course_model->update_user_test($user_test['id'], 'has_passed', FALSE);
			}

			/* Mark test completed */
			if ($test_stats['eligible_to_be_marked_completed'] > 0 || $test_stats["total_points"] < 1 ){
				$this->course_model->update_user_test($user_test['id'], 'has_completed', TRUE);
			}

			$test_stats = $this->course_model->get_test_stats($this->account_id, $this->default_course, $user_test);
			$the_iteration = $this->course_model->get_next_user_test_iteration($this->account_id, $course_iteration, $user_test['id']);

			if (isset($test_score)){
				$test_stats['score'] = $test_score;
			}

			$this->_data["stats"] = $test_stats;

			$the_status = 'unlocked';
			/* Print Messages */
			if ($postdata_decoded["test"]["total_points"] > 0){
				if ($test_stats["eligible_to_be_marked_passed"] > 0){
					$this->_data["status"] = 'success';
					$the_status = 'passed';
				}else{
					$this->_data["status"] = 'warning';
					$the_status = 'failed';
				}
				$this->_data["tmessage"] = 'You have '.$the_status.' "'.$test_name.'" with a score of: '.$test_score.'%';
			}else{
				$tbe_status = 'passed';
				$this->_data["status"] = 'info';
				$this->_data["tmessage"] = 'Your answers have been submitted.';
			}
			/* This is so that skill practices that fall under a parent in the left rail get a check or X */
			$this->course_model->update_user_course_activity($this->account_id, $this->default_course, $test_key, $the_status ,$this->log_model->get_last_log_id());
			/* ToDo: Need a place here to tally whether or not all test within parent are passed or failed instead of relying
			 * on latest test submission for parent to inherit
			 */
			if ($course_element["parent"] > 0){
				$course_parent = $this->course_model->get_course_element_rid_by_id($course_element["parent"]);
				$this->course_model->update_user_course_activity($this->account_id, $this->default_course, $course_parent, $the_status ,$this->log_model->get_last_log_id());
			}
		}else{
			$this->_data["status"] = 'failure';
			$this->_data["message"] = 'Please fill out all questions before submitting your test.';
		}
		echo json_encode($this->_data);
		return;
	}
	/**
	 * We override the default ajax_angular_call_analyzer here.	 We do some stuff with it.
	 */
	public function ajax_angular_call_analyzer() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$this->_is_hooked = true;
		parent::ajax_angular_call_analyzer();
			/* After a user hits a MADIO / Skill Practice Response, look at the response that led them there.
			 * if they got a motivational, do some stuff, if not do some stuff. */
			$course_activity = $this->course_model->get_user_course_activity($this->account_id, $this->default_course, $this->current_response);
			$course_element = $this->course_model->get_course_element_info($this->current_response);
			$this->_data['course_element'] = $course_element;
			$this->_data['course_activity'] = $course_activity;
			/* I've decided that skill practices are ONLY MADIOS with this statement.
			 * If this ever changes, we'll have to check if the response is motivational etc */
			if ($course_element['is_skill_practice'] > 0 && $course_element['number_of_atttempts_allowed'] > 0){
				$course_activity['attempt']++;
				/* Write to DB */
				$the_status = 'unlocked';
				if ($this->_data["response"]["type"] == "motivational"){
					$the_status = 'passed';
				}else{
					$the_status = 'failed';
				}
				if ($course_activity['attempt'] >= $course_element['number_of_atttempts_allowed']){
					$the_status = $course_activity['status'];
					/* Skill practice logic */
					$this->_data['status'] = "success";
					$old_response = $this->index_library->get_response($this->current_response);
					$this->_data['madio_done'] = $old_response["video_controls"]["done_id"];
					//$this->_data['message'] = "You have attempted this skill practice ".$course_element['number_of_atttempts_allowed']." times which is the maximum allowed... Moving on to next section.";
				}
				/* Write to DB */
				$this->course_model->update_user_course_activity($this->account_id, $this->default_course, $this->current_response, $the_status ,$this->log_model->get_last_log_id(),$course_activity['attempt']);
				/* This is so that skill practices that fall under a parent in the left rail get a check or X */
				if ($course_element["parent"] > 0){
					$course_parent = $this->course_model->get_course_element_rid_by_id($course_element["parent"]);
					$this->course_model->update_user_course_activity($this->account_id, $this->default_course, $course_parent, $the_status ,$this->log_model->get_last_log_id());
				}
			}
		echo json_encode($this->_data);
		$this->_is_hooked = false;
	}
	/**
	 * We override the default load_response here.	We do some stuff with it.
	 */
	public function ajax_angular_load_response() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		/* We're going to hook the parent */
		$this->_is_hooked = true;
		parent::ajax_angular_load_response();
			/* Test */
			if (isset($this->_data["response"]['type'])){
				if ($this->_data["response"]['type'] == "test" || $this->_data["response"]['ask_controls']['action'] == "answer"){
					$course_iteration = $this->default_course['current_iteration'];
					/* Get test based on test response id */
					$the_test = $this->course_model->get_test($this->_data["response"]["id"]);
					$the_iteration = $this->course_model->get_next_user_test_iteration($this->account_id,$course_iteration,$the_test['id']);
					$the_questions = $this->course_model->get_test_answers($this->account_id,$course_iteration,$the_test['id'], $the_iteration-1);
					$this->_data["test"] = $the_test;

					if ($the_iteration > 1){
						$user_test = array('test_id' => $the_test['id'], 'current_iteration' => $the_iteration-1);
						$test_stats = $this->course_model->get_test_stats($this->account_id, $this->default_course, $user_test);
						$this->_data["test"]["stats"] = $test_stats;
						$this->_data["test"]["stats"]['score'] = (int) (((float) $test_stats['correct_answers_submitted'] / (float) $test_stats['questions_answered']) * 100.0);
					}
					$this->_data["test"]["stats"]["iteration"] = $the_iteration;

					/* Grab answers from schemes table
					 * ToDo: This loop should really be harnessed by SQL in course_model
					 * Instead of PHP with a Join or some shit.
					 */
					foreach ($the_questions as &$questions){
						$the_choices = $this->course_model->get_element_scheme($questions["scheme"]);
						$questions["choices"] = $the_choices;
					}
					$this->_data["test"]["questions"] = $the_questions;
				}
			}
			/* Test Skipper 3000
			 * This loops through and skips tests that have already been visited that are
			 * Not required and not worth any points.
			 */
			if (isset($this->_data["response"]['video_controls']['next_id'])){
				/* Is there a next ID with a type of test? */
				do {
					$next_changed = false;
					$next_response = $this->index_library->get_response($this->_data["response"]['video_controls']['next_id']);
					if (isset($next_response["type"])){
						if ($next_response["type"] == "test"){
							$nr_course_activity = $this->course_model->get_user_course_activity($this->account_id, $this->default_course,$next_response["id"]);
							if ($nr_course_activity != false){
								if ($nr_course_activity["status"] != 'locked'){
									$the_test = $this->course_model->get_test($next_response["id"]);
									/* We only want to skip over tests that are NOT required and are NOT worth any points. (Surveys) */
									if (isset($the_test["required"]) && isset($the_test['total_points'])){
										if ($the_test["required"] == 0 && $the_test["total_points"] == 0){
											if (isset($next_response['video_controls']['next_id'])){
												$this->_data["response"]['video_controls']['next_id'] = $next_response['video_controls']['next_id'];
												$next_changed = true;
												if ($this->_data["response"]['video_controls']['next_id'] == $this->default_course['url']){
													//$this->_data['hard_redirect'] = '/admin';
												}
											}
										}
									}
								}
							}
						}
					}//if
				} while ($next_changed == true);
			}
			$course_activity = $this->course_model->get_user_course_activity($this->account_id, $this->default_course,$this->_data["response"]['id']);
			$course_element = $this->course_model->get_course_element_info($this->_data["response"]['id']);
			$this->_data["course"] = $this->default_course;
			$this->_data["course"]["stats"] = $this->course_model->get_course_stats($this->default_course);
			/* Disable responses not in current course
			 * but allow MADIOs to come through (Madios are not in the master_course_elements table)
			 */
			if ($this->course_model->get_course_id($this->_data["response"]['id']) == $this->default_course['course_id'] ||
					($this->_data["response"]['type'] == "motivational" ||
					 $this->_data["response"]['type'] == "ineffectual" ||
					 $this->_data["response"]['type'] == "accusatory" ||
					 $this->_data["response"]['type'] == "directive" ||
					 $this->_data["response"]['type'] == "offtopic" ||
					 $this->_data["response"]['type'] == "custom" ||
					 $this->_data["response"]['type'] == "model"
					 )
			){

			}else{
				$this->_data["status"] = "failure";
				$this->_data["message"] = "'".$this->_data["response"]['id']."' is not part of '".$this->default_course["course_name"].".'";
				echo json_encode($this->_data);
				return;
			}

			/* If response does not exist in user activity */
			if ($course_activity == false){
				/* ToDo: Need a smarter method for unlocking a course
				 * than simply relying on NEXT and A types
				 */
				if ($this->_data["action_type"] != ACTION_LEFT_RAIL) {
					$this->course_model->update_user_course_activity($this->account_id, $this->default_course, $this->_data["response"]['id'], 'unlocked',$this->log_model->get_last_log_id());
				}else{
					/* Add the entry, lock it. */
					$this->course_model->update_user_course_activity($this->account_id, $this->default_course, $this->_data["response"]['id'], 'locked',$this->log_model->get_last_log_id());
					$this->_data["status"] = "warning";
					$this->_data["message"] = "This module has not been unlocked yet. (Modules must be completed in sequence.)";
					echo json_encode($this->_data);
					return;
				}
			/* Okay, it exists */
			} else {
				if ($course_activity["status"] == "locked"){
					/* ToDo: Need a smarter method for unlocking a course
					 * than simply relying on NEXT and A types
					 */
					if ($this->_data["action_type"] != ACTION_LEFT_RAIL) {
						$this->course_model->update_user_course_activity($this->account_id, $this->default_course, $this->_data["response"]['id'], 'unlocked',$this->log_model->get_last_log_id());
					}else{
						$this->_data["status"] = "warning";
						$this->_data["message"] = "This module has not been unlocked yet. (Modules must be completed in sequence.)";
						echo json_encode($this->_data);
						return;
					}
				}
			}

			/* Before Certification */
			/* Until told otherwise, certificate issuing will be done on the User Dashboard
			if ($this->current_response == $this->default_course['before_certification'] && $this->_data["action_type"] == ACTION_NEXT){
				if(empty($this->default_course['certificate_page_accepted']) && $this->_data["course"]["stats"]["ready_pass"] > 0){
					$this->_data['hard_redirect'] = "/certification";
					$this->user_model->update_last_user_state($this->account_id, $this->org_id, $this->_data['response']['id'], 'main');
				}
			}
			*/

			/* Was the previous element the last element of the course? */
			if (($this->current_response == $this->default_course['last_rid'] ||	$this->_data["response"]["id"] == $this->default_course['url']) && $this->_data["action_type"] == ACTION_NEXT && $this->current_response != $this->default_course['after_disclaimer']){
					$this->_data['hard_redirect'] = "/admin";
					/* Set last ID to first */
					$this->user_model->update_last_user_state($this->account_id, $this->org_id, $this->default_course['url'], 'main');
			}
			/* For SBIRTS, video-text becomes a little popup above the input field */
			if ($this->_data["response"]["video_text"]){
				$this->_data["response"]["popup"] = $this->_data["response"]["video_text"];
			}

			/* ToDo: Something needs to hook logging here so that locked responses are flagged
			 * in the parent controller. (logging)
			 */
			if ((is_logged_in()) &&
					($this->_data['returning_user'] == 'false') &&
					($this->skip_response_save == false)) {
				$this->user_model->update_last_user_state($this->account_id, $this->org_id, $this->initial_response, 'main');
			}
			/* Get all user activity */
			$uc = $this->course_model->get_user_course_activity($this->account_id, $this->default_course);
			//$this->_data["uc"] = $uc;
			/* Look through rail */
			foreach ($this->_data["left_rail"] as &$rail) {
				foreach ($rail["responses"] as &$g){
					foreach ($g as &$r){
						$r["status"] = 'locked';
						/* Lock is the default unless we
						 * find a matching r_id in the user_courses
						 */
						foreach ($uc as &$c){
							if ($r["id"] == $c["response_id"]){
								$r["status"] = $c["status"];
							}
						}
					}
				}
			}
			echo json_encode($this->_data);
			$this->_is_hooked = false;
	}

}
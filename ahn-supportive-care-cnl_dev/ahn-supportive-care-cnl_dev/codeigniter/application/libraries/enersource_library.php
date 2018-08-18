<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ugly-ass library for a poorly planned project
// you've been warned
class Enersource_library {

	public $ci = NULL;
	public $account_id = NULL;

	private $_enersource_course_id = NULL;

	public function __construct() {
		$this->ci =& get_instance();

		$this->account_id = $this->ci->session->userdata('account_id');
		$this->_enersource_course_id = $this->_get_enersource_course_id();

		if($this->_enersource_course_id === NULL) {
			show_error('Enersource contest not set in the database');
		}

		$this->ci->load->model('course_model');
		$this->ci->load->model('user_model');
		$this->ci->load->model('user_experience_state_map_model');

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function get_user($user_id) {
		$query = $this->ci->db
			->where('id', $user_id)
			->limit(1)
			->get('master_users');

		if($query->num_rows() > 0) {
			return $query->row_array();
		}

		return array();
	}

	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// user related functions
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function get_users($requester_user_type = 'admin', $organization_id = FALSE, $search = FALSE, $organization_hierarchy_level_elements_filter = array()) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$requester_user_type = $this->ci->db->escape_str($requester_user_type);
		$organization_id = $this->ci->db->escape_str($organization_id);

		if ($requester_user_type == 'admin') {
			$where_user_type = "";
		} elseif($requester_user_type == 'site_admin') {
			$where_user_type = "\n\t\t\t\t\t\t\t\tAND master_user_types.type_name!='admin'\n";
		} elseif($requester_user_type == 'instructor') {
			$where_user_type = "\n\t\t\t\t\t\t\t\tAND master_user_types.type_name!='admin' AND master_user_types.type_name!='site_admin'\n";
		} else {
			$where_user_type = "\n\t\t\t\t\t\t\t\tAND master_user_types.type_name!='admin' AND master_user_types.type_name!='site_admin' AND master_user_types.type_name!='instructor'\n";
		}

		if($search) {
			$where_search = "\n\t\t\t\t\t\t\t\tAND (master_users.first_name LIKE '%" . $search . "%' OR master_users.last_name LIKE '%" . $search . "%' OR master_users.username LIKE '%" . $search . "%')";
		} else {
			$where_search = "";
		}

		if(is_admin() && !empty($organization_id) && ($organization_id == 1)) {
			$where_organization = "";
		} elseif (!empty($organization_id)){
			$where_organization = "\n\t\t\t\t\t\t\t\tAND master_organizations.id='$organization_id'\n";
		} else {
			$where_organization = "";
		}

		$where_organization_hierarchy = 'AND 1 = 1';

		if(!empty($organization_hierarchy_level_elements_filter)) {
			foreach($organization_hierarchy_level_elements_filter as $element_id) {
				if(is_numeric($element_id) && $element_id > 0) {
					$where_organization_hierarchy .= "
						AND EXISTS (
							SELECT *
							FROM master_users_organization_hierarchy_level_element_map AS muohlem
							WHERE
								muohlem.user_id = master_users.id
								AND muohlem.organization_hierarchy_level_element_id = $element_id
								AND muohlem.active = 1
						)
					";
				}
			}
		}

		$stmt = "
			SELECT		master_users.id,
						master_users.first_name,
						master_users.last_name,
						master_users.username,
						master_users.email,
						-- master_users.phone,
						-- master_users.address_line_1,
						-- master_users.address_line_2,
						-- master_users.municipality,
						-- master_users.province_id,
						master_users.postal_code as postal_code,
						master_users.customer_number,
						master_users.is_customer,
						master_users.customer_type,
						master_users.entered_contest,
						master_user_types.id as user_type_id,
						master_user_types.type_name as user_type_name,
						master_users.login_enabled as login_enabled,
						master_organizations.id as organization_id,
						master_organizations.name as organization_name
			FROM		master_users
						JOIN	master_user_types
									ON
									master_user_types.id=master_users.user_type_id
									AND
									master_user_types.active=1
						$where_user_type
						LEFT JOIN	 master_users_map
									ON
									master_users_map.user_id=master_users.id
									AND
									master_users_map.active=1
						LEFT JOIN	 master_organizations
									ON
									master_organizations.id=master_users_map.organization_id
									AND
									master_organizations.active=1
			WHERE		 master_users.active=1
			$where_organization
			$where_search
			$where_organization_hierarchy
			ORDER BY	master_organizations.name ASC, username ASC
		";

		$query = $this->ci->db->query($stmt);

		if($query->num_rows() < 1) {
			return array();
		}

		return $query->result_array();
	}

	public function get_provinces() {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$query = $this->ci->db
			->select('id, abbreviation, name')
			->from('master_provinces')
			->order_by('name', 'asc')
			->get();

		return $query->result_array();
	}

	public function insert_user(
		$first_name,
		$last_name,
		$organization_id,
		$user_type_id,
		$email,
		$phone,
		$address_line_1,
		$address_line_2,
		$municipality,
		$province_id,
		$postal_code,
		$customer_number,
		$is_customer,
		$customer_type,
		$login_enabled,
		$password = NULL
	) {

		$username = $email;

		log_debug(__FILE__, __LINE__, __METHOD__, 'Called username = ' . $username);

		if(strcasecmp($username, ANONYMOUS_GUEST_USERNAME) === 0) {
				return FALSE;
			}
			$data = array(
				'first_name'			=> $first_name,
				'last_name'				=> $last_name,
				'username'				=> $username,
				'user_type_id'		=> $user_type_id,
				'email'						=> $email,
				'phone'						=> $phone,
				'address_line_1'	=> $address_line_1,
				'address_line_2'	=> $address_line_2,
				'municipality'		=> $municipality,
				'province_id'			=> $province_id,
				'postal_code'			=> $postal_code,
				'customer_number'	=> $customer_number,
				'is_customer'			=> $is_customer,
				'customer_type'		=> $customer_type,
				'password'				=> empty($password) ? '' : md5($password),
				'login_enabled'		=> $login_enabled,
				'created_date'		=> date('Y-m-d H:i:s'),
				'created_by'			=> $this->account_id
			);

			$this->ci->db->insert('master_users', $data);
			$user_id = $this->ci->db->insert_id();
			$this->ci->user_model->insert_user_map($user_id, $organization_id);

			// initialize course and experience state for users
			if($user_type_id == 4) {
				$this->ci->course_model->insert_user_course($user_id, 1);
				$this->ci->user_experience_state_map_model->insert($user_id);
			}

			return $user_id;
	}

	public function is_customer($user_id) {
		if(!$user = $this->get_user($user_id)) {
			return FALSE;
		}

		return $user['is_customer'] ? TRUE : FALSE;
	}

	public function update_user(
		$user_id,
		$first_name,
		$last_name,
		$organization_id,
		$phone,
		$address_line_1,
		$address_line_2,
		$municipality,
		$province_id,
		$postal_code,
		$customer_number,
		$is_customer,
		$customer_type,
		$entered_contest,
		$login_enabled,
		$password = NULL
	)
	{
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called user_id = ' . $user_id);

		$user = $this->ci->user_model->get_user($user_id);

		if(empty($user)) {
			return FALSE;
		}

		if(empty($organization_id)) {
			return FALSE;
		}

		$this->ci->user_model->update_user_organization_map($user_id, $organization_id);

		$data = array(
				'first_name'					=> $first_name,
				'last_name'						=> $last_name,
				'customer_number'			=> $customer_number,
				'phone'								=> $phone,
				'address_line_1'			=> $address_line_1,
				'address_line_2'			=> $address_line_2,
				'municipality'				=> $municipality,
				'province_id'					=> $province_id,
				'postal_code'					=> $postal_code,
				'customer_number'			=> $customer_number,
				'is_customer'					=> $is_customer,
				'customer_type'				=> $customer_type,
				'entered_contest'			=> $entered_contest,
				'login_enabled'				=> $login_enabled,
				'last_modified_date'	=> date('Y-m-d H:i:s')
		);

		if (!empty($password)) {
			$data['password'] = md5($password);
		}

		$where = array('id' => $user_id);

		$this->ci->db->where($where)->update('master_users', $data);
		return TRUE;
	}
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// end - user related functions
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// flow related functions
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function user_has_completed_optional_sections($user_id) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called user_id = ' . $user_id);

		//-------------------------------------------------------------
		// DONE Response IDs for the three optional Enersource sections
		// Environment Responsibility - enr0468
		// Affordability - enr0563
		// Safety - enr0701
		//-------------------------------------------------------------

		$user_id = $this->ci->db->escape_str($user_id);

		$sql = "
			SELECT EXISTS (
				SELECT
					id
				FROM master_activity_logs
				WHERE
					user_id = $user_id
					AND response_id = 'enr0468'
					AND action = '".ACTION_DONE."'
			) AND EXISTS (
				SELECT
					id
				FROM master_activity_logs
				WHERE
					user_id = $user_id
					AND response_id = 'enr0563'
					AND action = '".ACTION_DONE."'
			) AND EXISTS (
				SELECT
					id
				FROM master_activity_logs
				WHERE
					user_id = $user_id
					AND response_id = 'enr0603'
					AND action = '".ACTION_DONE."'
			) AS user_has_completed_optional_sections
		";

		$query = $this->ci->db->query($sql);
		$result = $query->row_array();

		return ($result['user_has_completed_optional_sections'] == 1) ? TRUE : FALSE;
	}

	/**
	 * Determines whether a user has completed the 4 required sections below
	 *
	 * Reliability
	 * System Service and System Access Questions
	 * System Renewal Questions
	 * General Plant Questions
	 *
	 * @param  int $user_id - id of the user in question
	 * @return array - array containing keys indicating whether or not each section was completed
	 */
	public function user_progress($user_id) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called user_id = ' . $user_id);

		$completed = array(
			'reliability_section'		=> FALSE,
			'service_questions'			=> FALSE,
			'renewal_questions'			=> FALSE,
			'plant_questions'				=> FALSE,
			'value_benefits'				=> FALSE
		);

		$user_experience_state = $this->ci->user_experience_state_map_model->get_by_user($user_id);

		/* experience states
				'INITIALIZED',
				'RELIABILITY_COMPLETED',
				'TEST_IN_PROGRESS',
				'TEST_COMPLETED'
		*/

		if($user_experience_state !== 'INITIALIZED') {
			$completed['reliability_section'] = TRUE;

			if($user_experience_state === 'TEST_COMPLETED') {
				$completed['service_questions'] = TRUE;
				$completed['renewal_questions'] = TRUE;
				$completed['plant_questions'] = TRUE;
				$completed['value_benefits'] = TRUE;
			} else if($user_experience_state === 'TEST_IN_PROGRESS') {
				$user_id = $this->ci->db->escape_str($user_id);

				$sql = "
					SELECT (
					-- System Service and System Access Section
						-- Question 1
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr0806' AND mut.user_id = $user_id) AND
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr0807' AND mut.user_id = $user_id) AND
						-- Question 2
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr0808' AND mut.user_id = $user_id) AND
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr0809' AND mut.user_id = $user_id) AND
						-- Question 3
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr0810' AND mut.user_id = $user_id)
					) AS service_questions_completed, (
					-- System Renewal Section
						-- Question 4
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr0914' AND mut.user_id = $user_id) AND
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr0915' AND mut.user_id = $user_id) AND
						-- Question 5
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr0916' AND mut.user_id = $user_id) AND
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr0917' AND mut.user_id = $user_id) AND
						-- Question 6
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr0918' AND mut.user_id = $user_id)
					) AS renewal_questions_completed, (
					-- General Plant Section
						-- Question 7
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr1022' AND mut.user_id = $user_id) AND
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr1023' AND mut.user_id = $user_id) AND
						-- Question 8
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr1024' AND mut.user_id = $user_id) AND
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr1025' AND mut.user_id = $user_id) AND
						-- Question 9
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr1026' AND mut.user_id = $user_id)
					) AS plant_questions_completed, (
					-- Value Benefits Section
						-- Question 10
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr1132' AND mut.user_id = $user_id) AND
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr1304' AND mut.user_id = $user_id) AND
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr1305' AND mut.user_id = $user_id) AND
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr1306' AND mut.user_id = $user_id) AND
						-- Question 11
						EXISTS (SELECT mt.id FROM master_tests AS mt JOIN master_user_tests AS mut ON mut.test_id = mt.id WHERE mt.key = 'enr1307' AND mut.user_id = $user_id)
					) AS value_benefits_completed;
				";

				$query = $this->ci->db->query($sql);
				$result = $query->row_array();

				$completed['service_questions'] = ($result['service_questions_completed']) ? TRUE : FALSE;
				$completed['renewal_questions'] = ($result['renewal_questions_completed']) ? TRUE : FALSE;
				$completed['plant_questions'] = ($result['plant_questions_completed']) ? TRUE : FALSE;
				$completed['value_benefits'] = ($result['value_benefits_completed']) ? TRUE : FALSE;
			}
		}

		return $completed;
	}

	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// end - test related functions
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	// test related functions
	//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	public function complete_user_course($user_id) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called user_id = ' . $user_id);

		$this->ci->db
			->where(array(
				'user_id'		=> $user_id,
				'course_id'	=> 1
			))
			->update('master_user_courses', array(
				'has_completed'		=> 1,
				'has_passed'			=> 1,
				'date_completed'	=> date('y-m-d H:i:s')
			));
	}

	public function get_load_response_test_data($response_id) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called response_id = ' . $response_id);

		$data = array();

		$test = $this->ci->course_model->get_test($response_id);
		$questions = $this->ci->course_model->get_test_answers(0, 1, $test['id'], 1);
		$data = $test;

		foreach ($questions as &$row){
			$choices = $this->ci->course_model->get_element_scheme($row['scheme']);
			$row['choices'] = $choices;
		}

		$data['questions'] = $questions;

		$data['previous_question_answer'] = NULL;

		$why_do_you_say_that_previous_question_response_ids = array(
			'enr0808' => 'enr0807',
			'enr0810' => 'enr0809',
			'enr0916' => 'enr0915',
			'enr0918' => 'enr0917',
			'enr1024' => 'enr1023',
			'enr1026' => 'enr1025',
			'enr1305' => 'enr1304',
			'enr1307' => 'enr1306'
		);

		if(isset($why_do_you_say_that_previous_question_response_ids[$response_id])) {
			$data['previous_question_answer'] = $this->get_user_question_answer($this->account_id, $why_do_you_say_that_previous_question_response_ids[$response_id]);
		}

		return $data;
	}

	public function get_user_course_activity($user_id, $response_id = FALSE) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called user_id = ' . $user_id . ' | response_id = ' . $response_id);

		$return_value = array();
		$return_mode = 'result_array';
		$where = array(
			'user_id'		=> $user_id,
		);

		if($response_id !== FALSE) {
			$where['response_id'] = $response_id;
			$return_value = FALSE;
			$return_mode = 'row_array';
		}

		$query = $this->ci->db->where($where)->get('master_user_course_activity');

		if($query->num_rows() < 1) {
			return $return_value;
		}	else {
			return $query->{$return_mode}();
		}
	}

	public function get_user_question_answer($user_id, $response_id) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called user_id = ' . $user_id . ' | response_id = ' . $response_id);

		$user_id = $this->ci->db->escape_str($user_id);
		$response_id = $this->ci->db->escape_str($response_id);

		$sql = "
			SELECT
				IFNULL(mtes.text, muta.answer) answer
			FROM master_user_test_activity AS muta
			JOIN master_activity_logs AS mal
				ON mal.id = muta.activity_log_id
			JOIN master_test_elements AS mte
				ON mte.id = muta.test_element_id
			LEFT JOIN master_test_elements_schemes AS mtes
				ON mtes.scheme_id = mte.scheme AND mtes.answer = muta.answer
			JOIN master_tests AS mt
				ON mt.id = mte.test_id
			WHERE
				muta.user_id = '$user_id'
				AND mt.key = '$response_id'
			LIMIT 1
			";

		$query = $this->ci->db->query($sql);

		if($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result['answer'];
		}

		return NULL;
	}

	public function update_user_course_activity($user_id, $response_id, $status) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called user_id = ' . $user_id . ' | response_id = ' . $response_id . ' | status = ' . $status);

		if(($activity_log_id = $this->ci->log_model->get_last_log_id($user_id)) === NULL) {
			return FALSE;
		}

		$data = array(
				'user_id'					=> $user_id,
				'course_id'				=> 1,
				'response_id'			=> $response_id,
				'status'					=> $status,
				'activity_log_id'	=> $activity_log_id,
				'attempt'					=> 1
		);

		$user_course_activity = $this->get_user_course_activity($user_id, $response_id);

		if(!empty($user_course_activity)) {
			$this->ci->db->where(array('id' => $user_course_activity['id']))->update('master_user_course_activity', $data);
		} else {
			$this->ci->db->insert('master_user_course_activity', $data);
			$user_course_activity_id = $this->ci->db->insert_id();
		}
	}

	public function insert_user_test_activity($user_id, $test_key, $answer) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called user_id = ' . $user_id . ' | test_key = ' . $test_key . ' | answer = ' . $answer);


		// make sure that $test_key references a valid test
		if(($test = ($this->ci->course_model->get_test($test_key))) === FALSE) {
			return FALSE;
		}

		// make sure that a question exists for this test
		if(($test_element = $this->ci->course_model->get_test_element($test['id'], 0)) === FALSE) {
			return FALSE;
		}

		// retrieve the master_activity_log entry to associate with this submission
		if(($activity_log_id = $this->ci->log_model->get_last_log_id($user_id)) === NULL) {
			return FALSE;
		}

		if(empty($answer)) {
			$answer = NULL;
		}

		$master_user_test_activity_data = array(
			'user_id'						=> $user_id,
			'course_iteration'	=> 1,
			'test_element_id'		=> $test_element['id'],
			'iteration'					=> 1,
			'answer'						=> $answer,
			'activity_log_id'		=> $activity_log_id
		);

		// see if this user has already submitted this test.  if they have, update the existing record.  otherwise insert a new one
		if($this->ci->course_model->get_user_test($user_id, 1, $test['id'])) {
			$where = array(
				'user_id'					=> $user_id,
				'test_element_id'	=> $test_element['id']
			);

			$this->ci->db
				->where(array(
					'user_id'					=> $user_id,
					'test_element_id'	=> $test_element['id']
				))
				->update('master_user_test_activity', $master_user_test_activity_data);
		} else {
				$master_user_tests_data =	 array(
					'user_id'						=> $user_id,
					'course_iteration'	=> 1,
					'test_id'						=> $test['id'],
					'current_iteration'	=> 1,
					'score'							=> 0,
					'has_completed'			=> 1,
					'has_passed'				=> 1,
					'date_completed'		=> date('Y-m-d H:i:s')
				);

				$this->ci->db->insert('master_user_tests', $master_user_tests_data);
				$this->ci->db->insert('master_user_test_activity', $master_user_test_activity_data);
		}

		return TRUE;
	}

	public function get_survey_logs($limit = 1000, $offset = 0) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called limit = ' . $limit . ' | offset = ' . $offset);

		if(!is_numeric($limit) || !is_numeric($offset)) {
			return FALSE;
		}

		$sql = "
			SELECT
				mal.id AS activity_log_id,
				mu.id AS user_id,
				mu.customer_number,
				IF(mu.is_customer = 1, 'Yes', 'No') AS is_customer,
				mu.customer_type,
				IF(mu.entered_contest = 1, 'Yes', 'No') AS entered_contest,
				mu.first_name,
				mu.last_name,
				mu.email AS email_address,
				-- mu.phone AS phone_number,
				-- mu.address_line_1,
				-- mu.address_line_2,
				-- mu.municipality,
				-- mp.abbreviation AS province,
				mu.postal_code,
				mt.key AS response_id,
				mte.question,
				IFNULL(mtes.text, muta.answer) answer,
				mal.date AS date
			FROM master_users AS mu
			LEFT JOIN master_provinces AS mp
				ON mp.id = mu.province_id
			JOIN master_user_test_activity AS muta
				ON muta.user_id = mu.id
			JOIN master_activity_logs AS mal
				ON mal.id = muta.activity_log_id
			JOIN master_test_elements AS mte
				ON mte.id = muta.test_element_id
			LEFT JOIN master_test_elements_schemes AS mtes
				ON mtes.scheme_id = mte.scheme AND mtes.answer = muta.answer
			JOIN master_tests AS mt
				ON mt.id = mte.test_id
			ORDER by mal.date DESC
			LIMIT $limit
			OFFSET $offset
		";

		$query = $this->ci->db->query($sql);

		if($query->num_rows() > 0) {
			return $query;
		}

		return NULL;
	}

	public function write_survey_logs_to_csv($fully_qualified_filename, $chunk_size = 1000) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called fully_qualified_filename = ' . $fully_qualified_filename . ' chunk_size= ' . $chunk_size);

		$offset = 0;

		if(!$query = $this->get_survey_logs($chunk_size, $offset)) {
			return FALSE;
		}

		$this->ci->load->library('csv_library');

		if(!$this->ci->csv_library->write_query_result_to_csv_file($query, $fully_qualified_filename, TRUE)) {
			throw new Exception('Failed to Write CSV to File');
		}

		$offset += $chunk_size;

		while($query = $this->get_survey_logs($chunk_size, $offset)) {
			if(!$this->ci->csv_library->write_query_result_to_csv_file($query, $fully_qualified_filename, FALSE)) {
				throw new Exception('Failed to Write CSV to File');
			}
			$offset += $chunk_size;
		}

		return TRUE;
	}

	private function _get_enersource_course_id() {
		$query = $this->ci->db
			->select('id')
			->from('master_courses')
			->where('course_name', 'Enersource Contest')
			->limit(1)
			->get();

		if($query->num_rows() === 1) {
			$row = $query->row_array();
			return $row['id'];
		}

		return NULL;
	}
}

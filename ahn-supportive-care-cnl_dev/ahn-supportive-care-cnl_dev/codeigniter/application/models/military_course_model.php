<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Military_course_model extends CI_Model {
	private $account_id = false;
	private $user_type = false;
	private $current_datetime = FALSE;

	public function __construct() {
		parent::__construct();
		$this->account_id = $this->session->userdata('account_id');
		$this->user_type = $this->session->userdata('user_type');
		$this->current_datetime = date('Y-m-d H:i:s', now());

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function accept_certificate($user_id, $course_id, $accreditation_type_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = $course_id | $accreditation_type_id = $accreditation_type_id");

		$where = array(
				'user_id'														=> $user_id,
				'course_id'													=> $course_id,
				'accreditation_type_id'							=> $accreditation_type_id,
				'certificate_page_accepted'					=> 0,
				'date_certificate_page_accepted'		=> NULL,
				'certificate_accepted_by_user'			=> 0,
				'date_certificate_accepted_by_user'	=> NULL
		);
		$data = array(
				'certificate_page_accepted'      => 1,
				'date_certificate_page_accepted' => date('Y-m-d H:i:s', now())
		);

		/// only set if student is seeking accreditation
		if ($accreditation_type_id != 5)
		{
			$data['certificate_accepted_by_user']      = 1;
			$data['date_certificate_accepted_by_user'] = date('Y-m-d H:i:s', now());
		}

		$this->db->where($where)->update('master_user_certificates', $data);
	}

	public function accept_disclaimer($user_id, $accreditation_type_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | $accreditation_type_id = $accreditation_type_id");

		$where = array(
			'user_id'				=> $user_id,
			'accreditation_type_id' => $accreditation_type_id
		);

		$data = array(
			'disclaimer_accepted'		=> 1,
			'date_disclaimer_accepted'	=> date('Y-m-d H:i:s')
		);

		$this->db->where($where)->update('master_user_accreditation_map', $data);
	}

	public function activate_course($user_id, $course_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = $course_id");

		// deactive current course if it exists
		if ($currently_active_course = $this->get_active_course($user_id))
		{
			$this->deactivate_course($user_id, $currently_active_course['course_id']);
		}

		// see if we have an inactive, incompleted instance of the course
		$where = array(
			'user_id'				=> $user_id,
			'course_id'			=> $course_id,
			'has_completed'	=> 0,
			'active'				=> 0
		);

		$query = $this->db->where($where)->get('master_user_courses');

		// activate it and return
		if ($query->num_rows() > 0)
		{
			$user_course = $query->row_array();
			$user_course['active'] = 1;
			unset($where['active']);
			$this->db->where($where)->update('master_user_courses', array('active' => 1));
			return $user_course;
		}

		// create a new activation
		$next_iteration = $this->get_next_user_course_iteration($user_id, $course_id);
		$course = $this->get_course($course_id);
		$user_course = array(
			'course_id'			=> $course_id,
			'user_id'			=> $user_id,
			'current_iteration' => $next_iteration,
			'date_registered' => $this->current_datetime
		);

		if (!$this->db->insert('master_user_courses', $user_course))
		{
			return FALSE;
		}

		$query = $this->db->where(array('id' => $this->db->insert_id()))->get('master_user_courses');

		if ($query->num_rows() < 1)
		{
			return FALSE;
		}

		$this->initialize_user_certificate($user_id);

		return $query->row_array();
	}

	public function complete_active_course($user_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

		if(($course = $this->get_active_course($user_id)) === FALSE)
		{
			return FALSE;
		}

		$course_stats = $this->get_course_stats($course);
		$has_passed = 0;

		if ($course_stats['ready_pass'] > 0) {
			$has_passed = 1;
		}

		if ($course_stats['ready_complete'] > 0) {
			$sql = "
				UPDATE master_user_courses
				JOIN master_courses
					ON master_courses.id = master_user_courses.course_id
				SET
					master_user_courses.has_passed = $has_passed,
					master_user_courses.has_completed = 1,
					master_user_courses.date_completed = NOW(),
					master_user_courses.total_sections_visited = master_courses.total_sections,
					master_user_courses.total_tests_surveys_visited = master_courses.total_tests_surveys,
					master_user_courses.percent_complete = 100.00,
					master_user_courses.active = 0
				WHERE
					master_user_courses.user_id = $user_id
					AND master_user_courses.course_id = {$course['course_id']}
					AND master_user_courses.current_iteration = {$course['current_iteration']}
					AND master_user_courses.active = 1
			";

			$this->db->query($sql);
			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		}

		return FALSE;
	}

	public function deactivate_course($user_id, $course_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = $course_id");

		$where = array(
			'user_id'		=> $user_id,
			'course_id'	=> $course_id,
			'active'		=> 1
		);

		$this->db->where($where)->update('master_user_courses', array('active' => 0));
	}

	public function get_accreditation_report($accreditation_type_id, $start_date = NULL, $end_date = NULL, $limit = NULL, $offset = NULL, $return_query_object = TRUE)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with accreditation_type_id = $accreditation_type_id");

		if(!is_numeric($accreditation_type_id))
		{
			return array();
		}

		$accreditation_type_id = $this->db->escape_str($accreditation_type_id);
		$search_where_test_date_string = "AND 1 = 1";

		if(!empty($start_date) && !empty($end_date))
		{
			$start_datetime = date('Y-m-d H:i:s', strtotime($this->db->escape_str($start_date)));
			$end_datetime = date('Y-m-d H:i:s', strtotime($this->db->escape_str($end_date)) + 24 * 60 * 60);
			$search_where_test_date_string = "AND mut.date_completed BETWEEN '$start_datetime' AND '$end_datetime'";
		}

		$sql = "
			SELECT
				muc.user_id AS `User ID`,
				mu.first_name AS `First Name`,
				mu.middle_initial AS `Middle Initial`,
				mu.last_name AS `Last Name`,
				mr.role_name AS `Role`,
				ma.address_1 AS `Address 1`,
				ma.address_2 AS `Address 2`,
				ma.city AS `City`,
				ma.province AS `Province`,
				ms.abbreviation AS `State`,
				ma.zip AS `Zip`,
				mco.name AS `Country`,
				mu.email AS Email,
				mc.course_name AS `Course Name`,
				IF(mc.course_name = 'AlcoholSBIRT 1 Hour', '1', '3') AS `Credit Hours`,
				mut.date_completed AS `Test Date`,
				IF(mucert.certificate_page_accepted OR mucert.certificate_accepted_by_user, 'Yes', 'No') AS `Certificate Printed`,
				mt.passing_score AS `Number of Correct Answers Needed to Pass`,
				SUM(IF(mtes_given.text = mtes_correct.text, 1 , 0)) AS `Number of Correct Answers`,
				mt.total_points AS `Total Number of Questions`,
				ROUND(SUM(IF(mtes_given.text = mtes_correct.text, 1 , 0))/mt.total_points * 100, 2) AS `Percent Correct`,
				MAX(IF(mte.question_number_display_text = '1', mte.question, NULL)) AS `Question 1`,
				MAX(IF(mte.question_number_display_text = '1', mtes_correct.text, NULL)) AS `Question 1 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '1', mtes_given.text, NULL)) AS `Question 1 Answer Given`,
				MAX(IF(mte.question_number_display_text = '2', mte.question, NULL)) AS `Question 2`,
				MAX(IF(mte.question_number_display_text = '2', mtes_correct.text, NULL)) AS `Question 2 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '2', mtes_given.text, NULL)) AS `Question 2 Answer Given`,
				MAX(IF(mte.question_number_display_text = '3', mte.question, NULL)) AS `Question 3`,
				MAX(IF(mte.question_number_display_text = '3', mtes_correct.text, NULL)) AS `Question 3 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '3', mtes_given.text, NULL)) AS `Question 3 Answer Given`,
				MAX(IF(mte.question_number_display_text = '4', mte.question, NULL)) AS `Question 4`,
				MAX(IF(mte.question_number_display_text = '4', mtes_correct.text, NULL)) AS `Question 4 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '4', mtes_given.text, NULL)) AS `Question 4 Answer Given`,
				MAX(IF(mte.question_number_display_text = '5', mte.question, NULL)) AS `Question 5`,
				MAX(IF(mte.question_number_display_text = '5', mtes_correct.text, NULL)) AS `Question 5 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '5', mtes_given.text, NULL)) AS `Question 5 Answer Given`,
				MAX(IF(mte.question_number_display_text = '6', mte.question, NULL)) AS `Question 6`,
				MAX(IF(mte.question_number_display_text = '6', mtes_correct.text, NULL)) AS `Question 6 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '6', mtes_given.text, NULL)) AS `Question 6 Answer Given`,
				MAX(IF(mte.question_number_display_text = '7', mte.question, NULL)) AS `Question 7`,
				MAX(IF(mte.question_number_display_text = '7', mtes_correct.text, NULL)) AS `Question 7 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '7', mtes_given.text, NULL)) AS `Question 7 Answer Given`,
				MAX(IF(mte.question_number_display_text = '8', mte.question, NULL)) AS `Question 8`,
				MAX(IF(mte.question_number_display_text = '8', mtes_correct.text, NULL)) AS `Question 8 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '8', mtes_given.text, NULL)) AS `Question 8 Answer Given`,
				MAX(IF(mte.question_number_display_text = '9', mte.question, NULL)) AS `Question 9`,
				MAX(IF(mte.question_number_display_text = '9', mtes_correct.text, NULL)) AS `Question 9 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '9', mtes_given.text, NULL)) AS `Question 9 Answer Given`,
				MAX(IF(mte.question_number_display_text = '10', mte.question, NULL)) AS `Question 10`,
				MAX(IF(mte.question_number_display_text = '10', mtes_correct.text, NULL)) AS `Question 10 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '10', mtes_given.text, NULL)) AS `Question 10 Answer Given`,
				MAX(IF(mte.question_number_display_text = '11', mte.question, NULL)) AS `Question 11`,
				MAX(IF(mte.question_number_display_text = '11', mtes_correct.text, NULL)) AS `Question 11 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '11', mtes_given.text, NULL)) AS `Question 11 Answer Given`,
				MAX(IF(mte.question_number_display_text = '12', mte.question, NULL)) AS `Question 12`,
				MAX(IF(mte.question_number_display_text = '12', mtes_correct.text, NULL)) AS `Question 12 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '12', mtes_given.text, NULL)) AS `Question 12 Answer Given`,
				MAX(IF(mte.question_number_display_text = '13', mte.question, NULL)) AS `Question 13`,
				MAX(IF(mte.question_number_display_text = '13', mtes_correct.text, NULL)) AS `Question 13 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '13', mtes_given.text, NULL)) AS `Question 13 Answer Given`,
				MAX(IF(mte.question_number_display_text = '14', mte.question, NULL)) AS `Question 14`,
				MAX(IF(mte.question_number_display_text = '14', mtes_correct.text, NULL)) AS `Question 14 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '14', mtes_given.text, NULL)) AS `Question 14 Answer Given`,
				MAX(IF(mte.question_number_display_text = '15', mte.question, NULL)) AS `Question 15`,
				MAX(IF(mte.question_number_display_text = '15', mtes_correct.text, NULL)) AS `Question 15 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '15', mtes_given.text, NULL)) AS `Question 15 Answer Given`,
				MAX(IF(mte.question_number_display_text = '16', mte.question, NULL)) AS `Question 16`,
				MAX(IF(mte.question_number_display_text = '16', mtes_correct.text, NULL)) AS `Question 16 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '16', mtes_given.text, NULL)) AS `Question 16 Answer Given`,
				MAX(IF(mte.question_number_display_text = '17', mte.question, NULL)) AS `Question 17`,
				MAX(IF(mte.question_number_display_text = '17', mtes_correct.text, NULL)) AS `Question 17 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '17', mtes_given.text, NULL)) AS `Question 17 Answer Given`,
				MAX(IF(mte.question_number_display_text = '18', mte.question, NULL)) AS `Question 18`,
				MAX(IF(mte.question_number_display_text = '18', mtes_correct.text, NULL)) AS `Question 18 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '18', mtes_given.text, NULL)) AS `Question 18 Answer Given`,
				MAX(IF(mte.question_number_display_text = '19', mte.question, NULL)) AS `Question 19`,
				MAX(IF(mte.question_number_display_text = '19', mtes_correct.text, NULL)) AS `Question 19 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '19', mtes_given.text, NULL)) AS `Question 19 Answer Given`,
				MAX(IF(mte.question_number_display_text = '20', mte.question, NULL)) AS `Question 20`,
				MAX(IF(mte.question_number_display_text = '20', mtes_correct.text, NULL)) AS `Question 20 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '20', mtes_given.text, NULL)) AS `Question 20 Answer Given`,
				MAX(IF(mte.question_number_display_text = '21', mte.question, NULL)) AS `Question 21`,
				MAX(IF(mte.question_number_display_text = '21', mtes_correct.text, NULL)) AS `Question 21 Correct Answer`,
				MAX(IF(mte.question_number_display_text = '21', mtes_given.text, NULL)) AS `Question 21 Answer Given`
			FROM master_user_courses AS muc
			JOIN master_courses AS mc
				ON mc.id = muc.course_id
			JOIN master_users AS mu
				ON mu.id = muc.user_id
			JOIN master_user_address_map AS muaddm
				ON muaddm.user_id = mu.id
			JOIN master_addresses AS ma
				ON ma.id = muaddm.address_id
			JOIN master_states AS ms
				ON ms.id = ma.state_id
			JOIN master_countries AS mco
				ON mco.country_id = ma.country_id
			JOIN master_user_accreditation_map AS muam
				ON muam.user_id = mu.id
				AND muam.accreditation_type_id = $accreditation_type_id
			JOIN master_user_role_map AS murm
				ON murm.user_id = mu.id
			JOIN master_roles AS mr
				ON mr.id = murm.role_id
			JOIN master_user_certificates AS mucert
				ON mucert.user_id = mu.id
				AND mucert.course_id = muc.course_id
			JOIN master_tests AS mt
				ON mt.course_id = muc.course_id
				AND mt.required = 1
				AND mt.passing_score > 0
			JOIN master_user_tests AS mut
				ON mut.user_id = mu.id
				AND mut.course_iteration = muc.current_iteration
				AND mut.test_id = mt.id
				AND mut.has_completed = 1
				AND mut.has_passed = 1
			JOIN master_test_elements AS mte
				ON mte.test_id = mt.id
			JOIN master_test_elements_schemes AS mtes_correct
				ON mtes_correct.scheme_id = mte.scheme
				AND mtes_correct.answer = mte.correct_answer
			JOIN master_user_test_activity AS muta
				ON muta.user_id = mut.user_id
				AND muta.course_iteration = mut.course_iteration
				AND muta.test_element_id = mte.id
				AND muta.iteration = mut.current_iteration
			JOIN master_test_elements_schemes AS mtes_given
				ON mtes_given.scheme_id = mte.scheme
				AND mtes_given.answer = muta.answer
			WHERE
				mc.organization_id = ".PROPERTY_ORGANIZATION_ID."
				AND muc.percent_complete = 100.00
				AND muc.has_passed = 1
				$search_where_test_date_string
			GROUP BY muc.user_id, muc.course_id
		";

		if($limit !== NULL && is_numeric($limit)) {
			$sql .= " LIMIT $limit";
		}

		if($offset !== NULL && is_numeric($offset)) {
			$sql .= " OFFSET $offset";
		}

		$query = $this->db->query($sql);
//echo $this->db->last_query();die;
		if($query->num_rows() >= 1)
		{
			if($return_query_object)
			{
				return $query;
			}
			else
			{
				return $query->result_array();
			}
		}
		else
		{
			return array();
		}
	}

	public function get_active_course_and_accreditation_ids($user_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

		if(!is_numeric($user_id))
		{
			return FALSE;
		}

		$stmt = "
		SELECT
			master_users.id AS user_id,
				master_courses.id AS course_id,
				master_accreditation_types.id AS accreditation_type_id
		FROM `master_users`
		JOIN master_user_courses
			ON master_user_courses.user_id=master_users.id
			AND master_user_courses.active=1
		JOIN master_courses
			ON master_courses.id=master_user_courses.course_id
			AND master_courses.active=1
		LEFT JOIN master_user_accreditation_map
			ON master_user_accreditation_map.user_id=master_users.id
			AND master_user_accreditation_map.active=1
		LEFT JOIN master_accreditation_types
			ON master_accreditation_types.id=master_user_accreditation_map.accreditation_type_id
			AND master_user_accreditation_map.active=1
		WHERE
			master_users.id = ?
			AND master_courses.organization_id = ?
		";

		$query = $this->db->query($stmt, array($user_id, PROPERTY_ORGANIZATION_ID));

		if($query->num_rows() < 1)
		{
			return FALSE;
		}
		else
		{
			return $query->row_array();
		}
	}

	public function get_active_course($user_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

		if(!is_numeric($user_id))
		{
			return FALSE;
		}

		$stmt = "
		SELECT
			master_users.id AS user_id,
			master_courses.id AS course_id,
			master_courses.course_name AS course_name,
			master_courses.price AS course_price,
			master_courses.max_iterations AS max_iterations,
			master_user_courses.id AS user_course_id,
			master_user_courses.current_iteration,
			master_user_courses.has_completed,
			master_user_courses.has_passed,
			master_courses.url,
			master_courses.after_disclaimer,
			master_courses.after_certification,
			master_courses.before_certification,
			master_courses.last_rid,
			IF(master_accreditation_types.id=5, 0, 1) AS seeking_acceditation,
			master_accreditation_types.id AS accreditation_type_id,
			master_accreditation_types.accreditation_type AS accreditation_type,
			master_user_accreditation_map.disclaimer_accepted AS disclaimer_accepted,
			master_user_accreditation_map.date_disclaimer_accepted AS date_disclaimer_accepted,
			master_user_certificates.certificate_page_accepted AS certificate_page_accepted,
			master_user_certificates.date_certificate_page_accepted AS date_certificate_page_accepted,
			master_user_certificates.certificate_accepted_by_user AS certificate_accepted_by_user,
			master_user_certificates.date_certificate_accepted_by_user AS date_certificate_accepted_by_user,
			master_user_certificates.certificate_issued AS certificate_issued,
			master_user_certificates.date_certificate_issued AS date_certificate_issued
		FROM `master_users`
		JOIN master_user_courses
			ON master_user_courses.user_id=master_users.id
			AND master_user_courses.active=1
		JOIN master_courses
			ON master_courses.id=master_user_courses.course_id
			AND master_courses.active=1
		LEFT JOIN master_user_accreditation_map
			ON master_user_accreditation_map.user_id=master_users.id
			AND master_user_accreditation_map.active=1
		LEFT JOIN master_accreditation_types
			ON master_accreditation_types.id=master_user_accreditation_map.accreditation_type_id
			AND master_user_accreditation_map.active=1
		LEFT JOIN master_user_certificates
			ON master_user_certificates.user_id=master_user_courses.user_id
			AND master_user_certificates.course_id=master_user_courses.course_id
			AND master_user_certificates.active=1
		WHERE
			master_users.id = ?
			AND master_courses.organization_id = ?
		";

		$query = $this->db->query($stmt, array($user_id, PROPERTY_ORGANIZATION_ID));

		if($query->num_rows() < 1)
		{
			return FALSE;
		}
		else
		{
			return $query->row_array();
		}
	}

	public function get_active_course_id($user_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

		$query = $this->db
			->select('course_id')
			->from('master_user_courses AS muc')
			->join('master_courses AS mc', 'mc.id = muc.course_id')
			->where(array(
				'muc.user_id'					=> $user_id,
				'muc.active'					=> 1,
				'mc.organization_id'	=> PROPERTY_ORGANIZATION_ID
			))
			->limit(1)
			->get();

		if($query->num_rows() == 1)
		{
			$row = $query->row_array();
			return $row['course_id'];
		}

		return NULL;
	}

	public function get_active_test_graded_questions($user_test, $question_number = FALSE)
	{
		$user_id = $user_test['user_id'];
		$course_iteration = $user_test['course_iteration'];
		$test_id = $user_test['test_id'];
		$test_iteration = $user_test['current_iteration'];
		$where_question_number = "";

		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_iteration = $course_iteration | test_id = $test_id | test_iteration = $test_iteration");

		if(!is_numeric($user_id) || !is_numeric($course_iteration) || !is_numeric($test_id) || !is_numeric($test_iteration))
		{
			return array();
		}

		if ($question_number !== FALSE)
		{
			$question_number = $this->db->escape_str($question_number);
			$where_question_number = " AND master_test_elements.question_number='$question_number'";
		}

		$stmt = "
						SELECT		DISTINCT master_test_elements.id,
									master_test_elements.question_number AS question_number,
									master_test_elements.question_number_display_text,
									master_test_elements.question AS question,
									master_test_elements.correct_answer AS correct_answer,
									master_user_test_activity.answer AS answer_submitted,
									IF( master_tests.required=1,
										IF( master_test_elements.correct_answer!='',
											IF( master_test_elements.correct_answer=master_user_test_activity.answer,1,0),
											''
										),
										NULL
									) AS correct_answer_submitted
						FROM		master_users
						JOIN		master_users_map
									ON master_users_map.user_id=master_users.id
									AND master_users_map.active=1
						JOIN		master_user_courses
									ON master_user_courses.user_id=master_users.id
									AND master_user_courses.current_iteration='$course_iteration' -- ****
									AND master_user_courses.active=1
						JOIN		master_courses
									ON master_courses.id=master_user_courses.course_id
									AND master_user_courses.current_iteration='$course_iteration' -- ****
									AND master_courses.active=1
						JOIN		master_tests
									ON master_tests.course_id=master_courses.id
									AND master_tests.active=1
						JOIN		master_user_tests
									ON master_user_tests.user_id=master_users.id
									AND master_user_tests.test_id=master_tests.id
									AND master_user_tests.current_iteration='$test_iteration' -- ****
									AND master_user_tests.active=1
						JOIN		master_test_elements
									ON master_test_elements.test_id=master_tests.id
									AND master_tests.id='$test_id'
									$where_question_number
									AND master_tests.active=1
						LEFT JOIN master_user_test_activity
									ON master_user_test_activity.user_id=master_users.id
									AND master_user_test_activity.course_iteration='$course_iteration'
									AND master_user_test_activity.test_element_id=master_test_elements.id
									AND master_user_test_activity.iteration=master_user_tests.current_iteration -- ****
									AND master_user_test_activity.active=1
						WHERE		master_users.id='$user_id'
						ORDER BY	master_test_elements.question_number ASC, master_user_test_activity.id
		";

		$query = $this->db->query($stmt);

		if($query->num_rows() < 1)
		{
			return array();
		}
		else
		{
			return $query->result_array();
		}
	}

	public function get_course_id_given_role($role_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with role_id = $role_id");

		$query = $this->db
			->select('course_id')
			->from('master_role_course_map')
			->where(array(
					'role_id'	=> $role_id,
					'active'	=> 1
				))
			->limit(1)
			->get();

		if($query->num_rows() == 1) {
			$row = $query->row_array();
			return $row['course_id'];
		}

		return NULL;
	}

	public function get_content_knowlege_test_stats($user_id, $course_id, $course_iteration, $only_active_courses = TRUE)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = $course_id | course_iteration = $course_iteration");

		$test_id = ($course_id == 1) ? 2 : 7;
		$course = array(
			'course_id'					=> $course_id,
			'current_iteration'	=> $course_iteration
		);
		$test = array(
			'test_id'						=> $test_id,
			'current_iteration'	=> $this->get_last_test_iteration($user_id, $course_iteration, $test_id)
		);

		return $this->get_test_stats($user_id, $course, $test, $only_active_courses);
	}

	public function get_course($id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with course_id = $id");

		$query = $this->db->where(array('id' => $id, 'active' => 1))->get('master_courses');

		if ($query->num_rows() < 1)
		{
			return FALSE;
		}

		return $query->row_array();
	}

	public function get_course_id($key)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with key = $key");

		$query = $this->db
			->select('mce.course_id')
			->from('master_course_elements AS mce')
			->join('master_courses AS mc', 'mc.id = mce.course_id')
			->where(array(
					'mce.response_id' 		=> $key,
					'mc.organization_id'	=> PROPERTY_ORGANIZATION_ID
				))
			->get();

		if($query->num_rows() < 1)
		{
			return FALSE;
		}
		else
		{
			$row = $query->row_array();

			return $row['course_id'];
		}

	}

	public function get_course_name($id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with course_id = $id");

		if (($course = $this->get_course($id)) === FALSE)
		{
			return "";
		}

		return $course['course_name'];
	}

	public function get_course_stats($user_course)
	{
		$user_id = $user_course['user_id'];
		$course_id = $user_course['course_id'];
		$course_iteration = $user_course['current_iteration'];

		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = $course_id | course_iteration = $course_iteration");

		if(!is_numeric($user_id) || !is_numeric($course_id) || !is_numeric($course_iteration))
		{
			return FALSE;
		}

		$stmt = "
			SELECT
				muc.total_sections_visited,
				mc.total_sections,
				muc.total_tests_surveys_visited,
				mc.total_tests_surveys,
				muc.percent_complete,
				(
					muc.total_sections_visited = mc.total_sections
					AND muc.total_tests_surveys_visited = mc.total_tests_surveys
				) AS ready_complete,
				IFNULL(number_of_graded_tests_passed.sum, 0) AS number_of_graded_tests_passed,
				number_of_graded_tests.count AS number_of_graded_tests,
				(
					number_of_graded_tests_passed.sum = number_of_graded_tests.count
				) AS ready_pass
			FROM master_user_courses AS muc
			JOIN master_courses AS mc
				ON mc.id = muc.course_id
			JOIN (
				SELECT
					SUM(IFNULL(has_passed, 0)) AS sum
				FROM master_user_tests
				JOIN (
					SELECT
						mut.user_id,
						mut.test_id,
						MAX(mut.current_iteration) AS iteration
					FROM master_user_tests mut
					JOIN master_tests AS mt
						ON mt.id = mut.test_id
					WHERE
						mut.user_id = $user_id
						AND mt.course_id = $course_id
						AND mut.course_iteration = $course_iteration
						AND mt.required = 1
						AND mt.passing_score > 0
					GROUP BY mut.user_id, mt.course_id, mut.test_id
				) AS most_recent_test_iterations
					ON master_user_tests.user_id = most_recent_test_iterations.user_id
					AND master_user_tests.test_id = most_recent_test_iterations.test_id
					AND master_user_tests.current_iteration = most_recent_test_iterations.iteration
			) AS number_of_graded_tests_passed
			JOIN (
				SELECT
					COUNT(*) AS count
				FROM master_tests AS mt
				WHERE
					mt.course_id = $course_id
					AND mt.required = 1
					AND mt.passing_score > 0
					AND mt.active = 1
			) AS number_of_graded_tests
			WHERE
				muc.user_id = $user_id
				AND muc.course_id = $course_id
				AND muc.current_iteration = $course_iteration
		";

		$query = $this->db->query($stmt);

		if($query->num_rows() < 1)
		{
			return FALSE;
		}
		else
		{
			return $query->row_array();
		}
	}

	/***
	 * ToDo: Chet: These should be grabbed as part of
	 * get_test_elements. This will invoke too many DB calls
	 */
	public function get_element_scheme($scheme_id) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with scheme_id = $scheme_id");

		$where = array(
				'scheme_id'	=> $scheme_id
		);
		$query = $this->db->where($where)->get('master_test_elements_schemes');

		if($query->num_rows() < 1)
		{
			return FALSE;
		}
		else
		{
			return $query->result_array();
		}
	}

	public function get_initial_course_assignment($id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $id");

		if(!is_numeric($id))
		{
			return FALSE;
		}

		$stmt = "
			SELECT
				master_courses.*
			FROM `master_users`
			JOIN master_user_role_map
				ON master_user_role_map.user_id=master_users.id
				AND master_user_role_map.active=1
			JOIN master_role_course_map
				ON master_role_course_map.id=master_user_role_map.role_id
				AND master_role_course_map.active=1
			JOIN master_courses
				ON master_courses.id=master_role_course_map.course_id
				AND master_courses.active=1
			WHERE
				master_users.id = '$id'
				AND master_courses.organization_id = " . PROPERTY_ORGANIZATION_ID;

		$query = $this->db->query($stmt);

		if($query->num_rows() < 1)
		{
			return FALSE;
		}
		else
		{
			return $query->row_array();
		}
	}

	public function get_last_response_id($user_id, $course_id, $iteration)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = $course_id | course_iteration = $iteration");

		if(!is_numeric($user_id) || !is_numeric($course_id) || !is_numeric($iteration))
		{
			return FALSE;
		}

		$stmt = "
			SELECT		master_user_course_activity.response_id AS response_id
			FROM		master_user_course_activity
			LEFT JOIN master_user_tests
					ON master_user_tests.user_id=master_user_course_activity.user_id
					AND master_user_tests.course_iteration=master_user_course_activity.iteration
			LEFT JOIN master_tests
					ON master_tests.`key`=master_user_course_activity.response_id
			WHERE
				master_user_course_activity.user_id='$user_id'
				AND master_user_course_activity.course_id='$course_id'
				AND master_user_course_activity.iteration='$iteration'
				AND
				(
					(master_tests.required=1
						AND NOT master_user_course_activity.status='passed'
						AND NOT master_user_course_activity.status='failed'
					)
					OR
					(
						master_tests.id IS NULL
					)
				)
			ORDER BY	master_user_course_activity.id DESC
			LIMIT		1
		";

	$query = $this->db->query($stmt);

	if($query->num_rows() < 1)
	{
		return FALSE;
	}
	else
	{
		$row = $query->row_array();
		return $row['response_id'];
	}
	}

	public function get_last_test_iteration($user_id, $course_iteration, $test_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_iteration = $course_iteration | test_id = $test_id");

		if(!is_numeric($user_id) || !is_numeric($course_iteration) || !is_numeric($test_id))
		{
			return FALSE;
		}

		$stmt = "
		SELECT		master_user_tests.current_iteration
		FROM		master_user_tests
		WHERE		master_user_tests.user_id='$user_id'
					AND master_user_tests.course_iteration='$course_iteration'
					AND master_user_tests.test_id='$test_id'
		ORDER BY	master_user_tests.id DESC
		";

		$query = $this->db->query($stmt);

		if($query->num_rows() < 1)
		{
			return FALSE;
		}
		else
		{
			$row = $query->row_array();
			return $row['current_iteration'];
		}
	}

	public function get_next_user_course_iteration($user_id, $course_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = $course_id");

		if (!($user_course = $this->get_user_course($user_id, $course_id)))
		{
			return 1;
		}

		return $user_course['current_iteration'] + 1;
	}

	public function get_next_user_test_iteration($user_id, $course_iteration, $test_id)
	{
		if (!($user_test = $this->get_user_test($user_id, $course_iteration, $test_id)))
		{
			return 1;
		}

		return $user_test['current_iteration'] + 1;
	}

	public function get_raw_courses_dump($search = NULL, $department_id = NULL, $treatment_facility_id = NULL, $role_id = NULL, $limit = NULL, $offset = NULL, $return_query_object = TRUE) {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$search_where = " 1 = 1 ";
		$department_id_where = "";
		$treatment_facility_id_where = "";
		$role_id_where = "";
		$limit_stmt = "";
		$offset_stmt = "";

		if (!empty($search)) {
			$search_where = "(".
				"CONCAT(master_users.last_name,', ',master_users.first_name,IF(master_users.middle_initial!='',CONCAT(' ',master_users.middle_initial),'')) like '%$search%' ".
				"OR ".
				"CONCAT(master_users.first_name,' ',master_users.last_name) like '%$search%' ".
				"OR master_users.first_name	 like '%$search%' ".
				"OR master_users.last_name	like '%$search%' ".
				"OR master_users.username	 like '%$search%' ".
				"OR master_departments.department_name	like '%$search%' ".
				"OR master_accreditation_types.accreditation_type	 like '%$search%' ".
				"OR master_courses.course_name	like '%$search%' ".
				"OR master_user_numbers.user_number like '%$search%' ".
			")";
		}

		if($department_id !== NULL && is_numeric($department_id)) {
			$department_id_where = " AND master_user_department_map.department_id = $department_id";
		}

		if($treatment_facility_id !== NULL && is_numeric($treatment_facility_id)) {
			$treatment_facility_id_where = " AND master_user_treatment_facility_map.treatment_facility_id = $treatment_facility_id";
		}

		if($role_id !== NULL && is_numeric($role_id)) {
			$role_id_where = " AND master_user_role_map.role_id = $role_id";
		}

		if($limit !== NULL && is_numeric($limit)) {
			$limit_stmt= " LIMIT $limit";
		}

		if($offset !== NULL && is_numeric($offset)) {
			$offset_stmt = " OFFSET $offset";
		}

		$sql = "
			SELECT
				master_departments.department_name AS department_name,
				master_treatment_facilities.base as treatment_facility,
				master_roles.role_name,
				raw_courses_dump.user_id,
				master_users.username,
				master_users.first_name,
				master_users.middle_initial,
				master_users.last_name,
				raw_courses_dump.course_name,
				raw_courses_dump.course_iteration,
				raw_courses_dump.module,
				raw_courses_dump.type,
				raw_courses_dump.response_id,
				raw_courses_dump.status,
				raw_courses_dump.required,
				raw_courses_dump.has_completed,
				raw_courses_dump.has_passed,
				raw_courses_dump.score,
				raw_courses_dump.date
			FROM ((
				SELECT
					master_user_courses.user_id,
					master_courses.course_name AS course_name,
					master_user_course_activity.iteration as course_iteration,
					master_course_elements.tltle AS module,
					'activity' as type,
					master_user_course_activity.response_id,
					master_user_course_activity.status AS status,
					NULL as required,
					NULL as has_completed,
					NULL as has_passed,
					NULL as score,
					master_activity_logs.date
				FROM master_user_course_activity
				JOIN master_activity_logs
					ON master_activity_logs.id = master_user_course_activity.activity_log_id
				JOIN master_user_courses
					ON master_user_courses.user_id = master_user_course_activity.user_id
					AND master_user_courses.course_id = master_user_course_activity.course_id
					AND master_user_courses.current_iteration = master_user_course_activity.iteration
				JOIN master_courses
					ON master_courses.id = master_user_courses.course_id
				JOIN master_course_elements
					ON master_course_elements.response_id = master_user_course_activity.response_id
				WHERE
					master_courses.organization_id = ".PROPERTY_ORGANIZATION_ID."
					AND master_user_course_activity.active = 1
			) UNION ALL (
				SELECT
					master_user_tests.user_id,
					master_courses.course_name,
					master_user_tests.course_iteration,
					master_tests.test_name as module,
					'test' as type,
					NULL as response_id,
					NULL as status,
					IF(master_tests.required = 1, 'Yes', 'No') AS required,
					IF(master_user_tests.has_completed = 1,'Yes','No') AS has_completed,
					IF(master_user_tests.has_passed = 1,'Yes','No') AS has_passed,
					master_user_tests.score AS score,
					master_user_tests.date_completed as date
				FROM master_user_tests
				JOIN master_tests
					ON master_tests.id = master_user_tests.test_id
				JOIN master_courses
					ON master_courses.id = master_tests.course_id
				WHERE
					master_courses.organization_id = ".PROPERTY_ORGANIZATION_ID."
					AND master_user_tests.active = 1
			)) AS raw_courses_dump
			JOIN master_users
				ON master_users.id = raw_courses_dump.user_id
			JOIN master_users_map
				ON master_users_map.user_id = master_users.id
				AND master_users_map.organization_id = " . PROPERTY_ORGANIZATION_ID. "
				AND master_users_map.active = 1
			JOIN master_user_numbers
				ON master_user_numbers.user_id = master_users.id
				AND master_user_numbers.active = 1
			JOIN master_user_department_map
				ON master_user_department_map.user_id = master_users.id
				AND master_user_department_map.active = 1
			JOIN master_departments
				ON master_departments.id = master_user_department_map.department_id
				AND master_departments.id != 1
				AND master_user_department_map.active = 1
			JOIN master_user_role_map
				ON master_user_role_map.user_id = master_users.id
				AND master_user_role_map.active = 1
			JOIN master_roles
				ON master_roles.id = master_user_role_map.role_id
			JOIN master_user_courses
					ON master_user_courses.user_id = master_users.id
			JOIN master_courses
				ON master_courses.id = master_user_courses.course_id
				AND master_courses.active = 1
			JOIN master_user_accreditation_map
				ON master_user_accreditation_map.user_id = master_users.id
				AND master_user_accreditation_map.active = 1
			JOIN master_user_certificates
				ON master_user_certificates.user_id = master_user_courses.user_id
				AND master_user_certificates.course_id = master_user_courses.course_id
				AND master_user_certificates.active = 1
			JOIN master_user_treatment_facility_map
				ON master_user_treatment_facility_map.user_id = master_users.id
			JOIN master_treatment_facilities
				ON master_treatment_facilities.id = master_user_treatment_facility_map.treatment_facility_id
			JOIN master_accreditation_types
				ON master_accreditation_types.id = master_user_accreditation_map.accreditation_type_id
				AND master_accreditation_types.active = 1
			WHERE
				$search_where
				$department_id_where
				$treatment_facility_id_where
				$role_id_where
			ORDER BY raw_courses_dump.date DESC
			$limit_stmt $offset_stmt
		";

		$query = $this->db->query($sql);

		if($query->num_rows() >= 1) {
			if($return_query_object) {
				return $query;
			} else {
				return $query->result_array();
			}
		} else {
			return array();
		}
	}

	public function get_test($key)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with key = $key");

		$query = $this->db
			->select('mt.*')
			->from('master_tests AS mt')
			->join('master_courses AS mc', 'mc.id = mt.course_id')
			->where(array(
					'mc.organization_id'	=> PROPERTY_ORGANIZATION_ID,
					'mt.key'							=> $key
				))
			->get();

		if($query->num_rows() < 1)
		{
			return FALSE;
		}
		else
		{
			return $query->row_array();
		}
	}

	public function get_test_answers($user_id, $course_iteration, $test_id, $iteration)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_iteration = $course_iteration | test_id = $test_id | course_iteration = $iteration");

		$stmt ="
		SELECT		master_tests.id,
					master_test_elements.id AS test_elements_id,
					master_user_test_activity.id AS user_test_activity_id,master_test_elements.question_number AS question_number,
					master_test_elements.question_number_display_text AS question_number_display_text,
					master_test_elements.question AS question,
								master_test_elements.scheme AS scheme,
								master_test_elements.heading AS heading,
					master_test_elements.correct_answer AS correct_answer,
					master_user_test_activity.answer,
					IF(LOWER(master_test_elements.correct_answer)=LOWER(master_user_test_activity.answer),TRUE,FALSE) as is_correct
		FROM		master_tests
		JOIN		master_test_elements
					ON master_test_elements.test_id=master_tests.id
					AND master_test_elements.active=1
		LEFT JOIN master_user_test_activity
					ON master_user_test_activity.user_id = ?
					AND master_user_test_activity.course_iteration = ?
					AND master_user_test_activity.test_element_id=master_test_elements.id
					AND master_user_test_activity.iteration = ?
		WHERE		master_tests.id = ?
		";

		$query = $this->db->query($stmt, array($user_id, $course_iteration, $iteration, $test_id));

		if($query->num_rows() < 1)
		{
			return array();
		}
		else
		{
			return $query->result_array();
		}
	}

	public function get_possible_test_answers($master_tests_key) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with master_tests_key = $master_tests_key");

		if(empty($master_tests_key) || !is_string($master_tests_key)) {
			return array();
		}

		$master_tests_key = $this->db->escape_str($master_tests_key);

		$sql = "
			SELECT
				master_test_elements.question_number,
				master_test_elements_schemes.text,
					master_test_elements_schemes.answer,
					master_test_elements.correct_answer,
					IF(LOWER(master_test_elements_schemes.answer) = LOWER(master_test_elements.correct_answer), TRUE, FALSE) AS is_correct_answer
			FROM master_tests
			JOIN master_courses
				ON master_courses.id = master_tests.course_id
			JOIN master_test_elements
				ON master_test_elements.test_id = master_tests.id
			JOIN master_test_elements_schemes
				ON master_test_elements_schemes.scheme_id = master_test_elements.scheme
			WHERE
				master_courses.organization_id = ".PROPERTY_ORGANIZATION_ID."
				AND master_tests.key = ?
				AND master_tests.active = 1
				AND master_test_elements.active = 1
			ORDER BY master_test_elements.question_number
			";

		$query = $this->db->query($sql, array($master_tests_key));

		if($query->num_rows() > 0) {
			return $query->result_array();
		}

		return array();
	}

	/***
	 * Grabs everything to populate a test template
	 */
	public function get_test_elements($test_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with test_id = $test_id");

		$where = array(
				'test_id'			=> $test_id
				//'question_number' => $question_number
		);

		$query = $this->db->where($where)->get('master_test_elements');

		if($query->num_rows() < 1)
		{
			return FALSE;
		}
		else
		{
			return $query->result_array();
		}
	}

	public function get_test_element($test_id, $question_number)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with test_id = $test_id | question_number = $question_number");

		$where = array(
				'test_id'					=> $test_id,
				'question_number'	=> $question_number
		);

		$query = $this->db->where($where)->get('master_test_elements');

		if($query->num_rows() < 1)
		{
			return FALSE;
		}
		else
		{
			return $query->row_array();
		}
	}

	public function get_test_stats($user_id, $course, $test, $only_active_courses = TRUE)
	{
		$course_active_where_clause = '';
		if ($only_active_courses == TRUE){
			$course_active_where_clause = 'AND master_user_courses.active=1';
		}
		$course_id = $this->db->escape_str($course['course_id']);
		$test_id = $this->db->escape_str($test['test_id']);
		$current_course_iteration = $this->db->escape_str($course['current_iteration']);
		$current_test_iteration = $this->db->escape_str($test['current_iteration']);

		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | test_id = $test_id | course_iteration = $current_course_iteration | test_iteration = $current_test_iteration");

		$stmt = "
			SELECT		master_user_tests.id AS user_test_id,
			master_tests.total_points AS total_points,
			master_tests.passing_score as passing_score,
			SUM(master_user_test_activity.answer!='') AS questions_answered,
			IF( master_tests.total_points>0,
				IF( master_test_elements.correct_answer IS NOT NULL AND master_test_elements.correct_answer!='',
							SUM(master_test_elements.correct_answer=master_user_test_activity.answer),
							0
				),
				0
			) AS correct_answers_submitted,
			master_user_tests.has_completed AS marked_completed,
			master_user_tests.has_passed AS marked_passed,
			IF( total_points=SUM(IF(master_user_test_activity.answer IS NOT NULL,1,0)),
				1,
				0
			) AS eligible_to_be_marked_completed,
			IF (	master_tests.total_points>0,
					IF(
						SUM(master_test_elements.correct_answer=master_user_test_activity.answer)>=master_tests.passing_score,
						1,
						0
					),
					0
			) AS eligible_to_be_marked_passed
			FROM		master_users
			JOIN		master_users_map
						ON master_users_map.user_id=master_users.id
						AND master_users_map.active=1
			JOIN		master_user_courses
						ON master_user_courses.user_id=master_users.id
						AND master_user_courses.course_id='$course_id'
						AND master_user_courses.current_iteration='$current_course_iteration'
						$course_active_where_clause
			JOIN		master_courses
						ON master_courses.id=master_user_courses.course_id
						AND master_user_courses.current_iteration='$current_course_iteration'
						AND master_courses.id='$course_id'
						AND master_courses.active=1
			JOIN		master_tests
						ON master_tests.course_id=master_courses.id
						AND master_tests.id='$test_id'
						AND master_tests.active=1
			JOIN		master_test_elements
						ON master_test_elements.test_id=master_tests.id
						AND master_test_elements.test_id='$test_id'
						AND master_tests.active=1
			JOIN		master_user_tests
						ON master_user_tests.user_id=master_users.id
						AND master_user_tests.test_id=master_tests.id
						AND master_user_tests.course_iteration='$current_course_iteration'
						AND master_user_tests.current_iteration='$current_test_iteration'
						AND master_user_tests.active=1
			LEFT JOIN master_user_test_activity
						ON master_user_test_activity.user_id=master_users.id
						AND master_user_test_activity.test_element_id=master_test_elements.id
						AND master_user_test_activity.course_iteration='$current_course_iteration'
						AND master_user_test_activity.iteration='$current_test_iteration'
						AND master_user_test_activity.active=1
			WHERE		master_users.id=$user_id
			GROUP BY	master_tests.id
			ORDER BY	master_test_elements.question_number ASC, master_user_test_activity.id DESC, master_test_elements.id DESC
		";

		$query = $this->db->query($stmt);

		if($query->num_rows() < 1)
		{
			return FALSE;
		}
		else
		{
			return $query->row_array();
		}
	}

	public function get_course_element_rid_by_id($id) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with course_element_id = $id");

		$where = array(
			'id'		 => $id
		);

		$query = $this->db->where($where)->get('master_course_elements');

		if($query->num_rows() < 1) {
			return FALSE;
		}

		$result = $query->row_array();
		return $result["response_id"];
	}

	public function get_course_element_info($rid) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with response_id = $rid");

		$query = $this->db
			->select('mce.*')
			->from('master_course_elements AS mce')
			->join('master_courses AS mc', 'mc.id = mce.course_id')
			->where(array(
					'mce.response_id'			=> $rid,
					'mc.organization_id'	=> PROPERTY_ORGANIZATION_ID
				))
			->get();

		if($query->num_rows() < 1) {
			return FALSE;
		}

		return $query->row_array();
	}

	public function get_course_element_parent($rid) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with response_id = $rid");

		$where = array(
			'response_id'			=> $rid
		);

		$query = $this->db
			->select('mce.*')
			->from('master_course_elements AS mce')
			->join('master_courses AS mc', 'mc.id = mce.course_id')
			->where(array(
					'mce.response_id'			=> $rid,
					'mc.organization_id'	=> PROPERTY_ORGANIZATION_ID
				))
			->get();

		if($query->num_rows() < 1) {
			return FALSE;
		}

		$result = $query->row_array();

		$where = array(
			'id'		 => $result['parent']
		);

		$query = $this->db->where($where)->get('master_course_elements');

		if ($query->num_rows() < 1) {
			return FALSE;
		}

	 $result = $query->row_array();
	 return $result['response_id'];
	}

	public function get_course_element_children($rid) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with response_id = $rid");

		$query = $this->db
			->select('mce.*')
			->from('master_course_elements AS mce')
			->join('master_courses AS mc', 'mc.id = mce.course_id')
			->where(array(
					'mce.response_id'			=> $rid,
					'mc.organization_id'	=> PROPERTY_ORGANIZATION_ID
				))
			->get();

		if($query->num_rows() < 1) {
			return FALSE;
		}

		$result = $query->row_array();

		$where = array(
			'parent'		 => $result["id"]
		);

		$query = $this->db->where($where)->get('master_course_elements');

		if($query->num_rows() < 1) {
			return FALSE;
		}

	 return $result = $query->result_array();
	}

	public function get_user_certificate($user_id, $course_id, $accreditation_type_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = $course_id | accreditation_type_id = $accreditation_type_id");

		$where = array(
				'user_id'								=> $user_id,
				'course_id'							=> $course_id,
				'accreditation_type_id'	=> $accreditation_type_id,
				'active'								=> 1
		);

		$query = $this->db->where($where)->get('master_user_certificates');

		if($query->num_rows() < 1) {
			return FALSE;
		}

		return $query->row_array();
	}

	public function get_user_course($user_id, $course_id, $current_iteration = NULL) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = $course_id");

		if($current_iteration === NULL) {
			$where = array(
				'user_id'		=> $user_id,
				'course_id'	=> $course_id
			);
		} else if(is_numeric($current_iteration)) {
			$where = array(
				'user_id'		=> $user_id,
				'course_id'	=> $course_id,
				'current_iteration' => $current_iteration
			);
		} else {
			return FALSE;
		}

		$query = $this->db->where($where)->get('master_user_courses');

		if($query->num_rows() < 1) {
			return FALSE;
		}

		return $query->row_array();
	}

	public function get_user_answers($search = NULL, $department_id = NULL, $treatment_facility_id = NULL, $role_id = NULL, $limit = NULL, $offset = NULL, $return_query_object = FALSE)
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$search_where = "";
		$department_id_where = "";
		$treatment_facility_id_where = "";
		$role_id_where = "";
		$limit_stmt = "";
		$offset_stmt = "";

		if (!empty($search)) {
			$search =  $this->db->escape_like_str($search);
			$search_where = " AND (".
				"CONCAT(master_users.last_name,', ',master_users.first_name,IF(master_users.middle_initial!='',CONCAT(' ',master_users.middle_initial),'')) like '%$search%' ".
				"OR ".
				"CONCAT(master_users.first_name,' ',master_users.last_name) like '%$search%' ".
				"OR master_users.first_name	 like '%$search%' ".
				"OR master_users.last_name	like '%$search%' ".
				"OR master_users.username	 like '%$search%' ".
			")";
		}

		if($department_id !== NULL && is_numeric($department_id)) {
			$department_id_where = " AND master_user_department_map.department_id = $department_id";
		}

		if($treatment_facility_id !== NULL && is_numeric($treatment_facility_id)) {
			$treatment_facility_id_where = " AND master_user_treatment_facility_map.treatment_facility_id = $treatment_facility_id";
		}

		if($role_id !== NULL && is_numeric($role_id)) {
			$role_id_where = " AND master_user_role_map.role_id = $role_id";
		}

		if($limit !== NULL && is_numeric($limit)) {
			$limit_stmt= " LIMIT $limit ";
		}

		if($offset !== NULL && is_numeric($offset)) {
			$offset_stmt = " OFFSET $offset";
		}

		$sql = "
			SELECT
				master_departments.department_name AS department_name,
				master_treatment_facilities.base AS treatment_facility,
				master_roles.role_name,
				master_user_test_activity.user_id,
				master_users.username,
				master_users.first_name,
				master_users.middle_initial,
				master_users.last_name,
				master_courses.course_name,
				master_tests.test_name,
				master_test_elements.question,
				IFNULL(
					IF (
						master_test_elements.correct_answer IS NULL
						OR master_test_elements.correct_answer = '',
						NULL,
					IF (
						master_user_test_activity.answer = master_test_elements.correct_answer,
						'Yes',
						'No'
					)
					),
					'N/A'
				) AS correct_answer_given,
				master_user_test_activity.answer AS answer_given,
				master_test_elements_schemes_answer_given.text AS answer_given_text,
			IF (
				master_test_elements.correct_answer IS NULL
				OR master_test_elements.correct_answer = '',
				'N/A',
				master_test_elements.correct_answer
			) AS correct_answer,
			 IFNULL(
				master_test_elements_schemes_correct_answer.text,
				'N/A'
			) AS correct_answer_text,
			 master_activity_logs.date
			FROM master_user_test_activity
			JOIN master_test_elements ON master_test_elements.id = master_user_test_activity.test_element_id
			JOIN master_test_elements_schemes AS master_test_elements_schemes_answer_given ON master_test_elements_schemes_answer_given.scheme_id = master_test_elements.scheme
			AND master_test_elements_schemes_answer_given.answer = master_user_test_activity.answer
			LEFT JOIN master_test_elements_schemes AS master_test_elements_schemes_correct_answer ON master_test_elements_schemes_correct_answer.scheme_id = master_test_elements.scheme
			AND master_test_elements_schemes_correct_answer.answer = master_test_elements.correct_answer
			JOIN master_tests ON master_tests.id = master_test_elements.test_id
			JOIN master_courses ON master_courses.id = master_tests.course_id
			JOIN master_activity_logs ON master_activity_logs.id = master_user_test_activity.activity_log_id
			JOIN master_users ON master_users.id = master_user_test_activity.user_id
			JOIN master_users_map ON master_users_map.user_id = master_users.id
			JOIN master_user_department_map ON master_user_department_map.user_id = master_users.id
			JOIN master_departments ON master_departments.id = master_user_department_map.department_id
			JOIN master_user_role_map ON master_user_role_map.user_id = master_users.id
			JOIN master_roles ON master_roles.id = master_user_role_map.role_id
			JOIN master_user_treatment_facility_map ON master_user_treatment_facility_map.user_id = master_users.id
			JOIN master_treatment_facilities ON master_treatment_facilities.id = master_user_treatment_facility_map.treatment_facility_id
			-- JOIN master_user_courses ON master_user_courses.user_id = master_users.id AND master_user_courses.course_id = master_tests.course_id
			WHERE
				master_user_test_activity.active = 1
			AND master_users_map.organization_id = " . PROPERTY_ORGANIZATION_ID. "
			AND master_user_department_map.active = 1
			AND master_departments.id != 1
			AND master_user_department_map.active = 1
			AND master_user_role_map.active = 1
			AND master_courses.active = 1
			$search_where
			$department_id_where
			$treatment_facility_id_where
			$role_id_where
			ORDER BY master_activity_logs.date DESC
			$limit_stmt $offset_stmt
		";

		$query = $this->db->query($sql);

		if($query->num_rows() >= 1) {
			if($return_query_object) {
				return $query;
			} else {
				return $query->result_array();
			}
		} else {
			return array();
		}
	}

	public function get_user_courses($user_id = FALSE, $all = TRUE, $search = FALSE, $uncompleted = NULL, $not_passed = NULL, $no_cert = NULL, $department_id = NULL, $treatment_facility_id = NULL, $role_id = NULL, $limit = NULL, $offset = NULL, $return_query_object = FALSE) {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$join_all = "LEFT JOIN";
		$search_where = "";
		$uncompleted_where = "";
		$not_passed_where = "";
		$no_cert_where = "";
		$department_id_where = "";
		$treatment_facility_id_where = "";
		$role_id_where = "";

			if ($all === FALSE)
			{
				$join_all = "JOIN";
			}

			if (!empty($search))
			{
				$search = $this->db->escape_like_str($search);
				$search_where = "AND (".
					"CONCAT(master_users.last_name,', ',master_users.first_name,IF(master_users.middle_initial!='',CONCAT(' ',master_users.middle_initial),'')) like '%$search%' ".
					"OR ".
					"CONCAT(master_users.first_name,' ',master_users.last_name) like '%$search%' ".
					"OR master_users.first_name	 like '%$search%' ".
					"OR master_users.last_name	like '%$search%' ".
					"OR master_users.username	 like '%$search%' ".
					"OR master_departments.department_name	like '%$search%' ".
					"OR master_accreditation_types.accreditation_type	 like '%$search%' ".
					"OR master_courses.course_name	like '%$search%' ".
					"OR master_user_numbers.user_number like '%$search%' ".
				")";
			}

			if ($user_id !== FALSE)
			{
				$user_id = $this->db->escape_str($user_id);

				$stmt = "
						SELECT		master_courses.id AS course_id,
									master_courses.course_name AS course_name,
									master_courses.max_iterations AS max_iterations,
									master_courses.url AS url,
									MAX(master_user_courses.current_iteration) AS current_iteration,
									MAX(master_user_courses.has_completed) AS has_completed,
									MAX(master_user_courses.has_passed) AS has_passed,
									master_user_courses.date_registered AS date_registered,
									MAX(master_user_courses.active) AS is_active
						FROM		master_courses

						$join_all master_user_courses
									ON master_courses.id=master_user_courses.course_id
									AND master_courses.active=1
									AND master_user_courses.user_id='$user_id'
									-- AND master_user_courses.active=1
						WHERE		master_courses.organization_id=" . PROPERTY_ORGANIZATION_ID. "
						GROUP BY	master_courses.id
						ORDER BY	master_courses.course_name, master_user_courses.current_iteration DESC
				";
			}
			else
			{
				if($uncompleted === FALSE)
				{
					$uncompleted_where = " AND master_user_courses.percent_complete = 100.00";
				}
				else if($uncompleted === TRUE)
				{
					$uncompleted_where = " AND master_user_courses.percent_complete != 100.00";
				}

				if($not_passed === FALSE)
				{
					$not_passed_where = " AND master_user_courses.has_passed = 1";
				}
				else if($not_passed === TRUE)
				{
					$not_passed_where = " AND master_user_courses.has_passed = 0";
				}

				if($no_cert === FALSE)
				{
					// The has_passed condition is a hack to prevent certificate_accepted_by_user = 1 and master_user_courses.has_passed = 0 entries from showing on the Reports Dashboard
					$no_cert_where = " AND certificate_accepted_by_user = 1 AND master_user_courses.has_passed = 1";
					//$no_cert_where = " AND certificate_accepted_by_user = 1";
				}
				else if($no_cert === TRUE)
				{
					$no_cert_where = " AND certificate_accepted_by_user = 0";
				}

				if($department_id !== NULL && is_numeric($department_id)) {
					$department_id_where = " AND master_user_department_map.department_id = $department_id";
				}

				if($treatment_facility_id !== NULL && is_numeric($treatment_facility_id)) {
					$treatment_facility_id_where = " AND master_user_treatment_facility_map.treatment_facility_id = $treatment_facility_id";
				}

				if($role_id !== NULL && is_numeric($role_id)) {
					$role_id_where = " AND master_user_role_map.role_id = $role_id";
				}

				$stmt = "
					SELECT
								master_departments.department_name AS department_name,
								master_treatment_facilities.base as treatment_facility,
								master_roles.role_name,
								master_users.id AS user_id,
									master_users.username AS username,
								master_users.first_name AS first_name,
								master_users.middle_initial AS middle_initial,
								master_users.last_name AS last_name,
								CONCAT(
									master_users.last_name,
									', ',
									master_users.first_name,
									IF(master_users.middle_initial!='',CONCAT(' ',master_users.middle_initial),'')
								) AS full_name,
								master_accreditation_types.accreditation_type AS accreditation_type,
								master_courses.course_name AS course_name,
								master_user_courses.course_id AS course_id,
								master_user_courses.current_iteration,
								master_user_courses.percent_complete,
								IF(master_user_courses.has_passed, 'Yes', 'No') AS has_passed,
								IF(master_user_accreditation_map.disclaimer_accepted, 'Yes', 'No') AS disclaimer_accepted,
								-- The has_passed condition is a hack to prevent certificate_accepted_by_user = 1 and master_user_courses.has_passed = 0 entries from showing on the Reports Dashboard
								IF(master_user_certificates.certificate_accepted_by_user AND master_user_courses.has_passed, 'Yes', 'No') AS certificate_accepted_by_user
								-- IF(master_user_certificates.certificate_accepted_by_user, 'Yes', 'No') AS certificate_accepted_by_user
					FROM master_users
					JOIN master_users_map
								ON master_users_map.user_id=master_users.id
								AND master_users_map.organization_id=" . PROPERTY_ORGANIZATION_ID. "
								AND master_users_map.active=1
					JOIN master_user_numbers
								ON master_user_numbers.user_id=master_users.id
								AND master_user_numbers.active=1
					JOIN master_user_department_map
								ON master_user_department_map.user_id=master_users.id
								AND master_user_department_map.active=1
					JOIN master_departments
								ON master_departments.id=master_user_department_map.department_id
								AND master_departments.id!=1
								AND master_user_department_map.active=1
					JOIN master_user_role_map
								ON master_user_role_map.user_id=master_users.id
								AND master_user_role_map.active=1
					JOIN master_roles
						ON master_roles.id = master_user_role_map.role_id
					JOIN master_user_courses
								ON master_user_courses.user_id=master_users.id
					JOIN master_courses
								ON master_courses.id=master_user_courses.course_id
								AND master_courses.active=1
					JOIN master_user_accreditation_map
								ON master_user_accreditation_map.user_id=master_users.id
								AND master_user_accreditation_map.active=1
					JOIN master_user_certificates
								ON master_user_certificates.user_id=master_user_courses.user_id
								AND master_user_certificates.course_id=master_user_courses.course_id
								AND master_user_certificates.active=1
					JOIN master_user_treatment_facility_map
								ON master_user_treatment_facility_map.user_id=master_users.id
					JOIN master_treatment_facilities
								ON master_treatment_facilities.id = master_user_treatment_facility_map.treatment_facility_id
					JOIN master_accreditation_types
								ON master_accreditation_types.id=master_user_accreditation_map.accreditation_type_id
								AND master_accreditation_types.active=1
					WHERE master_users.active=1
								$search_where
								$uncompleted_where
								$not_passed_where
								$no_cert_where
								$department_id_where
								$treatment_facility_id_where
								$role_id_where
					GROUP BY	master_users.id, master_user_courses.id
					ORDER BY	master_departments.department_name, master_users.last_name, master_users.first_name, master_users.middle_initial, master_courses.course_name, master_courses.id, master_user_courses.current_iteration
			";
		}

		if($limit !== NULL && is_numeric($limit)) {
			$stmt .= " LIMIT $limit";
		}

		if($offset !== NULL && is_numeric($offset)) {
			$stmt .= " OFFSET $offset";
		}

		$query = $this->db->query($stmt);

		if($query->num_rows() >= 1)
		{
			if($return_query_object)
			{
				return $query;
			}
			else
			{
				return $query->result_array();
			}
		}
		else
		{
			return array();
		}
	}

	public function get_user_courses_and_iterations($user_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

		$stmt = "
			SELECT		master_courses.id AS course_id,
						master_courses.course_name AS course_name,
						master_courses.max_iterations AS max_iterations,
						master_courses.url AS url,
						master_user_courses.current_iteration AS current_iteration,
						master_user_courses.has_completed AS has_completed,
						master_user_courses.has_passed AS has_passed,
						master_user_courses.date_registered AS date_registered,
						master_user_courses.active AS is_active,
						master_user_certificates.certificate_page_accepted,
							IF(master_user_certificates.certificate_accepted_by_user IS NULL, 0, master_user_certificates.certificate_accepted_by_user) AS certificate_accepted_by_user,
							IF(master_user_certificates.certificate_issued IS NULL, 0, master_user_certificates.certificate_issued) AS certificate_issued
			FROM		master_user_courses
			JOIN		master_courses
						ON master_courses.id=master_user_courses.course_id
						AND master_courses.organization_id=".PROPERTY_ORGANIZATION_ID."
						AND master_courses.active=1
					JOIN master_user_certificates
								ON master_user_certificates.user_id=master_user_courses.user_id
								AND master_user_certificates.course_id=master_user_courses.course_id
								AND master_user_certificates.active=1

			WHERE		master_user_courses.user_id = ?
			GROUP BY	master_user_courses.course_id,master_user_courses.current_iteration ASC
			ORDER BY	master_courses.course_name, master_user_courses.current_iteration ASC
		";

		$query = $this->db->query($stmt, array($user_id));

		if($query->num_rows() < 1)
		{
			return array();
		}
		else
		{
			return $query->result_array();
		}
	}

	function get_user_course_activity($user_id, $course, $response_id = FALSE)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = {$course['course_id']} | course_iteration = {$course['current_iteration']}");

		$return_value = array();
		$return_mode = 'result_array';
		$where = array(
			'user_id'		=> $user_id,
			'course_id'	=> $course['course_id'],
			'iteration'	=> $course['current_iteration']
		);

		if ($response_id !== FALSE)
		{
			$where['response_id'] = $response_id;
			$return_value = FALSE;
			$return_mode = 'row_array';
		}

		$query = $this->db->where($where)->get('master_user_course_activity');

		if($query->num_rows() < 1)
		{
			return $return_value;
		}
		else
		{
			return $query->{$return_mode}();
		}
	}

	public function get_user_course_activity_friendly($user_id, $course_id, $current_iteration)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = $course_id | course_iteration = $current_iteration");

		$stmt = "
		SELECT		master_courses.course_name AS course_name,
					master_course_elements.tltle AS title,
					master_courses.id AS course_id,
					master_user_courses.current_iteration AS current_iteration,
					master_user_course_activity.response_id AS response_id,
					master_user_course_activity.status AS status,
					master_user_course_activity.activity_log_id,
					master_activity_logs.date
		FROM		master_user_course_activity
		JOIN master_activity_logs
					ON master_activity_logs.id = master_user_course_activity.activity_log_id
		JOIN		master_user_courses
					ON master_user_courses.user_id=master_user_course_activity.user_id
					AND master_user_courses.course_id=master_user_course_activity.course_id
					AND master_user_courses.current_iteration=master_user_course_activity.iteration
		JOIN		master_courses
					ON master_courses.id=master_user_courses.course_id
		JOIN		master_course_elements
					ON master_course_elements.response_id=master_user_course_activity.response_id
		WHERE		master_user_course_activity.user_id = ?
					AND master_user_course_activity.course_id = ?
					AND master_user_course_activity.iteration = ?
					AND master_user_course_activity.active=1
		ORDER BY master_user_course_activity.activity_log_id ASC
		";

		$query = $this->db->query($stmt, array($user_id, $course_id, $current_iteration));

		if($query->num_rows() < 1)
		{
			return array();
		}

		return $query->result_array();
	}

	// $iteration = FALSE implies get the most recent test
	public function get_user_test($user_id, $course_iteration, $test_id, $current_iteration = FALSE)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_iteration = $current_iteration | test_id = $test_id");

		$where = array(
				'user_id'						=> $user_id,
				'course_iteration'	=> $course_iteration,
				'test_id'						=> $test_id
		);

		if ($current_iteration !== FALSE)
		{
			$where['current_iteration'] = $current_iteration;
		}
		else
		{
			$this->db->order_by('current_iteration DESC');
		}

		$query = $this->db->where($where)->get('master_user_tests');

		if($query->num_rows() < 1)
		{
			return FALSE;
		}
		else
		{
			return $query->row_array();
		}

	}

	public function get_user_tests($user_id, $course_iteration, $test_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_iteration = $course_iteration | test_id = $test_id");

		$where = array(
				'user_id'						=> $user_id,
				'course_iteration'	=> $course_iteration,
				'test_id'						=> $test_id
		);

		$query = $this->db->where($where)->get('master_user_tests');

		if($query->num_rows() < 1)
		{
			return array();
		}
		else
		{
			return $query->result_array();
		}
	}

	public function get_user_tests_for_course_iteration($user_id, $course_id, $current_iteration)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = $course_id | course_iteration = $current_iteration");

		$stmt = "
				SELECT		master_tests.test_name AS test_name,
							master_user_tests.current_iteration AS current_iteration,
							IF(master_tests.required=1, 'Yes', 'No') AS required,
							IF(master_user_tests.has_completed=1,'Yes','No') AS has_completed,
							IF(master_user_tests.has_passed=1,'Yes','No') AS has_passed,
							master_user_tests.score AS score
				FROM		master_tests
				JOIN master_course_elements
					ON master_course_elements.response_id = master_tests.key
					AND master_course_elements.parent != 112 -- Filters Out Audit C Questions
				JOIN		master_user_tests
							ON master_user_tests.test_id=master_tests.id
							AND master_user_tests.user_id='$user_id'
							AND master_user_tests.course_iteration='$current_iteration'
				JOIN		master_courses
							ON master_courses.id=master_tests.course_id
				JOIN		master_user_courses
							ON master_user_courses.course_id=master_courses.id
							AND master_user_courses.user_id = ?
							AND master_user_courses.current_iteration = ?
							AND master_user_courses.current_iteration=master_user_tests.course_iteration
				WHERE		master_tests.course_id = ?
				ORDER BY	master_user_courses.current_iteration, master_user_tests.current_iteration, master_user_tests.id
		";

		$query = $this->db->query($stmt, array($user_id, $current_iteration, $course_id));

		if($query->num_rows() < 1)
		{
			return array();
		}
		else
		{
			return $query->result_array();
		}
	}

	public function initialize_course_assignment_upon_registraton($user_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

		if (!($course = $this->get_initial_course_assignment($user_id) ))
		{
			return FALSE;
		}

		return $this->insert_user_course($user_id, $course['id']);
	}

	public function initialize_user_certificate($user_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

		if (!($ret = $this->get_active_course_and_accreditation_ids($user_id)))
		{
			return FALSE;
		}

		$course_id = $ret['course_id'];
		$accreditation_type_id = $ret['accreditation_type_id'];

		if (($certificate = $this->get_user_certificate($user_id, $course_id, $accreditation_type_id)))
		{
			return $certificate;
		}

		$data = array(
				'user_id'								=> $user_id,
				'course_id'							=> $course_id,
				'accreditation_type_id'	=> $accreditation_type_id
		);

		$this->db->insert('master_user_certificates', $data);

		return $this->get_user_certificate($user_id, $course_id, $accreditation_type_id);
	}

	public function initialize_user_test($user_id, $course_id, $course_iteration, $key)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = $course_id | course_iteration = $course_iteration | key = $key");

		if (!($test = $this->get_test($key)))
		{
			return FALSE;
		}

		$test_id = $test['id'];

		$next_iteration = $this->get_next_user_test_iteration($user_id, $course_iteration, $test_id);

		$data =	 array(
				'user_id'						=> $user_id,
				'course_iteration'	=> $course_iteration,
				'test_id'						=> $test_id,
				'current_iteration'	=> $next_iteration,
				'score'							=> 0,
				'has_completed'			=> 0,
				'has_passed'				=> 0
		);

		$this->db->insert('master_user_tests', $data);

		$user_master_test_id = $this->db->insert_id();

		$query = $this->db->where(array('id' => $user_master_test_id))->get('master_user_tests');

		if($query->num_rows() < 1)
		{
			return FALSE;
		}
		else
		{
			return $query->row_array();
		}
	}

	public function insert_user_course($user_id, $course_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = $course_id");

		$data = array(
			'user_id'					=> $user_id,
			'course_id'				=> $course_id,
			'date_registered'	=> $this->current_datetime,
			'active'					=> 1
		);

		$this->db->insert('master_user_courses', $data);

		return $this->db->insert_id();
	}

	public function insert_user_test_activity($user_test, $question_number, $answer, $activity_log_id)
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		if (($test_element = $this->get_test_element($user_test['test_id'], $question_number)) === FALSE)
		{
			return FALSE;
		}

		// deactivate old records
		$where = array(
			'user_id'						=> $user_test['user_id'],
			'course_iteration'	=> $user_test['course_iteration'],
			'test_element_id'		=> $test_element['id'],
			'iteration'					=> $user_test['current_iteration']
		);

		$this->db->where($where)->update('master_user_test_activity', array('active' => 0));
		// get iteration
		$data = array(
			'user_id'						=> $user_test['user_id'],
			'course_iteration'	=> $user_test['course_iteration'],
			'test_element_id'		=> $test_element['id'],
			'iteration'					=> $user_test['current_iteration'],
			'answer'						=> $answer,
			'activity_log_id'		=> $activity_log_id
		);

		$this->db->insert('master_user_test_activity', $data);

		return $this->db->insert_id();
	}

	public function update_user_course($user_course, $field, $value)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_course_id = {$user_course['user_course_id']} | field = $field | value = $value");

		if (($field !== 'has_completed') && ($field !== 'has_passed'))
		{
			die('aborted');
			return FALSE;
		}

		$where = array('id' => $user_course['user_course_id']);

		$data = array($field => $value);

		if ($field === 'has_completed')
		{
			$data['date_completed'] = $this->current_datetime;
		}

		$this->db->where(array('id' => $user_course['user_course_id']))->update('master_user_courses', $data);
		return TRUE;
	}

	// @TODO - add in sections visited logic to update values in master_user_courses table
	function update_user_course_activity($user_id, $course, $response_id, $status, $activity_log_id = 0, $attempt = 0)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = {$course['course_id']} | response_id = $response_id | status = $status | activity_log_id = $activity_log_id | attempt = $attempt");

		$data = array(
				'user_id'					=> $user_id,
				'course_id'				=> $course['course_id'],
				'response_id'			=> $response_id,
				'iteration'				=> $course['current_iteration'],
				'status'					=> $status,
				'activity_log_id'	=> $activity_log_id,
				'attempt'					=> $attempt
		);

		$user_course_activity = $this->get_user_course_activity($user_id, $course, $response_id);

		if (!empty($user_course_activity))
		{
			$this->db->where(array('id' => $user_course_activity['id']))->update('master_user_course_activity', $data);
		}
		else
		{
			$this->db->insert('master_user_course_activity', $data);

			$user_course_activity_id = $this->db->insert_id();

			// update master_user_courses.total_sections_visited and master_user_courses.percent_complete
			if(!empty($user_course_activity_id) && $status !== 'locked')
			{
				$this->update_master_user_courses_total_sections_visited($user_id, $course['course_id'], $course['current_iteration']);
				$this->update_master_user_courses_total_tests_surveys_visited($user_id, $course['course_id'], $course['current_iteration']);
				$this->update_master_user_courses_percent_complete($user_id, $course['course_id'], $course['current_iteration']);
			}
		}
	}

	public function update_user_test($user_test_id, $field, $value)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_test_id = $user_test_id | field = $field | value = $value");

		if (($field !== 'has_completed') && ($field !== 'has_passed') && ($field !== 'score'))
		{
			die('aborted');
			return FALSE;
		}

		$data = array($field => $value);

		if ($field === 'has_completed')
		{
			$data['date_completed'] = $this->current_datetime;
		}

		$this->db->where(array('id' => $user_test_id))->update('master_user_tests', $data);

		// update master_user_courses.total_tests_surveys_visited and master_user_courses.percent_complete
		if($field === 'has_completed' && $this->db->affected_rows() > 0)
		{
			$query = $this->db
				->select('t.user_id, s.course_id, t.course_iteration')
				->from('master_user_tests AS t')
				->join('master_tests AS s', 's.id = t.test_id')
				->where(array('t.id' => $user_test_id))
				->get();

			if($query->num_rows() > 0) {
				$test_details = $query->row_array();
				$this->update_master_user_courses_total_tests_surveys_visited($test_details['user_id'], $test_details['course_id'], $test_details['course_iteration']);
				$this->update_master_user_courses_percent_complete($test_details['user_id'], $test_details['course_id'], $test_details['course_iteration']);
			}
		}

		return TRUE;
	}

	public function update_master_user_courses_percent_complete($user_id, $course_id, $course_iteration)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = $course_id | course_iteration = $course_iteration");

		$sql = "
			UPDATE master_user_courses
			JOIN master_courses
				ON master_courses.id = master_user_courses.course_id
			SET percent_complete = ROUND(((master_user_courses.total_tests_surveys_visited + master_user_courses.total_sections_visited) / (master_courses.total_tests_surveys + master_courses.total_sections)) * 100, 2)
			WHERE
				master_user_courses.user_id = ?
				AND master_user_courses.course_id = ?
				AND master_user_courses.current_iteration = ?
		";

		$this->db->query($sql, array($user_id, $course_id, $course_iteration));
	}

	public function update_master_user_courses_total_sections_visited($user_id, $course_id, $course_iteration)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = $course_id | course_iteration = $course_iteration");

		$user_id = $this->db->escape_str($user_id);
		$course_id = $this->db->escape_str($course_id);
		$course_iteration = $this->db->escape_str($course_iteration);

		$sql = "
			UPDATE master_user_courses
			SET master_user_courses.total_sections_visited = (
				SELECT COUNT(DISTINCT master_user_course_activity.id)
				FROM master_course_elements
				JOIN	master_user_course_activity
						ON master_user_course_activity.response_id = master_course_elements.response_id
				WHERE
						master_course_elements.response_id != ''
						AND master_course_elements.response_id IS NOT NULL
						AND master_course_elements.is_test = 0
						AND master_course_elements.active = 1
						AND master_user_course_activity.user_id = $user_id
						AND master_user_course_activity.course_id = $course_id
						AND master_user_course_activity.iteration = $course_iteration
						-- AND master_user_course_activity.`status` != 'locked'
						AND master_user_course_activity.active = 1
			)
			WHERE
				master_user_courses.user_id = $user_id
				AND master_user_courses.course_id = $course_id
				AND master_user_courses.current_iteration = $course_iteration
		";

		$this->db->query($sql);
	}

	public function update_master_user_courses_total_tests_surveys_visited($user_id, $course_id, $course_iteration)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | course_id = $course_id | course_iteration = $course_iteration");

		$user_id = $this->db->escape_str($user_id);
		$course_id = $this->db->escape_str($course_id);
		$course_iteration = $this->db->escape_str($course_iteration);

		$sql = "
			UPDATE master_user_courses as t
			JOIN (
				SELECT
					user_id,
					course_id,
					course_iteration,
					COUNT(distinct test_key) AS tests_completed
				FROM (
				(
					SELECT
						master_user_course_activity.user_id,
						master_user_course_activity.course_id,
						master_user_course_activity.iteration AS course_iteration,
						master_tests.id AS test_id,
						master_user_course_activity.response_id AS test_key
					FROM master_tests
					JOIN master_user_course_activity
						ON master_user_course_activity.response_id = master_tests.key
					WHERE
						master_user_course_activity.user_id = $user_id
						AND master_user_course_activity.course_id = $course_id
						AND master_user_course_activity.iteration = $course_iteration
						AND master_user_course_activity.active = 1
						AND master_tests.active = 1
				) UNION (
					SELECT
						master_user_tests.user_id,
						master_tests.course_id,
						master_user_tests.course_iteration,
						master_user_tests.test_id,
						master_tests.key as test_key
					FROM master_tests
					JOIN master_user_tests
						ON master_user_tests.test_id = master_tests.id
					WHERE
						master_user_tests.user_id = $user_id
						AND master_user_tests.course_iteration = $course_iteration
						AND master_user_tests.active = 1
						AND master_tests.course_id = $course_id
						AND master_tests.active = 0
				)) AS test_activity
				GROUP BY test_activity.user_id, test_activity.course_id, test_activity.course_iteration
			) AS r
			ON
				r.user_id = t.user_id
				AND r.course_id = t.course_id
				AND r.course_iteration = t.current_iteration
			SET t.total_tests_surveys_visited = r.tests_completed
		";

		$this->db->query($sql);
	}

}//class

?>
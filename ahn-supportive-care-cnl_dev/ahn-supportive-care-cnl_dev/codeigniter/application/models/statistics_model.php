<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Statistics_model extends CI_Model {

	private $_filters = array(
		'start_datetime'				=> NULL,
		'end_datetime'					=> NULL,
		'accreditation_type_id' => NULL,
		'department_id'					=> NULL,
		'treatment_facility_id'	=> NULL,
		'role_id'								=> NULL
	);

	private $_join_clauses = array(
		'department'					=> '',
		'treatment_facility'	=> ''
	);

	private $_where_clauses = array(
		'master_user_tests_datetime_between'		=> ' 1 = 1 ',
		'master_activity_logs_datetime_between'	=> ' AND 1 = 1',
		'accreditation_type_id'									=> ' AND 1 = 1 ',
		'department_id'													=> ' AND 1 = 1 ',
		'treatment_facility_id'									=> ' AND 1 = 1 ',
		'role_id'																=> ' AND 1 = 1 '
	);

	public function __construct() {
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	/**
	 * set_filters - set the filters for where clauses used in all statistics queries
	 * @param numeric $department_id
	 * @param numeric $treatment_facility_id
	 * @param numeric $role_id
	 * @return Statistics_model object
	 */
	public function set_filters($start_date = NULL, $end_date = NULL, $accreditation_type_id = NULL, $department_id = NULL, $treatment_facility_id = NULL, $role_id = NULL) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with start_date = $start_date | end_date = $end_date | accreditation_type_id = $accreditation_type_id | department_id = $department_id | treatment_facility_id = $treatment_facility_id | role_id = $role_id");

		if($start_date !== NULL  && !empty($start_date)  && is_string($start_date) && $end_date !== NULL  && !empty($end_date)  && is_string($end_date)) {
			$this->_filters['start_datetime'] = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($start_date))));
			$this->_filters['end_datetime'] = date('Y-m-d H:i:s', strtotime(date('Y-m-d', strtotime($end_date) + 24*60*60)));
			$this->_where_clauses['master_user_tests_datetime_bewteen'] = " master_user_tests.date_completed BETWEEN '{$this->_filters['start_datetime']}'  AND '{$this->_filters['end_datetime']}'";
			$this->_where_clauses['master_activity_logs_datetime_bewteen'] = " AND master_activity_logs.date BETWEEN '{$this->_filters['start_datetime']}'  AND '{$this->_filters['end_datetime']}'";
		}

		if($accreditation_type_id !== NULL && is_numeric($accreditation_type_id)) {
			$this->_filters['accreditation_type_id'] = $this->db->escape_str($accreditation_type_id);
			$this->_where_clauses['accreditation_type_id'] = ' AND master_user_accreditation_map.accreditation_type_id = ' . $this->_filters['accreditation_type_id'];
		}

		if($department_id !== NULL && is_numeric($department_id)) {
			$this->_filters['department_id'] = $this->db->escape_str($department_id);
			$this->_join_clauses['department'] = 'JOIN master_user_department_map ON master_user_department_map.user_id = master_users.id';
			$this->_where_clauses['department_id'] = ' AND master_user_department_map.department_id = ' . $this->_filters['department_id'] . ' AND master_user_department_map.active = 1';
		}

		if($treatment_facility_id !== NULL && is_numeric($treatment_facility_id)) {
			$this->_filters['treatment_facility_id'] = $this->db->escape_str($treatment_facility_id);
			$this->_join_clauses['treatment_facility'] = 'JOIN master_user_treatment_facility_map ON master_user_treatment_facility_map.user_id = master_users.id';
			$this->_where_clauses['treatment_facility_id'] = ' AND master_user_treatment_facility_map.treatment_facility_id = ' . $this->_filters['treatment_facility_id'] . ' AND master_user_treatment_facility_map.active = 1';
		}

		if($role_id !== NULL && is_numeric($role_id)) {
			$this->_filters['role_id'] = $this->db->escape_str($role_id);
			$this->_where_clauses['role_id'] = ' AND master_user_role_map.role_id = ' . $this->_filters['role_id'];
		}

		return $this;
	}

	/**
	 * get_statistics - wrapper method to obtain all relevant survey, test, and question statistics
	 * @return array
	 */
	public function get_statistics($start_date = NULL, $end_date = NULL, $accreditation_type_id = NULL, $department_id = NULL, $treatment_facility_id = NULL, $role_id = NULL) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with start_date = $start_date | end_date = $end_date | accreditation_type_id = $accreditation_type_id | department_id = $department_id | treatment_facility_id = $treatment_facility_id | role_id = $role_id");

		$this->set_filters($start_date, $end_date, $accreditation_type_id, $department_id, $treatment_facility_id, $role_id);

		switch(MR_PROJECT) {
			case 'dod':
				$statistics = array(
					'alcohol_sbirt_one_hour'	=> array(
						'pre_test'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'content_knowledge'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'practice'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'post_test_competence'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'satisfaction_survey'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						)
					),
					'alcohol_sbirt_three_hour'	=> array(
						'pre_test'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'content_knowledge'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'practice'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'post_test_competence'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'satisfaction_survey'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						)
					)
				);

				$courses = array(
					'alcohol_sbirt_one_hour' => array(
						'test' 	=> array(
							'content_knowledge'	=> 'dod_1hr_post_test_content',
						),
						'survey'	=> array(
							'pre_test'							=> 'dod_1hr_pre_test',
							'practice'							=> 'dod_1hr_practice',
							'post_test_competence'	=> 'dod_1hr_post_test_competence',
							'satisfaction_survey'		=> 'dod_1hr_post_test_satisfaction'
						)
					),
					'alcohol_sbirt_three_hour' => array(
						'test' 	=> array(
							'content_knowledge'	=> 'dod_3hr_post_test_content',
						),
						'survey'	=> array(
							'pre_test'							=> 'dod_3hr_pre_test',
							'practice'							=> 'dod_3hr_practice',
							'post_test_competence'	=> 'dod_3hr_post_test_competence',
							'satisfaction_survey'		=> 'dod_3hr_post_test_satisfaction'
						)
					)
				);
			break;

			case 'rush':
				$statistics = array(
					'alcohol_sbirt_one_hour'	=> array(
						'pre_test'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'content_knowledge'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'practice'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'post_test_competence'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'satisfaction_survey'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						)
					),
					'sbirt_coach_three_hour'	=> array(
						'pre_test'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'content_knowledge'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'post_test_competence'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'satisfaction_survey'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						)
					)
				);

				$courses = array(
					'alcohol_sbirt_one_hour' => array(
						'test' 	=> array(
							'content_knowledge'	=> 'dod_1hr_post_test_content',
						),
						'survey'	=> array(
							'pre_test'							=> 'dod_1hr_pre_test',
							'practice'							=> 'dod_1hr_practice',
							'post_test_competence'	=> 'dod_1hr_post_test_competence',
							'satisfaction_survey'		=> 'dod_1hr_post_test_satisfaction'
						)
					),
					'sbirt_coach_three_hour' => array(
						'test' 	=> array(
							'content_knowledge'	=> 'pas_p1_post_test_content',
						),
						'survey'	=> array(
							'pre_test'							=> 'pas_p1_pre_test',
							'post_test_competence'	=> 'pas_p1_post_test_competence',
							'satisfaction_survey'		=> 'pas_p1_post_test_satisfaction'
						)
					)
				);
			break;

			case 'sbirt':
				$statistics = array(
					'alcohol_sbirt_one_hour'	=> array(
						'pre_test'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'content_knowledge'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'practice'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'post_test_competence'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'satisfaction_survey'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						)
					),
					'alcohol_sbirt_three_hour'	=> array(
						'pre_test'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'content_knowledge'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'practice'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'post_test_competence'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'satisfaction_survey'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						)
					),
					'sbirt_coach_three_hour'	=> array(
						'pre_test'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'content_knowledge'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'post_test_competence'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						),
						'satisfaction_survey'	=> array(
							'overall'	=> array(),
							'individual_questions'	=> array()
						)
					)
				);

				$courses = array(
					'alcohol_sbirt_one_hour' => array(
						'test' 	=> array(
							'content_knowledge'	=> 'dod_1hr_post_test_content',
						),
						'survey'	=> array(
							'pre_test'							=> 'dod_1hr_pre_test',
							'practice'							=> 'dod_1hr_practice',
							'post_test_competence'	=> 'dod_1hr_post_test_competence',
							'satisfaction_survey'		=> 'dod_1hr_post_test_satisfaction'
						)
					),
					'alcohol_sbirt_three_hour' => array(
						'test' 	=> array(
							'content_knowledge'	=> 'dod_3hr_post_test_content',
						),
						'survey'	=> array(
							'pre_test'							=> 'dod_3hr_pre_test',
							'practice'							=> 'dod_3hr_practice',
							'post_test_competence'	=> 'dod_3hr_post_test_competence',
							'satisfaction_survey'		=> 'dod_3hr_post_test_satisfaction'
						)
					),
					'sbirt_coach_three_hour' => array(
						'test' 	=> array(
							'content_knowledge'	=> 'pas_p1_post_test_content',
						),
						'survey'	=> array(
							'pre_test'							=> 'pas_p1_pre_test',
							'post_test_competence'	=> 'pas_p1_post_test_competence',
							'satisfaction_survey'		=> 'pas_p1_post_test_satisfaction'
						)
					)
				);
			break;

			default:
				log_error(__FILE__, __LINE__, __METHOD__, 'Statistics config not set for ' . MR_PROJECT);
				return array();
			break;
		};

		foreach($courses as $course => $types) {
			foreach($types as $test_type => $tests) {
				foreach($tests as $test_name => $test_key) {
					if($test_type === 'survey') {
						$statistics[$course][$test_name]['overall'] = $this->get_survey_overall_statistics($test_key);
						$statistics[$course][$test_name]['individual_questions'] = $this->get_survey_question_statistics($test_key);
					} else {
						$statistics[$course][$test_name]['overall'] = $this->get_test_statistics($test_key);
						$statistics[$course][$test_name]['individual_questions'] = $this->get_questions_statistics($test_key);
					}

					$answers = $this->course_model->get_possible_test_answers($test_key);

					foreach($statistics[$course][$test_name]['individual_questions'] as $question_index => $question) {
						$statistics[$course][$test_name]['individual_questions'][$question_index]['answers'] = array_values(array_filter($answers, function($answer) use($question){
							return $answer['question_number'] == $question['question_number'];
						}));
					}
				}
			}
		}

		return $statistics;
	}

	/**
	 * get_test_statistics - returns overall test statistics for the dod_1hr_post_test_content and dod_3hr_post_test_content tests
	 * @param string $master_tests_key - master_tests.key to calculate test statistics for
	 * @return array
	 */
	public function get_test_statistics($master_tests_key) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with master_tests_key = $master_tests_key");

		$statistics = array();
		$acceptable_master_test_keys = array('dod_1hr_post_test_content', 'dod_3hr_post_test_content', 'pas_p1_post_test_content');

		if(empty($master_tests_key) || !is_string($master_tests_key) || !in_array($master_tests_key, $acceptable_master_test_keys)) {
			return $statistics;
		}

		$master_tests_key = $this->db->escape_str($master_tests_key);

		$sql = "
			SELECT
				COUNT(*) as tests_taken_count,
				ROUND(AVG(master_user_tests.score), 2) as average_score
			FROM (
				SELECT
					master_user_tests.user_id,
					master_user_tests.test_id,
					most_recent_master_user_tests_course_iteration.course_iteration,
					MAX(master_user_tests.current_iteration) AS current_iteration
				FROM (
					SELECT
						master_user_tests.user_id,
						master_user_tests.test_id,
						MAX(master_user_tests.course_iteration) AS course_iteration
					FROM master_user_tests
					JOIN master_users
						ON master_users.id = master_user_tests.user_id
					JOIN master_user_accreditation_map
						ON master_users.id = master_user_accreditation_map.user_id
					{$this->_join_clauses['department']}
					{$this->_join_clauses['treatment_facility']}
					JOIN master_user_role_map
						ON master_user_role_map.user_id = master_users.id
					WHERE
						{$this->_where_clauses['master_user_tests_datetime_bewteen']}
						AND master_user_tests.active = 1
						AND master_users.active = 1
						{$this->_where_clauses['accreditation_type_id']}
						AND master_user_accreditation_map.active = 1
						{$this->_where_clauses['department_id']}
						{$this->_where_clauses['treatment_facility_id']}
						{$this->_where_clauses['role_id']}
						AND master_user_role_map.active = 1
					GROUP BY user_id, test_id
				) AS most_recent_master_user_tests_course_iteration
				JOIN master_user_tests
					ON master_user_tests.user_id = most_recent_master_user_tests_course_iteration.user_id
						AND master_user_tests.test_id = most_recent_master_user_tests_course_iteration.test_id
						AND master_user_tests.course_iteration = most_recent_master_user_tests_course_iteration.course_iteration
				JOIN master_tests
					ON master_tests.id = master_user_tests.test_id
				WHERE master_tests.key = '$master_tests_key'
				GROUP BY user_id, test_id
			) AS most_recent_master_user_tests_current_iteration
			JOIN master_user_tests
				ON master_user_tests.user_id = most_recent_master_user_tests_current_iteration.user_id
				AND master_user_tests.test_id = most_recent_master_user_tests_current_iteration.test_id
				AND master_user_tests.course_iteration = most_recent_master_user_tests_current_iteration.course_iteration
				AND master_user_tests.current_iteration = most_recent_master_user_tests_current_iteration.current_iteration
			JOIN master_tests
				ON master_tests.id = master_user_tests.test_id
			JOIN master_courses
				ON master_courses.id = master_tests.course_id
			WHERE master_courses.organization_id = " .PROPERTY_ORGANIZATION_ID;

		$query = $this->db->query($sql);

		if($query->num_rows() === 1) {
			$statistics = $query->row_array();
		}

		return $statistics;
	}

	/**
	 * get_questsions_statistics - returns statistics for each question in the dod_1hr_post_test_content and dod_3hr_post_test_content tests
	 * @param string $master_tests_key - master_tests.key to calculate question statistics for
	 * @return array
	 */
	public function get_questions_statistics($master_tests_key) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with master_tests_key = $master_tests_key");

		$statistics = array();
		$acceptable_master_test_keys = array('dod_1hr_post_test_content', 'dod_3hr_post_test_content', 'pas_p1_post_test_content');

		if(empty($master_tests_key) || !is_string($master_tests_key) || !in_array($master_tests_key, $acceptable_master_test_keys)) {
			return $statistics;
		}

		$master_tests_key = $this->db->escape_str($master_tests_key);

		$sql = "
			SELECT
				master_user_test_activity.test_element_id,
				master_test_elements.question,
				master_test_elements.question_number,
				SUM(IF(master_user_test_activity.answer = master_test_elements.correct_answer, 1, 0)) AS num_correct,
				SUM(IF(master_user_test_activity.answer != master_test_elements.correct_answer, 1, 0)) AS num_incorrect,
				COUNT(*) AS num_responses,
				ROUND((SUM(master_user_test_activity.answer = master_test_elements.correct_answer) / COUNT(*)) * 100, 2) as percent_correct
			FROM(
				SELECT
					master_user_test_activity.test_element_id,
					master_user_test_activity.answer
				FROM (
					-- determine the most recent test iteration of the most recent course_iteration for each (user_id, test_element_id)
					SELECT
						master_user_test_activity.user_id,
						master_user_test_activity.test_element_id,
						most_recent_master_user_test_activity_course_iteration.course_iteration,
						MAX(master_user_test_activity.iteration) AS iteration
					FROM (
						-- determine the most recent course_iteration for each (user, test_element_id)
						SELECT
							master_user_test_activity.user_id,
							master_user_test_activity.test_element_id,
							MAX(master_user_test_activity.course_iteration) AS course_iteration
						FROM master_user_test_activity
						JOIN master_users
							ON master_users.id = master_user_test_activity.user_id
						JOIN master_user_accreditation_map
							ON master_users.id = master_user_accreditation_map.user_id
						{$this->_join_clauses['department']}
						{$this->_join_clauses['treatment_facility']}
						JOIN master_user_role_map
							ON master_user_role_map.user_id = master_users.id
						JOIN master_activity_logs
							ON master_activity_logs.id = master_user_test_activity.activity_log_id
						WHERE
							master_user_test_activity.active = 1
							AND master_users.active = 1
							{$this->_where_clauses['accreditation_type_id']}
							AND master_user_accreditation_map.active = 1
							{$this->_where_clauses['department_id']}
							{$this->_where_clauses['treatment_facility_id']}
							{$this->_where_clauses['role_id']}
							AND master_user_role_map.active = 1
							{$this->_where_clauses['master_activity_logs_datetime_bewteen']}
						GROUP BY master_user_test_activity.user_id, master_user_test_activity.test_element_id
					) AS most_recent_master_user_test_activity_course_iteration
					JOIN master_user_test_activity
						ON master_user_test_activity.user_id = most_recent_master_user_test_activity_course_iteration.user_id
						AND master_user_test_activity.test_element_id = most_recent_master_user_test_activity_course_iteration.test_element_id
						AND master_user_test_activity.course_iteration = most_recent_master_user_test_activity_course_iteration.course_iteration
					GROUP BY master_user_test_activity.user_id, master_user_test_activity.test_element_id
				) AS most_recent_master_user_test_activity_test_iteration
				JOIN master_user_test_activity
					ON master_user_test_activity.user_id = most_recent_master_user_test_activity_test_iteration.user_id
					AND master_user_test_activity.test_element_id = most_recent_master_user_test_activity_test_iteration.test_element_id
					AND master_user_test_activity.course_iteration = most_recent_master_user_test_activity_test_iteration.course_iteration
					AND master_user_test_activity.iteration = most_recent_master_user_test_activity_test_iteration.iteration
			) AS master_user_test_activity
			JOIN master_test_elements
				ON master_test_elements.id = master_user_test_activity.test_element_id
			JOIN master_tests
				ON master_tests.id = master_test_elements.test_id
			JOIN master_courses
				ON master_courses.id = master_tests.course_id
			WHERE
				master_courses.organization_id = " .PROPERTY_ORGANIZATION_ID."
				AND master_tests.key = '$master_tests_key'
			GROUP BY master_user_test_activity.test_element_id
			ORDER BY master_test_elements.question_number ASC
		";

		$query = $this->db->query($sql);

		if($query->num_rows() > 0) {
			$statistics = $query->result_array();
		}

		return $statistics;
	}

	/**
	 * get_survey_overall_statistics - returns overall statistics for survey type tests containing questions that don't have a correct answer
	 * @param string $master_tests_key - master_tests.key to calculate survey statistics for
	 * @return array
	 */
	public function get_survey_overall_statistics($master_tests_key) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with master_tests_key = $master_tests_key");

		$statistics = array();
		$acceptable_master_test_keys = array(
			'dod_1hr_pre_test',
			'dod_3hr_pre_test',
			'pas_p1_pre_test',
			'dod_1hr_practice',
			'dod_3hr_practice',
			'dod_1hr_post_test_competence',
			'dod_3hr_post_test_competence',
			'pas_p1_post_test_competence',
			'dod_1hr_post_test_satisfaction',
			'dod_3hr_post_test_satisfaction',
			'pas_p1_post_test_satisfaction'
		);

		if(empty($master_tests_key) || !is_string($master_tests_key) || !in_array($master_tests_key, $acceptable_master_test_keys)) {
			return $statistics;
		}

		$master_tests_key = $this->db->escape_str($master_tests_key);

		$sql = "
			SELECT
				ROUND(MIN(master_user_test_activity.answer), 2) AS minimum_response,
				ROUND(MAX(master_user_test_activity.answer), 2) AS maximum_response,
				ROUND(AVG(master_user_test_activity.answer),2) AS average_response,
				ROUND(VAR_SAMP(master_user_test_activity.answer), 2) AS response_variance,
				ROUND(STDDEV_SAMP(master_user_test_activity.answer), 2) AS response_standard_deviation,
				COUNT(*) AS num_responses,
				COUNT(DISTINCT master_user_test_activity.user_id) AS num_responders
			FROM(
				SELECT
					master_user_test_activity.user_id,
					master_user_test_activity.test_element_id,
					master_user_test_activity.answer
				FROM (
					-- determine the most recent test iteration of the most recent course_iteration for each (user_id, test_element_id)
					SELECT
						master_user_test_activity.user_id,
						master_user_test_activity.test_element_id,
						most_recent_master_user_test_activity_course_iteration.course_iteration,
						MAX(master_user_test_activity.iteration) AS iteration
					FROM (
						-- determine the most recent course_iteration for each (user, test_element_id)
						SELECT
							master_user_test_activity.user_id,
							master_user_test_activity.test_element_id,
							MAX(master_user_test_activity.course_iteration) AS course_iteration
						FROM master_user_test_activity
						JOIN master_users
							ON master_users.id = master_user_test_activity.user_id
						JOIN master_user_accreditation_map
							ON master_users.id = master_user_accreditation_map.user_id
						{$this->_join_clauses['department']}
						{$this->_join_clauses['treatment_facility']}
						JOIN master_user_role_map
							ON master_user_role_map.user_id = master_users.id
						JOIN master_activity_logs
							ON master_activity_logs.id = master_user_test_activity.activity_log_id
						WHERE
							master_user_test_activity.active = 1
							AND master_users.active = 1
							{$this->_where_clauses['accreditation_type_id']}
							AND master_user_accreditation_map.active = 1
							{$this->_where_clauses['department_id']}
							{$this->_where_clauses['treatment_facility_id']}
							{$this->_where_clauses['role_id']}
							AND master_user_role_map.active = 1
							{$this->_where_clauses['master_activity_logs_datetime_bewteen']}
						GROUP BY user_id, test_element_id
					) AS most_recent_master_user_test_activity_course_iteration
					JOIN master_user_test_activity
						ON master_user_test_activity.user_id = most_recent_master_user_test_activity_course_iteration.user_id
						AND master_user_test_activity.test_element_id = most_recent_master_user_test_activity_course_iteration.test_element_id
						AND master_user_test_activity.course_iteration = most_recent_master_user_test_activity_course_iteration.course_iteration
					GROUP BY master_user_test_activity.user_id, master_user_test_activity.test_element_id
				) AS most_recent_master_user_test_activity_test_iteration
				JOIN master_user_test_activity
					ON master_user_test_activity.user_id = most_recent_master_user_test_activity_test_iteration.user_id
					AND master_user_test_activity.test_element_id = most_recent_master_user_test_activity_test_iteration.test_element_id
					AND master_user_test_activity.course_iteration = most_recent_master_user_test_activity_test_iteration.course_iteration
					AND master_user_test_activity.iteration = most_recent_master_user_test_activity_test_iteration.iteration
			) AS master_user_test_activity
			JOIN master_test_elements
				ON master_test_elements.id = master_user_test_activity.test_element_id
			JOIN master_tests
				ON master_tests.id = master_test_elements.test_id
			JOIN master_courses
				ON master_courses.id = master_tests.course_id
			WHERE
				master_courses.organization_id = " .PROPERTY_ORGANIZATION_ID."
				AND master_tests.key = '$master_tests_key'
		";

		$query = $this->db->query($sql);

		if($query->num_rows() === 1) {
			$statistics = $query->row_array();
		}

		return $statistics;
	}

	/**
	 * get_survey_question_statistics - returns statistics for each individual question in survey type tests containing questions that don't have a right answer
	 * @param string $master_tests_key - master_tests.key to calculate survey statistics for
	 * @return array
	 */
	public function get_survey_question_statistics($master_tests_key) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with master_tests_key = $master_tests_key");

		$statistics = array();
		$acceptable_master_test_keys = array(
			'dod_1hr_pre_test',
			'dod_3hr_pre_test',
			'pas_p1_pre_test',
			'dod_1hr_practice',
			'dod_3hr_practice',
			'dod_1hr_post_test_competence',
			'dod_3hr_post_test_competence',
			'pas_p1_post_test_competence',
			'dod_1hr_post_test_satisfaction',
			'dod_3hr_post_test_satisfaction',
			'pas_p1_post_test_satisfaction'
		);

		if(empty($master_tests_key) || !is_string($master_tests_key) || !in_array($master_tests_key, $acceptable_master_test_keys)) {
			return $statistics;
		}

		$master_tests_key = $this->db->escape_str($master_tests_key);

		$sql = "
			SELECT
				master_user_test_activity.test_element_id,
				master_test_elements.question,
				master_test_elements.question_number,
				ROUND(MIN(master_user_test_activity.answer), 2) AS minimum_response,
				ROUND(MAX(master_user_test_activity.answer), 2) AS maximum_response,
				ROUND(AVG(master_user_test_activity.answer),2) AS average_response,
				ROUND(VAR_SAMP(master_user_test_activity.answer), 2) AS response_variance,
				ROUND(STDDEV_SAMP(master_user_test_activity.answer), 2) AS response_standard_deviation,
				COUNT(*) AS num_responses
			FROM(
				SELECT
					master_user_test_activity.test_element_id,
					master_user_test_activity.answer
				FROM (
					-- determine the most recent test iteration of the most recent course_iteration for each (user_id, test_element_id)
					SELECT
						master_user_test_activity.user_id,
						master_user_test_activity.test_element_id,
						most_recent_master_user_test_activity_course_iteration.course_iteration,
						MAX(master_user_test_activity.iteration) AS iteration
					FROM (
						-- determine the most recent course_iteration for each (user, test_element_id)
						SELECT
							master_user_test_activity.user_id,
							master_user_test_activity.test_element_id,
							MAX(master_user_test_activity.course_iteration) AS course_iteration
						FROM master_user_test_activity
						JOIN master_users
							ON master_users.id = master_user_test_activity.user_id
						JOIN master_user_accreditation_map
							ON master_users.id = master_user_accreditation_map.user_id
						{$this->_join_clauses['department']}
						{$this->_join_clauses['treatment_facility']}
						JOIN master_user_role_map
							ON master_user_role_map.user_id = master_users.id
						JOIN master_activity_logs
							ON master_activity_logs.id = master_user_test_activity.activity_log_id
						WHERE
							master_user_test_activity.active = 1
							AND master_users.active = 1
							{$this->_where_clauses['accreditation_type_id']}
							AND master_user_accreditation_map.active = 1
							{$this->_where_clauses['department_id']}
							{$this->_where_clauses['treatment_facility_id']}
							{$this->_where_clauses['role_id']}
							AND master_user_role_map.active = 1
							{$this->_where_clauses['master_activity_logs_datetime_bewteen']}
						GROUP BY user_id, test_element_id
					) AS most_recent_master_user_test_activity_course_iteration
					JOIN master_user_test_activity
						ON master_user_test_activity.user_id = most_recent_master_user_test_activity_course_iteration.user_id
						AND master_user_test_activity.test_element_id = most_recent_master_user_test_activity_course_iteration.test_element_id
						AND master_user_test_activity.course_iteration = most_recent_master_user_test_activity_course_iteration.course_iteration
					GROUP BY master_user_test_activity.user_id, master_user_test_activity.test_element_id
				) AS most_recent_master_user_test_activity_test_iteration
				JOIN master_user_test_activity
					ON master_user_test_activity.user_id = most_recent_master_user_test_activity_test_iteration.user_id
					AND master_user_test_activity.test_element_id = most_recent_master_user_test_activity_test_iteration.test_element_id
					AND master_user_test_activity.course_iteration = most_recent_master_user_test_activity_test_iteration.course_iteration
					AND master_user_test_activity.iteration = most_recent_master_user_test_activity_test_iteration.iteration
			) AS master_user_test_activity
			JOIN master_test_elements
				ON master_test_elements.id = master_user_test_activity.test_element_id
			JOIN master_tests
				ON master_tests.id = master_test_elements.test_id
			JOIN master_courses
				ON master_courses.id = master_tests.course_id
			WHERE
				master_courses.organization_id = " .PROPERTY_ORGANIZATION_ID."
				AND master_tests.key = '$master_tests_key'
			GROUP BY test_element_id
			ORDER BY master_test_elements.question_number ASC
		";

		$query = $this->db->query($sql);

		if($query->num_rows() > 0) {
			$statistics = $query->result_array();
		}

		return $statistics;
	}

}

/* End of file statistics_model.php */
/* Location: ./application/models/statistics_model.php */

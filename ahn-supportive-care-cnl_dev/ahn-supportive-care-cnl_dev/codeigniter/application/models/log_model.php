<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_model extends CI_Model
{
	private $account_id = FALSE;
	private $user_type = FALSE;
	private $session_id = FALSE;
	private $ip_address = FALSE;

	public function __construct()
	{
		parent::__construct();
		$this->load->dbutil();
		$this->account_id = $this->session->userdata('account_id');
		$this->user_type = $this->session->userdata('user_type');
		$this->session_id = $this->session->userdata('session_id');
		$this->ip_address = $this->session->userdata('ip_address');

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function get_activity_logs(
		$mr_project_filter = FALSE,
		$language_filter = FALSE,
		$offset = 0,
		$number_of_rows = FALSE,
		$search_keyword = FALSE,
		$search_start_date = FALSE,
		$search_end_date = FALSE,
		$organization_hierarchy_level_elements_filter = array(),
		$user_id_filter,
		$return_query_object = FALSE
	)
	{
		$limit_string = "";
		$where_user_id = '1 = 1';
		$search_where_mr_project_filter_string = 'AND 1 = 1';
		$search_where_was_asl_response_string = 'AND 1 = 1';
		$search_where_keyword_string = 'AND 1 = 1';
		$search_where_date_range_string = 'AND 1 = 1';
		$where_organization_hierarchy = 'AND 1 = 1';

		log_info(__FILE__, __LINE__, __METHOD__, "Called with search_keyword = $search_keyword");

		if(!empty($user_id_filter)) {
			$where_user_id = 'master_activity_logs.user_id NOT IN (' . implode(', ', $user_id_filter) . ')';
		}

		if(!empty($mr_project_filter)) {
			$mr_project_filter = $this->db->escape_str($mr_project_filter);
			$search_where_mr_project_filter_string = "AND master_activity_logs.mr_project = '$mr_project_filter'";
		}

		if($language_filter === 'english') {
			$search_where_was_asl_response_string = "AND master_activity_logs.was_asl_response = 0";
		} else if($language_filter === 'asl') {
			$search_where_was_asl_response_string = "AND master_activity_logs.was_asl_response = 1";
		}

		if (!empty($search_keyword)) {
			$search_keyword = $this->db->escape_str($search_keyword);
			$search_where_keyword_string = " AND
				(
					master_users.username like '%$search_keyword%'
					OR
					master_activity_logs.browser like '%$search_keyword%'
					OR
					master_activity_logs.action like '%$search_keyword%'
					OR
					master_activity_logs.input_question like '%$search_keyword%'
					OR
					master_activity_logs.response_question like '%$search_keyword%'
					OR
					master_activity_logs.ip_address like '%$search_keyword%'
				)
			";
		}

		if(($search_start_date != FALSE) && ($search_end_date != FALSE))
		{
			$search_start_date = $this->db->escape_str($search_start_date);
			$search_end_date = $this->db->escape_str($search_end_date);
			$search_where_date_range_string = " AND
				(
					( master_activity_logs.date>= '$search_start_date')
					AND
					( master_activity_logs.date<= '". date('Y-m-d', strtotime($search_end_date) + 24*60*60) . "')
				)
			";
		}

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

		if($number_of_rows != FALSE && is_numeric($number_of_rows))
		{
			$limit_string = "LIMIT $offset, $number_of_rows";
		}

		if(is_site_admin()) {
			$select = "
				master_users.username as username,
				master_activity_logs.session_id as session_id,
				master_activity_logs.action as action,
				master_activity_logs.input_question as input_question,
				master_activity_logs.response_question as response_question,
				DATE_FORMAT(master_activity_logs.date, '%m/%d/%Y %H:%i:%s') as date
			";
		} else {
			$select = "
				master_activity_logs.id as id,
				master_users.username as username,
				master_activity_logs.user_id as user_id,
				-- master_activity_logs.ip_address as ip_address,
				master_activity_logs.operating_system as operating_system,
				master_activity_logs.browser as browser,
				master_activity_logs.session_id as session_id,
				master_activity_logs.action as action,
				master_activity_logs.input_question as input_question,
				master_activity_logs.input_question_disambiguated as input_question_disambiguated,
				master_activity_logs.case_name as case_name,
				master_activity_logs.current_response as current_response,
				master_activity_logs.response_id as response_id,
				master_activity_logs.response_question as response_question,
				master_activity_logs.response_type as response_type,
				IF(master_activity_logs.was_asl_response = 1, 'Yes', 'No') as was_asl_response,
				master_activity_logs.ma_response_id as multiple_answer_response_ids,
				master_activity_logs.ma_question_1 as multiple_answer_question_1,
				master_activity_logs.ma_question_2 as multiple_answer_question_2,
				master_activity_logs.ma_question_3 as multiple_answer_question_3,
				DATE_FORMAT(master_activity_logs.date, '%m/%d/%Y %H:%i:%s') as date
			";
		}

		$stmt = "
			SELECT
				$select
			FROM
				master_activity_logs
					JOIN
				master_users ON master_activity_logs.user_id = master_users.id
			WHERE
			$where_user_id
			$search_where_mr_project_filter_string
			$search_where_was_asl_response_string
			$search_where_keyword_string
			$search_where_date_range_string
			$where_organization_hierarchy
			ORDER BY master_activity_logs.date DESC
			$limit_string
		";

		$query = $this->db->query($stmt);

		if($query->num_rows() > 0)
		{
			if ($return_query_object)
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
			return FALSE;
		}
	}

	public function get_most_recent_activity($user_id, $black_list){
		$sql = "
			SELECT response_id FROM master_activity_logs
			WHERE response_id NOT IN ( '" . implode( "', '" , $black_list ) . "' ) ORDER BY date DESC LIMIT 1;
		";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['response_id'];
	}
	public function get_current_flow_attempt($user_id = NULL)
	{
		$user_id = (empty($user_id)) ? $this->account_id : $user_id;

		if(empty($user_id)) {
			return NULL;
		}

		$sql = "
			SELECT
				IF(MAX(flow_attempt) IS NULL, 1, MAX(flow_attempt)) AS current_flow_attempt
			FROM master_activity_logs
			WHERE
				MR_PROJECT = '".MR_PROJECT."'
				AND user_id = $user_id
		";

		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['current_flow_attempt'];
	}

	// most frequently asked questions for clinical trials
	public function get_most_frequently_asked_questions($mr_project = FALSE, $organization_hierarchy_level_elements_filter = array(), $user_id_filter = array())
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$where_mr_project = '1 = 1';
		$where_organization_hierarchy = 'AND 1 = 1';
		$where_user_id = 'AND 1 = 1';

		if($mr_project !== FALSE) {
			$mr_project = $this->db->escape_str($mr_project);
			$where_mr_project = "master_activity_logs.mr_project = '$mr_project'";
		}

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

		if(!empty($user_id_filter)) {
			$where_user_id = 'AND master_activity_logs.user_id NOT IN (' . implode(', ', $user_id_filter) . ')';
		}

		$stmt = "
			SELECT		master_activity_logs.input_question AS question,
					count(master_activity_logs.session_id) AS number_of_times_asked
			FROM		master_activity_logs
			JOIN master_users
				ON master_users.id = master_activity_logs.user_id
				AND master_users.user_type_id = 4
			WHERE
				$where_mr_project
				$where_organization_hierarchy
				$where_user_id
				AND (master_activity_logs.action='" . ACTION_Q . "' OR master_activity_logs.action='" . ACTION_A . "')
				AND master_activity_logs.input_question!=''
		GROUP BY	master_activity_logs.input_question
		ORDER BY	count(master_activity_logs.session_id) DESC
		LIMIT	100
		";

		$query = $this->db->query($stmt);

		if($query->num_rows() < 1) {
			return array();
		}

		return $query->result_array();
	}

	public function get_most_recent_flow_response_attempt($response_id, $user_id = NULL) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with response_id = $response_id");

		$user_id = (empty($user_id)) ? $this->account_id : $user_id;

		if(empty($user_id)) {
			return NULL;
		}

		$current_flow_attempt = $this-> get_current_flow_attempt();

		$sql = "
			SELECT
				IF(MAX(flow_response_attempt) IS NULL, 0, MAX(flow_response_attempt)) AS most_recent_flow_response_attempt
			FROM master_activity_logs
			WHERE
				MR_PROJECT = '".MR_PROJECT."'
				AND user_id = $user_id
				AND response_id = '$response_id'
				AND flow_attempt = $current_flow_attempt
		";

		$query = $this->db->query($sql);
		$row = $query->row_array();
		return $row['most_recent_flow_response_attempt'];
	}

	public function get_responses_data($mr_project = FALSE, $organization_hierarchy_level_elements_filter = array(), $user_id_filter = array())
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$data = array(
			'all_responses'										=> array(),
			'user_question_responses'					=> array(),
			'related_question_responses'			=> array(),
			'left_rail_question_responses'		=> array()
		);

		if(!SHOW_RESPONSES_VIEWED_DATA) {
			return $data;
		}

		$where_mr_project = '1 = 1';
		$where_organization_hierarchy = 'AND 1 = 1';
		$where_user_id = 'AND 1 = 1';

		if($mr_project !== FALSE) {
			$mr_project = $this->db->escape_str($mr_project);
			$where_mr_project = "master_activity_logs.mr_project = '$mr_project'";
		}

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

		if(!empty($user_id_filter)) {
			$where_user_id = 'AND master_activity_logs.user_id NOT IN (' . implode(', ', $user_id_filter) . ')';
		}

		// all_responses
		$stmt = "
			SELECT
				master_activity_logs.response_id,
				count(master_activity_logs.response_id) AS number_of_times_viewed
			FROM master_activity_logs
			JOIN master_users
				ON master_users.id = master_activity_logs.user_id
				AND master_users.user_type_id = 4
			WHERE
				$where_mr_project
				$where_organization_hierarchy
				$where_user_id
		GROUP BY master_activity_logs.response_id
		ORDER BY count(master_activity_logs.response_id) DESC
		";

		$query = $this->db->query($stmt);

		if($query->num_rows() > 0) {
			$data['all_responses'] = $query->result_array();
			foreach($data['all_responses'] as $key => &$response) {
				if(!($base_question = $this->index_library->get_base_question($response['response_id'], MR_PROJECT))) {
					unset($data['all_responses'][$key]);
					continue;
				}

				$response['base_question'] = $base_question;
			}

			$data['all_responses'] = array_values($data['all_responses']);
		}

		// user_input_question_responses
		$stmt = "
			SELECT
				master_activity_logs.response_id,
				count(master_activity_logs.response_id) AS number_of_times_viewed
			FROM master_activity_logs
			JOIN master_users
				ON master_users.id = master_activity_logs.user_id
				AND master_users.user_type_id = 4
			WHERE
				$where_mr_project
				$where_organization_hierarchy
				$where_user_id
				AND (master_activity_logs.action='" . ACTION_Q . "' OR master_activity_logs.action='" . ACTION_A . "')
				AND master_activity_logs.input_question!=''
			GROUP BY master_activity_logs.response_id
			ORDER BY count(master_activity_logs.response_id) DESC
		";

		$query = $this->db->query($stmt);

		if($query->num_rows() > 0) {
			$data['user_question_responses'] = $query->result_array();
			foreach($data['user_question_responses'] as $key => &$response) {
				if(!($base_question = $this->index_library->get_base_question($response['response_id'], MR_PROJECT))) {
					unset($data['user_question_responses'][$key]);
					continue;
				}

				$response['base_question'] = $base_question;
			}

			$data['user_question_responses'] = array_values($data['user_question_responses']);
		}

		// related_question_responses
		$stmt = "
			SELECT
				master_activity_logs.response_id,
				count(master_activity_logs.response_id) AS number_of_times_viewed
			FROM master_activity_logs
			JOIN master_users
				ON master_users.id = master_activity_logs.user_id
				AND master_users.user_type_id = 4
			WHERE
				$where_mr_project
				$where_organization_hierarchy
				$where_user_id
				AND master_activity_logs.action='" . ACTION_RELATED . "'
			GROUP BY master_activity_logs.response_id
			ORDER BY count(master_activity_logs.response_id) DESC
		";

		$query = $this->db->query($stmt);

		if($query->num_rows() > 0) {
			$data['related_question_responses'] = $query->result_array();
			foreach($data['related_question_responses'] as $key => &$response) {
				if(!($base_question = $this->index_library->get_base_question($response['response_id'], MR_PROJECT))) {
					unset($data['related_question_responses'][$key]);
					continue;
				}

				$response['base_question'] = $base_question;
			}

			$data['related_question_responses'] = array_values($data['related_question_responses']);
		}

		// left_rail_question_responses
		$stmt = "
			SELECT
				master_activity_logs.response_id,
				count(master_activity_logs.response_id) AS number_of_times_viewed
			FROM master_activity_logs
			JOIN master_users
				ON master_users.id = master_activity_logs.user_id
				AND master_users.user_type_id = 4
			WHERE
				$where_mr_project
				$where_organization_hierarchy
				$where_user_id
				AND master_activity_logs.action='" . ACTION_LEFT_RAIL . "'
			GROUP BY master_activity_logs.response_id
			ORDER BY count(master_activity_logs.response_id) DESC
		";

		$query = $this->db->query($stmt);

		if($query->num_rows() > 0) {
			$data['left_rail_question_responses'] = $query->result_array();
			foreach($data['left_rail_question_responses'] as $key => &$response) {
				if(!($base_question = $this->index_library->get_base_question($response['response_id'], MR_PROJECT))) {
					unset($data['left_rail_question_responses'][$key]);
					continue;
				}

				$response['base_question'] = $base_question;
			}

			$data['left_rail_question_responses'] = array_values($data['left_rail_question_responses']);
		}

		return $data;
	}

	public function get_session_detail($session_id = FALSE)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with session_id = $session_id");

		if ($session_id === FALSE) {
			$where_session_id = "";
		} else {
			$session_id = $this->db->escape_str($session_id);
			$where_session_id = "WHERE master_activity_logs.session_id='$session_id'";
		}

		$stmt = "
			SELECT master_users.username,
				master_activity_logs.date,
				CONCAT(master_activity_logs.operating_system, '-', master_activity_logs.browser) AS platform,
				master_activity_logs.action,
				master_activity_logs.input_question,
				master_activity_logs.response_id,
				master_activity_logs.response_question,
				master_activity_logs.response_type
			FROM master_activity_logs
			JOIN master_users
				ON master_users.id=master_activity_logs.user_id
			$where_session_id
		";

		$query = $this->db->query($stmt);

		if($query->num_rows() < 1) {
			return array();
		}

		return $query->result_array();
	}

	public function get_sessions_summary($mr_project = FALSE, $organization_hierarchy_level_elements_filter = array(), $user_id_filter = array())
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$where_mr_project = '1 = 1';
		$where_organization_hierarchy = 'AND 1 = 1';
		$where_user_id = 'AND 1 = 1';

		if($mr_project !== FALSE) {
			$mr_project = $this->db->escape_str($mr_project);
			$where_mr_project = "master_activity_logs.mr_project = '$mr_project'";
		}

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

		if(!empty($user_id_filter)) {
			$where_user_id = 'AND master_activity_logs.user_id NOT IN (' . implode(', ', $user_id_filter) . ')';
		}

		$stmt = "
		SELECT
			t.session_id,
			t.start_date,
			t.end_date,
			t.number_of_questions_asked,
			FORMAT(TIME_TO_SEC(TIMEDIFF(t.end_date, t.start_date)) / 60, 2) AS duration,
			t.username
		FROM (
				SELECT
					master_activity_logs.session_id,
					MIN(master_activity_logs.date) AS start_date,
					MAX(master_activity_logs.date) AS end_date,
					SUM(
					IF((master_activity_logs.action='" . ACTION_Q . "' OR master_activity_logs.action='" . ACTION_A . "') AND master_activity_logs.input_question!='',
						1,
						0
				)) AS number_of_questions_asked,
				master_users.username AS username
			FROM master_activity_logs
			JOIN master_users
				ON master_users.id=master_activity_logs.user_id
				AND master_users.user_type_id = 4
			LEFT JOIN master_users_organization_hierarchy_level_element_map
				ON master_users_organization_hierarchy_level_element_map.user_id = master_users.id
				AND master_users_organization_hierarchy_level_element_map.active = 1
			WHERE
				$where_mr_project
				$where_organization_hierarchy
				$where_user_id
			GROUP BY	master_activity_logs.session_id
			ORDER BY	master_activity_logs.date DESC
		) AS t
		";

		$query = $this->db->query($stmt);

		if($query->num_rows() < 1)
		{
			return array();
		}

		return $query->result_array();
	}

	public function get_session_count_frequencies($mr_project = FALSE) {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$where_mr_project = '1 = 1';
		$user_identifying_column = USER_AUTHENTICATION_REQUIRED ? 'user_id' : 'ip_address';

		if($mr_project !== FALSE) {
			$where_mr_project = "mr_project = '$mr_project'";
		}

		$sql = "
			SELECT
				sessions_count,
				COUNT(*) AS num_occurences
			FROM (
				SELECT
					COUNT(DISTINCT session_id) AS sessions_count
				FROM master_activity_logs
				WHERE
					$where_mr_project
				GROUP BY $user_identifying_column
			) AS sessions_counts
			GROUP BY sessions_count
			ORDER BY COUNT(*) DESC
		";

		$query = $this->db->query($sql);

		if($query->num_rows() > 0) {
			return $query->result_array();
		}

		return array();
	}

	public function get_modified_session_count_frequencies($project_id = FALSE) {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$where_mr_project = '1 = 1';
		$user_identifying_column = USER_AUTHENTICATION_REQUIRED ? 'user_id' : 'ip_address';

		if($project_id !== FALSE) {
			$where_project_id = "project_id = $project_id";
		}

		$sql = "
			SELECT
				sessions_count,
				COUNT(1) AS num_occurences
			FROM (
				SELECT
					COUNT(1) AS sessions_count
				FROM master_processed_sessions
				JOIN master_session_processor_runs
					ON master_processed_sessions.session_processor_run_id = master_session_processor_runs.id
				WHERE
					$where_mr_project
				GROUP BY $user_identifying_column
			) AS sessions_counts
			GROUP BY sessions_count
			ORDER BY COUNT(1) DESC;
		";

		$query = $this->db->query($sql);

		if($query->num_rows() > 0) {
			return $query->result_array();
		}

		return array();
	}

	// get usage summary for clinical trials
	public function get_usage_summary($mr_project = FALSE, $organization_hierarchy_level_elements_filter = array(), $user_id_filter = array())
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$where_mr_project = '1 = 1';
		$where_organization_hierarchy = 'AND 1 = 1';
		$where_user_id = 'AND 1 = 1';

		if($mr_project !== FALSE) {
			$mr_project = $this->db->escape_str($mr_project);
			$where_mr_project = "master_activity_logs.mr_project = '$mr_project'";
		}

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

		if(!empty($user_id_filter)) {
			$where_user_id = 'AND master_activity_logs.user_id NOT IN (' . implode(', ', $user_id_filter) . ')';
		}

		$stmt = "
			SELECT	*
			FROM	(
						SELECT count(DISTINCT master_activity_logs.session_id) AS number_of_sessions
						FROM master_activity_logs
						JOIN master_users
							ON master_users.id = master_activity_logs.user_id
							AND master_users.user_type_id = 4
						WHERE
						$where_mr_project
						$where_organization_hierarchy
						$where_user_id
					) AS number_of_sessions,
					(
						SELECT count(master_activity_logs.session_id) AS number_of_questions
						FROM master_activity_logs
						JOIN master_users
							ON master_users.id = master_activity_logs.user_id
							AND master_users.user_type_id = 4
						WHERE
							$where_mr_project
							$where_organization_hierarchy
							$where_user_id
							AND (master_activity_logs.action='" . ACTION_Q . "' OR master_activity_logs.action='" . ACTION_A . "')
							AND master_activity_logs.input_question!=''
					) AS number_of_questions,
					(
						SELECT count(master_activity_logs.id) AS number_of_responses_viewed
						FROM master_activity_logs
						JOIN master_users
							ON master_users.id = master_activity_logs.user_id
							AND master_users.user_type_id = 4
						WHERE
						$where_mr_project
						$where_organization_hierarchy
						$where_user_id
					) AS number_of_responses_viewed,
					(
						SELECT count(master_activity_logs.id) AS number_of_responses_viewed_via_user_questions
						FROM master_activity_logs
						JOIN master_users
							ON master_users.id = master_activity_logs.user_id
							AND master_users.user_type_id = 4
						WHERE
						$where_mr_project
						$where_organization_hierarchy
						$where_user_id
						AND (master_activity_logs.action='" . ACTION_Q . "' OR master_activity_logs.action='" . ACTION_A . "')
						AND master_activity_logs.input_question!=''
					) AS number_of_responses_viewed_via_user_questions,
					(
						SELECT count(master_activity_logs.id) AS number_of_responses_viewed_via_related_questions
						FROM master_activity_logs
						JOIN master_users
							ON master_users.id = master_activity_logs.user_id
							AND master_users.user_type_id = 4
						WHERE
						$where_mr_project
						$where_organization_hierarchy
						$where_user_id
						AND master_activity_logs.action='" . ACTION_RELATED . "'
					) AS number_of_responses_viewed_via_related_questions,
					(
						SELECT count(master_activity_logs.id) AS number_of_responses_viewed_via_left_rail_questions
						FROM master_activity_logs
						JOIN master_users
							ON master_users.id = master_activity_logs.user_id
							AND master_users.user_type_id = 4
						WHERE
						$where_mr_project
						$where_organization_hierarchy
						$where_user_id
						AND master_activity_logs.action='" . ACTION_LEFT_RAIL . "'
					) AS number_of_responses_viewed_via_left_rail_questions,
					(
						SELECT	FORMAT(sum(t2.duration) / count(t2.duration), 2) AS average_session_duration
						FROM	(
									SELECT	t.session_id,
											t.start_date,
											t.end_date,
											FORMAT(TIME_TO_SEC(TIMEDIFF(t.end_date, t.start_date)) / 60, 2) AS duration
									FROM	(
												SELECT		master_activity_logs.session_id,
															MIN(master_activity_logs.date) AS start_date,
															MAX(master_activity_logs.date) AS end_date
												FROM		master_activity_logs
												JOIN master_users
													ON master_users.id = master_activity_logs.user_id
													AND master_users.user_type_id = 4
												WHERE
													$where_mr_project
													$where_organization_hierarchy
													$where_user_id
												GROUP BY	master_activity_logs.session_id
												ORDER BY	master_activity_logs.date ASC
											) AS t
								) AS t2
					) AS average_session_duration
		";

		$query = $this->db->query($stmt);

		if($query->num_rows() < 1)
		{
			return array();
		}

		return $query->row_array();
	}

	public function get_most_recent_log_by_session_id($sess_id, $response_id, $type)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with session_id = $sess_id | response_id = $response_id | type = $type");

		$this->db->select('*');
		$this->db->where('session_id', $sess_id);
		$this->db->where('current_response', $response_id);
		if ($type)
		{
			$this->db->where('action', $type);
		}
		$this->db->order_by('date', 'desc');

		$query = $this->db->get('master_activity_logs', 1);

		if($query->num_rows() > 0)
		{
			$result = $query->row_array();
			return $result;
		}
		else
		{
			return NULL;
		}
	}

	public function get_most_recent_log($user_id, $response_id, $type)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | response_id = $response_id | type = $type");

		$this->db->select('*');
		$this->db->where('user_id', $user_id);
		$this->db->where('current_response', $response_id);
		if ($type)
		{
			$this->db->where('action', $type);
		}
		$this->db->order_by('date', 'desc');

		$query = $this->db->get('master_activity_logs', 1);

		if($query->num_rows() > 0)
		{
			$result = $query->row_array();
			return $result;
		}
		else
		{
			return NULL;
		}
	}

	public function get_last_log_id($user_id = NULL) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

		$this->db->select('*');
		$this->db->order_by('date', 'desc');
		$this->db->limit(1);

		if(!empty($user_id)) {
			$this->db->where('user_id', $user_id);
		}

		$query = $this->db->get('master_activity_logs', 1);

		if($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result["id"];
		} else {
			return NULL;
		}

	}

	public function insert_feedback_log(
		$organization_id,
		$answer1,
		$answer2,
		$answer3,
		$answer4,
		$answer5,
		$answer6
	)
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		if (!$organization_id)
		{
			return FALSE;
		}

		$data = array(
			'ip_address'			=> $this->ip_address,
			'session_id'			=> $this->session_id,
			'organization_id'	=> $organization_id,
			'answer_1'				=> !empty($answer1) ? $answer1 : NULL,
			'answer_2'				=> !empty($answer2) ? $answer2 : NULL,
			'answer_3'				=> !empty($answer3) ? $answer3 : NULL,
			'answer_4'				=> !empty($answer4) ? $answer4 : NULL,
			'answer_5'				=> !empty($answer5) ? $answer5 : NULL,
			'answer_6'				=> !empty($answer6) ? $answer6 : NULL
		);

		$query = $this->db->insert('master_feedback_logs', $data);

		if ($this->db->affected_rows() > 0)
		{
			return TRUE;
		}

		return FALSE;
	}


	public function insert_activity_log(
		$action,
		$input_question,
		$input_question_disambiguated,
		$case_name,
		$current_response,
		$response_id,
		$response_question,
		$response_type,
		$was_asl_response,
		$flow_attempt = NULL,
		$ma_response_id = FALSE,
		$ma_question_1 = FALSE,
		$ma_question_2 = FALSE,
		$ma_question_3 = FALSE
	)
	{
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		// DO NOT log "Answer" and "Question" requests with an empty input_question.
		// These requests are issued after the user answers a question and then either presses the browser back button or reloads the page
		if(($action === ACTION_A || $action === ACTION_Q) && empty($input_question)) {
			return NULL;
		}

		// DO NOT log activity from search engine robots
		if($this->agent->is_robot()) {
			return NULL;
		}

		// input_question should only be set for "Answer" and "Question" requests
		if($action !== ACTION_A && $action !== ACTION_Q && $action !== ACTION_LOG) {
			$input_question = '';
		}

		$current_time = date('Y-m-d H:i:s', now());
		$os = $this->agent->platform();
		$browser = $this->agent->browser();
		$version_split = explode('.', $this->agent->version());
		$browser_version = $version_split[0];

		/* For sites that have private input we wanna blast away all non-null inputs */
		if (PRIVATE_DATA && ENVIRONMENT == 'production'){
			if (!empty($input_question) && $input_question != '' && $input_question != null){
				$input_question = 'N/A';
			}
		}

		$data = array(
			'mr_project'					=> MR_PROJECT,
			'session_id'					=> $this->session_id,
			'ip_address'					=> $this->ip_address,
			'operating_system'				=> $os,
			'browser'						=> $browser.' '.$browser_version,
			// NOTE (Alex Quinn 7/25/2014)	:
			// User 51 is an anonymous user with username 'none'
			// We can't just leave this blank because then a log needs to be
			// associated with a user in order to match the get_activity_logs query
			'user_id'						=> $this->account_id ? $this->account_id : 51,
			'action'						=> $action,
			'input_question'				=> $input_question,
			'input_question_disambiguated'	=> $input_question_disambiguated,
			'current_response'				=> $current_response,
			'case_name'						=> $case_name,
			'response_id'					=> $response_id,
			'response_question'				=> $response_question,
			'response_type'					=> $response_type,
			'was_asl_response'				=> ($was_asl_response) ? 1 : 0,
			'flow_attempt'					=> LOG_FLOW_ATTEMPTS ? $flow_attempt : NULL,
			'date'							=> $current_time
		);

		if(LOG_FLOW_ATTEMPTS) {
			$flow_response_attempt = "(
				SELECT
					COUNT(1) + 1 AS flow_response_attempt
				FROM (
					SELECT
						*
					FROM master_activity_logs
					WHERE
						mr_project = '".MR_PROJECT."'
						AND user_id = $this->account_id
						AND response_id = '$response_id'
						AND flow_attempt = $flow_attempt
				) AS master_activity_logs_alias
				WHERE
					mr_project = '".MR_PROJECT."'
					AND user_id = $this->account_id
					AND response_id = '$response_id'
					AND flow_attempt = $flow_attempt
			)";

			$this->db->set('flow_response_attempt', $flow_response_attempt, FALSE);
		}

		// Multiple answer columns are optional in the log
		if ($ma_response_id)
		{
			$data['$ma_response_id'] = $ma_response_id;
		}

		if ($ma_question_1)
		{
			$data['$ma_question_1'] = $ma_question_1;
		}

		if ($ma_question_2)
		{
			$data['$ma_question_2'] = $ma_question_2;
		}

		if ($ma_question_3)
		{
			$data['$ma_question_3'] = $ma_question_3;
		}

		$this->db->insert('master_activity_logs', $data);
	}

	public function user_activity_count($user_id) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

		$this->db->select('count(*) as log_count');
		$this->db->where('user_id', $user_id);

		$query = $this->db->get('master_activity_logs', 1);

		if($query->num_rows() > 0)
		{
			$result = $query->row_array();
			return $result['log_count'];
		}
		else
		{
			return 0;
		}
	}

	public function user_has_submitted_input_question_while_viewing_response($response_id, $user_id = NULL) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with response_id = $response_id");

		$user_id = (empty($user_id)) ? $this->account_id : $user_id;

		if(empty($user_id)) {
			return NULL;
		}

		$current_flow_attempt = $this-> get_current_flow_attempt();

		$sql = "
			SELECT
				COUNT(id) AS count
			FROM master_activity_logs
			WHERE
				MR_PROJECT = '".MR_PROJECT."'
				AND user_id = $user_id
				AND input_question != ''
				AND input_question IS NOT NULL
				AND current_response = '$response_id'
				AND flow_attempt = $current_flow_attempt
		";

		$query = $this->db->query($sql);
		$row = $query->row_array();
		$previous_attempts_count = $row['count'];
		log_debug(__FILE__, __LINE__, __METHOD__, sprintf('user_id = %s | current_flow_attempt = %s | response_id = %s | previous_attempts_count = %s', $user_id, $current_flow_attempt, $response_id, $previous_attempts_count));
		return ($previous_attempts_count > 0) ? TRUE : FALSE;
	}
}
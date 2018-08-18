<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tssim_library {

    public $ci = NULL;
    public $user_id = NULL;

    public function __construct() {
        $this->ci =& get_instance();
        $this->user_id = $this->ci->session->userdata('account_id');

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function get_dashboard_data($user_id = NULL, $limit = NULL, $offset = NULL) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $user_id_where = '1 = 1';
        $limit_offset_str = '';

        if(!empty($user_id)) {
            $user_id_where = sprintf('mu.id = %d', $user_id);;
        }

        if(!empty($offset) && !empty($limit)) {
            $limit_offset_str = sprintf('LIMIT %d OFFSET %d', $limit, $offset);
        }

        $sql = "
            SELECT
                mu.id AS user_id,
                mu.username,
                mal_flow_attempts.flow_attempt AS simulation_attempt,
                mal_flow_attempts.start_datetime,
                mal_flow_attempts.end_datetime,
                IF(
                    master_tssim_scores.end_datetime IS NOT NULL,
                    TRUE,
                    FALSE
                ) AS has_completed,
                IF (
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    'Scenario 6',
                IF (
                    EXISTS (SELECT id FROM master_activity_logs AS mal5 WHERE mal5.user_id = mal_flow_attempts.user_id AND mal5.response_id = 'HS6D001' AND mal5.flow_attempt = mal_flow_attempts.flow_attempt),
                    'Scenario 5',
                IF (
                    EXISTS (SELECT id FROM master_activity_logs AS mal4 WHERE mal4.user_id = mal_flow_attempts.user_id AND mal4.response_id = 'HS5D001' AND mal4.flow_attempt = mal_flow_attempts.flow_attempt),
                    'Scenario 4',
                IF (
                    EXISTS (SELECT id FROM master_activity_logs AS mal3 WHERE mal3.user_id = mal_flow_attempts.user_id AND mal3.response_id = 'HS4D001' AND mal3.flow_attempt = mal_flow_attempts.flow_attempt),
                    'Scenario 3',
                IF (
                    EXISTS (SELECT id FROM master_activity_logs AS mal2 WHERE mal2.user_id = mal_flow_attempts.user_id AND mal2.response_id = 'HS3D001' AND mal2.flow_attempt = mal_flow_attempts.flow_attempt),
                    'Scenario 2',
                IF (
                    EXISTS (SELECT id FROM master_activity_logs AS mal1 WHERE mal1.user_id = mal_flow_attempts.user_id AND mal1.response_id = 'HS2D001' AND mal1.flow_attempt = mal_flow_attempts.flow_attempt),
                    'Scenario 1',
                    'Introduction'
                )))))) AS last_scenario_completed,
                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(master_tssim_scores.gs_follow_up_raw_score, 0),
                    NULL
                ) AS gathering_stars_follow_up_raw_score,
                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(master_tssim_scores.gs_motivational_fit_planning_and_organizing_raw_score, 0),
                    NULL
                ) AS gathering_stars_motivational_fit_planning_and_organizing_raw_score,
                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(master_tssim_scores.gs_motivational_fit_decision_making_raw_score, 0),
                    NULL
                ) AS gathering_stars_motivational_fit_decision_making_raw_score,

                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(master_tssim_scores.gs_follow_up_modified_score, 0),
                    NULL
                ) AS gathering_stars_follow_up_modified_score,

                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(master_tssim_scores.gs_motivational_fit_planning_and_organizing_modified_score, 0),
                    NULL
                ) AS gathering_stars_motivational_fit_planning_and_organizing_modified_score,

                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(master_tssim_scores.gs_motivational_fit_decision_making_modified_score, 0),
                    NULL
                ) AS gathering_stars_motivational_fit_decision_making_modified_score,

                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(master_tssim_scores.gs_motivational_fit_combined_modified_score, 0),
                    NULL
                ) AS gathering_stars_motivational_fit_combined_modified_score,

                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(master_tssim_scores.gs_score, 0),
                    NULL
                ) AS gathering_stars_score,

                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(master_tssim_scores.gs_score_num_diamonds, 0),
                    NULL
                ) AS gathering_stars_score_num_diamonds,
                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(master_tssim_scores.behavioral_questions_attempts_count, 0),
                    NULL
                ) AS behavioral_questions_attempts_count,
                master_tssim_scores.behavioral_questions_score,
                master_tssim_scores.behavioral_questions_score_num_diamonds,
                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(master_tssim_scores.follow_up_questions_attempts_count, 0),
                    NULL
                ) AS follow_up_questions_attempts_count,
                master_tssim_scores.follow_up_questions_score,
                master_tssim_scores.follow_up_questions_score_num_diamonds,
                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(master_tssim_scores.motivational_fit_questions_attempts_count, 0),
                    NULL
                ) AS motivational_fit_questions_attempts_count,
                master_tssim_scores.motivational_fit_questions_score,
                master_tssim_scores.motivational_fit_questions_score_num_diamonds,
                master_tssim_scores.candidate_experience_score,
                master_tssim_scores.candidate_experience_score_num_diamonds,
                master_tssim_scores.moving_through_the_interview_time,
                master_tssim_scores.moving_through_the_interview_time_num_diamonds
            FROM master_users AS mu
            JOIN master_users_map AS mum
                ON mum.user_id = mu.id
            JOIN master_organizations AS mo
                ON mo.id = mum.organization_id
            JOIN master_organization_property_map AS mopm
                ON mopm.organization_id = mo.id
            JOIN master_properties AS mp
                ON mp.id = mopm.property_id
            JOIN (
                SELECT
                    user_id,
                    flow_attempt,
                    MIN(`date`) AS start_datetime,
                    IF(
                        COUNT(1) = 2,
                        MAX(`date`),
                        NULL
                    ) AS end_datetime
                FROM ((
                    SELECT
                        user_id,
                        flow_attempt,
                        MIN(`date`) AS date
                    FROM master_activity_logs
                    WHERE
                        mr_project = 'tss'
                        AND response_id = 'HIntroD001'
                    GROUP BY user_id, flow_attempt
                ) UNION (
                    SELECT
                        user_id,
                        flow_attempt,
                        MIN(`date`) AS date
                    FROM master_activity_logs
                    WHERE
                        mr_project = 'tss'
                        AND response_id = 'HEndD001'
                    GROUP BY user_id, flow_attempt
                )) AS mal_dates
                GROUP BY user_id, flow_attempt
            ) AS mal_flow_attempts
                ON mal_flow_attempts.user_id = mu.id
            LEFT JOIN master_tssim_scores
                ON master_tssim_scores.user_id = mu.id
                AND master_tssim_scores.simulation_attempt = mal_flow_attempts.flow_attempt
            WHERE
                $user_id_where
                AND mu.user_type_id = 4
                AND mo.name = 'DDI'
                AND mp.name = 'tss'
            ORDER BY mal_flow_attempts.start_datetime DESC
            $limit_offset_str
        ";

        $query = $this->ci->db->query($sql);
        //echo $this->ci->db->last_query();die;
        if($query->num_rows() > 0) {
            return $query->result_array();
        }

        return array();
    }

    public function get_dashboard_simulation_attempt_details_data($user_id, $simulation_attempt) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $sql = "
            SELECT
                mal.id AS activity_log_id,
                CASE
                    WHEN mal.response_id = 'HIntroD001' THEN 'Program Introduction' -- FIXME - currently not being selected due to current_response and response_id WHERE filters below
                    WHEN mal.current_response REGEXP '^HS1.*$' THEN 'Scenario 1'
                    WHEN mal.current_response REGEXP '^HS2.*$' THEN 'Scenario 2'
                    WHEN mal.current_response REGEXP '^HS3.*$' THEN 'Scenario 3'
                    WHEN mal.current_response REGEXP '^HS4.*$' THEN 'Scenario 4'
                    WHEN mal.current_response REGEXP '^HS5.*$' THEN 'Scenario 5'
                    WHEN mal.current_response REGEXP '^HS6.*$' THEN 'Scenario 6'
                    WHEN mal.response_id = 'HEndD001' THEN 'Program End' -- FIXME - currently not being selected due to current_response and response_id WHERE filters below
                END AS scenario,
                mal.current_response,
                CASE
                    WHEN mal.current_response REGEXP '^HS[2-6]D001$' THEN 'Behavioral Question'
                    WHEN mal.current_response REGEXP '^HS[1-6]FW001$' THEN 'Follow Up'
                    WHEN mal.current_response REGEXP '^HS[1-6]MF001$' THEN 'Motivational Fit'
                END AS option_selected,
                mal.input_question,
                mal.response_id,
                CASE
                    WHEN mal.response_id REGEXP '^.*Model$' THEN 'Model'
                    WHEN mal.response_id REGEXP '^.*Wrong$' THEN 'Wrong'
                    WHEN mal.response_id REGEXP '^.*Theo$' THEN 'Theoretical'
                    WHEN mal.response_id REGEXP '^.*Closed$' THEN 'Closed'
                    WHEN mal.response_id REGEXP '^.*Vague$' THEN 'Vague'
                    WHEN mal.response_id REGEXP '^.*Leading$' THEN 'Leading'
                    WHEN mal.response_id REGEXP '^.*Neg$' THEN 'Negative'
                    WHEN mal.response_id REGEXP '^.*Shame$' THEN 'Shame'
                    WHEN mal.response_id REGEXP '^.*Illegal$' THEN 'Illegal'
                    WHEN mal.response_id REGEXP '^.*Impolite$' THEN 'Impolite'
                    WHEN mal.response_id REGEXP '^.*Brain$' THEN 'Brain'
                    WHEN mal.response_id REGEXP '^.*Null$' THEN 'Null'
                END AS evaluation,
                mal.date
            FROM
                master_activity_logs AS mal
            JOIN master_users AS mu ON mu.id = mal.user_id
            JOIN master_users_map AS mum ON mum.user_id = mu.id
            JOIN master_organizations AS mo ON mo.id = mum.organization_id
            JOIN master_organization_property_map AS mopm ON mopm.organization_id = mo.id
            JOIN master_properties AS mp ON mp.id = mopm.property_id
            WHERE
                mal.flow_attempt = $simulation_attempt
                AND (
                    mal.current_response REGEXP '^HS[1-6](FW|MF)001$' -- target only responses returned when a user has entered input
                    OR mal.current_response REGEXP '^HS[2-6]D001$'
                )
                AND mal.response_id NOT REGEXP '^HS[1-6](FW|MF)001$' -- prevents page refreshes on responses that expect user input from being included in the result set
                AND mal.response_id NOT REGEXP '^HS[2-6]D001$'
                AND mu.id = $user_id
                AND mu.user_type_id = 4
                AND mo. NAME = 'DDI'
                AND mp. NAME = 'tss'
            ORDER BY
                date ASC;
        ";

        $query = $this->ci->db->query($sql);

        if($query->num_rows() > 0) {
            return $query->result_array();
        }

        return array();
    }

    /**
     * get_most_recent_input_response_id - Retrieves the most recent response that expects the user to enter input for a given user
     * @param int $user_id  - The target user.  Defaults to the currently authenticated user when NULL is passed in
     * @return string - A string of the most recent input response id
     */
    public function get_most_recent_input_response_id($user_id = NULL) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        if($user_id === NULL) {
            $user_id = $this->user_id;
        }

        if(!empty($user_id)) {
            $sql = "
                SELECT
                    response_id AS most_recent_input_response_id
                FROM master_activity_logs
                WHERE
                    mr_project = 'tss'
                    AND user_id = $user_id
                    AND response_id LIKE 'HS___001' OR response_id REGEXP '^HS[2-6]D001$'
                ORDER BY id DESC
                LIMIT 1;
            ";

            $query = $this->ci->db->query($sql);

            if($query->num_rows() == 1) {
                $row = $query->row_array();
                return $row['most_recent_input_response_id'];
            }
        }

        return NULL;
    }

    public function has_exhausted_input_question_attempts($response_id) {
        $response_id = $this->ci->db->escape_str(trim($response_id));

        // make sure that this response requires an input_question from the user
        // if the response_id doesn't require an input_question, then the user hasn't exhausted all attempts
        if(!preg_match('/^HS[1-6](FW|MF)001$/', $response_id) && !preg_match('/^HS[2-6]D001$/', $response_id)) {
            return FALSE;
        }

        $user_id = $this->user_id;
        $current_flow_attempt = $this->ci->log_model->get_current_flow_attempt($user_id);
        $scenario_number = substr($response_id, 2, 1);

        $sql = "
            SELECT
                COUNT(1) AS count
            FROM master_activity_logs
            WHERE
                mr_project = 'tss'
                AND user_id = $user_id
                AND flow_attempt = $current_flow_attempt
                AND action = 'Answer'
                AND input_question != ''
                AND current_response = '$response_id'
                AND response_id REGEXP '%s';
        ";

        // check to see if two non-model input_questions were entered for this response
        // if the user has entered two non-model input_questions, then they've exhausted their attempts
        $response_regexp = sprintf('^PS%s.*(Wrong|Theo|Leading|Vague|Null|Shame|Illegal|Brain|Impolite)$', $scenario_number);
        $query = $this->ci->db->query(sprintf($sql, $response_regexp));
        $result = $query->row_array();

        if($result['count'] == 2) {
            return TRUE;
        }

        // check to see if a model input question was entered for this response
        // if the user has entered a model input question, then they've exhausted their attempts
        $response_regexp = sprintf('^PS%s.*Model$', $scenario_number);
        $query = $this->ci->db->query(sprintf($sql, $response_regexp));
        $result = $query->row_array();

        if($result['count'] == 1) {
            return TRUE;
        }

        return FALSE;
    }

    public function has_finished_current_flow_attempt($user_id = NULL) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        if($user_id === NULL) {
            $user_id = $this->user_id;
        }

        if($user_id === NULL) {
            return FALSE;
        }

        $current_flow_attempt = $this->ci->log_model->get_current_flow_attempt($user_id);

        $query = $this->ci->db
            ->select('id')
            ->from('master_activity_logs')
            ->where(array(
                'mr_project'    => 'tss',
                'user_id'       => $user_id,
                'response_id'   => 'HEndD001',
                'flow_attempt'  => $current_flow_attempt
            ))
            ->limit(1)
            ->get();

        if($query->num_rows() == 1) {
            return TRUE;
        }

        return FALSE;
    }

    public function has_previously_attempted_question($response_id) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $user_id = $this->user_id;
        $current_flow_attempt = $this->ci->log_model->get_current_flow_attempt($user_id);
        $response_id = $this->ci->db->escape_str(trim($response_id));
        $scenario_number = substr($response_id, 2, 1);
        $response_regexp = sprintf('^PS%s.*(Wrong|Theo|Leading|Vague|Null|Shame|Illegal|Brain|Impolite)$', $scenario_number);

        $sql = "
            SELECT
                COUNT(1) AS count
            FROM master_activity_logs
            WHERE
                mr_project = 'tss'
                AND user_id = $user_id
                AND flow_attempt = $current_flow_attempt
                AND action = 'Answer'
                AND input_question != ''
                AND response_id REGEXP '$response_regexp';
        ";

        $query = $this->ci->db->query($sql);
        $row = $query->row_array();
        $previous_attempts_count = $row['count'];
        log_debug(__FILE__, __LINE__, __METHOD__, sprintf('response_id = %s | user_id = %s | current_flow_attempt = %s | scenario_number = %s | response_id_regex = %s | previous_attempts_count = %s', $response_id, $user_id, $current_flow_attempt, $scenario_number, $response_regexp, $previous_attempts_count));
        return ($previous_attempts_count > 1) ? TRUE : FALSE;
    }

    public function write_dashboard_data_to_csv_file($fully_qualified_filename, $chunk_size = 1000) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $offset = 0;

        $rows = $this->get_dashboard_data();

        if(empty($rows = $this->get_dashboard_data(NULL))) {
            return FALSE;
        }

        $this->ci->load->library('csv_library');

        if(!$this->ci->csv_library->write_associative_array_rows_to_csv_file($rows, array_keys($rows[0]), $fully_qualified_filename, TRUE)) {
            throw new Exception('Failed to Write CSV to File');
        }

        $offset += $chunk_size;
        $rows = $this->get_dashboard_data(NULL, $chunk_size, $offset);

        while(!empty($rows)) {
            if(!$this->ci->csv_library->write_associative_array_rows_to_csv_file($rows, array_keys($rows[0]), $fully_qualified_filename)) {
                return FALSE;
            }

            $offset += $chunk_size;
            $rows = $this->get_dashboard_data(NULL, $chunk_size, $offset);

        }

        return TRUE;
    }

    public function score_simulation_attempt($user_id, $simulation_attempt) {
        log_debug(__FILE__, __LINE__, __METHOD__, sprintf('Called with $user_id = %s | $simulation_attempt = %s', $user_id, $simulation_attempt));

        $this->ci->load->model('tssim_score_model');
        $this->ci->tssim_score_model->insert_user_simulation_attempt_scores($user_id, $simulation_attempt);
    }

}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Processed_Sessions_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function insert(
        $session_processor_run_id,
        $session_id,
        $ip_address,
        $user_id,
        $start_activity_id,
        $end_activity_id,
        $start_datetime,
        $end_datetime,
        $activity_count,
        $start_count,
        $replay_count,
        $previous_count,
        $next_count,
        $input_question_count,
        $related_question_count,
        $left_rail_question_count,
        $other_count)
    {
        $this->db->insert('master_processed_sessions', array(
            'session_processor_run_id' => $session_processor_run_id,
            'session_id'               => $session_id,
            'ip_address'               => $ip_address,
            'user_id'                  => $user_id,
            'start_activity_id'        => $start_activity_id,
            'end_activity_id'          => $end_activity_id,
            'start_datetime'           => $start_datetime,
            'end_datetime'             => $end_datetime,
            'seconds'                  => strtotime($end_datetime) - strtotime($start_datetime),
            'activity_count'           => $activity_count,
            'start_count'              => $start_count,
            'replay_count'             => $replay_count,
            'previous_count'           => $previous_count,
            'next_count'               => $next_count,
            'input_question_count'     => $input_question_count,
            'related_question_count'   => $related_question_count,
            'left_rail_question_count' => $left_rail_question_count,
            'other_count'              => $other_count
        ));

        return $this->db->insert_id();
    }

    public function get()
    {
        $query = $this->db
            ->select('
                mps.id,
                mps.session_id,
                mps.ip_address,
                mps.user_id,
                mu.username,
                mps.start_activity_id,
                mps.end_activity_id,
                mps.start_datetime,
                mps.end_datetime,
                FORMAT(mps.seconds / 60, 2) AS duration,
                mps.activity_count,
                mps.start_count,
                mps.replay_count,
                mps.previous_count,
                mps.next_count,
                mps.input_question_count,
                mps.related_question_count,
                mps.left_rail_question_count,
                mps.other_count',
            FALSE)
            ->from('master_processed_sessions AS mps')
            ->join('master_session_processor_runs AS mspr', 'mspr.id = mps.session_processor_run_id')
            ->join('master_users AS mu', 'mu.id = mps.user_id')
            ->join('master_user_types AS mut', 'mut.id = mu.user_type_id')
            ->where('mspr.property_id', PROPERTY_ID)
            ->where('mut.type_name', 'user')
            ->order_by('mps.start_datetime', 'DESC')
            ->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }

        return array();
    }

    public function get_session_detail($processed_session_id) {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with processed_session_id = $processed_session_id");

        $stmt = "
           SELECT
                mu.username,
                mal.date,
                CONCAT(mal.operating_system, '-', mal.browser) AS platform,
                mal.action AS action,
                mal.input_question AS input_question,
                mal.response_id AS response_id,
                mal.response_question AS response_question,
                mal.response_type AS response_type
            FROM master_processed_sessions AS mps
            JOIN master_activity_logs AS mal
                ON mal.user_id = mps.user_id
                    AND mal.session_id = mps.session_id
                    AND mal.id BETWEEN mps.start_activity_id AND mps.end_activity_id
            JOIN master_users AS mu
                ON mu.id = mal.user_id
            WHERE
                mps.id = $processed_session_id
            ORDER BY mal.date DESC;
        ";

        $query = $this->db->query($stmt);

        if($query->num_rows() < 1) {
            return array();
        }

        return $query->result_array();
    }

    public function get_usage_summary($mr_project = FALSE, $organization_hierarchy_level_elements_filter = array(), $user_id_filter = array())
    {
        log_info(__FILE__, __LINE__, __METHOD__, 'Called');

        $where_mr_project = 'AND 1 = 1';
        $where_organization_hierarchy = 'AND 1 = 1';
        $where_user_id = 'AND 1 = 1';

        if($mr_project !== FALSE) {
            $mr_project = $this->db->escape_str($mr_project);
            $where_mr_project = "AND mp.name = '$mr_project'";
        }

        if(!empty($organization_hierarchy_level_elements_filter)) {
            foreach($organization_hierarchy_level_elements_filter as $element_id) {
                if(is_numeric($element_id) && $element_id > 0) {
                    $where_organization_hierarchy .= "
                        AND EXISTS (
                            SELECT *
                            FROM master_users_organization_hierarchy_level_element_map AS muohlem
                            WHERE
                                muohlem.user_id = mps.user_id
                                AND muohlem.organization_hierarchy_level_element_id = $element_id
                                AND muohlem.active = 1
                        )
                    ";
                }
            }
        }

        if(!empty($user_id_filter)) {
            $where_user_id = 'AND mps.user_id NOT IN (' . implode(', ', $user_id_filter) . ')';
        }

        $stmt = "
            SELECT
                COUNT(*) AS number_of_sessions,
                SUM(mps.activity_count) AS number_of_responses_viewed,
                SUM(mps.start_count) AS number_of_responses_viewed_via_start,
                SUM(mps.replay_count) AS number_of_responses_viewed_via_replay_button,
                SUM(mps.previous_count) AS number_of_responses_viewed_via_previous_button,
                SUM(mps.next_count) AS number_of_responses_viewed_via_next_button,
                SUM(mps.input_question_count) AS number_of_responses_viewed_via_user_questions,
                SUM(mps.related_question_count) AS number_of_responses_viewed_via_related_questions,
                SUM(mps.left_rail_question_count) AS number_of_responses_viewed_via_left_rail_questions,
                SUM(mps.other_count) AS number_of_responses_viewed_via_other,
                FORMAT(AVG(mps.seconds) / 60, 2) AS average_session_duration
            FROM master_processed_sessions AS mps
            JOIN master_session_processor_runs AS mspr
                ON mspr.id = mps.session_processor_run_id
            JOIN master_properties AS mp
                ON mp.id = mspr.property_id
            JOIN master_users AS mu
                ON mu.id = mps.user_id
            JOIN master_user_types AS mut
                ON mut.id =mu.user_type_id
            WHERE
                mut.type_name = 'user'
                $where_mr_project
                $where_organization_hierarchy
                $where_user_id
        ";

        $query = $this->db->query($stmt);

        if($query->num_rows() < 1) {
            return array();
        }

        return $query->row_array();
    }

}

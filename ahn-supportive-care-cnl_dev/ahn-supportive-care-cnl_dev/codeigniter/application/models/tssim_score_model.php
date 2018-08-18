<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tssim_score_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function calculate_user_simulation_attempt_scores($user_id, $simulation_attempt) {
        log_debug(__FILE__, __LINE__, __METHOD__, sprintf('Called with $user_id = %s | $simulation_attempt = %s', $user_id, $simulation_attempt));

        $user_id_where = sprintf('mu.id = %d', $user_id);;

        $sql = "
            SELECT
                mu.id AS user_id,
                mal_flow_attempts.flow_attempt AS simulation_attempt,
                mal_flow_attempts.start_datetime,
                mal_flow_attempts.end_datetime,
                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(mal_gathering_stars_scores.gathering_stars_follow_up_raw_score, 0),
                    NULL
                ) AS gs_follow_up_raw_score,
                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(mal_gathering_stars_scores.gathering_stars_motivational_fit_planning_and_organizing_raw_score, 0),
                    NULL
                ) AS gs_motivational_fit_planning_and_organizing_raw_score,
                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(mal_gathering_stars_scores.gathering_stars_motivational_fit_decision_making_raw_score, 0),
                    NULL
                ) AS gs_motivational_fit_decision_making_raw_score,
                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(behavioral_questions_attempts_counts.behavioral_questions_attempts_count, 0),
                    NULL
                ) AS behavioral_questions_attempts_count,
                behavioral_questions_scores.behavioral_questions_score,
                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(follow_up_questions_attempts_counts.follow_up_questions_attempts_count, 0),
                    NULL
                ) AS follow_up_questions_attempts_count,
                follow_up_questions_scores.follow_up_questions_score,
                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    IFNULL(motivational_fit_questions_attempts_counts.motivational_fit_questions_attempts_count, 0),
                    NULL
                ) AS motivational_fit_questions_attempts_count,
                motivational_fit_questions_scores.motivational_fit_questions_score,
                candidate_experience_scores.candidate_experience_score,
                IF(
                    mal_flow_attempts.end_datetime IS NOT NULL,
                    TIMEDIFF(mal_flow_attempts.end_datetime, mal_flow_attempts. start_datetime),
                    NULL
                ) AS moving_through_the_interview_time
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
                        AND user_id = $user_id
                        AND flow_attempt = $simulation_attempt
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
                        AND user_id = $user_id
                        AND flow_attempt = $simulation_attempt
                        AND response_id = 'HEndD001'
                    GROUP BY user_id, flow_attempt
                )) AS mal_dates
                GROUP BY user_id, flow_attempt
            ) AS mal_flow_attempts
                ON mal_flow_attempts.user_id = mu.id
            -- gathering stars join
            LEFT JOIN (
                SELECT
                    master_activity_logs_stars.user_id,
                    master_activity_logs_stars.flow_attempt,
                    SUM(
                        CASE master_activity_logs_stars.response_id
                        WHEN 'HS1FW001' THEN -5
                        WHEN 'HS2FW001' THEN 10
                        WHEN 'HS3FW001' THEN -5
                        WHEN 'HS4FW001' THEN -5
                        WHEN 'HS5FW001' THEN 10
                        WHEN 'HS6FW001' THEN 10
                        ELSE 0
                        END
                    ) AS gathering_stars_follow_up_raw_score,
                    SUM(
                        CASE master_activity_logs_stars.response_id
                        WHEN 'HS1MF001' THEN -5
                        WHEN 'HS2MF001' THEN 10
                        WHEN 'HS3MF001' THEN 10
                        ELSE 0
                        END
                    ) AS gathering_stars_motivational_fit_planning_and_organizing_raw_score,
                    SUM(
                        CASE master_activity_logs_stars.response_id
                        WHEN 'HS4MF001' THEN -5
                        WHEN 'HS5MF001' THEN 10
                        WHEN 'HS6MF001' THEN 10
                        ELSE 0
                        END
                    ) AS gathering_stars_motivational_fit_decision_making_raw_score
                FROM (
                    SELECT
                        mal_outer.user_id,
                        mal_outer.flow_attempt,
                        mal_outer.response_id
                    FROM master_activity_logs AS mal_outer
                    WHERE
                        mal_outer.mr_project = 'tss'
                        AND user_id = $user_id
                        AND flow_attempt = $simulation_attempt
                        AND mal_outer.response_id IN (
                            'HS1FW001',
                            'HS2FW001',
                            'HS3FW001',
                            'HS4FW001',
                            'HS5FW001',
                            'HS6FW001',
                            'HS1MF001',
                            'HS2MF001',
                            'HS3MF001',
                            'HS4MF001',
                            'HS5MF001',
                            'HS6MF001'
                        )
                        AND EXISTS (
                            SELECT
                                id
                            FROM master_activity_logs AS mal_inner
                            WHERE
                                mal_inner.mr_project = 'tss'
                                AND mal_inner.user_id = mal_outer.user_id
                                AND mal_inner.flow_attempt = mal_outer.flow_attempt
                                AND mal_inner.response_id = 'HEndD001'
                            LIMIT 1
                        )
                    GROUP BY user_id, flow_attempt, response_id
                ) AS master_activity_logs_stars
                GROUP BY user_id, flow_attempt
            ) AS mal_gathering_stars_scores
                ON mal_gathering_stars_scores.user_id = mal_flow_attempts.user_id
                AND mal_gathering_stars_scores.flow_attempt = mal_flow_attempts.flow_attempt
            -- behavioral questions attempts count join
            LEFT JOIN (
                SELECT
                    user_id,
                    flow_attempt,
                    COUNT(1) AS behavioral_questions_attempts_count
                FROM (
                    SELECT
                        mal_outer.user_id,
                        mal_outer.flow_attempt
                    FROM master_activity_logs AS mal_outer
                    WHERE
                        mal_outer.mr_project = 'tss'
                        AND mal_outer.user_id = $user_id
                        AND mal_outer.flow_attempt = $simulation_attempt
                        AND mal_outer.action = 'Answer'
                        AND mal_outer.current_response REGEXP '^HS[2-6]D001$'
                        AND mal_outer.input_question != ''
                        AND EXISTS (
                            SELECT
                                id
                            FROM master_activity_logs AS mal_inner
                            WHERE
                                mal_inner.mr_project = 'tss'
                                AND mal_inner.user_id = $user_id
                                AND mal_inner.flow_attempt = $simulation_attempt
                                AND mal_inner.user_id = mal_outer.user_id
                                AND mal_inner.flow_attempt = mal_outer.flow_attempt
                                AND mal_inner.response_id = 'HEndD001'
                            LIMIT 1
                        )
                    GROUP BY mal_outer.user_id, mal_outer.flow_attempt, mal_outer.current_response
                ) AS x
                GROUP BY user_id, flow_attempt
            ) AS behavioral_questions_attempts_counts
                ON behavioral_questions_attempts_counts.user_id = mal_flow_attempts.user_id
                AND behavioral_questions_attempts_counts.flow_attempt = mal_flow_attempts.flow_attempt
            -- behavioral question scores join
            LEFT JOIN (
                SELECT
                    mal_outer.user_id,
                    mal_outer.flow_attempt,
                    SUM(
                        IF(
                            response_id REGEXP '^PS[2-6]BQ(Wrong|Theo|Leading|Vague)$',
                            IF(
                                EXISTS(
                                    SELECT
                                        id
                                    FROM master_activity_logs AS mal_inner
                                    WHERE
                                        mal_inner.user_id = mal_outer.user_id
                                        AND mal_inner.flow_attempt = mal_outer.flow_attempt
                                        AND mal_inner.current_response = mal_outer.current_response
                                        AND mal_inner.response_id REGEXP '^PS[2-6]BQ(Wrong|Theo|Leading|Vague)$'
                                        AND mal_inner.id < mal_outer.id
                                    LIMIT 1
                                ),
                                -5,
                                -2
                            ),
                            IF(
                                response_id REGEXP '^PS[2-6]BQModel$',
                                IF(
                                    EXISTS(
                                        SELECT
                                            id
                                        FROM master_activity_logs AS mal_inner
                                        WHERE
                                            mal_inner.user_id = mal_outer.user_id
                                            AND mal_inner.flow_attempt = mal_outer.flow_attempt
                                            AND mal_inner.current_response = mal_outer.current_response
                                            AND mal_inner.id < mal_outer.id
                                        LIMIT 1
                                    ),
                                    5,
                                    10
                                ),
                                0
                            )
                        )
                    ) AS behavioral_questions_score
                FROM master_activity_logs AS mal_outer
                WHERE
                    mal_outer.mr_project = 'tss'
                    AND mal_outer.user_id = $user_id
                    AND mal_outer.flow_attempt = $simulation_attempt
                    AND mal_outer.action = 'Answer'
                    AND mal_outer.current_response REGEXP '^HS[2-6]D001$'
                    AND mal_outer.input_question != ''
                    AND EXISTS (
                        SELECT
                            id
                        FROM master_activity_logs AS mal_inner
                        WHERE
                            mal_inner.mr_project = 'tss'
                            AND mal_inner.user_id = mal_outer.user_id
                            AND mal_inner.flow_attempt = mal_outer.flow_attempt
                            AND mal_inner.response_id = 'HEndD001'
                        LIMIT 1
                    )
                GROUP BY mal_outer.user_id, mal_outer.flow_attempt
            ) AS behavioral_questions_scores
                ON behavioral_questions_scores.user_id = mal_flow_attempts.user_id
                AND behavioral_questions_scores.flow_attempt = mal_flow_attempts.flow_attempt
            -- follow up questions attempts count join
            LEFT JOIN (
                SELECT
                    user_id,
                    flow_attempt,
                    COUNT(1) AS follow_up_questions_attempts_count
                FROM (
                    SELECT
                        mal_outer.user_id,
                        mal_outer.flow_attempt
                    FROM master_activity_logs AS mal_outer
                    WHERE
                        mal_outer.mr_project = 'tss'
                        AND mal_outer.user_id = $user_id
                        AND mal_outer.flow_attempt = $simulation_attempt
                        AND mal_outer.action = 'Answer'
                        AND mal_outer.current_response REGEXP '^HS[1-6]FW001$'
                        AND mal_outer.input_question != ''
                        AND EXISTS (
                            SELECT
                                id
                            FROM master_activity_logs AS mal_inner
                            WHERE
                                mal_inner.mr_project = 'tss'
                                AND mal_inner.user_id = mal_outer.user_id
                                AND mal_inner.flow_attempt = mal_outer.flow_attempt
                                AND mal_inner.response_id = 'HEndD001'
                            LIMIT 1
                        )
                    GROUP BY mal_outer.user_id, mal_outer.flow_attempt, mal_outer.current_response
                ) AS x
                GROUP BY user_id, flow_attempt
            ) AS follow_up_questions_attempts_counts
                ON follow_up_questions_attempts_counts.user_id = mal_flow_attempts.user_id
                AND follow_up_questions_attempts_counts.flow_attempt = mal_flow_attempts.flow_attempt
            -- follow up question scores join
            LEFT JOIN (
                SELECT
                    mal_outer.user_id,
                    mal_outer.flow_attempt,
                    SUM(
                        IF(
                            response_id REGEXP '^PS[1-6]FW(Wrong|Theo|Leading|Vague)$',
                            IF(
                                EXISTS(
                                    SELECT
                                        id
                                    FROM master_activity_logs AS mal_inner
                                    WHERE
                                        mal_inner.user_id = mal_outer.user_id
                                        AND mal_inner.flow_attempt = mal_outer.flow_attempt
                                        AND mal_inner.current_response = mal_outer.current_response
                                        AND mal_inner.response_id REGEXP '^PS[1-6]FW(Wrong|Theo|Leading|Vague)$'
                                        AND mal_inner.id < mal_outer.id
                                    LIMIT 1
                                ),
                                -5,
                                -2
                            ),
                            IF(
                                response_id REGEXP '^PS[1-6]FWModel$',
                                IF(
                                    EXISTS(
                                        SELECT
                                            id
                                        FROM master_activity_logs AS mal_inner
                                        WHERE
                                            mal_inner.user_id = mal_outer.user_id
                                            AND mal_inner.flow_attempt = mal_outer.flow_attempt
                                            AND mal_inner.current_response = mal_outer.current_response
                                            AND mal_inner.id < mal_outer.id
                                        LIMIT 1
                                    ),
                                    5,
                                    10
                                ),
                                0
                            )
                        )
                    ) AS follow_up_questions_score
                FROM master_activity_logs AS mal_outer
                WHERE
                    mal_outer.mr_project = 'tss'
                    AND mal_outer.user_id = $user_id
                    AND mal_outer.flow_attempt = $simulation_attempt
                    AND mal_outer.action = 'Answer'
                    AND mal_outer.current_response REGEXP '^HS[1-6]FW001$'
                    AND mal_outer.input_question != ''
                    AND EXISTS (
                        SELECT
                            id
                        FROM master_activity_logs AS mal_inner
                        WHERE
                            mal_inner.mr_project = 'tss'
                            AND mal_inner.user_id = mal_outer.user_id
                            AND mal_inner.flow_attempt = mal_outer.flow_attempt
                            AND mal_inner.response_id = 'HEndD001'
                    )
                GROUP BY mal_outer.user_id, mal_outer.flow_attempt
            ) AS follow_up_questions_scores
                ON follow_up_questions_scores.user_id = mal_flow_attempts.user_id
                AND follow_up_questions_scores.flow_attempt = mal_flow_attempts.flow_attempt
            -- motivational fit questions attempts count join
            LEFT JOIN (
                SELECT
                    user_id,
                    flow_attempt,
                    COUNT(1) AS motivational_fit_questions_attempts_count
                FROM (
                    SELECT
                        mal_outer.user_id,
                        mal_outer.flow_attempt
                    FROM master_activity_logs AS mal_outer
                    WHERE
                        mal_outer.mr_project = 'tss'
                        AND mal_outer.user_id = $user_id
                        AND mal_outer.flow_attempt = $simulation_attempt
                        AND mal_outer.action = 'Answer'
                        AND mal_outer.current_response REGEXP '^HS[1-6]MF001$'
                        AND mal_outer.input_question != ''
                        AND EXISTS (
                            SELECT
                                id
                            FROM master_activity_logs AS mal_inner
                            WHERE
                                mal_inner.mr_project = 'tss'
                                AND mal_inner.user_id = mal_outer.user_id
                                AND mal_inner.flow_attempt = mal_outer.flow_attempt
                                AND mal_inner.response_id = 'HEndD001'
                            LIMIT 1
                        )
                    GROUP BY mal_outer.user_id, mal_outer.flow_attempt, mal_outer.current_response
                ) AS x
                GROUP BY user_id, flow_attempt
            ) AS motivational_fit_questions_attempts_counts
                ON motivational_fit_questions_attempts_counts.user_id = mal_flow_attempts.user_id
                AND motivational_fit_questions_attempts_counts.flow_attempt = mal_flow_attempts.flow_attempt
            -- motivational fit question scores join
            LEFT JOIN (
                SELECT
                    mal_outer.user_id,
                    mal_outer.flow_attempt,
                    SUM(
                        IF(
                            response_id REGEXP '^PS[1-6]MF(Wrong|Theo|Leading|Vague)$',
                            IF(
                                EXISTS(
                                    SELECT
                                        id
                                    FROM master_activity_logs AS mal_inner
                                    WHERE
                                        mal_inner.user_id = mal_outer.user_id
                                        AND mal_inner.flow_attempt = mal_outer.flow_attempt
                                        AND mal_inner.current_response = mal_outer.current_response
                                        AND mal_inner.response_id REGEXP '^PS[1-6]MF(Wrong|Theo|Leading|Vague)$'
                                        AND mal_inner.id < mal_outer.id
                                    LIMIT 1
                                ),
                                -5,
                                -2
                            ),
                            IF(
                                response_id REGEXP '^PS[1-6]MFModel$',
                                IF(
                                    EXISTS(
                                        SELECT
                                            id
                                        FROM master_activity_logs AS mal_inner
                                        WHERE
                                            mal_inner.user_id = mal_outer.user_id
                                            AND mal_inner.flow_attempt = mal_outer.flow_attempt
                                            AND mal_inner.current_response = mal_outer.current_response
                                            AND mal_inner.id < mal_outer.id
                                        LIMIT 1
                                    ),
                                    5,
                                    10
                                ),
                                0
                            )
                        )
                    ) AS motivational_fit_questions_score
                FROM master_activity_logs AS mal_outer
                WHERE
                    mal_outer.mr_project = 'tss'
                    AND mal_outer.user_id = $user_id
                    AND mal_outer.flow_attempt = $simulation_attempt
                    AND mal_outer.action = 'Answer'
                    AND mal_outer.current_response REGEXP '^HS[1-6]MF001$'
                    AND mal_outer.input_question != ''
                    AND EXISTS (
                        SELECT
                            id
                        FROM master_activity_logs AS mal_inner
                        WHERE
                            mal_inner.mr_project = 'tss'
                            AND mal_inner.user_id = mal_outer.user_id
                            AND mal_inner.flow_attempt = mal_outer.flow_attempt
                            AND mal_inner.response_id = 'HEndD001'
                    )
                GROUP BY mal_outer.user_id, mal_outer.flow_attempt
            ) AS motivational_fit_questions_scores
                ON motivational_fit_questions_scores.user_id = mal_flow_attempts.user_id
                AND motivational_fit_questions_scores.flow_attempt = mal_flow_attempts.flow_attempt
            -- candidate experience score join
            LEFT JOIN (
                SELECT
                    mal_completed_flow_attempts.user_id,
                    mal_completed_flow_attempts.flow_attempt,
                    100 - (
                        IF(
                            mal_negative_response_counts.count IS NULL,
                            0,
                            IF(
                                mal_negative_response_counts.count < 20,
                                mal_negative_response_counts.count * 5,
                                100
                            )
                        )
                    ) AS candidate_experience_score
                FROM master_activity_logs AS mal_completed_flow_attempts
                LEFT JOIN (
                    SELECT
                        user_id,
                        flow_attempt,
                        COUNT(1) AS count
                    FROM master_activity_logs
                    WHERE
                        mr_project = 'tss'
                        AND user_id = $user_id
                        AND flow_attempt = $simulation_attempt
                        AND response_id REGEXP '^PS[1-6](Null|Shame|Illegal|Brain|Impolite)$'
                        AND input_question != ''
                    GROUP BY user_id, flow_attempt
                ) AS mal_negative_response_counts
                    ON mal_negative_response_counts.user_id = mal_completed_flow_attempts.user_id
                    AND mal_negative_response_counts.flow_attempt = mal_completed_flow_attempts.flow_attempt
                WHERE
                    mal_completed_flow_attempts.mr_project = 'tss'
                    AND mal_completed_flow_attempts.user_id = $user_id
                    AND mal_completed_flow_attempts.flow_attempt = $simulation_attempt
                    AND mal_completed_flow_attempts.response_id = 'HEndD001'
                GROUP BY mal_completed_flow_attempts.user_id, mal_completed_flow_attempts.flow_attempt, mal_completed_flow_attempts.response_id
            ) AS candidate_experience_scores
                ON candidate_experience_scores.user_id = mal_flow_attempts.user_id
                AND candidate_experience_scores.flow_attempt = mal_flow_attempts.flow_attempt
            WHERE
                mu.id = $user_id
                AND mu.user_type_id = 4
                AND mo.name = 'DDI'
                AND mp.name = 'tss'
                AND mal_flow_attempts.end_datetime IS NOT NULL
        ";

        $query = $this->db->query($sql);
        //echo $this->ci->db->last_query();die;
        if($query->num_rows() > 0) {
            $row = $query->row_array();

            // determine the modified gathering stars score for each flow attempt
            if($row['end_datetime'] === NULL) {
                $row['gs_follow_up_modified_score'] = NULL;
                $row['gs_motivational_fit_planning_and_organizing_modified_score'] = NULL;
                $row['gs_motivational_fit_decision_making_modified_score'] = NULL;
                $row['gs_motivational_fit_combined_modified_score'] = NULL;
                $row['gs_score'] = NULL;
            } else {
                $row['gs_follow_up_modified_score'] = $this->_rescale_gathering_stars_follow_up_raw_score($row['gs_follow_up_raw_score']);
                $row['gs_motivational_fit_planning_and_organizing_modified_score'] = $this->_rescale_gathering_stars_motivational_fit_planning_and_organizing_raw_score($row['gs_motivational_fit_planning_and_organizing_raw_score']);
                $row['gs_motivational_fit_decision_making_modified_score'] = $this->_rescale_gathering_stars_motivational_fit_decision_making_raw_score($row['gs_motivational_fit_decision_making_raw_score']);
                $row['gs_motivational_fit_combined_modified_score'] = $this->_combine_and_rescale_individual_motivational_fit_rescaled_scores($row['gs_motivational_fit_planning_and_organizing_modified_score'], $row['gs_motivational_fit_decision_making_modified_score']);
                $row['gs_score'] = $row['gs_follow_up_modified_score'] + $row['gs_motivational_fit_combined_modified_score'];
            }

            // determine the number of "diamonds" for each scoring category
            $row['gs_score_num_diamonds'] = $this->_determine_gathering_stars_score_num_diamonds($row['gs_score']);
            $row['behavioral_questions_score_num_diamonds'] = $this->_determine_behavioral_questions_score_num_diamonds($row['behavioral_questions_score'], $row['behavioral_questions_attempts_count']);
            $row['follow_up_questions_score_num_diamonds'] = $this->_determine_follow_up_questions_score_num_diamonds($row['follow_up_questions_score'], $row['follow_up_questions_attempts_count']);
            $row['motivational_fit_questions_score_num_diamonds'] = $this->_determine_motivational_fit_questions_score_num_diamonds($row['motivational_fit_questions_score'], $row['motivational_fit_questions_attempts_count']);
            $row['candidate_experience_score_num_diamonds'] = $this->_determine_candidate_experience_score_num_diamonds($row['candidate_experience_score']);
            $row['moving_through_the_interview_time_num_diamonds'] = $this->_determine_moving_through_the_interview_time_num_diamonds($row['moving_through_the_interview_time']);

            // reorder the associative array keys
            uksort($row, function($a, $b) {
                $desired_key_indices = array(
                    'user_id'                                                    => 0,
                    'username'                                                   => 1,
                    'simulation_attempt'                                         => 2,
                    'start_datetime'                                             => 3,
                    'end_datetime'                                               => 4,
                    'gs_follow_up_raw_score'                                     => 7,
                    'gs_motivational_fit_planning_and_organizing_raw_score'      => 8,
                    'gs_motivational_fit_decision_making_raw_score'              => 9,
                    'gs_follow_up_modified_score'                                => 10,
                    'gs_motivational_fit_planning_and_organizing_modified_score' => 11,
                    'gs_motivational_fit_decision_making_modified_score'         => 12,
                    'gs_motivational_fit_combined_modified_score'                => 13,
                    'gs_score'                                                   => 14,
                    'gs_score_num_diamonds'                                      => 15,
                    'behavioral_questions_attempts_count'                        => 16,
                    'behavioral_questions_score'                                 => 17,
                    'behavioral_questions_score_num_diamonds'                    => 18,
                    'follow_up_questions_attempts_count'                         => 19,
                    'follow_up_questions_score'                                  => 20,
                    'follow_up_questions_score_num_diamonds'                     => 21,
                    'motivational_fit_questions_attempts_count'                  => 22,
                    'motivational_fit_questions_score'                           => 23,
                    'motivational_fit_questions_score_num_diamonds'              => 24,
                    'candidate_experience_score'                                 => 25,
                    'candidate_experience_score_num_diamonds'                    => 26,
                    'moving_through_the_interview_time'                          => 27,
                    'moving_through_the_interview_time_num_diamonds'             => 28
                );

                if($desired_key_indices[$a] < $desired_key_indices[$b]) {
                    return -1;
                } else if($desired_key_indices[$a] > $desired_key_indices[$b]) {
                    return 1;
                }

                return 0;
            });

            return $row;
        }

        return array();
    }

    public function get_user_simulation_attempt_scores($user_id, $simulation_attempt) {
        log_debug(__FILE__, __LINE__, __METHOD__, sprintf('Called with $user_id = %s | simulation_attempt = %s', $user_id, $simulation_attempt));

        $query = $this->db
            ->select('*')
            ->from('master_tssim_scores')
            ->where(array(
                'user_id'            => $user_id,
                'simulation_attempt' => $simulation_attempt
            ))
            ->limit(1)
            ->get();

        if($query->num_rows() == 1) {
            return $query->row_array();
        }

        return array();
    }

    public function insert_user_simulation_attempt_scores($user_id, $simulation_attempt) {
        log_debug(__FILE__, __LINE__, __METHOD__, sprintf('Called with $user_id = %s | $simulation_attempt = %s', $user_id, $simulation_attempt));

        $user_simulation_attempt_scores = $this->get_user_simulation_attempt_scores($user_id, $simulation_attempt);

        if(!empty($user_simulation_attempt_scores)) {
            return $user_simulation_attempt_scores['id'];
        }

        $user_simulation_attempt_scores = $this->calculate_user_simulation_attempt_scores($user_id, $simulation_attempt);
        $this->db->insert('master_tssim_scores', $user_simulation_attempt_scores);

        return $this->db->insert_id();
    }

     // mofit_p + mofit_d modified scores, the total of which ranges from -10 - 20 rescaled to the range 0 -50
    private function _combine_and_rescale_individual_motivational_fit_rescaled_scores($motivational_fit_planning_and_organizing_modified_score, $motivational_fit_decision_making_modified_score) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        if(!is_numeric($motivational_fit_planning_and_organizing_modified_score) || !is_numeric($motivational_fit_decision_making_modified_score)) {
            return NULL;
        }

        return round(($motivational_fit_planning_and_organizing_modified_score + $motivational_fit_decision_making_modified_score + 10) / 30 * 50, 2);
    }

    private function _determine_gathering_stars_score_num_diamonds($modified_score) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        if($modified_score === NULL) {
            return NULL;
        }

        $num_diamonds = 1;

        if(80 <= $modified_score) {
            $num_diamonds = 5;
        } else if(60 <= $modified_score && $modified_score < 80) {
            $num_diamonds = 4;
        } else if(40 <= $modified_score && $modified_score < 60) {
            $num_diamonds = 3;
        } else if(20 <= $modified_score && $modified_score < 40) {
            $num_diamonds = 2;
        }

        return $num_diamonds;
    }

    private function _determine_behavioral_questions_score_num_diamonds($modified_score, $num_attempts) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        return $this->_determine_question_type_score_num_diamonds($modified_score, $num_attempts);
    }

    private function _determine_follow_up_questions_score_num_diamonds($modified_score, $num_attempts) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        return $this->_determine_question_type_score_num_diamonds($modified_score, $num_attempts);
    }

    private function _determine_motivational_fit_questions_score_num_diamonds($modified_score, $num_attempts) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        return $this->_determine_question_type_score_num_diamonds($modified_score, $num_attempts);
    }

    private  function _determine_question_type_score_num_diamonds($modified_score, $num_attempts) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        if($modified_score === NULL || $num_attempts === NULL) {
            return NULL;
        }

        $num_diamonds = 0;

        switch($num_attempts) {
            case 6:
                if(39.6 <= $modified_score) {
                    $num_diamonds = 5;
                } else if(19.2 <= $modified_score && $modified_score < 39.6) {
                    $num_diamonds = 4;
                } else if(-1.2 <= $modified_score && $modified_score < 19.2) {
                    $num_diamonds = 3;
                } else if(-21.6 <= $modified_score && $modified_score < -1.2) {
                    $num_diamonds = 2;
                } else {
                    $num_diamonds = 1;
                }
            break;

            case 5:
                if(33 <= $modified_score) {
                    $num_diamonds = 5;
                } else if(16 <= $modified_score && $modified_score < 33) {
                    $num_diamonds = 4;
                } else if(-1 <= $modified_score && $modified_score < 16) {
                    $num_diamonds = 3;
                } else if(-18 <= $modified_score && $modified_score < -1) {
                    $num_diamonds = 2;
                } else {
                    $num_diamonds = 1;
                }
            break;

            case 4:
                if(26.4 <= $modified_score) {
                    $num_diamonds = 5;
                } else if(12.8 <= $modified_score && $modified_score < 26.4) {
                    $num_diamonds = 4;
                } else if(-0.8 <= $modified_score && $modified_score < 12.8) {
                    $num_diamonds = 3;
                } else if(-14.4 <= $modified_score && $modified_score < -0.8) {
                    $num_diamonds = 2;
                } else {
                    $num_diamonds = 1;
                }
            break;

            case 3:
                if(19.8 <= $modified_score) {
                    $num_diamonds = 5;
                } else if(9.6 <= $modified_score && $modified_score < 19.8) {
                    $num_diamonds = 4;
                } else if(-0.6 <= $modified_score && $modified_score < 9.6) {
                    $num_diamonds = 3;
                } else if(-10.8 <= $modified_score && $modified_score < -0.6) {
                    $num_diamonds = 2;
                } else {
                    $num_diamonds = 1;
                }
            break;

            case 2:
                if(13.2 <= $modified_score) {
                    $num_diamonds = 5;
                } else if(6.4 <= $modified_score && $modified_score < 13.2) {
                    $num_diamonds = 4;
                } else if(-0.4 <= $modified_score && $modified_score < 6.4) {
                    $num_diamonds = 3;
                } else if(-7.2 <= $modified_score && $modified_score < -0.4) {
                    $num_diamonds = 2;
                } else {
                    $num_diamonds = 1;
                }
            break;

            case 1:
                if($modified_score >= 10) {
                    $num_diamonds = 5;
                } else if($modified_score == 3) {
                    $num_diamonds = 3;
                } else {
                    $num_diamonds = 2;
                }
            break;

            default:
                break;
        }

        return $num_diamonds;
    }

    private function _determine_candidate_experience_score_num_diamonds($modified_score) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        if($modified_score === NULL) {
            return NULL;
        }

        $num_diamonds = 1;

        if(95 <= $modified_score) {
            $num_diamonds = 5;
        } else if(85 <= $modified_score && $modified_score < 95) {
            $num_diamonds = 4;
        } else if(75 <= $modified_score && $modified_score < 85) {
            $num_diamonds = 3;
        } else if(65 <= $modified_score && $modified_score < 75) {
            $num_diamonds = 2;
        }

        return $num_diamonds;
    }

    private function _determine_moving_through_the_interview_time_num_diamonds($flow_attempt_duration) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        if($flow_attempt_duration === NULL) {
            return NULL;
        }

        $hms = $this->_extract_hours_minutes_seconds_from_duration_str($flow_attempt_duration);

        if(empty($hms)) {
            return NULL;
        }

        $num_diamonds = 1;

        if($hms['hours'] == 0) {
            if($hms['minutes'] < 20) {
                $num_diamonds = 5;
            } else if(20 <= $hms['minutes'] && $hms['minutes'] < 30) {
                $num_diamonds = 4;
            } else if(30 <= $hms['minutes'] && $hms['minutes'] < 40) {
                $num_diamonds = 3;
            } else if(40 <= $hms['minutes'] && $hms['minutes'] < 50) {
                $num_diamonds = 2;
            }
        }

        return $num_diamonds;
    }

    private function _extract_hours_minutes_seconds_from_duration_str($duration_str) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        if(empty($duration_str) || !preg_match('/^([0-9]{2,}):([0-5][0-9]):([0-5][0-9])$/', $duration_str, $matches)) {
            return array();
        }

        return array(
            'hours'   => (int) $matches[1],
            'minutes' => (int) $matches[2],
            'seconds' => (int) $matches[3]
        );
    }

    // follow up raw scores range from -15 to 30 and need to be rescaled to the range 0 - 50
    private function _rescale_gathering_stars_follow_up_raw_score($raw_score) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        if(!is_numeric($raw_score)) {
            return NULL;
        }

        return round(($raw_score + 15) / 45 * 50, 2);
    }

    // -5; 0; 5; 10; 15; 20 recoded to -5; 0; 5; 10; 10; 10
    private function _rescale_gathering_stars_motivational_fit_planning_and_organizing_raw_score($raw_score) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        if(!is_numeric($raw_score)) {
            return NULL;
        }

        return ($raw_score > 10) ? 10 : $raw_score;
    }

    // -5; 0; 5; 10; 15; 20 recoded to -5; 0; 5; 10; 10; 10
    private function _rescale_gathering_stars_motivational_fit_decision_making_raw_score($raw_score) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        if(!is_numeric($raw_score)) {
            return NULL;
        }

        return ($raw_score > 10) ? 10 : $raw_score;
    }

}

/* End of file tssim_score_model.php */
/* Location: ./application/models/tssim_score_model.php */

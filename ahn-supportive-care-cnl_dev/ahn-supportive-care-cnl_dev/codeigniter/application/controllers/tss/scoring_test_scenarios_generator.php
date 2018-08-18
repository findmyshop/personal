<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class scoring_test_scenarios_generator extends Constants_Controller
{
    public function __construct() {
        if(ENVIRONMENT == 'production') {
            die('disabled');
        }

        parent::__construct();
        set_time_limit(7200);
    }

    public function index() {
        echo 'hello';
    }

    public function insert_cached_scores() {
        echo 'insert_cached_scores start<br />';

        $this->load->model('tssim_score_model');
        $this->db->save_queries = false;

        $sql = "
            SELECT
                mal_completed_flow_attempts.user_id,
                mal_completed_flow_attempts.flow_attempt
            FROM master_activity_logs AS mal_completed_flow_attempts
            WHERE
                mal_completed_flow_attempts.mr_project = 'tss'
                AND mal_completed_flow_attempts.response_id = 'HEndD001'
            GROUP BY mal_completed_flow_attempts.user_id, mal_completed_flow_attempts.flow_attempt;
        ";

        $query = $this->db->query($sql);

        foreach($query->result_array() as $row) {
            $this->tssim_score_model->insert_user_simulation_attempt_scores($row['user_id'], $row['flow_attempt']);
        }

        echo 'insert_cached_scores end<br />';
    }

    public function gathering_stars() {
        echo 'gathering_stars start<br />';

        $this->load->model('user_model');
        $this->load->model('log_model');

        for($i = 0; $i < 4096; $i++) {
            $attempted_scenario_1_fw = (($i >> 11) & 1);
            $attempted_scenario_1_mf = (($i >> 10) & 1);
            $attempted_scenario_2_fw = (($i >> 9) & 1);
            $attempted_scenario_2_mf = (($i >> 8) & 1);
            $attempted_scenario_3_fw = (($i >> 7) & 1);
            $attempted_scenario_3_mf = (($i >> 6) & 1);
            $attempted_scenario_4_fw = (($i >> 5) & 1);
            $attempted_scenario_4_mf = (($i >> 4) & 1);
            $attempted_scenario_5_fw = (($i >> 3) & 1);
            $attempted_scenario_5_mf = (($i >> 2) & 1);
            $attempted_scenario_6_fw = (($i >> 1) & 1);
            $attempted_scenario_6_mf = ($i & 1);

            $email = sprintf('generating_stars_scoring_test_%s@medrespond.com', sprintf( '%012d', decbin($i)));

            $user_id = $this->user_model->insert_user(
                '',                                 // first_name
                '',                                 // last_name
                $email,                             // username
                17,                                 // organization_id
                4,                                  // user_type_id
                $email,                             // email
                'd41d8cd98f00b204e9800998ecf8427e', // password
                1                                   // login_enabled
            );

            $start_datetime = date('Y-m-d H:i:s', now());
            $end_datetime = date('Y-m-d H:i:s', now() + rand(300 , 7200));

            $this->_log_flow_attempt_start($user_id, $start_datetime);

            if($attempted_scenario_1_fw) {
                $this->_insert_next_click_activity($user_id, 'HS1D002', 'HS1FW001');
            }

            if($attempted_scenario_1_mf) {
                $this->_insert_next_click_activity($user_id, 'HS1D002', 'HS1MF001');
            }

            if($attempted_scenario_2_fw) {
                $this->_insert_next_click_activity($user_id, 'HS2D002', 'HS2FW001');
            }

            if($attempted_scenario_2_mf) {
                $this->_insert_next_click_activity($user_id, 'HS2D002', 'HS2MF001');
            }

            if($attempted_scenario_3_fw) {
                $this->_insert_next_click_activity($user_id, 'HS3D002', 'HS3FW001');
            }

            if($attempted_scenario_3_mf) {
                $this->_insert_next_click_activity($user_id, 'HS3D002', 'HS3MF001');
            }

            if($attempted_scenario_4_fw) {
                $this->_insert_next_click_activity($user_id, 'HS4D002', 'HS4FW001');
            }

            if($attempted_scenario_4_mf) {
                $this->_insert_next_click_activity($user_id, 'HS4D002', 'HS4MF001');
            }

            if($attempted_scenario_5_fw) {
                $this->_insert_next_click_activity($user_id, 'HS5D002', 'HS5FW001');
            }

            if($attempted_scenario_5_mf) {
                $this->_insert_next_click_activity($user_id, 'HS5D002', 'HS5MF001');
            }

            if($attempted_scenario_6_fw) {
                 $this->_insert_next_click_activity($user_id, 'HS6D002', 'HS6FW001');
            }

            if($attempted_scenario_6_mf) {
                 $this->_insert_next_click_activity($user_id, 'HS6D002', 'HS6MF001');
            }

            $this->_log_flow_attempt_end($user_id, $end_datetime);

        }

        echo 'gathering_stars end<br />';
    }

    /**
     * behavioral_questions
     *
     * insert behavioral questions test scenarios
     * all five behavioral questions must be completed by the user
     *
     * possible scenarios: 1024
     *
     * 0. Model Response First Try
     * 1. Model Response Second Try without Previous Point Subtracting Attempt
     * 2. Model Response Second Try with Previous Point Subtracting Attempt
     * 3. Two Point Subtacting Attempts
     *
     * @return type
     */
    public function behavioral_questions() {
        echo 'behavioral_questions start<br />';

        $non_model_response_type_suffixes = array(
            'Wrong',
            'Leading',
            'Theo',
            'Vague'
        );

        for($i = 0; $i < 1024; $i++) {
            $scenario_2_activity = (($i >> 8) & 3);
            $scenario_3_activity = (($i >> 6) & 3);
            $scenario_4_activity = (($i >> 4) & 3);
            $scenario_5_activity = (($i >> 2) & 3);
            $scenario_6_activity = ($i & 3);

            $email = sprintf('behavioral_scoring_test_%s_%s_%s_%s_%s@medrespond.com', sprintf('%02d', decbin($scenario_2_activity)), sprintf('%02d', decbin($scenario_3_activity)), sprintf('%02d', decbin($scenario_4_activity)), sprintf('%02d', decbin($scenario_5_activity)), sprintf('%02d', decbin($scenario_6_activity)));

            $user_id = $this->user_model->insert_user(
                '',                                 // first_name
                '',                                 // last_name
                $email,                             // username
                17,                                 // organization_id
                4,                                  // user_type_id
                $email,                             // email
                'd41d8cd98f00b204e9800998ecf8427e', // password
                1                                   // login_enabled
            );

            $start_datetime = date('Y-m-d H:i:s', now());
            $end_datetime = date('Y-m-d H:i:s', now() + rand(300 , 14400));

            $this->_log_flow_attempt_start($user_id, $start_datetime);

            switch($scenario_2_activity) {
                case 0:
                    $this->_insert_input_question_activity($user_id, 'HS2D001', 'PS2BQModel', 'passthru');
                break;

                case 1:
                    $this->_insert_input_question_activity($user_id, 'HS2D001', 'PS2Null', 'shame');
                    $this->_insert_input_question_activity($user_id, 'HS2D001', 'PS2BQModel', 'passthru');
                break;

                case 2:
                    $this->_insert_input_question_activity($user_id, 'HS2D001', 'PS2BQ' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                    $this->_insert_input_question_activity($user_id, 'HS2D001', 'PS2BQModel', 'passthru');
                break;

                case 3:
                    $this->_insert_input_question_activity($user_id, 'HS2D001', 'PS2BQ' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                    $this->_insert_input_question_activity($user_id, 'HS2D001', 'PS2BQ' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                break;
            }

            switch($scenario_3_activity) {
                case 0:
                    $this->_insert_input_question_activity($user_id, 'HS3D001', 'PS3BQModel', 'passthru');
                break;

                case 1:
                    $this->_insert_input_question_activity($user_id, 'HS3D001', 'PS3Null', 'shame');
                    $this->_insert_input_question_activity($user_id, 'HS3D001', 'PS3BQModel', 'passthru');
                break;

                case 2:
                    $this->_insert_input_question_activity($user_id, 'HS3D001', 'PS3BQ' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                    $this->_insert_input_question_activity($user_id, 'HS3D001', 'PS3BQModel', 'passthru');
                break;

                case 3:
                    $this->_insert_input_question_activity($user_id, 'HS3D001', 'PS3BQ' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                    $this->_insert_input_question_activity($user_id, 'HS3D001', 'PS3BQ' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                break;
            }

            switch($scenario_4_activity) {
                case 0:
                    $this->_insert_input_question_activity($user_id, 'HS4D001', 'PS4BQModel', 'passthru');
                break;

                case 1:
                    $this->_insert_input_question_activity($user_id, 'HS4D001', 'PS4Null', 'shame');
                    $this->_insert_input_question_activity($user_id, 'HS4D001', 'PS4BQModel', 'passthru');
                break;

                case 2:
                    $this->_insert_input_question_activity($user_id, 'HS4D001', 'PS4BQ' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                    $this->_insert_input_question_activity($user_id, 'HS4D001', 'PS4BQModel', 'passthru');
                break;

                case 3:
                    $this->_insert_input_question_activity($user_id, 'HS4D001', 'PS4BQ' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                    $this->_insert_input_question_activity($user_id, 'HS4D001', 'PS4BQ' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                break;
            }

            switch($scenario_5_activity) {
                case 0:
                    $this->_insert_input_question_activity($user_id, 'HS5D001', 'PS5BQModel', 'passthru');
                break;

                case 1:
                    $this->_insert_input_question_activity($user_id, 'HS5D001', 'PS5Null', 'shame');
                    $this->_insert_input_question_activity($user_id, 'HS5D001', 'PS5BQModel', 'passthru');
                break;

                case 2:
                    $this->_insert_input_question_activity($user_id, 'HS5D001', 'PS5BQ' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                    $this->_insert_input_question_activity($user_id, 'HS5D001', 'PS5BQModel', 'passthru');
                break;

                case 3:
                    $this->_insert_input_question_activity($user_id, 'HS5D001', 'PS5BQ' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                    $this->_insert_input_question_activity($user_id, 'HS5D001', 'PS5BQ' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                break;
            }

            switch($scenario_6_activity) {
                case 0:
                    $this->_insert_input_question_activity($user_id, 'HS6D001', 'PS6BQModel', 'passthru');
                break;

                case 1:
                    $this->_insert_input_question_activity($user_id, 'HS6D001', 'PS6Null', 'shame');
                    $this->_insert_input_question_activity($user_id, 'HS6D001', 'PS6BQModel', 'passthru');
                break;

                case 2:
                    $this->_insert_input_question_activity($user_id, 'HS6D001', 'PS6BQ' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                    $this->_insert_input_question_activity($user_id, 'HS6D001', 'PS6BQModel', 'passthru');
                break;

                case 3:
                    $this->_insert_input_question_activity($user_id, 'HS6D001', 'PS6BQ' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                    $this->_insert_input_question_activity($user_id, 'HS6D001', 'PS6BQ' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                break;
            }

            $this->_log_flow_attempt_end($user_id, $end_datetime);
        }

        echo 'behavioral_questions end<br />';
    }

    /**
     * follow_up_questions
     *
     * insert follow-up questions questions test scenarios
     * 6 distinct follow up questions
     *
     *
     * 0. Didn't attempt
     * 1. Model Response First Try
     * 2. Model Response Second Try without Previous Point Subtracting Attempt
     * 3. Model Response Second Try with Previous Point Subtracting Attempt
     * 4. Two Point Subtacting Attempts
     * 5. One Point Subtracting Attempt - user abandoned question
     *
     * @return type
     */
    public function follow_up_questions() {
        echo 'follow_up_questions start<br />';

        for($scenario_activity_type = 0; $scenario_activity_type <= 5; $scenario_activity_type++) {
            $this->_insert_follow_up_questions_activity($scenario_activity_type, $scenario_activity_type, $scenario_activity_type, $scenario_activity_type, $scenario_activity_type, $scenario_activity_type);
        }


        for($scenario_activity_type = 1; $scenario_activity_type <= 5; $scenario_activity_type++) {
            for($test_only_scenario_num = 1; $test_only_scenario_num <= 6; $test_only_scenario_num++) {
                switch($test_only_scenario_num) {
                    case 1:
                        $this->_insert_follow_up_questions_activity($scenario_activity_type, 0, 0, 0, 0, 0);
                    break;

                    case 2:
                        $this->_insert_follow_up_questions_activity(0, $scenario_activity_type, 0, 0, 0, 0);
                    break;

                    case 3:
                        $this->_insert_follow_up_questions_activity(0, 0, $scenario_activity_type, 0, 0, 0);
                    break;

                    case 4:
                        $this->_insert_follow_up_questions_activity(0, 0, 0, $scenario_activity_type, 0, 0);
                    break;

                    case 5:
                        $this->_insert_follow_up_questions_activity(0, 0, 0, 0, $scenario_activity_type, 0);
                    break;

                    case 6:
                        $this->_insert_follow_up_questions_activity(0, 0, 0, 0, 0, $scenario_activity_type);
                    break;
                }
            }
        }

        echo 'follow_up_questions end<br />';
    }

    private function _insert_follow_up_questions_activity($scenario_1_activity, $scenario_2_activity, $scenario_3_activity, $scenario_4_activity, $scenario_5_activity, $scenario_6_activity) {
        $this->db->save_queries = false;

        $non_model_response_type_suffixes = array(
            'Wrong',
            'Leading',
            'Theo',
            'Vague'
        );

        $email = sprintf('follow_up_scoring_test_%s_%s_%s_%s_%s_%s@medrespond.com', sprintf('%03d', decbin($scenario_1_activity)), sprintf('%03d', decbin($scenario_2_activity)), sprintf('%03d', decbin($scenario_3_activity)), sprintf('%03d', decbin($scenario_4_activity)), sprintf('%03d', decbin($scenario_5_activity)), sprintf('%03d', decbin($scenario_6_activity)));

        $user_id = $this->user_model->insert_user(
            '',                                 // first_name
            '',                                 // last_name
            $email,                             // username
            17,                                 // organization_id
            4,                                  // user_type_id
            $email,                             // email
            'd41d8cd98f00b204e9800998ecf8427e', // password
            1                                   // login_enabled
        );

        $start_datetime = date('Y-m-d H:i:s', now());
        $end_datetime = date('Y-m-d H:i:s', now() + rand(300 , 14400));

        $this->_log_flow_attempt_start($user_id, $start_datetime);

        switch($scenario_1_activity) {
            case 0:
                // no op
            break;

            case 1:
                // Model Response First Try
                $this->_insert_input_question_activity($user_id, 'HS1FW001', 'PS1FWModel', 'passthru');
            break;

            case 2:
                // Model Response Second Try without Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS1FW001', 'PS1Null', 'null');
                $this->_insert_input_question_activity($user_id, 'HS1FW001', 'PS1FWModel', 'passthru');
            break;

            case 3:
                // Model Response Second Try with Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS1FW001', 'PS1FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS1FW001', 'PS1FWModel', 'passthru');
            break;

            case 4:
                // Two Point Subtacting Attempts
                $this->_insert_input_question_activity($user_id, 'HS1FW001', 'PS1FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS1FW001', 'PS1FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
            break;

            case 5:
                // One Point Subtracting Attempt - user abandoned question
                $this->_insert_input_question_activity($user_id, 'HS1FW001', 'PS1FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
            break;
        }

        switch($scenario_2_activity) {
            case 0:
                // no op
            break;

            case 1:
                // Model Response First Try
                $this->_insert_input_question_activity($user_id, 'HS2FW001', 'PS2FWModel', 'passthru');
            break;

            case 2:
                // Model Response Second Try without Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS2FW001', 'PS2Null', 'null');
                $this->_insert_input_question_activity($user_id, 'HS2FW001', 'PS2FWModel', 'passthru');
            break;

            case 3:
                // Model Response Second Try with Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS2FW001', 'PS2FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS2FW001', 'PS2FWModel', 'passthru');
            break;

            case 4:
                // Two Point Subtacting Attempts
                $this->_insert_input_question_activity($user_id, 'HS2FW001', 'PS2FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS2FW001', 'PS2FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
            break;

            case 5:
                // One Point Subtracting Attempt - user abandoned question
                $this->_insert_input_question_activity($user_id, 'HS2FW001', 'PS2FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
            break;
        }

        switch($scenario_3_activity) {
        case 0:
            // no op
        break;

        case 1:
            // Model Response First Try
            $this->_insert_input_question_activity($user_id, 'HS3FW001', 'PS3FWModel', 'passthru');
        break;

        case 2:
            // Model Response Second Try without Previous Point Subtracting Attempt
            $this->_insert_input_question_activity($user_id, 'HS3FW001', 'PS3Null', 'null');
            $this->_insert_input_question_activity($user_id, 'HS3FW001', 'PS3FWModel', 'passthru');
        break;

        case 3:
            // Model Response Second Try with Previous Point Subtracting Attempt
            $this->_insert_input_question_activity($user_id, 'HS3FW001', 'PS3FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
            $this->_insert_input_question_activity($user_id, 'HS3FW001', 'PS3FWModel', 'passthru');
        break;

        case 4:
            // Two Point Subtacting Attempts
            $this->_insert_input_question_activity($user_id, 'HS3FW001', 'PS3FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
            $this->_insert_input_question_activity($user_id, 'HS3FW001', 'PS3FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
        break;

        case 5:
            // One Point Subtracting Attempt - user abandoned question
            $this->_insert_input_question_activity($user_id, 'HS3FW001', 'PS3FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
        break;
        }

        switch($scenario_4_activity) {
            case 0:
                // no op
            break;

            case 1:
                // Model Response First Try
                $this->_insert_input_question_activity($user_id, 'HS4FW001', 'PS4FWModel', 'passthru');
            break;

            case 2:
                // Model Response Second Try without Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS4FW001', 'PS4Null', 'null');
                $this->_insert_input_question_activity($user_id, 'HS4FW001', 'PS4FWModel', 'passthru');
            break;

            case 3:
                // Model Response Second Try with Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS4FW001', 'PS4FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS4FW001', 'PS4FWModel', 'passthru');
            break;

            case 4:
                // Two Point Subtacting Attempts
                $this->_insert_input_question_activity($user_id, 'HS4FW001', 'PS4FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS4FW001', 'PS4FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
            break;

            case 5:
                // One Point Subtracting Attempt - user abandoned question
                $this->_insert_input_question_activity($user_id, 'HS4FW001', 'PS4FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
            break;
        }

        switch($scenario_5_activity) {
            case 0:
                // no op
            break;

            case 1:
                // Model Response First Try
                $this->_insert_input_question_activity($user_id, 'HS5FW001', 'PS5FWModel', 'passthru');
            break;

            case 2:
                // Model Response Second Try without Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS5FW001', 'PS5Null', 'null');
                $this->_insert_input_question_activity($user_id, 'HS5FW001', 'PS5FWModel', 'passthru');
            break;

            case 3:
                // Model Response Second Try with Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS5FW001', 'PS5FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS5FW001', 'PS5FWModel', 'passthru');
            break;

            case 4:
                // Two Point Subtacting Attempts
                $this->_insert_input_question_activity($user_id, 'HS5FW001', 'PS5FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS5FW001', 'PS5FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
            break;

            case 5:
                // One Point Subtracting Attempt - user abandoned question
                $this->_insert_input_question_activity($user_id, 'HS5FW001', 'PS5FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
            break;
        }

        switch($scenario_6_activity) {
            case 0:
                // no op
            break;

            case 1:
                // Model Response First Try
                $this->_insert_input_question_activity($user_id, 'HS6FW001', 'PS6FWModel', 'passthru');
            break;

            case 2:
                // Model Response Second Try without Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS6FW001', 'PS6Null', 'null');
                $this->_insert_input_question_activity($user_id, 'HS6FW001', 'PS6FWModel', 'passthru');
            break;

            case 3:
                // Model Response Second Try with Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS6FW001', 'PS6FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS6FW001', 'PS6FWModel', 'passthru');
            break;

            case 4:
                // Two Point Subtacting Attempts
                $this->_insert_input_question_activity($user_id, 'HS6FW001', 'PS6FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS6FW001', 'PS6FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
            break;

            case 5:
                // One Point Subtracting Attempt - user abandoned question
                $this->_insert_input_question_activity($user_id, 'HS6FW001', 'PS6FW' . $non_model_response_type_suffixes[rand(0, 3)], 'point_subtracting_input');
            break;
        }

        $this->_log_flow_attempt_end($user_id, $end_datetime);
    }

    /**
     * motivational_fit_questions
     *
     * insert motivational fit questions questions test scenarios
     * 6 distinct motivational fit questions
     *
     *
     * 0. Didn't attempt
     * 1. Model Response First Try
     * 2. Model Response Second Try without Previous Point Subtracting Attempt
     * 3. Model Response Second Try with Previous Point Subtracting Attempt
     * 4. Two Point Subtacting Attempts
     * 5. One Point Subtracting Attempt - user abandoned question
     *
     * @return type
     */
    public function motivational_fit_questions() {
        echo 'motivational_fit_questions start<br />';

        for($scenario_activity_type = 0; $scenario_activity_type <= 5; $scenario_activity_type++) {
            $this->_insert_motivational_fit_questions_activity($scenario_activity_type, $scenario_activity_type, $scenario_activity_type, $scenario_activity_type, $scenario_activity_type, $scenario_activity_type);
        }

        for($scenario_activity_type = 1; $scenario_activity_type <= 5; $scenario_activity_type++) {
            for($test_only_scenario_num = 1; $test_only_scenario_num <= 6; $test_only_scenario_num++) {
                switch($test_only_scenario_num) {
                    case 1:
                        $this->_insert_motivational_fit_questions_activity($scenario_activity_type, 0, 0, 0, 0, 0);
                    break;

                    case 2:
                        $this->_insert_motivational_fit_questions_activity(0, $scenario_activity_type, 0, 0, 0, 0);
                    break;

                    case 3:
                        $this->_insert_motivational_fit_questions_activity(0, 0, $scenario_activity_type, 0, 0, 0);
                    break;

                    case 4:
                        $this->_insert_motivational_fit_questions_activity(0, 0, 0, $scenario_activity_type, 0, 0);
                    break;

                    case 5:
                        $this->_insert_motivational_fit_questions_activity(0, 0, 0, 0, $scenario_activity_type, 0);
                    break;

                    case 6:
                        $this->_insert_motivational_fit_questions_activity(0, 0, 0, 0, 0, $scenario_activity_type);
                    break;
                }
            }
        }


        echo 'motivational_fit_questions end<br />';
    }

    private function _insert_motivational_fit_questions_activity($scenario_1_activity, $scenario_2_activity, $scenario_3_activity, $scenario_4_activity, $scenario_5_activity, $scenario_6_activity) {
        $this->db->save_queries = false;

        $non_model_response_type_suffixes = array(
            'Leading',
            'Vague'
        );

        $email = sprintf('motivational_fit_scoring_test_%s_%s_%s_%s_%s_%s@medrespond.com', sprintf('%03d', decbin($scenario_1_activity)), sprintf('%03d', decbin($scenario_2_activity)), sprintf('%03d', decbin($scenario_3_activity)), sprintf('%03d', decbin($scenario_4_activity)), sprintf('%03d', decbin($scenario_5_activity)), sprintf('%03d', decbin($scenario_6_activity)));

        $user_id = $this->user_model->insert_user(
            '',                                 // first_name
            '',                                 // last_name
            $email,                             // username
            17,                                 // organization_id
            4,                                  // user_type_id
            $email,                             // email
            'd41d8cd98f00b204e9800998ecf8427e', // password
            1                                   // login_enabled
        );

        $start_datetime = date('Y-m-d H:i:s', now());
        $end_datetime = date('Y-m-d H:i:s', now() + rand(300 , 14400));

        $this->_log_flow_attempt_start($user_id, $start_datetime);

        switch($scenario_1_activity) {
            case 0:
                // no op
            break;

            case 1:
                // Model Response First Try
                $this->_insert_input_question_activity($user_id, 'HS1MF001', 'PS1MFModel', 'passthru');
            break;

            case 2:
                // Model Response Second Try without Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS1MF001', 'PS1Null', 'null');
                $this->_insert_input_question_activity($user_id, 'HS1MF001', 'PS1MFModel', 'passthru');
            break;

            case 3:
                // Model Response Second Try with Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS1MF001', 'PS1MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS1MF001', 'PS1MFModel', 'passthru');
            break;

            case 4:
                // Two Point Subtacting Attempts
                $this->_insert_input_question_activity($user_id, 'HS1MF001', 'PS1MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS1MF001', 'PS1MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
            break;

            case 5:
                // One Point Subtracting Attempt - user abandoned question
                $this->_insert_input_question_activity($user_id, 'HS1MF001', 'PS1MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
            break;
        }

        switch($scenario_2_activity) {
            case 0:
                // no op
            break;

            case 1:
                // Model Response First Try
                $this->_insert_input_question_activity($user_id, 'HS2MF001', 'PS2MFModel', 'passthru');
            break;

            case 2:
                // Model Response Second Try without Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS2MF001', 'PS2Null', 'null');
                $this->_insert_input_question_activity($user_id, 'HS2MF001', 'PS2MFModel', 'passthru');
            break;

            case 3:
                // Model Response Second Try with Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS2MF001', 'PS2MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS2MF001', 'PS2MFModel', 'passthru');
            break;

            case 4:
                // Two Point Subtacting Attempts
                $this->_insert_input_question_activity($user_id, 'HS2MF001', 'PS2MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS2MF001', 'PS2MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
            break;

            case 5:
                // One Point Subtracting Attempt - user abandoned question
                $this->_insert_input_question_activity($user_id, 'HS2MF001', 'PS2MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
            break;
        }

        switch($scenario_3_activity) {
        case 0:
            // no op
        break;

        case 1:
            // Model Response First Try
            $this->_insert_input_question_activity($user_id, 'HS3MF001', 'PS3MFModel', 'passthru');
        break;

        case 2:
            // Model Response Second Try without Previous Point Subtracting Attempt
            $this->_insert_input_question_activity($user_id, 'HS3MF001', 'PS3Null', 'null');
            $this->_insert_input_question_activity($user_id, 'HS3MF001', 'PS3MFModel', 'passthru');
        break;

        case 3:
            // Model Response Second Try with Previous Point Subtracting Attempt
            $this->_insert_input_question_activity($user_id, 'HS3MF001', 'PS3MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
            $this->_insert_input_question_activity($user_id, 'HS3MF001', 'PS3MFModel', 'passthru');
        break;

        case 4:
            // Two Point Subtacting Attempts
            $this->_insert_input_question_activity($user_id, 'HS3MF001', 'PS3MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
            $this->_insert_input_question_activity($user_id, 'HS3MF001', 'PS3MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
        break;

        case 5:
            // One Point Subtracting Attempt - user abandoned question
            $this->_insert_input_question_activity($user_id, 'HS3MF001', 'PS3MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
        break;
        }

        switch($scenario_4_activity) {
            case 0:
                // no op
            break;

            case 1:
                // Model Response First Try
                $this->_insert_input_question_activity($user_id, 'HS4MF001', 'PS4MFModel', 'passthru');
            break;

            case 2:
                // Model Response Second Try without Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS4MF001', 'PS4Null', 'null');
                $this->_insert_input_question_activity($user_id, 'HS4MF001', 'PS4MFModel', 'passthru');
            break;

            case 3:
                // Model Response Second Try with Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS4MF001', 'PS4MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS4MF001', 'PS4MFModel', 'passthru');
            break;

            case 4:
                // Two Point Subtacting Attempts
                $this->_insert_input_question_activity($user_id, 'HS4MF001', 'PS4MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS4MF001', 'PS4MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
            break;

            case 5:
                // One Point Subtracting Attempt - user abandoned question
                $this->_insert_input_question_activity($user_id, 'HS4MF001', 'PS4MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
            break;
        }

        switch($scenario_5_activity) {
            case 0:
                // no op
            break;

            case 1:
                // Model Response First Try
                $this->_insert_input_question_activity($user_id, 'HS5MF001', 'PS5MFModel', 'passthru');
            break;

            case 2:
                // Model Response Second Try without Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS5MF001', 'PS5Null', 'null');
                $this->_insert_input_question_activity($user_id, 'HS5MF001', 'PS5MFModel', 'passthru');
            break;

            case 3:
                // Model Response Second Try with Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS5MF001', 'PS5MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS5MF001', 'PS5MFModel', 'passthru');
            break;

            case 4:
                // Two Point Subtacting Attempts
                $this->_insert_input_question_activity($user_id, 'HS5MF001', 'PS5MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS5MF001', 'PS5MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
            break;

            case 5:
                // One Point Subtracting Attempt - user abandoned question
                $this->_insert_input_question_activity($user_id, 'HS5MF001', 'PS5MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
            break;
        }

        switch($scenario_6_activity) {
            case 0:
                // no op
            break;

            case 1:
                // Model Response First Try
                $this->_insert_input_question_activity($user_id, 'HS6MF001', 'PS6MFModel', 'passthru');
            break;

            case 2:
                // Model Response Second Try without Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS6MF001', 'PS6Null', 'null');
                $this->_insert_input_question_activity($user_id, 'HS6MF001', 'PS6MFModel', 'passthru');
            break;

            case 3:
                // Model Response Second Try with Previous Point Subtracting Attempt
                $this->_insert_input_question_activity($user_id, 'HS6MF001', 'PS6MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS6MF001', 'PS6MFModel', 'passthru');
            break;

            case 4:
                // Two Point Subtacting Attempts
                $this->_insert_input_question_activity($user_id, 'HS6MF001', 'PS6MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
                $this->_insert_input_question_activity($user_id, 'HS6MF001', 'PS6MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
            break;

            case 5:
                // One Point Subtracting Attempt - user abandoned question
                $this->_insert_input_question_activity($user_id, 'HS6MF001', 'PS6MF' . $non_model_response_type_suffixes[rand(0, 1)], 'point_subtracting_input');
            break;
        }

        $this->_log_flow_attempt_end($user_id, $end_datetime);
    }

    private function _insert_next_click_activity($user_id, $current_response, $response_id, $datetime = NULL) {
        $datetime = ($datetime !== NULL) ? $datetime : date('Y-m-d H:i:s', now());

        $this->db->insert('master_activity_logs', array(
            'mr_project'            => MR_PROJECT,
            'mr_directory'          => 'tss',
            'session_id'            => '123456789',
            'ip_address'            => '127.0.0.1',
            'operating_system'      => '',
            'browser'               => '',
            'user_id'               => $user_id,
            'action'                => 'Next',
            'input_question'        => '',
            'case_name'             => 'ACTIVITY_INSERTED_BY_SCRIPT',
            'current_response'      => $current_response,
            'response_id'           => $response_id,
            'response_question'     => '',
            'response_type'         => '',
            'was_asl_response'      => 0,
            'flow_attempt'          => 1,
            'flow_response_attempt' => 1,
            'date'                  => $datetime,
            'ma_response_id'        => '',
            'ma_question_1'         => '',
            'ma_question_2'         => '',
            'ma_question_3'         => ''
        ));
    }

    private function _insert_input_question_activity($user_id, $current_response, $response_id, $input_question) {
        $datetime = date('Y-m-d H:i:s', now());

        $this->db->insert('master_activity_logs', array(
            'mr_project'            => MR_PROJECT,
            'mr_directory'          => 'tss',
            'session_id'            => '123456789',
            'ip_address'            => '127.0.0.1',
            'operating_system'      => '',
            'browser'               => '',
            'user_id'               => $user_id,
            'action'                => 'Answer',
            'input_question'        => $input_question,
            'case_name'             => 'ACTIVITY_INSERTED_BY_SCRIPT',
            'current_response'      => $current_response,
            'response_id'           => $response_id,
            'response_question'     => '',
            'response_type'         => '',
            'was_asl_response'      => 0,
            'flow_attempt'          => 1,
            'flow_response_attempt' => 1,
            'date'                  => $datetime,
            'ma_response_id'        => '',
            'ma_question_1'         => '',
            'ma_question_2'         => '',
            'ma_question_3'         => ''
        ));
    }

    private function _log_flow_attempt_start($user_id, $datetime) {
        $this->db->insert('master_activity_logs', array(
            'mr_project'            => MR_PROJECT,
            'mr_directory'          => 'tss',
            'session_id'            => '123456789',
            'ip_address'            => '127.0.0.1',
            'operating_system'      => '',
            'browser'               => '',
            'user_id'               => $user_id,
            'action'                => 'Start',
            'input_question'        => '',
            'case_name'             => '',
            'current_response'      => '',
            'response_id'           => 'HIntroD001',
            'response_question'     => '',
            'response_type'         => '',
            'was_asl_response'      => 0,
            'flow_attempt'          => 1,
            'flow_response_attempt' => 1,
            'date'                  => $datetime,
            'ma_response_id'        => '',
            'ma_question_1'         => '',
            'ma_question_2'         => '',
            'ma_question_3'         => ''
        ));


    }

    private function _log_flow_attempt_end($user_id, $datetime) {
        $this->_insert_next_click_activity($user_id, 'HS6D002', 'HEndD001', $datetime);
    }

}
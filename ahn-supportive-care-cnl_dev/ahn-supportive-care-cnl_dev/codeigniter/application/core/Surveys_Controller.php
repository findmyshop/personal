<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Surveys_Controller extends Constants_Controller
{
    public function __construct() {
        parent::__construct();

        $this->load->model('survey_model');

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function ajax_angular_get_surveys() {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        echo json_encode(array(
            'status' => 'success',
            'surveys' => $this->survey_model->get_surveys()
        ));
    }

    public function ajax_angular_submit_survey_responses() {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $post_data = json_decode(file_get_contents("php://input"), TRUE);
        $survey_id = $post_data['survey_id'];
        $user_survey_question_responses = $post_data['user_survey_question_responses'];

        if($insert_rows = $this->_validate_survey_submission($survey_id, $user_survey_question_responses)) {
            if($this->survey_model->insert_user_survey_responses($survey_id, $insert_rows)) {
                echo json_encode(array(
                    'status'    => 'success'
                ));
            } else {
                echo json_encode(array(
                    'status'    => 'failure',
                    'message'   => 'Error saving survey question responses.'
                ));
            }
        } else {
            echo json_encode(array(
                'status'    => 'failure',
                'message'   => 'Please select an answer for each survey question.'
            ));
        }
    }

    public function ajax_angular_get_survey_responses_data() {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        echo json_encode(array(
            'status'                => 'success',
            'survey_responses_data' => $this->survey_model->get_survey_responses_data()
        ));
    }

    private function _validate_survey_submission($survey_id, $user_survey_question_responses) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $insert_rows = array();

        foreach($this->survey_model->get_survey_questions($survey_id) as $survey_question) {
            if($survey_question['input_type'] === 'radio') {
                // make sure that each radio survey question was answered
                if(!array_key_exists($survey_question['id'], $user_survey_question_responses)) {
                    return array();
                }

                // make sure that each radio survey selection was valid
                if(!in_array($user_survey_question_responses[$survey_question['id']], array_column($this->survey_model->get_survey_question_radio_options($survey_question['id']), 'id'))) {
                    return array();
                }

                $insert_rows[] = array(
                    'question_id'              => $survey_question['id'],
                    'selected_radio_option_id' => $user_survey_question_responses[$survey_question['id']],
                    'input_text'               => NULL
                );
            } else if($survey_question['input_type'] === 'text') {
                if(!array_key_exists($survey_question['id'], $user_survey_question_responses) || empty($user_survey_question_responses[$survey_question['id']])) {
                    $user_survey_question_responses[$survey_question['id']] = NULL;
                }

                $insert_rows[] = array(
                    'question_id'              => $survey_question['id'],
                    'selected_radio_option_id' => NULL,
                    'input_text'               => $user_survey_question_responses[$survey_question['id']]
                );
            }
        }

        return $insert_rows;
    }
}
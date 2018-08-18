<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Survey_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function get_surveys() {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $surveys = array();
        $survey_ids = $this->get_survey_ids();

        foreach($survey_ids as $survey_index => $survey_id) {
            $surveys[$survey_index]['id'] = $survey_id;
            $surveys[$survey_index]['questions'] = $this->get_survey_questions($surveys[$survey_index]['id']);

            foreach($surveys[$survey_index]['questions'] as $survey_question_index => $question) {
                $surveys[$survey_index]['questions'][$survey_question_index]['options'] = $this->get_survey_question_radio_options($question['id']);
            }
        }

        return $surveys;
    }

    public function get_survey_ids() {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $query = $this->db
            ->select('id')
            ->from('master_surveys')
            ->where('property_id', PROPERTY_ID)
            ->get();

        if($query->num_rows() > 0) {
            return array_column($query->result_array(), 'id');
        }

        return array();
    }

    public function get_survey_questions($survey_id) {
        log_debug(__FILE__, __LINE__, __METHOD__, sprintf('Called with $survey_id = %d', $survey_id));

        $query = $this->db
            ->select('*')
            ->from('master_survey_questions')
            ->where('survey_id', $survey_id)
            ->order_by('id', 'asc')
            ->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }

        return array();
    }

    public function get_survey_question_radio_options($question_id) {
        log_debug(__FILE__, __LINE__, __METHOD__, sprintf('Called with $question_id = %d', $question_id));

         $query = $this->db
            ->select('*')
            ->from('master_survey_question_radio_options')
            ->where('question_id', $question_id)
            ->order_by('id', 'asc')
            ->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }

        return array();
    }

    public function get_survey_responses_data($property_id = PROPERTY_ID) {
        $sql = "
            SELECT
                ms.id AS survey_id,
                muss.id AS submission_id,
                muss.ip_address,
                muss.session_id,
                muss.user_id,
                muss.timestamp_created AS submission_date,
                msq.id AS question_id,
                msq.input_type,
                msq.text as question_text,
                musr.selected_radio_option_id,
                IF(
                    msq.input_type = 'radio',
                    msqro.text,
                    musr.input_text
                ) AS answer_text
            FROM master_user_survey_submissions AS muss
            JOIN master_user_survey_responses AS musr
                ON musr.submission_id = muss.id
            JOIN master_survey_questions AS msq
                ON msq.id = musr.question_id
            JOIN master_surveys AS ms
                ON ms.id = msq.survey_id
            LEFT JOIN master_survey_question_radio_options AS msqro
                ON msqro.id = musr.selected_radio_option_id
            WHERE
                ms.property_id = $property_id
        ";

        $query = $this->db->query($sql);

        if($query->num_rows() > 0) {
            return $query->result_array();
        }

        return array();
    }

    public function insert_user_survey_responses($survey_id, $insert_rows) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $submission_data = array(
            'ip_address'    => $this->session->userdata('ip_address'),
            'session_id'    => $this->session->userdata('session_id'),
            'user_id'       => USER_AUTHENTICATION_REQUIRED ? $this->session->userdata('account_id') : NULL,
            'survey_id'     => $survey_id
        );

        $this->db->insert('master_user_survey_submissions', $submission_data);

        $submission_id = $this->db->insert_id();

        for($i = 0; $i < count($insert_rows); $i++) {
            $insert_rows[$i]['submission_id'] = $submission_id;
        }

        $this->db->insert_batch('master_user_survey_responses', $insert_rows);
    }

    public function property_has_surveys($property_id = PROPERTY_ID) {
        $query = $this->db
            ->select('count(id) AS count')
            ->from('master_surveys')
            ->where('property_id', $property_id)
            ->get();

        $result = $query->row_array();
        return ($result['count'] > 0) ? TRUE : FALSE;
    }

}

/* End of file survey_model.php */
/* Location: ./application/models/survey_model.php */

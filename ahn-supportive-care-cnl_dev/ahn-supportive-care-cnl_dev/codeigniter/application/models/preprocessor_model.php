<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preprocessor_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function insert_run($str, $disambiguated_str, $clause_segments, $curl_request_succeeded, $curl_request_milliseconds, $curl_error_message) {
        log_info(__FILE__, __LINE__, __METHOD__, sprintf('Called with str = %s', $str));

        $this->db->insert('master_preprocessor_runs', array(
            'string'                    => $str,
            'disambiguated_string'      => $disambiguated_str,
            'curl_request_succeeded'    => $curl_request_succeeded,
            'curl_request_milliseconds' => $curl_request_milliseconds,
            'curl_error_message'        => $curl_error_message
        ));

        if(!empty($clause_segments)) {
            $preprocessor_run_id = $this->db->insert_id();
            $clause_segments_batch_insert_data = array();

            foreach($clause_segments as $clause_segment) {
                $clause_segments_batch_insert_data[] = array(
                    'preprocessor_run_id' => $preprocessor_run_id,
                    'clause_segment'      => $clause_segment
                );
            }

            $this->db->insert_batch('master_preprocessor_clause_segments', $clause_segments_batch_insert_data);
        }

        return TRUE;
    }

}

/* End of file preprocessor_model.php */
/* Location: ./application/models/preprocessor_model.php */

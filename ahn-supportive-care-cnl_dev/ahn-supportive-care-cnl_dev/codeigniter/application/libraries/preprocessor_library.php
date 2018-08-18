<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Preprocessor_library {

    private $_ci = NULL;

    public function __construct() {
        $this->_ci =& get_instance();
        $this->_ci->load->model('preprocessor_model');

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function call_preprocessor($str) {
        log_debug(__FILE__, __LINE__, __METHOD__, sprintf('Called with str = %s', $str));

        $str = trim($str);
        $url_query_str = http_build_query(array('property_id' => PREPROCESSOR_PROPERTY_ID, 'string' => $str));
        $url = sprintf('%s?%s', PREPROCESSOR_URL, $url_query_str);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, PREPROCESSOR_CURLOPT_TIMEOUT_MS);
        $start_milliseconds = microtime(TRUE);
        $response = curl_exec($ch);
        $end_milliseconds = microtime(TRUE);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);

        // default to returning the string itself as the disambiguated string and sole clause segment
        $data = array(
            'clause_segments' => array($str),
            'disambiguated_string' => $str
        );

        $curl_request_succeeded = FALSE;
        $curl_request_milliseconds = round(($end_milliseconds - $start_milliseconds) * 1000);
        $curl_error_message = NULL;

        if($curl_errno > 0) {
            $curl_error_message = $curl_error;
            log_error(__FILE__, __LINE__, __METHOD__, sprintf('CURL ERROR - %s', $curl_error));
        } else {
            $response = json_decode($response, TRUE);

            if($response['success']) {
                $data['clause_segments'] = $response['data']['clause_segments'];
                $data['disambiguated_string'] = $response['data']['disambiguated_string'];
                $curl_request_succeeded = TRUE;
            }
        }

        $this->_ci->preprocessor_model->insert_run($str, $data['disambiguated_string'], $data['clause_segments'], $curl_request_succeeded, $curl_request_milliseconds, $curl_error_message);

        return $data;
    }

    public function call_preprocessor_clause_segmenter($str) {
        log_debug(__FILE__, __LINE__, __METHOD__, sprintf('Called with str = %s', $str));

        $str = trim($str);
        $url_query_str = http_build_query(array('string' => $str));
        $url = sprintf('%s?%s', PREPROCESSOR_CLAUSE_SEGMENTER_URL, $url_query_str);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, PREPROCESSOR_CURLOPT_TIMEOUT_MS);
        $start_milliseconds = microtime(TRUE);
        $response = curl_exec($ch);
        $end_milliseconds = microtime(TRUE);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);

        // by default, return an array containing just the input string
        $clause_segments = array($str);
        $curl_request_succeeded = FALSE;
        $curl_request_milliseconds = round(($end_milliseconds - $start_milliseconds) * 1000);
        $curl_error_message = NULL;

        if($curl_errno > 0) {
            $curl_error_message = $curl_error;
            log_error(__FILE__, __LINE__, __METHOD__, sprintf('CURL ERROR - %s', $curl_error));
        } else {
            $response = json_decode($response, TRUE);

            if($response['success']) {
                $clause_segments = $response['data']['clause_segments'];
                $curl_request_succeeded = TRUE;
            }
        }

        $this->_ci->preprocessor_model->insert_run($str, NULL, $clause_segments, $curl_request_succeeded, $curl_request_milliseconds, $curl_error_message);

        return $clause_segments;
    }

    public function call_preprocessor_disambiguator($str) {
        log_debug(__FILE__, __LINE__, __METHOD__, sprintf('Called with str = %s', $str));

        $str = trim($str);
        $url_query_str = http_build_query(array('property_id' => PREPROCESSOR_PROPERTY_ID, 'string' => $str));
        $url = sprintf('%s?%s', PREPROCESSOR_DISAMBIGUATOR_URL, $url_query_str);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, PREPROCESSOR_CURLOPT_TIMEOUT_MS);
        $start_milliseconds = microtime(TRUE);
        $response = curl_exec($ch);
        $end_milliseconds = microtime(TRUE);
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        curl_close($ch);

        // default to returning the string itself as the disambiguated string
        $disambiguated_string = $str;

        $curl_request_succeeded = FALSE;
        $curl_request_milliseconds = round(($end_milliseconds - $start_milliseconds) * 1000);
        $curl_error_message = NULL;

        if($curl_errno > 0) {
            $curl_error_message = $curl_error;
            log_error(__FILE__, __LINE__, __METHOD__, sprintf('CURL ERROR - %s', $curl_error));
        } else {
            $response = json_decode($response, TRUE);

            if($response['success']) {
                $disambiguated_string = $response['data']['disambiguated_string'];
                $curl_request_succeeded = TRUE;
            }
        }

        $this->_ci->preprocessor_model->insert_run($str, $disambiguated_string, [], $curl_request_succeeded, $curl_request_milliseconds, $curl_error_message);

        return $disambiguated_string;
    }


    public function str_contains_multiple_clauses($str) {
        log_debug(__FILE__, __LINE__, __METHOD__, sprintf('Called with str = %s', $str));

        $str = trim($str);
        $clause_segments = $this->call_clause_segmenter($str);

        if(count($clause_segments) > 1) {
            return TRUE;
        }

        return FALSE;
    }

}

/* End of file preprocessor_library.php */
/* Location: ./application/libraries/preprocessor_library.php */


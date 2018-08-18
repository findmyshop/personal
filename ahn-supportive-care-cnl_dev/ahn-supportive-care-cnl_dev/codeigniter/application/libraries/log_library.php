<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_library {
    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->model('log_model');
        $this->ci->load->library('csv_library');

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function write_activity_logs_to_csv_file($mr_project_filter, $language_filter, $search_keyword = FALSE, $search_start_date = FALSE, $search_end_date = FALSE, $organization_hierarchy_level_elements_filter, $user_id_filter, $fully_qualified_filename, $chunk_size = 1000) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $offset = 0;

        if(($query = $this->ci->log_model->get_activity_logs($mr_project_filter, $language_filter, $offset, $chunk_size, $search_keyword, $search_start_date, $search_end_date, $organization_hierarchy_level_elements_filter, $user_id_filter, TRUE)) === FALSE) {
            return FALSE;
        }

        if(!$this->ci->csv_library->write_query_result_to_csv_file($query, $fully_qualified_filename, TRUE)) {
            throw new Exception('Failed to Write CSV to File');
        }

        $offset += $chunk_size;

        while(($query = $this->ci->log_model->get_activity_logs($mr_project_filter, $language_filter, $offset, $chunk_size, $search_keyword, $search_start_date, $search_end_date, $organization_hierarchy_level_elements_filter, $user_id_filter, TRUE)) !== FALSE) {
            if(!$this->ci->csv_library->write_query_result_to_csv_file($query, $fully_qualified_filename, FALSE)) {
                throw new Exception('Failed to Write CSV to File');
            }
            $offset += $chunk_size;
        }

        return TRUE;
    }
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Response_category_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function get_view_counts() {
        $sql = "
            SELECT
                mrc.name AS response_category_name,
                SUM(IF(mal.id IS NOT NULL, 1, 0)) AS response_category_view_count
            FROM master_response_categories AS mrc
            JOIN master_response_response_category_map AS mrcm
                ON mrcm.response_category_id = mrc.id
            JOIN master_responses AS mr
                ON mr.id = mrcm.response_id
            LEFT JOIN master_activity_logs AS mal
                ON mal.response_id = mr.name
            WHERE mrc.property_id = ".PROPERTY_ID."
            GROUP BY mrc.name
            ORDER BY response_category_view_count DESC;
        ";

        $query = $this->db->query($sql);

        if($query->num_rows() > 0) {
            return $query->result_array();
        }

        return array();
    }

}

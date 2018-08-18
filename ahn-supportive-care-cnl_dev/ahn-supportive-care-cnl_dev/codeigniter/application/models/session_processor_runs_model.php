<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session_Processor_Runs_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function get_all()
    {
        $query = $this->db
            ->select('*')
            ->from('master_session_processor_runs')
            ->where('property_id', PROPERTY_ID)
            ->order_by('timestamp', 'desc')
            ->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }

        return array();
    }

    public function get_last_processed_activity_id()
    {
        $query = $this->db
            ->select('last_activity_id')
            ->from('master_session_processor_runs')
            ->where('property_id', PROPERTY_ID)
            ->where('last_activity_id is NOT NULL', NULL, FALSE)
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get();

        if($query->num_rows() == 1) {
            $row = $query->row_array();

            if($row['last_activity_id'] !== NULL) {
                return $row['last_activity_id'];
            }
        }

        return 0;
    }

    public function insert($first_activity_id = NULL, $last_activity_id = NULL, $start_timestamp = NULL, $end_timestamp = NULL)
    {
        $data = array(
            'property_id' => PROPERTY_ID
        );

        if($first_activity_id !== NULL) {
            $data['first_activity_id'] = $first_activity_id;
        }

        if($last_activity_id !== NULL) {
            $data['last_activity_id'] = $last_activity_id;
        }

        if($start_timestamp === NULL) {
            $data['start_timestamp'] = date('Y-m-d G:i:s');
        } else {
            $data['start_timestamp'] = date('Y-m-d G:i:s', strtotime($start_timestamp));
        }

        if($end_timestamp !== NULL) {
            $data['end_timestamp'] = date('Y-m-d G:i:s', strtotime($end_timestamp));
        }

        $this->db->insert('master_session_processor_runs', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db
            ->where('id', $id)
            ->update('master_session_processor_runs', $data);

        return $this->db->affected_rows();
    }

}

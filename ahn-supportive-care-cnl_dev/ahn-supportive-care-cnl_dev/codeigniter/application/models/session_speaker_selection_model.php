<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session_speaker_selection_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function get_stats($property_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with property_id = $property_id");

        $property_id = $this->db->escape_str($property_id);

        $sql = "
            SELECT
                master_session_speaker_selection_options.display_name AS name,
                COUNT(1) AS count
            FROM master_session_speaker_selections
            JOIN master_session_speaker_selection_options
                ON master_session_speaker_selection_options.post_name = master_session_speaker_selections.selection
            WHERE master_session_speaker_selections.property_id = $property_id
            GROUP BY master_session_speaker_selections.selection;
        ";

        $query = $this->db->query($sql);

        if($query->num_rows() > 0) {
            return $query->result_array();
        }

        return array();
    }

    public function insert($property_id, $session_id, $selection)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with property_id = $property_id | session_id = $session_id  | selection = $selection");

        $this->db->insert('master_session_speaker_selections', array(
            'property_id' => $property_id,
            'session_id'  => $session_id,
            'selection'   => $selection
        ));

        return $this->db->insert_id();
    }

}
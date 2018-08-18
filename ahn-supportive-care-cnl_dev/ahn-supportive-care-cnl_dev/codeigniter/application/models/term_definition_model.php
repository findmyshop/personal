<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Term_definition_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function get_property_term_definitions($property_id = PROPERTY_ID) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        if(!empty($property_id)) {
            $query = $this->db->select('id, term, definition, active')
                ->from('master_term_definitions')
                ->where(array(
                    'property_id' => $property_id
                ))
                ->get();

            if($query->num_rows() > 0) {
                return $query->result_array();
            }
        }

        return array();
    }

    public function update_term_definition($id, $term, $definition, $active) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $this->db
            ->where('id', $id)
            ->update('master_term_definitions', array(
                'term' => $term,
                'definition' => $definition,
                'active' => $active
            ));

        return $this->db->affected_rows();
    }

    public function insert_term_definition($property_id, $term, $definition, $active) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $this->db->insert('master_term_definitions', array(
                'property_id' => $property_id,
                'term'        => $term,
                'definition'  => $definition,
                'active'      => $active
            ));

        return $this->db->insert_id();
    }
}

/* End of file term_definition_model.php */
/* Location: ./application/models/term_definition_model.php */

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organization_hierarchy_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function element_ids_arr_contains_element_in_level($element_ids, $level_id) {
        log_info(__FILE__, __LINE__, __METHOD__, 'Called');

        if(empty($element_ids) || empty($level_id) || !is_numeric($level_id)) {
            return FALSE;
        }

        foreach($element_ids as $element_id) {
            if(!is_numeric($element_id)) {
                return FALSE;
            }
        }

        $query = $this->db
            ->select('id')
            ->from('master_organization_hierarchy_level_elements')
            ->where(array(
                    'organization_hierarchy_level_id'   => $level_id,
                    'active'                                                    => 1
                ))
            ->where_in('id', $element_ids)
            ->limit(1)
            ->get();

        if($query->num_rows() > 0) {
            return TRUE;
        }

        return FALSE;
    }

    public function get_assigned_organization_hierarchy_level_element_ids($user_id) {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

        $query = $this->db
            ->select('mohl.id as organization_hierarchy_level_id, mohl.multi_sibling_membership_allowed, mohle.id as organization_hierarchy_level_element_id')
            ->from('master_users_organization_hierarchy_level_element_map AS muohlem')
            ->join('master_organization_hierarchy_level_elements AS mohle', 'mohle.id = muohlem.organization_hierarchy_level_element_id')
            ->join('master_organization_hierarchy_levels as mohl', 'mohl.id = mohle.organization_hierarchy_level_id')
            ->where(array(
                    'muohlem.user_id' => $user_id,
                    'muohlem.active'  => 1,
                    'mohle.active'    => 1,
                    'mohl.active'     => 1
                ))
            ->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }

        return array();
    }

    public function get_organization_hierarchy_levels($organization_id = NULL) {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with organization_id = $organization_id");

        $organization_where = 'AND 1 = 1';

        if(!empty($organization_id) && is_numeric($organization_id)) {
            $organization_where = "AND mo.id = $organization_id";
        }

        $sql = "
            SELECT
                mo.id AS organization_id,
                mo.name AS organization_name,
                mohl.parent_id AS organization_hierarchy_level_parent_id,
                mohl.id AS organization_hierarchy_level_id,
                mohl.name AS organization_hierarchy_level_name,
                mohl.plural_name AS organization_hierarchy_level_plural_name,
                mohl.multi_sibling_membership_allowed
            FROM master_organization_hierarchy_levels AS mohl
            JOIN master_organizations AS mo
                ON mo.id = mohl.organization_id
            WHERE
                mohl.active = 1
                $organization_where
            ORDER BY organization_hierarchy_level_parent_id ASC
        ";

        $query = $this->db->query($sql);

        if($query->num_rows() > 0) {
            if($organization_id === NULL) {
                $temp = $query->result_array();
                $data = array();

                foreach($temp as $row) {
                    $data[$row['organization_id']][] = $row;
                }

                return $data;
            }

            return $query->result_array();
        }

        return array();
    }

    public function get_organization_hierarchy_level_elements($organization_id = NULL) {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with organization_id = $organization_id");

        $organization_where = 'AND 1 = 1';

        if(!empty($organization_id) && is_numeric($organization_id)) {
            $organization_where = "AND mo.id = $organization_id";
        }

        $sql = "
            SELECT
                mo.id AS organization_id,
                mo.name AS organization_name,
                mohl.id AS organization_hierarchy_level_id,
                mohl.parent_id AS organization_hierarchy_level_parent_id,
                mohl.name AS organization_hierarchy_level_name,
                mohl.plural_name AS organization_hierarchy_level_plural_name,
                mohl.multi_sibling_membership_allowed,
                mohle.id AS organization_hierarchy_level_element_id,
                mohlerm.organization_hierarchy_level_element_parent_id,
                mohle.name AS organization_hierarchy_level_element_name
            FROM master_organization_hierarchy_level_elements AS mohle
            JOIN master_organization_hierarchy_level_element_relationship_map AS mohlerm
                ON mohlerm.organization_hierarchy_level_element_id = mohle.id
                AND mohlerm.active = 1
            JOIN master_organization_hierarchy_levels AS mohl
                ON mohl.id = mohle.organization_hierarchy_level_id
                AND mohl.active = 1
            JOIN master_organizations AS mo
                ON mo.id = mohl.organization_id
                AND mo.active = 1
            WHERE
                mohle.active = 1
                $organization_where
        ";

        $query = $this->db->query($sql);

        if($query->num_rows() > 0) {
            if($organization_id === NULL) {
                $temp = $query->result_array();
                $data = array();

                foreach($temp as $row) {
                    $data[$row['organization_id']][] = $row;
                }

                return $data;
            }

            return $query->result_array();
        }

        return array();
    }

    public function get_organization_hierarchy_level_element_by_id($id) {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with id = $id");

        $query = $this->db
            ->select('*')
            ->from('master_organization_hierarchy_level_elements')
            ->where('id', $id)
            ->limit(1)
            ->get();

        if($query->num_rows() == 1) {
            return $query->row_array();
        }

        return array();
    }

    public function get_organization_hierarchy_level_element_by_name($organization_id, $organization_hierarchy_level_id, $organization_hierarchy_level_element_name) {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with organization_id = $organization_id | organization_hierarchy_level_id = $organization_hierarchy_level_id | organization_hierarchy_level_element_name = $organization_hierarchy_level_element_name");

        $query = $this->db
            ->select('mohle.*')
            ->from('master_organization_hierarchy_level_elements AS mohle')
            ->join('master_organization_hierarchy_levels AS mohl', 'mohl.id = mohle.organization_hierarchy_level_id')
            ->where(array(
                    'mohle.name'           => $organization_hierarchy_level_element_name,
                    'mohle.active'         => 1,
                    'mohl.organization_id' => $organization_id,
                    'mohl.id'              => $organization_hierarchy_level_id,
                    'mohl.active'          => 1
                ))
            ->limit(1)
            ->get();

        if($query->num_rows() == 1) {
            return $query->row_array();
        }

        return array();
    }

    public function get_organization_hierarchy_level_element_by_third_party_id($organization_id, $organization_hierarchy_level_id, $organization_hierarchy_level_element_third_party_id) {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with organization_id = $organization_id | organization_hierarchy_level_id = $organization_hierarchy_level_id | organization_hierarchy_level_element_third_party_id = $organization_hierarchy_level_element_third_party_id");

        $query = $this->db
            ->select('mohle.*')
            ->from('master_organization_hierarchy_level_elements AS mohle')
            ->join('master_organization_hierarchy_levels AS mohl', 'mohl.id = mohle.organization_hierarchy_level_id')
            ->where(array(
                    'mohle.third_party_id' => $organization_hierarchy_level_element_third_party_id,
                    'mohle.active'         => 1,
                    'mohl.organization_id' => $organization_id,
                    'mohl.id'              => $organization_hierarchy_level_id,
                    'mohl.active'          => 1
                ))
            ->limit(1)
            ->get();

        if($query->num_rows() == 1) {
            return $query->row_array();
        }

        return array();
    }

    public function insert_organization_hierarchy_level_element($organization_hierarchy_level_id, $organization_hierarchy_level_element_parent_id, $organization_hierarchy_level_element_third_party_id, $organization_hierarchy_level_element_name) {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with organization_hierarchy_level_id = $organization_hierarchy_level_id | organization_hierarchy_level_element_parent_id = $organization_hierarchy_level_element_parent_id | organization_hierarchy_level_element_third_party_id = $organization_hierarchy_level_element_third_party_id | organization_hierarchy_level_element_name = $organization_hierarchy_level_element_name");

        $this->db->insert('master_organization_hierarchy_level_elements', array(
            'organization_hierarchy_level_id' => $organization_hierarchy_level_id,
            'third_party_id'                  => $organization_hierarchy_level_element_third_party_id,
            'name'                            => $organization_hierarchy_level_element_name,
            'active'                          => 1
        ));

        $organization_hierarchy_level_element_id = $this->db->insert_id();

        $this->db->insert('master_organization_hierarchy_level_element_relationship_map', array(
            'organization_hierarchy_level_element_parent_id' => $organization_hierarchy_level_element_parent_id,
            'organization_hierarchy_level_element_id'        => $organization_hierarchy_level_element_id,
            'active'                                         => 1
        ));

        return $organization_hierarchy_level_element_id;
    }

    public function get_required_organization_hierarchy_levels($organization_id, $user_type_id) {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with organization_id = $organization_id | user_type_id = $user_type_id");

        $organization_id = $this->db->escape_str($organization_id);
        $user_type_id = $this->db->escape_str($user_type_id);

        $query = $this->db
            ->select('mohl.id, mohl.name, mohl.name, mohl.plural_name, mohl.multi_sibling_membership_allowed')
            ->from('master_user_type_organization_hierarchy_level_map AS mutohlm')
            ->join('master_organization_hierarchy_levels AS mohl', 'mohl.id = mutohlm.organization_hierarchy_level_id')
            ->where(array(
                    'mutohlm.user_type_id' => $user_type_id,
                    'mutohlm.active'       => 1,
                    'mutohlm.required'     => 1,
                    'mohl.organization_id' => $organization_id,
                    'mohl.active'          => 1
                ))
            ->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }

        return array();
    }

    public function get_user_type_organization_hierarchy_level_map() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Called');

        $query = $this->db
            ->select('user_type_id, organization_hierarchy_level_id, display, required')
            ->from('master_user_type_organization_hierarchy_level_map')
            ->where(array(
                    'active' => 1
                ))
            ->get();

        if($query->num_rows() > 0) {
            $temp = $query->result_array();
            $data = array();

            foreach($temp as $row) {
                $data[$row['user_type_id']][$row['organization_hierarchy_level_id']] = array(
                    'display'       => $row['display'],
                    'required'  => $row['required']
                );
            }

            return $data;
        }

        return array();
    }

    public function get_users_organization_hierarchy_level_element_map_entries($user_id = NULL, $active = TRUE) {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | active = $active");

        $where = array(
            'muohlem.active' => ($active) ? 1 : 0,
            'mohle.active' => 1,
            'mohl.active' => 1
        );

        $flatten_return_array = FALSE;

        if(!empty($user_id) || is_numeric($user_id)) {
            $where['muohlem.user_id'] = $user_id;
            $flatten_return_array = TRUE;
        }

        $query = $this->db
            ->select('muohlem.user_id, mohl.id as organization_hierarchy_level_id, mohl.multi_sibling_membership_allowed, mohle.id as organization_hierarchy_level_element_id')
            ->from('master_users_organization_hierarchy_level_element_map AS muohlem')
            ->join('master_organization_hierarchy_level_elements AS mohle', 'mohle.id = muohlem.organization_hierarchy_level_element_id')
            ->join('master_organization_hierarchy_levels as mohl', 'mohl.id = mohle.organization_hierarchy_level_id')
            ->where($where)
            ->get();

        if($query->num_rows() > 0) {
            $temp = $query->result_array();
            $data = array();

            if($flatten_return_array) {
                foreach($temp as $row) {
                        $data[] = $row['organization_hierarchy_level_element_id'];
                }
            } else {
                foreach($temp as $row) {
                    if($row['multi_sibling_membership_allowed']) {
                        $data[$row['user_id']][$row['organization_hierarchy_level_id']][] = $row['organization_hierarchy_level_element_id'];
                    } else {
                        $data[$row['user_id']][$row['organization_hierarchy_level_id']] = $row['organization_hierarchy_level_element_id'];
                    }
                }
            }

            return $data;
        }

        return array();
    }

    public function activate_users_organization_hierarchy_level_element_map_entries($user_id, $element_ids = array()) {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

        if(empty($user_id) || !is_numeric($user_id)) {
            return FALSE;
        }

        if(empty($element_ids) || !is_array($element_ids)) {
            return FALSE;
        }

        $data = array();

        foreach($element_ids as $element_id) {
            if(!is_numeric($element_id)) {
                return FALSE;
            }
        }

        $this->db
            ->where('user_id', $user_id)
            ->where_in('organization_hierarchy_level_element_id', $element_ids)
            ->update('master_users_organization_hierarchy_level_element_map', array('active' => 1));

        return $this->db->affected_rows();
    }

    public function deactivate_users_organization_hierarchy_level_element_map_entries($user_id, $element_ids = array()) {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

        if(empty($user_id) || !is_numeric($user_id)) {
            return FALSE;
        }

        if(empty($element_ids) || !is_array($element_ids)) {
            return FALSE;
        }

        $data = array();

        foreach($element_ids as $element_id) {
            if(!is_numeric($element_id)) {
                return FALSE;
            }
        }

        $this->db
            ->where('user_id', $user_id)
            ->where_in('organization_hierarchy_level_element_id', $element_ids)
            ->update('master_users_organization_hierarchy_level_element_map', array('active' => 0));

        return $this->db->affected_rows();
    }

    public function insert_users_organization_hierarchy_level_element_map_entries($user_id, $element_ids = array()) {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

        if(empty($user_id) || !is_numeric($user_id)) {
            return FALSE;
        }

        if(empty($element_ids) || !is_array($element_ids)) {
            return FALSE;
        }

        $data = array();

        foreach($element_ids as $element_id) {
            if(!is_numeric($element_id)) {
                return FALSE;
            }

            $data[] = array(
                'user_id'=> $user_id,
                'organization_hierarchy_level_element_id' => $element_id
            );
        }

        $this->db->insert_batch('master_users_organization_hierarchy_level_element_map', $data);

        return TRUE;
    }

    public function update_users_organization_hierarchy_level_element_map_entries($user_id, $element_ids = array()) {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

        if(empty($user_id) || !is_numeric($user_id)) {
            return FALSE;
        }

        if(empty($element_ids) || !is_array($element_ids)) {
            return FALSE;
        }

        foreach($element_ids as $element_id) {
            if(!is_numeric($element_id)) {
                return FALSE;
            }
        }

        $current_active_element_ids = $this->get_users_organization_hierarchy_level_element_map_entries($user_id);
        $current_inactive_element_ids = $this->get_users_organization_hierarchy_level_element_map_entries($user_id, FALSE);
        $element_ids_to_activate = array_intersect($element_ids, $current_inactive_element_ids);
        $element_ids_to_insert = array_diff($element_ids, array_merge($current_active_element_ids, $current_inactive_element_ids));
        $element_ids_to_deactivate = array_diff($current_active_element_ids, $element_ids);

        $this->activate_users_organization_hierarchy_level_element_map_entries($user_id, $element_ids_to_activate);
        $this->insert_users_organization_hierarchy_level_element_map_entries($user_id, $element_ids_to_insert);
        $this->deactivate_users_organization_hierarchy_level_element_map_entries($user_id, $element_ids_to_deactivate);

        return TRUE;
    }

}

/* End of file organization_hierarchy_model.php */
/* Location: ./application/models/organization_hierarchy_model.php */

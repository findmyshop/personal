<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
    private  $account_id = FALSE;
    private $user_type = FALSE;
    const USER_TYPE_ADMIN = 1;
    const MAILING_ADDRESS_TYPE_ID = 1;
    const USER_ID_NUMBER_TYPE_DOD = 1;

    public function __construct()
    {
        parent::__construct();
        $this->account_id = $this->session->userdata('account_id');
        $this->user_type = $this->session->userdata('user_type');

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function deactivate_other_user_map_entries($user_id, $organization_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | organization_id = $organization_id");

        $this->db
            ->where("(user_id=$user_id) AND (organization_id!=$organization_id)")
            ->update('master_users_map', array('active' => 0));
    }

    public function deactivate_user($user_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

        $map_query = $this->db->where('user_id', $user_id)->update('master_users_map', array('active' => 0));
        $users_query = $this->db->where('id', $user_id)->update('master_users', array('active' => 0));

        if ($this->db->affected_rows() <= 0)
        {
            log_message('error', 'DEV-ERROR: Failed to deactivate user: '.$user_id);
            return FALSE;
        }
        return TRUE;
    }

    public function deactivate_user_password_reset($user_id, $hash)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | hash = $hash");

        $where = array(
            'user_id'   => $user_id,
            'hash'      => $hash,
            'active'    => 1
        );

        $query = $this->db->where($where)->update('master_user_password_reset', array('active' => 0));

        $data['id'] = $this->db->insert_id();

        return $data;
    }

    public function generate_username($first_name, $middle_initial, $last_name)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with first_name = $first_name | middle_initial = $middle_initial | last_name = $last_name");

        $username_base = $this->db->escape_str(strtolower($first_name) . (!empty($middle_initial) ? ('.' . strtolower($middle_initial)) : '') . '.'. strtolower($last_name));
        $row = $this->get_user_by_username($username_base);

        if (empty($row))
        {
            return $username_base;
        }

        $cnt = 1;

        while (1)
        {
            $username = ($username_base . '.' . $cnt++);

            $row = $this->get_user_by_username($username);

            if (empty($row))
            {
                return $username;
            }
        }
    }

    public function get_email_by_user_id($id = NULL)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $id");

        $return = '';

        if(is_numeric($id))
        {
            $query = $this->db->select('id')->where('id', $id)->get('master_users', 1);

            if($query->num_rows() > 0)
            {
                $query = $query->row_array();
                $return = $query['email'];
            }
        }

        return $return;
    }

    public function get_last_user_state($user_id, $organization_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | organization_id = $organization_id");

        $query = $this->db
            ->select('last_response, last_left_rail')
            ->where(array('user_id' => $user_id, 'organization_id' => $organization_id))
            ->limit(1)
            ->get('master_users_map');

        if ($query->num_rows() != 1)
        {
            return FALSE;
        }

        return $query->row_array();
    }


    public function get_video_settings($user_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

        $query = $this->db
            ->select('video_player, video_bit_rate, show_asl_videos')
            ->from('master_users_map')
            ->where('user_id', $user_id)
            ->limit(1)
            ->get();

        if($query->num_rows() == 1) {
            return $query->row_array();
        }

        return array(
            'video_player'      => 'default',
            'video_bit_rate'    => '512k',
            'show_asl_videos'   => '0'
        );
    }

    public function get_name($id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $id");

        $query = $this->db->where(array('id' => $id))->get('master_users', 1);

        if($query->num_rows() > 0)
        {
            $row = $query->row_array();

            return ($row['first_name'] . ' ' . $row['last_name']);
        }
        else
        {
            return '';
        }
    }

    public function get_pay_grade($id, $active = FALSE)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with pay_grade_id = $id");

        $where = array('id' => $id);

        if (!empty($active))
        {
            $where['active'] = $active;
        }

        $query = $this->db->where($where)->get('master_pay_grades');

        if ($query->num_rows() < 1)
        {
            return FALSE;
        }

        return $query->row_array();
    }

    public function get_pay_grades($pay_grade_type_id = FALSE, $active = FALSE)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with pay_grade_type_id = $pay_grade_type_id");

        $where = array();

        if ($pay_grade_type_id !== FALSE)
        {
            $where['pay_grade_type_id'] = $pay_grade_type_id;
        }

        if ($active !== FALSE)
        {
            $where['active'] = $active;
        }

        if (!empty($where))
        {
            $this->db->where($where);
        }

        $query = $this->db->get('master_pay_grades');

        if ($query->num_rows() < 1)
        {
            return array();
        }

        return $query->result_array();

    }

    public function get_role($id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with role_id = $id");

        $query = $this->db->where(array('id' => $id))->get('master_roles');

        if($query->num_rows() < 1)
        {
            return array();
        }
        else
        {
            return $query->result_array();
        }
    }

    public function get_roles()
    {
        log_info(__FILE__, __LINE__, __METHOD__, 'Called');

        $query = $this->db->where(array('organization_id' => PROPERTY_ORGANIZATION_ID,'active' => 1))->order_by('role_name')->get('master_roles');

        if($query->num_rows() < 1)
        {
            return array();
        }
        else
        {
            return $query->result_array();
        }
    }

    public function get_training_user($user_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

        if(!is_numeric($user_id))
        {
            return FALSE;
        }

        $stmt = "
        SELECT      master_users.id AS id,
                    master_users.first_name AS first_name,
                    master_users.middle_initial AS middle_initial,
                    master_users.last_name AS last_name,
                    master_users.username AS username,
                    master_users.user_type_id AS user_type_id,
                    master_users.email AS email_address,
                    '' AS password,
                    '' AS confirm_password,
                    master_users.login_enabled AS login_enabled,
                    IF(master_user_accreditation_map.accreditation_type_id IS NULL, -1, master_user_accreditation_map.accreditation_type_id) AS accreditation_type_id,
                    IF(master_user_role_map.role_id IS NULL, -1, master_user_role_map.role_id) AS role_id,
                    master_addresses.address_1 AS address_1,
                    master_addresses.address_2 AS address_2,
                    master_addresses.city AS city,
                    IF (master_addresses.province IS NULL, '', master_addresses.province) AS province,
                    IF (master_addresses.state_id IS NULL, -1, master_addresses.state_id) AS state_id,
                    master_addresses.zip AS zip,
                    IF (master_addresses.country_id IS NULL, -1, master_addresses.country_id) AS country_id
        FROM        master_users
        LEFT JOIN master_user_accreditation_map
                    ON master_user_accreditation_map.user_id=master_users.id
                    AND master_user_accreditation_map.active=1
        LEFT JOIN master_user_role_map
                    ON master_user_role_map.user_id=master_users.id
                    AND master_user_role_map.active=1
        LEFT JOIN master_user_address_map
                    ON master_user_address_map.user_id=master_users.id
                    AND master_user_address_map.address_type_id=1
                    AND master_user_address_map.active=1
        LEFT JOIN master_addresses
                    ON master_addresses.id=master_user_address_map.address_id
                    AND master_addresses.active=1
        WHERE       master_users.id='$user_id'
        GROUP BY    master_users.id
        ";

        $query = $this->db->query($stmt);

        if($query->num_rows() > 0)
        {
            return $query->row_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_sbirt_user($user_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

        if(!is_numeric($user_id))
        {
            return FALSE;
        }

        $stmt = "
        SELECT      master_users.id AS id,
                    master_users.first_name AS first_name,
                    master_users.middle_initial AS middle_initial,
                    master_users.last_name AS last_name,
                    master_users.username AS username,
                    master_users.user_type_id AS user_type_id,
                    master_users.email AS email_address,
                    '' AS password,
                    '' AS confirm_password,
                    master_users.login_enabled AS login_enabled,
                    master_user_department_map.department_id AS department_id,
                    IF (master_user_pay_grade_map.pay_grade_id IS NULL, -1, master_user_pay_grade_map.pay_grade_id) AS pay_grade_id,
                    master_user_numbers.user_number AS dod_number,
                    IF(master_user_accreditation_map.accreditation_type_id IS NULL, -1, master_user_accreditation_map.accreditation_type_id) AS accreditation_type_id,
                    IF(master_user_role_map.role_id IS NULL, -1, master_user_role_map.role_id) AS role_id,
                    IF (master_user_treatment_facility_map.treatment_facility_id IS NULL, -1, master_user_treatment_facility_map.treatment_facility_id) AS treatment_facility_id,
                    master_addresses.address_1 AS address_1,
                    master_addresses.address_2 AS address_2,
                    master_addresses.city AS city,
                    IF (master_addresses.province IS NULL, '', master_addresses.province) AS province,
                    IF (master_addresses.state_id IS NULL, -1, master_addresses.state_id) AS state_id,
                    master_addresses.zip AS zip,
                    IF (master_addresses.country_id IS NULL, -1, master_addresses.country_id) AS country_id
        FROM        master_users
        JOIN        master_user_department_map
                    ON master_user_department_map.user_id=master_users.id
                    AND
                    master_user_department_map.active=1
        LEFT JOIN master_user_numbers
                    ON master_user_numbers.user_id=master_users.id
                    AND master_user_numbers.user_number_type_id=1
                    AND master_user_numbers.active=1
        LEFT JOIN master_user_pay_grade_map
                    ON master_user_pay_grade_map.user_id=master_users.id
                    AND master_user_pay_grade_map.active
        LEFT JOIN master_user_accreditation_map
                    ON master_user_accreditation_map.user_id=master_users.id
                    AND master_user_accreditation_map.active=1
        LEFT JOIN master_user_role_map
                    ON master_user_role_map.user_id=master_users.id
                    AND master_user_role_map.active=1
        LEFT JOIN master_user_treatment_facility_map
                    ON master_user_treatment_facility_map.user_id=master_users.id
                    AND master_user_treatment_facility_map.active=1
        LEFT JOIN master_user_address_map
                    ON master_user_address_map.user_id=master_users.id
                    AND master_user_address_map.address_type_id=1
                    AND master_user_address_map.active=1
        LEFT JOIN master_addresses
                    ON master_addresses.id=master_user_address_map.address_id
                    AND master_addresses.active=1
        WHERE       master_users.id='$user_id'
        GROUP BY    master_users.id
        ";

        $query = $this->db->query($stmt);

        if($query->num_rows() > 0)
        {
            return $query->row_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_training_users($requester_user_type = 'admin', $organization_id, $search = FALSE, $limit = NULL, $offset = NULL, $return_csv_file_contents = FALSE)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with requester_user_type = $requester_user_type | organization_id = $organization_id");

        $requester_user_type = $this->db->escape_str($requester_user_type);
        $organization_id = $this->db->escape_str($organization_id);

        if ($requester_user_type == 'admin')
        {
            $where_user_type = "";
        }
        elseif($requester_user_type == 'site_admin')
        {
            $where_user_type = "\n\t\t\t\t\t\t\t\tAND master_user_types.type_name!='admin'\n";
        }
        elseif($requester_user_type == 'instructor')
        {
            $where_user_type = "\n\t\t\t\t\t\t\t\tAND master_user_types.type_name!='admin' AND master_user_types.type_name!='site_admin'\n";
        }
        else
        {
            $where_user_type = "\n\t\t\t\t\t\t\t\tAND master_user_types.type_name!='admin' AND master_user_types.type_name!='site_admin' AND master_user_types.type_name!='instructor'\n";
        }

        if ($search)
        {
            $search = $this->db->escape_str($search);
            $where_search = "\n\t\t\t\t\t\t\t\tAND (master_users.first_name LIKE '%" . $search . "%' OR master_users.last_name LIKE '%" . $search . "%' OR master_users.username LIKE '%" . $search . "%')";
        }
        else
        {
            $where_search = "";
        }

        if($limit !== NULL && is_numeric($limit))
        {
            $limit_clause = " LIMIT $limit";
        }
        else
        {
            $limit_clause = "";
        }

        if($offset !== NULL && is_numeric($offset))
        {
            $offset_clause = " OFFSET $offset";
        }
        else
        {
            $offset_clause = "";
        }

        $stmt = "
        SELECT      master_users.id AS id,
                    master_users.first_name AS first_name,
                    master_users.middle_initial AS middle_inbitial,
                    master_users.last_name AS last_name,
                    master_users.username AS username,
                    master_users.email AS email,
                    master_user_types.id AS user_type_id,
                    master_user_types.type_name AS user_type_name,
                    master_users.login_enabled AS login_enabled,
                    master_organizations.name AS organization_name
        FROM        master_users
        JOIN        master_user_types
                    ON master_user_types.id=master_users.user_type_id
                    AND master_user_types.active=1
                    $where_user_type
        LEFT JOIN master_users_map
                    ON master_users_map.user_id=master_users.id
                    AND master_users_map.active=1
        JOIN        master_organizations
                    ON master_organizations.id=master_users_map.organization_id
                    AND master_organizations.active=1
                    AND master_organizations.id='$organization_id'
        WHERE       master_users.active=1
                    $where_search
        ORDER BY    master_organizations.name ASC, username ASC
        $limit_clause
        $offset_clause
        ";

        $query = $this->db->query($stmt);

        if($return_csv_file_contents)
        {
            return $this->dbutil->csv_from_result($query, ',', "\r\n");
        }
        else
        {
            if($query->num_rows() >= 1)
            {
                return $query->result_array();
            }
            else
            {
                return array();
            }
        }
    }

    public function get_sbirt_users($requester_user_type = 'admin', $organization_id, $search = FALSE, $limit = NULL, $offset = NULL, $return_csv_file_contents = FALSE)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with requester_user_type = $requester_user_type | organization_id = $organization_id");

        $requester_user_type = $this->db->escape_str($requester_user_type);
        $organization_id = $this->db->escape_str($organization_id);

        if ($requester_user_type == 'admin')
        {
            $where_user_type = "";
        }
        elseif($requester_user_type == 'site_admin')
        {
            $where_user_type = "\n\t\t\t\t\t\t\t\tAND master_user_types.type_name!='admin'\n";
        }
        elseif($requester_user_type == 'instructor')
        {
            $where_user_type = "\n\t\t\t\t\t\t\t\tAND master_user_types.type_name!='admin' AND master_user_types.type_name!='site_admin'\n";
        }
        else
        {
            $where_user_type = "\n\t\t\t\t\t\t\t\tAND master_user_types.type_name!='admin' AND master_user_types.type_name!='site_admin' AND master_user_types.type_name!='instructor'\n";
        }

        if ($search)
        {
            $search = $this->db->escape_str($search);
            $where_search = "\n\t\t\t\t\t\t\t\tAND (master_users.first_name LIKE '%" . $search . "%' OR master_users.last_name LIKE '%" . $search . "%' OR master_users.username LIKE '%" . $search . "%' OR master_departments.department_name LIKE '%" . $search . "%')";
        }
        else
        {
            $where_search = "";
        }

        if($limit !== NULL && is_numeric($limit))
        {
            $limit_clause = " LIMIT $limit";
        }
        else
        {
            $limit_clause = "";
        }

        if($offset !== NULL && is_numeric($offset))
        {
            $offset_clause = " OFFSET $offset";
        }
        else
        {
            $offset_clause = "";
        }

        $stmt = "
        SELECT      master_users.id AS id,
                    master_users.first_name AS first_name,
                    master_users.middle_initial AS middle_inbitial,
                    master_users.last_name AS last_name,
                    master_users.username AS username,
                    master_users.email AS email,
                    master_user_types.id AS user_type_id,
                    master_user_types.type_name AS user_type_name,
                    master_users.login_enabled AS login_enabled,
                    master_organizations.name AS organization_name,
                    master_departments.id AS department_id,
                    master_departments.department_name AS department_name
        FROM        master_users
        JOIN        master_user_types
                    ON master_user_types.id=master_users.user_type_id
                    AND master_user_types.active=1
                    $where_user_type
        LEFT JOIN master_users_map
                    ON master_users_map.user_id=master_users.id
                    AND master_users_map.active=1
        JOIN        master_organizations
                    ON master_organizations.id=master_users_map.organization_id
                    AND master_organizations.active=1
                    AND master_organizations.id='$organization_id'
        JOIN        master_user_department_map
                    ON master_user_department_map.user_id=master_users.id
                    AND master_user_department_map.active=1
        JOIN        master_departments
                    ON master_departments.id=master_user_department_map.department_id
        WHERE       master_users.active=1
                    $where_search
        ORDER BY    master_organizations.name ASC, department_name ASC, username ASC
        $limit_clause
        $offset_clause
        ";

        $query = $this->db->query($stmt);

        if($return_csv_file_contents)
        {
            return $this->dbutil->csv_from_result($query, ',', "\r\n");
        }
        else
        {
            if($query->num_rows() >= 1)
            {
                return $query->result_array();
            }
            else
            {
                return array();
            }
        }
    }

    public function get_sbirt_user_types($requester_user_type = 'admin', $active = FALSE)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called requester_user_type = $requester_user_type");

        if($requester_user_type == 'admin')
        {
            // show all types;
        }
        elseif($requester_user_type == 'site_admin')
        {
            $this->db->where_not_in('type_name', array('admin'));
        }
        elseif($requester_user_type == 'instructor')
        {
            $this->db->where_not_in('type_name', array('admin', 'site_admin'));
        }
        else
        {
            $this->db->where_not_in('type_name', array('admin', 'site_admin', 'instructor'));
        }

        if($active !== FALSE)
        {
            $this->db->where(array('active' => $active));
        }

        $query = $this->db->get('master_user_types');

        if ($query->num_rows() < 1)
        {
            return array();
        }

        return $query->result_array();
    }

    public function get_treatment_facilities()
    {
        log_info(__FILE__, __LINE__, __METHOD__, 'Called');

        $stmt = "
        SELECT      master_treatment_facilities.id AS id,
                    master_departments.department_name AS department_name,
                    CASE master_departments.id
                    WHEN 2 THEN CONCAT(master_treatment_facilities.base, ' -' , master_treatment_facilities.clinic)
                    WHEN 3 THEN CONCAT(master_treatment_facilities.region, ' - ', master_treatment_facilities.parent_command, ' - ', master_treatment_facilities.enrollment_site)
                    WHEN 4 THEN CONCAT(IF(master_states.abbreviation IS NULL, CONCAT(master_countries.iso3, ' - '), CONCAT(master_states.abbreviation, ' - ')), master_treatment_facilities.base)
                    WHEN 5 THEN master_treatment_facilities.clinic
                    ELSE NULL END as 'treatment_facility'
        FROM        master_treatment_facilities
        JOIN        master_departments
                    ON master_departments.id=master_treatment_facilities.department_id
                    AND
                    master_departments.active=1
        LEFT JOIN master_states
                    ON master_states.id=master_treatment_facilities.state_id
                    AND master_states.active=1
        LEFT JOIN master_countries
                    ON master_countries.country_id=master_treatment_facilities.country_id
        WHERE       master_treatment_facilities.active=1
        ORDER BY    master_departments.department_name ASC, treatment_facility
        ";

        $query = $this->db->query($stmt);

        if($query->num_rows() < 1)
        {
            return array();
        }
        else
        {
            return $query->result_array();
        }
    }

    public function get_user($id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $id");

        $query = $this->db->where(array('id' => $id))->get('master_users', 1);

        if($query->num_rows() > 0)
        {
            return $query->row_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_user_account($user_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

        $where = array(
            'id'            => $user_id,
            'login_enabled' => 1,
            'active'        => 1
        );

        $query = $this->db->where($where)->get('master_users');

        if($query->num_rows() < 1)
        {
            return FALSE;
        }
        else
        {
            return $query->row_array();
        }
    }

    public function get_accreditation_type_name($accreditation_type_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with accreditation_type_id = $accreditation_type_id");

        $query = $this->db
            ->select('accreditation_type')
            ->from('master_accreditation_types')
            ->where('id', $accreditation_type_id)
            ->limit(1)
            ->get();

        if($query->num_rows() == 1)
        {
            $row = $query->row_array();
            return $row['accreditation_type'];
        }

        return NULL;
    }

    public function get_user_accreditation_type_id($user_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

        $where = array(
            'user_id'   => $user_id,
            'active'    => 1
        );

        $query = $this->db
            ->select('accreditation_type_id')
            ->from('master_user_accreditation_map')
            ->where($where)
            ->limit(1)
            ->get();

        if($query->num_rows() > 0)
        {
            $data = $query->row_array();
            return $data['accreditation_type_id'];
        }

        return 0;
    }

    public function get_user_accreditation($user_id, $accreditation_type_id, $active = FALSE)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | accreditation_type_id = $accreditation_type_id");

        $where = array(
                'user_id'                               => $user_id,
                'accreditation_type_id' => $accreditation_type_id
        );

        if ($active !== FALSE)
        {
            $where['active'] = $active;
        }

        $query = $this->db->where($where)->get('master_user_accreditation_map');

        if ($query->num_rows() < 1)
        {
            return FALSE;
        }

        return $query->row_array();
    }

    public function get_user_address_map($user_id, $address_type_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | address_type_id = $address_type_id");

        $where = array(
            'user_id'                   => $user_id,
            'address_type_id'   => $address_type_id
        );

        $query = $this->db->where($where)->get('master_user_address_map');

        if($query->num_rows() > 0)
        {
            return $query->row_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_user_combined($id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $id");

        $id = $this->db->escape_str($id);

        $stmt = "
            SELECT      master_users.id AS id,
                        master_users.user_type_id AS user_type_id,
                        master_user_types.type_name AS type_name,
                        master_organizations.id AS organization_id,
                        master_organizations.name AS organization_name,
                        master_users.first_name AS first_name,
                        master_users.last_name AS last_name,
                        CONCAT(master_users.first_name, ' ', master_users.last_name) AS full_name,
                        master_users.username AS username,
                        master_users.email AS email,
                        master_users.login_enabled AS login_enabled
            FROM        master_users
            JOIN        master_user_types
                        ON master_user_types.id=master_users.user_type_id
                        AND master_user_types.active=1
            JOIN        master_users_map
                        ON master_users_map.user_id=master_users.id
                        AND master_users_map.active=1
            JOIN        master_organizations
                        ON master_organizations.id=master_users_map.organization_id
                        AND master_organizations.active=1
            WHERE        master_users.active=1
                        AND master_users.id='$id'
        ";

        $query = $this->db->query($stmt);

        if($query->num_rows() < 1)
        {
            return FALSE;
        }
        else
        {
            return $query->row_array();
        }
    }

    public function get_user_role($user_id, $role_id, $active = FALSE)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | role_id = $role_id");

        $where = array(
                'user_id' => $user_id,
                'role_id' => $role_id
        );

        if ($active !== FALSE)
        {
            $where['active'] = $active;
        }

        $query = $this->db->where($where)->get('master_user_role_map');

        if ($query->num_rows() < 1)
        {
            return FALSE;
        }

        return $query->row_array();
    }

    public function get_user_by_email($email = NULL)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with email = $email");

        if(!empty($email))
        {
            $email = $this->db->escape_str($email);
            $query = $this->db->where(array('email' => $email))->get('master_users', 1);

            if($query->num_rows() > 0)
            {
                return $query->row_array();
            }
        }

        return array();
    }

    public function get_user_by_username($username)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with username = $username");

        $username = $this->db->escape_str(trim($username));
        $query = $this->db->where(array('username' => $username))->get('master_users', 1);

        if($query->num_rows() > 0)
        {
            return $query->row_array();
        }

        return array();
    }

    public function get_user_department($user_id, $department_id, $active = FALSE)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | department_id = $department_id");

        $where = array(
                'user_id'               => $user_id,
                'department_id' => $department_id
        );

        if ($active !== FALSE)
        {
            $where['active'] = $active;
        }

        $query = $this->db->where($where)->get('master_user_department_map');

        if($query->num_rows() < 1)
        {
            return FALSE;
        }
        else
        {
            return $query->row_array();
        }
    }

    public function get_user_given_login_credentials($username, $password)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with username = $username");

        $username = $this->db->escape_str(trim($username));
        $password = $this->db->escape_str(trim($password));
        $hash = md5($password);

        $stmt="
            SELECT      u.*
            FROM
            (           SELECT      master_users.*
                        FROM        master_users
                        JOIN        master_users_map
                                    ON master_users_map.user_id=master_users.id
                                    AND (
                                        master_users_map.organization_id=" . PROPERTY_ORGANIZATION_ID . "
                                        OR master_users_map.organization_id=" . MR_ORGANIZATION_ID . "
                                    )

                        WHERE       master_users.username='$username'
                                    AND
                                    master_users.password='$hash'
                        UNION
                        SELECT      master_users.*
                        FROM        master_users
                        WHERE       master_users.username='$username'
                                    AND
                                    master_users.password='$hash'
                                    AND
                                    master_users.user_type_id=" . self::USER_TYPE_ADMIN. "
            ) AS u
        ";

        $query = $this->db->query($stmt);

        if ($query->num_rows() != 1)
        {
            return FALSE;
        }

        $user = $query->row_array();

        // automatically create a users_map entry for admins
        if (($user['user_type_id'] == self::USER_TYPE_ADMIN) && !$this->get_user_map($user['id'], PROPERTY_ORGANIZATION_ID))
        {
            $this->insert_user_map($user['id'], PROPERTY_ORGANIZATION_ID);
        }

        return $user;
    }

    public function get_user_map($user_id, $organization_id, $active = FALSE)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | organization_id = $organization_id");

        $user_id = $this->db->escape_str($user_id);
        $organization_id = $this->db->escape_str($organization_id);
        $where_active = ' AND active=1';

        if($active !== FALSE && is_numeric($active))
        {
            $where_active = " AND active='$active'";
        }

        $stmt = "
            SELECT      *
            FROM        master_users_map
            WHERE        user_id=$user_id
                        AND
                        organization_id=$organization_id
                        $where_active
        ";

        $query = $this->db->query($stmt);

        if ($query->num_rows() < 1)
        {
            return FALSE;
        }

        return $query->row_array();
    }

    public function get_user_number($user_id, $user_number_type_id, $active = FALSE)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | user_number_type_id = $user_number_type_id");

        $where = array(
                'user_id'                           => $user_id,
                'user_number_type_id'   => $user_number_type_id
        );

        if($active !== FALSE)
        {
            $where['active'] = $active;
        }

        $query = $this->db->where($where)->get('master_user_numbers');

        if ($query->num_rows() < 1)
        {
            return FALSE;
        }

        return $query->row_array();
    }

    public function get_user_organization($id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $id");

        $query = $this->db->where(array('id' => $id))->get('master_users', 1);

        if($query->num_rows() > 0)
        {
            $row =  $query->row_array();
        }
        else
        {
            return FALSE;
        }
    }

    public function get_user_password_reset_by_user_id($user_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

        $where = array('user_id' => $user_id, 'active' => 1);
        $query = $this->db->where($where)->get('master_user_password_reset');

        if ($query->num_rows() < 1)
        {
            return array();
        }

        return $query->row_array();
    }

    public function get_user_password_reset_by_hash($hash)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with hash = $hash");

        $hash = $this->db->escape_str($hash);
        $where = array('hash' => $hash, 'active' => 1);
        $query = $this->db->where($where)->get('master_user_password_reset');

        if ($query->num_rows() < 1)
        {
            return array();
        }

        return $query->row_array();
    }

    public function get_user_pay_grade($user_id, $pay_grade_id, $active = FALSE)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | pay_grade_id = $pay_grade_id");

        $where = array(
                'user_id'               => $user_id,
                'pay_grade_id'  => $pay_grade_id
        );

        if ($active !== FALSE)
        {
            $where['active'] = $active;
        }

        $query = $this->db->where($where)->get('master_user_pay_grade_map');

        if($query->num_rows() < 1)
        {
            return FALSE;
        }
        else
        {
            return $query->row_array();
        }
    }

    public function get_user_types($requester_user_type = 'admin', $active = FALSE)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with requester_user_type = $requester_user_type");

        if ($requester_user_type == 'admin')
        {
            // show all types;
        }
        elseif($requester_user_type == 'site_admin')
        {
            $this->db->where_not_in('type_name', array('admin'));
        }
        elseif($requester_user_type == 'instructor')
        {
            $this->db->where_not_in('type_name', array('admin', 'site_admin'));
        }
        else
        {
            $this->db->where_not_in('type_name', array('admin', 'site_admin', 'instructor'));
        }

        if($active !== FALSE)
        {
            $this->db->where(array('active' => $active));
        }

        $query = $this->db->get('master_user_types');

        if ($query->num_rows() < 1)
        {
            return array();
        }

        return $query->result_array();
    }

    public function get_user_type_id($user_type_name)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_type_name = $user_type_name");

        $query = $this->db->where(array('type_name' => $user_type_name))->limit(1)->get('master_user_types');

        if ($query->num_rows() != 1)
        {
            return '';
        }

        $row = $query->row_array();

        return $row['id'];
    }

    public function get_user_type_name($user_type_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_type_id = $user_type_id");

        $query = $this->db->where(array('id' => $user_type_id))->limit(1)->get('master_user_types');

        if ($query->num_rows() != 1)
        {
            return '';
        }

        $row = $query->row_array();

        return $row['type_name'];
    }

    public function get_user_treatment_facility($user_id, $treatment_facility_id, $active = FALSE)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | treatment_facility_id = $treatment_facility_id");

        $where = array(
                'user_id'                               => $user_id,
                'treatment_facility_id' => $treatment_facility_id
        );

        if ($active !== FALSE)
        {
            $where['active'] = $active;
        }

        $query = $this->db->where($where)->get('master_user_treatment_facility_map');

        if($query->num_rows() < 1)
        {
            return FALSE;
        }
        else
        {
            return $query->row_array();
        }
    }

    public function get_users($requester_user_type = 'admin', $organization_id = FALSE, $search = FALSE, $organization_hierarchy_level_elements_filter = array())
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with requester_user_type = $requester_user_type | organization_id = $organization_id | search = $search");

        $requester_user_type = $this->db->escape_str($requester_user_type);
        $organization_id = $this->db->escape_str($organization_id);

        if ($requester_user_type == 'admin')
        {
            $where_user_type = "";
        }
        elseif($requester_user_type == 'site_admin')
        {
            $where_user_type = "\n\t\t\t\t\t\t\t\tAND master_user_types.type_name!='admin'\n";
        }
        elseif($requester_user_type == 'instructor')
        {
            $where_user_type = "\n\t\t\t\t\t\t\t\tAND master_user_types.type_name!='admin' AND master_user_types.type_name!='site_admin'\n";
        }
        else
        {
            $where_user_type = "\n\t\t\t\t\t\t\t\tAND master_user_types.type_name!='admin' AND master_user_types.type_name!='site_admin' AND master_user_types.type_name!='instructor'\n";
        }

        if ($search)
        {
            $where_search = "\n\t\t\t\t\t\t\t\tAND (master_users.first_name LIKE '%" . $search . "%' OR master_users.last_name LIKE '%" . $search . "%' OR master_users.username LIKE '%" . $search . "%')";
        }
        else
        {
            $where_search = "";
        }

        if (is_admin() && !empty($organization_id) && ($organization_id == 1))
        {
            $where_organization = "";
        }
        elseif (!empty($organization_id))
        {
            $where_organization = "\n\t\t\t\t\t\t\t\tAND master_organizations.id='$organization_id'\n";
        }
        else
        {
            $where_organization = "";
        }

        $where_organization_hierarchy = 'AND 1 = 1';

        if(!empty($organization_hierarchy_level_elements_filter)) {
            foreach($organization_hierarchy_level_elements_filter as $element_id) {
                if(is_numeric($element_id) && $element_id > 0) {
                    $where_organization_hierarchy .= "
                        AND EXISTS (
                            SELECT *
                            FROM master_users_organization_hierarchy_level_element_map AS muohlem
                            WHERE
                                muohlem.user_id = master_users.id
                                AND muohlem.organization_hierarchy_level_element_id = $element_id
                                AND muohlem.active = 1
                        )
                    ";
                }
            }
        }

        $stmt = "
            SELECT      master_users.id,
                        master_users.first_name as first_name,
                        master_users.last_name as last_name,
                        master_users.username as username,
                        master_users.email as email,
                        master_user_types.id as user_type_id,
                        master_user_types.type_name as user_type_name,
                        master_users.login_enabled as login_enabled,
                        master_organizations.id as organization_id,
                        master_organizations.name as organization_name
            FROM        master_users
                        JOIN    master_user_types
                                    ON
                                    master_user_types.id=master_users.user_type_id
                                    AND
                                    master_user_types.active=1
                        $where_user_type
                        LEFT JOIN    master_users_map
                                    ON
                                    master_users_map.user_id=master_users.id
                                    AND
                                    master_users_map.active=1
                        LEFT JOIN    master_organizations
                                    ON
                                    master_organizations.id=master_users_map.organization_id
                                    AND
                                    master_organizations.active=1
            WHERE        master_users.active=1
            $where_organization
            $where_search
            $where_organization_hierarchy
            ORDER BY    master_organizations.name ASC, username ASC
        ";

        $query = $this->db->query($stmt);

        if ($query->num_rows() < 1)
        {
            return array();
        }

        return $query->result_array();
    }

    public function get_usernames() {
        $query = $this->db
            ->select('id, username')
            ->from('master_users')
            ->where('active', 1)
            ->order_by('username', 'asc')
            ->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }

        return array();
    }

    public function insert_sbirt_user(
            $pay_grade_id,
            $first_name,
            $middle_initial,
            $last_name,
            $department_id,
            $user_number,
            $role_id,
            $accreditation_type_id,
            $treatment_facility_id,
            $username,
            $user_type_id,
            $email,
            $password,
            $address_1,
            $address_2,
            $city,
            $state_id,
            $province,
            $zip,
            $country_id,
            $login_enabled
    )
    {
        log_info(__FILE__, __LINE__, __METHOD__, 'Called');

        $current_time = date('Y-m-d H:i:s', now());

        $data = array(
                'first_name'            => $first_name,
                'middle_initial'    => $middle_initial,
                'last_name'             => $last_name,
                'username'              => $username,
                'user_type_id'      => $user_type_id,
                'email'                     => $email,
                'password'              => md5($password),
                'login_enabled'     => $login_enabled,
                'created_date'      => $current_time,
                'created_by'            => $this->account_id
        );

        $this->db->insert('master_users', $data);

        $user_id = $this->db->insert_id();

        $this->insert_user_map($user_id, PROPERTY_ORGANIZATION_ID);
        $this->insert_user_department($user_id, $department_id);
        if ($treatment_facility_id > 0)
        {
            $this->insert_user_treatment_facility($user_id, $treatment_facility_id);
        }

        $this->insert_user_pay_grade($user_id, $pay_grade_id);
        $this->insert_user_address(
            $user_id,
            self::MAILING_ADDRESS_TYPE_ID,
            $address_1,
            $address_2,
            $city,
            $state_id,
            $province,
            $zip,
            $country_id
        );
        $this->insert_user_role($user_id, $role_id);
        $this->insert_user_accreditation($user_id, $accreditation_type_id);
        $this->insert_user_number($user_id, self::USER_ID_NUMBER_TYPE_DOD, $user_number);
        $this->action_model->insert(Action_model::ACTION_TYPE_USER_INSERT);
        return $user_id;
    }

    public function insert_training_user(
        $first_name,
        $middle_initial,
        $last_name,
        $email,
        $address_line_1,
        $address_line_2,
        $city,
        $state_id,
        $zip_code,
        $country_id,
        $password,
        $login_enabled,
        $user_type_id,
        $role_id,
        $accreditation_type_id
    ) {
        $current_time = date('Y-m-d H:i:s', now());

        $data = array(
                'first_name'            => $first_name,
                'middle_initial'    => $middle_initial,
                'last_name'             => $last_name,
                'username'              => $email,
                'user_type_id'      => $user_type_id,
                'email'                     => $email,
                'password'              => md5($password),
                'login_enabled'     => $login_enabled,
                'created_date'      => $current_time,
                'created_by'            => $this->account_id
        );

        $this->db->insert('master_users', $data);

        $user_id = $this->db->insert_id();

        $this->insert_user_map($user_id, PROPERTY_ORGANIZATION_ID);
        $this->insert_user_address(
            $user_id,
            self::MAILING_ADDRESS_TYPE_ID,
            $address_line_1,
            $address_line_2,
            $city,
            $state_id,
            NULL, // province
            $zip_code,
            $country_id
        );
        $this->insert_user_role($user_id, $role_id);
        $this->insert_user_accreditation($user_id, $accreditation_type_id);
        $this->action_model->insert(Action_model::ACTION_TYPE_USER_INSERT);
        return $user_id;
    }

    public function insert_user(
            $first_name,
            $last_name,
            $username,
            $organization_id,
            $user_type_id,
            $email,
            $password,
            $login_enabled
    )
    {
        log_info(__FILE__, __LINE__, __METHOD__, 'Called');

        if(strcasecmp($username, ANONYMOUS_GUEST_USERNAME) === 0) {
            return FALSE;
        }

        $current_time = date('Y-m-d H:i:s', now());

        $data = array(
            'first_name'        => $first_name,
            'last_name'         => $last_name,
            'username'          => $username,
            'user_type_id'  => $user_type_id,
            'email'                 => $email,
            'password'          => md5($password),
            'login_enabled' => $login_enabled,
            'created_date'  => $current_time,
            'created_by'        => $this->account_id
        );
        
        $thing = $this->db->insert('master_users', $data);
        $user_id = $this->db->insert_id();
        $this->insert_user_map($user_id, $organization_id);
        $this->action_model->insert(Action_model::ACTION_TYPE_USER_INSERT);
        return $user_id;
    }
    public function get_user_response($user_id, $response_id){
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id ");
        $stmt = "
            SELECT * FROM master_user_test_activity WHERE user_id = $user_id 
            AND response_id = '$response_id';
            ";
        $query = $this->db->query($stmt);

        if($query->num_rows() > 0){
            return $query->result_array()[0];
        }
        else{
            return FALSE;
        }
    }
    public function get_user_question_responses($user_id){
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id ");
        $stmt = "
            SELECT * FROM master_user_test_activity WHERE user_id = $user_id
            ";
        $query = $this->db->query($stmt);

        if($query->num_rows() > 0){
            $converted = array();
            //Key on the response_id field
            foreach ($query->result_array() as $row){
                $converted[$row['response_id']] = $row;
            }
            return $converted;
        }
        else{
            return FALSE;
        }
    }

    public function update_user_question_responses($user_id, $response_id, $master_user_test_activity_data){
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id ");
        $where = array(
            'user_id' => $this->account_id,
            'response_id' => $response_id
        ); 
        $this->db->where($where);
        $q = $this->db->get('master_user_test_activity');
    
        if ( $q->num_rows() > 0 ) {
            $this->db->where($where)->update('master_user_test_activity', $master_user_test_activity_data);
        } else {
            $this->db->insert('master_user_test_activity',$master_user_test_activity_data);
        }           
    }
    public function insert_user_accreditation($user_id, $accreditation_type_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | accreditation_type_id = $accreditation_type_id");

        $data = array(
                'user_id'                               => $user_id,
                'accreditation_type_id' => $accreditation_type_id
        );

        $this->db->insert('master_user_accreditation_map', $data);
    }

    public function insert_user_address(
        $user_id,
        $address_type_id,
        $address_1,
        $address_2,
        $city,
        $state_id,
        $province,
        $zip,
        $country_id
    )
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

        $data = array(
            'address_1'     => $address_1,
            'address_2'     =>  $address_2,
            'city'              =>  $city,
            'state_id'      =>  ($state_id == -1) ? NULL : $state_id,
            'province'      =>  ($state_id == -1) ? $province : NULL,
            'zip'                   =>  $zip,
            'country_id'    =>  $country_id
        );

        $this->db->insert('master_addresses', $data);
        $address_id = $this->db->insert_id();

        $data = array(
            'user_id'                   => $user_id,
            'address_type_id'   => $address_type_id,
            'address_id'            => $address_id
        );

        $this->db->insert('master_user_address_map', $data);
    }

    public function insert_user_role($user_id, $role_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | role_id = $role_id");

        $data = array(
            'user_id'   => $user_id,
            'role_id'   =>  $role_id
        );

        $this->db->insert('master_user_role_map', $data);
    }

    public function insert_user_department($user_id, $department_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | department_id = $department_id");

        $data = array(
                'user_id'               => $user_id,
                'department_id' => $department_id
        );

        $this->db->insert('master_user_department_map', $data);
    }

    public function insert_user_map($user_id, $organization_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | organization_id = $organization_id");

        $data = array(
            'last_left_rail' => '',
            'last_response' => '',
            'user_id'                   => $user_id,
            'organization_id'   =>   $organization_id
        );

        $this->db->insert('master_users_map', $data);
    }

    public function insert_user_number($user_id, $user_number_type_id, $user_number)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | user_number_type_id = $user_number_type_id | user_number = $user_number");

        $data = array(
            'user_id'                           => $user_id,
            'user_number_type_id'   => $user_number_type_id,
            'user_number'                   => $user_number
        );

        $this->db->insert('master_user_numbers', $data);
    }
    public function insert_user_password_reset($user_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

        $data = array(
            'user_id'   => $user_id,
            'hash'      => md5(time().rand()),
            'active'    => 1
        );

        $query = $this->db->insert('master_user_password_reset', $data);

        $data['id'] = $this->db->insert_id();

        return $data;
    }

    public function insert_user_pay_grade($user_id, $pay_grade_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | pay_grade_id = $pay_grade_id");

        $data = array(
                'user_id'               => $user_id,
                'pay_grade_id'  => $pay_grade_id
        );

        $this->db->insert('master_user_pay_grade_map', $data);
    }

    public function insert_user_treatment_facility($user_id, $treatment_facility_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | treatment_facility_id = $treatment_facility_id");

        $data = array(
                'user_id'                               => $user_id,
                'treatment_facility_id' => $treatment_facility_id
        );

        $this->db->insert('master_user_treatment_facility_map', $data);
    }

    public function is_medrespond_organization_user($user_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

        $query = $this->db
            ->select('mum.master_user_map')
            ->from('master_users_map AS mum')
            ->join('master_organizations AS mo', 'mo.id = mum.organization_id')
            ->where(array(
                'mum.user_id' => $user_id,
                'mo.name' => 'MedRespond'
            ))->get();

        return ($query->num_rows() > 0) ? TRUE : FALSE;
    }

    public function reset_password($id, $password)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $id");

        $current_time = date('Y-m-d H:i:s', now());
        $where = array('id' => $id);
        $data = array(
            'password'                      => md5($password),
            'last_modified_date'    => $current_time,
            'last_modified_by'      => $this->account_id
        );
        $this->db->where($where)->update('master_users', $data);
    }

    public function update_last_user_state($user_id, $organization_id, $response_id = FALSE, $left_rail_id = FALSE)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | organization_id = $organization_id | response_id = $response_id | left_rail_id = $left_rail_id");

        $set = array();

        if ($response_id)
        {
            $set['last_response'] = $response_id;
        }

        if ($left_rail_id)
        {
            $set['last_left_rail'] = $left_rail_id;
        }

        $where = array(
                'user_id'                   => $user_id,
                'organization_id'   => $organization_id
        );

        $this->db->where($where)->update('master_users_map', $set);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE)
        {
            return FALSE;
        }
        return TRUE;
    }

    public function update_training_user(
        $user_id,
        $first_name,
        $middle_initial,
        $last_name,
        $address_line_1,
        $address_line_2,
        $city,
        $state_id,
        $zip_code,
        $country_id,
        $password,
        $login_enabled,
        $accreditation_type_id
    ) {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

        if(!($orig_user = $this->user_model->get_training_user($user_id))) {
            return FALSE;
        }

        $data = array(
            'first_name'                    => $first_name,
            'middle_initial'            => $middle_initial,
            'last_name'                     => $last_name,
            'password'                      => md5($password),
            'login_enabled'             => $login_enabled,
            'last_modified_date'    => date('Y-m-d H:i:s'),
            'last_modified_by'      => $this->account_id
        );

        $this->db->where('id', $user_id)->update('master_users', $data);

        if(!$this->get_user_map($user_id, PROPERTY_ORGANIZATION_ID, 1)) {
            if(!$this->get_user_map($user_id, PROPERTY_ORGANIZATION_ID, 0)) {
                $this->insert_user_map($user_id, PROPERTY_ORGANIZATION_ID);
            } else {
                $this->update_user_map($user_id, PROPERTY_ORGANIZATION_ID, 1);
            }
        }

        if($orig_user['user_type_id'] != 1 && $orig_user['user_type_id'] != 2) {
            $this->update_user_address(
                $user_id,
                self::MAILING_ADDRESS_TYPE_ID,
                $address_line_1,
                $address_line_2,
                $city,
                $state_id,
                NULL, // province
                $zip_code,
                $country_id
            );
        }

        // update accreditation
        if($accreditation_type_id != $orig_user['accreditation_type_id'])
        {
            $this->update_user_accreditation($user_id, $accreditation_type_id);
        }

        $this->action_model->insert(Action_model::ACTION_TYPE_USER_UPDATE);
        return TRUE;
    }


    public function update_sbirt_user(
            $id,
            $pay_grade_id,
            $first_name,
            $middle_initial,
            $last_name,
            $department_id,
            $user_number,
            $role_id,
            $accreditation_type_id,
            $treatment_facility_id,
            $user_type_id,
            $email,
            $password,
            $address_1,
            $address_2,
            $city,
            $state_id,
            $province,
            $zip,
            $country_id,
            $login_enabled
    )
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $id");

        if (!($orig_user = $this->user_model->get_sbirt_user($_POST['id'])))
        {
            return FALSE;
        }

        $data = array(
                'first_name'                    => $first_name,
                'middle_initial'            => $middle_initial,
                'last_name'                     => $last_name,
                'username'                      => $orig_user['username'],
                'user_type_id'              => $user_type_id,
                'email'                             => $email,
                'login_enabled'             => $login_enabled,
                'last_modified_date'    => date('Y-m-d H:i:s'),
                'last_modified_by'      => $this->account_id
        );

        if (!empty($password))
        {
            $data['password'] = md5($password);
        }

        $this->db->where('id', $id)->update('master_users', $data);

        /* update user map */
        if (!$this->get_user_map($id, PROPERTY_ORGANIZATION_ID, 1))
        {
            if (!$this->get_user_map($id, PROPERTY_ORGANIZATION_ID, 0))
            {
                $this->insert_user_map($user_id, PROPERTY_ORGANIZATION_ID);
            }
            else
            {
                $this->update_user_map($user_id, PROPERTY_ORGANIZATION_ID, 1);
            }
        }

        /* update department */
        if ($department_id != $orig_user['department_id'])
        {
            $this->update_user_deparment($id, $department_id);
        }

        /* update treatment_facility */
        if ($treatment_facility_id != $orig_user['treatment_facility_id'])
        {
            if ($orig_user['treatment_facility_id'] != -1)
            {
                if ($this->get_user_treatment_facility($id, $orig_user['treatment_facility_id'], 1))
                {
                    $this->update_user_treatment_facility($id, $orig_user['treatment_facility_id'], 0);
                }
            }

            if ($treatment_facility_id != -1)
            {
                if ($this->get_user_treatment_facility($id, $treatment_facility_id, 0))
                {
                    $this->update_user_treatment_facility($id, $treatment_facility_id, 1);
                }
                else
                {
                    $this->insert_user_treatment_facility($id, $treatment_facility_id);
                }
            }
        }

        /* update pay_grade */
        if ($pay_grade_id != $orig_user['pay_grade_id'])
        {
            $this->update_user_pay_grade($id, $pay_grade_id);
        }

        /* update address */
        if ($user_type_id != 1)
        {
            $this->update_user_address(
                    $id,
                    self::MAILING_ADDRESS_TYPE_ID,
                    $address_1,
                    $address_2,
                    $city,
                    $state_id,
                    $province,
                    $zip,
                    $country_id
            );
        }
        else
        {
            /* deactivate address */
        }

        // update accreditation
        if ($accreditation_type_id != $orig_user['accreditation_type_id'])
        {
            $this->update_user_accreditation($id, $accreditation_type_id);
        }

        /* update role */
        $this->update_user_role($id, $role_id);

        /* update user number */
        if ($user_number != $orig_user['dod_number'])
        {
            $this->update_user_number($id, self::USER_ID_NUMBER_TYPE_DOD, $user_number);
        }

        $this->action_model->insert(Action_model::ACTION_TYPE_USER_UPDATE);
        return TRUE;
    }

    public function update_user_accreditation($id, $accreditation_type_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $id | accreditation_type_id = $accreditation_type_id");

        $this->db->where(array('user_id' => $id))->update('master_user_accreditation_map', array('active' => 0));

        if ($accreditation_type_id == -1)
        {
            return;
        }

        if ($this->get_user_accreditation($id, $accreditation_type_id, 0))
        {
            $this->db->where(array('user_id' => $id, 'accreditation_type_id' => $accreditation_type_id))->update('master_user_accreditation_map', array('active' => 1));
        }
        else
        {
            $this->insert_user_accreditation($id, $accreditation_type_id);
        }
    }

    /***
     * Simple user attribute stuff
     */
    public function update_user_attr($id, $command, $value){
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $id | command = $command | value = $value");

        if ($id) {
            $user = $this->get_user($id);
            if (empty($user)){
                return FALSE;
            }

            $points = $this->db->where(array('id' => $id))->limit(1)->get('master_users')->row()->$command;

            if (!$points){
                $points = 0;
            }

            $where = array('id' => $id);

            $data = array(
                $command => 1+($points),
            );
            $this->db->where($where)->update('master_users', $data);
        }else{
            return FALSE;
        }
        return TRUE;
    }

    public function update_user(
        $id,
        $first_name,
        $last_name,
        $username,
        $organization_id,
        $user_type_id,
        $email,
        $password,
        $login_enabled
    )
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $id");

        if(strcasecmp($username, ANONYMOUS_GUEST_USERNAME) === 0) {
            return FALSE;
        }

        $current_time = date('Y-m-d H:i:s', now());

        $user = $this->get_user($id);

        if (empty($user))
        {
            return FALSE;
        }

        if ($user['username'] !== $username)
        {
            return FALSE;
        }

        if (empty($organization_id))
        {
            return FALSE;
        }

        /*
        $this->deactivate_other_user_map_entries($id, $organization_id);

        if (!$this->get_user_map($id, $organization_id))
        {
            $this->insert_user_map($id, $organization_id);
        }
        */

        $this->update_user_organization_map($id, $organization_id);

        $data = array(
            'first_name'                    => $first_name,
            'last_name'                     => $last_name,
            'user_type_id'              => $user_type_id,
            'email'                             => $email,
            'login_enabled'             => $login_enabled,
            'last_modified_date'    => $current_time,
            'last_modified_by'      => $this->account_id
        );

        if (!empty($password))
        {
            $data['password'] = md5($password);
        }

        $where = array('id' => $id);

        $this->db->where($where)->update('master_users', $data);
        $this->action_model->insert(Action_model::ACTION_TYPE_USER_UPDATE);
        return TRUE;
    }

    public function update_user_address(
            $user_id,
            $address_type_id,
            $address_1,
            $address_2,
            $city,
            $state_id,
            $province,
            $zip,
            $country_id
    )
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

        $data = array(
                'address_1'     => $address_1,
                'address_2'     => $address_2,
                'city'              => $city,
                'state_id'      => ($state_id == -1) ? NULL : $state_id,
                'province'      => ($state_id == -1) ? $province : NULL,
                'zip'                   => $zip,
                'country_id'    => $country_id
        );

        if (!$user_address_map = $this->get_user_address_map($user_id, $address_type_id))
        {
            $this->insert_user_address(
                $user_id,
                $address_type_id,
                $address_1,
                $address_2,
                $city,
                $state_id,
                $province,
                $zip,
                $country_id
            );
            return;
        }

        $this->db->where(array('id' => $user_address_map['address_id']))->update('master_addresses', $data);
    }

    public function update_user_role($user_id, $role_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | role_id = $role_id");

        $this->db->where(array('user_id' => $user_id))->update('master_user_role_map', array('active' => 0));

        if ($role_id == -1)
        {
            return;
        }

        if ($this->get_user_role($user_id, $role_id, 0))
        {
            $this->db->where(array('user_id' => $user_id, 'role_id' => $role_id))->update('master_user_role_map', array('active' => 1));
        }
        else
        {
            $this->insert_user_role($user_id, $role_id);
        }
    }

    public function update_user_deparment($user_id, $department_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | department_id = $department_id");

        $this->db->where(array('user_id' => $user_id))->update('master_user_department_map', array('active' => 0));

        if ($this->get_user_department($user_id, $department_id, 0))
        {
            $this->db->where(array('user_id' => $user_id, 'department_id' => $department_id))->update('master_user_department_map', array('active' => 1));
        }
        else
        {
            $this->insert_user_department($user_id, $department_id);
        }
    }

    public function update_user_map($user_id, $organization_id, $active)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | organization_id = $organization_id");

        $where = array('user_id' => $user_id, 'organization_id'  =>  $organization_id);
        $data = array('active' => $active);

        $this->db->where($where)->update('master_users_map', $data);
    }

    public function update_user_number($user_id, $user_number_type_id, $user_number)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | user_number_type_id = $user_number_type_id | user_number = $user_number");

        $where = array(
            'user_id'               => $user_id,
            'user_number_type_id' => $user_number_type_id
        );

        if ($user_number == -1)
        {
            $data = array('active' => 0);

            $this->db->where($where)->update('master_user_numbers', $data);
            return;
        }

        if ($user_address_map = $this->get_user_number($user_id, $user_number_type_id, 1))
        {
            $data = array('user_number' => $user_number);

            $this->db->where($where)->update('master_user_numbers', $data);
            return;
        }
        elseif ($user_address_map = $this->get_user_number($user_id, $user_number_type_id, 0))
        {
            $data = array(
                'user_number' => $user_number,
                'active'                => 1
            );

            $this->db->where($where)->update('master_user_numbers', $data);
            return;
        }
        else
        {
            $data = array(
                    'user_id'               => $user_id,
                    'user_number_type_id' => $user_number_type_id,
                    'user_number'           => $user_number,
                    'active'                => 1
            );

            $this->db->insert('master_user_numbers', $data);
        }
    }

    public function update_user_organization_map($user_id, $organization_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | organization_id = $organization_id");

        if ($this->get_user_map($user_id, $organization_id))
        {
            return TRUE;
        }

        $this->deactivate_other_user_map_entries($user_id, $organization_id);

        if ($user_organization_map = $this->get_user_map($user_id, $organization_id, 0))
        {
            $data = array('active'=>1);
            $where = array('master_user_map' => $user_organization_map['master_user_map']);
            $this->db->where($where)->update('master_users_map', $data);
            return TRUE;
        }

        $this->insert_user_map($user_id, $organization_id);

        return TRUE;
    }

    public function update_user_pay_grade($user_id, $pay_grade_id)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | pay_grade_id = $pay_grade_id");

        $this->db->where(array('user_id' => $user_id))->update('master_user_pay_grade_map', array('active' => 0));

        if ($pay_grade_id == -1)
        {
            return;
        }

        if ($this->get_user_pay_grade($user_id, $pay_grade_id, 0))
        {
            $this->db->where(array('user_id' => $user_id, 'pay_grade_id' => $pay_grade_id))->update('master_user_pay_grade_map', array('active' => 1));
        }
        else
        {
            $this->insert_user_pay_grade($user_id, $pay_grade_id);
        }
    }

    public function update_user_treatment_facility($user_id, $treatment_facility_id, $active)
    {
        log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | treatment_facility_id = $treatment_facility_id");

        if ($treatment_facility_id == -1)
        {
            return;
        }

        if ($this->get_user_treatment_facility($user_id, $treatment_facility_id, ($active == 1) ? 0 : 1))
        {
            $this->db->where(array('user_id' => $user_id, 'treatment_facility_id' => $treatment_facility_id))->update('master_user_treatment_facility_map', array('active' => $active));
        }
    }

}

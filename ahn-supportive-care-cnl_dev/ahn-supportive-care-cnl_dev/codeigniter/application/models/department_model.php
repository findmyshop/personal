<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Department_model extends CI_Model {

	public function __construct() {
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function get_department($organization_id, $id) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with organization_id = $organization_id | department_id = $id");

		$organization_id = $this->db->escape_str($organization_id);
		$id = $this->db->escape_str($id);

		$stmt = "
			SELECT		master_departments.*
			FROM		master_departments
			JOIN		master_organization_department_map
						ON master_organization_department_map.department_id=master_departments.id
						AND master_organization_department_map.organization_id='$organization_id'
			WHERE		master_departments.active=1
						AND
						master_departments.id='$id'
			ORDER BY	master_departments.department_name ASC
		";

		$query = $this->db->query($stmt);

		if($query->num_rows() < 1) {
			return array();
		} else {
		 return $query->result_array();
		}
	}

	public function get_departments($organization_id, $exclude_list = FALSE) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with organization_id = $organization_id | exclude_list = $exclude_list");

		$organization_id = $this->db->escape_str($organization_id);
		$where_in = '';

		if ($exclude_list !== FALSE) {
			$exclude_list = $this->db->escape_str($exclude_list);
			$where_in = " AND master_departments.id NOT IN ($exclude_list)";
		}

		$stmt = "
			SELECT		master_departments.*
			FROM		master_departments
			JOIN		master_organization_department_map
						ON master_organization_department_map.department_id=master_departments.id
						AND master_organization_department_map.organization_id='$organization_id'
			WHERE		master_departments.active=1
						$where_in
			ORDER BY	master_departments.department_name ASC
		";

		$query = $this->db->query($stmt);

		if($query->num_rows() < 1) {
			return array();
		} else {
			return $query->result_array();
		}
	}

}

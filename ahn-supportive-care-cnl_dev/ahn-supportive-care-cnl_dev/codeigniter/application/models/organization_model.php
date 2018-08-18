<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Organization_model extends CI_Model {

	public function __construct() {
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function get_mr_organization() {
		return $this->get_organization('MedRespond');
	}

	public function get_organization($organization_name) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with organization_name = $organization_name");

		$query = $this->db
			->where('name', $organization_name)
			->limit(1)
			->get('master_organizations');

		if($query->num_rows() == 1) {
			return $query->row_array();
		}

		return array();
	}

	public function get_organization_id($organization_name) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with organization_name = $organization_name");

		$where = array('name' => $organization_name);
		$query = $this->db->where($where)->limit(1)->get('master_organizations');

		if($query->num_rows() != 1) {
			return '';
		}

		$row = $query->row_array();
		return $row['id'];
	}

	public function get_org_id_by_user_id($user_id) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

		$this->load->model('user_model');

		if (!($user = $this->user_model->get_user_combined($user_id))) {
			return FALSE;
		}
		return $user['organization_id'];
	}

	public function get_organization_by_property_name($property_name) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with property_name = $property_name");

		$query = $this->db
			->select('mo.*')
			->from('master_properties AS mp')
			->join('master_organization_property_map AS mopm', 'mopm.property_id = mp.id')
			->join('master_organizations AS mo', 'mo.id = mopm.organization_id')
			->where('mp.name', $property_name)
			->limit(2)
			->get();

		$organizations = $query->result_array();
		$num_organizations = count($organizations);

		if($num_organizations == 1) {
			return $organizations[0];
		} else if($num_organizations == 2) {
			foreach($organizations as $organization) {
				if($organization['name'] !== 'MedRespond') {
					return $organization;
				}
			}
		}

		return array();
	}

	public function get_organization_id_by_property_name($property_name) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with property_name = $property_name");

		if($organization = $this->get_organization_by_property_name($property_name)) {
			return $organization['id'];
		}

		return NULL;
	}

	public function get_organizations($user_id = FALSE) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

		$user_id = $this->db->escape_str($user_id);

		if($user_id != FALSE) {
			$stmt = "SELECT DISTINCT(master_organizations.id) AS id,
							master_organizations.name AS organization_name,
							(SELECT
								COUNT(*)
								FROM
									master_users_map
								WHERE
									organization_id = master_organizations.id
									AND active='1') AS number_of_users
					FROM		master_organizations
					JOIN		master_users_map
								ON master_users_map.organization_id=master_organizations.id
								AND master_users_map.user_id='$user_id'
								AND master_users_map.active='1'
					WHERE
						master_organizations.active = 1
					ORDER BY	master_organizations.name ASC";
		} else {
			$stmt = "SELECT DISTINCT(master_organizations.id) AS id,
							master_organizations.name AS organization_name,
							(SELECT
								COUNT(*)
								FROM
									master_users_map
								WHERE
									organization_id = master_organizations.id
									AND active='1') AS number_of_users
					FROM		master_organizations
					WHERE
						master_organizations.active = 1
					ORDER BY	master_organizations.name ASC";
		}

		$query = $this->db->query($stmt);

		if($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return FALSE;
		}
	}

	public function get_organizations_summary($user_id = FALSE, $organization_id = FALSE) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | organization_id = $organization_id");

		$user_id = $this->db->escape_str($user_id);
		$organization_where = "";

		if($organization_id != FALSE) {
			$organization_id = $this->db->escape_str($organization_id);
			$organization_where = "WHERE master_organizations.id = '$organization_id'";
		}

		if($user_id != FALSE) {
			$stmt = "
				SELECT		DISTINCT(master_organizations.id) AS id,
							master_organizations.id AS organization_id,
							master_organizations.name AS organization_name
				FROM		master_organizations
				JOIN		master_users_map
							ON master_users_map.organization_id=master_organizations.id
							AND master_users_map.user_id='$user_id'
							AnD master_users_map.active='1'
				ORDER BY	master_organizations.name
			";
		} else {
			$stmt = "
				SELECT		DISTINCT master_organizations.id AS id,
							master_organizations.id AS organization_id,
							master_organizations.name AS organization_name
				FROM		master_organizations
				$organization_where
				ORDER BY	master_organizations.name
			";
		}

		$query = $this->db->query($stmt);

		if($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return FALSE;
		}
	}

}

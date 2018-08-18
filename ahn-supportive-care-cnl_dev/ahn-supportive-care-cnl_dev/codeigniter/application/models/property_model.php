<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Property_model extends CI_Model {

	public function __construct() {
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function get_case_name($property_name) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with property_name = $property_name");

		$this->db->select('case_name');
		$query = $this->db->where(array('name' => $property_name))->get('master_properties', 1);

		if($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result['case_name'];
		} else {
			return FALSE;
		}
	}

	public function get_current_case_name() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$host = $this->_get_hostname();
		$this->db->select('case_name');
		$domain_pieces = explode('.', $host);
		$root_domain = (count($domain_pieces) == 2) ? ($host) : (implode('.', array_slice($domain_pieces, 1)));
		$query = $this->db->where(array('domain' => $root_domain))->get('master_properties', 1);

		if($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result['case_name'];
		} else {
			return FALSE;
		}
	}

	public function get_property_by_name($property_name) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with property_name = $property_name");

		$query = $this->db->where(array('name' => $property_name))->get('master_properties');

		if ($query->num_rows() < 1) {
			return array();
		}

		return $query->row_array();
	}

	public function get_response_prefix($property_name) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with property_name = $property_name");

		$this->db->select('response_prefix');
		$query = $this->db->where(array('name' => $property_name))->get('master_properties', 1);

		if($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result['response_prefix'];
		} else {
			return FALSE;
		}
	}

	public function get_title($property_name) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with property_name = $property_name");

		$this->db->select('title');
		$query = $this->db->where(array('name' => $property_name))->get('master_properties', 1);

		if($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result['title'];
		} else {
			return FALSE;
		}
	}

	public function get_video_domains($property_name) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with property_name = $property_name");

		$this->db->select('web_video_domain, rtmp_video_domain');
		$query = $this->db->where(array('name' => $property_name))->get('master_properties', 1);

		if($query->num_rows() > 0) {
			return $query->row_array();
		} else {
			return FALSE;
		}
	}

	public function get_mp4_video_domain($property_name) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with property_name = $property_name");

		$this->db->select('web_video_domain');
		$query = $this->db->where(array('name' => $property_name))->get('master_properties', 1);

		if($query->num_rows() > 0) {
			$row = $query->row_array();
			return $row['web_video_domain'];
		} else {
			return FALSE;
		}
	}

	public function get_welcome_response_id($property_name, $decision_flow_site = FALSE, $new_user = TRUE) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with property_name = $property_name | decision_flow_site = $decision_flow_site | new_user = $new_user");

		if($property_name === 'ppd') {
			if(strpos($_SERVER['HTTP_REFERER'], 'smartpatients.com') !== false) {
				return 'ppd017';
			}
		}

		if($decision_flow_site) {
			if($new_user) {
				$this->db->select('decision_flow_welcome_response as initial_response');
			} else {
				$this->db->select('welcome_back_response as initial_response');
			}
		} else {
			$this->db->select('general_welcome_response as initial_response');
		}

		if($property_name === 'ppd') {
			log_info(__FILE__, __LINE__, __METHOD__, "SERVER['HTTP_REFERER'] = " . $_SERVER['HTTP_REFERER']);
		}

		$query = $this->db->where(array('name' => $property_name))->get('master_properties');

		if($query->num_rows() > 0) {
			$result = $query->row_array();
			return $result['initial_response'];
		} else {
			return FALSE;
		}
	}

	public function is_welcome_back_response_id($property_name, $response_id) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with property_name = $property_name | response_id = $response_id");

		$property_name = $this->db->escape_str($property_name);
		$response_id = $this->db->escape_str($response_id);

		$sql = "
			SELECT id
			FROM master_properties
			WHERE
				name = '$property_name' AND
				welcome_back_response = '$response_id'
		";

		$query = $this->db->query($sql);

		if($query->num_rows() > 0) {
			return TRUE;
		}

		return FALSE;
	}

	private function _get_hostname() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$this->load->helper('url');
		$url_array = parse_url(current_url());
		return $url_array['host'];
	}

}

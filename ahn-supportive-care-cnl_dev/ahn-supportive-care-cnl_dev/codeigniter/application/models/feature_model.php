<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feature_model extends CI_Model {

	public function __construct() {
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	// this function returns true if a record for feature_name doesn't exist in the master_features table
	public function enabled($feature_name, $feature_permission_field = 'unauthenticated') {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with feature_name = $feature_name feature_permission_field = $feature_permission_field");

		if(!$feature = $this->get($feature_name)) {
			return TRUE;
		}

		if(!in_array($feature_permission_field, array('admin', 'site_admin', 'user'))) {
			$feature_permission_field = 'unauthenticated';
		}

		if(!isset($feature[$feature_permission_field])) {
			return FALSE;
		}

		return ($feature[$feature_permission_field]) ? TRUE : FALSE;
	}

	public function get($feature_name) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with feature_name = $feature_name");

		$query = $this->db
			->select('name, admin, site_admin, user, unauthenticated')
			->from('master_features')
			->where('name', $feature_name)
			->limit(1)
			->get();

		if($query->num_rows() == 1) {
			return $query->row_array();
		}

		return array();
	}

}

/* End of file feature_model.php */
/* Location: ./application/models/feature_model.php */

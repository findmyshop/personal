<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accreditation_Type_model extends CI_Model {

	public function __construct() {
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function get_accreditation_types() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$query = $this->db
			->where(array(
					'organization_id' => PROPERTY_ORGANIZATION_ID,
					'active' => 1
				))
			->order_by('`order` ASC, accreditation_type ASC')
			->get('master_accreditation_types');

		if($query->num_rows() < 1) {
			return array();
		} else {
			return $query->result_array();
		}
	}

}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_experience_state_map_model extends CI_Model {

	private $_EXPERIENCE_STATES = array(
		'INITIALIZED',
		'RELIABILITY_COMPLETED',
		'TEST_IN_PROGRESS',
		'TEST_COMPLETED'
	);

	public function __construct() {
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function get_by_user($user_id) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

		$query = $this->db
			->select('experience_state')
			->from('master_user_experience_state_map')
			->where(array(
				'user_id'	=> $user_id,
				'active'	=> 1
			))
			->limit(1)
			->get();

		if($query->num_rows() == 1) {
			$row = $query->row_array();
			return $row['experience_state'];
		}

		return FALSE;
	}

	public function insert($user_id) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id");

		$this->db->insert('master_user_experience_state_map', array(
			'user_id'						=> $user_id,
			'experience_state'	=> 'INITIALIZED'
		));

		return $this->db->insert_id();
	}

	public function update($user_id, $experience_state) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | experience_state = $experience_state");

		if(!in_array($experience_state, $this->_EXPERIENCE_STATES)) {
			log_error(__FILE__, __LINE__, __METHOD__, "Invalid experience_state = $experience_state");
			return FALSE;
		}

		$this->db
			->where('user_id', $user_id)
			->update('master_user_experience_state_map', array(
				'experience_state' => $experience_state
			));

		return $this->db->affected_rows();
	}

}

/* End of file user_experience_state_map_model.php */
/* Location: ./application/models/user_experience_state_map_model.php */

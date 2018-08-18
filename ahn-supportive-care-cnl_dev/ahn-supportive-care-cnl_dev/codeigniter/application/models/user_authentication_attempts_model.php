<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_authentication_attempts_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	private function _insert($username, $successful) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with username = $username | successful = $successful");

		$data = array(
			'ip_address'	=> $this->input->ip_address(),
			'user_id'			=> 0, // user_id = 0 indicates an attempt to login with an invalid username
			'username'		=> $username,
			'successful'	=> ($successful) ? TRUE : FALSE,
			'datetime'		=> date('Y-m-d H:i:s')
		);

		if($user = $this->user_model->get_user_by_username($username)) {
			$data['user_id'] = $user['id'];
		}

		$this->db->insert('master_user_authentication_attempts', $data);
	}

	public function insert_failure($username) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with username = $username");
		return $this->_insert($username, FALSE);
	}

	public function insert_success($username) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with username = $username");
		return $this->_insert($username, TRUE);
	}

	public function is_locked_out($username) {
		log_info(__FILE__, __LINE__, __METHOD__, "Called with username = $username");

		if(!BRUTE_FORCE_LOCKOUTS_ENABLED || !$user = $this->user_model->get_user_by_username($username)) {
			return FALSE;
		}

		$locked_datetime_threshold = date('Y-m-d H:i:s', now() - (BRUTE_FORCE_LOCKOUTS_MINUTES_LOCKED * 60));

		$sql = '
			SELECT
				IF(COUNT(successful) >= ' . BRUTE_FORCE_LOCKOUTS_SUCCESSIVE_FAILED_ATTEMPTS_THRESHOLD . ' AND SUM(successful) = 0 AND MAX(datetime) >= ?, 1, 0) AS is_locked
			FROM (
				SELECT
					successful,
					datetime
				FROM master_user_authentication_attempts
				WHERE
					user_id = ?
				ORDER BY datetime DESC
				LIMIT ' . BRUTE_FORCE_LOCKOUTS_SUCCESSIVE_FAILED_ATTEMPTS_THRESHOLD . '
			) AS t
		';

		$query = $this->db->query($sql, array($locked_datetime_threshold, $user['id']));

		if($query->num_rows() === 1) {
			$row = $query->row_array();
			return $row['is_locked'] ? TRUE : FALSE;
		}

		return FALSE;
	}

}

/* End of file User_authentication_attempts_model.php */
/* Location: ./application/models/user_authentication_attempts_model.php */

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oct_library {

	public $ci = NULL;
	public $ip_address = NULL;
	public $session_id = NULL;

	public function __construct() {
		$this->ci =& get_instance();
		$this->ip_address = $this->ci->session->userdata('ip_address');
		$this->session_id = $this->ci->session->userdata('session_id');
		$this->ci->load->model('course_model');

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function get_feedback_logs($limit = 1000, $offset = 0) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called limit = ' . $limit . ' | offset = ' . $offset);

		if(!is_numeric($limit) || !is_numeric($offset)) {
			return FALSE;
		}

		$sql = "
			SELECT
				session_id,
				ip_address,
				answer_1 AS oct142_answer,
				answer_2 AS oct143_answer,
				answer_3 AS oct144_answer,
				answer_4 AS oct155_answer,
				answer_5 AS oct156_answer
			FROM master_feedback_logs
			ORDER by id DESC
			LIMIT $limit
			OFFSET $offset
		";

		$query = $this->ci->db->query($sql);

		if($query->num_rows() > 0) {
			return $query;
		}

		return NULL;
	}

	public function get_load_response_test_data($response_id) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called response_id = ' . $response_id);

		$data = array();

		$test = $this->ci->course_model->get_test($response_id);
		$questions = $this->ci->course_model->get_test_answers(0, 1, $test['id'], 1);
		$data = $test;

		foreach ($questions as &$row){
			$choices = $this->ci->course_model->get_element_scheme($row['scheme']);
			$row['choices'] = $choices;
		}

		$data['questions'] = $questions;

		return $data;
	}

	public function get_session_feedback_log_id() {
		$query = $this->ci->db
			->select('id')
			->from('master_feedback_logs')
			->where('session_id', $this->session_id)
			->limit(1)
			->get();

		if($query->num_rows() == 1) {
			$row = $query->row_array();
			return $row['id'];
		}

		return NULL;
	}

	public function insert_feedback_log_item($response_id, $answer) {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		if($feedback_log_id = $this->get_session_feedback_log_id()) {
			return $this->_update_feedback_log($feedback_log_id, $response_id, $answer);
		} else {
			return $this->_insert_feedback_log($response_id, $answer);
		}
	}

	public function session_feedback_logs_submitted() {
		return ($this->get_session_feedback_log_id() === NULL) ? FALSE : TRUE;
	}

	public function write_feedback_logs_to_csv($fully_qualified_filename, $chunk_size = 1000) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called fully_qualified_filename = ' . $fully_qualified_filename . ' chunk_size= ' . $chunk_size);

		$offset = 0;

		if(!$query = $this->get_feedback_logs($chunk_size, $offset)) {
			return FALSE;
		}

		$this->ci->load->library('csv_library');

		if(!$this->ci->csv_library->write_query_result_to_csv_file($query, $fully_qualified_filename, TRUE)) {
			throw new Exception('Failed to Write CSV to File');
		}

		$offset += $chunk_size;

		while($query = $this->get_feedback_logs($chunk_size, $offset)) {
			if(!$this->ci->csv_library->write_query_result_to_csv_file($query, $fully_qualified_filename, FALSE)) {
				throw new Exception('Failed to Write CSV to File');
			}
			$offset += $chunk_size;
		}

		return TRUE;
	}

	private function _insert_feedback_log($response_id, $answer) {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$data = array(
			'ip_address'			=> $this->ip_address,
			'session_id'			=> $this->session_id,
			'organization_id'	=> PROPERTY_ORGANIZATION_ID,
			'answer_1'				=> NULL,
			'answer_2'				=> NULL,
			'answer_3'				=> NULL,
			'answer_4'				=> NULL,
			'answer_5'				=> NULL
		);

		switch($response_id) {
			case 'oct142':
				$data['answer_1'] = $answer;
			break;

			case 'oct143':
				$data['answer_2'] = $answer;
			break;

			case 'oct144':
				$data['answer_3'] = $answer;
			break;

			case 'oct155':
				$data['answer_4'] = $answer;
			break;

			case 'oct156':
				$data['answer_5'] = $answer;
			break;

			default:
				return NULL;
			break;
		}

		$this->ci->db->insert('master_feedback_logs', $data);
		return $this->ci->db->insert_id();
	}

	private function _update_feedback_log($feedback_log_id, $response_id, $answer) {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$data = array();

		switch($response_id) {
			case 'oct142':
				$data['answer_1'] = $answer;
			break;

			case 'oct143':
				$data['answer_2'] = $answer;
			break;

			case 'oct144':
				$data['answer_3'] = $answer;
			break;

			case 'oct155':
				$data['answer_4'] = $answer;
			break;

			case 'oct156':
				$data['answer_5'] = $answer;
			break;

			default:
				return FALSE;
			break;
		}

		$this->ci->db
			->where('id', $feedback_log_id)
			->update('master_feedback_logs', $data);

		return TRUE;
	}

}

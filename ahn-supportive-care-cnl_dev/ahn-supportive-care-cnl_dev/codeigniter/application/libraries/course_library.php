<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Course_library {
	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->model('course_model');
		$this->ci->load->library('csv_library');

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
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

	public function write_accreditation_report_to_csv($accreditation_type_id, $start_date, $end_date, $fully_qualified_filename, $chunk_size = 100) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');
		$offset = 0;

		if(!$query = $this->ci->course_model->get_accreditation_report($accreditation_type_id, $start_date, $end_date, $chunk_size, $offset, TRUE)) {
			return FALSE;
		}

		if(!$this->ci->csv_library->write_query_result_to_csv_file($query, $fully_qualified_filename, TRUE)) {
			throw new Exception('Failed to Write CSV to File');
		}

		$offset += $chunk_size;

		while($query = $this->ci->course_model->get_accreditation_report($accreditation_type_id, $start_date, $end_date, $chunk_size, $offset, TRUE)) {
			if(!$this->ci->csv_library->write_query_result_to_csv_file($query, $fully_qualified_filename, FALSE)) {
				throw new Exception('Failed to Write CSV to File');
			}
			$offset += $chunk_size;
		}

		return TRUE;
	}

	public function write_raw_courses_to_csv($search = NULL, $course_id = NULL, $role_id = NULL, $fully_qualified_filename, $chunk_size = 1000) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');
		$offset = 0;

		if(!$query = $this->ci->course_model->get_raw_courses_dump($search, $course_id, $role_id, $chunk_size, $offset, TRUE)) {
			return FALSE;
		}

		if(!$this->ci->csv_library->write_query_result_to_csv_file($query, $fully_qualified_filename, TRUE)) {
			throw new Exception('Failed to Write CSV to File');
		}

		$offset += $chunk_size;

		while($query = $this->ci->course_model->get_raw_courses_dump($search, $course_id, $role_id, $chunk_size, $offset, TRUE)) {
			if(!$this->ci->csv_library->write_query_result_to_csv_file($query, $fully_qualified_filename, FALSE)) {
				throw new Exception('Failed to Write CSV to File');
			}
			$offset += $chunk_size;
		}

		return TRUE;
	}

	public function write_user_answers_to_csv($search = NULL, $course_id = NULL, $role_id = NULL, $fully_qualified_filename, $chunk_size = 1000) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');
		$offset = 0;

		if(!$query = $this->ci->course_model->get_user_answers($search, $course_id, $role_id, $chunk_size, $offset, TRUE)) {
			return FALSE;
		}

		if(!$this->ci->csv_library->write_query_result_to_csv_file($query, $fully_qualified_filename, TRUE)) {
			throw new Exception('Failed to Write CSV to File');
		}

		$offset += $chunk_size;

		while($query = $this->ci->course_model->get_user_answers($search, $course_id, $role_id, $chunk_size, $offset, TRUE)) {
			if(!$this->ci->csv_library->write_query_result_to_csv_file($query, $fully_qualified_filename, FALSE)) {
				throw new Exception('Failed to Write CSV to File');
			}
			$offset += $chunk_size;
		}

		return TRUE;
	}

	public function write_user_courses_to_csv($user_id = FALSE, $all = TRUE, $search = FALSE, $uncompleted = NULL, $not_passed = NULL, $no_cert = NULL, $course_id = NULL, $role_id = NULL, $fully_qualified_filename, $chunk_size = 1000) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');
		$offset = 0;

		if(!$query = $this->ci->course_model->get_user_courses(FALSE, FALSE, $search, $uncompleted, $not_passed, $no_cert, $course_id, $role_id, $chunk_size, $offset, TRUE)) {
			return FALSE;
		}

		if(!$this->ci->csv_library->write_query_result_to_csv_file($query, $fully_qualified_filename, TRUE)) {
			throw new Exception('Failed to Write CSV to File');
		}

		$offset += $chunk_size;

		while($query = $this->ci->course_model->get_user_courses(FALSE, FALSE, $search, $uncompleted, $not_passed, $no_cert, $course_id, $role_id, $chunk_size, $offset, TRUE)) {
			if(!$this->ci->csv_library->write_query_result_to_csv_file($query, $fully_qualified_filename, FALSE)) {
				throw new Exception('Failed to Write CSV to File');
			}
			$offset += $chunk_size;
		}

		return TRUE;
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Password_rule_model extends CI_Model {

	private $_form_validation_error_message = '';  // form validation error message contructed from rules defined in master_password_rules and master_project_password_rule_map

	private $_rules = array(
		'min_length'	=> array(), // array contining a single max_length record from the database
		'max_length'	=> array(), // array containing a single min_length record from the database
		'regex'				=> array()  // multidimensional array containing all related regex records from the database
	);

	public function __construct() {
		parent::__construct();
		$this->_initialize_rules();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function is_valid_password($password) {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$password_length = strlen($password);

		if($password_length < $this->_rules['min_length']['rule']) {
			$this->_build_form_validation_error_message();
			return FALSE;
		}

		if($password_length > $this->_rules['max_length']['rule']) {
			$this->_build_form_validation_error_message();
			return FALSE;
		}

		foreach($this->_rules['regex'] as $rule) {
			if(!preg_match($rule['rule'], $password)) {
				$this->_build_form_validation_error_message();
				return FALSE;
			}
		}

		$this->_form_validation_error_message = '';
		return TRUE;
	}

	public function get_form_validation_error_message() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');
		return $this->_form_validation_error_message;
	}

	public function get_min_length_rule() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');
		return $this->_rules['min_length'];
	}

	public function get_max_length_rule() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');
		return $this->_rules['max_length'];
	}

	public function get_regex_rules() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');
		return $this->_rules['regex'];
	}

	public function get_rules() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');
		return $this->_rules;
	}

	private function _build_form_validation_error_message() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');
		$this->_form_validation_error_message = "Passwords must be between {$this->_rules['min_length']['rule']} and {$this->_rules['max_length']['rule']} characters";

		if(!empty($this->_rules['regex'])) {
			$this->_form_validation_error_message .= ' and consist of the following:';
			$this->_form_validation_error_message .= '<ul>';
			foreach($this->_rules['regex'] as $rule) {
				$this->_form_validation_error_message .= '<li>' . $rule['form_validation_text'] . '</li>';
			}
			$this->_form_validation_error_message .= '</ul>';
		} else {
			$this->_form_validation_error_message .= '.';
		}
	}

	private function _initialize_rules() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');
		if(!$this->_set_project_specific_rules()) {
			$this->_set_default_rules();
		}

		$this->_validate_rules();
	}

	private function _parse_rules_query_result($query) {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');
		foreach ($query->result_array() as $rule) {
			if($rule['type'] === 'regex') {
				$this->_rules['regex'][] = $rule;
			} else if($rule['type'] === 'min_length') {
				$this->_rules['min_length'] = $rule;
			} else if($rule['type'] === 'max_length') {
				$this->_rules['max_length'] = $rule;
			}
		}
	}

	private function _set_default_rules() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');
		$query = $this->db
			->select('type, rule, form_validation_text')
			->from('master_password_rules')
			->where(array(
					'default'	=> 1,
					'active'	=> 1
				))
			->get();

		if($query->num_rows() > 0) {
			$this->_parse_rules_query_result($query);
			return TRUE;
		}

		return FALSE;
	}

	private function _set_project_specific_rules() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');
		$query = $this->db
			->select('mpr.type, mpr.rule, mpr.form_validation_text')
			->from('master_password_rules AS mpr')
			->join('master_property_password_rule_map AS mpprm', 'mpprm.password_rule_id = mpr.id')
			->where(array(
					'mpr.active'				=> 1,
					'mpprm.property_id'	=> PROPERTY_ID,
					'mpprm.active'			=> 1
				))
			->get();

		if($query->num_rows() > 0) {
			$this->_parse_rules_query_result($query);
			return TRUE;
		}

		return FALSE;
	}

	private function _validate_rules() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');
		if(empty($this->_rules['min_length']) || empty($this->_rules['max_length'])) {
			die('Either a default, or project specific min_length and max_length rule type must be set in master_password_rules.  Project specific rule mappings are defined in master_project_password_rule_map.');
		}

		foreach($this->_rules['regex'] as $rule) {
			if(preg_match($rule['rule'], null) === false) {
				die('Invalid master_password_rules regex entry - ' . $rule);
			}
		}
	}
}

/* End of file password_rule_model.php */
/* Location: ./application/models/password_rule_model.php */

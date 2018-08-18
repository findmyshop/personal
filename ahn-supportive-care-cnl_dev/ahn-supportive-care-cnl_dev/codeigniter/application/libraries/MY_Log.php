<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Log extends CI_Log {

	protected $_ci = NULL;
	protected $_user_id = NULL;

	public function __construct() {
		parent::__construct();
		// set the canonical log level ordering.  CI's default ordering is insane.
		$this->_levels	= array('ERROR' => '1', 'INFO' => '2',  'DEBUG' => '3', 'ALL' => '4');

		$this->log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function log_debug($file, $line, $method, $msg) {
		$this->log('debug', $file, $line, $method, $msg);
	}

	public function log_error($file, $line, $method, $msg) {
		$this->log('error', $file, $line, $method, $msg);
	}

	public function log_info($file, $line, $method, $msg) {
		$this->log('info', $file, $line, $method, $msg);
	}

	public function log($level, $file, $line, $method, $msg, $php_error = FALSE) {
		$level = strtoupper($level);

		if(!isset($this->_levels[$level]) || ($this->_levels[$level] > $this->_threshold)) {
			return FALSE;
		}

		$msg = $this->_prep_message($file, $line, $method, $msg);
		parent::write_log($level, $msg, $php_error = FALSE);
	}

	// override
	public function write_log($level = 'error', $msg, $php_error = FALSE) {
		$msg = $this->_prep_message(NULL, NULL, NULL, $msg);
		parent::write_log($level, $msg, $php_error = FALSE);
	}

	protected function _prep_message($file, $line, $method, $msg) {
		if($this->_user_id === NULL) {
			$this->_set_user_id();
		}

		if($this->_user_id !== NULL) {
			$msg = "USER_ID = {$this->_user_id} | " . $msg;
		}

		if(!empty($method)) {
			$msg = "$method | " . $msg;
		}


		if(!empty($file) && !empty($line)) {
			$msg = "$file:$line | " . $msg;
		}

		return $msg;
	}

	private function _set_user_id() {
		if($this->_ci === NULL) {
			if(class_exists('CI_Controller', FALSE)) {
				$this->_ci =& get_instance();
			}
		}

		if($this->_user_id === NULL) {
			if(isset($this->_ci->session)) {
				$this->_user_id = $this->_ci->session->userdata('account_id') ? $this->_ci->session->userdata('account_id') : 0;
			}
		}
	}

}
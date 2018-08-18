<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('log_debug')) {
	function log_debug($file, $line, $method, $message) {
		$log =& load_class('Log');
		$log->log_debug($file, $line, $method, $message);
	}
}

if (!function_exists('log_error')) {
	function log_error($file, $line, $method, $message) {
		$log =& load_class('Log');
		$log->log_error($file, $line, $method, $message);
	}
}

if (!function_exists('log_info')) {
	function log_info($file, $line, $method, $message) {
		$log =& load_class('Log');
		$log->log_info($file, $line, $method, $message);
	}
}
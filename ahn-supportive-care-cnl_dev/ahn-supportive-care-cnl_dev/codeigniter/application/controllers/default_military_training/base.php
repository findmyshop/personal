<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends Base_Controller_Military_Training {

	public function __construct() {
		parent::__construct();
		$this->load->model('course_model');
		if ($this->account_id) {
			if(!is_admin() && empty($this->default_course['disclaimer_accepted'])) {
				redirect('/disclaimer');
			}
		}
		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

}

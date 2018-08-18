<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Certification extends Base_Certification {

	public function __construct() {
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends Base_Controller_Nami_White_Label {

	public function __construct() {
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

}

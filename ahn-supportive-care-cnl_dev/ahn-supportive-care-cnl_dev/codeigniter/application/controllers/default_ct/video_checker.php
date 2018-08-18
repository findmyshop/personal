<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video_Checker extends Video_Checker_Controller {

    public function __construct() {
        parent::__construct();
        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

}

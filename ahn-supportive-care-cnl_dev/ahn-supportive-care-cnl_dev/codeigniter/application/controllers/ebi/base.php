<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends Base_Controller_Hybrid {

    public function __construct() {
        parent::__construct();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function index() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        // do not allow admins and site_admins to enter the experience
        if(is_admin() || is_site_admin()) {
            log_info(__FILE__, __LINE__, __METHOD__, 'Unauthorized request to enter the experience');
            redirect('admin');
        }

        parent::index();
    }
}

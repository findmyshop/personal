<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller_Hybrid {

    public function __construct() {
        parent::__construct();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function actions() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        if($this->account_id != 1) {
            show_error('You are not authorized to view this page.', '401', 'Unauthorized Access');
        }

        parent::actions();
    }

    public function activity_logs() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        if($this->account_id != 1) {
            show_error('You are not authorized to view this page.', '401', 'Unauthorized Access');
        }

        parent::activity_logs();
    }

    public function moodle_link_builder() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        if($this->account_id != 1) {
            show_error('You are not authorized to view this page.', '401', 'Unauthorized Access');
        }

        $this->template_library
            ->set_title("Moodle Link Builder")
            ->set_module('Test')
            ->set_using_angularjs(TRUE, 'userApp')
            ->set_timeout_check_interval(60)
            ->build('admin/admin_index', $this->_data, 'admin/admin_header', 'admin/admin_moodle_link_builder');
    }

    public function users() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        if($this->account_id != 1) {
            show_error('You are not authorized to view this page.', '401', 'Unauthorized Access');
        }

        parent::users();
    }

}

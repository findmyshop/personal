<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Login_Controller_Hybrid {

    public function __construct() {
        parent::__construct();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function ajax_login() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        if(preg_match('/tssim\.com\/login\/admin\/?$/', $this->agent->referrer())) {
            parent::ajax_login();
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email');

            if($this->form_validation->run()) {
                $username = $this->input->post('username');
                $user = $this->user_model->get_user_by_username($username);

                if(empty($user)) {
                    $user_id = $this->user_model->insert_user(
                        '',                         // first_name,
                        '',                         // last_name,
                        $username,                  // username
                        PROPERTY_ORGANIZATION_ID,   // organization_id,
                        4,                          // user_type_id
                        $username,                  // email
                        '',                         // password
                        1                           // login_enabled
                    );
                } else {
                    $user_id = $user['id'];
                }

               if(!$this->auth_library->login_by_id($user_id)) {
                    ajax_status_failure($this->auth_library->get_message());
                } else {
                    ajax_status_success();
                }
            } else {
                ajax_status_failure(validation_errors());
            }
        }
    }

}
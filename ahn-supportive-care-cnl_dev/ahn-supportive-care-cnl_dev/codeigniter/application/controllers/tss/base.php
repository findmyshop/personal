<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends Base_Controller_Hybrid {

    public function __construct() {
        parent::__construct();
        $this->load->library('tssim_library');
        $this->load->model('tssim_score_model');

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    /**
     * We override the default load_response here.  We do some stuff with it.
     */
    public function ajax_angular_load_response() {
        /* We're going to hook the parent */
        $this->_is_hooked = true;
        parent::ajax_angular_load_response();

        log_info(__FILE__, __LINE__, __METHOD__, 'Request for response_id = ' . $this->_data['response']['id']);

        if($this->tssim_library->has_exhausted_input_question_attempts($this->_data['response']['id'])) {
            // if the requested response is a BQ input, redirect the user to the "What would you like to do next?" response for the scenario
            if(preg_match('/^HS([2-6])D001$/', $this->_data['response']['id'], $matches)) {
                $this->_data['status'] = 'failure';
                $this->_data['message'] = 'You have already completed the requested question.';
                $this->_data['hard_redirect'] = '#/RETURN/HS' . $matches[1] . 'D002';

            // redirect to the last viewed non-input response
            } else {
                $user_state = $this->user_model->get_last_user_state($this->account_id, $this->org_id);
                $this->_data['status'] = 'failure';
                $this->_data['message'] = 'You have already completed the requested question.  Redirecting to where you left off.';
                $this->_data['hard_redirect'] = '#/RETURN/' . $user_state['last_response'];
            }
        }

        // Map the next response id for Null, Shame, Illegal, Impolite, and Brain responses to the most recently visited response that accepts user input
        if(preg_match('/^HS\d(Null|Shame|Illegal|Impolite|Brain)$/', $this->_data['response']['id'])) {
            $this->_data['response']['video_controls']['next_id'] = $this->tssim_library->get_most_recent_input_response_id();
        }

        // redirect to the dashboard after the last response has played
        if($this->_data['response']['id'] === 'HEndD001') {
            $this->_data['hard_redirect'] = '/admin';
            $this->_data['hard_redirect_timeout'] = 12000;
            $this->tssim_score_model->insert_user_simulation_attempt_scores($this->account_id, $this->current_flow_attempt);
        }

        // for responses that have a done_id defined, use it as the next_id if they've previously attempted this question
        if($this->_data['response']['video_controls']['done_id'] !== '') {

            if($this->tssim_library->has_previously_attempted_question($this->_data['response']['id'])) {
                $this->_data['response']['video_controls']['next_id'] = $this->_data['response']['video_controls']['done_id'];
            }

            /* original behavior - only look to see whether or not the user has made this same type of mistake before
            if($this->_data['response']['attempt'] > 1) {
                $this->_data['response']['video_controls']['next_id'] = $this->_data['response']['video_controls']['done_id'];
            }
            */
        }

        // keep track of the last response the user visited
        if(!empty($this->_data['response']['id']) && !$this->property_model->is_welcome_back_response_id(MR_PROJECT, $this->_data['response']['id'])) {
            $this->user_model->update_last_user_state($this->account_id, $this->org_id, $this->_data['response']['id'], '');
        }

        echo json_encode($this->_data);
        $this->_is_hooked = false;
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

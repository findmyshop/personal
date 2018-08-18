<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Constants_Controller extends CI_Controller {

    private $case_name                 = FALSE;
    private $_mr_organization          = array();
    private $_mr_organization_id       = NULL;
    private $_property_organization    = array();
    private $_property_organization_id = NULL;
    private $_property                 = array();
    private $_property_id              = NULL;
    private $_preprocessor_property_id = NULL;

    public function __construct(){
        parent::__construct();

        $this->_set_constants();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    private function _set_constants() {
        $this->_set_mr_organization_id();
        $this->_set_property_organization_id();
        $this->_set_property_id();
        $this->_set_preprocessor_property_id();
        $this->_set_case_name();
    }

    private function _set_mr_organization() {
        if(empty($this->_mr_organization)) {
            $this->_mr_organization = $this->organization_model->get_mr_organization();
        }
    }

    private function _set_mr_organization_id() {
        if(empty($this->_mr_organization_id)) {
            $this->_set_mr_organization();

            if(!empty($this->_mr_organization)) {
                $this->_mr_organization_id = $this->_mr_organization['id'];

                if(!defined('MR_ORGANIZATION_ID')) {
                    define('MR_ORGANIZATION_ID', $this->_mr_organization_id);
                }
            }
        }
    }

    private function _set_property() {
        if(empty($this->_property)) {
            $this->_property = $this->property_model->get_property_by_name(MR_PROJECT);
        }
    }

    private function _set_property_id() {
        if(empty($this->_property_id)) {
            $this->_set_property();

            if(!empty($this->_property)) {
                $this->_property_id = $this->_property['id'];

                if(!defined('PROPERTY_ID')) {
                    define('PROPERTY_ID', $this->_property_id);
                }
            }
        }
    }

    private function _set_preprocessor_property_id() {
        if(empty($this->_preprocessor_property_id)) {
            $this->_set_property();

            if(!empty($this->_property)) {
                $this->_preprocessor_property_id = $this->_property['preprocessor_property_id'];

                if(!defined('PREPROCESSOR_PROPERTY_ID')) {
                    define('PREPROCESSOR_PROPERTY_ID', $this->_preprocessor_property_id);
                }
            }
        }
    }

    private function _set_property_organization() {
        if(empty($this->_property_organization)) {
            $this->_property_organization = $this->organization_model->get_organization_by_property_name(MR_PROJECT);
        }
    }

    private function _set_property_organization_id() {
        if(empty($this->_property_organization_id)) {
            $this->_set_property_organization();

            if(!empty($this->_property_organization)) {
                $this->_property_organization_id = $this->_property_organization['id'];

                if(!defined('PROPERTY_ORGANIZATION_ID')) {
                    define('PROPERTY_ORGANIZATION_ID', $this->_property_organization_id);
                }
            }
        }
    }

    private function _set_case_name() {
        if (!empty($this->case_name)) {
            return $this->$this->case_name;
        }

        $this->_set_property();

        if(empty($this->_property) || empty($this->_property['case_name'])) {
            $this->case_name = FALSE;
        } else {
            $this->case_name = $this->_property['case_name'];

            if(!defined('MR_CASE_NAME')) {
                define('MR_CASE_NAME', $this->case_name);
            }
        }

        return $this->case_name;
    }

}
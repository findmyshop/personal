<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends Constants_Controller {
    protected $_data = array();

    public function __construct(){
        parent::__construct();
        /* Load all of our libs here for use in child constructors */
        $this->load->library('template_library');
        $this->_check_maintenance_lock();
        $this->_set_db_session_variables();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function _remap($method, $params = array()) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called with method = ' . $method);

        if(MR_PROJECT === 'enr' && ENVIRONMENT === 'production' && !($this->router->fetch_class() === 'login' && $this->router->fetch_method() === 'disabled')) {
            redirect('login/disabled');
        }

        if(!USER_AUTHENTICATION_REQUIRED) {
            $this->auth_library->login_anonymous_guest_user();
        }
        /* Need this because logout defaults to the above statement, so
         * we cannot rely on the is_logged_in function below for admin */
        if(is_anonymous_guest_user()) {
            if($this->router->fetch_class() == 'admin') {
                if(substr($method, 0, 4) == 'ajax') {
                    $this->_data = array(
                        'status'        => 'failure',
                        'hard_redirect' => '/' . MR_DIRECTORY . 'login?m=inactive',
                        'message'       => 'Your session has expired.'
                    );
                    echo json_encode($this->_data);
                    return;
                } else {
                    redirect('/');
                }
            }
        }
        if(!is_logged_in() &&
                ($this->router->fetch_class() !== 'login' &&
                 $this->router->fetch_class() !== 'register' &&
                 $this->router->fetch_class() !== 'video' &&
                 $this->router->fetch_class() !== 'rid'
                 )) {
            if(substr($method, 0, 4) === 'ajax') {
                $this->_data = array(
                    'status'        => 'failure',
                    'hard_redirect' => '/' . MR_DIRECTORY . 'login?m=inactive',
                    'message'       => 'You have been logged out due to inactivity.'
                );
                echo json_encode($this->_data);
                return;
            } else {
                if(MR_PROJECT === 'sbirt') {
                    if($this->router->fetch_class() !== 'courses') {
                        redirect('courses');
                    } else {
                        if(method_exists($this, $method)) {
                            return call_user_func_array(array($this, $method), $params);
                        } else {
                            show_404();
                        }
                    }
                } else {
                    redirect('login');
                }
            }
        } else {
            if(substr($method, 0, 4) == 'ajax') {
                if (!IS_AJAX) {
                    $this->_data['status'] = 'failure';
                    $this->_data['message'] = 'This page must be called with AJAX';
                    echo json_encode($this->_data);
                    return;
                }
            }
            if(method_exists($this, $method)) {
                $this->load->model('url_subdirectory_model');
                $this->url_subdirectory_model->insert(MR_DIRECTORY);
                return call_user_func_array(array($this, $method), $params);
            } else {
                show_404();
            }
        }
    }

    private function _check_maintenance_lock() {
        if(file_exists(dirname(FCPATH) . '/.maintenance_lock')) {
            if(IS_AJAX) {
                echo json_encode(array(
                    'status'        => 'failure',
                    'hard_redirect' => '/' . MR_DIRECTORY . 'login?m=maintenance',
                    'message'       => 'You have been logged out while we perform maintenance.  We will be back up as soon as possible.'
                ));
                exit;
            } else {
                show_error('We are currently performing maintenance and will be back up as soon as possible.', '503', 'Service Temporarily Unavailable');
            }
        }
    }

    private function _set_db_session_variables() {
        $this->db->query('SET @current_authenticated_user_id = ?', $this->session->userdata('account_id') ? $this->session->userdata('account_id') : 0);
    }

}
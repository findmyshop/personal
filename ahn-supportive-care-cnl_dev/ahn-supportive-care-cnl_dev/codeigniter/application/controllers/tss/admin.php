<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller_Hybrid {

    public function __construct() {
        parent::__construct();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function ajax_angular_add_user() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $data = array(
            'status'        => 'success',
            'message'        => '',
            'user'          => array()
        );

        $postdata = file_get_contents("php://input");
        $user = json_decode($postdata, TRUE);

        $_POST['first_name'] = $user['first_name'];
        $_POST['last_name'] = $user['last_name'];
        $_POST['username'] = $user['username'];
        $_POST['organization_id'] = $user['organization_id'];
        $_POST['user_type_id'] = $user['user_type_id'];
        $_POST['email'] = $user['email'];
        $_POST['password'] = $user['password'];
        $_POST['confirm_password'] = $user['confirm_password'];
        $_POST['login_enabled'] = $user['login_enabled'];

        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|min_length[3]|max_length[45]|alpha_dash');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|min_length[3]|max_length[45]|alpha_dash');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[255]|alpha_dash|is_unique[master_users.username]');
        $this->form_validation->set_rules('organization_id', 'Organization', 'required|is_natural');
        $this->form_validation->set_rules('user_type_id', 'User Type', 'required|is_natural');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        $this->form_validation->set_rules('login_enabled', 'Login Enabled', 'trim|required|is_natural');

        if($_POST['user_type_id'] == 4) {
            $this->form_validation->set_rules('username', 'Username', 'trim|required|valid_email');
            $_POST['email'] = $_POST['username'];
            $_POST['password'] = '';
        } else {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_is_valid_password_check[1]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        }

        if($this->form_validation->run() == FALSE) {
            $_POST = array();
            $data['status'] = 'failure';
            $data['message'] = validation_errors();
            log_info(__FILE__, __LINE__, __METHOD__, 'Form validation errors');
            echo json_encode($data);
            return;
        }

        $user_id = $this->user_model->insert_user(
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['username'],
            $_POST['organization_id'],
            $_POST['user_type_id'],
            $_POST['email'],
            $_POST['password'],
            $_POST['login_enabled']
        );

        if($user_id === FALSE) {
            $_POST = array();
            $data['status'] = 'failure';
            $data['message'] = 'Unable to create an account for user: ' . $_POST['username'] . '.';
            log_error(__FILE__, __LINE__, __METHOD__, 'Failure inserting user');
            echo json_encode($data);
            return;
        }

        $data['message'] = 'An account was successfuly created for user: ' . $_POST['username'] . '.';

        log_info(__FILE__, __LINE__, __METHOD__, 'Successfully inserted user_id = ' . $user_id);
        echo json_encode($data);
        return;
    }

    public function ajax_angular_edit_user() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $data = array(
            'status'        => 'success',
            'message'        => '',
            'user'          => array()
        );

        $postdata = file_get_contents("php://input");
        $user = json_decode($postdata, TRUE);

        $_POST['id'] = $user['id'];
        $_POST['first_name'] = $user['first_name'];
        $_POST['last_name'] = $user['last_name'];
        $_POST['username'] = $user['username'];
        $_POST['organization_id'] = $user['organization_id'];
        $_POST['user_type_id'] = $user['user_type_id'];
        $_POST['email'] = $user['email'];
        $_POST['password'] = isset($user['password']) ? $user['password'] : '';
        $_POST['confirm_password'] = isset($user['confirm_password']) ? $user['confirm_password'] : '';
        $_POST['login_enabled'] = $user['login_enabled'];

        // Check if the user being edited exists
        if(!($orig_user = $this->user_model->get_user($_POST['id']))) {
            $_POST = array();
            $data['status'] = 'failure';
            $data['message'] = 'User cannot be updated at this point in time.';
            log_error(__FILE__, __LINE__, __METHOD__, 'Could not find user_id = ' . $user->id . ' to edit');
            echo json_encode($data);
            return;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'User ID', 'trim|required|is_natural');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|min_length[3]|max_length[45]|alpha_dash');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|min_length[3]|max_length[45]|alpha_dash');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('organization_id', 'Organization Name', 'required|is_natural');
        $this->form_validation->set_rules('user_type_id', 'User Type', 'required|is_natural');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');

        // require a password when first changing from a user account type to a admin or site admin
        if($user['user_type_id'] != 4 && $orig_user['user_type_id'] == 4) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_is_valid_password_check[0]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        } else {
            $this->form_validation->set_rules('password', 'Password', 'trim|callback_is_valid_password_check[0]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|matches[password]');
        }

        $this->form_validation->set_rules('login_enabled', 'Login Enabled', 'trim|required|is_natural');

        if($this->form_validation->run() == FALSE) {
            $_POST = array();
            $data['status'] = 'failure';
            $data['message'] = validation_errors();
            log_info(__FILE__, __LINE__, __METHOD__, 'Form validation errors while attempting to edit user_id = ' . $user['id']);
            echo json_encode($data);
            return;
        }

        if(($this->account_id == $_POST['id']) && ($orig_user['user_type_id'] != $_POST['user_type_id'])) {
            $_POST = array();
            $data['status'] = 'failure';
            $data['message'] = 'You cannot change your user type.';
            log_info(__FILE__, __LINE__, __METHOD__, 'Attempted to change own user_type_id');
            echo json_encode($data);
            return;
        }

        if(!$this->user_model->update_user(
            $_POST['id'],
            $_POST['first_name'],
            $_POST['last_name'],
            $_POST['username'],
            $_POST['organization_id'],
            $_POST['user_type_id'],
            $_POST['email'],
            $_POST['password'],
            $_POST['login_enabled']
        ))
        {
            $_POST = array();
            $data['status'] = 'failure';
            $data['message'] = 'Error updating user';
            log_error(__FILE__, __LINE__, __METHOD__, 'Unable to edit user_id = ' . $user['id']);
            echo json_encode($data);
            return;
        }

        log_info(__FILE__, __LINE__, __METHOD__, 'Successfully edited user_id = ' . $user['id']);
        echo json_encode($data);
        return;
    }

    public function ajax_angular_export_dashboard_data_csv() {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $this->load->library('tssim_library');

        $data = array(
            'status'  => 'success',
            'message' => '',
            'file'    => FALSE
        );

        if(!is_admin() && !is_site_admin()) {
            $data['status'] = 'failure';
            $data['message'] = 'You do not have access';
            log_error(__FILE__, __LINE__, __METHOD__, 'Unauthorized request to export tssim dashboard data');
            echo json_encode($data);
            return;
        }

        $filename = 'tssim_dashboard_data_'.$this->account_id.'_'.date('Y-m-d_H-i-s').'.csv';
        $filepath = FCPATH.'tmp/'.$filename;
        $data['file'] = $filename;

        $status = FALSE;

        try {
            $status = $this->tssim_library->write_dashboard_data_to_csv_file($filepath);
        } catch(Exception $e) {
            $data['status'] = 'failure';
            $data['message'] = 'Error Writing CSV File';
            log_error(__FILE__, __LINE__, __METHOD__, 'Unable to write csv file. error = ' . $data['message']);
            echo json_encode($data);
            return;
        }

        $this->action_model->insert(Action_model::ACTION_TYPE_DASHBOARD_CSV_EXPORT);

        if($status === FALSE) {
            $data['status'] = 'failure';
            $data['message'] = 'No Records Returned... Aborting Download';
            log_info(__FILE__, __LINE__, __METHOD__, 'No records returned.  Aborting csv export');
            echo json_encode($data);
            return;
        }

        log_info(__FILE__, __LINE__, __METHOD__, 'Request successful');
        echo json_encode($data);
    }

    public function ajax_angular_get_dashboard_data() {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $this->load->library('tssim_library');

        $user_id = NULL;

        if(!is_admin() && !is_site_admin()) {
            $user_id = $this->account_id;
        }

        $dashboard_data = $this->tssim_library->get_dashboard_data($user_id);
        echo json_encode(array(
            'status'         => 'success',
            'dashboard_data' => $dashboard_data
        ));
    }

    public function ajax_angular_get_dashboard_simulation_attempt_details_data($user_id, $simulation_attempt) {
        log_debug(__FILE__, __LINE__, __METHOD__, sprintf('Called with user_id = %s | simulation_attempt = %s', $user_id, $simulation_attempt));

        $this->load->library('tssim_library');

        echo json_encode(array(
            'status'         => 'success',
            'dashboard_simulation_attempt_details_data' => $this->tssim_library->get_dashboard_simulation_attempt_details_data($user_id, $simulation_attempt)
        ));
    }

    public function ajax_angular_retake_simulation() {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $flow_attempt = $this->log_model->get_current_flow_attempt();
        $this->load->library('tssim_library');

        if($this->tssim_library->has_finished_current_flow_attempt()) {
            // increment the current flow attempt stored in master_activity logs
            $flow_attempt += 1;

            $this->log_model->insert_activity_log(
                ACTION_START,
                '',
                '',
                '',
                'retake_simulation',
                '',
                '',
                FALSE,
                $flow_attempt
            );
        }

        echo json_encode(array(
            'status'       => 'success',
            'flow_attempt' => $flow_attempt
        ));
    }

    public function index() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        if(is_admin() || is_site_admin()) {
            $this->_data['has_finished_current_flow_attempt'] = NULL;
        } else {
            $this->load->library('tssim_library');
            $this->_data['has_finished_current_flow_attempt'] = $this->tssim_library->has_finished_current_flow_attempt();
        }

        $this->template_library
            ->set_title("Dashboard")
            ->set_module('Usage')
            ->set_using_angularjs(TRUE, 'userApp')
            ->set_timeout_check_interval(60)
            ->build('admin/admin_index', $this->_data, 'admin/admin_header', 'admin/admin_dashboard');
    }

}

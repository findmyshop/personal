<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {

    protected $account_id = FALSE;
    protected $user_type = FALSE;

    public function __construct() {
        parent::__construct();

        $this->_data = array();
        $this->account_id = $this->session->userdata('account_id');
        $this->user_type = $this->session->userdata('user_type');

        $this->_log_page_views();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function index() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $this->template_library
            ->set_title("Dashboard")
            ->set_module('Usage')
            ->set_using_angularjs(TRUE, 'userApp')
            ->set_timeout_check_interval(60)
            ->build('admin/admin_index', $this->_data, 'admin/admin_header', 'admin/admin_dashboard');
    }

    public function ajax_angular_add_user() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $this->_data = array(
            'status'  => 'success',
            'message' => '',
            'user'    => array()
        );

        $postdata = file_get_contents("php://input");
        $new_user = $this->_data['user'] = json_decode($postdata);


        $_POST['first_name'] = $new_user->first_name;
        $_POST['last_name'] = $new_user->last_name;
        $_POST['username'] = $new_user->username;
        $_POST['organization_id'] = $new_user->organization_id;
        $_POST['user_type_id'] = $new_user->user_type_id;
        $_POST['email'] = $new_user->email;
        $_POST['password'] = $new_user->password;
        $_POST['confirm_password'] = $new_user->confirm_password;
        $_POST['login_enabled'] = $new_user->login_enabled;
        $_POST['organization_hierarchy_level_element_ids'] = $new_user->organization_hierarchy_level_element_ids;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|min_length[3]|max_length[45]|alpha_dash');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|min_length[3]|max_length[45]|alpha_dash');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[255]|alpha_dash|is_unique[master_users.username]');
        $this->form_validation->set_rules('organization_id', 'Organization', 'required|is_natural');
        $this->form_validation->set_rules('user_type_id', 'User Type', 'required|is_natural');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_is_valid_password_check[1]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        $this->form_validation->set_rules('login_enabled', 'Login Enabled', 'trim|required|is_natural');

        $this->load->model('organization_hierarchy_model');

        $organization_hierarchy_level_elements_error_messages = array();
        $required_organization_hierarchy_levels = $this->organization_hierarchy_model->get_required_organization_hierarchy_levels($_POST['organization_id'], $_POST['user_type_id']);
        foreach($required_organization_hierarchy_levels as $level) {
            if(!$this->organization_hierarchy_model->element_ids_arr_contains_element_in_level($_POST['organization_hierarchy_level_element_ids'], $level['id'])) {
                $organization_hierarchy_level_elements_error_messages[] = '<p>The ' . $level['name']  . ' field is required.</p>';
            }
        }

        if($this->form_validation->run() == FALSE || !empty($organization_hierarchy_level_elements_error_messages)) {
            $_POST = array();
            $this->_data['status'] = 'failure';
            $this->_data['message'] = validation_errors() . implode('', $organization_hierarchy_level_elements_error_messages);
            log_info(__FILE__, __LINE__, __METHOD__, 'Form validation errors');
            echo json_encode($this->_data);
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
            $this->_data['status'] = 'failure';
            $this->_data['message'] = 'Unable to create an account for user: ' . $_POST['username'] . '.';
            log_error(__FILE__, __LINE__, __METHOD__, 'Failure inserting user');
            echo json_encode($this->_data);
            return;
        }

        $this->organization_hierarchy_model->insert_users_organization_hierarchy_level_element_map_entries($user_id, $_POST['organization_hierarchy_level_element_ids']);

        $this->_data['message'] = 'An account was successfuly created for user: ' . $_POST['username'] . '.';

        if(LOGIN_BY_USERNAME_ENABLED) {
            $this->_data['message'] .= '  The login link for this user is <strong>' . site_url() . '~' . $_POST['username'] .'</strong>';
        }

        log_info(__FILE__, __LINE__, __METHOD__, 'Successfully inserted user_id = ' . $user_id);
        echo json_encode($this->_data);
        return;
    }

    public function ajax_angular_delete_user()
    {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $this->_data = array(
            'status'  => 'success',
            'message' => '',
        );

        $postdata = file_get_contents("php://input");
        $user = json_decode($postdata);
        $user_id = $user->id;

        // Check if the user being deleted exists
        $existing_user = $this->user_model->get_user($user_id);
        if(!$existing_user) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Could not find user_id = ' . $user_id . ' to delete');
            $this->_data['status'] = 'failure';
            $this->_data['message'] = 'User cannot not be delete at this time.';
            echo json_encode($this->_data);
            return;
        }

        if($existing_user['active'] == 0) {
            $this->_data['status'] = 'failure';
            $this->_data['message'] = 'User has already been deleted.';
            log_error(__FILE__, __LINE__, __METHOD__, 'user_id = ' . $user_id . ' already deleted');
            echo json_encode($this->_data);
            return;
        }

        if($this->account_id == $user_id) {
            $this->_data['status'] = 'failure';
            $this->_data['message'] = 'You cannot delete your own user.';
            log_info(__FILE__, __LINE__, __METHOD__, 'attempted to delete own user');
            echo json_encode($this->_data);
            return;
        }

        if(!$this->user_model->deactivate_user($user_id)) {
            $this->_data['status'] = 'failure';
            $this->_data['message'] = 'Error deleting user';
            log_error(__FILE__, __LINE__, __METHOD__, 'Unable to delete user_id = ' . $user_id);
            echo json_encode($this->_data);
            return;
        }

        log_info(__FILE__, __LINE__, __METHOD__, 'Sucessfully deleted user_id = ' . $user_id);
        echo json_encode($this->_data);
        return;
    }

    public function ajax_angular_edit_user() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $this->_data = array(
            'status'  => 'success',
            'message' => '',
            'user'    => array()
        );

        $postdata = file_get_contents("php://input");
        $user = $this->_data['user'] = json_decode($postdata);

        $_POST['id'] = $user->id;
        $_POST['first_name'] = $user->first_name;
        $_POST['last_name'] = $user->last_name;
        $_POST['username'] = $user->username;
        $_POST['organization_id'] = $user->organization_id;
        $_POST['user_type_id'] = $user->user_type_id;
        $_POST['email'] = $user->email;
        $_POST['password'] = isset($user->password) ? $user->password : '';
        $_POST['confirm_password'] = isset($user->confirm_password) ? $user->confirm_password : '';
        $_POST['login_enabled'] = $user->login_enabled;
        $_POST['organization_hierarchy_level_element_ids'] = isset($user->organization_hierarchy_level_element_ids) ? $user->organization_hierarchy_level_element_ids : array();

        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'User ID', 'trim|required|is_natural');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|min_length[3]|max_length[45]|alpha_dash');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|min_length[3]|max_length[45]|alpha_dash');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[255]');
        $this->form_validation->set_rules('organization_id', 'Organization Name', 'required|is_natural');
        $this->form_validation->set_rules('user_type_id', 'User Type', 'required|is_natural');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|callback_is_valid_password_check[0]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|matches[password]');
        $this->form_validation->set_rules('login_enabled', 'Login Enabled', 'trim|required|is_natural');

        $this->load->model('organization_hierarchy_model');

        $organization_hierarchy_level_elements_error_messages = array();

        if($this->router->method !== 'ajax_angular_edit_my_user') {
            $required_organization_hierarchy_levels = $this->organization_hierarchy_model->get_required_organization_hierarchy_levels(PROPERTY_ORGANIZATION_ID, $_POST['user_type_id']);

            foreach($required_organization_hierarchy_levels as $level) {
                if(!$this->organization_hierarchy_model->element_ids_arr_contains_element_in_level($_POST['organization_hierarchy_level_element_ids'], $level['id'])) {
                    $organization_hierarchy_level_elements_error_messages[] = '<p>The ' . $level['name']  . ' field is required.</p>';
                }
            }
        }

        if($this->form_validation->run() == FALSE || !empty($organization_hierarchy_level_elements_error_messages)) {
            $_POST = array();
            $this->_data['status'] = 'failure';
            $this->_data['message'] = validation_errors() . implode('', $organization_hierarchy_level_elements_error_messages);
            log_info(__FILE__, __LINE__, __METHOD__, 'Form validation errors while attempting to edit user_id = ' . $user->id);
            echo json_encode($this->_data);
            return;
        }

        // Check if the user being edited exists
        if(!($orig_user = $this->user_model->get_user($_POST['id']))) {
            $_POST = array();
            $this->_data['status'] = 'failure';
            $this->_data['message'] = 'User cannot be updated at this point in time.';
            log_error(__FILE__, __LINE__, __METHOD__, 'Could not find user_id = ' . $user->id . ' to edit');
            echo json_encode($this->_data);
            return;
        }

        if(($this->account_id == $_POST['id']) && ($orig_user['user_type_id'] != $_POST['user_type_id'])) {
            $_POST = array();
            $this->_data['status'] = 'failure';
            $this->_data['message'] = 'You cannot change your user type.';
            log_info(__FILE__, __LINE__, __METHOD__, 'Attempted to change own user_type_id');
            echo json_encode($this->_data);
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
            $this->_data['status'] = 'failure';
            $this->_data['message'] = 'Error updating user';
            log_error(__FILE__, __LINE__, __METHOD__, 'Unable to edit user_id = ' . $user->id);
            echo json_encode($this->_data);
            return;
        }

        $this->organization_hierarchy_model->update_users_organization_hierarchy_level_element_map_entries($_POST['id'], $_POST['organization_hierarchy_level_element_ids']);

        log_info(__FILE__, __LINE__, __METHOD__, 'Successfully edited user_id = ' . $user->id);
        echo json_encode($this->_data);
        return;
    }

    public function ajax_angular_edit_my_user() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $postdata = file_get_contents("php://input");
        $user = json_decode($postdata);
        $_POST['username'] = $user->username;
        $_POST['current_password'] = (isset($user->current_password)) ? $user->current_password : NULL;

        $this->load->library('form_validation');
        $this->form_validation->set_rules('current_password', 'Current Password', 'required|callback_current_password_check');

        if($this->form_validation->run() == FALSE)
        {
            log_info(__FILE__, __LINE__, __METHOD__, 'Form validation error');

            $_POST = array();
            echo json_encode(array(
                'status'    => 'failure',
                'message'   => validation_errors()
            ));
            return;
        }

        $this->ajax_angular_edit_user();
    }

    public function ajax_angular_export_activity_log() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $this->load->model('log_model');

        $this->_data = array(
                'status'            => 'success',
                'message'           => '',
                'file'              => FALSE,
                'search_start_date' => FALSE,
                'search_end_date'   => FALSE,
                'search_keyword'    => FALSE
        );

        if (!is_admin()) {
            $this->_data['status'] = 'failure';
            $this->_data['message'] = 'You do not have access';
            log_error(__FILE__, __LINE__, __METHOD__, 'Unauthorized request to export activity logs');
            echo json_encode($this->_data);
            return;
        }

        $postdata = file_get_contents("php://input");;
        $post_variables = json_decode($postdata, true);

        if(!isset($post_variables['mr_project_filter'])) {
            $post_variables['mr_project_filter'] = 'all';
        }

        if(!isset($post_variables['language_filter'])) {
            $post_variables['language_filter'] = 'all';
        }

        $this->_data['mr_project_filter'] = $this->_resolve_mr_project_filter($post_variables['mr_project_filter']);
        $this->_data['language_filter'] = $this->_resolve_language_filter($post_variables['language_filter']);
        $this->_data['search_start_date'] = $post_variables['search_start_date'];
        $this->_data['search_end_date'] = $post_variables['search_end_date'];
        $this->_data['search_keyword'] = $post_variables['search_keyword'];
        $this->_data['organization_hierarchy_level_elements_filter'] = isset($post_variables['organization_hierarchy_level_elements_filter']) ? $post_variables['organization_hierarchy_level_elements_filter'] : array();
        $this->_data['user_id_filter'] = isset($post_variables['user_id_filter']) ? $post_variables['user_id_filter'] : array();

        $filename = 'activity_log_export_'.$this->account_id.'_'.date("Y-m-d_H-i-s").'.csv';
        $filepath = FCPATH.'tmp/'.$filename;
        $this->_data['file'] = $filename;

        $status = FALSE;

        try {
            $this->load->library('log_library');
            $status = $this->log_library->write_activity_logs_to_csv_file($this->_data['mr_project_filter'], $this->_data['language_filter'], $this->_data['search_keyword'], $this->_data['search_start_date'], $this->_data['search_end_date'], $this->_data['organization_hierarchy_level_elements_filter'], $this->_data['user_id_filter'], $filepath);
        } catch(Exception $e) {
            $this->_data['status'] = 'failure';
            $this->_data['message'] = 'Error Writing CSV File';
            log_error(__FILE__, __LINE__, __METHOD__, 'Unable to write csv file. error = ' . $this->_data['message']);
            echo json_encode($this->_data);
            return;
        }

        $this->action_model->insert(Action_model::ACTION_TYPE_ACTIVITY_LOGS_CSV_EXPORT);

        if($status === FALSE) {
            $this->_data['status'] = 'failure';
            $this->_data['message'] = 'No Records Returned... Aborting Download';
            log_info(__FILE__, __LINE__, __METHOD__, 'No records returned.  Aborting csv export');
            echo json_encode($this->_data);
            return;
        }

        log_info(__FILE__, __LINE__, __METHOD__, 'Request successful');
        echo json_encode($this->_data);
    }

    public function ajax_angular_export_csv() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $this->_data = array(
            'status'        => 'success',
            'message'        => '',
        );

        if(!is_admin() && !is_site_admin()) {
            $this->_data['status'] = 'failure';
            $this->_data['message'] = 'You do not have access';
            log_error(__FILE__, __LINE__, __METHOD__, 'Unauthorized request for csv file export');
            echo json_encode($this->_data);
            return;
        }

        $postdata = file_get_contents("php://input");
        $post_variables = json_decode($postdata, true);

        $this->load->library('csv_library');
        $filename = $this->csv_library->create_csv($post_variables['data'], $this->account_id);

        $report_type = (isset($post_variables['report_type'])) ? $post_variables['report_type'] : NULL;
        switch($report_type) {
            case 'users':
                $this->action_model->insert(Action_model::ACTION_TYPE_USERS_CSV_EXPORT);
                break;

            default:
                break;
        }

        $this->_data['file'] = $filename;
        $this->_data['report_type'] = $post_variables['report_type'];

        log_info(__FILE__, __LINE__, __METHOD__, 'Request successful');
        echo json_encode($this->_data);
    }

    public function ajax_angular_export_session_spreadsheet() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $data = array(
            'status'  => 'success',
            'message' => '',
            'file'    => ''
        );

        if (!is_admin() && !is_site_admin()) {
            $data['status'] = 'failure';
            $data['message'] = 'You do not have access';
            log_error(__FILE__, __LINE__, __METHOD__, 'Unauthorized request for session spreadsheet');
            echo json_encode($data);
            return;
        }

        $postdata = file_get_contents("php://input");;
        $post_variables = json_decode($postdata, true);

        $mr_project_filter = $this->_resolve_mr_project_filter($post_variables['mr_project_filter']);
        $organization_hierarchy_level_elements_filter = isset($post_variables['organization_hierarchy_level_elements_filter']) ? $post_variables['organization_hierarchy_level_elements_filter'] : array();
        $user_id_filter = isset($post_variables['user_id_filter']) ? $post_variables['user_id_filter'] : array();

        $filename = 'session_spreadsheet_'.$this->account_id.'_'.date("Y-m-d_H-i-s").'.xlsx';
        $filepath = FCPATH.'tmp/'.$filename;
        $data['file'] = $filename;

        $this->load->library('session_spreadsheet_library');
        $this->session_spreadsheet_library->write_to_file($mr_project_filter, $organization_hierarchy_level_elements_filter, $user_id_filter, $filepath);
        log_info(__FILE__, __LINE__, __METHOD__, 'Request successful');
        echo json_encode($data);
    }

    public function ajax_angular_get_usage_data() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $this->_data = array(
                'status'  => 'success',
                'message' => '',
                'user'    => array()
        );

        $post_data = file_get_contents("php://input");
        $params = $this->_data['session_id'] = json_decode($post_data, TRUE);

        $mr_project_filter = $this->_resolve_mr_project_filter($params['mr_project_filter']);
        $organization_hierarchy_level_elements_filter = isset($params['organization_hierarchy_level_elements_filter']) ? $params['organization_hierarchy_level_elements_filter'] : array();
        $user_id_filter = isset($params['user_id_filter']) ? $params['user_id_filter'] : array();

        $this->load->model('session_speaker_selection_model');
        $this->load->model('processed_sessions_model');
        $this->_data['usage_data']['usage_summary'] = $this->log_model->get_usage_summary($mr_project_filter, $organization_hierarchy_level_elements_filter, $user_id_filter);
        $this->_data['usage_data']['modified_usage_summary'] = $this->processed_sessions_model->get_usage_summary($mr_project_filter, $organization_hierarchy_level_elements_filter, $user_id_filter);
        $this->_data['usage_data']['most_frequently_asked_questions'] = $this->log_model->get_most_frequently_asked_questions($mr_project_filter, $organization_hierarchy_level_elements_filter, $user_id_filter);
        $this->_data['usage_data']['sessions_summary'] = $this->log_model->get_sessions_summary($mr_project_filter, $organization_hierarchy_level_elements_filter, $user_id_filter);
        $this->_data['usage_data']['modified_sessions_summary'] = $this->processed_sessions_model->get();
        $this->_data['usage_data']['session_speaker_selections'] = $this->session_speaker_selection_model->get_stats(PROPERTY_ID);
        $this->_data['usage_data']['session_count_frequencies'] = $this->log_model->get_session_count_frequencies($mr_project_filter);
        $this->_data['usage_data']['modified_session_count_frequencies'] = $this->log_model->get_modified_session_count_frequencies($mr_project_filter);

        // determine modified_sessions_summary_graph_data
        $start_date = date('Y-m-d');
        $end_date = $start_date;

        if(!empty($this->_data['usage_data']['modified_sessions_summary'])) {
            $datetimes = array_column($this->_data['usage_data']['modified_sessions_summary'], 'start_datetime');
            sort($datetimes);
            $start_date = date('Y-m-d', strtotime($datetimes[0]));
            unset($datetimes);
        }

        $modified_sessions_summary_graph_data = array();

        while($start_date <= $end_date) {
            $modified_sessions_summary_graph_data[$start_date] = array($start_date, 0);
            $start_date = date('Y-m-d',strtotime($start_date . '+1 days'));
        }

        foreach($this->_data['usage_data']['modified_sessions_summary'] as $row) {
            $date = date('Y-m-d', strtotime($row['start_datetime']));
            $modified_sessions_summary_graph_data[$date][1]++;
        }

        $this->_data['usage_data']['modified_sessions_summary_graph_data'] = array_values($modified_sessions_summary_graph_data);

        if(SHOW_RESPONSES_VIEWED_DATA) {
            $this->_data['usage_data']['responses_data'] = $this->log_model->get_responses_data($mr_project_filter, $organization_hierarchy_level_elements_filter, $user_id_filter);

            if(SHOW_RESPONSES_VIEWED_PER_CATEGORY_DATA) {
                $this->load->model('response_category_model');
                $this->_data['usage_data']['responses_data']['per_category'] = $this->response_category_model->get_view_counts();
            }
        }

        log_info(__FILE__, __LINE__, __METHOD__, 'Request successful');
        echo json_encode($this->_data);
    }

    public function ajax_angular_get_session_detail() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $this->_data = array(
                'status'  => 'success',
                'message' => '',
                'user'    => array()
        );

        $postdata = file_get_contents("php://input");
        $params = $this->_data['session_id'] = json_decode($postdata);
        $this->_data['session_detail'] = $this->log_model->get_session_detail($params->session_id);
        log_info(__FILE__, __LINE__, __METHOD__, 'Request successful');
        echo json_encode($this->_data);
    }

    public function ajax_angular_get_modified_session_detail() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $this->_data = array(
                'status'        => 'success',
                'message'        => '',
                'user'          => array()
        );

        $postdata = file_get_contents("php://input");
        $params = $this->_data['id'] = json_decode($postdata);
        $this->load->model('processed_sessions_model');
        $this->_data['session_detail'] = $this->processed_sessions_model->get_session_detail($params->processed_session_id);
        log_info(__FILE__, __LINE__, __METHOD__, 'Request successful');
        echo json_encode($this->_data);
    }

    public function ajax_angular_get_my_user() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');
        $this->_data = array(
            'status'        => 'success',
            'message'       => 'Information has been updated.',
            'organizations' => $this->organization_model->get_organizations_summary(),
            'user'          => $this->user_model->get_user_combined($this->account_id),
            'user_types'    => $this->user_model->get_user_types($this->user_type, 1),
        );
        $this->_data['user']['user_type_name'] = $this->_data['user']['type_name'];
        log_info(__FILE__, __LINE__, __METHOD__, 'Request successful');
        echo json_encode($this->_data);
    }

    public function ajax_angular_get_users() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $this->_data = array(
            'status'     => 'success',
            'message'    => '',
            'users'      => array(),
            'user_types' => array(),
        );

        if(!is_admin() && !is_site_admin()) {
            $this->_data['status'] = 'failure';
            $this->_data['message'] = 'You do not have access';
            log_error(__FILE__, __LINE__, __METHOD__, 'Unauthorized request for users data');
            echo json_encode($this->_data);
            return;
        }

        $postdata = file_get_contents("php://input");
        $postdata_decoded = json_decode($postdata);

        $search = $postdata_decoded->search;
        $organization_hierarchy_level_elements_filter = isset($postdata_decoded->organization_hierarchy_level_elements_filter) ? $postdata_decoded->organization_hierarchy_level_elements_filter : array();

        if(is_site_admin()) {
            $this->_data['users'] = $this->user_model->get_users($this->user_type, PROPERTY_ORGANIZATION_ID, $search, $organization_hierarchy_level_elements_filter);
        } else {
            $this->_data['users'] = $this->user_model->get_users($this->user_type, FALSE, $search, $organization_hierarchy_level_elements_filter);
        }

        $this->_data['user_types'] = $this->user_model->get_user_types($this->user_type, 1);
        $this->load->model('organization_hierarchy_model');
        $this->_data['users_organization_hierarchy_level_elements_map_entries'] = $this->organization_hierarchy_model->get_users_organization_hierarchy_level_element_map_entries();

        log_info(__FILE__, __LINE__, __METHOD__, 'Request successful');
        echo json_encode($this->_data);
    }

    public function ajax_angular_get_usernames() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $data = array(
            'status'        => 'success',
            'message'       => '',
            'usernames' => array(),
        );

        if(!is_admin() && !is_site_admin()) {
            $data['status'] = 'failure';
            $data['message'] = 'You do not have access';
            log_error(__FILE__, __LINE__, __METHOD__, 'Unauthorized request for username data');
            echo json_encode($data);
            return;
        }

        $data['usernames'] = $this->user_model->get_usernames();

        log_info(__FILE__, __LINE__, __METHOD__, 'Request successful');
        echo json_encode($data);
    }

    public function download() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        if(MR_DIRECTORY === '') {
            $report_type = $this->uri->segment(3);
            $filename = FCPATH.'tmp/'.$this->uri->segment(4);
        } else {
            $report_type = $this->uri->segment(4);
            $filename = FCPATH.'tmp/'.$this->uri->segment(5);
        }

        log_info(__FILE__, __LINE__, __METHOD__, "Request for REPORT_TYPE = $report_type | FILENAME = $filename");

        // Download file to user's desktop
        if (file_exists($filename))
        {
            // IE specific stuff
            if(ini_get('zlib.output_compression'))
            {
                ini_set('zlib.output_compression', 'Off');
            }

            // get the file mime
            $this->load->helper('file');
            $mime = get_mime_by_extension($filename);

            // Build the headers
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($filename)).' GMT');
            header('Cache-Control: private', false);
            header('Content-Type: '.$mime);
            header('Content-Disposition: attachment; filename="'. $report_type . '_report.' . pathinfo($filename, PATHINFO_EXTENSION) .'"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: '.filesize($filename));
            header('Connection: close');
            readfile($filename);

            log_info(__FILE__, __LINE__, __METHOD__, "Successful request for REPORT_TYPE = $report_type | FILENAME = $filename");

            // Delete file because we won't use it again
            $success = unlink($filename);
            if (!$success)
            {
                log_error(__FILE__, __LINE__, __METHOD__, "Unable to delete | REPORT_TYPE = $report_type | FILENAME = $filename");
            }
            exit();
        }
        else
        {
            log_error(__FILE__, __LINE__, __METHOD__, "File not found | REPORT_TYPE = $report_type | FILENAME = $filename");
            show_404($filename, 'Exported CSV file not found.');
        }
    }

    public function ajax_angular_get_actions() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $data = array(
            'status'  => 'success',
            'message' => '',
            'actions' => array()
        );

        if(!is_admin()) {
            $data['status'] = 'failure';
            $data['message'] = 'You do not have access';
            log_error(__FILE__, __LINE__, __METHOD__, 'Unauthorized request for actions data');
            echo json_encode($data);
            return;
        }

        $data['actions'] = $this->action_model->get();
        log_info(__FILE__, __LINE__, __METHOD__, 'Request successful');
        echo json_encode($data);
    }

    public function ajax_angular_get_activity_logs() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $this->_data = array(
            'status'        => 'success',
            'message'       => '',
            'activity_logs' => array()
        );

        if (!is_admin()) {
            $this->_data['status'] = 'failure';
            $this->_data['message'] = 'You do not have access';
            log_error(__FILE__, __LINE__, __METHOD__, 'Unauthorized request for activity logs data');
            echo json_encode($this->_data);
            return;
        }

        // get parms passed by client
        $postdata = file_get_contents("php://input");
        $params = json_decode($postdata);

        if(!isset($params->mr_project_filter)) {
            $params->mr_project_filter = 'all';
        }

        if(!isset($params->language_filter)) {
            $params->language_filter = 'all';
        }

        $mr_project_filter = $this->_data['mr_project_filter'] = $this->_resolve_mr_project_filter($params->mr_project_filter);
        $language_filter = $this->_data['language_filter'] = $this->_resolve_language_filter($params->language_filter);
        $offset = $this->_data['offset'] = ((!isset($params->offset) ? FALSE : $params->offset));
        $number_of_rows = $this->_data['number_of_rows'] = ((!isset($params->number_of_rows) ? FALSE : $params->number_of_rows));
        $search_keyword = $this->_data['search_keyword'] = ((empty($params->search_keyword) ? FALSE : $params->search_keyword));
        $search_start_date = $this->_data['search_start_date'] = ((empty($params->search_start_date) ? FALSE : $params->search_start_date));
        $search_end_date = $this->_data['search_start_date'] = ((empty($params->search_end_date) ? FALSE : $params->search_end_date));
        $organization_hierarchy_level_elements_filter = isset($params->organization_hierarchy_level_elements_filter) ? $params->organization_hierarchy_level_elements_filter : array();
        $user_id_filter = isset($params->user_id_filter) ? $params->user_id_filter : array();

        // snag log entries based upon search criteria
        $logs = $this->_data['activity_logs'] = $this->log_model->get_activity_logs(
            $mr_project_filter,
            $language_filter,
            $offset,
            $number_of_rows,
            $search_keyword,
            $search_start_date,
            $search_end_date,
            $organization_hierarchy_level_elements_filter,
            $user_id_filter
        );

        // Get fields for filtering
        $users_in_logs = array();
        $browsers_in_logs = array();
        $actions_in_logs = array();

        if($logs !== FALSE) {
            foreach($logs as $log) {
                if(!in_array($log['username'], $users_in_logs)) {
                    array_push($users_in_logs, $log['username']);
                }

                if(isset($log['browser']) && !in_array($log['browser'], $browsers_in_logs)) {
                    array_push($browsers_in_logs, $log['browser']);
                }

                if(!in_array($log['action'], $actions_in_logs)) {
                    array_push($actions_in_logs, $log['action']);
                }
            }
        }

        $this->_data['log_users'] = $users_in_logs;
        $this->_data['log_actions'] = $actions_in_logs;
        $this->_data['log_browsers'] = $browsers_in_logs;

        log_info(__FILE__, __LINE__, __METHOD__, 'Request successful');
        echo json_encode($this->_data);
    }

    public function ajax_angular_get_term_definitions() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $this->_data = array(
            'status'           => 'success',
            'message'          => '',
            'term_definitions' => array()
        );

        if(!is_admin()) {
            $this->_data['status'] = 'failure';
            $this->_data['message'] = 'You do not have access';
            log_error(__FILE__, __LINE__, __METHOD__, 'Unauthorized request for term definitions data');
            echo json_encode($this->_data);
            return;
        }

        $this->load->model('term_definition_model');
        $this->_data['term_definitions'] = $this->term_definition_model->get_property_term_definitions();

        echo json_encode($this->_data);
    }

    public function ajax_angular_edit_term_definition() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $data = array(
            'status'          => 'success',
            'message'         => ''
        );

        $postdata = file_get_contents('php://input');
        $term_definition = json_decode($postdata, TRUE);

        $_POST['id'] = $term_definition['id'];
        $_POST['term'] = $term_definition['term'];
        $_POST['definition'] = $term_definition['definition'];
        $_POST['active'] = $term_definition['active'];

        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'Term Definition ID', 'trim|required|is_natural');
        $this->form_validation->set_rules('term', 'Term', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('definition', 'Definition', 'trim|required');
        $this->form_validation->set_rules('active', 'Active', 'required');

        if($this->form_validation->run() == FALSE) {
            $_POST = array();
            $data['status'] = 'failure';
            $data['message'] = validation_errors();
            log_info(__FILE__, __LINE__, __METHOD__, 'Form validation errors while attempting to edit term_definition_id = ' . $term_definition['id']);
            echo json_encode($data);
            return;
        }

        $this->load->model('term_definition_model');
        $this->term_definition_model->update_term_definition($_POST['id'], $_POST['term'], $_POST['definition'], $_POST['active']);

        echo json_encode($data);
    }

    public function ajax_angular_insert_term_definition() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $data = array(
            'status'             => 'success',
            'message'            => ''
        );

        $postdata = file_get_contents('php://input');
        $term_definition = json_decode($postdata, TRUE);

        $_POST['term'] = $term_definition['term'];
        $_POST['definition'] = $term_definition['definition'];
        $_POST['active'] = $term_definition['active'];

        $this->load->library('form_validation');
        $this->form_validation->set_rules('term', 'Term', 'trim|required|max_length[128]');
        $this->form_validation->set_rules('definition', 'Definition', 'trim|required');
        $this->form_validation->set_rules('active', 'Active', 'required');

        if($this->form_validation->run() == FALSE) {
            $_POST = array();
            $data['status'] = 'failure';
            $data['message'] = validation_errors();
            log_info(__FILE__, __LINE__, __METHOD__, 'Form validation errors while attempting to insert term_definition_id');
            echo json_encode($data);
            return;
        }

        $this->load->model('term_definition_model');
        $this->term_definition_model->insert_term_definition(PROPERTY_ID, $_POST['term'], $_POST['definition'], $_POST['active']);

        echo json_encode($data);
    }

    public function ajax_angular_get_organizations() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $this->_data = array(
            'status'        => 'success',
            'message'       => '',
            'organizations' => array()
        );

        if (!is_admin() && !is_site_admin())
        {
            $this->_data['status'] = 'failure';
            $this->_data['message'] = 'You do not have access';
            log_error(__FILE__, __LINE__, __METHOD__, 'Unauthorized request for organizations data');
            echo json_encode($this->_data);
            return;
        }

        if(is_site_admin()) {
            $this->_data['organizations'] = $this->organization_model->get_organizations($this->account_id);
        } else {
            $this->_data['organizations'] = $this->organization_model->get_organizations();
        }

        $this->load->model('organization_hierarchy_model');
        $this->_data['organization_hierarchy_levels']['all']                            = $this->organization_hierarchy_model->get_organization_hierarchy_levels();
        $this->_data['organization_hierarchy_level_elements']['all']            = $this->organization_hierarchy_model->get_organization_hierarchy_level_elements();
        $this->_data['organization_hierarchy_levels']['current']                    = $this->organization_hierarchy_model->get_organization_hierarchy_levels(PROPERTY_ORGANIZATION_ID);
        $this->_data['organization_hierarchy_level_elements']['current']    = $this->organization_hierarchy_model->get_organization_hierarchy_level_elements(PROPERTY_ORGANIZATION_ID);
        $this->_data['assigned_organization_hierarchy_level_elements']      = $this->organization_hierarchy_model->get_assigned_organization_hierarchy_level_element_ids($this->account_id);
        $this->_data['user_type_organization_hierarchy_level_map']              = $this->organization_hierarchy_model->get_user_type_organization_hierarchy_level_map();

        log_info(__FILE__, __LINE__, __METHOD__, 'Request successful');
        echo json_encode($this->_data);
    }

    public function ajax_angular_get_organization_hierarchy() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $data = array(
            'status'    => 'success',
            'message'   => ''
        );

        $this->load->model('organization_hierarchy_model');

        $data['organization_hierarchy_levels'] = $this->organization_hierarchy_model->get_organization_hierarchy_levels(PROPERTY_ORGANIZATION_ID);
        $data['organization_hierarchy_level_elements'] = $this->organization_hierarchy_model->get_organization_hierarchy_level_elements(PROPERTY_ORGANIZATION_ID);

        log_info(__FILE__, __LINE__, __METHOD__, 'Request successful');
        echo json_encode($data);
    }

    public function profile() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');
        $this->template_library
            ->set_title("Dashboard")
            ->set_module('Profile')
            ->set_using_angularjs(TRUE, 'userApp')
            ->set_timeout_check_interval(60)
            ->build('admin/admin_index', $this->_data, 'admin/admin_header', 'admin/admin_profile');
    }

    public function actions() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        if(!is_admin()) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Unauthorized request for actions page');
            show_error('You are not authorized to view this page.', '401', 'Unauthorized Access');
        }

        $this->template_library
            ->set_title("Dashboard")
            ->set_module('Admin Actions')
            ->set_using_angularjs(TRUE, 'userApp')
            ->set_timeout_check_interval(60)
            ->build('admin/admin_index', $this->_data, 'admin/admin_header', 'admin/admin_actions');
    }

    public function activity_logs() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        if(!is_admin()) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Unauthorized request for activity logs page');
            show_error('You are not authorized to view this page.', '401', 'Unauthorized Access');
        }

        $this->template_library
            ->set_title("Dashboard")
            ->set_module('Activity')
            ->set_using_angularjs(TRUE, 'userApp')
            ->set_timeout_check_interval(60)
            ->build('admin/admin_index', $this->_data, 'admin/admin_header', 'admin/admin_activity_logs');
    }

    public function term_definitions() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        if(!is_admin()) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Unauthorized request for term_definitions page');
            show_error('You are not authorized to view this page.', '401', 'Unauthorized Access');
        }

        $this->template_library
            ->set_title("Dashboard")
            ->set_module('Term Definitions')
            ->set_using_angularjs(TRUE, 'userApp')
            ->set_timeout_check_interval(60)
            ->build('admin/admin_index', $this->_data, 'admin/admin_header', 'admin/admin_term_definitions');
    }

    public function users() {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $this->template_library
            ->set_title("Dashboard")
            ->set_module('Users')
            ->set_using_angularjs(TRUE, 'userApp')
            ->set_timeout_check_interval(60)
            ->build('admin/admin_index', $this->_data, 'admin/admin_header', 'admin/admin_users');
    }

    // form validation checks
    public function current_password_check() {
        if(!$this->user_model->get_user_given_login_credentials($this->input->post('username'), $this->input->post('current_password'))) {
            $this->form_validation->set_message('current_password_check', 'Invalid current password entered.');
            return FALSE;
        }

        return TRUE;
    }

    public function is_valid_password_check($password, $password_required = 1) {
        $this->load->model('password_rule_model');

        if(!$password_required && empty($password)) {
            return TRUE;
        }

        if(!$this->password_rule_model->is_valid_password($password)) {
            $this->form_validation->set_message('is_valid_password_check', $this->password_rule_model->get_form_validation_error_message());
            return FALSE;
        }

        return TRUE;
    }

    protected function _log_page_views() {
        if(is_logged_in()) {
            switch($this->router->fetch_method()) {
                case 'index':
                    $this->action_model->insert(Action_model::ACTION_TYPE_DASHBOARD_VIEW);
                    break;

                case 'users':
                    $this->action_model->insert(Action_model::ACTION_TYPE_USERS_VIEW);
                    break;

                case 'activity_logs':
                    $this->action_model->insert(Action_model::ACTION_TYPE_ACTIVITY_LOGS_VIEW);
                    break;

                case 'reports':
                    $this->action_model->insert(Action_model::ACTION_TYPE_REPORTS_VIEW);
                    break;

                case 'statistics':
                    $this->action_model->insert(Action_model::ACTION_TYPE_STATISTICS_VIEW);
                    break;

                default:
                    break;
            }
        }
    }

    protected function _resolve_language_filter($language_filter) {
        return (empty($language_filter) || $language_filter === 'all') ? FALSE : $language_filter;
    }

    protected function _resolve_mr_project_filter($mr_project_filter) {
        if(HAS_MULTIPLE_MR_DIRECTORIES) {
            $mr_project_filter = (empty($mr_project_filter) || $mr_project_filter === 'all') ? FALSE : $mr_project_filter;
        } else {
            $mr_project_filter = (empty($mr_project_filter) || $mr_project_filter === 'all') ? MR_PROJECT : $mr_project_filter;
        }

        return (empty($mr_project_filter) || $mr_project_filter === 'all') ? FALSE : $mr_project_filter;
    }

}

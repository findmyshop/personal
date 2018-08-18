<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Login_Controller_Hybrid {

    protected $school_organization_hierarchy_level = NULL;
    protected $course_organization_hierarchy_level = NULL;

    public function __construct() {
        parent::__construct();

        $this->load->model('organization_hierarchy_model');

        foreach($this->organization_hierarchy_model->get_organization_hierarchy_levels(PROPERTY_ORGANIZATION_ID) as $level) {
            if($level['organization_hierarchy_level_name'] === 'School') {
                $this->school_organization_hierarchy_level = $level;
            } else if($level['organization_hierarchy_level_name'] === 'Course') {
                $this->course_organization_hierarchy_level = $level;
            }
        }

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    /**
     * Link used in Pitt's Moodle to launch the experience as a student
     *
     * GET request with the following required parameters
     * ---------------------------------------------------
     * 1. user_id
     * 2. user_first_name
     * 3. user_last_name
     * 4. school_id
     * 5. school_name
     * 6. course_id
     * 7. course_name
     *
     * Example URL
     * -----------
     * https://www.pgh-sbirt-ebi.com/login/launch_student?user_id=1&user_first_name=John&user_last_name=Doe&school_id=1&school_name=University%20of%20Pittsburgh&course_id=1&course_name=Test%20Course
     */
    public function launch_student() {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $required_params = array(
            'user_id',
            'user_first_name',
            'user_last_name',
            'school_id',
            'school_name',
            'course_id',
            'course_name'
        );

        // check to make sure all required parameters were passed
        foreach($required_params as $param) {
            if(!isset($_GET[$param]) || empty($_GET[$param])) {
                $message = sprintf('%s are all required parameters', implode(', ', $required_params));
                show_error($message, 400);
                return;
            }
        }

        $third_party_user_id = trim($_GET['user_id']);
        $user_first_name = trim($_GET['user_first_name']);
        $user_last_name = trim($_GET['user_last_name']);
        $username = sprintf('student_%s', $third_party_user_id);
        $school_id = trim($_GET['school_id']);
        $school_name = trim($_GET['school_name']);
        $course_id = trim($_GET['course_id']);
        $course_name = trim($_GET['course_name']);

        // fetch or insert a user record for the student
        $student = $this->user_model->get_user_by_username($username);

        if(!empty($student)) {
            $user_id = $student['id'];
        } else {
            $user_id = $this->user_model->insert_user(
                $user_first_name,         // last_name
                $user_last_name,          // first_name
                $username,                // username
                PROPERTY_ORGANIZATION_ID, // organization_id
                4,                        // user_type_id
                '',                       // email
                random_string(),          // password
                1                         // login_enabled
            );
        }

        // fetch or insert school organization hierarchy record
        $school_organization_hierarchy_level_element_third_party_id = sprintf('school_%s', $school_id);
        $school = $this->organization_hierarchy_model->get_organization_hierarchy_level_element_by_third_party_id(PROPERTY_ORGANIZATION_ID, $this->school_organization_hierarchy_level['organization_hierarchy_level_id'], $school_organization_hierarchy_level_element_third_party_id);

        if(!empty($school)) {
            $school_organization_hierarchy_level_element_id = $school['id'];
        } else {
            $school_organization_hierarchy_level_element_id = $this->organization_hierarchy_model->insert_organization_hierarchy_level_element($this->school_organization_hierarchy_level['organization_hierarchy_level_id'], NULL, $school_organization_hierarchy_level_element_third_party_id, $school_name);
        }

        // fetch or insert course organization hierarchy record
        $course_organization_hierarchy_level_element_third_party_id = sprintf('course_%s', $course_id);
        $course = $this->organization_hierarchy_model->get_organization_hierarchy_level_element_by_third_party_id(PROPERTY_ORGANIZATION_ID, $this->course_organization_hierarchy_level['organization_hierarchy_level_id'], $course_organization_hierarchy_level_element_third_party_id);

        if(!empty($course)) {
            $course_organization_hierarchy_level_element_id = $course['id'];
        } else {
            $course_organization_hierarchy_level_element_id = $this->organization_hierarchy_model->insert_organization_hierarchy_level_element($this->course_organization_hierarchy_level['organization_hierarchy_level_id'], $school_organization_hierarchy_level_element_id, $course_organization_hierarchy_level_element_third_party_id, $course_name);
        }

        // associate this student with this school and course
        $this->organization_hierarchy_model->update_users_organization_hierarchy_level_element_map_entries($user_id, array($school_organization_hierarchy_level_element_id, $course_organization_hierarchy_level_element_id));

        /* debugging code
        pp(array(
            'user_id' => $user_id,
            'school_organization_hierarchy_level_element_id' => $school_organization_hierarchy_level_element_id,
            'course_organization_hierarchy_level_element_id' => $course_organization_hierarchy_level_element_id
        ));
        */

        // force login
        $this->auth_library->login_by_id($user_id);

        // redirect
        redirect('/');
    }

    /**
     * Link used in Pitt's Moodle to launch the admin interface as a course admin
     *
     * GET request with the following required parameters
     * ---------------------------------------------------
     * 1. user_id
     * 2. user_first_name
     * 3. user_last_name
     * 4. school_id[]
     * 5. school_name[]
     * 6. course_id[]
     * 7. course_name[]
     *
     * The school_id, school_name, course_id, and course_name parameters must have the same number of elements and the ordering is important.
     * school_name[0] should contain the school name for school_id[0] and course_name[0] should contain the course name for course_id[0] which should be associated with school_id[0].
     * Similarly, school_name[1] should contain the school name for school_id[1] and course_name[1] should contain the course name for course_id[1] which should be associated with school_id[1].
     *
     * Example URL
     * -----------
     * https://www.pgh-sbirt-ebi.com/login/launch_course_admin?user_id=1&user_first_name=Course&user_last_name=Admin&school_id[]=1&school_name[]=University%20of%20Miami&course_id[]=1&course_name[]=Miami%20Test%20Course
     */
    public function launch_course_admin() {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $required_params = array(
            'user_id',
            'user_first_name',
            'user_last_name',
            'school_id',
            'school_name',
            'course_id',
            'course_name'
        );

        // check to make sure all required parameters were passed
        foreach($required_params as $param) {
            if(!isset($_GET[$param]) || empty($_GET[$param])) {
                $message = sprintf('%s are all required parameters', implode(', ', $required_params));
                show_error($message, 400);
                return;
            }
        }

        if(!is_array($_GET['school_id']) || !is_array($_GET['school_name']) || !is_array($_GET['course_id']) || !is_array($_GET['course_name'])) {
            show_error('The school_id, school_name, course_id, and course_name parameters should be passed as arrays', 400);
            return;
        }

        if(count($_GET['school_id']) !== count($_GET['school_name']) || count($_GET['course_id']) !== count($_GET['course_name']) || count($_GET['school_id']) !== count($_GET['course_id'])) {
            show_error('The school_id, school_name, course_id, and course_name parameter arrays should contain an equal number of members', 400);
            return;
        }

        if(count($_GET['school_id']) < 1 || count($_GET['school_name']) < 1 || count($_GET['course_id']) < 1 || count($_GET['course_name']) < 1) {
            show_error('The school_id, school_name, course_id, and course_name parameter arrays should each contain at least one element', 400);
            return;
        }

        $third_party_user_id = trim($_GET['user_id']);
        $user_first_name = trim($_GET['user_first_name']);
        $user_last_name = trim($_GET['user_last_name']);
        $username = sprintf('course_admin_%s', $third_party_user_id);
        $school_ids = array_map('trim', $_GET['school_id']);
        $school_names = array_map('trim', $_GET['school_name']);
        $course_ids = array_map('trim', $_GET['course_id']);
        $course_names = array_map('trim', $_GET['course_name']);

        // fetch or insert a user record for the course admin
        $course_admin = $this->user_model->get_user_by_username($username);

        if(!empty($course_admin)) {
            $user_id = $course_admin['id'];
        } else {
            $user_id = $this->user_model->insert_user(
                $user_first_name,         // last_name
                $user_last_name,          // first_name
                $username,                // username
                PROPERTY_ORGANIZATION_ID, // organization_id
                2,                        // user_type_id
                '',                       // email
                random_string(),          // password
                1                         // login_enabled
            );
        }

        $organization_hierarchy_level_element_ids = array();

        // fetch or insert school and course organization hierarchy records
        for($i = 0; $i < count($school_ids); $i++) {
            // fetch or insert school organization hierarchy record
            $school_organization_hierarchy_level_element_third_party_id = sprintf('school_%s', $school_ids[$i]);
            $school = $this->organization_hierarchy_model->get_organization_hierarchy_level_element_by_third_party_id(PROPERTY_ORGANIZATION_ID, $this->school_organization_hierarchy_level['organization_hierarchy_level_id'], $school_organization_hierarchy_level_element_third_party_id);

            if(!empty($school)) {
                $school_organization_hierarchy_level_element_id = $school['id'];
            } else {
                $school_organization_hierarchy_level_element_id = $this->organization_hierarchy_model->insert_organization_hierarchy_level_element($this->school_organization_hierarchy_level['organization_hierarchy_level_id'], NULL, $school_organization_hierarchy_level_element_third_party_id, $school_names[$i]);
            }

            $organization_hierarchy_level_element_ids[] = $school_organization_hierarchy_level_element_id;

            // fetch or insert course organization hierarchy record
            $course_organization_hierarchy_level_element_third_party_id = sprintf('course_%s', $course_ids[$i]);
            $course = $this->organization_hierarchy_model->get_organization_hierarchy_level_element_by_third_party_id(PROPERTY_ORGANIZATION_ID, $this->course_organization_hierarchy_level['organization_hierarchy_level_id'], $course_organization_hierarchy_level_element_third_party_id);

            if(!empty($course)) {
                $course_organization_hierarchy_level_element_id = $course['id'];
            } else {
                $course_organization_hierarchy_level_element_id = $this->organization_hierarchy_model->insert_organization_hierarchy_level_element($this->course_organization_hierarchy_level['organization_hierarchy_level_id'], $school_organization_hierarchy_level_element_id, $course_organization_hierarchy_level_element_third_party_id, $course_names[$i]);
            }

            $organization_hierarchy_level_element_ids[] = $course_organization_hierarchy_level_element_id;
        }

        // associate this course admin with these schools and courses
        $this->organization_hierarchy_model->update_users_organization_hierarchy_level_element_map_entries($user_id, $organization_hierarchy_level_element_ids);

        /* debugging code
        pp(array(
            'user_id' => $user_id,
            'organization_hierarchy_level_element_ids' => $organization_hierarchy_level_element_ids
        ));
        */

        // force login
        $this->auth_library->login_by_id($user_id);

        // redirect
        redirect('/admin');
    }

    /**
     * Link used in Pitt's Moodle to launch the admin interface as a school admin
     *
     * GET request with the following required parameters
     * ---------------------------------------------------
     * 1. user_id
     * 2. user_first_name
     * 3. user_last_name
     * 4. school_id[]
     * 5. school_name[]
     *
     * The school_id and school_name parameters must have the same number of elements and the ordering is important.
     * school_name[0] should contain the school name for school_id[0]. Similarly, school_name[1] should contain the school name for school_id[1].
     *
     * Example URL
     * -----------
     * https://www.pgh-sbirt-ebi.com/login/launch_school_admin?user_id=1&user_first_name=John&user_last_name=Doe&school_id[]=1&school_name[]=University%20of%20Pittsburgh
     */
    public function launch_school_admin() {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $required_params = array(
            'user_id',
            'user_first_name',
            'user_last_name',
            'school_id',
            'school_name'
        );

        // check to make sure all required parameters were passed
        foreach($required_params as $param) {
            if(!isset($_GET[$param]) || empty($_GET[$param])) {
                $message = sprintf('%s are all required parameters', implode(', ', $required_params));
                show_error($message, 400);
                return;
            }
        }

        if(!is_array($_GET['school_id']) || !is_array($_GET['school_name'])) {
            show_error('The school_id and school_name parameters should be passed as arrays', 400);
            return;
        }

        if(count($_GET['school_id']) !== count($_GET['school_name'])) {
            show_error('The school_id and school_name parameter arrays should contain an equal number of members', 400);
            return;
        }

        if(count($_GET['school_id']) < 1 || count($_GET['school_name']) < 1) {
            show_error('The school_id and school_name parameter arrays should each contain at least one element', 400);
            return;
        }

        $third_party_user_id = trim($_GET['user_id']);
        $user_first_name = trim($_GET['user_first_name']);
        $user_last_name = trim($_GET['user_last_name']);
        $username = sprintf('school_admin_%s', $third_party_user_id);
        $school_ids = array_map('trim', $_GET['school_id']);
        $school_names = array_map('trim', $_GET['school_name']);

        // fetch or insert a user record for the school admin
        $school_admin = $this->user_model->get_user_by_username($username);

        if(!empty($school_admin)) {
            $user_id = $school_admin['id'];
        } else {
            $user_id = $this->user_model->insert_user(
                $user_first_name,         // last_name
                $user_last_name,          // first_name
                $username,                // username
                PROPERTY_ORGANIZATION_ID, // organization_id
                2,                        // user_type_id
                '',                       // email
                random_string(),          // password
                1                         // login_enabled
            );
        }

        // fetch or insert school organization hierarchy records
        foreach($school_ids as $key => $school_id) {
            $school_organization_hierarchy_level_element_third_party_id = sprintf('school_%s', $school_id);
            $school = $this->organization_hierarchy_model->get_organization_hierarchy_level_element_by_third_party_id(PROPERTY_ORGANIZATION_ID, $this->school_organization_hierarchy_level['organization_hierarchy_level_id'], $school_organization_hierarchy_level_element_third_party_id);

            if(!empty($school)) {
                $school_organization_hierarchy_level_element_ids[] = $school['id'];
            } else {
                $school_organization_hierarchy_level_element_ids[] = $this->organization_hierarchy_model->insert_organization_hierarchy_level_element($this->school_organization_hierarchy_level['organization_hierarchy_level_id'], NULL, $school_organization_hierarchy_level_element_third_party_id, $school_names[$key]);
            }
        }

        // associate this school admin with these schools
        $this->organization_hierarchy_model->update_users_organization_hierarchy_level_element_map_entries($user_id, $school_organization_hierarchy_level_element_ids);

        /* debugging code
        pp(array(
            'user_id' => $user_id,
            'school_organization_hierarchy_level_element_ids' => $school_organization_hierarchy_level_element_ids
        ));
        */

        // force login
        $this->auth_library->login_by_id($user_id);

        // redirect
        redirect('/admin');
    }

}
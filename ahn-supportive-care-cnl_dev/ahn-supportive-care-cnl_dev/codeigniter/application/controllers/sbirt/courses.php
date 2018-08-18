<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('course_model');

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function index($course = NULL) {
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $project_title = $this->property_model->get_title(MR_PROJECT);

        $course_prices = array(
            'alcohol_sbirt' => array(
                'one_hour'   => $this->course_model->get_course_price('AlcoholSBIRT 1 Hour'),
                'three_hour' => $this->course_model->get_course_price('AlcoholSBIRT 3 Hour')
            ),
            'sbirt_coach'   => $this->course_model->get_course_price('SBIRTCoach')
        );

        $this->template_library
            ->set_title($project_title)
            ->set_module('Home')
            ->set_using_angularjs(TRUE, 'userApp')
            ->set_timeout_check_interval(60)
            ->build('courses/courses_index', array('course_prices' => $course_prices), 'courses/courses_header', 'courses/courses_list');
    }

    public function alcohol_sbirt() {
        $project_title = $this->property_model->get_title(MR_PROJECT);

        $course_prices = array(
            'alcohol_sbirt' => array(
                'one_hour'   => $this->course_model->get_course_price('AlcoholSBIRT 1 Hour'),
                'three_hour' => $this->course_model->get_course_price('AlcoholSBIRT 3 Hour')
            )
        );

        $this->template_library
            ->set_title($project_title)
            ->set_module('Home')
            ->set_using_angularjs(TRUE, 'userApp')
            ->set_timeout_check_interval(60)
            ->build('courses/courses_index', array('course_prices' => $course_prices), 'courses/courses_header', 'courses/courses_course_description_alcohol_sbirt');
    }

    public function sbirt_coach() {
        $project_title = $this->property_model->get_title(MR_PROJECT);

        $course_prices = array(
            'sbirt_coach'   => $this->course_model->get_course_price('SBIRTCoach')
        );

        $this->template_library
            ->set_title($project_title)
            ->set_module('Home')
            ->set_using_angularjs(TRUE, 'userApp')
            ->set_timeout_check_interval(60)
            ->build('courses/courses_index', array('course_prices' => $course_prices), 'courses/courses_header', 'courses/courses_course_description_sbirt_coach');
    }

}


 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video_Controller extends MY_Controller {

	public function __construct(){
		parent::__construct();
		$this->_data = array();
	}

	public function index(){
		$project_title = $this->property_model->get_title(MR_PROJECT);

		$this->template_library
			->set_title($project_title)
			->set_module('Home')
			->set_using_angularjs(TRUE, 'userApp')
			->set_timeout_check_interval(60)
			->build('video/video_index', $this->_data, 'video/video_header', 'video/video_content');
	}

	public function get_response(){
		$this->output->set_header('Access-Control-Allow-Headers: content-type');
		$this->output->set_header('Content-Type: application/xml');
		$this->output->set_header('Access-Control-Allow-Origin: *');

		$_GET['response_id'] = $this->input->get('response_id');

		$this->_data = array('status' => 'failure', 'message' => 'Could not load video.');

		if (isset($_GET['response_id'])){
			$this->_data['status'] = 'success';
			$this->_data['message'] = 'Video loaded.';
			$this->_data['response'] = $this->index_library->get_response($_GET['response_id']);
		}else{

		}
		echo json_encode($this->_data);

	}
}
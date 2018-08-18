<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends Base_Controller {

	public function __construct() {
		parent::__construct();
        $this->load->model('course_model');
        $this->load->model('user_model');
        
		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }
    public function ajax_angular_load_response() {
		/* We're going to hook the parent */
		$this->_is_hooked = true;
		parent::ajax_angular_load_response();

		log_info(__FILE__, __LINE__, __METHOD__, 'Request for response_id = ' . $this->_data["response"]["id"]);
        $custom_response = '';

        //If on welcome back page response is no
        if ($this->_data['response']['id'] == 'cnl355'){
            $next_id = $this->log_model->get_most_recent_activity($this->account_id, ['cnl353', 'cnl355', 'cnl354']);
            $custom_response = $next_id;
            
        //If on welcome back page response is yes
        } else if($this->_data['response']['id'] == 'cnl354'){
            if($test_activity = $this->user_model->get_user_question_responses($this->account_id)){
                $first_test = $test_activity['cnl011'];
                $res = empty($first_test['answer']);
                if(($first_test = $test_activity['cnl011']) && (!empty($first_test['answer']))){
                    //If type == 'SCLC' go to ....
                    if($first_test['answer'] == "I Don't Know"){
                        $custom_response = 'cnl032';
                    }else if($first_test['answer'] == 'Small cell lung cancer'){
                        if(($first_test_sclc = $test_activity['cnl071']) && (!empty($first_test_sclc['answer']))){
                            switch ($first_test_sclc['answer']) {
                                case "I Don't Know":
                                    $custom_response = 'cnl076';
                                    break;
                                case 'Extensive':
                                    $custom_response = 'cnl075';
                                    break;
                                case 'Limited':
                                    $custom_response = 'cnl074';
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                        }else{
                            $custom_response = 'cnl072';
                        }
                    }else if($first_test['answer'] == 'Non-small cell lung cancer'){
                        // If Type == 'NSCLC then check the stage and go there
                        if(($second_test_nsclc = $test_activity['cnl041']) && (!empty($second_test_nsclc['answer']))){
                            switch ($second_test_nsclc['answer']) {
                                case 'Stage IA':
                                    $custom_response = 'cnl042a';
                                    break;
                                case 'Stage IB':
                                    $custom_response = 'cnl042a';
                                    break;    
                                case 'Stage IIA':
                                    $custom_response = 'cnl043a';
                                    break; 
                                case 'Stage IIB':
                                    $custom_response = 'cnl043a';
                                    break;       
                                case 'Stage IIIA':
                                    $custom_response = 'cnl044a';
                                    break;    
                                case 'Stage IIIB':
                                    $custom_response = 'cnl045a';
                                    break;  
                                case "Stage IVA":
                                    $custom_response = 'cnl046a';
                                    break;  
                                case "Stage IVB":
                                    $custom_response = 'cnl046a';
                                    break;
                                case "I Don't Know":
                                    $custom_response = 'cnl047';
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                        // If type == 'NSCLC' and there isn't a stage record then go to type of non-small cell
                        }else if(($first_test_nsclc = $test_activity['cnl034']) && (!empty($first_test_nsclc['answer']))){
                            switch ($first_test_nsclc['answer']) {
                                case "I Don't Know":
                                    $custom_response = 'cnl358';
                                    break;
                                case 'Adenocarcinoma':
                                    $custom_response = 'cnl035a';
                                    break;
                                case 'Squamous cell carcinoma':
                                    $custom_response = 'cnl036a';
                                    break;
                                case 'Large cell carcinoma':
                                    $custom_response = 'cnl037a';
                                    break;
                                case 'Cancer of unknown primary origin (CUP)':
                                    $custom_response = 'cnl039a';
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                        }else{
                            $custom_response = 'cnl020a';
                        }
                    }else if($first_test['answer'] == "I don't know"){
                        $custom_response = 'cnl032';
                    }
                }else{
                    $custom_response = 'cnl011';
                }
            };
        }else if($this->_data['response']['id'] == 'cnl005'){
            if($test_activity = $this->user_model->get_user_question_responses($this->account_id)){
                $first_test = $test_activity['cnl011'];
                if($first_test['answer'] == "Small cell lung cancer"){
                    if($sclc = $test_activity['cnl071']){
                        switch ($sclc['answer']) {
                            case 'Limited':
                                $custom_response = 'cnl294';
                                break;
                            case 'Extensive':
                                $custom_response = 'cnl204';
                                break;
                            case "I Don't Know":
                                break;
                            default:
                                # code...
                                break;
                        }
                    }
                }else if($first_test['answer'] == "Non-small cell lung cancer"){
                    if($nsclc = $test_activity['cnl041']){
                        switch ($nsclc['answer']) {
                            case 'Stage IA':
                                $custom_response = 'cnl139';
                                break;
                            case 'Stage IB':
                                $custom_response = 'cnl139';
                                break;
                            case "Stage IIA":
                                $custom_response = 'cnl140';
                                break;
                            case "Stage IIB":
                                $custom_response = 'cnl140';
                                break;                                
                            case "Stage IIIA":
                                $custom_response = 'cnl154';
                                break;
                            case "Stage IIIB":
                                $custom_response = 'cnl154';
                                break;
                            case "Stage IVA":
                                $custom_response = 'cnl173';
                                break;                                
                            case "Stage IVB":
                                $custom_response = 'cnl173';
                                break; 
                            case "I Don't Know":
                                $custom_response = '';
                                break;   
                            default:
                            # code...
                                break;
                        }
                    }
                }
            }
        }else if($this->_data['response']['id'] == 'cnl210'){
            if($test_activity = $this->user_model->get_user_question_responses($this->account_id)){
                $stage_test = $test_activity['cnl041'];
                if($stage_test['answer'] == "I Don't Know"){
                    $custom_response = 'cnl098';
                }else{
                    //Path 6
                    $custom_response = 'cnl111';
                }
            }
            //If user path history is idk and not a stage go to 098
        } else if($this->_data['response']['id'] == 'cnl127'){
            if($test_activity = $this->user_model->get_user_question_responses($this->account_id)){
                $first_test = $test_activity['cnl011'];
                if($first_test['answer'] == "Small cell lung cancer"){
                    if($sclc = $test_activity['cnl071']){
                        switch ($sclc['answer']) {
                            case 'Limited':
                                $custom_response = 'cnl074';
                                break;
                            case 'Extensive':
                                $custom_response = 'cnl075';
                                break;
                            case "I Don't Know":
                                $custom_response = 'cnl076';
                                break;
                            default:
                                # code...
                                break;
                        }
                    }
                }else if($first_test['answer'] == "Non-small cell lung cancer"){
                    if($nsclc = $test_activity['cnl041']){
                        switch ($nsclc['answer']) {
                            case 'Stage IA':
                                $custom_response = 'cnl128';
                                break;
                            case 'Stage IB':
                                $custom_response = 'cnl128';
                                break;
                            case "Stage IIA":
                                $custom_response = 'cnl129';
                                break;
                            case "Stage IIB":
                                $custom_response = 'cnl129';
                                break;                                
                            case "Stage IIIA":
                                $custom_response = 'cnl130';
                                break;
                            case "Stage IIIB":
                                $custom_response = 'cnl130';
                                break;
                            case "Stage IVA":
                                $custom_response = 'cnl131';
                                break;                                
                            case "Stage IVB":
                                $custom_response = 'cnl131';
                                break; 
                            case "I Don't Know":
                                $custom_response = '';
                                break;   
                            default:
                            # code...
                                break;
                        }
                    }
                }
            }
            //Diagnosis in path 7
        }else if($this->_data['response']['id'] == 'cnl141'){
            //To path 8 or treatment path
        }else if($this->_data['response']['id'] == 'cnl125'){
            //Treatment path based on diagnosis and stage
        }
        if(!empty($custom_response)){
            $this->_data['response']['video_controls']['next_id'] = $custom_response;
        }


        echo json_encode($this->_data);

    }
    public function ajax_angular_get_user_responses() {
		/* We're going to hook the parent */

		log_info(__FILE__, __LINE__, __METHOD__, 'Called ');

        $this->_data = array(
			'status'			 => 'success',
			'message'			 => '',
			'debug' => '',
			'response'	 => array()
        );
        
        if( $test_activity = $this->user_model->get_user_question_responses($this->account_id)){
            $this->_data['response']['data'] = $test_activity;
        }

        echo json_encode($this->_data);

    }

    public function ajax_angular_update_user_responses() {
		/* We're going to hook the parent */

		log_info(__FILE__, __LINE__, __METHOD__, 'Called ');

        $this->_data = array(
			'status'			 => 'success',
			'message'			 => '',
			'debug' => '',
			'response'	 => array()
        );
        
        $postdata_string = file_get_contents("php://input");
        $postdata_decoded = json_decode($postdata_string, TRUE);
        
        $test_activity = $this->user_model->get_user_question_responses($this->account_id);
        // Iterate through the questions updating questions answers
        if($postdata_decoded['responses']){
            foreach($postdata_decoded['responses'] as $key=>$value){
                if($key == 'cnl041'){
                    if($postdata_decoded['responses']['cnl034']['answer'] != $test_activity['cnl034']['answer']){
                        $value['answer'] = '';
                    }
                }
                $question_data = array(
                    'answer' => $value['answer'],
                    'user_id' => $this->account_id,
                    'response_id' => $key
                );
                $this->user_model->update_user_question_responses($this->account_id, $key, $question_data);
            }
        }
        $this->_data['response']['response_id'] = 'cnl354';
        echo json_encode($this->_data);

    }

    public function ajax_angular_submit_response(){
        // Depending on question response_id give different response
        log_info(__FILE__, __LINE__, __METHOD__, 'Request');

        $this->_data = array(
			'status'			 => 'success',
			'message'			 => '',
			'debug' => '',
			'response'	 => array()
		);

        $postdata_string = file_get_contents("php://input");
        $postdata_decoded = json_decode($postdata_string, TRUE);

        $custom_response = '';

        if (($test_elements = $this->course_model->get_test_elements_by_response($postdata_decoded['response_id'], 0)) === FALSE) {
            echo json_encode(array(
                'status' => 'failure',
                'message' => 'Error submitting Skill Practice 4 answers.'
            ));
            return;
        }else {
            $test_element = $test_elements[0];
        }
        // retrieve the master_activity_log entry to associate with this submission
        if (($activity_log_id = $this->log_model->get_last_log_id($this->account_id)) === NULL) {
            echo json_encode(array(
                'status' => 'failure',
                'message' => 'Error submitting Skill Practice 4 answers.'
            ));
            return;
        }

        $master_user_test_activity_data = array(
            'user_id' => $this->account_id,
            'test_element_id' => $test_element['id'],
            'answer' => $postdata_decoded['question_response'],
            'response_id' => $test_element['response_id'],
            'activity_log_id' => $activity_log_id,
            'date_completed' => date('Y-m-d H:i:s')
        );

        // Check if record exists for user otherwise create new one
        $this->user_model->update_user_question_responses($this->account_id, $test_element['response_id'], $master_user_test_activity_data);

        //What type of cancer do you have
        if($postdata_decoded['response_id'] == 'cnl011'){
            switch ($postdata_decoded['question_response']) {
                case "I Don't Know":
                    $custom_response = 'cnl032';
                    break;
                case 'Non-small cell lung cancer':
                    $custom_response = 'cnl020';
                    break;
                case 'Small cell lung cancer':
                    $custom_response = 'cnl072';
                    break;
                default:
            }
        // Update user profile
        }else if($postdata_decoded['response_id'] == 'cnl353'){
            switch ($postdata_decoded['question_response']) {
                case 'Yes':
                    $this->_data['response']['update_user_profile'] = TRUE;
                    break;
                case 'No':
                    $custom_response = 'cnl355';
                    break;
            }
        }else if($postdata_decoded['response_id'] == 'cnl071'){
            switch ($postdata_decoded['question_response']) {
                case 'Limited':
                    $custom_response = 'cnl074';
                    break;
                case 'Extensive':
                    $custom_response = 'cnl075';
                    break;
                case "I Don't Know":
                    $custom_response = 'cnl076';
                    break;
            }
        }else if($postdata_decoded['response_id'] == 'cnl034'){
            switch ($postdata_decoded['question_response']) {
                case "I Don't Know":
                    $custom_response = 'cnl358';
                    break;
                case 'Adenocarcinoma':
                    $custom_response = 'cnl035a';
                    break;
                case 'Squamous cell carcinoma':
                    $custom_response = 'cnl036a';
                    break;
                case 'Large cell carcinoma':
                    $custom_response = 'cnl037a';
                    break;
                case 'Cancer of unknown primary origin (CUP)':
                    $custom_response = 'cnl039a';
                    break;
            }
        }else if($postdata_decoded['response_id'] == 'cnl041'){
            switch ($postdata_decoded['question_response']) {
                case 'Stage IA':
                    $custom_response = 'cnl042a';
                    break;
                case 'Stage IB':
                    $custom_response = 'cnl042a';
                    break;    
                case 'Stage IIA':
                    $custom_response = 'cnl043a';
                    break; 
                case 'Stage IIB':
                    $custom_response = 'cnl043a';
                    break;       
                case 'Stage IIIA':
                    $custom_response = 'cnl044a';
                    break;    
                case 'Stage IIIB':
                    $custom_response = 'cnl044b';
                    break;  
                case "Stage IVA":
                    $custom_response = 'cnl046a';
                    break;  
                case "Stage IVB":
                    $custom_response = 'cnl046a';
                    break;
                case "I Don't Know":
                    $custom_response = 'cnl047';
                    break;
                default:
                    # code...
                    break;
            }
            //Prognosis Question
        }else if($postdata_decoded['response_id'] == 'cnl123'){
            switch ($postdata_decoded['question_response']) {
                case 'Know Prognosis Information Now':
                    $custom_response = 'cnl126';
                    break;
                case 'Know Prognosis Information Later':
                    $custom_response = 'cnl124';
                    break;
                default:
                    # code...
                    break;
            }

        }else{
            $custom_response = 'cnl001';
        }

        $this->_data['response']['response_id'] = $custom_response;

        echo json_encode($this->_data);

    }

}

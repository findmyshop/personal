<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Analyzer_library
{
	private $CI = FALSE;		// CodeIgniter Global Instance
	private $ANALYZER_SESSION_ID = '1234';

	public function __construct()
	{
		$this->CI =& get_instance();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}
	/* ask_controls signifies if the question type is a question or analyze */
	public function filter_open_ended($input_question){
		/* strip appos */
		log_info(__FILE__, __LINE__, __METHOD__, 'input_question = ' . $input_question);

		$input_question = str_replace("'", '', strtolower($input_question));
		$json_file = './config/filter-open-ended.json';
			$json = file_get_contents($json_file);
			$j_array = json_decode($json, TRUE);
			foreach ($j_array as $j_key => &$j_value) {
				/* Count words in phrase */
				foreach ($j_value as $a_key => &$a_value) {
					if ($a_key == 'phrase'){
						$words = explode(' ', $a_value);
						$j_value['words'] = count($words);
					}
				}
			}
			/* Sort array so that longer words come first. */
			usort($j_array, function($a, $b) {
				return $b['words'] - $a['words'];
			});
			foreach ($j_array as $j_key => $j_value) {
				/* See if phrase exists in user string */
				if (strpos($input_question, $j_value['phrase']) === 0){
					$response = $j_value['response'];
					break;
				}else{
					$response = 'yes';
				}
			}
			return $response;
	}

	public function get_response($input_question, $case_name, $current_response, $ask_controls = false)
	{
		log_info(__FILE__, __LINE__, __METHOD__, "input_question = $input_question | case_name = $case_name | current_response = $current_response : ask_controls = $ask_controls");

		if (substr($case_name, 0, 6) == 'filter'){
			$analyzer_result = new stdClass();
			$analyzer_result->InputQuestion = $input_question;
			$analyzer_result->CaseName = $case_name;
			$analyzer_result->ResponseIDs = new stdClass();
			$analyzer_result->ResponseIDs->string = '';
			$analyzer_result->ResponseType = 'filter';
			$response_id = $this->filter_open_ended($input_question);
		}else{
			$analyzer_result = $this->analyze($input_question, $case_name);

			/*Case name issues usually */
			if (!isset($analyzer_result->status)){
				return $analyzer_result;
			}
			if ($analyzer_result->status != 'success') {
				return $analyzer_result;
			}

			$response_id = $orig_response_id = $analyzer_result->ResponseIDs->string;
		}

		/* Extra step for question response types.	We need to look at the ui.xml file and figure out which
			 INDEXED response ID correlates with the one passed from the analyzer */
		if ($this->CI->index_library->has_multiple_indexes($current_response)){
			$response_id = $this->CI->index_library->get_question_response($current_response, $response_id);
			if (!$response_id){
				$response_id = $analyzer_result->ResponseIDs->string;
			}
			/* Query a new case-name provided by question */
			if (is_array($response_id)){
				/* ToDo: This code and the above code are the same. Need to organize this. */
				$analyzer_result = $this->analyze($input_question, $response_id['case']);
				if ($analyzer_result->status != 'success') {
					return $analyzer_result;
				}
				$response_id = $orig_response_id = $analyzer_result->ResponseIDs->string;
				/* Loop again */
				if ($ask_controls == 'question'){
					$response_id = $this->CI->index_library->get_question_response($current_response, $response_id);
				}
			}
		}

		if (!isset($response_id) || $response_id == false) {
			return array('status' => 'error', 'message' => 'response_id: ['.$orig_response_id.'] does not seem to exist in ui.xml');
		}
		if ($response_info = $this->CI->index_library->get_response($response_id)) {
			$response_info['status'] = 'success';
			/* Multi Answer */
			if (isset($analyzer_result->RelatedIDs)) {
				$response_info['related_questions'] = $this->CI->index_library->get_multi_response_info($analyzer_result->RelatedIDs->string);
				$response_info['type'] = "MA";
			}
			/* Set the original CaseName if it has one */
			if (isset($analyzer_result->CaseName)) {
				$response_info['logged_case_name'] = $analyzer_result->CaseName;
			}
			return $response_info;
		}else{
			return array('status' => 'error', 'message' => 'response_id: ['.$response_id.'] does not seem to exist in index.xml');
		}
		return array('status' => 'error', 'message' => 'Something is not working.');
	}

	public function analyze($input_question, $case_name) {
		log_info(__FILE__, __LINE__, __METHOD__, "input_question = $input_question | case_name = $case_name");

		// Initialize analyzer
		if (ENVIRONMENT == 'production'){
			//$analyzer = new SoapClient('http://209.162.178.106/medrespond/srv/test99451/sianalyzer3_mv3190/medrespond.sianalyzer.asmx?WSDL');
			$analyzer = new SoapClient('http://prod-analyzer.medrespond.net/MedRespond/SIAnalyzer3_mv3190/MedRespond.SIAnalyzer.asmx?WSDL',array('classmap' => array('getQuestionResponses' => 'localGetQuestionResponses')));
		}else {
			$analyzer = new SoapClient('http://52.11.214.101/MedRespond/SIAnalyzer3_mv3190/MedRespond.SIAnalyzer.asmx?WSDL',array('classmap' => array('getQuestionResponses' => 'localGetQuestionResponses')));
		}
		// Initialize params
		$params = array(
			'SessionID' => $this->ANALYZER_SESSION_ID,
			'CaseName' => $case_name,
			'InputQuestion' => $input_question
		);

		// var_dump($params);
		try{
			$result = $analyzer->getQuestionResponses($params)->getQuestionResponsesResult;
		}catch(Exception $e){
			return array('status' => 'error', 'message' => 'Did not receive a response from the analyzer.');
		}

		if (!isset($result)) {
			return array('status' => 'error', 'message' => 'Did not receive a response from the analyzer.');
		}
		if ($result->ResponseType === 'Null_InvalidCase') {
			return array('status' => 'error', 'message' => 'There was a problem connecting to case_name: ['.$case_name.']');
		}

		/* Rearrange Multiple answer questions to fill RQs */
		if ($result->ResponseType === 'MultAlt' || $result->ResponseType === 'Mult' || is_array($result->ResponseIDs->string)) {
			$responses = $result->ResponseIDs->string;
			/* Set the ResponseID to be the first value of the array */
			$result->ResponseIDs->string = $responses[0];
			/* Chop off the first ID */
			array_shift($responses);
			$result->RelatedIDs = new stdClass();
			$result->RelatedIDs->string = $responses;
		}
		$result->status = 'success';
		return $result;
	}
}

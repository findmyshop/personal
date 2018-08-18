<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index_library {

    protected $_ci = NULL;

    protected $_config_directory = './config/';
    protected $_left_rail_directory = '/left_rail/';
    protected $_config_filenames = array(
        'index'     => '/index.xml',
        'resources' => '/resources.xml',
        'ui'        => '/ui.xml'
    );

    protected $_simple_xml_element_config_objects = array(
        'index'     => NULL,
        'left_rail' => NULL,
        'resources' => NULL,
        'ui'        => NULL
    );

    protected $_empty_response = array(
        'id' => '',
        'name' => '',
        'rtmp_domain' => '',
        'web_domain' => '',
        'rtmp_domain' => '',
        'video_name' => '',
        'video_text' => '',
        'related_questions' => array(),
        'media' => array(),
        'still_image_path' => '',
        'playlists' => array(),
        'left_rail' => array(
            'id' => '',
            'hidden' => 'false',
            'module_selected' => '',
            'response_selected' => ''
        ),
        'video_controls' => array(
            'hidden' => 'false',
            'next_id' => '',
            'previous_id' => ''
        ),
        'ask_controls' => array(
            'hidden' => 'false',
            'action' => 'analyze'
        ),
        'case_name' => ''
    );

    public function __construct() {
        $this->_ci =& get_instance();
        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    protected function _initialize_simple_xml_element_config_object($project_name, $type) {
        log_debug(__FILE__, __LINE__, __METHOD__, "Called project_name = $project_name type = $type");

        if(!array_key_exists($type, $this->_simple_xml_element_config_objects)) {
            log_error(__FILE__, __LINE__, __METHOD__, "$type is not a valid key in _simple_xml_config_objects");
            return FALSE;
        }

        if($this->_simple_xml_element_config_objects[$type] === NULL) {
            $filename = $this->_config_directory . $project_name . $this->_config_filenames[$type];

            if(!file_exists($filename)) {
                log_info(__FILE__, __LINE__, __METHOD__, "Project specific $type xml config file at $filename doesn't exist.  Attempting to open the default $type xml config file");
                $filename = $this->_config_directory . 'default'. $this->_config_filenames[$type];
            }

            if(!file_exists($filename)) {
                log_error(__FILE__, __LINE__, __METHOD__, "Default $type xml config file at $filename doesn't exist");
                return FALSE;
            }

            if(!$xml_string = file_get_contents($filename)) {
                log_error(__FILE__, __LINE__, __METHOD__, "Unable to open $type xml config file - $filename");
                return FALSE;
            }

            if(!$this->_simple_xml_element_config_objects[$type] = simplexml_load_string($xml_string)) {
                $this->_simple_xml_config_objects[$type] = NULL;
                log_error(__FILE__, __LINE__, __METHOD__, "Unable to create a simple xml element object for - $type");
                return FALSE;
            }
        }

        return TRUE;
    }

    public function get_resources($project_name) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called project_name = ' . $project_name);

        if(empty($project_name)) {
            log_error(__FILE__, __LINE__, __METHOD__, 'project_name can\'t be empty');
            return NULL;
        }

        if(!$this->_initialize_simple_xml_element_config_object($project_name, 'resources')) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Aborting - Unable to initialize simple xml element config object');
            return NULL;
        }

        $categories = $this->_simple_xml_element_config_objects['resources']->xpath('/xml/Category');

        $resources = array();
        foreach($categories as $category) {
            $category_array = array(
                'rail'    => $this->_null_safe_to_string($category["rail"]),
                'heading' => $this->_null_safe_to_string($category->Heading),
                'type'    => $this->_null_safe_to_string($category["type"])
            );

            $category_array['resources'] = array();
            foreach ($category->Resource as $resource) {
                $resource_array = array(
                    'name'    => $this->_null_safe_to_string($resource->Name),
                    'details' => $this->_null_safe_to_string($resource->Details),
                    'link'    => $this->_null_safe_to_string($resource->Link),
                    'rids'    => $this->_null_safe_to_string($resource->Responses),
                    'modules' => $this->_null_safe_to_string($resource->Modules)
                );
                array_push($category_array['resources'], $resource_array);
            }

            array_push($resources, $category_array);
        }
        return $resources;
    }


    public function get_response($id) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called id= ' . $id);

        if(empty($id)) {
            log_error(__FILE__, __LINE__, __METHOD__, 'response_id can\'t be empty');
            return NULL;
        }

        $response = $this->_empty_response;

        $project_name = MR_PROJECT;

        if(empty($project_name)) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Could not resolve project name');
            return $response;
        }

        // Build up the response array by parsing different configuration files:
        // index.xml
        // ui.xml
        if($response = $this->get_basic_response_info($response, $project_name, $id)) {
            $response = $this->get_response_ui_info($response, $id);
        } else {
            // If we can't find a response, we don't want to just send back an empty response. We should error.
            return FALSE;
        }

        return $response;
    }

    /* For use with Sitemap */
    public function list_responses($project_name) {
        if(!$this->_initialize_simple_xml_element_config_object($project_name, 'index')) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Aborting - Unable to initialize simple xml element config object');
            return '';
        }
        if(!$responses = $this->_simple_xml_element_config_objects['index']->xpath('//xml/Response')) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Could not get a listing of responses.');
            return NULL;
        }
        return $responses;
    }

    public function get_response_ids($project_name) {
        if(!$this->_initialize_simple_xml_element_config_object($project_name, 'index')) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Aborting - Unable to initialize simple xml element config object');
            return array();
        }
        if(!$responses = $this->_simple_xml_element_config_objects['index']->xpath('//xml/Response/@id')) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Could not get a listing of responses.');
            return array();
        }

        $response_ids = array();

        foreach($responses as $response) {
            $response_ids[] = $this->_null_safe_to_string($response->id);
        }

        return $response_ids;
    }

    public function get_base_question($response_id, $project_name) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called response_id = ' . $response_id . ' | project_name = ' . $project_name);


        if(!$this->_initialize_simple_xml_element_config_object($project_name, 'index')) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Aborting - Unable to initialize simple xml element config object');
            return '';
        }

        if(!$this->_initialize_simple_xml_element_config_object($project_name, 'index')) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Aborting - Unable to initialize simple xml element config object');
            return FALSE;
        }

        // If the response id is an alias (cm#___) we need to resolve it with the project name for lookup in the index
        $response_id = $this->_resolve_alias_response_id($response_id);

        if($responses = $this->_simple_xml_element_config_objects['index']->xpath('/xml/Response[@id="'.$response_id.'"]')) {
            return $this->_null_safe_to_string($responses[0]->BaseQuestion);
        }

        log_error(__FILE__, __LINE__, __METHOD__, 'Could not find response that matches response_id = ' . $response_id);
        return '';
    }

    public function get_question_content($response_id, $project_name) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called response_id = ' . $response_id . ' | project_name = ' . $project_name);

        if(!$this->_initialize_simple_xml_element_config_object($project_name, 'index')) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Aborting - Unable to initialize simple xml element config object');
            return '';
        }

        // If the response id is an alias (cm#___) we need to resolve it with the project name for lookup in the index
        $response_id = $this->_resolve_alias_response_id($response_id);

        if($responses = $this->_simple_xml_element_config_objects['index']->xpath('/xml/Response[@id="'.$response_id.'"]')) {
            return nl2br($this->_null_safe_to_string($responses[0]->Content));
        }

        log_error(__FILE__, __LINE__, __METHOD__, 'Could not find response that matches response_id = ' . $response_id);
        return '';
    }

    /*
        Retrieves the left rail that is associated with a specific response
    */
    public function get_left_rail_content($project_name, $left_rail_id = 'main') {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called project_name = ' . $project_name . ' | left_rail_id = ' . $left_rail_id);
        // We can not just use the default parameter because the information
        // from the UI configuration might be '' and still get passed into this function
        if ($left_rail_id == '') {
            $left_rail_id = 'main';
        }

        $left_rail_file = $this->_config_directory . $project_name . $this->_left_rail_directory . $left_rail_id . '.xml';
        /* ToDo: This should really provide a better error handling, but for now it works. */
        if(!file_exists($left_rail_file)) {
            $left_rail_id = 'main';
            $left_rail_file = $this->_config_directory . $project_name . $this->_left_rail_directory . $left_rail_id . '.xml';
            if(!file_exists($left_rail_file)) {
                $left_rail_file = $this->_config_directory . 'default' . $this->_left_rail_directory . $left_rail_id . '.xml';
            }
        }

        $xml_string = file_get_contents($left_rail_file);
        // Parse left rail xml and build an array representing the left rail specific to the response.
        $left_rail = array();
        $left_rail_config = simplexml_load_string($xml_string);
        foreach($left_rail_config->Module as $module) {
            $module_array = array(
                'id'        => $this->_clean_xml_content($module['id']),
                'heading'   => $this->_clean_xml_content($module->Heading),
                'status'    => $this->_clean_xml_content($module["status"]),
                'action'    => $this->_clean_xml_content($module["action"]),
                'type'      => $this->_clean_xml_content($module["type"]),
                'responses' => array()
            );
            /* All response IDs will be wrapped in an array */
            foreach ($module->ResponseID as $id) {
                $group_array = array();
                $response_id = $this->_clean_xml_content($id);
                $status = $this->_clean_xml_content($id["status"]);
                $r_action = $this->_clean_xml_content($id["action"]);
                $r_type = $this->_clean_xml_content($id["type"]);
                //Look for commas to check if our ID is grouped (comma separated).
                if (strpos($response_id,',') !== false) {
                    //Store this string of ids in each response for checking active state (This is sloppy)
                    $group = $response_id;
                    $response_id = explode(',', $response_id);
                    foreach ($response_id as $id){
                        $question = $this->get_base_question($id, $project_name);
                        $response_array = array(
                            'id'       => $id,
                            'type'     => $r_type, // for pseudo-headings
                            'group'    => $group.',', //Need this coma for active state checking.
                            'status'   => $status,
                            'action'   => $r_action,
                            'question' => $question
                        );
                        array_push($group_array, $response_array);
                    }
                }else{
                    $question = $this->get_base_question($response_id, $project_name);
                    $response_array = array(
                        'id'       => $response_id,
                        'type'     => $r_type, // for pseudo-headings
                        'group'    => $response_id,
                        'status'   => $status,
                        'action'   => $r_action,
                        'question' => $question
                    );
                    array_push($group_array, $response_array);
                }
                //Make a group array
                array_push($module_array['responses'], $group_array);
            }
            array_push($left_rail, $module_array);
        }

        return $left_rail;
    }

    /*
        Takes an array of response IDs, spits back an array with response titles.
    */
    public function get_multi_response_info($id_array) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        if(empty($id_array)) {
            return array();
        }

        $project_name = MR_PROJECT;
        if(empty($project_name)) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Could not resolve project_name');
            return FALSE;
        }

        if(!$this->_initialize_simple_xml_element_config_object($project_name, 'index')) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Aborting - Unable to initialize simple xml element config object');
            return FALSE;
        }

        $new_array = array();

        /* Start by building the new RQ Array */
        foreach($id_array as $value) {
            $new_array[] = array(
                'id'                        => $value,
                'resolved_id'       => $this->_resolve_alias_response_id($value),
                'display_text'  => ''
            );
        }

        $xpath_predicate = implode(' or ', array_map(function ($entry) {
          return "@id='{$entry['resolved_id']}'";
        }, $new_array));

        if($responses = $this->_simple_xml_element_config_objects['index']->xpath('/xml/Response['.$xpath_predicate.']')) {
            foreach($responses as $response) {
                foreach($new_array as $key => $row) {
                    if($response['id'] == $row['resolved_id']) {
                        $new_array[$key]['display_text'] = $this->_null_safe_to_string($response->BaseQuestion);
                        break;
                    }
                }
            }
        }

        return $new_array;
    }
    /*
        Retrieves response information from the configuration file (xml) built
        by the indexer.
    */
    private function get_basic_response_info($response, $project_name, $id) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called response_id = ' . $id . ' | project_name = ' . $project_name);

        if(empty($project_name)) {
            log_error(__FILE__, __LINE__, __METHOD__, 'project_name can\'t be empty');
            return NULL;
        }

        if(!$this->_initialize_simple_xml_element_config_object($project_name, 'index')) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Aborting - Unable to initialize simple xml element config object');
            return NULL;
        }

        $resolved_id = $this->_resolve_alias_response_id($id);
        if(!$responses = $this->_simple_xml_element_config_objects['index']->xpath('/xml/Response[@id="'.$resolved_id.'"]')) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Could not find response information for response_id = ' . $id);
            return NULL;
        }

        $r                             = $responses[0];
        $response['id']                = $this->_null_safe_to_string($id);
        $response['name']              = $this->_null_safe_to_string($r->BaseQuestion);
        $response['wrong_answer_text'] = $this->_null_safe_to_string($r->WrongAnswer);
        $response['video_override']    = $this->_null_safe_to_string($r->ResponseID);
        $response['video_text']        = nl2br($this->_add_term_definition_tooltip_markup_to_string($this->_null_safe_to_string($r->Content)));

        // Look for related questions in the index xml
        if(isset($r->RQs)) {
            foreach ($r->RQs->RQ as $related_question) {
                $question = array(
                    'id'           => $this->_null_safe_to_string($related_question->ResponseID),
                    'display_text' => $this->_null_safe_to_string($related_question->BaseQuestion)
                );
                array_push($response['related_questions'], $question);
            }
        }

        // Look for Actors in the index xml
        if(isset($r->PlayLists)) {
            foreach ($r->PlayLists->PlayList as $playlist_instance) {
                $playlists = array(
                    'list_order'   => $this->_null_safe_to_string($playlist_instance->ListOrder),
                    'id'           => $this->_null_safe_to_string($playlist_instance->ResponseID),
                    'display_text' => $this->_null_safe_to_string($playlist_instance->BaseQuestion),
                    'actor_name'   => $this->_null_safe_to_string($playlist_instance->Actor),
                    'actor_image'  => $this->_null_safe_to_string($playlist_instance->ActorDefaultRelativeStillPath)
                );
                array_push($response['playlists'], $playlists);
            }
        }

        // Look for media in the index xml
        if(isset($r->MediaList)) {
            foreach($r->MediaList->Media as $media_instance) {
                $media = array(
                    'name' => $this->_null_safe_to_string($media_instance->Description),
                    'link' => $this->_null_safe_to_string($media_instance->Location)
                );
                array_push($response['media'], $media);
            }
        }

        if(isset($r->ActorDefaultRelativeStillPath)) {
            $response['still_image_path'] = $this->_null_safe_to_string($r->ActorDefaultRelativeStillPath);
        }

        // Get the S3 domains from the project database
        $video_domains = $this->_ci->property_model->get_video_domains(MR_PROJECT);
        $response['web_domain'] = $video_domains['web_video_domain'];
        $response['rtmp_domain'] = $video_domains['rtmp_video_domain'];

        if ($response['video_override'] != $response['id']){
            $response['video_name'] = $response['video_override'];
        }else{
            $response['video_name'] = $resolved_id;
        }

        return $response;
    }

    /* Better method for detecting multiple case_names */
    public function has_multiple_indexes($current_response) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called current_response = ' . $current_response);

        $project_name = MR_PROJECT;
        if(empty($project_name)) {
            log_error(__FILE__, __LINE__, __METHOD__, 'project_name can\'t be empty');
            return FALSE;
        }

        if(!$this->_initialize_simple_xml_element_config_object($project_name, 'ui')) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Aborting - Unable to initialize simple xml element config object');
            return FALSE;
        }

        if(!$responses = $this->_simple_xml_element_config_objects['ui']->xpath('/xml/Response[@id="'.$current_response.'"]/Answers')) {
            log_info(__FILE__, __LINE__, __METHOD__, "Determined that response_id = $current_response does not have multiple indexes");
            return FALSE;
        }

        log_info(__FILE__, __LINE__, __METHOD__, "Determined that response_id = $current_response has multiple indexes");
        return TRUE;
    }

    /* Gives us the response ID stored in ui.xml related to the question */
    public function get_question_response($current_response, $response_id) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called current_response = ' . $current_response . ' | response_id = ' . $response_id);

        $project_name = MR_PROJECT;
        if(empty($project_name)) {
            log_error(__FILE__, __LINE__, __METHOD__, 'project_name can\'t be empty');
            return FALSE;
        }

        if(!$this->_initialize_simple_xml_element_config_object($project_name, 'ui')) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Aborting - Unable to initialize simple xml element config object');
            return FALSE;
        }

        if($answers = $this->_simple_xml_element_config_objects['ui']->xpath('/xml/Response[@id="'.$current_response.'"]/Answers/Answer[@id="'.$response_id.'"]')) {
            $answer = $answers[0];
            if(isset($answer['case'])) {
                log_info(__FILE__, __LINE__, __METHOD__, "Question response found for current_response = $current_response, response_id = $response_id.  Returning {$answer['case']}");
                return array('case' => $answer['case']);
            } else {
                log_info(__FILE__, __LINE__, __METHOD__, "Question response found for current_response = $current_response, response_id = $response_id.  Returning $answer");
                return $this->_null_safe_to_string($answer);
            }
        }

        log_info(__FILE__, __LINE__, __METHOD__, "No question response found for current_response = $current_response, response_id = $response_id");
        return FALSE;
    }

    /*
        Retrieves any UI information specific to the response that is stored in
        the UI configuration file.
    */
    private function get_response_ui_info($response, $response_id) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called response_id = ' . $response_id);

        if(!($temp_response = $this->_get_response_ui($response, $response_id))) {
            // We could not find a ui entry with the original response_id so attempt to resolve the response_id to an alias and attempt to find an associated ui entry
            $resolved_id = $this->_resolve_alias_response_id($response_id);
            $temp_response = $this->_get_response_ui($response, $resolved_id);
        }

        if($temp_response) {
            return $temp_response;
        }

        return $response;
    }

    private function _clean_xml_content($target) {
        //log_debug(__FILE__, __LINE__, __METHOD__, 'Called');
        return trim(preg_replace("/\s+/", " ", $target));
    }

    private function _get_response_ui($response, $response_id) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called response_id = ' . $response_id);

        $project_name = MR_PROJECT;
        if(empty($project_name)) {
            log_error(__FILE__, __LINE__, __METHOD__, 'project_name can\'t be empty');
            return FALSE;
        }

        if(!$this->_initialize_simple_xml_element_config_object($project_name, 'ui')) {
            log_error(__FILE__, __LINE__, __METHOD__, 'Aborting - Unable to initialize simple xml element config object');
            return FALSE;
        }

        if($responses = $this->_simple_xml_element_config_objects['ui']->xpath('/xml/Response[@id="'.$response_id.'"]')) {
            $r                                          = $responses[0];
            $response['left_rail']['id']                = $this->_null_safe_to_string($r->LeftRail->Id);
            $response['left_rail']['hidden']            = $this->_null_safe_to_string($r->LeftRail->Hidden);
            $response['left_rail']['module_selected']   = $this->_null_safe_to_string($r->LeftRail->ModuleSelected);
            $response['left_rail']['response_selected'] = $this->_null_safe_to_string($r->LeftRail->ResponseSelected);
            $response['video_controls']['hidden']       = $this->_null_safe_to_string($r->VideoControls->Hidden);
            $response['video_controls']['next_id']      = $this->_null_safe_to_string($r->VideoControls->NextId);
            $response['video_controls']['next_title']   = $this->_null_safe_to_string($r->VideoControls->NextId['title']);
            $response['video_controls']['previous_id']  = $this->_null_safe_to_string($r->VideoControls->PreviousId);
            $response['video_controls']['done_id']      = $this->_null_safe_to_string($r->VideoControls->DoneId);
            $response['video_controls']['done_title']   = $this->_null_safe_to_string($r->VideoControls->DoneId['title']);
            $response['ask_controls']['hidden']         = $this->_null_safe_to_string($r->AskControls->Hidden);
            $response['ask_controls']['action']         = $this->_null_safe_to_string($r->AskControls->Action);
            $response['case_name']                      = $this->_null_safe_to_string($r->CaseName);
            $response['type']                           = $this->_null_safe_to_string($r['type']); //null, MADIO (offtopic, directive, etc.)
            $response['category']                       = $this->_null_safe_to_string($r['category']); //multianswer, shame, offtopic
            $response['redirect']                       = $this->_null_safe_to_string($r['redirect']);
            $response['test_content']                   = $this->_null_safe_to_string($r->TestContent); //Iframe test content in rush

            // Decisions (For use in DDI)
            if(isset($r->Decisions)) {
                $response['decisions'] = array();

                foreach ($r->Decisions->Decision as $decision) {
                    $decision_attempt_rows = (array) $decision->DecisionAttemptID;

                    foreach($decision_attempt_rows as $decision_attempt_response_id) {

                        if($this->_ci->log_model->user_has_submitted_input_question_while_viewing_response($decision_attempt_response_id) == FALSE) {
                            $response['decisions'][] = array(
                                'display_text' => $this->_null_safe_to_string($decision['text']),
                                'rid' => $decision_attempt_response_id
                            );

                            continue 2;
                        }
                    }

                    $response['decisions'][] = array(
                        'display_text' => $this->_null_safe_to_string($decision['text']),
                        'rid' => $decision_attempt_rows[count($decision_attempt_rows) - 1]
                    );
                }
            }

/*
            if(isset($r->Decisions)) {
                $response['decisions'] = array();
                foreach ($r->Decisions->Decision as $decision) {
                    $d = array(
                        'display_text' => $this->_null_safe_to_string($decision['text'])
                    );
                    $d['attempts'] = array();
                    foreach ($decision->DecisionID as $dID) {
                        $attempts = array(
                            'attempt' => $this->_null_safe_to_string($dID['attempt']),
                            'rid' => $this->_null_safe_to_string($dID),
                        );
                        array_push($d['attempts'], $attempts);
                    }
                    array_push($response['decisions'], $d);
                }
            }
*/
            return $response;
        }

        return FALSE;
    }

    private function _null_safe_to_string($target, $default_val = '') {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        if(empty($target)) {
            return $default_val;
        }

        if(is_string($target)) {
            return trim($target);
        }

        if(method_exists($target, '__toString')) {
            return trim($target->__toString());
        }

        return $default_val;
    }

    // NOTE (Alex Quinn 8/18/2014):
    // This function exists so we can map a single response to different UI configurations.
    // For example: We can point to a response in conversation module 2 by using the response
    // ID cm2XXX. This function returns the response with the original prefix (sccXXX) so
    // we can look up the content for that response in the index. However the UI configuration file
    // will contain information about cm2XXX that is specific to that conversation module
    //
    // An alias *must* begin with the string 'cm'
    private function _resolve_alias_response_id($response_id) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called response_id = ' . $response_id);

        if(substr($response_id, 0, 2) === 'cm') {
            if($prefix = $this->_ci->property_model->get_response_prefix(MR_PROJECT)) {
                return $prefix . substr($response_id, 3);
            } else {
                log_error(__FILE__, __LINE__, __METHOD__, 'Error getting a response prefix when resolving alias for response_id = ' . $response_id);
                return 'scc';
            }
        } else {
            return $response_id;
        }
    }

    private function _add_term_definition_tooltip_markup_to_string($str) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $this->_ci->load->model('term_definition_model');
        $term_definitions = $this->_ci->term_definition_model->get_property_term_definitions();

        foreach($term_definitions as $term_definition) {
            if($term_definition['active']) {
                // regex pattern performs case insensitive match of each instance of the term not already contained in html tags
                $pattern = sprintf('/(\b%s\b)(?![^<]*>|[^<>]*<\/)/mi', trim($term_definition['term']));
                // wrap each match in html markup that will yield a definition tooltip on hover
                $replacement = sprintf('<span class="term-definition" data-toggle="tooltip" data-container="body" data-trigger="click hover" data-placement="auto" title="%s">$1</span>', trim($term_definition['definition']));

                if(($processed_str = preg_replace($pattern, $replacement, $str)) !== NULL) {
                    $str = $processed_str;
                }
            }
        }

        return $str;
    }

}
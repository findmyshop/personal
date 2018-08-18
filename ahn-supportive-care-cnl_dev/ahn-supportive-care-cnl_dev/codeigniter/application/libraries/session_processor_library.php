<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session_processor_library
{
    protected $ci = NULL;

    protected $previous_session_processor_run_last_activity_id = NULL;

    protected $session_processor_run_id = NULL;
    protected $session_processor_run_first_activity_id = NULL;
    protected $session_processor_run_last_activity_id = NULL;

    public function __construct()
    {
        define('SESSION_IDS_CHUNK_LENGTH', 5); // number of session ids to process at a time.
        define('SESSION_TIMEOUT_SECONDS', 300); // number of seconds between user activity that constitutes a session timeout strictly for reporting purposes
        define('SESSION_PADDING_SECONDS', 90); // number of seconds added to a session to account for video playback time.  essentially, we're using this as the average video length


        $this->ci = & get_instance();
        $this->ci->load->model('processed_sessions_model');
        $this->ci->load->model('session_processor_runs_model');

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function execute()
    {
        log_info(__FILE__, __LINE__, __METHOD__, 'Called');

        $this->_initialize_session_processor_run();

        if($session_ids = $this->_get_session_ids()) {
            $chunk_length = 5;
            $session_ids_offset = 0;

            while($session_ids_chunk = array_slice($session_ids, $session_ids_offset, SESSION_IDS_CHUNK_LENGTH)) {
                $activity = $this->_get_activity($session_ids_chunk);
                $this->_process_activity($session_ids_chunk,$activity);
                $session_ids_offset += SESSION_IDS_CHUNK_LENGTH;
            }
        }

        $this->_finalize_session_processor_run();
    }

    private function _process_activity($session_ids, $activity)
    {
        $session_map = array();

        foreach($session_ids as $session_id) {
            $session_map[$session_id] = array();
        }

        foreach($activity as $row) {
            if($this->session_processor_run_first_activity_id === NULL) {
                $this->session_processor_run_first_activity_id = $row['id'];
            }

            if(empty($session_map[$row['session_id']])) {
                $session_map[$row['session_id']][] = array($row);
            } else {
                $session_index = count($session_map[$row['session_id']]) - 1;
                $activity_index = count($session_map[$row['session_id']][$session_index]) - 1;

                if(strtotime('-'.SESSION_TIMEOUT_SECONDS.' seconds', strtotime($row['date'])) <= strtotime($session_map[$row['session_id']][$session_index][$activity_index]['date'])) {
                    $session_map[$row['session_id']][$session_index][] = $row;
                } else {
                    $session_map[$row['session_id']][] = array($row);
                }
            }

            if($this->session_processor_run_last_activity_id === NULL || $row['id'] > $this->session_processor_run_last_activity_id) {
                $this->session_processor_run_last_activity_id = $row['id'];
            }
        }

        foreach($session_map as $session_id => $split_sessions) {
            foreach($split_sessions as $split_session_activity) {
                $activity_count = count($split_session_activity);
                $start_activity = $split_session_activity[0];
                $end_activity = $split_session_activity[$activity_count - 1];
                $user_id = $start_activity['user_id'];
                $ip_address = $start_activity['ip_address'];
                $start_activity_id = $start_activity['id'];
                $end_activity_id = $end_activity['id'];
                $start_datetime = $start_activity['date'];
                $end_datetime = date('Y-m-d H:i:s', strtotime('+'.SESSION_PADDING_SECONDS.' seconds', strtotime($end_activity['date'])));
                $start_count = 0;
                $replay_count = 0;
                $previous_count = 0;
                $next_count = 0;
                $input_question_count = 0;
                $related_question_count = 0;
                $left_rail_question_count = 0;
                $other_count = 0;

                foreach($split_session_activity as $activity) {
                    switch($activity['action']) {
                        case ACTION_START;
                            $start_count++;
                        break;

                        case ACTION_REPEAT:
                            $replay_count++;
                        break;

                        case ACTION_PREV:
                            $previous_count++;
                        break;

                        case ACTION_NEXT:
                            $next_count++;
                        break;

                        case ACTION_Q:
                        case ACTION_A:
                            if(!empty($activity['input_question'])) {
                                $input_question_count++;
                            }
                        break;

                        case ACTION_RELATED:
                            $related_question_count++;
                        break;

                        case ACTION_LEFT_RAIL:
                            $left_rail_question_count++;
                        break;

                        default:
                            $other_count++;
                        break;
                    }
                }

                $this->ci->processed_sessions_model->insert(
                    $this->session_processor_run_id,
                    $session_id,
                    $ip_address,
                    $user_id,
                    $start_activity_id,
                    $end_activity_id,
                    $start_datetime,
                    $end_datetime,
                    $activity_count,
                    $start_count,
                    $replay_count,
                    $previous_count,
                    $next_count,
                    $input_question_count,
                    $related_question_count,
                    $left_rail_question_count,
                    $other_count
                );
            }
        }

    }

    private function _get_activity($session_ids = array())
    {
        log_info(__FILE__, __LINE__, __METHOD__, 'Called');

        if(empty($session_ids)) {
            return array();
        }

        $query = $this->ci->db
            ->select('
                master_activity_logs.id,
                master_activity_logs.session_id,
                master_activity_logs.ip_address,
                master_activity_logs.user_id,
                master_activity_logs.action,
                master_activity_logs.input_question,
                master_activity_logs.date',
            FALSE)
            ->from('master_activity_logs')
            ->join('master_users', 'master_users.id = master_activity_logs.user_id')
            ->join('master_user_types', 'master_user_types.id = master_users.user_type_id')
            ->where_in('session_id', $session_ids)
            ->where(array(
                'master_activity_logs.id > '      => $this->previous_session_processor_run_last_activity_id,
                'master_activity_logs.mr_project' => MR_PROJECT,
                'master_user_types.type_name'     => 'user'
            ))
            ->order_by('date', 'ASC')
            ->get();

        if($query->num_rows() > 0) {
            return $query->result_array();
        }

        return array();
    }

    private function _get_session_ids()
    {
        log_info(__FILE__, __LINE__, __METHOD__, 'Called');

        $query = $this->ci->db
            ->distinct('session_id')
            ->from('master_activity_logs')
            ->join('master_users', 'master_users.id = master_activity_logs.user_id')
            ->join('master_user_types', 'master_user_types.id = master_users.user_type_id')
            ->where(array(
                'master_activity_logs.mr_project' => MR_PROJECT,
                'master_user_types.type_name'     => 'user'
            ))
            ->group_by('master_activity_logs.session_id')
            ->order_by('master_activity_logs.date', 'ASC')
            ->get();

        if($query->num_rows() > 0) {
            return array_column($query->result_array(), 'session_id');
        }

        return array();
    }

    private function _initialize_session_processor_run()
    {
        $this->previous_session_processor_run_last_activity_id = $this->ci->session_processor_runs_model->get_last_processed_activity_id();
        $this->session_processor_run_id = $this->ci->session_processor_runs_model->insert();
    }

    private function _finalize_session_processor_run()
    {
        $this->ci->session_processor_runs_model->update($this->session_processor_run_id, array(
            'first_activity_id' => $this->session_processor_run_first_activity_id,
            'last_activity_id'  => $this->session_processor_run_last_activity_id,
            'end_timestamp'     => date('Y-m-d G:i:s')
        ));
    }

}
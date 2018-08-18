<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session_Processor_Controller extends Constants_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session_processor_library');

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function index()
    {
        if(HAS_MULTIPLE_MR_DIRECTORIES) {
            $this->load->model('url_subdirectory_model');
            $subdirectories = $this->url_subdirectory_model->get();

            if(!empty($subdirectories)) {
                foreach ($subdirectories as $subdirectory) {
                    $url = base_url().$subdirectory.'/session_processor/execute';
                    // curl the session processor execute endpoint for each each subdirectory
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    echo curl_exec($ch);
                    curl_close($ch);
                }
            } else {
                $this->execute();
            }
        } else {
            $this->execute();
        }
    }

    public function execute()
    {
        echo sprintf('session processor run for %s start datetime - %s<br />', MR_PROJECT, date('Y-m-d G:i:s'));
        $this->session_processor_library->execute();
        echo sprintf('session processor run for %s end datetime - %s<br />', MR_PROJECT, date('Y-m-d G:i:s'));
    }

}
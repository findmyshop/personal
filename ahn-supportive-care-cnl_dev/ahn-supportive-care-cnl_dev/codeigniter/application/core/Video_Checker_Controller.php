<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Video_Checker_Controller extends Constants_Controller
{
    public function __construct() {
        parent::__construct();
        set_time_limit(3600);
        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function index() {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        if(HAS_MULTIPLE_MR_DIRECTORIES) {
            $this->load->model('url_subdirectory_model');
            $subdirectories = $this->url_subdirectory_model->get();

            if(!empty($subdirectories)) {
                foreach ($subdirectories as $subdirectory) {
                    $url = base_url() . $subdirectory . '/video_checker/execute';
                    // curl the video checker execute endpoint for each each subdirectory
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

    public function execute() {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        // The training and military training experiences contain responses that don't have a corresponding video so the video checks always fail for these types
        $check_videos = (MR_TYPE !== 'training' && MR_TYPE !== 'military_training');

        if($check_videos) {
            $cloudfront_mp4_domain = $this->property_model->get_mp4_video_domain(MR_PROJECT);
            $response_ids = $this->index_library->get_response_ids(MR_PROJECT);
            $missing_response_videos = array();

            foreach($response_ids as $response_id) {
                $video_filenames = $this->_get_response_video_filenames($response_id);

                foreach($video_filenames as $video_filename) {
                    $video_url = 'https://' . $cloudfront_mp4_domain . '/' .$video_filename;

                    if(!$this->_check_video($video_url)) {
                        $missing_response_videos[$response_id][] = $video_filename;
                    }
                }
            }

            if(!empty($missing_response_videos)) {
                $this->_send_error_email($missing_response_videos);
            } else {
                $this->_send_success_email();
            }
        }
    }

    private function _check_video($video_url) {
        log_debug(__FILE__, __LINE__, __METHOD__, sprintf('Called with video_url = %s', $video_url));

        $ch = curl_init($video_url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_NOBODY, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        // Interpret 2xx and 3xx response codes from CloudFront as a success.  CloudFront doesn't always serve 200's when the file is present and readable.  206 in particular is a common response code
        if(substr($http_code, 0, 1) == '2' || substr($http_code, 0, 1) == '3') {
            log_debug(__FILE__, __LINE__, __METHOD__, sprintf('Video check SUCCESS | video_url = %s | HTTP_CODE = %s', $video_url, $http_code));
            return TRUE;
        } else {
            log_error(__FILE__, __LINE__, __METHOD__, sprintf('Video check ERROR | video_url = %s | HTTP_CODE = %s', $video_url, $http_code));
            return FALSE;
        }
    }

    private function _get_response_video_filenames($response_id) {
        log_debug(__FILE__, __LINE__, __METHOD__, sprintf('Called with response_id = %s', $response_id));

        $video_names = array();

        if(HAS_ASL_VIDEOS) {
            $video_names[] = $response_id . '_512k';
            $video_names[] = $response_id . '_asl_512k';

            if(HAS_256K_VIDEOS) {
                $video_names[] = $response_id . '_256k';
                $video_names[] = $response_id . '_asl_256k';
            }
        } else if(MR_HAS_SPEAKER) {
            $video_names[] = $response_id . 'a_512k';
            // node1forpvst.com only has the male speaker
            if(MR_PROJECT !== 'msp') {
                $video_names[] = $response_id . 'b_512k';
            }

            if(HAS_256K_VIDEOS) {
                $video_names[] = $response_id . 'a_256k';
                // node1forpvst.com only has the male speaker
                if(MR_PROJECT !== 'msp') {
                    $video_names[] = $response_id . 'b_256k';
                }
            }
        } else {
            $video_names[] = $response_id . '_512k';

            if(HAS_256K_VIDEOS) {
                $video_names[] = $response_id . '_256k';
            }
        }

        foreach($video_names as $key => $video_name) {
            $video_names[$key] = $video_name . '.mp4';
        }

        return $video_names;
    }

    // For now, we're only sending emails when an error is encountered.
    private function _send_success_email() {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        echo 'success email sent!';die;
    }

    private function _send_error_email($missing_response_videos) {
        log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

        $data = array(
            'base_url'                => base_url(),
            'missing_response_videos' => $missing_response_videos
        );

        $config = array(
            'mailtype'  =>  'html',
            'proto'     =>  'mail'
        );

        $message = $this->load->view('video_checker/error_email', $data, TRUE);

        $this->postmark->initialize($config);
        $this->postmark->from(VIDEO_CHEKCER_EMAIL_ADDRESS);
        $this->postmark->to(VIDEO_CHEKCER_EMAIL_ADDRESS, 'Automated CloudFront Video Checker Process');
        $this->postmark->subject(sprintf('Video Errors Detected on %s', $data['base_url']));
        $this->postmark->message($message);
        $this->postmark->send();
        $this->postmark->clear();

        echo 'error email sent!';die;
    }

}
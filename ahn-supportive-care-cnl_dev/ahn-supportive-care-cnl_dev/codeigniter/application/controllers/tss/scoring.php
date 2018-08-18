calculate_user_simulation_attempt_scores($user_id, $simulation_attempt)

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class scoring extends Constants_Controller
{
    public function __construct() {
        parent::__construct();
    }

    public function index($user_id, $simulation_attempt) {
        $this->load->model('tssim_score_model');
        $user_simulation_attempt_scores = $this->tssim_score_model->calculate_user_simulation_attempt_scores($user_id, $simulation_attempt);
        var_dump($user_simulation_attempt_scores);die;
    }



}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Base extends Base_Controller_Clinical_Trials {

    public function __construct() {
        parent::__construct();

        $this->session->set_userdata('speaker', 'a');
    }

}

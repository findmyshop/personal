<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payments_Controller extends MY_Controller {

    protected $_user_id;
    protected $_course;

    public function __construct() {
        parent::__construct();
        require_once APPPATH.'libraries/third_party/Braintree/lib/Braintree.php';
        $this->load->config('braintree');
        $this->load->model('braintree_transactions_model');
        $this->load->model('course_model');

        $this->_user_id = $this->session->userdata('account_id');

        // if the user doesn't have an active course then redirect them to the admin panel.
        if(!$this->_course = $this->course_model->get_active_course($this->_user_id)) {
            redirect('admin');
        }

        // if the user has already paid for the course then redirect them to the experience.
        if($this->braintree_transactions_model->user_paid_for_course($this->_user_id, $this->_course['course_id'])) {
            redirect('/');
        }

        Braintree_Configuration::environment($this->config->item('braintree_environment'));
        Braintree_Configuration::merchantId($this->config->item('braintree_merchant_id'));
        Braintree_Configuration::publicKey($this->config->item('braintree_public_key'));
        Braintree_Configuration::privateKey($this->config->item('braintree_private_key'));

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function index() {
        $data = array(
            'client_token'  => Braintree_ClientToken::generate(),
            'course'        => $this->_course
        );

        $this->template_library
            ->set_title($this->property_model->get_title(MR_PROJECT))
            ->set_module('Payments')
            ->build('payments/payments_index', $data, 'payments/payments_header', 'payments/payments_base');
    }

    public function checkout() {
        $payment_method_nonce = $this->input->post('payment_method_nonce');

        if(!$payment_method_nonce) {
            $this->session->set_flashdata('payments_error', 'Falied to retrieve the payment method nonce from Braintree!');
            redirect('/payments');
        }

        $result = Braintree_Transaction::sale([
            'amount'             => $this->_course['course_price'],
            'customFields' => [
                'http_host' => $_SERVER['HTTP_HOST'],
                'property'  => MR_PROJECT,
                'user_id'   => $this->_user_id,
                'course_id' => $this->_course['course_id']
            ],
            'paymentMethodNonce' => $payment_method_nonce,
            'options'            => [
                'submitForSettlement'   => TRUE
            ]
        ]);

        if($result->success) {
            $this->braintree_transactions_model->insert($this->_user_id, $this->_course['course_id'], $result->transaction->id);
            redirect('/');
        } else {
            $this->session->set_flashdata('payments_error', $result->message);
            redirect('/payments');
        }

    }

}

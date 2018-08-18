<?php    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(ENVIRONMENT === 'production') {
    $config['braintree_environment'] = 'production';
    $config['braintree_merchant_id'] = 'x9qgv5rf67gzcvwb';
    $config['braintree_public_key'] = 'k76zzhn6nmzmznty';
    $config['braintree_private_key'] = '00bdc6b026a0e41264abe57c85cda988';
} else {
    // Braintree Sandbox account used in development and testing environments
    // Sandbox Login URL - https://sandbox.braintreegateway.com/login
    // Username - developers@medrespond.com
    // Password - d5e@6*47EU6g

    $config['braintree_environment'] = 'sandbox';
    $config['braintree_merchant_id'] = '8hpgy8rzrj4mpgf3';
    $config['braintree_public_key'] = 'q6wpqwc9rcxv459v';
    $config['braintree_private_key'] = 'cdd6245edeecad2a37f6a8c60545bc4c';
}

/* End of file braintree.php */
/* Location: ./application/config/braintree.php */
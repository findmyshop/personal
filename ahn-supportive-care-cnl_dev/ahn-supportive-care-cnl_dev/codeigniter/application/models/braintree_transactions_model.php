<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Braintree_Transactions_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function get_user_course_transactions($user_id, $course_id) {
        log_info(__FILE__, __LINE__, __METHOD__, sprintf('Called with user_id = %s | course_id = %s', $user_id, $course_id));

        $query = $this->db
            ->select('*')
            ->from('master_braintree_transactions')
            ->where('id', $id)
            ->get();

        if($query->num_rows() > 0) {
            return $query->results_array();
        }

        return array();
    }

    public function insert($user_id, $course_id, $transaction_id = NULL) {
        log_info(__FILE__, __LINE__, __METHOD__, sprintf('Called with user_id = %s | course_id = %s | transaction_id = %s', $user_id, $course_id, ($transaction_id) ? $transaction_id : 'NULL'));

        // NULL transaction ids indicate failed transaction attempts
        $this->db->insert('master_braintree_transactions', array(
            'user_id'           => $user_id,
            'course_id'         => $course_id,
            'transaction_id'    => (empty($transaction_id)) ? NULL : $transaction_id
        ));

        return $this->db->insert_id();
    }

    public function user_paid_for_course($user_id, $course_id) {
        log_info(__FILE__, __LINE__, __METHOD__, sprintf('Called with user_id = %s | course_id = %s', $user_id, $course_id));

        $query = $this->db
            ->select('id')
            ->from('master_braintree_transactions')
            ->where(array(
                'user_id'       => $user_id,
                'course_id'     => $course_id,
            ))
            ->where('transaction_id IS NOT NULL')
            ->limit(1)
            ->get();

        if($query->num_rows() == 1) {
            return TRUE;
        }

        return FALSE;
    }

}

/* End of file braintree_transactions_model.php */
/* Location: ./application/models/braintree_transactions_model.php */

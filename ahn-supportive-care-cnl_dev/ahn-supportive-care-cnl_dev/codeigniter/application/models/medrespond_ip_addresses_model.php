<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Medrespond_ip_addresses_model extends CI_Model {

    public function __construct() {
        parent::__construct();

        log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
    }

    public function insert($user_id, $username, $ip_address) {
        log_debug(__FILE__, __LINE__, __METHOD__, "Called with user_id = $user_id | username = $username | ip_address = $ip_address");

        // check to make sure that the user belongs to the MedRespond organization
        if($this->user_model->is_medrespond_organization_user($user_id)) {

            // check to make sure there isn't already an entry for this ip address before inserting one
            if(!$this->is_medrespond_ip_address($ip_address)) {
                $description = sprintf('Auto Inserted Entry for username = %s', $username);

                $this->db->insert('master_medrespond_ip_addresses', array(
                    'ip_address'    => $ip_address,
                    'description'   => $description
                ));

                return $this->db->insert_id();
            }
        }

        return NULL;
    }

    public function is_medrespond_ip_address($ip_address) {
        log_debug(__FILE__, __LINE__, __METHOD__, "Called with ip_address = $ip_address");

        $query = $this->db
            ->select('id')
            ->from('master_medrespond_ip_addresses')
            ->where('ip_address', $ip_address)
            ->get();

        return ($query->num_rows() > 0) ? TRUE : FALSE;
    }

}

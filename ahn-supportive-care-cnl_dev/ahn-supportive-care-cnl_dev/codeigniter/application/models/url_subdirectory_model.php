<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Url_subdirectory_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function get()
	{
		$query = $this->db
			->select('subdirectory')
			->from('master_url_subdirectories')
			->where('url', base_url())
			->get();

		$data = array();

		if($query->num_rows() > 0) {
			foreach($query->result_array() as $row) {
				$data[] = $row['subdirectory'];
			}
		}

		return $data;
	}

	public function insert($subdirectory)
	{
		if(empty($subdirectory)) {
			return NULL;
		}

		$url = base_url();
		$subdirectory = $this->db->escape_str(str_replace('/', '' , $subdirectory));

		// prevent duplicate inserts
		return $this->db->query("
			INSERT INTO master_url_subdirectories (url, subdirectory) SELECT '$url', '$subdirectory' FROM DUAL
			WHERE NOT EXISTS (
					SELECT url, subdirectory FROM master_url_subdirectories
					WHERE
						url = '$url' AND
						subdirectory = '$subdirectory'
					LIMIT 1
			)
		");
	}

}

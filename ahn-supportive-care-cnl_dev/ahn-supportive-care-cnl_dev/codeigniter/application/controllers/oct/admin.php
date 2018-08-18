<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller_Hybrid {

	public function __construct() {
		parent::__construct();

		if(!is_admin() && !is_site_admin()) {
			redirect('/');
		}

		$this->load->library('oct_library');

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function ajax_angular_export_feedback_logs_spreadsheet() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Request');

		$data = array(
			'status'	=> 'success',
			'message'	=> '',
			'file'		=> ''
		);

		$filename = 'feedback_logs_'.date("Y-m-d_H-i-s").'.csv';
		$filepath = FCPATH.'tmp/'.$filename;
		$data['file'] = $filename;

		$status = FALSE;

		try {
			$status = $this->oct_library->write_feedback_logs_to_csv($filepath);
		} catch(Exception $e) {
			$data['status']	= 'failure';
			$data['message'] = $e->getMessage();
			log_error(__FILE__, __LINE__, __METHOD__, 'Unable to write csv file | error = ' . $data['message']);
			echo json_encode($data);
			return;
		}

		if($status === FALSE) {
			$data['status'] = 'failure';
			$data['message'] = 'No Records Returned... Aborting Download';
			log_info(__FILE__, __LINE__, __METHOD__, 'No records returned.  Aborting feedback logs csv export');
			echo json_encode($data);
			return;
		}

		log_info(__FILE__, __LINE__, __METHOD__, 'Request successful');
		echo json_encode($data);
	}

}

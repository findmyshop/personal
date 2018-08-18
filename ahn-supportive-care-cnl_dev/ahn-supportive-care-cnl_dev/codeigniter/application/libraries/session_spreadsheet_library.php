<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'libraries/third_party/PHPExcel/Classes/PHPExcel.php';
require_once APPPATH.'libraries/third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';

class Session_spreadsheet_library {

	public $ci = NULL;

	private $_debug = FALSE;

	private $_excel_obj = NULL;
	private $_excel_reader = NULL;
	private $_excel_writer = NULL;

	// spreadsheet row index variables
	private $_worksheet_title_row_index = 7;
	private $_session_table_heading_row_index = 9;
	private $_session_table_first_row_index = 10;
	private $_session_table_last_row_index = 0;
	private $_summary_table_title_row_index = 0;
	private $_summary_table_heading_row_index = 0;
	private $_summary_table_data_row_index = 0;

	// summary statistics variables
	private $_num_users_processed = 0;
	private $_session_count = 0; // used when calculating the average number of sessions per user
	private $_session_seconds = 0; // used when calculating the average time each user has spent on the site
	private $_user_session_seconds = array(); // used when calculating the median time users have spent on the site
	private $_num_responses_viewed = 0; // used when calculating the average number of reponses viewed per user
	private $_user_num_responses_viewed = array(); // used when calculating the median number of reponses viewed per user


	public function __construct() {
		DEFINE('USER_CHUNK_SIZE', 20);

		// the number of seconds between user activity that constitutes a session timeout strictly for reporting purposes
		DEFINE('SESSION_TIMEOUT_SECONDS', 180);

		// define spreadsheet column indices
		DEFINE('COLUMN_INDEX_USERNAME', 'A');
		DEFINE('COLUMN_INDEX_SESSION_END_DATE', 'B');
		DEFINE('COLUMN_INDEX_SESSION_END_TIME', 'C');
		DEFINE('COLUMN_INDEX_SESSION_LENGTH', 'D');
		DEFINE('COLUMN_INDEX_SESSION_NUM_RESPONSES_VIEWED', 'E');
		DEFINE('COLUMN_INDEX_TOTAL_SESSION_LENGTH', 'F');
		DEFINE('COLUMN_INDEX_TOTAL_NUM_RESPONSES_VIEWED', 'G');
		DEFINE('COLUMN_INDEX_TOTAL_NUM_SESSIONS', 'H');
		DEFINE('COLUMN_INDEX_FREEZE', 'I');

		DEFINE('COLUMN_INDEX_SUMMARY_TABLE_NUM_USERS', 'B');
		DEFINE('COLUMN_INDEX_SUMMARY_TABLE_AVERAGE_SESSION_LENGTH', 'C');
		DEFINE('COLUMN_INDEX_SUMMARY_TABLE_AVERAGE_NUM_RESPONSES_VIEWED', 'D');
		DEFINE('COLUMN_INDEX_SUMMARY_TABLE_AVERAGE_NUM_SESSIONS', 'E');
		DEFINE('COLUMN_INDEX_SUMMARY_TABLE_MEDIAN_SESSION_LENGTH', 'F');
		DEFINE('COLUMN_INDEX_SUMMARY_TABLE_MEDIAN_NUM_RESPONSES_VIEWED', 'G');

		// define spreadsheet column heading names
		DEFINE('COLUMN_HEADING_USERNAME', 'User');
		DEFINE('COLUMN_HEADING_SESSION_END_DATE', 'Date');
		DEFINE('COLUMN_HEADING_SESSION_END_TIME', 'Ending Time');
		DEFINE('COLUMN_HEADING_SESSION_LENGTH', 'Time on Site');
		DEFINE('COLUMN_HEADING_SESSION_NUM_RESPONSES_VIEWED', 'Responses Viewed');
		DEFINE('COLUMN_HEADING_TOTAL_SESSION_LENGTH', 'Total Time');
		DEFINE('COLUMN_HEADING_TOTAL_NUM_RESPONSES_VIEWED', 'Total Responses');
		DEFINE('COLUMN_HEADING_TOTAL_NUM_SESSIONS', 'Number of Sessions');

		DEFINE('COLUMN_HEADING_SUMMARY_TABLE_NUM_USERS', 'Number of Users');
		DEFINE('COLUMN_HEADING_SUMMARY_TABLE_AVERAGE_SESSION_LENGTH', 'Average Time');
		DEFINE('COLUMN_HEADING_SUMMARY_TABLE_AVERAGE_NUM_RESPONSES_VIEWED', 'Average Views');
		DEFINE('COLUMN_HEADING_SUMMARY_TABLE_AVERAGE_NUM_SESSIONS', 'Average Sessions');
		DEFINE('COLUMN_HEADING_SUMMARY_TABLE_MEDIAN_SESSION_LENGTH', 'Median Time');
		DEFINE('COLUMN_HEADING_SUMMARY_TABLE_MEDIAN_NUM_RESPONSES_VIEWED', 'Median Views');

		$this->ci = & get_instance();
		$this->ci->load->helper('array_helper');

		if(!$this->_debug) {
			$this->_excel_reader = PHPExcel_IOFactory::createReader('Excel2007');
			$this->_excel_obj = $this->_excel_reader->load(FCPATH.'/assets/medrespond/templates/excel/session-spreadsheet-template.xlsx');;
			$this->_excel_obj->setActiveSheetIndex(0);
			$this->_excel_writer = PHPExcel_IOFactory::createWriter($this->_excel_obj, "Excel2007");
			$this->_excel_obj->setActiveSheetIndex(0);
		}

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function write_to_file($mr_project_filter = NULL, $organization_hierarchy_level_elements_filter = array(), $user_id_filter = array(), $filename) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		if(!$this->_debug) {
			$this->_insert_worksheet_title();
			$this->_insert_session_table_headers();
			$spreadsheet_user_row = $this->_session_table_first_row_index;
			$spreadsheet_row = $spreadsheet_user_row;
		}

		$user_offset = 0;

		// fetch arrays of user_id, username pairs in chunks of size USER_CHUNK_SIZE
		while(($users = $this->_get_users($mr_project_filter, $organization_hierarchy_level_elements_filter, $user_id_filter, $user_offset))) {
			$user_ids = array();
			$user_session_map = array();

			foreach($users as $user) {
				$user_ids[] = $user['id'];
				$user_session_map[$user['id']] = array(
					'username'								=> $user['username'],
					'sessions'								=> array(),
					'total_time'							=> 0,
					'total_responses_viewed'	=> 0,
					'num_sessions'						=> 0
				);
			}

			// fetch activity for all user_ids in this particular round
			$activity = $this->_get_activity($mr_project_filter, $user_ids);

			// loop through all activity items and construct the sessions arrays for each user
			foreach($activity as $activity_item) {
				if(empty($user_session_map[$activity_item['user_id']]['sessions'])) {
					$user_session_map[$activity_item['user_id']]['sessions'][] = array($activity_item['date']);
					$user_session_map[$activity_item['user_id']]['num_sessions']++;
				} else {
					$session_index = count($user_session_map[$activity_item['user_id']]['sessions']) - 1;
					$activity_index = count($user_session_map[$activity_item['user_id']]['sessions'][$session_index]) -1;

					// determine whether or not this activity took place within SESSION_TIMEOUT_SECONDS of the most recent activity for this user
					if(strtotime('-'.SESSION_TIMEOUT_SECONDS.' seconds', strtotime($activity_item['date'])) <= strtotime($user_session_map[$activity_item['user_id']]['sessions'][$session_index][$activity_index])) {
						$user_session_map[$activity_item['user_id']]['sessions'][$session_index][] = $activity_item['date'];
					} else {
						$user_session_map[$activity_item['user_id']]['sessions'][] = array($activity_item['date']);
						$user_session_map[$activity_item['user_id']]['num_sessions']++;
					}
				}

				$user_session_map[$activity_item['user_id']]['total_responses_viewed']++;
			}

			if(!$this->_debug) {
				// loop through all users in this chunk to begin parsing their session activity and writing to the excell file
				foreach($user_session_map as $user_id => $row) {
					$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_USERNAME.$spreadsheet_user_row, $row['username']);
					$total_user_num_responses_viewed = 0;
					$total_user_session_seconds = 0;
					$total_user_session_count = count($row['sessions']);
					$this->_session_count += $total_user_session_count;
					$this->_num_users_processed++;

					// loop through each user's sessions and calculate values to write to file
					foreach($row['sessions'] as $sessions) {
						$session_num_responses_viewed = count($sessions);
						$total_user_num_responses_viewed += $session_num_responses_viewed;
						$last_session_activity_index = $session_num_responses_viewed - 1;

						$session_begin_timestamp = strtotime($sessions[0]);
						$session_end_timestamp = strtotime($sessions[$last_session_activity_index]);
						$session_num_seconds = $session_end_timestamp - $session_begin_timestamp + 60; // always add 60 seconds to each session to account for the length of time to play the last video
						$total_user_session_seconds += $session_num_seconds;
						$session_end_date = date('n/j/y', $session_end_timestamp);
						$session_end_time = date('g:i A', $session_end_timestamp);
						$session_length = sprintf('%02d:%02d:%02d', ($session_num_seconds/3600),($session_num_seconds/60%60), $session_num_seconds%60);

						// write individual user session data
						$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_SESSION_END_DATE.$spreadsheet_row, $session_end_date);
						$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_SESSION_END_TIME.$spreadsheet_row, $session_end_time);
						$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_SESSION_LENGTH.$spreadsheet_row, $session_length);
						$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_SESSION_NUM_RESPONSES_VIEWED.$spreadsheet_row, $session_num_responses_viewed);

						$spreadsheet_row++;
					}

					$this->_session_seconds += $total_user_session_seconds;
					$this->_user_session_seconds[] = $total_user_session_seconds;
					$this->_num_responses_viewed += $total_user_num_responses_viewed;
					$this->_user_num_responses_viewed[] = $total_user_num_responses_viewed;

					// write user session totals data
					$total_user_session_length = sprintf('%02d:%02d:%02d', ($total_user_session_seconds/3600),($total_user_session_seconds/60%60), $total_user_session_seconds%60);
					$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_TOTAL_SESSION_LENGTH.$spreadsheet_user_row, $total_user_session_length);
					$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_TOTAL_NUM_RESPONSES_VIEWED.$spreadsheet_user_row, $total_user_num_responses_viewed);
					$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_TOTAL_NUM_SESSIONS.$spreadsheet_user_row, $total_user_session_count);

					$spreadsheet_row++;
					$spreadsheet_user_row = $spreadsheet_row;
				}
			}

			if($this->_debug) {
				pp($user_session_map, FALSE);
			}

			$user_offset += USER_CHUNK_SIZE;
		}

		if(!$this->_debug) {
			$this->_format_session_table();
			$this->_insert_summary_table();
			$this->_excel_writer->save($filename);
		}
	}

	private function _format_session_table() {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$this->_session_table_last_row_index = $this->_excel_obj->getActiveSheet()->getHighestRow();
		$this->_set_session_table_alternating_row_background_colors();
		$this->_set_session_table_border_color();
		$this->_set_session_table_cell_alignment();
		$this->_set_session_table_column_formats();
	}

	private function _get_activity($mr_project_filter = NULL, $user_ids) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$this->ci->db
			->select('user_id, date')
			->from('master_activity_logs')
			->join('master_users', 'master_users.id = master_activity_logs.user_id')
			->where_in('user_id', $user_ids)
			->order_by('username ASC, date ASC');

		if(!empty($mr_project_filter)) {
			$mr_project_filter = $this->ci->db->escape_str($mr_project_filter);
			$this->ci->db->where("master_activity_logs.mr_project = '$mr_project_filter'");
		}

		$query = $this->ci->db->get();

		if($query->num_rows() > 0) {
			return $query->result_array();
		}

		return array();
	}

	private function _get_users($mr_project_filter = NULL, $organization_hierarchy_level_elements_filter = array(), $user_id_filter = array(), $user_offset = 0) {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$where_user_id = '1 = 1';
		$where_mr_project = '1 = 1';
		$where_organization_hierarchy = '1 = 1';

		if(!empty($user_id_filter)) {
			$where_user_id = 'master_users.id NOT IN (' . implode(', ', $user_id_filter) . ')';
		}

		if(!empty($mr_project_filter)) {
			$mr_project_filter = $this->ci->db->escape_str($mr_project_filter);
			$where_mr_project = "mr_project = '$mr_project_filter'";
		}

		if(!empty($organization_hierarchy_level_elements_filter)) {
			foreach($organization_hierarchy_level_elements_filter as $element_id) {
				if(is_numeric($element_id) && $element_id > 0) {
					$where_organization_hierarchy .= "
						AND EXISTS (
							SELECT *
							FROM master_users_organization_hierarchy_level_element_map AS muohlem
							WHERE
								muohlem.user_id = master_users.id
								AND muohlem.organization_hierarchy_level_element_id = $element_id
								AND muohlem.active = 1
						)
					";
				}
			}
		}

		$sql = '
			SELECT
				id,
				username
			FROM master_users
			WHERE
				' . $where_user_id . '
				AND user_type_id = 4
				AND active = 1
				AND id IN (SELECT user_id FROM master_activity_logs WHERE ' . $where_mr_project . ')
				AND ' . $where_organization_hierarchy . '
			ORDER BY username ASC
			LIMIT ' . USER_CHUNK_SIZE . ' OFFSET '. $user_offset
		;

		$query = $this->ci->db->query($sql);

		if($query->num_rows() > 0) {
			return $query->result_array();
		}

		return array();
	}

	private function _insert_session_table_headers() {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		// set the session table column header values
		$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_USERNAME.$this->_session_table_heading_row_index, COLUMN_HEADING_USERNAME);
		$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_SESSION_END_DATE.$this->_session_table_heading_row_index, COLUMN_HEADING_SESSION_END_DATE);
		$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_SESSION_END_TIME.$this->_session_table_heading_row_index, COLUMN_HEADING_SESSION_END_TIME);
		$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_SESSION_LENGTH.$this->_session_table_heading_row_index, COLUMN_HEADING_SESSION_LENGTH);
		$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_SESSION_NUM_RESPONSES_VIEWED.$this->_session_table_heading_row_index, COLUMN_HEADING_SESSION_NUM_RESPONSES_VIEWED);
		$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_TOTAL_SESSION_LENGTH.$this->_session_table_heading_row_index, COLUMN_HEADING_TOTAL_SESSION_LENGTH);
		$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_TOTAL_NUM_RESPONSES_VIEWED.$this->_session_table_heading_row_index, COLUMN_HEADING_TOTAL_NUM_RESPONSES_VIEWED);
		$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_TOTAL_NUM_SESSIONS.$this->_session_table_heading_row_index, COLUMN_HEADING_TOTAL_NUM_SESSIONS);
		// make the column headers bold
		$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_USERNAME.$this->_session_table_heading_row_index.':'.COLUMN_INDEX_TOTAL_NUM_SESSIONS.$this->_session_table_heading_row_index)->getFont()->setBold(true);
		// freeze the column headers row
		$this->_excel_obj->getActiveSheet()->freezePane(COLUMN_INDEX_FREEZE.$this->_session_table_first_row_index);
		// set auto sizing on columns
		foreach(range(COLUMN_INDEX_USERNAME, COLUMN_INDEX_TOTAL_NUM_SESSIONS) as $column_id) {
			$this->_excel_obj->getActiveSheet()->getColumnDimension($column_id)->setAutoSize(true);
		}
	}

	private function _insert_summary_table() {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$this->_summary_table_title_row_index = $this->_session_table_last_row_index + 2;
		$this->_summary_table_heading_row_index = $this->_summary_table_title_row_index + 1;
		$this->_summary_table_data_row_index = $this->_summary_table_heading_row_index + 1;
		$this->_set_summary_table_formats();
		$this->_insert_summary_table_title();
		$this->_insert_summary_table_headings();
		$this->_insert_summary_table_data();
	}

	private function _insert_summary_table_data() {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$average_session_seconds = ($this->_num_users_processed > 0) ? ($this->_session_seconds / $this->_num_users_processed) : 0;
		$average_session_length = sprintf('%02d:%02d:%02d', ($average_session_seconds/3600),($average_session_seconds/60%60), $average_session_seconds%60);
		$average_session_count = ($this->_num_users_processed > 0) ? ($this->_session_count / $this->_num_users_processed) : 0;
		$median_session_seconds = empty($this->_user_session_seconds) ? 0 : calculate_array_median($this->_user_session_seconds);
		$median_session_length = sprintf('%02d:%02d:%02d', ($median_session_seconds/3600),($median_session_seconds/60%60), $median_session_seconds%60);
		$average_reponses_viewed = ($this->_num_users_processed > 0) ? ($this->_num_responses_viewed / $this->_num_users_processed) : 0;
		$median_responses_viewed = (empty($this->_user_num_responses_viewed)) ? 0 : calculate_array_median($this->_user_num_responses_viewed);

		$this->_excel_obj->getActiveSheet()
			->setCellValue(COLUMN_INDEX_SUMMARY_TABLE_NUM_USERS.$this->_summary_table_data_row_index, $this->_num_users_processed);
		$this->_excel_obj->getActiveSheet()
			->setCellValue(COLUMN_INDEX_SUMMARY_TABLE_AVERAGE_SESSION_LENGTH.$this->_summary_table_data_row_index, $average_session_length);
		$this->_excel_obj->getActiveSheet()
			->setCellValue(COLUMN_INDEX_SUMMARY_TABLE_AVERAGE_NUM_RESPONSES_VIEWED.$this->_summary_table_data_row_index, $average_reponses_viewed);
		$this->_excel_obj->getActiveSheet()
			->setCellValue(COLUMN_INDEX_SUMMARY_TABLE_AVERAGE_NUM_SESSIONS.$this->_summary_table_data_row_index, $average_session_count);
		$this->_excel_obj->getActiveSheet()
			->setCellValue(COLUMN_INDEX_SUMMARY_TABLE_MEDIAN_SESSION_LENGTH.$this->_summary_table_data_row_index, $median_session_length);
		$this->_excel_obj->getActiveSheet()
			->setCellValue(COLUMN_INDEX_SUMMARY_TABLE_MEDIAN_NUM_RESPONSES_VIEWED.$this->_summary_table_data_row_index, $median_responses_viewed);
	}

	private function _insert_summary_table_headings() {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_SUMMARY_TABLE_NUM_USERS.$this->_summary_table_heading_row_index, COLUMN_HEADING_SUMMARY_TABLE_NUM_USERS);
		$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_SUMMARY_TABLE_AVERAGE_SESSION_LENGTH.$this->_summary_table_heading_row_index, COLUMN_HEADING_SUMMARY_TABLE_AVERAGE_SESSION_LENGTH);
		$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_SUMMARY_TABLE_AVERAGE_NUM_RESPONSES_VIEWED.$this->_summary_table_heading_row_index, COLUMN_HEADING_SUMMARY_TABLE_AVERAGE_NUM_RESPONSES_VIEWED);
		$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_SUMMARY_TABLE_AVERAGE_NUM_SESSIONS.$this->_summary_table_heading_row_index, COLUMN_HEADING_SUMMARY_TABLE_AVERAGE_NUM_SESSIONS);
		$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_SUMMARY_TABLE_MEDIAN_SESSION_LENGTH.$this->_summary_table_heading_row_index, COLUMN_HEADING_SUMMARY_TABLE_MEDIAN_SESSION_LENGTH);
		$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_SUMMARY_TABLE_MEDIAN_NUM_RESPONSES_VIEWED.$this->_summary_table_heading_row_index, COLUMN_HEADING_SUMMARY_TABLE_MEDIAN_NUM_RESPONSES_VIEWED);
	}

	private function _insert_summary_table_title() {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$this->_excel_obj->getActiveSheet()->setCellValue(COLUMN_INDEX_SUMMARY_TABLE_NUM_USERS.$this->_summary_table_title_row_index, 'Summary Table');
	}

	private function _insert_worksheet_title() {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$organization = $this->ci->organization_model->get_organization_by_property_name(MR_PROJECT);
		$property = $this->ci->property_model->get_property_by_name(MR_PROJECT);
		$title = 'Summary Statistics for ' . $organization['name'] . ' ' . $property['title'] . ' Through ' . date('m/d/y g:i A') . ' UTC';
		$this->_excel_obj->getActiveSheet()->setCellValue('A'.$this->_worksheet_title_row_index, $title);
		$this->_excel_obj->getActiveSheet()->getStyle('A'.$this->_worksheet_title_row_index.':'.'E'.$this->_worksheet_title_row_index)
			->getFont()->setBold(true);
		$this->_excel_obj->getActiveSheet()->getStyle('A'.$this->_worksheet_title_row_index.':'.'E'.$this->_worksheet_title_row_index)
			->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	}

	private function _set_session_table_alternating_row_background_colors() {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		for($row = $this->_session_table_heading_row_index; $row <= $this->_session_table_last_row_index; $row++) {
			if($row % 2 == 0) {
				$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_USERNAME.$row.':'.COLUMN_INDEX_TOTAL_NUM_SESSIONS.$row)->applyFromArray(array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'DDEBF6')
					)
				));
			} else {
				$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_USERNAME.$row.':'.COLUMN_INDEX_TOTAL_NUM_SESSIONS.$row)->applyFromArray(array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'BED7ED')
					)
				));
			}
		}
	}

	private function _set_session_table_border_color() {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_USERNAME.$this->_session_table_heading_row_index.':'.COLUMN_INDEX_TOTAL_NUM_SESSIONS.$this->_session_table_last_row_index)->applyFromArray(array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '9CC3E4')
				)
			)
		));
	}

	private function _set_session_table_cell_alignment() {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		// left align the session table header row cell text
		$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_USERNAME.$this->_session_table_heading_row_index.':'.COLUMN_INDEX_TOTAL_NUM_SESSIONS.$this->_session_table_heading_row_index)
			->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		// left align the username column cell text
		$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_USERNAME .$this->_session_table_first_row_index.':'.COLUMN_INDEX_USERNAME.$this->_session_table_last_row_index)
			->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		// right align the remaining session table cell text
		$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_SESSION_END_DATE .$this->_session_table_first_row_index.':'. COLUMN_INDEX_TOTAL_NUM_SESSIONS.$this->_session_table_last_row_index)
			->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	}

	private function _set_session_table_column_formats() {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		// set the date column format
		$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_SESSION_END_DATE.$this->_session_table_first_row_index.':'.COLUMN_INDEX_SESSION_END_DATE.$this->_session_table_last_row_index)
			->getNumberFormat()
			->setFormatCode('m/d/y');
		// set the session length column format
		$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_SESSION_LENGTH.$this->_session_table_first_row_index.':'.COLUMN_INDEX_SESSION_LENGTH.$this->_session_table_last_row_index)
			->getNumberFormat()
			->setFormatCode('[hh]:mm:ss');
		// set total session length column format
		$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_TOTAL_SESSION_LENGTH.$this->_session_table_first_row_index.':'.COLUMN_INDEX_TOTAL_SESSION_LENGTH.$this->_session_table_last_row_index)
			->getNumberFormat()
			->setFormatCode('[hh]:mm:ss');
	}

	private function _set_summary_table_formats() {
		log_debug(__FILE__, __LINE__, __METHOD__, 'Called');

		// merge the summary table title cells
		$this->_excel_obj->getActiveSheet()->mergeCells(COLUMN_INDEX_SUMMARY_TABLE_NUM_USERS.$this->_summary_table_title_row_index.':'.COLUMN_INDEX_SUMMARY_TABLE_MEDIAN_NUM_RESPONSES_VIEWED.$this->_summary_table_title_row_index);
		// set the summary table border format
		$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_SUMMARY_TABLE_NUM_USERS.$this->_summary_table_title_row_index.':'.COLUMN_INDEX_SUMMARY_TABLE_MEDIAN_NUM_RESPONSES_VIEWED.$this->_summary_table_data_row_index)->applyFromArray(array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'color' => array('rgb' => '000000')
				)
			)
		));

		// make the summary table title and heading fonts bold
		$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_SUMMARY_TABLE_NUM_USERS.$this->_summary_table_title_row_index.':'.COLUMN_INDEX_SUMMARY_TABLE_MEDIAN_NUM_RESPONSES_VIEWED.$this->_summary_table_heading_row_index)
			->getFont()->setBold(true);
		// center align the summary table title text
		$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_SUMMARY_TABLE_NUM_USERS.$this->_summary_table_title_row_index.':'.COLUMN_INDEX_SUMMARY_TABLE_MEDIAN_NUM_RESPONSES_VIEWED.$this->_summary_table_title_row_index)
			->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		// left align the summary table heading cell text
		$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_SUMMARY_TABLE_NUM_USERS.$this->_summary_table_heading_row_index.':'.COLUMN_INDEX_SUMMARY_TABLE_MEDIAN_NUM_RESPONSES_VIEWED.$this->_summary_table_heading_row_index)
			->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		// right align the summary table data row text
		$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_SUMMARY_TABLE_NUM_USERS.$this->_summary_table_data_row_index.':'.COLUMN_INDEX_SUMMARY_TABLE_MEDIAN_NUM_RESPONSES_VIEWED.$this->_summary_table_data_row_index)
			->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		// set time and decimal cell formats
		$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_SUMMARY_TABLE_AVERAGE_SESSION_LENGTH.$this->_summary_table_data_row_index)
			->getNumberFormat()
			->setFormatCode('[hh]:mm:ss');
		$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_SUMMARY_TABLE_AVERAGE_NUM_RESPONSES_VIEWED.$this->_summary_table_data_row_index)
			->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
		$this->_excel_obj->getActiveSheet()->getStyle(COLUMN_INDEX_SUMMARY_TABLE_AVERAGE_NUM_SESSIONS.$this->_summary_table_data_row_index)
			->getNumberFormat()
			->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
	}

}
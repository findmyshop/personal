<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Action_model extends CI_Model {

	// ------------------------
	// admin views
	// ------------------------
	const ACTION_TYPE_DASHBOARD_VIEW										= 'dashboard_view';
	const ACTION_TYPE_USERS_VIEW												= 'users_view';
	const ACTION_TYPE_ACTIVITY_LOGS_VIEW								= 'activity_logs_view';
	// SBIRT
	const ACTION_TYPE_REPORTS_VIEW											= 'reports_view';
	const ACTION_TYPE_STATISTICS_VIEW										= 'statistics_view';
	// ------------------------
	// admin inserts/updates
	// ------------------------
	const ACTION_TYPE_USER_INSERT												= 'user_insert';
	const ACTION_TYPE_USER_UPDATE												= 'user_update';
	// ------------------------
	// admin csv exports
	// ------------------------
	const ACTION_TYPE_DASHBOARD_CSV_EXPORT 							= 'dashboard_csv_export';
	const ACTION_TYPE_USERS_CSV_EXPORT									= 'users_csv_export';
	const ACTION_TYPE_ACTIVITY_LOGS_CSV_EXPORT					= 'activity_logs_csv_export';
	// SBIRT
	const ACTION_TYPE_REPORTS_CSV_EXPORT								= 'reports_csv_export';
	const ACTION_TYPE_DETAILED_REPORTS_CSV_EXPORT				= 'detailed_reports_csv_export';
	const ACTION_TYPE_ANSWERS_CSV_EXPORT								= 'answers_csv_export';
	const ACTION_TYPE_ACCREDITATION_REPORTS_CSV_EXPORT	= 'accreditation_reports_csv_export';

	private $_valid_action_types = array(
		self::ACTION_TYPE_DASHBOARD_VIEW,
		self::ACTION_TYPE_USERS_VIEW,
		self::ACTION_TYPE_ACTIVITY_LOGS_VIEW,
		self::ACTION_TYPE_REPORTS_VIEW,
		self::ACTION_TYPE_STATISTICS_VIEW,
		self::ACTION_TYPE_USER_INSERT,
		self::ACTION_TYPE_USER_UPDATE,
		self::ACTION_TYPE_DASHBOARD_CSV_EXPORT,
		self::ACTION_TYPE_USERS_CSV_EXPORT,
		self::ACTION_TYPE_ACTIVITY_LOGS_CSV_EXPORT,
		self::ACTION_TYPE_REPORTS_CSV_EXPORT,
		self::ACTION_TYPE_DETAILED_REPORTS_CSV_EXPORT,
		self::ACTION_TYPE_ANSWERS_CSV_EXPORT,
		self::ACTION_TYPE_ACCREDITATION_REPORTS_CSV_EXPORT
	);

	public function __construct() {
		parent::__construct();

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	public function insert($action_type) {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called with action_type = ' . $action_type);

		if(!isset($action_type, $this->_valid_action_types)) {
			return NULL;
		}

		$os = $this->agent->platform();
		$browser = $this->agent->browser();
		$version_split = explode('.', $this->agent->version());
		$browser_version = $version_split[0];

		$data = array(
			'property_name'			=> MR_PROJECT,
			'session_id'				=> $this->session->userdata('session_id'),
			'ip_address'				=> $this->session->userdata('ip_address'),
			'operating_system'	=> $os,
			'browser'						=> $browser . ' ' . $browser_version,
			'user_id'						=> $this->session->userdata('account_id'),
			'action_type'				=> $action_type
		);

		$this->db->insert('master_actions', $data);
		return $this->db->insert_id();
	}

	public function get() {
		log_info(__FILE__, __LINE__, __METHOD__, 'Called');

		$query = $this->db
			->select('ma.property_name, ma.user_id, mu.username, ma.session_id, ma.ip_address, ma.operating_system, ma.browser, ma.action_type, ma.timestamp')
			->from('master_actions AS ma')
			->join('master_users AS mu', 'mu.id = ma.user_id')
			->order_by('timestamp', 'desc')
			->get();

		if($query->num_rows() > 0) {
			return $query->result_array();
		}

		return array();
	}

}

/* End of file action_model.php */
/* Location: ./application/models/action_model.php */

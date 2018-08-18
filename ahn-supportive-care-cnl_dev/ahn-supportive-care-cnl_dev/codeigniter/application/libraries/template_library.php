<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template_Library
{
	var $CI																= FALSE;		// CodeIgniter Global Instance
	var $account_id												= FALSE;		// Current User's Account ID
	var $segment													= FALSE;		// Array of uri segments
	var $tags															= array();
	var $links														= FALSE;
	protected $_project									 = '';
	protected $_cache_lifetime						= 0;
	protected $_assets										= array();
	protected $_meta											= array();
	protected $_module										= '';
	protected $_title											= '';
	protected $_logo_url									= '';
	protected $_body_class								= '';
	public		$_data											= array();
	protected $_bread_crumbs							= array();
	protected $_using_angularjs						= FALSE;
	protected $_angularjs_app							= '';
	protected $_timeout_check_interval		= FALSE;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->config('project');
		$this->CI->load->config('links');
		$this->CI->load->config('iframe_whitelist');
		$this->account_id = $this->CI->session->userdata('account_id');
		$this->links = $this->compile_links();
		/* Crunch CSS JS */
		$this->CI->load->library('carabiner');
		$this->CI->load->library('cssmin');
		$this->CI->load->library('jsmin');
		/* Breadcrumbs */
		$this->segment = array('1' => NULL,'2' => NULL,'3' => NULL,'4' => NULL,);
		$segment_array = $this->CI->uri->segment_array();
		$this->compile_bread_crumbs($segment_array);
		/* Body Class */

		$this->_body_class = $this->CI->router->fetch_class();

		$this->_project = $this->CI->config->item('project');
		$this->_assets = $this->CI->config->item('assets');
		$this->_title =	 $this->CI->config->item('title');
		$this->_logo_url = asset_url().'/projects/'.MR_PROJECT.'/images/logo.png';

		log_debug(__FILE__, __LINE__, __METHOD__, 'Initialized');
	}

	/*
	+-------------------------------------+
		Name: add_meta
		Purpose: adds meta tags to the page header
		@param return : this object
	+-------------------------------------+
	*/
	public function add_meta($meta)
	{
		if(isset($meta[0]))
		{
			foreach($meta as $m)
			{
				$this->_meta[] = $m;
			}
		}
		else
		{
			$this->_meta[] = $meta;
		}
		return $this;
	}
	/*
	+-------------------------------------+
		Name: add_assets
		Purpose: adds assets from config
		@param return : this object
	+-------------------------------------+
	*/
	public function add_assets($assets){
		if(isset($assets[0])){
			foreach($meta as $m){
				$this->_meta[] = $m;
			}
		}
		else{
			$this->_meta[] = $meta;
		}
		return $this;
	}
	/*
	+-------------------------------------+
		Name: append_title
		Purpose: append to the title
		@param return : $this
	+-------------------------------------+
	*/
	public function append_title($title, $seperator = ' - ')
	{
		$this->_title = $this->_title.$seperator.$title;
		return $this;
	}
	/*
	+-------------------------------------+
		Name: build
		Purpose: compiles the project together and generates the output
		@param return : none
	+-------------------------------------+
	*/
	public function build($stage = NULL, $data = array(), $header = NULL, $content = NULL,	$return = FALSE)
	{
		if(empty($stage))
		{
			log_error(__FILE__, __LINE__, __METHOD__, '$stage must be set');
			show_error('Cannot load NULL page.', 404);
		}

		log_info(__FILE__, __LINE__, __METHOD__, 'Called stage = ' . $stage . ' | header = ' . $header. ' | content = ' . $content);

		// Profiler & Headers & Caches OH MY!
		$this->CI->output->cache($this->_cache_lifetime);
		$this->set_headers();

		// Setting project variables
		$data['page']							= $this->compile_page_data();
		$data['project']					= MR_PROJECT;
		$data['links']						= $this->compile_links();
		$data['me']								= $this->CI->user_model->get_user($this->account_id);
		$data['data']							= $data;
		$data['iframe_whitelist'] = $this->get_iframe_whitelist();

		if (!isset($data['response'])) {
			$data['data']['response'] = array('id' => false,
																'name' => false,
																'video_text' => false,
																'video_name' => false);
		}


		if (!empty($stage)){
			if (file_exists(APPPATH."views/".$this->_project."/".$stage.".php")){
				$data['stage'] = $data['project'] . '/' . $stage;
			}else{
				if (file_exists(APPPATH."views/default_".MR_TYPE."/".$stage.".php")){
					$data['stage'] = 'default_'.MR_TYPE.'/' . $stage;
				}else{
					$data['stage'] = 'default/' . $stage;
				}
			}
		}
		if (!empty($header)){
			if (file_exists(APPPATH."views/".$this->_project."/".$header.".php")){
				$data['header'] = $data['project'] . '/' . $header;
			}else{
				if (file_exists(APPPATH."views/default_".MR_TYPE."/".$header.".php")){
					$data['header'] = 'default_'.MR_TYPE.'/' . $header;
				}else{
					$data['header'] = 'default/' . $header;
				}
			}
		}
		if (!empty($content)){
			if (file_exists(APPPATH."views/".$this->_project."/".$content.".php")){
				$data['content'] = $data['project'] . '/' . $content;
			}else{
				if (file_exists(APPPATH."views/default_".MR_TYPE."/".$content.".php")){
					$data['content'] = 'default_'.MR_TYPE.'/' . $content;
				}else{
					$data['content'] = 'default/' . $content;
				}
			}
		}
		if (file_exists(APPPATH."views/".$this->_project."/".strtolower($this->CI->router->fetch_class())."/main.php")){
			$view = $this->_project."/".strtolower($this->CI->router->fetch_class())."/main.php";
		}
		elseif (file_exists(APPPATH."views/".$this->_project."/main.php")){
			$view = $data['project']."/main.php";
		}else{
			if (file_exists(APPPATH."views/default_".MR_TYPE."/main.php")){
				$view = 'default_'.MR_TYPE.'/main.php';
			}else{
				$view = 'default/main.php';
			}
		}
		$this->CI->config->set_item('links', $data['links']);

		$this->set_data($data);

		// Generate and Output the view
		log_info(__FILE__, __LINE__, __METHOD__, "Loading $view");
		return $this->CI->load->view($view, $this->_data, $return);
	}

	/*
	+-------------------------------------+
		Name: compile_bread_crumbs
		Purpose: compile breadcrumbs
		@param return : none
	+-------------------------------------+
	*/
	private function compile_bread_crumbs($segment_array)
	{
		$this->_bread_crumbs = array('Admin' => '/admin');
		$path = "";
		$count = 0;

		foreach ($segment_array as $segment)
		{
			$count++;
			$path .= ('/' . $segment);

			if ($segment == 'organization')
			{
				$this->_bread_crumbs['Organizations'] = '/admin/organizations';
				$this->_bread_crumbs['^organization_name^'] = '';
				$this->_bread_crumbs['Classes'] = '';
				break;
			}
			elseif ($segment == 'class_')
			{
				$this->_bread_crumbs['Organizations'] = '/admin/organizations';
				$this->_bread_crumbs['^organization_name^'] = '/admin/organization/^organization_id^';
				$this->_bread_crumbs['Classes'] = '';
				$this->_bread_crumbs['^class_name^'] = '';
				break;
			}
			elseif ($segment == 'instructors')
			{
				if (is_admin())
				{
					$this->_bread_crumbs['Organizations'] = '/admin/organizations';
					$this->_bread_crumbs['^organization_name^'] = '/admin/organization/^organization_id^';
					$this->_bread_crumbs['Instructors'] = '';
				}
				else
				{
					$this->_bread_crumbs['Instructors'] = '';
				}
				break;
			}
			elseif ($segment == 'instructor')
			{
				if (is_admin())
				{
					$this->_bread_crumbs['Organizations'] = '/admin/organizations';
					$this->_bread_crumbs['^organization_name^'] = '/admin/organization/^organization_id^';
					$this->_bread_crumbs['Instructors'] = '/admin/instructors';
					$this->_bread_crumbs['^instructor_name^'] = '';
				}
				else
				{
					$this->_bread_crumbs['Instructors'] = '/admin/instructors';
					$this->_bread_crumbs['^instructor_name^'] = '';
				}
				break;
			}
			elseif ($segment == 'student')
			{
				$this->_bread_crumbs['Students'] = '/admin/students';
				$this->_bread_crumbs['^student_name^'] = '';
				break;
			}
			elseif ($segment == 'student_no_exam')
			{
				$this->_bread_crumbs['Students'] = '/admin/students';
				$this->_bread_crumbs['^student_name^'] = '';
				break;
			}
			else
			{
				$this->_bread_crumbs[ucwords(str_replace('_', ' ', $segment))] = ((count($segment_array) == $count) || $count >= 2) ? '' : $path;;

			}
		}
	}

	/*
	+-------------------------------------+
		Name: compile_links
		Purpose: compiles the links for the project
		@param return : array of links
	+-------------------------------------+
	*/
	private function compile_links()
	{
		$links = $this->CI->config->item('links');
		return $links;
	}

	/*
	+-------------------------------------+
		Name: compile_page_data
		Purpose: compiles the page meta data together
		@param return : array
	+-------------------------------------+
	*/
	private function compile_page_data()
	{
		return array(
			'project'					 => $this->_project,
			'assets'						=> $this->_assets,
			'meta'						 => $this->_meta,
			'module'					 => $this->_module,
			'title'						 => $this->_title,
			'body_class'				=> $this->_body_class,
			'logo_url'					=> $this->_logo_url,
			'bread_crumbs'				=> $this->_bread_crumbs,
			'using_angularjs'			 => $this->_using_angularjs,
			'angularjs_app'				 => $this->_angularjs_app,
			'timeout_check_interval'	=> $this->_timeout_check_interval
		);
	}

	private function get_iframe_whitelist()
	{
		$iframe_whitelist = $this->CI->config->item('iframe_whitelist');
		if(IFRAME_WHITELIST_DEFINED)
		{
			return $iframe_whitelist[MR_PROJECT];
		}

		return array();
	}

	/*
	+-------------------------------------+
		Name: prepend_title
		Purpose: prepend to the title
		@param return : $this
	+-------------------------------------+
	*/
	public function prepend_title($title, $seperator = ' - ')
	{
		$this->_title = $title.$seperator.$this->_title;
		return $this;
	}

	/*
	+-------------------------------------+
		Name: set_cache
		Purpose: sets the codeigniter cache's expiration in minutes
		@param return : none
	+-------------------------------------+
	*/
	public function set_cache($minutes)
	{
		 $this->_cache_lifetime = $minutes;
		 return $this;
	}

	/*
	+-------------------------------------+
		Name: set_data
		Purpose: sets more data to the array to be sent to the project
		@param return : this object
	+-------------------------------------+
	*/
	public function set_data($data)
	{
		$this->_data = array_merge($this->_data, $data);
		return $this;
	}

	/*
	+-------------------------------------+
		Name: set_headers
		Purpose: sets nessesary headers
		@param return : none
	+-------------------------------------+
	*/
	private function set_headers()
	{
		$this->CI->output->set_header('HTTP/1.0 200 OK');
		$this->CI->output->set_header('HTTP/1.1 200 OK');
		$this->CI->output->set_header('Expires: Sat, 01 Jan 2000 00:00:01 GMT');
		if($this->CI->router->fetch_class() != 'register')
		{
			$this->CI->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
			$this->CI->output->set_header('Cache-Control: post-check=0, pre-check=0, max-age=0');
			$this->CI->output->set_header('Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
		}
		$this->CI->output->set_header('Pragma: no-cache');
		return $this;
	}

	/*
	+-------------------------------------+
		Name: set_module
		Purpose: sets the title module
		@param return : this object
	+-------------------------------------+
	*/
	public function set_module($module)
	{
		$this->_module = ucwords($module);
		return $this;
	}

	/*
	+-------------------------------------+
		Name: set_project
		Purpose: sets the project for the builder to use
		@param return : none
	+-------------------------------------+
	*/
	public function set_project($project)
	{
		$this->_project = $project;

		// Rebuild stuff built in the constructor that relies on the project
		$this->_title =	 $this->CI->config->item('title');

		return $this;
	}

	public function set_timeout_check_interval($interval)
	{
		$this->_timeout_check_interval = $interval * 1000;
		return $this;
	}

	/*
	+-------------------------------------+
		Name: set_title
		Purpose: sets the title
		@param return : this object
	+-------------------------------------+
	*/
	public function set_title($title, $uc = TRUE)
	{
		$this->_title = ($uc) ? ucwords($title) : $title;
		return $this;
	}
	/*
	+-------------------------------------+
		Name: set_body_class
		Purpose: sets the title
		@param return : this object
	+-------------------------------------+
	*/
	public function set_body_class($c)
	{
		$this->_body_class = $c;
		return $this;
	}
	public function set_using_angularjs($flag = FALSE , $angularjs_app = '')
	{
		$this->_using_angularjs = $flag;
		$this->_angularjs_app = $angularjs_app;

		return $this;
	}
}
/* End of file project_library.php */
/* Location: ./application/libraries/project_library.php */

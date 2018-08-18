<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	 example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	 http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	 $route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	 $route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

function mr_get_controller_name_from_uri() {
	$uri = $_SERVER['REQUEST_URI'];
	if(($query_string_start_position = strpos($uri, '?')) !== FALSE) {
		// strip the query string from the uri
		$uri = substr($uri, 0, $query_string_start_position);
	}
	$pattern = '/^' . preg_quote('/' . MR_DIRECTORY, '/') . '/';
	$uri = preg_replace($pattern, '', $uri);
	$segments =  explode('/', $uri);
	return $segments[0];
}

$controller_name = mr_get_controller_name_from_uri();

if(empty($controller_name)) {
	$controller_name = 'base';
}
/* temporarily disabled enersource redirect
// redirect production, non-admin requests to http://www.enersource.com
if(MR_PROJECT === 'enr' && ENVIRONMENT === 'production') {
	$is_admin_request = ($controller_name === 'admin');
	$is_admin_login_request = (substr(rtrim($_SERVER['REQUEST_URI'], '/'), -strlen('/login/admin')) === '/login/admin');
	$is_ajax_login_request = (IS_AJAX && substr(rtrim($_SERVER['REQUEST_URI'], '/'), -strlen('/login/ajax_login')) === '/login/ajax_login');
	$is_ajax_logout_request = (IS_AJAX && substr(rtrim($_SERVER['REQUEST_URI'], '/'), -strlen('/login/ajax_logout')) === '/login/ajax_logout');
	$is_default_request = (substr(rtrim($_SERVER['REQUEST_URI'], '/'), -strlen('/enr')) === '/enr');

	if(!$is_admin_request && !$is_admin_login_request && !$is_ajax_login_request && !$is_ajax_logout_request && !$is_default_request) {
		header('Location: http://www.enersource.com');
		die;
	}
}
*/

// Redirect to a url that includes the MR_DIRECTORY when it's missing from the request
if(0 !== strpos($_SERVER['REQUEST_URI'], '/'.rtrim(MR_DIRECTORY, '/'))) {
	header('Location: '.$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.rtrim(MR_DIRECTORY, '/').$_SERVER['REQUEST_URI']);
	die;
}

if (file_exists(APPPATH."controllers/".MR_PROJECT."/". $controller_name .".php")){
	$route[MR_DIRECTORY.'~(:any)'] = MR_PROJECT."/login/login_by_username/$1";
	$route[MR_DIRECTORY.'(:any)'] = MR_PROJECT."/$1";
	$route['default_controller'] = MR_PROJECT."/base";
	$route[rtrim(MR_DIRECTORY, "/")] = MR_PROJECT."/base";
} else {
	$route[MR_DIRECTORY.'~(:any)'] = "default_".MR_TYPE."/login/login_by_username/$1";
	$route[MR_DIRECTORY.'(:any)'] = "default_".MR_TYPE."/$1";
	$route['default_controller'] = "default_".MR_TYPE."/base";
	$route[rtrim(MR_DIRECTORY, "/")] = "default_".MR_TYPE."/base";
}

$route['404_override'] = '';

/* End of file routes.php */
/* Location: ./application/config/routes.php */
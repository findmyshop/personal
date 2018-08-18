<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Links
| -------------------------------------------------------------------------
| This file contains all of the site path links for hyperlinks and urls.
|
|
*/

$base = "http://".$_SERVER['HTTP_HOST'];
$secure = "https://".$_SERVER['HTTP_HOST'];
$resource_base = $base;
$protocol = 'http://';

// if the connection is secure load the resources securely
if (isset($_SERVER['SERVER_PORT']) && ($_SERVER['SERVER_PORT'] == 443))
{
	$resource_base = $secure;
	$protocol = 'https://';
}

$links['protocol']								= $protocol;

//Admin
$links['admin']									 = $resource_base."/admin/";
$links['admin_users']							 = $resource_base."/admin/users/";

//Admin Authenticate
$links['authenticate_admin']						 = $resource_base."/login/";
$links['authenticate_admin_forgot_password']		 = $resource_base."/login/forgot_password/";
$links['authenticate_admin_password_reset_link']	 = $resource_base."/login/password_reset_link/";
$links['authenticate_admin_reset_password']		 = $resource_base."/login/reset_password/";

//User Authenticate
$links['authenticate_user']							= $resource_base."/login/";
$links['authenticate_user_forgot_password']			= $resource_base."/login/forgot_password/";
$links['authenticate_user_password_reset_link']		= $resource_base."/login/password_reset_link/";
$links['authenticate_user_reset_password']		= $resource_base."/login/reset_password/";

//Dashboard
$links['dashboard']								 = $resource_base."/admin/";

// Home
$links['home']									= $resource_base."/";

// Learn
$links['learn']									= $resource_base."/learn/";

// Resources (javascript, css, and layout images)
$links['css']								 = $resource_base."/css/";
$links['js']								= $resource_base."/js/";
$links['images']							= $resource_base."/images/";

$config['links'] = $links;
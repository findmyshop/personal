<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('feature_enabled')) {
	function feature_enabled($feature_name, $feature_permission_field = 'unauthenticated') {
		$ci = &get_instance();

		return $ci->feature_model->enabled($feature_name, $feature_permission_field);
	}
}


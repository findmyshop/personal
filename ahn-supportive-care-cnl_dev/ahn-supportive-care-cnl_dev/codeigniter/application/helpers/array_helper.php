<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('calculate_median')) {
	function calculate_array_median($arr) {
		sort($arr, SORT_NUMERIC);
		$count = count($arr);
		$middle_val = floor(($count - 1) / 2);

		if($count % 2) {
			$median = $arr[$middle_val];
		} else {
			$low = $arr[$middle_val];
			$high = $arr[$middle_val + 1];
			$median = (($low + $high) / 2);
		}

		return $median;
	}
}


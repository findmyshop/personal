<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Iframe Whitelist
| -------------------------------------------------------------------------
*/

$config['iframe_whitelist'] = array(
	'pra'	=> array(
		'pfpfizerusdev.prod.acquia-sites.com',
		'pfpfizerusdev2.prod.acquia-sites.com',
		'pfpfizerusstg.prod.acquia-sites.com',
		'www.pfizer.com',
		'medrespond.com'
	),
	'prb' => array(
		'pfpfizerusdev.prod.acquia-sites.com',
		'pfpfizerusdev2.prod.acquia-sites.com',
		'pfpfizerusstg.prod.acquia-sites.com',
		'www.pfizer.com',
		'medrespond.com'
	),
	'prc' => array(
		'pfpfizerusdev.prod.acquia-sites.com',
		'pfpfizerusdev2.prod.acquia-sites.com',
		'pfpfizerusstg.prod.acquia-sites.com',
		'www.pfizer.com',
		'medrespond.com'
	)
);

DEFINE('IFRAME_WHITELIST_DEFINED', isset($config['iframe_whitelist'][MR_PROJECT]) ? TRUE : FALSE);

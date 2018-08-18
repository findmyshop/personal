<?php	 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$project_assets = array();
$config['assets'] = array(
	array("type" => "css", "position" => "header", "show" => "all", "src" => "/font-awesome/css/font-awesome.min.css"),
	array("type" => "css", "position" => "header", "show" => "all", "src" => "/bootstrap/css/bootstrap.min.css"),
	array("type" => "css", "position" => "header", "show" => "all", "cache" => true, "src" => "/bootstrap/css/bootstrap-select.min.css"),
	array("type" => "css", "position" => "header", "show" => "admin", "cache" => true, "src" => "/bootstrap/css/bootstrap-theme.min.css"),
	array("type" => "css", "position" => "header", "show" => "base,login,register,disclaimer,certification,video,payments,courses,rid", "src" => "/medrespond/css/medrespond.css"),
	array("type" => "css", "position" => "header", "show" => "admin", "src" => "/medrespond/css/dashboard.css"),
	array("type" => "js", "position" => "header", "show" => "all", "src" => "/medrespond/js/polyfills.js"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/jquery/jquery-1.11.1.min.js"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/jquery/jquery-print.min.js"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/bootstrap/js/bootstrap.js"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/bootstrap/js/bootstrap-tooltip.min.js"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/bootstrap/js/bootstrap-select.min.js"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/jqplaceholder/jquery.html5-placeholder-shim.js"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/video-js/video.js", "browser" => "!IE8"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/video-js/video.old.js", "browser" => "IE8"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/respond/respond.min.js"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/html5shiv/html5shiv.min.js"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/json/json3.min.js"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/angular/js/angular.js"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/angular/js/ui-bootstrap-tpls.min.js"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/angular/js/angular-ui-ieshiv.min.js"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/angular/js/angular-cookies.js"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/angular/js/angular-natural-sort.js"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/angular/js/angular-sanitize.min.js"),
	array("type" => "js", "position" => "header", "show" => "all", "cache" => true, "src" => "/angular/js/angular-route.min.js"),
	array("type" => "js", "position" => "header", "show" => "admin", "cache" => true, "src" => "/lodash/lodash.min.js"),
	array("type" => "js", "position" => "header", "show" => "admin", "cache" => true, "src" => "/angular/js/angularjs-dropdown-multiselect.min.js"),
	array("type" => "js", "position" => "header", "show" => "all", "src" => "/medrespond/js/angular-directives-base.js"),
	array("type" => "js", "position" => "header", "show" => "all", "src" => "/medrespond/js/angular-controller-base.js"),
	array("type" => "js", "position" => "header", "show" => "base,login,register,disclaimer,certification,video,payments,courses,rid", "cache" => true, "src" => "/medrespond/js/iscroll.min.js"),
	array("type" => "js", "position" => "footer", "show" => "base,video,rid", "src" => "/medrespond/js/spell.js"),
	array("type" => "js", "position" => "footer", "show" => "all", "src" => "/medrespond/js/core.js"),
	array("type" => "js", "position" => "footer", "show" => "all", "src" => "/medrespond/js/login.js"),
	array("type" => "js", "position" => "header", "show" => "admin", "cache" => true, "src" => "/highcharts/js/highcharts.js"),
	array("type" => "js", "position" => "header", "show" => "admin", "cache" => true, "src" => "/highcharts/js/modules/exporting.js")
);

if (IFRAME_WHITELIST_DEFINED){
	$config['assets'][] = array("type" => "js", "position" => "header", "show" => "all", "src" => "/medrespond/js/anti-click-jack.js");
}

if (LOGIN_CAPTCHA){
	$config['assets'][] =  array("type" => "js", "position" => "header", "show" => "login", "src" => "https://www.google.com/recaptcha/api.js");
}

$config['logo_link'] = '#';
$config['meta_description'] = '';
$config['conversational_branding_text'] = '';
$config['conversational_branding_text_footer_element'] = '';


/* Project: http://www.supportivecareoptions.com */
if (MR_PROJECT === 'ebi') {
	$config['project'] = 'ebi';
	$config['title'] = 'Pitt SBIRT EBI';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base,login,rid", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js"),
		//array("type" => "js", "position" => "footer", "show" => "all", "src" => "/medrespond/js/login-ct.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/projects/".$config['project']."/js/angular-controller-ebi-moodle-link-builder.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/projects/".$config['project']."/js/angular-directives-ebi-moodle-link-builder.js")
	);
} else if (MR_PROJECT === 'adh') {
	$config['project'] = 'adh';
	$config['title'] = 'Shire ADHD';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base,login,rid", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "footer", "show" => "all", "src" => "/medrespond/js/login-ct.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")
	);
	$config['other_logo'] = '<img class="pull-left" height="34" style="padding-top:6px; padding-left:12px; padding-right:6px;" src="/assets/medrespond/images/logo-mmg.png" />';
/* Project: http://www.delightclinicalstudy.com */
} else if (MR_PROJECT === 'scc'){
	$config['project'] = 'scc';
	$config['title'] = 'Supportive Care Options';
	$config['copyright'] = '<div class="alert alert-danger mr-warning-bottom">If you feel at risk for harming yourself, please call 911 immediately</div>';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base login,rid", "src" => "/bootstrap/css/bootstrap-theme.min.css"),
		array("type" => "css", "position" => "header", "show" => "base,login,rid", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js"),
		array("type" => "js", "position" => "footer", "show" => "all", "src" => "/medrespond/js/safari-third-party-cookies-consent.js")
	);
/* Project: http://www.pkdconversations.com */
} else if (MR_PROJECT === 'pkd'){
	$config['project'] = 'pkd';
	$config['title'] = 'Otsuka';
	$config['copyright'] = '<div class="mr-warning-bottom">&copy;'.date("Y").' Otsuka Pharmaceutical Development &amp; Commercialization, Inc.</div>';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base,login,disclaimer", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login,disclaimer", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "footer", "show" => "all", "src" => "/medrespond/js/login-ct.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")
	);
	$config['other_logo'] = '<img class="pull-left" height="34" style="padding-top:6px; padding-left:12px; padding-right:6px;" src="/assets/medrespond/images/logo-mmg.png" />';
/* Project: http://www.monarch2conversations.com */
} else if (MR_PROJECT === 'jpbl'){
	$config['project'] = 'jpbl';
	$config['title'] = 'Lilly';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base,login", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "footer", "show" => "all", "src" => "/medrespond/js/login-ct.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")
	);
	$config['other_logo'] = '<img class="pull-left" height="34" style="padding-top:6px; padding-left:12px; padding-right:6px;" src="/assets/medrespond/images/logo-mmg.png" />';
/* Project: http://www.juniperconversations.com */
} else if (MR_PROJECT === 'jcc'){
	$config['project'] = 'jcc';
	$config['title'] = 'Lilly';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base,login", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "footer", "show" => "all", "src" => "/medrespond/js/login-ct.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")
	);
	$config['other_logo'] = '<img class="pull-left" height="34" style="padding-top:6px; padding-left:12px; padding-right:6px;" src="/assets/medrespond/images/logo-mmg.png" />';
/* Project: http://www.apecsconversation.com */
} else if (MR_PROJECT === 'alz'){
	$config['project'] = 'alz';
	$config['title'] = 'Prodromal Alzheimer\'s Clinical Research';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base,login", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "footer", "show" => "all", "src" => "/medrespond/js/login-ct.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")
	);
	$config['other_logo'] = '<img class="pull-left" height="34" style="padding-top:6px; padding-left:12px; padding-right:6px;" src="/assets/medrespond/images/logo-mmg.png" />';
/* Project: http://www.node1forpsvt.com */
} else if (MR_PROJECT === 'msp'){
	$config['project'] = 'msp';
	$config['title'] = 'PSVT Clinical Research';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base,login,rid", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "footer", "show" => "all", "src" => "/medrespond/js/login-ct.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")
	);
	$config['other_logo'] = '<img class="pull-left" height="34" style="padding-top:6px; padding-left:12px; padding-right:6px;" src="/assets/medrespond/images/logo-mmg.png" />';
/* Project: http://www.delightclinicalstudy.com */
} else if (MR_PROJECT === 't2d'){
	$config['project'] = 't2d';
	$config['title'] = 'T2D';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base,login", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "footer", "show" => "all", "src" => "/medrespond/js/login-ct.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")
	);
	$config['other_logo'] = '<img class="pull-left" height="34" style="padding-top:6px; padding-left:12px; padding-right:6px;" src="/assets/medrespond/images/logo-mmg.png" />';
/* Project: http://www.delightclinicalstudy.com */
} else if (MR_PROJECT === 'ddk'){
	$config['project'] = 'ddk';
	$config['title'] = 'T2D';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base,login", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "footer", "show" => "all", "src" => "/medrespond/js/login-ct.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")
	);
	$config['other_logo'] = '<img class="pull-left" height="34" style="padding-top:6px; padding-left:12px; padding-right:6px;" src="/assets/medrespond/images/logo-mmg.png" />';
/* Project: http://www.alcoholsbirt.com */
} else if (MR_PROJECT === 'dod'){
	$config['project'] = 'dod';
	$config['title'] = 'AlcoholSBIRT';
	$config['conversational_branding_text'] = 'Conversational&#8480; Education';
	$config['conversational_branding_text_footer_element'] = '<div class="conversational-branding-text">'.$config['conversational_branding_text'].'</div>';
	$project_assets = array(
		array("type" => "css", "position" => "header", "show" => "base,login,register,disclaimer,certification", "src" => "/bootstrap/css/bootstrap-theme.min.css"),
		array("type" => "css", "position" => "header", "show" => "base,login,register,disclaimer,certification", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "css", "position" => "header", "show" => "all", "src" => "/medrespond/css/global.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login,register,disclaimer,certification", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/projects/".$config['project']."/js/angular-controller-dod-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/projects/".$config['project']."/js/angular-directives-dod-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/projects/".$config['project']."/js/angular-controller-dod-reports.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/projects/".$config['project']."/js/angular-directives-dod-reports.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/projects/".$config['project']."/js/angular-controller-dod-statistics.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/projects/".$config['project']."/js/angular-directives-dod-statistics.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/projects/".$config['project']."/js/angular-controller-dod-courses.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/projects/".$config['project']."/js/angular-directives-dod-courses.js"),
		array("type" => "js", "position" => "header", "show" => "disclaimer", "src" => "/projects/".$config['project']."/js/angular-controller-dod-disclaimer.js"),
		array("type" => "js", "position" => "header", "show" => "disclaimer", "src" => "/projects/".$config['project']."/js/angular-directives-dod-disclaimer.js"),
		array("type" => "js", "position" => "header", "show" => "register", "src" => "/projects/".$config['project']."/js/angular-controller-dod-registration.js"),
		array("type" => "js", "position" => "header", "show" => "register", "src" => "/projects/".$config['project']."/js/angular-directives-dod-registration.js")
	);
/* Project: http://www.fit-for-surgery.com */
} else if (MR_PROJECT === 'f4s'){
	$config['project'] = 'f4s';
	$config['title'] = 'Fit For Surgery';
	$config['conversational_branding_text'] = 'Conversational&#8480; Healthcare';
	$config['conversational_branding_text_footer_element'] = '<div class="conversational-branding-text">'.$config['conversational_branding_text'].'</div>';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base login", "src" => "/bootstrap/css/bootstrap-theme.min.css"),
		array("type" => "css", "position" => "header", "show" => "base,login", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")
	);
/* Project: http://www.white-label.fit-for-surgery.com */
}else if (MR_PROJECT === 'cnl'){
	$config['project'] = 'cnl';
	$config['title'] = 'Cancer Care eNavigator';
	$config['conversational_branding_text'] = 'Conversational&#8480; Healthcare';
	$config['conversational_branding_text_footer_element'] = '<div class="conversational-branding-text">'.$config['conversational_branding_text'].'</div>';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base login", "src" => "/bootstrap/css/bootstrap-theme.min.css"),
		array("type" => "css", "position" => "header", "show" => "base,login", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")
	);
/* Project: http://www.white-label.fit-for-surgery.com */
} else if (MR_PROJECT === 'f4s_white_label_demo'){
	$config['project'] = 'f4s_white_label_demo';
	$config['title'] = 'Fit For Surgery';
	$config['conversational_branding_text'] = 'Conversational&#8480; Healthcare';
	$config['conversational_branding_text_footer_element'] = '<div class="conversational-branding-text">'.$config['conversational_branding_text'].'</div>';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base login", "src" => "/bootstrap/css/bootstrap-theme.min.css"),
		array("type" => "css", "position" => "header", "show" => "base,login", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")
	);
/* Project: http://www.postpartumconversations.com */
} else if (MR_PROJECT === 'ppd'){
	$config['project'] = 'ppd';
	$config['title'] = 'Postpartum Conversations';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base login,video", "src" => "/bootstrap/css/bootstrap-theme.min.css"),
		array("type" => "css", "position" => "header", "show" => "base,login,video", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login,video", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")
	);
/* Project: http://www.onsoralchemoguide.com */
} else if (MR_PROJECT === 'oct'){
	$config['meta_description'] = 'Welcome to our guide on Oral Cancer drugs. When people think of chemotherapy, they usually think of going to a hospital or clinic and being connected to an intravenous or I-V drip or getting an injection. But now, more and more cancer patients are being treated with Oral chemotherapy drugs -- cancer medications that you take by mouth, just like most other medications.';
	$config['project'] = 'oct';
	$config['title'] = 'Oral Chemo Guide';
	$config['conversational_branding_text'] = 'Conversational&#8480; Healthcare';
	$config['conversational_branding_text_footer_element'] = '<div class="conversational-branding-text">'.$config['conversational_branding_text'].'</div>';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base login,rid", "src" => "/bootstrap/css/bootstrap-theme.min.css"),
		array("type" => "css", "position" => "header", "show" => "base,login,rid", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login,rid", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")
	);
/* Project: http://www.excela.org */
} else if (MR_PROJECT === 'epr'){
	$config['meta_description'] = 'Hello and welcome to Baby Talk With My Excela Doc, a program for soon-to-be-parents where you can ask Excela healthcare professionals all your questions about pregnancy, labor and delivery. Type your questions in the Ask box below, or click on the menu to your left to explore the topics that interest you most. Along the way, we\'ll display links to related questions to the right of the page. And, you can click on the Resource link at the top of the page to display a list of documents and websites with even more information on the subjects you ask about. Go ahead, type in a question now, or click on a link to start a conversation with your Excela healthcare professional.';
	$config['logo_link'] = 'http://www.excelahealth.org';
	$config['project'] = 'epr';
	$config['title_logo'] = '<a href="#"><img style="margin:0 auto; margin-top:-16px;" height="53" src="'.base_url().'assets/projects/epr/images/logo-bt.png"/></a>';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base login", "src" => "/bootstrap/css/bootstrap-theme.min.css"),
		array("type" => "css", "position" => "header", "show" => "base,login,rid", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")

	);
	// babytalkwithmyexceladoc.com pixel tracking script
	if(ENVIRONMENT === 'production') {
		$project_assets[] = array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "https://i.simpli.fi/dpx.js?cid=53371&action=100&segment=excelahealthbaby&m=1&sifi_tuid=29557", "async" => true);
	}

/* Project: http://www.asknamisandiego.org */
} else if (MR_PROJECT === 'nsd'){
	$config['project'] = 'nsd';
	$config['title'] = 'NAMI San Diego';
	$config['conversational_branding_text'] = 'Conversational&#8480; Healthcare';
	$config['conversational_branding_text_footer_element'] = '<div class="conversational-branding-text" style="margin-top:9px;font-size:11px;">'.$config['conversational_branding_text'].'</div>';
	$config['copyright'] = '<div class="mr-warning-bottom" style="margin-left:0px;padding-left:0px;">&copy;'.date("Y").' Funded by the County of San Diego Health and Human Services Agency through the Mental Health Services Act.<img src="/assets/projects/'.$config['project'].'/images/logo-bottom.png"/></div>';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base,login,rid", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login,rid", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")
	);
/* BCRAN URL */
} else if (MR_PROJECT === 'bcran'){
	$config['project'] = 'bcran';
	$config['title'] = 'BCRAN TITLE';
	$config['conversational_branding_text'] = 'Conversational&#8480; Healthcare';
	$config['conversational_branding_text_footer_element'] = '<div class="conversational-branding-text" style="margin-top:9px;font-size:11px;">'.$config['conversational_branding_text'].'</div>';
	$config['copyright'] = '<div class="mr-warning-bottom" style="margin-top:0px;margin-left:10px;padding-left:0px;">&copy;'.date("Y").' MedRespond, Womens Cancer Research Center, and The Pittsburgh Cancer Center Institute.  All rights reserved.  This web site is intended for informational purposes only. The information provided through this web site should not be used for diagnosing or treating a health problem or disease. Please see your healthcare provider before taking any medical action.</div>';

	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base,login,rid", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login,rid", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")
	);
/* Project: http://www.medrespond.com */
} else if (MR_PROJECT === 'mrd'){
	$config['project'] = 'mrd';
	$config['title'] = 'MedRespond Demo';
	$config['copyright'] = '<div class="mr-warning-bottom">&copy;'.date("Y").' MedRespond LLC.</div>';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base,login", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")
	);
/* Project: Multi-domain (uses subfolders) */
} else if ((MR_PROJECT.'/') === MR_DIRECTORY || MR_PROJECT === 'ysc'){
	$config['project'] = MR_PROJECT;
	$config['title'] = MR_PROJECT;
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base,login", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "all", "src" => "/medrespond/js/login-ct.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js"),
		array("type" => "js", "position" => "footer", "show" => "login", "src" => "/medrespond/js/safari-third-party-cookies-consent.js")
	);
	if (MR_PROJECT == 'pra' || MR_PROJECT == 'prb' || MR_PROJECT == 'prc'){
		$config['copyright'] = '<div class="mr-warning-bottom">&copy;'.date("Y").' Pfizer Inc. All rights reserved.</div>';
		$config['other_logo'] = '<img class="pull-left" height="34" style="padding-top:6px; padding-left:12px; padding-right:6px;" src="/assets/medrespond/images/logo-mmg.png" />';
	}
} else if (MR_PROJECT === 'rush') {
	$config['project'] = MR_PROJECT;
	$config['title'] = MR_PROJECT;
	$config['conversational_branding_text'] = 'Conversational&#8480; Education';
	$config['conversational_branding_text_footer_element'] = '<div class="conversational-branding-text">'.$config['conversational_branding_text'].'</div>';
	$project_assets = array(
		array("type" => "css", "position" => "header", "show" => "all", "src" => "/medrespond/css/global.css"),
		array("type" => "js", "position" => "header", "show" => "register", "src" => "/medrespond/js/angular-controller-training-registration.js"),
		array("type" => "js", "position" => "header", "show" => "register", "src" => "/medrespond/js/angular-directives-training-registration.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base,login,register", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-training-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-training-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-training-reports.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-training-reports.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-training-statistics.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-training-statistics.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-training-courses.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-training-courses.js")
	);
} else if (MR_PROJECT === 'sbirt') {
	$config['project'] = MR_PROJECT;
	$config['title'] = MR_PROJECT;
	$config['conversational_branding_text'] = 'Conversational&#8480; Education';
	$config['conversational_branding_text_footer_element'] = '<div class="conversational-branding-text">'.$config['conversational_branding_text'].'</div>';
	$project_assets = array(
		array("type" => "css", "position" => "header", "show" => "all", "src" => "/medrespond/css/global.css"),
		array("type" => "js", "position" => "header", "show" => "register", "src" => "/medrespond/js/angular-controller-training-registration.js"),
		array("type" => "js", "position" => "header", "show" => "register", "src" => "/medrespond/js/angular-directives-training-registration.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base,login,register,payments,courses,disclaimer", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "js", "position" => "footer", "show" => "base,login,register,payments,courses,disclaimer", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-training-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-training-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-training-reports.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-training-reports.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-training-statistics.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-training-statistics.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-training-courses.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-training-courses.js"),
		array("type" => "js", "position" => "header", "show" => "disclaimer", "src" => "/projects/".$config['project']."/js/angular-controller-dod-disclaimer.js"),
		array("type" => "js", "position" => "header", "show" => "disclaimer", "src" => "/projects/".$config['project']."/js/angular-directives-dod-disclaimer.js"),
	);
/* Project: http://www.tssim.com */
} else if (MR_PROJECT === 'tss'){
	$config['project'] = 'tss';
	$config['title'] = 'DDI Targeted Simulation	&#174;';
	$project_assets = array(
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
		array("type" => "css", "position" => "header", "show" => "base,login", "src" => "/projects/".$config['project']."/css/style.css"),
		array("type" => "css", "position" => "header", "show" => "admin", "src" => "/projects/".$config['project']."/css/dashboard.css"),
		array("type" => "css", "position" => "header", "cache" => true, "show" => "base,login", "src" => "https://fonts.googleapis.com/icon?family=Material+Icons"),
		array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js"),
		array("type" => "js", "position" => "footer", "show" => "all", "src" => "/medrespond/js/login-ct.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/projects/".$config['project']."/js/angular-controller-tss-dashboard.js"),
		array("type" => "js", "position" => "header", "show" => "admin", "src" => "/projects/".$config['project']."/js/angular-directives-tss-dashboard.js"),
	);
} else if (MR_PROJECT === "enr") {
	$project_assets[] = array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js");
	$project_assets[] = array("type" => "js", "position" => "header", "show" => "login/register", "src" => "/projects/".$config['project']."/js/angular-controller-registration.js");
	$project_assets[] = array("type" => "js", "position" => "header", "show" => "login/register", "src" => "/projects/".$config['project']."/js/angular-directives-registration.js");
	$config['conversational_branding_text'] = 'Conversational&#8480; Engagement';
	$config['conversational_branding_text_footer_element'] = '<div class="conversational-branding-text">'.$config['conversational_branding_text'].'</div>';
	$config['other_logo'] = '<img class="pull-left" height="30" style="padding-top:12px; padding-left:12px;" src="/assets/projects/enr/images/logo-dp.png" />';
	/*
	$config['copyright'] = '<div class="ens-footer-stuff pull-right"><a target="_blank" href="http://enersource.com/">home</a> | <a target="_blank" href="http://enersource.com/Pages/sitemap.aspx">site map</a> | <a target="_blank" href="http://enersource.com/Pages/privacy.aspx">privacy</a><a class="f-tw" target="_blank" href="https://twitter.com/enersourcenews/"><img src="'.base_url().'assets/projects/enr/images/tw.jpg"/></a><a class="f-fb" target="_blank" href="https://www.facebook.com/enersourcenews/"><img src="'.base_url().'assets/projects/enr/images/fb.jpg"/></a></div><div class="mr-warning-bottom">&copy;'.date("Y").' Enersource Corporation. All Rights Reserved. Enersource Corporation prohibits any unauthorized use of its trademarks including Enersource&reg;, peaksaver&reg;, the Enersource logo and more than energy&trade; &copy;'.date("Y").' Decision Partners and MedRespond, LLC. All Rights Reserved.</div>
		<div style="clear:both;"></div>';
	*/
	$config['copyright'] = '<div class="mr-warning-bottom">&copy;'.date("Y").' Decision Partners and MedRespond, LLC. All Rights Reserved.</div>
		<div style="clear:both;"></div>';
} else if (MR_TYPE === 'nami_white_label') {
	if (MR_PROJECT === 'nami_white_label_demo_asl' || MR_PROJECT === 'nami_white_label_demo_eng') {
		$config['project'] = MR_PROJECT;
		$config['title'] = 'NAMI White Label Demo';
		$config['conversational_branding_text'] = 'Conversational&#8480; Healthcare';
		$config['conversational_branding_text_footer_element'] = '<div class="conversational-branding-text" style="margin-top:9px;font-size:11px;">'.$config['conversational_branding_text'].'</div>';
		$config['copyright'] = '<div class="mr-warning-bottom" style="margin-left:0px;padding-left:0px;">&copy;'.date("Y").' Funded by NAMI San Diego.<img src="/assets/projects/'.$config['project'].'/images/logo-bottom.jpg"/></div>';
		$project_assets = array(
			array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-hybrid-dashboard.js"),
			array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-hybrid-dashboard.js"),
			array("type" => "css", "position" => "header", "show" => "base,login", "src" => "/projects/".$config['project']."/css/style.css"),
			array("type" => "js", "position" => "footer", "show" => "base,login", "src" => "/projects/".$config['project']."/js/core.js"),
			array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-controller-default-dashboard.js"),
			array("type" => "js", "position" => "header", "show" => "admin", "src" => "/medrespond/js/angular-directives-default-dashboard.js")
		);
	}
}

if(!USER_AUTHENTICATION_REQUIRED && FACEBOOK_APP_ID) {
	$config['facebook_share_image'] = base_url()."assets/projects/".$config['project']."/images/facebook_share_image.png";
}

$config['assets'] = array_merge($config['assets'],$project_assets);
/* End of file template.php */
/* Location: ./application/config/template.php */


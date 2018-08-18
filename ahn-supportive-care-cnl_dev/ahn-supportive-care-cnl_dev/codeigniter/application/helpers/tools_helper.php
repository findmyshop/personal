<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * return software versions
 * @return void
 */
if (!function_exists('mr_version_info')) {
	function mr_version_info() {
		/* A few files we want to get version info on */
		$files = array(
				array(
					'path'	=> FCPATH.'assets/medrespond/js/spell.js',
					'url'		=> base_url().'assets/medrespond/js/spell.js',
					'type'	=> 'js'
				),
				array(
					'path'	=> FCPATH.'config/'.MR_PROJECT.'/index.xml',
					'url'		=> base_url().'config/'.MR_PROJECT.'/index.xml',
					'type'	=> 'xml'
				)
		);

		echo '<table class="table"><tbody><tr><th>File Name</th><th>Name</th><th>Date</th></tr>';
		foreach ($files as $key => $value) {
			echo '<tr>';
			/*
			$sp = get_file_data($value["path"],$value["type"]);
			*/
			$fn = parse_url($value["url"]);
			echo '<td><a target="_blank" href="'.$value["url"].'"><i class="glyphicon glyphicon-paperclip"></i> '.$fn["path"].'</a></td>';
			/*
			echo '<td>'.$sp['name'].'</td>';
			echo '<td>'.$sp['date'].'</td>';
			*/
			echo '<td>Disabled</td>';
			echo '<td>Disabled</td>';
			echo '</tr>';
		}
		echo '</tbody></table>';
	}
}
/**
 * get comments for file version
 * @return array
 */
if (!function_exists('get_file_data')) {
	function get_file_data($file,$type) {
		$data = array(
			'name'	=> '',
			'date'	=> ''
		);

		$file_data = file_get_contents($file);

		if(!$file_data) {
			log_message('error', 'Failed to get ' . $file);
			return $data;
		}

		//Get the comment
		if ($type != "xml") {
			if(preg_match('#^/\*\*(.*)\*/#s', $file_data, $comment) != false) {
				//Get all the lines and strip the * from the first character
				if(preg_match_all('#^\s*\*(.*)#m', trim($comment[1]), $lines) != false) {
					if(!empty($lines[1])) {
						$data['name'] = $lines[1][0];
						$data['date'] = $lines[1][1];
					}
					return $data;
				}
			}
		}else{
			if(preg_match('#^<!--\*\s*(.*)\*\s*(.*)-->#s', $file_data, $matches) != false) {
				if(!empty($matches[1]) && !empty($matches[2])) {
					$data['name'] = $matches[1];
					$data['date'] = $matches[2];
				}
			}
		}

		log_message('error', 'Failed to extract version information from ' . $file);

		return $data;
	}
}
/**
 * return what server we're on for body class
 * @return string
 */
if (!function_exists('get_environment'))
{
	function get_environment($echo = false) {
		if (defined('ENVIRONMENT')) {
			switch (ENVIRONMENT) {
			 case 'development':
					$_output = "mr-server-develop";
					break;
				case 'testing':
					$_output = "mr-server-testing";
					break;
				case 'production':
					$_output = "mr-server-live";
					break;
				default:
					$_output = "mr-server-unknown";
					break;
			}
		}
		if ($echo) {
			echo $_output;
		} else{
			return $_output;
		}
	}
}
/**
 * return assets url
 * @return string
 */
if (!function_exists('asset_url'))
{
	function asset_url($echo = false) {
		if ($echo) {
			echo base_url().'assets';
		} else{
			return base_url().'assets';
		}
	}
}
/**
 * return user agent string for use in template
 * @param bool $echo
 * @return string
 */
if (!function_exists('get_ua'))
{
	function get_ua($args) {
		$CI =& get_instance();
		$browser = str_replace(' ', '-', strtolower($CI->agent->browser()));
		$mobile = str_replace(' ', '-', strtolower($CI->agent->mobile()));
		$version = $CI->agent->version();
		$version = substr($version, 0, strpos($version, "."));
		$trident = 'false';
		if (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false){
			$trident = 'true';
		}

		if ($args === 'version') {
			return $version;
		}else if ($args === 'name') {
			return $browser;
		}else if ($args === 'trident') {
			return $trident;
		}else if ($args === 'mobile') {
			return $mobile;
		}else if ($args === 'class') {
			if ($mobile != '') {
				return 'mobile';
			}
		}
		return '';
	}
}
/**
 * barfs assets from an asset array
 * @param array $assetArray
 * @param object $filters
 * @param bool $echo
 * @return string
 */
if (!function_exists('get_assets'))
{
	function get_assets($assetArray, $filters, $echo = true) {
    $CI =& get_instance();

		/* Defaults */
		$_filters = array("position" => "header",
											"show" => "all",
											"src" => "");
		$_output = "";
		$_cacheBuster = "?" . date("YmdHis");
		$filters = array_replace ($_filters, $filters);

		foreach ($assetArray as $key => $value) {
			$_buffer = "";
			$_async = "";
			$_compile = false;
			$_browser = false;
			/* Check if the asset contains the show area */
			if ((strpos($value["show"], $filters["show"]) !== FALSE ||
					 strpos($value["show"], "all") !== FALSE) &&
					 $value["position"] === $filters["position"]) {
				/* Cache Files with cachebuster */
				$cacheBuster = $_cacheBuster;
				if (isset($value["cache"])){
					if ($value["cache"] == true){
						$cacheBuster = '';
					}
				}
				if (isset($value["compile"])){
					$_compile = $value["compile"];
				}
				if (isset($value["browser"])){
					$_browser = true;
				}
				if (isset($value["async"])){
					if ($value["async"] == true) $_async = 'async';
				}
				if(strpos($value['src'], "http://") !== false ||
					 strpos($value['src'], "https://") !== false ){
					$_local_url = '';
				}else{
					$_local_url = asset_url();
				}
				switch ($value["type"]) {
					case "css":
						if ($_compile == true){
							$CI->carabiner->css($value["src"]);
						}else{
							$_buffer .= '<link rel="stylesheet" href="'.$_local_url.$value["src"].$cacheBuster.'" />';
						}
						break;
					case "js":
						if ($_browser){
							if ($value["browser"] == "IE8"){
								if (get_ua('name') == "internet-explorer" && intval(get_ua('version')) < 9){

								}else{
									continue;
								}
							}else if ($value["browser"] == "!IE8"){
								if (get_ua('name') == "internet-explorer" && intval(get_ua('version')) == 8){
									continue;
								}
							}
						}
						if ($_compile == true){
							$CI->carabiner->js($value["src"]);
						}else{
							$_buffer .= '<script '.$_async.' type="text/javascript" src="'.$_local_url.$value["src"].$cacheBuster.'"></script>';
						}
						break;
				}
				$_output .= $_buffer;
			}
		}//foreach
		if ($echo) {
			if ($filters["position"] == "header"){
				$CI->carabiner->display('css');
				//$CI->carabiner->display('js');
			}else{
				//$CI->carabiner->display('js');
			}
			echo $_output;
		} else{
			return $output;
		}
	}
}

/* UI Elements */
if (!function_exists('get_survey')) {
	function get_survey(){
		echo '<div id="right-survey" class="mr-widget returning-user-buttons" ng-show="response.type != \'null\' && user_action == \'Q\' && cached_input_question != false && response.category != \'offtopic\' && response.category != \'shame\' && response.category != \'multianswer\' && response.id != \'offtopic\' && response.id != \'shame\' && response.id != \'multianswer\' ">
				<div class="panel-heading">Does this answer your question?</div>
				<div class="panel-body">
					<button class="btn btn-primary btn-block" type="button" ng-click="rate_response(\'Answered\')"><i class="glyphicon glyphicon-thumbs-up"></i> Yes</button>
					<button class="btn btn-primary btn-block" type="button" ng-click="rate_response(\'Unanswered\')"><i class="glyphicon glyphicon-thumbs-down"></i> No</button>
				</div>
			</div>';
	}
}
/* Related Questions */
if (!function_exists('get_related_questions')){
	function get_related_questions($args = null) {
		$args = (object) $args;
		if (!isset($args->ngHide)) {
			$args->ngHide = 'returningUser == true || response.related_questions < 1';
		}
		if (!isset($args->button)){
			$args->button = true;
		}
		if ($args->button == true){
			$button = '<br/><a class="btn btn-primary" href="#/RELATED/{{question.id}}/{{response.id}}/{{response.video_controls.next_id}}">
									<span class="glyphicon glyphicon-play"></span>
								</a>';
		}else{
			$button = '';
		}
		echo '<div class="mr-widget mr-related-widget" ng-hide="'.$args->ngHide.'">
				<div class="panel-heading">{{ question_title }}</div>
				<div class="panel-body">
					<div class="related-q" ng-repeat="question in response.related_questions" title="{{ question.display_text }}">
						<a class="link-text" href="#/RELATED/{{question.id}}/{{response.id}}/{{response.video_controls.next_id}}">{{ question.display_text }}</a>
						'.$button.'
					</div>
				</div>
			</div>';
	}
}
if (!function_exists('get_video_prefix')) {
	function get_video_prefix($echo = true) {
		$CI =& get_instance();
		$prefix = $CI->property_model->get_response_prefix(MR_PROJECT);
		echo $prefix;
	}
}
if (!function_exists('get_welcome_video')) {
	function get_welcome_video($echo = true) {
		$CI =& get_instance();
		$welcome = $CI->property_model->get_welcome_response_id(MR_PROJECT, FALSE, FALSE);
		echo $welcome;
	}
}
if (!function_exists('get_mr_icon')) {
	function get_mr_icon($echo = true) {
		$output = '<img class="mr-icon" src="'.asset_url(false).'/medrespond/images/mr-icon.png" />';
		if ($echo) {
			echo $output;
		}else{
			return $output;
		}
	}
}
if (!function_exists('get_left_rail')) {
	function get_left_rail($args = null) {
		$args = (object) $args;
		if (!isset($args->status)) {
			$args->status = '';
		}else{
			$args->status = 'mr-rq-status {{module.status}} {{r.status}} ';
		}
		if (!isset($args->after)) {
			$args->after = '';
		}
		if (!isset($args->before)) {
			$args->before = '';
		}
		if (!isset($args->li_before)) {
			$args->li_before = '';
		}
		if (!isset($args->a_before)) {
			$args->a_before = '';
		}
		?>
		<div class="mr-is-wrapper" id="left_rail">
			<ul class="left-rail-content mr-is-scroller">
				<?php echo $args->before; ?>
				<li class="left-rail-panel mr-widget" ng-repeat="module in left_rail">
					<div class="left-rail-response-body">
						<ul class="left-rail-response-list">
							<li class="left-rail-response-list-item" ng-if="module.type == 'link'" ng-repeat="g in module.responses">
								<a ng-repeat="r in g"
											 data-rid="{{r.id}}"
											 ng-show="$first"
											 ng-if="r.question"
											 data-toggle="tooltip"
											 ng-class="{active: r.id == response.id || r.id == response.left_rail.response_selected}"
											 class="left-rail-response-link <?php echo $args->status; ?> {{r.type}} {{r.action}}"
											 title="{{r.title || r.question}}"
											 href="#/LRQ/{{r.id}}">
											<?php echo $args->a_before; ?>
											<span>{{r.text || r.question}}</span>
											<span class="mr-rq-status-icon"></span>
										</a>
							</li>
						</ul>
					</div>
					<div ng-if="module.type != 'link'" class="left-rail-heading">
						<a id="mr-module-{{module.id}}" 
							class="left-rail-heading-link {{module.status}}" 
							title="{{module.heading}}" 
							data-toggle="{{module.status == 'locked' ? '' : 'collapse'}}" 
							data-target="#collapse{{module.id}}" 
							ng-class="{collapsed: !linkInModule(response.id, module.id)}">
							{{module.heading}}
						</a>
					</div>
					<div ng-if="module.type != 'link'" id="collapse{{module.id}}" 
						class="collapse left-rail-response-body" 
						ng-class="{ in: linkInModule(response.id, module.id) }">
						<ul class="left-rail-response-list">
							<?php echo $args->li_before; ?>
							<li ng-repeat="g in module.responses" class="left-rail-response-list-item">
								<a ng-repeat="r in g"
									 data-rid="{{r.id}}"
									 ng-show="$first"
									 ng-if="r.question"
									 data-toggle="tooltip"
									 ng-class="{active: r.id == response.id || r.id == response.left_rail.response_selected}"
									 class="left-rail-response-link <?php echo $args->status; ?> {{r.type}} {{r.action}}"
									 title="{{r.title || r.question}}"
									 href="#/LRQ/{{r.id}}">
									<?php echo $args->a_before; ?>
									<span>{{r.text || r.question}}</span>
									<span class="mr-rq-status-icon"></span>
								</a>
							</li>
						</ul>
					</div>
				</li>
				<?php echo $args->after; ?>
			</ul>
		</div>
	<?php }
}
if (!function_exists('get_ask_controls')) {
	function get_ask_controls($args) {
		$args = (object) $args;
		if (!isset($args->navigation)) {
			$args->navigation = false;
			$navigation = '';
		}
		if (!isset($args->size)) {
			$args->size = false;
			$size = 'input-group-lg';
		}
		if (!isset($args->ui)) {
			$args->ui = false;
		}
		if (!isset($args->answer_text)){
			$args->answer_text = "Answer";
		}
		if (!isset($args->after)) {
			$args->after = '';
		}
		if ($args->ui == true) {
			$ask_controls = 'ng-disabled="response.ask_controls.hidden == \'true\'" ng-cloak';
			$video_controls = 'ng-hide="response.video_controls.hidden == \'true\'" ng-cloak';
		}
		if ($args->size == 'medium') {
			$size = '';
		}else if ($args->size == 'large') {
			$size = 'input-group-lg';
		}
		if (!$args->ui){
			$ask_controls = '';
			$video_controls = '';
		}
		if ($args->navigation == true) {
			$navigation = '<span '.$video_controls.' class="input-group-btn">
				<a data-toggle="tooltip" title="Previous" id="mr-video-prev" class="btn btn-primary" ng-disabled="!response.video_controls.previous_id" href="#/PREVIOUS/{{response.video_controls.previous_id}}"><i class="icon glyphicon glyphicon-chevron-left"></i></a>
				<a data-toggle="tooltip" title="Replay" id="mr-video-repeat" class="btn btn-primary" ng-click="replay_video()"><i class="icon glyphicon glyphicon-repeat"></i></a>
				<a data-toggle="tooltip" title="Next" id="mr-video-next" class="btn btn-primary" ng-disabled="!response.video_controls.next_id" href="#/NEXT/{{response.video_controls.next_id}}">{{response.video_controls.next_title}}<i class="icon glyphicon glyphicon-chevron-right"></i></a>
			</span>';
		}else{
			$navigation = '';
		}
		echo '<div id="mr-input-row" class="basic-pad" ng-switch="response.ask_controls.action" ng-show="response.ask_controls.action != \'comment\'">
		<form class="input-group '.$size.'" role="form" ng-switch-default ng-submit="check_spelling(call_analyzer())" >'.$navigation.'<input '.$ask_controls.' class="form-control" ng-model="$parent.input_question" id="input_question" type="text" placeholder="Enter your question here" spellcheck="true" maxlength="'.(intval(MR_ASK_LENGTH)+1).'">
			<span class="input-group-btn">
				<button '.$ask_controls.' id="mr-ask-submit" title="Ask a question" class="btn btn-primary ask-button" type="submit">Ask '.get_mr_icon(false).'</button>
			</span>
		</form>
		<form class="input-group '.$size.'" ng-switch-when="question" role="form" ng-submit="check_spelling(call_analyzer());">';
		echo $navigation;
		echo '<input '.$ask_controls.' class="form-control" ng-model="$parent.input_question" id="input_question" type="text" placeholder="Type your answer here" spellcheck="true" maxlength="'.(intval(MR_ASK_LENGTH)+1).'">
			<span class="input-group-btn">
				<button '.$ask_controls.' id="mr-ask-submit" class="btn btn-default ask-button" type="submit">'.$args->answer_text .' <i class="icon glyphicon glyphicon-pencil"></i></button>
			</span>
		</form>
		<form class="input-group '.$size.'" ng-switch-when="answer" role="form" ng-submit="check_spelling(submit_test());">';
		echo $navigation;
		echo '<input '.$ask_controls.' class="form-control" ng-model="$parent.testData[1]" id="input_question" id="q-{{$parent.test.key}}-1-1" name="q-{{$parent.test.key}}-1-1" type="text" placeholder="Type your answer here" spellcheck="true" maxlength="'.(intval(MR_ASK_LENGTH)+1).'">
			<span class="input-group-btn">
				<button '.$ask_controls.' id="mr-ask-submit" class="btn btn-default ask-button" type="submit">'.$args->answer_text .' <i class="icon glyphicon glyphicon-pencil"></i></button>
			</span>
		</form>
		<span ng-switch-when="comment"></span>
		
		<form class=" form-inline" 
			role="form" 
			ng-switch-when="single_choice"
		>
		<h4>{{formQuestions[response.id].text}}</h4>

			<div class="input-group">
				<input ng-repeat="question in formQuestions[response.id].questions"
					class="form-check-input btn btn-sm btn-success" 
					ng-click="selectQuestionResponse($event)" 
					type="button" 
					value={{question}}>
			</div>
			
			<div class="input-group pull-right">
				<button '.$ask_controls.' ng-click="continue_single_choice()" id="mr-ask-submit" class="btn btn-primary ask-button" type="submit">'.$args->answer_text .' </button>
			</div>

		</form>

		<!-- legacy SCC CRAP -->
		<form class="input-group '.$size.'" ng-switch-when="cm" role="form" ng-submit="check_spelling(call_analyzer());">
			<input class="form-control" ng-model="$parent.input_question" id="input_question" type="text" placeholder="Type your answer here" spellcheck="true" maxlength="'.(intval(MR_ASK_LENGTH)+1).'">
			<span class="input-group-btn">
				<button id="mr-ask-submit" class="btn btn-default ask-button" type="submit">'.$args->answer_text .' <i class="icon glyphicon glyphicon-pencil"></i></button>
			</span>
		</form>
		'.$args->after.'</div><!--/.mr-input-row-->';
	}
}
if (!function_exists('get_player')) {
	function get_player($args) {
		$CI =& get_instance();
		/* Comes in from the DB as part of the session on AUTH */
		$playerType = $CI->session->userdata('video_player');
		$show_asl_video = $CI->session->userdata('show_asl_videos');
		$bitRate = $CI->session->userdata('video_bit_rate');
		$asl_button = '';
		$quality_button = '';
		if (HAS_ASL_VIDEOS){
			$asl_button = '<td id="mr-button-asl" data-toggle="tooltip" title="American Sign Language" class="mr-vc-r mr-button-asl" onclick="MR.video.control(this)"><i class="fa fa-american-sign-language-interpreting"></i><br/>'.($show_asl_video ? 'Yes' : 'No') .'</td>';
		}
		if (HAS_256K_VIDEOS){
			$quality_button = '<td data-toggle="tooltip" title="Video Quality" class="mr-vc-r mr-button-quality" onclick="MR.video.control(this)"><i class="icon glyphicon glyphicon-cog"></i><br/>'.$bitRate.'</td>';
		}
		$testControls = '';
		$args = (object) $args;
		if (!isset($args->control)) {
			$args->control = false;
		}
		if (!isset($args->before)){
			$args->before = '';
		}
		if (!isset($args->overlay_player_controls)){
			$args->overlay_player_controls = true;
		}

		if ($args->overlay_player_controls) {
			echo '<div id="mr-video">
			<div id="mr-player" data-player-type="'.$playerType.'" data-player-quality="'.$bitRate.'" data-player-show-asl-video="'.($show_asl_video ? 1 : 0).'">
				<video id="vjs-player" class="video-js vjs-default-skin"></video>'.$args->before;
			if ($args->control) {
				echo '<div id="mr-video-controls" class="overlayed"><table><tr>'.
				'<td class="mr-vc-r mr-button-rw" onclick="MR.video.control(this)" data-toggle="tooltip" title="Rewind"><i class="icon glyphicon glyphicon-backward"></i><br/>Rewind</td>'.
				'<td class="mr-vc-r mr-button-play" onclick="MR.video.control(this)" data-toggle="tooltip" title="Play / Pause"><i class="icon glyphicon glyphicon-pause"></i><br/>Pause</td>'.
				'<td class="mr-vc-r mr-button-ff" onclick="MR.video.control(this)" data-toggle="tooltip" title="Fast Forward"><i class="icon glyphicon glyphicon-forward"></i><br/>FF</td>'.
				'<td class="mr-vc-t vjs-default-skin"></td>'.
				'<td class="mr-vc-r mr-button-volume" onclick="MR.video.control(this)" data-toggle="tooltip" title="Volume"><i class="icon glyphicon glyphicon-volume-up"></i><br/>Volume</td>'.
				$asl_button.$quality_button.'</tr></table></div>';
			}
			echo '</div>';
			echo '</div>';
		} else {
			echo '<div id="mr-video">
			<div id="mr-player" data-player-type="'.$playerType.'" data-player-quality="'.$bitRate.'" data-player-show-asl-video="'.($show_asl_video ? 1 : 0).'">
				<video id="vjs-player" class="video-js vjs-default-skin"></video>'.$args->before.'</div>';
			if ($args->control) {
				echo '<table id="mr-video-controls" class="below"><tr>'.
				'<td class="mr-vc-r mr-button-rw" onclick="MR.video.control(this)"><i class="icon glyphicon glyphicon-backward"></i><br/>Rewind</td>'.
				'<td class="mr-vc-r mr-button-play" onclick="MR.video.control(this)"><i class="icon glyphicon glyphicon-pause"></i><br/>Pause</td>'.
				'<td class="mr-vc-r mr-button-ff" onclick="MR.video.control(this)"><i class="icon glyphicon glyphicon-forward"></i><br/>FF</td>'.
				'<td class="mr-vc-t vjs-default-skin"></td>'.
				'<td class="mr-vc-r mr-button-volume" onclick="MR.video.control(this)"><i class="icon glyphicon glyphicon-volume-up"></i><br/>Volume</td>'.
				$asl_button.$quality_button.'</tr></table>';
			}
			echo '</div>';
		}


	}
}
if (!function_exists('get_footer')) {
	function get_footer($args = null) {
		$args = (object) $args;
		if (!isset($args->logo)) {
			$args->logo = 'powered_by_medrespond.png';
		}
		if (!isset($args->before)) {
			$args->before = '';
		}
		if (!isset($args->after)) {
			$args->after = '';
		}
		$conversational_branding_text_footer_element = config_item('conversational_branding_text_footer_element');
		$cp = config_item('copyright');
		$other_logo = config_item('other_logo');
		echo '<div id="mr-footer">'.$args->before.$other_logo.'<a class="navbar-logo" target="_blank" href="http://www.medrespond.com"><img src="'.base_url().'assets/medrespond/images/'.$args->logo.'" alt="Powered by Medrespond" height="35" /></a>'.$conversational_branding_text_footer_element.$args->after.$cp.'<div style="clear:both;"></div></div>';
	}
}
if (!function_exists('get_nav_title')) {
	function get_nav_title($args = null) {
			echo '<span class="navbar-brand">';
				if (config_item('title_logo')) {
					echo config_item('title_logo');
				} else {
					echo config_item('title');
				}
			echo '</span>';
	}
}

if (!function_exists('get_video_text')) {
	function get_video_text($args = null) {
		$args = (object) $args;
		if (!isset($args->title)) {
			$args->title = true;
		}
		if (!isset($args->print)){
			$args->print = false;
		}
		if (!isset($args->after)){
			$args->after = '';
		}
		if (!isset($args->noAjax)){
			$args->noAjax = array('title' => false, 'video_text' => false);
		}
		if (!isset($args->share)){
			$args->share = false;
		}
		echo '<div id="video-text-div" class="mr-input-row mr-is-wrapper mr-row mr-row-scale">';
		echo '<div class="mr-is-scroller">';
		if ($args->print || $args->share){
			echo '<div id="mr-text-links" class="no-print">';
		}
		if ($args->print) {
			echo '<div title="Print this answer" id="mr-video-text-print" onclick="(function(){MR.video.player.pause(); $(\'#video-text-div\').find(\'.mr-is-scroller\').print();})();"><i class="glyphicon glyphicon-print"></i> Print</div>';
		}
		if ($args->share){
			echo '<div id="mr-share-link" onclick="MR.utils.share();"><i class="fa fa-facebook-official" aria-hidden="true"></i> Share</div>';
		}
		if ($args->print || $args->share){
			echo '<div style="clear:both;"></div></div>';
		}
		if ($args->noAjax['title']){
			echo '<h4 class="video-text-title">'.$args->noAjax['title'].'</h4>';
		}else{
			echo '<h4 class="video-text-title">{{response.name}}</h4>';
		}
		if ($args->noAjax['video_text']){
			echo '<p>'.$args->noAjax['video_text'].'</p>';
		}else{
			echo '<p ng-bind-html="response.video_text"></p>';
		}
		echo '</div>';
		echo '</div>';
	}
}
if (!function_exists('ajax_status_success')) {
	function ajax_status_success($supplemntal_data = array()) {
		$return_ar = array(
			'status'	=> 'success',
			'message'	 =>	 ''
		);
		echo json_encode(array_merge($return_ar, $supplemntal_data));
	}
}

if (!function_exists('ajax_status_failure')) {
	function ajax_status_failure($message, $supplemntal_data = array()) {
		$return_ar = array(
			'status'	=> 'failed',
			'message'	 =>	 $message
		);

		echo json_encode(array_merge($return_ar, $supplemntal_data));
	}
}

/***
 * Date Picker
 */
if (!function_exists('get_date_picker')){
	function get_date_picker($args = null, $echo = true){
		if (!isset($args['ng_model_start'])){
			$args['ng_model_start'] = 'search_start_date';
		}
		if (!isset($args['ng_model_end'])){
			$args['ng_model_end'] = 'search_end_date';
		}
		echo '<span class="input-group input-group-sm">
					<input type="text"
						class="form-control"
						datepicker-popup="{{format}}"
						ng-model="'.$args['ng_model_start'].'"
						is-open="start_datepicker_opened"
						min-date="\'2014-09-01\'"
						max-date="\''.date("Y-m-d", now() + 24*60*60).'\'"
						datepicker-options="dateOptions"
						date-disabled="disabled(date, mode)"
						ng-required="true"
						close-text="Close"
					/>
					<span class="input-group-btn">
						<button type="button" class="btn btn-default" ng-click="start_datepicker_open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
					</span>
					<span class="input-group-addon">through</span>
					<input type="text"
						class="form-control"
						datepicker-popup="{{format}}"
						ng-model="'.$args['ng_model_end'].'"
						is-open="end_datepicker_opened"
						min-date="\'2014-09-01\'"
						max-date="\''.date("Y-m-d", now() + 24*60*60).'\'"
						datepicker-options="dateOptions"
						date-disabled="disabled(date, mode)"
						ng-required="true"
						close-text="Close"
					/>
					<span class="input-group-btn">
						<button type="button" class="btn btn-default" ng-click="end_datepicker_open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
					</span>
				</span>';
	}
}
/***
 * Build Data Panel - Build a table for payloads. (Tired of so much angular lying around)
 */
if (!function_exists('build_shell_panel')) {
	function build_shell_panel($args = null, $echo = TRUE) {
		if (!isset($args['footer'])){
			$args['footer'] = '';
		}
		if (!isset($args['right'])){
			$args['right'] = '';
		}
		if (!isset($args['id'])){
			$args['id'] = '';
		}


		$panel = '<div id="'.$args['id'].'" class="mr-panel panel panel-default">';
		$panel .= '<div class="panel-heading">';
		$panel .= '<div class="pull-right">'.$args['right'].'</div>';
		$panel .= '<h1 class="panel-title"><i class="mr-modal-icon glyphicon glyphicon-cog"></i>'.$args['title'].'</h1>';
		$panel .= '<div style="clear:both;"></div></div>';
		$panel .= '<div class="panel-body">'.$args['body'].'</div><!--/.panel-body-->';
		if ($args['footer'] != ''){
			$panel .= '<div class="panel-footer">'.$args['footer'].'<div style="clear:both;"></div></div><!--/.panel-footer-->';
		}
		$panel .= '</div><!--/.panel-->';

		if($echo) {
			echo $panel;
			return;
		}

		return $panel;
	}
}
/***
 * Build Data Panel - Build a table for payloads. (Tired of so much angular lying around)
 */
if (!function_exists('build_data_panel')) {
	function build_data_panel($args = null) {
		if (!isset($args['id'])){
			$args['id'] = '';
		}
		if (!isset($args['right'])){
			$args['right'] = '';
		}
		if (!isset($args['ng_directive'])){
			$args['ng_directive'] = '';
		}
		if (!isset($args['ng_action'])){
			$args['ng_action'] = '';
		}
		if (!isset($args['type'])){
			$args['type'] = 'panel';
		}
		if (!isset($args['icon'])){
			$args['icon'] = 'cog';
		}
		if (!isset($args['title'])){
			$args['title'] = '';
		}
		if (!isset($args['spinner'])){
			$args['spinner'] = '';
		}
		if (!isset($args['sort_on'])){
			$args['sort_on'] = '';
		}
		$sort_order = 'DESC';
		if(isset($args['sort_order']) && in_array($args['sort_order'], array('ASC', 'DESC'))){
			$sort_order = $args['sort_order'];
		}

		$sort_on_var_prefix = str_replace('-', '_', $args['id']);
		$sort_on_column_var_name = $sort_on_var_prefix . '_sort_column_name';
		$sort_on_reverse_var_name = $sort_on_var_prefix . '_sort_reverse';

		/* This needs to be here for sorting on TH click on SCC because it is sorting objects*/
		if (!isset($args['is_object'])){
			$args['is_object'] = false;
		}
		echo '<div id="'.$args['id'].'" class="mr-panel mr-data-panel '.$args['type'].' '.$args['type'].'-default" ng-model="'.$args['ng_model'].'" '.$args['ng_directive'].'>';
		if ($args["type"] !== "table"){
			echo '<div class="'.$args['type'].'-heading">';
			echo '<div class="pull-right">'.$args['right'].'</div>';
			echo '<div><h1 class="'.$args['type'].'-title"><i class="mr-modal-icon glyphicon glyphicon-'.$args['icon'].'"></i>'.$args['title'].'</h1></div>';
			echo '<div style="clear:both;"></div>';
			echo '</div><!--/.'.$args['type'].'-heading-->';
		}
		echo '<div class="table-responsive" ng-init="'.$sort_on_column_var_name.'=\''.$args['sort_on'].'\';'.$sort_on_reverse_var_name.(($sort_order === 'DESC') ? '=!' : '==').$sort_on_reverse_var_name.'"><table class="table table-striped table-hover"><thead><tr>';
		foreach ($args['columns'] as $key => $value) {
			if (!isset($value['title'])){
				$value['title'] = '';
			}
			if (!isset($value['data_type'])){
				$value['data_type'] = '';
			}
			if ($value['data_type'] === 'custom'){
				$value["ng_data"] = 'custom';
			}
			echo '<th ng-class="{active:('.$sort_on_column_var_name.' === \''.$value["ng_data"].'\')}" ng-click="'.$sort_on_column_var_name.'=\''.$value["ng_data"].'\';'.$sort_on_reverse_var_name.'=!'.$sort_on_reverse_var_name.'">'.$value["title"];
			echo '<i class="mr-sort-arrow glyphicon" ng-class="{reverse:'.$sort_on_reverse_var_name.'}"></i>';
			echo '</th>';
		}
		echo '</tr></thead><tbody>';
		if ($args['is_object']){
			echo '<tr '.$args['ng_action'].' ng-repeat="'.$args['ng_repeat'].' in '.$args['ng_model'].' | orderObjectBy: '.$args['id'].'sort_column:'.$args['id'].'reverse" ng-cloak>';
		}else{
			echo '<tr '.$args['ng_action'].' ng-repeat="'.$args['ng_repeat'].' in '.$args['ng_model'].' | orderBy: [natural('.$sort_on_column_var_name.')]:'.$sort_on_reverse_var_name.'" ng-cloak>';
		}


		foreach ($args['columns'] as $key => $value) {
			$td = $args['ng_repeat'].'.'.$value["ng_data"];
			if (!isset($value['data_type'])){
				$value['data_type'] = false;
			}
			if ($value['data_type'] === 'boolean'){
				echo '<td>{{'.$td.' > 0 ? "Yes" : "No" }}</td>';
			}else if ($value['data_type'] === 'custom'){
				echo '<td>'.$value["ng_data"].'</td>';
			}else if ($value['data_type'] === 'html'){
				echo '<td ng-bind-html="'.$td.'"></td>';
			}else {
				echo '<td>{{'.$td.'}}</td>';
			}
		}
		echo '</tr>';
		echo $args['spinner'];
		echo '</tbody></table></div>';
		echo '</div><!--/.'.$args['type'].'-->';
	}
}

if (!function_exists('get_case_name')) {
	function get_case_name() {
		$CI =& get_instance();
		return $CI->property_model->get_current_case_name();
	}
}

if (!function_exists('get_user_info')) {
	function get_user_info($args) {
		$CI =& get_instance();
		return ($CI->session->userdata($args));
	}
}

if (!function_exists('is_admin')) {
	function is_admin() {
		$CI =& get_instance();

		if (!is_logged_in()) {
			return false;
		}

		return ($CI->session->userdata('user_type') == 'admin');

	}
}

if (!function_exists('is_logged_in')) {
	function is_logged_in() {
		$CI =& get_instance();
		return $CI->auth_library->is_logged_in();
	}
}

if (!function_exists('is_instructor')) {
	function is_instructor() {
		$CI =& get_instance();

		if(!is_logged_in()) {
			return false;
		}

		return ($CI->session->userdata('user_type') == 'instructor');
	}
}

if (!function_exists('is_anonymous_guest_user')) {
	function is_anonymous_guest_user() {
		$CI =& get_instance();
		return $CI->auth_library->is_anonymous_guest_user();
	}
}

if (!function_exists('is_medrespond_ip_address')) {
	function is_medrespond_ip_address() {
		$CI =& get_instance();
		$ip_address = $CI->input->ip_address();
		return $CI->medrespond_ip_addresses_model->is_medrespond_ip_address($ip_address);
	}
}

if (!function_exists('is_simple_user')) {
	function is_simple_user() {
		$CI =& get_instance();

		if(!is_logged_in()) {
			return false;
		}

		return ($CI->session->userdata('user_type') == 'user');
	}
}

if (!function_exists('is_site_admin')) {
	function is_site_admin() {
		$CI =& get_instance();

		if(!is_logged_in()) {
			return false;
		}

		return ($CI->session->userdata('user_type') == 'site_admin');
	}
}

if (!function_exists('get_logo_link')) {
	function get_logo_link(){
		return config_item('logo_link');
	}
}

if (!function_exists('get_base_question')) {
	function get_base_question($response_id, $project_name = MR_PROJECT) {
		if($response_id){
			$CI =& get_instance();
			return $CI->index_library->get_base_question($response_id, $project_name);
		}

		return '';
	}
}

if (!function_exists('get_question_content')) {
	function get_question_content($response_id, $project_name = MR_PROJECT) {
		if($response_id){
			$CI =& get_instance();
			return $CI->index_library->get_question_content($response_id, $project_name);
		}

		return '';
	}
}

if (!function_exists('get_meta_description')) {
	function get_meta_description($response_id){
		if($response_id) {
			$description = get_question_content($response_id);
			echo preg_replace('#<[^>]+>#', ' ', $description);
		}
	}
}

if (!function_exists('pp')) {
	function pp($array, $die = TRUE) {
		echo '<br class="clear" />';
		echo '<pre>' . print_r( $array, true ) . '</pre>';

		if($die) {
			die();
		}
	}
}

if (!function_exists('get_link')) {
	function get_link($key) {
		if(empty($links)) {
			static $links;
			$links = config_item('links');
		}

		return $links[$key];
	}
}

if (!function_exists('property_has_surveys')) {
	function property_has_surveys($property_id = PROPERTY_ID) {
		$CI =& get_instance();
		$CI->load->model('survey_model');
		return $CI->survey_model->property_has_surveys($property_id);
	}
}
?>

function BaseController($scope, $rootScope, $http, $q, $sce, $cookieStore, $location, $timeout)
{
	$scope.Math=Math;
	$scope.bug_information = {};
	$scope.consult_information = {};
	$scope.response = [];
	$scope.old_id = '';
	$scope.left_rail = [];
	$scope.resources = [];
	$scope.current_left_rail = '';
	$scope.input_question = '';
	$scope.input_question_disambiguated = null;
	$scope.question_feedback = {};
	$scope.showBugReport = false;
	$scope.showConsult = false;
	$scope.testData = {};
	$scope.showHelp = false;
	$scope.showAllResource = false;
	$scope.showDialog = false;
	$scope.videoPlaying = false;
	$scope.returningUser = false;
	$scope.showDisclaimer = false;
	$scope.video_url = '';
	$scope.showTestingModal = false;
	$scope.showPrivacyPolicy = false;
	$scope.showDeclineDisclaimer = false;
	$scope.decisionFlowSite = (window.location.pathname != '/#/');
	$scope.surveys = [];
	$scope.current_survey = null;
	$scope.user_survey_question_responses = {};
	$scope.num_responses_viewed = 0;
	/* Makes it so the backend ignores saving the users last state */
	$scope.skip_last_response_save = false;
	$scope.my_answers = {};
	$scope.showMyAnswers = false;
	$scope.course = false; // For SBIRT Stuff
	$scope.question_title = "Related Questions:";
	$scope.return_response_when_leaving_flow = '';
	$scope.user_action = 'LRQ';
	$scope.madio_done = '';
	$scope.speaker = '';
	$scope.video_bit_rate = $("#mr-player").attr("data-player-quality");
	$scope.show_asl_video = ($("#mr-player").attr("data-player-show-asl-video") == 1) ? true : false;
	$scope.cached_input_question = ''; //For use with Ratings
	$scope.cached_input_question_disambiguated = null;
	$scope.idleTime = 0; // Force logouts when this hits MR_IDLE_TIME
	$scope.show_facebook_share_button = false;
	$scope.questionResponse = ''
	/***
	 * Does all of the URL routing
	 */
	$scope.$on("$locationChangeStart", function(event, next, current) {
		$scope.route_page(event, next, current);
	});

	/***
	 * Do whatever needs done once the response has been loaded that
	 * is specific to this controller
	 * Handles event: base_controller.responseLoaded
	 */
	$scope.$on("responseLoaded", function(event, args) {
		/* Only do this for SEO enabled open sites. Can be set in index.php */
		if ($('html').attr("data-mr-seo") == '1'){
	    var metaTitle = args.response.name || '';
	    var metaDesc = args.response.video_text || '';
	    var metaImg = args.response.still_image_path || '';

	    $("title").text(args.response.name + ' - ' + $("html").attr("data-mr-title"));
	    //$("meta[name='description']").attr("content", metaDesc);
		}

		/* Kill stuck modal */
		MR.modal.hide('#mr-stuck-modal');
		/* Kill all remaining popovers. */
		$('.popover').each(function(){
			$(this).popover('destroy');
		});
		var flashWait = 0;
		if (MR.video){
			if (MR.video.flash == true){
				flashWait = 1500;
			}
		}
		window.setTimeout(function(){
			if ($scope.response.popup){
				MR.utils.popover({
					element: '#input_question',
					title: 'Information:',
					content: $scope.response.popup,
					delay: 500
				});
			}
		},flashWait);
		/* Wait a 300ms before updating some UI Stuff */
		window.setTimeout(function(){
			if (MR.scroll){
				MR.scroll.refreshAll();
				MR.scroll.scrollTop("#video-text-div");
			}
			/* Destroy and recreate tooltips */
			$('.tooltip').each(function(){
				$(this).tooltip('destroy');
			});
			$('#mr-input-row').find("[data-toggle='tooltip']").tooltip({
				'placement': 'top',
				'container':'body'
			});
		},300);
	});

	$scope.$on('$destroy', function() {
		// Destroy the object if it exists
		if ((MR.video.player !== undefined) && (MR.video.player !== null)) {
			MR.video.player.dispose();
		}
	});
	/***
	 * Do what needs done after the video finishes that is specific to this
	 * controller
	 * Handles event: base_controller.videoFinished
	 */
	$scope.$on("videoFinished", function(event, args) {
	/***
	 * Basically going to hardcode all this specific logic for what we want to do
	 * after a video plays. This might not be the best way to do this but at least
	 * it's contained in this controller.
	 * If there are too many of theses special cases we will have to think of something else
	 *
	 * Open resources if there was media mentioned
	 */
		if (args.response.id == "scc167") {
			$scope.show_my_answers();
		} else if (!(args.response.video_controls.hidden === "true") &&
								(args.response.video_controls.next_id != "")) {
			var current_response = args.response.id;
			/***
			 * For SBIRT, and our demo go to next video immediately.
			 * Unless we're on a MADIO or a TEST response
			 */
			if (MR.core.project_type == "training" || MR.core.project_type == "military_training" || MR.core.project == 'mrd'){
				if (($scope.response.id == current_response)){
					if (args.response.type != "test" &&
							args.response.type != 'offtopic' &&
							args.response.type != 'directive' &&
							args.response.type != 'accusatory' &&
							args.response.type != 'ineffectual' &&
							args.response.type != 'custom'){
								window.location = '/' + MR.core.base_url+'#/DONE/'+args.response.video_controls.next_id;
					}
				}
			} else {
				/* Delay before next video if the video type is not a question */
				if (args.response.ask_controls.action != 'comment' &&
						args.response.ask_controls.action != 'multiple_choice' &&
						args.response.ask_controls.action != 'question'
					){
					setTimeout(function(){
						// If the user hasn't moved to a different response, move to the next response
						if (($scope.response.id == current_response)){
							window.location = '/' + MR.core.base_url+'#/NEXT/'+args.response.video_controls.next_id;
						}
					}, 2000);
				}//if
			}//else
		}//if
	});

	///////Form Responses //////////

	//Testing
	// MR.modal.show("#user_questions_modal");
	///////
	$scope.formQuestionsWhiteList = [];
	$scope.enableSave = false;
	$scope.cancelModalRoute = 'cnl355';

	$scope.formResponses = {
		'cnl011':{'answer':''},
		'cnl353': {'answer':''},
		'cnl034': {'answer':''},
		'cnl041': {'answer':''},
		'cnl071': {'answer':''},
		'cnl123': {'answer':''},

	}
	$scope.formQuestions = {
		'cnl011':{'text': 'What type of cancer do you have?','questions':["I Don't Know", "Non-small cell lung cancer", "Small cell lung cancer"]},
		'cnl353': {'text': 'Update your profile?','questions': ['Yes', 'No']},
		'cnl034': {'text': 'What type of Non-small cell lung cancer?','questions': ['Adenocarcinoma', 'Squamous cell carcinoma', 'Large cell carcinoma', 'Cancer of unknown primary origin (CUP)', "I Don't Know"]},
		'cnl041': {'text': 'What stage is your Non-small cell lung cancer?','questions': ['Stage IA', 'Stage IB', 'Stage IIA', 'Stage IIB', 'Stage IIIA', 'Stage IIIB',"Stage IVA", "Stage IVB", "I Don't Know"]},
		'cnl071': {'text': 'What stage is your small cell lung cancer?','questions': ['Limited', 'Extensive', "I Don't Know"]},
		'cnl123': {'text': 'Prognosis Information Preference?','questions': ['Know Prognosis Information Now', 'Know Prognosis Information Later']}
	}
	$scope.createWhiteList = (enableSave) => {
		$scope.enableSave = enableSave;
		switch ($scope.formResponses['cnl011']['answer']) {
			case "I don't know":
				$scope.formQuestionsWhiteList = ['cnl011', 'cnl123']
				break;
			case "Non-small cell lung cancer":
				$scope.formQuestionsWhiteList = ['cnl011', 'cnl034', 'cnl041', 'cnl123']
				break;
			case "Small cell lung cancer":
				$scope.formQuestionsWhiteList = ['cnl011', 'cnl071', 'cnl123']
				break;
			default:
				$scope.formQuestionsWhiteList = ['cnl011', 'cnl123']
				break;
		}
	}

	$scope.selectQuestionResponse = function(event){
		$scope.questionResponse = event.target.defaultValue;

	}
	$scope.setFormResponses = function(key, val){
		$scope.formResponses[key] = val;
	}

	// Gather user data around the questions they have answered
	const getUserResponses = function(){
		$http.get('/base/ajax_angular_get_user_responses')
		.success(function(data, status, headers, config) {
			if (data.status == 'success' && data.response.data){
				//Set modal data with saved user data
				Object.keys(data.response.data).forEach((key)=>{
					if($scope.formResponses[key]){
						$scope.formResponses[key]['answer'] = data.response.data[key].answer;
					}
				})
				$scope.createWhiteList();
			}else if(data.status !== 'success'){
				// Don't know if this alert is neccesary
				MR.utils.alert({type:'error',message: 'User profle data could not be found.'});
			}

		})
	}	
	getUserResponses();

	$scope.linkInModule = function(response_id, module_id){	
		let result = false;
		if($scope.left_rail && $scope.left_rail){
			$scope.left_rail.forEach(function(el){
				if(el.id == module_id){
					el.responses.forEach(function(response){
						if(response[0]['id'] == response_id){
							result = true;
						}
					})
				}
			})
			return result;
		}
	}
	$scope.updateUserProfile = function(){
		if($scope.formResponses){
			$http.post('/base/ajax_angular_update_user_responses', {
				"responses" : $scope.formResponses,
				"current_response" : $scope.response.id,
			}).success(function(data, status, headers, config) {
				if (data.status == 'success'){
					if(data.response.response_id){
						//Navigate to response id returned from call
						MR.modal.hide("#user_questions_modal");
						window.location = '/' + MR.core.base_url+'#/NEXT/'+data.response.response_id;
					}else{
						//No response id
						MR.modal.hide("#user_questions_modal");

						MR.utils.alert({type:'error',message: 'No response id from server.'});
					}
				}
			})
		}
	}
	$scope.continue_single_choice = function(){
		//Check that the spelling is consistent with what is expected in base.php
		if($scope.questionResponse ){
			$http.post('/base/ajax_angular_submit_response', {
				"question_response" : $scope.questionResponse,
				"current_response" : $scope.response.id,
				"response_id" : $scope.response.id,
			}).success(function(data, status, headers, config) {
				if (data.status == 'success'){
					if(data.response.update_user_profile){
						MR.modal.show("#user_questions_modal");
						//Show modal
					}else if(data.response.response_id){
						//Navigate to response id returned from call
						window.location = '/' + MR.core.base_url+'#/NEXT/'+data.response.response_id;
					}else{
						//No response id
						MR.utils.alert({type:'error',message: 'No response id from server.'});
					}
				}
			})
		}else {
			//Error thrown if spelling doesn't match, case sensitive
			MR.utils.alert({type:'error',message: 'Answer not provided.'});

		}
	}
	////////////FORM///////

	$scope.start_app = function(response_id) {
		$scope.load_surveys();
	};

	$scope.route_page = function(event, next, current){

		if (next.slice(-3) == "/#/"){

		}else{
			/* Fix this popover to not bind itself to random elements */
			if ($(event.target).hasClass('ng-binding')){
				var tar = $(event.target).parent("a");
			}else{
				var tar = $(event.target);
			}
			if ($.check_repeats(next,current, tar)) {
				return false;
			}
		}

		var str = MR.utils.getHash(next);

		if (str){
			if (str.substring(0, 1) == '/') {
				str = str.substring(1);
			}
			str = str.split("/");
			/* Set Right Side Title */
			$scope.question_title = "Related Questions:";
			/* Load Response */
			$scope.user_action = str[0];

			/* Prevent navigating to nothing (Rushing next/prev clicks in IE) */
			if (str[1] === '' || !str[1] || str[1] == 'undefined'){
				if (MR.scope){
					return false;
				}else{
					$scope.user_action = 'LRQ';
					$scope.load_response(null,'LRQ');
				}
			}
			if (str[0] === ''){
				/* Welcome Response */
				$scope.user_action = 'LRQ';
				$scope.load_response(null, 'LRQ');
			}else if (str[0] === 'LRQ'){
				$scope.load_response(str[1], str[0]);
			}else if (str[0] === 'R'){
				$scope.load_response(str[1], str[0]);
			}else if (str[0] === 'RETURN'){
				$scope.load_response(str[1], str[0]);
			}else if (str[0] === 'DONE'){
				$scope.load_response(str[1], str[0]);
			}else if (str[0] === 'A'){
				$scope.load_response(str[1], str[0]);
			}else if (str[0] === 'Q'){
				$scope.load_response(str[1], str[0]);
			}else if (str[0] === 'NEXT'){
				$scope.load_next_response(str[1]);
			}else if (str[0] === 'START'){
				$scope.load_response(str[1],str[0]);
			}else if (str[0] === 'PREVIOUS'){
				$scope.load_prev_response(str[1]);
			}else if (str[0] === 'RELATED'){
				$scope.load_related_question(str[1],str[2],str[3]);
			}else if (str[0] === 'MA'){
				$scope.question_title = "Multiple Answers:";
				$scope.call_analyzer(decodeURIComponent(str[1]));
			}else{

			}
		}else{
			$scope.user_action = 'LRQ';
			$scope.load_response(null,'LRQ');
		}
	};

	$scope.log_user_input = function() {
	 /***
		* The variable $scope.response.id is from the base_controller. This only works because we are calling
		* this function when nested inside the base_controller. If this function must be called outside
		* the base_controller then this will need to be refactored somehow
		*/
		$http.post('/base/ajax_angular_log_user_input', {"user_input_question" : $scope.user_input_question, "current_response" : $scope.response.id, 'show_asl_video' : $scope.show_asl_video} ).
		success(function(data, status, headers, config)
		{
			if (data.status == 'success')
			{
				$scope.input_question = '';
				$scope.user_input_question = '';
				$scope.load_response($scope.response.video_controls.next_id);
			}
			else {
				MR.utils.alert({type:'error',message: data.message});
			}
		}).
		error(function(data, status, headers, config)
		{
			MR.utils.alert({type:'error',message:'Error logging answer'});
		});
	};

	$scope.rate_response = function(ans){
		$http.post('/base/ajax_rate_response', {
			"input_question" : $scope.cached_input_question,
			"input_question_disambiguated" : $scope.input_question_disambiguated,
			"current_response" : $scope.response.id,
			"response_id" : $scope.response.id,
			"response_question" : $scope.response.name,
			"response_type" : ans,
			"show_asl_video" : $scope.show_asl_video
		}).success(function(data, status, headers, config) {
			if (data.status == 'success'){
				if (ans != 'Answered'){
					if(MR.core.project == 'epr') {
						MR.utils.alert({type:'info',message:'For an answer to your question, please contact a member of your healthcare team.'});
					} else if(MR.core.project == 'nsd') {
						MR.utils.alert({type:'info',message:'For an answer to your question please contact NAMI San Diego Helpline at 1-800-523-5933 or ask another question.'});
					} else if(MR.core.project == 'nami_white_label_demo_asl' || MR.core.project == 'nami_white_label_demo_eng') {
						MR.utils.alert({type:'info',message:'For an answer to your question, please contact a behavioral health professional.'});
					} else if (MR.core.project == 'enr'){
						MR.modal.show("#question-feedback-modal");
					} else {
						MR.utils.alert({type:'info',message:'For an answer to your question, please contact a member of the study staff or ask a new question.'});
					}
				}else{
					MR.utils.alert({type:'success',message:'Thank you for your feedback.'});
				}
				$scope.cached_input_question = false;
				$scope.cached_input_question_disambiguated = null;
			} else {
				MR.utils.alert({type:'error',message: data.message});
			}
		}).error(function(data, status, headers, config) {
			MR.utils.alert({type:'error',message:'Error logging answer'});
		});
	};

	$scope.show_my_answers = function() {
		$http.post('/base/ajax_angular_get_my_answers').
		success(function(data, status, headers, config)
		{
			if (data.status == 'success')
			{
				$scope.my_answers = data.my_answers;
			}
			else
			{
				MR.utils.alert({type:'error',message:data.message});
			}
		}).
		error(function(data, status, headers, config)
		{
			MR.utils.alert({type:'error',message:'Error retreiving your answers'});
		});
		$scope.showMyAnswers = true;
	};

	// Hack to prevent from fields being sorted alphabetically
	$scope.keys = function(obj) {
		// Slicing off the last element because it is a $$hashKey
		return obj? Object.keys(obj).slice(0,-1) : [];
	};

	$scope.load_next_response = function(next_id) {
		$scope.load_response(next_id, 'NEXT', function() {
			// If we're hitting next video we're jumping back into the flow so we can remove the state
			$scope.return_response_when_leaving_flow = '';
		});
	};

	$scope.load_prev_response = function(next_id) {
		$scope.load_response(next_id, 'PREVIOUS', function() {
			// If we're hitting next video we're jumping back into the flow so we can remove the state
			$scope.return_response_when_leaving_flow = '';
		});
	};

	$scope.load_related_question = function(related_question_id, current_id, next_id) {
		// We only do special tracking of state when loading a related response if the user
		// is in a conversation module. To indicate if a user is in a conversation module, we check
		// if the left rail is disabled
		if ($scope.response.left_rail){
			if ($scope.response.left_rail.hidden == 'true'){
				// Save the video that we need to return to once we hit 'next video'
				// We save the original leaving point until the user goes to "next video" where
				// it is reset
				if ($scope.return_response_when_leaving_flow == '')
				{
					$scope.return_response_when_leaving_flow = current_id;
				}

				$scope.load_response(related_question_id, 'RELATED', function() {
					$scope.response.video_controls.hidden = 'false';
					$scope.response.ask_controls.hidden = 'true';
					$scope.response.left_rail.hidden = 'true';
					$scope.response.video_controls.previous_id = $scope.return_response_when_leaving_flow;
					$scope.response.video_controls.next_id = next_id;
				});
			}else{
				$scope.load_response(related_question_id, 'RELATED');
			}
		}else{
			$scope.load_response(related_question_id, 'RELATED');
		}
	};

	$scope.load_surveys = function() {
		$http.get('/surveys/ajax_angular_get_surveys')
			.success(function(data, status, headers, config) {
				$scope.surveys = data.surveys;

				// set the current survey
				if($scope.surveys.length > 0) {
					var completed_survey_ids = $scope.get_completed_survey_ids();

					for(var i = 0; i < $scope.surveys.length; i++) {
						if(completed_survey_ids.indexOf($scope.surveys[i].id)) {
							$scope.current_survey = $scope.surveys[i];
							break;
						}
					}
				}
			})
			.error(function(data, status, headers, config) {
				MR.utils.alert({type:'error',message:'Error loading surveys'});
			});
	};

	$scope.accept_disclaimer = function() {
		window.location = '/base';
	};

	$scope.decline_disclaimer = function() {
		$scope.showDeclineDisclaimer = true;
	};

	/***
	 * Private check spelling (called from call analyzer)
	 */
	$scope.check_spelling = function(callback,q) {
		var cb = callback || function(){};
		var input = $scope.input_question;
		var words;
		var badWord = false; //If we've got a spelling error

		if (MR.dictionary){
			do {
				words = input.split(" ");
				$.each(words,function(windex,wvalue){
					$.each(MR.dictionary,function(i,item){
						$.each(item.bad,function(key,value){
							badWord = false;
							if (wvalue.toLowerCase() == item.bad[key]){
								badWord = true;
								words[windex] = item.good;
								input = words.join(" ");
							}
						});
					});
				});
			} while (badWord == true);

			$("#input_question").val(input);
			$scope.input_question = input;

		}// if dictionary
		cb();
		return false;
	};

	/***
	 * Calls Bob's Magical analyzer
	 */
	$scope.call_analyzer = function(iq) {
		if (iq){
			i_question = iq;
		}else{
			i_question = $scope.input_question;
		}
		if (!i_question || i_question === null || i_question === ""){
			MR.utils.popover({
				element: '#input_question',
				type: 'error',
				title: 'What would you like to ask?',
				content: 'Please type a question in the box before pressing the ask button.'
			});
			return false;
		/* Limit Questions to MAX Characters */
		}else if (i_question.length > $('html').attr("data-mr-ask-length")){
			MR.utils.popover({
				element: '#input_question',
				type: 'error',
				title: 'Too many characters.',
				content: "Please limit what you type in this box to "+$('html').attr("data-mr-ask-length")+" characters and try again."
			});
			return false;
		}
		/* ToDo: Logic needs to be done here for correct answer. */
		if ($scope.response.ask_controls.action == "answer"){
			$location.path('/NEXT/'+$scope.response.video_controls.next_id);
			return;
		}
		/* Old Response */
		$scope.old_id = $scope.response.id;
		$http.post('/base/ajax_angular_call_analyzer', {"input_question" : i_question, "current_response" : $scope.response.id, "case_name" : $scope.response.case_name, "ask_controls" : $scope.response.ask_controls.action} ).
		success(function(data, status, headers, config) {
			if (data.status == 'success') {



				if ($scope.response.type != "MA"){
					if ($.check_repeats($scope.response.id,data.response.id, $("#input_question")) == true){
						return false;
					}
				}
				/* Hardcoded Result for NULL response... We need better coverage of nulls */
				if ((data.response.id != 'scc174') && (data.response.id != 'scc175')){

				}else {
					$scope.replay_video();
				}
				/* ToDo: The entire call_analyzer and load_response functions
				 * need to be recoded to support direct video access or analyzer search
				 * strings through the /#/ hash in the URL.
				 * i.e http://www.xxx.xxx/#/CA/Input-Question-Here
				 *		 http://www.xxx.xxx/#/LR/scc222
				 */
				var oldAction = $scope.response.ask_controls.action;
				$scope.response = data.response;
				if (data.response.type === "MA"){
					if ($location.path() != '/MA/'+i_question){
						$location.path('/MA/'+i_question);
					}else{
						$scope.response = data.response;
						$scope.left_rail = data.left_rail;
						$scope.current_left_rail = data.current_left_rail;
						$scope.returningUser = data.returning_user;
						$scope.input_question = '';
						$scope.load_video();
						// Broadcast to the other controllers that a response was loaded so they can do anything specific they want
						$scope.$broadcast("responseLoaded", {response: $scope.response});
					}
				}else{
					if (oldAction != "question"){
						$location.path('/Q/'+data.response.id);
					}else{
						$location.path('/A/'+data.response.id);
					}
				}

				$scope.cached_input_question = i_question;
				$scope.input_question_disambiguated = data.input_question_disambiguated;
				$scope.cached_input_question_disambiguated = data.input_question_disambiguated;

				if (data.madio_done){
					$scope.madio_done = data.madio_done;
				}
			}else {
				MR.utils.popover({
					element: '#input_question',
					type: data.status,
					title: data.status,
					content: data.message
				});
			}
		}).error(function(data, status, headers, config) {
			MR.utils.alert({type:'error',message:'Error calling analyzer'});
		});
	};

	$scope.enter_contest = function() {
		$http.post('/base/ajax_angular_submit_contest_entry', $scope.existing_user)
			.success(function(data, status, headers, config) {
				if(data.status === 'success') {
					MR.utils.alert({type:'success', message:data.message});
					MR.modal.hide('#draw-modal');
					$location.path('/DONE/enr4002');
				} else {
					MR.utils.alert({type:'error', message:data.message});
				}
			})
			.error(function(data, status, headers, config) {
				MR.utils.alert({type:'error', message:data.message});
			});
	};

	$scope.open_contest_modal = function() {
		$http.get('/base/ajax_angular_get_contest_form_data')
			.success(function(data, status, headers, config) {
				$scope.existing_user = data.user;
				$scope.existing_user.terms_accepted = false;
				$scope.provinces = data.provinces;
				MR.modal.show('#draw-modal');
			})
			.error(function(data, status, headers, config) {
				MR.utils.alert({type:'error', message:data.message});
			});
	};

	$scope.load_response = function(response_id, type, callback) {
		$scope.num_responses_viewed++;

		if ($('html').attr('data-mr-rid')){
			response_id = $('html').attr('data-mr-rid');
		}
		/* Broadcast to the other controllers that a response is loading */
		$scope.response.video_controls = {};
		$scope.$broadcast("responseLoading", {"response": response_id, "type": type});
		$http.post('/base/ajax_angular_load_response', {
			"input_question": $scope.input_question,
			"input_question_disambiguated": $scope.input_question_disambiguated,
			"logged_case_name": $scope.response.logged_case_name,
			"response_id" : response_id,
			"type" : type,
			"current_response" : $scope.old_id,
			"decision_flow_site" : $scope.decisionFlowSite,
			"skip_last_response_save" : $scope.skip_last_response_save,
			'video_bit_rate': $scope.video_bit_rate,
			'show_asl_video' : $scope.show_asl_video,
		}).success(function(data, status, headers, config) {
			/* When a controller issues a hard redirect */
			console.log(data, 'data')
			if (!data){
				return;
			}
			if (data.status == 'success') {
				/* SBIRT directions popups */
				$scope.course = data.course;
				$scope.response = data.response;
				$scope.response.video_text = $sce.trustAsHtml($scope.response.video_text);
				$scope.old_id = data.response.id;
				$scope.left_rail = data.left_rail;
				$scope.current_left_rail = data.current_left_rail;
				$scope.returningUser = data.returning_user;
				$scope.input_question = '';
				$scope.input_question_disambiguated = null;
				$scope.speaker = data.speaker;
				$scope.video_bit_rate = data.video_bit_rate;
				$scope.show_asl_video = (data.show_asl_video == 1) ? true : false;


				$timeout(function() {
					$('.term-definition').tooltip('destroy');
					$('.term-definition').tooltip();
				});

				MR.modal.hide('#test-status-modal');
				$scope.showMyAnswers = false; //SCC
				if(MR.core.project == 'tss') {
					TSS.core.cssFixes($scope.response.video_text.length);
				}
				if (data.response.ask_controls.action === "answer"){
					$scope.testData = [];
					$scope.test = data.test;
				} else if (data.response.ask_controls.action === "test"){
					$scope.testData = [];
					$scope.test = data.test;
					if (MR.core.project_type == "training" || MR.core.project_type == "military_training"){
						MR.modal.show("#test-modal",true);
						$scope.response['video_name'] = 'asb_splash';
					}
				} else if (data.response.ask_controls.action === "multiple_choice" || data.response.ask_controls.action === "comment"){
					$scope.testData = [];
					$scope.test = data.test;
				} else{
					if (MR.core.project_type == "training" || MR.core.project_type == "military_training"){
						MR.modal.hide("#test-modal");
					}
				}
				if ($scope.response.type == 'custom'){
					if (MR.core.project_type == "training" || MR.core.project_type == "military_training"){
						$scope.response['video_name'] = 'asb_splash';
					}
				}
				if ($scope.response.media.length > 0) {
					window.setTimeout(function(){
						MR.utils.popover({
						element: '#resources_dropdown',
						type: 'warning',
						placement:'bottom',
						trigger:'manual',
						title: false,
						content: 'This topic has related resources.'
					});},500)

				}
				$scope.load_video();
				// Broadcast to the other controllers that a response was loaded
				$scope.$broadcast("responseLoaded", {response: $scope.response});
				// Optional callback
				if (callback) {
					callback();
				}
				/* MADIO stuff */
				var madio = $scope.response.type;
				if (madio == 'offtopic' ||
						madio == 'directive' ||
						madio == 'accusatory' ||
						madio == 'ineffectual' ||
						madio == 'custom') {
					if (madio == 'offtopic'){
						madio = 'off-topic. Listen carefully to the instructions given by the host';
					}else{
						madio = 'too ' + madio;
					}
					var pop_lock = "#mr-video-prev";
					var pop_message = "Click the previous button [ < ] to try again.";
					if ($scope.madio_done != ''){
						$scope.response.video_controls.next_id = $scope.madio_done;
						pop_lock = "#mr-video-next";
						pop_message = "The max amount of attempts for this skill practice have been used. Click the next button [ > ] to move on.";
					}else{
						$scope.response.video_controls.next_id = '';
					}
					if ($scope.response.wrong_answer_text || madio == 'custom'){
						pop_message = $scope.response.wrong_answer_text+" "+pop_message;
					}else{
						pop_message = "Your answer was "+madio+". "+pop_message;
					}
					var flashWait = 0;
					if (MR.video){
						if (MR.video.flash == true){
							flashWait = 1500;
						}
					}
					window.setTimeout(function(){
						MR.utils.popover({
							element: pop_lock,
							type: 'warning',
							cl: 'sticky',
							trigger:'manual',
							placement:"right",
							title: 'Information:',
							content: pop_message
						});
					},flashWait);
				}
				if ($scope.madio_done != ''){
					//$scope.response.type = '';
					$scope.madio_done = '';
				}
			} else {
				$("#mr-vid-fader").stop(false,false).fadeOut(300);
				var debugMessage = '';

				if (!data.message){

				}else{
					MR.utils.alert({type:data.status,message:data.message,debug:data.message.debug});
				}
				//if the response is null, try and load the previous user state.
				if (!$scope.response.id){
					$scope.load_returning_user_state();
				}
			}

			if($scope.num_responses_viewed >= 10) {
				MR.video.player.on('loadeddata', function() {
					$scope.show_survey_modal();
				});
			}
		}).error(function(data, status, headers, config) {
			MR.utils.alert({type:'error', message:'Error loading response'});
		});
	};

	$scope.load_left_rail = function(left_rail_id) {
		$http.post('/base/ajax_angular_load_left_rail', {"left_rail_id" : left_rail_id}).
		success(function(data, status, headers, config) {
			if (data.status == 'success') {
				$scope.left_rail = data.left_rail;
				$scope.current_left_rail = data.current_left_rail;
			}
			else {
				MR.utils.alert({type:'error',message: data.message});
			}
		}).error(function(data, status, headers, config) {
			MR.utils.alert({type:'error',message: 'Error loading left rail'});
		});
	};

	$scope.load_returning_user_state = function() {
		$http.post('/base/ajax_angular_load_returning_user_state', {"current_response" : $scope.response.id }).
		success(function(data, status, headers, config) {
			console.log(data, 'returning user state')
			if (data.status == 'success') {
				console.log("hello")
				$location.path('/NEXT/'+data.response.id);
				$scope.load_response(data.response.id, 'NEXT');
			}
			else {
				MR.utils.alert({type:'error',message: data.message, debug:data.debug});
				MR.modal.show('#mr-stuck-modal');
			}
		}).error(function(data, status, headers, config) {
			MR.utils.alert({type:'error',message: 'Error loading response'});
		});
	};

	/***
	 * So redundant, but works on everything including iPad.
	 * Sould probably be done differently in the future, but for now
	 * this pile of code works well enough.
	 */
	$scope.load_video = function() {
		video_bit_rate = $scope.video_bit_rate;
		show_asl_video = $scope.show_asl_video;
		video_name = $scope.response['video_name'];
		web_domain = $scope.response['web_domain'];
		rtmp_domain = $scope.response['rtmp_domain'];

		if(show_asl_video) {
			video_name = video_name + '_asl';
		}

		if (video_bit_rate == ''){
			video_bit_rate = '512k';
		}

		video_name = video_name+"_"+video_bit_rate;

		poster_image = false;
		if ($scope.speaker != ''){
			video_name = video_name.insertBeforeLastOccurrence('_', $scope.speaker);
		}
		web_url = 'https://'+web_domain+'/'+video_name;
		rtmp_url = 'https://'+rtmp_domain+'/cfx/st/&mp4:'+video_name;

		if ($scope.response.still_image_path !== ''){
			poster_image =  'https://'+$scope.response['web_domain']+$scope.response.still_image_path;
		}

		var playlist = [
			{ type: "video/mp4", src: web_url+".mp4" },
			{ type: "rtmp/mp4", src: rtmp_url+".mp4"},
			{ type: "video/webm", src: web_url+".webm" },
			{ type: "video/ogg", src: web_url+".ogv" }
		];

		if (MR.video.bound == false){
			MR.video.init(playlist,poster_image);
		}else{
			MR.video.setPoster(poster_image);
			MR.video.player.src(playlist);
		}

	};

	$scope.store_feedback_answer = function(question_number, answer) {
		if (!$cookieStore.get('feedback_answers'))
		{
			$cookieStore.put('feedback_answers', []);
		}

		var feedback_answers = $cookieStore.get('feedback_answers');
		feedback_answers[question_number] = answer;
		$cookieStore.put('feedback_answers', feedback_answers);

		// If it is the last question, save the information to the database
		if (question_number == 6)
		{
			$scope.log_feedback_input();
			$cookieStore.remove('feedback_answers');
		}

		$scope.load_response($scope.response.video_controls.next_id);
		$scope.store_feedback_question = '';
	};

	$scope.log_feedback_input = function() {
		$http.post('/base/ajax_angular_log_feedback_input', {"answers" : $cookieStore.get('feedback_answers')}).
		success(function(data, status, headers, config) {
			if (data.status == 'success') {
				$scope.input_question = '';
			}
			else {
				MR.utils.alert({type:'error',message:data.message});
			}
		}).error(function(data, status, headers, config) {
			MR.utils.alert({type:'error',message:'Error logging feedback'});
		});
	};

	$scope.replay_video = function() {
		MR.video.player.currentTime(0.0);
		MR.video.player.play();
	};

	$scope.send_question_feedback = function() {
		$http.post('/base/ajax_angular_question_feedback', {"question_feedback" : $scope.question_feedback}).
		success(function(data, status, headers, config) {
			if (data.status == 'success') {
				$scope.question_feedback.question = '';
				$scope.question_feedback.terms_accepted = false;
				MR.utils.alert({type:'success',message:data.message});
				MR.modal.hide('#question-feedback-modal');
			} else {
				MR.utils.alert({type:'error',message:data.message});
			}
		}).error(function(data, status, headers, config) {
			MR.utils.alert({type:'error',message:data.message});
		});
	};

	$scope.send_bug_report = function() {
		/* Grab Image from the element core.js barfed our image data to prior to loading this modal. */
		$scope.bug_information.last_message = $("#bugLastMessage").val();
		$scope.bug_information.video_ping = $("#bugPingData").val();
		$http.post('/base/ajax_angular_bug_report', {"bug_information" : $scope.bug_information, "current_response" : $scope.response.id}).
		success(function(data, status, headers, config) {
			if (data.status == 'success') {
				$scope.bug_information = {};
				MR.utils.alert({type:'success',message:data.message});
				MR.modal.hide('#bug-modal');
			} else {
				MR.utils.alert({type:'error',message:data.message});
			}
		}).error(function(data, status, headers, config) {
			MR.utils.alert({type:'error',message:data.message});
		});
	};

	$scope.request_consult = function() {
		//window.location = '/base/download/pdf/contact_supportive_care/contact_supportive_care.pdf';
		$http.post('/base/ajax_angular_consult_information', {"consult_information" : $scope.consult_information, "current_response" : $scope.response.id}).
		success(function(data, status, headers, config) {
			if (data.status == 'success') {
				$scope.consult_information = {};
				MR.utils.alert({type:'success',message:data.message});
			}
			else {
				MR.utils.alert({type:'error',message:data.message});
			}
		}).error(function(data, status, headers, config) {
			MR.utils.alert({type:'error',message:data.message});
		});
	};

	$scope.show_help = function() {
		$scope.showHelp = true;
		startHelp();
	};

	$scope.show_report_a_bug = function() {
		$scope.showBugReport = true;
	};

	$scope.show_consult = function() {
		$scope.showConsult = true;
	};

	$scope.show_privacy_policy = function() {
		$scope.showPrivacyPolicy = true;
	};

	$scope.retry_test = function(){
		$scope.testData = [];
		$scope.load_prev_response($scope.response.id);
	};

	$scope.submit_comment = function(skip) {
		if(skip) {
			$scope.testData = ' ';
		}

		var postdata = {
			test_key : $scope.test.key,
			answer : $scope.testData
		};

		$http.post('/base/ajax_angular_submit_comment', postdata)
			.success(function(data, status, headers, config) {
				if(data.status === 'success') {
					if ($scope.response.id == 'enr1403'){
						$scope.open_contest_modal();
					}else{
						if ($scope.response.video_controls.next_id){
							$location.path('/NEXT/'+$scope.response.video_controls.next_id);
						}else if ($scope.response.video_controls.done_id){
							$location.path('/DONE/'+$scope.response.video_controls.done_id);
						}
					}
				} else {
					MR.utils.alert({type:data.status,message: data.message});
				}
			})
			.error(function(data, status, headers, config) {
				MR.utils.alert({type:data.status,message: data.message});
			});
	};

	$scope.submit_multiple_choice = function(skip) {

		if(skip) {
			$scope.testData = ' ';
		}

		var postdata = {
			test_key : $scope.test.key,
			answer : $scope.testData[0]
		};

		$http.post('/base/ajax_angular_submit_multiple_choice', postdata)
			.success(function(data, status, headers, config) {
				if(data.status === 'success') {
					if ($scope.response.video_controls.next_id){
						$location.path('/NEXT/'+$scope.response.video_controls.next_id);
					}else if ($scope.response.video_controls.done_id){
						$location.path('/DONE/'+$scope.response.video_controls.done_id);
					}
				} else {
					MR.utils.alert({type:data.status,message: data.message});
				}
			})
			.error(function(data, status, headers, config) {
				MR.utils.alert({type:data.status,message: data.message});
			});
	};

	$scope.get_completed_survey_ids = function() {
		var completed_surveys_cookie = getCookie('completed_surveys');

		if(completed_surveys_cookie !== null) {
			ids_obj = JSON.parse(completed_surveys_cookie);
			return ids_obj.ids;
		}

		return [];
	};

	$scope.show_survey_modal = function() {
		if($scope.current_survey !== null) {
			MR.modal.show('#survey-modal');
		}
	};

	$scope.submit_user_survey_question_responses = function() {
		var has_form_errors = false;

		// check to make sure that all radio questions have a selection
		for(q = 0; q < $scope.current_survey.questions.length; q++) {
			if($scope.current_survey.questions[q].input_type === 'radio' && (!$scope.user_survey_question_responses.hasOwnProperty($scope.current_survey.questions[q].id))) {
				has_form_errors = true;
				break;
			}
		}

		if(!has_form_errors) {
			var post_data = {
				survey_id: $scope.current_survey.id,
				user_survey_question_responses: $scope.user_survey_question_responses
			};

			$http.post('/surveys/ajax_angular_submit_survey_responses', post_data)
				.success(function(data, status, headers, config) {
					MR.modal.hide('#survey-modal');
					MR.utils.alert({type:'success',message:'Thank you for taking the time to answer our survey questions.'});
					$scope.current_survey = null;
					$scope.user_survey_question_responses = {};
					$scope.update_completed_surveys_cookie(post_data.survey_id);
				})
				.error(function(data, status, headers, config) {
					MR.utils.alert({type:'error',message:'Error submitting survey.'});
				});

		} else {
			MR.utils.alert({type:'error',message:'Please select an answer for each survey question.'});
		}
	};

	$scope.update_completed_surveys_cookie = function(completed_survey_id) {
		var completed_surveys_cookie = getCookie('completed_surveys');

		if(completed_surveys_cookie === null) {
			var cookie_value = JSON.stringify({
				ids: [completed_survey_id]
			});

			putCookie('completed_surveys', cookie_value, 9999);
		} else {
			var ids_obj = JSON.parse(completed_surveys_cookie);

			if(ids_obj.ids.indexOf(completed_survey_id) === -1) {
				ids_obj.ids.push(completed_survey_id);
				var cookie_value = JSON.stringify(ids_obj);
				putCookie('completed_surveys', cookie_value, 9999);
			}
		}
	};

	$scope.submit_test = function(){
		$scope.test.first_blank_answer = '';
		/* This is for those pesky AUDITS */
		var $testTable = $('#test-modal').find(".mr-test-questions table");
		if ($testTable.exists()){
			var check = true;
			$testTable.find("input").each(function(){
				if ($(this).val() == ''){
					check = false;
				}
			});
			if (!check){
				MR.utils.alert({type:'warning',message: "Please use the fields to the right of the AUDIT to tally up a total."});
				return false;
			}
		}
		$http.post('/base/ajax_submit_test',{ test: $scope.test, "data": $scope.testData, iteration: $scope.test.stats.iteration}).
		success(function(data, status, headers, config) {
			$scope.test.first_blank_answer = data.first_blank_answer;
			if (data.status == "success" || data.status == "info" || data.status == "warning"){
				$scope.test.message = data.tmessage;
				$scope.test.status = data.status;
				var iteration = $scope.test.stats.iteration;
				$scope.test.stats = data.stats;
				$scope.test.stats.iteration = iteration+1;
				$scope.testData = [];
				MR.modal.hide('#test-modal');
				MR.modal.show('#test-status-modal',true);
			}else{
				MR.utils.alert({type:data.status,message: data.message});
				if (!$testTable.exists()){
					MR.utils.scrollTo('#mr-test-q-'+data.first_blank_answer,'#test-modal');
				}
			}
		}).error(function(data, status, headers, config)
		{
			MR.utils.alert({type:data.status,message: data.message});
		});

	};

	$scope.check_r = function(r){
		$.each(r,function(key,value){
			if (r.status == "passed"){

			}else{
				return false;
			}
		});
	};

	$scope.get_profile = function(user_id) {
		var postvars = {};
		$http.post('/admin/ajax_angular_default_course', postvars).success(function(data, status, headers, config) {
			$scope.active_course = data.active_course;
			$scope.course_stats = data.course_stats;
			$scope.course_activity = data.course_activity;
			$scope.all_courses = data.all_courses;
			$scope.all_user_courses_and_iterations = data.all_user_courses_and_iterations;
			MR.modal.show('#profile-modal');
		}).error(function(data, status, headers, config) {
			alert('default_course error');
		});
	};

	$scope.show_all_resources = function(args) {
		var args = args || {};
		if (args.title){

		}else{
			args.title = 'Resources';
		}
		$scope.resources = [];
		$http.post('/base/ajax_angular_load_all_resources').
		success(function(data, status, headers, config)
		{
			if (!args.noModal) {
				MR.modal.show('#resources-modal');
				$scope.resources = data.resources;
				$scope.resources.title = args.title;
			}else{
				$("#mr-resources-dropdown").tooltip({ selector: '[data-toggle=tooltip]' });
				$scope.resources = [];
				$.each(data.resources,function(key,value){
					$.each(value.resources,function(rkey,rvalue){
						if ((value['rail'] == $scope.response.left_rail.id) &&
								(rvalue['rids'].indexOf($scope.response.id+",") > -1) ||
								(rvalue['modules'].indexOf(','+$scope.response.left_rail.module_selected+",") > -1)
							 ){
							$scope.resources.push({rail: value['rail'], name: rvalue['name'], details: rvalue['details'], link: rvalue['link']});
						}
					});
				});
			}
		}).
		error(function(data, status, headers, config)
		{
			MR.utils.alert({type:'error',message:'Error loading resources list'});
		});
	};
}



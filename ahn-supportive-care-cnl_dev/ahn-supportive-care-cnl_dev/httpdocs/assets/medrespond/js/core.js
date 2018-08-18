var MR = MR || {};
(function($){
	var Scroll = function(){
		var items = [];
		var args = { mouseWheel: true,
								 interactiveScrollbars: true,
								 scrollbars: 'custom',
								 scrollX: false,
								 scrollY: true,
								 click: false
							 };
		var i = 0;
		/* Add scrolling to anything scrollable */
		$('.mr-is-wrapper').each(function(){
			var $wrap = $(this);
			var _id = $wrap.attr("id");
			$wrap.attr("data-bound-scroller",i);
			items[i] = new IScroll(document.getElementById(_id),args);
			i++;
			/* If bootstrap expand event, expand the scroller */
			$wrap.on('hidden.bs.collapse shown.bs.collapse', function (e) {
				MR.scroll.items[$(this).attr("data-bound-scroller")].refresh();
			});
		});
		this.items = items;
		this.scrollTop = function(_id){
			for (i = 0; i < MR.scroll.items.length; i++){
				if ($(_id).exists){
					if ('#'+$(MR.scroll.items[i].wrapper).attr("id") == _id){
						MR.scroll.items[i].scrollTo(0,0);
					}
				}
			}
		}
		this.refreshAll = function(){
			for (i = 0; i < MR.scroll.items.length; i++){
				MR.scroll.items[i].refresh();
			}
		};
	};
	var Core = function(){
		this.base_url = $("html").attr("data-mr-base-url");
		this.project = $("html").attr("data-mr-project");
		this.project_type = $("html").attr("data-mr-type");
		this.url = $("html").attr("data-mr-url");
		this.max_idle = $('html').attr("data-mr-idle-time");
		this.idle_time = 0;
		$(document).ready(function(){
			MR.scope = angular.element("#base_controller").scope();
			MR.utils.browserCheck();
			MR.utils.fixConsole();
			MR.utils.toolTips();
			MR.utils.timerEvents();
			MR.utils.placeHolder();
			if ($("#base_controller").exists()){
				MR.utils.cssFixes();
				MR.utils.bindHashLinks();
				MR.utils.progressPanel();
			}
		});
		$(window).resize(function(){
			MR.utils.cssFixes();
		});

	};
	var Browser = function(){
		this.name =	 $("html").attr("data-ua-name");
		this.version = $("html").attr("data-ua-version");
		this.trident = $("html").attr("data-ua-trident");
		this.mobile = $("html").attr("data-ua-mobile");
	}
	var Modal = function(){
		this.show = function(id,noclose){
			/* Pause Current Video */
			if (MR.video.player){
				if (!MR.video.player.paused()){
					MR.video.player.pause();
				}
			}
			/* Special Bug Report Stuff */
			if (id == "#bug-modal"){
				$.Ping('https://'+MR.scope.response['web_domain']).done(function (success, url, time, on) {
					$("#bugPingData").val(arguments[2]);
				}).fail(function (failure, url, time, on) {
					$("#bugPingData").val('');
				});
			}
			$(id).modal('show');
			setTimeout(function(){
				MR.utils.placeHolder();
				$(id).find('input,textarea,select').filter(':visible:first').focus();
			}, 500);
			$(id).on('shown.bs.modal', function (e) {
				$('body').addClass('modal-open');
			});
		}
		this.hide = function(id){
			$(id).modal('hide');
		}
	}
	var Utils = function(){
		/* IE Placeholders */
		this.placeHolder = function(){
			if(jQuery().placeholder){
				$('input, textarea').placeholder();
				$('textarea').each(function(){
					var me = $(this);
					// clear stubborn textareas
					me.click(function(){
						if ($(this).val() == $(this).attr('placeholder')){
							$(this).val('');
						}
					});
				});
			}
		}
		/* For location change */
		this.link = function(url){
			if (url == '/'){
				url = '';
			}
			window.location = '/'+MR.core.base_url+url;
		}
		this.share = function(){
			MR.scope = angular.element("#base_controller").scope();
			var facebook_app_id = $('html').attr('data-facebook-app-id').trim();
			var response_id = MR.scope.response.id;
			var canonical_response_url = window.location.protocol + '//' + window.location.hostname + '/' + MR.core.base_url + 'rid/' + response_id;
			var facebook_sharer_url = 'https://www.facebook.com/sharer/sharer.php?app_id='+facebook_app_id+'&sdk=joey&u=' + encodeURIComponent(canonical_response_url);

			window.open(facebook_sharer_url, 'newwindow', 'width=300, height=250, top=100, left=300');

			return false;
		}
		this.scrollTo = function(elz,container){
			if (!container){
				container = 'html,body';
			}
			if ($(elz).exists()){
				$(container).animate({scrollTop: $(elz).get(0).offsetTop }, "slow");
			}
		}
		this.timerEvents = function(){
			/* Tick once every minute */
			$(document).mousemove(function (e) {
				MR.core.idle_time = 0;
			});
			$(document).keypress(function (e) {
				MR.core.idle_time = 0;
			});
			if (!$('body').hasClass('login')){
				var timeoutID = window.setInterval(function(){
					/* Enforce inactivity */
					if (MR.core.max_idle !== "false"){
						MR.core.idle_time++;
						console.log('Idle for: '+MR.core.idle_time+' minute(s)');
						if (MR.core.idle_time >= MR.core.max_idle) {
							MR.login.do_logout('inactive');
						}
					}
					/* Logging minutes online */
					if (document.hasFocus()){
						$.post('/'+MR.core.base_url+'base/ajax_angular_update_user_attr', {command: 'minutes_online', value: 1},function(data){
							if (data.status == 'success'){
								if (data.hard_redirect) {
									return (window.location = data.hard_redirect);
								}
							}
						});
					}
				}, 60000);
			}
		}
		this.clearIndexes = function(){
			$('#mr-output-screen').find(".injected").each(function(){
				$(this).remove();
			});
		}
		this.scanIndexes = function(args){
			var post_vars = {};
			post_vars.case_name = $('#mr-case-name').val();
			var lines = $('#mr-index-csv').val().split('\n');
			if (post_vars.case_name == '' || post_vars.case_name.length < 5){
				return MR.utils.alert({type:'failure',message:'Please enter a case_name'});
			}
			if ($('#mr-index-csv').val() == ''){
				return MR.utils.alert({type:'failure',message:'Please enter a data test set'});
			}
			if (lines.length > 0){
				post_vars.original_response = lines[0].substr(0,lines[0].indexOf(' ')); // beginning
				post_vars.input_question = lines[0].substr(lines[0].indexOf(' ')+1); // end
				$.post('/'+MR.core.base_url+'base/ajax_test_indexes', post_vars, function(data){
					if (data.status == 'success'){
						var newText = $('#mr-index-csv').val().replace(/^.*\n/g,"");
						var status = '<span class="label label-success"><i class="glyphicon glyphicon-ok"></i></span>';
						if (data.ResponseIDs.string != data.original_response){
							var status = '<span class="label label-danger"><i class="glyphicon glyphicon-remove"></i></span>';
						}
		    		$('#mr-index-csv').val(newText);
						$('#mr-output-screen').append('<tr class="injected"><td>'+status+'</td><td>'+data.original_response+'</td><td>'+data.InputQuestion+'</td><td>'+data.ResponseIDs.string+'</td></tr>');
						MR.modal.show('#about-output-modal');
						if (lines.length > 1){
							MR.utils.scanIndexes();
						}else{
							$('#mr-index-csv').val('');
						}
					}else{
						return MR.utils.alert({type:'failure',message:data.message});
					}
				}, 'json');
			}


		}
		/* This currently is used for activity logs and CT logs.
			 Takes in a single Browser or OS string or an array with the browsers
			 and operating systems.  Returns HTML so that we get a pretty icon.
		*/
		this.parseBrowserIcons = function(value){
			/* Pretty browser icon parser */
			if (value.constructor !== Array){
				value = [value];
			}
			var tempPlatform = value;
			$(tempPlatform).each(function(i,v){
				b = "unknown";
				if (v.toLowerCase().indexOf("mac") > -1 || v.toLowerCase().indexOf("ios") > -1){
					b = "mac";
				}else if (v.toLowerCase().indexOf("chrome") > -1){
					b = "chrome";
				}else if (v.toLowerCase().indexOf("explorer") > -1){
					b = "ie";
				}else if (v.toLowerCase().indexOf("mozilla") > -1 || v.toLowerCase().indexOf("firefox") > -1){
					b = "mozilla";
				}else if (v.toLowerCase().indexOf("windows") > -1){
					b = "windows";
				}else if (v.toLowerCase().indexOf("linux") > -1){
					b = "linux";
				}else if (v.toLowerCase().indexOf("safari") > -1){
					b = "safari";
				}
				tempPlatform[i] = '<span title="'+v+'" class="mr-platform-icon '+b+'">'+v+'</span>';
			});
			return tempPlatform.join(" ");
		}
		this.getHash = function(path) {
			var idx = path.indexOf('#');
			if (idx <= -1){
				return null;
			}else{
				return path.substr(idx + 1);
			}
		}
		/* A rude way to add some more behaviors to links */
		this.bindHashLinks = function(){
			$("body").on("click",function(e){
				if (($(e.target).is('img') || $(e.target).hasClass('ng-binding') || $(e.target).hasClass('mr-rq-status-icon')) && !$(e.target).is('a')){
					var tar = $(e.target).parent("a");
				}else{
					var tar = $(e.target);
				}
				/* ENR introduced unclickable left-rail entities.
				*/
				if (tar.hasClass("no-click")){
					return false;
				}
				/* Make sure link is not locked
					(This is also done Controller-Level for SBIRT.  This is to ensure this behavior.)
				*/
				if (tar.hasClass("locked")){
					var lock_message = '';
					/* Javascript level LOCK */
					if (MR.core.project == 'mrd'){
						lock_message = 'You are viewing the <strong>AlcoholSBIRT Demo Course</strong>. For this demonstration, access has been limited to certain exercises in Module 6.';
					}else if (MR.core.project == 'enr'){
						lock_message = 'This module is currently locked.';
					}else{
						lock_message = 'This module has not been unlocked yet. (Modules must be completed in sequence.)';
					}
					MR.utils.alert({type:'warning',message: lock_message });
					return false;
				}
				if (tar.is('a')){
					/* Pause video for links that open in a new window. */
					if (tar.attr("target")){
						var tarTar = tar.attr("target");
						if (tarTar.indexOf("_blank") > -1){
							/* Pause Current Video */
							if (MR.video.player){
								MR.video.player.pause();
							}
						}
					}
					/* A rude way to get all hash links to trigger locationChangeStart */
					if (tar.attr("href")){
						var tarHref = tar.attr("href");
						if (tarHref.indexOf("#") > -1){
							/* Compare Link to where the user is */
							if (MR.utils.getHash(window.location.hash) == MR.utils.getHash(tarHref)){
								MR.scope.route_page(e, tarHref, tarHref);
							}
						}
					}
				}
			});
		}
		/* checks for ie8 and below */
		this.browserCheck = function(){
			if (MR.browser.name == 'internet-explorer' && MR.browser.version <= 7 && MR.browser.trident == 'false') {
				$.get('/assets/medrespond/html/browser_upgrade.html', function( data ) {
					$('body').html( data );
				});
			}
		};
		/* **********************************************************
		 * Angular Global Hooks (Global AJAX Error checking)
		 * This scans all listed angular controllers and hooks
		 * an HTTP interceptor so that all ajax request failures
		 * display gracefully.
		 ********************************************************* */
		this.bindAngular = function(){
			/* We want a list of appnames we can hook
					Because we don't want to attach global stuff multiple times.
			*/
			var appNames = [
				'userApp',
				'trainingDashboardApp',
				'trainingCertificationApp',
				'trainingDisclaimerApp',
				'trainingReportsApp',
				'trainingStatisticsApp',
				'trainingRegistrationApp',
				'registrationApp'
			];

			$(appNames).each(function(key,value){
				try {
					if (angular.module(value)){
						var appName = window[value];
						appName.config(function($locationProvider){
							$locationProvider.html5Mode(false);
						});
						appName.config(['$httpProvider', function($httpProvider) {
							// Turn caching of GET requests off
							if (!$httpProvider.defaults.headers.get) {
								$httpProvider.defaults.headers.get = {};
							}

							$httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
							$httpProvider.defaults.headers.get['If-Modified-Since'] = '0';
							$httpProvider.responseInterceptors.push('myHttpInterceptor');
							$httpProvider.interceptors.push('httpRequestInterceptor');
						}]);
						/* Progress bars for all */
						appName.directive('myProgress', function() {
							return function(scope, element, attrs) {
							scope.$watch(attrs.myProgress, function(val) {
									 element.html('<div title="'+val+'%" class="progress-bar '+attrs.barColor+' progress-bar-striped" style="width: ' + val + '%">'+val+'%</div>');
							});
						 }
						});
						/* Nested IF */
						appName.filter('iif', function () {
							return function(input, trueValue, falseValue) {
								return input ? trueValue : falseValue;
							};
						});
						/*
						 * Object sorting for ng-repeat.
						 * @param attribute:string
						 * @param asc:boolean
						 */
						appName.filter('orderObjectBy', function(){
							return function(input, attribute, direction) {
								if (!angular.isObject(input)) return input;
								var array = [];
								for(var objectKey in input) {
									array.push(input[objectKey]);
								}
								array.sort(function(a, b){
									a = parseInt(a[attribute]);
									b = parseInt(b[attribute]);
									return direction == true ? a - b : b - a;
								});
								return array;
							}
						});
						appName.filter('trustAsResourceUrl', ['$sce', function($sce) {
							return function(val) {
								return $sce.trustAsResourceUrl(val);
							};
						}]);
						appName.directive('numericOnly', function(){
							 return {
									restrict: 'A',
									link: function (scope, element, attrs) {
									$(element).on('keyup', function (event) {
										var self = $(this)
											, form = self.parents('form:eq(0)')
											, focusable
											, next
											;
										if ($(element).val() > 4 || isNaN($(element).val())){
											$(element).val('');
										}else{
											focusable = form.find('input,a,select,button,textarea').filter(':visible');
											next = focusable.eq(focusable.index(this)+1);
											if (next.length) {
												next.focus();
											}
										}
									});
									$(element).on('keydown', function (event) {
									var key = event.which || event.keyCode;
										var self = $(this)
											, form = self.parents('form:eq(0)')
											, focusable
											, next
											;
										if (key == 13) {
											focusable = form.find('input,a,select,button,textarea').filter(':visible');
											next = focusable.eq(focusable.index(this)+1);
											if (next.length) {
												next.focus();
											}
											return false;
										}
									});
								}
							 };
						});
						appName.directive('bindUnsafeHtml', ['$compile', function ($compile) {
									return function(scope, element, attrs) {
											scope.$watch(
												function(scope) {
													// watch the 'bindUnsafeHtml' expression for changes
													return scope.$eval(attrs.bindUnsafeHtml);
												},
												function(value) {
													// when the 'bindUnsafeHtml' expression changes
													// assign it into the current DOM
													element.html(value);

													// compile the new DOM and link it to the current
													// scope.
													// NOTE: we only compile .childNodes so that
													// we don't get into infinite loop compiling ourselves
													$compile(element.contents())(scope);
												}
										);
								};
						}]);
						appName.filter('unsafe', function($sce){
							return function(val)
							{
								return $sce.trustAsHtml(val);
							};
						});
						appName.directive("modalShow", function () {
							return {
								restrict: "A",
								scope: {
									modalVisible: "="
								},
								link: function (scope, element, attrs) {
									//Hide or show the modal
									scope.showModal = function (visible) {
										if (visible) {
											element.modal("show");
										} else {
											element.modal("hide");
										}
									}
									//Check to see if the modal-visible attribute exists
									if (!attrs.modalVisible) {
										//The attribute isn't defined, show the modal by default
										scope.showModal(true);
									} else {
										//Watch for changes to the modal-visible attribute
										scope.$watch("modalVisible", function (newValue, oldValue) {
											scope.showModal(newValue);
										});
										//Update the visible value when the dialog is closed through UI actions (Ok, cancel, etc.)
										element.bind("hide.bs.modal", function () {
											scope.modalVisible = false;
											if (!scope.$$phase && !scope.$root.$$phase)
												scope.$apply();
										});
									}
								}
							};
						});
						/* AJAX Pre-Hooks */
						appName.factory('httpRequestInterceptor', function () {
							return {
							request: function (config) {
								/* We don't want to hook datepicker (angular plugins) so ignore
								 * if our string contains .html. We also don't need to add our MR_DIRECTORY
								 * to absolute links (http)
								 */
								if (config.url.indexOf("http") > -1 || config.url.indexOf(".html") > -1){

								}else{
									if (MR.core.base_url){
										config.url = '/'+MR.core.base_url.slice(0,-1)+config.url;
									}
								}
							return config;
								}
							};
						});
						appName.factory('myHttpInterceptor', function ($q, $window, $rootScope) {
							return function (promise) {
								$rootScope.polling = true;
								return promise.then(function (response) {
									if (response.data.status == "success"){
										$rootScope.polling = false;
									}else{
										if (response.data.message){
											MR.utils.alert({type:response.data.status,message: response.data.message});
										}
									}
									if (response.data.hard_redirect){

										if (response.data.hard_redirect_timeout){
											window.setTimeout(function() {
												window.location = response.data.hard_redirect;
											}, response.data.hard_redirect_timeout);
										} else {
											window.location = response.data.hard_redirect;
										}
									}
									return response;
								}, function (response) {
									$rootScope.polling = false;
									$rootScope.network_error = true;
									MR.utils.alert({type:'error',message: response.data.message});
									return $q.reject(response);
								});
							};
						});
						return;
					}
				} catch(err) { /* failed to require */

				}
			});
		}
		this.cssFixes = function(){
			MR.video.fixSize();
			if (MR.core.project == 'tss'){
				return false;
			}
			var winHeight = $(window).height();
			/* Calculate height of objects in left rail outside of wrapper */
			var leftOutsideHeight = 0;
			$("#mr-col-left").find(' > .mr-widget').each(function(){
				leftOutsideHeight += $(this).outerHeight(true);
			});

			var footHeight = 0;
			if (!$("#mr-footer").hasClass("mr-panel-footer")){
				footHeight = $("#mr-footer").outerHeight(true);
			}

			var conHeight = winHeight - $("#mr-header").outerHeight(true) - footHeight;
			var txtDivHeight = conHeight - $('#mr-video').outerHeight(true) - $('#mr-input-row').outerHeight(true) - parseInt($('#mr-video').css('padding-top')) - parseInt($('#mr-col-middle').css('padding-top')) - parseInt($('#mr-col-middle').css('padding-bottom')) - parseInt($('#mr-col-middle').css('margin-top')) - parseInt($('#mr-col-middle').css('margin-bottom'));
			$("#mr-col-middle").find(' > .mr-widget').each(function(){
				txtDivHeight -= $(this).outerHeight(true);
			});
			if ($('body').hasClass('login')){
				if (!MR.browser.mobile){
					/* Login Shiz */
					if ($('#mr-login-form').exists()){
						$("#mr-content").height(conHeight - parseInt($('#mr-content').css('padding-top')));
					}
				}
			} else if ($('body').hasClass('register') || $('body').hasClass('courses')){

			} else if($('body').hasClass('payments')){
				$("#mr-content").height(conHeight - 35 - parseInt($('#mr-content').css('padding-top')));
			} else {
				/* Inside Shiz */
				if (txtDivHeight < 1){
					conHeight = conHeight + footHeight;
				}
				$("#mr-col-left .mr-is-wrapper").each(function(){
					$(this).height(conHeight-leftOutsideHeight);
				});
				$("#mr-col-right .mr-is-wrapper").each(function(){
					$(this).height(conHeight);
				});
				if ($("#video-text-div").exists()){
					$("#video-text-div").height(txtDivHeight);
				}
				if ($("#comments-box").exists()){
					$("#comments-box").height(txtDivHeight);
				}
				if ($("#enr-test-box").exists()){
					$("#enr-test-box").height(txtDivHeight);
				}
				if($('body').hasClass('rid')){
					//$("#mr-video-mask").height($("#mr-col-middle").height());
				}else{
					MR.utils.sidePanels();
				}
			}
			if (MR.scroll) {
				MR.scroll.refreshAll();
			}
			MR.video.fixSize();
		};
		this.progressPanel = function(){
			$("#mr-progress").each(function(){
				var $this = $(this);
				var toggler = $this.find(".mr-panel-toggle");
				toggler.click(function(){
					$this.toggleClass("open");
				});
			});
			$("#mr-progress-toggle").click(function(e){
				e.preventDefault();
				$(this).parent("li").toggleClass("open");
				$("#mr-progress .mr-panel-toggle").click();
			});
		}
		this.panelOpen = function(t){
			MR.utils.cssFixes();
			var parent;
			if (t){
				parent = $(t).parent();
				parent.toggleClass("open");
				if (parent.hasClass("mr-panel-left")){
					$("#mr-col-right").removeClass("open");
				}else if (parent.hasClass("mr-panel-right")){
					$("#mr-col-left").removeClass("open");
				}
			}else{
				$(".mr-panel-left, .mr-panel-right").removeClass("open");
			}
		};
		this.sidePanels = function(){
			var winWidth = $(window).width();
			if (winWidth < 900){
				if (!$("#mr-col-left").hasClass("mr-panel-left") &&
						!$("#mr-col-right").hasClass("mr-panel-left") &&
						!$("#mr-footer").hasClass('mr-panel-footer')){

					$("#mr-col-left").addClass("mr-panel-left").prepend('<div class="mr-panel-toggle"><i class="mr-panel-toggle-icon icon glyphicon"></i></div>');
					$("#mr-col-middle").addClass("mr-panel-middle");
					$("#mr-col-right").addClass("mr-panel-right").prepend('<div class="mr-panel-toggle"><i class="mr-panel-toggle-icon icon glyphicon"></i></div>');
					//$("#mr-footer").addClass("mr-panel-footer").prepend('<div class="mr-panel-toggle"><i class="mr-panel-toggle-icon icon glyphicon"></i></div>');
					$(".mr-panel-toggle").each(function(){
						$(this).on("click touchstart",function(e){
							if ($(e.target).hasClass("mr-panel-toggle") || $(e.target).hasClass("mr-panel-toggle-icon")){
								/* Kill all remaining popovers. */
								$('.popover').each(function(){
									$(this).popover('destroy');
								});
								e.stopPropagation();
								e.preventDefault();
								MR.utils.panelOpen(this);
							}
						});
					});
				}
			}else{
				//$("#mr-footer").removeClass("mr-panel-footer");
				//$("#mr-footer").find(".mr-panel-toggle").remove();
				$("#mr-col-left").removeClass("mr-panel-left");
				$("#mr-col-left").find(".mr-panel-toggle").remove();
				$("#mr-col-middle").removeClass("mr-panel-middle");
				$("#mr-col-right").removeClass("mr-panel-right");
				$("#mr-col-right").find(".mr-panel-toggle").remove();
			}
		};
		this.popover = function(args,callback){
			var callback = callback || function(){};
			var template = '';
			var title = '';
			args.type = args.type || "info";
			if (args.type == 'success'){
				type = 'success';
				icon = "glyphicon-ok-sign";
			}else if (args.type == 'error' || args.type == 'failure'){
				type = 'danger';
				icon = 'glyphicon-exclamation-sign';
			}else if (args.type == 'info'){
				type = 'info';
				icon = 'glyphicon-info-sign';
			}else if (args.type == 'warning' || args.type == 'alert'){
				type = 'warning';
				icon = 'glyphicon-info-sign';
			}
			if (args.title){
				title = '<i class="glyphicon '+icon+'"></i> '+args.title;
				template = '<div style="z-index:1040" class="'+args.cl+' popover popover-'+type+'" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>';
			}else{
				title = false;
				template = '<div style="z-index:1040" class="'+args.cl+' popover popover-'+type+'" role="tooltip"><div class="arrow"></div><div class="popover-content"></div></div>';
			}
			if (!$(args.element).attr('aria-describedby')){
				$(args.element).popover({
									 animation:true,
									 html: 'true',
									 /* Sticky class is good for making me not vanish */
									 template: '<div style="z-index:1040" class="'+args.cl+' popover popover-'+type+'" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
									 title: title,
									 content: args.content,
									 placement: args.placement || 'top',
									 trigger: args.trigger || "manual",
									 delay: args.delay || 100,
									 container:'body'
								 }).popover('show');
			}


		}
		this.alert = function(args,callback){
			var callback = callback || function(){};
			var args = args || {type:'success', message:'message'};
			//Update bug report
			$("#bugLastMessage").val(args.message);
			//because all of our errors usually end up here, debug here.
			if (args.debug){
				console.debug('Mr.D: '+args.debug);
			}
			var title = '';
			if (!$("#mr-alerts").exists()) {
				$("body").prepend('<div id="mr-alerts"></div>');
			}
			if (args.type == 'success'){
				type = 'success';
				title = "Success";
			} else if (args.type == 'error' || args.type == 'failure'){
				type = 'danger';
				title = 'Error';
			} else if (args.type == 'info'){
				type = 'info';
				title = 'Info';
			} else if (args.type == 'warning' || args.type == 'alert'){
				type = 'warning';
				title = 'Alert';
			}
			if (title == '') {
				title = "Info";
			}
			if (!args.delay) {
				args.delay = 5000;
			}
			if (!args.removeOnClick) {
				args.removeOnClick = true;
			}
			var alert = document.createElement('div');
			$(alert).addClass('alert')
					.addClass('alert-'+type)
					.html('<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>'+title+': </strong>'+args.message)
					.click(function(){
						if(args.removeOnClick) {
							$(this).stop(true,true).fadeOut(300,function(){
								$(this).remove();
								callback();
							});
						}
					})
					.css({marginTop:'-100px'})
					.animate({marginTop:'20px'},300)
					.delay(args.delay)
					.fadeOut(300)
					.queue(function() {
						$(this).fadeOut(300,function(){
							$(this).remove();
							callback();
						});
					});
				$("#mr-alerts").html($(alert));
		};
		this.toolTips = function(){
			$("[data-toggle='tooltip']").each(function(){
				$(this).tooltip({
					'placement': $(this).data('placement'),
					'container':'body'
				});
				$(this).hover(function(){
					$(this).tooltip({
						'placement': $(this).data('placement'),
						'container':'body'
					});
				});
			});
			$("[data-toggle='popover']").popover({
				'container':'body'
			});
			//All popovers are dismissable
			$('html').on('mouseup', function(e) {
				if ($(e.target).parent('.sticky').exists()){
					$(e.target).parent('.sticky').popover('destroy');
				}
				$('.popover').each(function(){
					if (!$(this).hasClass('sticky')){
						$(this).popover('destroy');
					}
				});
			});
		};
		this.fixConsole = function(){
			var method;
			var noop = function () {};
			var methods = [
				'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
				'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
				'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
				'timeStamp', 'trace', 'warn'
			];
			var length = methods.length;
			var console = (window.console = window.console || {});

			while (length--)
			{
				method = methods[length];

				// Only stub undefined methods.
				if (!console[method])
				{
					console[method] = noop;
				}
			}
		}
	};//Utils
	var Video = function(){
		this.bound = false;
		this.flash = false; /* UI needs a delay for flash related stuff */
		this.init = function(playlist,posterImage){
			if (!this.bound){
				this.bound=true;
				videojs.options.flash.swf = MR.core.url+"assets/video-js/video-js.swf";

				/* Default */
				var techOrder = ['html5','flash'];
				if (MR.browser.name == 'internet-explorer' && MR.browser.version <= 10){
					this.flash = true;
					techOrder = ['flash','html5'];
				}

				/* User Settings (in master_users_map table) */
				if ($("#mr-player").attr("data-player-type") == 'flash'){
					techOrder = ['flash','html5'];
				}else if ($("#mr-player").attr("data-player-type") == 'html5'){
					techOrder = ['html5','flash'];
				}

				var args = {
					techOrder: techOrder,
					controls: true,
					autoplay: true,
					width: '100%',
					height: '100%',
				};

				/* We want the SEO crap to lead to the ajax base controller rid */
				if ($('body').hasClass('rid')){
					args.autoplay = false;
				}

				if (posterImage){
					args.poster = posterImage;
				}

				videojs("vjs-player", args, function(){
					MR.video.player = this;
					MR.video.videoFader(posterImage);
					MR.video.bindStuff();
					MR.video.fixSize();
				}).src(playlist);
			}
		}
		this.setPoster = function(posterImage){
			MR.video.player.poster(posterImage);
		};
		this.fixSize = function(){
			/* HTML VIDEO UGLY RESIZING (BLACK BOX FIX) */

			var ratio = 0.57504008236102;
			if (MR.core.project == "rush" || MR.core.project == "sbirt"){
				/* Sbirt has wierd sized videos, but we must
					 be in base for MR.scope to exist */
				if ($('body').hasClass('base')){
					if (MR.scope.current_left_rail == "mentor"){
						ratio = 0.5625;
					}
				}
			}
			var video = $('#mr-player').find('video');
			if (video.exists()){
				video.css("height","auto");
			}
			var flash = $("#mr-player").find("object");
			if (flash.exists()){
				$(".video-js").height(Math.floor(flash.width()*ratio));
			}else{
				$(".video-js").height(Math.floor(video.width()*ratio));
			}

		};
		this.checkVolume = function(vButton, vLevel){
			if (!vLevel){
				vButton.html('<i class="icon glyphicon glyphicon-volume-off"></i><br/>Volume');
			}else if (vLevel == 0.5){
				vButton.html('<i class="icon glyphicon glyphicon-volume-down"></i><br/>Volume');
			}else if (vLevel == 0){
				vButton.html('<i class="icon glyphicon glyphicon-volume-off"></i><br/>Volume');
			}else{
				vButton.html('<i class="icon glyphicon glyphicon-volume-up"></i><br/>Volume');
			}
		};
		this.bindStuff = function(){
			var p = MR.video.player;
			if (!$("#mr-video-controls").exists()){
				return;
			}
			/* MR Controls */
			var timeline = $("#mr-video-controls").find(".mr-vc-t");
			var play = $("#mr-video-controls").find(".mr-button-play");
			var vol = $("#mr-video-controls").find(".mr-button-volume");
			var quality = $("#mr-video-controls").find(".mr-button-quality");
			var show_asl_video = $("#mr-video-controls").find(".mr-button-asl");

			/* Video.js controls */
			var ctrlprogress = $(".vjs-progress-control"),
					ctrldivider = $('.vjs-time-divider').addClass('mr-seek-text'),
					ctrlcurrent = $(".vjs-current-time-display").addClass('mr-seek-text'),
					ctrlduration = $('.vjs-duration').addClass('mr-seek-text');

			var seek = document.createElement('div');
			$(seek).attr('id','mr-seek-text');
			$(seek).append(ctrlcurrent).append(ctrldivider).append(ctrlduration);
			timeline.append(ctrlprogress);
			timeline.append($(seek));

			/* Video gets hidden on IPAD in _mobile.less. Need a click function */
			if (MR.browser.mobile){
				$('#mr-video').on("click touchstart",function(){
					if (!p.paused()){
						p.pause();
					}else if (p.paused()){
						p.play();
					}
				});
			}

			p.on("ended", function (e) {
				MR.scope.$broadcast("videoFinished", {response: MR.scope.response});
			}).on("loadedmetadata", function (e) {
				$("#mr-video").attr("class","playing");
				MR.scope.$broadcast("videoReady");
				MR.utils.placeHolder();
				//$("#mr-video").find("video").attr("webkit-playsinline","webkit-playsinline");
			}).on("firstload", function (e) {
				MR.utils.cssFixes();
			}).on("error", function (e) {
				console.log(e);
			}).on("pause", function (e) {
				$("#mr-video").attr("class","paused");
				play.html('<i class="icon glyphicon glyphicon-play"></i><br/>Play');
			}).on("play", function (e) {
				$("#mr-video").attr("class","playing");
				play.html('<i class="icon glyphicon glyphicon-pause"></i><br/>Pause');
			}).on("volumechange", function (e) {
				MR.video.checkVolume(vol, p.volume());
			});
			MR.video.checkVolume(vol, p.volume());
		};
		this.control = function(evt){
			if (MR.video.player){
				var quality = $("#mr-video-controls").find(".mr-button-quality");
				var show_asl_video = $("#mr-video-controls").find(".mr-button-asl");
				var p = MR.video.player;
				var ct = p.currentTime();
				if ($(evt).hasClass("mr-button-play")) {
					if (!p.paused()){
						p.pause();
					}else if (p.paused()){
						p.play();
					}
				} else if ($(evt).hasClass("mr-button-volume")) {
					var vLevel = p.volume();
					if (!vLevel){
						p.volume(0.5);
					}else if (vLevel == 0){
						p.volume(0.5);
					}else if (vLevel == 0.5){
						p.volume(1);
					}else{
						p.volume(0);
					}
				} else if ($(evt).hasClass("mr-button-ff")) {
					p.currentTime(ct+5);
				} else if ($(evt).hasClass("mr-button-asl")) {
					MR.scope = angular.element("#base_controller").scope();
					if (MR.scope.show_asl_video){
						MR.scope.show_asl_video = false;
						show_asl_video.html('<i class="fa fa-american-sign-language-interpreting"></i><br/>No');
					}else{
						MR.scope.show_asl_video = true;
						show_asl_video.html('<i class="fa fa-american-sign-language-interpreting"></i><br/>Yes');
					}
					MR.scope.$apply();
					MR.scope.load_video();
				} else if ($(evt).hasClass("mr-button-quality")) {
					MR.scope = angular.element("#base_controller").scope();
					if (MR.scope.video_bit_rate == '512k'){
						MR.scope.video_bit_rate = '256k';
						quality.html('<i class="icon glyphicon glyphicon-cog"></i><br/>256k');
					}else{
						MR.scope.video_bit_rate = '512k';
						quality.html('<i class="icon glyphicon glyphicon-cog"></i><br/>512k');
					}
					MR.scope.$apply();
					MR.scope.load_video();
				} else if ($(evt).hasClass("mr-button-rw")) {
					if ($(".vjs-play-progress")[0].style.width === "100%"){
						p.currentTime(0);
						p.play();
					}else{
						p.currentTime(ct-5);
					}
				}
			}
		};
		this.videoFader = function(posterImage){
			if ($("#base_controller").exists()){
				MR.scope = angular.element("#base_controller").scope();
				if (!$("#mr-vid-fader").exists()){
					$("#mr-player").prepend('<div id="mr-vid-fader"></div>');
				}
				MR.scope.$on("responseLoading",function(){
					if (!posterImage){
						$("#mr-vid-fader").stop(false,false).fadeIn(300);
					}
					MR.utils.panelOpen();
				});
				MR.scope.$on("videoReady",function(){
					MR.utils.cssFixes();
					if (!posterImage){
						$("#mr-vid-fader:hidden").css({display:'block'});
						$("#mr-vid-fader").stop(false,false).fadeOut(300);
					}
				});
			}
		};
	};//Video
	/* Initialize all MR components */
	MR.scope = angular.element("#base_controller").scope();
	MR.browser = new Browser();
	MR.utils = new Utils();
	MR.modal = new Modal();
	MR.video = new Video();
	MR.core = new Core();
	MR.utils.bindAngular();

	if (!(MR.browser.name == 'internet-explorer' && MR.browser.version <= 9) && !(MR.browser.mobile)) {
		MR.scroll = new Scroll();
	}else{
		$('.mr-is-wrapper').each(function(){
			$(this).css("overflow-y","scroll");
		});
	}
})(jQuery);

/* Used ALOT to justify DOM Element Exists */
jQuery.fn.exists = function(){return this.length>0;}
/* String manipulation */
String.prototype.replaceBetween = function(start, end, what) {
	return this.substring(0, start) + what + this.substring(end);
};
String.prototype.insertBeforeLastOccurrence = function(strToFind, strToInsert) {
	var n = this.lastIndexOf(strToFind);
	if (n < 0) return this;
	return this.substring(0,n) + strToInsert + this.substring(n);
}
$.extend($, {
	Ping: function Ping(url, timeout) {
		timeout = timeout || 2500;
		var timer = null;
		return $.Deferred(function deferred(defer) {
			var img = new Image();
			img.onload = function () { success("onload"); };
			img.onerror = function () { success("onerror"); };  // onerror is also success, because this means the domain/ip is found, only the image not;
			var start = new Date();
			img.src = url += ("?cache=" + +start);
			timer = window.setTimeout(function timer() { fail(); }, timeout);
			function cleanup() {
				window.clearTimeout(timer);
				timer = img = null;
			}
			function success(on) {
				cleanup();
				defer.resolve(true, url, new Date() - start, on);
			}
			function fail() {
				cleanup();
				defer.reject(false, url, new Date() - start, "timeout");
			}
		}).promise();
	}
});
jQuery.check_repeats = function(new_id, old_id, elem){
	if (elem.exists()){
		if (new_id.indexOf("#") > -1 && old_id.indexOf("#") > -1){
			new_id = MR.utils.getHash(new_id).split("/");
			old_id = MR.utils.getHash(old_id).split("/");
			new_id = new_id[new_id.length-1];
			old_id = old_id[old_id.length-1];
		}
		if (new_id == old_id){
			if (!$("body").hasClass("sbirt")){
				var position = "top";
				if (elem.parents("#mr-col-left").length){
					position = "right";
				}else if (elem.parents("#mr-col-right").length){
					position = "left";
				}
				if (elem.exists()){

				}else{
					elem = $("#input_question");
				}
				elem.attr("title","");
				MR.utils.popover({
					element: elem,
					placement: position,
					type: 'info',
					title: "Please try a different question.",
					content:"This question is answered by the current video.",
					delay: 100
				});
			}
			return true;
		}
	}
	return false;
}


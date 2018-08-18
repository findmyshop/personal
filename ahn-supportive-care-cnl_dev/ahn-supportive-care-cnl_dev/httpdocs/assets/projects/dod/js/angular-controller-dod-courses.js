function trainingCoursesController($scope, $rootScope, $http, $injector, $q, $sce, $cookieStore, $location)
{
		$injector.invoke(trainingDashboardController, this, {$scope: $scope});

		$scope.name = 'courses';
		$scope.course_name = '';
		$scope.last_id = '';
		$scope.active_course					= [];
		$scope.barfed_course					= [];
		$scope.barfed_user					= [];
		$scope.course_stats						= [];
		$scope.course_activity					= [];
		$scope.all_courses						= [];
		$scope.tests_summary					= [];
		$scope.all_user_courses_and_iterations	= [];
		$scope.show_course_detail				= false;
		$scope.show_course_detail_text			= 'show';
		$scope.last_course_id_detail_shown		= false;
		$scope.states = '';
		$scope.countries = '';
		$scope.country_name = '';
		$scope.state_abbreviation = '';
		$scope.edit_address_country_changed = false;
		$scope.us_address_on_edit_address_form = false;

		$scope.activate_course = function(course_id) {
			var postvars = {
				course_id: course_id
			};

			$http.post('/admin/ajax_angular_activate_course', postvars)
				.success(function(data, status, headers, config) {
						if (data.last_id){
								window.location = '/#/START/'+data.last_id;
						} else {
								window.location = '/';
						}
				}).error(function(data, status, headers, config) {
				alert('default_course error');
			});
		};

		$scope.can_show_take_course_button = function(this_all_courses_index) {
			if($scope.all_courses[this_all_courses_index].is_active === '1' && $scope.all_courses[this_all_courses_index].has_completed  === '0' && $scope.all_courses[this_all_courses_index].has_passed === '0') {
				return true;
			}

			var other_all_courses_index = this_all_courses_index ^ 1;

			if(typeof $scope.all_courses[other_all_courses_index] !== 'undefined') {
				if($scope.all_courses[other_all_courses_index].is_active === '0' && $scope.all_courses[other_all_courses_index].has_completed === '1' && $scope.all_courses[other_all_courses_index].has_passed === '1') {
					if($scope.all_courses[this_all_courses_index].is_active === '0' && $scope.all_courses[this_all_courses_index].has_completed  === '1' && $scope.all_courses[this_all_courses_index].has_passed === '1') {
						return false;
					} else {
						return true;
					}
				}
			}

			return false;
		};
		$scope.edit_address_select_country_changed = function(country_id)
		{
			if ($scope.barfed_user){
				if (country_id == 230)
				{
					$scope.us_address_on_edit_address_form = true;
				}
				else
				{
					$scope.us_address_on_edit_address_form = false;
				}

				$scope.barfed_user.country_id = country_id;
				//$scope.user.province = '';
				//$scope.user.state_id = -1;

				if ($("#country_id option:selected").text() != '-- Select Country --')
				{
					$scope.country_name = $("#country_id option:selected").text();
				}
			}
		}
		$scope.edit_address = function()
		{
			var postvars = { user: $scope.barfed_user };
				$http.post('/certification/ajax_angular_update_user_address', postvars).
				success(function(data, status, headers, config) {
						if (data.status == 'success')
						{
								MR.modal.hide('#edit_address_modal');
								MR.utils.alert({type:'success',message:'Address edit successful'});
						}
						else
						{
							MR.utils.alert({type:'error',message:'Address edit failed - ' + data.message});
						}
				}).error(function(data, status, headers, config) {
					alert('certificate edit_address error');
				});
		}
		$scope.get_default_course = function(user_id)
		{
			var postvars = {};
			$http.post('/admin/ajax_angular_default_course', postvars).
			success(function(data, status, headers, config)
			{
				$scope.active_course = data.active_course;
				$scope.course_stats = data.course_stats;
				$scope.course_activity = data.course_activity;
				$scope.last_id = data.last_id;
				$scope.all_courses = data.all_courses;
				$scope.all_user_courses_and_iterations = data.all_user_courses_and_iterations;

						/* Show popover if course is ready to be completed */
						if (data.active_course){
								if ($scope.course_stats.ready_complete
									  && $scope.active_course.certificate_page_accepted > 0){
									MR.modal.show('#cert-prompt-modal');
								}
								setTimeout(function(){
									 MR.utils.popover({
										element: '#fail_course_button',
										type: 'failure',
										placement:'left',
										delay:100,
										trigger:'manual hover',
										title: 'Information:',
										content: 'You are currently failing the <em>'+$scope.active_course.course_name+'</em> course and you have used the max amount of allowed attempts. Click this if you are ready to recieve a grade for this course.'
									});
									 MR.utils.popover({
										element: '#retake_course_button',
										type: 'success',
										placement:'left',
										delay:100,
										trigger:'manual hover',
										title: 'Information:',
										content: 'You are currently failing the <em>'+$scope.active_course.course_name+'</em> course. Click this if you are ready to attempt this course again.'
									});
									 MR.utils.popover({
										element: '#close_course_button',
										type: 'success',
										placement:'left',
										delay:100,
										trigger:'manual hover',
										title: 'Information:',
										content: 'You are currently failing the <em>'+$scope.active_course.course_name+'</em> course and you have used the max amount of allowed attempts. Click this if you are ready to recieve a grade for this course.'
									});
									 MR.utils.popover({
										element: '#accept_certificate_button',
										type: 'success',
										placement:'left',
										delay:100,
										trigger:'manual hover',
										title: 'Important:',
										content: 'You are ready to accept your certificate for <em>'+$scope.active_course.course_name+'</em>. Click this to accept your certificate and complete the course.  You can then print a copy of your certificate.'
									});
								},500);
						}else{
							MR.modal.hide('#cert-prompt-modal');
						}

			})
			.error(function(data, status, headers, config)
			{
				alert('default_course error');
			});
		};
		$scope.barf_old_certificate = function(course)
		{
				var postvars = course;
				$http.post('/certification/ajax_barf_old_certificate', postvars).
				success(function(data, status, headers, config)
				{

						$scope.$parent.$parent.barfed_course = data.barfed_course;
						$scope.$parent.$parent.barfed_user = data.barfed_user;
						$scope.$parent.$parent.barfed_content_knowlege_test_stats = data.barfed_content_knowlege_test_stats;
						$scope.$parent.$parent.states = data.states;
						$scope.$parent.$parent.countries = data.countries;
						$scope.$parent.$parent.country_name = data.country_name;
						$scope.$parent.$parent.state_abbreviation = data.state_abbreviation;

						MR.modal.show('#old-certificate-modal');
				})
				.error(function(data, status, headers, config)
				{
						alert('default_course error');
				});
		}
		$scope.barf_certificate = function()
		{
				var postvars = {};
				$http.post('/certification/ajax_barf_certificate', postvars).
				success(function(data, status, headers, config)
				{
						$scope.$parent.active_course = data.active_course;
						$scope.$parent.return_id = data.return_id;
						$scope.$parent.user = data.user;
						$scope.$parent.content_knowlege_test_stats = data.content_knowlege_test_stats;
						$scope.$parent.states = data.states;
						$scope.$parent.countries = data.countries;
						$scope.$parent.country_name = data.country_name;
						$scope.$parent.state_abbreviation = data.state_abbreviation;
						$scope.$parent.all_courses = data.all_courses;
						$scope.$parent.all_user_courses_and_iterations = data.all_user_courses_and_iterations;
						MR.modal.show('#certificate-modal');
				})
				.error(function(data, status, headers, config)
				{
						alert('default_course error');
				});
		};

		$scope.accept_certificate = function()
		{
				var postvars = {};

				$http.post('/certification/ajax_angular_accept_certificate', postvars).
				success(function(data, status, headers, config)
				{
					console.log(data);
					if (data.status == "success"){
						window.location = '/admin';
					}
				})
				.error(function(data, status, headers, config)
				{
						alert('default_certificate error');
				});
		};

		$scope.complete_course = function(retry_course)
		{
				MR.modal.hide('#cert-prompt-modal');
				var postvars = {};
				$http.post('/base/ajax_complete_course', postvars).
				success(function(data, status, headers, config)
				{
						$scope.active_course = data.active_course;
						$scope.course_stats = data.course_stats;
						$scope.course_activity = data.course_activity;
						$scope.last_id = data.last_id;
						$scope.all_courses = data.all_courses;
						$scope.all_user_courses_and_iterations = data.all_user_courses_and_iterations;
						if (retry_course){
								$scope.activate_course(retry_course);
						}
				})
				.error(function(data, status, headers, config)
				{

				});
		};

		$scope.toggle_course_detail = function(course_id, current_iteration)
		{
			var make_ajax_call = false;
			var postvars = {};

			$scope.$apply(function()
			{
				if ($scope.$parent.show_course_detail == true)
				{
						if ($scope.$parent.last_course_id_detail_shown != course_id)
						{
							// leave show on and make ajax call
							make_ajax_call = true;
						}
						else
						{
							// hide section
							$scope.$parent.show_course_detail = false
						}
				}
				else
				{
					$scope.$parent.show_course_detail = true;
					make_ajax_call = true;
				}

				$scope.$parent.last_course_id_detail_shown = course_id;

				if (make_ajax_call)
				{
					postvars = {
							course_id:			course_id,
							current_iteration:	current_iteration
					};

					$http.post('/admin/ajax_angular_get_course_detail', postvars).
						success(function(data, status, headers, config)
						{
							$scope.$parent.course_activity = data.course_activity;
							$scope.$parent.tests_summary = data.tests_summary;
						})
						.error(function(data, status, headers, config)
						{
							alert('get_course_detail error');
						});
				}
			});
		};
}
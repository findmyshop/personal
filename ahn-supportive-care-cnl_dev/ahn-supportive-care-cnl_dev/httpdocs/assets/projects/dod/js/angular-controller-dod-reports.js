function trainingReportsController($scope, $rootScope, $http, $injector, $q, $sce, $cookieStore, $location)
{
		$injector.invoke(trainingDashboardController, this, {$scope: $scope});

		$scope.name																 = 'reports';
		$scope.data_row_clicked										 = '';
		$scope.departments												 = [];
		$scope.treatment_facilities								 = [];
		$scope.roles															 = [];
		$scope.user_courses												 = [];
		$scope.user_courses_offset								 = 0;
		$scope.user_courses_number_of_rows				 = 100;
		$scope.ready_for_more_user_courses_entries = false;
		$scope.downloading_user_courses_report		 = false;
		$scope.downloading_user_answers_report		 = false;
		$scope.show_spinner												 = '0';
		$scope.course_search											 = '';
		$scope.course_search_department_id				 = -1;
		$scope.course_search_treatment_facility_id = -1;
		$scope.course_search_role_id							 = -1;
		$scope.search_query_in_progress						 = false;
		$scope.show_uncompleted										 = -1;
		$scope.show_not_passed										 = -1;
		$scope.show_no_cert												 = -1;
		$scope.course_activity										 = [];
		$scope.tests_summary											 = [];

		$scope.get_course_detail = function(modal_id, user_id, course_id, current_iteration, course_name)
		{
			$scope.$parent.course_name = course_name;
			MR.modal.show(modal_id);
			var postvars = {
				user_id:			user_id,
				course_id:			course_id,
				current_iteration:	current_iteration
			};

				$http.post('/admin/ajax_angular_get_course_detail', postvars).
				success(function(data, status, headers, config)
				{

					$scope.$parent.course_activity = data.course_activity;
					$scope.$parent.tests_summary = data.tests_summary;
				}).
				error(function(data, status, headers, config)
				{
					alert('get_course_detail error');
					$scope.$parent.search_query_in_progress = false;
				}
			);
		}

		$scope.get_dropdown_filter_data = function() {
			$http.get('ajax_angular_get_dropdown_filter_data').
				success(function(data, status, headers, config) {
					$scope.departments = data.departments;
					$scope.treatment_facilities = data.treatment_facilities;
					$scope.roles = data.roles;
				}).error(function(data, status, headers, config) {
					alert('get_dropdown_filter_data error');
				});
		};

		$scope.get_user_courses = function(overwrite_user_courses) {
			if(typeof overwrite_user_courses != 'undefined' && overwrite_user_courses) {
				$scope.user_courses_offset = 0;
			}

			var postvars = {
				search: $scope.course_search,
				uncompleted: $scope.show_uncompleted,
				not_passed: $scope.show_not_passed,
				no_cert: $scope.show_no_cert,
				department_id: $scope.course_search_department_id,
				treatment_facility_id: $scope.course_search_treatment_facility_id,
				role_id: $scope.course_search_role_id,
				limit: $scope.user_courses_number_of_rows,
				offset: $scope.user_courses_offset
			};

			$scope.show_spinner = '1';
			$scope.search_query_in_progress = true;
			$scope.ready_for_more_user_courses_entries = false;

			$http.post('/admin/ajax_angular_get_user_courses', postvars)
				.success(function(data, status, headers, config) {
					if(typeof overwrite_user_courses != 'undefined' && overwrite_user_courses) {
						$scope.user_courses = data.user_courses;
						$scope.user_courses_offset = data.user_courses.length;
					} else {
						data.user_courses.forEach(function(a) {
							$scope.user_courses.push(a);
						});
						$scope.user_courses_offset += data.user_courses.length;
					}

					$scope.show_spinner = false;
					$scope.search_query_in_progress = false;
					setTimeout(function() {
						$scope.ready_for_more_user_courses_entries = true;
					}, 1000);

				}).error(function(data, status, headers, config) {
					alert('get_user_courses error');
					$scope.show_spinner = false;
					$scope.search_query_in_progress = false;
					setTimeout(function() {
						$scope.ready_for_more_user_courses_entries = true;
					}, 1000);
				}
			);
		};

		$scope.export_user_answers = function() {
			var postvars = {
				search								: $scope.course_search,
				department_id					: $scope.course_search_department_id,
				treatment_facility_id	: $scope.course_search_treatment_facility_id,
				role_id								: $scope.course_search_role_id
			};

			$scope.downloading_user_answers_report = true;

			$http.post('/admin/ajax_angular_export_user_answers', postvars).
			success(function(data, status, headers, config) {
				$scope.downloading_user_answers_report = false;

				if (data.status == 'success') {
					window.location = '/admin/download/user_answers/' + data.file;
				} else {
					MR.utils.alert({
						type: 'error',
						message: data.message
					});
				}
			}).
			error(function(data, status, headers, config) {
				$scope.downloading_user_answers_report = false;
				MR.utils.alert({
					type: 'error',
					message: 'failed to download file.'
				});
			});
		};

		$scope.export_user_courses = function(get_detailed_report) {
			var postvars = {
				search								: $scope.course_search,
				uncompleted						: $scope.show_uncompleted,
				not_passed						: $scope.show_not_passed,
				no_cert								: $scope.show_no_cert,
				department_id					: $scope.course_search_department_id,
				treatment_facility_id	: $scope.course_search_treatment_facility_id,
				role_id								: $scope.course_search_role_id,
				get_detailed_report		: (typeof get_detailed_report != 'undefined' && get_detailed_report) ? 1 : 0
			};

			$scope.downloading_user_courses_report = true;

			$http.post('/admin/ajax_angular_export_user_courses', postvars).
			success(function(data, status, headers, config) {
				$scope.downloading_user_courses_report = false;

				if (data.status == 'success') {
					window.location = '/admin/download/user_courses/' + data.file;
				} else {
					MR.utils.alert({
						type: 'error',
						message: data.message
					});
				}
			}).
			error(function(data, status, headers, config) {
				$scope.downloading_user_courses_report = false;
				MR.utils.alert({
					type: 'error',
					message: 'failed to download file.'
				});
			});
		};

		$scope.$watch('course_search', function(newValue, oldValue) {
			if ($scope.search_query_in_progress) {
				return;
			}

			if (newValue != oldValue) {
				$scope.search_query_in_progress = true;
				$scope.get_user_courses(true);
			}
		});

		$scope.$watch('show_no_cert', function(newValue, oldValue) {
			if ($scope.search_query_in_progress) {
				return;
			}

			if (newValue != oldValue) {
				$scope.search_query_in_progress = true;
				$scope.get_user_courses(true);
			}
		});

		$scope.$watch('show_not_passed', function(newValue, oldValue) {
			if ($scope.search_query_in_progress) {
				return;
			}

			if (newValue != oldValue) {
				$scope.search_query_in_progress = true;
				$scope.get_user_courses(true);
			}
		});

		$scope.$watch('show_uncompleted', function(newValue, oldValue) {
			if ($scope.search_query_in_progress) {
				return;
			}

			if (newValue != oldValue) {
				$scope.search_query_in_progress = true;
				$scope.get_user_courses(true);
			}
		});
		$scope.$watch('course_search_department_id', function(newValue, oldValue) {
			if ($scope.search_query_in_progress) {
				return;
			}

			if (newValue != oldValue) {
				$scope.search_query_in_progress = true;
				$scope.get_user_courses(true);
			}
		});

		$scope.$watch('course_search_treatment_facility_id', function(newValue, oldValue) {
			if ($scope.search_query_in_progress) {
				return;
			}

			if (newValue != oldValue) {
				$scope.search_query_in_progress = true;
				$scope.get_user_courses(true);
			}
		});

		$scope.$watch('course_search_role_id', function(newValue, oldValue) {
			if ($scope.search_query_in_progress) {
				return;
			}

			if (newValue != oldValue) {
				$scope.search_query_in_progress = true;
				$scope.get_user_courses(true);
			}
		});
}
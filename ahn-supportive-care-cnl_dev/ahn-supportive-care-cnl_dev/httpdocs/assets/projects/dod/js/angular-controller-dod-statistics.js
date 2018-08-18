function trainingStatisticsController($scope, $rootScope, $http, $injector, $q, $sce, $cookieStore, $location)
{
		$injector.invoke(trainingDashboardController, this, {$scope: $scope});

		$scope.name																			= 'statistics';
		$scope.statistics																= {};
		$scope.accreditation_types											= [];
		$scope.departments															= [];
		$scope.treatment_facilities											= [];
		$scope.roles																		= [];
		$scope.statistics_filter_course									= 'alcohol_sbirt_one_hour_course';
		$scope.statistics_filter_start_date							= new Date(2014,8,1);
		$scope.statistics_filter_end_date								= new Date();
		$scope.statistics_filter_accreditation_type_id	= -1;
		$scope.statistics_filter_department_id					= -1;
		$scope.statistics_filter_treatment_facility_id	= -1;
		$scope.statistics_filter_role_id								= -1;

		$scope.get_dropdown_filter_data = function() {
			$http.get('ajax_angular_get_dropdown_filter_data').
				success(function(data, status, headers, config) {
					$scope.accreditation_types = data.accreditation_types;
					$scope.departments = data.departments;
					$scope.treatment_facilities = data.treatment_facilities;
					$scope.roles = data.roles;
				}).error(function(data, status, headers, config) {
					alert('get_dropdown_filter_data error');
				});
		};

		$scope.export_accreditor_report = function() {
			if($scope.statistics_filter_accreditation_type_id == -1) {
				MR.utils.alert({
					type: 'error',
					message: 'Please select an Accreditation Type.'
				});
				return false;
			}

			$scope.show_spinner('Exporting Accreditor CSV');

			$http.post('/admin/ajax_angular_export_accreditor_report', {
				start_date						: $scope.statistics_filter_start_date,
				end_date							: $scope.statistics_filter_end_date,
				accreditation_type_id : $scope.statistics_filter_accreditation_type_id
			}).success(function(data, status, headers, config) {
				$scope.hide_spinner();
				if (data.status == 'success') {
					window.location = '/admin/download/accreditation/' + data.file;
				} else {
					MR.utils.alert({
						type: 'error',
						message: data.message
					});
				}
			}).error(function(data, status, headers, config) {
				$scope.hide_spinner();
				MR.utils.alert({
					type: 'error',
					message: 'failed to download the accreditor report.'
				});
			});
		};

		$scope.get_statistics = function() {
			$scope.show_spinner('Loading Statistics');

			$http.post('/admin/ajax_angular_get_course_statistics', {
				start_date						: $scope.statistics_filter_start_date,
				end_date							: $scope.statistics_filter_end_date,
				accreditation_type_id : $scope.statistics_filter_accreditation_type_id,
				department_id					: $scope.statistics_filter_department_id,
				treatment_facility_id	: $scope.statistics_filter_treatment_facility_id,
				role_id								: $scope.statistics_filter_role_id
			}).success(function(data, status, headers, config) {
				$scope.hide_spinner();
				$scope.statistics = data.statistics;
			}).error(function(data, status, headers, config) {
				$scope.hide_spinner();
				alert('get_statistics error');
			});
		};

		$scope.hide_spinner = function() {
			$('#spinner-text').html('');
			$('#spinner').hide();
		};

		$scope.show_spinner = function(text) {
			$('#spinner-text').html(text);
			$('#spinner').show();
		};

		$scope.$watch('statistics_filter_start_date', function(newValue, oldValue) {
			if (newValue != oldValue) {
				$scope.get_statistics();
			}
		});

		$scope.$watch('statistics_filter_end_date', function(newValue, oldValue) {
			if (newValue != oldValue) {
				$scope.get_statistics();
			}
		});

		$scope.$watch('statistics_filter_accreditation_type_id', function(newValue, oldValue) {
			if (newValue != oldValue) {
				$scope.get_statistics();
			}
		});

		$scope.$watch('statistics_filter_department_id', function(newValue, oldValue) {
			if (newValue != oldValue) {
				$scope.get_statistics();
			}
		});

		$scope.$watch('statistics_filter_treatment_facility_id', function(newValue, oldValue) {
			if (newValue != oldValue) {
				$scope.get_statistics();
			}
		});

		$scope.$watch('statistics_filter_role_id', function(newValue, oldValue) {
			if (newValue != oldValue) {
				$scope.get_statistics();
			}
		});
}
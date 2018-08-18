function trainingRegistrationController($scope, $rootScope, $http) {
	$scope.accreditation_types = [];
	$scope.roles = [];
	$scope.states = [];
	$scope.countries = [];

	$scope.new_user = {
		role_id								: -1,
		accreditation_type_id	: -1,
		first_name						: '',
		middle_initial				: '',
		last_name							: '',
		email									: '',
		address_line_1				: '',
		address_line_2				: '',
		city									: '',
		state_id							: -1,
		zip_code							: '',
		country_id						: 230, // currently defaults to the United States
		password							: '',
		confirm_password			: ''
	};

	$scope.add_user = function() {
		$http.post('/register/ajax_angular_register', $scope.new_user)
			.success(function(data, status, headers, config) {
				if(data.status === 'success') {
					window.location = '/' + MR.core.base_url;
				} else {
					MR.utils.alert({type:'error', message:data.message});
				}
			}).error(function(data, status, headers, config) {
		});
	}

	$scope.get_registration_form_data = function() {
	$http.get('/register/ajax_angular_get_registration_form_data')
		.success(function(data, status, headers, config) {
			$scope.accreditation_types = data.accreditation_types;
			$scope.roles = data.roles;
			$scope.states = data.states;
			$scope.countries = data.countries;
		})
		.error(function(data, status, headers, config) {
			MR.utils.alert({type:'error', message:data.message});
		});
	};
}
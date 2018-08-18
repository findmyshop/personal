function registrationController($scope, $rootScope, $http, $sce) {
	$scope.new_user = {
		is_customer	: '1',
		customer_type : 'Residential Customer',
		email				: '',
		postal_code	: '',
		captcha			: ''
	};

	$scope.add_user = function() {
		$('#sign-up-btn').prop('disabled', true);
		$scope.new_user.captcha = $('#g-recaptcha-response').val();

		$http.post('/login/ajax_register', $scope.new_user)
			.success(function(data, status, headers, config) {
				$('#sign-up-btn').prop('disabled', false);

				if(data.status === 'success') {
					window.location = '/' + MR.core.base_url;
				} else {
					MR.utils.alert({type:'error', message:data.message});
				}
			}).error(function(data, status, headers, config) {
		});
	}
}
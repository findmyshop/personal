function trainingDisclaimerController($scope, $rootScope, $http, $injector, $q, $sce, $cookieStore, $location) {
	$scope.name = 'disclaimer';

	$scope.active_course = [];
	$scope.disclaimer_accepted = false;

	$scope.accept_disclaimer = function() {
		var postvars = {};

		$http.post('/disclaimer/ajax_angular_accept_disclaimer', postvars)
			.success(function(data, status, headers, config) {
				if(data.rid){
					window.location = '/#/START/'+data.rid;
				} else {
					window.location = '/';
				}
			}).error(function(data, status, headers, config) {
				MR.utils.alert({type:'error',message:'Server is not responding.	 Make sure you are connected to the internet.'});
			});
	};

	$scope.load_active_course = function() {
		var postvars = {};

		console.log('in load_active_course method');

		$http.post('/disclaimer/ajax_angular_load_active_course', postvars)
			.success(function(data, status, headers, config) {
				$scope.active_course = data.active_course;
			}).error(function(data, status, headers, config) {
				MR.utils.alert({type:'error',message:'Server is not responding.	 Make sure you are connected to the internet.'});
			});
	}
}
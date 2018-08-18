trainingRegistrationApp = angular.module('trainingRegistrationApp', ['ngCookies', 'ngSanitize', 'ui.bootstrap'])

trainingRegistrationApp.config(function($locationProvider) {
	$locationProvider.html5Mode(false);
});

trainingRegistrationApp.directive('addUser', function($compile) {
	var directiveDefinitionObject = {
		restrict: 'A',
		scope: false,
		controller: 'trainingRegistrationController',
		link: function(scope, element, attrs) {
			element.bind('click', function() {
				scope.add_user();
			});
		}
	};
	return directiveDefinitionObject;
});

trainingRegistrationApp.directive('getRegistrationFormData', function($compile) {
	var directiveDefinitionObject = {
		restrict: 'A',
		scope: false,
		controller: 'trainingRegistrationController',
		link: function(scope, element, attrs) {
			scope.get_registration_form_data();
		}
	};
	return directiveDefinitionObject;
});

registrationApp = angular.module('registrationApp', ['ngCookies', 'ngSanitize', 'ui.bootstrap'])

registrationApp.config(function($locationProvider) {
	$locationProvider.html5Mode(false);
});

registrationApp.directive('addUser', function($compile) {
	var directiveDefinitionObject = {
		restrict: 'A',
		scope: false,
		controller: 'registrationController',
		link: function(scope, element, attrs) {
			element.bind('click', function() {
				scope.add_user();
			});
		}
	};
	return directiveDefinitionObject;
});

registrationApp.directive('isCustomerRadioButton', function() {
	return {
		restrict: 'A',
		scope: false,
		require: 'ngModel',
		controller: 'registrationController',
		link: function(scope, element, attrs, ctrl) {
			element.bind('change', function() {
				scope.$apply(function() {
					scope.new_user.is_customer = attrs.value;
				})
			});
		}
	};
});

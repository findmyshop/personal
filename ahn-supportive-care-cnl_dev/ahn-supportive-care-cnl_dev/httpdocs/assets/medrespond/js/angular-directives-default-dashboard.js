// Example for disabling adirective. Can be used to replace also.
var noopDirective = function() { return function () {}; };
// Disable ngPaste directive
// angular.module('userApp').factory('ngPasteDirective', noopDirective);

userApp.directive('loadOrganizationHierarchy', function($compile) {
	var directiveDefinitionObject = {
		restrict: 'A',
		scope: false,
		controller: 'defaultDashboardController',
		link: function(scope, element, attrs) {
			scope.get_organization_hierarchy();
		}
	};
	return directiveDefinitionObject;
});

userApp.directive('loadUsageData', function($compile) {
	var directiveDefinitionObject = {
		restrict: 'A',
		scope: false,
		controller: 'defaultDashboardController',
		link: function(scope, element, attrs) {
			scope.get_usage_data(attrs.user_id);
		}
	};
	return directiveDefinitionObject;
});

userApp.directive('loadSurveyResponsesData', function($compile) {
	var directiveDefinitionObject = {
		restrict: 'A',
		scope: false,
		controller: 'defaultDashboardController',
		link: function(scope, element, attrs) {
			scope.get_survey_responses_data();
		}
	};
	return directiveDefinitionObject;
});

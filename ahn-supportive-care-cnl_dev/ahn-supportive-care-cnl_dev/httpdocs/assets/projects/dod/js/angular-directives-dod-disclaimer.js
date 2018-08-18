trainingDisclaimerApp = angular.module('trainingDisclaimerApp', ['ngCookies', 'ngSanitize', 'ui.bootstrap','naturalSort'])

// Example for disabling a directive. Can be used to replace also.
var noopDirective = function() { return function () {}; };
// Disable ngPaste directive
// angular.module('userApp').factory('ngPasteDirective', noopDirective);

trainingDisclaimerApp.directive('acceptDisclaimer', function($compile)
{
	var directiveDefinitionObject = {
		restrict:		'A',
		scope:			false,
		controller:		'trainingDisclaimerController',
		link:			function(scope, element, attrs)
						{
								element.bind('click', function()
										{
									scope.accept_disclaimer();
										});
						}
	};
	return directiveDefinitionObject;
});


trainingDisclaimerApp.directive('loadActiveCourse', function($compile)
{
	var directiveDefinitionObject = {
		restrict:		'A',
		scope:			false,
		controller:		'trainingDisclaimerController',
		link:			function(scope, element, attrs)
						{
								console.log('in loadActiveCourse directive');
								scope.load_active_course();
						}
	};
	return directiveDefinitionObject;
});
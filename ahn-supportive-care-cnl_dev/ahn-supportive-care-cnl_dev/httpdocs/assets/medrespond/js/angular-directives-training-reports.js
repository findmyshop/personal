trainingReportsApp = angular.module('trainingReportsApp', ['ngCookies', 'ngSanitize', 'ui.bootstrap', 'naturalSort'])

trainingReportsApp.config(function($locationProvider)
{
	$locationProvider.html5Mode(false);

});
// Example for disabling adirective. Can be used to replace also.
var noopDirective = function() { return function () {}; };
// Disable ngPaste directive
// angular.module('userApp').factory('ngPasteDirective', noopDirective);

trainingReportsApp.directive('getCourseDetail', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingReportsController',
		link:			 function(scope, element, attrs)
						{
				element.bind('click', function()
								{
							scope.get_course_detail(attrs.modalId, attrs.userId, attrs.courseId, attrs.currentIteration, attrs.courseName);
								});
						}
	};
	return directiveDefinitionObject;
});

trainingReportsApp.directive('loadUserCourses', function($compile)
{
	var directiveDefinitionObject = {
		restrict: 'A',
		scope: false,
		controller: 'trainingReportsController',
		link: function(scope, element, attrs) {
			scope.get_user_courses();
			scope.get_dropdown_filter_data();
		}
	};
	return directiveDefinitionObject;
});

trainingReportsApp.directive('whenScrolled', function($window) {
	var directiveDefinitionObject = {
		restrict: 'A',
		scope: false,
		controller: 'trainingReportsController',
		link: function(scope, elm, attr) {
			var raw = elm[0];
			var funCheckBounds = function(evt) {
				var rectObject = raw.getBoundingClientRect();

				if (rectObject.bottom <= $window.innerHeight && scope.ready_for_more_user_courses_entries) {
					scope.get_user_courses();
				}
			};

			angular.element(window).bind('scroll load', funCheckBounds)
		}
	};

	return directiveDefinitionObject;
});


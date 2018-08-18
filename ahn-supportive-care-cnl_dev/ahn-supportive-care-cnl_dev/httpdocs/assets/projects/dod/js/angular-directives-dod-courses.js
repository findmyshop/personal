// Example for disabling a directive. Can be used to replace also.
var noopDirective = function() { return function () {}; };
// Disable ngPaste directive
// angular.module('userApp').factory('ngPasteDirective', noopDirective);

trainingDashboardApp.directive('barfCertificate', function($compile)
{
	var directiveDefinitionObject = {
		restrict:		'A',
		scope:			false,
		controller:		'trainingCoursesController',
		link:			function(scope, element, attrs)
						{
							element.bind('click', function() {
								scope.barf_certificate();
							});
						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('barfOldCertificate', function($compile)
{
	var directiveDefinitionObject = {
		restrict:		'A',
		scope:			false,
		controller:		'trainingCoursesController',
		link:			function(scope, element, attrs)
						{
							element.bind('click', function() {
								scope.barf_old_certificate(attrs.course);
							});
						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('acceptCertificate', function($compile)
{
	var directiveDefinitionObject = {
		restrict:		'A',
		scope:			false,
		controller:		'trainingCoursesController',
		link:			function(scope, element, attrs)
						{
								element.bind('click', function()
										{
									scope.accept_certificate();
										});
						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('loadDefaultCourse', function($compile)
{
	var directiveDefinitionObject = {
		restrict:		'A',
		scope:			false,
		controller:		'trainingCoursesController',
		link:			function(scope, element, attrs)
						{
							scope.get_default_course();
						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('toggleCourseDetail', function($compile)
{
	var directiveDefinitionObject = {
		restrict:		'A',
		scope:			false,
		controller:		'trainingCoursesController',
		link:	 function(scope, element, attrs) {
								element.bind('click', function() {
								//console.log(attrs);
								MR.modal.show(attrs.modalId);
								scope.$parent.course_name = attrs.courseName;
								scope.toggle_course_detail(attrs.toggleCourseDetail, attrs.currentIteration);
					 });
					}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('editAddress', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingCoursesController',
		link:			 function(scope, element, attrs)
						{
							element.bind('click', function()
							{
								scope.edit_address(scope.barfed_user);
							});

						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('hideSelectPromptOption', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingCoursesController',
		link:			 function(scope, element, attrs)
						{
							scope.$watch('barfed_user.country_id', function(newVal)
							{
								angular.element('#' + attrs.hideSelectPromptOption).css('display', 'none');
							});
						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('editAddressCountryChanged', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingCoursesController',
		link:			 function(scope, element, attrs)
						{
							scope.$watch('barfed_user.country_id', function(newVal)
							{
							scope.edit_address_select_country_changed(newVal);
							});
						}
	};
	return directiveDefinitionObject;
});


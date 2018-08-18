trainingDashboardApp = angular.module('trainingDashboardApp', ['ngCookies', 'ngSanitize', 'ui.bootstrap', 'naturalSort'])

trainingDashboardApp.directive('addNewUser', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingDashboardController',
		link:			 function(scope, element, attrs)
						{
							element.bind('click', function()
							{
								scope.add_user(scope.new_user);
							});

						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('addUserCountryChanged', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingDashboardController',
		link:			 function(scope, element, attrs)
						{
							scope.$watch('new_user.country_id', function(newVal)
							{
							scope.add_user_select_country_changed(newVal);
							});
						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('addUserSelectTypeChanged', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingDashboardController',
		link:			 function(scope, element, attrs)
						{
							scope.$watch('new_user.user_type_id', function(newVal)
							{
							scope.add_user_select_type_changed(newVal);
							});
						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('deleteUser', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingDashboardController',
		link:			 function(scope, element, attrs)
						{
							element.bind('click', function()
							{
								scope.delete_user();
							});
						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('editUser', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingDashboardController',
		link:			 function(scope, element, attrs)
						{
							element.bind('click', function()
							{
								scope.edit_user(scope.user);
							});

						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('editUserCountryChanged', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingDashboardController',
		link:			 function(scope, element, attrs)
						{
							scope.$watch('existing_user.country_id', function(newVal)
							{
							scope.edit_user_select_country_changed(newVal);
							});
						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('editUserSelectTypeChanged', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingDashboardController',
		link:			 function(scope, element, attrs)
						{
							scope.$watch('existing_user.user_type_id', function(newVal)
							{
							scope.edit_user_select_type_changed(newVal);
							});
						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('exportActivityLog', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingDashboardController',
		link:			 function(scope, element, attrs)
						{
							element.bind('click', function()
							{
								scope.export_activity_log(scope.search_keyword, scope.search_start_date, scope.search_end_date);
							});

						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('loadActions', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingDashboardController',
		link:			 function(scope, element, attrs)
						{
							scope.get_actions();
						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('loadActivityLog', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingDashboardController',
		link:			 function(scope, element, attrs)
						{
							element.bind('click', function()
							{
								scope.init_selected_activity_log(scope.log);
								set_show_info_dialog();
							});

						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('loadActivityLogs', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingDashboardController',
		link:			 function(scope, element, attrs)
						{
							scope.get_activity_logs();
						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('loadMoreActivityLogs', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingDashboardController',
		link:			 function(scope, element, attrs)
						{
					element.bind('click', function()
								{
						scope.get_activity_logs();
								});
						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('loadUser', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingDashboardController',
		link:			 function(scope, element, attrs)
						{
							element.bind('click', function()
							{
								scope.init_existing_user(scope.user);
								set_show_edit_dialog();
							});

						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('loadUsers', function($compile)
{
	var directiveDefinitionObject = {
		restrict:			'A',
		scope:			false,
		controller:		 'trainingDashboardController',
		link:			 function(scope, element, attrs)
						{
							scope.get_users();
						}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('refreshUsers', function($compile) {
	var directiveDefinitionObject = {
		restrict: 'A',
		scope: false,
		controller: 'trainingDashboardController',
		link: function(scope, element, attrs) {
			element.bind('click', function() {
				scope.refresh_users();
			});
		}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('activityLogsScroll', function($window) {
	var directiveDefinitionObject = {
		restrict: 'A',
		scope: false,
		controller: 'trainingDashboardController',
		link: function(scope, elm, attr) {
			var raw = elm[0];
			var funCheckBounds = function(evt) {
				var rectObject = raw.getBoundingClientRect();

				if (rectObject.bottom <= $window.innerHeight && scope.ready_for_more_activity_log_entries) {
					scope.get_activity_logs();
				}
			};

			angular.element(window).bind('scroll load', funCheckBounds);
		}
	};
	return directiveDefinitionObject;
});

trainingDashboardApp.directive('usersScroll', function($window) {
	var directiveDefinitionObject = {
		restrict: 'A',
		scope: false,
		controller: 'trainingDashboardController',
		link: function(scope, elm, attr) {
			var raw = elm[0];
			var funCheckBounds = function(evt) {
				var rectObject = raw.getBoundingClientRect();

				if(rectObject.bottom <= $window.innerHeight && scope.ready_for_more_user_entries) {
					scope.get_users(false);
				}
			};

			angular.element(window).bind('scroll load', funCheckBounds);
		}
	};
	return directiveDefinitionObject;
});
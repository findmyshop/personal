trainingStatisticsApp = angular.module('trainingStatisticsApp', ['ngCookies', 'ngSanitize', 'ui.bootstrap','naturalSort']);

trainingStatisticsApp.directive('loadStatistics', function($compile) {
	var directiveDefinitionObject = {
		restrict: 'A',
		scope: false,
		controller: 'trainingStatisticsController',
		link: function(scope, element, attrs) {
			scope.get_statistics();
			scope.get_dropdown_filter_data();
		}
	};
	return directiveDefinitionObject;
});

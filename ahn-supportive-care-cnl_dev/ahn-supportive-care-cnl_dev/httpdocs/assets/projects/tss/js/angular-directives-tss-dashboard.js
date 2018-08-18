userApp.directive('loadDashboardData', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'tssDashboardController',
        link: function(scope, element, attrs) {
            scope.load_dashboard_data();
        }
    };
    return directiveDefinitionObject;
});

userApp.directive('resumeSimulation', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'tssDashboardController',
        link: function(scope, element, attrs) {
            element.bind('click', function() {
                scope.resume_simulation();
            });
        }
    };
    return directiveDefinitionObject;
});

userApp.directive('retakeSimulation', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'tssDashboardController',
        link: function(scope, element, attrs) {
            element.bind('click', function() {
                scope.retake_simulation();
            });
        }
    };
    return directiveDefinitionObject;
});
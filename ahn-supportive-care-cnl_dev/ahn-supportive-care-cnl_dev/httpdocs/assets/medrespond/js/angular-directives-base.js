userApp = angular.module('userApp', ['ngCookies', 'ngSanitize', 'ui.bootstrap']);

userApp.directive('callAnalyzer', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'BaseController',
        link: function(scope, element, attrs) {
            scope.call_analyzer();
        }
    };
    return directiveDefinitionObject;
});

userApp.directive('startApp', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'BaseController',
        link: function(scope, element, attrs) {
            scope.start_app(scope.response_id);
        }
    };
    return directiveDefinitionObject;
});

userApp.directive('scrollIf', function () {
    return function (scope, element, attributes) {
        setTimeout(function () {
            if (scope.$eval(attributes.scrollIf)) {
                window.scrollTo(0, element[0].offsetTop - 100)
            }
        });
    }
});

userApp.directive('loadResponse', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'BaseController',
        link: function(scope, element, attrs) {
            scope.load_response(scope.response_id);
        }
    };
    return directiveDefinitionObject;
});

userApp.directive("ngVideoSrc", function () {
    return {
        restrict: "A",
        link: function (scope, element, attrs) {
            scope.load_video();
            element.src = scope.video_url;
        }
    }
});



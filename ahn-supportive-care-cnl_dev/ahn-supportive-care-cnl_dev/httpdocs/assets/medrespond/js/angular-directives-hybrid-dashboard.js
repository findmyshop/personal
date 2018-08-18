userApp = angular.module('userApp', ['ngCookies', 'ngSanitize', 'ui.bootstrap', 'naturalSort', 'angularjs-dropdown-multiselect']);

userApp.directive('addNewUser', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            element.bind('click', function() {
                scope.add_user(scope.new_user);
            });

        }
    };

    return directiveDefinitionObject;
});

userApp.directive('deleteUser', function($compile){
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            element.bind('click', function() {
                scope.delete_user();
            });
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('editMyUser', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            element.bind('click', function() {
                scope.edit_my_user(scope.user);
            });
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('editUser', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            element.bind('click', function() {
                scope.edit_user(scope.user);
            });
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('exportActivityLog', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            element.bind('click', function() {
                scope.export_activity_log(scope.activity_logs_mr_project_filter, scope.activity_logs_language_filter, scope.search_keyword, scope.search_start_date, scope.search_end_date);
            });
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('exportFeedbackLogs', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link:   function(scope, element, attrs) {
            element.bind('click', function() {
                scope.export_feedback_logs_spreadsheet();
            });
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('exportSessionSpreadsheet', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link:   function(scope, element, attrs) {
            element.bind('click', function() {
                scope.export_session_spreadsheet();
            });
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('exportSurveyLogs', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link:   function(scope, element, attrs) {
            element.bind('click', function() {
                scope.export_survey_logs();
            });
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('loadActions', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            scope.get_actions();
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('loadActivityLog', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            element.bind('click', function() {
                scope.init_selected_activity_log(scope.log);
                set_show_info_dialog();
            });
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('loadActivityLogs', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            scope.get_activity_logs();
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('loadMoreActivityLogs', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            element.bind('click', function() {
                scope.get_activity_logs();
            });
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('loadTermDefinitions', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            scope.get_term_definitions();
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('loadEditTermDefinitionModal', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            element.bind('click', function() {
                scope.set_term_definition_to_edit(scope.term_definition);
                set_show_edit_dialog();
            });
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('editTermDefinition', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            element.bind('click', function() {
                scope.edit_term_definition();
            });
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('insertTermDefinition', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            element.bind('click', function() {
                scope.insert_term_definition();
            });
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('loadUser', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            element.bind('click', function() {
                scope.init_existing_user(scope.user);
                set_show_edit_dialog();
            });
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('loadMyUser', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            scope.get_my_user();
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('loadUsers', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            scope.get_users();
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('loadUsernames', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            scope.get_usernames();
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('loadOrganizations', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            scope.get_organizations();
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('loadProvinces', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            scope.get_provinces();
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

userApp.directive('refreshUsers', function($compile) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
        link: function(scope, element, attrs) {
            element.bind('click', function() {
                scope.refresh_users();
            });
        }
    };

    return directiveDefinitionObject;
});

userApp.directive('activityLogsScroll', function($window) {
    var directiveDefinitionObject = {
        restrict: 'A',
        scope: false,
        controller: 'dashboardController',
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

userApp.directive('existingUserIsCustomerRadioButton', function() {
    return {
        restrict: 'A',
        scope: false,
        require: 'ngModel',
        controller: 'dashboardController',
        link: function(scope, element, attrs, ctrl) {
            element.bind('change', function() {
                scope.$apply(function() {
                    scope.existing_user.is_customer = attrs.value;
                });
            });
        }
    };
});

userApp.directive('newUserIsCustomerRadioButton', function() {
    return {
        restrict: 'A',
        scope: false,
        require: 'ngModel',
        controller: 'dashboardController',
        link: function(scope, element, attrs, ctrl) {
            element.bind('change', function() {
                scope.$apply(function() {
                    scope.new_user.is_customer = attrs.value;
                });
            });
        }
    };
});

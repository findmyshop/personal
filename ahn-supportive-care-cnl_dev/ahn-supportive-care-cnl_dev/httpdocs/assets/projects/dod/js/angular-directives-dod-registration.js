trainingRegistrationApp = angular.module('trainingRegistrationApp', ['ngCookies', 'ngSanitize', 'ui.bootstrap'])

trainingRegistrationApp.config(function($locationProvider)
{
  $locationProvider.html5Mode(false);

});
/*
 * Object sorting for ng-repeat.
 * @param attribute:string
 * @param asc:boolean
 */
trainingRegistrationApp.filter('orderObjectBy', function(){
  return function(input, attribute, direction) {
    if (!angular.isObject(input)) return input;
    var array = [];
    for(var objectKey in input) {
      array.push(input[objectKey]);
    }
    array.sort(function(a, b){
      a = parseInt(a[attribute]);
      b = parseInt(b[attribute]);
      return direction == true ? a - b : b - a;
    });
    return array;
  }
});

trainingRegistrationApp.filter('unsafe', function($sce){
  return function(val)
  {
	  return $sce.trustAsHtml(val);
  };
});

trainingRegistrationApp.config(['$httpProvider', function($httpProvider)
{
  // Turn caching of GET requests off
  if (!$httpProvider.defaults.headers.get) {
    $httpProvider.defaults.headers.get = {};
  }
  $httpProvider.defaults.headers.get['If-Modified-Since'] = '0';
}]);

trainingRegistrationApp.directive('addNewUser', function($compile)
{
  var directiveDefinitionObject = {
    restrict:     'A',
    scope:      false,
    controller:    'trainingRegistrationController',
    link:      function(scope, element, attrs)
            {
              element.bind('click', function()
              {
                scope.add_user(scope.new_user);
              });

            }
  };
  return directiveDefinitionObject;
});

trainingRegistrationApp.directive('addAccreditationTypeChanged', function($compile)
{
  var directiveDefinitionObject = {
    restrict:     'A',
    scope:      false,
    controller:    'trainingRegistrationController',
    link:      function(scope, element, attrs)
            {
              scope.$watch('new_user.accreditation_type_id', function(newVal)
              {
            	scope.add_accreditation_type_changed(newVal);
              });
            }
  };
  return directiveDefinitionObject;
});

trainingRegistrationApp.directive('addDepartmentChanged', function($compile)
{
  var directiveDefinitionObject = {
    restrict:     'A',
    scope:      false,
    controller:    'trainingRegistrationController',
    link:      function(scope, element, attrs)
            {
              scope.$watch('new_user.department_id', function(newVal)
              {
            	scope.add_department_changed(newVal);
              });
            }
  };
  return directiveDefinitionObject;
});

trainingRegistrationApp.directive('addUserCountryChanged', function($compile)
{
  var directiveDefinitionObject = {
    restrict:     'A',
    scope:      false,
    controller:    'trainingRegistrationController',
    link:      function(scope, element, attrs)
            {
              scope.$watch('new_user.country_id', function(newVal)
              {
            	scope.add_user_select_country_changed(newVal);
              });
            }
  };
  return directiveDefinitionObject;
});

trainingRegistrationApp.directive('addUserSelectTypeChanged', function($compile)
{
  var directiveDefinitionObject = {
    restrict:     'A',
    scope:      false,
    controller:    'trainingRegistrationController',
    link:      function(scope, element, attrs)
            {
              scope.$watch('new_user.user_type_id', function(newVal)
              {
            	scope.add_user_select_type_changed(newVal);
              });
            }
  };
  return directiveDefinitionObject;
});

trainingRegistrationApp.directive('continueClicked', function($compile)
{
  var directiveDefinitionObject = {
    restrict:     'A',
    scope:      false,
    controller:    'trainingRegistrationController',
    link:      function(scope, element, attrs)
            {
              element.bind('click', function()
              {
                scope.continue_clicked();
              });

            }
  };
  return directiveDefinitionObject;
});

trainingRegistrationApp.directive('hideSelectPromptOption', function($compile)
{
  var directiveDefinitionObject = {
    restrict:     'A',
    scope:      false,
    controller:    'trainingRegistrationController',
    link:      function(scope, element, attrs)
            {
              scope.$watch('new_user.country_id', function(newVal)
              {
            	  angular.element('#' + attrs.hideSelectPromptOption).css('display', 'none');
              });
            }
  };
  return directiveDefinitionObject;
});

trainingRegistrationApp.directive('loadSelectControlData', function($compile)
{
  var directiveDefinitionObject = {
    restrict:     'A',
    scope:      false,
    controller:    'trainingRegistrationController',
    link:      function(scope, element, attrs)
            {
              scope.get_select_control_data();
            }
  };
  return directiveDefinitionObject;
});

trainingRegistrationApp.directive('previousClicked', function($compile)
{
  var directiveDefinitionObject = {
    restrict:     'A',
    scope:      false,
    controller:    'trainingRegistrationController',
    link:      function(scope, element, attrs)
            {
              element.bind('click', function()
              {
                scope.previous_clicked();
              });

            }
  };
  return directiveDefinitionObject;
});

trainingRegistrationApp.directive('registrationTabClicked', function($compile)
{
  var directiveDefinitionObject = {
    restrict:     'A',
    scope:      false,
    controller:    'trainingRegistrationController',
    link:      function(scope, element, attrs)
            {
              element.bind('click', function()
              {
                scope.registration_tab_clicked(attrs.tabNumber);
              });

            }
  };
  return directiveDefinitionObject;
});

trainingRegistrationApp.directive('setRegistrationPanel', function($compile)
{
  var directiveDefinitionObject = {
    restrict:     'A',
    scope:      false,
    controller:    'trainingRegistrationController',
    link:   function(scope, element, attrs)
            {
              element.bind('click', function()
              {
            	  scope.set_registration_panel(attrs.setRegistrationPanel, attrs.id);

            	  angular.element('#' + attrs.id).focus();
              });
            }
  };
  return directiveDefinitionObject;
});

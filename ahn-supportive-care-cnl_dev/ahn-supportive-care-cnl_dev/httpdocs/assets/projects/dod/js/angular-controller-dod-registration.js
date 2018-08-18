function trainingRegistrationController($scope, $rootScope, $http, $q /*, existingUserService */)
{
  $scope.user_types = [];
  $scope.pay_grades = [];
  $scope.accreditation_types = [];
  $scope.roles = [];
  $scope.treatment_facilities = [];
  $scope.departments = [];
  $scope.states = [];
  $scope.countries = [];
  $scope.users = [];
  $scope.new_user = {};
  $scope.showDialog = false;
  $scope.showEditDialog = false;
  $scope.showInfoDialog = false;
  $scope.error_message = '';
  $scope.status_message_title = '';
  $scope.status_message_body = '';
  $scope.show_spinner='0';
  $scope.show_all_add_form_fields = true;
  $scope.us_address_on_add_form = true;
  $scope.current_tab = 1;
  $scope.highest_tab_visited = 1;
  $scope.highest_tab_validated = 0;
  $scope.show_previous_button=false;
  $scope.show_continue_button=false;
  $scope.app_initialized = false;
  $scope.add_department_changed_called = false;
  $scope.add_accreditation_type_changed_called = false;
  $scope.add_role_changed = false;
  $scope.add_pay_grade_changed = false;
  $scope.add_treatment_facility_changed = false;
  $scope.add_country_changed = false;
  $scope.selected_department_text = "";
  $scope.selected_accreditation_type_text = "";
  $scope.selected_country_text = "";
  $scope.selected_role_text = '';
  $scope.selected_pay_grade_text = '';
  $scope.selected_treatment_facility_text = '';
  $scope.selected_state_text = '';
  $scope.default_course = false;
  $scope.show_registration_failure_message = false;
  $scope.registration_failure_message = '';

  $scope.add_user = function(new_user)
  {
  $scope.show_registration_failure_message = false;
  $scope.registration_failure_message = '';

    $http.post('/register/ajax_angular_add_user', $scope.new_user).
    success(function(data, status, headers, config) {
      if (data.status == 'success') {
        $scope.new_user.username = data.username;
        $scope.default_course = data.default_course;

        $('.tab-pane').each(function(){
          $(this).removeClass('active');
        });

        $('.registration-tab').each(function() {
          $(this).removeClass('active');
        });

        $('#registration-tab-1').hide();
        $('#registration-tab-2').hide();
        $('#registration-tab-3').hide();
        $('#registration-tab-4').hide();
        $('#registration-tab-5').hide();

        $scope.show_previous_button=false;
        $scope.show_continue_button=false;
        $scope.current_tab = 6;

        $('#registration-panel-6').addClass('active');

        $('#registration-panel-6').show();
      } else {
        $scope.registration_failure_message = data.message;
        $scope.show_registration_failure_message = true;
      }
    }).error(function(data, status, headers, config) {
      $scope.registration_failure_message = 'internal error - failed to add user.';
      $scope.show_registration_failure_message = true;
    });
  }

  $scope.add_accreditation_type_changed = function(accreditation_type_id)
  {
    if ($scope.app_initialized == false) {
      return;
    }

    if (accreditation_type_id == -1) {
      return;
    }

    /* Code to close off an option. */
    /*
    if (accreditation_type_id == 4) {
      $scope.new_user.accreditation_type_id = -1;
      alert('APA accreditation for the 3-hour AlcoholSBIRT program is not available at this time.  In the interim, confirm that your state will accept CME and/or CE credits, and choose the option that will apply.');
      return;
    }
    */

    $scope.add_accreditation_type_changed_called = true;

    if ($scope.highest_tab_validated < 2) {
      $scope.highest_tab_validated = 2;
    }

    $scope.current_tab = 3;
    $scope.show_previous_button = true;
    $scope.selected_accreditation_type_text = $("#accreditation_type_id option:selected").text();

    if ($scope.current_tab > $scope.highest_tab_visited) {
      $scope.highest_tab_visited = $scope.current_tab;
    }

    $('#registration-panel-2').removeClass('active');
    $('#registration-panel-3').addClass('active');
    $('#registration-tab-2').removeClass('active');
    $('#registration-tab-3').addClass('active');
    $('#registration-tab-3').tab('show');
  }

  $scope.add_department_changed = function(department_id) {
    if ($scope.app_initialized == false) {
      return;
    }

    if (department_id == -1) {
      return;
    }

    $scope.add_department_changed_called = true;
    $scope.selected_department_text = $("#department_id option:selected").text();

    if ($scope.highest_tab_validated < 1) {
      $scope.highest_tab_validated = 1;
    }

    $scope.current_tab = 2;
    $scope.show_previous_button=true;

    if ($scope.current_tab > $scope.highest_tab_visited) {
      $scope.highest_tab_visited = $scope.current_tab;
    }

    $('#registration-panel-1').removeClass('active');
    $('#registration-panel-2').addClass('active');
    $('#registration-tab-1').removeClass('active');
    $('#registration-tab-2').addClass('active');
    $('#registration-tab-2').tab('show');

  }

  $scope.add_user_select_country_changed = function(country_id) {

    if (country_id == 230) {
      $scope.us_address_on_add_form = true;
    }
    else {
      $scope.us_address_on_add_form = false;
    }

    $scope.new_user.province = '';
    $scope.new_user.state_id = -1;
    $scope.selected_country_text = $("#country_id option:selected").text();

  }

  $scope.add_user_select_type_changed = function(user_type) {
    if (user_type == '1') {
      $scope.show_all_add_form_fields = false;
    }
    else {
      $scope.show_all_add_form_fields = true;
    }
  }

  $scope.continue_clicked = function() {
    if ($scope.current_tab == 5) {
      return;
    }

    $scope.$apply(function() {
      if ($scope.current_tab > $scope.highest_tab_validated) {
        $scope.highest_tab_validated = $scope.current_tab;
      }

      $scope.current_tab++;

      if ($scope.current_tab >= $scope.highest_tab_visited) {
        $scope.highest_tab_visited = $scope.current_tab;
      }

      if ($scope.current_tab == 5) {
        $scope.show_continue_button = false;
      }

      $scope.show_previous_button = true;
    });

    $('.tab-pane').each(function() {
      $(this).removeClass('active');
    });
    $('#registration-panel-'+$scope.current_tab).addClass('active');

    $('#registration-panel-'+$scope.current_tab).show();
    $('.registration-tab').each(function() {
      $(this).removeClass('active');
    });
    $('#registration-tab-'+$scope.current_tab).addClass('active');
    $('#registration-tab-'+$scope.current_tab).tab('show');

  }

  $scope.get_select_control_data = function() {
    $http.post('/register/ajax_angular_get_select_control_data', { user: $scope.new_user }).
      success(function(data, status, headers, config) {
        $scope.user_types = data.user_types;
        $scope.accreditation_types = data.accreditation_types;
        $scope.roles = data.roles;
        $scope.treatment_facilities = data.treatment_facilities;
        $scope.departments = data.departments;
        $scope.pay_grades = data.pay_grades;
        $scope.states = data.states;
        $scope.countries = data.countries;
      }).error(function(data, status, headers, config) {
        //alert('get_users error');
      });
  };

  $scope.init_app = function() {
    $('.tab-pane').each(function() {
      $(this).removeClass('active');
    });

    $('.registration-tab').each(function() {
      $(this).removeClass('active');
    });

    $scope.current_tab = '1';
    $scope.highest_tab_visited = 1;
    $scope.show_previous_button=false;
    $scope.show_continue_button=false;
    $scope.init_new_user();
    $scope.app_initialized = true;

    $('#registration-panel-1').addClass('active');
    $('#registration-panel-1').show();
  };

  $scope.init_new_user = function()
  {
    $scope.new_user = {
      first_name:    '',
      middle_initial:  '',
      last_name:    '',
      department_id:  -1,
      treatment_facility_id:    -1,
      pay_grade_id:    -1,
      dod_number:    '',
      role_id:      -1,
      accreditation_type_id: -1,
      username:      '',
      user_type_id:    4,
      email_address:  '',
      password:      '',
      confirm_password:  '',
      address_1:    '',
      address_2:    '',
      city:        '',
      state_id:      -1,
      province:      '',
      zip:        '',
      country_id:    -1,
      login_enabled:    1
    };

  }

  $scope.previous_clicked = function()
  {
    if ($scope.current_tab == 1) {
      return;
    }

    $scope.$apply(function() {
      $scope.current_tab--;
      if ($scope.current_tab == 1) {
        $scope.show_previous_button=false;
      }
      $scope.show_continue_button=true;
    });

    $('.tab-pane').each(function() {
      $(this).removeClass('active');
    });

    $('#registration-panel-'+$scope.current_tab).addClass('active');
    $('#registration-panel-'+$scope.current_tab).show();
    $('.registration-tab').each(function() {
      $(this).removeClass('active');
    });
    $('#registration-tab-'+$scope.current_tab).addClass('active');
    $('#registration-tab-'+$scope.current_tab).tab('show');
  }

  $scope.registration_tab_clicked = function(tab_number) {

    if (tab_number == 1) {
      $scope.$apply(function() {
        $scope.current_tab=tab_number;
        $scope.show_previous_button=false;
        $scope.show_continue_button=true;
      });
    } else if (tab_number == 5) {
      $scope.$apply(function() {
        $scope.current_tab=tab_number;
        $scope.show_previous_button=true;
        $scope.show_continue_button=false;
        if (tab_number > $scope.highest_tab_visited) {
          $scope.highest_tab_visited = tab_number;
        }
      });
    } else {
      $scope.$apply(function() {
        $scope.current_tab=tab_number;
        $scope.show_previous_button=true;
        $scope.show_continue_button=true;
        if (tab_number > $scope.highest_tab_visited) {
          $scope.highest_tab_visited = tab_number;
        }
      });
    }
  }

  $scope.set_registration_panel = function(panel, id) {

    $scope.registration_tab_clicked(panel);
    $scope.show_previous_button=false;
    $scope.show_continue_button=false;

    $('.tab-pane').each(function() {
      $(this).removeClass('active');
    });

    $('#registration-panel-'+panel).addClass('active');
    $('#registration-panel-'+panel).show();
    $('.registration-tab').each(function() {
      $(this).removeClass('active');
    });
    $('#registration-tab-'+panel).addClass('active');
    $('#registration-tab-'+panel).tab('show');
  }

  $scope.set_selection_text = function(id) {
    switch(id) {
    case 'role_id':
      $scope.selected_role_text = $("#" + id + " option:selected").text();
      break;
    case 'pay_grade_id':
      $scope.selected_pay_grade_text = $("#" + id + " option:selected").text();
      break;
    case 'treatment_facility_id':
      $scope.selected_treatment_facility_text = $("#" + id + " option:selected").text();
      break;
    case 'state_id':
      $scope.selected_state_text = $("#" + id + " option:selected").text();
      break;
    default:
    break;
    }
  }
  $scope.init_app();
}
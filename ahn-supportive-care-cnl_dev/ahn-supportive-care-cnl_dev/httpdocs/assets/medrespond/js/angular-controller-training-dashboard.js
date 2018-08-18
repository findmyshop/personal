function trainingDashboardController($scope, $rootScope, $http, $q, $timeout /*, existingUserService */)
{
	$scope.filtered_activity_logs								= [];
	$scope.actions															= [];
	$scope.activity_logs												= [];
	$scope.activity_logs_offset									= 0;
	$scope.activity_logs_number_of_rows					= 100;
	$scope.log_users														= [];
	$scope.log_actions													= [];
	$scope.log_browsers													= [];
	$scope.user_types														= [];
	$scope.roles																= [];
	$scope.states																= [];
	$scope.users																= [];
	$scope.users_offset													= 0;
	$scope.users_number_of_rows									= 100;
	$scope.new_user															= {};
	$scope.existing_user												= {};
	$scope.selected_activity_log								= {};
	$scope.showDialog														= false;
	$scope.showEditDialog												= false;
	$scope.showInfoDialog												= false;
	$scope.showConfirmDeleteDialog							= false;
	$scope.error_message												= '';
	$scope.showDashboardStatus									= false;
	$scope.status_message_title									= '';
	$scope.status_message_body									= '';
	$scope.search																= '';
	$scope.search_query_in_progress							= false;
	$scope.ready_for_more_activity_log_entries	= true;
	$scope.ready_for_more_user_courses_entries	= true;
	$scope.show_spinner													='1';
	$scope.search_start_date										= new Date(2014,8,1);
	$scope.search_end_date											= new Date();
	$scope.search_keyword												= "";
	$scope.end_datepicker_opened								= false;
	$scope.start_datepicker_opened							= false;
	$scope.show_all_add_form_fields							= false;
	$scope.show_all_edit_form_fields						= true;
	$scope.us_address_on_add_form								= true;
	$scope.us_address_on_edit_form							= true;

	$scope.end_datepicker_open = function($event)
	{
		$event.preventDefault();
		$event.stopPropagation();

		$scope.end_datepicker_opened = true;
	};

	$scope.start_datepicker_open = function($event)
	{
		$event.preventDefault();
		$event.stopPropagation();

		$scope.start_datepicker_opened = true;
	};

	$scope.add_user = function(new_user)
	{
		$http.post('/admin/ajax_angular_add_user', $scope.new_user).
		success(function(data, status, headers, config)
		{
			if (data.status == 'success')
			{
				$scope.users.push(data.user);
				$scope.users = [];
				$scope.get_users(true);
				$scope.init_new_user();
				$scope.showDialog = false;
				MR.utils.alert({type:'success',message:'User ' + data.user.username + ' was successfully added.'});
			}
			else
			{
				MR.utils.alert({type:'error',message:data.message});
			}
		}).
		error(function(data, status, headers, config)
		{
			MR.utils.alert({type:'error',message:'failed to add user.'});
		});
	}

	$scope.add_user_select_type_changed = function(user_type) {
		if(user_type == '1' || user_type == '2') {
			$scope.show_all_add_form_fields = false;
		} else {
			$scope.show_all_add_form_fields = true;
		}
	}

	$scope.delete_user = function()
	{
		$http.post('/admin/ajax_angular_delete_user', $scope.existing_user).
		success(function(data, status, headers, config)
		{
			if (data.status == 'success')
			{
				$scope.showConfirmDeleteDialog = false;
				$scope.showEditDialog = false;
				$scope.users = [];
				$scope.get_users(true);
			}
			else
			{
				MR.utils.alert({type:'error',message:data.message});
			}
		}).
		error(function(data, status, headers, config)
		{
			MR.utils.alert({type:'error',message:'failed to delete user.'});
		});
	}

	$scope.edit_user = function()
	{
		$http.post('/admin/ajax_angular_edit_user', $scope.existing_user).
		success(function(data, status, headers, config)
		{
			if (data.status == 'success')
			{
				$scope.showEditDialog = false;
				$scope.existing_user = [];
				$scope.users = [];
				$scope.get_users(true);
				MR.utils.alert({type:'success',message:'Update was successfull'});
			}
			else
			{
				MR.utils.alert({type:'error',message:data.message});
				//$scope.get_users();
			}
		}).
		error(function(data, status, headers, config)
		{
			MR.utils.alert({type:'error',message:'failed to edit user.'});
		});
	}

	$scope.edit_user_select_type_changed = function(user_type) {
		if(user_type == '1' || user_type == '2') {
			$scope.show_all_edit_form_fields = false;
		} else {
			$scope.show_all_edit_form_fields = true;
		}
	}

	$scope.export_activity_log = function(search_keyword, search_start_date, search_end_date) {
		var postvars = {
			search_keyword: search_keyword,
			search_start_date: search_start_date,
			search_end_date: search_end_date
		}

		$scope.file_upload_spinner('#file_upload_spinner', true);

		$http.post('/admin/ajax_angular_export_activity_log', postvars).
		success(function(data, status, headers, config) {
			$scope.file_upload_spinner('#file_upload_spinner', false);

			if (data.status == 'success') {
				window.location = '/admin/download/activity_logs/' + data.file;
			} else {
				MR.utils.alert({
					type: 'error',
					message: data.message
				});
			}
		}).
		error(function(data, status, headers, config) {
			$scope.file_upload_spinner('#file_upload_spinner', false);
			MR.utils.alert({
				type: 'error',
				message: 'failed to export log file.'
			});
		});
	}

	$scope.export_users = function() {
		var postvars = {
			search: $scope.search
		}

		$scope.file_upload_spinner('#file_upload_spinner', true);

		$http.post('/admin/ajax_angular_export_users', postvars).
		success(function(data, status, headers, config) {
			$scope.file_upload_spinner('#file_upload_spinner', false);

			if (data.status == 'success') {
				window.location = '/admin/download/users/' + data.file;
			} else {
				MR.utils.alert({
					type: 'error',
					message: data.message
				});
			}
		}).
		error(function(data, status, headers, config) {
			$scope.file_upload_spinner('#file_upload_spinner', false);
			MR.utils.alert({
				type: 'error',
				message: 'failed to download users file.'
			});
		});
	}

	$scope.export_csv = function(report_type, data)
	{
		$http.post('/admin/ajax_angular_export_csv', {'report_type': report_type, 'data': data}).
		success(function(data, status, headers, config)
		{
			if (data.status == 'success')
			{
				window.location = '/admin/download/' + data.report_type + '/' + data.file;
			}
			else
			{
				//console.debug(data);
			}
		}).
		error(function(data, status, headers, config)
		{
			MR.utils.alert({type:'error',message:'failed to export CSV.'});
		});
	}

	$scope.filter_log = function(username, action, browser)
	{
		var filtered_logs = [];
		if (username == null && browser == null && action == null)
		{
			filtered_logs = $scope.activity_logs;
		}
		else if (browser == null && action == null)
		{
			filtered_logs = $scope.activity_logs.filter(function(val) {
				return username == val.username
			});
		}
		else if (username == null && action == null)
		{
			filtered_logs = $scope.activity_logs.filter(function(val) {
				return browser == val.browser
			});
		}
		else if (username == null && browser == null)
		{
			filtered_logs = $scope.activity_logs.filter(function(val) {
				return action == val.action
			});
		}
		else if (action == null)
		{
			filtered_logs = $scope.activity_logs.filter(function(val) {
				return username == val.username &&
						 browser == val.browser;
			});
		}
		else if (username == null)
		{
			filtered_logs = $scope.activity_logs.filter(function(val) {
				return action == val.action &&
						 browser == val.browser;
			});
		}
		else if (browser == null)
		{
			filtered_logs = $scope.activity_logs.filter(function(val) {
				return action == val.action &&
						 username == val.username;
			});
		}
		else
		{
			filtered_logs = $scope.activity_logs.filter(function(val) {
				return username == val.username &&
						 action == val.action &&
						 browser == val.browser;
			});
		}
		$scope.filtered_activity_logs = filtered_logs;
	}

	$scope.get_actions = function() {
		$http.get('/admin/ajax_angular_get_actions/')
			.success(function(data, status, headers, config) {
				if(data.status === 'success') {
					data.actions.forEach (function(a){
						$scope.actions.push(a);
					});
				} else {
					MR.utils.alert({type:'error',message:'failed to load actions.'});
				}
		}).error(function(data, status, headers, config) {
			alert('get_actions error');
		});
	};


	$scope.get_activity_logs = function()
	{
	if (!$scope.ready_for_more_activity_log_entries)
	{
		return;
	}

	var postvars = {
			offset:				$scope.activity_logs_offset,
			number_of_rows:		$scope.activity_logs_number_of_rows,
			search_keyword:		$scope.search_keyword,
			search_start_date:	$scope.search_start_date,
			search_end_date:		$scope.search_end_date
	};

	$scope.ready_for_more_activity_log_entries = false;
	$scope.show_spinner="1";

	$http.post('/admin/ajax_angular_get_activity_logs/', postvars).
			success(function(data, status, headers, config)
			{
			if (data.activity_logs.length > 0)
			{
				data.activity_logs.forEach (function(a){
					if (a.browser){
						a.browser = MR.utils.parseBrowserIcons(a.browser);
					}
					if (a.operating_system){
						a.operating_system = MR.utils.parseBrowserIcons(a.operating_system);
					}
					$scope.activity_logs.push(a);
					$scope.filtered_activity_logs.push(a);
				});
					$scope.log_users = data.log_users;
					$scope.log_browsers = data.log_browsers;
					$scope.log_actions = data.log_actions;
					$scope.activity_logs_offset += data.activity_logs.length;
			}
			//setTimeout(function(){$scope.$parent.show_spinner="0";}, 300);
			$scope.show_spinner="0";
				setTimeout(function(){$scope.ready_for_more_activity_log_entries = true;}, 1000);
			}).
			error(function(data, status, headers, config)
			{
				alert('get_activity_logs error');
				//setTimeout(function(){$scope.$parent.show_spinner="0";}, 300);
				$scope.show_spinner="0";
				setTimeout(function(){$scope.ready_for_more_activity_log_entries = true;}, 1000);
			}
		);
	};

	$scope.get_users = function(overwrite_users) {
		if (typeof overwrite_users != 'undefined' && overwrite_users) {
			$scope.users_offset = 0;
		}

		var postvars = {
			search: $scope.search,
			limit: $scope.users_number_of_rows,
			offset: $scope.users_offset
		};

		$scope.show_spinner = '1';
		$scope.search_query_in_progress = true;
		$scope.ready_for_more_user_entries = false;

		$http.post('/admin/ajax_angular_get_users', postvars)
			.success(function(data, status, headers, config) {
				$scope.user_types = data.user_types;

				$scope.accreditation_types = data.accreditation_types;
				$scope.roles = data.roles;
				$scope.states = data.states;
				$scope.search_query_in_progress = false;

				if (typeof overwrite_users != 'undefined' && overwrite_users) {
					$scope.users = data.users;
					$scope.users_offset = data.users.length;
				} else {
					data.users.forEach(function(a) {
						$scope.users.push(a);
					});
					$scope.users_offset += data.users.length;
				}

				$scope.show_spinner = '0';
				$scope.search_query_in_progress = false;
				setTimeout(function() {
					$scope.ready_for_more_user_entries = true;
				}, 1000);

			}).
		error(function(data, status, headers, config) {
			alert('get_users error');
			$scope.show_spinner = '0';
			$scope.search_query_in_progress = false;
			setTimeout(function() {
					$scope.ready_for_more_user_entries = true;
				}, 1000);
		});
	};

	$scope.init_existing_organization = function(organization)
	{
		$scope.$parent.$apply(function ()
		{
			$scope.$parent.existing_organization = organization;
		});
	}

	$scope.init_existing_user = function(user)
	{
		$http.post('/admin/ajax_angular_get_user', {'user_id': $scope.user.id})
			.success(function(data, status, headers, config) {
					$scope.$parent.existing_user = data.user;
					$scope.$parent.edit_user_select_type_changed(data.user.user_type_id);
			}).error(function(data, status, headers, config) {
					alert('get_users error');
			});
	}

	$scope.init_new_user = function()
	{
		$timeout(function() {
			$scope.$parent.$apply(function () {
				$scope.new_user = {
					first_name						:	'',
					middle_initial				: '',
					last_name							:	'',
					role_id								:	-1,
					accreditation_type_id	: -1, /*$scope.accreditation_types[0].accreditation_type,*/
					username							:	'',
					user_type_id					:	-1 /*$scope.user_types[0].type_name*/,
					email_address					:	'',
					password							:	'',
					confirm_password			: '',
					address_1							:	'',
					address_2							:	'',
					city									:	'',
					state_id							:	-1, /*$scope.states[0].abbreviation,*/
					zip										:	'',
					country_id						:	230, // currently defaults to the United States
					login_enabled					:	1
				};
			});
		});
	}

	$scope.init_selected_activity_log = function(log)
	{
		$scope.$parent.$apply(function ()
		{
			$scope.$parent.selected_activity_log = log;
		});
	}

	// Hack to prevent from log fields being sorted alphabetically
	$scope.keys = function(obj)
	{
		// Slicing off the last element because it is a $$hashKey
		return obj? Object.keys(obj).slice(0,-1) : [];
	}

	$scope.display_field = function(field)
	{
		field = field.replace(/_/g, " ");
		field = field.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
		return field;
	}

	$scope.refresh_activity_logs = function()
	{
		$scope.$parent.$apply(function () {
			$scope.filtered_activity_logs = [];
			$scope.activity_logs = [];
			$scope.activity_logs_offset = 0;
			$scope.ready_for_more_activity_log_entries = true;
			//setTimeout(function(){$scope.$parent.show_spinner="0";}, 300);
			$scope.show_spinner="0";
	});

		$scope.get_activity_logs();
	};

	$scope.refresh_users = function()
	{
		$scope.users = [];
		$scope.get_users(true);
	};

	$scope.file_upload_spinner = function(selector, flag, file)
	{
		var str = "";

		if (flag)
		{
				str='<span style="padding-right: 20px;">Uploading activity log file</span><i class="fa fa-spinner fa-spin"></i><br><br>';
		}

		angular.element(selector).html(str);
	};

	/*
	$scope.$watch('search', function(newValue, oldValue) {
	if (newValue != oldValue)
	{
		$scope.get_users();
	}
	});
	*/
	$scope.$watch('search', function(newValue, oldValue) {

		if ($scope.search_query_in_progress) {
			return;
		}

		if (newValue != oldValue) {
			$scope.get_users(true);
		}
	});
}

/* hack for dealing with stuff that Bootstrap 3.0 broke (directive not firing on button) */
function export_csv(report_type, data)
{
	var scope = angular.element($("#dashboard_controller")).scope();
	scope.export_csv(report_type, data);
}

/* hack for dealing with stuff that Bootstrap 3.0 broke (directive not firing on button) */
function refresh_activity_logs()
{
	var scope = angular.element($("#dashboard_controller")).scope();
	scope.refresh_activity_logs();
}

/* hack for dealing with stuff that Bootstrap 3.0 broke (directive not firing on button) */
function refresh_users()
{
	var scope = angular.element($("#dashboard_controller")).scope();
	scope.refresh_users();
}

/* hack for dealing with stuff that Bootstrap 3.0 broke (directive not firing on button) */
function set_show_dialog(type)
{
	var scope = angular.element($("#dashboard_controller")).scope();

		if (type === 'user')
		{
			scope.init_new_user();
		}
		scope.showDialog = true;
}

/* hack for dealing with stuff that Bootstrap 3.0 broke (directive not firing on button) */
function set_show_edit_dialog()
{
	var scope = angular.element($("#dashboard_controller")).scope();
	scope.showEditDialog = true;
}

/* hack for dealing with stuff that Bootstrap 3.0 broke (directive not firing on button) */
function set_show_info_dialog()
{
	var scope = angular.element($("#dashboard_controller")).scope();
	scope.showInfoDialog = true;
}

function set_show_confirm_delete_dialog()
{
	var scope = angular.element($("#dashboard_controller")).scope();
	scope.showConfirmDeleteDialog = true;
}


	<div class="panel panel-default" ng-model="users" load-users users-scroll>
		<div class="panel-heading">
			<div class="col-xs-6">
				<h1 class="panel-title"><i class="mr-modal-icon glyphicon glyphicon-cog"></i>Select User to Edit</h1>
			</div>
			<div class="pull-right col-xs-6">
				<div class="input-group input-group-sm">
					<div class="input-group-btn"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#add_user_modal" onclick="set_show_dialog('user');"><i class="glyphicon glyphicon-plus-sign"></i> Add User</button><button type="button" class="btn btn-default" ng-click="export_users();"><i class="glyphicon glyphicon-export"></i> Export CSV</button></div>
					<input type="text" class="form-control" placeholder="Search" ng-model="search" />
					<div class="input-group-btn input-group-sm"><button type="button" class="btn btn-default" onclick="refresh_users();"><i class="glyphicon glyphicon-refresh"></i></button></div>
				</div>
			</div>
			<div style="clear:both;"></div>
		</div><!--/.panel-heading-->
<?php $spinner = '<tr ng-model="ready_for_more_user_entries" ng-show="show_spinner==\'1\'"><td colspan="4"><i class="fa fa-spinner fa-spin fa-2x" style="text-align:center; width:100%"></i></td></tr>';
$args = array(
'ng_repeat' => 'user',
'spinner' => $spinner,
'type' => 'table',
'ng_model' => 'users',
'id' => 'uzers',
'ng_action' => 'data-toggle="modal" load-user data-target="#edit_user_modal"',
	'columns' => array(
		array('title' => 'Username', 'ng_data' => 'username'),
		array('title' => 'User Type', 'ng_data' => 'user_type_name'),
		array('title' => 'Login Enabled', 'ng_data' => 'login_enabled', 'data_type' => 'boolean'),
	));
build_data_panel($args); ?>
	</div>
	<!--/.panel-->
	<!-- Add User Modal -->
	<div modal-show modal-visible="showDialog" class="modal fade" id="add_user_modal" tabindex="-1" role="dialog" aria-labelledby="add_user_modal_label" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content" ng-model="new_user">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="add_user_moda_label">Add User</h4>
				</div>
				<div class="modal-body">
					<!--	 ==================== ADD FORM - START ============================= -->
					<form class="form-horizontal" role="form" autocomplete="off">
						<div class="form-group">
							<div class="col-sm-4">
								<label for="user_type_id" class="control-label">User Type:</label>
							</div>
							<div class="col-sm-4">
								<select class="form-control" ng-model="new_user.user_type_id" id="user_type_id" name="user_type_id" add-user-select-type-changed>
									<option value="-1">-- Select User Type --</option>
									<option ng-repeat="user_type in user_types" ng-cloak value="{{user_type.id}}">{{user_type.type_name}}</option>
								</select>
							</div>
						</div>

						<div class="form-group" ng-show="show_all_add_form_fields">
							<div class="col-sm-4">
								<label for="role_id" class="control-label">Course:</label>
							</div>
							<div class="col-sm-3">
								<select class="form-control" ng-model="new_user.role_id" id="role_id" name="role_id">
									<option value="-1">-- Select Course --</option>
									<option ng-repeat="role in roles" ng-cloak ng-selected value="{{role.id}}">{{role.role_name}}</option>
								</select>
							</div>
						</div>

						<div class="form-group" ng-show="show_all_add_form_fields">
							<div class="col-sm-4">
								<label for="accreditation_type_id" class="control-label">Desired Accreditation:</label>
							</div>
							<div class="col-sm-3">
								<select class="form-control" ng-model="new_user.accreditation_type_id" id="accreditation_type_id" name="accreditation_type_id">
									<option value="-1">-- Select Accreditation --</option>
									<option ng-repeat="accreditation_type in accreditation_types" ng-cloak ng-selected value="{{accreditation_type.id}}">{{accreditation_type.accreditation_type}}</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							 <div class="col-sm-4">
								 <label for="email_address" class="control-label">Email Address:</label>
								</div>
							<div class="col-sm-3">
								<input type="text" ng-model="new_user.email_address" class="form-control" id="email_address" name="email_address" placeholder="Email Address">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-4">
									<label for="first_name" class="control-label">Name:</label>
								</div>

								<div class="col-sm-2" >
									<input type="text" ng-model="new_user.first_name" class="form-control" id="first_name" name="first_name" placeholder="First Name">
								</div>
								<div class="col-sm-1" style="padding:0">
									<input type="text" ng-model="new_user.middle_initial" class="form-control" id="middle_initial" name="middle_initial" placeholder="MI">
								</div>
								<div class="col-sm-2" >
									<input type="text" ng-model="new_user.last_name" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
								</div>
						</div>

						<div class="form-group" ng-show="show_all_add_form_fields">
							 <div class="col-sm-4">
								 <label for="address_1" class="control-label">Address 1:</label>
								</div>
							<div class="col-sm-3">
								<input type="text" ng-model="new_user.address_1" class="form-control" id="address_1" name="address_1" placeholder="Address 1">
							</div>
						</div>

						<div class="form-group" ng-show="show_all_add_form_fields">
							 <div class="col-sm-4">
								 <label for="address_2" class="control-label">Address 2:</label>
								</div>
							<div class="col-sm-3">
								<input type="text" ng-model="new_user.address_2" class="form-control" id="address_2" name="address_2" placeholder="Address 2">
							</div>
						</div>

						<div class="form-group" ng-show="show_all_add_form_fields">
							<div class="col-sm-4">
								<label for="city_state_zip" class="control-label">City, State, Zip:</label>
							</div>
							<div class="col-sm-2" >
								<input type="text" ng-model="new_user.city" class="form-control" id="city" name="city" placeholder="City">
							</div>
							<div class="col-sm-2" style="padding:0;">
									<select class="form-control" ng-model="new_user.state_id" id="state_id" name="state_id">
										<option value="-1">-- Select State --</option>
											<option ng-repeat="state in states" ng-cloak ng-selected value="{{state.id}}">{{state.abbreviation}}</option>
									</select>
								</div>
								<div class="col-sm-2" >
									<input type="text" ng-model="new_user.zip" class="form-control" id="zip" name="Zip" placeholder="{{us_address_on_add_form ? 'Zip' : 'Postal Code'}}">
								</div>
						</div>

						<div class="form-group">
							<div class="col-sm-4">
								<label for="password" class="control-label">Password:</label>
							</div>
							<div class="col-sm-3">
								<input type="password" class="form-control" ng-model="new_user.password" id="password" name="password" placeholder="Password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-4">
								<label for="confirm_password" class="control-label">Confirm Password:</label>
							</div>
							<div class="col-sm-3">
								<input type="password" class="form-control" ng-model="new_user.confirm_password" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-4">
								<label for="login_endabled" class="control-label">Login Enabled:</label>
							</div>
							<div class="col-sm-4">
								<label for="login_enabled_yes" class="control-label">Yes&nbsp;</label><input type="radio" class="radio-inline2"	 ng-model="new_user.login_enabled" id="login_enabled_yes" name="login_enabled" value="1" checked="checked">
								<label for="login_enabled_no" class="control-label">&nbsp;&nbsp;No&nbsp;</label><input type="radio" class="radio-inline2" ng-model="new_user.login_enabled" id="login_enabled_no" name="login_enabled" value="0">
							</div>
							<div id="add_user_error_message">
							</div>
						</div>
					</form>
					<!--	==================== ADD FORM - END ============================= -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" add-new-user>Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- / Add User Modal -->

	<!-- Edit User Modal -->
	<div modal-show modal-visible="showEditDialog" class="modal fade" id="edit_user_modal" tabindex="-1" role="dialog" aria-labelledby="edit_user_modal_label" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content" ng-model="existing_user">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="edit_user_moda_label">Edit User: <strong>{{existing_user.username}}</strong></h4>
				</div>
				<div class="modal-body">
					<!--	==================== EDIT FORM - START ============================= -->
					<form class="form-horizontal" role="form" autocomplete="off">
						<div class="form-group">
							<div class="col-sm-4">
								<label for="user_type_id" class="control-label">User Type:</label>
							</div>
							<div class="col-sm-4">
								<select readonly="readonly" disabled="disabled" class="form-control" ng-model="existing_user.user_type_id" id="user_type_id" name="user_type_id" edit-user-select-type-changed>
									<option value="-1">-- Select User Type --</option>
									<option ng-repeat="user_type in user_types" ng-cloak value="{{user_type.id}}">{{user_type.type_name}}</option>
								</select>
							</div>
						</div>

						<div class="form-group"	 ng-show="show_all_edit_form_fields">
							<div class="col-sm-4">
								<label for="role_id" class="control-label">Course:</label>
							</div>
							<div class="col-sm-3">
								<select readonly="readonly" disabled="disabled" class="form-control" ng-model="existing_user.role_id" id="role_id" name="role_id">
								<option value="-1">-- Select Course --</option>
									<option ng-repeat="role in roles" ng-cloak ng-selected value="{{role.id}}">{{role.role_name}}</option>
								</select>
							</div>
						</div>

						<div class="form-group"	 ng-show="show_all_edit_form_fields">
							<div class="col-sm-4">
								<label for="accreditation_type_id" class="control-label">Desired Accreditation:</label>
							</div>
							<div class="col-sm-3">
								<select class="form-control" ng-model="existing_user.accreditation_type_id" id="accreditation_type_id" name="accreditation_type_id">
									<option value="-1">-- Select Accreditation --</option>
									<option ng-repeat="accreditation_type in accreditation_types" ng-cloak ng-selected value="{{accreditation_type.id}}">{{accreditation_type.accreditation_type}}</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-4">
									<label for="first_name" class="control-label">Name:</label>
								</div>

								<div class="col-sm-2" >
									<input type="text" ng-model="existing_user.first_name" class="form-control" id="first_name" name="first_name" placeholder="First Name">
								</div>
								<div class="col-sm-1" style="padding:0">
									<input type="text" ng-model="existing_user.middle_initial" class="form-control" id="middle_initial" name="middle_initial" placeholder="MI">
								</div>
								<div class="col-sm-2" >
									<input type="text" ng-model="existing_user.last_name" class="form-control" id="last_name" name="last_name" placeholder="Last Name">
								</div>
						</div>

						<div class="form-group" ng-show="show_all_edit_form_fields">
							 <div class="col-sm-4">
								 <label for="address_1" class="control-label">Address 1:</label>
								</div>
							<div class="col-sm-3">
								<input type="text" ng-model="existing_user.address_1" class="form-control" id="address_1" name="address_1" placeholder="Address 1">
							</div>
						</div>

						<div class="form-group" ng-show="show_all_edit_form_fields">
							 <div class="col-sm-4">
								 <label for="address_2" class="control-label">Address 2:</label>
								</div>
							<div class="col-sm-3">
								<input type="text" ng-model="existing_user.address_2" class="form-control" id="address_2" name="address_2" placeholder="Address 2">
							</div>
						</div>

						<div class="form-group" ng-show="show_all_edit_form_fields">
							<div class="col-sm-4">
									<label for="city_state_zip" class="control-label">City, State, Zip:</label>
								</div>
								<div class="col-sm-2" >
									<input type="text" ng-model="existing_user.city" class="form-control" id="city" name="city" placeholder="City">
								</div>
								<div class="col-sm-2" style="padding:0;">
									<select class="form-control" ng-model="existing_user.state_id" id="state_id" name="state_id">
										<option value="-1">-- Select State --</option>
											<option ng-repeat="state in states" ng-cloak ng-selected value="{{state.id}}">{{state.abbreviation}}</option>
									</select>
								</div>
								<div class="col-sm-2">
									<input type="text" ng-model="existing_user.zip" class="form-control" id="zip" name="Zip" placeholder="{{us_address_on_edit_form ? 'Zip' : 'Postal Code'}}">
								</div>
						</div>

						<div class="form-group">
							<div class="col-sm-4">
								<label for="password" class="control-label">Password:</label>
							</div>
							<div class="col-sm-3">
								<input type="password" class="form-control" ng-model="existing_user.password" id="password" name="password" placeholder="Password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-4">
								<label for="confirm_password" class="control-label">Confirm Password:</label>
							</div>
							<div class="col-sm-3">
								<input type="password" class="form-control" ng-model="existing_user.confirm_password" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-4">
								<label for="login_enabled" class="control-label">Login Enabled:</label>
							</div>
							<div class="col-sm-4">
								<label for="login_enabled_yes" class="control-label">Yes&nbsp;</label><input type="radio" class="radio-inline2"	 ng-model="existing_user.login_enabled" id="login_enabled_yes" name="login_enabled" value="1">
								<label for="login_enabled_no" class="control-label">&nbsp;&nbsp;No&nbsp;</label><input type="radio" class="radio-inline2" ng-model="existing_user.login_enabled" id="login_enabled_no" name="login_enabled" value="0">
							</div>
							<div id="edit_user_error_message">
							</div>
						</div>
					</form>
					<!--	==================== EDIT FORM - END ============================= -->
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-toggle="modal" data-target="#confirm_delete_user_modal" onclick="set_show_confirm_delete_dialog();">Delete User</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" edit-user>Save changes</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- / Edit User Modal -->

	<div modal-show modal-visible="showConfirmDeleteDialog" class="modal fade" id="confirm_delete_user_modal" tabindex="-1" role="dialog" aria-labelledby="confirm_delete_user_modal_label" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content" ng-model="existing_user">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="confirm_delete_user_modal_label">Are you sure?</h4>
				</div>
				<div class="modal-body">
					Are you sure you want to delete user: {{existing_user.username}}?
					<div id="delete_user_error_message">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" delete-user><i class="glyphicon glyphicon-trash"></i> Yes</button>
					<button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove" aria-hidden="true"></i> No</button>
				</div>
			</div>
		</div>
	</div><!-- / Confirm Delete User Modal -->


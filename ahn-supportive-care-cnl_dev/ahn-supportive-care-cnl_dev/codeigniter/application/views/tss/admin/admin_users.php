<div class="panel panel-default" ng-model="users" load-users>
		<div class="panel-heading">
			<div class="col-xs-4">
				<h1 class="panel-title">Select User To Edit</h1>
			</div>

			<div style="width:26%" class="input-group input-group-sm pull-right">
				<div class="input-group-btn">
					<button type="button" class="btn btn-default" data-toggle="modal" data-target="#add_user_modal" onclick="set_show_dialog('user');"><i class="glyphicon glyphicon-plus-sign"></i> Add User</button>
					<button type="button" class="btn btn-default" ng-click="export_csv('users', users);"><i class="glyphicon glyphicon-export"></i> Export CSV</button>
				</div>
				<input type="text" class="form-control" placeholder="Search" ng-model="search" />
				<div class="input-group-btn input-group-sm">
					<button type="button" class="btn btn-default" onclick="refresh_users();"><i class="glyphicon glyphicon-refresh"></i></button>
				</div>
			</div><!--/.input-group-->
			<div class="input-group input-group-sm pull-right" ng-repeat="level in organization_hierarchy.filter.levels.slice().reverse()">
				<select class="form-control" ng-model="organization_hierarchy.filter.selected_element_ids[level.organization_hierarchy_level_id]"
					ng-options="element.organization_hierarchy_level_element_id as element.organization_hierarchy_level_element_name for element in elements = get_filter_organization_hierarchy_level_elements(level)"
					ng-change="get_users();">
				</select>
			</div><!--/.input-group-->
			<div style="clear:both;"></div>
		</div><!--/.panel-heading-->
<?php $spinner = '<tr ng-model="ready_for_more_user_entries" ng-show="show_spinner==\'1\'"><td colspan="4"><i class="fa fa-spinner fa-spin fa-2x" style="text-align:center; width:100%"></i></td></tr>';
$args = array(
'ng_repeat' => 'user',
'spinner' => $spinner,
'type' => 'table',
'ng_model' => 'users',
'icon' => 'user',
'id' => 'uzers',
'ng_action' => 'data-toggle="modal" load-user data-target="#edit_user_modal"',
	'columns' => array(
		array('title' => 'Username', 'ng_data' => 'username'),
		array('title' => 'Organization', 'ng_data' => 'organization_name'),
		array('title' => 'User Type', 'ng_data' => 'user_type_name'),
		array('title' => 'Login Enabled', 'ng_data' => 'login_enabled', 'data_type' => 'boolean'),
	));
build_data_panel($args); ?>
	</div><!--/.panel-->
	<!-- Add User Modal -->
	<div modal-show modal-visible="showDialog" class="modal fade" id="add_user_modal" tabindex="-1" role="dialog" aria-labelledby="add_user_modal_label" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content" ng-model="new_user">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="add_user_modal_label">Add User</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" autocomplete="off">
						<div class="form-group">
							<label for="username" class="col-sm-4 control-label">Username:</label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" ng-model="new_user.username" class="form-control" id="username" name="username" placeholder="Username">
							</div>
						</div>
						<div class="form-group">
							<label for="user_type_name" class="col-sm-4 control-label">User Type:</label>
							<div class="col-sm-6">
								<select class="form-control" ng-model="new_user.user_type_id" ng-options="user_type.id as user_type.type_name for user_type in user_types" id="user_type_name" name="user_type_name"></select>
							</div>
						</div>
						<div class="form-group">
							<label for="organization" class="col-sm-4 control-label">Organization:</label>
							<div class="col-sm-6">
								<select class="form-control" ng-model="new_user.organization_id" ng-options="organization.id as organization.organization_name for organization in organizations" id="organization_name" name="organization"></select>
							</div>
						</div>
						<div ng-show="new_user.user_type_id != 4" class="form-group">
							<label for="password" class="col-sm-4 control-label">Password:</label>
							<div class="col-sm-6">
								<input type="password" autocomplete="off" class="form-control" ng-model="new_user.password" id="password" name="password" placeholder="Password">
							</div>
						</div>
						<div ng-show="new_user.user_type_id != 4" class="form-group">
							<label for="confirm_password" class="col-sm-4 control-label">Confirm Password:</label>
							<div class="col-sm-6">
								<input type="password" autocomplete="off" class="form-control" ng-model="new_user.confirm_password" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
							</div>
						</div>
						<div class="form-group">
							<label for="login_endabled" class="col-sm-4 control-label">Login Enabled:</label>
							<div class="col-sm-6">
								<label for="login_enabled_yes" class="control-label">Yes&nbsp;</label><input type="radio" class="radio-inline2"	 ng-model="new_user.login_enabled" id="login_enabled_yes" name="login_enabled" value="1" checked="checked">
								<label for="login_enabled_no" class="control-label">&nbsp;&nbsp;No&nbsp;</label><input type="radio" class="radio-inline2" ng-model="new_user.login_enabled" id="login_enabled_no" name="login_enabled" value="0">
							</div>
							<div id="add_user_error_message">
							</div>
						</div>
					</form>
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
					<h4 class="modal-title" id="edit_user_modal_label">Edit User</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label for="username" class="col-sm-4 control-label">Username:</label>
							<div class="col-sm-6 input-group">
								<input type="text" autocomplete="off" ng-model="existing_user.username" class="form-control" id="edit_user_username" name="username" placeholder="text" readonly="readonly">
							</div>
						</div>
					<?php if (LOGIN_BY_USERNAME_ENABLED) : ?>
						<div class="form-group">
							<label for="username" class="col-sm-4 control-label">Login Link:</label>
							<div class="col-sm-6 input-group">
								<input type="text" value="<?php echo site_url(); ?>~{{existing_user.username}}" class="form-control" name="clipboard-text" id="clipboard-text" readonly="readonly">
								<span class="input-group-addon">
									<span data-toggle="tooltip" class="tooltipLink" title="" data-original-title="This 'quick link' will log a user in automatically, bypassing the login page.">
										<i class="glyphicon glyphicon-info-sign"></i>
									</span>
								</span>
							</div>
						</div>
					<?php endif; ?>
						<div class="form-group">
							<label for="user_type" class="col-sm-4 control-label">User Type:</label>
							<div class="col-sm-6 input-group">
								<select class="form-control" ng-model="existing_user.user_type_id" ng-options="user_type.id as user_type.type_name for user_type in user_types" id="user_type_name" name="user_type_name"></select>
							</div>
						</div>
						<div class="form-group">
							<label for="organization" class="col-sm-4 control-label">Organization:</label>
							<div class="col-sm-6 input-group">
								<select class="form-control" ng-model="existing_user.organization_id" ng-options="organization.id as organization.organization_name for organization in organizations" id="edit_user_organization_name" name="organization"></select>
							</div>
						</div>
						<div ng-show="existing_user.user_type_id != 4" class="form-group">
							<label for="password" class="col-sm-4 control-label">Password:</label>
							<div class="col-sm-6 input-group">
								<input type="password" autocomplete="off" class="form-control" ng-model="existing_user.password" id="edit_user_password" name="password" placeholder="Password">
							</div>
						</div>
						<div ng-show="existing_user.user_type_id != 4" class="form-group">
							<label for="confirm_password" class="col-sm-4 control-label">Confirm Password:</label>
							<div class="col-sm-6 input-group">
								<input type="password" autocomplete="off" class="form-control" ng-model="existing_user.confirm_password" id="edit_user_confirm_password" name="confirm_password" placeholder="Confirm Password">
							</div>
						</div>
						<div class="form-group">
							<label for="login_endabled" class="col-sm-4 control-label">Login Enabled:</label>
							<div class="col-sm-6 input-group">
								<label for="login_enabled_yes" class="control-label">Yes&nbsp;</label><input type="radio" class="radio-inline2"	 ng-model="existing_user.login_enabled" id="edit_user_login_enabled_yes" name="login_enabled" value="1" ng-checked="{{existing_user.login_enabled==1}}">
								<label for="login_enabled_no" class="control-label">&nbsp;&nbsp;No&nbsp;</label><input type="radio" class="radio-inline2" ng-model="existing_user.login_enabled" id="edit_user_login_enabled_no" name="login_enabled" value="0" ng-checked="{{existing_user.login_enabled==1}}">
							</div>
							<div id="edit_user_error_message">
							</div>
						</div>
					</form>
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


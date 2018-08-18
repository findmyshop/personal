<div class="panel panel-default" load-my-user>
	<div class="panel-heading">
			<h1 class="panel-title">User Profile</h1>
	</div><!--/.panel-heading-->
	<div class="panel-body">
		<form class="form-horizontal" role="form">
			<div class="form-group">
				<label for="username" class="col-sm-4 control-label">Username:</label>
				<div class="col-sm-6">
					<input  type="input" autocomplete="off" disabled="disabled" ng-model="existing_user.username" class="form-control" id="edit_user_username" name="username" placeholder="Username" readonly="readonly">
				</div>
			</div>
			<div class="form-group">
				<label for="organization" class="col-sm-4 control-label">Organization:</label>
				<div class="col-sm-6">
					<select readonly="readonly" disabled="disabled" class="form-control" ng-model="existing_user.organization_name" id="edit_user_organization_name" name="organization">
						<option ng-repeat="organization in organizations" ng-cloak>{{organization.organization_name}}</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="user_type" class="col-sm-4 control-label">User Type:</label>
				<div class="col-sm-6">
					<select readonly="readonly" disabled="disabled" class="form-control" ng-model="existing_user.user_type_name" id="edit_user_user_type_name" name="user_type_name">
						<option ng-repeat="user_type in user_types" ng-cloak>{{user_type.type_name}}</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="col-sm-4 control-label">Current Password:</label>
				<div class="col-sm-6">
					<input type="password" autocomplete="off" class="form-control" ng-model="existing_user.current_password" id="edit_user_current_password" name="current_password" placeholder="Password">
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="col-sm-4 control-label">New Password:</label>
				<div class="col-sm-6">
					<input type="password" autocomplete="off" class="form-control" ng-model="existing_user.password" id="edit_user_password" name="password" placeholder="Password">
				</div>
			</div>
			<div class="form-group">
				<label for="confirm_password" class="col-sm-4 control-label">Confirm Password:</label>
				<div class="col-sm-6">
					<input type="password" autocomplete="off" class="form-control" ng-model="existing_user.confirm_password" id="edit_user_confirm_password" name="confirm_password" placeholder="Confirm Password">
				</div>
			</div>
			<!--<div class="form-group">
				<label for="login_endabled" class="col-sm-4 control-label">Login Enabled:</label>
				<div class="col-sm-6">
					<label for="login_enabled_yes" class="control-label">Yes&nbsp;</label><input type="radio" class="radio-inline2"	 ng-model="existing_user.login_enabled" id="edit_user_login_enabled_yes" name="login_enabled" value="1" ng-checked="{{existing_user.login_enabled==1}}">
					<label for="login_enabled_no" class="control-label">&nbsp;&nbsp;No&nbsp;</label><input type="radio" class="radio-inline2" ng-model="existing_user.login_enabled" id="edit_user_login_enabled_no" name="login_enabled" value="0" ng-checked="{{existing_user.login_enabled==1}}">
				</div>
				<div id="edit_user_error_message">
				</div>
			</div>-->
		</form>
	</div><!--/.panel-body-->
	<div class="panel-footer">
		<button type="button" class="btn btn-primary pull-right" edit-my-user><i class="glyphicon glyphicon-floppy-save"></i> Update Profile</button>
	<div style="clear:both;"></div>
	</div><!--/./panel-footer-->
</div><!--/.panel-->



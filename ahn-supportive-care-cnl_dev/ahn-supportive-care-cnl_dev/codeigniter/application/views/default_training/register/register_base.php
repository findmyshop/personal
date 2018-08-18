<div ng-controller="trainingRegistrationController" get-registration-form-data class="col-md-6 col-md-offset-3">
	<div id="mr-login-form" class="well mr-main-login">
	<div class="panel-heading"><h3 class="text-muted" id="mr-login-title">Sign Up</h3></div>
		<form autocomplete="off" class="form-signin panel-body" method="POST">
			<!--prevent autocomplete-->
			<input type="email" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" />
			<!--/prevent autocomplete-->
			<div class="form-group">
				<div class="input-group">
					<label for="role_id" title="Course" class="input-group-addon">Course</label>
					<select class="form-control" ng-model="new_user.role_id" ng-options="role.id as role.role_name for role in roles" id="role_id" name="role_id" autofocus></select>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<label for="accreditation_type_id" title="Desired Accreditation" class="input-group-addon">Desired Accreditation</label>
					<select class="form-control" ng-model="new_user.accreditation_type_id" ng-options="accreditation_type.id as accreditation_type.accreditation_type for accreditation_type in accreditation_types" id="accreditation_type_id" name="accreditation_type_id"></select>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<label for="email" title="Email" class="input-group-addon">Email:</label>
					<input ng-model="new_user.email" id="email" title="Email" name="email" type="text" class="form-control" placeholder="Email">
					<span class="input-group-addon">
						<span data-toggle="tooltip" class="tooltipLink" title="It is important to remember the email address you type here, as it will be required for future logins.">
							<i class="glyphicon glyphicon-info-sign"></i>
						</span>
					</span>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<label for="first_name" title="First Name" class="input-group-addon">First Name:</label>
					<input ng-model="new_user.first_name" id="first_name" title="First Name" name="first_name" type="text" class="form-control" placeholder="First Name">
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<label for="middle_initial" title="Last Name" class="input-group-addon">Middle Initial:</label>
					<input ng-model="new_user.middle_initial" id="middle_initial" title="Middle Initial" name="middle_initial" type="text" class="form-control" placeholder="Middle Initial">
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<label for="last_name" title="Last Name" class="input-group-addon">Last Name:</label>
					<input ng-model="new_user.last_name" id="last_name" title="Last Name" name="last_name" type="text" class="form-control" placeholder="Last Name">
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<label for="address_line_1" title="Address Line 1" class="input-group-addon">Address Line 1</label>
					<input ng-model="new_user.address_line_1" id="address_line_1" title="Address Line 1" name="address_line_1" type="text" class="form-control" placeholder="Address Line 1">
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<label for="address_line_2" title="Address Line 2" class="input-group-addon">Address Line 2</label>
					<input ng-model="new_user.address_line_2" id="address_line_2" title="Address Line 2" name="address_line_2" type="text" class="form-control" placeholder="Address Line 2">
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<label for="city" title="City" class="input-group-addon">City</label>
					<input ng-model="new_user.city" id="city" title="City" name="city" type="text" class="form-control" placeholder="City">
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<label for="state_id" title="State" class="input-group-addon">State</label>
					<select class="form-control" ng-model="new_user.state_id" ng-options="state.id as state.abbreviation for state in states" id="state_id" name="state_id"></select>
				</div>
			</div>
			<!--
			<div class="form-group">
				<div class="input-group">
					<label for="country_id" title="State" class="input-group-addon">Country</label>
					<select class="form-control" ng-model="new_user.country_id" ng-options="country.country_id as country.name for country in countries" id="country_id" name="country_id"></select>
				</div>
			</div>
			-->
			<div class="form-group">
				<div class="input-group">
					<label for="zip_code" title="Zip Code" class="input-group-addon">Zip Code:</label>
					<input ng-model="new_user.zip_code" id="zip_code" title="Zip Code" name="zip_code" type="text" class="form-control" placeholder="Zip Code">
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<label for="password" title="Password" class="input-group-addon">Password:</label>
					<input ng-model="new_user.password" id="password" title="Password" name="password" type="password" class="form-control" placeholder="Password">
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<label for="confirm_password" title="Confirm Password" class="input-group-addon">Confirm Password:</label>
					<input ng-model="new_user.confirm_password" id="confirm_password" title="Confirm Password" name="confirm_password" type="password" class="form-control" placeholder="Confirm Password">
				</div>
			</div>
			<button title="Sign In" class="btn btn-lg btn-primary btn-block" type="submit" add-user>Sign Up</button>
			<br/>
			<a class="pull-left" id="mr-login-back" href="javascript:MR.utils.link('login');"><i class="glyphicon glyphicon-chevron-left"></i> Go Back</a>
		</form>
	</div>
</div>


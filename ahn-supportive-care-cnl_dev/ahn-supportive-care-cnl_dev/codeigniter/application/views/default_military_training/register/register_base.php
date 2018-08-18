<div ng-model="new_user" load-select-control-data>
	<div class="panel panel-default registration-panel">
			<div class="panel-heading">
				<div class="row">
				<div class="col-xs-12">
				 <h1 class="panel-title">User Registration</h1>
			</div>
			</div>
		</div>
		<div class="panel-body">
			<div role="tabpanel">
			<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li id="registration-tab-1" role="presentation" class="registration-tab" ng-class="{active:highest_tab_visited>=1}"><a href="#registration-panel-1" aria-controls="registration-panel-1" role="tab" data-toggle="tab" registration-tab-clicked tab-number="1" ng-show="highest_tab_visited>=1">Select Service Branch</a></li>
					<li id="registration-tab-2" role="presentation" class="registration-tab"><a href="#registration-panel-2" aria-controls="registration-panel-2" role="tab" data-toggle="tab" registration-tab-clicked tab-number="2" ng-show="highest_tab_visited>=2">Select Accreditation</a></li>
					<li id="registration-tab-3" role="presentation" class="registration-tab"><a href="#registration-panel-3" aria-controls="registration-panel-3" role="tab" data-toggle="tab" registration-tab-clicked tab-number="3" ng-show="highest_tab_visited>=3">Enter User Information</a></li>
					<li id="registration-tab-4" role="presentation" class="registration-tab"><a href="#registration-panel-4" aria-controls="registration-panel-4" role="tab" data-toggle="tab" registration-tab-clicked tab-number="4" ng-show="highest_tab_visited>=4">Enter Mail Addresses</a></li>
					<li id="registration-tab-5" role="presentation" class="registration-tab"><a href="#registration-panel-5" aria-controls="registration-panel-5" role="tab" data-toggle="tab" registration-tab-clicked tab-number="5" ng-show="highest_tab_visited>=5">Review and Submit</a></li>
					<li id="registration-tab-6" role="presentation" class="registration-tab"><a href="#registration-panel-6" aria-controls="registration-panel-6" role="tab" data-toggle="tab" registration-tab-clicked tab-number="6" ng-show="highest_tab_visited>=6">Review and Submit</a></li>
				</ul>
			</div>
			<!-- Tab panes -->
			<div class="tab-content" style="margin-top:15px;">
			<!-- REG PANEL #1 -->
				<div id="registration-panel-1" role="tabpanel" class="tab-pane active">
					<div class="panel panel-default">
						<div class="panel-heading"><div style="float: right; text-align:right;">(Step {{current_tab}} of 5)</div>For which Service (or National Capital Region enhanced Multi-Service Market) do you work?</div>
						<div class="registration-form">
							<form name="registration-panel-1-form" novalidate>
								<table class="table table-striped">
									<tr>
										<td class="row-label">
											Service Branch or National Capital Multi-Service Market:
										</td>
										<td class="req-label">
											<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
										</td>
										<td>
											<select class="form-control" ng-model="new_user.department_id" id="department_id" name="department_id" add_department_changed ng-required="true" ng-pattern="/[0-9]{1,3}/">
												<option value="-1" ng-show="!add_department_changed_called">-- Select Branch or Service Market --</option>
												<option ng-repeat="department in departments" ng-cloak ng-selected value="{{department.id}}">{{department.department_name}}</option>
											</select>
										</td>
										<td>
											<span class="glyphicon glyphicon-ok" aria-hidden="true" ng-show="new_user.department_id!=-1" ng-cloak></span>
											<span class="glyphicon glyphicon-warning-sign" aria-hidden="true" ng-show="add_department_changed_called&&(new_user.department_id==-1)" ng-cloak></span>
										</td>
									</tr>
								</table>
							</form>
						</div>
					</div>
				</div>
				<div id="registration-panel-2" role="tabpanel" class="tab-pane" id="profile" class="tab-pane active">
					<div class="panel panel-default">
						<div class="panel-heading"><div style="float: right; text-align:right;">(Step {{current_tab}} of 5)</div>Select Your Desired Accreditation for Continuing Education</div>
							<div class="registration-form">
								<form name="registration-panel-2-form" novalidate>
								<table class="table table-striped">
									<tr>
										<td class="row-label">
											Desired Accreditation:
										</td>
										<td class="req-label">
											<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
										</td>
										<td>
											<select class="form-control" ng-model="new_user.accreditation_type_id" id="accreditation_type_id" name="accreditation_type_id" add-accreditation-type-changed>
												<option value="-1" ng-show="!add_accreditation_type_changed_called">-- Select Accreditation --</option>
												<option ng-repeat="accreditation_type in accreditation_types" ng-cloak ng-selected value="{{accreditation_type.id}}">{{accreditation_type.accreditation_type}}</option>
											</select>
										</td>
										<td>
												<span class="glyphicon glyphicon-ok" aria-hidden="true" ng-show="new_user.accreditation_type_id!=-1"></span>
												<span class="glyphicon glyphicon-warning-sign" aria-hidden="true" ng-show="$scope.add_accreditation_type_changed_called&&(new_user.accreditation_type_id)==-1"></span>
										</td>
									</tr>
								</table>
							</form>
						</div>
					</div>
				</div>
				<div id="registration-panel-3" role="tabpanel" class="tab-pane" id="messages" class="tab-pane active">
					<div class="panel panel-default">
						<div class="panel-heading"><div style="float: right; text-align:right;">(Step {{current_tab}} of 5)</div>Enter User Information</div>
							<div class="registration-form">
								<form name="registration_panel_3_form" novalidate>
									<table class="table table-striped">
											<td class="row-label">
												Name:
											</td>
											<td class="req-label">
												<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
											</td>
											<td width="45%">
											<table>
												<tr>
												<td>
													<input type="input" ng-model="new_user.first_name" class="form-control" id="first_name" name="first_name" placeholder="First Name" required ng-minlength="1">
												</td>
												<td width="15%" style="padding-left:4px;padding-right:4px;">
													<input type="input" ng-model="new_user.middle_initial" class="form-control" id="middle_initial" name="middle_initial" placeholder="MI">
												</td>
												<td>
													<input type="input" ng-model="new_user.last_name" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required ng-minlength="1">
												</td>
												</tr>
												</table>
											</td>
											<td>
												<span class="glyphicon glyphicon-ok" aria-hidden="true" ng-show="!registration_panel_3_form.first_name.$invalid&&!registration_panel_3_form.last_name.$invalid"></span>
												<span class="glyphicon glyphicon-warning-sign" aria-hidden="true" ng-show="(registration_panel_3_form.first_name.$invalid||registration_panel_3_form.last_name.$invalid)&&((new_user.first_name!='')&&(new_user.last_name!=''))"></span>
											</td>
										</tr>
										<tr>
											<td class="row-label">
												DoD #:
											</td>
											<td class="req-label">
												<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
											</td>
											<td>
												<input type="input" ng-model="new_user.dod_number" class="form-control" id="dod_number" name="dod_number" placeholder="DOD #" ng-pattern="/^[0-9]{10,10}$/" ng-minlength="10" ng-maxlength="10" required>
											</td>
											<td>
												<span class="glyphicon glyphicon-ok" aria-hidden="true" ng-show="registration_panel_3_form.dod_number.$valid"></span>
												<span class="glyphicon glyphicon-warning-sign" aria-hidden="true" ng-show="registration_panel_3_form.dod_number.$dirty&&registration_panel_3_form.dod_number.$invalid"></span>
												<span ng-show="registration_panel_3_form.dod_number.$error.required||registration_panel_3_form.dod_number.$error.pattern"> (Enter the 10-digit number found on the back of your CAC)</span>
											</td>
										</tr>
									<tr>
										<td class="row-label">
											Role:
										</td>
										<td class="req-label">
											<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
										</td>
										<td>
											<select class="form-control" ng-model="new_user.role_id" id="role_id" name="role_id" hide-select-prompt-option="role_select_prompt" ng-change="set_selection_text('role_id')">
												<option id="role_select_prompt" value="-1">-- Select Role --</option>
												<option ng-repeat="role in roles" ng-cloak ng-selected value="{{role.id}}">{{role.role_name}}</option>
											</select>
										</td>
										<td>
											<span class="glyphicon glyphicon-ok" aria-hidden="true" ng-show="new_user.role_id!=-1"></span>
										</td>
									</tr>
									<tr>
										<td class="row-label">
											Pay Grade:
										</td>
										<td class="req-label">
											<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
										</td>
										<td>
											<select class="form-control" ng-model="new_user.pay_grade_id" id="pay_grade_id" name="pay_grade_id" hide-select-prompt-option="pay_grade_select_prompt" ng-change="set_selection_text('pay_grade_id')">
												<option id="pay_grade_select_prompt" value="-1">-- Select Pay Grade --</option>
												<option ng-repeat="pay_grade in pay_grades" ng-cloak ng-selected value="{{pay_grade.id}}">{{pay_grade.pay_grade_name}}</option>
											</select>
										</td>
										<td>
											<span class="glyphicon glyphicon-ok" aria-hidden="true" ng-show="new_user.pay_grade_id!=-1"></span>
										</td>
									</tr>
									<tr>
										<td class="row-label">
											Treatment Facility:
										</td>
										<td class="req-label">
											<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
										</td>
										<td>
											<select class="form-control" ng-model="new_user.treatment_facility_id" id="treatment_facility_id" name="treatment_facility_id" hide-select-prompt-option="treatment_facility_select_prompt" ng-change="set_selection_text('treatment_facility_id')">
												<option id="treatment_facility_select_prompt" value="-1">-- Select Treatment Facility --</option>
												<option ng-repeat="treatment_facility in treatment_facilities" ng-cloak ng-selected value="{{treatment_facility.id}}">{{treatment_facility.department_name}} - {{treatment_facility.treatment_facility}}</option>
											</select>
										</td>
										<td>
											<span class="glyphicon glyphicon-ok" aria-hidden="true" ng-show="new_user.treatment_facility_id!=-1"></span>
										</td>
									</tr>
									<tr>
										<td class="row-label">
											Password:
										</td>
										<td class="req-label">
											<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
										</td>
										<td>
											<input type="password" class="form-control" ng-model="new_user.password" id="password" name="password" autocomplete="off" placeholder="Password" ng-minlength="6" required>
										</td>
										<td>
											<span class="glyphicon glyphicon-ok" aria-hidden="true" ng-show="registration_panel_3_form.password.$valid"></span>
											<span class="glyphicon glyphicon-warning-sign" aria-hidden="true" ng-show="registration_panel_3_form.password.$dirty&&registration_panel_3_form.password.$invalid"></span>
											<span ng-show="registration_panel_3_form.password.$error.required||registration_panel_3_form.password.$error.minlength">(Must be at least six characters long)</span>
										</td>
									</tr>
									<tr>
										<td class="row-label">
											Confirm Password:
										</td>
										<td class="req-label">
											<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
										</td>
										<td>
											<input type="password" class="form-control" ng-model="new_user.confirm_password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" ng-minlength="6" required />
										</td>
										<td>
											<span class="glyphicon glyphicon-ok" aria-hidden="true" ng-show="!registration_panel_3_form.confirm_password.$error.required&&!registration_panel_3_form.confirm_password.$error.minlength&&(new_user.password==new_user.confirm_password)"></span>
											<span class="glyphicon glyphicon-warning-sign" aria-hidden="true" ng-show="registration_panel_3_form.confirm_password.$invalid||(new_user.password!=new_user.confirm_password)"></span>
											<span ng-show="registration_panel_3_form.confirm_password.$dirty&&registration_panel_3_form.confirm_password.$invalid&&(new_user.password!=new_user.confirm_password)">(Entry for Confirm Password does not match entry for Password)</span>
										</td>
									</tr>
								</table>
							</form>
						</div>
					</div>
				</div>
				<!-- REG PANEL #4 -->
				<div id="registration-panel-4" role="tabpanel" class="tab-pane" id="settings" class="tab-pane active">
					<div class="panel panel-default">
						<div class="panel-heading"><div style="float: right; text-align:right;">(Step {{current_tab}} of 5)</div>Enter Your Email Address</div>
							<div class="registration-form">
								<form name="registration_panel_4_form" novalidate>
								<table class="table table-striped">
									<tr>
										<td class="row-label">
											Email Address:
										</td>
										<td class="req-label">
											<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
										</td>
										<td>
											<input type="email" ng-model="new_user.email_address" class="form-control" id="email_address" name="email_address" placeholder="Email Address" required />
										</td>
										<td>
											<span class="glyphicon glyphicon-ok" aria-hidden="true" ng-show="!registration_panel_4_form.email_address.$invalid"></span>
											<span class="glyphicon glyphicon-warning-sign" aria-hidden="true" ng-show="registration_panel_4_form.email_address.$dirty&&registration_panel_4_form.email_address.$invalid"></span>
											</span>
										</td>
									</tr>
									<tr>
										<td class="row-label">
											Country:
										</td>
										<td class="req-label">
											<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
										</td>
										<td>
											<select class="form-control" ng-model="new_user.country_id" id="country_id" name="country_id" add-user-country-changed hide-select-prompt-option="county_select_prompt">
												<option id="county_select_prompt" value="-1">-- Select Country --</option>
												<option ng-repeat="country in countries" ng-cloak ng-selected value="{{country.country_id}}">{{country.name}}</option>
											</select>
										</td>
										<td>
											<span class="glyphicon glyphicon-ok" aria-hidden="true" ng-show="new_user.country_id!=-1"></span>
										</td>
									</tr>
									<tr>
										<td class="row-label">
											Street Address 1:
										</td>
										<td class="req-label">
											<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
										</td>
										<td>
											<input type="input" ng-model="new_user.address_1" class="form-control" id="address_1" name="address_1" placeholder="Address 1" required ng-minlength="3">
										</td>
										<td>
											<span class="glyphicon glyphicon-ok" aria-hidden="true" ng-show="!registration_panel_4_form.address_1.$invalid"></span>
											<span class="glyphicon glyphicon-warning-sign" aria-hidden="true" ng-show="registration_panel_4_form.address_1.$dirty&&registration_panel_4_form.address_1.$invalid"></span>
										</td>
									</tr>
									<tr>
										<td class="row-label">
											Street Address 2:
										</td>
										<td class="req-label">

										</td>
										<td>
											<input type="input" ng-model="new_user.address_2" class="form-control" id="address_2" name="address_2" placeholder="Address 2" required />
										</td>
										<td>
											<span class="glyphicon glyphicon-ok" aria-hidden="true" ng-show="!registration_panel_4_form.address_2.$invalid"></span>
										</td>
									</tr>
									<tr>
										<td class="row-label">
											City:
										</td>
										<td class="req-label">
											<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
										</td>
										<td>
											<input type="input" ng-model="new_user.city" class="form-control" id="city" name="city" placeholder="City" required ng-minlength="3" />
										</td>
										<td>
											<span class="glyphicon glyphicon-ok" aria-hidden="true" ng-show="!registration_panel_4_form.city.$invalid"></span>
											<span class="glyphicon glyphicon-warning-sign" aria-hidden="true" ng-show="registration_panel_4_form.city.$dirty&&registration_panel_4_form.city.$invalid"></span>
										</td>
									</tr>
									<tr>
										<td class="row-label">
											<span ng-show="us_address_on_add_form">State/APO:</span><span ng-show="!us_address_on_add_form">Province:</span>
										</td>
										<td class="req-label">
											<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
										</td>
										<td>
											<div ng-show="us_address_on_add_form">
												<select class="form-control" ng-model="new_user.state_id" id="state_id" name="state_id" ng-change="set_selection_text('state_id')">
													<option value="-1">-- Select State --</option>
													<option ng-repeat="state in states" ng-cloak ng-selected value="{{state.id}}">{{state.abbreviation}}</option>
												</select>
											</div>
											<div ng-show="!us_address_on_add_form">
												<input type="input" ng-model="new_user.province" class="form-control" id="province" name="province" placeholder="Province" ng-minlength="1" required>
											</div>
										</td>
										<td>
											<span class="glyphicon glyphicon-ok" aria-hidden="true" ng-show="!registration_panel_4_form.province.$invalid||(new_user.state_id!=-1)"></span>
											<span class="glyphicon glyphicon-warning-sign" aria-hidden="true" ng-show="(registration_panel_4_form.province.$dirty||registration_panel_4_form.state_id.$dirty)&&registration_panel_4_form.province.$invalid&&(new_user.state_id==-1)"></span>
										</td>
									</tr>
									<tr>
										<td class="row-label">
											<span ng-show="us_address_on_add_form">Zip:</span><span ng-show="!us_address_on_add_form">Postal Code:</span>
										</td>
										<td class="req-label">
											<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
										</td>
										<td>
											<input type="input" ng-model="new_user.zip" class="form-control" id="zip" name="zip" placeholder="{{us_address_on_add_form ? 'Zip' : 'Postal Code'}}" ng-minlength="5" required>
										</td>
										<td>
											<span class="glyphicon glyphicon-ok" aria-hidden="true" ng-show="!registration_panel_4_form.zip.$invalid"></span>
											<span class="glyphicon glyphicon-warning-sign" aria-hidden="true" ng-show="registration_panel_4_form.zip.$dirty&&registration_panel_4_form.zip.$invalid"></span>
										</td>
									</tr>
								</table>
							</form>
						</div>
					</div>
				</div>
				<!-- REG PANEL #5 -->
				<div id="registration-panel-5" role="tabpanel" class="tab-pane active">
					<div class="panel panel-default">
						<div class="panel-heading"><div style="float: right; text-align:right;">(Step {{current_tab}} of 5)</div>Review Your Information and Submit Your Registration</div>
						<div class="registration-form">
								<form name="registration_panel_5_form" novalidate>
								<table class="table table-striped">
									<tr>
										<td class="row-label">Service Branch or National Capital Multi-Service Market:</td>
										<td>{{selected_department_text}}</td>
										<td><button class="btn btn-default" set-registration-panel="1"><i class="glyphicon glyphicon-pencil"></i> edit</button></td>
									</tr>
									<tr>
										<td class="row-label">Desired Accreditation:</td>
										<td>{{selected_accreditation_type_text}}</td>
										<td><button class="btn btn-default" set-registration-panel="2"><i class="glyphicon glyphicon-pencil"></i> edit</button></td>
									</tr>
									<tr>
										<td class="row-label">Name:</td>
										<td>{{new_user.first_name}} {{new_user.middle_initial}} {{new_user.last_name}}</td>
										<td><button class="btn btn-default" set-registration-panel="3"><i class="glyphicon glyphicon-pencil"></i> edit</button></td>
									</tr>
										<td class="row-label">DoD Number:</td>
										<td>{{new_user.dod_number}}</td>
										<td><button class="btn btn-default" set-registration-panel="3"><i class="glyphicon glyphicon-pencil"></i> edit</button></td>
									</tr>
									<tr>
										<td class="row-label">Role:</td>
										<td>{{selected_role_text}}</td>
										<td><button class="btn btn-default" set-registration-panel="3"><i class="glyphicon glyphicon-pencil"></i> edit</button></td>
									</tr>
									<tr>
										<td class="row-label">Pay Grade:</td>
										<td>{{selected_pay_grade_text}}</td>
										<td><button class="btn btn-default" set-registration-panel="3"><i class="glyphicon glyphicon-pencil"></i> edit</button></td>
									</tr>
									<tr>
										<td class="row-label">Treatment Facility:</td>
										<td>{{selected_treatment_facility_text}}</td>
										<td><button class="btn btn-default" set-registration-panel="3"><i class="glyphicon glyphicon-pencil"></i> edit</button></td>
									</tr>
									<tr>
										<td class="row-label">Email Address:</td>
										<td>{{new_user.email_address}}</td>
										<td><button class="btn btn-default" set-registration-panel="4"><i class="glyphicon glyphicon-pencil"></i> edit</button></td>
									</tr>
									<tr>
										<td class="row-label">Country:</td>
										<td>{{selected_country_text}}</td>
										<td><button class="btn btn-default" set-registration-panel="4"><i class="glyphicon glyphicon-pencil"></i> edit</button></td>
									</tr>
									<tr>
										<td class="row-label">Street Address 1:</td>
										<td>{{new_user.address_1}}</td>
										<td><button class="btn btn-default" set-registration-panel="4"><i class="glyphicon glyphicon-pencil"></i> edit</button></td>
									</tr>
									<tr>
										<td class="row-label">Street Address 2:</td>
										<td>{{new_user.address_2}}</td>
										<td><button class="btn btn-default" set-registration-panel="4"><i class="glyphicon glyphicon-pencil"></i> edit</button></td>
									</tr>
									<tr>
										<td class="row-label">City:</td>
										<td>{{new_user.city}}</td>
										<td><button class="btn btn-default" set-registration-panel="4"><i class="glyphicon glyphicon-pencil"></i> edit</button></td>
									</tr>
									<tr	 ng-show="new_user.country_id==230">
										<td class="row-label">State/Province:</td>
										<td>{{selected_state_text}}</td>
										<td><button class="btn btn-default" set-registration-panel="4"><i class="glyphicon glyphicon-pencil"></i> edit</button></td>
									</tr>
									<tr ng-show="new_user.country_id!=230">
										<td class="row-label">Province:</td>
										<td>{{new_user.province}}</td>
										<td><button class="btn btn-default" set-registration-panel="4"><i class="glyphicon glyphicon-pencil"></i> edit</button></td>
									</tr>
									<tr>
										<td class="row-label">Zip/Postal Code:</td>
										<td>{{new_user.zip}}</td>
										<td><button class="btn btn-default" set-registration-panel="4"><i class="glyphicon glyphicon-pencil"></i> edit</button></td>
									</tr>
									<tr ng-show="show_registration_failure_message">
										<td colspan="3" style="text-align: center;">
											<p style="text-align: center; color: red;" ng-bind-html="registration_failure_message | unsafe"></p>
											<p>Please correct the problem and re-submit</p>
										</td>
									</tr>
								</table>
								</form>
							</div>
						</div>
					</div>
					<!-- REG PANEL #6 THE SUCCESS PANEL -->
					<div id="registration-panel-6" role="tabpanel" class="tab-pane active">
						<div class="panel panel-default ">
							<div class="panel-heading">Registration Succeeded</div>
								<div class="registration-form" style="padding:20px; text-align:center;">
										<h2 style="margin:20px 0px 30px 0px; color:green;">Congratulations!</h2>
										<p>You have successfully registered and have been assigned the following course: <strong>{{default_course.course_name}}!</strong> <br/>You can access your AlcoholSBIRT account by visiting:<br/><a href="http://<?=$_SERVER['HTTP_HOST']?>">http://<?=$_SERVER['HTTP_HOST']?></a>.</p>
										<p>When the site loads, you will be asked to provide a username and a password.<br/><small><em>(Use the password that you entered during registration.)</em></small></p>
										<p><strong>Your username is:</strong></p>
										<div class="well" style="display:inline-block; width:auto;">
											 <h3 style="margin:0;">{{new_user.username}}</h3>
										</div>
										<div style="padding:20px;">
											<a href="/" class="btn btn-primary btn-lg">Proceed to Course <i class="glyphicon glyphicon-chevron-right" aria-hidden="true"></i></a>
										</div>
								</div>
							</div>
					</div>
					<div>(<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>) Denotes required field</div>
				</div>
				<nav>
					<ul class="pager">
						<li ng-show="current_tab<=1" class="previous">
							<a class="registration-previous-button pull-left btn btn-default" name="back-to-panel-1" href="/login"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>&nbsp;Back to Login</a>
						</li>
						<li ng-show="show_previous_button" class="previous">
							<button class="registration-previous-button pull-left btn btn-default" name="back-to-panel-1" previous-clicked><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>&nbsp;Previous</button>
						</li>
						<li ng-show="current_tab<=highest_tab_validated" class="next">
							<button class="registration-continue-button pull-right btn btn-default" name="continue-to-panel-2" continue-clicked>Next&nbsp;<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button>
						</li>
						<li ng-show="!registration_panel_3_form.first_name.$invalid
						&&!registration_panel_3_form.last_name.$invalid
						&&!registration_panel_3_form.dod_number.$error.required
						&&!registration_panel_3_form.dod_number.$error.pattern
						&&!registration_panel_3_form.dod_number.$error.dod_number
						&&!registration_panel_3_form.dod_number.$error.dod_number
						&&new_user.role_id!=-1
						&&new_user.pay_grade_id!=-1
						&&new_user.treatment_facility_id!=-1
						&&!registration_panel_3_form.password.$error.required
						&&!registration_panel_3_form.password.$error.minlength
						&&!registration_panel_3_form.confirm_password.$error.required
						&&!registration_panel_3_form.confirm_password.$error.minlength
						&&(new_user.password==new_user.confirm_password)
						&&(highest_tab_validated<3)
						" class="next">
						<button class="registration-continue-to-panel-4-button pull-right btn btn-default" name="continue-to-panel-2" continue-clicked><span ng-show="true||current_tab<=highest_tab_validated">Proceed to Next Step&nbsp;<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></span></button>
						</li>
						<li ng-show="!registration_panel_4_form.email_address.$invalid
						&&new_user.country_id!=-1
						&&!registration_panel_4_form.address_1.$invalid
						&&!registration_panel_4_form.city.$invalid
						&&(!registration_panel_4_form.province.$invalid||(new_user.state_id!=-1))
						&&!registration_panel_4_form.zip.$invalid
						&&(highest_tab_validated<4)" class="next">
						<button class="registration-continue-to-panel-4-button pull-right btn btn-default" name="continue-to-panel-2" continue-clicked><span ng-show="true||current_tab<=highest_tab_validated">Review and Submit&nbsp;<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></span></button>
						</li>
						<li ng-show="current_tab==5" class="next">
							<button class="registration-submit-button pull-right btn btn-default" name="submit-registration" add-new-user><span>Submit Registration&nbsp;<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></span></button>
						</li>
					</ul>
				</nav>
		</div>
	</div>
</div>

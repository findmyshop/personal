<div ng-controller="registrationController" class="col-md-8 col-md-offset-2">
	<div id="mr-login-form" class="well mr-main-login">
	<div class="panel-heading"><h3 class="text-muted" id="mr-login-title">Sign Up</h3></div>
		<div class="col-sm-6" style="margin-top:14px; padding:0;">
			<div class="well" style="background:#FEFEFE; margin-bottom:0;">
				<strong>Disclaimer:</strong><br/><br/>
				This site is being hosted by Decision Partners, an independent third-party research and strategy company hired by Enersource. Decision Partners will produce a summary report of all the feedback collected.  The report will not identify anyone as the source of any feedback. Decision Partners will provide a separate list of customers who have completed the 11 Core Questions, along with their contact information, for entry into the draw. If you would like more information on Decision Partners’ Privacy Policy, you can click on the link in the resource section of the program.
			</div>
		</div>
		<div class="col-sm-6" style="padding:0;">
		<form autocomplete="off" class="form-signin panel-body" method="POST">
			<!--prevent autocomplete-->
			<input type="email" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" />
			<!--/prevent autocomplete-->
			<div class="alert alert-info" role="alert"><strong>Note:</strong> The contest ended <strong>11:59 p.m. EST on December 23, 2015</strong>. New sign-ups will <strong>not</strong> be entered in the drawing.</div>
			<div class="btn-group btn-group-justified form-group" data-toggle="buttons">
				<label class="btn active btn-default">
					<input is-customer-radio-button ng-model="new_user.is_customer" name="is_customer_1" id="is_customer_1" value="1" type="radio">Customer
				</label>
				<label class="btn btn-default">
					<input is-customer-radio-button ng-model="new_user.is_customer" name="is_customer_0" id="is_customer_0" value="0" type="radio">Guest
				</label>
			</div>
			<div class="form-group" ng-if="new_user.is_customer == 1">
				<div class="input-group">
					<label for="customer_type" title="Customer Type" class="input-group-addon">Type:</label>
					<select ng-model="new_user.customer_type" class="form-control">
						<option>Residential Customer</option>
						<option>Non-Residential Customer</option>
						<option>Large Use Customer</option>
					</select>
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
					<label for="postal_code" title="Postal Code" class="input-group-addon">Postal Code:</label>
					<input ng-model="new_user.postal_code" id="postal_code" title="Postal Code" name="postal_code" type="text" class="form-control" placeholder="Postal Code">
				</div>
			</div>
			<!-- <div class="checkbox">
				<label>
					<input name="agree" id="r-agree" type="checkbox" value="agree" /> I'm an Enersource Customer, I accept the <a href="javascript:MR.modal.show('#contest-rules');">terms and conditions</a> and would like to enter the drawing.
				</label>
			</div> -->
			<?php if (LOGIN_CAPTCHA) : ?>
			<div class="form-group">
				<div class="g-recaptcha" data-sitekey="6LdyhQwTAAAAAK20RjSdeCjp7FPIgBpWeV-L-DoF"></div>
			</div>
			<?php endif; ?>
		<button id="sign-up-btn" title="Sign In" class="btn btn-lg btn-primary btn-block" type="submit" add-user>Sign Up</button>
	</form>
	</div><!--/.col-->
		<a class="pull-left" id="mr-login-back" href="javascript:MR.utils.link('login');"><i class="glyphicon glyphicon-chevron-left"></i> Go Back</a>
	<div style="clear:both;"></div>
</div>
</div>


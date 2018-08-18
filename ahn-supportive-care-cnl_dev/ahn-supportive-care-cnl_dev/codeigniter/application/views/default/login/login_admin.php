<div class="col-md-6 col-md-offset-3">
	<div id="mr-login-form" class="well mr-main-login">
	<div class="panel-heading"><h3 class="text-muted" id="mr-login-title">Sign In</h3></div>
		<form autocomplete="off" class="form-signin panel-body" method="POST" onsubmit="return false">
			<!--prevent autocomplete-->
			<input type="text" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" />
			<input type="password" name="password_fake" id="password_fake" value="" style="display:none;" />
			<!--/prevent autocomplete-->
			<div class="form-group">
				<div class="input-group input-group-lg">
					<label for="username" title="Username" class="input-group-addon"><i class="glyphicon glyphicon-user"></i></label>
					<input id="username" title="Username" name="username" type="text" autocomplete="off" class="form-control" placeholder="Username" required autofocus >
					<span class="input-group-addon">
						<span data-toggle="tooltip" class="tooltipLink" title="Enter your username into the box">
							<i class="glyphicon glyphicon-info-sign"></i>
						</span>
					</span>
				</div>
			</div>
			<div id="mr-password" class="form-group">
				<div class="input-group input-group-lg">
					<label for="password" title="Password" class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></label>
					<input id="password" title="Password" name="password" type="password" autocomplete="off" class="form-control" placeholder="Password">
				</div>
			</div>
			<div id="login_error_message"></div>
		<button title="Sign In" class="btn btn-lg btn-primary btn-block" type="submit" id="mr-sign-in" onclick="MR.login.do_login();">Sign in</button>

		<br/>
		<a class="pull-left" id="mr-login-forgot" href="javascript:MR.utils.link('login/forgot_password');"><i class="glyphicon glyphicon-lock"></i> Forgot Password?</a>
	</form>
</div>
</div>
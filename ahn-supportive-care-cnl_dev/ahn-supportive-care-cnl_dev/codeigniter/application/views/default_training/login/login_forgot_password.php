<div class="col-md-6 col-md-offset-3">
	<div id="mr-login-form" class="well mr-forgot-login">
	<div class="panel-heading"><h3 class="text-muted" id="mr-login-title">Forgot Password</h3></div>
		 <form autocomplete="off" class="form-signin panel-body" onsubmit="return false">
			<p>Enter your email address:</p>
			<div class="form-group">
				<input id="email" name="email" type="text" autocomplete="off" class="form-control" placeholder="Enter your Email" required autofocus>
			</div>
			<div class="form-group">
			<div id="error_message"></div>
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit" onclick="MR.login.forgot_password('user');">Send Me a Password Reset Link</button>
			<br/>
			<a class="pull-left" id="mr-login-back" href="/login?u=admin">Go Back</a>
		</form>
	</div>
</div>




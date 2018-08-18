<div class="col-md-6 col-md-offset-3">
	<div id="mr-login-form" class="well mr-forgot-login">
	<div class="panel-heading"><h3 class="text-muted" id="mr-login-title">Forgot Password</h3></div>
		 <form autocomplete="off" class="form-signin panel-body" onsubmit="return false">
			<div class="form-group">
				<div class="input-group input-group-lg">
					<label for="email" title="Email Address" class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></label>
					<input type="text" autocomplete="off" id="email" name="email"  class="form-control" placeholder="Enter your Email" required autofocus>
					<span class="input-group-addon">
						<span data-toggle="tooltip" class="tooltipLink" title="Enter your email address in to the box.">
							<i class="glyphicon glyphicon-info-sign"></i>
						</span>
					</span>
				</div>
			</div>
			<br/>
			<button class="btn btn-lg btn-primary btn-block" type="submit" onclick="MR.login.forgot_password('user');">Send Me a Password Reset Link</button>
			<br/>
			<a class="pull-left" id="mr-login-back" href="javascript:MR.utils.link('login');">Go Back</a>
		</form>
	</div>
</div>




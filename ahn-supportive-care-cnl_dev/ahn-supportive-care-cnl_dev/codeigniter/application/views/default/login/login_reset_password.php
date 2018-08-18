<div class="col-md-6 col-md-offset-3">
		<div id="mr-login-form" class="well mr-forgot-login">
			 <div class="panel-heading"><h3 class="text-muted" id="mr-login-title">Reset Password</h3></div>
			 <form class="form-signin panel-body" method="POST" onsubmit="return false" autocomplete="off">
				<div class="form-group">
					<div class="input-group input-group-lg">
						<label for="username" title="Username" class="input-group-addon"><i class="glyphicon glyphicon-user"></i></label>
						<input id="username" name="username" type="text" autocomplete="off" class="form-control" placeholder="Username" value="<?php echo (isset($user['username']) ? $user['username'] : ''); ?>" readonly="readonly">
						<span class="input-group-addon">
							<span data-toggle="tooltip" class="tooltipLink" title="Your username">
								<i class="glyphicon glyphicon-info-sign"></i>
							</span>
						</span>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group input-group-lg">
						<label for="password" title="Password" class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></label>
						<input id="password" name="password" type="password" autocomplete="off" class="form-control" placeholder="New Password" required autofocus>
						<span class="input-group-addon">
							<span data-toggle="tooltip" class="tooltipLink" title="Type your desired new password">
								<i class="glyphicon glyphicon-info-sign"></i>
							</span>
						</span>
					</div>
				</div>
				<div class="form-group">
					<div class="input-group input-group-lg">
						<label for="confirm_password" title="Confirm Password" class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></label>
						<input id="confirm_password" name="confirm_password" type="password" autocomplete="off" class="form-control" placeholder="Confirm New Password" required>
						<span class="input-group-addon">
							<span data-toggle="tooltip" class="tooltipLink" title="Confirm your desired new password">
								<i class="glyphicon glyphicon-info-sign"></i>
							</span>
						</span>
					</div>
				</div>
				<input id="hash" name="hash" type="hidden" autocomplete="off" value="<?php echo (isset($user_password_reset['hash']) ? $user_password_reset['hash'] : ''); ?>">
				<br/>
				<button class="btn btn-lg btn-primary btn-block" type="submit" onclick="MR.login.reset_password('user');">Reset Password</button>
				<br/>
				<a class="pull-left" id="mr-login-back" href="javascript:MR.utils.link('login');">Go Back</a>
			</form>
		</div>
</div>






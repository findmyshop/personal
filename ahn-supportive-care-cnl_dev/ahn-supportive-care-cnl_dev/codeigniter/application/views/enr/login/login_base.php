<div class="col-md-8 col-md-offset-2" style="z-index:2;">
	<div id="mr-login-form" class="well mr-main-login" style="margin-top:10px;">
		<div class="panel-heading">
			<h3 class="text-muted" id="mr-login-title">Sign In</h3>
		</div>
		<div class="col-sm-6" style="padding:0;">
			<div class="well" style="background:#FEFEFE; margin-bottom:0;">
				<?php /* <img src="/assets/projects/enr/images/contest-image.png" width="100%" style="margin-bottom:15px;"/>
				<span style="color:#73c24f;">
				<p>Participate in the Enersource Customer Survey Contest for a chance to win a <strong>16 GB Samsung Galaxy Tab S</strong>.</p>
				<p>The Contest runs from 12:01 a.m. Eastern Standard Time ("EST") November 23, 2015 to 11:59 p.m. EST on December 23, 2015 (the "Contest Period"). All entries must be received during the Contest Period.</p>
				<p>To participate in the survey, please sign in or register an account.</p>
				</span> */ ?>
				<img src="/assets/projects/enr/images/logo-color.jpg" width="100%" style="margin-bottom:15px;"/>
				<span style="color:#73c24f;">
				<p><strong>Note:</strong> The contest ended <strong>11:59 p.m. EST on December 23, 2015</strong>. All new contest submissions are not elligible for the drawing.</p>
			</div>
		</div>
		<div class="col-sm-6" style="padding:0;">
			<form style="padding-top:0px;" autocomplete="off" class="form-signin panel-body" method="POST" onsubmit="return false">
				<h5 style="color:#AAA; margin:0px 0px 10px 0px;">Begin Program <span style="font-weight:normal; color:#BBB;"> (If you are coming to this site for the first time, start here).</span></h5>
				<a class="btn btn-lg btn-primary btn-block" title="Register" href="javascript:MR.utils.link('login/register')">Register</a>
				<hr style="border-color:#DDD; margin-top:30px;"/>
				<h5 style="color:#AAA; margin:20px 0px 10px 0px;">Returning Users <span style="font-weight:normal; color:#BBB;">(Sign in here).</span></h5>
				<!--prevent autocomplete-->
				<input type="email" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" />
				<!--/prevent autocomplete-->
				<div class="form-group">
					<div class="input-group input-group-lg">
						<label for="email" title="Email" class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></label>
						<input id="email" title="Email" name="email" type="text" class="form-control" placeholder="Email" required autofocus >
						<span class="input-group-addon">
							<span data-toggle="tooltip" class="tooltipLink" title="Enter your email into the box">
								<i class="glyphicon glyphicon-info-sign"></i>
							</span>
						</span>
					</div>
				</div>
				<?php if (LOGIN_CAPTCHA) : ?>
				<div class="form-group">
					<div class="g-recaptcha" data-sitekey="6LdyhQwTAAAAAK20RjSdeCjp7FPIgBpWeV-L-DoF"></div>
				</div>
				<?php endif; ?>
				<button style="color:#777;" title="Sign In" class="btn btn-lg btn-default btn-block" type="submit" id="mr-sign-in" onclick="MR.login.do_login('email_login');">Sign in</button>
			</form>
		</div><!--/.col-->
		<div style="clear:both;"></div>
	</div>
</div>


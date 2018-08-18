<div id="mr-ct-login-area">
<div class="col-xs-6 align-center col-1 mr-col ct-login-col">
	<div class="row ct-step"><h1>1</h1></div>
	<div class="row"><h4>Choose the person you would like to answer your questions:</h4></div>
	<div class="row">
		<div class="col-xs-6 portrait-col">
			<div class="portrait doctor"></div>
			<span class="btn btn-lg btn-purple"><form action=""><input name="speaker" id="r-doctor" type="radio" value="a" /> Study Doctor</span>
		</div>
		<div class="col-xs-6 portrait-col">
			<div class="portrait coordinator"></div>
			<span class="btn btn-lg btn-purple"><input name="speaker" id="r-coordinator" type="radio" value="b" /> Study Coordinator</span>
		</div>
	</div>
</div><!--/.mr-col-->
<div class="col-xs-6 align-center col-2 mr-col ct-login-col">
	<div class="row ct-step"><h1>2</h1></div>
	<div id="agreement-text" class="mr-is-wrapper">
		<div class="mr-is-scroller">
			<h4>Terms of Use</h4>
			<p><strong>PLEASE READ THESE TERMS OF USE CAREFULLY BEFORE USING THIS SITE.</strong></p>
			<p>By using this site, you signify your agreement to these terms of use. If you do not agree to these terms of use, please do not use this site.</p>
			<p>The videos on this site portray actors and actresses, not actual medical personnel. The content of the pages of this website, including questions and answers is for your general information and use only. It is subject to change without notice. Any answers provided on this site are not intended to replace a conversation with your personal doctor or the study doctor. Any specific questions about your health or participation in this clinical research study should be directed to the study doctor or another member of the study team.</p>
		</div>
	</div>
	<span class="btn btn-lg btn-purple btn-block btn-square btn-phat"><input name="agree" id="r-agree" type="checkbox" value="agree" /> I agree to the terms</span>
</div><!--/.mr-col-->
<div class="col-xs-12 row-sign-in mr-col ct-login-col">
		<form autocomplete="off" class="form-signin panel-body" method="POST" onsubmit="return false">
			<!--prevent autocomplete-->
			<input type="text" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" />
			<input type="password" name="password_fake" id="password_fake" value="" style="display:none;" />
			<!--/prevent autocomplete-->
			<?php
				/* MMG.login.checkOptions() has as a bool paramater for guest users and real users. */
				if (is_anonymous_guest_user()) :
			?>
				<div style="text-align:center;">
				<div style="display:inline-block;vertical-align:middle;margin-right:40px;" class="form-group ct-step">
					<h1>3</h1>
				</div>
				<div style="display:inline-block; vertical-align:middle;" class="form-group">
					<button style="padding-left:50px;padding-right:50px;" title="Sign In" class="btn btn-lg btn-primary" type="submit" id="mr-sign-in" onclick="MMG.login.checkOptions(true);">Enter Site</button>
				</div>
			</div>
			<?php else : ?>
			<div class="ct-step form-group col-xs-offset-1 col-xs-1">
				<h1>3</h1>
			</div>
			<div class="form-group col-xs-3">
				<div class="input-group input-group-lg">
					<input id="username" title="Username" name="username" type="text" class="form-control" placeholder="Username"  autofocus >
				</div>
			</div>
			<div id="mr-password" class="form-group col-xs-3">
				<div class="input-group input-group-lg">
					<input id="password" title="Password" name="password" type="password" class="form-control" placeholder="Password">
				</div>
			</div>
			<div id="mr-password" class="form-group col-xs-2">
				<button title="Sign In" class="btn btn-lg btn-primary btn-block" type="submit" id="mr-sign-in" onclick="MMG.login.checkOptions(false);">Sign in</button>
			</div>
			<?php endif; ?>
	</form>
</div>
</div><!--#mr-ct-login-area-->



<!-- Admin Login Modal -->
<?php if (is_anonymous_guest_user()) : ?>
<div class="modal fade" id="admin-login-modal" tabindex="-1" role="dialog" aria-labelledby="admin_login_modal_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form autocomplete="off" class="form-signin panel-body" onsubmit="return false">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="admin_login_modal_label">Administrator Login</h4>
				</div>
				<div class="modal-body">
					<div class="well">
						<div class="form-group">
							<div class="input-group input-group-lg">
								<label for="modal_username" title="Username" class="input-group-addon"><i class="glyphicon glyphicon-user"></i></label>
								<input id="modal_username" title="Username" name="username" type="text" autocomplete="off" class="form-control" placeholder="Username" />
								<span class="input-group-addon">
									<span data-toggle="tooltip" class="tooltipLink" title="Enter your username into the box">
										<i class="glyphicon glyphicon-info-sign"></i>
									</span>
								</span>
							</div>
						</div>
						<div class="form-group">
							<div class="input-group input-group-lg">
								<label for="modal_password" title="Password" class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></label>
								<input id="modal_password" title="Password" name="password" type="password" autocomplete="off" class="form-control" placeholder="Password" />
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a class="btn btn-default" href="javascript:MR.utils.link('login/forgot_password');"><i class="glyphicon glyphicon-lock"></i> Forgot Password?</a>
					<button title="Sign In" class="btn btn-primary" type="submit" id="mr-sign-in" onclick="MR.login.do_login('modal');"><i class="glyphicon glyphicon-ok"></i> Sign in</button>
					<button type="button" class="btn btn-default pull-left" tabindex="4" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- / About Modal -->
<?php endif; ?>

<!--Help Modal-->
<div class="modal fade" id="help-modal" tabindex="-1" role="dialog" aria-labelledby="help-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="help-modal-label">Help Topics</h4>
			</div>
			<div class="modal-body" role="tabpanel">
				<div class="col-xs-4 mr-col">
					<ul class="list-group" role="tablist">
						<?php if (USER_AUTHENTICATION_REQUIRED) : ?>
						<li role="presentation" class="active list-group-item"><a href="#help-tab-1" role="tab" data-toggle="tab">Logging In</a></li>
						<?php endif; ?>
						<li role="presentation" class="<?php if (!USER_AUTHENTICATION_REQUIRED) echo "active "; ?>list-group-item"><a href="#help-tab-2" role="tab" data-toggle="tab">Video Player</a></li>
						<li role="presentation" class="list-group-item"><a href="#help-tab-3" role="tab" data-toggle="tab">Video Controls</a></li>
						<li role="presentation" class="list-group-item"><a href="#help-tab-4" role="tab" data-toggle="tab">Ask Bar</a></li>
						<li role="presentation" class="list-group-item"><a href="#help-tab-5" role="tab" data-toggle="tab">Frequently Asked Questions</a></li>
						<li role="presentation" class="list-group-item"><a href="#help-tab-6" role="tab" data-toggle="tab">Related Questions</a></li>
						<li role="presentation" class="list-group-item"><a href="#help-tab-7" role="tab" data-toggle="tab">Video Text</a></li>
					</ul>
				</div><!--/.mr-col-->
				<div class="col-xs-8 mr-col">
					<div class="help-info-box tab-content">
						<?php if (USER_AUTHENTICATION_REQUIRED) : ?>
						<div role="tabpanel" class="tab-pane active" id="help-tab-1">
							<img class="mr-help-img" src="<?php asset_url(true); ?>/projects/<?php echo $project; ?>/images/help/login.jpg"/>
							<div class="mr-help-text">
								<h4>Logging In</h4>
								<?php if (MR_PROJECT == 'nsd') : ?>
									<p>If you are an administrator of this site, you can log in by clicking the <strong>Admin</strong> button above.  After that, type the username and password you were provided and press the "Sign In" button.</p>
								<?php elseif (MR_TYPE == 'ct') : ?>
									<p>First click on who you'd like to hear speak.	 Next, read the teams of use and click the "Agree to Terms" button.	 After that, type the username and password you were provided and press the "Sign In" button.</p>
								<?php endif; ?>
							</div>
						</div><!--/.tab-pane-->
						<?php endif; ?>
						<div role="tabpanel" class="<?php if (!USER_AUTHENTICATION_REQUIRED) echo "active "; ?>tab-pane" id="help-tab-2">
							<img class="mr-help-img" src="<?php asset_url(true); ?>/projects/<?php echo $project; ?>/images/help/video.jpg"/>
							<div class="mr-help-text">
								<h4>Video Player</h4>
								<p>You may click on the video to start/stop the playing video at any time.</p>
							</div>
						</div><!--/.tab-pane-->
						<div role="tabpanel" class="tab-pane" id="help-tab-3">
							<img class="mr-help-img" src="<?php asset_url(true); ?>/projects/<?php echo $project; ?>/images/help/video-controls.jpg"/>
							<div class="mr-help-text">
								<h4>Video Controls</h4>
								<p>You may use these video controls to skip ahead or repeat parts of a video that you've already heard or would like to hear again.</p>
								<?php if(HAS_ASL_VIDEOS): ?>
									<p>To switch between ASL and English videos, click on the ASL icon in the video controls bar.</p>
								<?php endif; ?>
							</div>
						</div><!--/.tab-pane-->
						<div role="tabpanel" class="tab-pane" id="help-tab-4">
							<img class="mr-help-img" src="<?php asset_url(true); ?>/projects/<?php echo $project; ?>/images/help/ask-bar.jpg"/>
							<div class="mr-help-text">
								<h4>Ask Bar</h4>
								<p>Type a question in to the box.	 You will be presented with a new video response after you click the "Ask" button or press "Enter" on your keyboard.</p>
							</div>
						</div><!--/.tab-pane-->
						<div role="tabpanel" class="tab-pane" id="help-tab-5">
							<img class="mr-help-img" src="<?php asset_url(true); ?>/projects/<?php echo $project; ?>/images/help/faq.jpg"/>
							<div class="mr-help-text">
								<h4>Frequently Asked Questions</h4>
								<p>FAQ's or "Frequently Asked Questions" are organized into dropdown menus.	 You may click on these to view their assigned video at any time.</p>
							</div>
						</div><!--/.tab-pane-->
						<div role="tabpanel" class="tab-pane" id="help-tab-6">
							<img class="mr-help-img" src="<?php asset_url(true); ?>/projects/<?php echo $project; ?>/images/help/related.jpg"/>
							<div class="mr-help-text">
								<h4>Related Questions</h4>
								<p>Questions related to the video response you are currntly viewing show up here.	 You may click the "Play" button next to one of these responses to hear an answer.</p>
							</div>
						</div><!--/.tab-pane-->
						<div role="tabpanel" class="tab-pane" id="help-tab-7">
							<img class="mr-help-img" src="<?php asset_url(true); ?>/projects/<?php echo $project; ?>/images/help/summary.jpg"/>
							<div class="mr-help-text">
								<h4>Video Text</h4>
								<p>All of the text spoken in your current video response will be displayed here.</p>
							</div>
						</div><!--/.tab-pane-->
					</div><!--/.tab-content-->
				</div><!--/.mr-col-->
				<div style="clear:both;"></div>
			</div>
		</div>
	</div>
</div>

<!-- 3rd party cookies consent modal -->
<div id ="safari-third-party-cookies-consent-modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Third-Party Cookies Consent</h4>
			</div>
			<div class="modal-body">
				<p>Safari does not allow third-party applications to access cookies without consent. This tool requires access to cookies to work properly. No personal information is captured with this consent. Please provide consent below to continue using this tool.</p>
			</div>
			<div class="modal-footer">
				<a title="Grant Access" class="btn btn-primary" id="safari-third-party-cookies-consent-button" target="_parent" href=""><i class="glyphicon glyphicon-ok"></i> Grant Access</a>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- This baby is MedResponds new secret weapon. This is a modal that saves our users with a return button when they are completely stuck! -->
<div id ="mr-stuck-modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Woo Doggies!</h4>
			</div>
			<div class="modal-body">
				<p>It appears you discovered a bug!  Please <a href="javascript:MR.modal.show('#bug-modal');">submit it to our bug team</a>, pronto!</p>
			</div>
			<div class="modal-footer">
				<a href="javascript:MR.utils.link('');" type="button" class="btn btn-primary pull-right" >Back to Program <i class="glyphicon glyphicon-chevron-right"></i></a>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="base_controller" class="container control-container">
	<div class="main-container">
		<div id="mr-header">
			<?php $this->load->view("/$header"); ?>
		</div> <!-- / mr-header -->
		<div class="page-height" id="mr-content">
			<!-- Load content view -->
			<?php $this->load->view("/$content");?>
		</div> <!-- / mr-content -->
	</div> <!--/.main-container -->
<?php get_footer(); ?>
</div><!--/#main_controller-->
<!-- UAT Alert -->
<div modal-show modal-visible="showTestingModal" class="modal fade" id="login_testing_modal" tabindex="-1" role="dialog" aria-labelledby="login_testing_modal_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" ng-model="modal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="error_dialog_modal_label">User Testing</h4>
			</div>
			<div class="modal-body">
				<p>Welcome to the the Fit For Surgery program. The goal of the program is to reinforce the information provided during a Fit For Surgery consultation.</p>
				<p>The program provides a guided discussion of Fit For Surgery (click Review Options on the 3rd screen) or you may ask questions (click Ask a Question). We would appreciate your reviewing options, asking questions and then, giving us your feedback by clicking on "Give Us Your Feedback" under the Resources tab.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- / UAT Alert -->

<!-- Privacy Policy dialog Modal -->
<div modal-show modal-visible="showPrivacyPolicy" class="modal fade" id="privacy_policy_modal" tabindex="-1" role="dialog" aria-labelledby="dialogue_modal_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" ng-model="dialog">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="error_dialog_modal_label">Fit For Surgery Privacy Policy</h4>
			</div>
			<div class="modal-body">
				<p>We respect your privacy interests and operate our hosted sites by these principles, and we have taken reasonable steps to ensure the integrity and confidentiality of personally identifiable information that you or your family or caregiver(s) may provide.
				You should understand, however, that electronic transmissions via the Internet are not necessarily secure from interception and so we cannot guarantee the security or confidentiality of such transmissions.<p>
				<h4>Patient Engagement/Information Sites (no login required)</h4>
				<p>Users may use MedRespond-hosted sites without disclosing personally identifiable information. The web server of MedRespond-hosted sites collect and saves the default information customarily logged by World Wide Web server software. Our logs contain the following information for each request: date and time, session ID, originating IP address and domain name (the unique address assigned to your internet service provider's computer that connects to the internet), user’s operating system and browser, options chosen, objects requested, question posed and completion status of the request. We use these logs to help improve our service by evaluating the "traffic" to our site in terms of number of unique visitors, level of demand, most popular page requests, most frequently asked questions and types of errors.</p>
				<p>These logs may be kept for an indefinite amount of time, used at any time and in any way to measure visitor satisfaction, to prevent security breaches and to ensure the integrity of the data on our servers.</p>
				<p>For sites without logins, we use session cookies to track navigation through the website and track usage statistics.	 Session cookies are temporary text files that are automatically deleted.	 Session cookies are not used to collect personal information, and no information is shared from session cookies.</p>
				<h4>Advertising Policy</h4>
				<p>Neither MedRespond, nor any of the MedRespond-hosted sites displays advertising, unless this is specifically requested by the site sponsor.</p>
				<h4>Sites with Logins</h4>
				<p>During the use of the programs, some users may voluntarily submit personal information that may be used to identify or contact them.	 For example, if users email their comments, that identifies their email address. If users request additional information be mailed to them, a limited number of administrators will see this information and use it to provide the requested information.	Users will always be asked to give permission and authorize such contact.</p>
				<p>Please note that, for login sites, we use "cookies," which are small files stored on your computer's hard drive that are used to track personal information. We may use this information to save username and password data when you are accessing interactive parts of our websites, to allow your web browser to "remember" who you are and assist you by "logging on" without you having to type your username and password repeatedly. Except for authorized law enforcement investigations or other facially valid legal processes, we will not share any information we receive with any parties outside of the MedRespond or our site development partners.</p>
				<h4>Changes to Our Privacy Policy</h4>
				<p>It is our policy to post any changes we make to our privacy policy on this page [with a notice that the privacy policy has been updated on the Website home page]. If we make material changes to how we treat our users' personal information, we will notify you by e-mail to the primary e-mail address specified in your account or through a notice on the Website home page. The date the privacy policy was last revised is identified at the bottom of the page. You are responsible for ensuring we have an up-to-date active and deliverable e-mail address for you, and for periodically visiting our Website and this privacy policy to check for any changes.</p>
				<h4>Contact Information</h4>
				<p>To ask questions or comment about this privacy policy and our privacy practices, contact us at:
				<a href="mailto:privacy@medrespond.com">privacy@medrespond.com</a></p>
				<h4>Last Revision Date</h4>
				<p>This Privacy Policy was last updated November 18, 2014</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- / Dialog Modal Modal -->
<!-- Login Video Modal -->
<div modal-show modal-visible="showLoginHelp" class="modal fade" id="login_help_modal" tabindex="-1" role="dialog" aria-labelledby="login_help_modal_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" ng-model="modal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="error_dialog_modal_label">Help Video</h4>
			</div>
			<div class="modal-body" id="player_wrapper">
				<div class="player" id="player">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="flowplayer().stop();">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- / Login Video Modal -->
<!-- Disclaimer Modal -->
<div modal-show modal-visible="showDisclaimer" class="modal fade" id="disclaimer_modal" tabindex="-1" role="dialog" aria-labelledby="disclaimer_modal_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="dialog_modal_label">Disclosure</h4>
			</div>
			<div class="modal-body">
				<p class="disclaimer-text">
					Welcome to the Fit For Surgery Resource Center. The answers in this site have been researched, and we hope they offer you the information you desire, but if you have greater need of knowledge, please contact your physician.
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" tabindex="4" onClick="PT.login.acceptDisclaimer(false)">I do not agree</button>
				<button type="button" class="btn btn-primary" tabindex="3" onClick="PT.login.acceptDisclaimer(true)">I agree</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- / Disclaimer Modal -->
<!-- Disclaimer modal -->

<!-- Decline Disclaimer Modal -->
<div modal-show modal-visible="showDeclineDisclaimer" class="modal fade" id="decline_disclaimer_modal" tabindex="-1" role="dialog" aria-labelledby="decline_disclaimer_modal_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="dialog_modal_label">Declined Disclosure</h4>
			</div>
			<div class="modal-body">
				<p>You must accept the disclaimer in order to use the website.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" tabindex="4" data-dismiss="modal">OK</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- / Decline Disclaimer Modal -->

<!-- Disclaimer modal -->
<div modal-show modal-visible="showBugReport" class="modal fade" id="bug_report_modal" tabindex="-1" role="dialog" aria-labelledby="bug_report_modal_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" ng-model="bug_information">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="dialog_modal_label">Contact Technical Support</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label for="email" class="col-sm-4 control-label">Email: </label>
						<div class="col-sm-6">
							<input type="input" ng-model="bug_information.email" class="form-control" id="email" name="email" placeholder="Email" tabindex="1" autofocus>
						</div>
					</div>
					<div class="form-group">
						<label for="phone_number" class="col-sm-4 control-label">Description: </label>
						<div class="col-sm-6">
							<textarea style="resize: none;" rows="15" ng-model="bug_information.report" class="form-control" id="report" name="report" placeholder="Description of Problem" tabindex="2"></textarea>
						</div>
					</div>
					<div style="padding: 0 20px">
						<div class="form-group">
							<div class="input-group input-group-sm">
								<span class="input-group-addon alert alert-info">
								<input ng-model="bug_information.privacy" name="privacy" id="privacy" type="checkbox" value="yes" /></span>
								<label for="privacy" class="form-control alert alert-info">Check here if it is okay to contact you.</label>
							</div>
						</div><!--/.form-group-->
						<div class="form-group">
							<div id="report_bug_status_message"></div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" tabindex="4" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" tabindex="3" ng-click="send_bug_report()">Submit</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- / Bug Report Modal -->

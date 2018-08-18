
<!-- My Answers Modal -->
<div modal-show modal-visible="showMyAnswers" class="modal fade" id="my_answers_modal" tabindex="-1" role="dialog" aria-labelledby="my_answers_modal_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" ng-model="my_answers">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="dialog_modal_label">My Answers</h4>
			</div>
			<div class="modal-body" id="print-survey-modal">
				<div ng-show="my_answers.length == 0">
					This area is used to record your answers to various questions that you will be asked in the "Walk me Through My Options" section. Once you answer the questions, you can come back here to review your answers.
				</div>
				<table ng-hide="my_answers.length == 0" class="table table-striped">
					<thead>
						<tr>
							<th>Question</th>
							<th>Your Answer</th>
						</tr>
					</thead>
					<tbody ng-repeat="(question, answer) in my_answers" ng-cloak>
						<tr>
							<td>{{question}}</td>
							<td>{{answer}}</td>
						</tr>
					</tbody>
				</table>
				<div id="my_answers_status_message">
				</div>
			</div>
			<div class="modal-footer">
				<a ng-show="response.id != 'scc170' && my_answers.length != 0" type="button" class="btn btn-default" href="#/NEXT/scc170">Continue <i class="icon glyphicon glyphicon-chevron-right"></i></a>
				<a ng-show="response.id != 'scc213' && my_answers.length == 0" type="button" class="btn btn-default" href="#/NEXT/scc213">Continue <i class="icon glyphicon glyphicon-chevron-right"></i></a>
				<button ng-show="response.id == 'scc170' || response.id == 'scc213'" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button ng-show="my_answers.length != 0" type="button" onClick="$('#print-survey-modal').print();" class="pull-left btn btn-default"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> Print</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- / My Answers Modal -->
<!-- Error dialog Modal -->
<div modal-show modal-visible="showErrorDialog" class="modal fade" id="error_dialog_modal" tabindex="-1" role="dialog" aria-labelledby="dialogue_modal_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" ng-model="dialog">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="error_dialog_modal_label">Error</h4>
			</div>
			<div class="modal-body" id="error_dialog_body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- / Dialog Modal Modal -->

<!-- Error dialog Modal -->
<div modal-show modal-visible="showPrivacyPolicy" class="modal fade" id="privacy_policy_modal" tabindex="-1" role="dialog" aria-labelledby="dialogue_modal_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" ng-model="dialog">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="error_dialog_modal_label">Supportive Care Privacy Policy</h4>
			</div>
			<div class="modal-body" id="print-privacy-modal">
				<p>We respect your privacy interests and operate our hosted sites by these principles, and we have taken reasonable steps to ensure the integrity and confidentiality of personally identifiable information that you or your family or caregiver(s) may provide.
				You should understand, however, that electronic transmissions via the Internet are not necessarily secure from interception and so we cannot guarantee the security or confidentiality of such transmissions.<p>
				<h5>Patient Engagement/Information Sites (no login required)</h5>
				<p>Users may use MedRespond-hosted sites without disclosing personally identifiable information. The web server of MedRespond-hosted sites collect and saves the default information customarily logged by World Wide Web server software. Our logs contain the following information for each request: date and time, session ID, originating IP address and domain name (the unique address assigned to your internet service provider's computer that connects to the internet), user’s operating system and browser, options chosen, objects requested, question posed and completion status of the request. We use these logs to help improve our service by evaluating the "traffic" to our site in terms of number of unique visitors, level of demand, most popular page requests, most frequently asked questions and types of errors.</p>
				<p>These logs may be kept for an indefinite amount of time, used at any time and in any way to measure visitor satisfaction, to prevent security breaches and to ensure the integrity of the data on our servers.</p>
				<p>For sites without logins, we use session cookies to track navigation through the website and track usage statistics.	 Session cookies are temporary text files that are automatically deleted.	 Session cookies are not used to collect personal information, and no information is shared from session cookies.</p>
				<h5>Advertising Policy</h5>
				<p>Neither MedRespond, nor any of the MedRespond-hosted sites displays advertising, unless this is specifically requested by the site sponsor.</p>
				<h5>Sites with Logins</h5>
				<p>During the use of the programs, some users may voluntarily submit personal information that may be used to identify or contact them.	 For example, if users email their comments, that identifies their email address. If users request additional information be mailed to them, a limited number of administrators will see this information and use it to provide the requested information.	Users will always be asked to give permission and authorize such contact.</p>
				<p>Please note that, for login sites, we use "cookies," which are small files stored on your computer's hard drive that are used to track personal information. We may use this information to save username and password data when you are accessing interactive parts of our websites, to allow your web browser to "remember" who you are and assist you by "logging on" without you having to type your username and password repeatedly. Except for authorized law enforcement investigations or other facially valid legal processes, we will not share any information we receive with any parties outside of the MedRespond or our site development partners.</p>
				<h5>Changes to Our Privacy Policy</h5>
				<p>It is our policy to post any changes we make to our privacy policy on this page [with a notice that the privacy policy has been updated on the Website home page]. If we make material changes to how we treat our users' personal information, we will notify you by e-mail to the primary e-mail address specified in your account or through a notice on the Website home page. The date the privacy policy was last revised is identified at the bottom of the page. You are responsible for ensuring we have an up-to-date active and deliverable e-mail address for you, and for periodically visiting our Website and this privacy policy to check for any changes.</p>
				<h5>Contact Information</h5>
				<p>To ask questions or comment about this privacy policy and our privacy practices, contact us at:
				<a href="mailto:privacy@medrespond.com">privacy@medrespond.com</a></p>
				<h5>Last Revision Date</h5>
				<p>This Privacy Policy was last updated November 18, 2014</p>
			</div>
			<div class="modal-footer">
				<button ng-show="my_answers.length != 0" type="button" onClick="$('#print-privacy-modal').print();" class="pull-left btn btn-default"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> Print</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- / Dialog Modal Modal -->

<!-- consult Modal -->
<div modal-show modal-visible="showConsult" class="modal fade" id="consult_modal" tabindex="-1" role="dialog" aria-labelledby="consult_modal_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" ng-model="consult_information">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="dialog_modal_label">Contact Supportive Care Team</h4>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label for="patient" class="col-sm-2 control-label">Patient: </label>
						<div class="col-sm-4">
							<input type="input" ng-model="consult_information.patient" class="form-control" id="patient" name="patient" placeholder="Name" tabindex="1" autofocus>
						</div>
						<label for="address" class="col-sm-2 control-label">Address: </label>
						<div class="col-sm-4">
							<div class="input-group">
								<input type="input" ng-model="consult_information.address" class="form-control" id="address" name="address" placeholder="Address" tabindex="1" autofocus>
							</div>
						</div>
						<div style="clear:both"></div>
					</div><!--/.form-group-->
					<div class="form-group">
						<label for="location" class="col-sm-2 control-label">Location: </label>
						<div class="col-sm-3">
							<div class="input-group">
								<select id="location" ng-model="consult_information.location" name="location" class="form-control">
									<option value="">-- Select One --</option>
									<option value="Home">Home</option>
									<option value="Hospital">Hospital</option>
									<option value="Other">Other</option>
								</select>
							</div>
						</div>
						<div style="clear:both"></div>
					</div><!--/.form-group-->
					<div class="well">
					Dear Supportive Care Team,<br/><br/> I would like to know more about the services of the Supportive Care program.	 <br/><br/>This request is for the following reasons: (Check all that apply)
					</div>
					<div class="form-group">
						<div class="col-sm-6">
							<div class="input-group input-group-sm">
								<span class="input-group-addon"><input ng-model="consult_information.topic" name="topic" id="r-coping" type="radio" value="Help coping with advancing illness" /></span>
								<label for="r-coping" class="form-control">Help coping with advancing illness</label>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-group input-group-sm">
								<span class="input-group-addon"><input ng-model="consult_information.topic" name="topic" id="r-hospice" type="radio" value="Need for hospice care at home" /></span>
								<label for="r-hospice" class="form-control">Need for hospice care at home</label>
							</div>
						</div>
						<div style="clear:both"></div>
					</div><!--/.form-group-->
					<div class="form-group">
						<div class="col-sm-6">
							<div class="input-group input-group-sm">
								<span class="input-group-addon"><input ng-model="consult_information.topic" name="topic" id="r-wills" type="radio" value="Advanced directives/living wills" /></span>
								<label for="" class="form-control">Advanced directives/living wills</label>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-group input-group-sm">
								<span class="input-group-addon"><input ng-model="consult_information.topic" name="topic" id="r-nurse" type="radio" value="Nursing home placement" /></span>
								<label for="r-nurse" class="form-control">Nursing home placement</label>
							</div>
						</div>
						<div style="clear:both"></div>
					</div><!--/.form-group-->
					<div class="form-group">
						<div class="col-sm-6">
							<div class="input-group input-group-sm">
								<span class="input-group-addon"><input ng-model="consult_information.topic" name="topic" id="r-caregiving" type="radio" value="Questions about caregiving at home" /></span>
								<label for="r-caregiving" class="form-control">Questions about caregiving at home</label>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-group input-group-sm">
								<span class="input-group-addon"><input ng-model="consult_information.topic" name="topic" id="r-worsening" type="radio" value="Questions about worsening disease" /></span>
								<label for="r-worsening" class="form-control">Questions about worsening disease</label>
							</div>
						</div>
						<div style="clear:both"></div>
					</div><!--/.form-group-->
					<div class="form-group">
						<div class="col-sm-6">
							<div class="input-group input-group-sm">
								<span class="input-group-addon"><input ng-model="consult_information.topic" name="topic" id="r-pain" type="radio" value="Pain management" /></span>
								<label for="r-pain" class="form-control">Pain management</label>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-group input-group-sm">
								<span class="input-group-addon"><input ng-model="consult_information.topic" name="topic" id="r-other" type="radio" value="Other" /></span>
								<label for="r-other" class="form-control">Other</label>
							</div>
						</div>
						<div style="clear:both"></div>
					</div><!--/.form-group-->
					<div class="well">
					Sincerely,
					</div>
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Name: </label>
						<div class="col-sm-3">
							<input type="input" ng-model="consult_information.name" class="form-control" id="name" name="name" placeholder="Name" tabindex="1" autofocus>
						</div>
						<label for="relationship" class="col-sm-4 control-label">Relationship to patient: </label>
						<div class="col-sm-3">
							<input type="input" ng-model="consult_information.relationship" class="form-control" id="relationship" name="relationship" placeholder="(Self/Other)" tabindex="1" autofocus>
						</div>
						<div style="clear:both"></div>
					</div><!--/.form-group-->
					<div class="form-group">
						<label for="phone" class="col-sm-2 control-label">Phone: </label>
						<div class="col-sm-3">
							<input type="input" ng-model="consult_information.phone" class="form-control" id="phone" name="phone" placeholder="Number" tabindex="1" autofocus>
						</div>
						<label for="phone" class="col-sm-4 control-label">Email: </label>
						<div class="col-sm-3">
							<input type="input" ng-model="consult_information.email" class="form-control" id="email" name="email" placeholder="Email" tabindex="1" autofocus>
						</div>
						<div style="clear:both"></div>
					</div><!--/.form-group-->
					<div class="form-group">
						<label for="privacy" class="col-sm-2 control-label">Privacy: </label>
						<div class="col-sm-10">
							<div class="input-group input-group-sm">
								<span class="input-group-addon alert alert-info">
								<input ng-model="consult_information.privacy" name="privacy" id="privacy" type="checkbox" value="yes" /></span>
								<label for="privacy" class="form-control alert alert-info">Check here if it is okay to contact you.</label>
							</div>
						</div>
						<div style="clear:both"></div>
					</div><!--/.form-group-->
				</form>
			</div><!-- .body-->
			<div class="modal-footer">
				<button type="button" class="btn btn-default" tabindex="4" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" tabindex="3" ng-click="request_consult()">Submit</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- / consult Modal -->

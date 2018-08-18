<!-- Certificate Modal -->
<div class="modal fade" id="certificate-modal" tabindex="-1" role="dialog" aria-labelledby="certificate-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
				<h4 class="modal-title" id="certificate-modal-label">Certificate</h4>
			</div>
			<div class="modal-body" style="border-bottom:1px dashed #CCC">
				<div class="alert alert-success text-center">
					<h4>Congratulations!</h4>
					<p>You have completed the course material for the AlcoholSBIRT program.</p>
				</div>
			</div>
			<div class="modal-body" style="border-bottom:1px dashed #CCC">
				<strong>Next Steps:</strong>
				<ul ng-show="active_course.accreditation_type_id!=3">
				<li>Click the 'Print Certificate' button to print a copy of your certificate for your records.</li>
				<li>After you have printed your certificate, click the <strong>'Accept Certificate and Continue'</strong> button. The course will be marked as completed and you will be directed to a post-course survey.</li>
				</ul>
				<!-- Social Work Specific -->
				<div ng-show="active_course.accreditation_type_id==3">
					<ul><li>At the bottom of this page, you will find a button Accept Your Certificate.</li>
							<li>Afterwards, a formal certificate will be issued and mailed to you at the address listed below:</li></ul>
					<div class="well">
							<button data-toggle="modal" data-target="#edit_address_modal" type="button" class="btn btn-lrg btn-default pull-right" edit-mailing-address><i class="glyphicon glyphicon-pencil"></i> Edit Address</button>
							<address>
							<div>{{user.address_1}}</div>
							<div ng-show="user.address_2!=''">{{user_address_2}}</div>
							<div>{{user.city}}, {{state_abbreviation}} {{user.province}}, {{user.zip}}</div>
							<div>{{country_name}}</div>
							</address>
				 	</div>
				</div>
			</div>
			<div class="modal-body" id="mr-certificate">
				<div class="">
					<h1 class="cert-title">Certificate of Completion</h1>
					<div ng-show="(active_course.accreditation_type_id==1)||(active_course.accreditation_type_id==2)">
						<h4>UPMC</h4>
						<h4>University of Pittsburgh School of Medicine</h4>
						<h4>Center for Continuing Education in the Health Sciences</h4>
						<hr/>
					</div>
					<h6>This is to acknowledge that on <span ng-bind="active_course.date_completed"></span></h6>
					<h1 class="cert-sign">{{user.first_name}} {{user.middle_initial}} {{user.last_name}}</h1>
					<div ng-show="(active_course.accreditation_type_id==1)||(active_course.accreditation_type_id==2)">
						<h6>participated in the continuing education activity:</h6>
					</div>
					<div ng-show="(active_course.accreditation_type_id==3)||(active_course.accreditation_type_id==4)||(active_course.accreditation_type_id==5)">
						<h6>Completed:</h6>
					</div>
					<h4><em>{{active_course.course_name}}</em></h4>

					<div ng-show="(active_course.accreditation_type_id==2)">
						<hr/>
						<p>This activity has been planned and implemented in accordance with accreditation requirements and policies of the Accreditation Council for Continuing Medical Education (ACCME) through the joint providership of the University of Pittsburgh School of Medicine and MedRespond, LLC.	 The University of Pittsburgh School of Medicine is accredited by the ACCME to provide continuing medical education for physicians.</p>
						<p>The University of Pittsburgh School of Medicine designates this enduring activity for a maximum of {{(active_course.course_id==1)?'1.5':'3.0'}} AMA PRA Category 1 Credits<sup>TM</sup>.	 Each physician should only claim credit commensurate with the extent of their participation in the activity.</p>
					</div>
					<div ng-show="(active_course.accreditation_type_id==1)">
						<hr/>
						<p>UPMC is accredited as a provider of continuing nursing education by the
							 <br/>American Nursing Credentialing Center, Commission on Accreditation.</p>
					</div>
					<div ng-show="(active_course.accreditation_type_id==1)||(active_course.accreditation_type_id==2)">
						<h5>Contact Hours Awarded: {{(active_course.course_id==1)?'1.0':'3.0'}}</h5>
						<p>For questions related to your continuing education credits, please contact:<br/>
							 UPMC Center for Continuing Education in the Health Sciences<br/>
							 Phone: 412-647-8232<br/>
							 Email: ccehs@upmc.edu
						</p>
					</div>
					<div ng-show="(active_course.accreditation_type_id==3)">
						<p>a {{(active_course.course_id==1)?'1':'3'}} hour education program with a post test score of <strong>{{(content_knowlege_test_stats.correct_answers_submitted/content_knowlege_test_stats.total_points)*100|number:0}}%</strong><br/>correctly answering <strong>{{content_knowlege_test_stats.correct_answers_submitted}}</strong> out of <strong>{{content_knowlege_test_stats.total_points}}</strong> questions.</p>
						<p>This program is co-sponsored by MedRespond LLC and the Pennsylvania Psychological Association. The Pennsylvania Psychological Association is approved by the American Psychological Association to sponsor continuing education for psychologists. PPA maintains responsibility for the program and its content. The Pennsylvania Psychological Association is an approved provider for Act 48 Continuing Professional Education Requirements as mandated by the Pennsylvania Department of Education.</p>
						<p>The following information is being provided to the University of Pittsburgh, School of Social Work:</br>Name, Postal Address, Email Address, Phone Number, Test Score</p>
						<p>Your certificate will be returned by Mail or Email.</p>
						<p><em>* Note: If you have not received your certificate within 4 weeks,<br/>contact Darlene Davis, at 2117 Cathedral of Learning, Pittsburgh, PA<br/>or phone the Continuing Education Office at (412) 624-6902.</em></p>
					</div>
					<div ng-show="(active_course.accreditation_type_id==4)">
						<p>a {{(active_course.course_id==1)?'1':'3'}} hour education program with a post test score of <strong>{{(content_knowlege_test_stats.correct_answers_submitted/content_knowlege_test_stats.total_points)*100|number:0}}%</strong><br/>correctly answering <strong>{{content_knowlege_test_stats.correct_answers_submitted}}</strong> out of <strong>{{content_knowlege_test_stats.total_points}}</strong> questions.</p>
						<p>This program is co-sponsored by MedRespond LLC and the Pennsylvania Psychological Association. The Pennsylvania Psychological Association is approved by the American Psychological Association to sponsor continuing education for psychologists. PPA maintains responsibility for the program and its content. The Pennsylvania Psychological Association is an approved provider for Act 48 Continuing Professional Education Requirements as mandated by the Pennsylvania Department of Education.</p>
						<p>Social Workers, Marriage and Family Therapists and Professional Counselors can receive continuing education credits from continuing education providers approved by the American Psychological Association. Since the Pennsylvania Psychological Association is approved by the American Psychological Association to sponsor continuing education, licensed social workers, licensed clinical social workers, licensed marriage and family therapists, and licensed professional counselors will be able to fulfill their continuing education requirement by attending PPA continuing education programs.</p>
						<p>For further information please visit the State Board of Social Workers, Marriage & Family Therapists and Professional Counselors Web site: <a href="http://www.dos.state.pa.us/social">www.dos.state.pa.us/social</a></p>
					</div>
					<div ng-show="(active_course.accreditation_type_id==5)">
						<p>a {{(active_course.course_id==1)?'1':'3'}} hour education program with a post test score of <strong>{{(content_knowlege_test_stats.correct_answers_submitted/content_knowlege_test_stats.total_points)*100|number:0}}%</strong><br/>correctly answering <strong>{{content_knowlege_test_stats.correct_answers_submitted}}</strong> out of <strong>{{content_knowlege_test_stats.total_points}}</strong> questions.</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default pull-left"><i class="glyphicon glyphicon-remove"></i> Close</button>
				<button onclick="$('#mr-certificate').print();" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-print"></i> Print Certificate</button>
				<button type="button" accept-certificate class="btn btn-primary"><i class="glyphicon glyphicon-share-alt"></i> Accept Certificate and Continue</button>
			</div>
		</div>
	</div>
</div>
<!-- Certificate Modal -->
<div class="modal fade" id="old-certificate-modal" tabindex="-1" role="dialog" aria-labelledby="old-certificate-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
				<h4 class="modal-title" id="old-certificate-modal-label">Certificate</h4>
			</div>
			<div class="modal-body" style="border-bottom:1px dashed #CCC" ng-show="barfed_course.accreditation_type_id==3">
				<!-- Social Work Specific -->
					<div class="well">
							<button data-toggle="modal" data-target="#edit_address_modal" type="button" class="btn btn-lrg btn-default pull-right" edit-mailing-address><i class="glyphicon glyphicon-pencil"></i> Edit Address</button>
							<address>
							<div>{{barfed_user.address_1}}</div>
							<div ng-show="barfed_user.address_2!=''">{{user_address_2}}</div>
							<div>{{barfed_user.city}}, {{state_abbreviation}} {{barfed_user.province}}, {{barfed_user.zip}}</div>
							<div>{{country_name}}</div>
							</address>
				 	</div>
			</div>
			<div class="modal-body" id="mr-certificate-old">
				<div class="">
					<h1 class="cert-title">Certificate of Completion</h1>
					<div ng-show="(barfed_course.accreditation_type_id==1)||(barfed_course.accreditation_type_id==2)">
						<h4>UPMC</h4>
						<h4>University of Pittsburgh School of Medicine</h4>
						<h4>Center for Continuing Education in the Health Sciences</h4>
						<hr/>
					</div>

					<h6>This is to acknowledge that on <span ng-bind="barfed_course.date_completed"></h6>
					<h1 class="cert-sign">{{barfed_user.first_name}} {{barfed_user.middle_initial}} {{barfed_user.last_name}}</h1>
					<div ng-show="(barfed_course.accreditation_type_id==1)||(barfed_course.accreditation_type_id==2)">
						<h6>participated in the continuing education activity:</h6>
					</div>
					<div ng-show="(barfed_course.accreditation_type_id==3)||(barfed_course.accreditation_type_id==4)||(barfed_course.accreditation_type_id==5)">
						<h6>Completed:</h6>
					</div>
					<h4><em>{{barfed_course.course_name}}</em></h4>

					<div ng-show="(barfed_course.accreditation_type_id==2)">
						<hr/>
						<p>This activity has been planned and implemented in accordance with accreditation requirements and policies of the Accreditation Council for Continuing Medical Education (ACCME) through the joint providership of the University of Pittsburgh School of Medicine and MedRespond, LLC.	 The University of Pittsburgh School of Medicine is accredited by the ACCME to provide continuing medical education for physicians.</p>
						<p>The University of Pittsburgh School of Medicine designates this enduring activity for a maximum of {{(barfed_course.course_id==1)?'1.5':'3.0'}} AMA PRA Category 1 Credits<sup>TM</sup>.	 Each physician should only claim credit commensurate with the extent of their participation in the activity.</p>
					</div>
					<div ng-show="(barfed_course.accreditation_type_id==1)">
						<hr/>
						<p>UPMC is accredited as a provider of continuing nursing education by the
							 <br/>American Nursing Credentialing Center, Commission on Accreditation.</p>
					</div>
					<div ng-show="(barfed_course.accreditation_type_id==1)||(barfed_course.accreditation_type_id==2)">
						<h5>Contact Hours Awarded: {{(barfed_course.course_id==1)?'1.0':'3.0'}}</h5>
						<p>For questions related to your continuing education credits, please contact:<br/>
							 UPMC Center for Continuing Education in the Health Sciences<br/>
							 Phone: 412-647-8232<br/>
							 Email: ccehs@upmc.edu
						</p>
					</div>
					<div ng-show="(barfed_course.accreditation_type_id==3)">
						<p>a {{(barfed_course.course_id==1)?'1':'3'}} hour education program with a post test score of <strong>{{(barfed_content_knowlege_test_stats.correct_answers_submitted/barfed_content_knowlege_test_stats.total_points)*100|number:0}}%</strong><br/>correctly answering <strong>{{barfed_content_knowlege_test_stats.correct_answers_submitted}}</strong> out of <strong>{{barfed_content_knowlege_test_stats.total_points}}</strong> questions.</p>
						<p>This program is co-sponsored by MedRespond LLC and the Pennsylvania Psychological Association. The Pennsylvania Psychological Association is approved by the American Psychological Association to sponsor continuing education for psychologists. PPA maintains responsibility for the program and its content. The Pennsylvania Psychological Association is an approved provider for Act 48 Continuing Professional Education Requirements as mandated by the Pennsylvania Department of Education.</p>
						<p>The following information is being provided to the University of Pittsburgh, School of Social Work:</br>Name, Postal Address, Email Address, Phone Number, Test Score</p>
						<p>Your certificate will be returned by Mail or Email.</p>
						<p><em>* Note: If you have not received your certificate within 4 weeks,<br/>contact Darlene Davis, at 2117 Cathedral of Learning, Pittsburgh, PA<br/>or phone the Continuing Education Office at (412) 624-6902.</em></p>
					</div>
					<div ng-show="(barfed_course.accreditation_type_id==4)">
						<p>a {{(barfed_course.course_id==1)?'1':'3'}} hour education program with a post test score of <strong>{{(barfed_content_knowlege_test_stats.correct_answers_submitted/barfed_content_knowlege_test_stats.total_points)*100|number:0}}%</strong><br/>correctly answering <strong>{{barfed_content_knowlege_test_stats.correct_answers_submitted}}</strong> out of <strong>{{barfed_content_knowlege_test_stats.total_points}}</strong> questions.</p>
						<p>This program is co-sponsored by MedRespond LLC and the Pennsylvania Psychological Association. The Pennsylvania Psychological Association is approved by the American Psychological Association to sponsor continuing education for psychologists. PPA maintains responsibility for the program and its content. The Pennsylvania Psychological Association is an approved provider for Act 48 Continuing Professional Education Requirements as mandated by the Pennsylvania Department of Education.</p>
						<p>Social Workers, Marriage and Family Therapists and Professional Counselors can receive continuing education credits from continuing education providers approved by the American Psychological Association. Since the Pennsylvania Psychological Association is approved by the American Psychological Association to sponsor continuing education, licensed social workers, licensed clinical social workers, licensed marriage and family therapists, and licensed professional counselors will be able to fulfill their continuing education requirement by attending PPA continuing education programs.</p>
						<p>For further information please visit the State Board of Social Workers, Marriage & Family Therapists and Professional Counselors Web site: <a href="http://www.dos.state.pa.us/social">www.dos.state.pa.us/social</a></p>
					</div>
					<div ng-show="(barfed_course.accreditation_type_id==5)">
						<p>a {{(barfed_course.course_id==1)?'1':'3'}} hour education program with a post test score of {{(barfed_content_knowlege_test_stats.correct_answers_submitted/barfed_content_knowlege_test_stats.total_points)*100|number:0}}% correctly answering {{barfed_content_knowlege_test_stats.correct_answers_submitted}} out of {{barfed_content_knowlege_test_stats.total_points}} questions.</p>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default pull-left"><i class="glyphicon glyphicon-remove"></i> Close</button>
				<button onclick="$('#mr-certificate-old').print();" type="button" class="btn btn-primary"><i class="glyphicon glyphicon-print"></i> Print Certificate</button>
			</div>
		</div>
	</div>
</div>
<!-- Edit Address Modal -->
<div modal-show modal-visible="showDialog" class="modal fade" id="edit_address_modal" tabindex="-1" role="dialog" aria-labelledby="edit_address_modal_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" ng-model="user">
			 <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="add_user_moda_label">Edit Address</h4>
			</div>
			<div class="modal-body">
				<table class="table table-striped">
					<tr>
						<td class="row-label">
							County:
						</td>
						<td class="req-label">
							<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
						</td>
						<td>
							<select class="form-control" ng-model="barfed_user.country_id" id="country_id" name="country_id" edit-address-country-changed hide-select-prompt-option="country_select_prompt">
								<option id="country_select_prompt" value="-1">-- Select Country --</option>
								<option ng-repeat="country in countries" ng-cloak ng-selected="country.country_id==barfed_user.country_id" value="{{country.country_id}}">{{country.name}}</option>
							</select>
						</td>
					</tr>
					<tr>
						<td class="row-label">
							Street Address 1:
						</td>
						<td class="req-label">
							<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
						</td>
						<td>
							<input type="input" ng-model="barfed_user.address_1" class="form-control" id="address_1" name="address_1" placeholder="Address 1" required ng-minlength="3">
						</td>
					</tr>
					<tr>
						<td class="row-label">
							Street Address 2:
						</td>
						<td class="req-label">

						</td>
						<td>
							<input type="input" ng-model="barfed_user.address_2" class="form-control" id="address_2" name="address_2" placeholder="Address 2" required />
						</td>
					</tr>
					<tr>
						<td class="row-label">
							City:
						</td>
						<td class="req-label">
							<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
						</td>
						<td>
							<input type="input" ng-model="barfed_user.city" class="form-control" id="city" name="city" placeholder="City" required ng-minlength="3" />
						</td>
					</tr>
					<tr>
						<td class="row-label">
							<span ng-show="us_address_on_edit_address_form">State/APO:</span><span ng-show="!us_address_on_edit_address_form">Province:</span>
						</td>
						<td class="req-label">
							<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
						</td>
						<td>
							<div ng-show="us_address_on_edit_address_form">
								<select class="form-control" ng-model="barfed_user.state_id" id="state_id" name="state_id" ng-change="set_selection_text('state_id')">
									<option value="-1">-- Select State --</option>
									<option ng-repeat="state in states" ng-cloak ng-selected="state.id==barfed_user.state_id" value="{{state.id}}">{{state.abbreviation}}</option>
								</select>
							</div>
							<div ng-show="!us_address_on_edit_address_form">
								<input type="input" ng-model="barfed_user.province" class="form-control" id="province" name="province" placeholder="Province" ng-minlength="1" required>
							</div>
						</td>
					</tr>
					<tr>
						<td class="row-label">
							<span ng-show="us_address_on_edit_address_form">Zip:</span><span ng-show="!us_address_on_edit_address_form">Postal Code:</span>
						</td>
						<td class="req-label">
							<i class="glyphicon glyphicon-asterisk" aria-hidden="true"></i>
						</td>
						<td>
							<input type="input" ng-model="barfed_user.zip" class="form-control" id="zip" name="zip" placeholder="{{us_address_on_edit_address_form ? 'Zip' : 'Postal Code'}}" ng-minlength="5" required>
						</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" edit-address>Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- / .modal -->
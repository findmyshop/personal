<!--test Modal-->
<div data-backdrop="static" data-keyboard="false" class="modal fade" id="test-modal" tabindex="-1" role="dialog" aria-labelledby="test-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form name="mr_test_form" ng-submit="submit_test()">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="test-modal-label">{{ test.test_name }}</h4>
				<span ng-if="test.stats.iteration < test.max_iterations && (test.stats.marked_passed < 1 || !test.stats.marked_passed)" class="label label-default">Attempt: {{test.stats.iteration}} of {{test.max_iterations}}</span>
				<span ng-class="{'label-danger' : test.stats.marked_passed < 1 }" ng-if="test.stats.score" class="label label-success">Score: {{test.stats.score}}% <em ng-if="test.stats.marked_passed < 1">(Failed)</em><em ng-if="test.stats.marked_passed > 0">(Passed)</em></span>
			</div>
			<div class="modal-body" ng-if="test.stats.iteration <= test.max_iterations && (test.stats.marked_passed < 1 || !test.stats.marked_passed)">
				<h5>{{ test.base_question }}</h5>
				<div class="mr-test-questions" ng-repeat="q in test.questions">
					<div ng-class="{'alert-danger': q.question_number == test.first_blank_answer && testData[q.question_number] == ''}" id="mr-test-q-{{q.question_number}}" class="form-group mr-test-question" ng-init="testData[q.question_number] = q.answer || ''">
						<div ng-if="q.heading" bind-unsafe-html="q.heading"></div>
						<h6 ng-if="q.choices.length > 0">{{ q.question_number_display_text }}) {{ q.question }}</h6>
							<div ng-if="q.choices.length > 0" style="vertical-align:top;width:48%;display:inline-block;padding:0 1% 5px 1%;" ng-repeat="c in q.choices">
								<div class="input-group mr-test-choice" ng-class="{'has-error': q.is_correct == 0 && q.answer == c.answer, 'has-success': q.is_correct == 1 && q.answer == c.answer}" ng-if="q.choices.length > 0">
									<span class="input-group-addon"><input ng-model="testData[q.question_number]" name="q-{{test.key}}-{{q.test_elements_id}}" id="q-{{test.key}}-{{q.test_elements_id}}-{{c.id}}" type="radio" value="{{c.answer}}" /></span>
									<label for="q-{{test.key}}-{{q.test_elements_id}}-{{c.id}}" class="form-control"><strong>{{ c.answer }}.</strong> {{ c.text }}</label>
								</div>
							</div>
							<div class="input-group input-group-lg" ng-class="{'has-error': q.is_correct == 0 && q.answer, 'has-success': q.is_correct == 1 }" ng-if="q.choices.length <= 0 || !q.choices.length">
								<div class="input-group-addon">{{ q.question }}</div>
								<input ng-model="testData[q.question_number]" ng-init="testData[q.question_number] = q.answer" name="q-{{test.key}}-{{q.test_elements_id}}" id="q-{{test.key}}-{{q.test_elements_id}}" type="text" class="form-control"/>
							</div>
					</div>
					<div style="clear:both;"></div>
				</div>
			</div>
			<div class="modal-body" ng-if="test.stats.iteration > test.max_iterations || test.stats.marked_passed > 0">
				<p ng-if="test.stats.marked_passed < 1">You have attempted this test the max amount of times.</p>
				<p ng-if="test.stats.marked_passed > 0 && test.stats.total_points > 0">You have already completed this test with a score of <strong>{{test.stats.score}}%</strong>.</p>
				<p ng-if="test.stats.marked_passed > 0 && test.stats.total_points < 1">You have already submitted this test.</p>
			</div>
			<div class="modal-footer" ng-if="test.stats.iteration <= test.max_iterations && (test.stats.marked_passed < 1 || !test.stats.marked_passed)">
				<button type="submit" title="Answer" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i> Answer</button>
				</button>
				<a class="btn btn-default pull-left" ng-disabled="!response.video_controls.previous_id" href="#/PREVIOUS/{{response.video_controls.previous_id}}"><i class="icon glyphicon glyphicon-chevron-left"></i> Back</a>
				<a class="btn btn-default pull-left" ng-disabled="test.required == 1" href="#/NEXT/{{response.video_controls.next_id}}">Skip <i class="icon glyphicon glyphicon-chevron-right"></i></a>
			</div>
			<div class="modal-footer" ng-if="test.stats.iteration > test.max_iterations || test.stats.marked_passed > 0">
				<a class="btn btn-default pull-left" ng-disabled="!response.video_controls.previous_id" href="#/PREVIOUS/{{response.video_controls.previous_id}}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
				<a class="btn btn-default pull-left" ng-disabled="!response.video_controls.next_id" href="#/NEXT/{{response.video_controls.next_id}}">Next <i class="icon glyphicon glyphicon-chevron-right"></i></a>
			</div>
			</form>
		</div>
	</div>
</div>
</div>
</div>
<!-- Test Status Modal -->
<div data-backdrop="static" data-keyboard="false" class="modal fade" id="test-status-modal" tabindex="-1" role="dialog" aria-labelledby="test-status-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="test-status-modal-label">{{ test.test_name }}</h4>
			</div>
			<div class="modal-body">
				<p>{{test.message}}</p>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default pull-left" ng-click="retry_test();"><i class="glyphicon glyphicon-chevron-left"></i> Retry</a>
				<a class="btn btn-default pull-left" ng-disabled="!response.video_controls.next_id" href="#/NEXT/{{response.video_controls.next_id}}">Next <i class="icon glyphicon glyphicon-chevron-right"></i></a>
			</div>
		</div>
	</div>
</div>
<!-- Profile Modal -->
<div class="modal fade" id="profile-modal" tabindex="-1" role="dialog" aria-labelledby="profile-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="profile-modal-label">{{ active_course.course_name }}</h4>
			</div>
			<div class="modal-body">
					<div class="col-xs-12">
					<h5>Course Progress:</h5>
					<div class="progress" title="progress" my-progress="course_stats.percent_complete" data-bar-color="progress-bar-default"></div>
					</div>
					<ul class="list-group col-xs-6"><li class="list-group-item">
						<i class="mr-status-label glyphicon glyphicon-th-list"></i>&nbsp;&nbsp;Sections Visited:
						<span class="mr-status label label-default">
							{{course_stats.number_of_sections_visited}} / {{course_stats.number_of_sections}}
						</span>
					</li>
					<li class="list-group-item">
						<i class="mr-status-label glyphicon glyphicon-star"></i>&nbsp;&nbsp;Tests Passed:
						<span class="mr-status label label-default">
							{{course_stats.number_of_required_tests_passed}} / {{course_stats.number_of_required_tests}}
						</span>
					</li>
					<li class="list-group-item">
						<i class="mr-status-label glyphicon glyphicon-star-empty"></i>&nbsp;&nbsp;Tests Completed:
						<span class="mr-status label label-default">
							{{course_stats.number_of_required_tests_completed}} / {{course_stats.number_of_required_tests}}
						</span>
					</li>
					<li class="list-group-item">
						<i class="mr-status-label glyphicon glyphicon-saved"></i>&nbsp;&nbsp;Certificate Accepted:
						<span ng-if="active_course.certificate_page_accepted > 0" class="mr-status label label-success"><i class="glyphicon glyphicon-ok"></i> Yes</span>
						<span ng-if="active_course.certificate_page_accepted <= 0" class="mr-status label label-danger"><i class="glyphicon glyphicon-remove"></i> No</span>
					</li>
					</ul><ul class="list-group col-xs-6">
					<li class="list-group-item">
						<i class="mr-status-label glyphicon glyphicon-repeat"></i>&nbsp;&nbsp;Course Attempt:
						<span class="mr-status label label-default">
							{{active_course.current_iteration}} / {{active_course.max_iterations}}
						</span>
					</li>
					<li class="list-group-item">
						<i class="mr-status-label glyphicon glyphicon-share"></i>&nbsp;&nbsp;Course Passed:
						<span ng-if="course_stats.ready_pass > 0" class="mr-status label label-success"><i class="glyphicon glyphicon-ok"></i> Yes</span>
						<span ng-if="course_stats.ready_pass <= 0" class="mr-status label label-danger"><i class="glyphicon glyphicon-remove"></i> No</span>
					</li>
					<li class="list-group-item">
						<i class="mr-status-label glyphicon glyphicon-check"></i>&nbsp;&nbsp;Course Complete:
						<span ng-if="course_stats.ready_complete > 0" class="mr-status label label-success"><i class="glyphicon glyphicon-ok"></i> Yes</span>
						<span ng-if="course_stats.ready_complete <= 0" class="mr-status label label-danger"><i class="glyphicon glyphicon-remove"></i> No</span>
					</li></ul>
					<div style="clear:both;"></div>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default pull-left"><i class="glyphicon glyphicon-remove"></i> Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Certificate Modal -->
<div class="modal fade" id="certificate-modal" tabindex="-1" role="dialog" aria-labelledby="test-status-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
				<h4 class="modal-title" id="certificate-modal-label">Certificate</h4>
			</div>
			<div class="modal-body" style="border-bottom:1px dashed #CCC">
					 <div class="alert alert-info">
						 <strong>Next Steps:</strong>
							<ul ng-show="active_course.accreditation_type_id!=4">
							<li>Click the 'Print Certificate' button to print a copy of your certificate for your records.</li>
							<li>After you have printed your certificate, click the <strong>'Accept Certificate and Continue'</strong> button. The course will be marked as completed and you will be directed to a post-course survey.</li>
							</ul>
						<ul ng-show="active_course.accreditation_type_id==4">
							<li>Your certificate has been transmitted to the accrediation agency for processing. Once it has been processed, your certificate will be mailed to the address that you specified on the previous screen.</li>
							<li>Please click the <strong>'Accept Certificate and Continue'</strong> button. This will mark you as having completed all course requirements and then direct you to a post-course survey.</li>
						</ul>
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
					<h6>This is to acknowledge that on <?php echo date("F jS, Y", now()); ?></h6>
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
					</div>
					<div ng-show="(active_course.accreditation_type_id==4)">
						<p>a {{(active_course.course_id==1)?'1':'3'}} hour education program with a post test score of {{(content_knowlege_test_stats.correct_answers_submitted/content_knowlege_test_stats.total_points)*100|number:0}}% correctly answering {{content_knowlege_test_stats.correct_answers_submitted}} out of {{content_knowlege_test_stats.total_points}} questions.</p>
						<br>
						<p>The following information is being provided to the University of Pittsburgh, School of Social Work:</p>
						<p>Name, Postal Address, Email Address, Phone Number, Test Score</p>
						<p>Your certificate will be returned by Mail or Email. If you have not received your certificate within 4 weeks, contact Darlene Davis, at 2117 Cathedral of Learning, Pittsburgh, PA or phone the Continuing Education Office at (412) 624-6902.</p>
					</div>
					<div ng-show="(active_course.accreditation_type_id==5)">
						<p>a {{(active_course.course_id==1)?'1':'3'}} hour education program with a post test score of {{(content_knowlege_test_stats.correct_answers_submitted/content_knowlege_test_stats.total_points)*100|number:0}}% correctly answering {{content_knowlege_test_stats.correct_answers_submitted}} out of {{content_knowlege_test_stats.total_points}} questions.</p>
					</div>
				</div>
				<!-- APA Specific -->
				<div ng-show="false&&(active_course.accreditation_type_id==3)">
					<strong>Accreditation Statement: </strong>
					<p>[ APA stuff goes here ]</p>
				</div>
				<!-- Social Work Specific -->
				<div ng-show="active_course.accreditation_type_id==4">
				</div>
				<!-- Non Credit Specific -->
				<div ng-show="false&&((active_course.accreditation_type_id==-1) || (active_course.accreditation_type_id==5))">
					<p>[ Non Certification stuff goes here ]</p>
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
<!-- Call Customer Support -->
<div class="modal fade" id="call-support-modal" tabindex="-1" role="dialog" aria-labelledby="call-support-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="call-support-modal-label">Speak to Customer Support</h4>
			</div>
			<div class="modal-body">
				<div class="well">
				<h5><i class="glyphicon glyphicon-phone-alt"></i> Customer Support Number: <a href="tel:1-888-448-6771">1-888-448-6771</a></h5>
				</div>
				<div class="alert alert-info"><small>* Customer Support is available 9:00AM to 5:00PM Eastern Time</small></div>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default pull-left"><i class="glyphicon glyphicon-remove"></i> Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Demo Disclaimer -->
<div class="modal fade" id="demo-disclaimer" tabindex="-1" role="dialog" aria-labelledby="demo-disclaimer-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="demo-disclaimer-label">Welcome to the MedRespond SBIRT Demo</h4>
			</div>
			<div class="modal-body">
				<p>For this demo, we've unlocked Module 6 of our AlcoholSBIRT program.  Turn up your volume and follow through the guided program.</p>
				<div class="alert alert-info"><small>* Note: This is intended for demo purposes only.</small></div>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default pull-left"><i class="glyphicon glyphicon-remove"></i> Close</button>
			</div>
		</div>
	</div>
</div>


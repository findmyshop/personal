<!-- Test Instructions Modal -->
<div data-backdrop="static" data-keyboard="false" class="modal fade" id="test-instructions-modal" tabindex="-1" role="dialog" aria-labelledby="test-instructions-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="test-instructions-modal-label">Post-Test Instructions</h4>
			</div>
			<div class="modal-body">
				<div ng-if="current_left_rail == '3hour'">
					<h5>Completing the Post-Test</h5>
					<ul>
					<li>The Post-Test consists of 21 multiple choice questions.</li>
					<li>A score of at least 70% is required to pass the course and receive credit.</li>
					<li>You will have 3 tries to achieve a passing score.</li>
					</ul>
					<p>Enter your responses to each question and click "Answer" at the bottom right of the post-test. You will be shown your score.	 If you do not pass the Post-Test, select "Retry" to review the answers and try again. Incorrect answers are highlighted in red, correct answers are highlighted in green. Make your corrections and submit the Post-Test again.</p>
					<p>If your third try is not successful you will proceed to the Satisfaction Survey, the Competence Questions, and the Practice Questions.	 You will not be provided with a certificate or credits for the course.</p>
					<h5>Receiving Your Certificate</h5>
					<p>Once you have passed the Post-Test and completed the Satisfaction Survey, Competence Questions, and the Practice Questions, you can print your certificate unless receiving Social Work credits. Those receiving Social Work credits will receive their certificates by mail or email.</li>
					</p>
				</div>
				<div ng-if="current_left_rail == '0hour'">
					<h5>Completing the Post-Test</h5>
					<ul>
					<li>The Post-Test consists of 6 multiple choice questions.</li>
					<li>A score of at least 70% is required to pass the course and receive credit.</li>
					<li>You will have 3 tries to achieve a passing score.</li>
					</ul>
					<p>Enter your responses to each question and click "Answer" at the bottom right of the post-test. You will be shown your score.	 If you do not pass the Post-Test, select "Retry" to review the answers and try again. Incorrect answers are highlighted in red, correct answers are highlighted in green. Make your corrections and submit the Post-Test again.</p>
					<p>If your third try is not successful you will proceed to the Satisfaction Survey, the Competence Questions, and the Practice Questions.	 You will not be provided with a certificate or credits for the course.</p>
					<h5>Receiving Your Certificate</h5>
					<p>Once you have passed the Post-Test and completed the Satisfaction Survey, Competence Questions, and the Practice Questions, you can print your certificate unless receiving Social Work credits. Those receiving Social Work credits will receive their certificates by mail or email.</li>
					</p>
				</div>
			</div>
			<div class="modal-footer">
				<a class="btn btn-default pull-left" ng-disabled="!response.video_controls.previous_id" href="#/PREVIOUS/{{response.video_controls.previous_id}}"><i class="glyphicon glyphicon-chevron-left"></i> Back</a>
				<a class="btn btn-default pull-left" ng-disabled="!response.video_controls.next_id" href="#/NEXT/{{response.video_controls.next_id}}">Next <i class="icon glyphicon glyphicon-chevron-right"></i></a>
			</div>
		</div>
	</div>
</div>
<!-- ASB24 modal -->
<div class="modal fade" id="asb3_did024-modal" tabindex="-1" role="dialog" aria-labelledby="asb3_did024-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
				<h4 class="modal-title" id="test-modal-label">AUDIT</h4>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="mr-quiz-table table table-striped table-bordered">
						<thead>
							<tr>
								<th>Questions</th>
								<th>0</th>
								<th>1</th>
								<th>2</th>
								<th>3</th>
								<th>4</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>1. How often do you have a drink containing alcohol?</th>
								<td>Never</td>
								<td>Monthly or less</td>
								<td>Two to four times a month</td>
								<td>Two to three times a week</td>
								<td>Four or more times a week</td>
							</tr>
							<tr>
								<th>2. How many drinks do you have on a typical day when you are drinking?</th>
								<td>1 or 2</td>
								<td>3 or 4</td>
								<td>5 or 6</td>
								<td>7 to 9</td>
								<td>10 or more</td>
							</tr>
							<tr>
								<th>3. How often do you have six or more drinks on one occasion?</th>
								<td>Never</td>
								<td>Less than monthly</td>
								<td>Monthly</td>
								<td>Weekly</td>
								<td>Daily or almost daily</td>
							</tr>
							<tr>
								<th>4. How often during the last year have you found that you were not able to stop drinking once you had started?</th>
								<td>Never</td>
								<td>Less than monthly</td>
								<td>Monthly</td>
								<td>Weekly</td>
								<td>Daily or almost daily</td>
							</tr>
							<tr>
								<th>5. How often during the last year have you failed to do what was normally expected from you because of drinking?</th>
								<td>Never</td>
								<td>Less than monthly</td>
								<td>Monthly</td>
								<td>Weekly</td>
								<td>Daily or almost daily</td>
							</tr>
							<tr>
								<th>6. How often during the last year have you needed a first drink in the morning to get yourself going after a heavy drinking session?</th>
								<td>Never</td>
								<td>Less than monthly</td>
								<td>Monthly</td>
								<td>Weekly</td>
								<td>Daily or almost daily</td>
							</tr>
							<tr>
								<th>7. How often during the last year have you had a feeling of guilt or remorse after drinking?</th>
								<td>Never</td>
								<td>Less than monthly</td>
								<td>Monthly</td>
								<td>Weekly</td>
								<td>Daily or almost daily</td>
							</tr>
							<tr>
								<th>8. How often during the last year have you been unable to remember what happened the night before because of your drinking?</th>
								<td>Never</td>
								<td>Less than monthly</td>
								<td>Monthly</td>
								<td>Weekly</td>
								<td>Daily or almost daily</td>
							</tr>
							<tr>
								<th>9. Have you or someone else been injured as a result of your drinking?</th>
								<td>No</td>
								<td>-</td>
								<td>Yes, but not in the last year</td>
								<td>-</td>
								<td>Yes, during the last year</td>
							</tr>
							<tr>
								<th>10. Has a relative or friend, doctor or other healthcare worker been concerned about your drinking or suggested you cut down?</th>
								<td>No</td>
								<td>-</td>
								<td>Yes, but not in the last year</td>
								<td>-</td>
								<td>Yes, during the last year</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default">Continue <i class="glyphicon glyphicon-chevron-right"></i></button>
			</div>
		</div>
	</div>
</div>
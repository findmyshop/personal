<div id="statistics-panel" class="mr-panel mr-data-panel panel panel-default" ng-model="user_courses" load-statistics>
	<div class="panel-heading">
		<h1 class="panel-title pull-left"><i class="mr-modal-icon glyphicon glyphicon-cog"></i>Statistics</h1>
		<div class="col-xs-4 pull-right">
			<?php get_date_picker(array('ng_model_start' => 'statistics_filter_start_date', 'ng_model_end' => 'statistics_filter_end_date')); ?>
		</div>
		<div class="col-xs-6">
			<!--
			<span class="input-group-btn input-group-sm">
				<select class="form-control" ng-model="statistics_filter_role_id" name="statistics_filter_role_id">
					<option value="-1">All Courses</option>
					<option ng-repeat="role in roles" ng-cloak ng-selected value="{{role.id}}">{{role.role_name}}</option>
				</select>
			</span>
			-->

			<span class="input-group-btn input-group-sm">
				<select class="form-control" ng-model="statistics_filter_course" name="statistics_filter_course">
				<?php foreach($course_dropdowns as $value => $display): ?>
					<?php echo '<option value="' . $value . '">' . $display .  '</option>'; ?>
				<?php endforeach; ?>

				</select>
			</span>

			<span class="input-group-btn input-group-sm">
				<select class="form-control" ng-model="statistics_filter_accreditation_type_id" name="statistics_filter_accreditation_type_id">
					<option value="-1">All Accreditations</option>
					<option ng-repeat="accreditation_type in accreditation_types" ng-cloak ng-selected value="{{accreditation_type.id}}">{{accreditation_type.accreditation_type}}</option>
				</select>
			</span>
		</div><!--/.col-->

		<?php if(is_admin()): ?>
		<div style="clear:both;"></div>
			<div class="col-xs-12 pull-right">
				<span class="input-group-btn">
					<button type="button" class="btn btn-default pull-right" ng-click="export_accreditor_report();"><i class="glyphicon glyphicon-export"></i>Export Accreditor CSV</button>
				</span>
			</div>
		<?php endif; ?>

		<div style="clear:both;"></div>
	</div><!--/.panel-heading-->

	<div id="spinner" style="display: none; text-align:center; width:100%; color:red;">
		<span id="spinner-text" style="padding-right: 5px;"></span><i class="fa fa-spinner fa-spin"></i>
	</div>

	<div class="panel-body">
		<?php foreach($courses as $course): ?>
			<div id="<?= $course ?>_course" ng-cloak ng-show="statistics_filter_course == '<?= $course ?>_course'">
				<?php $content_knowledge_overall_statistics_body = '
				<ul class="list-group">
					<li class="list-group-item list-group-item-warning" ng-cloak><strong>Summary:</strong></li>
					<li class="list-group-item" ng-cloak><strong>Average Test Score:</strong> {{statistics.'. $course.'.content_knowledge.overall.average_score}}</li>
					<li class="list-group-item" ng-cloak><strong>Number of Tests Taken:</strong> {{statistics.'. $course.'.content_knowledge.overall.tests_taken_count}}</li>
				</ul>'; ?>
				<?php $print_button = '<button type="button" onClick="$(\'#'.$course.'_course\').find(\'.tab-pane.active\').print();" class="btn btn-default"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> Print</button>'; ?>
				<?php $content_knowledge_individual_questions_statistics_body = '
					<ul class="list-group">
						<li class="list-group-item list-group-item-warning" ng-cloak><strong>Individual Questions:</strong></li>
						<li class="list-group-item" ng-cloak ng-repeat="question in statistics.'. $course.'.content_knowledge.individual_questions">
							<h5>{{question.question_number}}.&nbsp;{{question.question}}</h5>
							<div class="mr-test-choice" ng-repeat="answer in question.answers">
							<span class="glyphicon glyphicon-unchecked" ng-if="answer.is_correct_answer < 1"></span>
							<span class="glyphicon glyphicon-check alert-success" ng-if="answer.is_correct_answer > 0"></span> <strong>{{answer.answer}}.</strong> {{answer.text}}</div>
							<hr/>
							<div><strong>Percentage Correct:</strong>&nbsp;{{question.percent_correct}}%</div>
							<div><strong>Number of Correct Answers:</strong>&nbsp;{{question.num_correct}}</div>
							<div><strong>Number of Incorrect Answers:</strong>&nbsp;{{question.num_incorrect}}</div>
							<div><strong>Total Number of Answers:</strong>&nbsp;{{question.num_responses}}</div>
						</li>
					</ul>
				'; ?>

				<?php $satisfaction_survey_overall_statistics_body = '
					<ul class="list-group col-xs-12">
						<li class="list-group-item list-group-item-warning" ng-cloak><strong>Summary:</strong></li>
						<li class="list-group-item" ng-cloak>
							<div><strong>Minimum Response:</strong>&nbsp;{{statistics.'. $course.'.satisfaction_survey.overall.minimum_response}}</div>
							<div><strong>Maximum Response:</strong>&nbsp;{{statistics.'. $course.'.satisfaction_survey.overall.maximum_response}}</div>
							<div><strong>Average Response:</strong>&nbsp;{{statistics.'. $course.'.satisfaction_survey.overall.average_response}}</div>
							<div><strong>Response Variance:</strong>&nbsp;{{statistics.'. $course.'.satisfaction_survey.overall.response_variance}}</div>
							<div><strong>Response Standard Deviation:</strong>&nbsp;{{statistics.'. $course.'.satisfaction_survey.overall.response_standard_deviation}}</div>
							<div><strong>Number of Responses:</strong>&nbsp;{{statistics.'. $course.'.satisfaction_survey.overall.num_responses}}</div>
							<div><strong>Number of Responders:</strong>&nbsp;{{statistics.'. $course.'.satisfaction_survey.overall.num_responders}}</div>
						</li>
					</ul>
				'; ?>

				<?php $satisfaction_survey_individual_questions_statistics_body = '
					<ul class="list-group">
						<li class="list-group-item list-group-item-warning" ng-cloak><strong>Individual Questions:</strong></li>
						<li class="list-group-item" ng-cloak ng-repeat="question in statistics.'. $course.'.satisfaction_survey.individual_questions">
							<h5>{{question.question_number}}.&nbsp;{{question.question}}</h5>
							<div class="mr-test-choice" ng-repeat="answer in question.answers">
							<span class="glyphicon glyphicon-unchecked" ng-if="answer.is_correct_answer < 1"></span>
							<span class="glyphicon glyphicon-check alert-success" ng-if="answer.is_correct_answer > 0"></span> <strong>{{answer.answer}}.</strong> {{answer.text}}</div>
							<hr/>
							<div><strong>Minimum Response:</strong>&nbsp;{{question.minimum_response}}</div>
							<div><strong>Maximum Response:</strong>&nbsp;{{question.maximum_response}}</div>
							<div><strong>Average Response:</strong>&nbsp;{{question.average_response}}</div>
							<div><strong>Response Variance:</strong>&nbsp;{{question.response_variance}}</div>
							<div><strong>Response Standard Deviation:</strong>&nbsp;{{question.response_standard_deviation}}</div>
							<div><strong>Number of Responses:</strong>&nbsp;{{question.num_responses}}</div>
						</li>
					</ul>
				'; ?>

				<?php $pre_and_post_test_competence_test_overall_statistics_body = '
				<ul class="list-group">
					<li class="list-group-item list-group-item-warning" ng-cloak><strong>Summary:</strong></li>
					<li class="list-group-item">
					<ul class="list-group col-xs-6">
						<li class="list-group-item list-group-item-warning" ng-cloak><strong>Pre Test</strong></li>
						<li class="list-group-item" ng-cloak>
							<div><strong>Minimum Response:</strong>&nbsp;{{statistics.'. $course.'.pre_test.overall.minimum_response}}</div>
							<div><strong>Maximum Response:</strong>&nbsp;{{statistics.'. $course.'.pre_test.overall.maximum_response}}</div>
							<div><strong>Average Response:</strong>&nbsp;{{statistics.'. $course.'.pre_test.overall.average_response}}</div>
							<div><strong>Response Variance:</strong>&nbsp;{{statistics.'. $course.'.pre_test.overall.response_variance}}</div>
							<div><strong>Response Standard Deviation:</strong>&nbsp;{{statistics.'. $course.'.pre_test.overall.response_standard_deviation}}</div>
							<div><strong>Number of Responses:</strong>&nbsp;{{statistics.'. $course.'.pre_test.overall.num_responses}}</div>
							<div><strong>Number of Responders:</strong>&nbsp;{{statistics.'. $course.'.pre_test.overall.num_responders}}</div>
						</li>
					</ul>
					<ul class="list-group col-xs-6">
						<li class="list-group-item list-group-item-warning" ng-cloak><strong>Post Test</strong></li>
						<li class="list-group-item" ng-cloak>
							<div><strong>Minimum Response:</strong>&nbsp;{{statistics.'. $course.'.post_test_competence.overall.minimum_response}}</div>
							<div><strong>Maximum Response:</strong>&nbsp;{{statistics.'. $course.'.post_test_competence.overall.maximum_response}}</div>
							<div><strong>Average Response:</strong>&nbsp;{{statistics.'. $course.'.post_test_competence.overall.average_response}}</div>
							<div><strong>Response Variance:</strong>&nbsp;{{statistics.'. $course.'.post_test_competence.overall.response_variance}}</div>
							<div><strong>Response Standard Deviation:</strong>&nbsp;{{statistics.'. $course.'.post_test_competence.overall.response_standard_deviation}}</div>
							<div><strong>Number of Responses:</strong>&nbsp;{{statistics.'. $course.'.post_test_competence.overall.num_responses}}</div>
							<div><strong>Number of Responders:</strong>&nbsp;{{statistics.'. $course.'.post_test_competence.overall.num_responders}}</div>
						</li>
					</ul>
					<div style="clear:both;"></div>
					</li>
				</ul>
				'; ?>

				<?php $pre_and_post_test_competence_test_individual_questions_statistics_body = '
					<ul class="list-group">
						<li class="list-group-item list-group-item-warning" ng-cloak><strong>Individual Questions:</strong></li>
						<li class="list-group-item" ng-cloak ng-repeat="question in statistics.'. $course.'.pre_test.individual_questions">
							<h5>{{question.question_number}}.&nbsp;{{question.question}}</h5>
							<div class="mr-test-choice" ng-repeat="answer in question.answers"><span class="glyphicon glyphicon-unchecked" ng-if="answer.is_correct_answer < 1"></span>
							<span class="glyphicon glyphicon-check alert-success" ng-if="answer.is_correct_answer > 0"></span> <strong>{{answer.answer}}.</strong> {{answer.text}}</div>
							<hr/>
							<ul class="list-group col-xs-6">
							<li class="list-group-item list-group-item-warning" ng-cloak><strong>Pre Test</strong></li>
							<li class="list-group-item" ng-cloak>
								<div><strong>Minimum Response:</strong>&nbsp;{{question.minimum_response}}</div>
								<div><strong>Maximum Response:</strong>&nbsp;{{question.maximum_response}}</div>
								<div><strong>Average Response:</strong>&nbsp;{{question.average_response}}</div>
								<div><strong>Response Variance:</strong>&nbsp;{{question.response_variance}}</div>
								<div><strong>Response Standard Deviation:</strong>&nbsp;{{question.response_standard_deviation}}</div>
								<div><strong>Number of Responses:</strong>&nbsp;{{question.num_responses}}</div>
							</li>
							</ul>

							<ul class="list-group col-xs-6">
								<li class="list-group-item list-group-item-warning" ng-cloak><strong>Post Test</strong></li>
								<li class="list-group-item" ng-cloak>
								<div><strong>Minimum Response:</strong>&nbsp;{{statistics.'. $course.'.post_test_competence.individual_questions[$index].minimum_response}}</div>
								<div><strong>Maximum Response:</strong>&nbsp;{{statistics.'. $course.'.post_test_competence.individual_questions[$index].maximum_response}}</div>
								<div><strong>Average Response:</strong>&nbsp;{{statistics.'. $course.'.post_test_competence.individual_questions[$index].average_response}}</div>
								<div><strong>Response Variance:</strong>&nbsp;{{statistics.'. $course.'.post_test_competence.individual_questions[$index].response_variance}}</div>
								<div><strong>Response Standard Deviation:</strong>&nbsp;{{statistics.'. $course.'.post_test_competence.individual_questions[$index].response_standard_deviation}}</div>
								<div><strong>Number of Responses:</strong>&nbsp;{{statistics.'. $course.'.post_test_competence.individual_questions[$index].num_responses}}</div>
							</li>
							</ul>
							<div style="clear:both;"></div>
						</li>
					</ul>
				'; ?>

				<?php $practice_overall_statistics_body = '
					<ul class="list-group">
						<li class="list-group-item list-group-item-warning" ng-cloak><strong>Summary:</strong></li>
						<li class="list-group-item" ng-cloak>
							<div><strong>Minimum Response:</strong>&nbsp;{{statistics.'. $course.'.practice.overall.minimum_response}}</div>
							<div><strong>Maximum Response:</strong>&nbsp;{{statistics.'. $course.'.practice.overall.maximum_response}}</div>
							<div><strong>Average Response:</strong>&nbsp;{{statistics.'. $course.'.practice.overall.average_response}}</div>
							<div><strong>Response Variance:</strong>&nbsp;{{statistics.'. $course.'.practice.overall.response_variance}}</div>
							<div><strong>Response Standard Deviation:</strong>&nbsp;{{statistics.'. $course.'.practice.overall.response_standard_deviation}}</div>
							<div><strong>Number of Responses:</strong>&nbsp;{{statistics.'. $course.'.practice.overall.num_responses}}</div>
							<div><strong>Number of Responders:</strong>&nbsp;{{statistics.'. $course.'.practice.overall.num_responders}}</div>
						</li>
					</ul>
				'; ?>

				<?php $practice_individual_questions_statistics_body = '
					<ul class="list-group">
						<li class="list-group-item list-group-item-warning" ng-cloak><strong>Individual Questions:</strong></li>
						<li class="list-group-item" ng-cloak ng-repeat="question in statistics.'. $course.'.practice.individual_questions">
							<h5>{{question.question_number}}.&nbsp;{{question.question}}</h5>
							<div class="mr-test-choice" ng-repeat="answer in question.answers">
							<span class="glyphicon glyphicon-unchecked" ng-if="answer.is_correct_answer < 1"></span>
							<span class="glyphicon glyphicon-check alert-success" ng-if="answer.is_correct_answer > 0"></span> <strong>{{answer.answer}}.</strong> {{answer.text}}</div>
							<hr/>
							<div><strong>Minimum Response:</strong>&nbsp;{{question.minimum_response}}</div>
							<div><strong>Maximum Response:</strong>&nbsp;{{question.maximum_response}}</div>
							<div><strong>Average Response:</strong>&nbsp;{{question.average_response}}</div>
							<div><strong>Response Variance:</strong>&nbsp;{{question.response_variance}}</div>
							<div><strong>Response Standard Deviation:</strong>&nbsp;{{question.response_standard_deviation}}</div>
							<div><strong>Number of Responses:</strong>&nbsp;{{question.num_responses}}</div>
						</li>
					</ul>
				'; ?>

				<?php $panel_body = '
				<div class="col-xs-4" role="tabpanel">
					<ul class="nav nav-pills nav-stacked" role="tablist">
						<li class="active" role="presentation"><a href="#t1-'.$course.'" role="tab" data-toggle="tab">
							<i class="glyphicon glyphicon-list-alt"></i> Content/Knowledge</a>
						</li>
						<li role="presentation">
							<a href="#t2-'.$course.'" role="tab" data-toggle="tab">
								<i class="glyphicon glyphicon-list-alt"></i> Satisfaction Survey
							</a>
						</li>
						<li role="presentation">
							<a href="#t3-'.$course.'" role="tab" data-toggle="tab">
								<i class="glyphicon glyphicon-list-alt"></i> Pre and Post Test Competence
							</a>
						</li>
						<li ng-show="statistics_filter_course !== \'sbirt_coach_three_hour_course\'" role="presentation">
							<a href="#t4-'.$course.'" role="tab" data-toggle="tab">
								<i class="glyphicon glyphicon-list-alt"></i> About Your Practice
							</a>
						</li>
					</ul>
				</div>
				<div class="tab-content col-xs-8" id="test-print-panel">
					<div role="tabpanel" class="tab-pane active" id="t1-'.$course.'">
						' . build_shell_panel(array('right' => $print_button, 'title' => 'Test: Content/Knowledge',  'body' => $content_knowledge_overall_statistics_body . '<div style="clear:both"></div>
						' . $content_knowledge_individual_questions_statistics_body), FALSE) . '
					</div>
					<div role="tabpanel" class="tab-pane" id="t2-'.$course.'">
						' . build_shell_panel(array('right' => $print_button, 'title' => 'Test: Satisfaction Survey', 'body' => $satisfaction_survey_overall_statistics_body . '<div style="clear:both"></div>
						' . $satisfaction_survey_individual_questions_statistics_body), FALSE) . '
					</div>
					<div role="tabpanel" class="tab-pane" id="t3-'.$course.'">
						' . build_shell_panel(array('right' => $print_button, 'title' => 'Test: Pre and Post Test Competence', 'body' => $pre_and_post_test_competence_test_overall_statistics_body . '<div style="clear:both"></div>
						' . $pre_and_post_test_competence_test_individual_questions_statistics_body), FALSE) . '
					</div>
					<div ng-show="statistics_filter_course != \'sbirt_coach_three_hour_course\'" role="tabpanel" class="tab-pane" id="t4-'.$course.'">
						' . build_shell_panel(array('right' => $print_button, 'title' => 'Test: About Your Practice', 'body' => $practice_overall_statistics_body . '<div style="clear:both"></div>
						' . $practice_individual_questions_statistics_body), FALSE) .
					'</div>
				</div>';
			?>

			<?php
				$panel_title = 'Course: ';

				if($course === 'alcohol_sbirt_one_hour') {
					$panel_title .= 'AlcoholSBIRT 1 Hour';
				} else if($course === 'alcohol_sbirt_three_hour') {
					$panel_title .= 'AlcoholSBIRT 3 Hour';
				} else if($course === 'sbirt_coach_three_hour') {
					$panel_title .= 'SBIRTCoach 3 Hour';
				}
			?>

			<?= build_shell_panel(array(
				'title'	=> $panel_title,
				'body'	=> $panel_body
			)); ?>
			</div>
		<?php endforeach; ?>
	</div>	<!--/ panel-body -->
</div><!--/ .panel -->
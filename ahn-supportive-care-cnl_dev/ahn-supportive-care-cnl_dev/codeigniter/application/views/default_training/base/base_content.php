<div id="mr-col-left" class="col-xs-3 mr-col">
<?php get_left_rail(
				array("status" => true)
			); ?>
</div><!--/.mr-col-->
<div id="mr-col-middle" class="col-xs-9 mr-col">
<div id="mr-progress">
	<div class="mr-panel-toggle"><i class="icon glyphicon"></i> Progress</div>
	<div class="mr-progress-inside">
		<div class="progress" title="progress" my-progress="course.stats.percent_complete" data-bar-color="progress-bar-warning"> </div>
	</div>
</div>
	<?php get_player(array("control" => true,"before" => '<div div id="mr-response-label" ng-show="response.type == \'model\'">Model Response</div><div ng-show="response.ask_controls.action == \'test\'" id="mr-test-controls"><a id="mr-test-controls-prev" ng-show="response.video_controls.previous_id" href="#/NEXT/{{response.video_controls.previous_id}}"></a><a id="mr-test-controls-open" href="javascript:MR.modal.show(\'#test-modal\',true);"><div id="mr-test-title">{{ test.test_name }}</div></a><a id="mr-test-controls-next" ng-show="response.video_controls.next_id" href="#/NEXT/{{response.video_controls.next_id}}"></a></div>')); ?>
	<?php get_ask_controls(array("navigation" => true, "ui" => true, "size" => 'medium')); ?>
	<div class="mr-widget mr-comments-box" ng-show="response.ask_controls.action == 'comment' || response.ask_controls.action == 'multiple_choice'">
		<form ng-show="response.ask_controls.action == 'multiple_choice'" role="form" ng-submit="submit_test();">
		<!--<h5>{{ test.base_question }}</h5>-->
		<div class="mr-test-questions" ng-repeat="q in test.questions">
			<div ng-class="{'alert-danger': q.question_number == test.first_blank_answer && testData[q.question_number] == ''}" id="mr-test-q-{{q.question_number}}" class="form-group mr-test-question" ng-init="testData[q.question_number] = q.answer || ''">
				<div ng-if="q.heading" bind-unsafe-html="q.heading"></div>
				<h5>{{ q.question }}</h5>
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
		<button class="btn btn-primary pull-right" type="submit">Answer <i class="icon glyphicon glyphicon-pencil"></i></button>
		<a ng-show="response.video_controls.next_id" href="#/NEXT/{{response.video_controls.next_id}}" class="btn btn-default">Skip <i class="icon glyphicon glyphicon-chevron-right"></i></a>
		</form>
		<div style="clear:both;"></div>
	</div><!--/.mr-widget-->
	<div id="video-text-div" style="background:#4488cc;"></div>
</div><!--/#middle-col-->

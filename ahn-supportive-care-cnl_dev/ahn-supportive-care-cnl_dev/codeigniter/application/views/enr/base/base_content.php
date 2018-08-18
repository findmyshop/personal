<div id="mr-col-left" class="col-xs-3 mr-col">
	<?php get_left_rail(array('status' => true, 'before' => '<div class="fake-panel-heading">Navigation:</div>')); ?>
</div><!--/.mr-col-->
<div id="mr-col-middle" class="col-xs-6 mr-col">
	<?php get_player(array("control" => true)); ?>
		<?php get_ask_controls(array("navigation" => true, "ui" => true, "size" => 'medium')); ?>
	<div ng-hide="response.ask_controls.action == 'comment' || response.ask_controls.action == 'multiple_choice'">
		<?php get_video_text(); ?>
	</div>
		<div class="mr-comments-box" style="overflow-y:scroll; margin-top:5px;" id="enr-test-box" ng-show="response.ask_controls.action == 'comment' || response.ask_controls.action == 'multiple_choice'">
			<form ng-show="response.ask_controls.action == 'comment'" role="form" ng-submit="check_spelling(submit_comment());">
			<div class="mr-test-questions" ng-repeat="q in test.questions">
				<h5 class="video-text-title"><span ng-show="test.previous_question_answer">You answered: <em>{{test.previous_question_answer}}</em>. </span>{{ q.question }}</h5>
			</div>
			<textarea autofocus class="form-control" ng-model="testData" id="mr-comment-text" placeholder="Type your comment here" spellcheck="true" maxlength="500"></textarea>
				<button class="btn btn-primary pull-right" type="submit">Answer <i class="icon glyphicon glyphicon-pencil"></i></button>
				<a ng-show="response.video_controls.next_id" ng-click="submit_comment(true)" class="btn btn-default">Skip <i class="icon glyphicon glyphicon-chevron-right"></i></a>
			</form>
			<form ng-show="response.ask_controls.action == 'multiple_choice'" role="form" ng-submit="check_spelling(submit_multiple_choice());">
			<div class="mr-test-questions" ng-repeat="q in test.questions">
				<h5 class="video-text-title">{{ q.question }}</h5>
				<div style="vertical-align:top;width:49%;display:inline-block;padding:0 1% 5px 0;" ng-repeat="c in q.choices">
					<div class="input-group mr-test-choice" ng-if="q.choices.length > 0">
						<span class="input-group-addon"><input ng-model="testData[q.question_number]" name="q-{{test.key}}-{{q.test_elements_id}}" id="q-{{test.key}}-{{q.test_elements_id}}-{{c.id}}" type="radio" value="{{c.answer}}" /></span>
						<label style="height:auto;" for="q-{{test.key}}-{{q.test_elements_id}}-{{c.id}}" class="form-control"><strong>{{ c.answer }}.</strong> {{ c.text }}</label>
					</div>
				</div>
			</div>
			<button class="btn btn-primary pull-right" type="submit">Answer <i class="icon glyphicon glyphicon-pencil"></i></button>
			<a ng-show="response.video_controls.next_id" ng-click="submit_multiple_choice()" class="btn btn-default">Skip <i class="icon glyphicon glyphicon-chevron-right"></i></a>
			</form>
			<div style="clear:both;"></div>
		</div><!--/.mr-widget-->
</div><!--/#middle-col-->
<div id="mr-col-right" class="col-xs-3 mr-col">
	<div id="related-questions" class="mr-is-wrapper">
		<div class="mr-is-scroller">

			<div class="mr-widget mr-options-widget" class="returning-user-buttons" ng-show="(returningUser != 'false' || skip_last_response_save == true || response.video_controls.done_id || response.id == 'enr4002' || response.id == 'enr4003' || response.id == 'enr3010') && response.ask_controls.action == 'analyze' || response.id == 'enr1403'">
				<div class="panel-heading">Options:</div>
				<div class="panel-body">
					<?php if(feature_enabled('contest', $this->session->userdata('user_type'))): ?>
					<a ng-if="response.id == 'enr1403'" ng-click="open_contest_modal();" class="btn-sparkle btn btn-primary btn-block">Enter Draw</a>
					<?php endif; ?>
					<a ng-if="response.id == 'enr4002' || response.id == 'enr4003'" href="http://www.enersource.com/survey/" target="_blank" class="btn-sparkle btn btn-primary btn-block">Instructions for Draw</a>
					<a id="enr-finish-section" ng-if="response.video_controls.done_id" class="btn-sparkle btn btn-primary btn-block" href="#/DONE/{{response.video_controls.done_id}}">{{ response.video_controls.done_title === "" ? "Finish this Section" : response.video_controls.done_title }}</a>
					<button id="mr-return-button" ng-if="returningUser != 'false' || skip_last_response_save == true || response.id == 'enr3010'" class="btn btn-primary btn-sparkle btn-block" type="button" ng-click="load_returning_user_state();">Return where you left off</button>
				</div>
			</div>
			<div class="mr-widget mr-related-widget" ng-hide="returningUser == true || response.related_questions < 1">
				<div class="panel-heading">{{ question_title }}</div>
				<div class="panel-body">
					<div class="related-q" ng-repeat="question in response.related_questions" title="{{ question.display_text }}">
						<a href="#/RELATED/{{question.id}}/{{response.id}}/{{response.video_controls.next_id}}">{{ question.display_text }}</a>
					</div>
				</div>
			</div>
			<div class="mr-widget mr-playlist-widget" ng-hide="response.playlists < 1">
				<div class="panel-heading">Related Conversations</div>
				<div class="panel-body">
					<div class="playlist-c" ng-repeat="playlist in response.playlists" title="{{ playlist.display_text }}">
						<a href="#/RELATED/{{playlist.id}}/{{response.id}}/{{response.video_controls.next_id}}" class="mr-playlist-thumbnail-loader">
							<img title="{{ playlist.actor_name }}" alt="{{ playlist.actor_name }}" class="mr-playlist-thumbnail" ng-src="{{playlist.actor_image}}"/>
							<div class="mr-icon-play"></div>
							<div class="mr-icon-film"></div>
						</a>
						<p>{{ playlist.display_text }}</p>
						<div style="clear:both;"></div>
					</div>
				</div>
			</div>
			<?php get_survey(); ?>
		</div>
	</div>
</div><!--/.mr-col-->

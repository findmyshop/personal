<div id="mr-col-left" class="col-xs-3 mr-col">
	<?php get_left_rail(); ?>
	<div class="mr-widget mr-button-widget">
		<div class="panel-heading">Our Sponsors:</div>
		<ul class="panel-body">
			<li class="list-group-item">
				<span class="sponsor-heading gold" data-toggle="tooltip" title="Gold Sponsors"><span class="sponsor-icon gold"></span>GOLD SPONSORS</span>
				<span class="sponsor-content">
					<img src="/assets/projects/oct/images/logos/logo-onyx.png" height="50" />
					<img src="/assets/projects/oct/images/logos/logo-pms.png" height="50" />
				</span>
			</li>
			<li class="list-group-item">
				<span class="sponsor-heading bronze" data-toggle="tooltip" title="Bronze Sponsors"><span></span><span class="sponsor-icon bronze"></span>BRONZE SPONSORS</span>
				<span class="sponsor-content">
					<img src="/assets/projects/oct/images/logos/logo-gene.png" height="20" />
				</span>
			</li>
		</ul>
		<a class="btn btn-default btn-block" href="javascript:MR.modal.show('#oct-become-sponsor-modal');"><i class="glyphicon glyphicon-star"></i>&nbsp;&nbsp;Become A Sponsor</a>
	</div>
</div><!--/.mr-col-->
<div id="mr-col-middle" class="col-xs-6 mr-col">
	<?php get_player(array("control" => true)); ?>
		<?php get_ask_controls(array("navigation" => true, "ui" => true, "size" => 'medium')); ?>
	<div ng-hide="response.ask_controls.action == 'comment' || response.ask_controls.action == 'multiple_choice'">
		<?php get_video_text(array("share" => true)); ?>
	</div>
		<div class="mr-comments-box" style="overflow-y:scroll; margin-top:5px; background:#FFF;" id="enr-test-box" ng-show="response.ask_controls.action == 'comment' || response.ask_controls.action == 'multiple_choice'">
			<form ng-show="response.ask_controls.action == 'comment'" role="form" ng-submit="check_spelling(submit_comment());">
			<div class="mr-test-questions" ng-repeat="q in test.questions">
				<h5 class="video-text-title-quiz"><span ng-show="test.previous_question_answer">You answered: <em>{{test.previous_question_answer}}</em>. </span>{{ q.question }}</h5>
			</div>
			<textarea autofocus class="form-control" ng-model="testData" id="mr-comment-text" placeholder="Type your comment here" spellcheck="true" maxlength="500"></textarea>
				<button class="btn btn-primary pull-right" type="submit">Answer <i class="icon glyphicon glyphicon-pencil"></i></button>
				<a ng-show="response.video_controls.next_id" ng-click="submit_comment(true)" class="btn btn-default">Skip <i class="icon glyphicon glyphicon-chevron-right"></i></a>
			</form>
			<form ng-show="response.ask_controls.action == 'multiple_choice'" role="form" ng-submit="check_spelling(submit_multiple_choice());">
			<div class="mr-test-questions" ng-repeat="q in test.questions">
				<h5 class="video-text-title-quiz">{{ q.question }}</h5>
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
			<div class="returning-user-buttons">
				<div class="panel-heading">Options:</div>
				<div class="panel-body">
					<a class="btn btn-primary btn-block" href="#/LRQ/oct155" ng-if="response.show_feedback_button && response.id != 'oct155' && response.id != 'oct156' && response.id != 'oct141' && response.id != 'oct142' && response.id != 'oct143' && response.id != 'oct144' && response.id != 'oct145' && response.id != 'oct156z'">Submit Feedback</a>
					<a href="#/START/<?php get_welcome_video(); ?>" class="btn btn-default btn-block" ng-hide="response.id == 'oct001'">Return to the beginning</a>
					<button id="mr-return-button" ng-if="returningUser != 'true' || skip_last_response_save == true" ng-hide="response.id == 'oct001' || user_action == 'NEXT' || user_action == 'PREVIOUS' || user_action == 'A' || user_action == 'RETURN'" class="btn btn-default btn-block" type="button" ng-click="load_returning_user_state();">Return where you left off</button>
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
						<p class="mr-playlist-text">{{ playlist.display_text }}</p>
						<div style="clear:both;"></div>
					</div>
				</div>
			</div>
			<?php get_related_questions(); ?>
			<?php get_survey(); ?>
		</div>
	</div>
</div><!--/.mr-col-->

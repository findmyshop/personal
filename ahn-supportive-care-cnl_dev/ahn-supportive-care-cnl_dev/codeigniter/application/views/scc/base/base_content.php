<div id="mr-col-left" class="col-xs-3 mr-col">
	<?php get_left_rail(array("after" => '
			<li class="left-rail-panel left-rail-heading left-rail-direct-link">
				<a data-rid="scc213" href="#/LRQ/scc213" class="left-rail-heading-link" title="Walk me through my options">
					<i class="icon glyphicon glyphicon-share-alt"></i> Walk Me Through My Options
				</a>
			</li>')); ?>
</div><!--/.mr-col-->
<div id="mr-col-middle" class="col-xs-6 mr-col">
	<?php get_player(array("control" => true)); ?>
	<?php get_ask_controls(array("size" => "medium", "navigation" => true, "after" => '<div id="mr-quiz-row" class="mr-input-row">
<form class="input-group btn-group" ng-switch-when="log" role="form" action="" ng-submit="log_user_input()">
					<input class="form-control" ng-model="$parent.user_input_question" id="user_input_question" type="text" placeholder="Answer question" maxlength="200">
					<span class="input-group-btn">
						<button class="btn btn-default ask-button" type="submit">Answer <i class="icon glyphicon glyphicon-pencil"></i></button>
					</span>
				</form>
				<form class="input-group btn-group" ng-switch-when="options" role="form" action="">
					<a data-toggle="tooltip" href="#/LRQ/scc213" title="Review Options" class="btn btn-primary">Review Options <i class="icon glyphicon glyphicon-info-sign"></i></a>
				</form>
				<form class="input-group btn-group" ng-switch-when="fb-intro" role="form" action="">
					<a class="btn btn-primary" href="#/LRQ/scc180">Yes, take survey</a>
					<a class="btn btn-primary" href="#/LRQ/scc186">No, ask me later</a>
				</form>
				<form class="input-group btn-group" ng-switch-when="fb-1" role="form" action="" ng-submit="store_feedback_answer(1, $parent.store_feedback_question)">
					<input class="form-control" ng-model="$parent.store_feedback_question" id="store_feedback_question" type="text" placeholder="Who is answering these questions?" maxlength="200">
					<span class="input-group-btn">
						<button class="btn btn-default ask-button" type="submit">Answer <i class="icon glyphicon glyphicon-pencil"></i></button>
					</span>
				</form>
				<form class="input-group btn-group" ng-switch-when="fb-2" role="form" action="">
					<button class="btn btn-primary survey-button" ng-click="store_feedback_answer(2, 1)">Not at all helpful</button>
					<button class="btn btn-primary survey-button" ng-click="store_feedback_answer(2, 2)">Somewhat helpful</button>
					<button class="btn btn-primary survey-button" ng-click="store_feedback_answer(2, 3)">Very helpful</button>
					<button class="btn btn-primary survey-button" ng-click="store_feedback_answer(2, 4)">Extremely helpful</button>
				</form>
				<form class="input-group btn-group" ng-switch-when="fb-3" role="form" action="">
					<button class="btn btn-primary survey-button" ng-click="store_feedback_answer(3, 1)">Not at all likely</button>
					<button class="btn btn-primary survey-button" ng-click="store_feedback_answer(3, 2)">Somewhat likely</button>
					<button class="btn btn-primary survey-button" ng-click="store_feedback_answer(3, 3)">Very likely</button>
					<button class="btn btn-primary survey-button" ng-click="store_feedback_answer(3, 4)">Extremely likely</button>
				</form>
				<form class="input-group btn-group" ng-switch-when="fb-4" role="form" action="" ng-submit="store_feedback_answer(4, $parent.store_feedback_question)">
					<input class="form-control" ng-model="$parent.store_feedback_question" id="store_feedback_question" type="text" placeholder="Please tell us about your experience with this site, good and bad." maxlength="200">
					<span class="input-group-btn">
						<button class="btn btn-default ask-button" type="submit">Answer <i class="icon glyphicon glyphicon-pencil"></i></button>
					</span>
				</form>
				<form class="input-group btn-group" ng-switch-when="fb-5" role="form" action="" ng-submit="store_feedback_answer(5, $parent.store_feedback_question)">
					<input class="form-control" ng-model="$parent.store_feedback_question" id="store_feedback_question" type="text" placeholder="What information was most helpful to you?" maxlength="200">
					<span class="input-group-btn">
						<button class="btn btn-default ask-button" type="submit">Answer <i class="icon glyphicon glyphicon-pencil"></i></button>
					</span>
				</form>
				<form class="input-group btn-group" ng-switch-when="fb-6" role="form" action="" ng-submit="store_feedback_answer(6, $parent.store_feedback_question)">
					<input class="form-control" ng-model="$parent.store_feedback_question" id="store_feedback_question" type="text" placeholder="What additional information would you find helpful?" maxlength="200">
					<span class="input-group-btn">
						<button class="btn btn-default ask-button" type="submit">Answer <i class="icon glyphicon glyphicon-pencil"></i></button>
					</span>
				</form>
		</div>')); ?>
	<?php get_video_text(array("share" => true, "title" => false)); ?>
</div><!--/#middle-col-->
<div id="mr-col-right" class="col-xs-3 mr-col">
	<div id="related-questions" class="mr-is-wrapper">
		<div class="mr-is-scroller">
			<div class="alert alert-info" style="margin:5px;" ng-show="returningUser">
				<strong>*Note:</strong> Supportive Care Options is now an open access program. You no longer need an access code to use Supportive Care Options.
			</div>
			<div class="returning-user-buttons" ng-show="returningUser">
				<div class="panel-heading">Options:</div>
				<div class="panel-body">
					<a href="#/LRQ/scc212" class="btn btn-primary btn-block">Explore other topics</a>
					<?php if (USER_AUTHENTICATION_REQUIRED == 'true') : ?>
						<button class="btn btn-primary btn-block" type="button" ng-click="load_returning_user_state();">Return where you left off</button>
					<?php endif; ?>
					<a href="#/LRQ/<?php get_welcome_video(); ?>" class="btn btn-primary btn-block">Return to the beginning</a>
				</div>
			</div>
			<?php get_related_questions(); ?>
		</div>
	</div>
</div><!--/.mr-col--><!-- Left rail heading to add that link directly to something rather than have an accoridion	 -->


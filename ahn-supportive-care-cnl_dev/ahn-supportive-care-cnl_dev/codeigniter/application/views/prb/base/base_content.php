<div id="mr-col-left" class="col-xs-3 mr-col">
	<?php get_left_rail(); ?>
	<div class="mr-widget mr-button-widget">
		<a class="btn btn-primary btn-block" href="#/LRQ/prb008">Learn More</a>
	</div>
</div><!--/.mr-col-->
<div id="mr-col-middle" class="col-xs-6 mr-col">
	<?php get_player(array("control" => true)); ?>
	<div id="mr-input-row" class="basic-pad" ng-switch="response.ask_controls.action">
		<form class="input-group input-group-lg" role="form" action="" ng-switch-default ng-submit="check_spelling(call_analyzer())" >
			<input class="form-control" ng-model="$parent.input_question" id="input_question" type="text" placeholder="Enter your question here" maxlength="200">
			<span class="input-group-btn">
				<button id="mr-ask-submit" title="Ask a question" class="btn btn-primary ask-button" type='submit'><i class="icon glyphicon glyphicon-play"></i>Ask <?php get_mr_icon(); ?></button>
			</span>
		</form>
	</div><!--/.mr-input-row-->
	<?php get_video_text(); ?>
</div><!--/#middle-col-->
<div id="mr-col-right" class="col-xs-3 mr-col">
	<div id="related-questions" class="mr-is-wrapper">
		<div class="mr-is-scroller">
			<?php if (MR_DIRECTORY === '') : ?>
				<div class="returning-user-buttons" ng-show="returningUser">
					<div class="panel-heading">Options:</div>
					<div class="panel-body">
						<button class="btn btn-primary btn-block" type="button" ng-click="load_returning_user_state();">Return where you left off</button>
						<?php /* <a href="#/LRQ/<?php get_welcome_video(); ?>" class="btn btn-primary btn-block">Return to the beginning</a> */ ?>
					</div>
				</div>
			<?php endif; ?>
			<?php get_related_questions(); ?>

			<?php get_survey(); ?>

		</div>
	</div>
</div><!--/.mr-col-->

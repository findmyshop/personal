<div id="mr-col-left" class="col-xs-3 mr-col">
	<?php get_left_rail(); ?>
</div><!--/.mr-col-->
<div id="mr-col-middle" class="col-xs-6 mr-col">
	<?php get_player(array("control" => true)); ?>
	<div id="mr-input-row" class="basic-pad" ng-switch="response.ask_controls.action">
		<form class="input-group input-group-lg" role="form" action="" ng-switch-default ng-submit="check_spelling(call_analyzer())" >
			<input class="form-control" ng-model="$parent.input_question" id="input_question" type="text" placeholder="Enter your question heres" maxlength="200">
			<span class="input-group-btn">
				<button id="mr-ask-submit" title="Ask a question" class="btn btn-primary ask-button" type='submit'><i class="icon glyphicon glyphicon-play"></i>Ask <?php get_mr_icon(); ?></button>
			</span>
		</form>

		<div ng-show="show_facebook_share_button" id="fb-share-button-wrapper" class="fb-share-button" data-href="" data-layout="button_count" data-size="small" data-mobile-iframe="true">
				<a id="fb-share-button-link" class="fb-xfbml-parse-ignore" target="_blank" href="">Share</a>
		</div>
	</div><!--/.mr-input-row-->
	<?php get_video_text(); ?>
</div><!--/#middle-col-->
<div id="mr-col-right" class="col-xs-3 mr-col">
	<div id="related-questions" class="mr-is-wrapper">
		<div class="mr-is-scroller">
			<?php /* We only want this return to flow button under these circumstances. */
			if (MR_DIRECTORY === '' && USER_AUTHENTICATION_REQUIRED) : ?>
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

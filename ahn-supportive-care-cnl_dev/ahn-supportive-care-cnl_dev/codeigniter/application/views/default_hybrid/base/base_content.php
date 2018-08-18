<div id="mr-col-left" class="col-xs-3 mr-col">
	<?php get_left_rail(); ?>
</div><!--/.mr-col-->
<div id="mr-col-middle" class="col-xs-6 mr-col">
	<?php get_player(array("control" => true)); ?>
		<?php get_ask_controls(array("navigation" => true, "ui" => true, "size" => 'medium')); ?>
	<?php get_video_text(); ?>
</div><!--/#middle-col-->
<div id="mr-col-right" class="col-xs-3 mr-col">
	<div id="related-questions" class="mr-is-wrapper">
		<div class="mr-is-scroller">
			<?php /* We only want this return to flow button under these circumstances. */
			if (MR_DIRECTORY === '' && USER_AUTHENTICATION_REQUIRED) : ?>
			<div class="returning-user-buttons" ng-show="returningUser != 'false' || skip_last_response_save == true ">
				<div class="panel-heading">Options:</div>
				<div class="panel-body">
					<button class="btn btn-primary btn-block" type="button" ng-click="load_returning_user_state();">Return where you left off</button>
					<a href="#/LRQ/<?php get_welcome_video(); ?>" class="btn btn-primary btn-block">Return to the beginning</a>
				</div>
			</div>
		<?php endif; ?>
		<?php get_related_questions(); ?>
		</div>
	</div>
</div><!--/.mr-col-->
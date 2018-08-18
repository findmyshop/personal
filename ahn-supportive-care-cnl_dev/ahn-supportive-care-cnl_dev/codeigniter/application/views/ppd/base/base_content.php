<div id="mr-col-left" class="col-xs-3 mr-col">
	<?php get_left_rail(); ?>
	<div class="mr-widget mr-button-widget">
		<div class="panel-heading">Our Sponsors:</div>
		<ul class="panel-body">
			<li class="list-group-item">
				<span class="sponsor-heading gold" data-toggle="tooltip" title="Gold Sponsors"><span class="sponsor-icon gold"></span>GOLD SPONSORS</span>
				<span class="sponsor-content">
					<a href="http://www.alexisjoyfoundation.org/" target="_blank"><img src="/assets/projects/ppd/images/logos/logo-alexis-joy-foundation.png" height="50" /></a>
				</span>
			</li>
		</ul>
		<!--<a class="btn btn-default btn-block" href="javascript:MR.modal.show('#oct-become-sponsor-modal');"><i class="glyphicon glyphicon-star"></i>&nbsp;&nbsp;Become A Sponsor</a>-->
	</div>
</div><!--/.mr-col-->
<div id="mr-col-middle" class="col-xs-6 mr-col">
	<?php get_player(array("control" => true)); ?>
		<?php get_ask_controls(array("navigation" => true, "ui" => true, "size" => 'medium')); ?>
	<?php get_video_text(array("share" => true)); ?>
</div><!--/#middle-col-->
<div id="mr-col-right" class="col-xs-3 mr-col">
	<div id="related-questions" class="mr-is-wrapper">
		<div class="mr-is-scroller">
			<?php /* We only want this return to flow button under these circumstances. */
			if (MR_DIRECTORY === '' && USER_AUTHENTICATION_REQUIRED) : ?>
			<div class="returning-user-buttons" ng-show="returningUser != 'false' || skip_last_response_save == true">
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

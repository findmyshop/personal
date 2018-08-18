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
	<?php get_player(array("control" => true)); ?>
	<?php get_ask_controls(array("navigation" => true,
																"ui" => true,
																"size" => 'medium')); ?>
	<div id="video-text-div"></div>
</div><!--/#middle-col-->

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
	<?php get_player(array("control" => true,"before" => '<div ng-show="response.ask_controls.action == \'test\'" id="mr-test-controls"><a id="mr-test-controls-prev" ng-show="response.video_controls.previous_id" href="#/NEXT/{{response.video_controls.previous_id}}"></a><a id="mr-test-controls-open" href="javascript:MR.modal.show(\'#test-modal\',true);"><div id="mr-test-title">{{ test.test_name }}</div></a><a id="mr-test-controls-next" ng-show="response.video_controls.next_id" href="#/NEXT/{{response.video_controls.next_id}}"></a></div>')); ?>
	<?php get_ask_controls(array("navigation" => true,
																"ui" => true,
																"size" => 'medium')); ?>
	<div id="video-text-div"></div>
</div><!--/#middle-col-->

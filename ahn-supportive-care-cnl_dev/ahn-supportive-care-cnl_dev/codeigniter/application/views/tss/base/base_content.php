<div id="mr-col-middle" class="control-container container-fluid container">
	<div id="tss-left-col" class="col-sm-8">
			<?php get_player(array("control" => true)); ?>
	</div>
	<div id="tss-right-col" class="col-sm-4">
			<?php get_video_text(); ?>
	</div>
	<div style="clear:both;"></div>
	<div ng-show="response.type !== 'flow_decision' && response.ask_controls.hidden == 'false'">
		<div ng-cloak id="mr-input-row" class="basic-pad" ng-switch="response.ask_controls.action" ng-show="response.ask_controls.action != 'multiple_choice' && response.ask_controls.action != 'comment'">
			<form class="input-block-level" role="form" name="analyzer_form" ng-submit="check_spelling(call_analyzer());">
				<textarea ng-cloak ng-model="input_question" id="user-query" class="form-control" name="user_query" placeholder="Type your answer here" rows="3" maxlength="201"></textarea>
				<button ng-cloak id="mr-ask-submit" class="btn btn-primary btn-block btn-lg" type="submit">Submit</button>
			</form>
		</div>
	</div>
	<div id="comments-box">
		<div class="mr-comments-box" ng-show="response.type == 'flow_decision'">
			<div class="mr-decision" ng-repeat="d in response.decisions">
				<button onClick="TSS.core.setChoice(this);" class="btn btn-secondary btn-block flow-decision" data-href="#/NEXT/{{d.rid}}">{{d.display_text}}</button>
			</div>
			<a id="mr-choice-submit" href="#" class="btn btn-primary btn-block btn-lg" role="button" disabled="disabled">Submit</a>
		</div>
	</div>
	<div class="row prev-next-controls" ng-show="response.type !== 'flow_decision'">
		<div class="col-xs-6 prev">
			<a title="Previous" class="btn btn-secondary btn-block" ng-disabled="!response.video_controls.previous_id" href="#/NEXT/{{response.video_controls.previous_id}}"><i class="glyphicon glyphicon-chevron-left"></i> Previous</a>
		</div>
		<div class="col-xs-6 next" ng-show="returningUser == 'false'">
			<a title="Next" class="btn btn-secondary btn-block" ng-disabled="!response.video_controls.next_id" href="#/NEXT/{{response.video_controls.next_id}}">Next <i class="glyphicon glyphicon-chevron-right"></i></a>
		</div>
		<div class="col-xs-6 next" ng-show="returningUser != 'false'">
			<a title="Continue" class="btn btn-secondary btn-block" ng-click="load_returning_user_state();">Continue <i class="glyphicon glyphicon-chevron-right"></i></a>
		</div>
	</div>
</div><!--/#middle-col-->

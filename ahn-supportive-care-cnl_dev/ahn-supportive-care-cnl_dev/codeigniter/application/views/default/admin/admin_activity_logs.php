	<div class="panel panel-default" ng-model="users" load-activity-logs load-usernames>
		<div class="panel-heading">
				<?php if(USER_AUTHENTICATION_REQUIRED): ?>
				<div class="input-group input-group-sm pull-left">
					<div ng-dropdown-multiselect=""
						options="username_filter.elements"
						selected-model="username_filter.selected_elements"
						extra-settings="username_filter.settings"
						translation-texts="username_filter.translation_texts"
						events="{
							onItemSelect: refresh_activity_logs,
							onItemDeselect: refresh_activity_logs
					 }"></div>
				</div>
				<?php endif; ?>
				<div style="width:26%" class="input-group input-group-sm pull-right">
					<input type="text" class="form-control" id="search_keyword" name="search_keyword" ng-model="search_keyword" placeholder="Enter search term"/>
					<span class="input-group-btn">
						<button type="button" class="btn btn-default btn-xs pull-right" refresh-activity-logs onclick="refresh_activity_logs();"><i class="glyphicon glyphicon-refresh"></i></button>
					</span>
					<span class="input-group-btn">
						<button type="button" class="btn btn-default" export-activity-log><i class="glyphicon glyphicon-export"></i> Export CSV</button>
					</span>
				</div><!--/.input-group-->
				<div class="input-group input-group-sm pull-left" ng-repeat="level in organization_hierarchy.filter.levels.slice().reverse()">
					<select class="form-control" ng-model="organization_hierarchy.filter.selected_element_ids[level.organization_hierarchy_level_id]"
						ng-options="element.organization_hierarchy_level_element_id as element.organization_hierarchy_level_element_name for element in elements = get_filter_organization_hierarchy_level_elements(level)"
						ng-change="refresh_activity_logs();">
					</select>
				</div>
				<div style="width:30%" class="pull-left"><?php get_date_picker(); ?></div>
				<?php if(HAS_ASL_VIDEOS): ?>
					<span class="input-group input-group-sm pull-right" style="width:20%;">
						<span class="input-group-addon input-group-sm">
							<i class="mr-status-label glyphicon glyphicon-share"></i> Language:
						</span>
						<select class="form-control" ng-model="activity_logs_language_filter" name="activity_logs_language_filter" ng-change="refresh_activity_logs();">
							<option value="all">All</option>
							<option value="english">English</option>
							<option value="asl">American Sign Language</option>
						</select>
					</span>
				<?php endif; ?>
				<?php if(!empty($mr_project_filter)): ?>
					<span style="width:20%" class="input-group input-group-sm pull-right">
						<span class="input-group-addon input-group-sm">
							<i class="mr-status-label glyphicon glyphicon-share"></i> Property:
						</span>
						<select class="form-control" ng-model="activity_logs_mr_project_filter" name="activity_logs_mr_project_filter" ng-change="refresh_activity_logs();">
						<?php foreach($mr_project_filter as $value => $option): ?>
							<option value="<?php echo $value ?>"><?php echo $option ?></option>
						<?php endforeach; ?>
						</select>
					</span>
				<?php endif; ?>
		<div style="clear:both;"></div>
	</div><!--/.panel-heading-->
<!-- Filtering controls -->
<div id="file_upload_spinner" style="text-align:center; width:100%; color: red;"></div>
<span id="exort_csv_error_message"></span>
<form class="form-horizontal pull-right" role="form" name="search_form" ng-cloak></form>
<!-- Log table -->
<?php
$uaq = USER_AUTHENTICATION_REQUIRED;
$args = array(
'ng_directive' => 'activity-logs-scroll',
'ng_repeat' => 'log',
'type' => 'table',
'sort_on' => 'date',
'spinner' => '<tr ng-model="ready_for_more_activity_log_entries" ng-show="show_spinner==\'1\'"><td colspan="6"><i class="fa fa-spinner fa-spin fa-2x" style="text-align:center; width:100%"></i></td></tr>',
'ng_model' => 'filtered_activity_logs',
'icon' => 'list-alt',
'ng_action' => 'data-toggle="modal" data-target="#show_log_modal" log-id="{{log.id}}" load-activity-log',
	'columns' => array(
		array('title' => ($uaq) ? 'Username' : 'Session', 'ng_data' => ($uaq) ? 'username' : 'session_id'),
		array('title' => 'Browser', 'ng_data' => 'browser', 'data_type' => 'html', 'show' => is_admin()),
		array('title' => 'Action', 'ng_data' => 'action' ),
		array('title' => 'Input Question', 'ng_data' => 'input_question'),
		array('title' => 'Response Question', 'ng_data' => 'response_question'),
		array('title' => 'Date', 'ng_data' => 'date')
	));
build_data_panel($args); ?>

</div><!--/.panel-->
<!-- Show Log Modal -->
<div modal-show modal-visible="showInfoDialog" class="modal fade" id="show_log_modal" tabindex="-1" role="dialog" aria-labelledby="show_log_modal_label" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content" ng-model="selected_activity_log">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h4 class="modal-title" id="show_log_modal_label">Log Information</h4>
</div>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Field</th>
			<th>Value</th>
		</tr>
	</thead>
	<tbody>
		<tr ng-repeat="(key, value) in selected_activity_log" ng-cloak>
			<td ng-if="!!value">{{key}}</td>
			<td ng-if="!!value" ng-bind-html="value"></td>
		</tr>
	</tbody>
</table>
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove"></i> Close</button>
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- / Show Log Modal -->

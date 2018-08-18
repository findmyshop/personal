<div ng-controller="defaultDashboardController">
<div class="modal fade mr-printable" id="sd-modal" tabindex="-1" role="dialog" aria-labelledby="sd-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" id="print-div">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="sd-modal-label">Session Details</h4>
			</div>
				<?php
				$args = array(
									'id' => 'session-detail-panel',
									'title' => 'Session: {{data_row_clicked}}',
									'ng_model' => 'session_detail.data',
									'ng_repeat' => 'r',
									'sort_on' => 'date',
									'icon' => 'list-alt',
									'ng_action' => 'data-modal-id="#course-details-modal" data-course-name="{{cc.course_name}}" toggle-course-detail="{{cc.course_id}}" current_iteration="{{cc.current_iteration}}"',
									'columns' => array(
										array('title' => 'Date', 'ng_data' => 'date'),
										array('title' => 'Platform', 'ng_data' => 'platform', 'data_type' => 'html'),
										array('title' => 'Action', 'ng_data' => 'action'),
										array('title' => 'Input Question', 'ng_data' => 'input_question'),
										array('title' => 'Response ID', 'ng_data' => 'response_id'),
										array('title' => 'Response Question', 'ng_data' => 'response_question'),
										array('title' => 'Response Type', 'ng_data' => 'response_type')
								));
				build_data_panel($args); ?>
			<div class="modal-footer mr-no-print">
				<button type="button" onClick="$('#print-div').print();" class="btn btn-default"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> Print</button>
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove" aria-hidden="true"></i> Close</button>
			</div>
		</div>
	</div>
</div>
<div class="panel panel-default" ng-model="usage_data" load-usernames load-usage-data ng-cloak>
		<div class="panel-heading">
			<?php if(MR_PROJECT === 'oct'): ?>
				<span class="input-group input-group-sm pull-right">
					<button type="button" class="btn btn-default btn-sm" export-feedback-logs><i class="glyphicon glyphicon-export"></i> Export Feedback Logs</button>
				</span>
			<?php endif; ?>

			<?php if(MR_PROJECT === 'enr'): ?>
				<span class="input-group input-group-sm pull-right">
					<button type="button" class="btn btn-default btn-sm" export-survey-logs><i class="glyphicon glyphicon-export"></i> Export Survey Logs</button>
				</span>
			<?php endif; ?>

			<?php if(USER_AUTHENTICATION_REQUIRED): ?>
				<span class="input-group input-group-sm pull-right">
					<button type="button" class="btn btn-default btn-sm" export-session-spreadsheet><i class="glyphicon glyphicon-export"></i> Export Session Spreadsheet</button>
				</span>
			<?php endif; ?>

			<div class="input-group input-group-sm pull-right" ng-repeat="level in organization_hierarchy.filter.levels.slice().reverse()">
				<select class="form-control" ng-model="organization_hierarchy.filter.selected_element_ids[level.organization_hierarchy_level_id]"
					ng-options="element.organization_hierarchy_level_element_id as element.organization_hierarchy_level_element_name for element in elements = get_filter_organization_hierarchy_level_elements(level)"
					ng-change="get_usage_data()">
				</select>
			</div>
			<?php if(USER_AUTHENTICATION_REQUIRED): ?>
			<div class="input-group input-group-sm pull-right">
				<div ng-dropdown-multiselect=""
					options="username_filter.elements"
					selected-model="username_filter.selected_elements"
					extra-settings="username_filter.settings"
					translation-texts="username_filter.translation_texts"
					events="{
						onItemSelect: get_usage_data,
						onItemDeselect: get_usage_data
				 }"></div>
			</div>
			<?php endif; ?>
			<?php if(!empty($mr_project_filter)): ?>
				<span class="input-group input-group-sm pull-right" style="width:30%;">
					<span class="input-group-addon input-group-sm">
						<i class="mr-status-label glyphicon glyphicon-share"></i> Property:
					</span>
					<select class="form-control" ng-model="mr_project_filter" name="mr_project_filter" ng-change="get_usage_data();">
					<?php foreach($mr_project_filter as $value => $option): ?>
						<option value="<?= $value ?>"><?= $option ?></option>
					<?php endforeach; ?>
					</select>
				</span>
			<?php endif; ?>

			<div class="col-xs-2">
				<h1 class="panel-title">Dashboard</h1>
			</div><!--/.col-->
			<div style="clear:both;"></div>
		</div><!--/.panel-heading-->
		</div><!--/.panel-body-->
			<div class="panel-body" role="tabpanel">
				<!-- Nav tabs -->
				<ul class="nav nav-pills" role="tablist">
					<li class="ct-report-tabs active" role="presentation"><a href="#summary" aria-controls="summary" role="tab" data-toggle="tab">
					<i class="glyphicon glyphicon-eye-open"></i>
					Summary</a></li>

					<?php if(is_admin()): ?>
					<li class="ct-report-tabs" role="presentation"><a href="#modified-summary" aria-controls="modified-summary" role="tab" data-toggle="tab">
					<i class="glyphicon glyphicon-eye-open"></i>
					Modified Summary</a></li>
					<?php endif; ?>

					<?php if (!PRIVATE_DATA) : ?>
					<li class="ct-report-tabs" role="presentation"><a href="#most-frequently-asked-questions" aria-controls="most-frequently-asked-questions" role="tab" data-toggle="tab">
					<i class="glyphicon glyphicon-time"></i>
					Most Frequently Asked Questions</a></li>
					<?php endif; ?>
					<?php if(SHOW_RESPONSES_VIEWED_DATA): ?>
					<li class="dropdown ct-report-tabs">
						<a class="dropdown-toggle" data-toggle="tab" href="#">Responses Viewed
						<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="#responses-viewed" aria-controls="responses-viewed" role="tab" data-toggle="tab">All</a></li>
							<li><a href="#responses-viewed-via-user-questions" aria-controls="responses-viewed-via-user-questions" role="tab" data-toggle="tab">Via User Questions</a></li>
							<li><a href="#responses-viewed-via-related-questions" aria-controls="responses-viewed-via-related-questions" role="tab" data-toggle="tab">Via Related Questions</a></li>
							<li><a href="#responses-viewed-via-left-rail-questions" aria-controls="responses-viewed-via-left-rail-questions" role="tab" data-toggle="tab">Via Left Rail Questions</a></li>
							<?php if(SHOW_RESPONSES_VIEWED_PER_CATEGORY_DATA): ?>
								<li><a href="#responses-viewed-per-category" aria-controls="responses-viewed-per-category" role="tab" data-toggle="tab">Per Category</a></li>
							<?php endif; ?>
						</ul>
					</li>
					<?php endif; ?>
					<li class="dropdown ct-report-tabs">
						<a class="dropdown-toggle" data-toggle="tab" href="#"><i class="glyphicon glyphicon-list-alt"></i> Sessions
						<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<?php if(is_admin()): ?>
								<li>
									<a href="#session-data" aria-controls="session-data" role="tab" data-toggle="tab">Session Data</a>
								</li>
								<li>
									<a href="#modified-session-data" aria-controls="modified-session-data" role="tab" data-toggle="tab">Modified Session Data</a>
								</li>
								<li>
									<a href="#session-count-frequencies" aria-controls="session-count-frequencies" role="tab" data-toggle="tab">Session Count Frequencies</a>
								</li>
								<li>
									<a href="#modified-session-count-frequencies" aria-controls="modified-session-count-frequencies" role="tab" data-toggle="tab">Modified Session Count Frequencies</a>
								</li>
								<li>
									<a href="#modified-session-data-graph" aria-controls="modified-session-data-graph" role="tab" data-toggle="tab">Modified Session Data Graph</a>
								</li>
							<?php else: ?>
								<li>
									<a href="#session-data" aria-controls="session-data" role="tab" data-toggle="tab">Session Data</a>
								</li>
								<li>
									<a href="#session-count-frequencies" aria-controls="session-count-frequencies" role="tab" data-toggle="tab">Session Count Frequencies</a>
								</li>
								<li>
									<a href="#session-data-graph" aria-controls="session-data-graph" role="tab" data-toggle="tab">Session Data Graph</a>
								</li>
							<?php endif; ?>
						</ul>
					</li>

					<?php if(property_has_surveys()): ?>
					<li class="ct-report-tabs" role="presentation"><a href="#surveys" aria-controls="surveys" role="tab" data-toggle="tab">
					<i class="glyphicon glyphicon-list-alt"></i>
					Surveys</a></li>
					<?php endif; ?>
				</ul>
			</div>
			<!-- Tab panes -->
			<div class="tab-content">
				<?php if(is_admin()): ?>
					<!-- summary tab -->
					<div role="tabpanel" class="tab-pane active" id="summary">
						<div class="row" style="margin-bottom:10px;">
							<div class="col-xs-12">
									<button type="button" class="btn btn-default pull-right" ng-click="export_csv('usage_summary', [usage_data.usage_summary]);"><i class="glyphicon glyphicon-export"></i>Export Summary CSV</button>
							</div>
						</div>
						<table class="table table-striped">
							<tr>
								<?php if(USER_AUTHENTICATION_REQUIRED): ?>
									<td><b>Total Number of User Logins (sessions)</b></td>
								<?php else: ?>
									<td><b>Total Number of User Sessions</b></td>
								<?php endif; ?>
								<td ng-cloak>{{usage_data.usage_summary.number_of_sessions}}</td>
							</tr>
							<?php if(SHOW_RESPONSES_VIEWED_DATA): ?>
							<tr>
								<td><b>Total Number of Responses Viewed</b></td>
								<td ng-cloak>{{usage_data.usage_summary.number_of_responses_viewed}}</td>
							</tr>
							<?php if (!PRIVATE_DATA) : ?>
							<tr>
								<td><b>Total Number of Individual Responses Viewed via User Questions</b></td>
								<td ng-cloak>{{usage_data.usage_summary.number_of_responses_viewed_via_user_questions}}</td>
							</tr>
							<?php endif; ?>
							<tr>
								<td><b>Total Number of Responses Viewed via Related Questions</b></td>
								<td ng-cloak>{{usage_data.usage_summary.number_of_responses_viewed_via_related_questions}}</td>
							</tr>
							<tr>
								<td><b>Total Number of Responses Viewed via Left Rail Questions</b></td>
								<td ng-cloak>{{usage_data.usage_summary.number_of_responses_viewed_via_left_rail_questions}}</td>
							</tr>
							<?php endif; ?>
							<tr>
								<td><b>Average Session Duration</b></td>
								<td ng-cloak>{{usage_data.usage_summary.average_session_duration}} min</td>
							</tr>
							<?php if (!PRIVATE_DATA) : ?>
							<tr>
								<td><b>Average Number of Questions Asked per Session</b></td>
								<td ng-cloak>{{usage_data.usage_summary.number_of_responses_viewed_via_user_questions / usage_data.usage_summary.number_of_sessions|number:2}}</td>
							</tr>
							<?php endif; ?>
							<tr ng-if="usage_data.session_speaker_selections" ng-repeat="speaker_option in usage_data.session_speaker_selections">
								<td><b>{{speaker_option.name}} Speaker Selections</b></td>
								<td ng-cloak>{{speaker_option.count}}</td>
							</tr>
						</table>
					</div>
					<!-- end summary tab -->
				<?php endif; ?>

				<!-- modified summary tab -->
				<div role="tabpanel" class="tab-pane <?php echo (is_site_admin()) ? 'active' : '' ?>" id="<?php echo (is_admin()) ? 'modified-summary' : 'summary' ?>">
					<div class="row" style="margin-bottom:10px;">
					<?php if(is_admin()): ?>
						<div class="col-xs-9">
							<div class="alert alert-warning" role="alert"><i class="glyphicon glyphicon-warning-sign"></i>&nbsp;Modified Session Data is updated daily at 4:00 UTC</div>
						</div>
						<div class="col-xs-12">
								<button type="button" class="btn btn-default pull-right" ng-click="export_csv('usage_summary', [usage_data.modified_usage_summary]);"><i class="glyphicon glyphicon-export"></i>Export Modified Summary CSV</button>
						</div>
					<?php else: ?>
						<div class="col-xs-9">
							<div class="alert alert-warning" role="alert"><i class="glyphicon glyphicon-warning-sign"></i>&nbsp;Session Data is updated daily at 4:00 UTC</div>
						</div>
						<div class="col-xs-3">
							<button type="button" class="btn btn-default pull-right" ng-click="export_csv('usage_summary', [usage_data.modified_usage_summary]);"><i class="glyphicon glyphicon-export"></i>Export Summary CSV</button>
						</div>
					<?php endif; ?>
					</div>

					<table class="table table-striped">
						<tr>
							<?php if(USER_AUTHENTICATION_REQUIRED): ?>
								<td><b>Total Number of User Logins (sessions)</b></td>
							<?php else: ?>
								<td><b>Total Number of User Sessions</b></td>
							<?php endif; ?>
							<td ng-cloak>{{usage_data.modified_usage_summary.number_of_sessions}}</td>
						</tr>
						<?php if(SHOW_RESPONSES_VIEWED_DATA): ?>
						<tr>
							<td><b>Total Number of Responses Viewed</b></td>
							<td ng-cloak>{{usage_data.modified_usage_summary.number_of_responses_viewed}}</td>
						</tr>
						<?php if (!PRIVATE_DATA) : ?>
						<tr>
							<td><b>Total Number of Individual Responses Viewed via User Questions</b></td>
							<td ng-cloak>{{usage_data.modified_usage_summary.number_of_responses_viewed_via_user_questions}}</td>
						</tr>
						<?php endif; ?>
						<tr>
							<td><b>Total Number of Responses Viewed via Related Questions</b></td>
							<td ng-cloak>{{usage_data.modified_usage_summary.number_of_responses_viewed_via_related_questions}}</td>
						</tr>
						<tr>
							<td><b>Total Number of Responses Viewed via Left Rail Questions</b></td>
							<td ng-cloak>{{usage_data.modified_usage_summary.number_of_responses_viewed_via_left_rail_questions}}</td>
						</tr>
						<?php endif; ?>
						<tr>
							<td><b>Average Session Duration</b></td>
							<td ng-cloak>{{usage_data.modified_usage_summary.average_session_duration}} min</td>
						</tr>
						<?php if (!PRIVATE_DATA) : ?>
						<tr>
							<td><b>Average Number of Questions Asked per Session</b></td>
							<td ng-cloak>{{usage_data.modified_usage_summary.number_of_responses_viewed_via_user_questions / usage_data.modified_usage_summary.number_of_sessions|number:2}}</td>
						</tr>
						<?php endif; ?>
						<tr ng-if="modified_usage_data.session_speaker_selections" ng-repeat="speaker_option in modified_usage_data.session_speaker_selections">
							<td><b>{{speaker_option.name}} Speaker Selections</b></td>
							<td ng-cloak>{{speaker_option.count}}</td>
						</tr>
					</table>
				</div>
				<!-- end modified sumary tab -->

				<!-- most frequently asked questions tab -->
				<div role="tabpanel" class="tab-pane" id="most-frequently-asked-questions">
					<div class="row" style="margin-bottom:10px;">
						<div class="col-xs-12">
								<button type="button" class="btn btn-default pull-right" ng-click="export_csv('most_frequently_asked_questions', usage_data.most_frequently_asked_questions);"><i class="glyphicon glyphicon-export"></i>Export Most Frequently Asked Questions CSV</button>
						</div>
					</div>

					<?php
					$args = array(
					'id' => 'most-frequently-asked-questions-panel',
					'ng_repeat' => 'question',
					'type' => 'table',
					'sort_on' => 'number_of_times_asked',
					'ng_model' => 'usage_data.most_frequently_asked_questions',
					'ng_action' => '',
					'columns' => array(
						array('title' => 'Question Asked by User', 'ng_data' => 'question'),
						array('title' => 'Associated # of Occurrences', 'ng_data' => 'number_of_times_asked'),
					));
					build_data_panel($args); ?>
				</div>
				<!-- end most frequently asked questions tab -->

				<?php if(SHOW_RESPONSES_VIEWED_DATA): ?>
					<!-- all responses viewed tab -->
					<div role="tabpanel" class="tab-pane" id="responses-viewed">
						<div class="row" style="margin-bottom:10px;">
							<div class="col-xs-12">
									<button type="button" class="btn btn-default pull-right" ng-click="export_csv('responses_viewed', usage_data.responses_data.all_responses);"><i class="glyphicon glyphicon-export"></i>Export Responses Viewed CSV</button>
							</div>
						</div>

						<?php
						$args = array(
						'id' => 'all-responses-viewed-panel',
						'ng_repeat' => 'response',
						'type' => 'table',
						'sort_on' => 'number_of_times_viewed',
						'ng_model' => 'usage_data.responses_data.all_responses',
						'ng_action' => '',
						'columns' => array(
							array('title' => 'Response ID', 'ng_data' => 'response_id'),
							array('title' => 'Base Question', 'ng_data' => 'base_question'),
							array('title' => '# Views', 'ng_data' => 'number_of_times_viewed'),
						));
						build_data_panel($args); ?>
					</div>
				<!-- end all responses viewed tab -->


				<?php if (!PRIVATE_DATA) : ?>
					<!-- responses viewed via user questions tab -->
					<div role="tabpanel" class="tab-pane" id="responses-viewed-via-user-questions">
						<div class="row" style="margin-bottom:10px;">
							<div class="col-xs-12">
									<button type="button" class="btn btn-default pull-right" ng-click="export_csv('responses_viewed_user_questions', usage_data.responses_data.user_question_responses);"><i class="glyphicon glyphicon-export"></i>Export Responses Viewed Via User Questions CSV</button>
							</div>
						</div>

						<?php
						$args = array(
						'id' => 'responses-viewed-via-user-questions-panel',
						'ng_repeat' => 'response',
						'type' => 'table',
						'sort_on' => 'number_of_times_viewed',
						'ng_model' => 'usage_data.responses_data.user_question_responses',
						'ng_action' => '',
						'columns' => array(
							array('title' => 'Response ID', 'ng_data' => 'response_id'),
							array('title' => 'Base Question', 'ng_data' => 'base_question'),
							array('title' => '# Views', 'ng_data' => 'number_of_times_viewed'),
						));
						build_data_panel($args); ?>
					</div>
					<?php endif; ?>
					<!-- end responses viewed via user questions tab -->

					<!-- responses viewed via related questions tab -->
					<div role="tabpanel" class="tab-pane" id="responses-viewed-via-related-questions">
						<div class="row" style="margin-bottom:10px;">
							<div class="col-xs-12">
									<button type="button" class="btn btn-default pull-right" ng-click="export_csv('responses_viewed_related_questions', usage_data.responses_data.related_question_responses);"><i class="glyphicon glyphicon-export"></i>Export Responses Viewed Via Related Questions CSV</button>
							</div>
						</div>

						<?php
						$args = array(
						'id' => 'responses-viewed-via-related-questions-panel',
						'ng_repeat' => 'response',
						'type' => 'table',
						'sort_on' => 'number_of_times_viewed',
						'ng_model' => 'usage_data.responses_data.related_question_responses',
						'ng_action' => '',
						'columns' => array(
							array('title' => 'Response ID', 'ng_data' => 'response_id'),
							array('title' => 'Base Question', 'ng_data' => 'base_question'),
							array('title' => '# Views', 'ng_data' => 'number_of_times_viewed'),
						));
						build_data_panel($args); ?>
					</div>
					<!-- end responses viewed via related questions tab -->

					<!-- responses viewed via left rail questions tab -->
					<div role="tabpanel" class="tab-pane" id="responses-viewed-via-left-rail-questions">
						<div class="row" style="margin-bottom:10px;">
							<div class="col-xs-12">
									<button type="button" class="btn btn-default pull-right" ng-click="export_csv('responses_viewed_via_left_rail_questions', usage_data.responses_data.left_rail_question_responses);"><i class="glyphicon glyphicon-export"></i>Export Responses Viewed Via Left Rail Questions CSV</button>
							</div>
						</div>

						<?php
						$args = array(
						'id' => 'responses-viewed-via-left-rail-questions-panel',
						'ng_repeat' => 'response',
						'type' => 'table',
						'sort_on' => 'number_of_times_viewed',
						'ng_model' => 'usage_data.responses_data.left_rail_question_responses',
						'ng_action' => '',
						'columns' => array(
							array('title' => 'Response ID', 'ng_data' => 'response_id'),
							array('title' => 'Base Question', 'ng_data' => 'base_question'),
							array('title' => '# Views', 'ng_data' => 'number_of_times_viewed'),
						));
						build_data_panel($args); ?>
					</div>

					<!-- responses viewed per category tab -->
					<?php if(SHOW_RESPONSES_VIEWED_PER_CATEGORY_DATA): ?>
						<div role="tabpanel" class="tab-pane" id="responses-viewed-per-category">
							<div class="row" style="margin-bottom:10px;">
								<div class="col-xs-12">
										<button type="button" class="btn btn-default pull-right" ng-click="export_csv('responses_viewed_per_category', usage_data.responses_data.per_category);"><i class="glyphicon glyphicon-export"></i>Export Responses Viewed Per Category CSV</button>
								</div>
							</div>

							<?php
							$args = array(
							'id' => 'responses-viewed-per-category-panel',
							'ng_repeat' => 'category',
							'type' => 'table',
							'sort_on' => 'view_count',
							'ng_model' => 'usage_data.responses_data.per_category',
							'ng_action' => '',
							'columns' => array(
								array('title' => 'Category', 'ng_data' => 'response_category_name'),
								array('title' => '# Views', 'ng_data' => 'response_category_view_count'),
							));
							build_data_panel($args); ?>
						</div>
					<?php endif; ?>
					<!-- end responses viewed per category tab -->

				<?php endif; ?>

				<?php if(is_admin()): ?>
					<!-- session data tab -->
					<div role="tabpanel" class="tab-pane" id="session-data">
						<div class="row" style="margin-bottom:10px;">
							<div class="col-xs-12">
									<button type="button" class="btn btn-default pull-right" ng-click="export_csv('sessions_summary', usage_data.sessions_summary);"><i class="glyphicon glyphicon-export"></i>Export Session Data CSV</button>
							</div>
						</div>

						<?php
						$uaq = USER_AUTHENTICATION_REQUIRED;
						$args = array(
						'id' => 'session-summary-panel',
						'ng_repeat' => 'session',
						'type' => 'table',
						'ng_model' => 'usage_data.sessions_summary',
						'sort_on' => 'start_date',
						'ng_action' => 'id="{{session.session_id}}" ng-click="get_session_detail(session.session_id);"',
						'columns' => array(
							array('title' => ($uaq) ? 'Username' : 'Session ID', 'ng_data' => ($uaq) ? 'username' : 'session_id'),
							array('title' => 'Start Date', 'ng_data' => 'start_date'),
							array('title' => 'End Date', 'ng_data' => 'end_date'),
							array('title' => 'Duration (Minutes)', 'ng_data' => 'duration'),
							array('title' => '# Asked Questions', 'ng_data' => 'number_of_questions_asked'),
						));
						build_data_panel($args); ?>
					</div>
					<!-- end session data tab -->
				<?php endif; ?>

				<!-- modified session data tab -->
				<div role="tabpanel" class="tab-pane" id="<?php echo (is_admin()) ? 'modified-session-data' : 'session-data' ?>">
					<?php if(is_admin()): ?>
						<div class="row" style="margin-bottom:10px;">
							<div class="col-xs-9">
								<div class="alert alert-warning" role="alert"><i class="glyphicon glyphicon-warning-sign"></i>&nbsp;Modified Session Data is updated daily at 4:00 UTC</div>
							</div>
							<div class="col-xs-3">
								<button type="button" class="btn btn-default pull-right" ng-click="export_csv('modified_sessions_summary', usage_data.modified_sessions_summary);"><i class="glyphicon glyphicon-export"></i>Export Modified Session Data CSV</button>
							</div>
						</div>
					<?php else: ?>
						<div class="row" style="margin-bottom:10px;">
							<div class="col-xs-9">
								<div class="alert alert-warning" role="alert"><i class="glyphicon glyphicon-warning-sign"></i>&nbsp;Session Data is updated daily at 4:00 UTC</div>
							</div>
							<div class="col-xs-3">
								<button type="button" class="btn btn-default pull-right" ng-click="export_csv('sessions_summary', usage_data.modified_sessions_summary);"><i class="glyphicon glyphicon-export"></i>Export Session Data CSV</button>
							</div>
						</div>
					<?php endif; ?>

					<?php
					$uaq = USER_AUTHENTICATION_REQUIRED;
					$args = array(
					'id' => (is_admin()) ? 'modified-session-summary-panel' : 'session-summary-panel',
					'ng_repeat' => 'modified_session',
					'type' => 'table',
					'ng_model' => 'usage_data.modified_sessions_summary',
					'sort_on' => 'start_datetime',
					'ng_action' => 'id="{{modified_session.id}}" ng-click="get_modified_session_detail(modified_session.id, modified_session.session_id);"',
					'columns' => array(
						array('title' => ($uaq) ? 'Username' : 'Session ID', 'ng_data' => ($uaq) ? 'username' : 'session_id'),
						array('title' => 'Start Date', 'ng_data' => 'start_datetime'),
						array('title' => 'End Date', 'ng_data' => 'end_datetime'),
						array('title' => 'Duration (Minutes)', 'ng_data' => 'duration'),
						array('title' => '# Asked Questions', 'ng_data' => 'input_question_count'),
					));
					build_data_panel($args); ?>
				</div>
				<!-- end modified session data tab -->

				<?php if(is_admin()): ?>
				<!-- session count frequencies tab -->
					<div role="tabpanel" class="tab-pane" id="session-count-frequencies">
						<div class="row" style="margin-bottom:10px;">
							<div class="col-xs-12">
								<button type="button" class="btn btn-default pull-right" ng-click="export_csv('session_count_frequencies', usage_data.session_count_frequencies);"><i class="glyphicon glyphicon-export"></i>Export Session Count Frequencies CSV</button>
							</div>
						</div>
						<?php
						$args = array(
						'id' => 'session-count-frequencies-panel',
						'ng_repeat' => 'session_count_frequency_row',
						'type' => 'table',
						'ng_model' => 'usage_data.session_count_frequencies',
						'sort_on' => 'sessions_count',
						'sort_order' => 'ASC',
						'columns' => array(
							array('title' => 'Number of Sessions', 'ng_data' => 'sessions_count'),
							array('title' => 'Number of Users', 'ng_data' => 'num_occurences')
						));
						build_data_panel($args); ?>
					</div>
				<!-- end session count frequencies tab -->
				<?php endif; ?>

				<!-- modified session count frequencies tab -->
				<div role="tabpanel" class="tab-pane" id="<?php echo (is_admin()) ? 'modified-session-count-frequencies' : 'session-count-frequencies' ?>">
					<div class="row" style="margin-bottom:10px;">
						<?php if(!USER_AUTHENTICATION_REQUIRED && !is_admin()): ?>
							<div class="col-xs-9">
								<div class="alert alert-info" role="alert"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;The data below is collected based on IP Address in accordance with our <a href="http://www.medrespond.com/company/privacy-policy/" target="_blank">privacy policy</a>.</div>
							</div>
							<div class="col-xs-3">
								<button type="button" class="btn btn-default pull-right" ng-click="export_csv('session_count_frequencies', usage_data.modified_session_count_frequencies);"><i class="glyphicon glyphicon-export"></i>Export Session Count Frequencies CSV</button>
							</div>
						<?php else: ?>
							<div class="col-xs-12">
								<button type="button" class="btn btn-default pull-right" ng-click="export_csv('session_count_frequencies', usage_data.modified_session_count_frequencies);"><i class="glyphicon glyphicon-export"></i>Export Session Count Frequencies CSV</button>
							</div>
						<?php endif; ?>
					</div>
					<?php
					$args = array(
					'id' => 'session-count-frequencies-panel',
					'ng_repeat' => 'session_count_frequency_row',
					'type' => 'table',
					'ng_model' => 'usage_data.modified_session_count_frequencies',
					'sort_on' => 'sessions_count',
					'sort_order' => 'ASC',
					'columns' => array(
						array('title' => 'Number of Sessions', 'ng_data' => 'sessions_count'),
						array('title' => 'Number of Users', 'ng_data' => 'num_occurences')
					));
					build_data_panel($args); ?>
				</div>
				<!-- end modified session count frequencies tab -->

				<!-- session data graph tab -->
				<div role="tabpanel" class="tab-pane" id="<?php echo (is_admin()) ? 'modified-session-data-graph' : 'session-data-graph' ?>">
					<div class="row">
						<div class="col-xs-12">
							<div id="session-data-graph-container"></div>
						</div>
					</div>
				</div>
				<!-- end session data graph tab -->

				<?php if(property_has_surveys()): ?>
				<!-- surveys tab -->
				<div load-survey-responses-data role="tabpanel" class="tab-pane" id="surveys">
					<div class="row" style="margin-bottom:10px;">
						<div class="col-xs-12">
							<button type="button" class="btn btn-default pull-right" ng-click="export_csv('survey_responses', survey_responses_data);"><i class="glyphicon glyphicon-export"></i>Export Surveys CSV</button>
						</div>
					</div>

					<?php
					$args = array(
					'id' => 'surveys-panel',
					'ng_repeat' => 'survey_response',
					'type' => 'table',
					'sort_on' => 'submission_date',
					'ng_model' => 'survey_responses_data',
					'ng_action' => '',
					'columns' => array(
						array('title' => 'Submission ID', 'ng_data' => 'submission_id'),
						array('title' => 'Session ID', 'ng_data' => 'session_id'),
						array('title' => 'Submission Date', 'ng_data' => 'submission_date'),
						array('title' => 'Question', 'ng_data' => 'question_text'),
						array('title' => 'Answer', 'ng_data' => 'answer_text')
					));
					build_data_panel($args); ?>
				</div>
				<!-- end surveys tab -->
				<?php endif; ?>

			</div>
			<!-- end tab panes -->
</div><!--/.panel-->
</div><!--/c-->

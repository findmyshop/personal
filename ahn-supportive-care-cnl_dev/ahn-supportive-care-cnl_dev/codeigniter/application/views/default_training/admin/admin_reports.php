<div id="" class="mr-panel mr-data-panel panel panel-default" ng-model="user_courses" load-user-courses>
	<div class="panel-heading">
		<h1 class="pull-left panel-title"><i class="mr-modal-icon glyphicon glyphicon-cog"></i>Select User</h1>
		<div class="input-group input-group-sm col-xs-9 pull-right">
			<span class="input-group input-group-sm pull-right" style="width:30%;">
				<span class="input-group-addon input-group-sm">
					<i class="mr-status-label glyphicon glyphicon-saved"></i> Certificate Accepted:
				</span>
				<select class="form-control" ng-model="show_no_cert" name="course_search_show_no_cert" style="margin-left:-7px;">
					<option value="-1">All</option>
					<option value="0">Accepted</option>
					<option value="1">Not Accepted</option>
				</select>
			</span>
			<span class="input-group input-group-sm pull-right" style="width:30%;">
				<span class="input-group-addon input-group-sm">
					<i class="mr-status-label glyphicon glyphicon-share"></i> Exam Passed:
				</span>
				<select class="form-control" ng-model="show_not_passed" name="course_search_show_not_passed" style="margin-left:-7px;">
					<option value="-1">All</option>
					<option value="0">Passed</option>
					<option value="1">Not Passed</option>
				</select>
			</span>
			<span class="input-group input-group-sm pull-right" style="width:30%;">
				<span class="input-group-addon input-group-sm">
					<i class="mr-status-label glyphicon glyphicon-check"></i> Course Complete:
				</span>
				<select class="form-control" ng-model="show_uncompleted" name="course_search_show_uncompleted" style="margin-left:-7px;">
					<option value="-1">All</option>
					<option value="0">Complete</option>
					<option value="1">Incomplete</option>
				</select>
			</span>
		</div>
		<div style="clear:both; height:3px;"></div>

		<div class="input-group input-group-sm col-xs-7 pull-right">
			<input type="text" class="form-control" placeholder="Search" ng-model="course_search" />
			<span class="input-group-btn">
				<button type="button" class="btn btn-default" ng-click="get_user_courses(true);"><i class="glyphicon glyphicon-refresh"></i></button>
			</span>
			<span class="input-group-btn">
				<button type="button" class="btn btn-default" ng-click="export_user_courses(false);"><i class="glyphicon glyphicon-export"></i> Export CSV</button>
			</span>
			<span class="input-group-btn">
				<button type="button" class="btn btn-default" ng-click="export_user_courses(true);"><i class="glyphicon glyphicon-export"></i> Export Detailed CSV</button>
			</span>
			<span class="input-group-btn">
				<button type="button" class="btn btn-default" ng-click="export_user_answers();"><i class="glyphicon glyphicon-export"></i> Export Answers CSV</button>
			</span>
		</div>
		<div class="input-group input-group-sm col-xs-5">
			<span class="input-group-btn input-group-sm">
				<select class="form-control" ng-model="course_search_course_id" name="course_search_course_id">
					<option value="-1">All Courses</option>
					<option ng-repeat="course in courses" ng-cloak ng-selected value="{{course.id}}">{{course.course_name}}</option>
				</select>
			</span>
		</div>
		<div style="clear:both;"></div>
	</div>
	<!--/.panel-heading-->
	<div ng-show="downloading_user_courses_report" ng-cloak style="text-align:center; width:100%; color: red;">Downloading User Courses CSV File</div>
	<div ng-show="downloading_user_answers_report" ng-cloak style="text-align:center; width:100%; color: red;">Downloading User Answers CSV File</div>
	<?php
	$args = array(
	'ng_directive' => 'when-scrolled',
	'ng_repeat' => 'user_course',
	'type' => 'table',
	'id' => 'blarf',
	'ng_model' => 'user_courses',
	'ng_action' => 'data-modal-id="#course-details-modal" course_name="{{user_course.course_name}}" user_id="{{user_course.user_id}}" course_id="{{user_course.course_id}}" current_iteration="{{user_course.current_iteration}}" get-course-detail data-target="#course-details-modal"',
	'spinner' => '<tr ng-model="ready_for_more_user_course_entries" ng-show="show_spinner==\'1\'"><td colspan="10"><i class="fa fa-spinner fa-spin fa-2x" style="text-align:center; width:100%"></i></td></tr>',
		'columns' => array(
			array('title' => 'Name', 'ng_data' => 'full_name'),
			array('title' => 'Username', 'ng_data' => 'username'),
			array('title' => 'Accred', 'ng_data' => 'accreditation_type'),
			array('title' => 'Course', 'ng_data' => 'course_name'),
			array('title' => 'Attempt #', 'ng_data' => 'current_iteration'),
			array('title' => 'Percent Complete', 'ng_data' => 'percent_complete'),
			array('title' => 'Exam Passed', 'ng_data' => 'has_passed'),
			array('title' => 'Cert Accepted', 'ng_data' => 'certificate_accepted_by_user')
		));
	build_data_panel($args);
	?>
</div>
<!--/.panel-->


<!-- Course Details Modal -->
<div class="modal fade" id="course-details-modal" tabindex="-1" role="dialog" aria-labelledby="course-details-modal-label" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
<h4 class="modal-title" id="course-details-modal-label">Details: {{ course_name }}</h4>
</div>
<div class="modal-body">
<?php
/* Test Summary */
$args = array('title' => 'Test Summary',
		'ng_model' => 'tests_summary',
		'id' => 'tests_summary',
		'ng_repeat' => 'cc',
		'columns' => array( array('title' => 'Test Name', 'ng_data' => 'test_name' ),
				array('title' => 'Attempt', 'ng_data' => 'current_iteration' ),
				array('title' => 'Required', 'ng_data' => 'required' ),
				array('title' => 'Completed', 'ng_data' => 'has_completed' ),
				array('title' => 'Passed', 'ng_data' => 'has_passed' ),
				array('title' => 'Score', 'ng_data' => 'score' )
		));
build_data_panel($args);
/* Course Activity */
$args = array('title' => 'Course Activity',
		'ng_model' => 'course_activity',
		'id' => 'course_activity',
		'ng_repeat' => 'cc',
		'columns' => array( array('title' => 'Course Name', 'ng_data' => 'course_name' ),
				array('title' => 'Module', 'ng_data' => 'title' ),
				array('title' => 'Attempt', 'ng_data' => 'current_iteration' ),
				array('title' => 'Status', 'ng_data' => 'status' ),
				array('title' => 'Response ID', 'ng_data' => 'response_id' ),
				array('title' => 'Log ID', 'ng_data' => 'activity_log_id' ),
				array('title' => 'Date', 'ng_data' => 'date')
		));

build_data_panel($args);

?>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default pull-left"><i class="glyphicon glyphicon-remove"></i> Close</button>
			</div>
		</div>
	</div>
</div>

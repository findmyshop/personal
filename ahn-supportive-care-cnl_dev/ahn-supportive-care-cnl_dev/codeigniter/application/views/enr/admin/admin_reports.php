<div id="" class="mr-panel mr-data-panel panel panel-default" ng-model="report" load-report>
	<div class="panel-heading">
		<h1 class="pull-left panel-title"><i class="mr-modal-icon glyphicon glyphicon-cog"></i>Report</h1>


	<!--/.panel-heading-->
	<div ng-show="downloading_report" ng-cloak style="text-align:center; width:100%; color: red;">Downloading Report CSV File</div>
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
			array('title' => 'Branch', 'ng_data' => 'department_name'),
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
		'columns' => array( array('title' => 'Test Name', 'ng_data' => 'test_name'),
				array('title' => 'Attempt', 'ng_data' => 'current_iteration'),
				array('title' => 'Required', 'ng_data' => 'required'),
				array('title' => 'Completed', 'ng_data' => 'has_completed'),
				array('title' => 'Passed', 'ng_data' => 'has_passed'),
				array('title' => 'Score', 'ng_data' => 'score')
		));
build_data_panel($args);
/* Course Activity */
$args = array('title' => 'Course Activity',
		'ng_model' => 'course_activity',
		'id' => 'course_activity',
		'ng_repeat' => 'cc',
		'columns' => array( array('title' => 'Course Name', 'ng_data' => 'course_name'),
				array('title' => 'Module', 'ng_data' => 'title'),
				array('title' => 'Attempt', 'ng_data' => 'current_iteration'),
				array('title' => 'Status', 'ng_data' => 'status'),
				array('title' => 'Response ID', 'ng_data' => 'response_id'),
				array('title' => 'Log ID', 'ng_data' => 'activity_log_id'),
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

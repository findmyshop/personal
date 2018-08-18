<div class="panel panel-default" ng-model="courses">
	<div class="panel-heading">
		<div class="row">
			<div class="col-xs-12">
				<h1 class="panel-title">User Dashboard</h1>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<div role="tabpanel">
			<!-- Nav tabs -->
			<ul class="nav nav-pills" role="tablist" style="margin-bottom:10px;">
				<li role="presentation" class="active"><a href="#my_courses" aria-controls="my_courses" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-education"></i> My Courses</a></li>
				<li role="presentation"><a href="#course_library" aria-controls="course_library" role="tab" data-toggle="tab"><i class="glyphicon glyphicon-education"></i> All Courses</a></li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="my_courses" load-default-course ng-cloak>


				<div ng-show="active_course">
				<?php $panel_body = '<div class="col-xs-12">
					<h5>Course Progress: </h5>
					<div class="progress" title="progress" my-progress="course_stats.percent_complete" data-bar-color="progress-bar-default"> </div>
					</div><ul class="list-group col-xs-6">
					<li class="list-group-item">
						<i class="mr-status-label glyphicon glyphicon-th-list"></i>&nbsp;&nbsp;Sections Visited:
						<span class="mr-status label label-default">
							{{course_stats.total_sections_visited}} / {{course_stats.total_sections}}
						</span>
					</li>
					<li class="list-group-item">
						<i class="mr-status-label glyphicon glyphicon-star"></i>&nbsp;&nbsp;Tests Passed:
						<span class="mr-status label label-default">
							{{course_stats.number_of_graded_tests_passed}} / {{course_stats.number_of_graded_tests}}
						</span>
					</li>
					<li class="list-group-item">
						<i class="mr-status-label glyphicon glyphicon-star-empty"></i>&nbsp;&nbsp;Tests/Surveys Visited:
						<span class="mr-status label label-default">
							{{course_stats.total_tests_surveys_visited}} / {{course_stats.total_tests_surveys}}
						</span>
					</li>
					<li class="list-group-item">
						<i class="mr-status-label glyphicon glyphicon-saved"></i>&nbsp;&nbsp;Certificate Accepted:
						<span ng-if="active_course.certificate_page_accepted > 0" class="mr-status label label-success"><i class="glyphicon glyphicon-ok"></i> Yes</span>
						<span ng-if="active_course.certificate_page_accepted <= 0" class="mr-status label label-danger"><i class="glyphicon glyphicon-remove"></i> No</span>
					</li>
					</ul><ul class="list-group col-xs-6">
					<li class="list-group-item">
						<i class="mr-status-label glyphicon glyphicon-repeat"></i>&nbsp;&nbsp;Course Attempt:
						<span class="mr-status label label-default">
							{{active_course.current_iteration}} / {{active_course.max_iterations}}
						</span>
					</li>
					<li class="list-group-item">
						<i class="mr-status-label glyphicon glyphicon-share"></i>&nbsp;&nbsp;Course Passed:
						<span ng-if="course_stats.ready_pass > 0" class="mr-status label label-success"><i class="glyphicon glyphicon-ok"></i> Yes</span>
						<span ng-if="course_stats.ready_pass <= 0" class="mr-status label label-danger"><i class="glyphicon glyphicon-remove"></i> No</span>
					</li>
					<li class="list-group-item">
						<i class="mr-status-label glyphicon glyphicon-check"></i>&nbsp;&nbsp;Course Complete:
						<span ng-if="course_stats.ready_complete > 0" class="mr-status label label-success"><i class="glyphicon glyphicon-ok"></i> Yes</span>
						<span ng-if="course_stats.ready_complete <= 0" class="mr-status label label-danger"><i class="glyphicon glyphicon-remove"></i> No</span>
					</li></ul>';
					$right = '<a href="{{last_id}}" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-blackboard"></i> Return to Course</a>';
					$footer = '<div ng-show="course_stats.ready_pass > 0 && course_stats.total_sections_visited == course_stats.total_sections">
						<button id="accept_certificate_button" ng-show="active_course.certificate_page_accepted < 1" accept-certificate class="btn btn-success pull-right"><i class="glyphicon glyphicon-export"></i>Accept Certificate and Complete Course</button>
						<button id="complete_course_button" ng-show="course_stats.ready_complete && active_course.certificate_page_accepted > 0" ng-click="complete_course();" class="btn btn-success pull-right"><i class="glyphicon glyphicon-check"></i> Complete Course</button>
						</div>
						<div ng-show="course_stats.ready_pass < 1">
						<button id="close_course_button" ng-show="active_course.certificate_page_accepted > 0 && course_stats.ready_complete > 0 && active_course.current_iteration >= active_course.max_iterations" ng-click="complete_course();" class="btn btn-danger pull-right"><i class="glyphicon glyphicon-check"></i> Close Course</button>
						<button id="retake_course_button" ng-show="course_stats.ready_complete > 0 && active_course.current_iteration < active_course.max_iterations" ng-click="complete_course(active_course.course_id);" class="btn btn-danger pull-right"><i class="glyphicon glyphicon-check"></i> Retake Course</button>
						<button id="fail_course_button" ng-show="course_stats.ready_complete > 0 && active_course.certificate_page_accepted < 1 && active_course.current_iteration >= active_course.max_iterations" ng-click="complete_course();" class="btn btn-danger pull-right"><i class="glyphicon glyphicon-check"></i> Complete Course</button>
						</div>';
					$args = array('title' => 'Current Course: {{active_course ? active_course.course_name : "[none]"}}',
					'body' => $panel_body,
					'right' => $right,
					'footer' => $footer);
					build_shell_panel($args); ?>
				</div>

				<div ng-show="!active_course">
					<?php $panel_body = 'You currently have no active courses.';
					$right = '';
					$footer = '';
					$args = array('title' => 'Current Course: [none]',
					'body' => $panel_body,
					'right' => $right,
					'footer' => $footer);
					build_shell_panel($args); ?>
				</div>



				<?php /* Course Registrations */
				$args = array('title' => 'Course History',
											 'ng_model' => 'all_user_courses_and_iterations',
											 'ng_repeat' => 'cc',
											 'id' => 'history',
											 'columns' => array( array('title' => 'Active', 'ng_data' => 'is_active', 'data_type' => 'boolean' ),
																					 array('title' => 'Course Name', 'ng_data' => 'course_name' ),
																					 array('title' => 'Attempt', 'ng_data' => 'current_iteration' ),
																					 array('title' => 'Date Registered', 'ng_data' => 'date_registered' ),
																					 array('title' => 'Completed', 'ng_data' => 'has_completed' , 'data_type' => 'boolean'),
																					 array('title' => 'Passed', 'ng_data' => 'has_passed', 'data_type' => 'boolean' ),
																					 array('title' => 'Options', 'data_type' => 'custom', 'ng_data' => '<button class="btn btn-default" data-modal-id="#course-details-modal" data-course-name="{{cc.course_name}}" toggle-course-detail="{{cc.course_id}}" current_iteration="{{cc.current_iteration}}"><i class="glyphicon glyphicon-info-sign"></i> Details</button> <button class="btn btn-success" ng-show="cc.has_passed > 0 && (cc.certificate_accepted_by_user > 0 || cc.certificate_page_accepted)" barf-old-certificate data-course="{{cc}}"><i class="glyphicon glyphicon-saved"></i> View Certificate</button>')

											 ));

				build_data_panel($args);

				?>
				</div><!--/.tabpanel -->
				<div role="tabpanel" class="tab-pane" id="course_library">
				<?php /* Course Registrations */
				$args = array('title' => 'All Courses',
											 'ng_model' => 'all_courses',
											 'ng_repeat' => 'cc',
											 'id' => 'all_courses',
											 'right' => '<a ng-hide="!active_course" href="{{last_id}}" class="pull-right btn btn-default btn-sm"><i class="glyphicon glyphicon-blackboard"></i> Return to Course</a>',
											 'ng_action' => '',
											 'columns' => array( array('title' => 'Active', 'ng_data' => 'is_active', 'data_type' => 'boolean' ),
																					 array('title' => 'Course Name', 'ng_data' => 'course_name' ),
																					 array('title' => 'Attempts', 'ng_data' => 'current_iteration' ),
																					 array('title' => 'Date Registered', 'ng_data' => 'date_registered' ),
																					 array('title' => 'Completed', 'ng_data' => 'has_completed' , 'data_type' => 'boolean'),
																					 array('title' => 'Passed', 'ng_data' => 'has_passed', 'data_type' => 'boolean' ),
																					 array('title' => 'Options', 'data_type' => 'custom', 'ng_data' => '<button class="btn btn-success btn-xs" ng-show="can_show_take_course_button($index)" ng-click="activate_course(cc.course_id)"><i class="glyphicon glyphicon-education"></i> Take Course</button>')
											 ));

				build_data_panel($args);

				?>
				</div> <!--	 tab panel -->
			</div> <!-- tab content -->
		</div>	<!--	tab content -->
	</div>	<!--	panel body-->
</div> <!-- panel -->

<!-- Cert Prompt Modal -->
<div class="modal fade" id="cert-prompt-modal" tabindex="-1" role="dialog" aria-labelledby="cert-prompt-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
				<h4 class="modal-title" id="cert-prompt-modal-label">Congratulations!</h4>
			</div>
			<div class="modal-body">
			You have passed the <em>{{ active_course.course_name }}</em> course. Click 'Complete Course' below to mark this course as complete.
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-default pull-left"><i class="glyphicon glyphicon-remove"></i> Close</button>
				<button id="complete_course_button" ng-click="complete_course();" class="btn btn-success pull-right"><i class="glyphicon glyphicon-check"></i> Complete Course</button>
			</div>
		</div>
	</div>
</div>
<!-- Course Details Modal -->
<div class="modal fade" id="course-details-modal" tabindex="-1" role="dialog" aria-labelledby="course-details-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
				<h4 class="modal-title" id="course-details-modal-label">{{ course_name }}</h4>
			</div>
			<div class="modal-body">
				<?php
				/* Test Summary */
				$args = array('title' => 'Test Summary',
											 'ng_model' => 'tests_summary',
											 'ng_repeat' => 'cc',
											 'id' => 'summary',
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
											 'ng_repeat' => 'cc',
											 'id' => 'activity',
											 'columns' => array( array('title' => 'Course Name', 'ng_data' => 'course_name' ),
																					 array('title' => 'Module', 'ng_data' => 'title' ),
																					 array('title' => 'Attempt', 'ng_data' => 'current_iteration' ),
																					 array('title' => 'Status', 'ng_data' => 'status' ),
																					 array('title' => 'Response ID', 'ng_data' => 'response_id' ),
																					 array('title' => 'Log ID', 'ng_data' => 'activity_log_id' )
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

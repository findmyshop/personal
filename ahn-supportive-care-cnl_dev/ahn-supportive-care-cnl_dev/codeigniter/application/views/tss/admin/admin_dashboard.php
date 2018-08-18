<div ng-controller="tssDashboardController">
    <div load-dashboard-data class="panel panel-default">
        <div class="panel-heading">
            <div class="col-xs-2">
                <h1 class="panel-title">Dashboard</h1>
            </div>
            <?php if(is_admin() || is_site_admin()): ?>
                <div class="input-group input-group-sm pull-right">
                    <div class="input-group-btn pull-right" style="margin-right:90px;">
                        <button type="button" class="btn btn-default" ng-click="export_dashboard_data_csv();"><i class="glyphicon glyphicon-export"></i> Export CSV</button>
                    </div>
                </div>
            <?php endif; ?>
            <div style="clear:both;"></div>
        </div>

        <div ng-show="show_spinner" style="width:100%; margin-top:10px; text-align:center;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
        </div>

        <div class="panel-body">
        <?php if(is_admin() || is_site_admin()): ?>
            <!-- show admin reports data -->
            <?php
            $args = array(
            'id' => 'dashboard-panel-admin',
            'ng_repeat' => 'dashboard_row',
            'type' => 'table',
            'sort_on' => 'start_datetime',
            'ng_model' => 'dashboard_data',
            'ng_action' => 'id="dashboard-row-user-id{{dashboard_row.user_id}}-simulation_attempt-{{dashboard_row.simulation_attempt}}" ng-click="get_dashboard_simulation_attempt_details_data(dashboard_row.user_id, dashboard_row.username, dashboard_row.simulation_attempt);"',
                'columns' => array(
                    array('title' => 'Username', 'ng_data' => 'username'),
                    array('title' => 'Simulation Attempt', 'ng_data' => 'simulation_attempt'),
                    array('title' => 'Start Datetime', 'ng_data' => 'start_datetime'),
                    array('title' => 'End Datetime', 'ng_data' => 'end_datetime'),
                    array('title' => 'Last Scenario Completed', 'ng_data' => 'last_scenario_completed'),
                    array('title' => 'Gathering STARS', 'ng_data' => 'gathering_stars_score'),
                    array('title' => 'Behavioral Questions', 'ng_data' => 'behavioral_questions_score'),
                    array('title' => 'Follow Up Questions', 'ng_data' => 'follow_up_questions_score'),
                    array('title' => 'Motivational Fit Questions', 'ng_data' => 'motivational_fit_questions_score'),
                    array('title' => 'Candidate Experience', 'ng_data' => 'candidate_experience_score'),
                    array('title' => 'Moving Through The Interview', 'ng_data' => 'moving_through_the_interview_time')
                ));
            build_data_panel($args);
            ?>
        <?php else: ?>
            <!-- show user report data -->
            <?php
            $args = array(
            'id' => 'dashboard-panel-user',
            'ng_repeat' => 'dashboard_row',
            'type' => 'table',
            'sort_on' => 'start_datetime',
            'ng_model' => 'dashboard_data',
                'columns' => array(
                    array('title' => 'Username', 'ng_data' => 'username'),
                    array('title' => 'Simulation Attempt', 'ng_data' => 'simulation_attempt'),
                    array('title' => 'Start Datetime', 'ng_data' => 'start_datetime'),
                    array('title' => 'End Datetime', 'ng_data' => 'end_datetime'),
                    array('title' => 'Has Completed', 'data_type' => 'boolean', 'ng_data' => 'has_completed'),
                    array('title' => 'Action', 'data_type' => 'custom', 'ng_data' => '<button ng-disabled="!dashboard_row.end_datetime" ng-click="show_dashboard_simulation_attempt_scoring_modal(dashboard_row);" class="btn btn-default">View Score</button>')
                ));
            build_data_panel($args);
            ?>

            <?php if($has_finished_current_flow_attempt): ?>
                <button retake-simulation type="button" class="btn btn-primary">Retake Simulation</button>
            <?php else: ?>
                <button resume-simulation type="button" class="btn btn-primary">Resume Simulation</button>
            <?php endif; ?>
        <?php endif; ?>
        </div>
    </div>

    <div class="modal fade mr-printable" id="dashboard-simulation-attempt-details-modal" tabindex="-1" role="dialog" aria-labelledby="dashboard-simulation-attempt-details-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" id="print-div">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="dashboard-simulation-attempt-details-label">Simulation Attempt Details</h4>
                </div>
                <div ng-if="dashboard_simulation_attempt_details_data.length > 0">
                    <?php
                    $args = array(
                                'id' => 'dashboard-simulation-attempt-details-panel',
                                'title' => 'Simulation Attempt {{dashboard_simulation_attempt_details_simulation_attempt}} for {{dashboard_simulation_attempt_details_username}}',
                                'ng_model' => 'dashboard_simulation_attempt_details_data',
                                'ng_repeat' => 'dashboard_simulation_attempt_details_data_row',
                                'sort_on' => 'date',
                                'sort_order' => 'ASC',
                                'icon' => 'list-alt',
                                'ng_action' => '',
                                'columns' => array(
                                    array('title' => 'Scenario', 'ng_data' => 'scenario'),
                                    array('title' => 'Option Selected', 'ng_data' => 'option_selected'),
                                    array('title' => 'Input', 'ng_data' => 'input_question'),
                                    array('title' => 'Evaluation', 'ng_data' => 'evaluation'),
                                    array('title' => 'Date', 'ng_data' => 'date'),
                                    ));
                    build_data_panel($args); ?>
                </div>
                <div ng-if="dashboard_simulation_attempt_details_data == 0" class="col-xs-12" style="padding:20px;">
                    {{dashboard_simulation_attempt_details_username}} hasn't participated in any of the scenarios during simulation attempt {{dashboard_simulation_attempt_details_simulation_attempt}} yet.
                </div>
                <div class="modal-footer mr-no-print">
                    <button type="button" onClick="$('#print-div').print();" class="btn btn-default"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> Print</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove" aria-hidden="true"></i> Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade mr-printable" id="dashboard-simulation-attempt-scoring-modal" tabindex="-1" role="dialog" aria-labelledby="dashboard-simulation-attempt-scoring-label">
        <div class="modal-dialog">
            <div class="modal-content" id="scoring-print-div">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="dashboard-simulation-attempt-scoring-label">Attempt #{{dashboard_simulation_attempt_scoring_data.simulation_attempt}} Simulation Scoring for {{dashboard_simulation_attempt_scoring_data.username}}</h4>
                </div>
                <div id="dashboard-simulation-attempt-scoring-container" class="container">
                    <div class="row">
                        <div class="scoring-category-heading">
                            Gathering Stars
                            <span ng-if="dashboard_simulation_attempt_scoring_data.gathering_stars_score_num_diamonds == 5">
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.gathering_stars_score_num_diamonds == 4">
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.gathering_stars_score_num_diamonds == 3">
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.gathering_stars_score_num_diamonds == 2">
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.gathering_stars_score_num_diamonds == 1">
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                        </div>

                        <p>Recognized the complete STARs and number of STARs per target.</p>

                        <ul>
                            <li>Recognized whether complete and relevant STARs were collected</li>
                            <li>Recognized that enough STARs were collected for each target</li>
                            <li>Asked motivational fit questions where appropriate</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="scoring-category-heading">
                            Using Behavioral Questions
                            <span ng-if="dashboard_simulation_attempt_scoring_data.behavioral_questions_score_num_diamonds == 5">
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.behavioral_questions_score_num_diamonds == 4">
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.behavioral_questions_score_num_diamonds == 3">
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.behavioral_questions_score_num_diamonds == 2">
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.behavioral_questions_score_num_diamonds == 1">
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                        </div>

                        <p>Used questions that obtained examples of past behavior.</p>

                        <ul>
                            <li>Asked behavioral questions</li>
                            <li>Avoided theoretical questions</li>
                            <li>Avoided leading questions</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="scoring-category-heading">
                            Using Follow-Up Questions
                            <span ng-if="dashboard_simulation_attempt_scoring_data.follow_up_questions_score_num_diamonds == 5">
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.follow_up_questions_score_num_diamonds == 4">
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.follow_up_questions_score_num_diamonds == 3">
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.follow_up_questions_score_num_diamonds == 2">
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.follow_up_questions_score_num_diamonds == 1">
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                        </div>

                        <p>Recognized false and incomplete STARs and asked questions to obtain complete, specific examples of past behavior.</p>

                        <ul>
                            <li>Asked for specifics when given false or incomplete STARs</li>
                            <li>Asked for situation/task, asked for action, asked for result</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="scoring-category-heading">
                            Asking Motivational Fit Questions
                            <span ng-if="dashboard_simulation_attempt_scoring_data.motivational_fit_questions_score_num_diamonds == 5">
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.motivational_fit_questions_score_num_diamonds == 4">
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.motivational_fit_questions_score_num_diamonds == 3">
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.motivational_fit_questions_score_num_diamonds == 2">
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.motivational_fit_questions_score_num_diamonds == 1">
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                        </div>

                        <p>Gathered information to determine the candidate's motivational fit for the job.</p>

                        <ul>
                            <li>Asked relevant and appropriate questions</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="scoring-category-heading">
                            Candidate Experience
                            <span ng-if="dashboard_simulation_attempt_scoring_data.candidate_experience_score_num_diamonds == 5">
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.candidate_experience_score_num_diamonds == 4">
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.candidate_experience_score_num_diamonds == 3">
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.candidate_experience_score_num_diamonds == 2">
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.candidate_experience_score_num_diamonds == 1">
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                        </div>

                        <p>Created a positive experience for the candidate.</p>

                        <ul>
                            <li>Kept conversation job focused</li>
                            <li>Showed candidate respect</li>
                            <li>Avoided seeking or sharing personal information</li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="scoring-category-heading">
                            Interview Flow and Control
                            <span ng-if="dashboard_simulation_attempt_scoring_data.moving_through_the_interview_time_num_diamonds == 5">
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.moving_through_the_interview_time_num_diamonds == 4">
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-high-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.moving_through_the_interview_time_num_diamonds == 3">
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-medium-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.moving_through_the_interview_time_num_diamonds == 2">
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                            <span ng-if="dashboard_simulation_attempt_scoring_data.moving_through_the_interview_time_num_diamonds == 1">
                                <svg class="scoring-diamond-svg-low-category" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 17 17" enable-background="new 0 0 16 16" width="16" height="16">
                                    <path d="M8.5.015l8.485 8.485-8.485 8.485-8.485-8.485z"/>
                                </svg>
                            </span>
                        </div>

                        <p>Took a reasonable amount of time to collect data</p>

                        <ul>
                            <li>Spent appropriate amount of time on each question</li>
                            <li>Redirected the candidate to focus on more relevant information</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer mr-no-print">
                    <button type="button" onClick="$('#scoring-print-div').print();" class="btn btn-default"><i class="glyphicon glyphicon-print" aria-hidden="true"></i> Print</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-remove" aria-hidden="true"></i> Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
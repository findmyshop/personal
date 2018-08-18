<div class="panel panel-default" ng-controller="ebiMoodleLinkBuilderController" ng-cloak>
    <div class="panel-heading">
        <h1 class="panel-title">Moodle Link Builder</h1>
    </div>
    <div class="panel-body">
        <div class="alert alert-info" role="alert"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;Use the form below to contruct a Moodle Account Login Link.  Click on the link to login as that particular user.  Note that clicking on the link below will potentially create Schools, Courses, and a User account.</div>

        <div id="moodle-link-builder-nav-tab-panel">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a ng-click="setStudentLinkType();" href="#student" data-toggle="tab">Student</a>
                </li>
                <li>
                    <a ng-click="setCourseAdminLinkType();" href="#course-admin" data-toggle="tab">Course Admin</a>
                </li>
                <li>
                    <a ng-click="setSchoolAdminLinkType();" href="#school-admin" data-toggle="tab">School Admin</a>
                </li>
            </ul>

            <div class="tab-content" style="padding-top:10px;">
                <div class="tab-pane active" id="student">
                    <div class="row">
                        <div class="col-xs-12">
                            <h4>Create a Student Moodle Account Link</h4>

                            <form style="padding-top:10px;">
                                <!-- user -->
                                <fieldset class="form-group">
                                    <legend>User</legend>
                                    <div class="form-group row">
                                        <label for="user_id" class="col-xs-2 col-form-label">User ID</label>
                                        <div class="col-xs-10">
                                            <input ng-model="userData.user_id" type="text" class="form-control" id="user_id" placeholder="User ID">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="user_first_name" class="col-xs-2 col-form-label">First Name</label>
                                        <div class="col-xs-10">
                                            <input ng-model="userData.user_first_name" type="text" class="form-control" id="user_first_name" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="user_last_name" class="col-xs-2 col-form-label">Last Name</label>
                                        <div class="col-xs-10">
                                            <input ng-model="userData.user_last_name" type="text" class="form-control" id="user_last_name" placeholder="Last Name">
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset class="form-group" style="margin-bottom:5px;">
                                    <legend>School/Course</legend>
                                    <!-- school -->
                                    <div class="col-xs-6">
                                        <div class="form-group row">
                                            <label for="school_id" class="col-xs-4 col-form-label">School ID</label>
                                            <div class="col-xs-8">
                                                <input ng-model="userData.organizationHierarchyAssignments[0].school_id" type="text" class="form-control" id="school_id" placeholder="School ID">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="school_name" class="col-xs-4 col-form-label">School Name</label>
                                            <div class="col-xs-8">
                                                <input ng-model="userData.organizationHierarchyAssignments[0].school_name" type="text" class="form-control" id="school_name" placeholder="School Name">
                                            </div>
                                        </div>
                                    </div>
                                     <!-- course -->
                                    <div class="col-xs-6">
                                        <div class="form-group row">
                                            <label for="course_id" class="col-xs-4 col-form-label">Course ID</label>
                                            <div class="col-xs-8">
                                                <input ng-model="userData.organizationHierarchyAssignments[0].course_id" type="text" class="form-control" id="course_id" placeholder="Course ID">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="course_name" class="col-xs-4 col-form-label">Course Name</label>
                                            <div class="col-xs-8">
                                                <input ng-model="userData.organizationHierarchyAssignments[0].course_name" type="text" class="form-control" id="course_name" placeholder="Course Name">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                                <!-- submit button -->
                                <div class="form-group row">
                                    <div class="col-xs-2 col-xs-offset-10">
                                        <div>
                                            <button type="submit" class="btn btn-primary pull-right" ng-click="buildLink();">Build Link</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="course-admin">
                    <div class="row">
                        <div class="col-xs-12">
                            <h4>Create a Course Admin Moodle Account Link</h4>

                            <form style="padding-top:10px;">
                                <!-- user -->
                                <fieldset class="form-group">
                                    <legend>User</legend>
                                    <div class="form-group row">
                                        <label for="user_id" class="col-xs-2 col-form-label">User ID</label>
                                        <div class="col-xs-10">
                                            <input ng-model="userData.user_id" type="text" class="form-control" id="user_id" placeholder="User ID">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="user_first_name" class="col-xs-2 col-form-label">First Name</label>
                                        <div class="col-xs-10">
                                            <input ng-model="userData.user_first_name" type="text" class="form-control" id="user_first_name" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="user_last_name" class="col-xs-2 col-form-label">Last Name</label>
                                        <div class="col-xs-10">
                                            <input ng-model="userData.user_last_name" type="text" class="form-control" id="user_last_name" placeholder="Last Name">
                                        </div>
                                    </div>
                                </fieldset>
                                <!-- schools/courses -->
                                <div ng-repeat="organizationHierarchyAssignment in userData.organizationHierarchyAssignments">
                                    <fieldset class="form-group" style="margin-bottom:5px;">
                                        <legend>School/Course {{$index + 1}}</legend>
                                        <!-- school -->
                                        <div class="col-xs-6">
                                            <div class="form-group row">
                                                <label for="school_id" class="col-xs-4 col-form-label">School ID</label>
                                                <div class="col-xs-8">
                                                    <input ng-model="userData.organizationHierarchyAssignments[$index].school_id" type="text" class="form-control" id="school_id" placeholder="School ID">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="school_name" class="col-xs-4 col-form-label">School Name</label>
                                                <div class="col-xs-8">
                                                    <input ng-model="userData.organizationHierarchyAssignments[$index].school_name" type="text" class="form-control" id="school_name" placeholder="School Name">
                                                </div>
                                            </div>
                                        </div>
                                         <!-- course -->
                                        <div class="col-xs-6">
                                            <div class="form-group row">
                                                <label for="course_id" class="col-xs-4 col-form-label">Course ID</label>
                                                <div class="col-xs-8">
                                                    <input ng-model="userData.organizationHierarchyAssignments[$index].course_id" type="text" class="form-control" id="course_id" placeholder="Course ID">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="course_name" class="col-xs-4 col-form-label">Course Name</label>
                                                <div class="col-xs-8">
                                                    <input ng-model="userData.organizationHierarchyAssignments[$index].course_name" type="text" class="form-control" id="course_name" placeholder="Course Name">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <!-- remove school/course -->
                                    <div ng-if="$index > 0" class="form-group row">
                                        <div class="col-xs-2 col-xs-offset-10">
                                            <a ng-click="removeUserOrganizationHierarchyAssignment($index);" class="btn btn-danger pull-right">Remove School/Course {{$index + 1}}</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- submit button -->
                                <div class="form-group row">
                                    <div class="col-xs-4 col-xs-offset-8">
                                        <div>
                                            <button ng-click="buildLink();" type="submit" class="btn btn-primary pull-right">Build Link</button>
                                            <a ng-click="addUserOrganizationHierarchyAssignments();" class="btn btn-default pull-right" style="margin-right:10px;">Add School/Course</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="school-admin">
                    <div class="row">
                        <div class="col-xs-12">
                            <h4>Create a School Admin Moodle Account Link</h4>

                            <form style="padding-top:10px;">
                                <!-- user -->
                                <fieldset class="form-group">
                                    <legend>User</legend>
                                    <div class="form-group row">
                                        <label for="user_id" class="col-xs-2 col-form-label">User ID</label>
                                        <div class="col-xs-10">
                                            <input ng-model="userData.user_id" type="text" class="form-control" id="user_id" placeholder="User ID">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="user_first_name" class="col-xs-2 col-form-label">First Name</label>
                                        <div class="col-xs-10">
                                            <input ng-model="userData.user_first_name" type="text" class="form-control" id="user_first_name" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="user_last_name" class="col-xs-2 col-form-label">Last Name</label>
                                        <div class="col-xs-10">
                                            <input ng-model="userData.user_last_name" type="text" class="form-control" id="user_last_name" placeholder="Last Name">
                                        </div>
                                    </div>
                                </fieldset>
                                <!-- schools -->
                                <div ng-repeat="organizationHierarchyAssignment in userData.organizationHierarchyAssignments">
                                    <fieldset class="form-group" style="margin-bottom:5px;">
                                        <legend>School {{$index + 1}}</legend>
                                        <div class="col-xs-6">
                                            <div class="form-group row">
                                                <label for="school_id" class="col-xs-4 col-form-label">School ID</label>
                                                <div class="col-xs-8">
                                                    <input ng-model="userData.organizationHierarchyAssignments[$index].school_id" type="text" class="form-control" id="school_id" placeholder="School ID">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="school_name" class="col-xs-4 col-form-label">School Name</label>
                                                <div class="col-xs-8">
                                                    <input ng-model="userData.organizationHierarchyAssignments[$index].school_name" type="text" class="form-control" id="school_name" placeholder="School Name">
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <!-- remove school -->
                                    <div ng-if="$index > 0" class="form-group row">
                                        <div class="col-xs-2 col-xs-offset-10">
                                            <a ng-click="removeUserOrganizationHierarchyAssignment($index);" class="btn btn-danger pull-right">Remove School {{$index + 1}}</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- submit button -->
                                <div class="form-group row">
                                    <div class="col-xs-4 col-xs-offset-8">
                                        <div>
                                            <button ng-click="buildLink();" type="submit" class="btn btn-primary pull-right">Build Link</button>
                                            <a ng-click="addUserOrganizationHierarchyAssignments();" class="btn btn-default pull-right" style="margin-right:10px;">Add School</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <p class="alert alert-danger" style="padding:15px;">
                    <strong>Moodle Account Login Link:</strong> <span ng-bind-html="link"></span>
                </p>
            </div>
        </div>
    </div>
</div>










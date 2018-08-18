function ebiMoodleLinkBuilderController($scope) {
    /**
     * link - string anchor link that's built when all required form fields have been filled out and the user clicked the Build Link button
     * @type {string}
     */
    $scope.link = null;

    /**
     * userData - form model object that holds user information used to build links
     * @type {Object}
     */
    $scope.userData = {};

    /**
     * selectedLinkType - 'student', 'course-admin', or 'school-admin'.  this value determines how to perform form validation and link building
     * @type {[type]}
     */
    $scope.selectedLinkType = null;

    var isEmpty = function(data) {
        return (data === '' || data === null) ? true : false;
    };

    /**
     * init - initialization routine that prepares the form by setting the selected link type to 'student'
     * @return {void}
     */
    $scope.init = function() {
        $scope.setStudentLinkType();
    };

    /**
     * resetUserData - reset the userData object which is used to build a moodle link
     * @return void
     */
    $scope.resetUserData = function() {
        $scope.userData = {
            user_id: null,
            user_first_name: null,
            user_last_name: null,
            organizationHierarchyAssignments: [{
                school_id: null,
                school_name: null,
                course_id: null,
                course_name: null
            }]
        };
    };

    /**
     * addUserOrganizationHierarchyAssignments description - add a school/course to the form
     */
    $scope.addUserOrganizationHierarchyAssignments = function() {
        $scope.userData.organizationHierarchyAssignments.push({
            school_id: null,
            school_name: null,
            course_id: null,
            course_name: null
        });
    };

    /**
     * removeUserOrganizationHierarchyAssignment - remove a previosuly added school/course from the form
     * @param  {int} index - index to remove
     * @return {void}
     */
    $scope.removeUserOrganizationHierarchyAssignment = function(index) {
        if(index > 0 && index < $scope.userData.organizationHierarchyAssignments.length) {
            $scope.userData.organizationHierarchyAssignments.splice(index, 1);
        }
    };

    /**
     * setStudentLinkType - configure the form for generating student links
     */
    $scope.setStudentLinkType = function() {
        $scope.selectedLinkType = 'student';
        $scope.resetUserData();
        $scope.resetLink();

        /*
        'user_id',
        'user_first_name',
        'user_last_name',
        'school_id',
        'school_name',
        'course_id',
        'course_name'
        */
    };


    /**
     * setCourseAdminLinkType - configure the form for generating course admin links
     */
    $scope.setCourseAdminLinkType = function() {
        $scope.selectedLinkType = 'course-admin';
        $scope.resetUserData();
        $scope.resetLink();
        /*
        'user_id',
        'user_first_name',
        'user_last_name',
        'school_id',
        'school_name',
        'course_id',
        'course_name'
         */
    };

    /**
     * setSchoolAdminLinkType - configure the form for generating school admin links
     */
    $scope.setSchoolAdminLinkType = function() {
        $scope.selectedLinkType = 'school-admin';
        $scope.resetUserData();
        $scope.resetLink();
        /*
        'user_id',
        'user_first_name',
        'user_last_name',
        'school_id',
        'school_name'
         */
    };

    /**
     * validateUserData - form validation that's run before link building runs
     * @return {boolean} - true if form validation is successfull, false otherwise
     */
    $scope.validateUserData = function() {

        if(isEmpty($scope.userData.user_id)) {
            MR.utils.alert({type:'error', message: 'User ID is required!'});
            return false;
        }

        if(isEmpty($scope.userData.user_first_name)) {
            MR.utils.alert({type:'error', message: 'First Name is required!'});
            return false;
        }

        if(isEmpty($scope.userData.user_last_name)) {
            MR.utils.alert({type:'error', message: 'Last Name is required!'});
            return false;
        }

        switch($scope.selectedLinkType) {
            case 'student':
                if(isEmpty($scope.userData.organizationHierarchyAssignments[0].school_id)) {
                    MR.utils.alert({type:'error', message: 'School ID is required!'});
                    return false;
                }

                if(isEmpty($scope.userData.organizationHierarchyAssignments[0].school_name)) {
                    MR.utils.alert({type:'error', message: 'School Name is required!'});
                    return false;
                }

                if(isEmpty($scope.userData.organizationHierarchyAssignments[0].course_id)) {
                    MR.utils.alert({type:'error', message: 'Course ID is required!'});
                    return false;
                }

                if(isEmpty($scope.userData.organizationHierarchyAssignments[0].course_name)) {
                    MR.utils.alert({type:'error', message: 'Course Name is required!'});
                    return false;
                }
            break;

            case 'course-admin':
                for(i = 0; i < $scope.userData.organizationHierarchyAssignments.length; i++) {
                    if(isEmpty($scope.userData.organizationHierarchyAssignments[i].school_id)) {
                        MR.utils.alert({type:'error', message: 'School ID is required for School/Course ' + (i + 1) + '!'});
                        return false;
                    }

                    if(isEmpty($scope.userData.organizationHierarchyAssignments[i].school_name)) {
                        MR.utils.alert({type:'error', message: 'School Name is required for School/Course ' + (i + 1) + '!'});
                        return false;
                    }

                    if(isEmpty($scope.userData.organizationHierarchyAssignments[i].course_id)) {
                        MR.utils.alert({type:'error', message: 'Course ID is required for School/Course ' + (i + 1) + '!'});
                        return false;
                    }

                    if(isEmpty($scope.userData.organizationHierarchyAssignments[i].course_name)) {
                        MR.utils.alert({type:'error', message: 'Course Name is required for School/Course ' + (i + 1) + '!'});
                        return false;
                    }
                }
            break;

            case 'school-admin':
                for(i = 0; i < $scope.userData.organizationHierarchyAssignments.length; i++) {
                    if(isEmpty($scope.userData.organizationHierarchyAssignments[i].school_id)) {
                        MR.utils.alert({type:'error', message: 'School ID is required for School ' + (i + 1) + '!'});
                        return false;
                    }

                    if(isEmpty($scope.userData.organizationHierarchyAssignments[i].school_name)) {
                        MR.utils.alert({type:'error', message: 'School Name is required for School ' + (i + 1) + '!'});
                        return false;
                    }
                }
            break;
        }

        return true;
    };

    /**
     * buildStudentLink - builds a link for a student user
     * @return boolean - whether or not the link was built
     */
    $scope.buildStudentLink = function() {
        if($scope.validateUserData()) {
            var url = '/login/launch_student?'
                + 'user_id=' + encodeURIComponent($scope.userData.user_id) + '&'
                + 'user_first_name=' + encodeURIComponent($scope.userData.user_first_name) + '&'
                + 'user_last_name=' + encodeURIComponent($scope.userData.user_last_name) + '&'
                + 'school_id=' + encodeURIComponent($scope.userData.organizationHierarchyAssignments[0].school_id) + '&'
                + 'school_name=' + encodeURIComponent($scope.userData.organizationHierarchyAssignments[0].school_name) + '&'
                + 'course_id=' + encodeURIComponent($scope.userData.organizationHierarchyAssignments[0].course_id) + '&'
                + 'course_name=' + encodeURIComponent($scope.userData.organizationHierarchyAssignments[0].course_name);

            var username = $scope.userData.user_first_name + ' ' + $scope.userData.user_last_name;
            $scope.link = '<a class="" href="' + url + '">Login as ' + username + '</a>';
            MR.utils.alert({type:'success', message: 'Please visit the link below to login as ' + username + '!'});
        }
    };

    /**
     * buildCourseAdminLink - builds a link for a course admin user
     * @return boolean - whether or not the link was built
     */
    $scope.buildCourseAdminLink = function() {
        if($scope.validateUserData()) {
            var url = '/login/launch_course_admin?'
                + 'user_id=' + encodeURIComponent($scope.userData.user_id) + '&'
                + 'user_first_name=' + encodeURIComponent($scope.userData.user_first_name) + '&'
                + 'user_last_name=' + encodeURIComponent($scope.userData.user_last_name);

                // add school parameters for each school/course
                for(i = 0; i < $scope.userData.organizationHierarchyAssignments.length; i++) {
                    url += '&school_id[]=' + encodeURIComponent($scope.userData.organizationHierarchyAssignments[i].school_id);
                    url += '&school_name[]=' + encodeURIComponent($scope.userData.organizationHierarchyAssignments[i].school_name);
                }

                // add course parameters for each school/course
                for(j = 0; j < $scope.userData.organizationHierarchyAssignments.length; j++) {
                    url += '&course_id[]=' + encodeURIComponent($scope.userData.organizationHierarchyAssignments[j].course_id);
                    url += '&course_name[]=' + encodeURIComponent($scope.userData.organizationHierarchyAssignments[j].course_name);
                }

            var username = $scope.userData.user_first_name + ' ' + $scope.userData.user_last_name;
            $scope.link = '<a class="" href="' + url + '">Login as ' + username + '</a>';
            MR.utils.alert({type:'success', message: 'Please visit the link below to login as ' + username + '!'});
        }
    };

    /**
     * buildSchoolAdminLink - builds a link for a school admin user
     * @return boolean - whether or not the link was built
     */
    $scope.buildSchoolAdminLink = function() {
        if($scope.validateUserData()) {
            var url = '/login/launch_school_admin?'
                + 'user_id=' + encodeURIComponent($scope.userData.user_id) + '&'
                + 'user_first_name=' + encodeURIComponent($scope.userData.user_first_name) + '&'
                + 'user_last_name=' + encodeURIComponent($scope.userData.user_last_name);

                // add school parameters for each school
                for(i = 0; i < $scope.userData.organizationHierarchyAssignments.length; i++) {
                    url += '&school_id[]=' + encodeURIComponent($scope.userData.organizationHierarchyAssignments[i].school_id);
                    url += '&school_name[]=' + encodeURIComponent($scope.userData.organizationHierarchyAssignments[i].school_name);
                }

            var username = $scope.userData.user_first_name + ' ' + $scope.userData.user_last_name;
            $scope.link = '<a class="" href="' + url + '">Login as ' + username + '</a>';
            MR.utils.alert({type:'success', message: 'Please visit the link below to login as ' + username + '!'});
        }
    };

    /**
     * resetLink - set the link to null
     * @return boolean - whether or not the link needed reset
     */
    $scope.resetLink = function() {
        var wasReset = ($scope.link !== null) ? true : false;
        $scope.link = null;
        return wasReset;
    }

    /**
     * buildLink - build the appropriate link type depending on selectedLinkType
     * @return boolean
     */
    $scope.buildLink = function() {
        $scope.resetLink();

        switch($scope.selectedLinkType) {
            case 'student':
                return $scope.buildStudentLink();
            break;

            case 'course-admin':
                return $scope.buildCourseAdminLink();
            break;

            case 'school-admin':
                return $scope.buildSchoolAdminLink();
            break;
        }

        return false;
    };

    // initialize the moodle link builder
    $scope.init();
}
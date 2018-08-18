function tssDashboardController($scope, $rootScope, $http, $injector, $q, $sce, $cookieStore, $location, $filter) {

    $scope.dashboard_data = [];
    $scope.dashboard_simulation_attempt_details_data = [];
    $scope.dashboard_simulation_attempt_details_username = '';
    $scope.dashboard_simulation_attempt_details_simulation_attempt = '';
    $scope.dashboard_simulation_attempt_scoring_data = {};

    $scope.show_spinner = false;

    $scope.load_dashboard_data = function() {
        $scope.show_spinner = true;
        $http.get('/admin/ajax_angular_get_dashboard_data')
            .success(function(data, status, headers, config) {
                $scope.dashboard_data = data.dashboard_data;
                $scope.show_spinner = false;
            }).error(function(data, status, headers, config) {
                MR.utils.alert({type:'error',message:'load_dashboard_data error.'});
                $scope.show_spinner = false;
        });
    };

    $scope.export_dashboard_data_csv = function() {console.log('export');
        $scope.show_spinner = true;
        $http.get('/admin/ajax_angular_export_dashboard_data_csv').success(function(data, status, headers, config) {
            if(data.status == 'success') {
                window.location = '/' + MR.core.base_url + 'admin/download/tssim_dashboad_data/' + data.file;
            } else {
                MR.utils.alert({type:'error',message:data.message});
            }
            $scope.show_spinner = false;
        }).error(function(data, status, headers, config) {
            MR.utils.alert({type:'error',message:'failed to export log file.'});
            $scope.show_spinner = false;
        });
    };

    $scope.get_dashboard_simulation_attempt_details_data = function(user_id, username, simulation_attempt) {
        var url = '/admin/ajax_angular_get_dashboard_simulation_attempt_details_data/' + user_id + '/' + simulation_attempt;

        $scope.dashboard_simulation_attempt_details_username = username;
        $scope.dashboard_simulation_attempt_details_simulation_attempt = simulation_attempt;

        $http.get(url)
            .success(function(data, status, headers, config) {
                $scope.dashboard_simulation_attempt_details_data = data.dashboard_simulation_attempt_details_data;
                MR.modal.show("#dashboard-simulation-attempt-details-modal");
            }).error(function(data, status, headers, config) {
                alert('get_dashboard_simulation_attempt_details_data error');
        });
    };

    $scope.resume_simulation = function() {
        window.location = '/';
    };

    $scope.retake_simulation = function() {
        $http.get('/admin/ajax_angular_retake_simulation')
            .success(function(data, status, headers, config) {
                window.location = '/#/START/HIntroD001';
            }).error(function(data, status, headers, config) {
                alert('retake_simulation error');
        });
    };

    $scope.show_dashboard_simulation_attempt_scoring_modal = function(dashboard_data_row) {
        $scope.dashboard_simulation_attempt_scoring_data = dashboard_data_row;
        console.log($scope.dashboard_simulation_attempt_scoring_data);

        MR.modal.show("#dashboard-simulation-attempt-scoring-modal");
    };

};
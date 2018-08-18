function defaultDashboardController($scope, $rootScope, $http, $injector, $q, $sce, $cookieStore, $location, $filter) {
    //$injector.invoke(dashboardController, this, {$scope: $scope});

    $scope.name = 'reports';
    $scope.data_row_clicked = '';
    $scope.mr_project_filter = 'all';

    $scope.usage_data = {
        usage_summary: {
            number_of_sessions: 0,
            number_of_questions: 0,
            average_session_duration : 0
        },
        most_frequently_asked_questions: []
    };

    $scope.session = [];
    $scope.session_detail = {
        data: []
    };

    $scope.survey_responses_data = [];

    $scope.chart = null;

    /***
     * Does all of the URL routing
     */
    $scope.$on("$locationChangeStart", function(event, next, current) {
        var str = MR.utils.getHash(next);
        if (str){
            if (str.substring(0, 1) == '/') {
                str = str.substring(1);
            }
            str = str.split("/");
            switch(str[0])
            {
                case 'session-data':
                case 'modified-session-data':
                case 'session-count-frequencies':
                case 'modified-session-count-frequencies':
                case 'most-frequently-asked-questions':
                case 'summary':
                case 'modified-summary':
                case 'responses-viewed':
                case 'responses-viewed-via-user-questions':
                case 'responses-viewed-via-related-questions':
                case 'responses-viewed-via-left-rail-questions':
                case 'responses-viewed-per-category':
                case 'surveys':
                    jQuery('a[href="#' + str[0] + '"]').tab('show');
                break;
                case 'session-data-graph':
                case 'modified-session-data-graph':
                    jQuery('a[href="#' + str[0] + '"]').tab('show');

                    if($scope.chart !== null) {
                        $scope.chart.reflow(); // resizes the chart
                    }
                break;
                default:
                break;
            }
        }
    });

    $scope.get_usage_data = function(user_id) {
        var get_usage_data = function() {
            var postvars = {
                mr_project_filter: $scope.mr_project_filter,
                organization_hierarchy_level_elements_filter: [],
                user_id_filter: []
            };

            // extract hierarchy level filters if any
            $scope.organization_hierarchy.filter.selected_element_ids.forEach(function(organization_hierarchy_level_element_id) {
                if(organization_hierarchy_level_element_id !== null) {
                    postvars.organization_hierarchy_level_elements_filter.push(organization_hierarchy_level_element_id);
                }
            });

            $scope.username_filter.selected_elements.forEach(function(element) {
                postvars.user_id_filter.push(element.id);
            });

            $http.post('/admin/ajax_angular_get_usage_data/', postvars)
                .success(function(data, status, headers, config){
                    $scope.usage_data = data.usage_data;
                    $scope.draw_session_data_graph(data.usage_data.modified_sessions_summary_graph_data);
                }).error(function(data, status, headers, config){
                    alert('get_usage_data error');
            });
        };

        if(!$scope.organization_hierarchy.filter.selected_element_ids_initialized) {
            $scope.get_organizations(get_usage_data);
        } else {
            get_usage_data();
        }
    };

    $scope.get_session_detail = function(id) {
        var postvars = { session_id : id };
        $http.post('/admin/ajax_angular_get_session_detail', postvars)
            .success(function(data, status, headers, config) {
                $(data.session_detail).each(function(index,value) {
                    /* Split these because they come in from the controller separated by a hyphen */
                    if (value.platform) {
                        value.platform = MR.utils.parseBrowserIcons(value.platform.split("-"));
                    }
                });
                $scope.session_detail.data = data.session_detail;
                $scope.data_row_clicked = id;
                MR.modal.show("#sd-modal");

            }).error(function(data, status, headers, config){
                alert('get_session_detail error');
            });
    };

    $scope.get_modified_session_detail = function(id, session_id) {
        var postvars = { processed_session_id : id };
        $http.post('/admin/ajax_angular_get_modified_session_detail', postvars)
            .success(function(data, status, headers, config) {
                $(data.session_detail).each(function(index,value) {
                    /* Split these because they come in from the controller separated by a hyphen */
                    if (value.platform) {
                        value.platform = MR.utils.parseBrowserIcons(value.platform.split("-"));
                    }
                });
                $scope.session_detail.data = data.session_detail;
                $scope.data_row_clicked = session_id;
                MR.modal.show("#sd-modal");

            }).error(function(data, status, headers, config){
                alert('get_modified_session_detail error');
            });
    };

    $scope.get_survey_responses_data = function() {
        $http.post('/surveys/ajax_angular_get_survey_responses_data')
            .success(function(data, status, headers, config) {
                $scope.survey_responses_data = data.survey_responses_data;
            }).error(function(data, status, headers, config){
                alert('get_survey_responses_data error');
            });
    };

    $scope.draw_session_data_graph = function(modified_sessions_summary_graph_data) {
        angular.forEach(modified_sessions_summary_graph_data, function(value, key) {
            var date_parts = value[0].split('-');
            this[key][0] = Date.UTC(date_parts[0], date_parts[1]-1, date_parts[2]);
        }, modified_sessions_summary_graph_data);

         $scope.chart = new Highcharts.Chart({
            chart: {
                type: 'spline',
                zoomType: 'x',
                renderTo: 'session-data-graph-container'
            },
            title: {
                text: 'Number of Sessions over Time'
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
            },
            xAxis: {
                type: 'datetime'
            },
            yAxis: {
                title: {
                    text: 'Number of Sessions'
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                spline: {
                    marker: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'Number of Sessions',
                data: modified_sessions_summary_graph_data
            }]
        });

    };
}
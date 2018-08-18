function dashboardController($scope, $rootScope, $http, $q, $timeout /*, existingUserService */) {
    $scope.filtered_activity_logs          = [];
    $scope.actions                         = [];
    $scope.activity_logs                   = [];
    $scope.activity_logs_offset            = 0;
    $scope.activity_logs_number_of_rows    = 100;
    $scope.activity_logs_mr_project_filter = 'all';
    $scope.activity_logs_language_filter   = 'all';
    $scope.term_definitions                = [];
    $scope.term_definition_to_edit         = {};
    $scope.term_definition_to_insert = {
        term       : '',
        definition : '',
        active     : 1
    };
    $scope.log_users                       = [];
    $scope.log_actions                     = [];
    $scope.log_browsers                    = [];
    $scope.user_types                      = [];
    $scope.users                           = [];
    $scope.username_filter = {
        elements          : [],
        selected_elements : [],
        settings          : {
            buttonClasses  : 'btn btn-default btn-sm',
            displayProp    : 'username',
            idProp         : 'id',
            enableSearch   : true,
            scrollable     : true,
            showCheckAll   : false,
            showUncheckAll : false
        },
        translation_texts  : {
            buttonDefaultText       : 'Filter Out Users',
            dynamicButtonTextSuffix : 'Users Filtered Out'
        }
    };
    $scope.organizations = [];
    $scope.organization_hierarchy = {
        form : {
            levels               : [],
            level_elements       : [],
            user_type_level_map  : [],
            selected_element_ids : {
                new_user      : [],
                existing_user : []
            }
        },
        filter : {
            levels                           : [],
            level_elements                   : [],
            user_type_level_map              : [],
            selected_element_ids             : [],
            selected_element_ids_initialized : false
        }
    };
    $scope.provinces                            = [];
    $scope.new_user                             = {};
    $scope.existing_user                        = {};
    $scope.selected_activity_log                = {};
    $scope.showDialog                           = false;
    $scope.showEditDialog                       = false;
    $scope.showInfoDialog                       = false;
    $scope.showConfirmDeleteDialog              = false;
    $scope.error_message                        = '';
    $scope.showDashboardStatus                  = false;
    $scope.status_message_title                 = '';
    $scope.status_message_body                  = '';
    $scope.search                               = '';
    $scope.search_query_in_progress             = false;
    $scope.ready_for_more_activity_log_entries  = true;
    $scope.search_start_date                    = new Date(2014,8,1);
    $scope.search_end_date                      = new Date();
    $scope.search_keyword                       = '';
    $scope.end_datepicker_opened                = false;
    $scope.start_datepicker_opened              = false;

    $scope.end_datepicker_open = function($event) {
        $event.preventDefault();
        $event.stopPropagation();

        $scope.end_datepicker_opened = true;
    };
    $scope.start_datepicker_open = function($event) {
        $event.preventDefault();
        $event.stopPropagation();

        $scope.start_datepicker_opened = true;
    };

    $scope.add_user = function(new_user) {
        var postvars = $scope.new_user;
        postvars.organization_hierarchy_level_element_ids = $scope.prep_selected_organization_hierarchy_level_element_ids_for_submit('new_user');

        $http.post('/admin/ajax_angular_add_user', postvars).
        success(function(data, status, headers, config) {
            if(data.status == 'success') {
                $scope.users.push(data.user);
                $scope.users = [];
                $scope.get_users();
                $scope.init_new_user();
                $scope.showDialog = false;
                MR.utils.alert({delay:600000, removeOnClick:false, type:'success', message: data.message});
            } else {
                MR.utils.alert({type:'error',message:data.message});
            }
        }).error(function(data, status, headers, config) {
            MR.utils.alert({type:'error',message:'failed to add user.'});
        });
    }

    $scope.delete_user = function() {
        $http.post('/admin/ajax_angular_delete_user', $scope.existing_user).
        success(function(data, status, headers, config) {
            if(data.status == 'success') {
                $scope.showConfirmDeleteDialog = false;
                $scope.showEditDialog = false;
                $scope.users = [];
                $scope.get_users();
            } else {
                MR.utils.alert({type:'error',message:data.message});
            }
        }).error(function(data, status, headers, config) {
            MR.utils.alert({type:'error',message:'failed to delete user.'});
        });
    }

    $scope.edit_my_user = function() {
        if($('#edit_user_password').val() == '') {
            return MR.utils.alert({type:'warning',message:'You have not supplied an updated password.'});
        }
        $http.post('/admin/ajax_angular_edit_my_user', $scope.existing_user).
        success(function(data, status, headers, config) {
            if(data.status == 'success') {
                $scope.user = {};
                $scope.get_my_user();
                MR.utils.alert({type:'success',message:'Information has been updated.'});
            } else {
                MR.utils.alert({type:'error',message:data.message});
                $scope.get_my_user();
            }
        }).error(function(data, status, headers, config) {
            MR.utils.alert({type:'error',message:'failed to edit user.'});
        });
    }

    $scope.edit_user = function() {
        var postvars = $scope.existing_user;
        postvars.organization_hierarchy_level_element_ids = $scope.prep_selected_organization_hierarchy_level_element_ids_for_submit('existing_user');

        $http.post('/admin/ajax_angular_edit_user', postvars).
        success(function(data, status, headers, config) {
            if(data.status == 'success') {
                $scope.showEditDialog = false;
                $scope.users = [];
                $scope.get_users();
            } else {
                MR.utils.alert({type:'error',message:data.message});
                $scope.get_users();
            }
        }).error(function(data, status, headers, config) {
            MR.utils.alert({type:'error',message:'failed to edit user.'});
        });
    }

    $scope.export_activity_log = function(mr_project_filter, language_filter, search_keyword, search_start_date, search_end_date) {
    var postvars = {
            mr_project_filter                            : mr_project_filter,
            language_filter                              : language_filter,
            search_keyword                               : search_keyword,
            search_start_date                            : search_start_date,
            search_end_date                              : search_end_date,
            organization_hierarchy_level_elements_filter : [],
            user_id_filter                               : []
    }

    // extract hierarchy level filters if any
    $scope.organization_hierarchy.filter.selected_element_ids.forEach(function(organization_hierarchy_level_element_id) {
        if(organization_hierarchy_level_element_id !== null) {
            postvars.organization_hierarchy_level_elements_filter.push(organization_hierarchy_level_element_id);
        }
    });

    $scope.username_filter.selected_elements.forEach(function(element) {
        postvars.user_id_filter.push(element.id);
    });

    $scope.file_upload_spinner('#file_upload_spinner', true);

    $http.post('/admin/ajax_angular_export_activity_log', postvars).
        success(function(data, status, headers, config) {
            $scope.file_upload_spinner('#file_upload_spinner', false);

            if(data.status == 'success') {
                window.location = '/' + MR.core.base_url + 'admin/download/activity_logs/' + data.file;
            } else {
                MR.utils.alert({type:'error',message:data.message});
            }
        }).error(function(data, status, headers, config) {
            $scope.file_upload_spinner('#file_upload_spinner', false);
            MR.utils.alert({type:'error',message:'failed to export log file.'});
        });
    }

    $scope.export_csv = function(report_type, data) {
        var postvars = {
            data : data,
            report_type                                  : report_type,
            mr_project_filter                            : $scope.mr_project_filter,
            organization_hierarchy_level_elements_filter : []
        };

        // extract hierarchy level filters if any
        $scope.organization_hierarchy.filter.selected_element_ids.forEach(function(organization_hierarchy_level_element_id) {
            if(organization_hierarchy_level_element_id !== null) {
                postvars.organization_hierarchy_level_elements_filter.push(organization_hierarchy_level_element_id);
            }
        });

        $http.post('/admin/ajax_angular_export_csv', postvars)
            .success(function(data, status, headers, config) {
                if(data.status == 'success') {
                    window.location = '/' + MR.core.base_url + 'admin/download/' + data.report_type + '/' + data.file;
                } else {
                    console.debug(data);
                }
            }).error(function(data, status, headers, config) {
                MR.utils.alert({type:'error',message:'failed to export CSV.'});
            });
    }

    $scope.export_feedback_logs_spreadsheet = function() {

        $http.get('/admin/ajax_angular_export_feedback_logs_spreadsheet')
            .success(function(data, status, headers, config) {
                if(data.status == 'success') {
                    window.location = '/' + MR.core.base_url + 'admin/download/feedback_logs/' + data.file;
                } else {
                    MR.utils.alert({type:'error',message:data.message});
                }
            }).error(function(data, status, headers, config) {
                MR.utils.alert({type:'error',message:'failed to export session spreadsheet.'});
            });
    };

    $scope.export_session_spreadsheet = function() {
        var postvars = {
            mr_project_filter                            : $scope.mr_project_filter,
            organization_hierarchy_level_elements_filter : [],
            user_id_filter                               : []
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

        $http.post('/admin/ajax_angular_export_session_spreadsheet', postvars)
            .success(function(data, status, headers, config) {
                if(data.status == 'success') {
                    window.location = '/' + MR.core.base_url + 'admin/download/session_statistics/' + data.file;
                } else {
                    MR.utils.alert({type:'error',message:data.message});
                }
            }).error(function(data, status, headers, config) {
                MR.utils.alert({type:'error',message:'failed to export session spreadsheet.'});
            });
    };

    $scope.export_survey_logs = function() {
        $http.post('/admin/ajax_angular_export_survey_logs', {})
            .success(function(data, status, headers, config) {
                if(data.status == 'success') {
                    window.location = '/' + MR.core.base_url + 'admin/download/session_statistics/' + data.file;
                } else {
                    MR.utils.alert({type:'error',message:data.message});
                }
            }).error(function(data, status, headers, config) {
                MR.utils.alert({type:'error',message:'failed to export session spreadsheet.'});
            });
    };

    $scope.filter_log = function(username, action, browser) {
        var filtered_logs = [];
        if(username == null && browser == null && action == null) {
            filtered_logs = $scope.activity_logs;
        } else if(browser == null && action == null) {
            filtered_logs = $scope.activity_logs.filter(function(val) {
                return username == val.username
            });
        } else if(username == null && action == null) {
            filtered_logs = $scope.activity_logs.filter(function(val) {
                return browser == val.browser
            });
        } else if(username == null && browser == null) {
            filtered_logs = $scope.activity_logs.filter(function(val) {
                return action == val.action
            });
        } else if(action == null) {
            filtered_logs = $scope.activity_logs.filter(function(val) {
                return username == val.username &&
                         browser == val.browser;
            });
        } else if(username == null) {
            filtered_logs = $scope.activity_logs.filter(function(val) {
                return action == val.action &&
                         browser == val.browser;
            });
        } else if(browser == null) {
            filtered_logs = $scope.activity_logs.filter(function(val) {
                return action == val.action &&
                         username == val.username;
            });
        } else {
            filtered_logs = $scope.activity_logs.filter(function(val) {
                return username == val.username &&
                         action == val.action &&
                         browser == val.browser;
            });
        }

        $scope.filtered_activity_logs = filtered_logs;
    }

    $scope.get_actions = function() {
        $http.get('/admin/ajax_angular_get_actions/')
            .success(function(data, status, headers, config) {
                if(data.status === 'success') {
                    data.actions.forEach (function(a) {
                        $scope.actions.push(a);
                    });
                } else {
                    MR.utils.alert({type:'error',message:'failed to load actions.'});
                }
        }).error(function(data, status, headers, config) {
            alert('get_actions error');
        });
    };

    $scope.get_activity_logs = function() {
        if(!$scope.ready_for_more_activity_log_entries) {
            return;
        }

        $scope.ready_for_more_activity_log_entries = false;
        $scope.show_spinner="1";

        $scope.get_organizations(function() {
            var postvars = {
                    mr_project_filter                            : $scope.activity_logs_mr_project_filter,
                    language_filter                              : $scope.activity_logs_language_filter,
                    offset                                       : $scope.activity_logs_offset,
                    number_of_rows                               : $scope.activity_logs_number_of_rows,
                    search_keyword                               : $scope.search_keyword,
                    search_start_date                            : $scope.search_start_date,
                    search_end_date                              : $scope.search_end_date,
                    organization_hierarchy_level_elements_filter : [],
                    user_id_filter                               : []
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

            $http.post('/admin/ajax_angular_get_activity_logs/', postvars)
                .success(function(data, status, headers, config) {
                    if(data.activity_logs.length > 0) {
                        data.activity_logs.forEach (function(a) {
                            if(a.browser) {
                                a.browser = MR.utils.parseBrowserIcons(a.browser);
                            }
                            if(a.operating_system) {
                                a.operating_system = MR.utils.parseBrowserIcons(a.operating_system);
                            }
                            $scope.activity_logs.push(a);
                            $scope.filtered_activity_logs.push(a);
                        });

                        $scope.log_users = data.log_users;
                        $scope.log_browsers = data.log_browsers;
                        $scope.log_actions = data.log_actions;
                        $scope.activity_logs_offset += data.activity_logs.length;
                    }

                    $scope.show_spinner="0";
                        setTimeout(function() {$scope.ready_for_more_activity_log_entries = true;}, 1000);
                }).error(function(data, status, headers, config) {
                    alert('get_activity_logs error');
                    $scope.show_spinner="0";
                    setTimeout(function() {$scope.ready_for_more_activity_log_entries = true;}, 1000);
                });
        });
    };

    $scope.get_term_definitions = function() {
        $http.get('/admin/ajax_angular_get_term_definitions/')
            .success(function(data, status, headers, config) {
                $scope.term_definitions = data.term_definitions;
            }).error(function(data, status, headers, config) {
                alert('get_term_definitions error');
            });
    };

    $scope.set_term_definition_to_edit = function(term_definition) {
        $scope.$parent.$apply(function() {
            $scope.$parent.term_definition_to_edit = term_definition;
        });
    };

    $scope.edit_term_definition = function() {
        $http.post('/admin/ajax_angular_edit_term_definition', $scope.term_definition_to_edit)
            .success(function(data, status, headers, config) {
                if(data.status == 'success') {
                    $scope.showEditDialog = false;
                    $scope.term_definitions = [];
                    $scope.get_term_definitions();
                } else {
                    MR.utils.alert({type:'error', message:data.message});
                    $scope.get_term_definitions();
                }
            }).error(function(data, status, headers, config) {
                MR.utils.alert({type:'error',message:'failed to edit term definition.'});
            });
    };

    $scope.insert_term_definition = function() {
        $http.post('/admin/ajax_angular_insert_term_definition', $scope.term_definition_to_insert)
            .success(function(data, status, headers, config) {
                if(data.status == 'success') {
                    $scope.showDialog = false;
                    $scope.term_definitions = [];
                    $scope.get_term_definitions();
                    $scope.term_definition_to_insert = {
                        term: '',
                        definition: '',
                        active: 1
                    };
                } else {
                    MR.utils.alert({type:'error', message:data.message});
                    $scope.get_term_definitions();
                }
            }).error(function(data, status, headers, config) {
                MR.utils.alert({type:'error',message:'failed to insert term definition.'});
            });
    };

    $scope.get_organizations = function(callback) {
        var callback = callback || function() {};
        $http({method: 'GET', url: '/admin/ajax_angular_get_organizations'}).
            success(function(data, status, headers, config) {
                $scope.organizations                                                  = data.organizations;
                $scope.organization_hierarchy.form.levels                             = data.organization_hierarchy_levels.all;
                $scope.organization_hierarchy.form.level_elements                     = data.organization_hierarchy_level_elements.all;
                $scope.organization_hierarchy.form.user_type_level_map                = data.user_type_organization_hierarchy_level_map;
                $scope.organization_hierarchy.form.selected_element_ids.new_user      = [];
                $scope.organization_hierarchy.form.selected_element_ids.existing_user = [];

                // add the default 'All' elements option to each hierarchy level
                angular.forEach(data.organization_hierarchy_levels.current, function(level) {
                    data.organization_hierarchy_level_elements.current.unshift({
                        organization_hierarchy_level_id                 : level.organization_hierarchy_level_id,
                        organization_hierarchy_level_parent_id          : level.organization_hierarchy_level_parent_id,
                        organization_hierarchy_level_element_id         : 0,
                        organization_hierarchy_level_element_parent_id  : 0,
                        organization_hierarchy_level_element_name       : 'All ' + level.organization_hierarchy_level_plural_name
                    });

                    // set the default selected filter element for this level to the 'All' option if one hasn't already been specified
                    if(!$scope.organization_hierarchy.filter.selected_element_ids_initialized) {
                        $scope.organization_hierarchy.filter.selected_element_ids[level.organization_hierarchy_level_id] = 0;
                    }
                });

                // override the 'All' filter option at each level the user has been assigned to an element
                if(!$scope.organization_hierarchy.filter.selected_element_ids_initialized) {
                    angular.forEach(data.assigned_organization_hierarchy_level_elements, function(row) {
                        $scope.organization_hierarchy.filter.selected_element_ids[row.organization_hierarchy_level_id] = row.organization_hierarchy_level_element_id;
                    });
                }

                $scope.organization_hierarchy.filter.levels = data.organization_hierarchy_levels.current;
                $scope.organization_hierarchy.filter.level_elements = data.organization_hierarchy_level_elements.current;
                $scope.organization_hierarchy.filter.selected_element_ids_initialized = true;

                callback();
            }).error(function(data, status, headers, config) {
                MR.utils.alert({type:'error',message:'failed to load organizations.'});
            }
        );
    };

    $scope.get_provinces = function() {
        $http({method: 'GET', url: '/admin/ajax_angular_get_provinces'}).
            success(function(data, status, headers, config) {
                $scope.provinces = data.provinces;
            }).error(function(data, status, headers, config) {
                MR.utils.alert({type:'error',message:'failed to load provinces.'});
            }
        );
    }

    $scope.get_my_user = function() {
        $http.post('/admin/ajax_angular_get_my_user', {}).
            success(function(data, status, headers, config) {
                $scope.existing_user = data.user;
                $scope.user_types = data.user_types;
                $scope.organizations = data.organizations;
            }).error(function(data, status, headers, config)
            {
                alert('get_users error');
            }
        );
    };

    $scope.get_users = function() {
        $scope.get_organizations(function() {
            var postvars = {
                search                                       : $scope.search,
                organization_hierarchy_level_elements_filter : []
            };

            // extract hierarchy level filters if any
            $scope.organization_hierarchy.filter.selected_element_ids.forEach(function(organization_hierarchy_level_element_id) {
                if(organization_hierarchy_level_element_id !== null) {
                    postvars.organization_hierarchy_level_elements_filter.push(organization_hierarchy_level_element_id);
                }
            });

            $http.post('/admin/ajax_angular_get_users', postvars).
                success(function(data, status, headers, config)
                {
                    $scope.users = data.users;
                    $scope.user_types = data.user_types;
                    $scope.users_organization_hierarchy_level_elements_map_entries = data.users_organization_hierarchy_level_elements_map_entries;
                    $scope.search_query_in_progress = false;
                }).
                error(function(data, status, headers, config)
                {
                    alert('get_users error');
                    $scope.search_query_in_progress = false;
                }
            );
        });
    };

    $scope.get_usernames = function() {
        $http.get('/admin/ajax_angular_get_usernames')
            .success(function(data, status, headers, config) {
                $timeout(function() {
                    $scope.$apply(function() {
                        $scope.username_filter.elements = data.usernames;
                    });
                })


            }).error(function(data, status, headers, config) {
                alert('get_usernames error');
            }
        );
    };

    $scope.init_existing_user = function(user) {
        $scope.$parent.$apply(function() {
            $scope.$parent.existing_user = user;
            $scope.$parent.organization_hierarchy.form.selected_element_ids.existing_user = [];

            if($scope.$parent.users_organization_hierarchy_level_elements_map_entries.hasOwnProperty(user.id)) {
                for(var organization_hierarchy_level_id in $scope.$parent.users_organization_hierarchy_level_elements_map_entries[user.id]) {
                    $scope.$parent.organization_hierarchy.form.selected_element_ids.existing_user[organization_hierarchy_level_id] = [];

                    if(angular.isArray($scope.$parent.users_organization_hierarchy_level_elements_map_entries[user.id][organization_hierarchy_level_id])) {
                        $scope.$parent.users_organization_hierarchy_level_elements_map_entries[user.id][organization_hierarchy_level_id].forEach(function(organization_hierarchy_level_element_id) {
                            $scope.$parent.organization_hierarchy.form.selected_element_ids.existing_user[organization_hierarchy_level_id].push(organization_hierarchy_level_element_id);
                        });
                    } else {
                        $scope.$parent.organization_hierarchy.form.selected_element_ids.existing_user[organization_hierarchy_level_id] = $scope.$parent.users_organization_hierarchy_level_elements_map_entries[user.id][organization_hierarchy_level_id];
                    }
                }
            }
        });
    }

    $scope.init_selected_activity_log = function(log) {
        $scope.$parent.$apply(function () {
            $scope.$parent.selected_activity_log = log;
        });
    }

    $scope.init_new_user = function() {
        $scope.new_user = {
            first_name       : '',
            last_name        : '',
            username         : '',
            organization_id  : $scope.organizations[0].id,
            user_type_id     : $scope.user_types[0].id,
            email            : '',
            phone            : null,
            password         : '',
            confirm_password : '',
            customer_number  : null,
            is_customer      : 1,
            customer_type    : 'Residential Customer',
            address_line_1   : null,
            address_line_2   : null,
            municipality     : null,
            province_id      : null,
            postal_code      : null,
            login_enabled    : 1
        };
    }

    // Hack to prevent from log fields being sorted alphabetically
    $scope.keys = function(obj) {
        // Slicing off the last element because it is a $$hashKey
        return obj? Object.keys(obj).slice(0,-1) : [];
    }

    $scope.display_field = function(field) {
        field = field.replace(/_/g, " ");
        field = field.replace(/\w\S*/g, function(txt) {return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
        return field;
    }

    $scope.refresh_activity_logs = function() {
        $timeout(function() {
            $scope.$parent.$apply(function () {
                $scope.filtered_activity_logs = [];
                $scope.activity_logs = [];
                $scope.activity_logs_offset = 0;
                $scope.ready_for_more_activity_log_entries = true;
                $scope.show_spinner = "0";
                $scope.get_activity_logs();
            });
        });
    };

    $scope.refresh_organizations = function() {
        $scope.organizations                                                  = [];
        $scope.organization_hierarchy.form.levels                             = [];
        $scope.organization_hierarchy.form.level_elements                     = [];
        $scope.organization_hierarchy.form.user_type_level_map                = [];
        $scope.organization_hierarchy.form.selected_element_ids.new_user      = [];
        $scope.organization_hierarchy.form.selected_element_ids.existing_user = [];
        $scope.get_organizations();
    };

    $scope.refresh_users = function() {
        $scope.users = [];
        $scope.get_users();
    };

    $scope.file_upload_spinner = function(selector, flag, file) {
        var str = "";

        if(flag) {
            str='<span style="padding-right: 20px;">Uploading activity log file</span><i class="fa fa-spinner fa-spin"></i><br><br>';
        }

        angular.element(selector).html(str);
    };

    $scope.$watch('search', function(newValue, oldValue) {
        if($scope.search_query_in_progress) {
            return;
        }

        if(newValue != oldValue) {
            $scope.search_query_in_progress = true;
            $scope.get_users();
        }
    });

    $scope.get_filter_organization_hierarchy_level_elements = function(level) {
        var elements = [];

        // determine if the given element level's parent level has a selected element other than the 'All' option
        var parent_level_has_selection = function(element) {
            return $scope.organization_hierarchy.filter.selected_element_ids.hasOwnProperty(element.organization_hierarchy_level_parent_id) && $scope.organization_hierarchy.filter.selected_element_ids[element.organization_hierarchy_level_parent_id] !== 0;
        };

        // determine if the given element's parent level element was selected
        var parent_element_was_selected = function(element) {
            return angular.equals($scope.organization_hierarchy.filter.selected_element_ids[element.organization_hierarchy_level_parent_id], element.organization_hierarchy_level_element_parent_id);
        };

        // determine a preliminary list of elements within this hierarchy level (this list may contain duplicates if they belong to multiple parent levels)
        angular.forEach($scope.organization_hierarchy.filter.level_elements, function(element) {
            if(element.organization_hierarchy_level_id === level.organization_hierarchy_level_id) {
                if(level.organization_hierarchy_level_parent_id === null) {
                    elements.push(element);
                } else {
                    if(parent_level_has_selection(element)) {
                        if(parent_element_was_selected(element)) {
                            elements.push(element);
                        }
                    } else {
                        elements.push(element);
                    }
                }

                if(element.organization_hierarchy_level_element_id == 0) {
                    elements.push(element);
                }
            }
        });

        unique_elements = [];

        // filter out duplicate elements
        angular.forEach(elements, function (element) {
            var is_duplicate = false;

            for(var i = 0; i < unique_elements.length; i++) {
                if(angular.equals(unique_elements[i].organization_hierarchy_level_element_id, element.organization_hierarchy_level_element_id)) {
                    is_duplicate = true;
                    break;
                }
            }

            if(!is_duplicate) {
                unique_elements.push(element);
            }
        });

        // set the default selected element within this level to the 'All' option if the number of available elements to choose from is 1
        if(unique_elements.length == 1) {
            $scope.organization_hierarchy.filter.selected_element_ids[level.organization_hierarchy_level_id] = 0;
        }

        return unique_elements;
    }

    $scope.get_form_organization_hierarchy_level_elements = function(form_type, user_type_id, organization_id, level) {
        var delete_selected_organization_hierarchy_level_element_ids = true;
        var elements = [];
        var inserted_element_ids = [];

        if($scope.organization_hierarchy.form.user_type_level_map[user_type_id][level.organization_hierarchy_level_id].display == '1') {
            $scope.organization_hierarchy.form.level_elements[organization_id].forEach(function(element) {
                if(element.organization_hierarchy_level_id == level.organization_hierarchy_level_id) {
                    if(level.organization_hierarchy_level_parent_id == null) {
                        if(inserted_element_ids.indexOf(element.organization_hierarchy_level_element_id) == -1) {
                            delete_selected_organization_hierarchy_level_element_ids = false;
                            inserted_element_ids.push(element.organization_hierarchy_level_element_id);
                            elements.push(element);
                        }
                    } else {
                        if(angular.isArray($scope.organization_hierarchy.form.selected_element_ids[form_type][level.organization_hierarchy_level_parent_id])) {
                            if($scope.organization_hierarchy.form.selected_element_ids[form_type][level.organization_hierarchy_level_parent_id].indexOf(element.organization_hierarchy_level_element_parent_id) > -1) {
                                if(inserted_element_ids.indexOf(element.organization_hierarchy_level_element_id) == -1) {
                                    delete_selected_organization_hierarchy_level_element_ids = false;
                                    inserted_element_ids.push(element.organization_hierarchy_level_element_id);
                                    elements.push(element);
                                }
                            }
                        } else {
                            if($scope.organization_hierarchy.form.selected_element_ids[form_type][level.organization_hierarchy_level_parent_id] !== 'undefined') {
                                if($scope.organization_hierarchy.form.selected_element_ids[form_type][level.organization_hierarchy_level_parent_id] == element.organization_hierarchy_level_element_parent_id) {
                                    if(inserted_element_ids.indexOf(element.organization_hierarchy_level_element_id) == -1) {
                                        delete_selected_organization_hierarchy_level_element_ids = false;
                                        inserted_element_ids.push(element.organization_hierarchy_level_element_id);
                                        elements.push(element);
                                    }
                                }
                            }
                        }
                    }
                }
            });
        }

        if(delete_selected_organization_hierarchy_level_element_ids === true) {
            $scope.organization_hierarchy.form.selected_element_ids[form_type].splice(level.organization_hierarchy_level_id, 1);
        }

        return elements;
    };

    $scope.show_form_organization_hierarchy_level_dropdown = function(form_type, user_type_id, organization_id, level) {
        if($scope.organization_hierarchy.form.user_type_level_map[user_type_id][level.organization_hierarchy_level_id].display == '0') {
            return false;
        }

        var level_has_elements_belonging_to_selected_parent_level = function() {
            if(angular.isArray($scope.organization_hierarchy.form.level_elements[organization_id])) {
                for(i = 0, length = $scope.organization_hierarchy.form.level_elements[organization_id].length; i < length; i++) {
                    var element = $scope.organization_hierarchy.form.level_elements[organization_id][i];

                    if(element.organization_id == organization_id && element.organization_hierarchy_level_id == level.organization_hierarchy_level_id) {
                        if(level.organization_hierarchy_level_parent_id == null) {
                            return true;
                        } else {
                            if(angular.isArray($scope.organization_hierarchy.form.selected_element_ids[form_type][level.organization_hierarchy_level_parent_id])) {
                                if($scope.organization_hierarchy.form.selected_element_ids[form_type][level.organization_hierarchy_level_parent_id].indexOf(element.organization_hierarchy_level_element_parent_id) > -1) {
                                    return true;
                                }
                            } else {
                                if($scope.organization_hierarchy.form.selected_element_ids[form_type][level.organization_hierarchy_level_parent_id] == element.organization_hierarchy_level_element_parent_id) {
                                    return true;
                                }
                            }
                        }
                    }
                }
            }

            return false;
        };

        if(level.organization_hierarchy_level_parent_id == null) {
            return level_has_elements_belonging_to_selected_parent_level();
        } else {
            if(typeof $scope.organization_hierarchy.form.selected_element_ids[form_type][level.organization_hierarchy_level_parent_id] == 'undefined') {
                return false;
            } else {
                return level_has_elements_belonging_to_selected_parent_level();
            }
        }

        return true;
    };


    $scope.prep_selected_organization_hierarchy_level_element_ids_for_submit = function(form_type) {
        var organization_hierarchy_level_element_ids = [];

        $scope.organization_hierarchy.form.selected_element_ids[form_type].forEach(function(id) {
            // check whether this level allows multi sibling membership
            if(angular.isArray(id)) {
                id.forEach(function(organization_hierarchy_level_element_id) {
                    organization_hierarchy_level_element_ids.push(organization_hierarchy_level_element_id);
                });
            } else {
                organization_hierarchy_level_element_ids.push(id);
            }
        });

        return organization_hierarchy_level_element_ids;
    }
}

/* hack for dealing with stuff that Bootstrap 3.0 broke (directive not firing on button) */
function export_csv(report_type, data) {
    var scope = angular.element($("#dashboard_controller")).scope();
    scope.export_csv(report_type, data);
}

/* hack for dealing with stuff that Bootstrap 3.0 broke (directive not firing on button) */
function refresh_activity_logs() {
    var scope = angular.element($("#dashboard_controller")).scope();
    scope.refresh_activity_logs();
}

/* hack for dealing with stuff that Bootstrap 3.0 broke (directive not firing on button) */
function refresh_organizations() {
    var scope = angular.element($("#dashboard_controller")).scope();
    scope.refresh_organizations();
}

/* hack for dealing with stuff that Bootstrap 3.0 broke (directive not firing on button) */
function refresh_users() {
    var scope = angular.element($("#dashboard_controller")).scope();
    scope.refresh_users();
}

/* hack for dealing with stuff that Bootstrap 3.0 broke (directive not firing on button) */
function set_show_dialog(type) {
    var scope = angular.element($("#dashboard_controller")).scope();
    scope.get_organizations(function() {
        if(type === 'user') {
            scope.init_new_user();
        }

        scope.showDialog = true;
    });
}

/* hack for dealing with stuff that Bootstrap 3.0 broke (directive not firing on button) */
function set_show_edit_dialog() {
    var scope = angular.element($("#dashboard_controller")).scope();
    scope.showEditDialog = true;
}

/* hack for dealing with stuff that Bootstrap 3.0 broke (directive not firing on button) */
function set_show_info_dialog() {
    var scope = angular.element($("#dashboard_controller")).scope();
    scope.showInfoDialog = true;
}

function set_show_confirm_delete_dialog() {
    var scope = angular.element($("#dashboard_controller")).scope();
    scope.showConfirmDeleteDialog = true;
}



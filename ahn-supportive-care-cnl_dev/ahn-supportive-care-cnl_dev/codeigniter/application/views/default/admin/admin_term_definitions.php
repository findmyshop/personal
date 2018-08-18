<div class="panel panel-default" load-term-definitions>
    <div class="panel-heading">
        <div class="col-xs-6">
            <h1 class="panel-title">Select Term Definition To Edit</h1>
        </div>

        <div class="col-xs-6 input-group input-group-sm pull-right">
            <div class="input-group-btn">
                <button type="button" class="btn btn-default pull-right" ng-click="export_csv('term_definitions', term_definitions);"><i class="glyphicon glyphicon-export"></i> Export CSV</button>
                <button type="button" class="btn btn-default pull-right" data-toggle="modal" data-target="#add_term_definition_modal" onclick="set_show_dialog('term_definition_to_add');"><i class="glyphicon glyphicon-plus-sign"></i> Add Term Definition</button>
            </div>
        </div>
        <div style="clear:both;"></div>
    </div>

    <?php
    $args = array(
    'id'    => 'term_definitions_table',
    'type' => 'table',
    'sort_on' => 'term',
    'sort_order' => 'ASC',
    'ng_model' => 'term_definitions',
    'ng_repeat' => 'term_definition',
    'icon' => 'list-alt',
    'ng_action' => 'data-toggle="modal" load-edit-term-definition-modal data-target="#edit_term_definition_modal"',
    'columns' => array(
        array('title' => 'Term', 'ng_data' => 'term'),
        array('title' => 'Definition', 'ng_data' => 'definition'),
        array('title' => 'Active', 'ng_data' => 'active', 'data_type' => 'boolean')
    ));
    build_data_panel($args); ?>
</div>

<!-- add term definition modal -->
<div modal-show modal-visible="showDialog" class="modal fade" id="add_term_definition_modal" tabindex="-1" role="dialog" aria-labelledby="add_term_definition_modal_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" ng-model="term_definition_to_insert">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="add_term_definition_modal_label">Add Term Definition</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="term" class="col-sm-4 control-label">Term:</label>
                        <div class="col-sm-6 input-group">
                            <input type="text" autocomplete="off" ng-model="term_definition_to_insert.term" class="form-control" id="term" name="term" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="definition" class="col-sm-4 control-label">Definition:</label>
                        <div class="col-sm-6 input-group">
                            <textarea ng-model="term_definition_to_insert.definition" class="form-control" rows="5" id="definition"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="login_endabled" class="col-sm-4 control-label">Active:</label>
                        <div class="col-sm-6 input-group">
                            <label for="term_definition_active_yes" class="control-label">Yes&nbsp;</label><input type="radio" class="radio-inline2"  ng-model="term_definition_to_insert.active" id="term_definition_active_yes" name="term_definition_active" value="1" ng-checked="{{term_definition_to_insert.active==1}}">
                            <label for="term_definition_active_no" class="control-label">&nbsp;&nbsp;No&nbsp;</label><input type="radio" class="radio-inline2" ng-model="term_definition_to_insert.active" id="term_definition_active_no" name="term_definition_active" value="0" ng-checked="{{term_definition_to_insert.active==1}}">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" insert-term-definition>Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- edit term definition modal -->
<div modal-show modal-visible="showEditDialog" class="modal fade" id="edit_term_definition_modal" tabindex="-1" role="dialog" aria-labelledby="edit_term_definition_modal_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" ng-model="term_definition_to_edit">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="edit_term_definition_modal_label">Edit Term Definition</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="term" class="col-sm-4 control-label">Term:</label>
                        <div class="col-sm-6 input-group">
                            <input type="text" autocomplete="off" ng-model="term_definition_to_edit.term" class="form-control" id="term" name="term" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="definition" class="col-sm-4 control-label">Definition:</label>
                        <div class="col-sm-6 input-group">
                            <textarea ng-model="term_definition_to_edit.definition" class="form-control" rows="5" id="definition"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="login_endabled" class="col-sm-4 control-label">Active:</label>
                        <div class="col-sm-6 input-group">
                            <label for="term_definition_active_yes" class="control-label">Yes&nbsp;</label><input type="radio" class="radio-inline2"  ng-model="term_definition_to_edit.active" id="term_definition_active_yes" name="term_definition_active" value="1" ng-checked="{{term_definition_to_edit.active==1}}">
                            <label for="term_definition_active_no" class="control-label">&nbsp;&nbsp;No&nbsp;</label><input type="radio" class="radio-inline2" ng-model="term_definition_to_edit.active" id="term_definition_active_no" name="term_definition_active" value="0" ng-checked="{{term_definition_to_edit.active==1}}">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" edit-term-definition>Save changes</button>
            </div>
        </div>
    </div>
</div>

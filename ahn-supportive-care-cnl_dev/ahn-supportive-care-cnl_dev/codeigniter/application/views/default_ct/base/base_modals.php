<!-- Surveys Modal -->
<div class="modal fade" id="survey-modal" tabindex="-1" role="dialog" aria-labelledby="survey_modal_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="dialog_modal_label">Survey</h4>
            </div>
            <div class="modal-body">
                <p>
                    Please take a moment to answer a few survey questions.
                </p>
                <ol>
                    <li ng-repeat="question in current_survey.questions">
                        <p>
                            {{question.text}}
                        </p>

                        <div ng-switch="question.input_type">
                            <div ng-switch-when="text">
                                <textarea ng-model="user_survey_question_responses[question.id]" name="user_survey_question_responses_{{question.id}}" rows="4" cols="256" maxlength="1024" style="width:100%"></textarea>
                            </div>

                            <div ng-switch-when="radio">
                                <div class="radio" ng-repeat="option in question.options">
                                  <label><input ng-model="user_survey_question_responses[question.id]" ng-value="{{option.id}}" type="radio" name="user_survey_question_responses_{{question.id}}">{{option.text}}</label>
                                </div>
                            </div>
                        </div>
                    </li>
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" tabindex="4" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" ng-click="submit_user_survey_question_responses();">Submit</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- / All Resources Modal -->

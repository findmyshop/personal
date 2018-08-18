<div class="modal fade" id="user_questions_modal" tabindex="-1" role="dialog" aria-labelledby="call-support-modal-label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="call-support-modal-label">Update User Profile</h4>
			</div>
			<div class="modal-body col-md-12">
                    <form class="form-horizontal" role="form" >
                        <div class="form-group list-group" 
                            ng-repeat="(key, val) in formQuestions"
                            ng-if="formQuestionsWhiteList.includes(key)"
                        >
                            <label class="col-sm-3">{{val.text}}</label>
                            <div class="col-sm-8 list-group-item">
                                <div  ng-repeat="question in val.questions" class="col-md-4 form-check p-3">
                                    <label ng-click="createWhiteList(true)" class="form-check-label break-word">
                                    <input type="radio" 
                                            class="form-check-input" 
                                            ng-model="formResponses[key].answer" 
                                            value="{{question}}"></input>
                                    {{question}}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button ng-disabled="!enableSave" ng-click="updateUserProfile()" class="btn btn-success pull-right"> Save</button>
                        <button ng-click="load_response(cancelModalRoute)"data-dismiss="modal" class="btn btn-primary pull-right"> Cancel</button>
                    </form>
        </div>
			<div class="modal-footer">
				<!-- <button data-dismiss="modal" class="btn btn-default pull-left"><i class="glyphicon glyphicon-remove"></i> Close</button> -->
			</div>
		</div>
	</div>
</div>


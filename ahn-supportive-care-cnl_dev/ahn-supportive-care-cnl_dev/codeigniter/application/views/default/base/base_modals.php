<!-- Bug Report Modal -->
<div class="modal fade" id="bug-modal" tabindex="-1" role="dialog" aria-labelledby="bug_report_modal_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" ng-model="bug_information">
			<form class="form-horizontal" role="form">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="dialog_modal_label">Contact Technical Support</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="email" class="col-sm-4 control-label">Email: </label>
						<div class="col-sm-6">
							<input type="input" type="email" ng-model="bug_information.email" class="form-control" id="email" name="email" placeholder="email" tabindex="1" />
						</div>
					</div>
					<div class="form-group">
						<label for="phone_number" class="col-sm-4 control-label">Description: </label>
						<div class="col-sm-6">
							<textarea style="resize: none;" rows="15" ng-model="bug_information.report" class="form-control" id="report" name="report" placeholder="Description of Problem" tabindex="2"></textarea>
							<input ng-model="bug_information.video_ping" type="hidden" name="bugPingData" id="bugPingData" />
							<input ng-model="bug_information.last_message" type="hidden" name="bugLastMessage" id="bugLastMessage" />
						</div>
					</div>
					<div class="form-group">
						<label for="privacy" class="col-sm-4 control-label">Privacy: </label>
						<div class="col-sm-6">
							<div class="input-group input-group-sm">
								<span class="input-group-addon alert alert-info">
								<input ng-model="bug_information.privacy" name="privacy" id="privacy" type="checkbox" value="yes" /></span>
								<label for="privacy" class="form-control alert alert-info">Check here if it is okay to contact you.</label>
							</div>
						</div>
					</div><!--/.form-group-->
				</div>
			</form>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" tabindex="4" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" tabindex="3" ng-click="send_bug_report()">Submit</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- / Bug Report Modal -->

<!-- All Resources	Modal -->
<div class="modal fade" id="resources-modal" tabindex="-1" role="dialog" aria-labelledby="all_resources_modal_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="dialog_modal_label">{{resources.title}}</h4>
			</div>
			<div class="modal-body">
				<div ng-repeat="category in resources" ng-if="category.rail == current_left_rail || !category.rail || category.rail == ''" class="{{category.type}}">
					<h5>{{ category.heading }}</h5>
					<ul>
						<li ng-repeat="resource in category.resources"><a ng-if="resource.link" class="resource-link" target="_blank" href="{{ resource.link }}">{{ resource.name }}</a><span ng-if="!resource.link">{{ resource.name }}</span><em> {{ resource.details }}</em></li>
					</ul>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" tabindex="4" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- / All Resources Modal -->



<div class="modal fade" id="about-modal" tabindex="-1" role="dialog" aria-labelledby="about_modal_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="about_modal_label">MedRespond Indexer Area</h4>
			</div>
			<div class="modal-body">
					<label class="control-label" for="index-csv">Paste test-set here:</label>
					<textarea name="mr-index-csv" id="mr-index-csv" class="form-control" rows="3"></textarea>
					<br/>
					<div class="col-xs-6">
						<div class="input-group">
							<div class="input-group-btn">
								<button class="btn btn-default" onclick="MR.utils.scanIndexes();" target="_blank"><i class="glyphicon glyphicon-search"></i> Scan Indexes</button>
							</div>
							<input id="mr-case-name" name="mr-case-name" type="text" class="form-control" placeholder="Casename" />
						</div>
					</div>
					<div class="col-xs-6">
						<a class="btn btn-default pull-left" href="/config/linkchecker.php?project=<?php echo MR_PROJECT; ?>" target="_blank"><i class="glyphicon glyphicon-sunglasses"></i> Launch Link Checker</a>
					</div>
					<div style="clear:both;"></div>
				</div>
			<?php mr_version_info(); ?>
			<div class="modal-footer">

				<button type="button" class="btn btn-default" tabindex="4" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- / About Modal -->
<div class="modal fade" id="about-output-modal" tabindex="-1" role="dialog" aria-labelledby="output_modal_label" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="output_modal_label">Testing output</h4>
			</div>
			<table class="table table-striped" id="mr-output-screen">
				<tr>
					<th>Status</th>
					<th>Expected</th>
					<th>Input Question</th>
					<th>Actual</th>
				</tr>
			</table>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" tabindex="4" onclick="MR.utils.clearIndexes();">Clear Data</button>
				<button type="button" class="btn btn-default" tabindex="4" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- / Output Modal -->
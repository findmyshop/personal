<div class="panel panel-default" load-actions>
	<div class="panel-heading">
		<div class="col-xs-6">
			<h1 class="panel-title">Admin Actions</h1>
		</div><!--/.col-->
		<div class="col-xs-6 input-group input-group-sm">
			<div class="input-group-btn">
				<button type="button" class="btn btn-default pull-right" ng-click="export_csv('actions', actions);"><i class="glyphicon glyphicon-export"></i> Export CSV</button>
			</div>
		</div>
		<div style="clear:both;"></div>
	</div><!--/.panel-heading-->
	<!-- Actions table -->
	<?php
	$args = array(
	'id'	=> 'actions_table',
	'type' => 'table',
	'sort_on' => 'timestamp',
	'ng_model' => 'actions',
	'ng_repeat'	=> 'action',
	'icon' => 'list-alt',
		'columns' => array(
			array('title' => 'Property', 'ng_data' => 'property_name'),
			array('title' => 'Username', 'ng_data' => 'username'),
			array('title' => 'Session', 'ng_data' => 'session_id'),
			array('title' => 'IP Address', 'ng_data' => 'ip_address'),
			array('title' => 'Operating System', 'ng_data' => 'operating_system'),
			array('title' => 'Browser', 'ng_data' => 'browser'),
			array('title' => 'Action Type', 'ng_data' => 'action_type'),
			array('title' => 'Timestamp', 'ng_data' => 'timestamp')
		));
	build_data_panel($args); ?>
</div><!--/.panel-->

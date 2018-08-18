<div id="base_controller">
	<div id="mr-header">
		<?php $this->load->view("/$header"); ?>
	</div>
	<div class="main-container">
		<div start-app ng-cloak id="mr-content">
			<!-- Load content view -->
			<?php $this->load->view("/$content");?>
			<div style="clear:both;"></div>
		</div>
	</div>
	<div class="container">
		<?php get_footer(); ?>
	</div>
</div>

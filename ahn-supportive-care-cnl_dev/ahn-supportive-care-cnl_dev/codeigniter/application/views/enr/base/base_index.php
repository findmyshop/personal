<div id="base_controller" class="container control-container">
	<div id="mr-header">
		<?php $this->load->view("/$header"); ?>
	</div>
	<div class="main-container">
		<div start-app ng-cloak id="mr-content">
			<!-- Load content view -->
			<?php $this->load->view("/$content");?>
		</div>
	</div>

	<?php get_footer(array("logo" => "powered_by_medrespond_gray.png")); ?>
</div>

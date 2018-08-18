<div id="base_controller" class="container control-container">
	<div class="main-container">
		<div id="mr-header">
			<?php $this->load->view("/$header"); ?>
		</div> <!-- / mr-header -->
		<div class="page-height" id="mr-content">
			<!-- Load content view -->
			<?php $this->load->view("/$content");?>
		</div> <!-- / mr-content -->
	</div> <!--/.main-container -->
	<div style="clear:both; margin-bottom:40px;"></div>
	<?php get_footer(array("logo" => "powered_by_medrespond_gray.png")); ?>
</div><!--/#main_controller-->
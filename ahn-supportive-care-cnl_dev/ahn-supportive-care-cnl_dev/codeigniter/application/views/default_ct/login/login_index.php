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
<?php get_footer(); ?>
</div>
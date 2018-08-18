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

	<?php get_footer(array("logo" => "powered_by_medrespond_gray.png", "after" => '<div id="epr-footer-stuff"><a href="http://www.excelahealth.org " target="_blank"><img class="bot-logo" src="'.base_url().'assets/projects/epr/images/logo-white.png" height="30"/></a><a href="https://www.facebook.com/ExcelaHealth/" target="_blank" class="sm-icon"><img src="'.base_url().'assets/projects/epr/images/icon-fb.png"/></a><a href="http://www.twitter.com/excela_health" target="_blank" class="sm-icon"><img src="'.base_url().'assets/projects/epr/images/icon-tw.png"/></a><a href="https://www.linkedin.com/company/928849" target="_blank" class="sm-icon"><img src="'.base_url().'assets/projects/epr/images/icon-li.png"/></a><a href="https://www.youtube.com/user/ExcelaHealth1" target="_blank" class="sm-icon"><img src="'.base_url().'assets/projects/epr/images/icon-yt.png"/></a><a href="https://www.instagram.com/excelahealth" target="_blank" class="sm-icon"><img src="'.base_url().'assets/projects/epr/images/icon-ig.png"/></a><div class="mid-fart">To request an appointment please call: <strong>1-855-ExcelaDoc</strong></div></div>', "before" => '<div class="mr-warning-bottom pull-right"><a href="http://www.excelahealth.org/Portals/9/PDFs/Excelaprivacypractices.pdf" target="_blank">Privacy and Legal Conditions</a></div>')); ?>
</div>

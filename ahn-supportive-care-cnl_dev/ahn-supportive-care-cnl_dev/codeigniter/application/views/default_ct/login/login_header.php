<nav class="navbar navbar-default learn-nav" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mr-navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-logo" href="#">
				<img alt="Logo" src="<?php echo $page['logo_url'];?>">
			</a>
			<span class="navbar-brand"><?=$page['title']?></span>
		</div>
		<div class="collapse navbar-collapse" id="mr-navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li>
					<a class="top-nav-button" href="javascript:MR.modal.show('#help-modal');">Help</a>
				</li>
				<?php if (is_anonymous_guest_user()) : ?>
				<li>
					<a class="top-nav-button" href="javascript:MR.modal.show('#admin-login-modal');"><i class="glyphicon glyphicon-lock"></i> Admin</a>
				</li>
				<?php endif; ?>
			</ul>
	</div>
	</div>
</nav>


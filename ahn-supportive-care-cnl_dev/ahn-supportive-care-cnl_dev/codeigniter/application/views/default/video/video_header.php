<nav class="navbar navbar-default learn-nav" role="navigation">
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
				<?php if(!is_simple_user()){ ?>
					<li><a class="top-nav-button" href="javascript:MR.utils.link('admin');">Admin</a></li>
				<?php } ?>
				<?php if (is_anonymous_guest_user()) : ?>
					<li><a class="top-nav-button" href="javascript:MR.modal.show('#admin-login-modal');"><i class="glyphicon glyphicon-lock"></i> Admin</a></li>
				<?php endif; ?>
				<li>
					<a class="top-nav-button" href="javascript:MR.modal.show('#help-modal');">Help</a>
				</li>
				<li>
					<a class="top-nav-button" href="javascript:MR.login.do_logout('user');">Log Out</a>
				</li>
			</ul>
	</div>
</nav>


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
				<img alt="Logo" src="<?php echo $page['logo_url'];?>" height="50">
			</a>
			<a class="navbar-brand fake-active" href="<?=get_link('home')?>"><?php echo $page['title']?><?php echo !empty($page['module']) ? ' - ' . $page['module'] : ""?></a>
		</div>
	</div>
</nav>
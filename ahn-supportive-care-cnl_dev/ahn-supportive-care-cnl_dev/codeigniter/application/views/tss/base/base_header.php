<?php if(is_logged_in()): ?>

<nav class="navbar navbar-default learn-nav" role="navigation">
	<div class="container">
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
			<!-- <a class="navbar-brand fake-active" href="<?=get_link('home')?>"><?=$page['title']?></a> -->
		</div>
		<div class="collapse navbar-collapse" id="mr-navbar-collapse">
			<ul class="nav navbar-nav navbar-right">

					<li>
						<a href="javascript:void(0)" ng-click="show_all_resources({title: 'Library'})">
							<i class="material-icons">library_books</i> Library
						</a>
					</li>

					<li class="dropdown">
						<a class="top-nav-button"	 id="settings_dropdown" href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
							<i class="material-icons">help</i>
							Help
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="javascript:MR.modal.show('#bug-modal');"><i class="glyphicon glyphicon-envelope"></i> Email Customer Support</a></li>
						</ul>
					</li>
					<li>
						<a href="/admin"><i class="fa fa-tachometer"></i> Dashboard</a>
					</li>
					<li>
						<a href="javascript:MR.login.do_logout('user');"><i class="glyphicon glyphicon-off"></i> Log Out</a>
					</li>
				</ul>
			</div>
	</div>
</nav>
<?php else: ?>
<nav class="navbar navbar-default learn-nav" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
			</button>
			<a class="navbar-logo" href="#">
				<img alt="Logo" src="<?=$logo_url?>" height="40">
			</a>
			<p class="navbar-text"><?=$page['title']?></p>
		</div>
			<ul class="nav navbar-nav navbar-right">
				 <li><a href="/login"><i class="glyphicon glyphicon-question-off"></i> Sign In</a></li>
			</ul>
	</div>
</nav>
<?php endif; ?>

<nav class="navbar navbar-default learn-nav" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mr-navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<!--
			<a class="navbar-logo" href="#">
				<img alt="Logo" src="<?php echo $page['logo_url'];?>" height="40">
			</a>
			-->
			<a class="navbar-brand fake-active" href="<?=get_link('home')?>"><?=$page['title']?></a>
		</div>
		<div id="mr-navbar-collapse" class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a class="top-nav-button"	id="resources_dropdown" href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon glyphicon glyphicon-paperclip"></i> Resources <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="javascript:MR.modal.show('#privacy-modal');"><i class="glyphicon glyphicon-pushpin"></i> Privacy Policy</a></li>
						</ul>
					</li>
					<!--
					<li style="padding-left:20px;" class="top-nav-big-icon"><a class="top-nav-button"	target="_blank" href="http://enersource.com/"><i class="fa fa-home fa-2x"></i></a></li>
					-->
					<li style="padding-left:20px;" class="top-nav-big-icon"><a class="top-nav-button"	target="_blank" href="javascript:void(0)"><i class="fa fa-home fa-2x"></i></a></li>
			</ul>
		</div>
	</div>
</nav>


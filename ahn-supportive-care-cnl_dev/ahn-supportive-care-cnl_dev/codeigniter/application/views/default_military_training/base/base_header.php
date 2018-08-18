<?php if(is_logged_in()): ?>

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
			<!-- <a class="navbar-brand fake-active" href="<?=get_link('home')?>"><?=$page['title']?></a> -->
		</div>
		<div class="collapse navbar-collapse" id="mr-navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="" ng-click="get_profile()">
							<i class="icon glyphicon glyphicon-tasks"></i>
								My Profile
							<span class="caret"></span>
						</a>
					</li>
					<li>
						<a class="top-nav-button" href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
							<i class="glyphicon glyphicon-file"></i>
								Patient Information
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
						<li><a target="_blank" href="https://s3.amazonaws.com/dod-media/Documents/Bonesso+Audit-C.pdf?1"><i class="glyphicon glyphicon-tasks"></i>Bonesso AUDIT-C</a></li>
						<li><a target="_blank" href="https://s3.amazonaws.com/dod-media/Documents/Caulfield+Audit-C.pdf?1"><i class="glyphicon glyphicon-tasks"></i>Caulfield AUDIT-C</a></li>
						<li ng-if="response.left_rail.id == '3hour'"><a target="_blank" href="https://s3.amazonaws.com/dod-media/Documents/Fortune+Audit-C.pdf?1"><i class="glyphicon glyphicon-tasks"></i>Fortune AUDIT-C</a></li>
						<li><a target="_blank" href="https://s3.amazonaws.com/dod-media/Documents/Hernandez+Audit+C.pdf?1"><i class="glyphicon glyphicon-tasks"></i>Hernandez AUDIT-C</a></li>
						<li ng-if="response.left_rail.id == '3hour'"><a target="_blank" href="https://s3.amazonaws.com/dod-media/Documents/Miller+Audit-C.pdf?1"><i class="glyphicon glyphicon-tasks"></i>Miller AUDIT-C</a></li>
						<li ng-if="response.left_rail.id == '3hour'"><a target="_blank" href="https://s3.amazonaws.com/dod-media/Documents/Miller+Audit.pdf?1"><i class="glyphicon glyphicon-tasks"></i>Miller AUDIT</a></li>
						</ul>
					</li>
					<li>
						<a href="" ng-click="show_all_resources({title: 'Library'})">
							<i class="icon glyphicon glyphicon-book"></i>
								Library
							<span class="caret"></span>
						</a>
					</li>
					<li class="dropdown">
						<a class="top-nav-button"	 id="resources_dropdown" href="javascript:void(0)" ng-click="show_all_resources({noModal: 'true'})" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon glyphicon glyphicon-paperclip"></i>
							Resource
						<span class="caret"></span>
						</a>
						<ul id="mr-resources-dropdown" class="dropdown-menu" role="menu">
							<li ng-repeat="media in response.media"><a data-toggle="tooltip" data-placement="left" title="{{media.name}}" target="_blank" href="{{ media.link }}"><i class="glyphicon glyphicon-file"></i>{{ media.name }}</a></li>
							<li ng-repeat="resource in resources" ng-if="response.left_rail.id == resource.rail"><a data-toggle="tooltip" data-placement="left" title="{{ resource.name }} {{ resource.details }}" class="truncate" target="_blank" href="{{ resource.link }}"><i class="glyphicon glyphicon-file"></i> {{ resource.name }}</a>
							</li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="top-nav-button"	 id="settings_dropdown" href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon glyphicon glyphicon-question-sign"></i>
							Help
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="javascript:MR.modal.show('#bug-modal');"><i class="glyphicon glyphicon-envelope"></i> Email Customer Support</a></li>
							<li><a href="javascript:MR.modal.show('#call-support-modal');"><i class="glyphicon glyphicon-phone-alt"></i> Speak to Customer Support</a></li>
						</ul>
					</li>
					<li class="dropdown">
						<a class="top-nav-button"	 id="settings_dropdown" href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon glyphicon glyphicon-user"></i>
							<?php echo get_user_info('username'); ?>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="/admin"><i class="fa fa-tachometer"></i> Dashboard</a></li>
							<li><a href="javascript:MR.login.do_logout('user');"><i class="glyphicon glyphicon-off"></i> Log Out</a></li>
						</ul>
					</li>
				</ul>
			</div>
	</div>
</nav>
<?php else: ?>
<nav class="navbar navbar-default learn-nav" role="navigation">
	<div class="container-fluid">
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

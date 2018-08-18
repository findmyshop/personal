<?php if(is_logged_in()): ?>
<div class="navbar navbar-default learn-nav" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mr-navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-logo" href="#">
				<img alt="Logo" src="<?php echo $page['logo_url'];?>" />
			</a>
			<a class="navbar-brand fake-active" href="<?=get_link('home')?>"><?=$page['title']?> | more than energy&trade;</a>
		</div>
		<div class="collapse navbar-collapse" id="mr-navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
					<li>
						<div class="enr-progress-bar">
							<div class="progress-title">Progress</div>
<!-- 							<div ng-class="{ 'complete': response.user_progress.reliability_section }" data-toggle="tooltip" data-placement="bottom" title="Reliability Section" class="progress-number">1</div> -->
							<div ng-class="{ 'complete': response.user_progress.service_questions }" data-toggle="tooltip" data-placement="bottom" title="Service Questions" class="progress-number">1</div>
							<div ng-class="{ 'complete': response.user_progress.renewal_questions }" data-toggle="tooltip" data-placement="bottom" title="Renewal Questions" class="progress-number">2</div>
							<div ng-class="{ 'complete': response.user_progress.plant_questions }" data-toggle="tooltip" data-placement="bottom" title="Plant Questions" class="progress-number">3</div>
							<div ng-class="{ 'complete': response.user_progress.value_benefits }" data-toggle="tooltip" data-placement="bottom" title="Value/Benefits" class="progress-number">4</div>
						</div>
					</li>
					<li class="dropdown">
						<a class="top-nav-button"	id="resources_dropdown" href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon glyphicon glyphicon-paperclip"></i> Resources <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a data-toggle="tooltip" data-placement="left" title="Contact Us" target="_blank" href="http://www.enersource.com/about-enersource/Pages/contact-us.aspx"><i class="glyphicon glyphicon-file"></i> Contact Us</a></li>
							<li ng-repeat="media in response.media"><a data-toggle="tooltip" data-placement="left" title="{{media.name}}" target="_blank" class="truncate" href="{{ media.link }}"><i class="glyphicon glyphicon-file"></i> {{ media.name }}</a></li>
							<li class="divider" ng-show="response.media"></li>
							<li><a href="javascript:MR.modal.show('#privacy-modal');"><i class="glyphicon glyphicon-pushpin"></i> Privacy Policy</a></li>
							<li><a href="javascript:MR.modal.show('#contest-rules-modal');"><i class="glyphicon glyphicon-pushpin"></i> Contest Rules</a></li>
							<li><a href="javascript:MR.modal.show('#bug-modal');"><i class="glyphicon glyphicon-fire"></i> Contact Technical Support</a></li>
							<!-- <li><a href="javascript:MR.modal.show('#help-modal');"><i class="glyphicon glyphicon-question-sign"></i> Help</a></li> -->
						</ul>
					</li>
					<?php if(!is_anonymous_guest_user()) : ?>
					<li class="dropdown">
						<a class="top-nav-button"	id="settings_dropdown" href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon glyphicon glyphicon-user"></i>
							<?php echo get_user_info('username'); ?>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<?php if(!is_simple_user()){ ?>
								<li><a href="javascript:MR.utils.link('admin');"><i class="fa fa-tachometer"></i> Dashboard</a></li>
							<?php } ?>
							<li><a href="javascript:MR.login.do_logout('user');"><i class="glyphicon glyphicon-off"></i> Log Out</a></li>
						</ul>
					</li>
					<?php else :?>
					<li>
						<a class="top-nav-button"	href="javascript:MR.modal.show('#admin-login-modal');"><i class="icon glyphicon glyphicon-lock"></i> Admin</a>
					</li>
					<?php endif; ?>
					<li style="padding-left:20px;" class="top-nav-big-icon"><a class="top-nav-button"	target="_blank" href="http://enersource.com/"><i class="fa fa-home fa-2x"></i></a></li>
				</ul>
			</div>
	</div>
</div>
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
				 <li><a href="javascript:MR.utils.link('login');"><i class="glyphicon glyphicon-question-off"></i> Sign In</a></li>
			</ul>
	</div>
</nav>
<?php endif; ?>

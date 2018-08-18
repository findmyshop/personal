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
				<img alt="Logo" src="<?php echo $page['logo_url'];?>" height="40">
			</a>
			<a class="navbar-brand fake-active" href="<?=get_link('home')?>"><?=$page['title']?></a>
		</div>
		<div class="collapse navbar-collapse" id="mr-navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a class="top-nav-button"	 id="resources_dropdown" href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
						<i class="icon glyphicon glyphicon-paperclip"></i>
						Resources
						<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li ng-repeat="media in response.media"><a target="_blank" href="{{ media.link }}">{{ media.name }}</a></li>
							<li class="divider" ng-show="response.media"></li>
							<li><a href="" ng-click="show_all_resources()"><i class="glyphicon glyphicon-pushpin"></i> View All Resources</a></li>
							<li><a href="" ng-click="show_my_answers()"><i class="glyphicon glyphicon-list-alt"></i> Options Review Summary</a></li>
							<li><a href="https://s3.amazonaws.com/ahn_suppcare/ResourceDocuments/Decision+Support+Tool.docx" target="_blank"><i class="glyphicon glyphicon-list-alt"></i> Decision Support Tool</a></li>
							<li><a href="javascript:MR.modal.show('#consult_modal');"><i class="glyphicon glyphicon-envelope"></i> Contact Supportive Care</a></li>
							<li><a href="javascript:MR.modal.show('#bug-modal');"><i class="glyphicon glyphicon-fire"></i> Contact Technical Support</a></li>
							<li><a href="#/LRQ/scc180"><i class="glyphicon glyphicon-comment"></i> Give Us Your Feedback</a></li>
							<li><a href="http://www.nlm.nih.gov/medlineplus/" target="_blank"><i class="glyphicon glyphicon-search"></i> Search Medline Plus</a></li>
							<li><a href="" ng-click="show_privacy_policy()"><i class="glyphicon glyphicon-eye-open"></i> Privacy Policy</a></li>
							<li><a href="javascript:MR.modal.show('#help-modal');"><i class="glyphicon glyphicon-question-sign"></i> Help</a></li>
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
								<li><a href="/admin"><i class="fa fa-tachometer"></i> Dashboard</a></li>
							<?php } ?>
							<li><a href="javascript:MR.login.do_logout('user');"><i class="glyphicon glyphicon-off"></i> Log Out</a></li>
						</ul>
					</li>
					<?php else :?>
					<li>
						<a class="top-nav-button"	href="javascript:MR.modal.show('#admin-login-modal');"><i class="icon glyphicon glyphicon-lock"></i> Admin</a>
					</li>
					<?php endif; ?>
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

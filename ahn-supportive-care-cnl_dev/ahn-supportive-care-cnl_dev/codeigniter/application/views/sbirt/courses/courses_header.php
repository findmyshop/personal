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
					<a href="" class="dropdown-toggle top-nav-button">
						<i class="icon glyphicon glyphicon-list-alt"></i>
						Courses
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="/courses"><i class="glyphicon glyphicon-list-alt"></i> SBIRT Course Offerings</a></li>
						<li><a href="/courses/alcohol_sbirt"><i class="glyphicon glyphicon-info-sign"></i> AlcoholSBIRT&#8482 Course Descriptions</a></li>
						<li><a href="/courses/sbirt_coach"><i class="glyphicon glyphicon-info-sign"></i> SBIRTCoach&#8482 Course Description</a></li>
					</ul>
				</li>
				<li>
					<a href="/register">
						<i class="icon glyphicon glyphicon-user"></i>
							Register
						<span class="caret"></span>
					</a>
				</li>
				<li>
					<a href="/login">
						<i class="icon glyphicon glyphicon-log-in"></i>
							Login
						<span class="caret"></span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</nav>


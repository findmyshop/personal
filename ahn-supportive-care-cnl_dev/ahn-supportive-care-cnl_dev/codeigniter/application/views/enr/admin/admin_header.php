	<nav class="navbar navbar-default learn-nav navbar-inverse bs-docs-nav" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mr-navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand fake-active" href="<?=get_link('home')?>"><i class="fa fa-tachometer"></i> <?php echo config_item('conversational_branding_text') . ' ' . $page['title'] ?></a>
			</div>
			<div class="collapse navbar-collapse" id="mr-navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a class="top-nav-button"	 id="resources_dropdown" href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
							<i class="icon glyphicon glyphicon-paperclip"></i> Resources <span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="javascript:MR.utils.link('admin');"><i class="fa fa-bar-chart"></i> Admin</a></li>
								<li><a href="javascript:MR.utils.link('admin/users');"><i class="fa fa-users"></i> Users</a></li>
								<?php if(is_admin()): ?>
									<li><a href="javascript:MR.utils.link('admin/actions');"><i class="glyphicon glyphicon-list-alt"></i> Actions</a></li>
									<li><a href="javascript:MR.utils.link('admin/activity_logs');"><i class="glyphicon glyphicon-list-alt"></i> Activity Logs</a></li>
								<?php endif; ?>
							</ul>
						</li>
						<li class="dropdown">
							<a class="top-nav-button"	 id="settings_dropdown" href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
								<i class="icon glyphicon glyphicon-user"></i>
								<?php echo get_user_info('username'); ?>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="javascript:MR.utils.link('admin/profile');"><i class="glyphicon glyphicon-user"></i> Profile</a></li>
								<li><a href="javascript:MR.login.do_logout('user');"><i class="glyphicon glyphicon-off"></i> Log Out</a></li>
							</ul>
						</li>
					</ul>
				</div>
		</div>
	</nav>
<!-- Display Breadcrumbs -->
	<ol class="breadcrumb">
	<?php foreach ($page['bread_crumbs'] as $bread_crumb_key => $bread_crumb_value): ?>
		<?
			if (!empty($data['organization_name']))
			{
				$bread_crumb_key = str_replace('^organization_name^', $data['organization_name'], $bread_crumb_key);
				$bread_crumb_value = str_replace('^organization_name^', $data['organization_name'], $bread_crumb_value);
			}
			if (!empty($data['organization_id']))
			{
				$bread_crumb_key = str_replace('^organization_id^', $data['organization_id'], $bread_crumb_key);
				$bread_crumb_value = str_replace('^organization_id^', $data['organization_id'], $bread_crumb_value);
			}
			if (!empty($data['class_name']))
			{
				$bread_crumb_key = str_replace('^class_name^', $data['class_name'], $bread_crumb_key);
				$bread_crumb_value = str_replace('^class_name^', $data['class_name'], $bread_crumb_value);
			}
			if (!empty($data['class_id']))
			{
				$bread_crumb_key = str_replace('^class_id^', $data['class_id'], $bread_crumb_key);
				$bread_crumb_value = str_replace('^class_id^', $data['class_id'], $bread_crumb_value);
			}
			if (!empty($data['instructor_name']))
			{
				$bread_crumb_key = str_replace('^instructor_name^', $data['instructor_name'], $bread_crumb_key);
				$bread_crumb_value = str_replace('^instructor_name^', $data['instructor_name'], $bread_crumb_value);
			}
			if (!empty($data['student_name']))
			{
				$bread_crumb_key = str_replace('^student_name^', $data['student_name'], $bread_crumb_key);
				$bread_crumb_value = str_replace('^student_name^', $data['student_name'], $bread_crumb_value);
			}
		?>
		<?php if(empty($bread_crumb_value)): ?>
			<li class="active"><?=$bread_crumb_key?></li>
		<?php else: ?>
			<li><a href="<?=$bread_crumb_value?>"><?=$bread_crumb_key?></a></li>
		<?php endif; ?>
	<?php endforeach; ?>
	</ol>
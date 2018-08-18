<!DOCTYPE html>
<html lang="en">
<head>
<title>User Registration</title>
</head>
<body>
<span style="color: green;">Congratulations!</span>
<br>
<br>
You have successfully registered.
<br>
<br>
You have been registered to take the following course: <strong><?=$course_name?></strong>.
<br>
<br>
You can access your account by visiting <a href="<?=get_link('authenticate_user')?>"><?=get_link('authenticate_user')?></a>.
<br>
<br>
When the program begins, you will be asked to provide a username and a password.
<br>
<br>
Your username is <strong><?=$username?></strong>
<br>
<br>
<strong>Note: </strong>Use the password that you entered during registration. If you do not recall your password, you can reset it by clicking the <a href="<?=get_link('authenticate_user_forgot_password');?>">forgot password</a> link.
<br>
<br>
Thank You,
<br>
<br>
The MedRespond Team
<br>
<br>
<div style="width: 100%; text-align: center;">
<a href="http://www.medrespond.com/"><img src="<?=get_link('home')?>assets/medrespond/images/powered_by_medrespond.png" height="50"></a>
</div>
</body>
</html>
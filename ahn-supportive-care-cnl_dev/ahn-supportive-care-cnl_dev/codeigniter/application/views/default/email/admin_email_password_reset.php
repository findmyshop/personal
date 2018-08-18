<!DOCTYPE html>
<html lang="en">
<head>
	<title>Password Reset</title>
</head>
<body>
<?=$user['first_name']?>,
<br>
<br>
You have requested a password reset using the MedRespond 'forgat password' feature.
<br>
<br>
You may reset your password by clicking on the following link:
<br>
<br>
<a href="<?=get_link('authenticate_admin_password_reset_link').$hash?>"><?=get_link('authenticate_admin_password_reset_link').$hash?></a>
<br>
<br>
Regards,
<br>
<br>
The Medrespond Team
</body>
</html>

<html>
<body>
	<h1>NW PA GIS Conference</h1>
	<h3>Forgotten Password</h3>
	<p><?php echo sprintf(lang('email_forgot_password_heading'), $identity);?></p>
	<p>Thank you for registering an account with Clarion University's NW PA GIS Conference. Please follow the activation link to log in, and register to attend the next conference.</p>
	<p><?php echo sprintf(lang('email_forgot_password_subheading'), anchor('auth/reset_password/'. $forgotten_password_code, lang('email_forgot_password_link')));?></p>
</body>
</html>
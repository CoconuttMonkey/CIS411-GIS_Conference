<html>
<body>
	<h1>NW PA GIS Conference</h1>
	<h3>Account Activation</h3>
	<p><?php echo sprintf(lang('email_activate_heading'), $identity);?></p>
	<p>Thank you for registering an account with Clarion University's NW PA GIS Conference. Please follow the activation link to log in, and register to attend the next conference.</p>
	<p><?php echo sprintf(lang('email_activate_subheading'), anchor('auth/activate/'. $id .'/'. $activation, lang('email_activate_link')));?></p>
</body>
</html>
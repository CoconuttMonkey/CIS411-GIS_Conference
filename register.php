<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header("Location: account.php"); die(); }

//Forms posted
if(!empty($_POST))
{
	$errors = array();
	$email = trim($_POST["email"]);
	$password = trim($_POST["password"]);
	$confirm_pass = trim($_POST["passwordc"]);
	$captcha = md5($_POST["captcha"]);
	
	if ($captcha != $_SESSION['captcha'])
	{
		$errors[] = lang("CAPTCHA_FAIL");
	}
	if(minMaxRange(8,50,$password) && minMaxRange(8,50,$confirm_pass))
	{
		$errors[] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
	}
	else if($password != $confirm_pass)
	{
		$errors[] = lang("ACCOUNT_PASS_MISMATCH");
	}
	if(!isValidEmail($email))
	{
		$errors[] = lang("ACCOUNT_INVALID_EMAIL");
	}
	//End data validation
	if(count($errors) == 0)
	{	
		//Construct a user object
		$user = new User($password,$email);
		
		//Checking this flag tells us whether there were any errors such as possible data duplication occured
		if(!$user->status)
		{
			if($user->email_taken) 	  $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));		
		}
		else
		{
			//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
			if(!$user->userCakeAddUser())
			{
				if($user->mail_failure) $errors[] = lang("MAIL_ERROR");
				if($user->sql_failure)  $errors[] = lang("SQL_ERROR");
			}
		}
	}
	if(count($errors) == 0) {
		$successes[] = $user->success;
	}
}

require_once("models/header.php");
echo "
<body>
<link href='css/signin.css' rel='stylesheet'>";
include("models/main-nav.php");
echo "
<div id='wrapper'>
<div id='top'><div id='logo'></div></div>
<div id='content'>
<div id='main'>";

echo resultBlock($errors,$successes);

echo "
	<div class='container'>
		<form name='newUser' action='".$_SERVER['PHP_SELF']."' method='post' class='form-signin' role='form'>
			<h2 class='form-signin-heading'>Register User</h2>
			<input type='text' class='form-control' placeholder='Email Address' name='email'  required autofocus/>
			<input type='password' class='form-control' placeholder='Password' name='password'  required />
			<input type='password' class='form-control' placeholder='Confirm password' name='passwordc'  required />
			<label>Security Code:
			<img src='models/captcha.php'></label>
			<input type='text' class='form-control' placeholder='Enter Security Code' name='captcha'  required />
			<button type='submit' class='btn btn-lg btn-primary btn-block'>Register</button>
		</form>
	</div>

</div>
<div id='bottom'></div>
</div>";
include("models/footer.php");
include("models/BootstrapJavaScript.php");
echo "
</body>
</html>";
?>

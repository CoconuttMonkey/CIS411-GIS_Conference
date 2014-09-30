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
	$username = trim($_POST["username"]);
	$displayname = trim($_POST["displayname"]);
	$password = trim($_POST["password"]);
	$confirm_pass = trim($_POST["passwordc"]);
	$captcha = md5($_POST["captcha"]);
	
	
	if ($captcha != $_SESSION['captcha'])
	{
		$errors[] = lang("CAPTCHA_FAIL");
	}
	if(minMaxRange(5,25,$username))
	{
		$errors[] = lang("ACCOUNT_USER_CHAR_LIMIT",array(5,25));
	}
	if(!ctype_alnum($username)){
		$errors[] = lang("ACCOUNT_USER_INVALID_CHARACTERS");
	}
	if(minMaxRange(5,25,$displayname))
	{
		$errors[] = lang("ACCOUNT_DISPLAY_CHAR_LIMIT",array(5,25));
	}
	if(!ctype_alnum($displayname)){
		$errors[] = lang("ACCOUNT_DISPLAY_INVALID_CHARACTERS");
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
		$user = new User($username,$displayname,$password,$email);
		
		//Checking this flag tells us whether there were any errors such as possible data duplication occured
		if(!$user->status)
		{
			if($user->username_taken) $errors[] = lang("ACCOUNT_USERNAME_IN_USE",array($username));
			if($user->displayname_taken) $errors[] = lang("ACCOUNT_DISPLAYNAME_IN_USE",array($displayname));
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
?>
<body>
	<header class="row">
		<img src="http://fakeimg.pl/1920x480/?text=GIS Conference" width="100%" alt="Header Image">
		<?php 
			include("nav.php"); 
		?>
	</header>
	<section class="container">
	<h1>Register</h1>
		<div class="row">
			<article class="col-30 centered">
				<?php echo resultBlock($errors,$successes); ?>
				<form name='newUser' action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms text-centered">

					<label>User Name
						<input type='text' name='username' class="width-100" required />
					</label>
					
					<label>Display Name
						<input type='text' name='displayname' class="width-100" required />
					</label>
					
					<label>Password
						<input type='password' name='password' class="width-100" required />
					</label>
					
					<label>Confirm
						<input type='password' name='passwordc' class="width-100" required />
					</label>
					
					<label>Email
						<input type='email' name='email' class="width-100" required />
					</label>
					
					<label>Security Code: <img src='models/captcha.php' class="right"></label>
						
					
					<label>Enter Security Code
						<input name='captcha' type='text' class="width-100" required >
					</label>
					
					<input type='submit' value='Register' class="btn"/>
				</form>
			</article>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>
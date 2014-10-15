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
	$first_name = trim($_POST["first_name"]);
	$last_name = trim($_POST["last_name"]);
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
		$user = new User($first_name,$last_name,$password,$email);
		
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
?>

<style>
	.show {
		display: block;
	}
	.hide {
		display: none;
	}
</style>

<body>
	<?php include("models/main-nav.php"); ?>
	<section class="container">
	<h1>Registration</h1>
		<div class="row">
			<?php echo resultBlock($errors,$successes); ?>
			<form name='newUser' action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms text-left">
				<div class="col-33 centered">
				    <fieldset id="general-info" class="text-centered">
				        <legend>Account Information</legend>
						<label>
							<input type='text' name='first_name' class="width-100" placeholder='First Name' required />
						</label>

						<label>
							<input type='text' name='last_name' class="width-100" placeholder='Last Name' required />
						</label>
						
						<label>
							<input type='email' name='email' class="width-100" placeholder='Email Address' required />
						</label>

						<label>
							<input type='password' name='password' class="width-100" placeholder="Password" required />
						</label>
						
						<label>
							<input type='password' name='passwordc' class="width-100" placeholder="Confirm" required />
						</label>

						<img src='models/captcha.php'class="width-50" >
						<label>
							<input name='captcha' type='text' class="width-50 centered" placeholder="Security Code" required >
						</label>
						
						<input type='submit' value='Register' class="btn col-50 centered"/>
					</fieldset>
				</div>
			</form>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>

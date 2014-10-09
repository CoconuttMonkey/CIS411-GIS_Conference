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
	$first_name = trim($_POST["first_name"]);
	$last_name = trim($_POST["last_name"]);
	$email = trim($_POST["email"]);
	$reg_type = trim($_POST["reg_type"]);
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
		$user = new User($password, $email, $token, $activationRequest, $passwordRequest, $active, $title, $signUp, $signIn, $first_name, $last_name, $reg_type);
		//Checking this flag tells us whether there were any errors such as possible data duplication occured
		if(!$user->status)
		{
			if($user->email_taken) {
				$errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));		
			}
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
	<?php include("nav.php"); ?>
	<section class="container">
	<h1>Registration</h1>
		<div class="row">
			<article class="col-100">
				<?php echo resultBlock($errors,$successes); ?>
				<form name='newUser' action='<? echo $_SERVER['PHP_SELF']; ?>' method='post' class="forms width-50 centered">
					<fieldset>
						<legend>Account Information</legend>
						<label>First Name
							<input type='text' name='first_name' class="width-100" required />
						</label>
	
						<label>Last Name
							<input type='text' name='last_name' class="width-100" required />
						</label>
												
						<label>Email Address
							<input type='email' name='email' class="width-100" required />
						</label>
					
						<label>Registration Type
							<ul class="forms-list">
						        <li>
						            <input type="radio" name="reg_type" id="reg_type-1" value="1-day">
						            <label for="reg_type-1">1 Day Admittance ($25)</label>
						        </li>
						        <li>
						            <input type="radio" name="reg_type" id="reg_type-2" value="2-day">
						            <label for="reg_type-2">2 Day Admittance ($35)</label>
						        </li>
						        <li>
						            <input type="radio" name="reg_type" id="reg_type-exhibitor" value="exhibitor">
						            <label for="reg_type-exhibitor">Exhibitor ($125)</label>
						        </li>
						        <li>
						            <input type="radio" name="reg_type" id="reg_type-presenter" value="presenter">
						            <label for="reg_type-presenter">Presenter</label>
						        </li>
						        <li>
						            <input type="radio" name="reg_type" id="reg_type-student" value="student">
						            <label for="reg_type-student">Student</label>
						        </li>
						        <li>
						            <input type="radio" name="reg_type" id="reg_type-staff" value="staff">
						            <label for="reg_type-staff">Faculty / Staff</label>
						        </li>
						    </ul>
						</label>
						
						<label>Password
							<input type='password' name='password' class="width-100" required />
						</label>
						
						<label>Confirm Password
							<input type='password' name='passwordc' class="width-100" required />
						</label>
	
						<label class="text-centered">Please enter the code below<br>
							<img src='models/captcha.php'class="width-50" >
							<input name='captcha' type='text' class="width-30 centered" placeholder="Security Code" required >
						</label>
						
						<label class="text-centered">
							<input type='submit' value='Register' class="btn col-50 centered" /><br><br>
							<a href='login.php' class='small'>Already have an account?</a> | <a href='forgot-password.php' class='small'>Forgot Password</a>
						</label>
					</fieldset>
				</form>
			</article>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>
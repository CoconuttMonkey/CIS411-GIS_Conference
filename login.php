<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(isUserLoggedIn()) { header("Location: user_dashboard.php"); die(); }

//Forms posted
if(!empty($_POST))
{
	$errors = array();
	$email = trim($_POST["email"]);
	$password = trim($_POST["password"]);
	
	//Perform some validation
	//Feel free to edit / change as required
	if($email == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_USERNAME");
	}
	if($password == "")
	{
		$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
	}

	if(count($errors) == 0)
	{
		//A security note here, never tell the user which credential was incorrect
		if(!emailExists($email))
		{
			$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
		}
		else
		{
			$userdetails = fetchUserDetails($email);
			
			//See if the user's account is activated
			if($userdetails["active"]==0)
			{
				$errors[] = lang("ACCOUNT_INACTIVE");
			}
			else
			{
				//Hash the password and use the salt from the database to compare the password.
				$entered_pass = generateHash($password,$userdetails["password"]);
				
				if($entered_pass != $userdetails["password"])
				{
					//Again, we know the password is at fault here, but lets not give away the combination incase of someone bruteforcing
					$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
				}
				else
				{
					//Passwords match! we're good to go'
					
					//Construct a new logged in user object
					//Transfer some db data to the session object
					$loggedInUser = new loggedInUser();
					$loggedInUser->email = $userdetails["email"];
					$loggedInUser->user_id = $userdetails["id"];
					$loggedInUser->hash_pw = $userdetails["password"];
					$loggedInUser->title = $userdetails["title"];
					
					// Check if user is an attendee
					if (userIsAttendee($userdetails["id"])) {
						
						// Get attendee details
						$attendeeDetails = fetchAttendeeDetails($userdetails["id"]);
						
						$loggedInUser->first_name = $attendeeDetails["f_name"];
						$loggedInUser->last_name = $attendeeDetails["l_name"];
						$loggedInUser->address_1 = $attendeeDetails["address_1"];
						$loggedInUser->address_2 = $attendeeDetails["address_2"];
						$loggedInUser->city = $attendeeDetails["city"];
						$loggedInUser->state = $attendeeDetails["state"];
						$loggedInUser->zip = $attendeeDetails["postal_code"];
						$loggedInUser->country = $attendeeDetails["country"];
						$loggedInUser->phone = $attendeeDetails["phone"];
						$loggedInUser->company = $attendeeDetails["company"];
					}
					
					//Update last sign in
					$loggedInUser->updateLastSignIn();
					$_SESSION["userCakeUser"] = $loggedInUser;
					
					//Redirect to logged in page
					header("Location: user_dashboard.php");
					die();
				}
			}
		}
	}
}

require_once("models/header.php");

echo "<body>";

include("models/main-nav.php");
echo "
<div id='wrapper'>
<div id='top'><div id='logo'></div></div>
<div id='content'>
<div id='main'>";

echo resultBlock($errors,$successes);

echo "
<link href='css/signin.css' rel='stylesheet'>
	<div class='container'>
		<form name='login' action='".$_SERVER['PHP_SELF']."' method='post' class='form-signin' role='form'>
			<h2 class='form-signin-heading'>Login</h2>
			<input type='email' class='form-control' placeholder='Email Address' name='email'  required autofocus />
			<input type='password' class='form-control' placeholder='Password' name='password'  required/>
			<button type='submit' class='btn btn-lg btn-primary btn-block'>Sign in</button>
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

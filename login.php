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
					$loggedInUser->first_name = $userdetails["first_name"];
					$loggedInUser->last_name = $userdetails["last_name"];
					
					// Check if user is an attendee
					if (userIsAttendee($userdetails["id"])) {
						
						// Get attendee details
						$attendeeDetails = fetchAttendeeDetails($userdetails["id"]);
						
						$loggedInUser->country = $attendeeDetails["country"];
						$loggedInUser->phone = $attendeeDetails["phone"];
						$loggedInUser->address_1 = $attendeeDetails["address_1"];
						$loggedInUser->address_2 = $attendeeDetails["address_2"];
						$loggedInUser->city = $attendeeDetails["city"];
						$loggedInUser->state = $attendeeDetails["state"];
						$loggedInUser->zip = $attendeeDetails["zip"];
						$loggedInUser->company = $attendeeDetails["company"];
						$loggedInUser->reg_type = $attendeeDetails["reg_type"];
					}
					
					//Update last sign in
					$loggedInUser->updateLastSignIn();
					$_SESSION["userCakeUser"] = $loggedInUser;
					
					//Redirect to user account page
					header("Location: ../user_dashboard.php");
					die();
				}
			}
		}
	}
}

require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<section class="container">
		<div class="row">
			<article class="col-lg-4 col-lg-push-4 col-md-6 col-md-push-3 col-sm-8 col-sm-push-2">
				<?php echo resultBlock($errors,$successes); ?>
				
				<?php include('models/loginForm.php'); ?>
			</article>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>
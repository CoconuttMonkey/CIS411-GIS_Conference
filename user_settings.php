<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he is not logged in
if (!isUserLoggedIn()) { header("Location: login.php"); die(); }

if (!empty($_POST)) {
	$errors = array();
	$successes = array();
	$password = $_POST["password"];
	$password_new = $_POST["passwordc"];
	$password_confirm = $_POST["passwordcheck"];
	
	$errors = array();
	$email = $_POST["email"];
	
	//Perform some validation
	//Feel free to edit / change as required
	
	//Confirm the hashes match before updating a users password
	$entered_pass = generateHash($password,$loggedInUser->hash_pw);
	
	if (trim($password) == ""){
		$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
	}
	else if ($entered_pass != $loggedInUser->hash_pw) {
		//No match
		$errors[] = lang("ACCOUNT_PASSWORD_INVALID");
	}

	if ($email != $loggedInUser->email) {
		if(trim($email) == "") {
			$errors[] = lang("ACCOUNT_SPECIFY_EMAIL");
		} else if (!isValidEmail($email)) {
			$errors[] = lang("ACCOUNT_INVALID_EMAIL"); 
		} else if (emailExists($email)) {
			$errors[] = lang("ACCOUNT_EMAIL_IN_USE", array($email));	
		}
		
		//End data validation
		if(count($errors) == 0) {
			$loggedInUser->updateEmail($email);
			$successes[] = lang("ACCOUNT_EMAIL_UPDATED");
		}
	}
	
	if ($password_new != "" OR $password_confirm != "") {
		if (trim($password_new) == "") {
			$errors[] = lang("ACCOUNT_SPECIFY_NEW_PASSWORD");
		} else if (trim($password_confirm) == "") {
			$errors[] = lang("ACCOUNT_SPECIFY_CONFIRM_PASSWORD");
		} else if (minMaxRange(8,50,$password_new)) {	
			$errors[] = lang("ACCOUNT_NEW_PASSWORD_LENGTH",array(8,50));
		} else if ($password_new != $password_confirm) {
			$errors[] = lang("ACCOUNT_PASS_MISMATCH");
		}
		
		//End data validation
		if (count($errors) == 0) {
			//Also prevent updating if someone attempts to update with the same password
			$entered_pass_new = generateHash($password_new,$loggedInUser->hash_pw);
			
			if ($entered_pass_new == $loggedInUser->hash_pw) {
				//Don't update, this fool is trying to update with the same password Â¬Â¬
				$errors[] = lang("ACCOUNT_PASSWORD_NOTHING_TO_UPDATE");
			} else {
				//This function will create the new hash and update the hash_pw property.
				$loggedInUser->updatePassword($password_new);
				$successes[] = lang("ACCOUNT_PASSWORD_UPDATED");
			}
		}
	}
	if (count($errors) == 0 AND count($successes) == 0) {
		$errors[] = lang("NOTHING_TO_UPDATE");
	}
}

require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<section class="container">
		<div class="row">
			<? echo resultBlock($errors,$successes); ?>
			<div class="col-80" style="margin-left: 0;">
				<h1>User Settings</h1>
				<form name='updateAccount' action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms">
					<section class="row">
						<div class="col-50">
					      <legend>Account Information</legend>
								<label>First Name
									<input type='text' name='first_name' class="width-100" value="<? echo $loggedInUser->first_name; ?>" />
								</label>
			
								<label>Last Name
									<input type='text' name='last_name' class="width-100" value="<? echo $loggedInUser->last_name; ?>" />
								</label>
								
								<label>Email Address
									<input type='email' name='email' class="width-100" value="<? echo $loggedInUser->email; ?>" />
								</label>
						</div>
						<div class="col-50">
						  <legend>Change Password</legend>
							<label>New Password
								<input type='password' name='passwordc' class="width-100" />
							</label>
							
							<label>Confirm Password
								<input type='password' name='passwordcheck' class="width-100" />
							</label>
						</div>
					</section>
					<section class="row">
						<div class="col-50 centered text-centered">
						  
							<label><legend>Enter Password to apply changes</legend>
								<input type='password' name='password' class="width-100" required />
							</label>
							<input type='submit' value='Update' class='btn' />
						</div>
					</section>
				</form>
			</div>
			<aside class="col-20 nav">
				<? 
				if(isUserLoggedIn()) {
					include('models/sideNav.php');
				} else {
					include('models/loginForm.php');
				}
				?>
			</aside>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>
<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/
error_reporting(E_ALL); 
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
	$first_name = $_POST["first_name"];
	$last_name = trim($_POST["last_name"]);
	$company = trim($_POST["company"]);
	$email = trim($_POST["email"]);
	$address_1 = trim($_POST["address_1"]);
	$address_2 = trim($_POST["address_2"]);
	$city = trim($_POST["city"]);
	$state = trim($_POST["state"]);
	$zip = trim($_POST["zip"]);
	
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

	if ($first_name != $loggedInUser->first_name) {
		if(trim($first_name) == "") {
			$errors[] = lang("ACCOUNT_SPECIFY_FNAME");
		}
		
		//End data validation
		if(count($errors) == 0) {
			$loggedInUser->updateFirstName($first_name);
			$successes[] = lang("ACCOUNT_FNAME_UPDATED");
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
	<header class="row">
		<?php include("nav.php"); ?>
	</header>
	<section class="container">
	<h1>User Settings</h1>
		<div class="row">
			<? echo resultBlock($errors,$successes); ?>
			<form name='updateAccount' action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms">

				<fieldset id="general-info" class="col-40 col-push-10">
			        <legend>Account Information</legend>
					<label>First Name
						<input type='text' name='first_name' class="width-100" value="<? echo $loggedInUser->first_name; ?>" />
					</label>

					<label>Last Name
						<input type='text' name='last_name' class="width-100" value="<? echo $loggedInUser->last_name; ?>" />
					</label>

					<label>Company / Institution
						<input type='text' name='company' class="width-100" value="<? echo $loggedInUser->company; ?>" />
					</label>
					
					<label>Email Address
						<input type='email' name='email' class="width-100" value="<? echo $loggedInUser->email; ?>" />
					</label>

					<label>Address Line 1
						<input type='text' name='address_1' class="width-100" value="<? echo $loggedInUser->address_1; ?>" />
					</label>

					<label>Address Line 2
						<input type='text' name='address_2' class="width-100" value="<? echo $loggedInUser->address_2; ?>" />
					</label>

					<label>City
						<input type='text' name='city' class="width-100" value="<? echo $loggedInUser->city; ?>" />
					</label>

					<label>State / Province
						<input type='text' name='state' class="width-100" value="<? echo $loggedInUser->state; ?>" />
					</label>

					<label>Zip Code
						<input type='text' name='zip' class="width-100" value="<? echo $loggedInUser->zip; ?>" />
					</label>
				</fieldset>
					
				<div class="col-40 col-push-10">
					<fieldset class="width-100" >
					    <legend>Change Password</legend>
						<label>New Password
							<input type='password' name='passwordc' class="width-100" />
						</label>
						
						<label>Confirm Password
							<input type='password' name='passwordcheck' class="width-100" />
						</label>
					</fieldset>

					<fieldset class="width-100" >
					    <legend>Enter Password to apply changes</legend>
						<label>Password
							<input type='password' name='password' class="width-100" required />
						</label>
						<input type='submit' value='Update' class='btn' />
					</fieldset>
				
					<fieldset class="width-100">
						<legend>Account Status</legend>
						<? if ($loggedInUser->paid == '1') { 
							echo '<span class="success">Paid</span>';
						} else if ($loggedInUser->paid == '0') { 
							echo '<span class="error">You have an unpaid balance of '.$loggedInUser->balance.'</span>';
						} ?>
					</fieldset>
				</div>
			</form>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>
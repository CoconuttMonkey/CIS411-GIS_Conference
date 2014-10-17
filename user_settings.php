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
		<ol class="breadcrumb">
		  <li><a href="account.php">Dashboard</a></li>
		  <li class="active"><a href="user_settings.php">Settings</a></li>
		</ol>
			<? echo resultBlock($errors,$successes); ?>
			<div class="col-lg-12">
				<h1>Account Settings</h1>
				<form name='updateAccount' action='<? $_SERVER['PHP_SELF'] ?>' method='post' style="margin-bottom: 100px;">
					<section class="row">
						<div class="col-lg-6 col-md-6">
					      <h3>Account Information</h3>
								<div class="input-group">
									<span class="input-group-addon">First Name</span>
								  <input type="text" class="form-control" name="first_name" value="<? echo $loggedInUser->first_name; ?>" required>
								</div>
								<br>
								<div class="input-group">
									<span class="input-group-addon">Last Name</span>
								  <input type="text" class="form-control" name="last_name" value="<? echo $loggedInUser->last_name; ?>" required>
								</div>
								<br>
								<div class="input-group">
									<span class="input-group-addon">@</span>
								  <input type="text" class="form-control" name="email" value="<? echo $loggedInUser->email; ?>" required>
								</div>
						</div>
						<div class="col-lg-6 col-md-6">
						  <h3>Change Password</h3>
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
							  <input type="password" class="form-control" name="passwordc" placeholder="New Password" required>
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
							  <input type="password" class="form-control" name="passwordcheck" placeholder="New Password" required>
							</div>
							<br>
							<div class="input-group">
								<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
					      <input type='password' name='password' class="form-control" placeholder="Current Password" required />
					      <span class="input-group-btn">
					        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-check"></span> Save</button>
					      </span>
					    </div><!-- /input-group -->
					</section>
				</form>
			</div>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>
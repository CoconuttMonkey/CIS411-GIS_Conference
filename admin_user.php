<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$userId = $_GET['id'];

//Check if selected user exists
if(!userIdExists($userId)){
	header("Location: admin_users.php"); die();
}

$userdetails = fetchUserDetails(NULL, NULL, $userId); //Fetch user details

//Forms posted
if(!empty($_POST))
{	
	//Delete selected account
	if(!empty($_POST['delete'])){
		$deletions = $_POST['delete'];
		if ($deletion_count = deleteUsers($deletions)) {
			$successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
		}
		else {
			$errors[] = lang("SQL_ERROR");
		}
	}
	else
	{
		//Update display name
		if ($userdetails['display_name'] != $_POST['display']){
			$displayname = trim($_POST['display']);
			
			//Validate display name
			if(displayNameExists($displayname))
			{
				$errors[] = lang("ACCOUNT_DISPLAYNAME_IN_USE",array($displayname));
			}
			elseif(minMaxRange(5,25,$displayname))
			{
				$errors[] = lang("ACCOUNT_DISPLAY_CHAR_LIMIT",array(5,25));
			}
			elseif(!ctype_alnum($displayname)){
				$errors[] = lang("ACCOUNT_DISPLAY_INVALID_CHARACTERS");
			}
			else {
				if (updateDisplayName($userId, $displayname)){
					$successes[] = lang("ACCOUNT_DISPLAYNAME_UPDATED", array($displayname));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
			
		}
		else {
			$displayname = $userdetails['display_name'];
		}
		
		//Activate account
		if(isset($_POST['activate']) && $_POST['activate'] == "activate"){
			if (setUserActive($userdetails['activation_token'])){
				$successes[] = lang("ACCOUNT_MANUALLY_ACTIVATED", array($displayname));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		//Update email
		if ($userdetails['email'] != $_POST['email']){
			$email = trim($_POST["email"]);
			
			//Validate email
			if(!isValidEmail($email))
			{
				$errors[] = lang("ACCOUNT_INVALID_EMAIL");
			}
			elseif(emailExists($email))
			{
				$errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));
			}
			else {
				if (updateEmail($userId, $email)){
					$successes[] = lang("ACCOUNT_EMAIL_UPDATED");
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
		}
		
		//Update title
		if ($userdetails['title'] != $_POST['title']){
			$title = trim($_POST['title']);
			
			//Validate title
			if(minMaxRange(1,50,$title))
			{
				$errors[] = lang("ACCOUNT_TITLE_CHAR_LIMIT",array(1,50));
			}
			else {
				if (updateTitle($userId, $title)){
					$successes[] = lang("ACCOUNT_TITLE_UPDATED", array ($displayname, $title));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
		}
		
		//Remove permission level
		if(!empty($_POST['removePermission'])){
			$remove = $_POST['removePermission'];
			if ($deletion_count = removePermission($remove, $userId)){
				$successes[] = lang("ACCOUNT_PERMISSION_REMOVED", array ($deletion_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		if(!empty($_POST['addPermission'])){
			$add = $_POST['addPermission'];
			if ($addition_count = addPermission($add, $userId)){
				$successes[] = lang("ACCOUNT_PERMISSION_ADDED", array ($addition_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		$userdetails = fetchUserDetails(NULL, NULL, $userId);
	}
}

$userPermission = fetchUserPermissions($userId);
$permissionData = fetchAllPermissions();

require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<div class='row'>
			<div class='col-80'>
				<h1>Edit User</h1>
				<? echo resultBlock($errors,$successes); ?>
				<form name='adminUser' action='<? echo $_SERVER['PHP_SELF']; ?>?id=<? echo $userId; ?>' method='post' class='forms'>
					<div class='col-50'>
						<fieldset id='general-info' class='width-100'>
						    <legend>Contact Information</legend>
							<label>First Name
								<input type='text' name='first_name' class='width-100 contact-info' value='<? echo $userdetails['first_name']; ?>' />
							</label>
						
							<label>Last Name
								<input type='text' name='last_name' class='width-100 contact-info' value='<? echo $userdetails['last_name']; ?>' />
							</label>
							
							<label>Email Address
								<input type='email' name='email' class='width-100 contact-info' value='<? echo $userdetails['email']; ?>' />
							</label>
						</fieldset>
					</div>
					<div class='col-40'>
						<fieldset id='general-info' class='width-100'>
							<legend>Account Details</legend>
							<label>Active:
								<? //Display activation link, if account inactive
								if ($userdetails['active'] == '1'){
									echo "Yes";	
								}
								else{
									echo "No
									</p>
									<p>
									<label>Activate:</label>
									<input type='checkbox' name='activate' id='activate' value='activate'></label>
									";
								} ?>
							</label>
							
							<label>Paid:
								<? //Display payment status
								if ($userdetails['paid'] == '1'){
									echo " <span class='success'>Yes</span>";	
								}
								else{
									echo " <span class='error'>No</span>
									";
								} ?>
							</label>
							
							<label>Title 
								<input type='text' name='title' value='<? echo $userdetails['title']; ?>' />
							</label>
							
							<label>Sign Up: <? echo date("j M, Y", $userdetails['sign_up_stamp']); ?></label>
							
							<label>Last Sign In:
								<? //Last sign in, interpretation
								if ($userdetails['last_sign_in_stamp'] == '0'){
									echo "Never";	
								}
								else {
									echo date("j M, Y", $userdetails['last_sign_in_stamp']);
								} ?>

							</label>
							
							<label>
								<input type='checkbox' name='delete[<? echo $userdetails['id']; ?>]' id='delete[<? echo $userdetails['id']; ?>]' value='<? echo $userdetails['id']; ?>'> Delete User
							</label>
						</fieldset>

						<?
						//Settings for permission level 4 (web master)
						if ($loggedInUser->checkPermission(array(4))){
						echo "
						<fieldset>
						<legend>Account Permission</legend>
						<div id='regbox'>
						<p><strong>Remove Permission:</strong>";
	
						//List of permission levels user is apart of
						foreach ($permissionData as $v1) {
							if(isset($userPermission[$v1['id']])){
								echo "<br><input type='checkbox' name='removePermission[".$v1['id']."]' id='removePermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name'];
							}
						}
	
						//List of permission levels user is not apart of
						echo "</p><p><strong>Add Permission:</strong>";
						foreach ($permissionData as $v1) {
							if(!isset($userPermission[$v1['id']])){
								echo "<label style='margin: 0; padding: 0; line-height: 1.6em;'><input type='checkbox' name='addPermission[".$v1['id']."]' id='addPermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name']."</label>";
							}
						} ?>
						</p>
						</fieldset>
						<? } ?>
						<input type='submit' value='Update' class='btn' />
					</div>
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
	</div>
	<?php include("models/footer.php"); ?>
	<script>
		$('edit-contact-info').click(function {
			$( "form :disabled" ).removeAttr('disabled');
		});
	</script>
</body>
</html>

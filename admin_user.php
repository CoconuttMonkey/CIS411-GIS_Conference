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
		$email = $_POST["email"];
		$first_name = trim($_POST["first_name"]);
		$last_name = trim($_POST["last_name"]);
		$company = trim($_POST["company"]);
		$email = trim($_POST["email"]);
		$address_1 = trim($_POST["address_1"]);
		$address_2 = trim($_POST["address_2"]);
		$city = trim($_POST["city"]);
		$state = trim($_POST["state"]);
		$zip = trim($_POST["zip"]);

		if ($email != $userdetails['email']) {
			if(trim($email) == "") {
				$errors[] = lang("ACCOUNT_SPECIFY_EMAIL");
			} else if (!isValidEmail($email)) {
				$errors[] = lang("ACCOUNT_INVALID_EMAIL"); 
			} else if (emailExists($email)) {
				$errors[] = lang("ACCOUNT_EMAIL_IN_USE", array($email));	
			}
			
			//End data validation
			if(count($errors) == 0) {
				updateEmail($userdetails['id'], $email);
				$successes[] = lang("ACCOUNT_EMAIL_UPDATED");
			}
		}

		if ($first_name != $userdetails['first_name']) {
			if(trim($first_name) == "") {
				$errors[] = lang("ACCOUNT_SPECIFY_FNAME");
			}
			
			//End data validation
			if(count($errors) == 0) {
				updateFirstName($userdetails['id'], $first_name);
				$userdetails['first_name'] = $first_name;
				$successes[] = lang("ACCOUNT_FNAME_UPDATED");
			}
		}

		if ($last_name != $userdetails['last_name']) {
			if(trim($last_name) == "") {
				$errors[] = lang("ACCOUNT_SPECIFY_LNAME");
			}
			
			//End data validation
			if(count($errors) == 0) {
				updateLastName($userdetails['id'], $last_name);
				$userdetails['last_name'] = $last_name;
				$successes[] = lang("ACCOUNT_LNAME_UPDATED");
			}
		}

		if ($company != $userdetails['company']) {
			if(trim($company) == "") {
				$success[] = lang("ACCOUNT_SPECIFY_COMPANY");
			}
			
			//End data validation
			if(count($errors) == 0) {
				updateCompany($userdetails['id'], $company);
				$userdetails['company'] = $company;
				$successes[] = lang("ACCOUNT_COMPANY_UPDATED");
			}
		}

		if ($address_1 != $userdetails['address_1']) {
			if(trim($address_1) == "") {
				$errors[] = lang("ACCOUNT_SPECIFY_ADDRESS");
			}
			
			//End data validation
			if(count($errors) == 0) {
				updateAddress_1($userdetails['id'], $address_1);
				$userdetails['address_1'] = $address_1;
				$successes[] = lang("ACCOUNT_ADDRESS_UPDATED");
			}
		}

		if ($address_2 != $userdetails['address_2']) {
			if(trim($address_2) == "") {
				$errors[] = lang("ACCOUNT_SPECIFY_ADDRESS");
			}
			
			//End data validation
			if(count($errors) == 0) {
				updateAddress_2($userdetails['id'], $address_1);
				$userdetails['address_2'] = $address_2;
				$successes[] = lang("ACCOUNT_ADDRESS_UPDATED");
			}
		}

		if ($city != $userdetails['city']) {
			if(trim($city) == "") {
				$errors[] = lang("ACCOUNT_SPECIFY_CITY");
			}
			
			//End data validation
			if(count($errors) == 0) {
				updateCity($userdetails['id'], $city);
				$userdetails['city'] = $city;
				$successes[] = lang("ACCOUNT_CITY_UPDATED");
			}
		}

		if ($state != $userdetails['state']) {
			if(trim($state) == "") {
				$errors[] = lang("ACCOUNT_SPECIFY_STATE");
			}
			
			//End data validation
			if(count($errors) == 0) {
				updateState($userdetails['id'], $state);
				$userdetails['state'] = $state;
				$successes[] = lang("ACCOUNT_STATE_UPDATED");
			}
		}

		if ($zip != $userdetails['zip']) {
			if(trim($zip) == "") {
				$errors[] = lang("ACCOUNT_SPECIFY_ZIP");
			}
			
			//End data validation
			if(count($errors) == 0) {
				updateZip($userdetails['id'], $zip);
				$userdetails['zip'] = $zip;
				$successes[] = lang("ACCOUNT_ZIP_UPDATED");
			}
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
	<?php include("nav.php"); ?>
	<?
echo "
<body>
<div class='container'>
<h1>Admin User</h1>
<div class='row'>
<div class='col-100'>";

echo resultBlock($errors,$successes);

echo "
<form name='adminUser' action='".$_SERVER['PHP_SELF']."?id=".$userId."' method='post' class='forms'>
<div class='col-40'>
<fieldset id='general-info' class='width-100'>
    <legend>Contact Information</legend>
	<label>First Name
		<input type='text' name='first_name' class='width-100 contact-info' value='".$userdetails['first_name']."' />
	</label>

	<label>Last Name
		<input type='text' name='last_name' class='width-100 contact-info' value='".$userdetails['last_name']."' />
	</label>

	<label>Company / Institution
		<input type='text' name='company' class='width-100 contact-info' value='".$userdetails['company']."' />
	</label>
	
	<label>Email Address
		<input type='email' name='email' class='width-100 contact-info' value='".$userdetails['email']."' />
	</label>

	<label>Address Line 1
		<input type='text' name='address_1' class='width-100 contact-info' value='".$userdetails['address_1']."' />
	</label>

	<label>Address Line 2
		<input type='text' name='address_2' class='width-100 contact-info' value='".$userdetails['address_2']."' />
	</label>

	<label>City
		<input type='text' name='city' class='width-100 contact-info' value='".$userdetails['city']."' />
	</label>

	<label>State / Province
		<input type='text' name='state' class='width-100 contact-info' value='".$userdetails['state']."' />
	</label>

	<label>Zip Code
		<input type='text' name='zip' class='width-100 contact-info' value='".$userdetails['zip']."' />
	</label>
</fieldset>
</div>

<div class='col-40'>
<fieldset id='general-info' class='width-100'>
    <legend>Account Details</legend>
<label>Active:";

//Display activation link, if account inactive
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
}

echo "</label>
<label>Paid:";

//Display activation link, if account inactive
if ($userdetails['active'] == '1'){
	echo " <span class='success'>Yes</span>";	
}
else{
	echo " <span class='error'>No</span>
	";
}

echo "</label>
<label>Title <input type='text' name='title' value='".$userdetails['title']."' /></label>
<label>Sign Up: ".date("j M, Y", $userdetails['sign_up_stamp'])."</label>
<label>Last Sign In: ";

//Last sign in, interpretation
if ($userdetails['last_sign_in_stamp'] == '0'){
	echo "Never";	
}
else {
	echo date("j M, Y", $userdetails['last_sign_in_stamp']);
}

echo "</label>
<label><input type='checkbox' name='delete[".$userdetails['id']."]' id='delete[".$userdetails['id']."]' value='".$userdetails['id']."'> Delete User</label>
</fieldset>
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
}

echo"
</p>
</fieldset>
<input type='submit' value='Update' class='btn' />
</div>
</form>
</div>
</div>
</div>
</div>";

?>
	<?php include("models/footer.php"); ?>
	<script>
		$('edit-contact-info').click(function {
			$( "form :disabled" ).removeAttr('disabled');
		});
	</script>
</body>
</html>

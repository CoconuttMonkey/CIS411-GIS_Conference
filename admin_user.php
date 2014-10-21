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

if(userIsAttendee($userId)) {
	$userdetails = fetchAttendeeDetails($userId); //Fetch attendee details
} else {
	$userdetails = fetchUserDetails(NULL, NULL, $userId); //Fetch user details
}

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
		
		
	}
}

$userPermission = fetchUserPermissions($userId);
$permissionData = fetchAllPermissions();

require_once("models/header.php");

?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<ol class="breadcrumb">
		  <li><a href="account.php">Dashboard</a></li>
		  <li><a href="admin_users.php">Users</a></li>
		  <li class="active"><a href="#"><? echo $userdetails['first_name']." ".$userdetails['last_name']; ?></a></li>
							<h4 style="float: right; margin-top: -1px;">
								<? //Display payment status
								if ($userdetails['active'] == '1'){
									echo " <span class='label label-success'>Active</span>";	
								}
								else{
									echo " <span class='label label-danger'>Inactive</span>";
								} ?>
							</h4>
		</ol>
		<div class='container'>
					<h1>Edit User</h1>
				</div>
					<? echo resultBlock($errors,$successes); ?>
					<form name='adminUser' action='<? echo $_SERVER['PHP_SELF']; ?>?id=<? echo $userId; ?>' method='post'>
						<div class="row">
							<div class='col-lg-6'>
								<div class="panel panel-primary">
									<div class="panel-heading">Account Information</div>
								  <div class="panel-body">
										<div class="form-group">
											<label>First Name</label>
										  <input type="text" class="form-control" name="first_name" value='<? echo $userdetails['first_name']; ?>' required>
										</div>
										
										<div class="form-group">
											<label>Last Name</label>
										  <input type="text" class="form-control" name="last_name" value='<? echo $userdetails['last_name']; ?>' required>
										</div>
										
										<div class="form-group">
											<label>Email Address</label>
										  <input type="text" class="form-control" name="email" value='<? echo $userdetails['email']; ?>' required>
										</div>
								  </div>
								</div>
							</div>
							
							<div class='col-lg-6'>
								<div class="panel panel-primary">
									<div class="panel-heading">Account Status</div>
								  <div class="panel-body">
								  	<div class="form-group">
											<label>Title</label>
										  <input type="text" class="form-control" name="title" value='<? echo $userdetails['title']; ?>' required>
										</div>
										
										<div class="form-group">
											<label>Sign Up</label>
										  <input type="text" class="form-control" name="sign_up_stamp" value='<? echo date("j M, Y", $userdetails['sign_up_stamp']); ?>' disabled="disabled">
										</div>
										
										<div class="form-group">
											<label>Last Sign In</label>
										  <input type="text" class="form-control" name="title" value='<? //Last sign in, interpretation
											if ($userdetails['last_sign_in_stamp'] == '0'){
												echo "Never";	
											}
											else {
												echo date("j M, Y", $userdetails['last_sign_in_stamp']);
											} ?>' disabled="disabled">
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class='col-lg-6'>
								<div class="panel panel-primary">
									<div class="panel-heading">Account Permissions</div>
								  <div class="panel-body">
								  	<? //Settings for permission level 4 (web master)
										if ($loggedInUser->checkPermission(array(4))){
										echo "
										<legend>Account Permission</legend>
										
										<strong>Remove Permission</strong>";
					
										//List of permission levels user is apart of
										foreach ($permissionData as $v1) {
											if(isset($userPermission[$v1['id']])){
												echo "<br><input type='checkbox' name='removePermission[".$v1['id']."]' id='removePermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name'];
											}
										}
					
										//List of permission levels user is not apart of
										echo "<br><br><strong>Add Permission</strong>";
										foreach ($permissionData as $v1) {
											if(!isset($userPermission[$v1['id']])){
												echo "<br><input type='checkbox' name='addPermission[".$v1['id']."]' id='addPermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name'];
											}
										} ?>
										<? } ?>
								  	</div>
								</div>
							</div>
							<? if(userIsAttendee($userId)) { ?>
							<div class='col-lg-6'>
								<div class="panel panel-primary">
									<div class="panel-heading">Contact Information</div>
								  <div class="panel-body">
									  
										<div class="form-group">
											<label>Country</label>
			                <select class="form-control" name="country" data-bv-notempty data-bv-notempty-message="The country is required">
		                    <option value="">-- Select a country --</option>
		                    <option value="US" <? if ($userdetails['country'] == 'US') echo 'selected="selected"';?>>United States</option>
		                    <option value="FR" <? if ($userdetails['country'] == 'FR') echo 'selected="selected"';?>>France</option>
		                    <option value="DE" <? if ($userdetails['country'] == 'DE') echo 'selected="selected"';?>>Germany</option>
		                    <option value="IT" <? if ($userdetails['country'] == 'IT') echo 'selected="selected"';?>>Italy</option>
		                    <option value="JP" <? if ($userdetails['country'] == 'JP') echo 'selected="selected"';?>>Japan</option>
		                    <option value="RU" <? if ($userdetails['country'] == 'RU') echo 'selected="selected"';?>>Russia</option>
		                    <option value="GB" <? if ($userdetails['country'] == 'GB') echo 'selected="selected"';?>>United Kingdom</option>
			                </select>
				            </div>
				                    
										<div class="form-group">
											<label>Phone Number</label>
										  <input type="text" class="form-control" name="phone" value="<? echo $userdetails['phone']; ?>">
										</div>
										
										<div class="form-group">
											<label>Address Line 1</label>
										  <input type="text" class="form-control" name="address_1" value="<? echo $userdetails['address_1']; ?>">
										</div>
										
										<div class="form-group">
											<label>Address Line 2</label>
										  <input type="text" class="form-control" name="address_2" value="<? echo $userdetails['address_2']; ?>">
										</div>
										
										<div class="form-group">
											<label>City</label>
										  <input type="text" class="form-control" name="city"  value="<? echo $userdetails['city']; ?>">
										</div>
										
										<div class="form-group">
											<label>State</label>
										  <input type="text" class="form-control" name="state"  value="<? echo $userdetails['state']; ?>">
										</div>
										
										<div class="form-group">
											<label>Zip</label>
										  <input type="text" class="form-control" name="zip"  value="<? echo $userdetails['zip']; ?>">
										</div>
										
										<div class="form-group">
											<label>Company / Institution</label>
										  <input type="text" class="form-control" name="company"  value="<? echo $userdetails['company']; ?>">
										</div>
										
									</div>
								</div>
							</div>
							<? } ?>
						</div>
						<p style="text-align: center;">
							<input type='submit' value='Update' class='btn btn-lg btn-success' />
						</p>
				</form>
			</div>
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

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

$userPermission = fetchUserPermissions($userId);
$permissionData = fetchAllPermissions();

require_once("models/header.php");

?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<ol class="breadcrumb">
		  <li><a href="../admin_dashboard.php">Admin Dashboard</a></li>
		  <li><a href="#">Users</a></li>
		  <li class="active"><a href="#"><? echo $userdetails['f_name']." ".$userdetails['l_name']; ?></a></li>
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
					<h1>User Details</h1>
				</div>
					<div class="row">
						<? echo resultBlock($errors,$successes); ?>
					</div>
					<form name='adminUser' action='edit_user.php?id=<? echo $userId; ?>' method='post'>
						<div class="row">
							<div class='col-lg-6'>
								<div class="panel panel-primary">
									<div class="panel-heading">Account Information</div>
								  <div class="panel-body">
										<div class="form-group">
											<label>First Name</label>
										  <input type="text" class="form-control can-enable" name="first_name" value='<? echo $userdetails['f_name']; ?>' disabled="disabled">
										</div>
										
										<div class="form-group">
											<label>Last Name</label>
										  <input type="text" class="form-control can-enable" name="last_name" value='<? echo $userdetails['l_name']; ?>' disabled="disabled">
										</div>
										
										<div class="form-group">
											<label>Email Address</label>
										  <input type="text" class="form-control can-enable" name="email" value='<? echo $userdetails['email']; ?>' disabled="disabled">
										</div>
								  </div>
								</div>
								
								<div class="panel panel-primary">
									<div class="panel-heading">Account Status</div>
								  <div class="panel-body">
								  	<div class="form-group">
											<label>Title</label>
										  <input type="text" class="form-control can-enable" name="title" value='<? echo $userdetails['title']; ?>' disabled="disabled">
										</div>
								  	<?
										echo "
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
			                <select class="form-control can-enable" name="country" data-bv-notempty data-bv-notempty-message="The country is required" disabled="disabled">
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
										  <input type="text" class="form-control can-enable" name="phone" value="<? echo $userdetails['phone']; ?>" disabled="disabled">
										</div>
										
										<div class="form-group">
											<label>Address Line 1</label>
										  <input type="text" class="form-control can-enable" name="address_1" value="<? echo $userdetails['address_1']; ?>" disabled="disabled">
										</div>
										
										<div class="form-group">
											<label>Address Line 2</label>
										  <input type="text" class="form-control can-enable" name="address_2" value="<? echo $userdetails['address_2']; ?>" disabled="disabled">
										</div>
										
										<div class="form-group">
											<label>City</label>
										  <input type="text" class="form-control can-enable" name="city"  value="<? echo $userdetails['city']; ?>" disabled="disabled">
										</div>
										
										<div class="form-group">
											<label>State</label>
										  <input type="text" class="form-control can-enable" name="state"  value="<? echo $userdetails['state']; ?>" disabled="disabled">
										</div>
										
										<div class="form-group">
											<label>Zip</label>
										  <input type="text" class="form-control can-enable" name="postal_code"  value="<? echo $userdetails['postal_code']; ?>" disabled="disabled">
										</div>
										
										<div class="form-group">
											<label>Company / Institution</label>
										  <input type="text" class="form-control can-enable" name="company"  value="<? echo $userdetails['company']; ?>" disabled="disabled">
										</div>
										
									</div>
								</div>
							</div>
							<? } ?>
						<p style="text-align: center;">
							<input type='submit' value='Save' class='btn btn-lg btn-success' disabled="disabled"/>
							<input type='submit' id='enable-fields' value='Edit' class='btn btn-lg btn-danger'/>
						</p>
						</div>
				</form>
			</div>
		</div>
	</div>
	<?php 
		include("models/footer.php");
		include("models/BootstrapJavaScript.php"); 
	 ?>
</body>
</html>

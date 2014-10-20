<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$permissionId = $_GET['id'];

//Check if selected permission level exists
if(!permissionIdExists($permissionId)){
	header("Location: admin_permissions.php"); die();	
}

$permissionDetails = fetchPermissionDetails($permissionId); //Fetch information specific to permission level

//Forms posted
if(!empty($_POST)){
	
	//Delete selected permission level
	if(!empty($_POST['delete'])){
		$deletions = $_POST['delete'];
		if ($deletion_count = deletePermission($deletions)){
		$successes[] = lang("PERMISSION_DELETIONS_SUCCESSFUL", array($deletion_count));
		}
		else {
			$errors[] = lang("SQL_ERROR");	
		}
	}
	else
	{
		//Update permission level name
		if($permissionDetails['name'] != $_POST['name']) {
			$permission = trim($_POST['name']);
			
			//Validate new name
			if (permissionNameExists($permission)){
				$errors[] = lang("ACCOUNT_PERMISSIONNAME_IN_USE", array($permission));
			}
			elseif (minMaxRange(1, 50, $permission)){
				$errors[] = lang("ACCOUNT_PERMISSION_CHAR_LIMIT", array(1, 50));	
			}
			else {
				if (updatePermissionName($permissionId, $permission)){
					$successes[] = lang("PERMISSION_NAME_UPDATE", array($permission));
				}
				else {
					$errors[] = lang("SQL_ERROR");
				}
			}
		}
		
		//Remove access to pages
		if(!empty($_POST['removePermission'])){
			$remove = $_POST['removePermission'];
			if ($deletion_count = removePermission($permissionId, $remove)) {
				$successes[] = lang("PERMISSION_REMOVE_USERS", array($deletion_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		//Add access to pages
		if(!empty($_POST['addPermission'])){
			$add = $_POST['addPermission'];
			if ($addition_count = addPermission($permissionId, $add)) {
				$successes[] = lang("PERMISSION_ADD_USERS", array($addition_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		//Remove access to pages
		if(!empty($_POST['removePage'])){
			$remove = $_POST['removePage'];
			if ($deletion_count = removePage($remove, $permissionId)) {
				$successes[] = lang("PERMISSION_REMOVE_PAGES", array($deletion_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
		
		//Add access to pages
		if(!empty($_POST['addPage'])){
			$add = $_POST['addPage'];
			if ($addition_count = addPage($add, $permissionId)) {
				$successes[] = lang("PERMISSION_ADD_PAGES", array($addition_count));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
			$permissionDetails = fetchPermissionDetails($permissionId);
	}
}

$pagePermissions = fetchPermissionPages($permissionId); //Retrieve list of accessible pages
$permissionUsers = fetchPermissionUsers($permissionId); //Retrieve list of users with membership
$userData = fetchAllUsers(); //Fetch all users
$pageData = fetchAllPages(); //Fetch all pages

require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<ol class="breadcrumb">
		  <li><a href="account.php">Dashboard</a></li>
		  <li><a href="admin_permissions.php">Permissions</a></li>
		  <li class="active"><a href="#"><? echo $permissionDetails['name']; ?></a></li>
		</ol>
		<div class='row'>
			<h1>Admin Permissions</h1>
			<? echo resultBlock($errors,$successes); ?>
			<form name='adminPermission' action='<? echo $_SERVER['PHP_SELF']; ?>?id=<? echo $permissionId; ?>' method='post'>
				
					<div class='col-lg-6'>
						<div class="panel panel-primary">
							<div class="panel-heading">Permission Information</div>
						  <div class="panel-body">
								<div class="form-group">
									<label>Permission ID</label>
								  <input type="text" class="form-control" name="id" value='<? echo $permissionDetails['id']; ?>' disabled="disabled">
								</div>
								
								<div class="form-group">
									<label>Permission Name</label>
								  <input type="text" class="form-control" name="name" value='<? echo $permissionDetails['name']; ?>'>
								</div>
								
								<div class="form-group">
								  <input type='checkbox' name='delete[<? echo $permissionDetails['id']; ?>]' id='delete[<? echo $permissionDetails['id']; ?>]' value='<? echo $permissionDetails['id']; ?>'>&nbsp;
									<label for="delete[<? echo $permissionDetails['id']; ?>]">Delete Permission</label>
								</div>
						  </div>
						</div>
						
						
						<div class="panel panel-primary">
							<div class="panel-heading">Permission Members</div>
						  <div class="panel-body">
								<div class="form-group">
									<label>Remove Members</label>
								  <? //List users with permission level
									foreach ($userData as $v1) {
										if(isset($permissionUsers[$v1['id']])){
											echo "<br><input type='checkbox' name='removePermission[".$v1['id']."]' id='removePermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['first_name']." ".$v1['last_name']."</label>";
										}
									} ?>
								</div>
								
								<div class="form-group">
									<label>Add Members</label>
								  <? //List users without permission level
									foreach ($userData as $v1) {
										if(!isset($permissionUsers[$v1['id']])){
											echo "<br><input type='checkbox' name='addPermission[".$v1['id']."]' id='addPermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['first_name']." ".$v1['last_name'];
										}
									} ?>
								</div>
						  </div>
						</div>
					</div>

					<div class='col-lg-6'>
						<div class="panel panel-primary">
							<div class="panel-heading">Permission Access</div>
						  <div class="panel-body">
								<div class="form-group">
									<label>Public Access</label>
								  <? //List public pages
									foreach ($pageData as $v1) {
										if($v1['private'] != 1){
											echo "<br>".$v1['page'];
										}
									} ?> 
								</div>
								
								<div class="form-group">
									<label>Remove Access</label>
								  <? //List pages accessible to permission level
									foreach ($pageData as $v1) {
										if(isset($pagePermissions[$v1['id']]) AND $v1['private'] == 1){
											echo "<br><input type='checkbox' name='removePage[".$v1['id']."]' id='removePage[".$v1['id']."]' value='".$v1['id']."'> ".$v1['page'];
										}
									} ?>
								</div>
								
								<div class="form-group">
									<label>Add Access</label>
								  <? //List pages inaccessible to permission level
									foreach ($pageData as $v1) {
										if(!isset($pagePermissions[$v1['id']]) AND $v1['private'] == 1){
											echo "<br><input type='checkbox' name='addPage[".$v1['id']."]' id='addPage[".$v1['id']."]' value='".$v1['id']."'> ".$v1['page'];
										}
									} ?>
								</div>
						  </div>
						</div>
								<input type='submit' value='Update' class='btn btn-lg btn-success' />
					</div>
				</form>
		</div>
	</div>
	<?php include("models/footer.php"); ?>
</body>
</html>

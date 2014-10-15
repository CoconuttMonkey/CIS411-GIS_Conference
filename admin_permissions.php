<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Forms posted
if(!empty($_POST))
{
	//Delete permission levels
	if(!empty($_POST['delete'])){
		$deletions = $_POST['delete'];
		if ($deletion_count = deletePermission($deletions)){
		$successes[] = lang("PERMISSION_DELETIONS_SUCCESSFUL", array($deletion_count));
		}
	}
	
	//Create new permission level
	if(!empty($_POST['newPermission'])) {
		$permission = trim($_POST['newPermission']);
		
		//Validate request
		if (permissionNameExists($permission)){
			$errors[] = lang("PERMISSION_NAME_IN_USE", array($permission));
		}
		elseif (minMaxRange(1, 50, $permission)){
			$errors[] = lang("PERMISSION_CHAR_LIMIT", array(1, 50));	
		}
		else{
			if (createPermission($permission)) {
			$successes[] = lang("PERMISSION_CREATION_SUCCESSFUL", array($permission));
		}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
	}
}

$permissionData = fetchAllPermissions(); //Retrieve list of all permission levels

require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<div class='row'>
			<div class='col-80'>
				<h1>Permission Levels</h1>
				<? echo resultBlock($errors,$successes); ?>

				<form name='adminPermissions' action='<? echo $_SERVER['PHP_SELF'] ?>' method='post' class='forms width-100'>
					<table class='admin width-100'>
						<tr style='text-align: left;'>
							<th>Delete</th><th>Permission Name</th>
						</tr>
						<? //List each permission level
						foreach ($permissionData as $v1) {
							echo "
							<tr>
							<td><input type='checkbox' name='delete[".$v1['id']."]' id='delete[".$v1['id']."]' value='".$v1['id']."'></td>
							<td><a href='admin_permission.php?id=".$v1['id']."'>".$v1['name']."</a></td>
							</tr>";
						} ?>
						<tr>
							<td>Add New</td>
							<td><input type='text' name='newPermission' /></td>
						</tr>
					</table>

					<input type='submit' name='Submit' value='Submit' class='btn' />
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
</body>
</html>

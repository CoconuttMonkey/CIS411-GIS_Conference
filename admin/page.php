<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$pageId = $_GET['id'];

//Check if selected pages exist
if(!pageIdExists($pageId)){
	header("Location: ../admin/pages.php"); die();	
}

$pageDetails = fetchPageDetails($pageId); //Fetch information specific to page

//Forms posted
if(!empty($_POST)){
	$update = 0;
	
	if(!empty($_POST['private'])){ $private = $_POST['private']; }
	
	//Toggle private page setting
	if (isset($private) AND $private == 'Yes'){
		if ($pageDetails['private'] == 0){
			if (updatePrivate($pageId, 1)){
				$successes[] = lang("PAGE_PRIVATE_TOGGLED", array("private"));
			}
			else {
				$errors[] = lang("SQL_ERROR");
			}
		}
	}
	elseif ($pageDetails['private'] == 1){
		if (updatePrivate($pageId, 0)){
			$successes[] = lang("PAGE_PRIVATE_TOGGLED", array("public"));
		}
		else {
			$errors[] = lang("SQL_ERROR");	
		}
	}
	
	//Remove permission level(s) access to page
	if(!empty($_POST['removePermission'])){
		$remove = $_POST['removePermission'];
		if ($deletion_count = removePage($pageId, $remove)){
			$successes[] = lang("PAGE_ACCESS_REMOVED", array($deletion_count));
		}
		else {
			$errors[] = lang("SQL_ERROR");	
		}
		
	}
	
	//Add permission level(s) access to page
	if(!empty($_POST['addPermission'])){
		$add = $_POST['addPermission'];
		if ($addition_count = addPage($pageId, $add)){
			$successes[] = lang("PAGE_ACCESS_ADDED", array($addition_count));
		}
		else {
			$errors[] = lang("SQL_ERROR");	
		}
	}
	
	$pageDetails = fetchPageDetails($pageId);
}

$pagePermissions = fetchPagePermissions($pageId);
$permissionData = fetchAllPermissions();

require_once("../models/header.php");
?>
<body>
	<?php include("../models/main-nav.php"); ?>
	<div class='container'>
		<div class='row'>
				<h1>Admin Page</h1>
				<? echo resultBlock($errors,$successes); ?>
				<form name='adminPage' action='<? echo $_SERVER['PHP_SELF']; ?>?id=<? echo $pageId ?>' method='post'>
					
					<div class='col-lg-6'>
						<div class="panel panel-primary">
							<div class="panel-heading">Page Information</div>
						  <div class="panel-body">
								<div class="form-group">
									<label>Permission ID</label>
								  <input type="text" class="form-control" name="id" value='<? echo $pageDetails['id']; ?>' disabled="disabled">
								</div>
								
								<div class="form-group">
									<label>Permission Name</label>
								  <input type="text" class="form-control" name="name" value='<? echo $pageDetails['page']; ?>' disabled="disabled">
								</div>
								
								<div class="form-group">
									<? //Display private checkbox
									if ($pageDetails['private'] == 1){
										echo "<input type='checkbox' name='private' id='private' value='Yes' checked>";
									}
									else {
										echo "<input type='checkbox' name='private' id='private' value='Yes'>";	
									} ?>
									<label>Private</label>
								</div>
						  </div>
						</div>
					</div>
					
					<div class='col-lg-6'>
						<div class="panel panel-primary">
							<div class="panel-heading">Page Information</div>
							  <div class="panel-body">
									<div class="form-group">
										<label>Remove Access</label>
										<? //Display list of permission levels with access
										foreach ($permissionData as $v1) {
											if(isset($pagePermissions[$v1['id']])){
												echo "<br><input type='checkbox' name='removePermission[".$v1['id']."]' id='removePermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name'];
											}
										} ?>
									</div>
									
									<div class="form-group">
										<label>Add Access</label>
										<? //Display list of permission levels without access
										foreach ($permissionData as $v1) {
											if(!isset($pagePermissions[$v1['id']])){
												echo "<br><input type='checkbox' name='addPermission[".$v1['id']."]' id='addPermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name'];
											}
										} ?>
									</div>
								</div>
						  </div>
						</div>
					</div>
					<input type='submit' value='Update' class='btn btn-lg btn-success' />
				</form>
			</div>
		</div>
	</div>
	<?php include("../models/footer.php"); ?>
</body>
</html>
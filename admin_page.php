<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$pageId = $_GET['id'];

//Check if selected pages exist
if(!pageIdExists($pageId)){
	header("Location: admin_pages.php"); die();	
}

$pageDetails = fetchPageDetails($pageId); //Fetch information specific to page

//Forms posted
if(!empty($_POST)){
	$update = 0;
	
	if(!empty($_POST['private'])){ $private = $_POST['private']; }
	if(!empty($_POST['title'])){ $title = $_POST['title']; }
	
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
	
	// Update page title
	if ($pageDetails['title'] != $title) {
		if(updatePageTitle($pageId, $title)) {
			$successes[] = lang("PAGE_TITLE_UPDATED");
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
	
	if(count($errors) == 0 && count($success) == 0) {
		$successes[] = lang("NOTHING_TO_UPDATE");
	}
	
	$pageDetails = fetchPageDetails($pageId);
}

$pagePermissions = fetchPagePermissions($pageId);
$permissionData = fetchAllPermissions();

require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<ol class="breadcrumb">
		  <li><a href="admin_dashboard.php">Dashboard</a></li>
		  <li><a href="admin_pages.php">Pages</a></li>
		  <li class="active"><a href="#"><? echo $pageDetails['title']; ?></a></li>
		</ol>
		<div class='row'>
				<form name='adminPage' action='<? echo $_SERVER['PHP_SELF']; ?>?id=<? echo $pageId ?>' method='post'>
					<? echo resultBlock($errors,$successes); ?>
					<div class='col-lg-6'>
						<div class="panel panel-primary">
							<div class="panel-heading">Page Information</div>
						  <div class="panel-body">
								<div class="form-group">
									<label>Page ID</label>
								  <input type="text" class="form-control" name="id" value='<? echo $pageDetails['id']; ?>' disabled="disabled">
								</div>
								
								<div class="form-group">
									<label>Page Name</label>
								  <input type="text" class="form-control" name="name" value='<? echo $pageDetails['page']; ?>' disabled="disabled">
								</div>
								
								<div class="form-group">
									<label>Page Title</label>
								  <input type="text" class="form-control" name="title" value='<? echo $pageDetails['title']; ?>'>
								</div>
								
								<div class="form-group">
									<label><? //Display private checkbox
									if ($pageDetails['private'] == 1){
										echo "<input type='checkbox' name='private' id='private' value='Yes' checked>";
									}
									else {
										echo "<input type='checkbox' name='private' id='private' value='Yes'>";	
									} ?>
									Private</label>
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
												echo "<br><label style='font-weight: 400;'><input type='checkbox' name='removePermission[".$v1['id']."]' id='removePermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name']."</label>";
											}
										} ?>
									</div>
									
									<div class="form-group">
										<label>Add Access</label>
										<? //Display list of permission levels without access
										foreach ($permissionData as $v1) {
											if(!isset($pagePermissions[$v1['id']])){
												echo "<br><label style='font-weight: 400;'><input type='checkbox' name='addPermission[".$v1['id']."]' id='addPermission[".$v1['id']."]' value='".$v1['id']."'> ".$v1['name']."</label>";
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
	<?php 
		include("models/footer.php");
		include("models/BootstrapJavaScript.php"); 
	?>
</body>
</html>
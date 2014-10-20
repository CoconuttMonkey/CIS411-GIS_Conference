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
	$deletions = $_POST['delete'];
	if ($deletion_count = deleteUsers($deletions)){
		$successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
	}
	else {
		$errors[] = lang("SQL_ERROR");
	}
}

//List posted
if(!empty($_GET))
{
	if ($_GET['list'] == 'attendees') 
	{
		$pageTitle = "Attendees";
		$userData = fetchAllAttendees();
	}
	else if ($_GET['list'] == 'unpaid')
	{
		$pageTitle = "Unpaid Users";
		$status = 'unpaid';
		$userData = fetchAllAttendees($status);
	}
	else 
	{
		$pageTitle = "All Users";
		$userData = fetchAllUsers(); //Fetch information for all users
	}
}
 else 
{
	$pageTitle = "All Users";
	$userData = fetchAllUsers(); //Fetch information for all users
}

require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<ol class="breadcrumb">
		  <li><a href="account.php">Dashboard</a></li>
		  <li class="active"><a href="#"><? echo $pageTitle; ?></a></li>
		</ol>
		<div class='row'>
			<div class='col-lg-12'>
				<? echo resultBlock($errors,$successes); ?>
				<form name='adminUsers' action='<? $_SERVER['PHP_SELF']; ?>' method='post' class='forms'>
					<div class="panel panel-default">
			  		<div class="panel-heading"><h1><? echo $pageTitle; ?></h1></div>
			  		
						<!-- Table -->
					  <table class="table">
							<tr style='text-align: left;'>
								<th>Delete</th><th>Name</th><th>Email</th><th>Title</th><th>Active</th>
							</tr>
							
							<? //Cycle through users
						foreach ($userData as $v1) {
						?>
						<tr>
							<td><input type='checkbox' name='delete[<?php echo $v1['user_id']; ?>]' id='delete[<?php echo $v1['user_id']; ?>]' value='<?php echo $v1['user_id']; ?>'></td>
							<td class="clickableCell" href="admin_user.php?id=<? echo $v1['user_id']; ?>"><? echo $v1['first_name']." ".$v1['last_name'] ?></td>
							<td class="clickableCell" href="admin_user.php?id=<? echo $v1['user_id']; ?>"><?php echo $v1['email']; ?></td>
							<td class="clickableCell" href="admin_user.php?id=<? echo $v1['user_id']; ?>"><?php echo $v1['title']; ?></td>
							<td class="clickableCell" href="admin_user.php?id=<? echo $v1['user_id']; ?>">
								<? //Display payment status
								if ($v1['active'] == '1'){
									echo " <span class='label label-success'>Active</span>";	
								}
								else{
									echo " <span class='label label-danger'>Not Active</span>
									";
								} ?>
							</td>
						</tr> <? } ?>
							
					  </table>
					</div>
					<input type='submit' name='Submit' value='Delete' class='btn btn-danger' />
				</form>
			</div>
		</div>
	</div>
	<?php include("models/footer.php"); ?>
	<script>
	jQuery(document).ready(function($) {
		$(".clickableCell").click(function() {
			window.document.location = $(this).attr("href");
		});
	});
	</script>
</body>
</html>

<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//List posted
if(!empty($_GET))
{
	if ($_GET['list'] == 'attendees')
		$pageTitle = "Attendees";
	else if ($_GET['list'] == 'unpaid')
		$pageTitle = "Unpaid Users";
	else
		$pageTitle = "All Users";
} else {
	$pageTitle = "All Users";
}

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

$userData = fetchAllUsers(); //Fetch information for all users

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
			<div class='col-lg-10 col-md-10 col-sm-8'>
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
							<td><input type='checkbox' name='delete[<?php echo $v1['id']; ?>]' id='delete[<?php echo $v1['id']; ?>]' value='<?php echo $v1['id']; ?>'></td>
							<td class="clickableCell" href="admin_user.php?id=<? echo $v1['id']; ?>"><? echo $v1['first_name']." ".$v1['last_name'] ?></td>
							<td class="clickableCell" href="admin_user.php?id=<? echo $v1['id']; ?>"><?php echo $v1['email']; ?></td>
							<td class="clickableCell" href="admin_user.php?id=<? echo $v1['id']; ?>"><?php echo $v1['title']; ?></td>
							<td class="clickableCell" href="admin_user.php?id=<? echo $v1['id']; ?>"><? if ($v1['active'] === 1) { 
									echo '<span class="success">Paid</span>';
								} else if ($v1['paid'] === 0) { 
									echo '<span class="error">Not Paid</span>';
								} ?></td>
						</tr> <? } ?>
							
					  </table>
					</div>
					<input type='submit' name='Submit' value='Delete' class='btn btn-danger' />
				</form>
			</div>
			<aside class="col-lg-2 col-md-2 col-sm-4">
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
	jQuery(document).ready(function($) {
		$(".clickableCell").click(function() {
			window.document.location = $(this).attr("href");
		});
	});
	</script>
</body>
</html>

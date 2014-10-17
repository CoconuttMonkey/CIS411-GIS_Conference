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
	if ($_GET['list'] == 'pending')
		$pageTitle = "Pending Presentations";
	else if ($_GET['list'] == 'active')
		$pageTitle = "Scheduled Presentations";
	else
		$pageTitle = "All Presentations";
} else {
	$pageTitle = "All Presentations";
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
		  <li class="active"><a href="#">Presentations</a></li>
		</ol>
		<div class='row'>
			<div class='col-lg-12'>
				<? echo resultBlock($errors,$successes); ?>
					<div class="panel panel-default">
			  		<div class="panel-heading"><h1><? echo $pageTitle; ?></h1></div>
			
						<!-- Table -->
					  <table class="table">
							<tr style='text-align: left;'>
								<th>Title</th><th>Presenter</th><th>Track</th><th>Session</th><th>Active</th>
							</tr>
							
							<? //Cycle through users
						foreach ($userData as $v1) {
						?>
						<tr>
							<td class="clickableCell" href="admin_user.php?id=<? echo $v1['id']; ?>"><? echo $v1['first_name']; ?></td>
							<td class="clickableCell" href="admin_user.php?id=<? echo $v1['id']; ?>"><?php echo $v1['email']; ?></td>
							<td class="clickableCell" href="admin_user.php?id=<? echo $v1['id']; ?>"><?php echo $v1['last_name']; ?></td>
							<td class="clickableCell" href="admin_user.php?id=<? echo $v1['id']; ?>"><?php echo $v1['title']; ?></td>
							<td class="clickableCell" href="admin_user.php?id=<? echo $v1['id']; ?>"><? if ($v1['active'] === 1) { 
									echo '<span class="success">Scheduled</span>';
								} else if ($v1['paid'] === 0) { 
									echo '<span class="warning">Pending</span>';
								} ?></td>
						</tr> <? } ?>
							
					  </table>
					</div>
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

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

$userData = fetchAllUsers(); //Fetch information for all users

require_once("models/header.php");
?>
<body>
	<?php include("nav.php"); ?>

	<div class='container'>
		<div class='row'>
			<div class='col-80'>
				<h1>Registrants</h1>
				<? echo resultBlock($errors,$successes); ?>
				<form name='adminUsers' action='<? $_SERVER['PHP_SELF']; ?>' method='post' class='forms width-100'>
					<table class='admin width-100 table-hovered'>
						<tr style='text-align: left;'>
							<th>Delete</th><th>Name</th><th>Email</th><th>Title</th><th>Paid</th>
						</tr>
						<? //Cycle through users
						foreach ($userData as $v1) {
						?>
						<tr>
							<td><input type='checkbox' name='delete[<?php echo $v1['id']; ?>]' id='delete[<?php echo $v1['id']; ?>]' value='<?php echo $v1['id']; ?>'></td>
							<td class="clickableCell" href="admin_user.php?id=<? echo $v1['id']; ?>"><? echo $v1['first_name']." ".$v1['last_name'] ?></td>
							<td class="clickableCell" href="admin_user.php?id=<? echo $v1['id']; ?>"><?php echo $v1['email']; ?></td>
							<td class="clickableCell" href="admin_user.php?id=<? echo $v1['id']; ?>"><?php echo $v1['title']; ?></td>
							<td class="clickableCell" href="admin_user.php?id=<? echo $v1['id']; ?>"><? if ($v1['paid'] === 1) { 
									echo '<span class="success">Paid</span>';
								} else if ($v1['paid'] === 0) { 
									echo '<span class="error">Not Paid</span>';
								} ?></td>
						</tr> <? } ?>
					</table>
					<input type='submit' name='Submit' value='Delete' class='btn' />
				</form>
			</div>
			<aside class="col-20 nav">
				<? 
				if(isUserLoggedIn()) {
					include('includes/sideNav.php');
				} else {
					include('includes/loginForm.php');
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

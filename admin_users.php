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
		  <li><a href="admin_dashboard.php">Admin Dashboard</a></li>
		  <li class="active"><a href="#"><? echo $pageTitle; ?></a></li>
		</ol>
		<div class='row'>
			<div class='col-lg-12'>
				<? echo resultBlock($errors,$successes); ?>
				<form name='adminUsers' action='<? $_SERVER['PHP_SELF']; ?>' method='post' class='forms'>
					<div class="panel panel-default">
			  		<div class="panel-heading"><h1><? echo $pageTitle; ?></h1></div>
			  		
						<!-- Table -->
					  <table class="tablesorter-bootstrap">
							<thead>
								<th>User ID</th><th>First Name</th><th>Last Name</th><th>Email</th><th>Title</th><th>Active</th>
							</thead>
							<tbody>
							<? //Cycle through users
						foreach ($userData as $v1) {
						?>
						<tr class="clickableCell" href="../admin_user.php?id=<? echo $v1['user_id']; ?>">
							<td><? echo $v1['user_id']; ?></td>
							<td><? echo $v1['first_name']; ?></td>
							<td><? echo $v1['last_name']; ?></td>
							<td><?php echo $v1['email']; ?></td>
							<td><?php echo $v1['title']; ?></td>
							<td>
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
							</tbody>
					  </table>
					</div>
					<p class="text-center">
						<input id="clear-filters" type='reset' name='Submit' value='Clear Filters' class='btn btn-warning' />
					</p>
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
		
		$('.tablesorter-bootstrap').tablesorter({
			usNumberFormat : false,
			sortReset      : true,
			sortRestart    : true,
			theme : 'bootstrap',
			headerTemplate: '{content} {icon}',
			widgets    : ['zebra', 'uitheme', 'filter'],
			widgetOptions: {
	      filter_reset: '.reset',
				filter_cssFilter   : 'form-control',
	    }
		});
	});
	  $('#clear-filters').click(function(){
	    $('.tablesorter-bootstrap').trigger('filterReset');
	    return false;
		});
	</script>
</body>
</html>

<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<section class="container">
	
		<?php if ($loggedInUser->checkPermission(array(2)) || $loggedInUser->checkPermission(array(4))) { ?>
		<div class="row">
			<article class="col-80">
				<h1>Dashboard</h1>
				<section class="row">
					<div class="col-50 panel panel-primary">
						<div class="panel-body text-right">
							<h3><? echo count(fetchAllUsers())*3; ?></h3>
							Total Users
						</div>
						<a href="admin_users.php?list=all">
							<div class="panel-footer">View Users</div>
						</a>
					</div>
					<div class="col-50 panel panel-primary">
						<div class="panel-body text-right">
							<h3><? echo count(fetchAllUsers()); ?></h3>
							Total Attendees
						</div>
						<a href="admin_users.php?list=attendees">
							<div class="panel-footer">View Attendees</div>
						</a>
					</div>
				</section>
				
				<section class="row">
					<div class="col-50 panel panel-warning">
						<div class="panel-body text-right">
							<h3><? echo count(fetchAllUsers()); ?></h3>
							Pending Presentations
						</div>
						<a href="conf_presentations.php?list=pending">
							<div class="panel-footer">View Pending</div>
						</a>
					</div>
					<div class="col-50 panel panel-success">
						<div class="panel-body text-right">
							<h3><? echo count(fetchAllUsers())*4; ?></h3>
							Scheduled Presentations
						</div>
						<a href="conf_presentations.php?list=active">
							<div class="panel-footer">View Presentations</div>
						</a>
					</div>
				</section>
				
				<section class="row">
					<div class="col-50 panel panel-warning">
						<div class="panel-body text-right">
							<h3><? echo count(fetchAllUsers())*2; ?></h3>
							Pending Exhibits
						</div>
						<a href="conf_exhibits.php?list=pending">
							<div class="panel-footer">View Pending</div>
						</a>
					</div>
					<div class="col-50 panel panel-success">
						<div class="panel-body text-right">
							<h3><? echo count(fetchAllUsers())*1; ?></h3>
							Scheduled Exhibits
						</div>
						<a href="conf_exhibits.php?list=active">
							<div class="panel-footer">View Exhibits</div>
						</a>
					</div>
				</section>
				
				<section class="row">
					<div class="col-50 panel panel-warning">
						<div class="panel-body text-right">
							<h3><? echo count(fetchAllUsers())*0; ?></h3>
							Pending Sponsors
						</div>
						<a href="conf_sponsors.php?list=pending">
							<div class="panel-footer">View Pending</div>
						</a>
					</div>
					<div class="col-50 panel panel-success">
						<div class="panel-body text-right">
							<h3><? echo count(fetchAllUsers())*2; ?></h3>
							Active Sponsors
						</div>
						<a href="conf_sponsors.php?list=active">
							<div class="panel-footer">Sponsor List</div>
						</a>
					</div>
				</section>
				<? } ?>
				
			</article>
			<aside class="col-20">
				<? 
				if(isUserLoggedIn()) {
					include('models/sideNav.php');
				} else {
					include('models/loginForm.php');
				}
				?>
			</aside>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>
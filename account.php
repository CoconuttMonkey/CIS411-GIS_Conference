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
	<?php if ($loggedInUser->checkPermission(array(2)) || $loggedInUser->checkPermission(array(4))) { ?>
	<section class="container">
		<div class="row">
			<article class="col-80">
				<h1>Dashboard</h1>
				<section class="row">
					<div class="col-50">
						Total Users
					</div>
					<div class="col-50">
						Total Attendees
					</div>
				</section>
				
				<section class="row">
					<div class="col-50">
						Pending Presentations
					</div>
					<div class="col-50">
						Active Presentations
					</div>
				</section>
				
				<section class="row">
					<div class="col-50">
						Pending Exhibits
					</div>
					<div class="col-50">
						Active Exhibits
					</div>
				</section>
				
				<section class="row">
					<div class="col-50">
						Pending Sponsors
					</div>
					<div class="col-50">
						Active Sponsors
					</div>
				</section><? } ?>
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
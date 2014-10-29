<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");

?>
<style>
	.announcement-heading { font-size: 3.2em; }
</style>
<body>
	<?php include("models/main-nav.php"); ?>
	<section class="container">
		<h3>Dashboard</h3>
		<? if(!userIsAttendee($loggedInUser->user_id)) { echo '<div class="col-lg-12 text-center"><a href="../register_attendee.php" class="btn btn-lg btn-success">Register for the next conference!</a></div>'; } else { ?>
		<div class="row">
			<p>
				<a class="btn btn-warning" href="../conf_presentation.php?register">Presentation Request</a>
				<a class="btn btn-warning" href="../conf_exhibit.php?register">Exhibit Request</a>
			</p>
			<p>
				<a class="btn btn-success" href="../conf_sponsor.php?register">Sponsor Registration</a>
			</p>
		</div><!-- /.row -->
		<? } ?>
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>
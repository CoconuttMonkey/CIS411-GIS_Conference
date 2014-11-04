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
		<h1>Dashboard</h1>
			<p>
				<h4>Conference Registration</h4>
				After activation get sent to <a href="../register_attendee.php">Attendee Registration</a>
			</p>
			
			<p>
				<h4>Event Requests</h4>
				<a class="btn btn-primary" href="../register_presentation.php">Presentation Request</a>
				<a class="btn btn-primary" href="../conf_exhibit.php?register">Exhibit Request</a>
			</p>
			
			<p>
				<h4>Sponsor Request</h4>
				<a class="btn btn-primary" href="../conf_sponsor.php?register">Sponsor Registration</a>
			</p>
	</section>
	<?php 
		include("models/footer.php");
		include("models/BootstrapJavaScript.php"); 
	?>
</body>
</html>
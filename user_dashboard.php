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
				<a class="btn btn-lg btn-primary" href="../register_attendee.php">Attendee Registration</a>
				<a class="btn btn-lg btn-primary" href="../register_presentation.php">Presentation Request</a>
				<a class="btn btn-lg btn-primary" href="../register_exhibit.php">Exhibit Request</a>
				<a class="btn btn-lg btn-primary" href="../register_sponsor.php">Sponsor Registration</a>
			</p>
	</section>
	<?php 
		include("models/footer.php");
		include("models/BootstrapJavaScript.php"); 
	?>
</body>
</html>
<?php
	require_once("models/config.php");
	if (!securePage($_SERVER['PHP_SELF'])){die();}
	require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<section class="container">
		<div class="row">
			<h1>Schedule</h1>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>

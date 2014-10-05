<?php
	require_once("models/config.php");
	if (!securePage($_SERVER['PHP_SELF'])){die();}
	require_once("models/header.php");
?>
<body>
	<header class="row">
		<?php 
			include("nav.php"); 
		?>
	</header>
	<section class="container">
		<div class="row">
			<img src="models/site-templates/assets/page_under_construction.png" alt="Page Under Construction, Check back soon" style="width: 100%; margin: 100px 0 150px 0">
		</div>
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>

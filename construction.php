<?php
	require_once("models/config.php");
	if (!securePage($_SERVER['PHP_SELF'])){die();}
	require_once("models/header.php");
?>
<body>
	<?php include("nav.php"); ?>
	<section class="container">
		<div class="row">
			<div class="col-80">
				<img src="models/site-templates/assets/page_under_construction.png" alt="Page Under Construction, Check back soon" style="width: 100%; margin: 100px 0 150px 0">
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
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>

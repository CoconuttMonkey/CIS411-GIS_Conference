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
		<img src="http://fakeimg.pl/1920x480/?text=GIS Conference Banner" width="100%" alt="Header Image">
	</header>
	<section class="container">
		<div class="row">
			<article class="col-80">
				<h1>Welcome</h1>
				<? include('content/home.txt') ?>
			</article>
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

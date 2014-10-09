<?php
	require_once("models/config.php");
	if (!securePage($_SERVER['PHP_SELF'])){die();}
	require_once("models/header.php");
?>
<style>
	#banner {
		background-image: url('content/2014_banner-<? echo rand(1,7); ?>.jpg');
		background-size: cover;
		background-position: center center;
		height: 400px; 
		overflow: hidden;
		position: relative;
		border-bottom: solid 6px #fff;
	}
	.banner-title {
		position: absolute;
		font-size: 5em;
		bottom: 10px;
	}
	#banner h1, #banner h2, #banner h3 {
		color: #fff;
		text-shadow:0px 4px 9px black;
	}
	.annual {
		position: absolute;
		bottom: 90px;
	}
</style>
<body>
	<?php include("nav.php"); ?>
	<header id="banner" class="row drop-shadow">
		<div class="container">
			<h3 class="subheading text-right">Oct. 16<sup>th</sup> and 17<sup>th</sup> 2014</h3>
			<h2 class="subheading annual">9<sup>th</sup> Annual</h2>
			<h1 class="banner-title">NW PA GIS Conference</h1>
		</div>
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
	<script src="models/site-templates/js/jquery.bxslider.min.js"></script>
	<link rel="stylesheet" type="text/css" href="models/site-templates/css/jquery.bxslider.css">
</body>
</html>

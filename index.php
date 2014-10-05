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
			<article class="col-20 nav text-centered">
				<h2>Links</h2>
				<ul>
					<li><a href="https://mapsengine.google.com/map/viewer?mid=zEErqgFTcQx8.kORF4RYRO3sw" target="_blank"><img src="models/site-templates/assets/person1.svg" width="25%" alt="Accomodations"></a></li>
					<li><a href=""><img src="models/site-templates/assets/map5.svg" width="25%" alt="GIS Conference Location" style="margin-top: 40px"></a></li>
				</ul>
			</article>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>

<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");


	$year = date("Y");
	$conferenceData = fetchConferenceDetails($year);
?>
<style>
	#banner {
		background-image: url('<?= $conferenceData['banner'] ?>');
		background-size: cover;
		background-position: center center;
		height: 400px; 
		overflow: hidden;
		position: relative;
		width: 100%;
		z-index: -999;
		top: 0;
		left: 0;
		padding: 0;
		margin: -100px 0 0 0;
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
	#banner h3 {
		top: 100px;
		position: absolute;
		right: 10%;
	}
	.annual {
		position: absolute;
		bottom: 90px;
	}
</style>
<body>
	<? require_once("models/main-nav.php"); ?>
	<header id="banner" class="row drop-shadow">
		<div class="container">
			<h3 class="subheading text-right">Oct. 16<sup>th</sup> and 17<sup>th</sup> 2014</h3>
			<h2 class="subheading annual"><?= $conferenceData['tagline'] ?></h2>
			<h1 class="banner-title"><?= $conferenceData['title'] ?></h1>
		</div>
	</header>
	<section class="container">
		<div class="row">
			<article class="col-lg-12">
				<h1>Welcome</h1>
				Donec sed odio dui. Nulla vitae elit libero, a pharetra augue. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.

Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Sed posuere consectetur est at lobortis. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Cras mattis consectetur purus sit amet fermentum.

Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Vestibulum id ligula porta felis euismod semper. Maecenas sed diam eget risus varius blandit sit amet non magna. Nullam id dolor id nibh ultricies vehicula ut id elit.

Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Nulla vitae elit libero, a pharetra augue. Maecenas faucibus mollis interdum. Donec sed odio dui.
			</article>
		</div>
	</section>
	<?php 
		include("models/footer.php");
		include("models/BootstrapJavaScript.php"); 
	?>
</body>
<script>$('#navbar-home').addClass("active");</script>
</html>

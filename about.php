<?php
	require_once("models/config.php");
	if (!securePage($_SERVER['PHP_SELF'])){die();}
	require_once("models/header.php");
?>
<body>
	<header class="row">
		<img src="http://fakeimg.pl/1920x480/?text=GIS Conference" width="100%" alt="Header Image">
		<?php 
			include("nav.php"); 
		?>
	</header>
	<section class="container">
		<div class="row">
			<article class="col-50">
				<h1>About</h1>
				<p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
Cras justo odio, dapibus ac facilisis in, egestas eget quam. Curabitur blandit tempus porttitor. Nullam quis risus eget urna mollis ornare vel eu leo. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Maecenas sed diam eget risus varius blandit sit amet non magna. Sed posuere consectetur est at lobortis.
Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam quis risus eget urna mollis ornare vel eu leo. Donec ullamcorper nulla non metus auctor fringilla. Donec ullamcorper nulla non metus auctor fringilla.
Cras justo odio, dapibus ac facilisis in, egestas eget quam. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Nullam quis risus eget urna mollis ornare vel eu leo. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
			</article>
			<aside class="col-50">
				<div>
					<h2 class="text-right">Presentations</h2>
				</div>
				<ul class="blocks-3">
					<li>
						<h5>Wednesday</h5>
						Vestibulum id ligula porta felis euismod semper.
					</li>
					<li>
						<h5>Thursday</h5>
						Morbi leo risus, porta ac consectetur ac, vestibulum at eros.
					</li>
					<li>
						<h5>Friday</h5>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					</li>
				</ul>
				<div>
					<h2 class="text-right">Exhibits</h2>
				</div>
				<ul class="blocks-3">
					<li>
						<h5>Wednesday</h5>
						Vestibulum id ligula porta felis euismod semper.
					</li>
					<li>
						<h5>Thursday</h5>
						Morbi leo risus, porta ac consectetur ac, vestibulum at eros.
					</li>
					<li>
						<h5>Friday</h5>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					</li>
				</ul>
			</aside>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>

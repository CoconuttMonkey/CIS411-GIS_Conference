<?php
	require_once("models/config.php");
	if (!securePage($_SERVER['PHP_SELF'])){die();}
	require_once("models/header.php");
?>
<body>
	<?php include("nav.php"); ?>
	<section class="container">
		<div class="row">
			<article class="col-80">
				<h1>Schedule</h1>
				<ul class="blocks-3">
					<li>
						<h5>Wednesday</h5>
						<dl>
							<dt>11am</dt>
							<dd>Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</dd>
							<dt>1pm</dt>
							<dd>Donec id elit non mi porta gravida at eget metus.</dd>
						</dl>
					</li>
					<li>
						<h5>Thursday</h5>
						<dl>
							<dt>10am</dt>
							<dd>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</dd>
							<dt>12pm</dt>
							<dd>Donec ullamcorper nulla non metus auctor fringilla.</dd>
							<dt>2pm</dt>
							<dd>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</dd>
							<dt>3pm</dt>
							<dd>Donec ullamcorper nulla non metus auctor fringilla.</dd>
						</dl>
					</li>
					<li>
						<h5>Friday</h5>
						<dl>
							<dd>Nulla vitae elit libero, a pharetra augue.</dd>
							<dt>12pm</dt>
							<dd>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</dd>
							<dt>2pm</dt>
							<dd>Cras justo odio, dapibus ac facilisis in, egestas eget quam.</dd>
							<dt>3pm</dt>
							<dd>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</dd>
						</dl>
					</li>
				</ul>
			</article>
			<aside class="col-20">
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

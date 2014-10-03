<?php
	require_once("models/config.php");
	if (!securePage($_SERVER['PHP_SELF'])){die();}
	require_once("models/header.php");
?>
<body>
	<?php include("nav.php"); ?>
	<section class="container">
		<h1>Contact</h1>
		<div class="row">
			<article class="col-50">
				<form method="post" action="" class="forms">
				    <label>
				        Name
				        <input type="text" name="name" class="width-60" required />
				    </label>
				    <label>
				        Name
				        <input type="email" name="email" class="width-60" required />
				    </label>
				    <label for="message">
				        Message
				        <textarea name="message" rows="4" class="width-60" required></textarea>
				    </label>
				</form>

			</article>
			<article class="col-50">
				<h2>GOOGLE MAP HERE</h2>
			</article>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>

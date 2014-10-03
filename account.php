<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
?>
<body>
	<?php include("nav.php"); ?>
	<section class="container">
		<div class="row">
			<article class="col-50 centered">
				<h1>Welcome <? echo $loggedInUser->displayname; ?></h1>
				<p>
					This is an example secure page designed to demonstrate some of the basic features of UserCake. Just so you know, your title at the moment is <? echo $loggedInUser->title; ?>, and that can be changed in the admin panel. You registered this account on <? echo date("M d, Y", $loggedInUser->signupTimeStamp()); ?>.
				</p>
			</article>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>
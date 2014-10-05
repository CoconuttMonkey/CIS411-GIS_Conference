		
	<footer class="container">
		<div class="row">
		<div class='col-80'>
			<nav class='navbar'>
		        <ul style='padding: 0; line-height: 2em;'>
		            <li><a href='index.php'>Home</a></li>
		            <li><a href='about.php'>About</a></li>
		            <li><a href='contact.php'>Contact</a></li>
					<?
						//Links for logged in user
						if(!isUserLoggedIn()) {
					?>
					<li><a href='login.php'>Login</a></li>
					<li><a href='register.php'>Register</a></li>
					<li><a href='forgot-password.php'>Forgot Password</a></li>
					<? } 
						//Links for logged in user
						if(isUserLoggedIn()) {
					?>
					<li><a href='account.php'>Account</a></li>
					<li><a href='user_settings.php'>User Settings</a></li>
					<? } ?>
					<?php if ($emailActivation) {
					echo "<li><a href='resend-activation.php'>Resend Activation Email</a></li>";
					} ?>
				</ul>
			</nav>
		</div>
		<div class="col-20 text-centered">
			<ul class="blocks-2">
				<li><img src="models/site-templates/assets/cup_logo.png" width="100%" alt="Sponsor Image"></li>
				<li><img src="models/site-templates/assets/esri_logo.png" width="100%" alt="Sponsor Image"></li>
			</ul>
		</div>
	</div>
	</footer>
	<script>
		var currentPage = currentPage();
		$("nav ul li a").each(function(){
			if ( $(this).attr("href") == currentPage || $(this).attr("href") == '' ) {
				$(this).addClass("active");
			}
		});
		
		$( '#result' ).delay(2000).fadeOut('slow','linear');
	</script>
	<footer class="container">
		<div class="row">
			<div class='col-lg-6 col-md-6'>
				<nav>
			    <ul>
			      <li><a href='sponsor_registration.php'>Become a Sponsor</a></li>
			      <li><a href='about.php'>About</a></li>
			      <li><a href='contact.php'>Contact</a></li>
						<? if(!isUserLoggedIn()) { ?>
						<li><a href='login.php'>Login</a></li>
						<li><a href='register.php'>Register</a></li>
						<li><a href='forgot-password.php'>Forgot Password</a></li>
						<? } else { ?>
						<li><a href='user/dashboard.php'>Account</a></li>
						<li><a href='user/settings.php'>User Settings</a></li>
						<? } if ($emailActivation) {
						echo "<li><a href='resend-activation.php'>Resend Activation Email</a></li>";
						} ?>
					</ul>
				</nav>
			</div>
			<div class="col-lg-6 col-md-6 text-right">
					<a href="http://clarion.edu" target="_blank"><img src="uploads/sponsor_logo/cup_logo.png" width="15%" alt="Sponsor Image"></a>
					<a href="http://www.esri.com/" target="_blank"><img src="uploads/sponsor_logo/esri_logo.png" width="15%" alt="Sponsor Image"></a>
					<a href="http://www.mcmconsultinggrp.com/" target="_blank"><img src="uploads/sponsor_logo/mcm_logo.jpg" width="15%" alt="Sponsor Image"></a>
					<a href="http://ssmgroup.com/" target="_blank"><img src="uploads/sponsor_logo/ssm_logo.gif" width="15%" alt="Sponsor Image"></a>
			</div>
		</div>
	</footer>
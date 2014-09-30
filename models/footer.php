		
	<footer class="container">
		<div class="row">
		<div class='col-50'>
			<nav class='navbar'>
		        <ul style='padding: 0; line-height: 2em;'>
		            <li><a href='index.php'>Home</a></li>
		            <li><a href='about.php'>About</a></li>
		            <li><a href='lodging.php'>Lodging</a></li>
		            <li><a href='contact.php'>Contact</a></li>
					<li><a href='login.php'>Login</a></li>
					<li><a href='register.php'>Register</a></li>
					<li><a href='forgot-password.php'>Forgot Password</a></li>
					<?php if ($emailActivation) {
					echo "<li><a href='resend-activation.php'>Resend Activation Email</a></li>";
					} ?>
				</ul>
			</nav>
		</div>
		<div class="col-50">
			<ul class="blocks-4">
				<li><img src="http://fakeimg.pl/400x400/?text=Sponsor1" width="100%" alt="Sponsor Image"></li>
				<li><img src="http://fakeimg.pl/400x400/?text=Sponsor2" width="100%" alt="Sponsor Image"></li>
				<li><img src="http://fakeimg.pl/400x400/?text=Sponsor3" width="100%" alt="Sponsor Image"></li>
				<li><img src="http://fakeimg.pl/400x400/?text=Sponsor4" width="100%" alt="Sponsor Image"></li>
			</ul>
		</div>
	</div>
	</footer>
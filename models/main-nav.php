<header id="navigation" class="row drop-shadow">
	<div class="container">
		<nav class="navbar navbar-pills navbar-left">
			<ul>
				<li><a href="<? echo $websiteUrl; ?>"><? echo $websiteName; ?></a></li>
			</ul>
		</nav>
		<nav class="navbar navbar-pills navbar-right">
      <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="schedule.php">Schedule</a></li><? if (!isUserLoggedIn()) { ?>
          <li><a href="register.php">Register</a></li>
          <li><a href="login.php">Login</a></li><? } ?>
          <li><a href="contact.php">Contact Us</a></li>
      </ul>
	  </nav>
	</div>
</header>
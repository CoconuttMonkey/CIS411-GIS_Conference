
	<header id="navigation" class="row">
		<div class="container">
			<div class="group">
				<nav class="navbar navbar-pills navbar-left">
			        <ul>
			            <li><a href="index.php">Home</a></li>
			            <li><a href="about.php">About</a></li>
			            <li><a href="schedule.php">Schedule</a></li>
			            <li><a href="contact.php">Contact</a></li>
			        </ul>
			    </nav>
			    <nav class="navbar navbar-pills navbar-right">
<?php
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Links for logged in user
if(isUserLoggedIn()) {
	echo "
	<ul>
	<li><a href='account.php'>Account</a>
	<ul>
	<li><a href='user_settings.php'>User Settings</a></li>
	</ul>
	</li>";
	//Links for permission level 2 (default admin)
	if ($loggedInUser->checkPermission(array(2)) || $loggedInUser->checkPermission(array(4))){
	echo "
	<li><a href='#'>Conference</a>
	<ul>
	<li><a href='conference_events.php'>Events</a></li>
	<li><a href='conference_sendemail.php'>Send Mail</a></li>
	<li><a href='admin_users.php'>Registrants</a></li>
	<li><a href='conference_reports.php'>Reports</a></li>
	<li><a href='conference_settings.php'>Settings</a></li>
	</ul>
	</li>";
	}
	//Links for permission level 2 (default admin)
	if ($loggedInUser->checkPermission(array(4))){
	echo "
	<li><a href='#'>Admin</a>
	<ul>
	<li><a href='admin_configuration.php'>Site Configuration</a></li>
	<li><a href='admin_users.php'>Users</a></li>
	<li><a href='admin_permissions.php'>Permissions</a></li>
	<li><a href='admin_pages.php'>Web Pages</a></li>
	</ul>
	</li>";
	}
	echo "
	<li><a href='logout.php'>Logout</a></li></ul>";
} 
//Links for users not logged in
else {
	echo "
	<ul>
	<li><a href='login.php'>Login</a></li>
	<li><a href='register.php'>Register</a></li>
	</ul>";
}

?>

			    </nav>
			</div>
		</div>
	</header>
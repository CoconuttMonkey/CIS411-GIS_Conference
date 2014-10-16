<nav class="nav sideNav">
<?php
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Links for logged in user
if(isUserLoggedIn()) {
	echo "
	<ul class='nav nav-pills nav-stacked'>
		<li class='disabled'><a href='#'>My Account</a>
			<ul>
				<li><a href='account.php'>Dashboard</a>
				<li><a href='user_settings.php'>Account Settings</a></li>
				<li><a href='logout.php'>Logout</a></li>
			</ul>
		</li>
	</ul>";
	//Links for permission level 2 (admin) and level 4 (webmaster)
	if ($loggedInUser->checkPermission(array(2)) || $loggedInUser->checkPermission(array(4))){
	echo "
	<ul class='nav nav-pills nav-stacked'>
		<li class='disabled'><a href='#'>Conference</a>
			<ul>
				<li><a href='admin_users.php'>Registrant List</a></li>
				<li><a href='conf_presentations.php'>Presentations</a></li>
				<li><a href='conf_exhibits.php'>Exhibits</a></li>
				<li><a href='construction.php'>Sponsors</a></li>
				<li><a href='admin_conference.php'>Settings</a></li>
			</ul>
		</li>
	</ul>";
	}
	//Links for permission level 3 (secretary)
	if ($loggedInUser->checkPermission(array(3))){
	echo "
	<ul class='nav nav-pills nav-stacked'>
		<li class='disabled'><a href='#'>Admin</a></li>
		<li><a href='admin_users.php'>Attendee List</a></li>
	</ul>";
	}
	//Links for permission level 4 (web master)
	if ($loggedInUser->checkPermission(array(4))){
	echo "
	<ul class='nav nav-pills nav-stacked'>
		<li class='disabled'><a href='#'>Web Master</a>
			<ul>
				<li><a href='admin_configuration.php'>Site Settings</a></li>
				<li><a href='admin_users.php'>User List</a></li>
				<li><a href='admin_permissions.php'>Permission List</a></li>
				<li><a href='admin_pages.php'>Web Pages</a></li>
			</ul>
		</li>
	</ul>";
	}
} 
//Links for users not logged in
else {
	echo "
	<ul class='nav nav-pills nav-stacked'>
		<li class='disabled'><a href='#'>Accounts</a></li>
		<li><a href='login.php'>Login</a></li>
		<li><a href='register.php'>Register</a></li>
	</ul>";
}
?>
</nav>
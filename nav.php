		<style type="text/css">
  li ul {display: none;}
  li:hover ul {display: block; position: absolute;}
  li:hover li {float: none;}
</style>
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
	<li><a href='account.php'>Account Home</a></li>
	<li><a href='user_settings.php'>User Settings</a></li>";
	//Links for permission level 2 (default admin)
	if ($loggedInUser->checkPermission(array(2))){
	echo "
	<li><a href='admin_configuration.php'>Admin</a>
	<ul>
	<li><a href='admin_configuration.php'>Admin Configuration</a></li>
	<li><a href='admin_users.php'>Admin Users</a></li>
	<li><a href='admin_permissions.php'>Admin Permissions</a></li>
	<li><a href='admin_pages.php'>Admin Pages</a></li>
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
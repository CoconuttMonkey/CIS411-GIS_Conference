<nav class="nav sideNav">
<?//Links for logged in user
if(!isUserLoggedIn()) {
	echo "
	<ul class='nav nav-pills nav-stacked'>
		<li class='disabled'><a href='#'>Accounts</a></li>
		<li><a href='login.php'>Login</a></li>
		<li><a href='register.php'>Register</a></li>
	</ul>";
}
?>
</nav>
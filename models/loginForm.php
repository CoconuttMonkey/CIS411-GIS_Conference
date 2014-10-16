<form name='login' action='login.php' method='post' class="forms text-centered">
	<h3>Login</h3>
		<div class="input-group">
			<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
		  <input type="text" class="form-control" name="email" placeholder="Email Address" required>
		</div>
		<br>
		<div class="input-group">
			<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
		  <input type="password" class="form-control" name="password" placeholder="Password" required>
		</div>
		<br>
	<input type='submit' value='Login' class="btn btn-success" /> 
	<a href='register.php' class='small'>Register</a> | <a href='forgot-password.php' class='small'>Forgot Password</a>
</form>
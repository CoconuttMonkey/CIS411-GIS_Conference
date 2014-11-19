	<!-- Intro Content -->
	<div class="container" style="margin-top: 50px;">
		<div class="col-sm-12">
			<h2>User Login</h2>
			<p>The user login page is the primary gateway for authenticating a users login details are valid before redirecting the user to a logged in landing page.</p>
			<p>The flexi auth library offers numerous methods and features to aid authentication of users, including auto login via 'Remember me' cookies, captchas automatically activated upon repeated failed login attempts, and incremental time limit bans for users with a high number of failed login attempts.</p>
			<p>In addition to the authentication methods, the library includes functions to help users with tasks like reseting forgotten passwords, and resending account activation emails. All of these features available within the library are optional, and can be mixed and matched with each other or completely left out.</p>
		</div>
	</div>
	
	<!-- Main Content -->
	<div class="container">
		<div class="col-md-12">
		<?php if (! empty($message)) { ?>
			<div id="message">
				<?php echo $message; ?>
			</div>
		<?php } ?>
			
			<?php echo form_open(current_url(), 'class="parallel"');?>  	
				<fieldset class="col-sm-6 parallel_target">
					<legend>Registered Users</legend>
					<h2 class='form-signin-heading'>Login</h2>
					<div class="form-group">
						<label>Email Address</label>
						<input type='email' class='form-control' name='email'  required autofocus />
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type='password' class='form-control' name='password'  required/>
					</div>
					<button type='submit' class='btn btn-lg btn-primary btn-block'>Sign in</button>

						<ul>
							<li>
								<label for="identity">Email or Username:</label>
								<input type="text" id="identity" name="login_identity" value="<?php echo set_value('login_identity', 'admin@admin.com');?>" class="tooltip_parent"/>
								<span class="tooltip width_400">
									<h6>Example Users</h6>
									<p>There are 3 example users setup, login to each account using the following details.</p>
									<table>
										<thead>
											<tr>
												<th>Email</th>
												<th>Username</th>
												<th>Password</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>admin@admin.com</td>
												<td>admin</td>
												<td>password123</td>
											</tr>
											<tr>
												<td>moderator@moderator.com</td>
												<td>moderator</td>
												<td>password123</td>
											</tr>
											<tr>
												<td>public@public.com</td>
												<td>public</td>
												<td>password123</td>
											</tr>
										</tbody>
									</table>
								</span>
							</li>
							<li>
								<label for="password">Password:</label>
								<input type="password" id="password" name="login_password" value="<?php echo set_value('login_password', 'password123');?>"/>
							</li>
						<?php 
							# Below are 2 examples, the first shows how to implement 'reCaptcha' (By Google - http://www.google.com/recaptcha),
							# the second shows 'math_captcha' - a simple math question based captcha that is native to the flexi auth library. 
							# This example is setup to use reCaptcha by default, if using math_captcha, ensure the 'auth' controller and 'demo_auth_model' are updated.
						
							# reCAPTCHA Example
							# To activate reCAPTCHA, ensure the 'if' statement immediately below is uncommented and then comment out the math captcha 'if' statement further below.
			 				# You will also need to enable the recaptcha examples in 'controllers/auth.php', and 'models/demo_auth_model.php'.
							#/*
							if (isset($captcha)) 
							{ 
								echo "<li>\n";
								echo $captcha;
								echo "</li>\n";
							}
							#*/
							
							/* math_captcha Example
							# To activate math_captcha, ensure the 'if' statement immediately below is uncommented and then comment out the reCAPTCHA 'if' statement just above.
							# You will also need to enable the math_captcha examples in 'controllers/auth.php', and 'models/demo_auth_model.php'.
							if (isset($captcha))
							{
								echo "<li>\n";
								echo "<label for=\"captcha\">Captcha Question:</label>\n";
								echo $captcha.' = <input type="text" id="captcha" name="login_captcha" class="width_50"/>'."\n";
								echo "</li>\n";
							}
							#*/
						?>
							<li>
								<label for="remember_me">Remember Me:</label>
								<input type="checkbox" id="remember_me" name="remember_me" value="1" <?php echo set_checkbox('remember_me', 1); ?>/>
							</li>
							<li>
								<label for="submit">Login:</label>
								<input type="submit" name="login_user" id="submit" value="Submit" class="link_button large"/>
							</li>
							<li>
								<small>Note: On this demo, 3 failed login attempts will raise security on the account, activating a 10 second time limit ban per login attempt (20 secs after 9+ attempts), and activation of a captcha that must be completed to login.</small> 
							</li>
							<li>
								<hr/>
								<a href="<?php echo $base_url;?>auth/forgotten_password">Reset Forgotten Password</a>
							</li>
							<li>
								<a href="<?php echo $base_url;?>auth/resend_activation_token">Resend Account Activation Token</a>
							</li>
						</ul>
					</fieldset>
	
				<fieldset class="col-sm-6 r_margin parallel_target">
					<legend>New Users</legend>
					<ul>
						<li>
							New users can register for an account.
						</li>
						<li>
							<hr/>
							<a href="<?php echo $base_url;?>auth/register_account" class="link_button large">Register New Account</a>
						</li>
					</ul>
				</fieldset>
			<?php echo form_close();?>
		</div>
	</div>
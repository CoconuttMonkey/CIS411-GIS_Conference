<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<div class='row'>
			<div class='col-80'>
				<h1>Presentation</h1>
				<? echo resultBlock($errors,$successes); ?>
				<form name='adminPermission' action='<? echo $_SERVER['PHP_SELF']; ?>?id=<? echo $permissionId; ?>' method='post' class='forms'>
					
					<section class="row">
						<div class="col-50">
								<label>Title
									<input type='text' name='title' class="width-100" />
								</label>
			
								<label>Abstract
									<textarea  type='text' name='abstract' class="width-100"></textarea>
								</label>
			
								<label>Track
									<input type='text' name='track' class="width-100" />
								</label>
			
								<label>Session
									<input type='text' name='session' class="width-100" />
								</label>
			
								<label>Active
									<input type='text' name='active' class="width-100" />
								</label>
						</div>
						<div class="col-50">
								<label>Presenters
									<table>
										<tr>
											<td>Matt Ondo</td>
										</tr>
										<tr>
											<td>Dr. Ayad</td>
										</tr>
									</table>
								</label>
						</div>
					</section>
					<section class="row">
						<div class="col-50 centered text-centered">
							<input type='submit' value='Update' class='btn' />
						</div>
					</section>
					
				</form>
			</div>
			<aside class="col-20 nav">
				<? 
				if(isUserLoggedIn()) {
					include('models/sideNav.php');
				} else {
					include('models/loginForm.php');
				}
				?>
			</aside>
		</div>
	</div>
	<?php include("models/footer.php"); ?>
</body>
</html>

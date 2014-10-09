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
	<?php include("nav.php"); ?>
	<section class="container">
		<div class="row">
			<article class="col-80">
				<h1>Become a Sponsor</h1>
				<form name='login' action='<? echo $_SERVER['PHP_SELF']; ?>' method='post' enctype="multipart/form-data" class="forms width-50">
					<fieldset>
						<legend>Company Profile</legend>
						<label>Company Name
							<input type='text' name='sponsor_companyName' class="width-100" disabled="disabled" />
						</label>
						
						<label>Contact Name
							<input type='text' name='sponsor_contactName' class="width-100" required />
						</label>
						
						<label>Contact Email
							<input type='email' name='sponsor_email' class="width-100" required />
						</label>
						
						<label>Contact Phone Number
							<ul class="forms-inline-list">
						        <li>
						            <input type="text" name="phone-prefix" size="3" required />
						        </li>
						        <li>
						            <input type="text" name="phone-number-1" size="3" required />
						        </li>
						            <input type="text" name="phone-number-2" size="3" required />
						        </li>
						        <li>
						            ext: <input type="text" name="phone-ext" size="3" />
						        </li>
						    </ul>
						</label>
						
						<label>Contact Address
							<input type='text' name='conf_address1' class="width-100" placeholder="Address Line 1" style="border-bottom: 0;" required />
							<input type='text' name='conf_address2' class="width-100" placeholder="Address Line 2" style="border-bottom: 0;" required />
							<input type='text' name='conf_city' class="width-100" placeholder="City" style="border-bottom: 0;" required />
							<input type='text' name='conf_state' class="width-100" placeholder="State" style="border-bottom: 0;" required />
							<input type='text' name='conf_zip' class="width-100" placeholder="Zip Code" required />
						</label>
											
						<label>Company Logo
							<input type="file" name="sponsor_logo" id="sponsor_logo">
						</label>
						
						<label>Sponsorship Level
							<ul class="forms-list">
						        <li>
						            <input type="radio" name="sponsor_level" id="sponsor_level-1">
						            <label for="sponsor_level-1">Level 1 ($300)</label>
						        </li>
						        <li>
						            <input type="radio" name="sponsor_level" id="sponsor_level-2">
						            <label for="sponsor_level-2">Level 2 ($500)</label>
						        </li>
						        <li>
						            <input type="radio" name="sponsor_level" id="sponsor_level-3">
						            <label for="sponsor_level-3">Level 3 ($750)</label>
						        </li>
						    </ul>
						</label>
						
						<label class="text-centered">
							<input type='submit' value='Submit' class="btn width-50" />
						</label>
					</fieldset>
				</form>
			</article>
			<aside class="col-20">
				<? 
				if(isUserLoggedIn()) {
					include('includes/sideNav.php');
				} else {
					include('includes/loginForm.php');
				}
				?>
			</aside>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>
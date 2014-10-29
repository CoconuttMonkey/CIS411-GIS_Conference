<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Forms posted
if(!empty($_POST))
{
	$cfgId = array();
	$newSettings = $_POST['settings'];
	
	//Validate new site name
	if ($newSettings[1] != $websiteName) {
		$newWebsiteName = $newSettings[1];
		if(minMaxRange(1,150,$newWebsiteName))
		{
			$errors[] = lang("CONFIG_NAME_CHAR_LIMIT",array(1,150));
		}
		else if (count($errors) == 0) {
			$cfgId[] = 1;
			$cfgValue[1] = $newWebsiteName;
			$websiteName = $newWebsiteName;
		}
	}
	
	//Validate new URL
	if ($newSettings[2] != $websiteUrl) {
		$newWebsiteUrl = $newSettings[2];
		if(minMaxRange(1,150,$newWebsiteUrl))
		{
			$errors[] = lang("CONFIG_URL_CHAR_LIMIT",array(1,150));
		}
		else if (substr($newWebsiteUrl, -1) != "/"){
			$errors[] = lang("CONFIG_INVALID_URL_END");
		}
		else if (count($errors) == 0) {
			$cfgId[] = 2;
			$cfgValue[2] = $newWebsiteUrl;
			$websiteUrl = $newWebsiteUrl;
		}
	}
	
	//Validate new site email address
	if ($newSettings[3] != $emailAddress) {
		$newEmail = $newSettings[3];
		if(minMaxRange(1,150,$newEmail))
		{
			$errors[] = lang("CONFIG_EMAIL_CHAR_LIMIT",array(1,150));
		}
		elseif(!isValidEmail($newEmail))
		{
			$errors[] = lang("CONFIG_EMAIL_INVALID");
		}
		else if (count($errors) == 0) {
			$cfgId[] = 3;
			$cfgValue[3] = $newEmail;
			$emailAddress = $newEmail;
		}
	}
	
	//Validate email activation selection
	if ($newSettings[4] != $emailActivation) {
		$newActivation = $newSettings[4];
		if($newActivation != "true" AND $newActivation != "false")
		{
			$errors[] = lang("CONFIG_ACTIVATION_TRUE_FALSE");
		}
		else if (count($errors) == 0) {
			$cfgId[] = 4;
			$cfgValue[4] = $newActivation;
			$emailActivation = $newActivation;
		}
	}
	
	//Validate new email activation resend threshold
	if ($newSettings[5] != $resend_activation_threshold) {
		$newResend_activation_threshold = $newSettings[5];
		if($newResend_activation_threshold > 72 OR $newResend_activation_threshold < 0)
		{
			$errors[] = lang("CONFIG_ACTIVATION_RESEND_RANGE",array(0,72));
		}
		else if (count($errors) == 0) {
			$cfgId[] = 5;
			$cfgValue[5] = $newResend_activation_threshold;
			$resend_activation_threshold = $newResend_activation_threshold;
		}
	}
	
	//Update configuration table with new settings
	if (count($errors) == 0 AND count($cfgId) > 0) {
		updateConfig($cfgId, $cfgValue);
		$successes[] = lang("CONFIG_UPDATE_SUCCESSFUL");
	}
}

$languages = getLanguageFiles(); //Retrieve list of language files
$templates = getTemplateFiles(); //Retrieve list of template files
$permissionData = fetchAllPermissions(); //Retrieve list of all permission levels
require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<section class="container">
		<ol class="breadcrumb">
		  <li><a href="admin_dashboard.php">Admin Dashboard</a></li>
		  <li class="active"><a href="#">Site Settings</a></li>
		</ol>
		<? echo resultBlock($errors,$successes); ?>
		<div class='row'>
				<form name='adminConfiguration' action='<? echo $_SERVER['PHP_SELF']; ?>' method='post' class='forms'>
						<div class='col-lg-6 col-lg-push-3 col-md-6 col-md-push-3'>
							<div class="panel panel-primary">
								<div class="panel-heading"><h2>Site Configuration</h2></div>
							  <div class="panel-body">
									<div class="form-group">
										<label>Website Name</label>
									  <input type='text' name='settings[<? echo $settings['website_name']['id']; ?>]' value='<? echo $websiteName ?>' class="form-control" />
									</div>
									
									<div class="form-group">
										<label>Website URL</label>
									  <input type='text' name='settings[<? echo $settings['website_url']['id']; ?>]' value='<? echo $websiteUrl ?>' class="form-control" />
									</div>
									
									<div class="form-group">
										<label>Email</label>
									  <input type='text' name='settings[<? echo $settings['email']['id']; ?>]' value='<? echo $emailAddress ?>' class="form-control" />
									</div>
									
									<div class="form-group">
										<label>Activation Threshold </label>
									  <input type='text' name='settings[<? echo $settings['resend_activation_threshold']['id']; ?>]' value='<? echo $resend_activation_threshold; ?>'  class="form-control" />
									</div>
									
									<div class="form-group">
										<label>Email Activation</label>
										<select class="form-control" name='settings[<? echo $settings['activation']['id']; ?>]'>";
											<? //Display email activation options
											if ($emailActivation == "true"){
												echo "
												<option value='true' selected>True</option>
												<option value='false'>False</option>";
											}
											else {
												echo "
												<option value='true'>True</option>
												<option value='false' selected>False</option>";
											} ?>
										</select>
									</div>
									
									<input type='submit' name='Submit' value='Submit' class='btn btn-success' />
							  </div>
						  </div>
						</div>
				</form>
			</div>
		</section>
	<?php include("models/footer.php"); ?>
</body>
</html>
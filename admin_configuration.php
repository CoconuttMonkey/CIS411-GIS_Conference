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
	
	//Validate new language selection
	if ($newSettings[6] != $language) {
		$newLanguage = $newSettings[6];
		if(minMaxRange(1,150,$language))
		{
			$errors[] = lang("CONFIG_LANGUAGE_CHAR_LIMIT",array(1,150));
		}
		elseif (!file_exists($newLanguage)) {
			$errors[] = lang("CONFIG_LANGUAGE_INVALID",array($newLanguage));				
		}
		else if (count($errors) == 0) {
			$cfgId[] = 6;
			$cfgValue[6] = $newLanguage;
			$language = $newLanguage;
		}
	}
	
	//Validate new template selection
	if ($newSettings[7] != $template) {
		$newTemplate = $newSettings[7];
		if(minMaxRange(1,150,$template))
		{
			$errors[] = lang("CONFIG_TEMPLATE_CHAR_LIMIT",array(1,150));
		}
		elseif (!file_exists($newTemplate)) {
			$errors[] = lang("CONFIG_TEMPLATE_INVALID",array($newTemplate));				
		}
		else if (count($errors) == 0) {
			$cfgId[] = 7;
			$cfgValue[7] = $newTemplate;
			$template = $newTemplate;
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
		<? echo resultBlock($errors,$successes); ?>
		<div class='row'>
			<div class="col-80" syle="margin-left: 0 !important;">
				<form name='adminConfiguration' action='<? echo $_SERVER['PHP_SELF']; ?>' method='post' class='forms'>
					<h1>Site Configuration</h1>
					<label>Website Name 
						<input type='text' name='settings[<? echo $settings['website_name']['id']; ?>]' value='<? echo $websiteName ?>' class="width-30" />
					</label>
	
					<label>Website URL 
						<input type='text' name='settings[<? echo $settings['website_url']['id']; ?>]' value='<? echo $websiteUrl ?>' class="width-30" />
					</label>
	
					<label>Email 
						<input type='text' name='settings[<? echo $settings['email']['id']; ?>]' value='<? echo $emailAddress ?>' class="width-30" />
					</label>
	
					<label>Activation Threshold 
						<input type='text' name='settings[<? echo $settings['resend_activation_threshold']['id']; ?>]' value='<? echo $resend_activation_threshold; ?>' />
					</label>
	
					<label>Language 
						<select name='settings[<? echo $settings['language']['id']; ?>]'>
						<? //Display language options
						foreach ($languages as $optLang){
							if ($optLang == $language){
								echo "<option value='".$optLang."' selected>$optLang</option>";
							}
							else {
								echo "<option value='".$optLang."'>$optLang</option>";
							}
						} ?>
						</select>
					</label>
	
					<label>Email Activation 
						<select name='settings[<? echo $settings['activation']['id']; ?>]'>";
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
					</label>
							
					<label>Template
						<select name='settings[<? echo $settings['template']['id']; ?>]'>";
						<? //Display template options
						foreach ($templates as $temp){
							if ($temp == $template){
								echo "<option value='".$temp."' selected>$temp</option>";
							}
							else {
								echo "<option value='".$temp."'>$temp</option>";
							}
						} ?>
						</select>
					</label>
	
					<input type='submit' name='Submit' value='Submit' class='btn' />
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
		</section>
	<?php include("models/footer.php"); ?>
</body>
</html>
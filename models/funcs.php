<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

//Functions that do not interact with DB
//------------------------------------------------------------------------------

//Retrieve a list of all .php files in models/languages
function getLanguageFiles() {
	$directory = "models/languages/";
	$languages = glob($directory . "*.php");
	//print each file name
	return $languages;
}

//Retrieve a list of all .css files in models/site-templates 
function getTemplateFiles() {
	$directory = "models/site-templates/";
	$languages = glob($directory . "*.css");
	//print each file name
	return $languages;
}

//Retrieve a list of all .php files in root files folder
function getPageFiles() {
	$directory = "";
	$pages = glob($directory . "*.php");
	//print each file name
	foreach ($pages as $page){
		$row[$page] = $page;
	}
	return $row;
}

//Destroys a session as part of logout
function destroySession($name) {
	if(isset($_SESSION[$name]))
	{
		$_SESSION[$name] = NULL;
		unset($_SESSION[$name]);
	}
}

//Generate a unique code
function getUniqueCode($length = "") {	
	$code = md5(uniqid(rand(), true));
	if ($length != "") return substr($code, 0, $length);
	else return $code;
}

//Generate an activation key
function generateActivationToken($gen = null) {
	do
	{
		$gen = md5(uniqid(mt_rand(), false));
	}
	while(validateActivationToken($gen));
	return $gen;
}

//@ Thanks to - http://phpsec.org
function generateHash($plainText, $salt = null) {
	if ($salt === null)
	{
		$salt = substr(md5(uniqid(rand(), true)), 0, 25);
	}
	else
	{
		$salt = substr($salt, 0, 25);
	}
	
	return $salt . sha1($salt . $plainText);
}

//Checks if an email is valid
function isValidEmail($email) {
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return true;
	}
	else {
		return false;
	}
}

//Inputs language strings from selected language.
function lang($key,$markers = NULL) {
	global $lang;
	if($markers == NULL)
	{
		$str = $lang[$key];
	}
	else
	{
		//Replace any dyamic markers
		$str = $lang[$key];
		$iteration = 1;
		foreach($markers as $marker)
		{
			$str = str_replace("%m".$iteration."%",$marker,$str);
			$iteration++;
		}
	}
	//Ensure we have something to return
	if($str == "")
	{
		return ("No language key found");
	}
	else
	{
		return $str;
	}
}

//Checks if a string is within a min and max length
function minMaxRange($min, $max, $what) {
	if(strlen(trim($what)) < $min)
		return true;
	else if(strlen(trim($what)) > $max)
		return true;
	else
	return false;
}

//Replaces hooks with specified text
function replaceDefaultHook($str) {
	global $default_hooks,$default_replace;	
	return (str_replace($default_hooks,$default_replace,$str));
}

//Displays error and success messages
function resultBlock($errors,$successes) {
	//Error block
	if(count($errors) > 0)
	{
		echo "<div id='result' class='col-lg-8 col-lg-push-2' style='pading: 50px;'><div class='alert alert-danger'>
		<span class='btn btn-sm btn-danger glyphicon glyphicon-remove' style='float: right;' onclick=\"showHide('result');\"></span>
		<ul style='padding-top:20px;'>";
		foreach($errors as $error)
		{
			echo "<li>".$error."</li>";
		}
		echo "</ul>";
		echo "</div></div>";
	}
	//Success block
	if(count($successes) > 0)
	{
		echo "<div id='result' class='col-lg-8 col-lg-push-2' style='pading: 50px;'><div class='alert alert-success'>
		<span class='btn btn-sm btn-danger glyphicon glyphicon-remove' style='float: right;'  onclick=\"showHide('result');\"></span>
		<ul style='padding-top:20px;'>";
		foreach($successes as $success)
		{
			echo "<li>".$success."</li>";
		}
		echo "</ul>";
		echo "</div></div>";
	}
}

//Completely sanitizes text
function sanitize($str) {
	return strtolower(strip_tags(trim(($str))));
}

//Functions that interact mainly with .users table
//------------------------------------------------------------------------------

//Delete a defined array of users
function deleteUsers($users) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."users 
		WHERE id = ?");
	$stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 
		WHERE user_id = ?");
	foreach($users as $id){
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt2->bind_param("i", $id);
		$stmt2->execute();
		$i++;
	}
	$stmt->close();
	$stmt2->close();
	return $i;
}

//Check if a display name exists in the DB
function presentationExists($title) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT *
		FROM presentation
		WHERE
		title = ?
		LIMIT 1");
	$stmt->bind_param("s", $title);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Check if an email exists in the DB
function emailExists($email) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT active
		FROM ".$db_table_prefix."users
		WHERE
		email = ?
		LIMIT 1");
	$stmt->bind_param("s", $email);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Retrieve information for all users
function fetchAllUsers() {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id as user_id,
		password,
		email,
		activation_token,
		last_activation_request,
		lost_password_request,
		active,
		title,
		sign_up_stamp,
		last_sign_in_stamp
		FROM ".$db_table_prefix."users");
	$stmt->execute();
	$stmt->bind_result($id, $password, $email, $token, $activationRequest, $passwordRequest, $active, $title, $signUp, $signIn);
	
	while ($stmt->fetch()){
		$row[] = array('user_id' => $id, 'password' => $password, 'email' => $email, 'activation_token' => $token, 'last_activation_request' => $activationRequest, 'lost_password_request' => $passwordRequest, 'active' => $active, 'title' => $title, 'sign_up_stamp' => $signUp, 'last_sign_in_stamp' => $signIn);
	}
	$stmt->close();
	return ($row);
}

//Retrieve complete user information by username, token or ID
function fetchUserDetails($email=NULL,$username=NULL,$token=NULL, $id=NULL) {
	if($email!=NULL) {
		$column = "email";
		$data = $email;
	} 
	elseif($username!=NULL) {
		$column = "user_name";
		$data = $username;
	}
	elseif($token!=NULL) {
		$column = "activation_token";
		$data = $token;
	}
	elseif($id!=NULL) {
		$column = "id";
		$data = $id;
	}
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		password,
		email,
		activation_token,
		last_activation_request,
		lost_password_request,
		active,
		title,
		sign_up_stamp,
		last_sign_in_stamp
		FROM users
		WHERE
		$column = ?
		LIMIT 1");
		$stmt->bind_param("s", $data);
	
	$stmt->execute();
	$stmt->bind_result($id, $password, $email, $token, $activationRequest, $passwordRequest, $active, $title, $signUp, $signIn);
	while ($stmt->fetch()){
		$row = array('id' => $id, 'password' => $password, 'email' => $email, 'activation_token' => $token, 'last_activation_request' => $activationRequest, 'lost_password_request' => $passwordRequest, 'active' => $active, 'title' => $title, 'sign_up_stamp' => $signUp, 'last_sign_in_stamp' => $signIn);
	}
	$stmt->close();
	return ($row);
}

//Toggle if lost password request flag on or off
function flagLostPasswordRequest($username,$value) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET lost_password_request = ?
		WHERE
		user_name = ?
		LIMIT 1
		");
	$stmt->bind_param("ss", $value, $username);
	$result = $stmt->execute();
	$stmt->close();
	return $result;
}

//Check if a user is logged in
function isUserLoggedIn() {
	global $loggedInUser,$mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT 
		id,
		password
		FROM ".$db_table_prefix."users
		WHERE
		id = ?
		AND 
		password = ? 
		AND
		active = 1
		LIMIT 1");
	$stmt->bind_param("is", $loggedInUser->user_id, $loggedInUser->hash_pw);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if($loggedInUser == NULL)
	{
		return false;
	}
	else
	{
		if ($num_returns > 0)
		{
			return true;
		}
		else
		{
			destroySession("userCakeUser");
			return false;	
		}
	}
}

//Change a user from inactive to active
function setUserActive($token) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET active = 1
		WHERE
		activation_token = ?
		LIMIT 1");
	$stmt->bind_param("s", $token);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Update a user's email
function updateEmail($id, $email) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET 
		email = ?
		WHERE
		id = ?");
	$stmt->bind_param("si", $email, $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Input new activation token, and update the time of the most recent activation request
function updateLastActivationRequest($new_activation_token,$username,$email) {
	global $mysqli,$db_table_prefix; 	
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET activation_token = ?,
		last_activation_request = ?
		WHERE email = ?
		AND
		user_name = ?");
	$stmt->bind_param("ssss", $new_activation_token, time(), $email, $username);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Generate a random password, and new token
function updatePasswordFromToken($pass,$token) {
	global $mysqli,$db_table_prefix;
	$new_activation_token = generateActivationToken();
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET password = ?,
		activation_token = ?
		WHERE
		activation_token = ?");
	$stmt->bind_param("sss", $pass, $new_activation_token, $token);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Update a user's title
function updateTitle($id, $title) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
		SET 
		title = ?
		WHERE
		id = ?");
	$stmt->bind_param("si", $title, $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

//Check if a user ID exists in the DB
function userIdExists($id) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT active
		FROM ".$db_table_prefix."users
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Check if activation token exists in DB
function validateActivationToken($token,$lostpass=NULL) {
	global $mysqli,$db_table_prefix;
	if($lostpass == NULL) 
	{	
		$stmt = $mysqli->prepare("SELECT active
			FROM ".$db_table_prefix."users
			WHERE active = 0
			AND
			activation_token = ?
			LIMIT 1");
	}
	else 
	{
		$stmt = $mysqli->prepare("SELECT active
			FROM ".$db_table_prefix."users
			WHERE active = 1
			AND
			activation_token = ?
			AND
			lost_password_request = 1 
			LIMIT 1");
	}
	$stmt->bind_param("s", $token);
	$stmt->execute();
	$stmt->store_result();
		$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Functions that interact mainly with .permissions table
//------------------------------------------------------------------------------

//Create a permission level in DB
function createPermission($permission) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."permissions (
		name
		)
		VALUES (
		?
		)");
	$stmt->bind_param("s", $permission);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;
}

//Delete a permission level from the DB
function deletePermission($permission) {
	global $mysqli,$db_table_prefix,$errors; 
	$i = 0;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permissions 
		WHERE id = ?");
	$stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 
		WHERE permission_id = ?");
	$stmt3 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 
		WHERE permission_id = ?");
	foreach($permission as $id){
		if ($id == 1){
			$errors[] = lang("CANNOT_DELETE_NEWUSERS");
		}
		elseif ($id == 2){
			$errors[] = lang("CANNOT_DELETE_ADMIN");
		}
		else{
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$stmt2->bind_param("i", $id);
			$stmt2->execute();
			$stmt3->bind_param("i", $id);
			$stmt3->execute();
			$i++;
		}
	}
	$stmt->close();
	$stmt2->close();
	$stmt3->close();
	return $i;
}

//Retrieve information for all permission levels
function fetchAllPermissions() {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		name
		FROM ".$db_table_prefix."permissions");
	$stmt->execute();
	$stmt->bind_result($id, $name);
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'name' => $name);
	}
	$stmt->close();
	return ($row);
}

//Retrieve information for a single permission level
function fetchPermissionDetails($id) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		name
		FROM ".$db_table_prefix."permissions
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->bind_result($id, $name);
	while ($stmt->fetch()){
		$row = array('id' => $id, 'name' => $name);
	}
	$stmt->close();
	return ($row);
}

//Check if a permission level ID exists in the DB
function permissionIdExists($id) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT id
		FROM ".$db_table_prefix."permissions
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Check if a permission level name exists in the DB
function permissionNameExists($permission) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT id
		FROM ".$db_table_prefix."permissions
		WHERE
		name = ?
		LIMIT 1");
	$stmt->bind_param("s", $permission);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Change a permission level's name
function updatePermissionName($id, $name) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."permissions
		SET name = ?
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("si", $name, $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

//Functions that interact mainly with .user_permission_matches table
//------------------------------------------------------------------------------

//Match permission level(s) with user(s)
function addPermission($permission, $user) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."user_permission_matches (
		permission_id,
		user_id
		)
		VALUES (
		?,
		?
		)");
	if (is_array($permission)){
		foreach($permission as $id){
			$stmt->bind_param("ii", $id, $user);
			$stmt->execute();
			$i++;
		}
	}
	elseif (is_array($user)){
		foreach($user as $id){
			$stmt->bind_param("ii", $permission, $id);
			$stmt->execute();
			$i++;
		}
	}
	else {
		$stmt->bind_param("ii", $permission, $user);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}

//Retrieve information for all user/permission level matches
function fetchAllMatches() {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		user_id,
		permission_id
		FROM ".$db_table_prefix."user_permission_matches");
	$stmt->execute();
	$stmt->bind_result($id, $user, $permission);
	while ($stmt->fetch()){
		$row[] = array('id' => $id, 'user_id' => $user, 'permission_id' => $permission);
	}
	$stmt->close();
	return ($row);	
}

//Retrieve list of permission levels a user has
function fetchUserPermissions($user_id) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT
		id,
		permission_id
		FROM ".$db_table_prefix."user_permission_matches
		WHERE user_id = ?
		");
	$stmt->bind_param("i", $user_id);	
	$stmt->execute();
	$stmt->bind_result($id, $permission);
	while ($stmt->fetch()){
		$row[$permission] = array('id' => $id, 'permission_id' => $permission);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Retrieve list of users who have a permission level
function fetchPermissionUsers($permission_id) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT id, user_id
		FROM ".$db_table_prefix."user_permission_matches
		WHERE permission_id = ?
		");
	$stmt->bind_param("i", $permission_id);	
	$stmt->execute();
	$stmt->bind_result($id, $user);
	while ($stmt->fetch()){
		$row[$user] = array('id' => $id, 'user_id' => $user);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Unmatch permission level(s) from user(s)
function removePermission($permission, $user) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches 
		WHERE permission_id = ?
		AND user_id =?");
	if (is_array($permission)){
		foreach($permission as $id){
			$stmt->bind_param("ii", $id, $user);
			$stmt->execute();
			$i++;
		}
	}
	elseif (is_array($user)){
		foreach($user as $id){
			$stmt->bind_param("ii", $permission, $id);
			$stmt->execute();
			$i++;
		}
	}
	else {
		$stmt->bind_param("ii", $permission, $user);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}

//Functions that interact mainly with .configuration table
//------------------------------------------------------------------------------

//Update configuration table
function updateConfig($id, $value) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."configuration
		SET 
		value = ?
		WHERE
		id = ?");
	foreach ($id as $cfg){
		$stmt->bind_param("si", $value[$cfg], $cfg);
		$stmt->execute();
	}
	$stmt->close();	
}

//Functions that interact mainly with .pages table
//------------------------------------------------------------------------------

//Add a page to the DB
function createPages($pages) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."pages (
		page
		)
		VALUES (
		?
		)");
	foreach($pages as $page){
		$stmt->bind_param("s", $page);
		$stmt->execute();
	}
	$stmt->close();
}

//Update a Page Title

function updatePageTitle($id, $title) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE pages
		SET 
		title = ?
		WHERE
		id = ?");
	$stmt->bind_param("si", $title, $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

//Delete a page from the DB
function deletePages($pages) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."pages 
		WHERE id = ?");
	$stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 
		WHERE page_id = ?");
	foreach($pages as $id){
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt2->bind_param("i", $id);
		$stmt2->execute();
	}
	$stmt->close();
	$stmt2->close();
}

//Fetch information on all pages
function fetchAllPages() {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		page,
		private
		FROM ".$db_table_prefix."pages");
	$stmt->execute();
	$stmt->bind_result($id, $page, $private);
	while ($stmt->fetch()){
		$row[$page] = array('id' => $id, 'page' => $page, 'private' => $private);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Fetch information for a specific page
function fetchPageDetails($id) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT 
		id,
		page,
		title,
		private
		FROM pages
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$stmt->bind_result($id, $page, $title, $private);
	while ($stmt->fetch()){
		$row = array('id' => $id, 'page' => $page, 'title' => $title, 'private' => $private);
	}
	$stmt->close();
	return ($row);
}

//Check if a page ID exists
function pageIdExists($id) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("SELECT private
		FROM ".$db_table_prefix."pages
		WHERE
		id = ?
		LIMIT 1");
	$stmt->bind_param("i", $id);	
	$stmt->execute();
	$stmt->store_result();	
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Toggle private/public setting of a page
function updatePrivate($id, $private) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."pages
		SET 
		private = ?
		WHERE
		id = ?");
	$stmt->bind_param("ii", $private, $id);
	$result = $stmt->execute();
	$stmt->close();	
	return $result;	
}

//Functions that interact mainly with .permission_page_matches table
//------------------------------------------------------------------------------

//Match permission level(s) with page(s)
function addPage($page, $permission) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."permission_page_matches (
		permission_id,
		page_id
		)
		VALUES (
		?,
		?
		)");
	if (is_array($permission)){
		foreach($permission as $id){
			$stmt->bind_param("ii", $id, $page);
			$stmt->execute();
			$i++;
		}
	}
	elseif (is_array($page)){
		foreach($page as $id){
			$stmt->bind_param("ii", $permission, $id);
			$stmt->execute();
			$i++;
		}
	}
	else {
		$stmt->bind_param("ii", $permission, $page);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}

//Retrieve list of permission levels that can access a page
function fetchPagePermissions($page_id) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT
		id,
		permission_id
		FROM ".$db_table_prefix."permission_page_matches
		WHERE page_id = ?
		");
	$stmt->bind_param("i", $page_id);	
	$stmt->execute();
	$stmt->bind_result($id, $permission);
	while ($stmt->fetch()){
		$row[$permission] = array('id' => $id, 'permission_id' => $permission);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Retrieve list of pages that a permission level can access
function fetchPermissionPages($permission_id) {
	global $mysqli,$db_table_prefix; 
	$stmt = $mysqli->prepare("SELECT
		id,
		page_id
		FROM ".$db_table_prefix."permission_page_matches
		WHERE permission_id = ?
		");
	$stmt->bind_param("i", $permission_id);	
	$stmt->execute();
	$stmt->bind_result($id, $page);
	while ($stmt->fetch()){
		$row[$page] = array('id' => $id, 'permission_id' => $page);
	}
	$stmt->close();
	if (isset($row)){
		return ($row);
	}
}

//Unmatched permission and page
function removePage($page, $permission) {
	global $mysqli,$db_table_prefix; 
	$i = 0;
	$stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches 
		WHERE page_id = ?
		AND permission_id =?");
	if (is_array($page)){
		foreach($page as $id){
			$stmt->bind_param("ii", $id, $permission);
			$stmt->execute();
			$i++;
		}
	}
	elseif (is_array($permission)){
		foreach($permission as $id){
			$stmt->bind_param("ii", $page, $id);
			$stmt->execute();
			$i++;
		}
	}
	else {
		$stmt->bind_param("ii", $permission, $user);
		$stmt->execute();
		$i++;
	}
	$stmt->close();
	return $i;
}

//Check if a user has access to a page
function securePage($uri) {
	
	//Separate document name from uri
	$tokens = explode('/', $uri);
	$page = $tokens[sizeof($tokens)-1];
	global $mysqli,$db_table_prefix,$loggedInUser;
	//retrieve page details
	$stmt = $mysqli->prepare("SELECT 
		id,
		page,
		private
		FROM ".$db_table_prefix."pages
		WHERE
		page = ?
		LIMIT 1");
	$stmt->bind_param("s", $page);
	$stmt->execute();
	$stmt->bind_result($id, $page, $private);
	while ($stmt->fetch()){
		$pageDetails = array('id' => $id, 'page' => $page, 'private' => $private);
	}
	$stmt->close();
	//If page does not exist in DB, allow access
	if (empty($pageDetails)){
		return true;
	}
	//If page is public, allow access
	elseif ($pageDetails['private'] == 0) {
		return true;	
	}
	//If user is not logged in, deny access
	elseif(!isUserLoggedIn()) 
	{
		header("Location: login.php");
		return false;
	}
	else {
		//Retrieve list of permission levels with access to page
		$stmt = $mysqli->prepare("SELECT
			permission_id
			FROM ".$db_table_prefix."permission_page_matches
			WHERE page_id = ?
			");
		$stmt->bind_param("i", $pageDetails['id']);	
		$stmt->execute();
		$stmt->bind_result($permission);
		while ($stmt->fetch()){
			$pagePermissions[] = $permission;
		}
		$stmt->close();
		//Check if user's permission levels allow access to page
		if ($loggedInUser->checkPermission($pagePermissions)){ 
			return true;
		}
		//Grant access if master user
		elseif ($loggedInUser->user_id == $master_account){
			return true;
		}
		else {
			header("Location: account.php");
			return false;	
		}
	}
}

// Returns page title
function pageTitle($uri) {
	//Separate document name from uri
	$tokens = explode('/', $uri);
	$page = $tokens[sizeof($tokens)-1];
	global $mysqli,$loggedInUser;
	//retrieve page details
	$stmt = $mysqli->prepare("SELECT 
		id,
		page,
		title,
		private
		FROM pages
		WHERE
		page = ?
		LIMIT 1");
	$stmt->bind_param("s", $page);
	$stmt->execute();
	$stmt->bind_result($id, $page, $title, $private);
	while ($stmt->fetch()){
		$pageDetails = array('id' => $id, 'page' => $page, 'title' => $title, 'private' => $private);
	}
	$stmt->close();
	
	return $pageDetails['title'];
}

//Retrieve information for all conferences
function fetchAllConferences() {
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
			conference_id,
			title,
			tagline,
			start_date,
			end_date,
			reg_open_date,
			reg_close_date
	FROM conference");
	$stmt->execute();
	$stmt->bind_result($conference_id, $title, $tagline, $start_date, $end_date, $reg_open_date, $reg_close_date);
	
	while ($stmt->fetch()){
		$row[] = array('conference_id' => $conference_id, 'title' => $title, 'tagline' => $tagline, 'start_date' => $start_date, 'end_date' => $end_date, 'reg_open_date' => $reg_open_date, 'reg_close_date' => $reg_close_date);
	}
	$stmt->close();
	return ($row);
}

//Retrieve information for all conferences
function fetchConferenceDetails($year) {
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
			conference_id,
			title,
			tagline,
			start_date,
			end_date,
			reg_open_date,
			reg_close_date,
			banner,
			schedule
	FROM conference WHERE conference_id = $year;");
	$stmt->execute();
	$stmt->bind_result($conference_id, $title, $tagline, $start_date, $end_date, $reg_open_date, $reg_close_date, $banner, $schedule);
	
	while ($stmt->fetch()){
		$row = array('conference_id' => $conference_id, 'title' => $title, 'tagline' => $tagline, 'start_date' => $start_date, 'end_date' => $end_date, 'reg_open_date' => $reg_open_date, 'reg_close_date' => $reg_close_date, 'banner' => $banner, 'schedule' => $schedule);
	}
	$stmt->close();
	return ($row);
}

function addPresentation($main_presenter_id, $main_presenter_bio, $title, $abstract, $track, $day_request) {
	$year = date("Y");
	
	global $mysqli;
	
	//Insert the user into the database providing no errors have been found.
	$stmt = $mysqli->prepare("INSERT INTO presentation (
		conference_id,
		title,
		abstract,
		track_id,
		week_day
		)
		VALUES (
		?,
		?,
		?,
		?,
		?
		)");
	
	$stmt->bind_param("issis", $year, $title, $abstract, $track, $day_request);
	$stmt->execute();
	$inserted_id = $mysqli->insert_id;
	$stmt->close();
	
	//Insert default permission into matches table
	$stmt = $mysqli->prepare("INSERT INTO presenter  (
		attendee_user_id,
		presentation_id,
		main,
		biography
		)
		VALUES (
		?,
		?,
		'1',
		?
		)");
	$stmt->bind_param("iis", $main_presenter_id, $inserted_id, $main_presenter_bio);
	$stmt->execute();
	$stmt->close();
	
	updateTitle($main_presenter_id, 'Presenter');
	
	return true;
}

//Retrieve information for all presentations
function fetchAllPresentations($filter = NULL) {
	
	if ($filter != NULL) {
		if ($filter == 'pending') { 
			$filter = " WHERE presentation.active IS NULL";
		}
		
		if ($filter == 'scheduled') { 
			$filter = " WHERE presentation.active IS NOT NULL";
		}
	} else { $filter = ""; }
	
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
			presentation.presentation_id, 
			presentation.conference_id, 
	 		presentation.title,
			track.full_name AS track_name,
			presentation.active,
			presentation.week_day,
			CONCAT (attendee.f_name, ' ', attendee.l_name) AS presenter_name
			FROM presentation
	INNER JOIN `presenter` ON presentation.presentation_id = presenter.presentation_id
						 					  AND presenter.main = 1
 	INNER JOIN `track` 	 	 ON presentation.track_id = track.track_id
 	INNER JOIN `attendee`  ON presenter.attendee_user_id = attendee.user_id 
 	{$filter};");
	$stmt->execute();
	$stmt->bind_result($presentation_id, $conference_id, $title, $track, $active, $week_day, $presenter_name);
	
	while ($stmt->fetch()){
		$row[] = array('presentation_id' => $presentation_id, 'conference_id' => $conference_id, 'title' => $title, 'track_name' => $track, 'active' => $active, 'week_day' => $week_day, 'presenter_name' => $presenter_name);
	}
	$stmt->close();
	return ($row);
}

//Retrieve a list of all .php files in models/languages
function fetchTracks($conference_id) {
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
			track_id,
			full_name
	FROM track WHERE conference_id = {$conference_id}");
	$stmt->execute();
	$stmt->bind_result($track_id, $track_title);
	
	while ($stmt->fetch()){
		$row[] = array('track_id' => $track_id, 'full_name' => $track_title);
	}
	$stmt->close();
	return ($row);
}

//Checks if a username exists in the DB
function userIsAttendee($user_id) {
	global $mysqli;
	$stmt = $mysqli->prepare("SELECT *
		FROM attendee
		WHERE
		user_id = ?
		LIMIT 1");
	$stmt->bind_param("i", $user_id);	
	$stmt->execute();
	$stmt->store_result();
	$num_returns = $stmt->num_rows;
	$stmt->close();
	
	if ($num_returns > 0)
	{
		return true;
	}
	else
	{
		return false;	
	}
}

//Retrieve information for all attendees
function fetchAllAttendees() {
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
			attendee.user_id, 
			users.email,
			users.active,
			users.title,
			users.sign_up_stamp,
	 		attendee.f_name,
	 		attendee.l_name,
			attendee.address_1, 
			attendee.address_2, 
			attendee.city, 
			attendee.state, 
			attendee.postal_code,
			attendee.country,
			attendee.phone,
			attendee.company
			FROM attendee
	INNER JOIN `users` on attendee.user_id = users.id;");
	$stmt->execute();
	$stmt->bind_result($user_id, $email, $active, $title, $signUp, $f_name, $l_name, $address_1, $address_2, $city, $state, $postal_code, $country, $phone, $company);
	
	while ($stmt->fetch()){
		$row[] = array('user_id' => $user_id, 'email' => $email, 'active' => $active, 'title' => $title, 'sign_up_stamp' => $signUp, 'f_name' => $f_name, 'l_name' => $l_name, 'address_1' => $address_1, 'address_2' => $address_2, 'city' => $city, 'state' => $state, 'postal_code' => $postal_code, 'country' => $country, 'phone' => $phone, 'company' => $company);
	}
	$stmt->close();
	return ($row);
}

//Retrieve information for a single attendee
function fetchAttendeeDetails($user_id) {
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
			attendee.user_id, 
			users.email,
			users.active,
			users.title,
			users.sign_up_stamp,
	 		attendee.f_name,
	 		attendee.l_name,
			attendee.address_1, 
			attendee.address_2, 
			attendee.city, 
			attendee.state, 
			attendee.postal_code,
			attendee.country,
			attendee.phone,
			attendee.company
			FROM attendee
	INNER JOIN `users` ON attendee.user_id = {$user_id} AND users.id = {$user_id}");
	$stmt->execute();
	$stmt->bind_result($user_id, $email, $active, $title, $signUp, $f_name, $l_name, $address_1, $address_2, $city, $state, $zip, $country, $phone, $company);
	
	while ($stmt->fetch()){
		$row = array('user_id' => $user_id, 'email' => $email,'active' => $active, 'title' => $title, 'sign_up_stamp' => $signUp, 'f_name' => $f_name, 'l_name' => $l_name, 'address_1' => $address_1, 'address_2' => $address_2, 'city' => $city, 'state' => $state, 'postal_code' => $zip, 'country' => $country, 'phone' => $phone, 'company' => $company);
	}
	$stmt->close();
	return ($row);
}

//Update attendee field
function updateAttendeeDetail($user_id, $field, $value) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE attendee
		SET `{$field}` = '{$value}'
		WHERE
		user_id = {$user_id}");
	$result = $stmt->execute();
	$stmt->close();
}

//Retrieve information for all presentations
function fetchPresentationDetails($presentationId) {
	
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
			presentation.presentation_id, 
			presentation.conference_id, 
	 		presentation.title,
	 		presentation.abstract,
			presentation.track_id,
			presentation.active,
			presentation.presentation_attachment,
			presentation.week_day,
			presentation.start_time,
			presentation.end_time,
			presentation.room_id,
			presenter.attendee_user_id,
			presenter.biography,
			CONCAT (attendee.f_name, ' ', attendee.l_name) AS main_presenter_name
			FROM presentation
	INNER JOIN `presenter` ON presentation.presentation_id = presenter.presentation_id
						 	AND presenter.main = 1
 	INNER JOIN `track` 	 ON presentation.track_id = track.track_id
 	INNER JOIN `attendee`  ON presenter.attendee_user_id = attendee.user_id
 	WHERE presentation.presentation_id = {$presentationId}");
	$stmt->execute();
	$stmt->bind_result($presentation_id,
										 $conference_id,
										 $presentation_title,
										 $presentation_abstract,
										 $track_id,
										 $active,
										 $presentation_attachment,
										 $week_day,
										 $start_time,
										 $end_time,
										 $room_id,
										 $main_presenter_id,
										 $biography,
										 $main_presenter_name);
	
	while ($stmt->fetch()){
		$row = array('presentation_id' => $presentation_id, 'conference_id' => $conference_id, 'title' => $presentation_title,  'abstract' => $presentation_abstract, 'track_id' => $track_id, 'active' => $active, 'presentation_attachment' => $presentation_attachment, 'week_day' => $week_day, 'start_time' => $start_time, 'end_time' => $end_time, 'room_id' => $room_id, 'attendee_user_id' => $main_presenter_id, 'biography' => $biography, 'main_presenter_name' => $main_presenter_name);
	}
	$stmt->close();
	return ($row);
}

//Update presentation details
function updatePresentationDetail($presentationId, $field, $value) {
	global $mysqli;
	$stmt = $mysqli->prepare("UPDATE presentation
		SET `{$field}` = '{$value}'
		WHERE
		presentation_id = {$presentationId}");
	$result = $stmt->execute();
	$stmt->close();
}

function newSponsor($conference_id,$main_contact,$company_name,$company_address,$logo,$website_url,$sponsor_lvl) {
	global $mysqli;
	
	//Insert the user into the database providing no errors have been found.
	$stmt = $mysqli->prepare("INSERT INTO sponsor (
		main_contact,
		company_name,
		company_address,
		logo,
		url,
		sponsor_lvl
		)
		VALUES (
		?,
		?,
		?,
		?,
		?,
		?
		)");
	
	$stmt->bind_param("issssi", $main_contact, $company_name, $company_address, $logo, $website_url, $sponsor_lvl);
	$stmt->execute();
	$inserted_id = $mysqli->insert_id;
	$stmt->close();
	
	//Insert default permission into matches table
	$stmt = $mysqli->prepare("INSERT INTO sponsor_conference_lookup  (
		sponsor_id,
		conference_id
		)
		VALUES (
		?,
		?
		)");
	$stmt->bind_param("ii", $inserted_id, $conference_id);
	$stmt->execute();
	$stmt->close();
	
	updateTitle($main_contact, 'Sponsor');
	
	return true;
}

function fetchAllSponsors($filter = NULL) {
	
	if ($filter != NULL) {
		if ($filter == 'pending') { 
			$filter = " WHERE sponsor.paid IS NULL";
		}
		
		if ($filter == 'active') { 
			$filter = " WHERE sponsor.paid IS NOT NULL";
		}
	} else { $filter = ""; }
	
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
			sponsor.sponsor_id, 
			sponsor.company_name, 
	 		sponsor.paid,
	 		sponsor.sponsor_lvl,
			CONCAT (attendee.f_name, ' ', attendee.l_name) AS main_contact
			FROM sponsor
 	INNER JOIN `attendee`  ON sponsor.main_contact = attendee.user_id
 	$filter;");
	$stmt->execute();
	$stmt->bind_result($sponsor_id, $company_name, $paid, $sponsor_lvl, $main_contact);
	
	while ($stmt->fetch()){
		$row[] = array('sponsor_id' => $sponsor_id, 'company_name' => $company_name, 'paid' => $paid, 'sponsor_lvl' => $sponsor_lvl, 'main_contact' => $main_contact);
	}
	$stmt->close();
	return ($row);
}

function fetchSponsorDetails($sponsorId) {
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
			sponsor.sponsor_id, 
			sponsor.company_name, 
			sponsor.company_address, 
			sponsor.logo, 
			sponsor.url, 
	 		sponsor.paid,
	 		sponsor.sponsor_lvl,
	 		attendee.user_id,
			CONCAT (attendee.f_name, ' ', attendee.l_name) AS main_contact_name
			FROM sponsor
 	INNER JOIN `attendee`  ON sponsor.main_contact = attendee.user_id
 	WHERE sponsor.sponsor_id = $sponsorId;");
	$stmt->execute();
	$stmt->bind_result($sponsor_id, $company_name, $company_address, $logo, $url, $paid, $sponsor_lvl, $main_contact_id, $main_contact_name);
	
	while ($stmt->fetch()) {
		$row = array('sponsor_id' => $sponsor_id, 'company_name' => $company_name, 'company_address' => $company_address, 'logo' => $logo, 'url' => $url, 'paid' => $paid, 'sponsor_lvl' => $sponsor_lvl, 'user_id' => $main_contact_id, 'main_contact_name' => $main_contact_name);
	}
	$stmt->close();
	return ($row);
}

function updateSponsorDetail($sponsorId, $field, $value) {
	global $mysqli,$db_table_prefix;
	$stmt = $mysqli->prepare("UPDATE sponsor
		SET `{$field}` = '{$value}'
		WHERE
		sponsor_id = {$sponsorId}");
	$result = $stmt->execute();
	$stmt->close();
}

function newExhibit($conference_id, $company_profile, $special_requests, $contact_person) {
	global $mysqli;
	
	//Insert the user into the database providing no errors have been found.
	$stmt = $mysqli->prepare("INSERT INTO exhibit (
		conference_id,
		company_profile,
		special_requests
		)
		VALUES (
		?,
		?,
		?
		)");
	
	$stmt->bind_param("iss", $conference_id, $company_profile, $special_requests);
	$stmt->execute();
	$inserted_id = $mysqli->insert_id;
	$stmt->close();
	
	//Insert default permission into matches table
	$stmt = $mysqli->prepare("INSERT INTO exhibitor  (
		attendee_user_id,
		exhibit_id,
		isMain
		)
		VALUES (
		?,
		?,
		'1'
		)");
	$stmt->bind_param("ii", $contact_person, $inserted_id);
	$stmt->execute();
	$stmt->close();
	
	updateTitle($contact_person, 'Exhibitor');
	
	return true;
}

function fetchAllExhibits($filter = NULL) {
	
	if ($filter != NULL) {
		if ($filter == 'pending') { 
			$filter = " WHERE exhibit.paid IS NULL";
		}
		
		if ($filter == 'active') { 
			$filter = " WHERE exhibit.paid IS NOT NULL";
		}
	} else { $filter = ""; }
	
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
			exhibit.exhibit_id, 
			exhibit.conference_id, 
			exhibit.company_profile, 
	 		exhibit.special_requests,
	 		exhibit.paid,
	 		exhibit.table_loc,
			CONCAT (attendee.f_name, ' ', attendee.l_name) AS main_contact,
			attendee.company
			FROM exhibit
 	INNER JOIN `exhibitor`  ON exhibit.exhibit_id = exhibitor.exhibit_id
 	INNER JOIN `attendee`  ON exhibitor.attendee_user_id = attendee.user_id
 	$filter;");
	$stmt->execute();
	$stmt->bind_result($exhibit_id, $conference_id, $company_profile, $special_requests, $paid, $table_loc, $main_contact, $company);
	
	while ($stmt->fetch()){
		$row[] = array('exhibit_id' => $exhibit_id, 'conference_id' => $conference_id, 'company_profile' => $company_profile, 'special_requests' => $special_requests, 'paid' => $paid, 'table_loc' => $table_loc, 'main_contact' => $main_contact, 'company' => $company);
	}
	$stmt->close();
	return ($row);
}

function fetchExhibitDetails($exhibitId) {
	global $mysqli; 
	$stmt = $mysqli->prepare("SELECT 
			exhibit.exhibit_id, 
			exhibit.conference_id, 
			exhibit.company_profile, 
	 		exhibit.special_requests,
	 		exhibit.paid,
	 		exhibit.table_loc,
	 		exhibitor.attendee_user_id AS main_contact_id,
			CONCAT (attendee.f_name, ' ', attendee.l_name) AS main_contact_name,
			attendee.company
			FROM exhibit
 	INNER JOIN `exhibitor`  ON exhibit.exhibit_id = exhibitor.exhibit_id
 	INNER JOIN `attendee`  ON exhibitor.attendee_user_id = attendee.user_id WHERE exhibit.exhibit_id = {$exhibitId}");
	$stmt->execute();
	$stmt->bind_result($exhibit_id, $conference_id, $company_profile, $special_requests, $paid, $table_loc, $main_contact_id, $main_contact_name, $company);
	
	while ($stmt->fetch()){
		$row = array('exhibit_id' => $exhibit_id, 'conference_id' => $conference_id, 'company_profile' => $company_profile, 'special_requests' => $special_requests, 'paid' => $paid, 'table_loc' => $table_loc, 'main_contact_id' => $main_contact_id, 'main_contact_name' => $main_contact_name, 'company' => $company);
	}
	$stmt->close();
	return ($row);

}
?>

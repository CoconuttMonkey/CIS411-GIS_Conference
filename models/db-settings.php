<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/


$currentSite = $_SERVER['HTTP_HOST'];
if ($currentSite == 'cisprod.clarion.edu') {

	//Live Database Information
	$db_host = "localhost"; //Host address (most likely localhost)
	$db_name = "cis411_gisconference"; //Name of Database
	$db_user = "s_mrondo"; //Name of database user
	$db_pass = "s_mrondo"; //Password for database user
	$db_table_prefix = "uc_";
	
} else if ($currentSite == 'gisconference.local') {

	//LOCAL Database Information
	$db_host = "localhost"; //Host address (most likely localhost)
	$db_name = "gisconference"; //Name of Database
	$db_user = "root"; //Name of database user
	$db_pass = "Gr@ys0n"; //Password for database user
	$db_table_prefix = "uc_";

}

GLOBAL $errors;
GLOBAL $successes;

$errors = array();
$successes = array();

/* Create a new mysqli object with database connection parameters */
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
GLOBAL $mysqli;

if(mysqli_connect_errno()) {
	echo "Connection Failed: " . mysqli_connect_errno();
	exit();
}

//Direct to install directory, if it exists
if(is_dir("install/"))
{
	header("Location: install/");
	die();

}

?>
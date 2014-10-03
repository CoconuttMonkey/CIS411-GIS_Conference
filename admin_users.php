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
	$deletions = $_POST['delete'];
	if ($deletion_count = deleteUsers($deletions)){
		$successes[] = lang("ACCOUNT_DELETIONS_SUCCESSFUL", array($deletion_count));
	}
	else {
		$errors[] = lang("SQL_ERROR");
	}
}

$userData = fetchAllUsers(); //Fetch information for all users

require_once("models/header.php");
?>
<body>
	<?php include("nav.php"); ?>
	<?
echo "
<body>
<div class='container'>
<h1>Registrants</h1>
<div class='row'>
<div class='col-100'>";

echo resultBlock($errors,$successes);

echo "
<form name='adminUsers' action='".$_SERVER['PHP_SELF']."' method='post' class='forms width-100'>
<table class='admin width-100'>
<tr style='text-align: left;'>
<th>Delete</th><th>Name</th><th>Email</th><th>Title</th><th>Paid</th>
</tr>";

//Cycle through users
foreach ($userData as $v1) {
?>
<tr>
	<td><input type='checkbox' name='delete[<?php echo $v1['id']; ?>]' id='delete[<?php echo $v1['id']; ?>]' value='<?php echo $v1['id']; ?>'></td>
	<td><a href="admin_user.php?id=<? echo $v1['id']; ?>"><? echo $v1['first_name']." ".$v1['last_name'] ?></a></td>
	<td><?php echo $v1['email']; ?></td>
	<td><?php echo $v1['title']; ?></td>
	<td><? if ($v1['paid'] === 1) { 
			echo '<span class="success">Paid</span>';
		} else if ($v1['paid'] === 0) { 
			echo '<span class="error">Not Paid</span>';
		} ?></td>
</tr>
<?
}


echo "
</table>
<input type='submit' name='Submit' value='Delete' />
</form>
</div>
</div>
</div>";

?>
	<?php include("models/footer.php"); ?>
</body>
</html>

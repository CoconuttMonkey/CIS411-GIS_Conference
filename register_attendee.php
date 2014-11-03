<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/
require_once("models/config.php");
require_once("models/class.newattendee.php");

if (!securePage($_SERVER['PHP_SELF'])){die();}
//Prevent the user visiting the logged in page if he/she is already logged in
if(!isUserLoggedIn()) { header("Location: ../login.php"); die(); }

//print_r($_POST);

if(userIsAttendee($loggedInUser->user_id)) {
	$errors[] = "ATTENDEE_EXISTS";
}

if (isset($_POST['newAttendee'])) {
	$errors = array();
	$f_name = trim($_POST["f_name"]);
	$l_name = trim($_POST["l_name"]);
	$address_1 = trim($_POST["address_1"]);
	$address_2 = trim($_POST["address_2"]);
	$city = trim($_POST["city"]);
	$state = trim($_POST["state"]);
	$postal_code = trim($_POST["postal_code"]);
	$country = trim($_POST["country"]);
	$phone = trim($_POST["phone"]);
	$company = trim($_POST["company"]);
	
	if (!userIsAttendee($loggedInUser->user_id)) {
		
		//Construct a user object
		$attendee = new Attendee($loggedInUser->user_id,$f_name,$l_name,$address_1,$address_2,$city,$state,$postal_code,$country,$phone,$company);
		
		print_r($attendee);
		
		if(!$attendee->addAttendee()) {
			if($attendee->mail_failure) $errors[] = lang("MAIL_ERROR");
			if($attendee->sql_failure)  $errors[] = lang("SQL_ERROR");
		} else {
			$successes[] = lang("ATTENDEE_REGISTERED");
		}
	} else {
		$errors[] = lang("ATTENDEE_EXISTS");
	}
} // COMPLETE

require_once("models/header.php");
?>

<body>
	<?php include("models/main-nav.php"); ?>
	<section class="container">
		<?php echo resultBlock($errors,$successes); ?>
		<form name='newAttendee' id="newAttendee" action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms text-left">
		  <input type="text" class="form-control" name="newAttendee" value="1" style="display:none;" />
			<div class="row">
				<div class="col-lg-6 col-lg-push-3">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Attendee Registration</h4></div>
					  <div class="panel-body">
	                    
							<div class="form-group">
								<label>First Name</label>
							  <input type="text" class="form-control" name="f_name">
							</div>
	                    
							<div class="form-group">
								<label>Last Name</label>
							  <input type="text" class="form-control" name="l_name">
							</div>
							
							<div class="form-group">
								<label>Address Line 1</label>
							  <input type="text" class="form-control" name="address_1" required>
							</div>
							
							<div class="form-group">
								<label>Address Line 2</label>
							  <input type="text" class="form-control" name="address_2">
							</div>
							
							<div class="form-group">
								<label>City</label>
							  <input type="text" class="form-control" name="city" required>
							</div>
							
							<div class="form-group">
								<label>State</label>
							  <input type="text" class="form-control" name="state" required>
							</div>
							
							<div class="form-group">
								<label>Postal Code</label>
							  <input type="text" class="form-control" name="postal_code" required>
							</div>
							
		          <div class="form-group">
                <label>Country</label>
                <select class="form-control" name="country" data-bv-notempty data-bv-notempty-message="The country is required">
                    <option value="">-- Select a country --</option>
                    <option value="US">United States</option>
                    <option value="FR">France</option>
                    <option value="DE">Germany</option>
                    <option value="IT">Italy</option>
                    <option value="JP">Japan</option>
                    <option value="RU">Russia</option>
                    <option value="GB">United Kingdom</option>
                </select>
	            </div>
	                    
							<div class="form-group">
								<label>Phone Number</label>
							  <input type="text" class="form-control" name="phone">
							</div>
							
							<div class="form-group">
								<label>Company / Institution</label>
							  <input type="text" class="form-control" name="company" required>
							</div>
							
							<div class="form-group text-center">
							  <input type="submit" class="btn btn-success" value="Register Now!">
							</div>
					  </div>
					</div>
				</div>
			</div><!-- /.row -->
		</form>
	</section>
	<script type="text/javascript">
	</script>

	<?php 
include("models/footer.php");
include("models/BootstrapJavaScript.php"); ?>
</body>
</html>

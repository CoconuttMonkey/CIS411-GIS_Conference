<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he/she is already logged in
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }


//Forms posted
if(!empty($_POST))
{
	$errors = array();
	$user_id = trim($_POST["user_id"]);
	$country = trim($_POST["country"]);
	$phone = trim($_POST["phone"]);
	$address_1 = trim($_POST["address_1"]);
	$address_2 = trim($_POST["address_2"]);
	$city = trim($_POST["city"]);
	$state = trim($_POST["state"]);
	$zip = trim($_POST["zip"]);
	
	
	//End data validation
	if(count($errors) == 0)
	{	
		//Construct a user object
		$attendee = new Attendee($user_id,$country,$phone,$address_1,$address_2,$city,$state,$zip);
		
		if($attendee->attendee_exists) $errors[] = lang("ATTENDEE_EXISTS");
		
		if($attendee->status) {
			//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
			if(!$attendee->confAddAttendee())
			{
				if($attendee->sql_failure)  $errors[] = lang("SQL_ERROR");
			}
		}
	}
	if(count($errors) == 0) {
		$successes[] = $user->success;
		// Check if user is an attendee
		if (userIsAttendee($user_id)) {
			
			// Get attendee details
			$attendeeDetails = fetchAttendeeDetails($user_id);
			
			$loggedInUser->country = $attendeeDetails["country"];
			$loggedInUser->phone = $attendeeDetails["phone"];
			$loggedInUser->address_1 = $attendeeDetails["address_1"];
			$loggedInUser->address_2 = $attendeeDetails["address_2"];
			$loggedInUser->city = $attendeeDetails["city"];
			$loggedInUser->state = $attendeeDetails["state"];
			$loggedInUser->zip = $attendeeDetails["zip"];
			$loggedInUser->company = $attendeeDetails["company"];
			$loggedInUser->reg_type = $attendeeDetails["reg_type"];
		}
	}
}

require_once("models/header.php");
?>

<style>
	.show {
		display: block;
	}
	.hide {
		display: none;
	}
</style>

<body>
	<?php include("models/main-nav.php"); ?>
	<section class="container">
	<h1>Conference Registration</h1>
	<? 
		//Prevent the user visiting the logged in page if he/she is already logged in
		if(!userIsAttendee($loggedInUser->user_id)) {
	?>
		<div class="row">
			<?php echo resultBlock($errors,$successes); ?>
			<form name='newUser' action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms text-left">
				<div class="col-lg-4 col-lg-push-4 col-md-6 col-md-push-3 col-sm-8 col-sm-push-2">
						<input type="text" class="form-control" name="user_id" value="<? echo $loggedInUser->user_id; ?>" style="display:none;" required>
						
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
						  <input type="text" class="form-control" name="phone" required>
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
							<label>Zip</label>
						  <input type="text" class="form-control" name="zip" required>
						</div>
						
						<div class="form-group">
							<label>Company / Institution</label>
						  <input type="text" class="form-control" name="company" required>
						</div>
						
						<input type='submit' value='Register' class="btn btn-success"/>
				</div>
			</form>
		</div>
	<? } else { ?> 
		<div class="col-lg-6 col-lg-push-3">
		  <div class="panel panel-success">
		    <div class="panel-heading">
		      <div class="row">
		        <div class="col-xs-12">
		          <p class="announcement-heading text-left">Thank You</p>
		          <p class="announcement-text text-right">You are registered for this years conference.</p>
		        </div>
		      </div>
		    </div>
		    <a href="account.php">
		      <div class="panel-footer announcement-bottom">
		        <div class="row">
		          <div class="col-xs-12">
		            Go to Dashboard
		          </div>
		        </div>
		      </div>
		    </a>
		  </div>
		</div>
	
	<? } ?>
	
	
	</section>
	<?php include("models/footer.php"); ?>
</body>
<script>
$(document).ready(function() {
    $('.forms').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            phone: {
                message: 'The phone number is not valid',
                validators: {
                    notEmpty: {
                        message: 'The phone number is required'
                    },
                    digits: {
                        message: 'The value can contain only digits'
                    }
                }
            },
            address_1: {
                message: 'Address is not valid',
                validators: {
                    notEmpty: {
                        message: 'Your address is required and cannot be empty'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\s]+$/,
                        message: 'Your address can only consist of alphabetical, number and underscore'
                    }
                }
            },
            address_2: {
                validators: {
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\s]+$/,
                        message: 'Your address can only consist of alphabetical, number and underscore'
                    }
                }
            },
            city: {
                message: 'City is not valid',
                validators: {
                    notEmpty: {
                        message: 'City field is required and cannot be empty'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\s]+$/,
                        message: 'City can only consist of alphabetical, number and underscore'
                    }
                }
            },
            state: {
                message: 'State is not valid',
                validators: {
                    notEmpty: {
                        message: 'State field is required and cannot be empty'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_]+$/,
                        message: 'State can only consist of alphabetical, number and underscore'
                    }
                }
            },
            zip: {
                validators: {
                    zipCode: {
                        country: 'country',
                        // %s will be replaced with "US zipcode", "Italian postal code", and so on
                        // when you choose the country as US, IT, etc.
                        message: 'The value is not valid %s'
                    }
                }
            }
        }
    });
});	
</script>
</html>

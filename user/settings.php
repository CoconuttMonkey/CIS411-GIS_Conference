<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he is not logged in
if (!isUserLoggedIn()) { header("Location: ../login.php"); die(); }

if (!empty($_POST)) {
	$errors = array();
	$successes = array();
	$password = $_POST["password"];
	$password_new = $_POST["passwordc"];
	$password_confirm = $_POST["passwordcheck"];
	
	$country = $_POST["country"];
	$phone = $_POST["phone"];
	$address_1 = $_POST["address_1"];
	$address_2 = $_POST["address_2"];
	$city = $_POST["city"];
	$state = $_POST["state"];
	$zip = $_POST["zip"];
	$company = $_POST["company"];
	
	$errors = array();
	$email = $_POST["email"];
	
	//Perform some validation
	//Feel free to edit / change as required
	
	//Confirm the hashes match before updating a users password
	$entered_pass = generateHash($password,$loggedInUser->hash_pw);
	
	if (trim($password) == ""){
		$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
	}
	else if ($entered_pass != $loggedInUser->hash_pw) {
		//No match
		$errors[] = lang("ACCOUNT_PASSWORD_INVALID");
	}

	if ($email != $loggedInUser->email) {
		if(trim($email) == "") {
			$errors[] = lang("ACCOUNT_SPECIFY_EMAIL");
		} else if (!isValidEmail($email)) {
			$errors[] = lang("ACCOUNT_INVALID_EMAIL"); 
		} else if (emailExists($email)) {
			$errors[] = lang("ACCOUNT_EMAIL_IN_USE", array($email));	
		}
		
		//End data validation
		if(count($errors) == 0) {
			$loggedInUser->updateEmail($email);
			$successes[] = lang("ACCOUNT_EMAIL_UPDATED");
		}
	}
	
	/*
		Update Country Code
	*/
	if($country != $loggedInUser->country) {
		updateAttendeeDetail($loggedInUser->user_id, 'country', $country);
		$loggedInUser->country = $country;
		$successes[] = lang("ACCOUNT_COUNTRY_UPDATED");
	}
	
	/*
		Update Phone Number
	*/
	if ($phone != $loggedInUser->phone) {
		if(trim($phone) == "") {
			$errors[] = lang("ACCOUNT_SPECIFY_PHONE");
		}
		
		//End data validation
		if(count($errors) == 0) {
			updateAttendeeDetail($loggedInUser->user_id, 'phone', $phone);
			$loggedInUser->phone = $phone;
			$successes[] = lang("ACCOUNT_PHONE_UPDATED");
		}
	}
	
	/*
		Update Address 1
	*/
	if ($address_1 != $loggedInUser->address_1) {
		if(trim($address_1) == "") {
			$errors[] = lang("ACCOUNT_SPECIFY_ADDRESS");
		}
		
		//End data validation
		if(count($errors) == 0) {
			updateAttendeeDetail($loggedInUser->user_id, 'address_1', $address_1);
			$loggedInUser->address_1 = $address_1;
			$successes[] = lang("ACCOUNT_ADDRESS_UPDATED");
		}
	}
	
	/*
		Update Address 2
	*/	if ($address_2 != $loggedInUser->address_2) {
		if(trim($address_2) == "") {
			$errors[] = lang("ACCOUNT_SPECIFY_ADDRESS");
		}
		
		//End data validation
		if(count($errors) == 0) {
			updateAttendeeDetail($loggedInUser->user_id, 'address_2', $address_2);
			$loggedInUser->address_2 = $address_2;
			$successes[] = lang("ACCOUNT_ADDRESS_UPDATED");
		}
	}
	
	/*
		Update City
	*/
	if ($city != $loggedInUser->city) {
		if(trim($city) == "") {
			$errors[] = lang("ACCOUNT_SPECIFY_CITY");
		}
		
		//End data validation
		if(count($errors) == 0) {
			updateAttendeeDetail($loggedInUser->user_id, 'city', $city);
			$loggedInUser->city = $city;
			$successes[] = lang("ACCOUNT_CITY_UPDATED");
		}
	}

	/*
		Update State
	*/
	if ($state != $loggedInUser->state) {
		if(trim($state) == "") {
			$errors[] = lang("ACCOUNT_SPECIFY_STATE");
		}
		
		//End data validation
		if(count($errors) == 0) {
			updateAttendeeDetail($loggedInUser->user_id, 'state', $state);
			$loggedInUser->state = $state;
			$successes[] = lang("ACCOUNT_STATE_UPDATED");
		}
	}

	/*
		Update Zip
	*/
	if ($zip != $loggedInUser->zip) {
		if(trim($zip) == "") {
			$errors[] = lang("ACCOUNT_SPECIFY_ZIP");
		}
		
		//End data validation
		if(count($errors) == 0) {
			updateAttendeeDetail($loggedInUser->user_id, 'zip', $zip);
			$loggedInUser->zip = $zip;
			$successes[] = lang("ACCOUNT_ZIP_UPDATED");
		}
	}

	/*
		Update Company
	*/
	if ($company != $loggedInUser->company) {
		updateAttendeeDetail($loggedInUser->user_id, 'company', $company);
		$loggedInUser->company = $company;
		$successes[] = lang("ACCOUNT_STATE_UPDATED");
	}
	
	/*
		Update Password
	*/
	if ($password_new != "" OR $password_confirm != "") {
		if (trim($password_new) == "") {
			$errors[] = lang("ACCOUNT_SPECIFY_NEW_PASSWORD");
		} else if (trim($password_confirm) == "") {
			$errors[] = lang("ACCOUNT_SPECIFY_CONFIRM_PASSWORD");
		} else if (minMaxRange(8,50,$password_new)) {	
			$errors[] = lang("ACCOUNT_NEW_PASSWORD_LENGTH",array(8,50));
		} else if ($password_new != $password_confirm) {
			$errors[] = lang("ACCOUNT_PASS_MISMATCH");
		}
		
		//End data validation
		if (count($errors) == 0) {
			//Also prevent updating if someone attempts to update with the same password
			$entered_pass_new = generateHash($password_new,$loggedInUser->hash_pw);
			
			if ($entered_pass_new == $loggedInUser->hash_pw) {
				//Don't update, this fool is trying to update with the same password Â¬Â¬
				$errors[] = lang("ACCOUNT_PASSWORD_NOTHING_TO_UPDATE");
			} else {
				//This function will create the new hash and update the hash_pw property.
				$loggedInUser->updatePassword($password_new);
				$successes[] = lang("ACCOUNT_PASSWORD_UPDATED");
			}
		}
	}
	if (count($errors) == 0 AND count($successes) == 0) {
		$errors[] = lang("NOTHING_TO_UPDATE");
	}
}

require_once("../models/header.php");
?>
<body>
	<?php include("../models/main-nav.php"); ?>
	<section class="container">
		<ol class="breadcrumb">
		  <li><a href="/user/dashboard.php">Dashboard</a></li>
		  <li class="active"><a href="../user/settings.php">Settings</a></li>
		</ol>
			<? echo resultBlock($errors,$successes); ?>
			<div class="col-lg-12">
				<form name='updateAccount' action='<? $_SERVER['PHP_SELF'] ?>' method='post' style="margin-bottom: 100px;" id="updateAccount">
					<section class="row">
						<div class="col-lg-6 col-md-6">
					      <h3>Account Information</h3>
								<div class="form-group">
									<label>First Name</label>
								  <input type="text" class="form-control" name="first_name" value="<? echo $loggedInUser->first_name; ?>" required>
								</div>
								
								<div class="form-group">
									<label>Last Name</label>
								  <input type="text" class="form-control" name="last_name" value="<? echo $loggedInUser->last_name; ?>" required>
								</div>
								
								<div class="form-group">
									<label>Email Address</label>
								  <input type="email" class="form-control" name="email" value="<? echo $loggedInUser->email; ?>" required>
								</div>
								
							  <h3>Change Password</h3>
								<div class="form-group">
									<label>New Password</label>
								  <input type="password" class="form-control" name="passwordc" placeholder="New Password">
								</div>
								
								<div class="form-group">
									<label>Confirm New Password</label>
								  <input type="password" class="form-control" name="passwordcheck" placeholder="New Password">
								</div>
								
								<label>Current Password</label>
								<div class="input-group">
						      <input type='password' name='password' class="form-control" placeholder="Current Password" required />
						      <span class="input-group-btn">
						        <button class="btn btn-success" type="submit"><span class="glyphicon glyphicon-check"></span> Save Changes</button>
						      </span>
						    </div><!-- /input-group -->
						</div>
						<? if(userIsAttendee($loggedInUser->user_id)) { ?>
						<div class="col-lg-6 col-md-6">
							<h3>Contact Information</h3>
							<div class="form-group">
                <label>Country</label>
                <select class="form-control" name="country" data-bv-notempty data-bv-notempty-message="The country is required">
                    <option value="">-- Select a country --</option>
                    <option value="US" <? if ($loggedInUser->country == 'US') echo 'selected="selected"';?>>United States</option>
                    <option value="FR" <? if ($loggedInUser->country == 'FR') echo 'selected="selected"';?>>France</option>
                    <option value="DE" <? if ($loggedInUser->country == 'DE') echo 'selected="selected"';?>>Germany</option>
                    <option value="IT" <? if ($loggedInUser->country == 'IT') echo 'selected="selected"';?>>Italy</option>
                    <option value="JP" <? if ($loggedInUser->country == 'JP') echo 'selected="selected"';?>>Japan</option>
                    <option value="RU" <? if ($loggedInUser->country == 'RU') echo 'selected="selected"';?>>Russia</option>
                    <option value="GB" <? if ($loggedInUser->country == 'GB') echo 'selected="selected"';?>>United Kingdom</option>
                </select>
	            </div>
	                    
							<div class="form-group">
								<label>Phone Number</label>
							  <input type="text" class="form-control" name="phone" value="<? echo $loggedInUser->phone; ?>">
							</div>
							
							<div class="form-group">
								<label>Address Line 1</label>
							  <input type="text" class="form-control" name="address_1" value="<? echo $loggedInUser->address_1; ?>">
							</div>
							
							<div class="form-group">
								<label>Address Line 2</label>
							  <input type="text" class="form-control" name="address_2" value="<? echo $loggedInUser->address_2; ?>">
							</div>
							
							<div class="form-group">
								<label>City</label>
							  <input type="text" class="form-control" name="city"  value="<? echo $loggedInUser->city; ?>">
							</div>
							
							<div class="form-group">
								<label>State</label>
							  <input type="text" class="form-control" name="state"  value="<? echo $loggedInUser->state; ?>">
							</div>
							
							<div class="form-group">
								<label>Zip</label>
							  <input type="text" class="form-control" name="zip"  value="<? echo $loggedInUser->zip; ?>">
							</div>
							
							<div class="form-group">
								<label>Company / Institution</label>
							  <input type="text" class="form-control" name="company"  value="<? echo $loggedInUser->company; ?>">
							</div>
						</div><? } ?>
					</section>
				</form>
			</div>
		</div>
	</section>
	<? if(userIsAttendee($loggedInUser->user_id)) { ?>
	<script>
	$(document).ready(function() {
	    $('#updateAccount').bootstrapValidator({
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
	<? }
	
		include("../models/footer.php"); ?>
</body>
</html>
<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
if(!isUserLoggedIn()) { header("Location: ../login.php"); die(); }
require_once("models/class.newsponsor.php");

//Forms posted
if(!empty($_POST))
{
	$errors = array();
	$main_contact = $loggedInUser->user_id;
	$company_name = trim($_POST["company_name"]);
	$company_address = trim($_POST["company_address"]);
	$website_url = trim($_POST["website_url"]);
	$sponsor_attendees = trim($_POST["sponsor_attendees"]);
	$sponsor_lvl = $_POST["sponsor_lvl"];
	
	if ($company_name == "") {
		$errors[] = "COMPANY_NAME_REQUIRED";
	}
	if ($company_address == "") {
		$errors[] = "COMPANY_ADDRESS_REQUIRED";
	}
	
	//End data validation
	if(count($errors) == 0)
	{	
		//Construct a sponsor object
		$sponsor = new Sponsor($main_contact,$company,$address,$logo,$website_url,$sponsor_lvl);
		
		//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
		if(!$sponsor->addSponsor())
		{
			if($sponsor->mail_failure) $errors[] = lang("MAIL_ERROR");
			if($sponsor->sql_failure)  $errors[] = lang("SQL_ERROR");
		}
	}
	if(count($errors) == 0) {
		$successes[] = $sponsor->success;
	}
}

require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<div class='row'>
			<div class='col-lg-12'>
				<h1>Sponsor Registration</h1>
				<? echo resultBlock($errors,$successes); ?>
		<form name='newSponsor' id="newSponsor" action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms text-left">
				<div class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Company Profile</h4></div>
					  <div class="panel-body">
              <div class="form-group"><label class="control-label">Company Name</label>
				        <input type="text" class="form-control" name="company_name" required />
              </div>
              
		          <div class="form-group"><label class="control-label">Company Address</label>
						  	<textarea class="form-control" rows="4" id="company_address" name="company_address"></textarea>
		          </div>
		          <div class="form-group">
			          <label class="control-label">Company Logo</label>
			          <div class="form-group">
			            <input type="file" class="form-control" name="sponsor_logo" />
			            <span class="help-block text-right">Choose a pdf file with a size less than 1M.</span>
			          </div>
			        </div>
              <div class="form-group"><label class="control-label">Website URL</label>
				        <input type="text" class="form-control" name="website_url" placeholder="http://" />
              </div>
					  </div>
					</div>
					
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Attendees</h4></div>
		        <input type="text" class="form-control" name="contact_person_id" value="<? echo $loggedInUser->user_id; ?>" style="display:none;" />
					  <div class="panel-body">				      
              <div class="form-group"><label class="control-label">Email Addresses</label>
				        <input type="text" class="form-control" name="sponsor_attendees[]" placeholder="Invite by email" />
				        <br>
				        <input type="text" class="form-control" name="sponsor_attendees[]" placeholder="Invite by email" />
				        <br>
				        <input type="text" class="form-control" name="sponsor_attendees[]" placeholder="Invite by email" />
				    	</div>
					  </div>
					</div>
				</div>
				
				<div class="col-lg-6">
					
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Sponsorship Level</h4></div>
		        <input type="text" class="form-control" name="contact_person_id" value="<? echo $loggedInUser->user_id; ?>" style="display:none;" />
					  <div class="panel-body">				      
              <div class="form-group"><label class="control-label">Choose a level</label>
	              
	              <div class="radio">
								  <label>
								  	<input type="radio" name="sponsor_lvl" value="1">Level 1 $300
									  <p>
										  <ul>
											  <li>Exhibit table for both of the conference days (Full Day 1 & Half Day 2)</li>
											  <li>Receive 2 complimentary conference registrations</li>
											  <li>Listed as Sponsor on the conference's printed agenda</li>
											  <li>Verbal recognition of sponsorship at the conference's introductions</li>
											  <li>Receive a list of conference attendees</li>
										  </ul>
									  </p>
								  </label>
								</div>
								
	              <div class="radio">
								  <label>
								  	<input type="radio" name="sponsor_lvl" value="2">Level 2 $500
									  <p>
										  <ul>
											  <li>All Level 1 Benefits Plus:</li>
											  <li>Opportunity to have a 5-min company introduction/brief promotional presentation at the conference's morning or mid-day keynote address (in coordination with keynote and other sponsors)</li>
											  <li>Listed on the conference's website and include a link on all conference's email communications</li>
											  <li>Sponsor designation on attendee(s) name badge</li>
										  </ul>
									  </p>
								  </label>
								</div>
				    	</div>
					  </div>
					</div>
				</div>
			</div><!-- /.row -->
			<p style="text-align: center;">
				<input type='submit' value='Register' class='btn btn-lg btn-success'/>
			</p>
		</form>
			</div>
		</div>
	</div>
	<?php 
		include("models/footer.php");
		include("models/BootstrapJavaScript.php"); 
	?>
</body>
</html>

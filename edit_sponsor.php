<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
if(!isUserLoggedIn()) { header("Location: ../login.php"); die(); }
if(!isset($_GET['id'])) { header("Location: ../list_sponsors.php"); die(); }

$sponsorId = $_GET['id'];

$sponsorDetails = fetchSponsorDetails($sponsorId);
//print_r($sponsorDetails);

if (isset($_POST['editSponsor'])) {
	
	$company_name = $_POST['company_name'];
	$company_address = $_POST['company_address'];
	$company_url = $_POST['website_url'];
	$sponsor_lvl = $_POST['sponsor_lvl'];
	$copresenter = $_POST['copresenter'];
	
	//print_r($_POST);
	
	if ($company_name != $sponsorDetails['company_name']) {
		if ($company_name != "") {
			updateSponsorDetail($sponsorId, 'company_name', $company_name);
			$successes[] = lang("COMPANY_NAME_UPDATED");
		} else {
			$errors[] = lang("COMPANY_NAME_REQUIRED");
		}
	}
	
	if ($company_address != $sponsorDetails['company_address']) {
		if ($company_address != "") {
			updateSponsorDetail($sponsorId, 'company_address', $company_address);
			$successes[] = lang("COMPANY_ADDRESS_UPDATED");
		} else {
			$errors[] = lang("COMPANY_ADDRESS_REQUIRED");
		}
	}
	
	if ($company_url != $sponsorDetails['url']) {
		if ($company_url != "") {
			updateSponsorDetail($sponsorId, 'url', $company_url);
			$successes[] = lang("COMPANY_URL_UPDATED");
		} else {
			$errors[] = lang("COMPANY_URL_EMPTY");
		}
	}
	
	if ($sponsor_lvl != $sponsorDetails['sponsor_lvl']) {
		if ($sponsor_lvl != "") {
			updateSponsorDetail($sponsorId, 'sponsor_lvl', $sponsor_lvl);
			$successes[] = lang("COMPANY_SPONSOR_LVL_UPDATED");
		}
	}
	
	$logo_size = $_FILES["logo"]["size"];
		
	if ($logo_size) {
		$target_dir = $sponsor_logo_dir . "$sponsorId/";
		$logo = $target_dir . basename( $_FILES["logo"]["name"]);
		$logo_type = $_FILES["logo"]["type"];
		$uploadOk = 1;
	
		if (file_exists($logo . $_FILES["logo"]["name"])) {
			$errors[] = lang("LOGO_FILE_EXISTS");
	    $uploadOk = 0;
		}
		
		if ($logo_size > 100000) {
			$errors[] = lang("LOGO_ABOVE_FILE_SIZE");
	    $uploadOk = 0;
		}
		
		if (!($logo_type == "image/jpeg")) {
			$errors[] = lang("LOGO_TYPE_ERROR");
	    $uploadOk = 0;
		}
		
		if (!move_uploaded_file($_FILES["logo"]["tmp_name"], $logo)) {
			//$errors[] = lang("LOGO_UPLOAD_ERROR");
		}
	}

	if (!count($successes) && !count($errors)) $successes[] = lang("NOTHING_TO_UPDATE");
	else $sponsorDetails = fetchSponsorDetails($sponsorId);
}


$languages = getLanguageFiles(); //Retrieve list of language files
require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<ol class="breadcrumb">
		  <li><a href="../admin_dashboard.php">Admin Dashboard</a></li>
		  <li><a href="../list_sponsors.php">Sponsors</a></li>
		  <li class="active"><a href="#"><?=$sponsorDetails['company_name']?></a></li>
							<h4 style="float: right; margin-top: -1px;">
								<? //Display payment status
								if ($presentationDetails['paid']){
									echo " <span class='label label-success'>Paid</span>";	
								}
								else{
									echo " <span class='label label-danger'>Unpaid</span>";
								} ?>
							</h4>
		</ol>
		<div class='row'>
			<div class='col-lg-12'>
				<h1>Sponsor Registration</h1>
				<? echo resultBlock($errors,$successes); ?>
		<form name='editSponsor' id="editSponsor" action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms text-left"  enctype="multipart/form-data">
		<input type="text" class="form-control" name="editSponsor" value="1" style="display:none;" />
				<div class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Company Profile</h4></div>
					  <div class="panel-body">
              <div class="form-group"><label class="control-label">Company Name</label>
				        <input type="text" class="form-control" name="company_name" value="<?=$sponsorDetails['company_name']?>" />
              </div>
              
		          <div class="form-group"><label class="control-label">Company Address</label>
						  	<textarea class="form-control" rows="4" id="company_address" name="company_address" ><?=$sponsorDetails['company_address']?></textarea>
		          </div>
		          
		          <div class="form-group">
			          <label class="control-label">Company Logo</label>
			          <div class="form-group">
			            <input type="file" class="form-control" name="logo" />
			            <span class="help-block text-right">Choose a pdf file with a size less than 1M.</span>
			          </div>
			        </div>
                  
              <div class="form-group"><label class="control-label">Website URL</label>
				        <input type="text" class="form-control" name="website_url" value="<?=$sponsorDetails['url']?>" />
              </div>
					  </div>
					</div>
					
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Attendees</h4></div>
					  <div class="panel-body">				   
			          <div class="form-group">
				          <label>Main Presenter</label>
								  <div class="input-group">
							      <input type="text" class="form-control" name="main_presenter_name" value="<?= $sponsorDetails['main_contact_name'] ?>" disabled>
							      <span class="input-group-btn">
							        <a href="details_user.php?id=<?=$sponsorDetails["user_id"]?>"><button class="btn btn-success" type="button">View Profile <span class="glyphicon glyphicon-arrow-right"></span></button></a>
							      </span>
							    </div>
			          </div>
				      
              <div class="form-group"><label class="control-label">Email Addresses</label><br>
				        <input type="text" class="form-control" name="sponsor_attendees[]" placeholder="Invite by email">
				        <br>
				        <input type="text" class="form-control" name="sponsor_attendees[]" placeholder="Invite by email">
				        <br>
				        <input type="text" class="form-control" name="sponsor_attendees[]" placeholder="Invite by email">
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
								  	<input type="radio" name="sponsor_lvl" value="1" <? if ($sponsorDetails['sponsor_lvl'] == 1) { echo "checked"; } ?> >Level 1 $300
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
								  	<input type="radio" name="sponsor_lvl" value="2" <? if ($sponsorDetails['sponsor_lvl'] == 2) { echo "checked"; } ?> >Level 2 $500
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
								
								<div class="radio">
								  <label>
								  	<input type="radio" name="sponsor_lvl" value="3" <? if ($sponsorDetails['sponsor_lvl'] == 3) { echo "checked"; } ?> >Level 3 $750
									  <p>
										  <ul>
											  <li>All Level 1 & Level 2 Benefits Plus:</li>
											  <li>Opportunity to have a 10-min company introduction/brief promotional presentation at the conference's morning or mid-day keynote address (in coordination with keynote and other sponsors)</li>
											  <li>A full page Ad in the Conference's printed agenda</li>
											  <li>Inclusion of company's flyer/handout in the attendees registration packet</li>
										  </ul>
									  </p>
								  </label>
								</div>
				    	</div>
					  </div>
					</div>
				</div>
			</div><!-- /.row -->
					<div class="row text-center">
						<input type="submit" class="btn btn-lg btn-success" value="Save" />
						<a href="edit_sponsor.php?id=<?=$sponsorId?>" class="btn btn-lg btn-danger" disabled>Edit</a>
					</div><!-- /.row -->
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

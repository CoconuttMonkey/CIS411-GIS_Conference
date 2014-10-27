<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("../models/config.php");

if (!securePage($_SERVER['PHP_SELF'])){die();}
//Prevent the user visiting the logged in page if he/she is already logged in
if(!isUserLoggedIn()) { header("Location: ../login.php"); die(); }

$reg_type = trim($_GET['type']);

//print_r($_POST);
if (isset($_POST['newPresentation'])) {
	
	require_once("../models/class.newpresentation.php");
	
	$errors = array();
	$main_presenter = $_POST['main_presenter'];
	$presenter_bio = $_POST['presenter_bio'];
	$copresenter = $_POST['copresenter'];
	$presentation_title = $_POST['presentation_title'];
	$presentation_abstract = $_POST['presentation_abstract'];
	$presentation_track = $_POST['presentation_track'];
	$presentation_day_request = $_POST['presentation_day_request'];
	if($_POST['gallery']) {
		$gallery_title = $_POST['gallery_title'];
		$gallery_abstract = $_POST['gallery_abstract'];
		$gallery_expertise_level = $_POST['gallery_expertise_level'];
		$gallery_critique = $_POST['gallery_critique'];
	}
	
	//Construct a user object
	$presentation = new Presentation($main_presenter,$presenter_bio,$presentation_title,$presentation_abstract,$presentation_track,$presentation_day_request);
	print_r($presentation);
	
	if(!$presentation->addPresentation()) {
		$errors[] = lang("PRESENTATION_ERROR");
	} else {
		$successes = lang("PRESENTATION_REGISTERED");
	}
	
}

if (isset($_POST['newAttendee'])) {
	$errors = array();
	$country = trim($_POST["country"]);
	$phone = trim($_POST["phone"]);
	$address_1 = trim($_POST["address_1"]);
	$address_2 = trim($_POST["address_2"]);
	$city = trim($_POST["city"]);
	$state = trim($_POST["state"]);
	$zip = trim($_POST["zip"]);
	$company = trim($_POST["company"]);
	
	if (!userIsAttendee($loggedInUser->user_id)) {
		//Construct a user object
		$attendee = new Attendee($loggedInUser->user_id,$country,$phone,$address_1,$address_2,$city,$state,$zip,$company);
		
		if(!$attendee->addAttendee()) {
			if($attendee->mail_failure) $errors[] = lang("MAIL_ERROR");
			if($attendee->sql_failure)  $errors[] = lang("SQL_ERROR");
		} else {
			$successes = lang("ATTENDEE_REGISTERED");
		}
	} else {
		$errors[] = lang("ATTENDEE_EXISTS");
	}
} // COMPLETE

require_once("../models/header.php");
?>

<body>
	<?php include("../models/main-nav.php"); ?>
	<section class="container">
		<?php echo resultBlock($errors,$successes); ?>
		<?php if ($reg_type == 'presentation') { ?>
		<form name='newPresentation' id="newPresentation" action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms text-left">
		  <input type="text" class="form-control" name="newPresentation" value="1" style="display:none;" />
			<div class="row">
				<h1>Presentation Registration</h1>
				<div class="col-lg-4">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Main Presenter</h4></div>
		        <input type="text" class="form-control" name="main_presenter" value="<? echo $loggedInUser->user_id; ?>" style="display:none;" />
					  <div class="panel-body">
		          <div class="form-group">
		              <label class="control-label">First Name</label>
		              <input type="text" class="form-control" name="first_name" value="<? echo $loggedInUser->first_name; ?>" disabled="disabled" />
		          </div>
		          <div class="form-group">
		              <label class="control-label">Last name</label>
		              <input type="text" class="form-control" name="last_name" value="<? echo $loggedInUser->last_name; ?>" disabled="disabled" />
		          </div>
		
		          <div class="form-group">
		              <label class="control-label">Email address</label>
		              <input type="text" class="form-control" name="email" value="<? echo $loggedInUser->email; ?>" disabled="disabled" />
		          </div>
					  </div>
					</div>
				</div>
				
				<div class="col-lg-4">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Presenter Biography</h4></div>
					  <div class="panel-body">
		          <div class="form-group">
						  	<textarea class="form-control" rows="8" name="presenter_bio" id="presenter_bio" placeholder="Tell us about yourself"></textarea>
		          </div>
					  </div>
					</div>
				</div>
				
				<div class="col-lg-4">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Co-Presenters</h4></div>
					  <div class="panel-body">
				      <label class="control-label">Options</label>
              <div class="row form-group">
				        <div class="col-lg-9">
				            <input type="text" class="form-control" name="copresenter[]" placeholder="Invite by email" />
				        </div>
				        <div class="col-lg-3">
				            <button type="button" class="btn btn-success addButton"><span class="glyphicon glyphicon-plus"></span></button>
				        </div>
				    	</div>
				    	<!-- The option field template containing an option field and a Remove button -->
					    <div class="row form-group hide" id="copresenterTemplate">
				        <div class="col-lg-9">
				          <input class="form-control" type="text" name="copresenter[]" placeholder="Invite by email" />
				        </div>
				        <div class="col-lg-3">
				          <button type="button" class="btn btn-danger removeButton"><span class="glyphicon glyphicon-remove"></span></button>
				        </div>
					    </div>
					  </div>
					</div>
				</div>
			</div><!-- /.row -->
			
			<div class="row">
				<div class="col-lg-8">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Presentation Information</h4></div>
					  <div class="panel-body">
						  <div class="col-lg-6">
			          <div class="form-group">
			              <label class="control-label">Title</label>
			              <input type="text" class="form-control" name="presentation_title" />
			          </div>
			
			          <div class="form-group">
			              <label class="control-label">Abstract</label>
			              <textarea class="form-control" rows="8" name="presentation_abstract" id="presentation_abstract" placeholder="A description of your presentation."></textarea>
			          </div>
						  </div>
						  
						  <div class="col-lg-6">
							  <div class="form-group">
								  <label for="presentation_track">Track</label>
								  <select class="form-control" id="presentation_track" name="presentation_track">
								    <option selected="selected" value="">Select a Track</option>
								    <option value="1">ED: GIS in Education</option>
								    <option value="2">NA: Natural Resources Management</option>
								    <option value="3">EM: Emergency Preparedness</option>
								    <option value="4">AC: GIS in Action</option>
								  </select>
								</div>
								
								<div class="form-group">
	                <label class="control-label">Request a Day</label>
	                <div class="input-group date" id="presentation_day_request">
	                    <input type="text" class="form-control" name="presentation_day_request" />
	                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	                </div>
	              </div>
						  </div>
					  </div>
					</div>
				</div>
					
				<div class="col-lg-4">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Map / Poster Gallery</h4></div>
					  <div class="panel-body">
						  <div class="form-group">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="gallery" id="gallery" /> <strong>Register Map / Poster Gallery</strong>
                  </label>
                </div>
              </div>
              
						  <div id="gallery_info" style="display: none;">
							  <div class="form-group">
								  <label for="gallery_expertise_level">Expertise Level</label>
								  <select class="form-control" id="gallery_expertise_level" name="gallery_expertise_level">
								    <option selected="selected" value="">Select an expertise level</option>
								    <option value="N">Novice</option>
								    <option value="I">Intermediate</option>
								    <option value="E">Expert</option>
								  </select>
								</div>
              
							  <div class="form-group">
	                <div class="checkbox">
	                  <label>
	                    <input type="checkbox" name="gallery_critique" id="gallery_critique" /> <strong>Be Critiqued?</strong>
	                  </label>
	                </div>
	              </div>
	              
                <div class="form-group">
                    <label class="control-label">Title</label>
                    <input class="form-control" type="text" name="gallery_title" />
                </div>
			
			          <div class="form-group">
			              <label class="control-label">Abstract</label>
			              <textarea class="form-control" rows="8" name="gallery_abstract" id="gallery_abstract" placeholder="A description of your map or poster gallery."></textarea>
			          </div>
              </div>
					 </div>
				</div>
			</div>
			</div><!-- /.row -->
			
			<div class="row text-center">
				<input type="submit" class="btn btn-lg btn-success" value="Submit" />
			</div><!-- /.row -->
		</form>
		<? } else if ($reg_type == 'exhibit') { ?>
		<form name='newExhibit' id="newExhibit" action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms text-left">
			<div class="row">
				<h1>Exhibition Registration</h1>
				<div class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Contact Person</h4></div>
		        <input type="text" class="form-control" name="first_name" value="<? echo $loggedInUser->user_id; ?>" disabled="disabled" style="display:none;" />
					  <div class="panel-body">
		          <div class="form-group">
		              <label class="control-label">First Name</label>
		              <input type="text" class="form-control" name="first_name" value="<? echo $loggedInUser->first_name; ?>" disabled="disabled" />
		          </div>
		          <div class="form-group">
		              <label class="control-label">Last name</label>
		              <input type="text" class="form-control" name="last_name" value="<? echo $loggedInUser->last_name; ?>" disabled="disabled" />
		          </div>
		
		          <div class="form-group">
		              <label class="control-label">Email address</label>
		              <input type="text" class="form-control" name="email" value="<? echo $loggedInUser->email; ?>" disabled="disabled" />
		          </div>
					  </div>
					</div>
				</div>
				
				<div class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Co-Exhibitors</h4></div>
					  <div class="panel-body">
				      <label class="control-label">Email Addresses</label>
              <div class="row form-group">
				        <div class="col-lg-9">
				            <input type="text" class="form-control" name="coexhibitor[]" placeholder="Invite by email" />
				        </div>
				        <div class="col-lg-3">
				            <button type="button" class="btn btn-success addButton"><span class="glyphicon glyphicon-plus"></span></button>
				        </div>
				    	</div>
				    	<!-- The option field template containing an option field and a Remove button -->
					    <div class="row form-group hide" id="coexhibitorTemplate">
				        <div class="col-lg-9">
				          <input class="form-control" type="text" name="coexhibitor[]" placeholder="Invite by email" />
				        </div>
				        <div class="col-lg-3">
				          <button type="button" class="btn btn-danger removeButton"><span class="glyphicon glyphicon-remove"></span></button>
				        </div>
					    </div>
					  </div>
					</div>
				</div>
			</div><!-- /.row -->
			
			<div class="row">
				
				
				<div class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Company Profile</h4></div>
					  <div class="panel-body">
		          <div class="form-group">
						  	<textarea class="form-control" rows="8" id="exhibit_comp_profile" placeholder="Tell us about yourself"></textarea>
		          </div>
					  </div>
					</div>
				</div>
				
				<div class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Special Requests</h4></div>
					  <div class="panel-body">
		          <div class="form-group">
						  	<textarea class="form-control" rows="8" id="exhibit_special_requests" placeholder="Tell us about yourself"></textarea>
		          </div>
					  </div>
					</div>
				</div>
				
			</div>
			</div><!-- /.row -->
		</form>
		<? } else if ($reg_type == 'sponsor') { ?>
		<form name='newSponsor' id="newSponsor" action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms text-left">
			<div class="row">
				<h1>Sponsor Registration</h1>
				<div class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Contact Person</h4></div>
		        <input type="text" class="form-control" name="first_name" value="<? echo $loggedInUser->user_id; ?>" disabled="disabled" style="display:none;" />
					  <div class="panel-body">
		          <div class="form-group">
	              <label class="control-label">First Name</label>
	              <input type="text" class="form-control" name="first_name" value="<? echo $loggedInUser->first_name; ?>" disabled="disabled" />
		          </div>
		          <div class="form-group">
	              <label class="control-label">Last name</label>
	              <input type="text" class="form-control" name="last_name" value="<? echo $loggedInUser->last_name; ?>" disabled="disabled" />
		          </div>
		
		          <div class="form-group">
	              <label class="control-label">Email address</label>
	              <input type="text" class="form-control" name="email" value="<? echo $loggedInUser->email; ?>" disabled="disabled" />
		          </div>
					  </div>
					</div>
				</div>
			
				<div class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Company Profile</h4></div>
					  <div class="panel-body">
		          <div class="form-group">
						  	<textarea class="form-control" rows="8" id="exhibit_comp_profile" placeholder="Tell us about yourself"></textarea>
		          </div>
		          <div class="form-group">
			          <label class="control-label">Company Logo</label>
			          <div class="form-group">
			            <input type="file" class="form-control" name="sponsor_logo" />
			            <span class="help-block text-right">Choose a pdf file with a size less than 1M.</span>
			          </div>
			        </div>
					  </div>
					</div>
				</div>
			</div><!-- /.row -->
				
			<div class="row">
				<div class="col-lg-6">
						<div class="panel panel-primary">
							<div class="panel-heading"><h4>Attendees</h4></div>
						  <div class="panel-body">
					      <label class="control-label">Email Addresses</label>
	              <div class="row form-group">
					        <div class="col-lg-9">
					            <input type="text" class="form-control" name="sponsor_attendees[]" placeholder="Invite by email" />
					        </div>
					        <div class="col-lg-3">
					            <button type="button" class="btn btn-success addButton"><span class="glyphicon glyphicon-plus"></span></button>
					        </div>
					    	</div>
					    	<!-- The option field template containing an option field and a Remove button -->
						    <div class="row form-group hide" id="sponsor_attendeesTemplate">
					        <div class="col-lg-9">
					          <input class="form-control" type="text" name="sponsor_attendees[]" placeholder="Invite by email" />
					        </div>
					        <div class="col-lg-3">
					          <button type="button" class="btn btn-danger removeButton"><span class="glyphicon glyphicon-remove"></span></button>
					        </div>
						    </div>
						  </div>
						</div>
					</div>
			</div><!-- /.row -->
		</form>
		<? } else if ($reg_type == 'attendee') { ?>
		<form name='newAttendee' id="newAttendee" action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms text-left">
		  <input type="text" class="form-control" name="newAttendee" value="1" style="display:none;" />
			<div class="row">
				<h1>Attendee Registration</h1>
				<div class="col-lg-6 col-lg-push-3">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Contact Information</h4></div>
					  <div class="panel-body">
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
							
							<div class="form-group text-center">
							  <input type="submit" class="btn btn-lg btn-success" value="Register Now!">
							</div>
					  </div>
					</div>
				</div>
			</div><!-- /.row -->
		</form>
		<? } ?>
	</section>
    <link rel="stylesheet" href="http://eonasdan.github.io/bootstrap-datetimepicker/content/bootstrap-datetimepicker.css"/>
    <script type="text/javascript" src="http://eonasdan.github.io/bootstrap-datetimepicker/scripts/moment.js"></script>
    <script type="text/javascript" src="http://eonasdan.github.io/bootstrap-datetimepicker/scripts/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
<?php if ($reg_type == 'presentation') { ?>
			$('#gallery').click(function(){
			    $('#gallery_info').toggle();
			});
			
			
			$('#presentation_day_request').datetimepicker({
				pickTime: false
			});
      $('#presentation_day_request').on('dp.change dp.show', function(e) {
          // Validate the date when user change it
          $('#newPresentation').data('bootstrapValidator').revalidateField('presentation_day_request');
          // You also can call it as following:
          // $('#defaultForm').bootstrapValidator('revalidateField', 'datetimePicker');
      });


			
			
	    // The maximum number of options
	    var MAX_OPTIONS = 3;
	
	    $('#newPresentation')
	        // Add button click handler
	        .on('click', '.addButton', function() {
	            var $template = $('#copresenterTemplate'),
	                $clone    = $template
	                                .clone()
	                                .removeClass('hide')
	                                .removeAttr('id')
	                                .insertBefore($template),
	                $option   = $clone.find('[name="copresenter[]"]');
	
	            // Add new field
	            $('#newPresentation').bootstrapValidator('addField', $option);
	        })
	
	        // Remove button click handler
	        .on('click', '.removeButton', function() {
	            var $row    = $(this).parents('.form-group'),
	                $option = $row.find('[name="copresenter[]"]');
	
	            // Remove element containing the option
	            $row.remove();
	
	            // Remove field
	            $('#newPresentation').bootstrapValidator('removeField', $option);
	        })
	
	        // Called after adding new field
	        .on('added.field.bv', function(e, data) {
	            // data.field   --> The field name
	            // data.element --> The new field element
	            // data.options --> The new field options
	
	            if (data.field === 'copresenter[]') {
	                if ($('#newPresentation').find(':visible[name="copresenter[]"]').length >= MAX_OPTIONS) {
	                    $('#newPresentation').find('.addButton').attr('disabled', 'disabled');
	                }
	            }
      })

      // Called after removing the field
      .on('removed.field.bv', function(e, data) {
         if (data.field === 'copresenter[]') {
              if ($('#newPresentation').find(':visible[name="copresenter[]"]').length < MAX_OPTIONS) {
                  $('#newPresentation').find('.addButton').removeAttr('disabled');
              }
          }
      });
<? } else if ($reg_type == 'exhibit') { ?>
      // The maximum number of options
	  var MAX_OPTIONS = 3;
	
	  $('#newExhibit')
	      // Add button click handler
	      .on('click', '.addButton', function() {
	          var $template = $('#coexhibitorTemplate'),
	              $clone    = $template
	                              .clone()
	                              .removeClass('hide')
	                              .removeAttr('id')
	                              .insertBefore($template),
	              $option   = $clone.find('[name="coexhibitor[]"]');
	
	          // Add new field
	          $('#newExhibit').bootstrapValidator('addField', $option);
	      })
	
	      // Remove button click handler
	      .on('click', '.removeButton', function() {
	          var $row    = $(this).parents('.form-group'),
	              $option = $row.find('[name="coexhibitor[]"]');
	
	          // Remove element containing the option
	          $row.remove();
	
	          // Remove field
	          $('#newExhibit').bootstrapValidator('removeField', $option);
	      })
	
	      // Called after adding new field
	      .on('added.field.bv', function(e, data) {
	          // data.field   --> The field name
	          // data.element --> The new field element
	          // data.options --> The new field options
	
	          if (data.field === 'coexhibitor[]') {
	              if ($('#newExhibit').find(':visible[name="coexhibitor[]"]').length >= MAX_OPTIONS) {
	                  $('#newExhibit').find('.addButton').attr('disabled', 'disabled');
	              }
	          }
      })

      // Called after removing the field
      .on('removed.field.bv', function(e, data) {
         if (data.field === 'coexhibitor[]') {
              if ($('#newExhibit').find(':visible[name="coexhibitor[]"]').length < MAX_OPTIONS) {
                  $('#newExhibit').find('.addButton').removeAttr('disabled');
              }
          }
      });
<? } ?>
		});
	</script>

	<?php include("../models/footer.php"); ?>
</body>
</html>

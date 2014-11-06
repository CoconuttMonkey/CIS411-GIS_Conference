<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
if(!isUserLoggedIn()) { header("Location: login.php"); die(); }

if (isset($_POST['newPresentation'])) {
		
	$main_presenter_id = $_POST["main_presenter"];
	$main_presenter_bio = $_POST["presenter_bio"];
	$title = $_POST["presentation_title"];
	$abstract = $_POST["presentation_abstract"];
	$track = $_POST["presentation_track"];
	$day_request = $_POST["day_request"];
	$copresenters = $_POST["copresenters"];
	
	// Data Validation
	if ($main_presenter_bio == "") $errors[] = lang('PRESENTER_NO_BIO');
	if ($title == "") $errors[] = lang('PRESENTATION_NO_TITLE');
	if ($abstract == "") $errors[] = lang('PRESENTATION_NO_ABSTRACT');
	
	if (!count($errors)) {
		
		if (!addPresentation($main_presenter_id, $main_presenter_bio, $title, $abstract, $track, $day_request)) {
			$errors[] = lang("ERROR");
		} else {
			$successes[] = lang("PRES_REQUEST_SUCCESS");
		}
	}
}

$languages = getLanguageFiles(); //Retrieve list of language files
require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<div class="row">
				<? echo resultBlock($errors,$successes); ?>
		</div>
		<div class='row'>
			<div class='col-lg-12'>
				<h1>Presentation Request</h1>
				<form name='newPresentation' id="newPresentation" action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms text-left">
				  <input type="text" class="form-control" name="newPresentation" value="1" style="display:none;" />
					<div class="col-lg-4">
						<div class="panel panel-primary">
							<div class="panel-heading"><h4>Main Presenter</h4></div>
			        <input type="text" class="form-control" name="main_presenter" value="<? echo $loggedInUser->user_id; ?>" style="display:none;" />
						  <div class="panel-body">
			          <div class="form-group">
				          <label>Presenter Biography</label>
							  	<textarea class="form-control" rows="8" name="presenter_bio" id="presenter_bio" placeholder="Tell us about yourself" required></textarea>
			          </div>
							</div>
						</div>
						
						<div class="panel panel-primary">
							<div class="panel-heading"><h4>Co-Presenters</h4></div>
						  <div class="panel-body">
	              <div class="form-group">
					        <input type="text" class="form-control" name="copresenter[]" placeholder="Invite by email" />
					    	</div>
	              <div class="form-group">
					        <input type="text" class="form-control" name="copresenter[]" placeholder="Invite by email" />
					    	</div>
	              <div class="form-group">
					        <input type="text" class="form-control" name="copresenter[]" placeholder="Invite by email" />
					    	</div>
							</div>
						</div>
					</div><!-- /.col-lg-4 -->
						<div class="col-lg-8">
							<div class="panel panel-primary">
								<div class="panel-heading"><h4>Presentation Information</h4></div>
							  <div class="panel-body">
								  <div class="col-lg-6">
					          <div class="form-group">
					              <label class="control-label">Title</label>
					              <input type="text" class="form-control" name="presentation_title" required />
					          </div>
					
					          <div class="form-group">
					              <label class="control-label">Abstract</label>
					              <textarea class="form-control" rows="8" name="presentation_abstract" id="presentation_abstract" placeholder="A description of your presentation." required></textarea>
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
										  <label for="day_request">Request a Day</label>
										  <select class="form-control" id="day_request" name="day_request">
										    <option selected="selected" value="">No Preference</option>
										    <option value="Thursday">Thursday</option>
										    <option value="Friday">Friday</option>
										  </select>
			              </div>
								  </div>
							  </div>
							</div>
						</div>
							
						<div class="col-lg-8">
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
			</div>
		</div>
	</div>
  <link rel="stylesheet" href="http://eonasdan.github.io/bootstrap-datetimepicker/content/bootstrap-datetimepicker.css"/>
  <script type="text/javascript" src="http://eonasdan.github.io/bootstrap-datetimepicker/scripts/moment.js"></script>
  <script type="text/javascript" src="http://eonasdan.github.io/bootstrap-datetimepicker/scripts/bootstrap-datetimepicker.js"></script>
	<script>
		$(document).ready(function() {
			
			
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
    });	
	</script>
	<?php 
		include("models/footer.php");
		include("models/BootstrapJavaScript.php"); 
	 ?>
</body>
</html>

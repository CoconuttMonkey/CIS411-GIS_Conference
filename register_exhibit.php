<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
if(!isUserLoggedIn()) { header("Location: ../login.php"); die(); }

if (isset($_POST['newExhibit'])) {

	$conference_id = date("Y");
	$contact_person = $_POST['contact_person'];
	$company_profile = $_POST['company_profile'];
	$special_requests = $_POST['special_requests'];
	
	if ($company_profile != "") {
		
		if (!newExhibit($conference_id, $company_profile, $special_requests, $contact_person)) {
			$errors[] = lang("EXHIBIT_REQUEST_FAILED");
		} else {
			$successes[] = lang("EXHIBIT_REQUEST_SUCCEEDED");
		}
		
	} else {
		$errors[] = lang("COMPANY_PROFILE_REQUIRED");
	}
}

require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<div class='row'>
			<div class='col-lg-12'>
				<h1>Exhibition Registration</h1>
				<? echo resultBlock($errors,$successes); ?>
				<form name='newExhibit' id="newExhibit" action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms text-left">
			<div class="row">
				<div class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Contact Person</h4></div>
		        <input type="text" class="form-control" name="newExhibit" value="1" style="display:none;" />
		        
		        <input type="text" class="form-control" name="contact_person" value="<? echo $loggedInUser->user_id; ?>" style="display:none;" />
					  <div class="panel-body">
		          <div class="form-group">
		              <label class="control-label">First Name</label>
		              <input type="text" class="form-control" name="first_name" value="<? echo $loggedInUser->first_name; ?>" disabled />
		          </div>
		          <div class="form-group">
		              <label class="control-label">Last name</label>
		              <input type="text" class="form-control" name="last_name" value="<? echo $loggedInUser->last_name; ?>" disabled />
		          </div>
		
		          <div class="form-group">
		              <label class="control-label">Email address</label>
		              <input type="text" class="form-control" name="email" value="<? echo $loggedInUser->email; ?>" disabled />
		          </div>
					  </div>
					</div>
				</div>
				
				<div class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Co-Exhibitors</h4></div>
					  <div class="panel-body">
				      <label class="control-label">Email Addresses</label>
              <div class="form-group">
				        <input type="text" class="form-control" name="coexhibitor[]" placeholder="Invite by email" />
				    	</div>
              <div class="form-group">
				        <input type="text" class="form-control" name="coexhibitor[]" placeholder="Invite by email" />
				    	</div>
              <div class="form-group">
				        <input type="text" class="form-control" name="coexhibitor[]" placeholder="Invite by email" />
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
						  	<textarea class="form-control" rows="8" name="company_profile" placeholder="Tell us about yourself"></textarea>
		          </div>
					  </div>
					</div>
				</div>
				
				<div class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Special Requests</h4></div>
					  <div class="panel-body">
		          <div class="form-group">
						  	<textarea class="form-control" rows="8" name="special_requests" placeholder="Tell us about yourself"></textarea>
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
			
			$('.forms').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            title: {
                validators: {
                    notEmpty: {
                        message: 'A title is required and cannot be empty'
                    }
                }
            },
            abstract: {
                validators: {
                    notEmpty: {
                        message: 'A description is required'
                    }
                }
            },
            presenter_bio: {
                validators: {
                    notEmpty: {
                        message: 'A short biography is required'
                    }
                }
            }
          }  
        }
    	});
			
			
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

<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
if(!isUserLoggedIn()) { header("Location: ../login.php"); die(); }

require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<div class='row'>
			<div class='col-lg-12'>
				<h1>Exhibition Registration</h1>
				<? echo resultBlock($errors,$successes); ?><form name='newExhibit' id="newExhibit" action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms text-left">
			<div class="row">
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
	<?php include("models/footer.php"); ?>
</body>
</html>

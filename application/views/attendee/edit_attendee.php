<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-md-4 col-md-push-4">
			<h2>Edit Contact Info</h2>
			
			<div id="infoMessage"><?php echo $message;?></div>
			
			<?php echo form_open("attendee/edit/".$user_id);?>
			      <div class="form-group">
			        <label>Address Line 1</label>
			        <?php echo form_input($address_1);?>
			      </div>
			      
			      <div class="form-group">
			        <label>Address Line 2</label>
			        <?php echo form_input($address_2);?>
			      </div>
			      
			      <div class="form-group row">
				      <div class="col-xs-8">
			        <label>City</label>
			        	<?php echo form_input($city);?>
					      </div>
			        <div class="col-xs-4">
			        	<label>State</label>
								<?php echo form_dropdown('state', $state_options, $state, 'class="form-control"');?>
			        </div>
			      </div>
			      
			      <div class="form-group">
			        <label>Zip Code</label>
			        <?php echo form_input($zip);?>
			      </div>
			      
			      <div class="form-group">
			        <label>Country</label>
			        <?php echo form_input($country);?>
			      </div>
			      
			      <div class="form-group">
			        <label>Admission Type</label>
			        <?php echo form_dropdown('admission_type', $admission_options, $admission_type, 'class="form-control" id="admission_type"');?>
			      </div>
			
			
			      <p><input type="submit" class="btn btn-block btn-fresh">
					</p>
			
			<?php echo form_close();?>
		</div>
	</section>
</div>

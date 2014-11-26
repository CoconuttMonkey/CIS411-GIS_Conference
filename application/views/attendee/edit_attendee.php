<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-md-4 col-md-push-4">
			<h2>Edit Attendee</h2>
			
			<div id="infoMessage"><?php echo $message;?></div>
			
			<?php echo form_open("attendee/register");?>
						<input type="text" name="user_id" value="<?=$user_id?>" hidden>
			
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
								<?php echo form_input($state);?>
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
	            <div class="radio">
							  <label>
							  	<input type="radio" name="admission_type" value="1">1 Day Pass $xx
							  </label>
							</div>
							
	            <div class="radio">
							  <label>
							  	<input type="radio" name="admission_type" value="2">2 Day Pass $xx
							  </label>
							</div>
							
							<div class="radio">
							  <label>
							  	<input type="radio" name="admission_type" value="3">Student / Faculty 
							  </label>
							</div>
							
							<div class="radio">
							  <label>
							  	<input type="radio" name="admission_type" value="4">Presenter
							  </label>
							</div>
							
							<div class="radio">
							  <label>
							  	<input type="radio" name="admission_type" value="5">Exhibitor $xxx
							  </label>
							</div>
						</div>
			
			
			      <p><input type="submit" class="btn btn-block btn-fresh"></p>
			
			<?php echo form_close();?>
		</div>
	</section>
</div>

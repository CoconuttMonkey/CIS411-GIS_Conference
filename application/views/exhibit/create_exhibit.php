<div class="container" style="margin-top: 100px;">
	<section class="row">
		<div class="col-sm-12">
			<h2>Register Exhibit</h2>
			<p>Send a request to provide an Exhibit.</p>
			
			<div id="infoMessage"><?php echo $message;?></div>
		</div>
			<?php echo form_open("exhibit/register");?>
			<div class="col-sm-6">
				<input type="text" name="user_id" value="<?=$user_id?>" hidden>
				<input type="text" name="conference_id" value="<?=$conference_id?>" hidden>
	
	      <div class="form-group">
	        <label>Company Profile</label>
	        <?php echo form_textarea($company_profile);?>
	      </div>
			</div>
			
			<div class="col-sm-6">
	      
	      <div class="form-group">
	        <label>Special Requests</label>
	        <?php echo form_textarea($special_requests);?>
	      </div>
	      
	      <p><input type="submit" class="btn btn-block btn-fresh"></p>
			</div>
			
			<?php echo form_close();?>
		</div>
	</section>
</div>

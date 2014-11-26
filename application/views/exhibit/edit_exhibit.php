<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-sm-12">
			<h2>Register Presentation</h2>
			<p>Send a request to present.</p>
			
			<div id="infoMessage"><?php echo $message;?></div>
		</div>
			<?php echo form_open("exhibit/edit/".$exhibit_id);?>
			<div class="col-sm-6">
				<input type="text" name="user_id" value="<?=$user_id?>" hidden>
	
	      <div class="form-group">
	        <label>Company Profile</label>
	        <?php echo form_textarea($company_profile);?>
	      </div>
	      
	      <div class="form-group">
	        <label>Special Requests</label>
	        <?php echo form_textarea($company_profile);?>
	      </div>
			</div>
			
			<div class="col-sm-6">
	      <? if ($this->ion_auth->is_admin()): ?>
		      <label>Admin Options</label><br>
	      
	      <div class="form-group">
	        <label>Table Location</label>
	        <?php echo form_input($table_loc);?>
	      </div>
	      
	      <div class="form-group">
		      <input id="paid" name='paid' type="checkbox" value='yes' <? if($paid['value'] == 'yes') echo "checked"; ?> data-on-color="success" data-on-text="Paid" data-off-color="danger" data-off-text="Unpaid" >
	      </div>
	      <? endif; ?>
	      
	      <p><input type="submit" class="btn btn-block btn-fresh" value="Update"></p>
			</div>
			
			<?php echo form_close();?>
		</div>
	</section>
</div>

<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-md-4 col-md-push-4">
			<h2>Site Settings</h2>
			<p>These settings effect the entire web site.</p>
			
			<div id="infoMessage"><?php echo $message;?></div>
			<?php echo form_open("auth/settings");?>
			
		  <div class="form-group">
		    <label>Active Conference ID</label>
	      <?php echo form_dropdown('active_conference', $conf_list, $active_conf, 'class="form-control" id="active_conference"');?>
		  </div>
			
		  <div class="form-group">
		    <label>Conference Contact Email</label>
	      <input name="contact_email" type="email" class="form-control" value="<?=$settings['contact_email']?>" required>
		  </div>
			
		  <div class="form-group">
		    <label>Billing Contact Email</label>
	      <input name="billing_email" type="email" class="form-control" value="<?=$settings['billing_email']?>" required>
		  </div>
			
			<input type="submit" class="btn btn-block btn-fresh" value="Save">
			
			<?php echo form_close();?>
		</div>
	</section>
</div>
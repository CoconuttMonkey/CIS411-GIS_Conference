<div class="container" style="margin-top: 100px;">
	<section class="col-sm-6 col-sm-push-3">
		<div class="col-sm-12">
			<h2>Send Email</h2>
			<p>This form allows you to send a mass email to <strong><?=$email_group?></strong></p>
			
			<div id="infoMessage"><?php echo $message;?></div>
		</div>
			<?php echo form_open("email/attendees");?>
				<div class="col-sm-12">
		      <div class="form-group">
		        <label>Subject</label>
		        <?php echo form_input($subject);?>
		      </div>
		      
		      <div class="form-group">
		        <label>Message</label>
		        <?php echo form_textarea($message_body);?>
		      </div>
		      
		      <p class="text-center"><input type="submit" class="btn btn-fresh" value="Send"></p>
				</div>
			
			<?php echo form_close();?>
		</div>
	</section>
</div>

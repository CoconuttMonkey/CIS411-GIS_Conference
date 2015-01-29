<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-md-4 col-md-push-4">
			<h1><?php echo lang('forgot_password_heading');?></h1>
			<p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>
			
			<div id="alert alert-danger"><?php echo $message;?></div>
			
			<?php echo form_open("auth/forgot_password");?>
			
      <div class="form-group">
      	<label for="email"><?php echo sprintf(lang('forgot_password_email_label'), $identity_label);?></label> <br />
      	<?php echo form_input($email);?>
      </div>
			
			<p><?php echo form_submit('submit', lang('forgot_password_submit_btn'));?></p>
			
			<?php echo form_close();?>
		</div>
	</section>
</div>
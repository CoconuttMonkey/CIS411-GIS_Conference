<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-md-4 col-md-push-4">
			<h2><?php echo lang('login_heading');?></h2>
			<p><?php echo lang('login_subheading');?></p>
			
			<div id="infoMessage"><?php echo $message;?></div>
			
			<?php echo form_open("auth/login");?>
			
			  <div class="form-group">
			    <?php echo lang('login_identity_label', 'identity');?>
			    <?php echo form_input($identity);?>
			  </div>
			
			  <div class="form-group">
			    <?php echo lang('login_password_label', 'password');?>
			    <?php echo form_input($password);?>
			  </div>
			
			  <div class="form-group h5 text-center">
			    <?php echo lang('login_remember_label', 'remember');?>
			    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
			  </div>
			
			
			  <p><?php echo form_submit('submit', lang('login_submit_btn'));?></p>
			
			<?php echo form_close();?>
			
			<p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>
		</div>
	</section>
</div>
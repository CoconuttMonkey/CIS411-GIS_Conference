<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-md-4 col-md-push-4">			
			<h2><?php echo lang('deactivate_heading');?></h2>
			<p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>

			<?php echo form_open("auth/deactivate/".$user->id);?>
			
			  <div class="form-group">
			  	<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
			    <input type="radio" name="confirm" value="yes" checked="checked" />
			    <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
			    <input type="radio" name="confirm" value="no" />
			  </div>
			
			  <?php echo form_hidden($csrf); ?>
			  <?php echo form_hidden(array('id'=>$user->id)); ?>
			
			  <div class="form-group">
				  <?php echo form_submit('submit', lang('deactivate_submit_btn'));?>
			  </div>
			
			<?php echo form_close();?>
		</div>
	</section>
</div>
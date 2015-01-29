<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-md-4 col-md-push-4">						
			<h2><?php echo lang('create_group_heading');?></h2>
			<p><?php echo lang('create_group_subheading');?></p>
			
			<div id="infoMessage"><?php echo $message;?></div>

			<?php echo form_open("auth/create_group");?>
			
			      <div class="form-input">
			            <?php echo lang('create_group_name_label', 'group_name');?> <br />
			            <?php echo form_input($group_name);?>
			      </div>
			
			      <div class="form-input">
			            <?php echo lang('create_group_desc_label', 'description');?> <br />
			            <?php echo form_input($description);?>
			      </div>
			      <br>
			      <div class="form-input">
			      	<?php echo form_submit('submit', lang('create_group_submit_btn'));?>
			      </div>
			
			<?php echo form_close();?>
		</div>
	</section>
</div>
<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-md-12">
			<h1>Create Conference</h1>
			<div id="infoMessage"><?php echo $message;?></div>
		</div>
		<?php echo form_open("conference/setup_new_conference");?>
			<div class="col-md-6 col-md-push-3">
	      <div class="form-group">
          <?php echo lang('create_conf_id_label', 'conf_id');?> <br />
          <?php echo form_input($conf_id);?>
	      </div>
	
	      <div class="form-group">
          <?php echo lang('create_conf_title_label', 'conf_title');?> <br />
          <?php echo form_input($conf_title);?>
	      </div>
	
	      <div class="form-group">
          <?php echo lang('create_conf_prefix_label', 'prefix');?> <br />
          <?php echo form_input($prefix);?>
	      </div>
	
	      <div class="form-group">
          <?php echo lang('create_conf_theme_label', 'theme');?> <br />
          <?php echo form_input($theme);?>
	      </div>
	
				<div class="row">
		      <div class="form-group col-sm-6">
            <?php echo lang('create_conf_startdate_label', 'startdate');?> <br />
            <?php echo form_input($start_date);?>
		      </div>
		
		      <div class="form-group col-sm-6">
            <?php echo lang('create_conf_enddate_label', 'enddate');?> <br />
            <?php echo form_input($end_date);?>
		      </div>
				</div>
	
				<div class="row">
		      <div class="form-group col-sm-6">
            <?php echo lang('create_conf_regopendate_label', 'regopendate');?> <br />
            <?php echo form_input($reg_open_date);?>
		      </div>
		
		      <div class="form-group col-sm-6">
            <?php echo lang('create_conf_regclosedate_label', 'regclosedate');?> <br />
            <?php echo form_input($reg_close_date);?>
		      </div>
				</div>
	
	      <div class="form-group">
          <?php echo lang('create_conf_abstract_label', 'abstract');?> <br />
          <?php echo form_textarea($frontpage_content);?>
	      </div>
	      
				<div class='col-md-4 col-md-push-4'><?php echo form_submit('submit', lang('create_conference_submit_btn'));?></div>
			</div>
			
			
			<?php echo form_close();?>
	</section>
</div>

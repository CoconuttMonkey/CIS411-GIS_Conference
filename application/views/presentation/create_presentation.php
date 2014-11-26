<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-sm-12">
			<h2>Register Presentation</h2>
			<p>Send a request to present.</p>
			
			<div id="infoMessage"><?php echo $message;?></div>
		</div>
			<?php echo form_open("presentation/register");?>
			<div class="col-sm-6">
				<input type="text" name="user_id" value="<?=$user_id?>" hidden>
				<input type="text" name="conference_id" value="<?=$conference_id?>" hidden>
	
	      <div class="form-group">
	        <label>Title</label>
	        <?php echo form_input($title);?>
	      </div>
	      
	      <div class="form-group">
	        <label>Abstract</label>
	        <?php echo form_textarea($abstract);?>
	      </div>
	      
	      <div class="form-group">
	        <label>Track</label>
	        <?php echo form_input($track_id);?>
	      </div>
	      
	      <div class="form-group">
	        <label>Week Day</label>
	        <?php echo form_dropdown('week_day', $weekday_options, 'nopref', 'class="form-control" id="week_day"');?>
	      </div>
			</div>
			
			<div class="col-sm-6">
	      <div class="form-group">
	        <label>Presenter Biography</label>
	        <?php echo form_textarea($biography);?>
	      </div>
			
	      <div class="form-group">
	        <label>Co-Presenter 1 Email</label>
	        <?php echo form_input($copresenter_1);?>
	      </div>
				
	      <div class="form-group">
	        <label>Co-Presenter 2 Email</label>
	        <?php echo form_input($copresenter_2);?>
	      </div>
				
	      <div class="form-group">
	        <label>Co-Presenter 3 Email</label>
	        <?php echo form_input($copresenter_3);?>
	      </div>
	      
	      <p><input type="submit" class="btn btn-block btn-fresh"></p>
			</div>
			
			<?php echo form_close();?>
		</div>
	</section>
</div>

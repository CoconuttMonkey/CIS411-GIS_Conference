<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-sm-12">
			<h2>Register Presentation</h2>
			<p>Send a request to present.</p>
			
			<div id="infoMessage"><?php echo $message;?></div>
		</div>
			<?php echo form_open("presentation/edit/".$presentation_id);?>
			<div class="col-sm-6">
				<input type="text" name="user_id" value="<?=$user_id?>" hidden>
	
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
	        <?php echo form_dropdown('week_day', $weekday_options, $week_day, 'class="form-control" id="week_day"');?>
	      </div>
			</div>
			
			<div class="col-sm-6">
	      <div class="form-group">
	        <label>Presenter Biography</label>
	        <?php echo form_textarea($biography);?>
	      </div>
	      
	      <? if ($this->ion_auth->is_admin()): ?>
		      <label>Admin Options</label><br>
	      <div class="form-group row">
		     	<div class="col-xs-6">
		        <label>Start Time</label>
		        <?php echo form_input($start_time);?>
		     	</div>
		     	<div class="col-xs-6">
		        <label>End Time</label>
		        <?php echo form_input($end_time);?>
		     	</div>
	      </div>
	      
	      <div class="form-group">
	        <label>Room</label>
	        <?php echo form_input($room_id);?>
	      </div>
	      
	      <div class="form-group">
		      <input id="active" name='active' type="checkbox" value='yes' <? if($active['value'] == 'yes') echo "checked"; ?> data-on-color="success" data-on-text="Active" data-off-color="danger" data-off-text="Pending" >
	      </div>
	      <? endif; ?>
	      
	      <p><input type="submit" class="btn btn-block btn-fresh" value="Update"></p>
			</div>
			
			<?php echo form_close();?>
		</div>
	</section>
</div>

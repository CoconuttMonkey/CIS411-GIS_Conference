<div class="container" style="margin-top: 100px;">
	<section class="row">
		<div class="col-sm-12">
			<h2>Edit Presentation</h2>
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
	        <?php echo form_dropdown('track_id', $track_options, $track_id, 'class="form-control" id="track_id"');?>
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
	        <?php echo form_dropdown('room_id', $room_options, $room_id, 'class="form-control" id="room_id"');?>
	      </div>
	      
	      <div class="form-group">
		      <input id="active" name='scheduled' type="checkbox" value='yes' <? if($scheduled['value'] == 'yes') echo "checked"; ?> data-on-color="success" data-on-text="Active" data-off-color="danger" data-off-text="Pending" >
	      </div>
	      <? endif; ?>
	      
	      <div class="form-group">
	      <? if ($attachment) : ?>
	        <a href="<?= site_url('download/presentation_attachment/'.$presentation_id) ?>" class="btn btn-sky">Download Attachment</a>
	      <? endif; ?>
	        <a id="delete" href="<?= site_url('presentation/withdraw/'.$presentation_id) ?>" class="btn btn-hot">Withdraw Presentation</a>
	      </div>
	      
	      <p><input type="submit" class="btn btn-block btn-fresh" value="Update"></p>
			</div>
			
			<?php echo form_close();?>
		</div>
	</section>
</div>

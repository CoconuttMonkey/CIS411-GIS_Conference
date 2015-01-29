<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-md-12">
			<h1>Add Tracks &amp; Rooms</h1>
			<div id="infoMessage"><?php echo $message;?></div>
		</div>
		<?php echo form_open("conference/add_track_room/$conf_id");?>
		<div class="col-md-6">
			<h4>Tracks</h4>
			<div class="form-group row">
				<div class="col-xs-3">
	        Acronym
				</div>
				<div class="col-xs-9">
	        Name
				</div>
			</div>
			<div class="form-group row">
				<div class="col-xs-3">
					<input type="text" name="track_acronym[0]" class="form-control" required>
				</div>
				<div class="col-xs-9">
					<input type="text" name="track_name[0]" class="form-control" required>
				</div>
			</div>
			
			<div class="form-group row">
				<div class="col-xs-3">
					<input type="text" name="track_acronym[1]" class="form-control" required>
				</div>
				<div class="col-xs-9">
					<input type="text" name="track_name[1]" class="form-control" required>
				</div>
			</div>
		</div>
				
		<div class="col-md-6">
			<h4>Rooms</h4>
			<div class="form-group row">
				<div class="col-xs-3">
	        Number
				</div>
				<div class="col-xs-9">
	        Building
				</div>
			</div>
			<div class="form-group row">
				<div class="col-xs-3">
					<input type="text" name="room_number[0]" class="form-control" required>
				</div>
				<div class="col-xs-9">
					<input type="text" name="room_building[0]" class="form-control" required>
				</div>
			</div>
			
			<div class="form-group row">
				<div class="col-xs-3">
					<input type="text" name="room_number[1]" class="form-control" required>
				</div>
				<div class="col-xs-9">
					<input type="text" name="room_building[1]" class="form-control" required>
				</div>
			</div>
	  </div> 
		
		<div class='col-md-4 col-md-push-4'><?php echo form_submit('submit', lang('add_track_room_submit_btn'));?></div>

	<?php echo form_close();?>
	</section>
</div>

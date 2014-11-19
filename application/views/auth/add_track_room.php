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
          <?php echo form_input($track1_acronym);?>
				</div>
				<div class="col-xs-9">
          <?php echo form_input($track1_name);?>
				</div>
			</div>
			
			<div class="form-group row">
				<div class="col-xs-3">
          <?php echo form_input($track2_acronym);?>
				</div>
				<div class="col-xs-9">
          <?php echo form_input($track2_name);?>
				</div>
			</div>
			
			<div class="form-group row">
				<div class="col-xs-3">
          <?php echo form_input($track3_acronym);?>
				</div>
				<div class="col-xs-9">
          <?php echo form_input($track3_name);?>
				</div>
			</div>
			
			<div class="form-group row">
				<div class="col-xs-3">
          <?php echo form_input($track4_acronym);?>
				</div>
				<div class="col-xs-9">
          <?php echo form_input($track4_name);?>
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
          <?php echo form_input($room1_number);?>
				</div>
				<div class="col-xs-9">
          <?php echo form_input($room1_building);?>
				</div>
			</div>
			
			<div class="form-group row">
				<div class="col-xs-3">
          <?php echo form_input($room2_number);?>
				</div>
				<div class="col-xs-9">
          <?php echo form_input($room2_building);?>
				</div>
			</div>
			
			<div class="form-group row">
				<div class="col-xs-3">
          <?php echo form_input($room3_number);?>
				</div>
				<div class="col-xs-9">
          <?php echo form_input($room3_building);?>
				</div>
			</div>
			
			<div class="form-group row">
				<div class="col-xs-3">
          <?php echo form_input($room4_number);?>
				</div>
				<div class="col-xs-9">
          <?php echo form_input($room4_building);?>
				</div>
			</div>
	  </div> 
		
		<div class='col-md-4 col-md-push-4'><?php echo form_submit('submit', lang('add_track_room_submit_btn'));?></div>

	<?php echo form_close();?>
	</section>
</div>

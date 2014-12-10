<div class="container" style="margin-top: 100px;">
	<div class="col-sm-6 col-sm-push-3">
		<h2><?=$header?></h2>
		<div id="infoMessage"><?php echo $message;?></div>
		<?php echo form_open_multipart($form_name);?>
	
			<input type="file" class="form-control" name="upload_data" size="20" />
			<br /><br />
	
			<input type="submit" class="btn btn-fresh" value="Upload" />
		</form>
	</div>
</div>
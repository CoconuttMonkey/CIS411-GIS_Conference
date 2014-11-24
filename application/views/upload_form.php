<div class="container" style="margin-top: 50px;">
	<div class="col-sm-6 col-sm-push-3">
		<div id="infoMessage"><?php echo $message;?></div>
		<?php echo form_open_multipart('upload/sponsor_logo/'.$id);?>
	
			<input type="file" class="form-control" name="userfile" size="20" />
			<br /><br />
	
			<input type="submit" class="btn btn-fresh" value="Upload" />
		</form>
	</div>
</div>
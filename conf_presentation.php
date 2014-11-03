<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
$presentationId = $_GET['id'];

//Check if selected permission level exists

if(!presentationExists($presentationId)){
	header("Location: ../conf_presentations.php"); die();	
}

// ALL UPDATE FUNCTIONS HERE

$presentationDetails = fetchPresentationDetails($presentationId); 
require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<div class='row'>
			<div class='col-lg-12'>
				<h1><?= $pageTitle ?></h1>
				<? echo resultBlock($errors,$successes); ?>
				<form name='newPresentation' id="newPresentation" action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms text-left">
				  <input type="text" class="form-control" name="newPresentation" value="1" style="display:none;" />
					<div class="row">
						<div class="col-lg-4">
							<div class="panel panel-primary">
								<div class="panel-heading"><h4>Main Presenter</h4></div>
							  <div class="panel-body">
				          <div class="form-group">
			              <label class="control-label">ID</label>
			              <input type="text" class="form-control" name="first_name" value="<?= $presentationDetails['main_presenter_id']?>" disabled="disabled" />
				          </div>
				          
				          <div class="form-group">
			              <label class="control-label">Name</label>
			              <input type="text" class="form-control" name="last_name" value="<?= $presentationDetails['main_presenter_name']?>" disabled="disabled" />
				          </div>
				          
				          <div class="form-group">
				             <label class="control-label">Biography</label>
								  	<textarea class="form-control" rows="8" name="presenter_bio" id="presenter_bio" placeholder="Tell us about yourself"><?= $presentationDetails['main_presenter_bio']?></textarea>
				          </div>
							  </div>
							</div>
							
							<div class="panel panel-primary">
								<div class="panel-heading"><h4>Co-Presenters</h4></div>
							  <div class="panel-body">
		              <div class="form-group">
						      	<label class="control-label">Co Presenter 1</label>
						        <input type="text" class="form-control" name="copresenter[]" />
						    	</div>
						    	
		              <div class="form-group">
						      	<label class="control-label">Co Presenter 2</label>
						        <input type="text" class="form-control" name="copresenter[]" />
						    	</div>
						    	
		              <div class="form-group">
						      	<label class="control-label">Co Presenter 3</label>
						        <input type="text" class="form-control" name="copresenter[]" />
						    	</div>
							  </div>
							</div>
						</div>
						
						<div class="col-lg-8">
							<div class="panel panel-primary">
								<div class="panel-heading"><h4>Presentation Information</h4></div>
							  <div class="panel-body">
								  <div class="col-lg-6">
					          <div class="form-group">
					              <label class="control-label">Title</label>
					              <input type="text" class="form-control" name="presentation_title" value="<?= $presentationDetails['title']?>" />
					          </div>
					
					          <div class="form-group">
					              <label class="control-label">Abstract</label>
					              <textarea class="form-control" rows="8" name="presentation_abstract" id="presentation_abstract" placeholder="A description of your presentation."><?= $presentationDetails['abstract']?></textarea>
					          </div>
								  </div>
								  
								  <div class="col-lg-6">
					          <div class="form-group">
					              <label class="control-label">Track</label>
					              <input type="text" class="form-control" name="track_title" value="<?= $presentationDetails['track_title']?>" />
					          </div>
					          <? if (isset($_GET['new'])) { ?>
										<div class="form-group">
										  <label for="day_request">Request a Day</label>
										  <select class="form-control" id="day_request" name="day_request">
										    <option selected="selected" value="">-</option>
										    <option>Wednesday</option>
										    <option>Thursday</option>
										    <option>Friday</option>
										  </select>
			              </div>
										<? } else { ?>
										<div class="form-group">
			                <label class="control-label">Presentation Time</label>
			                <p>
				                <?= $presentationDetails['week_day']?> from <?= date('h:ia', strtotime($presentationDetails['start_time']))?> to <?= date('h:ia', strtotime($presentationDetails['end_time']))?>
			                </p>
			              </div>
										
										<div class="form-group">
			                <label class="control-label">Presentation Location</label>
			                <p>
				                <?= $presentationDetails['building']." ".$presentationDetails['room_number']?>
			                </p>
			              </div>
										<div class="form-group">
				              <label><? //Display private checkbox
												if ($presentationDetails['active'] == 1){
													echo "<input type='checkbox' name='active' id='active' value='Yes' checked>";
												}
												else {
													echo "<input type='checkbox' name='active' id='active' value='No'>";	
												} ?>
											Active</label>
										</div>
			              <? } ?>
								  </div>
							  </div>
							</div>
							
							<div class="panel panel-primary">
								<div class="panel-heading"><h4>Map / Poster Gallery</h4></div>
							  <div class="panel-body">
								  <div class="form-group">
		                <div class="checkbox">
		                  <label>
		                    <input type="checkbox" name="gallery" id="gallery" /> <strong>Register Map / Poster Gallery</strong>
		                  </label>
		                </div>
		              </div>
		              
								  <div id="gallery_info">
									  <div class="form-group">
										  <label for="gallery_expertise_level">Expertise Level</label>
										  <select class="form-control" id="gallery_expertise_level" name="gallery_expertise_level">
										    <option selected="selected" value="">Select an expertise level</option>
										    <option value="N">Novice</option>
										    <option value="I">Intermediate</option>
										    <option value="E">Expert</option>
										  </select>
										</div>
		              
									  <div class="form-group">
			                <div class="checkbox">
			                  <label>
			                    <input type="checkbox" name="gallery_critique" id="gallery_critique" /> <strong>Be Critiqued?</strong>
			                  </label>
			                </div>
			              </div>
			              
		                <div class="form-group">
		                    <label class="control-label">Title</label>
		                    <input class="form-control" type="text" name="gallery_title" />
		                </div>
					
					          <div class="form-group">
					              <label class="control-label">Abstract</label>
					              <textarea class="form-control" rows="8" name="gallery_abstract" id="gallery_abstract" placeholder="A description of your map or poster gallery."></textarea>
					          </div>
		              </div>
							 </div>
						</div>
						</div>
					</div><!-- /.row -->
					
					<div class="row text-center">
						<input type="submit" class="btn btn-lg btn-success" value="Submit" />
					</div><!-- /.row -->
				</form>
			</div>
		</div>
	</div>
	<?php 
		include("models/footer.php");
		include("models/BootstrapJavaScript.php"); 
	?>
</body>
</html>
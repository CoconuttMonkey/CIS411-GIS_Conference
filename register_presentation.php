<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
require_once("models/class.newpresentation.php");

if (!securePage($_SERVER['PHP_SELF'])){die();}
//Prevent the user visiting the logged in page if he/she is already logged in
if(!isUserLoggedIn()) { header("Location: ../login.php"); die(); }

//print_r($_POST);

if (isset($_POST['newPresentation'])) {
	$errors = array();
	$main_presenter_id = $loggedInUser->user_id;
	$conference_id = date('Y');
	$main_presenter_bio = trim($_POST["main_presenter_bio"]);
	$copresenter = $_POST["copresenter"];
	$title = trim($_POST['presentation_title']);
	$abstract = trim($_POST['presentation_abstract']);
	$track_id = trim($_POST['track_id']);
	$day_request = trim($_POST['day_request']);
	
	//Construct a user object
	$presentation = new Presentation($conference_id, $title, $abstract, $track_id, $main_presenter_id, $main_presenter_bio);
	
	if(!$presentation->addPresentation()) {
		if($presentation->mail_failure) $errors[] = lang("MAIL_ERROR");
		if($presentation->sql_failure)  $errors[] = lang("SQL_ERROR");
	} else {
		$successes[] = lang("PRESENTATION_REGISTERED");
	}
}

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
				             <label class="control-label"><?= $loggedInUser->first_name." ".$loggedInUser->last_name."'s " ?>Biography</label>
								  	<textarea class="form-control" rows="8" name="main_presenter_bio" id="main_presenter_bio" placeholder="Tell us about yourself"></textarea>
				          </div>
							  </div>
							</div>
							
							<div class="panel panel-primary">
								<div class="panel-heading"><h4>Co-Presenters</h4></div>
							  <div class="panel-body">
								  <p class="small">Co-presenters are invited via email, and will be added to your presenter list upon account activation</p>
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
					              <input type="text" class="form-control" name="presentation_title" />
					          </div>
					
					          <div class="form-group">
					              <label class="control-label">Abstract</label>
					              <textarea class="form-control" rows="8" name="presentation_abstract" id="presentation_abstract" placeholder="A description of your presentation."></textarea>
					          </div>
								  </div>
								  
								  <div class="col-lg-6">
					          <div class="form-group">
											<label for="track_id">Track:</label>
											<select class="form-control" name='track_id' id="track_id">
										    <option selected="selected" value="">-</option>
												<? //Display track options
												$thisyear = date('Y');
												$tracks = fetchTracks($thisyear);
												
												print_r($tracks);
												
												foreach ($tracks as $temp) {
												  echo "<option value='".$temp['track_id']."'>".$temp['full_name']."</option>";
												}
												?>
											</select>
					          </div>
										<div class="form-group">
										  <label for="day_request">Request a Day</label>
										  <select class="form-control" id="day_request" name="day_request">
										    <option selected="selected" value="">-</option>
										    <option>Thursday</option>
										    <option>Friday</option>
										  </select>
			              </div>
								  </div>
							  </div>
							</div>
							
							<div class="panel panel-primary">
								<div class="panel-heading"><h4><input type="checkbox" name="gallery" id="gallery" value="true" /> Register Map / Poster Gallery</h4></div>
							  <div class="panel-body">
		              
								  <div id="gallery_info">
									  <div class="col-lg-6">
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
									  </div>
			              
									  <div class="col-lg-6">
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
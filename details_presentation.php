<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
if (!isUserLoggedIn()) { header("Location: login.php"); die(); }
if (!isset($_GET["id"])) { header("Location: admin_dashboard.php"); die(); }

$presId = $_GET["id"];

$presentationDetails = fetchPresentationDetails($presId);

$languages = getLanguageFiles(); //Retrieve list of language files
require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<ol class="breadcrumb">
		  <li><a href="admin_dashboard.php">Admin Dashboard</a></li>
		  <li><a href="list_presentations.php">Presentations</a></li>
		  <li class="active"><a href="#"><?=$presentationDetails['title']?></a></li>
							<h4 style="float: right; margin-top: -1px;">
								<? //Display payment status
								if ($presentationDetails['active']){
									echo " <span class='label label-success'>Scheduled</span>";	
								}
								else{
									echo " <span class='label label-danger'>Pending</span>";
								} ?>
							</h4>
		</ol>
		<div class="row">
				<? echo resultBlock($errors,$successes); ?>
		</div>
		<div class='row'>
			<div class='col-lg-12'>
				<h1>Presentation Details</h1>
				<form name='newPresentation' id="newPresentation" action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms text-left">
				  <input type="text" class="form-control" name="newPresentation" value="1" style="display:none;" />
					<div class="col-lg-4">
						<div class="panel panel-primary">
							<div class="panel-heading"><h4>Main Presenter</h4></div>
						  <div class="panel-body">   
			          <div class="form-group">
				          <label>Main Presenter</label>
								  <div class="input-group">
							      <input type="text" class="form-control" name="main_presenter_name" value="<?= $presentationDetails['main_presenter_name'] ?>" disabled>
							      <span class="input-group-btn">
							        <a href="details_user.php?id=<?=$presentationDetails["attendee_user_id"]?>"><button class="btn btn-success" type="button">View Profile <span class="glyphicon glyphicon-arrow-right"></span></button></a>
							      </span>
							    </div>
			          </div>
					          
			          <div class="form-group">
				          <label>Presenter Biography</label>
							  	<textarea class="form-control" rows="8" name="presenter_bio" id="presenter_bio" disabled ><?= $presentationDetails['biography'] ?></textarea>
			          </div>
							</div>
						</div>
						
						<div class="panel panel-primary">
							<div class="panel-heading"><h4>Co-Presenters</h4></div>
						  <div class="panel-body">
	              <div class="form-group">
					        <input type="text" class="form-control" name="copresenter[]" placeholder="Invite by email" disabled>
					    	</div>
	              <div class="form-group">
					        <input type="text" class="form-control" name="copresenter[]" placeholder="Invite by email" disabled>
					    	</div>
	              <div class="form-group">
					        <input type="text" class="form-control" name="copresenter[]" placeholder="Invite by email" disabled>
					    	</div>
							</div>
						</div>
					</div><!-- /.col-lg-4 -->
						<div class="col-lg-8">
							<div class="panel panel-primary">
								<div class="panel-heading"><h4>Presentation Information</h4></div>
							  <div class="panel-body">
								  <div class="col-lg-6">
					          <div class="form-group">
					              <label class="control-label">Title</label>
					              <input type="text" class="form-control" name="presentation_title" value="<?= $presentationDetails['title'] ?>" disabled />
					          </div>
					
					          <div class="form-group">
					              <label class="control-label">Abstract</label>
					              <textarea class="form-control" rows="8" name="presentation_abstract" id="presentation_abstract" disabled><?= $presentationDetails['abstract'] ?></textarea>
					          </div>
								  </div>
								  
								  <div class="col-lg-6">
									  <div class="form-group">
										  <label for="presentation_track">Track</label>
										  <select class="form-control" id="presentation_track" name="presentation_track" disabled>
											  <?
												  $track = fetchTracks($presentationDetails['conference_id']);
												  
												  
												  foreach ($track as $t1) {
														if ($t1['track_id'] === $presentationDetails['track_id']) 
															echo "<option value='".$t1['track_id']."' selected>".$t1['full_name']."</option>\n";
														else
															echo "<option value='".$t1['track_id']."'>".$t1['full_name']."</option>\n";
												  }
												?>
										  </select>
										</div>
										
										<div class="form-group">
										  <label for="day"><? if (!$presentationDetails['active']) { echo "Requested ";} ?>Presentation Day</label>
										<? if (!$presentationDetails['active']) {  ?>
										  <p>Requested: <?=$presentationDetails['week_day']?><p>Scheduled:</p>
										<? } ?>
										</div>
										
										<div class="form-group">
										  <select class="form-control" id="day" name="day" disabled>
										    <option value="">Not Set</option>
										    <option value="Thursday" <? if ($presentationDetails['week_day'] == 'Thursday') echo "selected"; ?>>Thursday</option>
										    <option value="Friday" <? if ($presentationDetails['week_day'] == 'Friday') echo "selected"; ?>>Friday</option>
										  </select>
			              </div>
			              
										<label for="start_time">Start Time</label>
									  <div class="input-group bootstrap-timepicker">
					            <input id="start_time" type="text" name="start_time" class="form-control" disabled>
					            <span class="input-group-addon"><apan class="glyphicon glyphicon-time"></span></span>
										</div>
										<br>
										<label for="start_time">End Time</label>
									  <div class="input-group bootstrap-timepicker">
					            <input id="end_time" type="text" name="end_time" class="form-control" disabled>
					            <span class="input-group-addon"><apan class="glyphicon glyphicon-time"></span></span>
										</div>
								  </div>
							  </div>
							</div>
						</div>
							
						<div class="col-lg-8">
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
		              
								  <div id="gallery_info" style="display: none;">
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
						<input type="submit" class="btn btn-lg btn-success" value="Save" disabled />
						<a href="edit_presentation.php?id=<?=$presId?>" class="btn btn-lg btn-danger">Edit</a>
					</div><!-- /.row -->
				</form>
			</div>
		</div>
	</div>
	<?php 
		include("models/footer.php");
		include("models/BootstrapJavaScript.php"); 
	 ?>
	<script src='js/bootstrap-timepicker.min.js' type='text/javascript'></script>
	<link href="css/bootstrap-timepicker.min.css" rel="stylesheet" />
  <script type="text/javascript">
      $('#start_time').timepicker('setTime', '<?=$presentationDetails["start_time"]?>');
      $('#end_time').timepicker('setTime', '<?=$presentationDetails["end_time"]?>');
  </script>
</body>
</html>

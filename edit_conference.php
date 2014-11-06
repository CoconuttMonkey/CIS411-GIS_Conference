<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$pageTitle = "Conference Settings";
$conference_id = $_GET['id'];
$conferenceData = fetchConferenceDetails($conference_id);

//print_r($conferenceData);

//Forms posted
	if (isset($_POST['editConference'])) {
		
		require_once("../models/class.newconference.php");
		
		$errors = array();
		$title = $_POST['title'];
		$tagline = $_POST['tagline'];
		$conf_start = date('Y-m-d', strtotime($_POST['conf_start']));
		$conf_end = date('Y-m-d', strtotime($_POST['conf_end']));
		$reg_open = date('Y-m-d', strtotime($_POST['reg_open']));
		$reg_close = date('Y-m-d', strtotime($_POST['reg_close']));
		$home_content = $_POST['home_content'];
		
		print_r($_POST);
		
		$banner_size = $_FILES["banner"]["size"];
		$schedule_size = $_FILES["schedule"]["size"];
		
		if (count($conference) == 0) {
				$errors[] = lang("CONFERENCE_ERROR");
		} else {
				$successes[] = lang("CONFERENCE_SUCCESS");
		}
	}

$languages = getLanguageFiles(); //Retrieve list of language files
require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<section class="container">
		<ol class="breadcrumb">
		  <li><a href="admin_dashboard.php">Admin Dashboard</a></li>
		  <li class="active"><a href="conf_settings.php">Conference Settings</a></li>
		</ol>
		<? echo resultBlock($errors,$successes); ?>
		<div class='row'>
				<form name='conf_settings' id="conf_settings" action='edit_conference.php?id=<? echo $conferenceData['conference_id']; ?>' method='post' class='forms' enctype="multipart/form-data">
					<input type="text" name="editConference" value="1" style="display:none;" />
						<div class='col-lg-6 col-lg-push-3 col-md-6 col-md-push-3'>
							<div class="panel panel-primary">
								<div class="panel-heading"><h2><? echo $pageTitle; ?></h2></div>
							  <div class="panel-body">
									<div class="form-group">
										<label>Conference Title</label>
									  <input type='text' name='title' class="form-control" value="<? echo $conferenceData['title']; ?>"  />
									</div>
									
									<div class="form-group">
										<label>Conference Tagline</label>
									  <input type='text' name='tagline' class="form-control" value="<? echo $conferenceData['tagline']; ?>"  />
									</div>
									
									<div class="row">
										<div class="form-group col-lg-6">
	                    <label class="control-label">Start Date</label>
	                    <div class="input-group date" id="conf_start">
	                        <input type="text" class="form-control" name="conf_start" value="<? echo $conferenceData['start_date']; ?>"  />
	                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	                    </div>
	                  </div>
										
										<div class="form-group col-lg-6">
	                    <label class="control-label">End Date</label>
	                    <div class="input-group date" id="conf_end">
	                        <input type="text" class="form-control" name="conf_end" value="<? echo $conferenceData['end_date']; ?>"  />
	                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	                    </div>
	                  </div>
									</div>
									
									<div class="row">
										<div class="form-group col-lg-6">
	                    <label class="control-label">Registration Open Date</label>
	                    <div class="input-group date" id="reg_open">
	                        <input type="text" class="form-control" name="reg_open" value="<? echo $conferenceData['reg_open_date']; ?>"  />
	                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	                    </div>
	                  </div>
										
										<div class="form-group col-lg-6">
	                    <label class="control-label">Registration Close Date</label>
	                    <div class="input-group date" id="reg_close">
	                        <input type="text" class="form-control" name="reg_close" value="<? echo $conferenceData['reg_close_date']; ?>"  />
	                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	                    </div>
	                  </div>
									</div>
									
									<div class="form-group">
									  <label for="comment">Abstract</label>
									  <textarea class="form-control" rows="5" id="home_content" name="home_content" value="<? echo $conferenceData['home_content']; ?>" ></textarea>
									</div>
									
									<div class="form-group">
                    <label class="control-label">Conference Banner</label>
                    <div class="form-group">
                      <input type="file" class="form-control" value="<?= $conferenceData['banner'] ?>" name="banner" />
                      <span class="help-block text-right">Choose a jpg file with a size less than 1M.</span>
                    </div>
                  </div>
									
									<div class="form-group">
                    <label class="control-label">Conference Schedule</label>
                    <div class="form-group">
                      <input type="file" class="form-control" name="schedule" />
                      <span class="help-block text-right">Choose a pdf file with a size less than 10M.</span>
                    </div>
                  </div>
							  </div>
						  </div>
						<p style="text-align: center;">
							<input type='submit' value='Save' class='btn btn-lg btn-success' />
							<input type='submit' id='enable-fields' value='Edit' class='btn btn-lg btn-danger'  disabled="disabled"/>
						</p>
						</div>
				</form>
		</div>
	</section>
  <link rel="stylesheet" href="http://eonasdan.github.io/bootstrap-datetimepicker/content/bootstrap-datetimepicker.css"/>
  <script type="text/javascript" src="http://eonasdan.github.io/bootstrap-datetimepicker/scripts/moment.js"></script>
  <script type="text/javascript" src="http://eonasdan.github.io/bootstrap-datetimepicker/scripts/bootstrap-datetimepicker.js"></script>
 	<?php 
		include("models/footer.php");
		include("models/BootstrapJavaScript.php"); 
	 ?>
</body>
</html>
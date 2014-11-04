<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$pageTitle = "Conference Settings";
$year = date("Y");
$conferenceData = fetchConferenceDetails($year);

//print_r($conferenceData);

//Forms posted
if (!empty($_POST)) {
	if (isset($_POST['newConference'])) {
		
		require_once("../models/class.newconference.php");
		
		$errors = array();
		$title = $_POST['title'];
		$tagline = $_POST['tagline'];
		$conf_start = date('Y-m-d', strtotime($_POST['conf_start']));
		$conf_end = date('Y-m-d', strtotime($_POST['conf_end']));
		$reg_open = date('Y-m-d', strtotime($_POST['reg_open']));
		$reg_close = date('Y-m-d', strtotime($_POST['reg_close']));
		$conf_abstract = $_POST['abstract'];
		
		print_r($_POST);
		
		$banner_size = $_FILES["banner"]["size"];
		$schedule_size = $_FILES["schedule"]["size"];
		
		if ($banner_size) {
			$target_dir = "../uploads/";
			$banner = $target_dir . basename( $_FILES["banner"]["name"]);
			$banner_type = $_FILES["banner"]["type"];
			$uploadOk = 1;
		
			if (file_exists($banner . $_FILES["banner"]["name"])) {
				$errors[] = lang("BANNER_FILE_EXISTS");
		    $uploadOk = 0;
			}
			
			if ($banner_size > 500000) {
				$errors[] = lang("BANNER_ABOVE_FILE_SIZE");
		    $uploadOk = 0;
			}
			
			if (!($banner_type == "image/jpeg")) {
				$errors[] = lang("BANNER_TYPE_ERROR");
		    $uploadOk = 0;
			}
			
			if (move_uploaded_file($_FILES["banner"]["tmp_name"], $banner)) {
				$successes[] = lang("BANNER_UPLOAD_SUCCESS");
			} else {
				$errors[] = lang("BANNER_UPLOAD_ERROR");
			}
		}
		
		if($schedule_size) {
			$schedule = $target_dir . basename( $_FILES["schedule"]["name"]);
			$schedule_type = $_FILES["schedule"]["type"];
			$uploadOk = 1;
			
			if (file_exists($schedule . $_FILES["schedule"]["name"])) {
				$errors[] = lang("SCHEDULE_FILE_EXISTS");
		    $uploadOk = 0;
			}
			
			if ($schedule_size > 500000) {
				$errors[] = lang("BANNER_ABOVE_FILE_SIZE");
		    $uploadOk = 0;
			}
			
			if (!($schedule_type == "application/pdf")) {
				$errors[] = lang("SCHEDULE_TYPE_ERROR");
		    $uploadOk = 0;
			}
			
			if (move_uploaded_file($_FILES["schedule"]["tmp_name"], $schedule)) {
				$successes[] = lang("SCHEDULE_UPLOAD_SUCCESS");
			} else {
				$errors[] = lang("SCHEDULE_UPLOAD_ERROR");
			}
		}
		
		if(count($errors) == 0) {
			//Construct a user object
			$conference = new Conference($title,$tagline,$conf_start,$conf_end,$reg_open,$reg_close,$conf_abstract,$banner,$schedule);
			
			echo "<br>";
			print_r($conference);
			
			$conference->addConference();
			
			if(count($conference) == 0) {
				$errors[] = lang("CONFERENCE_ERROR");
			} else {
				$successes[] = lang("CONFERENCE_SUCCESS");
			}
		}
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
					<? if (isset($_GET['new'])) {?><input type="text" name="newConference" value="1" style="display:none;" /><?} ?>
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
									  <textarea class="form-control" rows="5" id="abstract" name="abstract" value="<? echo $conferenceData['abstract']; ?>" ></textarea>
									</div>
									
									<div class="form-group">
                    <label class="control-label">Conference Banner</label>
                    <div class="form-group">
                      <input type="file" class="form-control" name="banner" />
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
	<script>
    $(function () {
      $('#conf_start').datetimepicker({
				pickTime: false
			});
      $('#conf_end').datetimepicker({
				pickTime: false
			});
			$("#conf_start").on("dp.change",function (e) {
         $('#conf_end').data("DateTimePicker").setMinDate(e.date);
      });
      $("#conf_end").on("dp.change",function (e) {
         $('#conf_start').data("DateTimePicker").setMaxDate(e.date);
      });
      $('#conf_start').on('dp.change dp.show', function(e) {
          // Validate the date when user change it
          $('#conf_settings').data('bootstrapValidator').revalidateField('conf_start');
          // You also can call it as following:
          // $('#defaultForm').bootstrapValidator('revalidateField', 'datetimePicker');
      });
      $('#conf_end').on('dp.change dp.show', function(e) {
          // Validate the date when user change it
          $('#conf_settings').data('bootstrapValidator').revalidateField('conf_end');
          // You also can call it as following:
          // $('#defaultForm').bootstrapValidator('revalidateField', 'datetimePicker');
      });
      
      $('#reg_open').datetimepicker({
				pickTime: false
			});
      $('#reg_close').datetimepicker({
				pickTime: false
			});
			$("#reg_open").on("dp.change",function (e) {
         $('#reg_close').data("DateTimePicker").setMinDate(e.date);
      });
      $("#reg_close").on("dp.change",function (e) {
         $('#reg_open').data("DateTimePicker").setMaxDate(e.date);
      });
      $('#reg_open').on('dp.change dp.show', function(e) {
          // Validate the date when user change it
          $('#conf_settings').data('bootstrapValidator').revalidateField('reg_open');
          // You also can call it as following:
          // $('#defaultForm').bootstrapValidator('revalidateField', 'datetimePicker');
      });
      $('#reg_close').on('dp.change dp.show', function(e) {
          // Validate the date when user change it
          $('#conf_settings').data('bootstrapValidator').revalidateField('reg_close');
          // You also can call it as following:
          // $('#defaultForm').bootstrapValidator('revalidateField', 'datetimePicker');
      });
    });
	</script>
	<?php 
		include("models/footer.php");
		include("models/BootstrapJavaScript.php"); 
	 ?>
</body>
</html>
<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}


$pageTitle = $_GET['id']." GIS Conference";
$year = date("Y");

$conferenceData = fetchConferenceDetails($_GET['id']);
	
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
				<form name='conf_settings' id="conf_settings" action='edit_conference.php?id=<? echo $conferenceData['conference_id']; ?>' class='forms' enctype="multipart/form-data">
					<? if (isset($_GET['new'])) {?><input type="text" name="newConference" value="1" style="display:none;" /><?} ?>
						<div class='col-lg-6 col-lg-push-3 col-md-6 col-md-push-3'>
							<div class="panel panel-primary">
								<div class="panel-heading"><h2><? echo $pageTitle; ?></h2></div>
							  <div class="panel-body">
									<div class="form-group">
										<label>Conference Title</label>
									  <input type='text' name='title' class="form-control" value="<? echo $conferenceData['title']; ?>" disabled="disabled" />
									</div>
									
									<div class="form-group">
										<label>Conference Tagline</label>
									  <input type='text' name='tagline' class="form-control" value="<? echo $conferenceData['tagline']; ?>" disabled="disabled" />
									</div>
									
									<div class="row">
										<div class="form-group col-lg-6">
	                    <label class="control-label">Start Date</label>
	                    <div class="input-group date" id="conf_start">
	                        <input type="text" class="form-control" name="conf_start" value="<? echo $conferenceData['start_date']; ?>" disabled="disabled" />
	                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	                    </div>
	                  </div>
										
										<div class="form-group col-lg-6">
	                    <label class="control-label">End Date</label>
	                    <div class="input-group date" id="conf_end">
	                        <input type="text" class="form-control" name="conf_end" value="<? echo $conferenceData['end_date']; ?>" disabled="disabled" />
	                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	                    </div>
	                  </div>
									</div>
									
									<div class="row">
										<div class="form-group col-lg-6">
	                    <label class="control-label">Registration Open Date</label>
	                    <div class="input-group date" id="reg_open">
	                        <input type="text" class="form-control" name="reg_open" value="<? echo $conferenceData['reg_open_date']; ?>" disabled="disabled" />
	                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	                    </div>
	                  </div>
										
										<div class="form-group col-lg-6">
	                    <label class="control-label">Registration Close Date</label>
	                    <div class="input-group date" id="reg_close">
	                        <input type="text" class="form-control" name="reg_close" value="<? echo $conferenceData['reg_close_date']; ?>" disabled="disabled" />
	                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
	                    </div>
	                  </div>
									</div>
									
									<div class="form-group">
									  <label for="comment">Abstract</label>
									  <textarea class="form-control" rows="5" id="abstract" name="abstract" value="<? echo $conferenceData['abstract']; ?>" disabled="disabled"></textarea>
									</div>
									
									<div class="form-group">
                    <label class="control-label">Conference Banner</label>
                    <div class="form-group">
                      <img src="<? echo $conferenceData['banner']; ?>" alt="banner" width="100%">
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
							<input type='submit' value='Save' class='btn btn-lg btn-success' disabled="disabled"/>
							<input type='submit' id='enable-fields' value='Edit' class='btn btn-lg btn-danger'/>
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
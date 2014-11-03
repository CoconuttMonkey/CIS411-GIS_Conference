<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$current_conf = date("Y");


$pageTitle = "Scheduled Presentations";
$presentationData = fetchScheduledPresentations($current_conf); //Fetch information for all presentations this year
	
//List posted
if(!empty($_GET)) {
	if ($_GET['list'] == 'pending') {
		$pageTitle = "Pending Presentations";
		$presentationData = fetchPendingPresentations();
	}
}
require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<ol class="breadcrumb">
		  <li><a href="../admin_dashboard.php">Admin Dashboard</a></li>
		  <li class="active"><a href="#"><? echo $pageTitle; ?></a></li>
		</ol>
		<div class='row'>
			<div class='col-lg-12'>
				<? echo resultBlock($errors,$successes); ?>
				<form name='adminUsers' action='<? $_SERVER['PHP_SELF']; ?>' method='post' class='forms'>
					<div class="panel panel-default">
			  		<div class="panel-heading"><h1><? echo $pageTitle; ?></h1></div>
			  		
						<!-- Table -->
					  <table class="tablesorter-bootstrap">
							<thead>
								<th>Title</th><th>Presenter</th><th>Track</th><th>Day</th><th>Session</th><th>Location</th><th>Active</th>
							</thead>
							<tbody>
							<? foreach ($presentationData as $v1) { ?>
								<tr class="clickableCell" href="../conf_presentation.php?id=<? echo $v1['presentation_id']; ?>">
									<td><? echo $v1['title']; ?></td>
									<td><? echo $v1['main_presenter']; ?></td>
									<td><? echo $v1['track_title']; ?></td>
									<td><? echo $v1['week_day']; ?></td>
									<td><? echo $v1['start_time']." - ".$v1['end_time']; ?></td>
									<td><? echo $v1['room_number']." ".$v1['building']; ?></td>
									<td>
										<? //Display payment status
											if ($v1['active'] == '0'){
											echo " <span class='label label-warning'>Unscheduled</span>";	
										}
										else{
											echo " <span class='label label-success'>".$v1['presentation_session']."</span>
											";
										} ?></td>
								</tr> 
							<? } ?>
							</tbody>
					  </table>
					</div>
					<p class="text-center">
						<input id="clear-filters" type='reset' name='Submit' value='Clear Filters' class='btn btn-warning' />
					</p>
				</form>
			</div>
		</div>
	</div>
	<?php 
		include("models/footer.php");
		include("models/BootstrapJavaScript.php"); 
	 ?>
	<script src='js/jquery.tablesorter.js' type='text/javascript'></script>
	<script src='js/jquery.tablesorter.widgets.min.js' type='text/javascript'></script>
	<script>
	jQuery(document).ready(function($) {
		$(".clickableCell").click(function() {
			window.document.location = $(this).attr("href");
		});
		
		$('.tablesorter-bootstrap').tablesorter({
			usNumberFormat : false,
			sortReset      : true,
			sortRestart    : true,
			theme : 'bootstrap',
			headerTemplate: '{content} {icon}',
			widgets    : ['zebra', 'uitheme', 'filter'],
			widgetOptions: {
	      filter_reset: '.reset',
				filter_cssFilter   : 'form-control',
	    }
		});
	});
	  $('#clear-filters').click(function(){
	    $('.tablesorter-bootstrap').trigger('filterReset');
	    return false;
		});
	</script>
</body>
</html>

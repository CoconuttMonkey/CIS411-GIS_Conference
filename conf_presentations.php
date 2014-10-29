<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//List posted
if(!empty($_GET)) {
	if ($_GET['list'] == 'pending') {
		$pageTitle = "Pending Presentations";
		$presentationData = fetchPresentations('pending');
	} else {
		$pageTitle = "All Presentations";
		$presentationData = fetchPresentations(); //Fetch information for all users
	}
} else {
	$pageTitle = "All Presentations";
	$presentationData = fetchPresentations(); //Fetch information for all users
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
								<th>Title</th><th>Presenter</th><th>Session</th><th>Track</th><th>Active</th>
							</thead>
							<tbody>
							<? //Cycle through users
						foreach ($presentationData as $v1) {
							$track = fetchTrackName($v1['presentation_track']);
						?>
						<tr class="clickableCell" href="../conference/presentation.php?id=<? echo $v1['presentation_id']; ?>">
							<td><? echo $v1['presentation_title']; ?></td>
							<td><? echo $v1['first_name']." ".$v1['last_name']; ?></td>
							<td>
								<? //Display payment status
									if ($v1['presentation_session'] == '0'){
									echo " <span class='label label-warning'>Unscheduled</span>";	
								}
								else{
									echo " <span class='label label-success'>".$v1['presentation_session']."</span>
									";
								} ?></td>
							<td><? echo $track['full_name']; ?></td>
							<td>
								<? //Display payment status
									if ($v1['active'] == '1'){
									echo " <span class='label label-success'>Active</span>";	
								}
								else{
									echo " <span class='label label-danger'>Not Active</span>
									";
								} ?>
							</td>
						</tr> <? } ?>
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
	<?php include("models/footer.php"); ?>
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

<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//List posted
if(!empty($_GET)) {
	if ($_GET['list'] == 'pending') {
		$pageTitle = "Pending Exhibits";
		$exhibitData = fetchExhibits('pending');
	} else {
		$pageTitle = "All Exhibits";
		$exhibitData = fetchExhibits(); //Fetch information for all users
	}
} else {
	$pageTitle = "All Exhibits";
	$exhibitData = fetchExhibits(); //Fetch information for all users
}

require_once("../models/header.php");
?>
<body>
	<?php include("../models/main-nav.php"); ?>
	<div class='container'>
		<ol class="breadcrumb">
		  <li><a href="../admin/dashboard.php">Admin Dashboard</a></li>
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
								<th>Exhibit ID</th><th>Contact Person</th><th>Company Name</th><th>Table</th><th>Paid</th>
							</thead>
							<tbody>
							<? //Cycle through users
						foreach ($exhibitData as $v1) {
							
						?>
						<tr class="clickableCell" href="../conference/exhibit.php?id=<? echo $v1['exhibit_id']; ?>">
							<td><? echo $v1['exhibit_id']; ?></td>
							<td><? echo $v1['first_name']." ".$v1['last_name']; ?></td>
							<td><? echo $v1['company']; ?></td>
							<td><? echo $v1['table_location']." # ".$v1['table_number']; ?></td>
							<td> 
								<? //Display payment status
									if ($v1['paidStatus'] == '1'){
									echo " <span class='label label-success'>Paid</span>";	
								}
								else{
									echo " <span class='label label-danger'>Not Paid</span>";
								} ?>
							</td>
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

<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$pageTitle = "Exhibits";
$exhibitorData = fetchAllExhibits();


if ($_GET['filter'] == 'pending') {
	$pageTitle = "Pending Exhibits";
	$exhibitorData = fetchAllExhibits("pending");
}
if ($_GET['filter'] == 'active') {
	$pageTitle = "Active Exhibits";
	$exhibitorData = fetchAllExhibits("active");
}

//print_r($exhibitorData);
require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<ol class="breadcrumb">
		  <li><a href="admin_dashboard.php">Admin Dashboard</a></li>
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
								<th>Exhibit ID</th><th>Company</th><th>Main Contact</th><th>Paid</th>
							</thead>
							<tbody>
							<? //Cycle through users
						foreach ($exhibitorData as $v1) {
						?>
						<tr class="clickableCell" href="../details_exhibit.php?id=<? echo $v1['exhibit_id']; ?>">
							<td><? echo $v1['exhibit_id']; ?></td>
							<td><?php echo $v1['company']; ?></td>
							<td><?php echo $v1['main_contact']; ?></td>
							<td><? //Display payment status
								if ($userdetails['paid'] == '1'){
									echo " <span class='label label-success'>Yes</span>";	
								}
								else{
									echo " <span class='label label-danger'>No</span>";
								} ?></td>
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

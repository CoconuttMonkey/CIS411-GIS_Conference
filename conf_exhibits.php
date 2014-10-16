<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}


//$exhibitData = fetchAllExhibits(); //Fetch information for all exhibits
require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<div class='row'>
			<div class='col-80'>
				<h1>Exhibits</h1>
				<? echo resultBlock($errors,$successes); ?>
				<form name='adminUsers' action='<? $_SERVER['PHP_SELF']; ?>' method='post' class='forms width-100'>
					<table class='admin width-100 table-hovered'>
						<tr style='text-align: left;'>
							<th>Title</th><th>Exhibitor</th><th>Table</th><th>Track</th><th>Active</th>
						</tr>
						<? //Cycle through users
						foreach ($presentationData as $v1) {
						?>
						<tr class="clickableCell" href="presentation.php?id=<? echo $v1['id']; ?>">
							<td><?php echo $v1['title']; ?></td>
							<td><? echo $v1['presentation_id']; ?></td>
							<td><?php echo $v1['session']; ?></td>
							<td><?php echo $v1['track']; ?></td>
							<td><? if ($v1['active'] === 1) { 
									echo '<span class="success">Paid</span>';
								} else if ($v1['paid'] === 0) { 
									echo '<span class="error">Not Paid</span>';
								} ?></td>
						</tr> <? } ?>
					</table>
				</form>
			</div>
			<aside class="col-20 nav">
				<? 
				if(isUserLoggedIn()) {
					include('models/sideNav.php');
				} else {
					include('models/loginForm.php');
				}
				?>
			</aside>
		</div>
	</div>
	<?php include("models/footer.php"); ?>
	<script>
	jQuery(document).ready(function($) {
		$(".clickableCell").click(function() {
			window.document.location = $(this).attr("href");
		});
	});
	</script>
</body>
</html>

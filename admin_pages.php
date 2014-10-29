<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

$pages = getPageFiles(); //Retrieve list of pages in root usercake folder
$dbpages = fetchAllPages(); //Retrieve list of pages in pages table
$creations = array();
$deletions = array();

//Check if any pages exist which are not in DB
foreach ($pages as $page){
	if(!isset($dbpages[$page])){
		$creations[] = $page;	
	}
}

//Enter new pages in DB if found
if (count($creations) > 0) {
	createPages($creations)	;
}

if (count($dbpages) > 0){
	//Check if DB contains pages that don't exist
	foreach ($dbpages as $page){
		if(!isset($pages[$page['page']])){
			$deletions[] = $page['id'];	
		}
	}
}

//Delete pages from DB if not found
if (count($deletions) > 0) {
	deletePages($deletions);
}

//Update DB pages
$dbpages = fetchAllPages();

require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<div class='row'>
			<div class="col-lg-6 col-lg-push-3 col-md-6 col-md-push-3">
				<div class="panel panel-default">
				  <div class="panel-heading"><h1>Web Pages</h1></div>
				  		
					<!-- Table -->
				  <table class="table">
						<tr style='text-align: left;'>
							<th>ID</th><th>Page</th><th>Access</th>
						</tr>
						<? //Display list of pages
						foreach ($dbpages as $page){
							echo "
							<tr class='clickableCell' href='../admin/page.php?id=".$page['id']."' >
							<td>
							".$page['id']."
							</td>
							<td>
							".$page['page']."</a>
							</td>
							<td>";
							
							//Show public/private setting of page
							if($page['private'] == 0){
								echo "Public";
							}
							else {
								echo "Private";	
							}
							
							echo "
							</td>
							</tr>";
						} ?>
					</table>
				</div>
			</div>
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
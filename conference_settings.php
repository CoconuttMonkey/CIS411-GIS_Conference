<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/
error_reporting(E_ALL); 
require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}

//Prevent the user visiting the logged in page if he is not logged in
if (!isUserLoggedIn()) { header("Location: login.php"); die(); }

if (!empty($_POST)) {
	$errors = array();
	$successes = array();
	
	// THIS IS WHERE UPDATE FUNCTIONS GET CALLED

	if (count($errors) == 0 AND count($successes) == 0) {
		$errors[] = lang("NOTHING_TO_UPDATE");
	}
}


require_once("models/header.php");
?>
<body>
	<?php include("nav.php"); ?>
	<section class="container">
	<? echo resultBlock($errors,$successes); ?>
	<h1>Conference Settings</h1>
		<div class="row">

			<div id="tabContainer" class="col-90">
			    <div id="tabs">
			      <ul>
			        <li id="tabHeader_1">Current</li>
			        <li id="tabHeader_2">New</li>
			      </ul>
			    </div>
			    <div id="tabscontent">
					<div class="tabpage" id="tabpage_1">
						<form name='updateConference' action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms">
				        	<legend>Current Conference</legend>
				        	<label for="start_date">Start Date
				        		<input name="start_date" type="text" id="start_date" />
				        	</label>
				        	<label for="duration">Duration <small>(In Days)</small>
				        		<input name="duration" type="text" />
				        	</label>
				        	<input type="submit" class='btn' value='Update'>
						</form>
					</div>
					<div class="tabpage" id="tabpage_2">
						<form name='newConference' action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms">
						    <legend>New Conference</legend>
						</form>
					</div>
			    </div>
			</div>

			<div class="col-10 text-centered">
				<fieldset>
			    	<legend>Archive</legend>
			    	<nav class="nav">
						<ul>
							<li><a href="#">2013</a></li>
							<li><a href="#">2012</a></li>
							<li><a href="#">2011</a></li>
							<li><a href="#">2010</a></li>
							<li><a href="#">2009</a></li>
							<li><a href="#">2008</a></li>
							<li><a href="#">2007</a></li>
							<li><a href="#">2006</a></li>
							<li><a href="#">2005</a></li>
						</ul>
					</nav>
				</fieldset>
			</div>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
	<script src="models/site-templates/js/jquery.datetimepicker.js"></script>
	<link rel="stylesheet" type="text/css" href="models/site-templates/js/jquery.datetimepicker.css">
	<script>
		$('#start_date').datetimepicker({
			timepicker:false,
			mask:true,
			format:'m/d/Y'
		});

		window.onload=function() {

		  // get tab container
		  	var container = document.getElementById("tabContainer");
				var tabcon = document.getElementById("tabscontent");
				//alert(tabcon.childNodes.item(1));
		    // set current tab
		    var navitem = document.getElementById("tabHeader_1");
				
		    //store which tab we are on
		    var ident = navitem.id.split("_")[1];
				//alert(ident);
		    navitem.parentNode.setAttribute("data-current",ident);
		    //set current tab with class of activetabheader
		    navitem.setAttribute("class","tabActiveHeader");

		    //hide two tab contents we don't need
		   	 var pages = tabcon.getElementsByTagName("div");
		    	for (var i = 1; i < pages.length; i++) {
		     	 pages.item(i).style.display="none";
				};

		    //this adds click event to tabs
		    var tabs = container.getElementsByTagName("li");
		    for (var i = 0; i < tabs.length; i++) {
		      tabs[i].onclick=displayPage;
		    }
		}

		// on click of one of tabs
		function displayPage() {
		  var current = this.parentNode.getAttribute("data-current");
		  //remove class of activetabheader and hide old contents
		  document.getElementById("tabHeader_" + current).removeAttribute("class");
		  document.getElementById("tabpage_" + current).style.display="none";

		  var ident = this.id.split("_")[1];
		  //add class of activetabheader to new active tab and show contents
		  this.setAttribute("class","tabActiveHeader");
		  document.getElementById("tabpage_" + ident).style.display="block";
		  this.parentNode.setAttribute("data-current",ident);
		}
	</script>
</body>
</html>
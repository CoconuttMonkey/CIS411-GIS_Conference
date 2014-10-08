<?php
	require_once("models/config.php");
	if (!securePage($_SERVER['PHP_SELF'])){die();}
	require_once("models/header.php");
?>
<body>
	<?php include("nav.php"); ?>
	<section class="container">
		<div class="row">
			<div id="tabContainer" class="col-100" style="margin-top: 20px; padding: 0;">
			    <div id="tabs">
			      <ul>
			        <li id="tabHeader_1">Wednesday</li>
			        <li id="tabHeader_2">Thursday</li>
			        <li id="tabHeader_3">Friday</li>
			      </ul>
			    </div>
			    <div id="tabscontent" style="padding: 0;">
					<div class="tabpage" id="tabpage_1">
						<table class="table-bordered width-100" style="font-size: 10px; margin-bottom: 0;">
						    <tr>
						        <th width="10%">Time</th>
						        <th width="10%">MPR</th>
						        <th width="15%">Room 252</th>
						        <th width="15%">Room 250</th>
						        <th width="15%">Room 248</th>
						        <th width="15%">Room 246</th>
						    </tr>
						    <tr>
						        <td>9:00 - 10:00</td>
						        <td>Poster Session</td>
						        <td>Keynote</td>
						        <td>Keynote</td>
						        <td>Keynote</td>
						        <td>Keynote</td>
						    </tr>
						    <tr>
						    	<td>10:15 - 10:35</td>
						        <td>Poster Session</td>
						    	<td>Integration of ESRI Tools with 9-1-1 CAD Products - Barry Hutchins (County of Lycoming)</td>
						    	<td>Source Water Protection Integrated with Emergency Response - Christopher Berkey & Mark Stephens (PA DEP)</td>
						        <td>The US Census Bureau's OnTheMap for Emergency Management Application, and a Geographic Support System Initiative (GSS-I) Update - Kevin Holmes (US Census Bureau)</td>
						        <td>Esri Hands-On Learning Lab (10.2.2)</td>
						    </tr>
						</table>
					</div>

					<div class="tabpage" id="tabpage_2">
						<table class="table-bordered width-100" style="font-size: 10px; margin-bottom: 0;">
						    <tr>
						        <th width="10%">Time</th>
						        <th width="10%">MPR</th>
						        <th width="15%">Room 252</th>
						        <th width="15%">Room 250</th>
						        <th width="15%">Room 248</th>
						        <th width="15%">Room 246</th>
						    </tr>
						    <tr>
						        <td>9:00 - 10:00</td>
						        <td>Poster Session</td>
						        <td>Keynote</td>
						        <td>Keynote</td>
						        <td>Keynote</td>
						        <td>Keynote</td>
						    </tr>
						    <tr>
						    	<td>10:15 - 10:35</td>
						        <td>Poster Session</td>
						    	<td>Integration of ESRI Tools with 9-1-1 CAD Products - Barry Hutchins (County of Lycoming)</td>
						    	<td>Source Water Protection Integrated with Emergency Response - Christopher Berkey & Mark Stephens (PA DEP)</td>
						        <td>The US Census Bureau's OnTheMap for Emergency Management Application, and a Geographic Support System Initiative (GSS-I) Update - Kevin Holmes (US Census Bureau)</td>
						        <td>Esri Hands-On Learning Lab (10.2.2)</td>
						    </tr>
						    <tr>
						    	<td>10:35 - 11:00</td>
						        <td></td>
						    	<td></td>
						    	<td>Unlocking Census Data: Census Data Resources for GIS Users - Noemi Mendez (US Census Bureau)</td>
						        <td></td>
						        <td>
						        	<ol style="margin: 0; padding-left: 10px;">
										<li>Introduction to ArcGIS for Desktop</li>
										<li>Creating a map in ArcGIS for Desktop</li>
										<li>Basics of the geodatabase model</li>
										<li>Editing with ArcGIS for Desktop</li>
										<li>Introduction to versioned editing</li>
						        	</ol>
								</td>
						    </tr>
						    <tr>
						        <td>11:15 - 11:35</td>
						        <td>Poster Session</td>
						        <td>Water Main Failure Analysis and GIS Methodology, Erie Water Works - Justin Stangl & Amanda Donegan (Erie Water Works)</td>
						        <td>Baker’s Addressing Web Portal Solution - Mike Anderson & Scott Treaster (Michael Baker Corporation)</td>
						        <td>Use of GIS to Identify Potential Transmission Pipeline Valve Locations per DOT Regulations - David Nichter (Fisher Associates)</td>
						        <td>
						        	<ol start="6" style="margin: 0; padding-left: 10px;">
										<li>Geocoding with ArcGIS for Desktop</li>
										<li>Introduction to ArcGIS Network Analyst</li>
										<li>Introduction to linear referencing</li>
										<li>Using geometric networks for utilities applications</li>
										<li>Introduction to ArcGIS Spatial Analyst</li>
										<li>Introduction to ArcGIS for Server</li>
										<li>Designing web applications using ArcGIS for Server</li>
						        	</ol>
								</td>
						    </tr>
						    <tr>
						    	<td>11:35 - 12:00</td>
						        <td></td>
						    	<td></td>
						    	<td>The Use of the ArcGIS Platform to support the Local Government’s Mission of Managing Natural Disasters - David Kunz (Civil Solutions)</td>
						        <td></td>
						        <td>
						        	<ol start="14" style="margin: 0; padding-left: 10px;">
										<li>Sharing maps and tools using ArcGIS Online</li>
										<li>Sharing data with the Community Maps Program</li>
										<li>Spatial statistics for public health</li>
										<li>Working with CAD in ArcGIS for Desktop</li>
										<li>Introduction to geoprocessing using Python</li>
										<li>What’s new in ArcGIS for Desktop 10 and 10.1</li>
						        	</ol>
								</td>
						    </tr>
						</table>
					</div>

					<div class="tabpage" id="tabpage_3">
						<table class="table-bordered width-100" style="font-size: 10px; margin-bottom: 0;">
						    <tr>
						        <th width="10%">Time</th>
						        <th width="10%">MPR</th>
						        <th width="15%">Room 252</th>
						        <th width="15%">Room 250</th>
						        <th width="15%">Room 248</th>
						        <th width="15%">Room 246</th>
						    </tr>
						    <tr>
						        <td>9:00 - 10:00</td>
						        <td>Poster Session</td>
						        <td>Keynote</td>
						        <td>Keynote</td>
						        <td>Keynote</td>
						        <td>Keynote</td>
						    </tr>
						    <tr>
						    	<td>10:15 - 10:35</td>
						        <td>Poster Session</td>
						    	<td>Integration of ESRI Tools with 9-1-1 CAD Products - Barry Hutchins (County of Lycoming)</td>
						    	<td>Source Water Protection Integrated with Emergency Response - Christopher Berkey & Mark Stephens (PA DEP)</td>
						        <td>The US Census Bureau's OnTheMap for Emergency Management Application, and a Geographic Support System Initiative (GSS-I) Update - Kevin Holmes (US Census Bureau)</td>
						        <td>Esri Hands-On Learning Lab (10.2.2)</td>
						    </tr>
						    <tr>
						    	<td>10:35 - 11:00</td>
						        <td></td>
						    	<td></td>
						    	<td>Unlocking Census Data: Census Data Resources for GIS Users - Noemi Mendez (US Census Bureau)</td>
						        <td></td>
						        <td>
						        	<ol style="margin: 0; padding-left: 10px;">
										<li>Introduction to ArcGIS for Desktop</li>
										<li>Creating a map in ArcGIS for Desktop</li>
										<li>Basics of the geodatabase model</li>
										<li>Editing with ArcGIS for Desktop</li>
										<li>Introduction to versioned editing</li>
						        	</ol>
								</td>
						    </tr>
						    <tr>
						        <td>11:15 - 11:35</td>
						        <td>Poster Session</td>
						        <td>Water Main Failure Analysis and GIS Methodology, Erie Water Works - Justin Stangl & Amanda Donegan (Erie Water Works)</td>
						        <td>Baker’s Addressing Web Portal Solution - Mike Anderson & Scott Treaster (Michael Baker Corporation)</td>
						        <td>Use of GIS to Identify Potential Transmission Pipeline Valve Locations per DOT Regulations - David Nichter (Fisher Associates)</td>
						        <td>
						        	<ol start="6" style="margin: 0; padding-left: 10px;">
										<li>Geocoding with ArcGIS for Desktop</li>
										<li>Introduction to ArcGIS Network Analyst</li>
										<li>Introduction to linear referencing</li>
										<li>Using geometric networks for utilities applications</li>
										<li>Introduction to ArcGIS Spatial Analyst</li>
										<li>Introduction to ArcGIS for Server</li>
										<li>Designing web applications using ArcGIS for Server</li>
						        	</ol>
								</td>
						    </tr>
						    <tr>
						    	<td>11:35 - 12:00</td>
						        <td></td>
						    	<td></td>
						    	<td>The Use of the ArcGIS Platform to support the Local Government’s Mission of Managing Natural Disasters - David Kunz (Civil Solutions)</td>
						        <td></td>
						        <td>
						        	<ol start="14" style="margin: 0; padding-left: 10px;">
										<li>Sharing maps and tools using ArcGIS Online</li>
										<li>Sharing data with the Community Maps Program</li>
										<li>Spatial statistics for public health</li>
										<li>Working with CAD in ArcGIS for Desktop</li>
										<li>Introduction to geoprocessing using Python</li>
										<li>What’s new in ArcGIS for Desktop 10 and 10.1</li>
						        	</ol>
								</td>
						    </tr>
						</table>
					</div>
			    </div>
			</div>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
	
<script>

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

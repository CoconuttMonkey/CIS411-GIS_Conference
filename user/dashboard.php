<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/
require_once("../models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("../models/header.php");

?>
<style>
	.announcement-heading { font-size: 3.2em; }
</style>
<body>
	<?php include("../models/main-nav.php"); ?>
	<section class="container">
			<h3>Attendee Dashboard</h3>
			<div class="row">
	      <div class="col-lg-4">
	        <div class="panel panel-danger">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading">Presentations</p>
	              </div>
	            </div>
	          </div>
	          <a href="../conference/register.php?type=presentation">
	            <div class="panel-footer announcement-bottom">
	              <div class="row">
	                <div class="col-xs-12">
	                  Request a Presentation
	                </div>
	              </div>
	            </div>
	          </a>
	        </div>
	      </div>
	      <div class="col-lg-4">
	        <div class="panel panel-success">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading">Exhibits</p>
	              </div>
	            </div>
	          </div>
	          <a href="../conference/register.php?type=exhibit">
	            <div class="panel-footer announcement-bottom">
	              <div class="row">
	                <div class="col-xs-12">
	                  Request an Exhibit
	                </div>
	              </div>
	            </div>
	          </a>
	        </div>
	      </div>
	      <div class="col-lg-4">
	        <div class="panel panel-warning">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading">Sponsors</p>
	              </div>
	            </div>
	          </div>
	          <a href="../conference/regitster.php?type=new">
	            <div class="panel-footer announcement-bottom">
	              <div class="row">
	                <div class="col-xs-12">
	                  Become a Sponsor
	                </div>
	              </div>
	            </div>
	          </a>
	        </div>
	      </div>
			</div>
		</div>
	</section>
	<?php include("../models/footer.php"); ?>
</body>
</html>
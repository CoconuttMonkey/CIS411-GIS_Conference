<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<section class="container">
		<h1>Dashboard</h1>
		<div class="col-lg-10 col-md-10">
			<?php if ($loggedInUser->checkPermission(array(2)) || $loggedInUser->checkPermission(array(4))) { ?>
			<div class="row">
				<div class="col-lg-3">
	        <div class="panel panel-info">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading">456</p>
	                <p class="announcement-text">Total Users</p>
	              </div>
	            </div>
	          </div>
	          <a href="admin_users.php?list=all">
	            <div class="panel-footer announcement-bottom">
	              <div class="row">
	                <div class="col-xs-12">
	                  View All Users
	                </div>
	              </div>
	            </div>
	          </a>
	        </div>
	      </div>
	      
	      <div class="col-lg-3">
	        <div class="panel panel-warning">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading">0</p>
	                <p class="announcement-text">Pending Presentations</p>
	              </div>
	            </div>
	          </div>
	          <a href="conf_presentations.php?list=pending">
	            <div class="panel-footer announcement-bottom">
	              <div class="row">
	                <div class="col-xs-12">
	                  View Pending
	                </div>
	              </div>
	            </div>
	          </a>
	        </div>
	      </div>
	      
	      <div class="col-lg-3">
	        <div class="panel panel-warning">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading">0</p>
	                <p class="announcement-text">Pending Exhibits</p>
	              </div>
	            </div>
	          </div>
	          <a href="conf_exhibits.php?list=pending">
	            <div class="panel-footer announcement-bottom">
	              <div class="row">
	                <div class="col-xs-12">
	                  View Pending
	                </div>
	              </div>
	            </div>
	          </a>
	        </div>
	      </div>
	      
	      <div class="col-lg-3">
	        <div class="panel panel-danger">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading">3</p>
	                <p class="announcement-text">Pending Sponsors</p>
	              </div>
	            </div>
	          </div>
	          <a href="conf_sponsors.php?list=pending">
	            <div class="panel-footer announcement-bottom">
	              <div class="row">
	                <div class="col-xs-12">
	                  View Pending
	                </div>
	              </div>
	            </div>
	          </a>
	        </div>
	      </div>
			</div><!-- /.row -->
	      
			<div class="row">
				<div class="col-lg-3">
	        <div class="panel panel-info">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading">96</p>
	                <p class="announcement-text">Attendees</p>
	              </div>
	            </div>
	          </div>
	          <a href="admin_users.php?list=attendees">
	            <div class="panel-footer announcement-bottom">
	              <div class="row">
	                <div class="col-xs-12">
	                  View Attendees
	                </div>
	              </div>
	            </div>
	          </a>
	        </div>
	      </div>
	      
	      <div class="col-lg-3">
	        <div class="panel panel-success">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading">12</p>
	                <p class="announcement-text">Scheduled Presentations</p>
	              </div>
	            </div>
	          </div>
	          <a href="conf_presentations.php?list=active">
	            <div class="panel-footer announcement-bottom">
	              <div class="row">
	                <div class="col-xs-12">
	                  View Presentations
	                </div>
	              </div>
	            </div>
	          </a>
	        </div>
	      </div>
	      
				<div class="col-lg-3">
	        <div class="panel panel-success">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading">6</p>
	                <p class="announcement-text">Active Exhibits</p>
	              </div>
	            </div>
	          </div>
	          <a href="conf_exhibits.php?list=active">
	            <div class="panel-footer announcement-bottom">
	              <div class="row">
	                <div class="col-xs-12">
	                  View Exhibits
	                </div>
	              </div>
	            </div>
	          </a>
	        </div>
	      </div>
	      
				<div class="col-lg-3">
	        <div class="panel panel-success">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading">4</p>
	                <p class="announcement-text">Active Sponsors</p>
	              </div>
	            </div>
	          </div>
	          <a href="conf_sponsors.php?list=active">
	            <div class="panel-footer announcement-bottom">
	              <div class="row">
	                <div class="col-xs-12">
	                  View Exhibits
	                </div>
	              </div>
	            </div>
	          </a>
	        </div>
	      </div>
			</div><!-- /.row -->
		</div>
			<? } ?>
		<aside class="col-lg-2">
			<? 
			if(isUserLoggedIn()) {
				include('models/sideNav.php');
			} else {
				include('models/loginForm.php');
			}
			?>
		</aside>
	</section>
	<?php include("models/footer.php"); ?>
</body>
</html>
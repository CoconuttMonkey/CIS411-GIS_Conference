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
		<h1>Admin Dashboard <? if(!userIsAttendee($loggedInUser->user_id)) echo '<a href="../conference/register.php" class="btn btn-success" style="float: right;">Register for the next conference!</a>'; ?></h1>
		<div class="col-lg-12">
			<div class="row">
				<h2>Users</h2>
				<div class="col-lg-3 col-md-3 col-sm-6">
	        <div class="panel panel-info">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading"><? echo count(fetchAllUsers()); ?></p>
	                <p class="announcement-text">Total Users</p>
	              </div>
	            </div>
	          </div>
	          <a href="../admin/users.php?list=all">
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
	      
				<div class="col-lg-3 col-md-3 col-sm-6">
	        <div class="panel panel-success">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading"><? echo count(fetchAllAttendees()); ?></p>
	                <p class="announcement-text">Attendees</p>
	              </div>
	            </div>
	          </div>
	          <a href="../admin/users.php?list=attendees">
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
	      
				<div class="col-lg-3 col-md-3 col-sm-6">
	        <div class="panel panel-danger">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading"><? echo count(fetchAllAttendees()); ?></p>
	                <p class="announcement-text">Unpaid</p>
	              </div>
	            </div>
	          </div>
	          <a href="../admin/users.php?list=attendees">
	            <div class="panel-footer announcement-bottom">
	              <div class="row">
	                <div class="col-xs-12">
	                  View Unpaid Attendees
	                </div>
	              </div>
	            </div>
	          </a>
	        </div>
	      </div>
			</div>
			<div class="row">
				<h2>Presentations</h2>
	      <div class="col-lg-3 col-md-3 col-sm-6">
	        <div class="panel panel-info">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading">0</p>
	                <p class="announcement-text">Pending Presentations</p>
	              </div>
	            </div>
	          </div>
	          <a href="../conference/presentations.php?list=pending">
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
	      
	      <div class="col-lg-3 col-md-3 col-sm-6">
	        <div class="panel panel-success">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading">12</p>
	                <p class="announcement-text">Scheduled Presentations</p>
	              </div>
	            </div>
	          </div>
	          <a href="../conference/presentations.php?list=active">
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
			</div><!-- /.row -->
			<div class="row">
				<h2>Exhibits</h2>
	      <div class="col-lg-3 col-md-3 col-sm-6">
	        <div class="panel panel-info">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading">0</p>
	                <p class="announcement-text">Pending Exhibits</p>
	              </div>
	            </div>
	          </div>
	          <a href="../conference/exhibits.php?list=pending">
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
	      
				<div class="col-lg-3 col-md-3 col-sm-6">
	        <div class="panel panel-success">
	          <div class="panel-heading">
	            <div class="row">
	              <div class="col-xs-12 text-right">
	                <p class="announcement-heading">6</p>
	                <p class="announcement-text">Active Exhibits</p>
	              </div>
	            </div>
	          </div>
	          <a href="../conference/exhibits.php?list=active">
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
	</section>
	<?php include("../models/footer.php"); ?>
</body>
</html>
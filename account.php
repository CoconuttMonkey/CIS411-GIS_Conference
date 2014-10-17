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
	<section>
	<div class="col-lg-2">
	<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a class="active" href="index.html"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Charts<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="flot.html">Flot Charts</a>
                                </li>
                                <li>
                                    <a href="morris.html">Morris.js Charts</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="tables.html"><i class="fa fa-table fa-fw"></i> Tables</a>
                        </li>
                        <li>
                            <a href="forms.html"><i class="fa fa-edit fa-fw"></i> Forms</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-wrench fa-fw"></i> UI Elements<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="panels-wells.html">Panels and Wells</a>
                                </li>
                                <li>
                                    <a href="buttons.html">Buttons</a>
                                </li>
                                <li>
                                    <a href="notifications.html">Notifications</a>
                                </li>
                                <li>
                                    <a href="typography.html">Typography</a>
                                </li>
                                <li>
                                    <a href="grid.html">Grid</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                    <!-- /.nav-third-level -->
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div></div>
            <!-- /.navbar-static-side -->
        </nav>
		<h1>Dashboard</h1>
		<div class="col-lg-8">
			<?php if ($loggedInUser->checkPermission(array(2)) || $loggedInUser->checkPermission(array(4))) { ?>
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-6">
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
	      
				<div class="col-lg-3 col-md-3 col-sm-6">
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
	      
	      <div class="col-lg-3 col-md-3 col-sm-6">
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
			</div><!-- /.row -->
	      
			<div class="row">
	      
	      <div class="col-lg-3 col-md-3 col-sm-6">
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
	      
	      <div class="col-lg-3 col-md-3 col-sm-6">
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
	      
				<div class="col-lg-3 col-md-3 col-sm-6">
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
	                  View Sponsors
	                </div>
	              </div>
	            </div>
	          </a>
	        </div>
	      </div>
			</div><!-- /.row -->
		</div>
	</section>
	<?php } include("models/footer.php"); ?>
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>
</body>
</html>
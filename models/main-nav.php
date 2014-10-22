
	<nav id="main-nav" class="navbar navbar-default navbar-inverse drop-shadow" role="navigation">
		<div class="container">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="<? echo $websiteUrl; ?>"><? echo $websiteName; ?></a>
		    </div>
				
		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		          <li id="navbar-home"><a href="index.php">Home</a></li>
		          <li id="navbar-schedule"><a href="schedule.php">Schedule</a></li>
		          <li id="navbar-contact"><a href="contact.php">Contact Us</a></li>
		      </ul>
		      <ul class="nav navbar-nav navbar-right"><? if (!isUserLoggedIn()) { ?>
	          <li id="navbar-register"><a href="register.php">Register</a></li>
	          <li id="navbar-login"><a href="login.php">Login</a></li><? } ?>
		      <? if(isUserLoggedIn()) { ?>
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account <span class="caret"></span></a>
		          <ul class="dropdown-menu" role="menu">
								<li><a href='account.php'>Dashboard</a></li>
								<li><a href='user_settings.php'>Account Settings</a></li>
								<li><a href='logout.php'>Logout</a></li>
		          </ul>
		        </li>
						<? if($loggedInUser->checkPermission(array(3)) || $loggedInUser->checkPermission(array(4))) { ?>
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <span class="caret"></span></a>
		          <ul class="dropdown-menu" role="menu">
								<li><a href='admin_users.php'>Users</a></li>
								<li><a href='admin_users.php?list=attendees'>Attendees</a></li>
								<li><a href='conf_presentations.php'>Presentations</a></li>
								<li><a href='conf_exhibits.php'>Exhibits</a></li>
								<li><a href='sponsors.php'>Sponsors</a></li>
								<li><a href='conf_settings.php'>Conference Settings</a></li>
		          </ul>
		        </li>
		        <? } if ($loggedInUser->checkPermission(array(4))) { ?>
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Web Master <span class="caret"></span></a>
		          <ul class="dropdown-menu" role="menu">
								<li><a href='admin_configuration.php'>Site Settings</a></li>
								<li><a href='admin_users.php'>User Listing</a></li>
								<li><a href='admin_permissions.php'>Permission Levels</a></li>
								<li><a href='admin_pages.php'>Web Pages</a></li>
		          </ul>
		        </li>
						<? } ?>
	        <? } ?>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</div>
	</nav>
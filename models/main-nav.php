
	<nav id="main-nav" class="navbar navbar-default navbar-inverse" role="navigation">
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
		        <li class="dropdown">
		          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
		          <ul class="dropdown-menu" role="menu">
		            <li><a href="#">Action</a></li>
		            <li><a href="#">Another action</a></li>
		            <li><a href="#">Something else here</a></li>
		            <li class="divider"></li>
		            <li><a href="#">Separated link</a></li>
		          </ul>
		        </li>
		      </ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</div>
	</nav>
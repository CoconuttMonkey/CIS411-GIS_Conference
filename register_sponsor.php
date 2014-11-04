<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
if(!isUserLoggedIn()) { header("Location: ../login.php"); die(); }

require_once("models/header.php");
?>
<body>
	<?php include("models/main-nav.php"); ?>
	<div class='container'>
		<div class='row'>
			<div class='col-lg-12'>
				<h1>Sponsor Registration</h1>
				<? echo resultBlock($errors,$successes); ?>
		<form name='newSponsor' id="newSponsor" action='<? $_SERVER['PHP_SELF'] ?>' method='post' class="forms text-left">
				<div class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Contact Person</h4></div>
		        <input type="text" class="form-control" name="first_name" value="<? echo $loggedInUser->user_id; ?>" disabled="disabled" style="display:none;" />
					  <div class="panel-body">
		          <div class="form-group">
	              <label class="control-label">First Name</label>
	              <input type="text" class="form-control" name="first_name" value="<? echo $loggedInUser->first_name; ?>" disabled="disabled" />
		          </div>
		          <div class="form-group">
	              <label class="control-label">Last name</label>
	              <input type="text" class="form-control" name="last_name" value="<? echo $loggedInUser->last_name; ?>" disabled="disabled" />
		          </div>
		
		          <div class="form-group">
	              <label class="control-label">Email address</label>
	              <input type="text" class="form-control" name="email" value="<? echo $loggedInUser->email; ?>" disabled="disabled" />
		          </div>
					  </div>
					</div>
			
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Attendees</h4></div>
					  <div class="panel-body">
				      <label class="control-label">Email Addresses</label>
              <div class="row form-group">
				        <div class="col-lg-9">
				            <input type="text" class="form-control" name="sponsor_attendees[]" placeholder="Invite by email" />
				        </div>
				        <div class="col-lg-3">
				            <button type="button" class="btn btn-success addButton"><span class="glyphicon glyphicon-plus"></span></button>
				        </div>
				    	</div>
				    	<!-- The option field template containing an option field and a Remove button -->
					    <div class="row form-group hide" id="sponsor_attendeesTemplate">
				        <div class="col-lg-9">
				          <input class="form-control" type="text" name="sponsor_attendees[]" placeholder="Invite by email" />
				        </div>
				        <div class="col-lg-3">
				          <button type="button" class="btn btn-danger removeButton"><span class="glyphicon glyphicon-remove"></span></button>
				        </div>
					    </div>
					  </div>
					</div>
				</div>
				
				<div class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-heading"><h4>Company Profile</h4></div>
					  <div class="panel-body">
		          <div class="form-group">
						  	<textarea class="form-control" rows="8" id="exhibit_comp_profile" placeholder="Tell us about yourself"></textarea>
		          </div>
		          <div class="form-group">
			          <label class="control-label">Company Logo</label>
			          <div class="form-group">
			            <input type="file" class="form-control" name="sponsor_logo" />
			            <span class="help-block text-right">Choose a pdf file with a size less than 1M.</span>
			          </div>
			        </div>
					  </div>
					</div>
				</div>
			</div><!-- /.row -->
		</form>
			</div>
		</div>
	</div>
	<?php 
		include("models/footer.php");
		include("models/BootstrapJavaScript.php"); 
	?>
</body>
</html>

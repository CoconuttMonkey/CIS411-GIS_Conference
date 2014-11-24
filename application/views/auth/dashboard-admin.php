<div class="container" style="margin-top: 50px;">
	<div class="col-md-9">
		<section class="row">
			<h1>Administrative Dashboard</h1>
			<p>Here you can access all administrative functions</p>
			<div id="infoMessage"><?php echo $message;?></div>
		</section>
		
		<!-- 
			INFO ABOUT USERS / ATTENDEES
		-->
		<section class="row">
			<div class="col-lg-4 col-md-4 col-sm-4">
	      <div class="panel panel-info">
	        <div class="panel-heading">
	          <div class="row">
	            <div class="col-xs-12 text-right">
	              <p class="announcement-heading"><?= $user_count ?></p>
	              <p class="announcement-text">Total Users</p>
	            </div>
	          </div>
	        </div>
	        <a href="<?= site_url('auth/users') ?>">
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
		</section>
		
		<!-- 
			INFO ABOUT SPONSORS
		-->
	  <section class="row">
			<div class="col-lg-4 col-md-4 col-sm-4">
	      <div class="panel panel-warning">
	        <div class="panel-heading">
	          <div class="row">
	            <div class="col-xs-12 text-right">
	              <p class="announcement-heading"><?= $unpaid_sponsor_count ?></p>
	              <p class="announcement-text">Unpaid Sponsors</p>
	            </div>
	          </div>
	        </div>
	        <a href="<?= site_url('sponsor/list/unpaid') ?>">
	          <div class="panel-footer announcement-bottom">
	            <div class="row">
	              <div class="col-xs-12">
	                View Unpaid Sponsors
	              </div>
	            </div>
	          </div>
	        </a>
	      </div>
	    </div>
	    
			<div class="col-lg-4 col-md-4 col-sm-4">
	      <div class="panel panel-success">
	        <div class="panel-heading">
	          <div class="row">
	            <div class="col-xs-12 text-right">
	              <p class="announcement-heading"><?= $paid_sponsor_count ?></p>
	              <p class="announcement-text">Paid Sponsors</p>
	            </div>
	          </div>
	        </div>
	        <a href="<?= site_url('sponsor/list/unpaid') ?>">
	          <div class="panel-footer announcement-bottom">
	            <div class="row">
	              <div class="col-xs-12">
	                View Paid Sponsors
	              </div>
	            </div>
	          </div>
	        </a>
	      </div>
	    </div>
		</section>
	</div>
	
	<aside class="col-md-3">
		<p>
			<a href="<?= site_url('conference/setup_new_conference') ?>" class="btn btn-sunny btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Setup New Conference</a>
			<a href="<?= site_url('auth/create_user') ?>" class="btn btn-sunny btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create User</a>
			<a href="<?= site_url('sponsor/create_sponsor') ?>" class="btn btn-sunny btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create Sponsor</a>
		</p>
	</aside>
</div>
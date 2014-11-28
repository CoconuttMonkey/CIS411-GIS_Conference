<div class="container" style="margin-top: 50px;">
	
	<section class="col-lg-12">
		<h2>Administrative Dashboard</h2>
		<p>Here you can access all administrative functions</p>
	</section>
	<div class="col-sm-9">
		<div id="infoMessage"><?php echo $message;?></div>
		<!-- 
			INFO ABOUT USERS / ATTENDEES
		-->
		<section class="row">
			<div class="col-md-4 col-xs-6">
	      <div class="panel panel-info">
	        <div class="panel-heading">
	          <div class="row">
	            <div class="col-sm-12 text-right">
	              <p class="announcement-heading"><?= $user_count ?></p>
	              <p class="announcement-text">Total Users</p>
	            </div>
	          </div>
	        </div>
	        <a href="<?= site_url('auth/users') ?>">
	          <div class="panel-footer announcement-bottom">
	            <div class="row">
	              <div class="col-sm-12">
	                View All Users
	              </div>
	            </div>
	          </div>
	        </a>
	      </div>
	    </div>
	    
			<div class="col-md-4 col-xs-6">
	      <div class="panel panel-success">
	        <div class="panel-heading">
	          <div class="row">
	            <div class="col-sm-12 text-right">
	              <p class="announcement-heading"><?= $attendee_count ?></p>
	              <p class="announcement-text">Total Attendees</p>
	            </div>
	          </div>
	        </div>
	        <a href="<?= site_url('attendee/listing/'.$current_conf) ?>">
	          <div class="panel-footer announcement-bottom">
	            <div class="row">
	              <div class="col-sm-12">
	                View All Attendees
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
			<div class="col-md-4 col-xs-6">
	      <div class="panel panel-warning">
	        <div class="panel-heading">
	          <div class="row">
	            <div class="col-sm-12 text-right">
	              <p class="announcement-heading"><?= $unpaid_sponsor_count ?></p>
	              <p class="announcement-text">Unpaid Sponsors</p>
	            </div>
	          </div>
	        </div>
	        <a href="<?= site_url('sponsor/listing/unpaid') ?>">
	          <div class="panel-footer announcement-bottom">
	            <div class="row">
	              <div class="col-sm-12">
	                View Unpaid Sponsors
	              </div>
	            </div>
	          </div>
	        </a>
	      </div>
	    </div>
	    
			<div class="col-md-4 col-xs-6">
	      <div class="panel panel-success">
	        <div class="panel-heading">
	          <div class="row">
	            <div class="col-sm-12 text-right">
	              <p class="announcement-heading"><?= $paid_sponsor_count ?></p>
	              <p class="announcement-text">Paid Sponsors</p>
	            </div>
	          </div>
	        </div>
	        <a href="<?= site_url('sponsor/listing/paid') ?>">
	          <div class="panel-footer announcement-bottom">
	            <div class="row">
	              <div class="col-sm-12">
	                View Paid Sponsors
	              </div>
	            </div>
	          </div>
	        </a>
	      </div>
	    </div>
		</section>
		
		<!-- 
			INFO ABOUT PRESENTATIONS
		-->
	  <section class="row">
			<div class="col-md-4 col-xs-6">
	      <div class="panel panel-warning">
	        <div class="panel-heading">
	          <div class="row">
	            <div class="col-sm-12 text-right">
	              <p class="announcement-heading"><?= $pending_presentation_count ?></p>
	              <p class="announcement-text">Pending Presentations</p>
	            </div>
	          </div>
	        </div>
	        <a href="<?= site_url('presentation/listing/pending') ?>">
	          <div class="panel-footer announcement-bottom">
	            <div class="row">
	              <div class="col-sm-12">
	                View Pending Presentations
	              </div>
	            </div>
	          </div>
	        </a>
	      </div>
	    </div>
	    
			<div class="col-md-4 col-xs-6">
	      <div class="panel panel-success">
	        <div class="panel-heading">
	          <div class="row">
	            <div class="col-sm-12 text-right">
	              <p class="announcement-heading"><?= $scheduled_presentation_count ?></p>
	              <p class="announcement-text">Scheduled Presentations</p>
	            </div>
	          </div>
	        </div>
	        <a href="<?= site_url('presentation/listing/scheduled') ?>">
	          <div class="panel-footer announcement-bottom">
	            <div class="row">
	              <div class="col-sm-12">
	                View Scheduled Presentations
	              </div>
	            </div>
	          </div>
	        </a>
	      </div>
	    </div>
		</section>
		
		<!-- 
			INFO ABOUT EXHIBITS
		-->
	  <section class="row">
			<div class="col-md-4 col-xs-6">
	      <div class="panel panel-warning">
	        <div class="panel-heading">
	          <div class="row">
	            <div class="col-sm-12 text-right">
	              <p class="announcement-heading"><?= $unpaid_exhibit_count ?></p>
	              <p class="announcement-text">Unpaid Exhibits</p>
	            </div>
	          </div>
	        </div>
	        <a href="<?= site_url('exhibit/listing/unpaid') ?>">
	          <div class="panel-footer announcement-bottom">
	            <div class="row">
	              <div class="col-sm-12">
	                View Unpaid Exhibits
	              </div>
	            </div>
	          </div>
	        </a>
	      </div>
	    </div>
	    
			<div class="col-md-4 col-xs-6">
	      <div class="panel panel-success">
	        <div class="panel-heading">
	          <div class="row">
	            <div class="col-sm-12 text-right">
	              <p class="announcement-heading"><?= $paid_exhibit_count ?></p>
	              <p class="announcement-text">Paid Exhibits</p>
	            </div>
	          </div>
	        </div>
	        <a href="<?= site_url('exhibit/listing/paid') ?>">
	          <div class="panel-footer announcement-bottom">
	            <div class="row">
	              <div class="col-sm-12">
	                View Paid Exhibits
	              </div>
	            </div>
	          </div>
	        </a>
	      </div>
	    </div>
		</section>
	</div>
	
	<aside class="col-sm-3">
		<p>	
			<h5 class="text-right">Conference Links</h5>
			<a href="<?= site_url('conference/setup_new_conference') ?>" class="btn btn-sunny btn-block">Create Conference</a>
			<a href="<?= site_url('sponsor/create_sponsor') ?>" class="btn btn-sunny btn-block">Create Sponsor</a>
			<a href="<?= site_url('presentation/register') ?>" class="btn btn-block btn-sunny">Create Presentation</a>
			<a href="<?= site_url('exhibit/register') ?>" class="btn btn-block btn-sunny">Create Exhibit</a>
			<h5 class="text-right">User Links</h5>
			<a href="<?= site_url('auth/create_user') ?>" class="btn btn-sunny btn-block">Create User</a>
			<a href="<?= site_url('attendee/register') ?>" class="btn btn-sunny btn-block">Attendee Registration</a>
			<h5 class="text-right">Downloads</h5>
			<br>
		</p>
	</aside>
</div>
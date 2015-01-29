<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-xs-6">
			<h2>Administrative Dashboard</h2>
			<p>Here you can access all administrative functions</p>
		</div>
		
		<aside class="col-xs-6 text-right" style="padding-top: 15px;">
			<div class="dropdown" style="position: relative; display: inline-block;">
			  <button class="btn btn-sunny dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
			    
			    Create <span class="caret white-caret"></span>
			  </button>
			  <ul class="dropdown-menu text-left" role="menu" aria-labelledby="dropdownMenu1">
			
					<li role="presentation"><a href="<?= site_url('auth/create_user') ?>">User</a></li>
					<? if (!$secretary) : ?>
					<li role="presentation"><a href="<?= site_url('conference/setup_new_conference') ?>">Conference</a></li>
					<li role="presentation"><a href="<?= site_url('sponsor/create_sponsor') ?>">Sponsor</a></li>
					<li role="presentation"><a href="<?= site_url('presentation/register') ?>">Presentation</a></li>
					<li role="presentation"><a href="<?= site_url('exhibit/register') ?>">Exhibit</a></li>
					<li role="presentation"><a href="<?= site_url('auth/create_group') ?>">Group</a></li>	
					<? endif; ?>
			  </ul>
			</div>
			
			<div class="dropdown" style="position: relative; display: inline-block;">
			  <button class="btn btn-sunny dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">
			    
			     Download <span class="caret white-caret"></span>
			  </button>
			  <ul class="dropdown-menu text-left" role="menu" aria-labelledby="dropdownMenu1">
					<li role="presentation"><a href="<?= site_url('download/attendees/'.$current_conf) ?>">Attendees</a></li>
					<li role="presentation"><a href="<?= site_url('download/presentations/'.$current_conf.'/scheduled') ?>">Scheduled Presentations</a></li>
					<li role="presentation"><a href="<?= site_url('download/presentations/'.$current_conf.'/pending') ?>">Pending Presentations</a></li>
					<li role="presentation"><a href="<?= site_url('download/exhibits/'.$current_conf.'/paid') ?>">Scheduled Exhibits</a></li>
					<li role="presentation"><a href="<?= site_url('download/exhibits/'.$current_conf.'/unpaid') ?>">Pending Exhibits</a></li>
					<li role="presentation"><a href="<?= site_url('download/sponsors/'.$current_conf.'/paid') ?>">Paid Sponsors</a></li>	
					<li role="presentation"><a href="<?= site_url('download/sponsors/'.$current_conf.'/unpaid') ?>">Unpaid Sponsors</a></li>	
			  </ul>
			</div>
			
			<? if (!$secretary) : ?>
			<div class="dropdown" style="position: relative; display: inline-block;">
			  <button class="btn btn-sunny dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-expanded="true">
			    
			    Send mail to <span class="caret white-caret"></span>
			  </button>
			  <ul class="dropdown-menu text-left" role="menu" aria-labelledby="dropdownMenu3">
					<li role="presentation"><a href="<?= site_url('email/attendees/') ?>">All Attendees</a></li>
					<li role="presentation"><a href="<?= site_url('email/attendees/paid') ?>">Paid Attendees</a></li>
					<li role="presentation"><a href="<?= site_url('email/attendees/unpaid') ?>">Unpaid Attendees</a></li>
					<li role="presentation"><a href="<?= site_url('email/presenters/scheduled') ?>">Scheduled Presenters</a></li>
					<li role="presentation"><a href="<?= site_url('email/presenters/pending') ?>">Pending Presenters</a></li>
					<li role="presentation"><a href="<?= site_url('email/exhibitors/paid') ?>">Paid Exhibitors</a></li>
					<li role="presentation"><a href="<?= site_url('email/exhibitors/unpaid') ?>">Unpaid Exhibitors</a></li>
					<li role="presentation"><a href="<?= site_url('email/sponsors/paid') ?>">Paid Sponsors</a></li>	
					<li role="presentation"><a href="<?= site_url('email/sponsors/unpaid') ?>">Unpaid Sponsors</a></li>	
			  </ul>
			</div>
			<? endif; ?>
		</aside>
	</section>
	
	<div class="col-sm-9">
		<div id="infoMessage"><?php echo $message;?></div>
		<!-- 
			INFO ABOUT USERS / ATTENDEES
		-->
		<section class="row">
			<div class=" col-xs-6">
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
	    
			<div class=" col-xs-6">
	      <div class="panel panel-success">
	        <div class="panel-heading">
	          <div class="row">
	            <div class="col-sm-12 text-right">
	              <p class="announcement-heading"><?= $attendee_count ?></p>
	              <p class="announcement-text">Total Attendees</p>
	            </div>
	          </div>
	        </div>
	        <a href="<?= site_url('attendee/listing') ?>">
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
			<div class=" col-xs-6">
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
	    
			<div class=" col-xs-6">
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
			<div class=" col-xs-6">
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
	    
			<div class=" col-xs-6">
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
			<div class=" col-xs-6">
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
	    
			<div class=" col-xs-6">
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
</div>
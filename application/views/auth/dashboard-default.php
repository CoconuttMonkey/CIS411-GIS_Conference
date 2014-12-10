<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-md-9">
			<div class="row">
				<div class="col-xs-12">
					<h2>Dashboard</h2>
					<p>Here you can access all conference functions</p>
					<div id="infoMessage"><?php echo $message;?></div>
				</div>
			</div>
			
			<div class="row">
					<div class="col-xs-6">
			      <div class="panel panel-warning">
			        <div class="panel-heading">
			          <div class="row">
			            <div class="col-sm-12 text-right">
			              <p class="announcement-heading">Presentations</p>
			              <p class="announcement-text">
											<p class="text-left">Check out our scheduled presentations for this years conference!</p>
			              </p>
			            </div>
			          </div>
			        </div>
			        <a href="<?= site_url('presentation/listing/scheduled') ?>">
			          <div class="panel-footer announcement-bottom">
			            <div class="row">
			              <div class="col-sm-12">
			                <span class="glyphicon glyphicon-pencil"></span> View Presentations
			              </div>
			            </div>
			          </div>
			        </a>
			      </div>
			    </div>
			    
					<div class="col-xs-6">
			      <div class="panel panel-warning">
			        <div class="panel-heading">
			          <div class="row">
			            <div class="col-sm-12 text-right">
			              <p class="announcement-heading">Exhibits</p>
			              <p class="announcement-text">
											<p class="text-left">Check out our scheduled exhibits for this years conference!</p>
			              </p>
			            </div>
			          </div>
			        </div>
			        <a href="<?= site_url('exhibit/listing/paid') ?>">
			          <div class="panel-footer announcement-bottom">
			            <div class="row">
			              <div class="col-sm-12">
			                <span class="glyphicon glyphicon-pencil"></span> View Exhibits
			              </div>
			            </div>
			          </div>
			        </a>
			      </div>
			    </div>
			</div>
			
			<div class="row">
				
				<? if ($is_main_presenter == TRUE) : ?>
					<div class="col-xs-6">
			      <div class="panel panel-info">
			        <div class="panel-heading">
			          <div class="row">
			            <div class="col-sm-12 text-right">
			              <p class="announcement-heading">My Presentation</p>
			              <p class="announcement-text">
				              <? if ($presentation['scheduled'] == 'yes') : ?>
											<div class="alert alert-success"><strong>Scheduled</strong>
												<p class="text-left">
													<strong>Day:</strong> <?= $presentation['week_day']?><br>
													<strong>Room:</strong> <?= $presentation['room_number']." ".$presentation['building']?><br>
													<strong>Time:</strong> <?= date('h:i A', strtotime($presentation['start_time']))." - ".date('h:i A', strtotime($presentation['end_time']))?><br>
												</p>
											</div>
											<? endif; ?>
											
				              <? if ($presentation['scheduled'] == 'no') : ?>
				              <div class="alert alert-warning">
												<strong>Not Scheduled</strong>
												<p class="text-left">
													Please be patient, you will be notified when your presentation is scheduled.
												</p>
												<p class="text-left">
													<strong>Requested Day:</strong> <?= $presentation['week_day']?><br>
													<strong>Requested Time:</strong> <?= $presentation['time_request']?><br>
												</p>
				              </div>
											<? endif; ?>
											<p class="text-center">
											<? if ($presentation['presentation_attachment']) : ?>
											<a href="<?= site_url('download/presentation_attachment/'.$presentation['presentation_id']) ?>">Download Attachment</a> |
											<? endif; ?>
											<a href="<?= site_url('upload/presentation_attachment/'.$presentation['presentation_id']) ?>">Upload Attachment</a>
											</p>
			              </p>
			            </div>
			          </div>
			        </div>
			        <a href="<?= site_url('presentation/edit/'.$presentation['presentation_id']) ?>">
			          <div class="panel-footer announcement-bottom">
			            <div class="row">
			              <div class="col-sm-12">
			                <span class="glyphicon glyphicon-pencil"></span> Edit My Presentation
			              </div>
			            </div>
			          </div>
			        </a>
			      </div>
			    </div>
				<? endif; ?>
				
				<? if ($is_main_exhibitor == TRUE) : ?>
					<div class="col-xs-6">
			      <div class="panel panel-info">
			        <div class="panel-heading">
			          <div class="row">
			            <div class="col-sm-12 text-right">
			              <p class="announcement-heading">My Exhibit</p>
			              <p class="announcement-text">
				              <? if ($exhibit['paid'] == 'no') : ?>
											<div class="alert alert-danger">
												Balance: <strong>$125.00</strong>
												<p class="text-left">
													<strong>Please send payments to:</strong><br>ATTN: Dr. Yasser Ayad<br>840 Wood Street<br>Clarion, PA 16214
												</p>
												<p class="text-left">
													<strong>Please make checks payable to:</strong><br>NW PA GIS Conference
												</p>
											</div>
											<? endif; ?>
			              </p>
			            </div>
			          </div>
			        </div>
			        <a href="<?= site_url('exhibit/edit/'.$exhibit['exhibit_id']) ?>">
			          <div class="panel-footer announcement-bottom">
			            <div class="row">
			              <div class="col-sm-12">
			                <span class="glyphicon glyphicon-pencil"></span> Edit My Exhibit
			              </div>
			            </div>
			          </div>
			        </a>
			      </div>
			    </div>
				<? endif; ?>
				
				<? if ($is_sponsor == TRUE) : ?>
					<div class="col-xs-6">
			      <div class="panel panel-info">
			        <div class="panel-heading">
			          <div class="row">
			            <div class="col-sm-12 text-right">
			              <p class="announcement-heading">Sponsorship</p>
			              <p class="announcement-text">
				              <? if ($sponsor['paid'] != 'yes') : ?>
											<div class="alert alert-danger">Balance: <strong><?=$balance?></strong>
												<p class="text-left">
													<strong>Please send payments to:</strong><br>ATTN: Dr. Yasser Ayad<br>840 Wood Street<br>Clarion, PA 16214
												</p>
												<p class="text-left">
													<strong>Please make checks payable to:</strong><br>NW PA GIS Conference
												</p>
											</div>
											<? endif; ?>
			              </p>
			            </div>
			          </div>
			        </div>
			        <a href="<?= site_url('sponsor/edit/'.$sponsor['sponsor_id']) ?>">
			          <div class="panel-footer announcement-bottom">
			            <div class="row">
			              <div class="col-sm-12">
			                <span class="glyphicon glyphicon-pencil"></span> Edit Sponsor Details
			              </div>
			            </div>
			          </div>
			        </a>
			      </div>
			    </div>
				<? endif; ?>
			</div>
		</div>
		
		<aside class="col-md-3">
			<h5 class="text-right">Links</h5>
			<p>
				<? if (!$is_attendee) : ?>
				<a href="<?= site_url('attendee/register') ?>" class="btn btn-block btn-fresh">Conference Registration</a>
				<? endif; ?>
				<? if ($is_attendee) : ?>
				<a href="<?= site_url('sponsor/create_sponsor') ?>" class="btn btn-block btn-fresh">Become a Sponsor</a>
				<a href="<?= site_url('presentation/register') ?>" class="btn btn-block btn-fresh">Register a Presentation</a>
				<a href="<?= site_url('exhibit/register') ?>" class="btn btn-block btn-fresh">Register an Exhibit</a>
				<a href="<?= site_url('attendee/edit/'.$user_id)?>" class="btn btn-block btn-sky">Edit Contact Info</a>
				<a href="<?= site_url('attendee/withdraw/'.$user_id)?>" class="btn btn-block btn-hot">Withdraw from Conference</a>
				<? endif; ?>
			</p>
		</aside>
			
	</section>
</div>
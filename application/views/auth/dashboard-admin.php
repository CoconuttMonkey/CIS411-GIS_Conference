<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-md-9">
			<h1>Administrative Dashboard</h1>
			<p>Here you can access all administrative functions</p>
			<div id="infoMessage"><?php echo $message;?></div>
		
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
		</div>
		
		<aside class="col-md-3">
			<p>
				<a href="<?= site_url('conference/setup_new_conference') ?>" class="btn btn-sunny btn-block"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Setup New Conference</a>
			</p>
		</aside>
			
	</section>
</div>
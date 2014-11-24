<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-md-9">
			<div class="row">
				<h1>Dashboard</h1>
				<p>Here you can access all conference functions</p>
				<div id="infoMessage"><?php echo $message;?></div>
			</div>
			
			<div class="row">
				
			</div>
		</div>
		
		<aside class="col-md-3">
			<h2>Links</h2>
			<p>
				<a href="<?= site_url('conference/register_attendee') ?>" class="btn btn-block btn-fresh">Conference Registration</a>
				<a href="<?= site_url('sponsor/create_sponsor') ?>" class="btn btn-block btn-fresh">Become a Sponsor</a>
			</p>
		</aside>
			
	</section>
</div>
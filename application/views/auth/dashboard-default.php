<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-md-9">
			<div class="row">
				<h1 Dashboard</h1>
				<p>Here you can access all conference functions</p>
				<div id="infoMessage"><?php echo $message;?></div>
			</div>
			
			<div class="row">
				<a href="<?= site_url('conference/register_attendee') ?>" class="btn btn-lg btn-fresh">Conference Registration</a>
			</div>
		</div>
		
		<aside class="col-md-3">
			<p>
			
			</p>
		</aside>
			
	</section>
</div>
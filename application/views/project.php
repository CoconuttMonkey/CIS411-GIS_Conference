<div class="container" style="margin-top: 50px;">
	<?= $this->breadcrumbs->show() ?>
	<section class="row">
	  <article class="col-md-4">
			<h1><?= $title ?></h1>
			
			<h5>About the project</h5>
			<p style="padding-left: 20px;"><?= $body ?></p>
			
			<h5>Deploy Date</h5>
			<p style="padding-left: 20px;"><?= $date ?></p>
			
			<h5>URL</h5>
			<p style="padding-left: 20px;"><a href="<?= $url ?>" target="_blank"><?= $url ?></a></p>
		</article>
		<aside class="col-md-8">
			<img src="<?= site_url($img) ?>" style="width: 100%; border: solid 5px rgb(0,117,191);" alt="<?= $title ?> Screenshot" />
		</aside>
	</section>
</div>

<style>
	.jumbotron {
		background: url(<?=site_url($banner)?>);
		background-size: contain;
		color: #fff !important;
	}
</style>
<div class="container" style="margin-top: 100px;">
	<div class="jumbotron">
			<p class="text-right"><?=$date?></p>
			<h1><span class="small"><?=$prefix?></span><br><?=$title?></h1>
			<p><?=$theme?></p>
	</div>
	<div class="clear"></div>
	<section class="row">
		<article class="col-lg-12">
			<?=$content?>
		</article>
	</section>
</div>

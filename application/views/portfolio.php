<div class="container" style="margin-top: 50px;">
	<section class="row">
		<?php foreach($query as $project): ?>
	  <article class="col-sm-6 col-md-4">
	    <div class="thumbnail">
	      <img src="<?php echo base_url($project->thumb); ?>" style="height: 100px; margin-top: 10px;" alt="East End Salon">
	      <div class="caption">
	        <h3><?= $project->title; ?></h3>
	        <p class="small"><?= word_limiter($project->body, 25); ?></p>
	        <p><a href="<?= site_url('portfolio/project/'.$project->project_id) ?>" class="btn btn-block btn-primary" role="button">View Project <i class="fa fa-arrow-right"></i></a></p>
	      </div>
	    </div>
	  </article>
	  <?php endforeach; ?>
	</section>
</div>

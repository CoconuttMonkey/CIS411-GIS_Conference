<div class="container" style="margin-top: 50px;">
	<?=$this->breadcrumbs->show()?>
	<section class="row">
		<div class="col-lg-12">
			<h2>Conference Listing</h2>
			<table class="table">
				<thead>
					<th>Year</th>
					<th>Title</th>
					<th>Theme</th>
					<th>Dates</th>
				</thead>
				<tbody>
				<?php foreach($list as $conference): ?>
					<tr>
						<td><?= $conference->conf_id ?></td>
						<td><?= $conference->prefix." ".$conference->title ?></td>
						<td><?= $conference->theme ?></td>
						<td><?= $conference->start_date." ".$conference->end_date ?></td>
						<td><a href="<?= site_url('conference/edit/'.$conference->conf_id) ?>">Edit</a>
					<tr>
			  <?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</section>
</div>

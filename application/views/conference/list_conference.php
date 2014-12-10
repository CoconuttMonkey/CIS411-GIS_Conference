<div class="container" style="margin-top: 100px;">
	<?=$this->breadcrumbs->show()?>
	<h2>Conference Listing<button type="button" class="reset btn btn-fresh" style="float: right; font-weight: normal; font-family: 'Open Sans';" data-column="0" data-filter=""><i class="glyphicon glyphicon-refresh"></i> Reset filters</button></h2>
	<div id="infoMessage"><?php echo $message;?></div>
	<table id="sort" class="tablesorter tablesorter-bootstrap" style="width:100%">
		<thead>
			<th>Year</th>
			<th>Title</th>
			<th>Theme</th>
			<th>Dates</th>
		</thead>
		<tfoot>
			<tr>
				<th colspan="7" id="pager" class="form-inline">
					<button type="button" class="btn btn-sky first"><i class="glyphicon glyphicon-step-backward"></i></button>
					<button type="button" class="btn btn-sky prev"><i class="glyphicon glyphicon-backward"></i></button>
					<span class="pagedisplay"></span>
					<button type="button" class="btn btn-sky next"><i class="glyphicon glyphicon-forward"></i></button>
					<button type="button" class="btn btn-sky last"><i class="glyphicon glyphicon-step-forward"></i></button>
					<label>Results per page: </label>
					<div class="form-group">
						<select class="pagesize form-control">
						<option selected="selected" value="10">10</option>
							<option value="20">20</option>
							<option value="30">30</option>
							<option value="40">40</option>
						</select>
					</div>
				</th>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach($list as $conference): 
			$start_date = new DateTime($conference->start_date);
			$start_date = $start_date->format("M d");
			$end_date = new DateTime($conference->end_date);
			$end_date = $end_date->format("M d");
			
		?>
			<tr>
				<td><?= $conference->conf_id ?></td>
				<td><?= $conference->prefix." ".$conference->title ?></td>
				<td><?= $conference->theme ?></td>
				<td><?= $start_date." - ".$end_date ?></td>
				<td><a href="<?= site_url('conference/edit/'.$conference->conf_id) ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
			</tr>
	  <?php endforeach; ?>
		</tbody>
	</table>
</div>

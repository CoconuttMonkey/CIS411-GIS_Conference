<div class="container" style="margin-top: 100px;">
	<?=$this->breadcrumbs->show()?>
	<div id="infoMessage"><?php echo $message;?></div>
	<div class="col-sm-6">
		<h2><?=$heading?></h2>
		<p><?=$subheading?></p>
	</div>
	
	<div class="col-sm-6" style="padding-top: 20px;">
    <ul class="nav navbar navbar-right nav-pills">
	    <? if ( $this->ion_auth->in_group('admin')) : ?>
	    <li <? if(is_active('presentation/listing/all')): ?>class="active"<? endif; ?>><a href="<?= site_url('presentation/listing/all') ?>">All</a></li>
      <li <? if(is_active('presentation/listing/scheduled')): ?>class="active"<? endif; ?>><a href="<?= site_url('presentation/listing/scheduled') ?>">Scheduled</a></li>
      <li <? if(is_active('presentation/listing/pending')): ?>class="active"<? endif; ?>><a href="<?= site_url('presentation/listing/pending') ?>">Pending</a></li>
      <? endif; ?>
    </ul>
	</div>
	
	<table id="sort" class="tablesorter tablesorter-bootstrap" style="width:100%">
		<thead>
			<th>Presentation ID</th>
			<th>Main Presenter</th>
			<th>Title</th>
			<? if(is_active('presentation/listing/scheduled')): ?>
			<th>Track</th>
			<th>Room</th>
			<th>Time</th>
       <? endif; ?>
			<th class="filter-false">Attachment</th>
		</thead>
		<tfoot>
			<tr>
				<th colspan="<? if(is_active('presentation/listing/scheduled')){echo"7";}else {echo"4";} ?>" id="pager" class="form-inline">
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
					<button type="button" class="reset btn btn-fresh" style="float: right; font-weight: normal; font-family: 'Open Sans';" data-column="0" data-filter=""><i class="glyphicon glyphicon-refresh"></i> Reset filters</button>
				</th>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($presentations as $presentation):?>
			<tr>
        <td><?=$presentation->presentation_id?></td>
        <td><?=$presentation->first_name." ".$presentation->last_name?></td>
        <td><?=$presentation->title?></td>
				<? if(is_active('presentation/listing/scheduled')): ?>
				<td><?=$presentation->full_name?></td>
				<td><?=$presentation->room_number." ".$presentation->building?></td>
        <td><?=$presentation->start_time." ".$presentation->end_time?></td>
        <? endif; ?>
				<td><a href="<?= site_url('download/presentation_attachment/'.$presentation->presentation_id) ?>" class="btn btn-sky">Download Attachment</a></td>
        <? if ( $this->ion_auth->in_group('admin')) : ?>
				<td><a href="<?=site_url('presentation/edit/'.$presentation->presentation_id)?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
				<? endif; ?>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>
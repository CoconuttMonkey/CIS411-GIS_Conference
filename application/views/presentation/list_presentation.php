<div class="container" style="margin-top: 50px;">
	<?=$this->breadcrumbs->show()?>
	<div id="infoMessage"><?php echo $message;?></div>
	<div class="col-sm-6">
		<h2><?=$heading?></h2>
		<p><?=$subheading?></p>
	</div>
	
	<div class="col-sm-6" style="padding-top: 20px;">
    <ul class="nav navbar navbar-right nav-pills">
	    <li <? if(is_active('presentation/listing/all')): ?>class="active"<? endif; ?>><a href="<?= site_url('presentation/listing/all') ?>">All</a></li>
      <li <? if(is_active('presentation/listing/scheduled')): ?>class="active"<? endif; ?>><a href="<?= site_url('presentation/listing/scheduled') ?>">Scheduled</a></li>
      <li <? if(is_active('presentation/listing/pending')): ?>class="active"<? endif; ?>><a href="<?= site_url('presentation/listing/pending') ?>">Pending</a></li>
    </ul>
	</div>
	
	<table class="table table-striped">
		<thead>
			<th>Presentation ID</th>
			<th>Main Presenter</th>
			<th>Title</th>
			<th>Track</th>
			<th>Room</th>
			<th>Time</th>
			<th></th>
		</thead>
		<tbody>
		<?php foreach ($presentations as $presentation):?>
			<tr>
        <td><?=$presentation->presentation_id?></td>
        <td><?=$presentation->first_name." ".$presentation->last_name?></td>
        <td><?=$presentation->title?></td>
				<td><?=$presentation->full_name?></td>
				<td><?=$presentation->room_number." ".$presentation->building?></td>
        <td><?=$presentation->start_time." ".$presentation->end_time?></td>
				<td><a href="<?=site_url('presentation/edit/'.$presentation->presentation_id)?>"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>
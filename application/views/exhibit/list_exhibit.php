<div class="container" style="margin-top: 50px;">
	<?=$this->breadcrumbs->show()?>
	<div id="infoMessage"><?php echo $message;?></div>
	<div class="col-sm-6">
		<h2><?=$heading?></h2>
		<p><?=$subheading?></p>
	</div>
	
	<div class="col-sm-6" style="padding-top: 20px;">
    <ul class="nav navbar navbar-right nav-pills">
	    <li <? if(is_active('exhibit/listing/all')): ?>class="active"<? endif; ?>><a href="<?= site_url('exhibit/listing/all') ?>">All</a></li>
      <li <? if(is_active('exhibit/listing/paid')): ?>class="active"<? endif; ?>><a href="<?= site_url('exhibit/listing/paid') ?>">Paid</a></li>
      <li <? if(is_active('exhibit/listing/unpaid')): ?>class="active"<? endif; ?>><a href="<?= site_url('exhibit/listing/unpaid') ?>">Unpaid</a></li>
    </ul>
	</div>
	
	<table class="table table-striped">
		<thead>
			<th>Exhibit ID</th>
			<th>Main Exhibitor</th>
			<th>Company</th>
			<th>Table Location</th>
			<th>Paid</th>
			<th></th>
		</thead>
		<tbody>
		<?php foreach ($exhibits as $exhibit):?>
			<tr>
        <td><?=$exhibit->exhibit_id?></td>
        <td><?=$exhibit->first_name." ".$exhibit->last_name?></td>
        <td><?=$exhibit->company?></td>
				<td><?=$exhibit->table_loc?></td>
				<td><? if($exhibit->paid == 'no'): ?><span class="label label-danger">Not Paid</span><? elseif($exhibit->paid == 'yes'): ?><span class="label label-success">Paid</span><? endif; ?></td>
				<td><a href="<?=site_url('exhibit/edit/'.$exhibit->exhibit_id)?>"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>
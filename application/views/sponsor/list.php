<div class="container" style="margin-top: 50px;">
	<?=$this->breadcrumbs->show()?>
	<div id="infoMessage"><?php echo $message;?></div>
	<div class="col-sm-6">
		<h2><?=$heading?></h2>
		<p><?=$subheading?></p>
	</div>
	
	<div class="col-sm-6" style="padding-top: 20px;">
    <ul class="nav navbar navbar-right nav-pills">
	    <li <? if(is_active('sponsor/listing/all')): ?>class="active"<? endif; ?>><a href="<?= site_url('sponsor/listing/all') ?>">All</a></li>
      <li <? if(is_active('sponsor/listing/paid')): ?>class="active"<? endif; ?>><a href="<?= site_url('sponsor/listing/paid') ?>">Paid</a></li>
      <li <? if(is_active('sponsor/listing/unpaid')): ?>class="active"<? endif; ?>><a href="<?= site_url('sponsor/listing/unpaid') ?>">Unpaid</a></li>
    </ul>
	</div>
	
	<table class="table">
		<tr>
			<th>Sponsor ID</th>
			<th>Contact Email</th>
			<th>Company Name</th>
			<th>Company Address</th>
			<th>URL</th>
			<th>Logo</th>
			<th>Paid Status</th>
			<th></th>
		</tr>
		<?php foreach ($sponsors as $sponsor):?>
			<tr>
        <td><?=$sponsor->sponsor_id?></td>
        <td><?=$sponsor->main_contact?></td>
        <td><?=$sponsor->company_name?></td>
				<td><?=$sponsor->company_address?></td>
				<td><?=$sponsor->url?></td>
				<td><img src="<?=base_url($sponsor->logo)?>" alt="<?=$sponsor->company_name?>" height="40px">
				<td><? if ($sponsor->paid == 'no') echo "<span class='label label-danger'>No</span>"; else echo "<span class='label label-success'>Yes</span>";?></td>
				<td><a href="<?=site_url('sponsor/edit/'.$sponsor->sponsor_id)?>"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>
			</tr>
		<?php endforeach;?>
	</table>
</div>
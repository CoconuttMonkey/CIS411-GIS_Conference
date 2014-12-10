<div class="container" style="margin-top: 100px;">
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
	
	<table id="sort" class="tablesorter tablesorter-bootstrap" style="width:100%">
		<thead>
			<tr>
				<th>Sponsor ID</th>
				<th>Main Contact</th>
				<th>Company Name</th>
				<th>Company Address</th>
				<th>URL</th>
				<th class="filter-false">Logo</th>
				<th>Paid Status</th>
			</tr>
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
					<button type="button" class="reset btn btn-fresh" style="float: right; font-weight: normal; font-family: 'Open Sans';" data-column="0" data-filter=""><i class="glyphicon glyphicon-refresh"></i> Reset filters</button>
				</th>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($sponsors as $sponsor):?>
			<tr>
        <td><?=$sponsor->sponsor_id?></td>
        <td><?=$sponsor->first_name." ".$sponsor->last_name?></td>
        <td><?=$sponsor->company_name?></td>
				<td><?=$sponsor->company_address?></td>
				<td><?=$sponsor->url?></td>
				<td><img src="<?=base_url($sponsor->logo)?>" alt="<?=$sponsor->company_name?>" height="40px">
				<td><? if ($sponsor->paid == 'no') echo "<span class='label label-danger'>No</span>"; else echo "<span class='label label-success'>Yes</span>";?></td>
				<td><a href="<?=site_url('sponsor/edit/'.$sponsor->sponsor_id)?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>
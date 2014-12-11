<div class="container" style="margin-top: 100px;">
	<?=$this->breadcrumbs->show()?>
	<div id="infoMessage"><?php echo $message;?></div>
	<div class="col-sm-6">
		<h2><?=$heading?></h2>
		<p><?=$subheading?></p>
	</div>
	
	<div class="col-sm-6" style="padding-top: 20px;">
	  <? if ( $this->ion_auth->in_group('admin')) : ?>
    <ul class="nav navbar navbar-right nav-pills">
	    <li <? if(is_active('exhibit/listing/all')): ?>class="active"<? endif; ?>><a href="<?= site_url('exhibit/listing/all') ?>">All</a></li>
      <li <? if(is_active('exhibit/listing/paid')): ?>class="active"<? endif; ?>><a href="<?= site_url('exhibit/listing/paid') ?>">Paid</a></li>
      <li <? if(is_active('exhibit/listing/unpaid')): ?>class="active"<? endif; ?>><a href="<?= site_url('exhibit/listing/unpaid') ?>">Unpaid</a></li>
    </ul>
    <? endif; ?>
	</div>
	
	<table id="sort" class="tablesorter tablesorter-bootstrap" style="width:100%">
		<thead>
			<th>Exhibit ID</th>
			<th>Main Exhibitor</th>
			<th>Company</th>
			<th>Table Location</th>
	    <? if ( $this->ion_auth->in_group('admin')) : ?>
			<th>Paid</th>
			<? endif; ?>
		</thead>
		<tfoot>
			<tr>
				<th colspan="<? if ( $this->ion_auth->in_group('admin')) {echo"5";}else{echo"4";} ?>" id="pager" class="form-inline">
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
		<?php foreach ($exhibits as $exhibit):?>
			<tr>
        <td><?=$exhibit->exhibit_id?></td>
        <td><?=$exhibit->first_name." ".$exhibit->last_name?></td>
        <td><?=$exhibit->company?></td>
				<td><?=$exhibit->table_loc?></td>
	    <? if ( $this->ion_auth->in_group('admin')) : ?>
				<td><? if($exhibit->paid == 'no'): ?><span class="label label-danger">Not Paid</span><? elseif($exhibit->paid == 'yes'): ?><span class="label label-success">Paid</span><? endif; ?></td>
				<td><a href="<?=site_url('exhibit/edit/'.$exhibit->exhibit_id)?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
				<? endif; ?>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>
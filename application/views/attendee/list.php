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
	    <li <? if(is_active('attendee/listing/all')): ?>class="active"<? endif; ?>><a href="<?= site_url('attendee/listing/all') ?>">All</a></li>
      <li <? if(is_active('attendee/listing/paid')): ?>class="active"<? endif; ?>><a href="<?= site_url('attendee/listing/paid') ?>">Paid</a></li>
      <li <? if(is_active('attendee/listing/unpaid')): ?>class="active"<? endif; ?>><a href="<?= site_url('attendee/listing/unpaid') ?>">Unpaid</a></li>
    </ul>
    <? endif; ?>
	</div>
	
	
	<table id="sort" class="tablesorter tablesorter-bootstrap" style="width:auto">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Location</th>
				<th>Admission Type</th>
				<th>Company</th>
				<th>Paid</th>
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
		<?php foreach ($attendees as $attendee):?>
			<tr>
        <td><?=$attendee->user_id?></td>
        <td><?=$attendee->first_name." ".$attendee->last_name?></td>
        <td><?=$attendee->email?></td>
        <td><?=$attendee->city.", ".$attendee->state?></td>
				<td><?=$attendee->name?></td>
				<td><?=$attendee->company?></td>
				<td><? if ($attendee->paid == 'no') echo "<span class='label label-danger'>No</span>"; else echo "<span class='label label-success'>Yes</span>";?></td>						
				<td><a href="<?=site_url('attendee/edit/'.$attendee->user_id)?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>
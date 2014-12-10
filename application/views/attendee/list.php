<div class="container" style="margin-top: 100px;">
	<?=$this->breadcrumbs->show()?>
	<h2><?=$heading?><button type="button" class="reset btn btn-fresh" style="float: right; font-weight: normal; font-family: 'Open Sans';" data-column="0" data-filter=""><i class="glyphicon glyphicon-refresh"></i> Reset filters</button></h2>
	<p><?=$subheading?></p>
	
	<div id="infoMessage"><?php echo $message;?></div>
	<table id="sort" class="tablesorter tablesorter-bootstrap" style="width:auto">
		<thead>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Location</th>
				<th>Admission Type</th>
				<th>Company</th>
				<th>Active Status</th>
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
				<td><? if ($attendee->active == 'no') echo "<span class='label label-danger'>No</span>"; else echo "<span class='label label-success'>Yes</span>";?></td>						
				<td><a href="<?=site_url('attendee/edit/'.$attendee->user_id)?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>
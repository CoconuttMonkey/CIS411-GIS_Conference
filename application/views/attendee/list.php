<div class="container" style="margin-top: 50px;">
	<?=$this->breadcrumbs->show()?>
	<h2><?=$heading?></h2>
	<p><?=$subheading?></p>
	
	<div id="infoMessage"><?php echo $message;?></div>
	
	<table class="table">
		<tr>
			<th>User ID</th>
			<th>Name</th>
			<th>Email</th>
			<th>Location</th>
			<th>Admission Type</th>
			<th>Company</th>
			<th>Paid Status</th>
			<th></th>
		</tr>
		
		<?php foreach ($attendees as $attendee):?>
			<tr>
        <td><?=$attendee->user_id?></td>
        <td><?=$attendee->first_name." ".$attendee->last_name?></td>
        <td><?=$attendee->email?></td>
        <td><?=$attendee->city.", ".$attendee->state?></td>
				<td><?=$attendee->admission_type?></td>
				<td><?=$attendee->company?></td>
				<td><?=$attendee->active?></td>
				<td><a href="<?=site_url('attendee/edit/'.$attendee->user_id)?>"><span class="glyphicon glyphicon-pencil"></span> Edit</a></td>
			</tr>
		<?php endforeach;?>
	</table>
</div>
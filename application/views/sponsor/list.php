<div class="container" style="margin-top: 50px;">
	<h2><?=$heading?></h2>
	<p><?=$subheading?></p>
	
	<div id="infoMessage"><?php echo $message;?></div>
	
	<table class="table">
		<tr>
			<th>Sponsor ID</th>
			<th>Contact Email</th>
			<th>Company Name</th>
			<th>Company Address</th>
			<th>URL</th>
			<th>Logo</th>
			<th>Paid Status</th>
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
			</tr>
		<?php endforeach;?>
	</table>
	
	<p><?php echo anchor('auth/create_user', lang('index_create_user_link'))?> | <?php echo anchor('auth/create_group', lang('index_create_group_link'))?></p>
</div>
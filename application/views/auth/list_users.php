<div class="container" style="margin-top: 100px;">
	
	<?=$this->breadcrumbs->show()?>
	<h2><?php echo lang('index_heading');?></h2>
	<p><?php echo lang('index_subheading');?></p>
	
	<div id="infoMessage"><?php echo $message;?></div>
	
	<button type="button" class="reset btn btn-fresh" style="float: right; font-weight: normal; font-family: 'Open Sans';" data-column="0" data-filter=""><i class="glyphicon glyphicon-refresh"></i> Reset filters</button>
	<table id="sort" class="tablesorter tablesorter-bootstrap" style="width:100%">
		<thead>
			<tr>
				<th><?php echo lang('index_fname_th');?></th>
				<th><?php echo lang('index_lname_th');?></th>
				<th><?php echo lang('index_email_th');?></th>
				<th><?php echo lang('index_groups_th');?></th>
				<th><?php echo lang('index_status_th');?></th>
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
		<?php foreach ($users as $user):?>
			<tr>
        <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?></td>
        <td><?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?></td>
        <td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
				<td>
					<?php foreach ($user->groups as $group):?>
						<?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?>&nbsp;
	        <?php endforeach?>
				</td>
				<td><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'));?></td>
				<td><?php echo anchor("auth/edit_user/".$user->id, '<span class="glyphicon glyphicon-pencil"></span>') ;?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
</div>
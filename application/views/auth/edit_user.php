<div class="container" style="margin-top: 50px;">
	<section class="row">
		<div class="col-md-4 col-md-push-4">
			<h2><?php echo lang('edit_user_heading');?></h2>
			<p><?php echo lang('edit_user_subheading');?></p>
			
			<div id="infoMessage"><?php echo $message;?></div>
			
			<?php echo form_open(uri_string());?>
			
			      <div class="form-group">
			            <?php echo lang('edit_user_fname_label', 'first_name');?> <br />
			            <?php echo form_input($first_name);?>
			      </div>
			
			      <div class="form-group">
			            <?php echo lang('edit_user_lname_label', 'last_name');?> <br />
			            <?php echo form_input($last_name);?>
			      </div>
			
			      <div class="form-group">
			            <?php echo lang('edit_user_company_label', 'company');?> <br />
			            <?php echo form_input($company);?>
			      </div>
			
			      <div class="form-group">
			            <?php echo lang('edit_user_phone_label', 'phone');?> <br />
			            <?php echo form_input($phone);?>
			      </div>
			
			      <div class="form-group">
			            <?php echo lang('edit_user_password_label', 'password');?> <br />
			            <?php echo form_input($password);?>
			      </div>
			
			      <div class="form-group">
			            <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?><br />
			            <?php echo form_input($password_confirm);?>
			      </div>
			
			      <?php if ($this->ion_auth->is_admin()): ?>
			
			          <h3><?php echo lang('edit_user_groups_heading');?></h3>
			          <?php foreach ($groups as $group):?>
			              <label class="checkbox">
			              <?php
			                  $gID=$group['id'];
			                  $checked = null;
			                  $item = null;
			                  foreach($currentGroups as $grp) {
			                      if ($gID == $grp->id) {
			                          $checked= ' checked="checked"';
			                      break;
			                      }
			                  }
			              ?>
			              <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
			              <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
			              </label>
			          <?php endforeach?>
			
			      <?php endif ?>
			
			      <?php echo form_hidden('id', $user->id);?>
			      <?php echo form_hidden($csrf); ?>
			
						<div class="form-group">
							<div class="col-xs-6">
								<a id="delete" href="<?= site_url('auth/delete_user/'.$user->id) ?>" class="btn btn-block btn-hot">Delete User</a>
							</div>
							<div class="col-xs-6">
								<button type="submit" class="btn btn-block btn-fresh">Save Changes</button>
							</div>
						</div>
			
			<?php echo form_close();?>
		</div>
	</section>
</div>

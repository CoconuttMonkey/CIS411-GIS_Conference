<div class="container" style="margin-top: 50px;">
	<?=$this->breadcrumbs->show()?>
	<section class="row">
		<div class="col-md-6">
			<h2>Edit Sponsor</h2>
			<div id="infoMessage"><?php echo $message;?></div>
		</div>
	</section>
	<section class="row">
		<?php echo form_open_multipart("sponsor/edit/$id");?>
			<div class="col-md-6">
	      
	      <div class="form-group">
          <?php echo lang('create_main_contact_label', 'main_contact');?> <br />
          <?php echo form_input($main_contact);?>
	      </div>
	
	      <div class="form-group">
          <?php echo lang('create_company_name_label', 'company_name');?> <br />
          <?php echo form_input($company_name);?>
	      </div>
	
	      <div class="form-group">
          <?php echo lang('create_company_address_label', 'company_addresss');?> <br />
          <?php echo form_textarea($company_address);?>
	      </div>
	
	      <div class="form-group">
          <?php echo lang('create_url_label', 'url');?> <br />
          <?php echo form_input($url);?>
	      </div>
	      
	      <? if ($this->ion_auth->is_admin()): ?>
	      <div class="form-group">
		      <label>Admin Options</label><br>
		      <input id="paid" name='paid' type="checkbox" value='yes' <? if($paid['value'] == 'yes') echo "checked"; ?> data-on-color="success" data-on-text="Paid" data-off-color="danger" data-off-text="Unpaid" >
	      </div>
	      <? endif; ?>
	      
			</div>
			<div class="col-md-6">
				<div class="row">
          <div class="form-group"><label class="control-label">Choose a sponsor level</label>
            
            <div class="radio">
						  <label>
						  	<input type="radio" name="sponsor_level" value="1" <? if ($sponsor_level['value'] == 1) echo "checked='checked'"; ?>>Level 1 $300
							  <p>
								  <ul>
									  <li>Exhibit table for both of the conference days (Full Day 1 & Half Day 2)</li>
									  <li>Receive 2 complimentary conference registrations</li>
									  <li>Listed as Sponsor on the conference's printed agenda</li>
									  <li>Verbal recognition of sponsorship at the conference's introductions</li>
									  <li>Receive a list of conference attendees</li>
								  </ul>
							  </p>
						  </label>
						</div>
						
            <div class="radio">
						  <label>
						  	<input type="radio" name="sponsor_level" value="2" <? if ($sponsor_level['value'] == 2) echo "checked='checked'"; ?>>Level 2 $500
							  <p>
								  <ul>
									  <li>All Level 1 Benefits Plus:</li>
									  <li>Opportunity to have a 5-min company introduction/brief promotional presentation at the conference's morning or mid-day keynote address (in coordination with keynote and other sponsors)</li>
									  <li>Listed on the conference's website and include a link on all conference's email communications</li>
									  <li>Sponsor designation on attendee(s) name badge</li>
								  </ul>
							  </p>
						  </label>
						</div>
						
						<div class="radio">
						  <label>
						  	<input type="radio" name="sponsor_level" value="3" <? if ($sponsor_level['value'] == 3) echo "checked='checked'"; ?>>Level 3 $750
							  <p>
								  <ul>
									  <li>All Level 1 & Level 2 Benefits Plus:</li>
									  <li>Opportunity to have a 10-min company introduction/brief promotional presentation at the conference's morning or mid-day keynote address (in coordination with keynote and other sponsors)</li>
									  <li>A full page Ad in the Conference's printed agenda</li>
									  <li>Inclusion of company's flyer/handout in the attendees registration packet</li>
								  </ul>
							  </p>
						  </label>
						</div>
		    	</div>
				</div>
	      
				<div class='col-md-4 col-md-push-4'><input type="submit" class="btn btn-lg btn-fresh" value="Update"></div>
			</div>
			<?php echo form_close();?>
	</section>
</div>
<script>

</script>

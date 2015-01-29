<div class="container" style="margin-top: 100px;">
	<section class="row">
		<div class="col-md-6">
			<h1>Become a Sponsor</h1>
			<div id="infoMessage"><?php echo $message;?></div>
		</div>
	</section>
	<section class="row">
		<?php echo form_open_multipart("sponsor/create_sponsor");?>
			<div class="col-md-6">
	
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
			</div>
				
			<div class="col-md-6">
				<div class="row">
          <div class="form-group"><label class="control-label">Choose a sponsor level</label>
            
            <div class="radio">
						  <label>
						  	<input type="radio" name="sponsor_level" value="1">Level 1 $300
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
						  	<input type="radio" name="sponsor_level" value="2">Level 2 $500
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
						  	<input type="radio" name="sponsor_level" value="3">Level 3 $750
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
	      
				<div class='col-md-4 col-md-push-4'><?php echo form_submit('submit', lang('create_sponsor_submit_btn'));?></div>
			</div>
			
			
			<?php echo form_close();?>
	</section>
</div>

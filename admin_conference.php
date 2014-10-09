<?php
/*
UserCake Version: 2.0.2
http://usercake.com
*/

require_once("models/config.php");
if (!securePage($_SERVER['PHP_SELF'])){die();}
require_once("models/header.php");
?>
<body>
	<?php include("nav.php"); ?>
	<section class="container">
		<div class="row">
			<article class="col-80">
				<h1>Conference Settings</h1>
				<form name='login' action='login.php' method='post' enctype="multipart/form-data" class="forms width-50">
					<label>Conference ID
						<input type='text' name='conf_id' class="width-20" disabled="disabled" />
					</label>
					
					<label>Title
						<input type='text' name='conf_title' class="width-100" required />
					</label>
					
					<label>TagLine
						<input type='text' name='conf_tagline' class="width-100" required />
					</label>
					
					<div class="width-50 left">
						<label>Conference Start 
							<input id="conf_startDate" name="conf_startDate" type="text" value="" required />
						</label>
						
						<label>Registration Period Start 
							<input id="conf_reg_startDate" name="conf_reg_startDate" type="text" value="" required />
						</label>
					</div>
					
					<div class="width-50 left">
						<label>Conference End 
							<input id="conf_endDate" name="conf_endDate" type="text" value="" required />
						</label>
						
						<label>Registration Period End 
							<input id="conf_reg_endDate" name="conf_reg_endDate" type="text" value="" required />
						</label>
					</div>
					
					<label>Home Page Text
						<input type='text' name='conf_id' class="width-100" required />
					</label>
					
					<label>Banner Image
						<input type="file" name="conf_banner_image" id="conf_banner_image">
					</label>
					
					<label>Schedule PDF
						<input type="file" name="conf_schedule_pdf" id="conf_schedule_pdf">
					</label>
					
					<label>Contact Phone Number
						<ul class="forms-inline-list">
				        <li>
				            ( <input type="text" name="phone-prefix" size="3" /> )
				        </li>
				        <li>
				            <input type="text" name="phone-number-1" size="3" />
				        </li>
				            - <input type="text" name="phone-number-2" size="3" />
				        </li>
				        <li>
				            ext: <input type="text" name="phone-ext" size="3" />
				        </li>
				        <div class="forms-desc">Needed if there are questions about your order</div>
				    </ul>
					</label>
					
					<label>Contact Email
						<input type='email' name='conf_email' class="width-100" required />
					</label>
					
					<label>Contact Address
						<input type='text' name='conf_address1' class="width-100" placeholder="Address Line 1" style="border-bottom: 0;" required />
						<input type='text' name='conf_address2' class="width-100" placeholder="Address Line 2" style="border-bottom: 0;" required />
						<input type='text' name='conf_city' class="width-100" placeholder="City" style="border-bottom: 0;" required />
						<input type='text' name='conf_state' class="width-100" placeholder="State" style="border-bottom: 0;" required />
						<input type='text' name='conf_zip' class="width-100" placeholder="Zip Code" required />
					</label>
					
					<input type='submit' value='Create' class="btn width-50" />
				</form>
			</article>
			<aside class="col-20">
				<? 
				if(isUserLoggedIn()) {
					include('includes/sideNav.php');
				} else {
					include('includes/loginForm.php');
				}
				?>
			</aside>
		</div>
	</section>
	<?php include("models/footer.php"); ?>
	<link rel="stylesheet" type="text/css" href="models/site-templates/js/jquery.datetimepicker.css"/ >
	<script src="models/site-templates/js//jquery.datetimepicker.js"></script>
	<script>
		jQuery(function(){
		 jQuery('#conf_startDate').datetimepicker({
		  format:'m/d/Y',
		  onShow:function( ct ){
		   this.setOptions({
		    maxDate:jQuery('#conf_endDate').val()?jQuery('#conf_endDate').val():false
		   })
		  },
		  timepicker:false
		 });
		 jQuery('#conf_endDate').datetimepicker({
		  format:'m/d/Y',
		  onShow:function( ct ){
		   this.setOptions({
		    minDate:jQuery('#conf_reg_startDate').val()?jQuery('#conf_startDate').val():false
		   })
		  },
		  timepicker:false
		 });
		 jQuery('#conf_reg_startDate').datetimepicker({
		  format:'m/d/Y',
		  onShow:function( ct ){
		   this.setOptions({
		    maxDate:jQuery('#conf_reg_endDate').val()?jQuery('#conf_reg_endDate').val():false
		   })
		  },
		  timepicker:false
		 });
		 jQuery('#conf_reg_endDate').datetimepicker({
		  format:'m/d/Y',
		  onShow:function( ct ){
		   this.setOptions({
		    minDate:jQuery('#conf_reg_startDate').val()?jQuery('#conf_reg_startDate').val():false
		   })
		  },
		  timepicker:false
		 });
		});
	</script>
</body>
</html>
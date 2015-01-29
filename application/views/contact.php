<div class="container" style="margin-top: 100px;">
  <? if (isset($sent) && $sent == true): ?>
	<div class="alert alert-success" role="alert">
	  <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
	  <span class="sr-only">Success:</span>
	  Thank you for your message!
	</div>
	<? endif; ?>
  <? if (isset($sent)&& $sent == false): ?>
	<div class="alert alert-success" role="alert">
	  <span class="glyphicon glyphicon-exclemation" aria-hidden="true"></span>
	  <span class="sr-only">Fail:</span>
	  Thank you for your message!
	</div>
	<? endif; ?>
	<div class="col-md-6">
  	<h2>Map</h2>
		<iframe src="https://mapsengine.google.com/map/embed?mid=zEErqgFTcQx8.kORF4RYRO3sw" width="100%" height="500px" style="border: solid 4px #fff;"></iframe>
	</div>
  <form id="contactform" method="post" action="<?= site_url("contact/send") ?>" class="col-md-6 forms">
	  <input type="text" name="sendmail" value="1" hidden>
  	<h2>Contact</h2>
		<div class="form-group">
			<label>Name</label>
		  <input type="text" class="form-control" name="name" placeholder="Name" required/>
		</div>
		
		<div class="form-group">
			<label>Email</label>
		  <input type="email" class="form-control" name="email" placeholder="Email Address" required/>
		</div>
		
		<div class="form-group">
			<label>Subject</label>
		  <select name="subject" class="form-control">
			  <option value="general">General Conference Inquery</option>
			  <option value="billing">Payment/Billing Inquery</option>
			  <option value="event">Event Questions</option>
		  </select>
		</div>
		
		<div class="form-group">
			<label>Message</label>
		  <textarea class="form-control" rows="8" name="message" placeholder="Write you message here!" required></textarea>
		</div>
		
		<button type="submit" class="btn btn-success">Send</button>
	</form>
</div>

<div class="container" style="margin-top: 50px;">
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
  <form id="contactform" method="post" action="<?= site_url("contact/send") ?>" class="col-md-6 col-md-push-6 forms">
	  <input type="text" name="sendmail" value="1" hidden>
  	<h2>Contact</h2>
		<div class="form-group">
		  <input type="text" class="form-control" name="name" placeholder="Name" required/>
		</div>
		
		<div class="form-group">
		  <input type="text" class="form-control" name="email" placeholder="Email Address" required/>
		</div>
		
		<div class="form-group">
		  <textarea class="form-control" rows="8" name="message" placeholder="Write you message here!" required></textarea>
		</div>
		
		<button type="submit" class="btn btn-success">Send</button>
	</form>
</div>

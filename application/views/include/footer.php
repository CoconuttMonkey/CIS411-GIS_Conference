	<footer class="container">
		<div class="col-sm-4">
			&copy; 2014 Clarion University of PA
		</div>
		<div id="sponsors" class="col-sm-8 text-right">
			<?php 
				// Load PAID Sponsors & display logo with link
				$query = $this->db->get_where('sponsor', array('paid' => 'yes'));
				foreach ($query->result() as $sponsor): ?>
			<a href="<?=prep_url($sponsor->url)?>" target="_blank"><img src="<?=base_url($sponsor->logo)?>" alt="<?=$sponsor->company_name?>" height="80px"></a>
			<? endforeach; ?>
		</div>
	</footer>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/1.3.1/lodash.min.js"></script>
	<script src="//fsasso.com/labs/blur/js/StackBlur.js" type="text/javascript"></script>
	<script src="//fsasso.com/labs/blur/js/html2canvas.js" type="text/javascript"></script>
	<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
	<script src="<?php echo base_url('assets/js/custom.js') ?>"></script>
	<style>
			
	</style>
	<script>
		
	</script>
</body>
</html>

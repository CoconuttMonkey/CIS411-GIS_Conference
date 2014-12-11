<header class="navbar navbar-fixed-top navbar-inverse" role="navigation">
	<div class="container">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        
		    <span class="navbar-brand" rel="home" title="NW PA GIS Conference">
		        <img style="max-width:100px; margin-top: -17px; position: absolute"
		             src="<?= site_url('assets/img/gis_logo.png') ?>">
		    </span>
        
		    <a class="navbar-brand" rel="home" href="<?= site_url() ?>" style="margin-left: 70px;" title="NW PA GIS Conference">
		        NW PA GIS Conference
		    </a>
        
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
		      <li <? if(is_active()): ?>class="active"<? endif; ?>><a href="<?= site_url() ?>">Home</a></li>
		      <li <? if(is_active('about')): ?>class="active"<? endif; ?>><a href="<?= site_url('about') ?>">About</a></li>
		      <li <? if(is_active('contact')): ?>class="active"<? endif; ?>><a href="<?= site_url('contact') ?>">Contact</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
				<?
        if ($this->ion_auth->logged_in()) {
	        // Get users info
	        $user = $this->ion_auth->user()->row();
					// Display account links
				?>
					<li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?=$user->email?> <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li <? if(is_active('auth/dashboard')): ?>class="active"<? endif; ?>><a href="<?= site_url('auth/dashboard') ?>">Dashboard</a></li>
              <li <? if(is_active('auth/edit_user')): ?>class="active"<? endif; ?>><a href="<?= site_url('auth/edit_user/'.$user->id) ?>">Account Settings</a></li>
              <li class="divider"></li>
              <li><a href="<?= site_url('auth/logout') ?>">Logout</a></li>
            </ul>
          </li>
				<? } 
					if ($this->ion_auth->is_admin()) {
					// Display admin links
				?>
					<li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Admin <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li <? if(is_active('auth/dashboard')): ?>class="active"<? endif; ?>><a href="<?= site_url('auth/dashboard') ?>">Dashboard</a></li>
              <? if ($this->ion_auth->in_group('admin') && !$this->ion_auth->in_group('secretary')) : ?>
              <li <? if(is_active('auth/settings')): ?>class="active"<? endif; ?>><a href="<?= site_url('auth/settings') ?>">Site Settings</a></li>
              <li <? if(is_active('auth/users')): ?>class="active"<? endif; ?>><a href="<?= site_url('auth/users') ?>">All Users</a></li>
              <? endif; ?>
              <li class="divider"></li>
              <li <? if(is_active('conference/listing')): ?>class="active"<? endif; ?>><a href="<?= site_url('conference/listing/all') ?>">Conferences</a></li>
              <li <? if(is_active('attendee/listing')): ?>class="active"<? endif; ?>><a href="<?= site_url('attendee/listing') ?>">Attendees</a></li>
              <li <? if(is_active('presentation/listing')): ?>class="active"<? endif; ?>><a href="<?= site_url('presentation/listing/all') ?>">Presentations</a></li>
              <li <? if(is_active('exhibit/listing')): ?>class="active"<? endif; ?>><a href="<?= site_url('exhibit/listing/all') ?>">Exhibits</a></li>
              <li <? if(is_active('sponsor/listing')): ?>class="active"<? endif; ?>><a href="<?= site_url('sponsor/listing/all') ?>">Sponsors</a></li>
            </ul>
          </li>
				<? }
				if (!$this->ion_auth->logged_in()) { ?>
					<li <? if(is_active('auth/login')): ?>class="active"<? endif; ?>><a href="<?= site_url('auth/login') ?>">Login</a></li>
					<li <? if(is_active('auth/create_user')): ?>class="active"<? endif; ?>><a href="<?= site_url('auth/create_user') ?>">Register</a></li>
				<? } ?>
        </ul>
      </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
	</div><!--/.container -->
</header>
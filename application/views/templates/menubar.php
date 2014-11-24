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
        <a class="navbar-brand" href="<?= site_url() ?>">NW PA GIS Conference</a>
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
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li <? if(is_active('auth/dashboard')): ?>class="active"<? endif; ?>><a href="<?= site_url('auth/dashboard') ?>">Dashboard</a></li>
              <li <? if(is_active('auth/edit_user')): ?>class="active"<? endif; ?>><a href="<?= site_url('auth/edit_user/'.$user->id) ?>">Settings</a></li>
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
              <li <? if(is_active('site_settings')): ?>class="active"<? endif; ?>><a href="<?= site_url('site_settings') ?>">Site Settings</a></li>
              <li <? if(is_active('auth/users')): ?>class="active"<? endif; ?>><a href="<?= site_url('auth/users') ?>">All Users</a></li>
              <li class="divider"></li>
              <li <? if(is_active('conference/listing')): ?>class="active"<? endif; ?>><a href="<?= site_url('conference/listing') ?>">Conferences</a></li>
              <li <? if(is_active('auth/attendees')): ?>class="active"<? endif; ?>><a href="<?= site_url('auth/users/attendees') ?>">Attendees</a></li>
              <li <? if(is_active('presentation/list')): ?>class="active"<? endif; ?>><a href="<?= site_url('presentation/listing') ?>">Presentations</a></li>
              <li <? if(is_active('exhibit/list')): ?>class="active"<? endif; ?>><a href="<?= site_url('exhibit/listing') ?>">Exhibits</a></li>
              <li <? if(is_active('sponsor/list')): ?>class="active"<? endif; ?>><a href="<?= site_url('sponsor/listing') ?>">Sponsors</a></li>
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
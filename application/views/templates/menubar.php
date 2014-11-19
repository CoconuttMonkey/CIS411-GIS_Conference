
<header class="navbar navbar-fixed-top navbar-default" role="navigation">
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
		      <li <? if(is_active('register')): ?>class="active"<? endif; ?>><a href="<?= site_url('register/account') ?>">Register</a></li>
		      <li <? if(is_active('login')): ?>class="active"<? endif; ?>><a href="<?= site_url('login') ?>">Login</a></li>
          <!-- <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Account <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              <li><a href="#">Login</a></li>
              <li><a href="#">Register</a></li>
              <li class="divider"></li>
              <li><a href="#">Logout</a></li>
            </ul>
          </li> -->
        </ul>
      </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
	</div>
</header>
<div class="blurheader">
	
</div>


<div class="container" style="margin-top: 50px;">
	<div class="jumbotron">
			<p class="text-right"><?=$today?></p>
			<h1>NW PA GIS Conference<br>Online Registration System</h1>
			<p>This is the installation file for the Registration System created by Matt Ondo, Frank Walls, and Adam Wolbert as our CIS 411 class project.</p>
			<p><strong>If you see this page, your database has been set up correctly. You my continue to create your first conference.</strong></p>
			<p class="text-center"><a href="<?= site_url('conference/setup_new_conference') ?>" class="btn btn-lg btn-fresh">Set up your first conference!</a></p>
	</div>
	<div class="clear"></div>
	<section class="row">
		<div class="col-lg-12"><h2>Website Componants</h2></div>
		<article class="col-sm-4">
			<dl>
				<dt>CodeIgniter 2.2.0</dt>
				<dd>CodeIgniter is an open source PHP MVC framework that allows for extendibility, scalability, and a better overall organization of a website. Each page is split into a Model which connects to the database and retrieves information, a View which displays the information to the user, and a Controller which connects the two together. This allows for better security as we separate the data from the end user view. It also creates a much more elegant web application.</dd>
			</dl>
		</article>
		<article class="col-sm-4">
			<dl>
				<dt>IonAuth 2.0</dt>
				<dd>IonAuth is a lightweight authentication library for CodeIgniter. This is what allows users to create and manage account information as well as administer the website.</dd>
				<br>
				<dt>TableSorter 2</dt>
				<dd>Table Sorter is a jQuery library and used to filter table data. It has ascending/descending and also includes a search tool. </dd>
			</dl>
		</article>
		<article class="col-sm-4">
			<dl>
				<dt>Bootstrap</dt>
				<dd>Bootstrap is used for the front-end framework. The web page structure, style and functionalities are molded by the use of this framework. Pre-defined CSS3 classes and a JavaScript library (based off the jQuery library) are included. Bootstrap also has additional tools that are used such as form validation.</dd>
			</dl>
		</article>
	</section>
</div>

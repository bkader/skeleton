<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="row mb-2">
	<div class="col-xs-6 col-sm-6 col-md-3">
		<div class="card status card-success text-center">
			<div class="card-header"><h1 class="card-title"><?php echo $count_users ?></h1></div>
			<a class="btn btn-link btn-block" href="<?php echo admin_url('users') ?>"><strong><?php _e('CSK_ADMIN_USERS') ?></strong></a>
		</div>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-3">
		<div class="card status card-warning text-center">
			<div class="card-header"><h1 class="card-title"><?php echo $count_themes ?></h1></div>
			<a class="btn btn-link btn-block" href="<?php echo admin_url('themes') ?>"><strong><?php _e('CSK_ADMIN_THEMES') ?></strong></a>
		</div>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-3">
		<div class="card status card-danger text-center">
			<div class="card-header"><h1 class="card-title"><?php echo $count_plugins ?></h1></div>
			<a class="btn btn-link btn-block" href="<?php echo admin_url('plugins') ?>"><strong><?php _e('CSK_ADMIN_PLUGINS') ?></strong></a>
		</div>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-3">
		<div class="card status card-info text-center">
			<div class="card-header"><h1 class="card-title"><?php echo $count_languages ?></h1></div>
			<a class="btn btn-link btn-block" href="<?php echo admin_url('language') ?>"><strong><?php _e('CSK_ADMIN_LANGUAGES') ?></strong></a>
		</div>
	</div>
</div>
<h2>Feel Free to remove content below.</h2>
<div class="well well-sm">
	<p>New contexts have been added. All you have to do is to create the corresponding controllers within your modules. Make sure all the following controllers extend the <code>Admin_Controller</code> class.</p>
	<div class="table-responsive-sm mt-3 mb-3">
		<table class="table table-sm table-striped table-hover">
			<thead><tr><th class="w-15">Controller</th><th>Description</th></tr></thead>
			<tbody>
				<tr>
					<th>Admin.php</th>
					<td>If your module has an admin area, the easiest way is to create this controller. Link to it will be listed under the <code>Components</code> menu dropdown.</td>
				</tr>
				<tr>
					<th>Content.php</th>
					<td>If your module is meant to manage any type of content, it is better to create this controller instead of <code>Admin.php</code>. Link to the module will be listed under the <code>Content</code> menu dropdown.</td>
				</tr>
				<tr>
					<th>Reports.php</th>
					<td>If you want to allow tracking or reporting, simply creaete this controller in your module and make sure to use the <code>Kbcore_activities</code> library to manage your module's reports. Link to the module will be listed under the <code>Reports</code> menu dropdown.</td>
				</tr>
				<tr>
					<th>Settings.php</th>
					<td>if your module has a settings section, simply createt this controller. For this section, it is advised to use the <code>Kbcore_options</code> library. Link to the settings are will be available under the <code>System</code> menu dropdown.</td>
				</tr>
			</tbody>
		</table>
	</div>
	<p>There are other controllers you may create within your modules controllers directory:</p>
	<div class="table-responsive-sm mt-3 mb-3">
		<table class="table table-sm table-striped table-hover">
			<thead><tr><th class="w-15">Controller</th><th>Description</th></tr></thead>
			<tbody>
				<tr>
					<th>Ajax.php</th>
					<td>If your module has AJAX section and methods, it is possible to put them within your main controller but, it is recommended to create this controller so you can use our built-in AJAX feature. This controller <strong>SHOULD</strong> extend the <code>AJAX_Controller</code> class and its methods should return nothing and simply use the provided <code>$response</code> property.</td>
				</tr>
				<tr>
					<th>Process.php</th>
					<td>As we discussed before, process controllers are simply controllers meant to execute actions and redirect users right away, they only accept <code>$_GET</code> requests. This controller should extend the <code>Process_Controller</code> class.</td>
				</tr>
			</tbody>
		</table>
	</div>
	<p>All modules <strong>MUST</strong> contain a <code>manifest.json</code> file in their root folders. This file will be used to list details about the module and make sure to display its links within the dashboard.</p>
	<p>Below is an example of the file (menus module):</p>
	<pre class="mt-2 mb-2"><code>{
	"name":"Menus Manager",
	"module_uri":null,
	"description":"Manage site menus and locations.",
	"version":"1.0.0",
	"license":"MIT",
	"license_uri":"http://opensource.org/licenses/MIT",
	"author":"Kader Bouyakoub",
	"author_uri":"https://goo.gl/wGXHO9",
	"author_email":"bkade@mail.com",
	"tags":null,
	"enabled":true,
	"routes":[],
	"admin_menu":"Menus",
	"admin_order":2,
	"translations":{
		"admin_menu":{
			"french":"Menus"
			}
		}
	}
}</code></pre>
	<p>The <code>admin_menu</code> element if what's displayed on the dashboard menu. If none provided, it will use <code>ucwords('module_name')</code>.</p>
	<p>Right below it, you see the <code>admin_order</code>. That what determines the order of the element. <strong>0</strong> is at the very top... etc.</p>
</div>

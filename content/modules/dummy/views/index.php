<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="card">
	<div class="card-body">
		<p>The content below is loaded on <code>Dummy Module</code> <strong>init.php</strong> file using the <code>admin_index_content</code> action. Delete the module to remove the action to delete it.</p>
		<p>New contexts have been added. All you have to do is to create the corresponding controllers within your modules. Make sure all the following controllers extend the corresponding class or at least extend the <code>Admin_Controller</code> class.</p>
		<div class="table-responsive-sm mt-3 mb-3">
			<table class="table table-sm table-striped table-hover">
				<thead><tr><th class="w-15">Controller</th><th>Description</th></tr></thead>
				<tbody>
					<tr>
						<th>Admin.php</th>
						<td>If your module has an admin area, the easiest way is to create this controller. Link to it will be listed under the <code>Components</code> menu dropdown. This controller should extend <code>Admin_Controller</code> class.</td>
					</tr>
					<tr>
						<th>Content.php</th>
						<td>Extends the <code>Content_Controller</code> class. If your module is meant to manage any type of content, it is better to create this controller instead of <code>Admin.php</code>. Link to the module will be listed under the <code>Content</code> menu dropdown.</td>
					</tr>
					<tr>
						<th>Extensions.php</th>
						<td>Default extensions are modules, plugins, themes and languages. If your module purpose is to add new type of extensions, your can create this controller that should extends <code>Admin_Controller</code>.</td>
					</tr>
					<tr>
						<th>Help.php</th>
						<td>If you provide an internal documentation section for your module, simply create this controller and its views. This should extend the <code>Help_Controller</code> class and its link will be displayed under the <code>Help</code> dropdown menu.</td>
					</tr>
					<tr>
						<th>Reports.php</th>
						<td>If you want to allow tracking or reporting, simply creaete this controller in your module and make sure to extend <code>Reports_Controller</code> class and use the <code>Kbcore_activities</code> library to manage your module's reports. Link to the module will be listed under the <code>Reports</code> menu dropdown.</td>
					</tr>
					<tr>
						<th>Settings.php</th>
						<td>if your module has a settings section, simply createt this controller. For this section, make sure to extends <code>Settings_Controller</code> class and it is advised to use the <code>Kbcore_options</code> library. Link to the settings are will be available under the <code>System</code> menu dropdown.</td>
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
		<p>Below is an example of the file (Media Manager module).</p>
		<p>If you want your module to be enabled as soon as it is installed, simply add <code>"enabled": true</code> to your manifest. Otherwise, it is advised not to add it.</p>
		<p>The <code>admin_menu</code> element if what's displayed on the dashboard menu. If none provided, it will use your module's name.</p>
		<p>Right below it, you see the <code>admin_order</code>. That what determines the order of the element. <strong>0</strong> is at the very top... etc.</p>
	</div>
</div>

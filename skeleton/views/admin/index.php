<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<div class="row mb-2">
	<div class="col-xs-6 col-sm-6 col-md-3">
		<div class="info-box bg-green">
			<div class="inner">
				<h3><?php echo $count_users; ?></h3>
				<p><?php _e('CSK_ADMIN_USERS'); ?></p>
			</div>
			<div class="icon"><i class="fa fa-fw fa-users"></i></div>
			<?php
			echo html_tag('a', array(
				'href' => admin_url('users'),
				'class' => 'info-box-footer',
			), line('CSK_BTN_MANAGE').fa_icon('arrow-circle-right ml-1'));
			?>
		</div>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-3">
		<div class="info-box bg-orange">
			<div class="inner">
				<h3><?php echo $count_themes; ?></h3>
				<p><?php _e('CSK_ADMIN_THEMES'); ?></p>
			</div>
			<div class="icon"><i class="fa fa-fw fa-paint-brush"></i></div>
			<?php
			echo html_tag('a', array(
				'href' => admin_url('themes'),
				'class' => 'info-box-footer',
			), line('CSK_BTN_MANAGE').fa_icon('arrow-circle-right ml-1'));
			?>
		</div>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-3">
		<div class="info-box bg-red">
			<div class="inner">
				<h3><?php echo $count_plugins; ?></h3>
				<p><?php _e('CSK_ADMIN_PLUGINS'); ?></p>
			</div>
			<div class="icon"><i class="fa fa-fw fa-plug"></i></div>
			<?php
			echo html_tag('a', array(
				'href' => admin_url('plugins'),
				'class' => 'info-box-footer',
			), line('CSK_BTN_MANAGE').fa_icon('arrow-circle-right ml-1'));
			?>
		</div>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-3">
		<div class="info-box bg-teal">
			<div class="inner">
				<h3><?php echo $count_languages; ?></h3>
				<p><?php _e('CSK_ADMIN_LANGUAGES'); ?></p>
			</div>
			<div class="icon"><i class="fa fa-fw fa-globe"></i></div>
			<?php
			echo html_tag('a', array(
				'href' => admin_url('languages'),
				'class' => 'info-box-footer',
			), line('CSK_BTN_MANAGE').fa_icon('arrow-circle-right ml-1'));
			?>
		</div>
	</div>
</div>
<h2>Feel Free to remove content below.</h2>
<div class="well well-sm">
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
	<p>Below is an example of the file (Media Manager module):</p>
	<pre class="mt-2 mb-2"><code>{
  "name": "Media Manager",
  "module_uri": "https://goo.gl/G26BTB",
  "description": "The Media Manager is a tool for uploading or deleting media on your CodeIgniter Skeleton application. Tools included are: upload new file(s), updating file(s) details and deleting file(s).",
  "version": "1.0.0",
  "license": "MIT",
  "license_uri": "http://opensource.org/licenses/MIT",
  "author": "Kader Bouyakoub",
  "author_uri": "https://goo.gl/wGXHO9",
  "author_email": "bkade@mail.com",
  "tags": "csk, codeigniter, skeleton, media, library",
  "translations": {
    "french": {
      "name": "Gestionnaire des médias",
      "description": "Le Gestionnaire de médias est un outil pour télécharger ou supprimer des médias sur votre application CodeIgniter Skeleton. Les fonctionnalités incluses sont: télécharger de nouveaux fichiers, mettre à jour les détails des fichiers et supprimer les fichiers.",
      "admin_menu": "Médias"
    },
    "arabic": {
      "name": "إدارة الوسائط",
      "description": "يعد موديل إدارة الوسائط أداة لتحميل أو حذف الوسائط على تطبيق كوديجنتر سكلتون الخاص بك. الأدوات المضمنة هي: تحميل ملف (ملفات) جديد(ة)، تحديث تفاصيل الملف (الملفات) وحذف الملف (الملفات).",
      "admin_menu": "الوسائط"
    }
  }
}

}</code></pre>
	<p>If you want your module to be enabled as soon as it is installed, simply add <code>"enabled": true</code> to your manifest. Otherwise, it is advised not to add it.</p>
	<p>The <code>admin_menu</code> element if what's displayed on the dashboard menu. If none provided, it will use your module's name.</p>
	<p>Right below it, you see the <code>admin_order</code>. That what determines the order of the element. <strong>0</strong> is at the very top... etc.</p>
	<p>If you want </p>
</div>

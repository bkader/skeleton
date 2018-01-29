<h1 class="page-header"><?php _e('dashboard') ?></h1>
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-3">
		<div class="panel status panel-success text-center">
			<div class="panel-heading"><h1 class="panel-title"><?php echo $count_users ?></h1></div>
			<a class="btn btn-link btn-block" href="<?php echo admin_url('users') ?>"><strong><?php _e('users') ?></strong></a>
		</div>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-3">
		<div class="panel status panel-warning text-center">
			<div class="panel-heading"><h1 class="panel-title"><?php echo $count_themes ?></h1></div>
			<a class="btn btn-link btn-block" href="<?php echo admin_url('themes') ?>"><strong><?php _e('themes') ?></strong></a>
		</div>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-3">
		<div class="panel status panel-danger text-center">
			<div class="panel-heading"><h1 class="panel-title"><?php echo $count_plugins ?></h1></div>
			<a class="btn btn-link btn-block" href="<?php echo admin_url('plugins') ?>"><strong><?php _e('plugins') ?></strong></a>
		</div>
	</div>
	<div class="col-xs-6 col-sm-6 col-md-3">
		<div class="panel status panel-info text-center">
			<div class="panel-heading"><h1 class="panel-title"><?php echo $count_languages ?></h1></div>
			<a class="btn btn-link btn-block" href="<?php echo admin_url('languages') ?>"><strong><?php _e('languages') ?></strong></a>
		</div>
	</div>
</div>

<div class="well well-sm">
	<small>
		The sidebar menu is generated automatically by fetching all modules that have <strong>Admin.php</strong> controller. The order is determined by the <code>admin_order</code> setting inside the <code>manifest.json</code> file. Here is an example of a full module's details (menus for instance):
	</small><br />
	<pre><code><?php $details = $this->router->module_details('menus'); $details['folder'] = 'hidden_for_security_reason';
		print_r($details); ?></code></pre>
	<p>The <code>admin_menu</code> element if what's displayed on the sidebar. If none provided, it will use <code>lang('module_name')</code>.</p>
	<p>Right below it, you see the <code>admin_order</code>. That what determines the order of the element. <strong>0</strong> is right below "Dashboard"...etc</p>
</div>

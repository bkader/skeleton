<!-- acp navbar -->
<nav class="navbar navbar-default navbar-fixed-top navbar-admin">
	<div class="container-fluid">
		<div class="navbar-header">
		<button type="button" class="navbar-toggle sidebar-toggle">
			<span class="sr-only">Toggle Sidebar</span>
			<i class="fa fa-toggle-right"></i>
		</button>
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<i class="fa fa-bars"></i>
		</button>
		<a href="<?php echo admin_url() ?>" class="navbar-brand"><?php echo get_option('site_name') ?></a>
		</div><!--/.navbar-header-->

		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
			<?php if (isset($site_languages) && count($site_languages) >= 1): ?>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $current_language['name']; ?> <span class="caret"></span></a>
					<ul class="dropdown-menu">
					<?php foreach($site_languages as $folder => $lang): ?>
						<li><a href="<?php echo site_url('language/change/'.$folder); ?>"><small class="text-muted pull-right"><?php echo $lang['name']; ?></small><?php echo $lang['name_en']; ?></a></li>
					<?php endforeach; unset($folder, $lang); ?>
					</ul>
				</li>
			<?php endif; ?>
				<li><?php echo anchor('', lang('view_site')) ?></li>
				<li class="user-menu dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $c_user->first_name; ?><?php echo user_avatar(24, $c_user->id, 'class="img-circle"'); ?></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo admin_url('users/edit/'.$c_user->id); ?>"><?php _e('edit_profile'); ?></a></li>
						<li class="divider"></li>
						<li><a href="<?php echo site_url('logout'); ?>"><?php _e('logout'); ?></a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div><!--/.container-fluid-->
</nav>
<!-- /acp navbar -->

<main class="wrapper" id="wrapper" role="main">
	<div class="container-fluid">
		<?php the_content(); ?>
		<div class="footer clearfix" id="kbfooter" role="contentinfo">
			<small class="text-muted" id="footer-thankyou"><?php echo apply_filters('admin_footer_text', lang('admin_footer_text')); ?></small>
			<small class="text-muted pull-right" id="footer-upgrade"><?php printf(lang('version_num'), KB_VERSION); ?> &#124; <strong>{elapsed_time}</strong></small>
		</div>
	</div>
</main>

<aside class="sidebar" id="sidebar" role="complementay">
	<ul class="nav nav-sidebar">
		<li<?php echo (get_the_module() == null) ? ' class="active"' : '' ?>><?php echo admin_anchor('', lang('dashboard')) ?></li>
		<?php foreach ($admin_menu as $url => $title): ?>
		<li<?php echo is_module($url) ? ' class="active"' : '' ?>><?php echo admin_anchor($url, $title) ?></li>
		<?php endforeach; ?>
	</ul>
</aside>

<?php the_alert(); ?>

<script type="text/x-handlebars-template" id="tpl-alert">
	<div class="alert alert-{{type}} alert-dismissable text-left" role="alert">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		{{message}}
	</div>
</script>

<script type="text/x-handlebars-template" id="tpl-confirm">
	<div class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-body">
					{{message}}
					<br />
					<div class="mt15">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('no'); ?></button>
						<a href="{{href}}" class="btn btn-primary pull-right"><?php _e('yes'); ?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

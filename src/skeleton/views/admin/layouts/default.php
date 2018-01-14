<!-- acp navbar -->
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
		<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<i class="fa fa-bars"></i>
		</button>
		<a href="<?php echo admin_url() ?>" class="navbar-brand"><span class="logo"></span> <?php echo get_option('site_name') ?></a>
		</div><!--/.navbar-header-->

		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><?php echo anchor('', lang('view_site')) ?></li>
				<li class="user-menu dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $c_user->first_name; ?><?php echo user_avatar(24, $c_user->id, 'class="img-circle"'); ?></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo admin_url('users/edit/'.$c_user->id); ?>"><i class="fa fa-edit"></i><?php _e('edit_profile'); ?></a></li>
						<li class="divider"></li>
						<li><a href="<?php echo site_url('logout'); ?>"><i class="fa fa-sign-out"></i><?php _e('logout'); ?></a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div><!--/.container-fluid-->
</nav>
<!-- /acp navbar -->

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-sm-3 col-md-2 sidebar">
			<ul class="nav nav-sidebar">
				<li<?php echo (get_the_module() == null) ? ' class="active"' : '' ?>><?php echo admin_anchor('', lang('dashboard')) ?></li>
				<li<?php echo is_module('users') ? ' class="active"' : '' ?>><?php echo admin_anchor('users', lang('users')) ?></li>
				<li<?php echo is_module('themes') ? ' class="active"' : '' ?>><?php echo admin_anchor('themes', lang('themes')) ?></li>
				<li<?php echo is_module('menus') ? ' class="active"' : '' ?>><?php echo admin_anchor('menus', lang('menus')) ?></li>
				<li<?php echo is_module('plugins') ? ' class="active"' : '' ?>><?php echo admin_anchor('plugins', lang('plugins')) ?></li>
				<li<?php echo is_module('settings') ? ' class="active"' : '' ?>><?php echo admin_anchor('settings', lang('settings')) ?></li>
			</ul>
		</div>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<?php the_content(); ?>
			<div class="footer">
				<hr>
				<p class="text-center"><?php echo anchor('', get_option('site_name')) ?>. &copy; Copyright <?php echo date('Y') ?>. RT: <strong>{elapsed_time}</strong>. TT: <strong>{theme_time}</strong>.<br ><?php _e('created_by'); ?> <a href="https://github.com/bkader" target="_blank">Kader Bouyakoub</a></p>
			</div>
		</div>
	</div><!--/.row-->
</div><!--/.container-fluid-->
<?php the_alert(); ?>

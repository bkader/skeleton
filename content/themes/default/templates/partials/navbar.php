<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php echo anchor('', get_option('site_name'), 'class="navbar-brand"') ?>
		</div>
		<div class="collapse navbar-collapse navbar-ex1-collapse">
<?php
if (is_callable('build_menu')) {
	echo build_menu(array(
		'location' => 'header-menu',
		'menu_attr' => array(
			'class' => 'nav navbar-nav'
		),
		'container' => false,
	));
}
?>
			<div class="navbar-right">
				<ul class="nav navbar-nav">
				<?php if (isset($site_languages) && count($site_languages) >= 1): ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $current_language['name']; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu">
						<?php foreach($site_languages as $folder => $lang): ?>
							<li><a href="<?php echo site_url('process/set_language/'.$folder); ?>"><small class="text-muted pull-right"><?php echo $lang['name']; ?></small><?php echo $lang['name_en']; ?></a></li>
						<?php endforeach; unset($folder, $lang); ?>
						</ul>
					</li>
				<?php endif; ?>
<?php if ($this->auth->online()): ?>
				<?php if ($this->auth->is_admin()): ?>
					<li><?php echo admin_anchor('', line('CSK_BTN_ADMIN_PANEL')) ?></li>
				<?php endif; ?>
					<li class="user-menu dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $c_user->first_name; ?><?php echo user_avatar(24, $c_user->id, 'class="img-circle"'); ?></a>
						<ul class="dropdown-menu pull-right">
							<li><?php echo anchor($c_user->username, line('CSK_BTN_VIEW_PROFILE')) ?></li>
							<li><?php echo anchor('settings', line('CSK_BTN_SETTINGS')) ?></li>
							<li class="divider"></li>
							<li><?php echo anchor('logout', line('CSK_BTN_LOGOUT')) ?></li>
						</ul>
					</li>
<?php endif; ?>
				</ul>
<?php if ( ! $this->auth->online()): ?>
				<?php echo anchor('login', line('CSK_BTN_LOGIN'), 'class="btn btn-primary navbar-btn"') ?>
			<?php if (get_option('allow_registration', false) === true): ?>
				&nbsp;<?php echo anchor('register', line('CSK_BTN_CREATE_ACCOUNT'), 'class="btn btn-default navbar-btn"') ?>
			<?php endif; ?>
<?php endif; ?>
			</div>
		</div>
	</div>
</nav>

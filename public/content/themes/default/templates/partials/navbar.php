<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?= anchor('', get_option('site_name'), 'class="navbar-brand"') ?>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse navbar-ex1-collapse">
<?php echo build_menu(array(
	'location' => 'header-menu',
	'menu_attr' => array(
		'class' => 'nav navbar-nav'
	),
	'container' => false,
)); ?>

<?php if ($this->auth->online()): ?>

			<ul class="nav navbar-nav navbar-right">
			<?php if ($this->auth->is_admin()): ?>
				<li><?= admin_anchor('', __('admin_panel')) ?></li>
			<?php endif; ?>
				<li class="dropdown">
					<a href="<?= site_url($c_user->username) ?>" class="dropdown-toggle user-menu" data-toggle="dropdown"><?= $c_user->full_name ?></a>
					<ul class="dropdown-menu">
						<li><?= anchor($c_user->username, __('profile')) ?></li>
						<li><?= anchor('settings', __('settings')) ?></li>
						<li class="divider"></li>
						<li><?= anchor('logout', __('logout')) ?></li>
					</ul>
				</li>
			</ul>

<?php else: ?>
			<div class="navbar-right">
				<?= anchor('login', __('login'), 'class="btn btn-primary navbar-btn"') ?>
			<?php if (get_option('allow_registration', false) === true): ?>
				&nbsp;<?= anchor('register', __('create_account'), 'class="btn btn-default navbar-btn"') ?>
			<?php endif; ?>
			</div>
<?php endif; ?>
		</div><!-- /.navbar-collapse -->
	</div>
</nav>

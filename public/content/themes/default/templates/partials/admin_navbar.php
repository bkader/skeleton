<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button class="btn btn-default navbar-btn acp-toggle" type="button"><i class="fa fa-bars"></i></button>
			<?= anchor('', $site_name, 'class="navbar-brand"') ?>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse navbar-ex1-collapse">
<?php if ($this->auth->online()): ?>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="<?= site_url($c_user->username) ?>" class="dropdown-toggle user-menu" data-toggle="dropdown"><?= $c_user->full_name ?></a>
					<ul class="dropdown-menu">
						<li><?= anchor($c_user->username, __('profile')) ?></li>
						<li><?= anchor('settings', __('settings')) ?></li>
						<?php if ($c_user->admin === true): ?>
						<li class="divider"></li>
						<li><?= anchor('admin', __('admin_panel')) ?></li>
						<?php endif; ?>
						<li class="divider"></li>
						<li><?= anchor('pages/manage', __('manage_pages')) ?></li>
						<li><?= anchor('groups/manage', __('manage_groups')) ?></li>
						<li class="divider"></li>
						<li><?= anchor('logout', __('logout')) ?></li>
					</ul>
				</li>
			</ul>

<?php else: ?>
			<div class="navbar-right">
				<?= anchor('login', __('login'), 'class="btn btn-primary navbar-btn"') ?>
			<?php if (get_option('allow_registration', false) === true): ?>
				<?= anchor('register', __('create_account'), 'class="btn btn-default navbar-btn"') ?>
			<?php endif; ?>
			</div>
<?php endif; ?>
		</div><!-- /.navbar-collapse -->
	</div>
</nav>

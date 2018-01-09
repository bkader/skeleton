<h2 class="page-header">
	<?= __('theme_settings') ?>
	<span class="pull-right"><?php echo admin_anchor('themes/add', lang('add_theme'), 'class="btn btn-primary btn-sm"'); ?></span>
</h2>

<div class="row">
<?php foreach ($themes as $theme): ?>
	<div class="col-sm-6 col-md-4" id="theme-<?= $theme['folder'] ?>">
		<div class="thumbnail">
			<img src="<?= $theme['screenshot'] ?>" alt="<?= $theme['name'] ?>" class="img-responsive" data-action="zoom">
			<div class="caption">
				<h3><a href="<?= $theme['theme_uri'] ?>"><?= $theme['name'] ?></a> <?= $theme['enabled'] ? '<small>('.__('active').')</small>' : '' ?></h3>
				<p><?= $theme['description'] ?></p>
				<p><?= __('author') ?>: <strong><a href="<?= $theme['author_uri'] ?>" target="_blank"><?= $theme['author'] ?></a></strong></p>
				<p><?= __('author_email') ?>: <strong><a href="mailto:<?= $theme['author_email'] ?>" target="_blank"><?= $theme['author_email'] ?></a></strong></p>
				<p><?= _('version') ?>: <strong><?= $theme['version'] ?></strong></p>
				<p><?= __('license') ?>: <strong><a href="<?= $theme['license_uri'] ?>" target="_blank"><?= $theme['license'] ?></a></strong></p>
				<p><?= __('tags') ?>: <strong><?= $theme['tags'] ?></strong></p>
			<?php if ($theme['folder'] <> get_option('theme')): ?>
				<?= safe_admin_anchor("themes/activate/{$theme['folder']}", __('enable'), 'class="btn btn-primary btn-block"') ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div><!--/.row-->

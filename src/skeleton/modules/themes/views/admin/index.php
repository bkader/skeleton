<h2 class="page-header">
	<?php _e('theme_settings') ?>
	<span class="pull-right"><?php echo admin_anchor('themes/add', lang('add_theme'), 'class="btn btn-primary btn-sm"'); ?></span>
</h2>

<div class="row">
<?php foreach ($themes as $theme): ?>
	<div class="col-sm-6 col-md-4" id="theme-<?php echo $theme['folder'] ?>">
		<div class="thumbnail">
			<img src="<?php echo $theme['screenshot'] ?>" alt="<?php echo $theme['name'] ?>" class="img-responsive" data-action="zoom">
			<div class="caption">
				<h3><a href="<?php echo $theme['theme_uri'] ?>"><?php echo $theme['name'] ?></a> <?php echo $theme['enabled'] ? '<small>('.lang('active').')</small>' : '' ?></h3>
				<p><?php echo $theme['description'] ?></p>
				<p><?php _e('author') ?>: <strong><a href="<?php echo $theme['author_uri'] ?>" target="_blank"><?php echo $theme['author'] ?></a></strong></p>
				<p><?php _e('author_email') ?>: <strong><a href="mailto:<?php echo $theme['author_email'] ?>" target="_blank"><?php echo $theme['author_email'] ?></a></strong></p>
				<p><?php echo _('version') ?>: <strong><?php echo $theme['version'] ?></strong></p>
				<p><?php _e('license') ?>: <strong><a href="<?php echo $theme['license_uri'] ?>" target="_blank"><?php echo $theme['license'] ?></a></strong></p>
				<p><?php _e('tags') ?>: <strong><?php echo $theme['tags'] ?></strong></p>
			<?php if ($theme['folder'] <> get_option('theme')): ?>
				<?php echo safe_admin_anchor("themes/activate/{$theme['folder']}", lang('enable'), 'class="btn btn-primary btn-block"') ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div><!--/.row-->

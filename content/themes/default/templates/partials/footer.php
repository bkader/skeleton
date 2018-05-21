<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
	<div class="container">
		<p class="navbar-text"><?php echo anchor('', get_option('site_name')) ?>. &copy; Copyright <?php echo date('Y') ?>.<?php if (ENVIRONMENT !== 'production'): ?> <abbr title="Render Time">RT</abbr>: <strong>{elapsed_time}</strong>. <abbr title="Theme Render Time">TT</abbr>: <strong>{theme_time}</strong>.<?php endif; ?></p>

<?php
if (is_callable('build_menu')) {
	echo build_menu(array(
		'location' => 'footer-menu',
		'menu_attr' => array(
			'class' => 'nav navbar-nav navbar-right'
		),
		'container' => false,
	));
}
?>
	</div>
</nav>

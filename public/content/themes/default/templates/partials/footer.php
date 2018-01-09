<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
	<div class="container">
		<p class="navbar-text"><?= anchor('', get_option('site_name')) ?>. &copy; Copyright <?= date('Y') ?>. RT: <strong>{elapsed_time}</strong>. TT: <strong>{theme_time}</strong>.</p>

<?php echo build_menu(array(
	'location' => 'footer-menu',
	'menu_attr' => array(
		'class' => 'nav navbar-nav navbar-right'
	),
	'container' => false,

)); ?>
	</div>
</nav>

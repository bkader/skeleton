<?php
if ( is_callable('has_menu') && has_menu( 'sidebar-menu' )) {
	echo build_menu(array(
		'location' => 'sidebar-menu',
		'menu_attr' => array(
			'class' => 'nav nav-pills nav-stacked nav-sidebar'
		),
		'container' => 'div',
		'container_attr' => array('class' => 'panel')
	));
}
?>
<div class="panel panel-default">
	<div class="panel-heading"><h2 class="panel-title"><?php _e('theme_sidebar_heading', 'default'); ?></h2></div>
	<div class="panel-body">
		<h2>Deafult theme Sidebar</h2>
	</div>
</div>

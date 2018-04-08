<?php
if ( has_menu( 'sidebar-menu' )) {
	echo build_menu(array(
		'location' => 'sidebar-menu',
		'menu_attr' => array(
			'class' => 'nav nav-pills nav-stacked nav-sidebar'
		),
		'container' => 'div',
		'container_attr' => array('class' => 'panel')
	));
}

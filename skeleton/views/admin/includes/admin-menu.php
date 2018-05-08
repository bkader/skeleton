<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// ------------------------------------------------------------------------
// System dropdown item.
// ------------------------------------------------------------------------

echo '<li class="nav-item dropdown">',
	
	// Dropdown toggler.
	html_tag('a', array(
		'href'        => '#',
		'class'       => 'nav-link dropdown-toggle',
		'data-toggle' => 'dropdown',
	), line('system')),

	// Dropdown menu.
	'<div class="dropdown-menu">',
	'</div>';

echo '</li>';

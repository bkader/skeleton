<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dummy plugin to demonstrate plugins system.
 *
 * @package 	CodeIgniter
 * @category 	Plugins
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */

// Action to do after plugin's activation.
add_action('plugin_activate_helloworld', function() {
	return true;
});

// Action to do after plugin's deactivation.
add_action('plugin_deactivate_helloworld', function() {
	return true;
});

// Action to do if the plugin is used.
add_action('plugin_install_helloworld', 'Helloworld::init');

class Helloworld
{
	public static function init()
	{
		add_metadata('author', 'https://github.com/bkader', 'rel');
		// add_filter('extra_head', function($output) {
		// 	$output .= "\n\t<!-- This line was added by Helloworld plugin --->";
		// 	return $output;
		// });
	}
}

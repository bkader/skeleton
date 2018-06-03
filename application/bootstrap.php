<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * In case you want to use Gettext extension instead of CodeIgniter PHP array
 * for languages lines, set this to "true".
 * @since 	2.1.0
 */
defined('USE_GETTEXT') OR define('USE_GETTEXT', false);

/**
 * We make sure to load our Skeleton "bootstrap.php" file.
 * NOTE: Keep this line at the top of this file and right
 * below "USE_GETTEXT" definition.
 * @since 	2.1.0
 */
require_once(KBPATH.'bootstrap.php');

// ------------------------------------------------------------------------
// YOU MAY EDIT LINES BELOW.
// ------------------------------------------------------------------------

// Application classes.
Autoloader::add_classes(array(
	/**
	 * Add classes you want to add/override here.
	 * @example: 'Classname' => APPPATH.'libraries/Classname.php'
	 */
));

/**
 * This action is fired before Skeleton libraries are loaded.
 * @since 	2.1.3
 */
// add_action('init', function() {
// 	// Do your magic.
// });

/**
 * Inspired by WordPress cache mechanism, the Data_Cache was created in 
 * order to cache objects and anything cross-files.
 * @since 	2.1.0
 */
// start_data_cache(array('group1', 'group2'));

// ------------------------------------------------------------------------
// Additional modules, plugins and themes details.
// ------------------------------------------------------------------------

/**
 * In case you want to add more details to modules headers, please
 * use the action below.
 * @since 	2.1.2
 */
// add_action('modules_headers', function($headers) {
// 	return $headers;
// });

/**
 * In case you want to add more details to plugins headers, please
 * use the action below.
 * @since 	2.1.2
 */
// add_action('plugins_headers', function($headers) {
// 	// Added key:
// 	// $headers['new_key'] = 'Key Value';
// 	return $headers;
// });

/**
 * In case you want to add more details to themes headers, please
 * use the action below.
 * @since 	2.1.2
 */
// add_action('themes_headers', function($headers) {
// 	$headers[] = 'added_key';
// 	return $headers;
// });

// ------------------------------------------------------------------------
// DO NOT EDIT BELOW.
// ------------------------------------------------------------------------

/**
 * We now register the autoloader.
 * @since 	2.1.0
 */
Autoloader::register();

/**
 * We now load CodeIgniter bootstrap file, and as they said:
 *
 * And away we go...
 */
require_once(BASEPATH.'core/CodeIgniter.php');

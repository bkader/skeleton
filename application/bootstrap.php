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

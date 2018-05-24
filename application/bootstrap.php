<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * We make sure to load our Skeleton "bootstrap.php" file.
 * NOTE: Keep this line at the top of this file.
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
require_once BASEPATH.'core/CodeIgniter.php';

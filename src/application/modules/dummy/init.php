<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * You can literally put anything is this file.
 * It is loaded even if you don't access the module via HTTP.
 * 
 * Because "init.php" files are loaded inside the main controller
 * constructor, you have access to CI object by using "$this".
 */

/**
 * @example
 * We temporary change the site name.
 */
// $this->config->set_item('site_name', 'Site Name');

// ------------------------------------------------------------------------

/**
 * You can even use a class!
 */
// class Dummy
// {
// 	public static function new_name()
// 	{
// 		return 'New Site Name';
// 	}
// }
// $this->config->set_item('site_name', Dummy::new_name());

<?php
/**
 * CodeIgniter Skeleton
 *
 * A ready-to-use CodeIgniter skeleton  with tons of new features
 * and a whole new concept of hooks (actions and filters) as well
 * as a ready-to-use and application-free theme and plugins system.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package 	CodeIgniter
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @copyright	Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://goo.gl/wGXHO9
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Autoloader Class
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Add-ons
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.1.0
 * @version 	2.1.0
 */
class Autoloader
{
	/**
	 * Holds all the classes and their paths.
	 * @var array
	 */
	protected static $classes = array();

	/**
	 * Method for adding classes load path. Any class added here will not
	 * be searched for but explicitly loaded from the path.
	 *
	 * @static
	 * @access 	public
	 * @param 	string 	$class 	The class name.
	 * @param 	string 	$path 	The path to the class file.
	 * @return 	void
	 */
	public static function add_class($class, $path)
	{
		// Support for namespaces.
		strpos($class, '\\') && $class = str_replace('\\', '/', $class);

		self::$classes[$class] = normalize_path($path);
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for adding multiple class paths to the load path {@see Autoloader::add_class}.
	 *
	 * @static
	 * @param 	array 	$classes 	Array of classes and their paths (class => path)
	 * @return 	void
	 */
	public static function add_classes($classes)
	{
		foreach ($classes as $class => $path)
		{
			self::$classes[$class] = normalize_path($path);
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for returning the path to the previously registered class.
	 *
	 * @since 	2.1.2
	 * @static
	 * @param 	string 	$class 	The class name.
	 * @return 	mixed 	The full path if found, else false.
	 */
	public static function class_path($class)
	{
		return isset(self::$classes[$class]) ? self::$classes[$class] : false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Registers the autoloader to the SPL autoload stack.
	 *
	 * @static
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public static function register()
	{
		spl_autoload_register('Autoloader::load', true, true);
	}

	// ------------------------------------------------------------------------

	/**
	 * Loads a class.
	 *
	 * @static
	 * @access 	public
	 * @param 	string 	$class 	The class to load.
	 * @return 	bool 	true if the class was loaded, else false.
	 */
	public static function load($class)
	{
		if ( ! isset(self::$classes[$class]))
		{
			return false;
		}

		require_once(self::$classes[$class]);
		return true;
	}

}

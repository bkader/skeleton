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
 * @since 		2.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Bootstrap File.
 *
 * This file registers Skeleton classes to they can easily loaded/extended.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Autoloader
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.1.0
 */

/**
 * Load some base functions that we added to CodeIgniter.
 * @since 	2.0.0
 */
require_once(KBPATH.'third_party/print_d/print_d.php');
require_once(KBPATH.'third_party/bkader/compat.php');
require_once(KBPATH.'third_party/bkader/base.php');
require_once(KBPATH.'third_party/bkader/format.php');
require_once(KBPATH.'third_party/bkader/sanitize.php');
require_once(KBPATH.'third_party/bkader/escape.php');
require_once(KBPATH.'third_party/bkader/class-hooks.php');
require_once(KBPATH.'third_party/bkader/class-route.php');

/**
 * Setup Skeleton default constants.
 * @since 	2.0.0
 */
KPlatform::constants();

/**
 * Add default Skeleton classes.
 * @since 	2.1.0
 */
Autoloader::add_classes(array(
	// Kader Class.
	'CS_Hooks' => KBPATH.'third_party/bkader/class-hooks.php',
	'Route'    => KBPATH.'third_party/bkader/class-route.php',
	'Events'   => KBPATH.'third_party/bkader/class-events.php',

	// Core classes.
	'Admin_Controller'    => KBPATH.'core/Admin_Controller.php',
	'Content_Controller'  => KBPATH.'core/Admin_Controller.php',
	'Help_Controller'     => KBPATH.'core/Admin_Controller.php',
	'Reports_Controller'  => KBPATH.'core/Admin_Controller.php',
	'Settings_Controller' => KBPATH.'core/Admin_Controller.php',
	'AJAX_Controller'     => KBPATH.'core/AJAX_Controller.php',
	'KB_Controller'       => KBPATH.'core/KB_Controller.php',
	'KB_Config'           => KBPATH.'core/KB_Config.php',
	'KB_Hooks'            => KBPATH.'core/KB_Hooks.php',
	'KB_Input'            => KBPATH.'core/KB_Input.php',
	'KB_Lang'             => KBPATH.'core/KB_Lang.php',
	'KB_Loader'           => KBPATH.'core/KB_Loader.php',
	'KB_Model'            => KBPATH.'core/KB_Model.php',
	'KB_Security'         => KBPATH.'core/KB_Security.php',
	'KB_Router'           => KBPATH.'core/KB_Router.php',
	'Process_Controller'  => KBPATH.'core/Process_Controller.php',
	'User_Controller'     => KBPATH.'core/User_Controller.php',
	'API_Controller'      => KBPATH.'core/API_Controller.php',

	// Libraries.
	'Format'             => KBPATH.'libraries/Format.php',
	'Hash'               => KBPATH.'libraries/Hash.php',
	'Jquery_validation'  => KBPATH.'libraries/Jquery_validation.php',
	'KB_Email'           => KBPATH.'libraries/KB_Email.php',
	'KB_Form_validation' => KBPATH.'libraries/KB_Form_validation.php',
	'KB_Image_lib'       => KBPATH.'libraries/KB_Image_lib.php',
	'KB_Pagination'      => KBPATH.'libraries/KB_Pagination.php',
	'KB_Table'           => KBPATH.'libraries/KB_Table.php',
	'KB_Upload'          => KBPATH.'libraries/KB_Upload.php',
	'Theme'              => KBPATH.'libraries/Theme.php',

	// Main Skeleton Libraries.
	'Kbcore'            => KBPATH.'libraries/Kbcore/Kbcore.php',
	'CRUD_interface'    => KBPATH.'libraries/Kbcore/CRUD_interface.php',
	'Kbcore_activities' => KBPATH.'libraries/Kbcore/drivers/Kbcore_activities.php',
	'Kbcore_entities'   => KBPATH.'libraries/Kbcore/drivers/Kbcore_entities.php',
	'Kbcore_groups'     => KBPATH.'libraries/Kbcore/drivers/Kbcore_groups.php',
	'Kbcore_metadata'   => KBPATH.'libraries/Kbcore/drivers/Kbcore_metadata.php',
	'Kbcore_objects'    => KBPATH.'libraries/Kbcore/drivers/Kbcore_objects.php',
	'Kbcore_options'    => KBPATH.'libraries/Kbcore/drivers/Kbcore_options.php',
	'Kbcore_plugins'    => KBPATH.'libraries/Kbcore/drivers/Kbcore_plugins.php',
	'Kbcore_relations'  => KBPATH.'libraries/Kbcore/drivers/Kbcore_relations.php',
	'Kbcore_users'      => KBPATH.'libraries/Kbcore/drivers/Kbcore_users.php',
	'Kbcore_variables'  => KBPATH.'libraries/Kbcore/drivers/Kbcore_variables.php',
));

/**
 * KPlatform Class
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.1.6
 */
class KPlatform {
	/**
	 * Method for defining all initial Skeleton constants.
	 *
	 * @since 	2.0.0
	 */
	public static function constants()
	{
		// We define useful Skeleton constants first.
		define('KB_VERSION', '2.1.6');
		define('DS', DIRECTORY_SEPARATOR);
		define('EXT', '.php');

		/**
		 * Constants useful for expressing human-readable data sizes
		 * in their respective number of bytes.
		 * @since 	1.0.0
		 */
		define('KB_IN_BYTES', 1024);
		define('MB_IN_BYTES', 1024 * KB_IN_BYTES);
		define('GB_IN_BYTES', 1024 * MB_IN_BYTES);
		define('TB_IN_BYTES', 1024 * GB_IN_BYTES);

		// Memory limit.
		$memory_limit    = @ini_get('memory_limit');
		$memory_limit_in = self::_convert_to_bytes($memory_limit);

		// Define memory limit.
		if ( ! defined('KB_MEMORY_LIMIT')) {
			if (false === self::_ini_value_changeable('memory_limit')) {
				define('KB_MEMORY_LIMIT', $memory_limit);
			} else {
				define('KB_MEMORY_LIMIT', '40M');
			}
		}

		// Define maximum memory limit.
		if ( ! defined('KB_MAX_MEMORY_LIMIT')) {
			if (false === self::_ini_value_changeable('memory_limit')) {
				define('KB_MAX_MEMORY_LIMIT', $memory_limit);
			} elseif (-1 === $memory_limit_in OR $memory_limit_in > 268435456)  {
				define('KB_MAX_MEMORY_LIMIT', $memory_limit);
			} else {
				define('KB_MAX_MEMORY_LIMIT', '256M');
			}
		}

		// Set memory limits.
		$csk_limit_int = self::_convert_to_bytes(KB_MEMORY_LIMIT);
		if (-1 !== $memory_limit_in 
			&& (-1 === $csk_limit_int OR $csk_limit_int > $memory_limit_in)) {
			@init_set('memory_limit', KB_MEMORY_LIMIT);
		}

		// Constants for expressing human-readable intervals.
		define('MINUTE_IN_SECONDS', 60);
		define('HOUR_IN_SECONDS',   60 * MINUTE_IN_SECONDS);
		define('DAY_IN_SECONDS',    24 * HOUR_IN_SECONDS);
		define('WEEK_IN_SECONDS',   7 * DAY_IN_SECONDS);
		define('MONTH_IN_SECONDS',  30 * DAY_IN_SECONDS);
		define('YEAR_IN_SECONDS',  365 * DAY_IN_SECONDS);

		// Default Skeleton path.
		define('CONTENT_DIR', normalize_path(FCPATH.'content'.DS));
		define('MODULES_DIR', normalize_path(CONTENT_DIR.'modules'.DS));
		define('PLUGINS_DIR', normalize_path(CONTENT_DIR.'plugins'.DS));
		define('THEMES_DIR', normalize_path(CONTENT_DIR.'themes'.DS));

		// We assign database options to configuration.
		self::setup_options();
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for quick access to CodeIgniter database and query builder.
	 *
	 * This is useful because we have some stuff stored in database and we need
	 * to retrieve them at the very beginning execution.
	 *
	 * @since 	2.0.0
	 */
	public static function DB() {

		// So to make the method remember the object.
		static $DB;

		if (empty($DB)) {

			// We make sure to load this file because of required functions.
			if ( ! function_exists('show_error')) {
				require_once(BASEPATH.'core/Common.php');
			}

			// If the file has not already been loaded, we load it.
			if ( ! function_exists('DB')) {
				require_once(BASEPATH.'database/DB.php');
			}

			$DB =& DB();
		}

		return $DB;
	}

	// ------------------------------------------------------------------------

	/**
	 * Instead of letting the Kbcore_options library do the job for us,
	 * we directly assign configuration here.
	 * @since 	2.0.0
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public static function setup_options()
	{
		static $_config, $_options;

		if (empty($config) && is_file(KBPATH.'config/defaults.php'))
		{
			require_once(KBPATH.'config/defaults.php');
			isset($config) && $_config = $config;
		
		}

		if (empty($_options) && ! empty($db_options = self::DB()->get('options')->result()))
		{
			foreach ($db_options as $option)
			{
				$_config[$option->name] = from_bool_or_serialize($option->value);
			}
		}

		global $assign_to_config;
		is_array($assign_to_config) OR $assign_to_config = array();
		$assign_to_config = array_merge($assign_to_config, $_config);
	}

	// ------------------------------------------------------------------------

	/**
	 * Converts a shorthand byte value to an integer bye value.
	 * 
	 * @since 	2.0.0
	 *
	 * @link 	https://secure.php.net/manual/en/function.ini-get.php
	 * @link 	https://secure.php.net/manual/en/faq.using.php#faq.using.shorthandbytes
	 *
	 * @param 	string 	$value 	A (PHP ini) byte value, either shorthand or ordinary.
	 * @return 	int 	An integer byte value.
	 */
	public static function _convert_to_bytes($value) {
		// Make sure constants are defined.
		defined('KB_IN_BYTES') OR self::constants();

		$value = strtolower(trim($value));
		$bytes = (int) $value;

		if (false !== strpos($value, 'g')) {
			$bytes *= GB_IN_BYTES;
		} elseif (false !== strpos($value, 'm')) {
			$bytes *= MB_IN_BYTES;
		} elseif (false !== strpos($value, 'k')) {
			$bytes *= KB_IN_BYTES;
		}

		/**
		 * We deal with large (float) values which run into the
		 * maximum integer size.
		 */
		return min($bytes, PHP_INT_MAX);
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for determining whether a PHP ini value is changeable at runtime.
	 *
	 * @since 	2.0.0
	 *
	 * @link 	https://secure.php.net/manual/en/function.ini-get-all.php
	 *
	 * @param 	string 	$value 	The nae of the ini setting to check.
	 * @return 	bool 	true if the setting is changeable at runtime, else false.
	 */
	public static function _ini_value_changeable($value) {
		static $ini_get_all; // Make the method remember all.

		if (empty($ini_get_all)) {
			$ini_get_all = false;

			/**
			 * Sometimes "init_get_all()" function is disabled via the 
			 * "disabled_functions" option for "security purposes" they say.
			 */
			if (function_exists('ini_get_all')) {
				$ini_get_all = ini_get_all();
			}
		}

		/**
		 * If we were unable to retrieve PHP INI details, we fail gracefully
		 * and assume it's changeable.
		 */
		if ( ! is_array($ini_get_all)) {
			return true;
		}

		if (isset($ini_get_all[$value]['access']) 
			&& (INI_ALL === ($ini_get_all[$value]['access'] & 7) 
				OR INI_USER === ($ini_get_all[$value]['access'] & 7))) {
			return true;
		}

		return false;
	}

	// ------------------------------------------------------------------------

	/**
	 * Method for returning the array or reserved modules names.
	 *
	 * @since 	2.0.0
	 *
	 * @return 	array
	 */
	public static function _reserved_modules() {
		static $modules; // Make sure method remembers them.
		
		if (empty($modules)) {
			$modules = array(
				'languages',
				'modules',
				'plugins',
				'themes',
				'users'
			);
		}
		
		return $modules;
	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('_DB')) {
	/**
	 * A quick-access to KPlatform::DB() method.
	 * @since 	2.0.0
	 * @param 	none
	 * @return 	DB
	 */
	function _DB() {
		static $DB = null;
		is_null($DB) && $DB = KPlatform::DB();
		return $DB;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_csk_modules')) {
	/**
	 * Function that returns reserved modules names.
	 *
	 * The reason behind reserved modules names is that the dashboard already comes
	 * with predefined controllers (routes), this is why this approach comes handy.
	 *
	 * @since 	2.0.0
	 * @return 	array
	 */
	function _csk_modules() {
		static $modules = null;
		is_null($modules) && $modules = KPlatform::_reserved_modules();
		return $modules;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_csk_reserved_module')) {
	/**
	 * Function for checking whether to selected module is reserved.
	 *
	 * @since 	2.0.0
	 *
	 * @param 	string 	$name 	The module name to check (folder name).
	 * @return 	bool 	true if the module is reversed, else false.
	 */
	function _csk_reserved_module($module = null)
	{
		// If nothing is provided, we assume it is not reserved.
		if (empty($module))
		{
			return false;
		}

		// We make the function remembers reserved modules.
		static $modules;

		if (empty($modules))
		{
			$modules = (function_exists('_csk_modules'))
				? _csk_modules()
				: KPlatform::_reserved_modules();

			// We make sure it's an array.
			is_array($modules) OR $modules = (array) $modules;
		}

		return (empty($modules)) ? false : in_array($module, $modules);
	}
}

// ------------------------------------------------------------------------

/**
 * See if the user decided to use PHP-Gettext instead of PHP Array
 * for languages lines.
 * @since 	2.1.0
 */
if (defined('USE_GETTEXT') && true === USE_GETTEXT)
{
	require_once(KBPATH.'third_party/bkader/gettext/class-gettext.php');
}

// ------------------------------------------------------------------------

if ( ! function_exists('start_data_cache'))
{
	/**
	 * Starts Skeleton Data_Cache object. internal access only.
	 *
	 * Make sure to call this function at the beginning of application 
	 * "bootstrap.php" file.
	 * 
	 * @since 	2.1.0
	 * 
	 * @access 	private
	 * @param 	array 	$groups 	Groups to initialize (Optional)
	 * @return 	void
	 */
	function start_data_cache($groups = null)
	{
		if ( ! function_exists('data_cache_init'))
		{
			require_once(KBPATH.'third_party/bkader/class-data-cache.php');
		}

		if (function_exists('data_cache_init'))
		{
			// We start the cache object.
			data_cache_init();

			if (function_exists('data_cache_add_groups'))
			{
				// Default groups.
				$default = array(
					'globals',
					'languages',
					'modules',
					'options',
					'plugins',
					'users',
				);

				if (is_array($groups))
				{
					$groups = array_merge($default, $groups);
				}
				elseif (is_string($groups))
				{
					$groups .= ','.implode(',', $default);
				}
				else
				{
					$groups = $default;
				}

				data_cache_add_groups($groups);
			}
		}
	}
}

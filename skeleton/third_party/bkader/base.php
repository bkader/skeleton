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
 * Copyright (c) 2018, Kader Bouyakoub <bkader@mail.com>
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
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @copyright	Copyright (c) 2018, Kader Bouyakoub <bkader@mail.com>
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://goo.gl/wGXHO9
 * @since 		2.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('_guess_base_url'))
{
	/**
	 * This function can be used to automatically guess site
	 * base URL. On production, make sure to set your base URL
	 * on the configuration file.
	 * @since 	2.0.0
	 * @return 	string
	 */
	function _guess_base_url()
	{
		static $base_url;

		if (empty($base_url))
		{
			$base_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://' : 'http://';
			$base_url .= $_SERVER['SERVER_NAME'];
			$base_url .= substr($_SERVER['SCRIPT_NAME'], 0, strpos($_SERVER['SCRIPT_NAME'], basename($_SERVER['SCRIPT_FILENAME'])));
		}

		return $base_url;
	}
}

// ------------------------------------------------------------------------
// Files importers.
// ------------------------------------------------------------------------

if ( ! function_exists('import')) {
	/**
	 * Function for loading files.
	 *
	 * @since 	2.0.0
	 *
	 * @param 	string 	$path 	The path to the file.
	 * @param 	string 	$folder 	The folder where the file should be.
	 * @return 	void
	 */
	function import($path, $folder = 'core') {
		$path = str_replace('\\', '/', $path);

		// We start with CodeIgniter "system" folder.
		if (false !== is_file($basepath = BASEPATH.$folder.'/'.$path.'.php')) {
			require_once($basepath);
		}

		// Does Skeleton have a file to use?
		if (false !== is_file($cskpath = KBPATH.$folder.'/'.$path.'.php')) {
			require_once($cskpath);
		}

		// Does the application has an override (on new class).
		if (false !== is_file($apppath = APPPATH.$folder.'/'.$path.'.php')) {
			require_once($apppath);
		}
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('import_with_vars')) {
	/**
	 * Including files with optional variables.
	 * @param 	string 	$filepath 	The file to include.
	 * @param 	array 	$vars 		Variables to pass.
	 * @param 	bool 	$print 		Whether to print th output.
	 * @return 	mixed
	 */
	function import_with_vars($filepath, $vars = array(), $print = false) {
		$output = null;

		if (is_file($filepath)) {
			is_array($vars) OR $vars = array($vars);
			extract($vars);
			ob_start();
			include_once($filepath);
			$output = ob_get_clean();
		}

		if (false === $print) {
			return $output;
		}

		print $output;
	}
}

// ------------------------------------------------------------------------
// Array Helpers.
// ------------------------------------------------------------------------

if ( ! function_exists('iin_array')) {
	/**
	 * A case-insensitive version of PHP in_array.
	 *
	 * @since 	2.0.0
	 *
	 * @param 	mixed 	$needle
	 * @param 	array 	$haystack
	 * @return 	bool
	 */
	function iin_array($needle, $haystack) {
		$needle   = strtolower($needle);
		$haystack = array_map('strtolower', $haystack);

		return in_array($needle, $haystack);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('array_clean')) {
	/**
	 * This function make sure to clean the given array by first removing
	 * white-spaces from array values, then removing empty elements and
	 * final keep unique values.
	 *
	 * @since 	1.4.0
	 *
	 * @param 	array
	 * @return 	array
	 */
	function array_clean(array $array = array()) {
		if ( ! empty($array)) {
			$array = array_map('trim', $array);
			$array = array_unique(array_filter($array));
		}

		return $array;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_deep_map')) {
	/**
	 * _deep_map
	 *
	 * Maps a function to all non-iterable elements of an array or an object.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	mixed 		$value
	 * @param 	callable 	$callback
	 * @return 	mixed
	 */
	function _deep_map($value, $callback) {
		if (is_array($value)) {
			foreach ($value as $key => $val) {
				$value[$key] = _deep_map($val, $callback);
			}
		}
		elseif (is_object($value)) {
			$vars = get_object_vars($value);
			foreach ($vars as $key => $val) {
				$value->{$key} = _deep_map($val, $callback);
			}
		} else {
			$value = call_user_func($callback, $value);
		}

		return $value;
	}
}

// ------------------------------------------------------------------------
// YAML files functions.
// ------------------------------------------------------------------------

if ( ! function_exists('yaml_read_file')) {
	/**
	 * Function for reading YAML files using Spyc class.
	 *
	 * @since 	2.0.0
	 *
	 * @param 	$path 	The full path to file.
	 * @return 	array 	Array if the file was found, else false.
	 */
	function yaml_read_file($path)
	{
		// We make sure to remember loaded file.
		static $already_loaded = array();

		if ( ! isset($already_loaded[$path])) {
			if ( ! is_file($path)) {
				return false;
			}

			class_exists('Spyc', false) OR import('spyc/spyc', 'third_party');
			$already_loaded[$path] = Spyc::YAMLLoad($path);
		}

		$data = $already_loaded[$path];

		/**
		 * Spyc file loader returns the file path if the file could not
		 * be found. If it's the case, we return false.
		 */
		if (isset($data[0]) && $data[0] === $path) {
			return false;
		}

		return $data;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('yaml_write_file'))
{
	/**
	 * Function for writing PHP arrays/objects into a YAML file.
	 *
	 * @since 	2.0.0
	 *
	 * @param 	string 	$path 		Path to the file.
	 * @param 	mixed 	$data 		Array or object.
	 * @param 	bool 	$override 	Whether to override old content.
	 * @return 	bool 	true if the file was written, else false.
	 */
	function yaml_write_file($path, $data = array(), $override = false) {
		class_exists('Spyc', false) OR import('spyc/spyc', 'third_party');
		function_exists('write_file') OR import('file_helper', 'helpers');

		/**
		 * If the file already exists, we make sure to load its old content
		 * and merge/replace everything before saving it.
		 */
		if (false === $override 
			&& false === empty($old_data = yaml_read_file($path))) {
			$data = array_replace_recursive($old_data, (array) $data);
		}

		$data = Spyc::YAMLDump($data, false, false, true);
		return write_file($path, $data);
	}
}

// ------------------------------------------------------------------------
// JSON files functions.
// ------------------------------------------------------------------------

if ( ! function_exists('json_read_file')) {
	/**
	 * json_read_file
	 *
	 * Function for reading JSON encoded files content.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	string 	$path 	The path to the file to read.
	 * @return 	mixed 	Array if the file is found and valid, else false.
	 */
	function json_read_file($path)
	{
		// Make sure function remember read files.
		static $cached = array();

		// No already cached?
		if ( ! isset($cached[$path])) {
			// Make sure the file exists.
			if (true !== is_file($path)) {
				return false;
			}

			// Get the content of the file and cache it if found.
			$content = file_get_contents($path);
			$content = json_decode($content, true);
			is_array($content) && $cached[$path] = $content;
		}

		return isset($cached[$path]) ? $cached[$path] : false;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('json_write_file')) {
	/**
	 * json_write_file
	 *
	 * Function writing Arrays/Objects into a json file.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	string 	$path 		The path to the file.
	 * @param 	mixed 	$data 		The data to write to file.
	 * @param 	bool 	$override 	Whether to override all file content.
	 * @return 	bool 	true if the file was written, else false.
	 */
	function json_write_file($path, $data = array(), $override = false)
	{
		// We shall not override content?
		if (false === $override && false !== ($old_data = json_read_file($path))) {
			$data = array_replace_recursive($old_data, (array) $data);
		}

		function_exists('write_file') OR import('file_helper', 'helpers');
		return write_file($path, json_encode($data, JSON_PRETTY_PRINT));
	}
}

// ------------------------------------------------------------------------
// PHPass functions.
// ------------------------------------------------------------------------

if ( ! function_exists('phpass_instance')) {
	/**
	 * This method creates an instance of PasswordHash object.
	 *
	 * @since 	2.0.0
	 *
	 * @return 	mixed 	phpass object if found, else false.
	 */
	function &phpass_instance($iterations = 8, $portable = false) {
		// Make the function remember the object.
		static $hasher;

		// Already set? Use it.
		if ( ! empty($hasher) && is_object($hasher)) {
			// Parameters have changed? Change the object.
			if ($hasher->iteration_count_log2 !== $iterations 
				OR $hasher->portable_hashes !== $portable) {
				$hasher = new PasswordHash($iterations, $portable);
			}

			return $hasher;
		}

		// Make sure to load the PasswordHash file and make sure the class exists.
		if ( ! class_exists('PasswordHash', false)) {
			import('phpass/PasswordHash', 'third_party');
			
			if ( ! class_exists('PasswordHash', false)) {
				return false;
			}
		}

		// Create a new instance of hasher and return it.
		$hasher = new PasswordHash($iterations, $portable);
		return $hasher;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('phpass_hash') && function_exists('phpass_instance')) {
	/**
	 * Hashes a given string, aka password, using phpass library.
	 *
	 * @since 	2.0.0
	 *
	 * @param 	string 	$password
	 * @return 	string 	the password after being hashed.
	 */
	function phpass_hash($password) {
		if (false !== ($phpass =& phpass_instance())) {
			return $phpass->HashPassword($password);
		}

		// Fall-back to "password_hash".
		if (function_exists('password_hash')) {
			return password_hash($password, PASSWORD_BCRYPT);
		}

		return $password;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('phpass_check')) {
	/**
	 * Checks whether the given password is valid after comparison 
	 * against a stored hashed password.
	 *
	 * @since 	2.0.0
	 *
	 * @param 	string 	$password
	 * @param 	string 	$stored_hash
	 * @return 	bool 	true if valid, else false.
	 */
	function phpass_check($password, $stored_hash) {
		if (false !== ($phpass =& phpass_instance())) {
			return $phpass->CheckPassword($password, $stored_hash);
		}

		// Fall-back to "password_verify".
		if (function_exists('password_verify')) {
			return password_verify($password, $stored_hash);
		}

		return false;
	}
}

// ------------------------------------------------------------------------
// Usernames functions.
// ------------------------------------------------------------------------

if ( ! function_exists('_forbidden_usernames')) {
	/**
	 * This function returns an array of all possible forbidden usernames.
	 *
	 * @since 	2.0.0
	 *
	 * @return 	array
	 */
	function _forbidden_usernames()
	{
		static $usernames;

		if (empty($usernames)) {
			if (function_exists('yaml_read_file') && 
				false !== ($u = yaml_read_file(KBPATH.'third_party/bkader/inc/usersnames.yml'))) {
				$usernames = $u;
			}
			elseif (is_file(KBPATH.'third_party/bkader/inc/usernames.php')) {
				$usernames = require_once(KBPATH.'third_party/bkader/inc/usernames.php');
			}
		}

		return $usernames;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('is_forbidden_username')) {
	/**
	 * Checks whether the given name is forbidden.
	 *
	 * @since 	2.0.0
	 *
	 * @param 	string 	$username
	 * @return 	bool 	true if the username is forbidden, else false.
	 */
	function is_forbidden_username($username)
	{
		$usernames = _forbidden_usernames();
		return (in_array($username, $usernames));
	}
}

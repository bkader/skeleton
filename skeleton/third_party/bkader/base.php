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
// Paths functions.
// ------------------------------------------------------------------------

if ( ! function_exists('normalize_path')) {
	/**
	 * Normalizes a filesystem path.
	 *
	 * @since 	2.0.1
	 *
	 * @param 	string 	$path 	Path to normalize.
	 * @return 	string 	Normalized path.
	 */
	function normalize_path($path) {
		$path = str_replace('\\', '/', $path);
		$path = preg_replace('|(?<=.)/+|', '/', $path);

		// Upper-case driver letters on windows systems.
		if (':' === substr($path, 1, 1) && ! ctype_upper($path[0])) {
			$path = ucfirst($path);
		}

		return $path;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('path_is_stream')) {
	/**
	 * Tests if the given path is a stream URL.
	 *
	 * @since 	2.0.1
	 *
	 * @param 	string 	$path 	The resource path or URL.
	 * @return 	bool 	true if the path is a stream URL, else false.
	 */
	function path_is_stream($path) {
		$wrappers = '('.join('|', stream_get_wrappers()).')';
		return (preg_match("!^{$wrappers}://!", $path) === 1);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('path_is_url')) {
	/**
	 * Tests if the given path is a URL with or without protocol.
	 *
	 * @since 	2.1.1
	 *
	 * @param 	string 	$path 	The resource path or URL.
	 * @return 	bool 	true if the path is a valid URL, else false.
	 */
	function path_is_url($path) {
		static $regex;
		if (is_null($regex)) {
			$regex = '/(?:https?:\/\/)?(?:[a-zA-Z0-9.-]+?\.(?:[a-zA-Z])|\d+\.\d+\.\d+\.\d+)/';
		}

		return preg_match($regex, $path);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('path_mkdir')) {
	/**
	 * Recursive directory creation based on full path.
	 *
	 * @since 	2.0.1
	 *
	 * @param 	string 	$target 	Full path to create.
	 * @return 	bool 	true if directory was created or exists, else false.
	 */
	function path_mkdir($target) {
		$wrapper = null;

		// Strip the protocol.
		if (path_is_stream($target)) {
			list($wrapper, $target) = explode('://', $target, 2);
		}

		// From php.net/mkdir user contributed notes.
		$target = str_replace('//', '/', $target);

		// We put the wrapper back on the target.
		if ($wrapper !== null) {
			$target = $wrapper.'://'.$target;
		}

		// Safe mode fails wit a trailing slash under certain PHP versions.
		$target = rtrim($target.'/');
		empty($target) && $target = '/';

		if (file_exists($target)) {
			return @is_dir($target);
		}

		/**
		 * We need to find the permissions of the parent folder
		 * that exists and inherit that.
		 */
		$target_parent = dirname($target);
		while ('.' != $target_parent 
			&& ! is_dir($target_parent) 
			&& dirname($target_parent) !== $target_parent) {
			$target_parent = dirname($target_parent);
		}

		// Get the permission bits.
		$dir_perms = ($stat = @stat($target_parent)) ? $stat['mode'] & 0007777 : 0777;

		// Successful directory creation?
		if (false !== @mkdir($target, $dir_perms, true)) {

			/**
			 * If a umask is set and modifies $dir_permis, we will have to
			 * re-set the $dir_perms correctly with chmod.
			 */
			if ($dir_perms != ($dir_perms & ~umask())) {
				$folder_parts = explode('/', substr($target, strlen($target_parent) + 1));
				$c = count($folder_parts);
				for ($i = 1; $i <= $c; $i++ ) {
					@chmod($target_parent.'/'.implode('/', array_slice($folder_parts, 0, $i)), $dir_perms);
				}
			}

			return true;
		}

		// The directory could not be created.
		return false;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('path_is_absolute')) {
	/**
	 * Tests if the given path is absolute.
	 *
	 * @since 	2.0.1
	 *
	 * @param 	string 	$path 	File path.
	 * @return 	bool 	true if the path is absolute, else false.
	 */
	function path_is_absolute($path) {

		/**
		 * This is definitely true bu fails if $path does not exist or
		 * contains a symbolic link.
		 */
		if (realpath($path) == $path) {
			return true;
		}

		// Ignore parent directory.
		if (strlen($path) == 0 OR $path[0] == '.') {
			return false;
		}

		// Windows absolute paths.
		if (preg_match('#^[a-zA-Z]:\\\\#', $path)) {
			return true;
		}

		/**
		 * Path starting with / or \ is absolute.
		 * Anything else is relative.
		 */
		return ($path[0] == '/' || $path[0] == '\\');
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('path_join')) {
	/**
	 * Joins two filesystem paths together.
	 *
	 * @since 	2.0.1
	 *
	 * @param 	string 	$base 	The base path.
	 * @param 	string 	$path 	The relative path to $base.
	 * @return 	string 	The path with base or absolute path.
	 */
	function path_join($base, $path) {
		// If the provided $path is not an absolute path, we prepare it.
		if ( ! path_is_absolute($path)) {
			$base = rtrim(str_replace('\\', '/', $base), '/').'/';
			$path = ltrim(str_replace('\\', '/', $path), '/');
			$path = $base.$path;
		}

		return $path;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('backslashit')) {
	/**
	 * Adds backslashes before letters and before a number at
	 * the start of the string.
	 * 
	 * @since 	2.0.1
	 *
	 * @param 	string 	$string 	Value to which backslashes will be added.
	 * @return 	string 	String with backslashes inserted.
	 */
	function backslashit($string) {
		if (isset($string[0]) && $string[0] >= '0' && $string[0] <= '9') {
			$string = '\\\\'.$string;
		}

		return addcslashes($string, 'A..Za..z');
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('trailingslashit')) {
	/**
	 * Removes trailing forward and backslashes if it exists already before
	 * adding a trailing slash. This prevents double slashing a string or path.
	 *
	 * The primary use of this is for paths and this should be used for paths.
	 * It is not restricted to paths and offers no specific path support.
	 *
	 * @since 	2.0.1
	 *
	 * @param 	string 	$string 	What to add the trailing slash to.
	 * @return 	string 	String with trailing slash added.
	 */
	function trailingslashit($string) {
		return rtrim($string, '/\\').'/';
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('untrailingslashit')) {
	/**
	 * Removes trailing forward and backslashes if they exists.
	 * 
	 * The primary use of this is for paths and thus should be used for paths.
	 * It is not restricted to paths and offers no specific path support.
	 *
	 * @since 	2.0.1
	 *
	 * @param 	string 	$string 	What to remove the trailing slash from.
	 * @return 	string 	String with trailing slash removed.
	 */
	function untrailingslashit($string) {
		return rtrim($string, '/\\');
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
		$path = normalize_path($path);

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

if ( ! function_exists('array_get')) {
	/**
	 * Access array keys using dot-notation.
	 *
	 * @since 	2.1.0
	 *
	 * @param 	array 	$array 		The array used for search.
	 * @param 	string 	$key 		Key to look for.
	 * @param 	mixed 	$default 	Default value if key is not found.
	 */
	function array_get($array, $key, $default = false) {
		$value = $array;
		$path  = explode('.', $key);
		$count = count($path);

		for ($i = 0; $i < $count; ++$i) {
			$sub_key = $path[$i];

			if (is_array($value) && isset($value[$sub_key])) {
				$value = $value[$sub_key];
			} elseif (is_object($value) && isset($value->{$sub_key})) {
				$value = $value->{$sub_key};
			} else {
				return $default;
			}
		}

		return $value;
	}
}

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
// Attributes functions.
// ------------------------------------------------------------------------

if ( ! function_exists('array_to_attr')) {
	/**
	 * Takes an array of attributes and turns it into a string of HTML tag.
	 *
	 * @since 	2.1.0
	 *
	 * @param 	array 	$attr 	Attributes to turn to string.
	 * @return 	string
	 */
	function array_to_attr($attr) {
		$attr_str = '';
		is_array($attr) OR $attr = (array) $attr;

		foreach ($attr as $key => $val)
		{
			// We ignore null/false values.
			if ($val === null OR $val === false)
			{
				continue;
			}

			// Numeric keys must be something like disabled="disabled"
			if (is_numeric($key))
			{
				$key = $val;
			}

			$attr_str .= $key.'="'.str_replace('"', '&quot;', $val).'" ';
		}

		// We strip extra spaces before and after.
		return trim($attr_str);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('attr_to_array')) {
	/**
	 * Takes a string of HTML attributes and turns it into an array.
	 *
	 * @since 	2.1.0
	 *
	 * @param 	string 	$str 	HTML attributes string.
	 * @return 	array
	 */
	function attr_to_array($str) {
		preg_match_all('#(\w+)=([\'"])(.*)\\2#U', $str, $matches);
		$params = array();

		foreach($matches[1] as $key => $val)
		{
			if ( ! empty($matches[3]))
			{
				$params[$val] = $matches[3][$key];
			}
		}

		return $params;
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

// ------------------------------------------------------------------------

if ( ! function_exists('_load_session'))
{
	/**
	 * This function is used to early-load session library
	 * @param 	none
	 * @return 	CI_Session
	 */
	function _load_session()
	{
		static $session;

		if (is_null($session) OR ! isset($_SESSION))
		{
			if ( ! function_exists('load_class'))
			{
				require_once(BASEPATH.'libraries/Session/Session.php');
				$session = new CI_Session();
			}
			else
			{
				$session =& load_class('Session', 'libraries/Session');
			}
		}

		return $session;
	}
}

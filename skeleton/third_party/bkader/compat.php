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
 * @since 		2.1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Backward compatibility functions.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Compatibility
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.1.0
 * @version 	2.1.0
 */

if ( ! function_exists('hash_hmac')) {
	/**
	 * Compatibility function to mimic hash_hmac.
	 * @param 	string 	$algo 			Name of selected hashing algorithm.
	 * @param 	string 	$data 			Message to be hashed.
	 * @param 	string 	$key 			Secret key used for hashing.
	 * @param 	bool 	$raw_output 	When set to TRUE, outputs raw binary data.
	 *                            		FALSE outputs lowercase hexits.
	 */
	function hash_hmac($algo, $data, $key, $raw_output = false) {
		$hmac  = false;
		$packs = array('md5' => 'H32', 'sha1' => 'H40');

		if (isset($packs[$algo])) {
			$pack = $packs[$algo];
			(strlen($key) > 64) && $key = pack($pack, $algo($key));
			
			$key = str_pad($key, 64, chr(0));

			$ipad = (substr($key, 0, 64) ^ str_repeat(chr(0x36), 64));
			$opad = (substr($key, 0, 64) ^ str_repeat(chr(0x5C), 64));

			$hmac = $algo($opad . pack($pack, $algo($ipad . $data)));

			$raw_output && $hmac = pack($pack, $hmac);
		}

		return $hmac;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('hash_equals')) {
	/**
	 * Timing attack safe string comparison.
	 * Compares two strings using the same time whether they're equal or not.
	 * This function was added in PHP 5.6
	 * Note: It can leak the length of a string when arguments of differing
	 * length are supplied.
	 * @param 	string 	$known_string 	The string of known length to compare against
	 * @param 	string 	$user_string 	The user-supplied string
	 * @return 	bool 	Returns TRUE when the two strings are equal, FALSE otherwise.
	 */
	function hash_equals($known_string, $user_string) {
		if ( ! is_string($known_string)) {
			throw new Exception('hash_equals(): Expected known_string to be a string, integer given');
		}
		if ( ! is_string($user_string)) {
			throw new Exception('hash_equals(): Expected user_string to be a string, integer given');
		}

		$known_string_length = strlen($known_string);
		if ($known_string_length !== strlen($user_string)) {
			return false;
		}

		$result = 0;
		for ($i = 0; $i < $known_string_length; $i++) {
			$result |= ord($known_string[$i]) ^ ord($user_string[$i]);
		}

		return $result === 0;
	}
}

// ------------------------------------------------------------------------
// JSON backup plan.
// ------------------------------------------------------------------------

/**
 * JSON_PRETTY_PRINT was introduced in PHP 5.4.
 * Defined here to prevent a notice when using it with json_write_file()
 * or other functions on the application.
 */
defined('JSON_PRETTY_PRINT') OR define('JSON_PRETTY_PRINT', 128);

// ------------------------------------------------------------------------

if ( ! function_exists('json_encode')) {
	/**
	 * Compatibility function to mimic json_encode.
	 * @param 	mixed 	$value 	The value being encoded. Can be any type except a resource.
	 * @return 	string 	Returns a JSON encoded string on success or FALSE on failure.
	 */
	function json_encode($value) {
		static $json;

		if (empty($json) OR ! ($json instanceof Services_JSON)) {
			require_once(KBPATH.'third_party/json/JSON.php');
			$json = new Services_JSON();
		}

		return is_object($json) ? $json->encode($value) : $value;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('json_decode')) {
	/**
	 * Compatibility function to mimic json_encode.
	 * @param 	mixed 	$json 	The json string being decoded.
	 * @return 	mixed 	Returns the value encoded in json in appropriate PHP type.
	 */
	function json_decode($json) {
		static $json;

		if (empty($json) OR ! ($json instanceof Services_JSON)) {
			require_once(KBPATH.'third_party/json/JSON.php');
			$json = new Services_JSON();
		}

		return is_object($json) ? $json->decode($json) : $json;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('json_last_error_msg')) {
	/**
	 * Retrieves the error string of the last json_encode() or json_decode() call.
	 * @internal 	This is a compatibility function for PHP <5.5
	 * @return 	mixed 	Returns the error message on success, "No Error" if 
	 *                  no error has occurred, or false on failure.
	 */
	function json_last_error_msg() {
		// In case the function does not exists.
		if ( ! function_exists( 'json_last_error')) {
			return false;
		}

		$last_error_code = json_last_error();

		// Just in case JSON_ERROR_NONE is not defined.
		$error_code_none = defined( 'JSON_ERROR_NONE' ) ? JSON_ERROR_NONE : 0;

		switch (true) {
			case $last_error_code === $error_code_none:
				return 'No error';

			case defined('JSON_ERROR_DEPTH') && JSON_ERROR_DEPTH === $last_error_code:
				return 'Maximum stack depth exceeded';

			case defined('JSON_ERROR_STATE_MISMATCH') && JSON_ERROR_STATE_MISMATCH === $last_error_code:
				return 'State mismatch (invalid or malformed JSON)';

			case defined('JSON_ERROR_CTRL_CHAR') && JSON_ERROR_CTRL_CHAR === $last_error_code:
				return 'Control character error, possibly incorrectly encoded';

			case defined('JSON_ERROR_SYNTAX') && JSON_ERROR_SYNTAX === $last_error_code:
				return 'Syntax error';

			case defined('JSON_ERROR_UTF8') && JSON_ERROR_UTF8 === $last_error_code:
				return 'Malformed UTF-8 characters, possibly incorrectly encoded';

			case defined('JSON_ERROR_RECURSION') && JSON_ERROR_RECURSION === $last_error_code:
				return 'Recursion detected';

			case defined('JSON_ERROR_INF_OR_NAN') && JSON_ERROR_INF_OR_NAN === $last_error_code:
				return 'Inf and NaN cannot be JSON encoded';

			case defined('JSON_ERROR_UNSUPPORTED_TYPE') && JSON_ERROR_UNSUPPORTED_TYPE === $last_error_code:
				return 'Type is not supported';

			default:
				return 'An unknown error occurred';
		}
	}
}

// ------------------------------------------------------------------------
// Random int, introduced in PHP 7.0
// ------------------------------------------------------------------------
if ( ! function_exists('random_int')) {
	require_once(KBPATH.'third_party/random_compat/random.php');
}

// ------------------------------------------------------------------------

if ( ! function_exists('array_replace_recursive')) {
	/**
	 * PHP-agnostic version of {@link array_replace_recursive()}.
	 *
	 * The array_replace_recursive() function is a PHP 5.3 function. Skeleton
	 * is trying to support down to PHP 5.2, so this method is a workaround
	 * for PHP 5.2.
	 *
	 * Note: array_replace_recursive() supports infinite arguments, but for our use-
	 * case, we only need to support two arguments.
	 *
	 * @see https://secure.php.net/manual/en/function.array-replace-recursive.php#109390
	 *
	 * @param  array $base         Array with keys needing to be replaced.
	 * @param  array $replacements Array with the replaced keys.
	 * @return array
	 */
	function array_replace_recursive($base = array(), $replacements = array()) {
		foreach (array_slice(func_get_args(), 1) as $replacements) {
			$bref_stack = array(&$base);
			$head_stack = array($replacements);

			do {
				end($bref_stack);

				$bref = &$bref_stack[key($bref_stack)];
				$head = array_pop($head_stack);

				unset($bref_stack[key($bref_stack)]);

				foreach (array_keys($head) as $key) {
					if (isset($key, $bref) 
						&& isset($bref[ $key]) 
						&& is_array($bref[$key]) 
						&& isset($head[$key]) 
						&& is_array($head[$key])
					) {
						$bref_stack[] = &$bref[ $key ];
						$head_stack[] = $head[ $key ];
					} else {
						$bref[ $key ] = $head[ $key ];
					}
				}
			} while (count($head_stack));
		}

		return $base;
	}
}

// ------------------------------------------------------------------------
// Polyfill for SPL autoload.
// ------------------------------------------------------------------------
if ( ! function_exists('spl_autoload_register')) {
	/**
	 * Holds all registered classes and paths;
	 * @var array
	 */
	$_cs_spl_autoloaders = array();
	
	/**
	 * Autoloader compatibility callback.
	 * @param 	string 	$classname 	Class to attempt autoloading.
	 * @return 	void
	 */
	function __autoload($classname) {
		global $_cs_spl_autoloaders;
		foreach ($_cs_spl_autoloaders as $autoloader) {
			// Avoid the extra warning if the autoloader isn't callable.
			if ( ! is_callable($autoloader)) {
				continue;
			}
			
			call_user_func($autoloader, $classname);
			
			// If it has been autoloaded, stop processing.
			if (class_exists($classname, false)) {
				return;
			}
		}
	}

	// ------------------------------------------------------------------------
	
	/**
	 * Registers a function to be autoloaded.
	 * @param 	callable 	$function 	function to register.
	 * @param 	bool 		$throw 		Whether the function should throw an exception.
	 * @param 	bool 		Whether the function should be prepended to the stack.
	 */
	function spl_autoload_register($function, $throw = true, $prepend = false) {
		// String not translated to match PHP core.
		if ($throw && ! is_callable($function)) {
			throw new Exception('Function not callable');
		}
		
		global $_cs_spl_autoloaders;
		
		// Don't allow multiple registration.
		if (in_array($function, $_cs_spl_autoloaders)) {
			return;
		}
		
		if ($prepend) {
			array_unshift($_cs_spl_autoloaders, $function);
		} else {
			$_cs_spl_autoloaders[] = $function;
		}
	}

	// ------------------------------------------------------------------------
	
	/**
	 * Unregisters an autoloader function.
	 * @param 	callable 	$function 	The function to unregister.
	 * @return 	bool 		true if the function was unregistered, false if it could not be.
	 */
	function spl_autoload_unregister($function) {
		global $_cs_spl_autoloaders;
		foreach ($_cs_spl_autoloaders as &$autoloader) {
			if ($autoloader === $function) {
				unset($autoloader);
				return true;
			}
		}
		
		return false;
	}

	// ------------------------------------------------------------------------
	
	/**
	 * Retrieves the registered autoloader functions.
	 * @return 	array List of autoloader functions.
	 */
	function spl_autoload_functions() {
		return $GLOBALS['_cs_spl_autoloaders'];
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('is_countable')) {
	/**
	 * Polyfill for is_countable() function added in PHP 7.3.
	 *
	 * Verify that the content of a variable is an array or an object
	 * implementing the Countable interface.
	 *
	 * @param 	mixed 	$var 	The value to check.
	 * @return 	bool 	true if `$var` is countable, false otherwise.
	 */
	function is_countable($var) {
		return (is_array($var) 
			OR $var instanceof Countable 
			OR $var instanceof SimpleXMLElement 
			OR $var instanceof ResourceBundle);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('is_iterable')) {
	/**
	 * Polyfill for is_iterable() function added in PHP 7.1.
	 *
	 * Verify that the content of a variable is an array or an object
	 * implementing the Traversable interface.
	 *
	 * @param 	mixed 	$var 	The value to check.
	 * @return 	bool 	true if `$var` is iterable, false otherwise.
	 */
	function is_iterable($var) {
		return (is_array($var) OR $var instanceof Traversable);
	}
}

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
 * Hash Class
 *
 * Hashes, encrypts/decrypts strings and generates random strings.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Libraries
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.0.0
 */
class Hash
{
	/**
	 * @var object - instance of ci object.
	 */
	private $ci;

	/**
	 * @var string - glue used for encryption and imploding;
	 */
	public $glue = '~';

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		// Prepare ci object instance.
		$this->ci =& get_instance();

		log_message('info', 'Hash Class Initialized');
	}

	// ------------------------------------------------------------------------
	// Random String Generator
	// ------------------------------------------------------------------------

	/**
	 * Generate a random string using string_helper.
	 * @param 	int 	$length 	random string's length.
	 * @param 	string 	$type 		random string's type.
	 * @return 	string
	 */
	public function random($length = 8, $type = 'alnum')
	{
		// Load string helper only if not loaded.
		(function_exists('random_string')) OR $this->ci->load->helper('string');

		return random_string($type, $length);
	}

	/**
	 * Portable hashed string using Bcrypt.
	 * @param 	string 	$string 	the string to hash.
	 * @return 	string 	the string after being hashed.
	 */
	public function hash($string)
	{
		static $phpass;

		empty($phpass) && $phpass =& phpass_instance(8, true);

		return $phpass->HashPassword($string);
	}

	// ------------------------------------------------------------------------
	// Encode and Decode using Encryption library.
	// ------------------------------------------------------------------------

	/**
	 * Takes any number or arguments, implode them and encrypts.
	 * @param 	mixed 	array or multiple arguments.
	 * @return 	string
	 */
	public function encode()
	{
		if ( ! empty($args = func_get_args()))
		{
			(is_array($args[0])) && $args = $args[0];

			// Load Encrypt library if not loaded.
			if ( ! class_exists('CI_Encryption', false))
			{
				$this->ci->load->library('encryption');
			}

			return $this->ci->encryption->encrypt(implode($this->glue, $args));
		}

		return null;
	}

	/**
	 * Takes a string and try to decrypt it using encryption library.
	 * @param 	string 	$str 	the string to decrypt
	 * @return 	array|null
	 */
	public function decode($str)
	{
		if ( ! empty($str))
		{
			// Load Encrypt library if not loaded.
			if ( ! class_exists('CI_Encryption', false))
			{
				$this->ci->load->library('encryption');
			}

			$decoded = $this->ci->encryption->decrypt($str);

			return (empty($decoded)) ? null : explode($this->glue, $decoded);
		}

		return null;
	}

	// ------------------------------------------------------------------------
	// Hash and Check Password methods.
	// ------------------------------------------------------------------------

	/**
	 * Hashes a password using Bcrypt library.
	 * @param 	string 	$password 		the password to hash.
	 * @return 	string 	the password after being hashed.
	 */
	public function hash_password($password)
	{
		return phpass_hash($password);
	}

	/**
	 * Compare between a known password and a hash.
	 * @param 	string 	$password 	the known password.
	 * @param 	string 	$hash 		the known hash.
	 * @return 	bool 	true if password is valid, else false.
	 */
	public function check_password($password, $hash)
	{
		return phpass_check($password, $hash);
	}

}

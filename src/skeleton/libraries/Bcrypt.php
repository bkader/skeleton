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
 * @link 		https://github.com/bkader
 * @since 		Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Bcrypt Class
 *
 * This a simple portable password hashing library.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Libraries
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 * @author 		Dwight Watson
 * @link 		http://www.github.com/studiousapp/codeigniter-bcrypt
 */
class Bcrypt
{
	/**
	 * Characters to be used for hashing.
	 * @var string
	 */
	private $_itoa64 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

	/**
	 * Randomness state
	 * @var int
	 */
	private $_random_state;
	
	/**
	 * Number of iterations.
	 * @var int
	 */
	private $_iteration_count = 8;

	/**
	 * Whether to use portable hashing.
	 * @var boolean
	 */
	private $_portable_hashes = FALSE;

	/**
	 * Constructor
	 * @access	public
	 * @param	array $config 	Library config array?
	 * @return 	void
	 */
	public function __construct($config = array())
	{
		// Initialize class preference.
		(empty($config)) OR $this->initialize($config);

		// Correct iterations count.
		if ($this->_iteration_count < 4 OR $this->_iteration_count > 31)
		{
			$this->_iteration_count = 8;
		}

		// Cache the randomness state.
		$this->_random_state = microtime().(function_exists('getmypid') ? getmypid() : '');
	}

	// ------------------------------------------------------------------------
	
	/**
	 * Initialize preferences
	 * @access 	public
	 * @param	array 	$config 	Class config array.
	 * @return	void
	 */
	public function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
			(isset($this->{'_'.$key})) && $this->{'_'.$key} = $val;
		}
	}

	// ------------------------------------------------------------------------

	/**
	 * Generate random bytes.
	 * @access 	private
	 * @param 	int 	$length 	Number of bytes.
	 * @return 	string
	 */
	private function get_random_bytes($length)
	{
		// Prepare empty output.
		$output = '';
		
		// Readable /dev/urandom ?
		if (is_readable('/dev/urandom') &&
		    ($fh = @fopen('/dev/urandom', 'rb')))
		{
			$output = fread($fh, $length);
			fclose($fh);
		}

		// Issue with length? Try to generate it.
		if (strlen($output) < $length)
		{
			// Reset the output.
			$output = '';

			for ($i = 0; $i < $length; $i += 16)
			{
				$this->_random_state = md5(microtime().$this->_random_state);
				$output .= pack('H*', md5($this->_random_state));
			}

			// Cut the output to the desired length.
			$output = substr($output, 0, $length);
		}

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * Simple base64 encoder.
	 * @access 	private
	 * @param 	string 	$input 	The input to encode.
	 * @param 	int 	$length Output length.
	 * @return 	string
	 */
	private function encode64($input, $length)
	{
		$output = '';
		$i = 0;
		do
		{
			$value = ord($input[$i++]);
			$output .= $this->_itoa64[$value & 0x3f];
			
			if ($i < $length)
			{
				$value |= ord($input[$i]) << 8;
			}

			$output .= $this->_itoa64[($value >> 6) & 0x3f];
			
			if ($i++ >= $length)
			{
				break;
			}

			if ($i < $length)
			{
				$value |= ord($input[$i]) << 16;
			}

			$output .= $this->_itoa64[($value >> 12) & 0x3f];

			if ($i++ >= $length)
			{
				break;
			}

			$output .= $this->_itoa64[($value >> 18) & 0x3f];
		}
		while ($i < $length);

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * Generate a private salt for the given input.
	 * @access 	private
	 * @param 	string 	$string 	The string to generate salt from.
	 * @return 	string
	 */
	private function gensalt_private($string)
	{
		$output = '$P$';
		$output .= $this->_itoa64[min($this->_iteration_count + ((PHP_VERSION >= '5') ? 5 : 3), 30)];
		$output .= $this->encode64($string, 6);
		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * Crypt private
	 * @access 	private
	 * @return 	string
	 */
	private function crypt_private($password, $setting)
	{
		$output = '*0';
		
		if (substr($setting, 0, 2) == $output)
		{
			$output = '*1';
		}

		$id = substr($setting, 0, 3);
		
		// We use "$P$", phpBB3 uses "$H$" for the same thing
		if ($id != '$P$' && $id != '$H$')
		{
			return $output;
		}

		$count_log2 = strpos($this->_itoa64, $setting[3]);
		
		if ($count_log2 < 7 OR $count_log2 > 30)
		{
			return $output;
		}

		$count = 1 << $count_log2;

		$salt = substr($setting, 4, 8);
		
		if (strlen($salt) != 8)
		{
			return $output;
		}

		/**
		 * We're kind of forced to use MD5 here since it's the only
		 * cryptographic primitive available in all versions of PHP
		 * currently in use.  To implement our own low-level crypto
		 * in PHP would result in much worse performance and
		 * consequently in lower iteration counts and hashes that are
		 * quicker to crack (by non-PHP code).
		 */

		if (PHP_VERSION >= '5')
		{
			$hash = md5($salt.$password, TRUE);

			do
			{
				$hash = md5($hash.$password, TRUE);
			}
			while (--$count);
		}
		else
		{
			$hash = pack('H*', md5($salt.$password));
			do
			{
				$hash = pack('H*', md5($hash.$password));
			}
			while (--$count);
		}

		$output = substr($setting, 0, 12);
		$output .= $this->encode64($hash, 16);

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * Generate extended salt.
	 * @access 	private
	 * @param 	string 	$string
	 * @return 	string 	$output
	 */
	private function gensalt_extended($string)
	{
		$count_log2 = min($this->_iteration_count + 8, 24);
		/**
		 * This should be odd to not reveal weak DES keys, and the
		 * maximum valid value is (2**24 - 1) which is odd anyway.
		 */

		$count = (1 << $count_log2) - 1;

		$output = '_';
		$output .= $this->_itoa64[$count & 0x3f];
		$output .= $this->_itoa64[($count >> 6) & 0x3f];
		$output .= $this->_itoa64[($count >> 12) & 0x3f];
		$output .= $this->_itoa64[($count >> 18) & 0x3f];

		$output .= $this->encode64($string, 3);

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * Generate salt using blowfish.
	 * @access 	private
	 * @param 	string 	$string
	 * @return 	string 	$output
	 */
	private function gensalt_blowfish($string)
	{
		/**
		 * This one needs to use a different order of characters and a
		 * different encoding scheme from the one in encode64() above.
		 * We care because the last character in our encoded string will
		 * only represent 2 bits.  While two known implementations of
		 * bcrypt will happily accept and correct a salt string which
		 * has the 4 unused bits set to non-zero, we do not want to take
		 * chances and we also do not want to waste an additional byte
		 * of entropy.
		 */

		$itoa64 = './ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

		$output = '$2a$';
		$output .= chr(ord('0') + $this->_iteration_count / 10);
		$output .= chr(ord('0') + $this->_iteration_count % 10);
		$output .= '$';

		$i = 0;
		do
		{
			$c1 = ord($string[$i++]);
			$output .= $itoa64[$c1 >> 2];
			$c1 = ($c1 & 0x03) << 4;
			
			if ($i >= 16)
			{
				$output .= $itoa64[$c1];
				break;
			}

			$c2 = ord($string[$i++]);
			$c1 |= $c2 >> 4;
			$output .= $itoa64[$c1];
			$c1 = ($c2 & 0x0f) << 2;

			$c2 = ord($string[$i++]);
			$c1 |= $c2 >> 6;
			$output .= $itoa64[$c1];
			$output .= $itoa64[$c2 & 0x3f];
		}
		while (1);

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * Hash a given password.
	 * @access 	public
	 * @param 	string 	$password
	 * @return 	string
	 */

	public function hash_password($password)
	{
		$random = '';

		// CRYPT_BLOWFISH?
		if (CRYPT_BLOWFISH == 1 && ! $this->_portable_hashes)
		{
			$random = $this->get_random_bytes(16);
			$hash = crypt($password, $this->gensalt_blowfish($random));
			
			if (strlen($hash) == 60)
			{
				return $hash;
			}
		}

		// CRYPT_EXT_DES?
		if (CRYPT_EXT_DES == 1 && ! $this->_portable_hashes)
		{
			if (strlen($random) < 3)
			{
				$random = $this->get_random_bytes(3);
			}

			$hash = crypt($password, $this->gensalt_extended($random));
			
			if (strlen($hash) == 20)
			{
				return $hash;
			}
		}

		if (strlen($random) < 6)
		{
			$random = $this->get_random_bytes(6);
		}

		$hash = $this->crypt_private($password, $this->gensalt_private($random));

		if (strlen($hash) == 34)
		{
			return $hash;
		}

		/**
		 * Returning '*' on error is safe here, but would _not_ be safe
		 * in a crypt(3)-like function used _both_ for generating new
		 * hashes and for validating passwords against existing hashes.
		 */

		return '*';
	}

	// ------------------------------------------------------------------------

	/**
	 * Compares between a known password and a given hashed string.
	 * @access 	public
	 * @param 	string 	$password
	 * @param 	string 	$hashed
	 * @return 	boolean
	 */
	public function check_password($password, $hashed)
	{
		$hash = $this->crypt_private($password, $hashed);

		if ($hash[0] == '*')
		{
			$hash = crypt($password, $hashed);
		}

		return ($hash == $hashed);
	}
}

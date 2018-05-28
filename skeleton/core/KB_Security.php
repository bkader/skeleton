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
 * @since 		1.4.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KB_Security Class
 *
 * This file extends CI_Security class in order to add some useful security
 * methods, such as nonce creation.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.4.0
 * @version 	2.0.0
 */
class KB_Security extends CI_Security {

	/**
	 * create_nonce
	 *
	 * Creates a cryptographic token tied to the selected action, user,
	 * user session id and window of time.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @access 	public
	 * @param 	mixed 	$action 	Scalar value to add context to the nonce.
	 * @return 	string 	The generated token.
	 */
	public function create_nonce($action = -1)
	{
		// Prepare an instance of CI object.
		$CI =& get_instance();

		// Get the current user's ID.
		$uid = (false !== $user = $CI->auth->user()) 
			? $user->id
			: apply_filters('nonce_user_logged_out', 0, $action);

		// Make sure to get the current user session's ID.
		(class_exists('CI_Session', false)) OR $CI->load->library('session');
		$token = session_id();
		$tick  = $this->nonce_tick();

		return substr($this->_nonce_hash($tick.'|'.$action.'|'.$uid.'|'.$token), -12, 10);
	}

	// ------------------------------------------------------------------------

	/**
	 * verify_nonce
	 *
	 * Method for verifying that a correct nonce was used with time limit.
	 * The user is given an amount of time to use the token, so therefore, since
	 * the UID and $action remain the same, the independent variable is time.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @access 	public
	 * @param 	string 	$nonce 		The nonce that was used in the action.
	 * @param 	mixed 	$action 	The action for which the nonce was created.
	 * @return 	bool 	returns true if the token is valid, else false.
	 */
	public function verify_nonce($nonce, $action = -1)
	{
		// Prepare an instance of CI object.
		$CI =& get_instance();

		// Get the current user's ID.
		$uid = (false !== $user = $CI->auth->user()) 
			? $user->id
			: apply_filters('nonce_user_logged_out', 0, $action);

		// No nonce provided? Nothing to do.
		if (empty($nonce))
		{
			return false;
		}

		// Make sure to get the current user session's ID.
		(class_exists('CI_Session', false)) OR $CI->load->library('session');
		$token = session_id();
		$tick  = $this->nonce_tick();

		// Prepare the expected hash and make sure it equals to nonce.
		$expected = substr($this->_nonce_hash($tick.'|'.$action.'|'.$uid.'|'.$token), -12, 10);
		return ($expected === $nonce);
	}

	// ------------------------------------------------------------------------

	/**
	 * nonce_tick
	 *
	 * Method for getting the time-dependent variable used for nonce creation.
	 * A nonce has a lifespan of two ticks, it may be updated in its second tick.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	float 	Float value rounded up to the next highest integer.
	 */
	public function nonce_tick()
	{
		$nonce_life = apply_filters('nonce_life', DAY_IN_SECONDS);
		return ceil(time() / ($nonce_life / 2));
	}

	// ------------------------------------------------------------------------

	/**
	 * _nonce_hash
	 *
	 * Method for hashing the given string and return the nonce.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @access 	protected
	 * @param 	string
	 * @return 	string
	 */
	protected function _nonce_hash($string)
	{
		// We make sure to use the encryption key provided.
		$salt = config_item('encryption_key');
		(empty($salt)) && $salt = 'CoDEiGniTrR SkELetON nOnCe SaLt';
		return hash_hmac('md5', $string, $salt);
	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('sanitize'))
{
	/**
	 * sanitize
	 *
	 * Function for sanitizing a string.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @param 	string 	$string 	The string to sanitize.
	 * @return 	string 	The string after being sanitized.
	 */
	function sanitize($string)
	{
		// Make sure required functions are available.
		$CI =& get_instance();
		(function_exists('strip_slashes')) OR $CI->load->helper('string');
		(function_exists('xss_clean')) OR $CI->load->helper('security');

		// Sanitize the string.
		return xss_clean(htmlentities(strip_slashes($string), ENT_QUOTES, 'UTF-8'));
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('create_nonce'))
{
	/**
	 * create_nonce
	 *
	 * Helper that uses KB_Security::create_nonce made available to be
	 * used with directly using the class method.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @param 	mixed
	 * @return 	string
	 */
	function create_nonce($action = -1)
	{
		return get_instance()->security->create_nonce($action);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('verify_nonce'))
{
	/**
	 * verify_nonce
	 *
	 * Function that uses KB_Security::verify_nonce.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @param 	string
	 * @param 	mixed
	 * @return 	bool
	 */
	function verify_nonce($nonce, $action = 1)
	{
		return get_instance()->security->verify_nonce($nonce, $action);
	}
}

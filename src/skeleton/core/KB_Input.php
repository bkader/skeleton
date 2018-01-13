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
 * KB_Input Class
 *
 * This class extends CI_Input class in order to add some useful methods.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */
class KB_Input extends CI_Input
{
	/**
	 * Fetch an item from the REQUEST array
	 * @param	mixed	$index		Index for item to be fetched from $_GET
	 * @param	bool	$xss_clean	Whether to apply XSS filtering
	 * @return	mixed
	 */
	public function request($index = null, $xss_clean = null)
	{
		return $this->_fetch_from_array($_REQUEST, $index, $xss_clean);
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the protocol that the request was made with.
	 * @access 	public
	 * @return 	string
	 */
	public function protocol()
	{
		if ($this->server('HTTPS') == 'on' OR
			$this->server('HTTPS') == 1 OR
			$this->server('SERVER_PORT') == 443)
		{
			return 'https';
		}

		return 'http';
	}

	// ------------------------------------------------------------------------

	/**
	 * Return the referrer.
	 * @access 	public
	 * @param 	string 	$default 	What to return if no referrer is found.
	 * @param 	bool 	$xss_clean 	Whether to apply XSS filtering
	 * @return 	string
	 */
	public function referrer($default = '', $xss_clean = NULL)
	{
		$referrer = $this->server('HTTP_REFERER', $xss_clean);
		return ($referrer) ? $referrer : $default;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the query string.
	 * @access 	public
	 * @param 	string 	$default 	What to return if nothing found.
	 * @param 	bool 	$xss_clean 	Whether to apply XSS filtering
	 * @return 	string
	 */
	public function query_string($default = '', $xss_clean = null)
	{
		$query_string = $this->server('QUERY_STRING', $xss_clean);
		return ($query_string) ? $query_string : $default;
	}

}

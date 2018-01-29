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
 * KB_security_helper
 *
 * Extending and overriding some of CodeIgniter security function.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Helpers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */

if ( ! function_exists('sanitize'))
{
    /**
     * Sanitize text
     * @param   string
     * @return  string
     */
    function sanitize($str)
    {
        $CI =& get_instance();
        $CI->load->helper('string');
        $str = strip_slashes($str);
        return xss_clean(htmlentities($str, ENT_QUOTES, 'UTF-8'));
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('generate_safe_token'))
{
	/**
	 * Generate Safe Token
	 *
	 * @param 	int 	$time   unix_timestamp
	 * @param 	string 	$key 	encryption key
	 * @return 	string
	 */
	function generate_safe_token($time = false, $key = null)
	{
		($time) OR $time = time();
		($key) OR $key = get_instance()->config->item('encryption_key');

		return md5($time . $key . session_id());
	}
}

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
 * @since 		2.2.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter SSL Hook
 *
 * This hook will automatically redirect to the HTTPS version of your website
 * and set the appropriate headers.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Hooks
 * @author 		Mehdi Bounya
 * @link 		https://github.com/mehdibo/Codeigniter-SSLHook
 * @copyright 	Copyright (c) 2018, Mehdi Bounya (https://github.com/mehdibo)
 * @since 		2.2.0
 * @version 	2.2.0
 */
if ( ! function_exists('skeleton_ssl_hook'))
{
	/**
	 * Appropriate headers and redirection for SSL websites.
	 * @param 	none
	 * @return 	void
	 */
	function skeleton_ssl_hook()
	{
		// Check whether to base URL starts with HTTPS.
		if (substr(base_url(), 0, 5) !== 'https')
		{
			return;
		}

		// Make sure both "is_https" and "is_cli" functions exist.
		if ( ! function_exists('is_https') OR ! function_exists('is_cli'))
		{
			return;
		}

		// We are not using HTTPS or in a CLI?
		if ( ! is_https() OR is_cli())
		{
			redirect(site_url(uri_string()));
			exit;
		}

		$CI =& get_instance();

		// We only allow HTTPS cookies (no JS).
		$CI->config->set_item('cookie_secure', true);
		$CI->config->set_item('cookie_httponly', true);

		$CI->output

			// Force future requests to be over HTTPS (max-age is set to 1 month.
			->set_header('Strict-Transport-Security: max-age=2629800')
			
			// Disable MIME type sniffing.
			->set_header('X-Content-Type-Options: nosniff')
			
			// Only allow referrers to be sent withing the website.
			->set_header('Referrer-Policy: strict-origin')
			
			// Frames are not allowed.
			->set_header('X-Frame-Options: DENY')
			
			// Enable XSS protection in browser
			->set_header('X-XSS-Protection: 1; mode=block');
	}
}

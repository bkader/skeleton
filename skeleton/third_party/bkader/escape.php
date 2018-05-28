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

if ( ! function_exists('esc_url')) {
	/**
	 * esc_url
	 *
	 * Removes certain characters from URL.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @see 	http://uk1.php.net/manual/en/function.urlencode.php#97969
	 *
	 * @param 	string
	 * @return 	string
	 */
	function esc_url($url) {
		$search  = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
		$replace = array('!', '*', "'", '(', ')', ';', ':', '@', '&', '=', '+', '$', ',', '/', '?', '%', '#', '[', ']');
		return _deep_replace($search, $replace, $url);
	}
}

if ( ! function_exists('esc_js')) {
	/**
	 * esc_js
	 *
	 * Function for escaping string for echoing in JS. It is intended to be used for
	 * inline JS (in a tag attribute, onclick="..." for instance).
	 * Strings must be in single quotes.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	string 	$string
	 * @return 	string
	 */
	function esc_js($string) {
		$safe = convert_invalid_utf8($string);
		$safe = deep_htmlentities($safe, ENT_COMPAT);
		$safe = preg_replace('/&#(x)?0*(?(1)27|39);?/i', "'", stripslashes($safe));
		$safe = str_replace("\r", '', $safe);
		$safe = str_replace("\n", '\\n', addslashes($safe));
		return apply_filters('esc_js', $safe, $text, $string);
	}
}

if ( ! function_exists('esc_html')) {
	/**
	 * esc_html
	 *
	 * Escapes HTML from the given string.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	string 	$string
	 * @return 	string
	 */
	function esc_html($string) {
		$safe = convert_invalid_utf8($string);
		$safe = deep_htmlentities($safe, ENT_QUOTES);
		return apply_filters('esc_html', $safe, $string);
	}
}

if ( ! function_exists('esc_attr')) {
	/**
	 * esc_attr
	 *
	 * Function to escaping HTML attributes.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	string 	$string
	 * @return 	string
	 */
	function esc_attr($string) {
		$safe = convert_invalid_utf8($string);
		$safe = deep_htmlentities($safe, ENT_QUOTES);
		return apply_filters('esc_attr', $safe, $string);
	}
}

if ( ! function_exists('esc_textarea')) {
	/**
	 * esc_textarea
	 *
	 * Escaping for textarea values.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	string 	$text
	 * @return 	string
	 */
	function esc_textarea($text) {
		$safe = deep_htmlentities($text, ENT_QUOTES);
		return apply_filters('esc_textarea', $safe, $text);
	}
}

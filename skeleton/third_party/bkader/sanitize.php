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

if ( ! function_exists('sanitize_key')) {
	/**
	 * sanitize_key
	 *
	 * Sanitizes a string for using as internal identifiers.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	string 
	 * @return 	string
	 */
	function sanitize_key($key) {
		$key = strtolower(convert_accents($key));
		$key = preg_replace('/[^a-z0-9_\-]/', '', $key);
		return apply_filters('sanitize_key', $key);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('sanitize_text_field')) {
	function sanitize_text_field($string) {
		$filtered = _sanitize_text_fields($string, false);
		return apply_filters('sanitize_text_field', $filtered, $string);
	}
}
// ------------------------------------------------------------------------

if ( ! function_exists('sanitize_textarea_field')) {
	function sanitize_textarea_field($string) {
		$filtered = _sanitize_text_fields($string, true);
		return apply_filters('sanitize_textarea_field', $filtered, $string);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_sanitize_text_fields')) {
	/**
	 * _sanitize_text_fields
	 *
	 * Internal helper function used to sanitize a string from user
	 * input or from the database.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	string 	$str 			The string to sanitize.
	 * @param 	bool 	$keep_newlines 	Whether to keep newline.
	 * @return 	string
	 */
	function _sanitize_text_fields($str, $keep_newlines = false) {
		$filtered = convert_invalid_utf8($str);

		if (false !== strpos($filtered, '<')) {
			$filtered = strip_all_tags($filtered);
			$filtered = str_replace("<\n", "&lt;\n", $filtered);
		}

		if ( ! $keep_newlines) {
			$filtered = preg_replace('/[\r\n\t ]+/', ' ', $filtered);
		}

		$filtered = trim($filtered);

		$found = false;
		$preg  = preg_match('/%[a-f0-9]{2}/i', $filtered, $match);

		while (preg_match('/%[a-f0-9]{2}/i', $filtered, $match)) {
			$filtered = str_replace($match[0], '', $filtered);
			$found = true;
		}

		$found && $filtered = trim(preg_replace('/ +/', ' ', $filtered));

		return $filtered;
	}
}

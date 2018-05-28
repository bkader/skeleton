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
 * @since 		Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KB_string_helper
 *
 * Extending and overriding some of CodeIgniter string function.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Helpers
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */

if ( ! function_exists('readable_random_string'))
{
	/**
	 * Generates a human readable random string
	 *
	 * @param   integer
	 * @param   boolean
	 * @return  string
	 */
	function readable_random_string($length = 6, $camelize = FALSE)
	{
		$conso  = array("b","c","d","f","g","h","j","k","l","m","n","p","r","s","t","v","w","x","y","z");
		$vocal  = array("a","e","i","o","u");
		$string = "";

		srand ((double)microtime()*1000000);

		$max = $length / 2;
		for($i = 1; $i <= $max; $i++)
		{
			$string .=$conso[rand(0,19)];
			$string .=$vocal[rand(0,4)];
		}
		return ($camelize) ? ucwords($string) : $string;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('mask_string'))
{
	/**
	 * Masks a string with a give char
	 *
	 * @param   string
	 * @param   integer
	 * @param   integer
	 * @param   string
	 * @return  string
	 */
	function mask_string($str = NULL, $start = 3, $end = 3, $mask = '*')
	{
		// Prepare the length of the string
		$length = strlen($str);

		// We then prepare the array that will holds all of chars
		$chars = array();

		foreach(str_split($str) as $index => $char)
		{
			if ($char === ' ')
			{
				$chars[$index] = ' ';
			}
			else
			{
				$chars[$index] = ($index <= ($start - 1) or $index >= ($length - $end))
									? $char : $mask;
			}
			//$chars[$index] = ($char === ' ') ? ' ' : $mask;
		}
		return implode('', $chars);
	}
}

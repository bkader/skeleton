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
 * @link 		https://goo.gl/wGXHO9
 * @since 		Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Functions in this file handles elements php serialization.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Helpers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */

if ( ! function_exists('is_serialized'))
{
    /**
     * Check value to find if it was serialized.
     * @param   string  $str    value to check if serialized
     * @param   bool  $string 	whether to be strict about the end of $str.
     * @author  Kader Bouyakoub <bkader@mail.com>
     * @link    https://goo.gl/wGXHO9
     * @return  boolean
     */
    function is_serialized($str, $strict = true)
    {
		// if it isn't a string, it isn't serialized.
		if ( ! is_string($str))
		{
			return false;
		}

		$str = trim( $str);
	 	if ('N;' == $str)
	 	{
			return true;
		}

		if (strlen($str) < 4)
		{
			return false;
		}
		if (':' !== $str[1])
		{
			return false;
		}

		if ($strict)
		{
			$lastc = substr($str, -1);

			if (';' !== $lastc && '}' !== $lastc)
			{
				return false;
			}
		}
		else
		{
			$semicolon = strpos($str, ';');
			$brace     = strpos($str, '}');

			// Either ; or } must exist.
			if (false === $semicolon && false === $brace)
			{
				return false;
			}

			// But neither must be in the first X characters.
			if (false !== $semicolon && $semicolon < 3)
			{
				return false;
			}

			if (false !== $brace && $brace < 4)
			{
				return false;
			}
		}

		$token = $str[0];

		switch ($token)
		{
			case 's' :
				if ($strict)
				{
					if ('"' !== substr($str, -2, 1))
					{
						return false;
					}
				}
				elseif (false === strpos($str, '"'))
				{
					return false;
				}
				// or else fall through

			case 'a' :
			case 'O' :
				return (bool) preg_match("/^{$token}:[0-9]+:/s", $str);
			case 'b' :
			case 'i' :
			case 'd' :
				$end = $strict ? '$' : '';
				return (bool) preg_match("/^{$token}:[0-9.E-]+;$end/", $str);
		}

		return false;
    }
}

// --------------------------------------------------------------------

if ( ! function_exists('maybe_serialize'))
{
    /**
     * Turns arrays and objects only into serialized string
     * @param   mixed   $str
     * @author  Kader Bouyakoub <bkader@mail.com>
     * @link    https://goo.gl/wGXHO9
     * @return  string
     */
    function maybe_serialize($arg = null)
    {
        return (is_array($arg) OR is_object($arg)) ? serialize($arg) : $arg;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('maybe_unserialize'))
{
    /**
     * Turns a serialized string into its nature
     * @param   string  $str    the string to return
     * @author  Kader Bouyakoub <bkader@mail.com>
     * @link    https://goo.gl/wGXHO9
     * @return  mixed
     */
    function maybe_unserialize($str)
    {
        return is_serialized($str) ? unserialize($str) : $str;
    }
}

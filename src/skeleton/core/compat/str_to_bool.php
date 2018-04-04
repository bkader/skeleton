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
 * Functions in this files handles boolean to string representation
 * and vice versa.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Helpers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */

if ( ! function_exists('str_to_bool'))
{
    /**
     * Coverts a string boolean representation to a true boolean
     * @access  public
     * @param   string
     * @param   boolean
     * @author  Kader Bouyakoub <bkader@mail.com>
     * @link    https://github.com/bkader
     * @return  boolean
     */
    function str_to_bool($str, $strict = false)
    {
        // If no string is provided, we return 'false'
        if (empty($str))
        {
            return false;
        }

        // If the string is already a boolean, no need to convert it
        if (is_bool($str))
        {
            return $str;
        }

        $str = strtolower(@(string) $str);

        if (in_array($str, array('no', 'n', 'false', 'off')))
        {
            return false;
        }

        if ($strict)
        {
            return in_array($str, array('yes', 'y', 'true', 'on'));
        }

        return true;
    }
}

// --------------------------------------------------------------------

if ( ! function_exists('is_str_to_bool'))
{
    /**
     * Checks whether a given value can be a strict string
     * representation or a true boolean
     * @access  public
     * @param   string
     * @param   boolean
     * @author  Kader Bouyakoub <bkader@mail.com>
     * @link    https://github.com/bkader
     * @return  boolean
     */
    function is_str_to_bool($str, $strict = false)
    {
        if ($strict === false)
        {
            $str_test = @(string) $str;

            if (is_numeric($str_test))
            {
                return true;
            }
        }

        return (!str_to_bool($str) or str_to_bool($str, true));
    }
}

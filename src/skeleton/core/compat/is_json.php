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
 * Functions in this file handle JSON conversions.
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

if ( ! function_exists('is_json'))
{
    /**
     * Checks whether a string is a json_encoded
     * @param   string  $str
     * @author  Kader Bouyakoub <bkader@mail.com>
     * @link    https://github.com/bkader
     * @return  boolean
     */
    function is_json($str)
    {
        json_decode($str);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}

// --------------------------------------------------------------------

if ( ! function_exists('maybe_json_encode'))
{
    /**
     * Turns arrays and objects into json encoded strings
     * @param   mixed   $arg
     * @author  Kader Bouyakoub <bkader@mail.com>
     * @link    https://github.com/bkader
     * @return  string
     */
    function maybe_json_encode($arg = null)
    {
        return (is_array($arg) OR is_object($arg)) ? json_encode($arg) : $arg;
    }
}

// --------------------------------------------------------------------

if ( ! function_exists('maybe_json_decode'))
{
    /**
     * Turns a json encoded string into its true nature
     * @param   string  $str
     * @author  Kader Bouyakoub <bkader@mail.com>
     * @link    https://github.com/bkader
     * @return  array
     */
    function maybe_json_decode($str)
    {
        return (is_json($str)) ? json_decode($str) : $str;
    }
}

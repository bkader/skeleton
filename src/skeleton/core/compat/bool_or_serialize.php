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
 * Functions in this file use both "str_to_bool.php" and 
 * "is_serialized.php" functions to format arguments.
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

if ( ! function_exists('to_bool_or_serialize'))
{
    /**
     * Checks the string and turn it into a string
     * representation of a boolean if it is one, or
     * serialize it in case of an array or object, or
     * simply return in as it if it's neither a boolean
     * nor an array or object.
     * @param   mixed   $str
     * @author  Kader Bouyakoub <bkader@mail.com>
     * @link    https://github.com/bkader
     * @return  string  the $str after being converted.
     */
    function to_bool_or_serialize($str)
    {
        if (is_bool($str))
        {
            $str = ($str === true) ? 'true' : 'false';
        }
        else
        {
            $str = maybe_serialize($str);
        }

        return $str;
    }
}

// --------------------------------------------------------------------

if ( ! function_exists('from_bool_or_serialize'))
{
    /**
     * Takes a string as an arguments and checks if
     * it is a string representation of a boolean, then
     * returns the equivalent boolean, OR if is a
     * previously serialized array or object and return
     * it as it was before.
     * @param   string   $str
     * @author  Kader Bouyakoub <bkader@mail.com>
     * @link    https://github.com/bkader
     * @return  mixed   depends on the $str.
     */
    function from_bool_or_serialize($str)
    {
        return (is_str_to_bool($str, true))
            ? str_to_bool($str)
            : maybe_unserialize($str);
    }
}

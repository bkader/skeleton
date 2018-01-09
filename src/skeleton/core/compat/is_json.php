<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * JSOn Helpers.
 *
 * @package 	CodeIgniter
 * @category 	Helpers
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
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


/* End of file is_json.php */
/* Location: ./system/core/compat/is_json.php */

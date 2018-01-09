<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Boolean and Serialization Helpers
 *
 * @package 	CodeIgniter
 * @category 	Helpers
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
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

/* End of file bool_or_serialize.php */
/* Location: ./system/core/compat/bool_or_serialize.php */

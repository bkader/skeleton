<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Boolean to String representation and vice versa
 *
 * @package 	CodeIgniter
 * @category 	Helpers
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
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


/* End of file str_to_bool.php */
/* Location: ./system/core/compat/str_to_bool.php */

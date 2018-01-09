<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Serialization Helpers
 *
 * @package 	CodeIgniter
 * @category 	Helpers
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */

if ( ! function_exists('is_serialized'))
{
    /**
     * Check value to find if it was serialized.
     * @param   string  $str    value to check if serialized
     * @param   bool  $string 	whether to be strict about the end of $str.
     * @author  Kader Bouyakoub <bkader@mail.com>
     * @link    https://github.com/bkader
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
     * @link    https://github.com/bkader
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
     * @link    https://github.com/bkader
     * @return  mixed
     */
    function maybe_unserialize($str)
    {
        return is_serialized($str) ? unserialize($str) : $str;
    }
}


/* End of file is_serialized.php */
/* Location: ./system/core/compat/is_serialized.php */

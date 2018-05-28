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

// ------------------------------------------------------------------------
// String format checkers.
// ------------------------------------------------------------------------

if ( ! function_exists('is_xml')) {
	/**
	 * is_xml
	 *
	 * Checks whether the given string is a valid XML.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	string
	 * @return 	bool
	 * @throws 	Exception.
	 */
	function is_xml($string) {
		if ( ! defined('LIBXML_COMPACT')) {
			throw new Exception("libxml is required to use is_xml() function.");
		}

		$errors = libxml_use_internal_errors();
		libxml_use_internal_errors(true);
		$result = simplexml_load_string($string) !== false;
		libxml_use_internal_errors($errors);

		return $result;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('is_html')) {
	/**
	 * is_html
	 *
	 * Checks whether the given string is HTML.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 * 
	 * @param 	string
	 * @return 	bool
	 */
	function is_html($string) {
		return strlen(strip_tags($string)) < strlen($string);
	}
}

// ------------------------------------------------------------------------
// JSON checker/encode/decode function.
// ------------------------------------------------------------------------

if ( ! function_exists('is_json')) {
	/**
	 * is_json
	 *
	 * Checks if the given string is JSON encoded.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.0.0
	 *
	 * @param 	string
	 * @return 	bool
	 */
	function is_json($string) {
		if (is_string($string)) {
			json_decode($string);
			return (json_last_error() === JSON_ERROR_NONE);
		}

		return false;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('maybe_json_encode'))
{
	/**
	 * Turns arrays and objects into json encoded strings
	 * @param   mixed   $value
	 * @author  Kader Bouyakoub <bkader[at]mail[dot]com>
	 * @link    https://goo.gl/wGXHO9
	 * @return  string
	 */
	function maybe_json_encode($value, $options = 0, $depth = 512) {
		if (is_array($value) OR is_object($value)) {
			$value = json_encode($value, $options, $depth);
		}

		return $value;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('maybe_json_decode'))
{
	/**
	 * Turns a json encoded string into its true nature
	 * @param   string  $json
	 * @author  Kader Bouyakoub <bkader[at]mail[dot]com>
	 * @link    https://goo.gl/wGXHO9
	 * @return  array
	 */
	function maybe_json_decode($json, $assoc = false, $depth = 512, $options = 0) {
		is_json($json) && $json = json_decode($json, $assoc, $depth, $options);
		return $json;
	}
}

// ------------------------------------------------------------------------
// PHP check serialized, serialize and unserialize.
// ------------------------------------------------------------------------

if ( ! function_exists('is_serialized')) {
	/**
	 * is_serialized
	 *
	 * Checks whether the given string is a serialized.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.0.0
	 *
	 * @param 	string
	 * @return 	bool
	 */
	function is_serialized($string) {
		$array = @unserialize($string);
		return ! ($array === false and $string !== 'b:0;');
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('maybe_serialize')) {
	/**
	 * maybe_serialize
	 *
	 * Turns Array an Objects into serialized strings;
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.0.0
	 *
	 * @param 	mixed 	$value
	 * @return 	string
	 */
    function maybe_serialize($value) {
    	(is_array($value) OR is_object($value)) && $value = serialize($value);
    	return $value;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('maybe_unserialize')) {
	/**
	 * maybe_unserialize
	 *
	 * Turns a serialized string into its nature.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.0.0
	 *
	 * @param 	string 	$string
	 * @return 	mixed
	 */
    function maybe_unserialize($string) {
    	is_serialized($string) && $string = unserialize($string);
    	return $string;
    }
}

// ------------------------------------------------------------------------
// Boolean string representations.
// ------------------------------------------------------------------------

if ( ! function_exists('str2bool')) {
	/**
	 * Coverts a string boolean representation to a true boolean
	 * @access  public
	 * @param   string
	 * @param   boolean
	 * @author  Kader Bouyakoub <bkader[at]mail[dot]com>
	 * @link    https://goo.gl/wGXHO9
	 * @return  boolean
	 */
	function str2bool($str, $strict = false) {
		// If no string is provided, we return 'false'
		if (empty($str)) {
			return false;
		}

		// If the string is already a boolean, no need to convert it
		if (is_bool($str)) {
			return $str;
		}

		$str = strtolower( @(string) $str);

		if (in_array($str, array('no', 'n', 'false', 'off'))) {
			return false;
		}

		if ($strict) {
			return in_array($str, array('yes', 'y', 'true', 'on'));
		}

		return true;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('str_to_bool')) {
	/**
	 * str2bool function wrapper. Kept for backward-compatibility.
	 */
	function str_to_bool($str, $strict = false) {
		return str2bool($str, $strict);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('is_str2bool')) {
	/**
	 * is_str2bool
	 *
	 * Function for checking whether the given string is a string
	 * representation of a boolean.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	string 	$str
	 * @param 	bool 	$string
	 * @return 	bool
	 */
	function is_str2bool($str, $strict = false)
	{
		if ($strict === false) {
			$str_test = @(string) $str;

			if (is_numeric($str_test)) {
				return true;
			}
		}

		return (!str2bool($str) OR str2bool($str, true));
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('is_str_to_bool')) {
	/**
	 * Wrapper of the "is_str2bool" function.
	 */
	function is_str_to_bool($str, $strict = false) {
		return is_str2bool($str, $strict);
	}
}

// ------------------------------------------------------------------------
// Value preparation before inserting and after getting from database.
// ------------------------------------------------------------------------

if ( ! function_exists('to_bool_or_serialize')) {
	/**
	 * Takes any type of arguments and turns it into its string
	 * representations before inserting into databases.
	 * @param 	mixed 	$value
	 * @return 	string 	the string representation of "$value".
	 */
	function to_bool_or_serialize($value) {
		$value = (is_bool($value))
			? (true === $value ? 'true' : 'false')
			: maybe_serialize($value);
		return $value;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('from_bool_or_serialize')) {
	/**
	 * Takes any type of data retrieved from database and turns it into
	 * it's original data type.
	 * @param 	string 	$str
	 * @return 	mixed
	 */
	function from_bool_or_serialize($string) {
		return is_str2bool($string, true)
			? str2bool($string)
			: maybe_unserialize($string);
	}
}

// ------------------------------------------------------------------------
// Sanitization functions.
// ------------------------------------------------------------------------

if ( ! function_exists('deep_specialchars')) {
	function deep_specialchars($string, $flags = ENT_NOQUOTES, $encoding = null, $double_encode = false) {
		if ( ! is_array($string)) {
			$string = (string) $string;

			if (0 === strlen($string)) {
				return '';
			}
			
			// Don't bother if there are no specialchars - saves some processing
			if ( ! preg_match('/[&<>"\']/', $string)) {
				return $string;
			}

			if (empty($flags)) {
				$flags = ENT_NOQUOTES;
			} elseif ( ! in_array($flags, array(0, 2, 3, 'single', 'double'), true)) {
				$flags = ENT_NOQUOTES;
			}

			if (empty($encoding)) {
				static $_encoding = null;
				if ( ! isset($_encoding)) {
					$_encoding = config_item('charset') ?: 'UTF-8';
				}
				$encoding = $_encoding;
			}

			if (in_array($encoding, array('utf8', 'utf-8', 'UTF8', 'UTF-8'))) {
				$encoding = 'UTF-8';
			}

			$_flags  = $flags;

			if ($flags === 'double') {
				$flags = ENT_COMPAT;
				$_flgas = ENT_COMPAT;
			} elseif ($flags === 'single') {
				$flags = ENT_NOQUOTES;
			}

			$double_encode && $string = kses_normalize_entities($string);

			$string = htmlspecialchars($string, $flags, $encoding, $double_encode);

			if ('single' === $_flags) {
				$string = str_replace("'", '&#039;', $string);
			}

			return $string;
		}

		foreach ($string as $key => $val) {
			$string[$key] = deep_specialchars($val, $flags, $encoding, $double_encode);
		}

		return $string;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_deep_replace')) {
	/**
	 * Performs a deep string replace operation to ensure the values in
	 * $search are replace with values from $replace
	 * @param 	mixed 	$search
	 * @param 	mixed 	$replace
	 * @param 	mixed 	$subject 	String for single item, or array.
	 * @return 	mixed 
	 */
	function _deep_replace($search, $replace = '', $subject) {
		if ( ! is_array($subject)) {
			$subject = (string) $subject;
			$count = 1;
			while($count) {
				$subject = str_replace($search, $replace, $subject, $count);
			}

			return $subject;
		}

		foreach ($subject as $key => $val) {
			$subject[$key] = _deep_replace($search, $replace, $val);
		}

		return $subject;
	}
}

if ( ! function_exists('e')) {
	/**
	 * Encodes the given string using the deep_htmlentities function.
	 *
	 * @since 	2.0.0
	 *
	 * @param 	mixed 	$string
	 * @return 	mixed
	 */
	function e($string) {
		return function_exists('deep_htmlentities')
			? deep_htmlentities($string)
			: htmlentities($string, ENT_QUOTES, 'UTF-8');
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('deep_htmlentities')) {
	/**
	 * Function for using "htmlentities" on anything.
	 *
	 * @since 	2.0.0
	 *
	 * @param 	mixed 	$value
	 * @param 	int 	$flags
	 * @param 	string 	$encoding
	 * @param 	bool 	$double_encode
	 * @return 	string
	 */
	function deep_htmlentities($value, $flags = null, $encoding = null, $double_encode = null) {
		static $cached = array();

		(null === $flags) && $flags = ENT_QUOTES;
		(null === $encoding) && $encoding = 'UTF-8';
		(null === $double_encode) && $double_encode = false;

		if ( ! is_array($value)) {
			if ( ! isset($cached[$value])) {
				$cached[$value] = htmlentities($value, $flags, $encoding, $double_encode);
			}

			return $cached[$value];
		}

		foreach ($value as $key => $val) {
			$value[$key] = deep_htmlentities($val, $flags, $encoding, $double_encode);
		}

		return $value;
	}
}



// ------------------------------------------------------------------------

if ( ! function_exists('deep_addslashes')) {
	/**
	 * Quote string with slashes
	 *
	 * @since 	2.0.0
	 *
	 * @param 	mixed 	$value
	 * @return 	mixed
	 */
	function deep_addslashes($value) {
		return _deep_map($value, 'addslashes');
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('deep_xss_clean')) {
	/**
	 * Custom XSS clean function that uses htmLawed.
	 *
	 * @since 	2.0.0
	 * @see 	http://www.bioinformatics.org/phplabware/internal_utilities/htmLawed/
	 *
	 * @param 	mixed 	$value
	 * @param 	array 	$options
	 * @return 	mixed
	 */
	function deep_xss_clean($value, array $options = array()) {
		if ( ! is_array($value)) {
			if ( ! function_exists('htmLawed')) {
				import('htmLawed/htmLawed', 'third_party');
			}

			$options = array_merge(array(
				'safe'     => 1,
				'balanced' => 0,
			), $options);

			return htmLawed($value, $options);
		}

		foreach ($value as $key => $val) {
			$value[$key] = deep_xss_clean($val, $options);
		}

		return $value;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('deep_strip_tags')) {
	/**
	 * Function for striping tags of string with recursive action on arrays.
	 *
	 * @since 	2.0.0
	 *
	 * @param 	mixed 	$value
	 * @return 	mixed
	 */
	function deep_strip_tags($value) {
		if ( ! is_array($value)) {
			return filter_var($value, FILTER_SANITIZE_STRING);
		}

		foreach ($value as $key => $val) {
			$value[$key] = deep_strip_tags($val);
		}
		
		return $value;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('strip_all_tags')) {
	/**
	 * strip_all_tags
	 *
	 * Properly strip all HTML tags including script and style.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	string 	$string 	The string containing HTML.
	 * @param 	bool 	$breaks 	Whether to remove left over line breaks.
	 * @return 	string
	 */
	function strip_all_tags($string, $breaks = false) {
		$string = preg_replace('@<(script|style)[^>]*?>.*?</\\1>@si', '', $string);
		$string = strip_tags($string);

		$breaks && $string = preg_replace('/[\r\n\t ]+/', ' ', $string);
		return trim($string);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('convert_accents')) {
	/**
	 * Just like CodeIgniter "convert_accented_characters" function.
	 * 
	 * @since 	2.0.0
	 *
	 * @param 	string 	$str 	input string.
	 * @return 	string
	 */
	function convert_accents($str) {
		static $foreign_chars, $chars_from, $chars_to;

		if (empty($foreign_chars)) {
			$foreign_characters = array(
				'/ä|æ|ǽ/' => 'ae',
				'/ö|œ/' => 'oe',
				'/ü/' => 'ue',
				'/Ä/' => 'Ae',
				'/Ü/' => 'Ue',
				'/Ö/' => 'Oe',
				'/À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ|Α|Ά|Ả|Ạ|Ầ|Ẫ|Ẩ|Ậ|Ằ|Ắ|Ẵ|Ẳ|Ặ|А/' => 'A',
				'/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª|α|ά|ả|ạ|ầ|ấ|ẫ|ẩ|ậ|ằ|ắ|ẵ|ẳ|ặ|а/' => 'a',
				'/Б/' => 'B',
				'/б/' => 'b',
				'/Ç|Ć|Ĉ|Ċ|Č/' => 'C',
				'/ç|ć|ĉ|ċ|č/' => 'c',
				'/Д/' => 'D',
				'/д/' => 'd',
				'/Ð|Ď|Đ|Δ/' => 'Dj',
				'/ð|ď|đ|δ/' => 'dj',
				'/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě|Ε|Έ|Ẽ|Ẻ|Ẹ|Ề|Ế|Ễ|Ể|Ệ|Е|Э/' => 'E',
				'/è|é|ê|ë|ē|ĕ|ė|ę|ě|έ|ε|ẽ|ẻ|ẹ|ề|ế|ễ|ể|ệ|е|э/' => 'e',
				'/Ф/' => 'F',
				'/ф/' => 'f',
				'/Ĝ|Ğ|Ġ|Ģ|Γ|Г|Ґ/' => 'G',
				'/ĝ|ğ|ġ|ģ|γ|г|ґ/' => 'g',
				'/Ĥ|Ħ/' => 'H',
				'/ĥ|ħ/' => 'h',
				'/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ|Η|Ή|Ί|Ι|Ϊ|Ỉ|Ị|И|Ы/' => 'I',
				'/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı|η|ή|ί|ι|ϊ|ỉ|ị|и|ы|ї/' => 'i',
				'/Ĵ/' => 'J',
				'/ĵ/' => 'j',
				'/Ķ|Κ|К/' => 'K',
				'/ķ|κ|к/' => 'k',
				'/Ĺ|Ļ|Ľ|Ŀ|Ł|Λ|Л/' => 'L',
				'/ĺ|ļ|ľ|ŀ|ł|λ|л/' => 'l',
				'/М/' => 'M',
				'/м/' => 'm',
				'/Ñ|Ń|Ņ|Ň|Ν|Н/' => 'N',
				'/ñ|ń|ņ|ň|ŉ|ν|н/' => 'n',
				'/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ|Ο|Ό|Ω|Ώ|Ỏ|Ọ|Ồ|Ố|Ỗ|Ổ|Ộ|Ờ|Ớ|Ỡ|Ở|Ợ|О/' => 'O',
				'/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º|ο|ό|ω|ώ|ỏ|ọ|ồ|ố|ỗ|ổ|ộ|ờ|ớ|ỡ|ở|ợ|о/' => 'o',
				'/П/' => 'P',
				'/п/' => 'p',
				'/Ŕ|Ŗ|Ř|Ρ|Р/' => 'R',
				'/ŕ|ŗ|ř|ρ|р/' => 'r',
				'/Ś|Ŝ|Ş|Ș|Š|Σ|С/' => 'S',
				'/ś|ŝ|ş|ș|š|ſ|σ|ς|с/' => 's',
				'/Ț|Ţ|Ť|Ŧ|τ|Т/' => 'T',
				'/ț|ţ|ť|ŧ|т/' => 't',
				'/Þ|þ/' => 'th',
				'/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ|Ũ|Ủ|Ụ|Ừ|Ứ|Ữ|Ử|Ự|У/' => 'U',
				'/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ|υ|ύ|ϋ|ủ|ụ|ừ|ứ|ữ|ử|ự|у/' => 'u',
				'/Ƴ|Ɏ|Ỵ|Ẏ|Ӳ|Ӯ|Ў|Ý|Ÿ|Ŷ|Υ|Ύ|Ϋ|Ỳ|Ỹ|Ỷ|Ỵ|Й/' => 'Y',
				'/ẙ|ʏ|ƴ|ɏ|ỵ|ẏ|ӳ|ӯ|ў|ý|ÿ|ŷ|ỳ|ỹ|ỷ|ỵ|й/' => 'y',
				'/В/' => 'V',
				'/в/' => 'v',
				'/Ŵ/' => 'W',
				'/ŵ/' => 'w',
				'/Ź|Ż|Ž|Ζ|З/' => 'Z',
				'/ź|ż|ž|ζ|з/' => 'z',
				'/Æ|Ǽ/' => 'AE',
				'/ß/' => 'ss',
				'/Ĳ/' => 'IJ',
				'/ĳ/' => 'ij',
				'/Œ/' => 'OE',
				'/ƒ/' => 'f',
				'/ξ/' => 'ks',
				'/π/' => 'p',
				'/β/' => 'v',
				'/μ/' => 'm',
				'/ψ/' => 'ps',
				'/Ё/' => 'Yo',
				'/ё/' => 'yo',
				'/Є/' => 'Ye',
				'/є/' => 'ye',
				'/Ї/' => 'Yi',
				'/Ж/' => 'Zh',
				'/ж/' => 'zh',
				'/Х/' => 'Kh',
				'/х/' => 'kh',
				'/Ц/' => 'Ts',
				'/ц/' => 'ts',
				'/Ч/' => 'Ch',
				'/ч/' => 'ch',
				'/Ш/' => 'Sh',
				'/ш/' => 'sh',
				'/Щ/' => 'Shch',
				'/щ/' => 'shch',
				'/Ъ|ъ|Ь|ь/' => '',
				'/Ю/' => 'Yu',
				'/ю/' => 'yu',
				'/Я/' => 'Ya',
				'/я/' => 'ya'
			);
			
			$chars_from = array_keys($foreign_characters);
			$chars_to = array_values($foreign_characters);
		}

		return preg_replace($chars_from, $chars_to, $str);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('html_excerpt')) {
	/**
	 * html_excerpt
	 *
	 * Safely extracts not more than the first $length characters from the
	 * given string, even if HTML.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	string 	$str 	 	The string to generate excerpt from.
	 * @param 	int 	$length 	Maximum number of characters.
	 * @param 	string 	$more 		What to append if $str needs to be trimmed.
	 * @return 	string 	The final excerpt.
	 */
	function html_excerpt($str, $length, $more = null) {
		$more OR $more = '';
		$str = strip_all_tags($str, true);
		$excerpt = mb_substr($str, 0, $length);

		// Remove part of an entity at the end.
		$excerpt = preg_replace('/&[^;\s]{0,6}$/', '', $excerpt);
		
		if ($str !== $excerpt) {
			$excerpt = trim($excerpt).$more;
		}
		
		return $excerpt;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('html_wexcerpt')) {
	/**
	 * html_wexcerpt
	 *
	 * Does the same job as the "html_excerpt" function, except that
	 * it uses words count instead of characters count.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	string 	$str 	The string to generate excerpt from.
	 * @param 	int 	$count 	How many words to keep.
	 * @param 	string 	$more 	What to append if $str needs to be trimmed.
	 * @return 	string 	The final excerpt.
	 */
	function html_wexcerpt($str, $count, $more = null) {
		// Make sure $more is always a string.
		$more OR $more = '';

		// Remove all tags and prepare the array of all words.
		$excerpt = strip_all_tags($str);
		$words   = str_word_count($excerpt, 2);
		
		// Proceed only if $str has more words that requested.
		if (count($words) > $count) {
			$words = array_slice($words, 0, $count, true);
			end($words);
			
			$pos     = key($words) + strlen(current($words));
			$excerpt = substr($excerpt, 0, $pos).$more;
		}
		
		return $excerpt;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('convert_invalid_utf8')) {
	function convert_invalid_utf8($string, $strip = false) {
		$string = (string) $string;
		if (0 === strlen($string)) {
			return '';
		}

		static $is_utf8 = null;
		if ( ! isset($is_utf8)) {
			$is_utf8 = in_array(
				config_item('charset'),
				array('utf8', 'utf-8', 'UTF8', 'UTF-8')
			);
		}

		if ( ! $is_utf8) {
			return $string;
		}

		static $utf8_pcre = null;
		if ( ! isset($utf8_pcre)) {
			$utf8_pcre = @preg_match('/^./u', 'a');
		}

		if ( ! $utf8_pcre) {
			return $string;
		}

		// preg_match fails when it encounters invalid UTF8 in $string
		if (1 === @preg_match('/^./us', $string)) {
			return $string;
		}

		// Attempt to strip the bad chars if requested (not recommended)
		if ($strip && function_exists('iconv')) {
			return iconv('utf-8', 'utf-8', $string);
		}

		return '';
	}
}

if ( ! function_exists('convert_invalid_entities')) {
	function convert_invalid_entities($string) {
		$replacements = array(
			'&#128;' => '&#8364;', // the Euro sign
			'&#129;' => '',
			'&#130;' => '&#8218;', // these are Windows CP1252 specific characters
			'&#131;' => '&#402;',  // they would look weird on non-Windows browsers
			'&#132;' => '&#8222;',
			'&#133;' => '&#8230;',
			'&#134;' => '&#8224;',
			'&#135;' => '&#8225;',
			'&#136;' => '&#710;',
			'&#137;' => '&#8240;',
			'&#138;' => '&#352;',
			'&#139;' => '&#8249;',
			'&#140;' => '&#338;',
			'&#141;' => '',
			'&#142;' => '&#381;',
			'&#143;' => '',
			'&#144;' => '',
			'&#145;' => '&#8216;',
			'&#146;' => '&#8217;',
			'&#147;' => '&#8220;',
			'&#148;' => '&#8221;',
			'&#149;' => '&#8226;',
			'&#150;' => '&#8211;',
			'&#151;' => '&#8212;',
			'&#152;' => '&#732;',
			'&#153;' => '&#8482;',
			'&#154;' => '&#353;',
			'&#155;' => '&#8250;',
			'&#156;' => '&#339;',
			'&#157;' => '',
			'&#158;' => '&#382;',
			'&#159;' => '&#376;'
		);

		if (false !== strpos($string, '&#1')) {
			$string = strtr($string, $replacements);
		}

		return $string;
	}
}

// ------------------------------------------------------------------------
// Some CodeIgniter and PHP override to use Hooks.
// ------------------------------------------------------------------------

if ( ! function_exists('url_title')) {
	/**
	 * url_title
	 *
	 * Takes a string as input and created a human friendly URL string with
	 * a "separator" string as the word separator.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	string 	$str
	 * @param 	string 	$sep
	 * @param 	bool 	$low
	 * @return 	string
	 */
	function url_title($str, $sep = '-', $low = false) {
		if ('dash' === $sep) {
			$sep = '-';
		} elseif ('underscore' === $sep) {
			$sep = '_';
		}

		$q_sep = preg_quote($sep, '#');

		$trans = array(
			'&.+?;'         => '',
			'[^\w\d _-]'    => '',
			'\s+'           => $sep,
			'('.$q_sep.')+' => $sep
		);

		$str = strip_tags($str);
		$utf8 = ('UTF-8' === config_item('charset'));

		foreach ($trans as $key => $val) {
			$str = preg_replace('#'.$key.'#i'.($utf8 ? 'u' : ''), $val, $str);
		}

		$low && $str = strtolower($str);

		return apply_filters('url_title', $str);
	}
}

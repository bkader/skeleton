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
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KB_Lang Class
 *
 * This class extends CI_Lang class in order en add, override or
 * enhance some of the parent's methods.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Core Extension
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.3.4
 */
class KB_Lang extends CI_Lang
{
	/**
	 * Fall-back language.
	 * @var string
	 */
	protected $fallback = 'english';

	/**
	 * Array of cached languages details.
	 * @var array
	 */
	protected $_languages;

	/**
	 * Details of the current language.
	 * @var array
	 */
	public $lang;

	/**
	 * Class constructor.
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->config =& load_class('Config', 'core');
	}

	// --------------------------------------------------------------------

	/**
	 * Load a language file
	 *
	 * @param	mixed	$langfile	Language file name
	 * @param	string	$idiom		Language name (english, etc.)
	 * @param	bool	$return		Whether to return the loaded array of translations
	 * @param 	bool	$add_suffix	Whether to add suffix to $langfile
	 * @param 	string	$alt_path	Alternative path to look for the language file
	 *
	 * @return	void|string[]	Array containing translations, if $return is set to true
	 */
	public function load($langfile, $idiom = '', $return = false, $add_suffix = true, $alt_path = '')
	{
		// echo print_d(get_instance()->session->all_userdata());
		// exit;
		if (is_array($langfile))
		{
			foreach ($langfile as $value)
			{
				$this->load($value, $idiom, $return, $add_suffix, $alt_path);
			}

			return;
		}

		$langfile = str_replace('.php', '', $langfile);

		if ($add_suffix === true)
		{
			$langfile = preg_replace('/_lang$/', '', $langfile).'_lang';
		}

		$langfile .= '.php';

		// If the language is stored in session and is available, use it.
		if (empty($idiom) 
			&& isset($_SESSION['language']) 
			&& in_array($_SESSION['language'], $this->config->item('languages')))
		{
			// Set the language and update config item.
			$idiom = $_SESSION['language'];
		}

		if (empty($idiom) OR ! preg_match('/^[a-z_-]+$/i', $idiom))
		{
			$idiom = empty($this->config->item('language')) ? $this->fallback : $this->config->item('language');
		}

		if ($return === false && isset($this->is_loaded[$langfile]) && $this->is_loaded[$langfile] === $idiom)
		{
			return;
		}

		// Prepare the array of language lines and
		// load the english version first.
		$full_lang = array();

		// Load the base file, so any others found can override it
		$basepath = BASEPATH.'language/'.$this->fallback.'/'.$langfile;
		if (($found = file_exists($basepath)) === true)
		{
			include_once($basepath);
		}

		// Do we have an alternative path to look in?
		if ($alt_path !== '')
		{
			$alt_path .= 'language/'.$this->fallback.'/'.$langfile;
			if (file_exists($alt_path))
			{
				include_once($alt_path);
				$found = true;
			}
		}

		if ($found !== true)
		{
			foreach (get_instance()->load->get_package_paths(true) as $package_path)
			{
				$package_path .= 'language/'.$this->fallback.'/'.$langfile;
				if ($basepath !== $package_path && file_exists($package_path))
				{
					include_once($package_path);
					$found = true;
					break;
				}
			}
		}

		if ($found !== true)
		{
			show_error('Unable to load the requested language file: language/'.$this->fallback.'/'.$langfile);
		}

		// Was the language array updated?
		$full_lang = isset($lang) ? $lang : array();

		// Proceed only if the requested language id different of the fallback.
		if ($idiom !== $this->fallback)
		{
			$lang = array();

			// Load the base file, so any others found can override it
			$basepath = BASEPATH.'language/'.$idiom.'/'.$langfile;
			if (file_exists($basepath))
			{
				include_once($basepath);
			}

			// Do we have an alternative path to look in?
			if ($alt_path !== '')
			{
				$alt_path .= 'language/'.$idiom.'/'.$langfile;
				if (file_exists($alt_path))
				{
					include_once($alt_path);
					$found = true;
				}
			}
			else
			{
				foreach (get_instance()->load->get_package_paths(true) as $package_path)
				{
					$package_path .= 'language/'.$idiom.'/'.$langfile;
					if ($basepath !== $package_path && file_exists($package_path))
					{
						include_once($package_path);
						$found = true;
						break;
					}
				}
			}
		}
		else
		{
			$idiom = $this->fallback;
		}

		if ($found !== true)
		{
			show_error('Unable to load the requested language file: language/'.$idiom.'/'.$langfile);
		}

		(isset($lang)) OR $lang = array();
		$full_lang = array_replace_recursive($full_lang, $lang);

		if ( ! isset($full_lang) OR ! is_array($full_lang))
		{
			log_message('error', 'Language file contains no data: language/'.$idiom.'/'.$langfile);

			if ($return === true)
			{
				return array();
			}
			return;
		}

		if ($return === true)
		{
			return $full_lang;
		}

		$this->is_loaded[$langfile] = $idiom;
		$this->language = array_merge($this->language, $full_lang);

		log_message('info', 'Language file loaded: language/'.$idiom.'/'.$langfile);
		return true;
	}

	// --------------------------------------------------------------------

	/**
	 * Language line
	 *
	 * Fetches a single line of text from the language array
	 *
	 * @param	string	$line 	Language line key
	 * @param	string	$index 	Acts like gettext domain.
	 * @return	string	Translation
	 */
	public function line($line, $index = '')
	{
		if ($index == '')
		{
			$value = (isset($this->language[$line]))
				? $this->language[$line]
				: false;
		}
		else
		{
			$value = (isset($this->language[$index][$line]))
				? $this->language[$index][$line]
				: false;
		}

		// Because killer robots like unicorns!
		if ($value === false)
		{
			log_message('error', 'Could not find the language line "'.$line.'"');

			// Use inflector to generate the $value instead.
			// (function_exists('humanize')) OR get_instance()->load->helper('inflector');
			// $value = humanize($line);
			$value = "FIXME('{$line}')";
		}

		return $value;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the name or details about the language currently in use.
	 * @access 	public
	 * @param 	mixed 	what to retrieve.
	 * @return 	mixed
	 */
	public function lang()
	{
		// Collect function arguments.
		$args = func_get_args();

		// Empty? Return the current language.
		if (empty($args))
		{
			if (isset($this->lang))
			{
				return $this->lang['folder'];
			}

			$this->lang = $this->languages($this->config->item('language'));
			return $this->lang['folder'];
		}

		// The language is already cached? Use it. Otherwise load it.
		$return = (isset($this->lang)) 
			? $this->lang 
			: $this->languages($this->config->item('language'));

		// Not found ?
		if ( ! $return)
		{
			return FALSE;
		}

		// Get rid of nasty array.
		(is_array($args[0])) && $args = $args[0];

		// In case of a boolean, we return all language details.
		if (is_bool($args[0]) && $args[0] === true)
		{
			return $return;
		}

		// In case of a single item and found, return it.
		if (count($args) === 1 && isset($return[$args[0]]))
		{
			return $return[$args[0]];
		}

		$_return = array();

		// Loop through language details and get only what's requested.
		foreach ($args as $arg)
		{
			if (isset($return[$arg]))
			{
				$_return[$arg] = $return[$arg];
			}
		}

		// Return the result if any.
		return ($_return) ? $_return : $return;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns an array of languages details.
	 * @access 	public
	 * @param 	string 	$single 	The language to return.
	 * @return 	array
	 */
	public function languages($single = null)
	{
		// If they are already cached, use them.
		if (isset($this->_languages))
		{
			return ($single && isset($this->_languages[$single]))
				? $this->_languages[$single]
				: $this->_languages;
		}

		// User's file has the priority.
		if (is_file(APPPATH.'third_party/languages.php'))
		{
			$this->_languages = include(APPPATH.'third_party/languages.php');
		}
		// If not found, use our.
		elseif (is_file(KBPATH.'third_party/languages.php'))
		{
			$this->_languages = include(KBPATH.'third_party/languages.php');
		}
		// Otherwise, use an empty array.
		else
		{
			$this->_languages = array();
		}

		return ($single && isset($this->_languages[$single]))
			? $this->_languages[$single]
			: $this->_languages;
	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('lang'))
{
	/**
	 * Lang
	 *
	 * Fetches a language variable and optionally outputs a form label.
	 * The reason we are adding this here is to make the function available
	 * even if the language helper is not loaded.
	 * @param	string	$line		The language line
	 * @param	string	$for		The "for" value (id of the form element)
	 * @param	array	$attributes	Any additional HTML attributes
	 * @return	string
	 */
	function lang($line, $for = '', $attributes = array())
	{
		$line = get_instance()->lang->line($line);

		if ($for !== '')
		{
			$line = '<label for="'.$for.'"'._stringify_attributes($attributes).'>'.$line.'</label>';
		}

		return $line;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('line'))
{
	/**
	 * Alias of Lang::line with optional arguments.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.4 	Added $before and $after.
	 *
	 * @param 	string 	$line 	the line the retrieve.
	 * @param 	string 	$index 	whether to look under an index.
	 * @param 	string 	$before 	Whether to put something before the line.
	 * @param 	string 	$after 		Whether to put something after the line.
	 * @return 	string
	 */
	function line($line, $index = '', $before = '', $after = '')
	{
		// Shall we translate the before?
		if ('' !== $before && 1 === sscanf($before, 'lang:%s', $b_line))
		{
			$before = line($b_line, $index);
		}

		// Shall we translate the after?
		if ('' !== $after && 1 === sscanf($after, 'lang:%s', $a_line))
		{
			$after = line($a_line, $index);
		}

		return $before.get_instance()->lang->line($line, $index).$after;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('__'))
{
	/**
	 * Alias of Lang::line with optional arguments.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.4 	Added $before and $after.
	 *
	 * @param 	string 	$line 	the line the retrieve.
	 * @param 	string 	$index 	whether to look under an index.
	 * @param 	string 	$before 	Whether to put something before the line.
	 * @param 	string 	$after 		Whether to put something after the line.
	 * @return 	string
	 */
	function __($line, $index = '', $before = '', $after = '')
	{
		// Shall we translate the before?
		if ('' !== $before && 1 === sscanf($before, 'lang:%s', $b_line))
		{
			$before = line($b_line, $index);
		}

		// Shall we translate the after?
		if ('' !== $after && 1 === sscanf($after, 'lang:%s', $a_line))
		{
			$after = line($a_line, $index);
		}

		return $before.get_instance()->lang->line($line, $index).$after;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_e'))
{
	/**
	 * Alias of Lang::line with optional arguments.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.4 	Added $before and $after.
	 *
	 * @param 	string 	$line 		the line the retrieve.
	 * @param 	string 	$index 		whether to look under an index.
	 * @param 	string 	$before 	Whether to put something before the line.
	 * @param 	string 	$after 		Whether to put something after the line.
	 * @return 	string
	 */
	function _e($line, $index = '', $before = '', $after = '')
	{
		echo line($line, $index, $before, $after);
	}
}

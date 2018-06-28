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
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.1.6
 */
class KB_Lang extends CI_Lang
{
	/**
	 * Fall-back language.
	 * @var string
	 */
	protected $fallback = 'english';

	/**
	 * Holds an array of language details.
	 * @since 	2.1.6
	 * @var 	array
	 */
	public $details = array(
		'name'      => 'English',
		'name_en'   => 'English',
		'folder'    => 'english',
		'locale'    => 'en-US',
		'gettext'   => 'en_US',
		'direction' => 'ltr',
		'code'      => 'en',
		'flag'      => 'us',
	);

	/**
	 * Flag to check whether we should use PHP-Gettext.
	 * @since 	2.1.0
	 */
	public $gettext = false;

	/**
	 * Class constructor.
	 * @return 	void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->config =& load_class('Config', 'core');
		$this->router =& load_class('Router', 'core');

		/**
		 * Store language in session and change config item.
		 * @since 	2.1.6
		 */
		$this->_set_language();

		/**
		 * In order to use PHP-Gettext, the following must be true:
		 * 1. USE_GETTEXT constant is defined and set to TRUE.
		 * 2. "gettext_instance" function exists.
		 */
		$this->gettext = (defined('USE_GETTEXT') && true === USE_GETTEXT);
		$this->gettext = function_exists('gettext_instance');
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
		/**
		 * The only section of the website we language should ALWAYS be 
		 * english is the dashboard login page.
		 * @since 	2.0.0
		 */
		if (true === $this->router->is_admin() 
			&& 'login' === $this->router->fetch_class())
		{
			$idiom = 'english';
		}

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
			// We use the language stored in session.
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
		/**
		 * See if we are are using PHP-Gettext.
		 * @since 	2.1.0
		 */
		if ($this->gettext && false === stripos($line, 'csk_'))
		{
			return __($line, $index); // $index is used as the text domain.
		}

		/**
		 * Because some lines start with CSK_ (uppercased), we make sure
		 * to format the $line before we proceed.
		 */
		if (0 === stripos($line, 'csk_') && false === ctype_upper($line))
		{
			$line = strtoupper($line);
		}

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

			/**
			 * Both "inflect" and "FIXME" use were dropped. We use the $line
			 * as it is, as the line to return.
			 * @since 	2.1.0
			 */
			$value = $line;
		}

		return $value;
	}

	// ------------------------------------------------------------------------

	/**
	 * Singular and plural language line.
	 *
	 * Fetches a single line of text from the language array depending on the
	 * given $n (number). Fake "ngettext".
	 *
	 * @since 	2.0.1
	 *
	 * @param	string	$singular 	The singular form of the line.
	 * @param	string	$plural 	The plural form of the line.
	 * @param	int 	$number 	The number used for comparison.
	 * @param	string	$index 		Acts like gettext domain.
	 * @return	string	Translation.
	 */
	public function nline($singular, $plural, $number, $index = '')
	{
		/**
		 * See if we are are using PHP-Gettext.
		 * @since 	2.1.0
		 */
		if ($this->gettext && false === stripos($line, 'csk_'))
		{
			// $index is used as the text domain.
			return _n($singular, $plural, $number, $index);
		}

		return ($number == 1) 
			? $this->line($singular, $index)
			: $this->line($plural, $index);
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
		// Make the method remember language details.
		static $details;

		is_null($details) && $details = $this->details;

		$return = $this->details;

		// The language was not found?
		if ( ! $return)
		{
			return false;
		}

		// Not arguments passed? Return the language folder.
		if (empty($args = func_get_args()))
		{
			return $return['folder'];
		}

		// Get rid of nasty array.
		(is_array($args[0])) && $args = $args[0];
		$args_count = count($args);

		// In case of a boolean, we return all language details.
		if ($args_count == 1 && $args[0] === true)
		{
			return $return;
		}

		// In case of a single item and found, return it.
		if ($args_count === 1 && isset($return[$args[0]]))
		{
			return $return[$args[0]];
		}

		// Multiple arguments?
		if ($args_count >= 2)
		{
			$_return = array();

			foreach ($args as $arg)
			{
				isset($return[$arg]) && $_return[$arg] = $return[$arg];
			}

			empty($_return) OR $return = $_return;
		}

		return $return;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns an array of languages details.
	 *
	 * @since 	1.0.0
	 * @since 	1.4.0 	Possibility to retrieve multiple languages.
	 * 
	 * @access 	public
	 * @param 	mixed 	$langs 	String, comma-separated strings or array.
	 * @return 	array
	 */
	public function languages($langs = null)
	{
		static $languages;
		// Not cached? Cache them if found.
		if (empty($languages))
		{
			// User's file has the priority.
			if (is_file(APPPATH.'third_party/languages.php'))
			{
				$languages = require_once(APPPATH.'third_party/languages.php');
			}
			// If not found, use our.
			elseif (is_file(KBPATH.'third_party/bkader/inc/languages.php'))
			{
				$languages = require_once(KBPATH.'third_party/bkader/inc/languages.php');
			}
			// Otherwise, use an empty array.
			else
			{
				$languages = array();
			}
		}

		$return = $languages;

		// No argument? return all languages.
		if (null === $langs)
		{
			return $return;
		}

		// Format our requested languages.
		( ! is_array($langs)) && $langs = array_map('trim', explode(',', $langs));

		if ( ! empty($langs))
		{
			// Build requested languages array.
			$_languages = array();
			foreach ($langs as $lang)
			{
				if (isset($languages[$lang]))
				{
					$_languages[$lang] = $languages[$lang];
				}
			}

			empty($_languages) OR $return = $_languages;
		}

		return $return;
	}

	// ------------------------------------------------------------------------

	/**
	 * Moved from KBcore.php for earlier usage.
	 *
	 * Make sure to store language in session.
	 *
	 * @since 	2.1.6
	 *
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _set_language()
	{
		// We make sure to load session first.
		_load_session();

		// Site available language and all languages details.
		$site_languages = $this->config->item('languages');
		$languages = $this->languages();

		// Current and default language.
		$default = $this->config->item('language');
		$current = isset($_SESSION['language']) ? $_SESSION['language'] : $default;

        /**
         * In case the language is not stored in session or is not available;
         * we attempt to detect clients language. If available, we use it
         * instead of the default language.
         */
		if ( ! isset($_SESSION['language']) 
			OR ! in_array($_SESSION['language'], $site_languages))
		{
			$code = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) 
				? substr(html_escape($_SERVER['HTTP_ACCEPT_LANGUAGE']), 0, 2) 
				: 'en';

			foreach ($languages as $folder => $lang)
			{
                /**
                 * In order for the language to be used, the code must exists and
                 * the language must be available.
                 */
				if (isset($lang['code']) && $code === $lang['code'] && in_array($folder, $site_languages))
				{
					$current = $folder;
					break;
				}
			}

			$_SESSION['language'] = $current;
		}

		$this->details = $languages[$current];
		$this->config->set_item('current_language', $this->details);

		if (false !== $this->gettext 
			&& (isset($this->details['gettext']) OR isset($this->details['locale'])))
		{
			$locale = isset($this->details['gettext'])
				? $this->details['gettext']
				: str_replace('-', '_', $this->details['locale']);

			gettext_instance()->setlocale($locale);

			if ($this->router->is_admin())
			{
				gettext_instance()->add_location(KBPATH.'language');
				gettext_instance()->textdomain('admin');
			}
		}
	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('langinfo'))
{
	/**
	 * Returns the name or details about the language currently in use.
	 * @param 	mixed 	$key what to retrieve.
	 * @return 	mixed
	 */
	function langinfo($key = null)
	{
		return get_instance()->lang->lang($key);
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
	 * Alias of KB_Lang::line with optional arguments.
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
     * Alias of KB_Lang::line with optional arguments.
     *
     * @since 	1.0.0
     * @since 	1.3.4 	Added $before and $after.
     * @since 	2.1.0 	Function ignored if using Gettext.
     *
     * @param 	string 	$line 		the line the retrieve.
     * @param 	string 	$index 		whether to look under an index.
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
	 * Alias of KB_Lang::line with optional arguments.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.4 	Added $before and $after.
	 * @since 	2.1.0 	Function ignored if using Gettext.
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

// ------------------------------------------------------------------------

if ( ! function_exists('nline'))
{
	/**
	 * This function is wrapper of 'KB_Lang::nline()' method.
	 * @param	string	$singular 	The singular form of the line.
	 * @param	string	$plural 	The plural form of the line.
	 * @param	int 	$number 	The number used for comparison.
	 * @param	string	$index 		Acts like gettext domain.
	 * @return	string	Translation.
	 */
	function nline($singular, $plural, $number, $index = '')
	{
		return get_instance()->lang->nline($singular, $plural, $number, $index);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_n'))
{
	/**
	 * This function is wrapper of 'KB_Lang::nline()' method.
	 * 
	 * @since 	2.1.0 	Function ignored if using Gettext.
	 * 
	 * @param	string	$singular 	The singular form of the line.
	 * @param	string	$plural 	The plural form of the line.
	 * @param	int 	$number 	The number used for comparison.
	 * @param	string	$index 		Acts like gettext domain.
	 * @return	string	Translation.
	 */
	function _n($singular, $plural, $number, $index = '')
	{
		return get_instance()->lang->nline($singular, $plural, $number, $index);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_en'))
{
	/**
	 * Alias of the "nline" function, the only different is that this 
	 * function echoes the line directly.
	 *
	 * @since 	2.0.0
	 * @since 	2.1.0 	Function ignored if using Gettext.
	 * 
	 * @param	string	$singular 	The singular form of the line.
	 * @param	string	$plural 	The plural form of the line.
	 * @param	int 	$number 	The number used for comparison.
	 * @param	string	$index 		Acts like gettext domain.
	 * @return	void
	 */
	function _en($singular, $plural, $number, $index = '')
	{
		echo nline($singular, $plural, $number, $index);
	}
}

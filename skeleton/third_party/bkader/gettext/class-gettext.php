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

// We define path to this directory.
$gettext_dir = normalize_path(dirname(__FILE__).'/');

/**
 * We use the Autoloader class to add paths to Gettext classes.
 * If the class does not exists, we simply include files.
 */
if (class_exists('Autoloader', false))
{
	Autoloader::add_classes(array(
		'Gettext_reader'     => $gettext_dir.'class-gettext-reader.php',
		'Stream_reader'      => $gettext_dir.'class-stream-reader.php',
		'String_reader'      => $gettext_dir.'class-string-reader.php',
		'File_reader'        => $gettext_dir.'class-file-reader.php',
		'Cached_file_reader' => $gettext_dir.'class-cached-file-reader.php',
	));
}
else
{
	require_once(KBPATH.'third_party/bkader/gettext/class-gettext-reader.php');
	require_once(KBPATH.'third_party/bkader/gettext/class-stream-reader.php');
	require_once(KBPATH.'third_party/bkader/gettext/class-string-reader.php');
	require_once(KBPATH.'third_party/bkader/gettext/class-file-reader.php');
	require_once(KBPATH.'third_party/bkader/gettext/class-cached-file-reader.php');
}

/**
 * Gettext Class
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Third Party
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.1.0
 * @version 	2.1.0
 */
class Gettext {

	/**
	 * Holds an array of loaded text domains.
	 * @var array
	 */
	private $domains = array();

	/**
	 * Holds the default domain to be used.
	 * @var string
	 */
	private $domain = null;

	/**
	 * Holds the currently used locale (CodeIgniter language).
	 * @var string
	 */
	private $locale = null;

	/**
	 * Holds the array of paths where language files may be located.
	 * @var array
	 */
	private $locations;

	/**
	 * Reference of this object singleton.
	 * @var object
	 */
	private static $instance;

	/**
	 * Returns an instance of Gettext singleton.
	 *
	 * @static
	 * @access 	public
	 * @param 	none
	 * @return 	object
	 */
	public static function instance()
	{
		// We create an instance if not already set.
		isset(self::$instance) OR self::$instance = new self();

		return self::$instance;
	}

	// ------------------------------------------------------------------------
	// PHP Gettext emulation methods.
	// ------------------------------------------------------------------------

	/**
	 * Sets a requested locale.
	 *
	 * @access 	public
	 * @param 	string 	$locale
	 * @return 	Gettext
	 */
	public function setlocale($locale = '')
	{
		if ( ! empty($locale) && $locale !== $this->locale)
		{
			$this->locale = $locale;

			/**
			 * We allow locale to be changed on the go for one
			 * translation domain.
			 */
			if (array_key_exists($this->domain, $this->domains))
			{
				unset($this->domains[$this->default_domain]->l10n);
			}
		}

		return $this->locale;
	}

	// ------------------------------------------------------------------------

	/**
	 * Sets the path for a domain
	 *
	 * @access 	public
	 * @param 	string 	$domain 	The domain.
	 * @param 	string 	$path 	The directory path.
	 * @return 	The full pathname for the domain currently being set.
	 */
	public function bindtextdomain($domain, $path)
	{
		if ( ! isset($this->domains[$domain]))
		{
			$this->domains[$domain] = $this->_domain_tmp();
		}

		$this->domains[$domain]->path = normalize_path($path);
		return $this->domains[$domain]->path;
	}

	// ------------------------------------------------------------------------

	/**
	 * Specify the character encoding in which the messages from the DOMAIN 
	 * message catalog will be returned.
	 *
	 * @access 	public
	 * @param 	string 	$domain 	The domain.
	 * @param 	string 	$codeset 	The codeset.
	 * @return 	A string on success.
	 */
	public function bind_textdomain_codeset($domain, $codeset = 'UTF-8')
	{
		if ( ! isset($this->domains[$domain]))
		{
			$this->domains[$domain] = $this->_domain_tmp();
		}

		$this->domains[$domain]->codeset = $codeset;
		return $this->domains[$domain]->codeset;
	}

	// ------------------------------------------------------------------------

	/**
	 * Sets the default domain.
	 *
	 * @access 	public
	 * @param 	string 	$domain 	The new message domain, or NULL to get the current one.
	 * @return 	string 	The current message domain after possible changing it.
	 */
	public function textdomain($domain = null)
	{
		if ( ! empty($domain) && $domain !== $this->domain)
		{
			$this->domain = $domain;
		}

		return $this->domain;
	}

	// ------------------------------------------------------------------------
	// Object-related methods.
	// ------------------------------------------------------------------------

	/**
	 * Returns the array of loaded domains.
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	array
	 */
	public function domains()
	{
		return $this->domains;
	}

	// ------------------------------------------------------------------------

	/**
	 * Adds a new domain to domains array. This method is wrapper for the
	 * "Gettext::bindtextdomain". Because we have "add_location", it is good
	 * to have "add_domain" as well.
	 *
	 * @access 	public
	 * @param 	string 	$domain 	The domain.
	 * @param 	string 	$path 	The directory path.
	 * @return 	The full pathname for the domain currently being set.
	 */
	public function add_domain($domain, $path)
	{
		return $this->bindtextdomain($domain, $path);
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the array of locations where language file may be located.
	 *
	 * @access 	public
	 * @param 	void
	 * @return 	array
	 */
	public function locations()
	{
		isset($this->locations) OR $this->locations = $this->_locations();
		return $this->locations;
	}

	// ------------------------------------------------------------------------

	/**
	 * Adds a location to use when searching for language files.
	 *
	 * @access 	public
	 * @param 	string
	 * @return 	object
	 */
	public function add_location($path)
	{
		isset($this->locations) OR $this->location = $this->_locations();
		$this->locations[] = normalize_path($path);

		// We make sure to add unique and valid directories.
		$this->locations = array_unique(array_filter($this->locations, 'is_dir'));

		// Make method chainable.
		return $this;
	}

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------

	/**
	 * Prepare default locations where language file may be located.
	 *
	 * @access 	private
	 * @param 	none
	 * @return 	array
	 */
	private function _locations()
	{
		// Not already cached?
		if ( ! isset($this->locations))
		{
			// Default as empty array.
			$this->locations = array();

			// 1. Language can be located on content directory.
			if (is_dir(FCPATH.'content/language'))
			{
				$this->locations[] = normalize_path(FCPATH.'content/language');
			}

			// 2. Application folder.
			if (is_dir(APPPATH.'language'))
			{
				$this->locations[] = normalize_path(APPPATH.'language');
			}

			// We make sure to add unique and valid directories.
			$this->locations = array_unique(array_filter($this->locations, 'is_dir'));
		}

		return $this->locations;
	}

	// ------------------------------------------------------------------------

	/**
	 * This method creates a new empty domain object to use as template when
	 * initializing new domain objects.
	 *
	 * @access 	private
	 * @param 	none
	 * @return 	object
	 */
	private function _domain_tmp()
	{
		// Make the method remember this.
		static $domain;

		if (is_null($domain))
		{
			$domain = new stdClass();
			$domain->l10n = null;
			$domain->path = null;
			$domain->codeset = null;
		}

		return $domain;
	}

	// ------------------------------------------------------------------------
	// Translation methods.
	// ------------------------------------------------------------------------

	/**
	 * Gets a Stream_reader for the given text domain.
	 *
	 * @access 	private
	 * @param 	string 	$domain 	The domain.
	 * @param 	bool 	$cache 		Whether to cache the file.
	 * @return 	object
	 */
	public function get_reader($domain = null, $cache = true)
	{
		isset($domain) OR $domain = $this->domain;

		if ( ! isset($this->domains[$domain]->l10n))
		{
			// Prepare the path to language directory.
			$path = isset($this->domains[$domain]->path)
				? $this->domains[$domain]->path
				: normalize_path(APPPATH.'language');

			// Prepare an empty $inout and $file.
			$input = null;

			$file = array($domain, $this->locale);
			('default' === $domain) && array_shift($file);
			$file = implode('-', array_filter($file)).'.mo';

			$file_path = $path.'/'.$file;
			if ( ! is_file($file_path))
			{
				foreach ($this->_locations() as $location)
				{
					if (is_file($location.'/'.$file))
					{
						$file_path = $location.'/'.$file;
						break;
					}
				}
			}

			is_file($file_path) && $input = new File_reader($file_path);

			if ( ! isset($this->domains[$domain]))
			{
				$this->domains[$domain] = $this->_domain_tmp();
			}

			$this->domains[$domain]->l10n = new Gettext_reader($input, $cache);
		}

		return $this->domains[$domain]->l10n;
	}

	// ------------------------------------------------------------------------

	/**
	 * Get the codeset for the given domain.
	 *
	 * @access 	public
	 * @param 	string 	$domain 	The domain
	 * @return 	string
	 */
	public function get_codeset($domain = null)
	{
		isset($domain) OR $domain = $this->domain;

		return (isset($this->domains[$domain]->codeset))
			? $this->domains[$domain]->codeset
			: ini_get('mbstring.internal_encoding');
	}

	// ------------------------------------------------------------------------

	/**
	 * Converts the given string to the encoding set by bind_textdomain_codeset.
	 *
	 * @access 	public
	 * @param 	string 	$string
	 * @return 	string
	 */
	public function encode($string) {
		$source = mb_detect_encoding($string);
		$target = $this->get_codeset();

		// Different encoding? Convert it.
		if ($source !== $target)
		{
			$string = mb_convert_encoding($string, $target, $source);
		}

		return $string;
	}

}

// ------------------------------------------------------------------------

if ( ! function_exists('gettext_instance'))
{
	/**
	 * Returns a references to Gettext class.
	 * @param 	none
	 * @return 	Gettext
	 */
	function gettext_instance()
	{	
		return Gettext::instance();
	}
}

// ------------------------------------------------------------------------
// Alternative Gettext methods.
// ------------------------------------------------------------------------

if ( ! function_exists('_setlocale'))
{
	/**
	 * Sets a requested locale.
	 * @param 	string 	$locale
	 * @return 	Gettext
	 */
	function _setlocale($locale = '')
	{
		return gettext_instance()->setlocale($locale);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_bindtextdomain'))
{
	/**
	 * Sets the path for a domain
	 * @param 	string 	$domain 	The domain.
	 * @param 	string 	$path 	The directory path.
	 * @return 	The full pathname for the domain currently being set.
	 */
	function _bindtextdomain($domain, $path)
	{
		return gettext_instance()->bindtextdomain($domain, $path);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_bind_textdomain_codeset'))
{
	/**
	 * Specify the character encoding in which the messages from the DOMAIN 
	 * message catalog will be returned.
	 * @param 	string 	$domain 	The domain.
	 * @param 	string 	$codeset 	The codeset.
	 * @return 	A string on success.
	 */
	function _bind_textdomain_codeset($domain, $codeset = 'UTF-8')
	{
		return gettext_instance()->bind_textdomain_codeset($domain, $codeset);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_textdomain'))
{
	/**
	 * Sets the default domain.
	 * @param 	string 	$domain 	The new message domain, or NULL to get the current one.
	 * @return 	string 	The current message domain after possible changing it.
	 */
	function _textdomain($domain)
	{
		return gettext_instance()->textdomain($domain);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_gettext'))
{
	/**
	 * Lookup a message in the current domain.
	 * @param 	string 	$msgid
	 * @return 	string
	 */
	function _gettext($msgid)
	{
		$l10n = gettext_instance()->get_reader();
		return gettext_instance()->encode($l10n->translate($msgid));
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_ngettext'))
{
	/**
	 * Plural version of gettext
	 * @param 	string 	$singular 	The singular message ID.
	 * @param 	string 	$plural 	The plural message ID.
	 * @param 	int 	$number 	The number user for comparison.
	 * @return 	string 	Returns correct plural form of message
	 */
	function _ngettext($singular, $plural, $number)
	{
		$l10n = gettext_instance()->get_reader();
		return gettext_instance()->encode($l10n->ngettext($singular, $plural, $number));
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_dgettext'))
{
	/**
	 * Override the current domain
	 * @param 	string 	The domain.
	 * @param 	string 	The message.
	 * @return 	A string on success.
	 */
	function _dgettext($domain, $msgid)
	{
		$l10n = gettext_instance()->get_reader($domain);
		return gettext_instance()->encode($l10n->translate($msgid));
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_dngettext'))
{
	/**
	 * Plural version of dgettext
	 * @param 	string 	$domain 	The domain
	 * @param 	string 	$singular 	The singular message ID.
	 * @param 	string 	$plural 	The plural message ID.
	 * @param 	int 	$number 	The number used for comparison.
	 * @return 	string 	Returns correct plural form of message.
	 */
	function _dngettext($domain, $singular, $plural, $number)
	{
		$l10n = gettext_instance()->get_reader($domain);
		return gettext_instance()->encode($l10n->ngettext($singular, $plural, $number));
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_pgettext'))
{
	/**
	 * Context version of Gettext.
	 * @param 	string 	$context 	The context.
	 * @param 	string 	$msgid 		The message.
	 * @return 	string 	Returns the connect form of message.
	 */
	function _pgettext($context, $msgid)
	{
		$l10n = gettext_instance()->get_reader();
	    return gettext_instance()->encode($l10n->pgettext($context, $msgid));
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_dpgettext'))
{
	/**
	 * Override the current domain in a context Gettext call.
	 * @param 	string 	$domain 	The domain.
	 * @param 	string 	$context 	The context.
	 * @param 	string 	$msgid 		The message.
	 * @return 	string
	 */
	function _dpgettext($domain, $context, $msgid)
	{
		$l10n = gettext_instance()->get_reader($domain);
	    return gettext_instance()->encode($l10n->pgettext($context, $msgid));
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_npgettext'))
{
	/**
	 * Context version of ngettext.
	 * @param 	string 	$context 	The context.
	 * @param 	string 	$singular 	The singular message ID.
	 * @param 	string 	$plural 	The plural message ID.
	 * @param 	int 	$number 	The number used for comparison.
	 * @return 	string 	Returns correct plural form of message.
	 */
	function _npgettext($context, $singular, $plural, $number)
	{
		$l10n = gettext_instance()->get_reader();
		return gettext_instance()->encode($l10n->npgettext($context, $singular, $plural, $number));
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_dnpgettext'))
{
	/**
	 * Override the current domain in a context ngettext call.
	 * @param 	string 	$domain 	The domain.
	 * @param 	string 	$context 	The context
	 * @param 	string 	$singular 	The singular message ID.
	 * @param 	string 	$plural 	The plural message ID.
	 * @param 	int 	$number 	The number used for comparison.
	 * @return 	string 	Returns correct plural form of message.
	 */
	function _dnpgettext($domain, $context, $singular, $plural, $number)
	{
		$l10n = gettext_instance()->get_reader($domain);
		return gettext_instance()->encode($l10n->npgettext($context, $singular, $plural, $number));
	}
}

// ------------------------------------------------------------------------
// Define Gettext functions if the extension is not loaded.
// ------------------------------------------------------------------------

if ( ! function_exists('gettext'))
{
	function bindtextdomain($domain, $path)
	{
		return _bindtextdomain($domain, $path);
	}

	function bind_textdomain_codeset($domain, $codeset = 'UTF-8')
	{
		return _bind_textdomain_codeset($domain, $codeset);
	}

	function textdomain($domain = null)
	{
		return _textdomain($domain = null);
	}

	function _($msgid)
	{
		return _gettext($msgid);
	}

	function gettext($msgid)
	{
		return _gettext($msgid);
	}

	function ngettext($singular, $plural, $number)
	{
		return _ngettext($singular, $plural, $number);
	}

	function dgettext($domain, $msgid)
	{
		return _dgettext($domain, $msgid);
	}

	function dngettext($domain, $singular, $plural, $number)
	{
		return _dngettext($domain, $singular, $plural, $number);
	}

	function pgettext($context, $msgid)
	{
		return _pgettext($context, $msgid);
	}

	function dpgettext($domain, $context, $msgid)
	{
		return _dpgettext($domain, $context, $msgid);
	}

	function npgettext($context, $singular, $plural, $number)
	{
		return _npgettext($context, $singular, $plural, $number);
	}

	function dnpgettext($domain, $context, $singular, $plural, $number)
	{
		return _dnpgettext($domain, $context, $singular, $plural, $number);
	}
}

// ------------------------------------------------------------------------
// Useful helpers.
// ------------------------------------------------------------------------

if ( ! function_exists('__'))
{
	/**
	 * Retrieves the translation of $msgid. 
	 *
	 * If there is no translation, or the text domain isn't loaded, the
	 * original text is returned.
	 *
	 * @param 	string 	$msgid  	Text to translate.
	 * @param 	string 	$domain 	Optional. The text domain.
	 * @return 	string 	Translated text.
	 */
	function __($msgid, $domain = null)
	{
		return _dgettext($domain, $msgid);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('esc_attr__')) {
	/**
	 * Retrieves the translation of $msgid and escapes it for safe use
	 * in attributes.
	 * @param 	string 	$msgid 	 	The message to translate.
	 * @param 	string 	$domain 	Optional. The text domain.
	 * @return 	string 	Translated and escaped string.
	 */
	function esc_attr__($msgid, $domain)
	{
		return esc_attr(_dgettext($domain, $msgid));
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('esc_html__')) {
	/**
	 * Retrieves the translation of $msgid and escapes it for safe use
	 * in attributes.
	 * @param 	string 	$msgid 	 	The message to translate.
	 * @param 	string 	$domain 	Optional. The text domain.
	 * @return 	string 	Translated and escaped string.
	 */
	function esc_html__($msgid, $domain)
	{
		return esc_html(_dgettext($domain, $msgid));
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_e'))
{
	/**
	 * Displays the translated text.
	 * @param 	string 	$msgid  	The message to translate.
	 * @param 	string 	$domain 	THe text domain.
	 */
	function _e($msgid, $domain = null)
	{
		echo _dgettext($domain, $msgid);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('esc_attr_e')) {
	/**
	 * Retrieves the translation of $msgid and escapes it for safe use
	 * in attributes.
	 * @param 	string 	$msgid 	 	The message to translate.
	 * @param 	string 	$domain 	Optional. The text domain.
	 */
	function esc_attr_e($msgid, $domain)
	{
		echo esc_attr(_dgettext($domain, $msgid));
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('esc_html_e')) {
	/**
	 * Retrieves the translation of $msgid and escapes it for safe use
	 * in attributes.
	 * @param 	string 	$msgid 	 	The message to translate.
	 * @param 	string 	$domain 	Optional. The text domain.
	 */
	function esc_html_e($msgid, $domain)
	{
		echo esc_html(_dgettext($domain, $msgid));
	}
}

// ------------------------------------------------------------------------
// Gettext context.
// ------------------------------------------------------------------------

if ( ! function_exists('_x'))
{
	/**
	 * Retrieve translated string with gettext context. Useful to avoid 
	 * collisions with similar translatable text found in more that two
	 * places, but with different translated context.
	 * @param 	string 	$text 		Text to translate.
	 * @param 	string 	$context 	Context information for the translators.
	 * @param 	string 	$domain 	Optional. The text domain.
	 * @return 	string 	Translated context string without pipe.
	 */
	function _x($msgid, $context, $domain = null)
	{
		return _dpgettext($domain, $context, $msgid);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_ex'))
{
	/**
	 * Display translated string with gettext context.
	 * @param 	string 	$text 		Text to translate.
	 * @param 	string 	$context 	Context information for the translators.
	 * @param 	string 	$domain 	Optional. The text domain.
	 * @return 	string 	Translated context string without pipe.
	 */
	function _ex($msgid, $context, $domain = null)
	{
		echo _dpgettext($domain, $context, $msgid);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('esc_attr_x')) {
	/**
	 * Retrieves the translation of $msgid and escapes it for safe use
	 * in attributes.
	 * @param 	string 	$msgid 	 	The message to translate.
	 * @param 	string 	$domain 	Optional. The text domain.
	 * @return 	string 	Translated and escaped string.
	 */
	function esc_attr_x($msgid, $context, $domain = null)
	{
		return esc_attr(_dpgettext($domain, $context, $msgid));
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('esc_html_x')) {
	/**
	 * Retrieves the translation of $msgid and escapes it for safe use
	 * in attributes.
	 * @param 	string 	$msgid 	 	The message to translate.
	 * @param 	string 	$domain 	Optional. The text domain.
	 * @return 	string 	Translated and escaped string.
	 */
	function esc_html_x($msgid, $context, $domain = null)
	{
		return esc_html(_dpgettext($domain, $context, $msgid));
	}
}

// ------------------------------------------------------------------------
// Singular and plural functions.
// ------------------------------------------------------------------------

if ( ! function_exists('_n'))
{
	/**
	 * Translates and retrieves the singular or plural form based on the
	 * supplied number. You may want to use it with "sprintf" or "printf".
	 * @param 	string 	$single 	The text to be used if the number is singular.
	 * @param 	string 	$plural 	The text to be used if the number is plural.
	 * @param 	int 	$number 	The number used for comparison.
	 * @param 	string 	$domain 	Optional. The text domain.
	 * @return 	string The translated singular or plural form.
	 */
	function _n($singular, $plural, $number, $domain = null)
	{
		return _dngettext($domain, $singular, $plural, $number);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_nx'))
{
	/**
	 * Translates and retrieves the singular or plural form based on the
	 * supplied number, with gettext context. This is a hybrid of _n() 
	 * and _x(). It supports context and plurals.
	 * 
	 * @param 	string 	$single 	The text to be used if the number is singular.
	 * @param 	string 	$plural 	The text to be used if the number is plural.
	 * @param 	int 	$number 	The number used for comparison.
	 * @param 	string 	$context 	Context information for the translators.
	 * @param 	string 	$domain 	Optional. The text domain
	 * @return 	string 	The translated singular or plural form.
	 */
	function _nx($singular, $plural, $number, $context, $domain = null)
	{
		return _dnpgettext($domain, $context, $singular, $plural, $number);
	}
}

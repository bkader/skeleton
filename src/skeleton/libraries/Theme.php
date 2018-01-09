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
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Theme Class
 *
 * This is the magical library that allow you to make create 
 * amazing app-independent themes.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Libraries
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */
class Theme
{
	/**
	 * Header template
	 * @var string
	 */
	private $_template_header = <<<EOT
<!DOCTYPE html>
<html{html_class}{language_attributes}>
<head>
    {charset}
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{title}</title>
    {metadata}
    {stylesheets}{extra_head}
</head>
<body{body_class}>\n
EOT;

	/**
	 * Footer template.
	 * @var string
	 */
	private $_template_footer = <<<EOT
	{javascripts}
	{analytics}
</body>
</html>
EOT;

	/**
	 * Google analytics template.
	 * @var string
	 */
	private $_template_google_analytics = <<<EOT
	<script>
        window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
        ga('create','{site_id}','auto');ga('send','pageview')
    </script>
    <script src="https://www.google-analytics.com/analytics.js" async defer></script>
EOT;

	/**
	 * Default layout template to use as
	 * a fallback if no layout is found
	 */
	private $_template_layout = <<<EOT
{navbar}
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-8">
			{content}
		</div><!--/.col-sm-8-->
		<div class="col-xs-12 col-sm-4">
			{sidebar}
		</div><!--/.col-sm-4-->
	</div><!--/.row-->
</div><!-- /.container -->
{footer}
EOT;

	/**
	 * Default alert message template to use
	 * as a fallback if none is provided.
	 */
	private $_template_alert = <<<EOT
	<div class="{class} alert-dismissable text-left" role="alert">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		{message}
	</div>
EOT;

	/**
	 * JavaSript alert template.
	 */
	private $_template_alert_js =<<<EOT
'<div class="{class} alert-dismissable text-left" role="alert">'
+'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'
+'{message}'
+'</div>'
EOT;

	/**
	 * Array of default alerts classes.
	 * @var  array
	 */
	private $_alert_classes = array(
		'info'    => 'alert alert-info',
		'error'   => 'alert alert-danger',
		'warning' => 'alert alert-warning',
		'success' => 'alert alert-success'
	);

	/**
	 * Array of languages to be used
	 * when i18n_enabled is set to true.
	 * @var array
	 */
	private $_languages = array('aa' => 'afar', 'ab' => 'abkhazian', 'ae' => 'avestan', 'af' => 'afrikaans', 'ak' => 'akan', 'am' => 'amharic', 'an' => 'aragonese', 'ar' => 'arabic', 'as' => 'assamese', 'av' => 'avaric', 'ay' => 'aymara', 'az' => 'azerbaijani', 'ba' => 'bashkir', 'be' => 'belarusian', 'bg' => 'bulgarian', 'bh' => 'bihari', 'bi' => 'bislama', 'bm' => 'bambara', 'bn' => 'bengali', 'bo' => 'tibetan', 'br' => 'breton', 'bs' => 'bosnian', 'ca' => 'catalan', 'ce' => 'chechen', 'ch' => 'chamorro', 'co' => 'corsican', 'cr' => 'cree', 'cs' => 'czech', 'cu' => 'church-slavic', 'cv' => 'chuvash', 'cy' => 'welsh', 'da' => 'danish', 'de' => 'german', 'dv' => 'divehi', 'dz' => 'dzongkha', 'ee' => 'ewe', 'el' => 'greek', 'en' => 'english', 'eo' => 'esperanto', 'es' => 'spanish', 'et' => 'estonian', 'eu' => 'basque', 'fa' => 'persian', 'ff' => 'fulah', 'fi' => 'finnish', 'fj' => 'fijian', 'fo' => 'faroese', 'fr' => 'french', 'fy' => 'western-frisian', 'ga' => 'irish', 'gd' => 'scottish-gaelic', 'gl' => 'galician', 'gn' => 'guarani', 'gu' => 'gujarati', 'gv' => 'manx', 'ha' => 'hausa', 'he' => 'hebrew', 'hi' => 'hindi', 'ho' => 'hiri-motu', 'hr' => 'croatian', 'ht' => 'haitian', 'hu' => 'hungarian', 'hy' => 'armenian', 'hz' => 'herero', 'ia' => 'interlingua', 'id' => 'indonesian', 'ie' => 'interlingue', 'ig' => 'igbo', 'ii' => 'sichuan-yi', 'ik' => 'inupiaq', 'io' => 'ido', 'is' => 'icelandic', 'it' => 'italian', 'iu' => 'inuktitut', 'ja' => 'japanese', 'jv' => 'javanese', 'ka' => 'georgian', 'kg' => 'kongo', 'ki' => 'kikuyu', 'kj' => 'kwanyama', 'kk' => 'kazakh', 'kl' => 'kalaallisut', 'km' => 'khmer', 'kn' => 'kannada', 'ko' => 'korean', 'kr' => 'kanuri', 'ks' => 'kashmiri', 'ku' => 'kurdish', 'kv' => 'komi', 'kw' => 'cornish', 'ky' => 'kirghiz', 'la' => 'latin', 'lb' => 'luxembourgish', 'lg' => 'ganda', 'li' => 'limburgish', 'ln' => 'lingala', 'lo' => 'lao', 'lt' => 'lithuanian', 'lu' => 'luba-katanga', 'lv' => 'latvian', 'mg' => 'malagasy', 'mh' => 'marshallese', 'mi' => 'maori', 'mk' => 'macedonian', 'ml' => 'malayalam', 'mn' => 'mongolian', 'mr' => 'marathi', 'ms' => 'malay', 'mt' => 'maltese', 'my' => 'burmese', 'na' => 'nauru', 'nb' => 'norwegian-bokmal', 'nd' => 'north-ndebele', 'ne' => 'nepali', 'ng' => 'ndonga', 'nl' => 'dutch', 'nn' => 'norwegian-nynorsk', 'no' => 'norwegian', 'nr' => 'south-ndebele', 'nv' => 'navajo', 'ny' => 'chichewa', 'oc' => 'occitan', 'oj' => 'ojibwa', 'om' => 'oromo', 'or' => 'oriya', 'os' => 'ossetian', 'pa' => 'panjabi', 'pi' => 'pali', 'pl' => 'polish', 'ps' => 'pashto', 'pt' => 'portuguese', 'qu' => 'quechua', 'rm' => 'raeto-romance', 'rn' => 'kirundi', 'ro' => 'romanian', 'ru' => 'russian', 'rw' => 'kinyarwanda', 'sa' => 'sanskrit', 'sc' => 'sardinian', 'sd' => 'sindhi', 'se' => 'northern-sami', 'sg' => 'sango', 'si' => 'sinhala', 'sk' => 'slovak', 'sl' => 'slovenian', 'sm' => 'samoan', 'sn' => 'shona', 'so' => 'somali', 'sq' => 'albanian', 'sr' => 'serbian', 'ss' => 'swati', 'st' => 'southern-sotho', 'su' => 'sundanese', 'sv' => 'swedish', 'sw' => 'swahili', 'ta' => 'tamil', 'te' => 'telugu', 'tg' => 'tajik', 'th' => 'thai', 'ti' => 'tigrinya', 'tk' => 'turkmen', 'tl' => 'tagalog', 'tn' => 'tswana', 'to' => 'tonga', 'tr' => 'turkish', 'ts' => 'tsonga', 'tt' => 'tatar', 'tw' => 'twi', 'ty' => 'tahitian', 'ug' => 'uighur', 'uk' => 'ukrainian', 'ur' => 'urdu', 'uz' => 'uzbek', 've' => 'venda', 'vi' => 'vietnamese', 'vo' => 'volapuk', 'wa' => 'walloon', 'wo' => 'wolof', 'xh' => 'xhosa', 'yi' => 'yiddish', 'yo' => 'yoruba', 'za' => 'zhuang', 'zh' => 'chinese', 'zu' => 'zul');

	/**
	 * Whether to force multilingual use or not.
	 * @var boolean
	 */
	private $_i18n_enabled = false;

	/**
	 * Instance of CI object
	 * @var 	object
	 */
	private $_ci;

	/**
	 * Default configuration array.
	 * @var array
	 */
	private $_config;

	/**
	 * Array of partial views.
	 * @var  array
	 */
	private $_partials;

	/**
	 * Array of variables to pass to view
	 * @var array
	 */
	private $_data = array();

	/**
	 * Inforation about access to module,
	 * controller and method.
	 */
	public $module = null;
	public $controller = null;
	public $method = null;

	/**
	 * Holds the full path to themes.
	 * @var string
	 */
	private $_themes_folder = 'themes';

	/**
	 * Holds the current theme's name.
	 * @var string
	 */
	private $_theme = null;

	/**
	 * Holds the current theme's language index.
	 * @var string
	 */
	private $_theme_language_index = '';

	/**
	 * Set to true if the language file was loaded.
	 * @var bool
	 */
	private $_theme_lang_loaded = false;

	/**
	 * Holds an object of the current theme's details.
	 * @var  object
	 */
	private $_theme_details;

	/**
	 * Holds the currently used layout.
	 * @var string
	 */
	private $_layout = null;

	/**
	 * Holds the currently loaded view.
	 * @var string
	 */
	private $_view = null;

	/**
	 * Holds the realpath to theme's folder.
	 * @var  string
	 */
	private $_theme_path;

	/**
	 * Holds the realpath to theme's views folder.
	 * @var string
	 */
	private $_views_path;

	/**
	 * Holds the realpath to theme's layouts folder.
	 * @var string
	 */
	private $_layouts_path;

	/**
	 * Array of <html> tag classes.
	 * @var array
	 */
	private $_html_classes = array();

	/**
	 * Array of <html> lang attribute.
	 * @var array
	 */
	private $_lang_attrs = array();

	/**
	 * Array of site's charsets.
	 * @var  array
	 */
	private $_charsets = array();

	/**
	 * Holds the current page's title.
	 * @var  string
	 */
	private $_title = null;

	/**
	 * Holds the page's title parts separator.
	 * @var string
	 */
	private $_title_sep = '&#150;';

	/**
	 * Holds an array of all <meta> tags.
	 * @var  array
	 */
	private $_metadata = array();

	/**
	 * Array of stylesheets to add first.
	 * @var array
	 */
	private $_prepended_styles = array();

	/**
	 * Array of stylesheets
	 * @var array
	 */
	private $_styles = array();

	/**
	 * Array of inline styles.
	 * @var array
	 */
	private $_inline_styles = array();

	/**
	 * Array of remove styles.
	 * @var array
	 */
	private $_removed_styles = array();

	/**
	 * Extra string to use on {extra_head}
	 * @var string
	 */
	private $_extra_head = null;

	/**
	 * This flag is used to check if the header output was
	 * called or not so we call it in case it wasn't.
	 * @var boolean
	 */
	private $_header_called = false;

	/**
	 * This flag is used to check if the footer output was
	 * called or not so we call it in case it wasn't.
	 * @var boolean
	 */
	private $_footer_called = false;

	/**
	 * body classes.
	 * @var array
	 */
	private $_body_classes = array();

	/**
	 * Holds the current view content.
	 * @var string
	 */
	private $_the_content;

	/**
	 * Array of scripts to be put first.
	 * @var array
	 */
	private $_prepended_scripts = array();

	/**
	 * Array of JavaScripts files.
	 * @var array
	 */
	private $_scripts = array();

	/**
	 * Array of inline scripts to output.
	 * @var array
	 */
	private $_inline_scripts = array();

	/**
	 * Array of removed scripts
	 * @var array
	 */
	private $_removed_scripts = array();

	/**
	 * Array of generated alert messages
	 * @var array
	 */
	private $_messages;

	/**
	 * Whether to detect browser details or not.
	 * @var  boolean
	 */
	private $_detect_browser = false;

	/**
	 * Array of client browser's details.
	 * @var array
	 */
	private $_client = array();

	/**
	 * Set to true if on mobile browser.
	 * @var boolean
	 */
	private $_is_mobile = false;

	/**
	 * Put default preferences into class' property so
	 * they can be overriden later.
	 * @var array
	 */
	private $_defaults = array(
		'theme' => 'default',
		'title_sep' => '&#150;',
		'compress' => false,
		'cache_lifetime' => 0,
		'cdn_enabled' => false,
		'cdn_server' => null,
		'site_name' => 'CI-Theme',
		'site_description' => 'Simply makes your CI-based applications themable. Easy and fun to use.',
		'site_keywords' => 'codeigniter, themes, libraries, bkader, bouyakoub'
	);

	/**
	 * Constructor
	 */
	public function __construct($config = array())
	{
		$this->_config = $config;
		// Prepare instance of CI object
		$this->_ci =& get_instance();

		// Make sure URL helper is load then we load our helper
		(function_exists('base_url')) or $this->_ci->load->helper('url');

		// Initialize preferences.
		$this->_charsets[] = $this->_ci->config->item('charset');

		log_message('debug', 'Theme Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize class preferences.
	 *
	 * @param 	array 	$config
	 * @return 	void
	 */
	public function _initialize()
	{
		$this->_ci->benchmark->mark('theme_initialize_start');

		$config = array_replace_recursive($this->_defaults, $this->_config);

		foreach ($this->_defaults as $key => $val) {
			if ($item = $this->_ci->config->item($key)) {
				$config[$key] = $item;
			}
		}
		unset($key, $val, $item);

		// Create class properties.
		foreach ($config as $key => $val) {
			// Just to add spaces before
			// and after title separator.
			if ($key == 'title_sep') {
				$this->_title_sep = ' ' . trim($val) . ' ';
			} else {
				$this->{'_' . $key} = $val;
			}
		}

		// Let's store accessed module, controller and methods.
		$this->module     = (method_exists($this->_ci->router, 'fetch_module')) ? $this->_ci->router->fetch_module() : null;
		$this->controller = $this->_ci->router->fetch_class();
		$this->method     = $this->_ci->router->fetch_method();

		// We store the real path to theme's folder.
		$this->_theme_path = realpath(FCPATH . "{$this->_themes_folder}/{$this->_theme}");
		($this->_theme_path) && $this->_theme_path .= DS;

		// If the path to the theme was not found!
		if (false === $this->_theme_path) {
			// We do nothing on admin area.
			if ($this->controller === 'admin') {
				return;
			}

			// Simply die();
			die();
		}

		// Make sure the selected theme exists!
		if (false === $this->_theme_path) {
			show_error("The theme your are currently using does not exist. Theme: '{$this->_theme}'");
		}

		// Define a constant that can be used everywhere.
		defined('THEME_PATH') OR define('THEME_PATH', $this->_theme_path);

		// Check if it's a mobile client.
		(class_exists('CI_User_agent', false)) OR $this->_ci->load->library('user_agent');
		$this->_is_mobile = $this->_ci->agent->is_mobile();

		// Let's detect client browser's details.
		$this->__detect_browser();

		// Handle language.
		$this->__i18n();

		if (!is_file($this->_theme_path . 'functions.php')) {
			show_error("Unable to locate the theme's 'functions.php' file.");
		}

		include_once $this->_theme_path . 'functions.php';

		/**
		 * Here we are some default variables that you can
		 * use on yout views.
		 */
		$this->set('uri_string', uri_string(), true);

		// Benchmark for eventual use.
		$this->_ci->benchmark->mark('theme_initialize_end');
	}

	// --------------------------------------------------------------------

	/**
	 * By using this magic method I could handle the
	 * do_action('init').
	 *
	 * @access 	public
	 * @param 	string 	$method 	the method to call.
	 * @param 	array 	$params 	arguments to pass to method.
	 * @return 	depends on the called method.
	 */
	public function __call($method, $params = array())
	{
		// We throw a BadMethodCallException if no method exists.
		if (!method_exists($this, '_' . $method)) {
			throw new BadMethodCallException("No such method: " . get_called_class() . "::{$method}().");
		}

		// All our methods have a prepended underscore.
		$_method = '_' . $method;

		/**
		 * By using the ReflectionMethod class we make sure to
		 * call only public or protected method but never
		 * private one.
		 */
		$reflection = new ReflectionMethod($this, $_method);

		if ($reflection->isPrivate()) {
			throw new BadMethodCallException("Call to a private method " . get_called_class() . "::{$method}()");
		}

		// Initialize class.
		$this->_initialize();

		return call_user_func_array(array($this, $_method), $params);
	}

	// ------------------------------------------------------------------------

	/**
	 * Remove all filters and actions.
	 * @access 	protected
	 * @return 	void
	 */
	protected function _reset()
	{
		$filters = array(
			'after_metadata',
			'after_scripts',
			'after_styles',
			'after_theme_setup',
			'alert_classes',
			'alert_classes',
			'alert_template',
			'alert_template',
			'before_metadata',
			'before_scripts',
			'before_styles',
			'body_class',
			'enqueue_metadata',
			'enqueue_partials',
			'enqueue_scripts',
			'enqueue_styles',
			'extra_head',
			'html_class',
			'init',
			'language_attributes',
			'the_charset',
			'the_content',
			'the_title',
			'theme_layout',
			'theme_layout',
			'theme_layout_fallback',
			'theme_layouts_path',
			'theme_menus',
			'theme_partial_fallback',
			'theme_partials_path',
			'theme_translation',
			'theme_view',
			'theme_view_fallback',
			'theme_views_path',
		);

		// Exclude filters?
		if ( ! empty($args = func_get_args()))
		{
			(is_array($args[0])) && $args = $args[0];
			$filters = array_diff($filters, $args);
		}

		array_map('remove_all_filters', $filters);
	}

	// --------------------------------------------------------------------

	/**
	 * Returns an array of themes details objects.
	 * @access 	public
	 * @param 	none
	 * @return 	array of objects.
	 */
	public function get_themes()
	{
		// Prepare an empty array of folders.
		$folders = array();

		// Let's go through folders and check if there are any.
		if ($handle = opendir($this->_themes_folder)) {
			$_to_eliminate = array(
				'.',
				'..',
				'index.html',
				'.htaccess'
			);

			while (false !== ($file = readdir($handle))) {
				if (!in_array($file, $_to_eliminate)) {
					$folders[] = $file;
				}
			}
		}

		// If there are any folders present, we get themes details.
		if (!empty($folders)) {
			foreach ($folders as $key => $folder) {
				// A theme is valid ONLY if it has the 'theme_infp.php' file.
				if (false !== realpath(FCPATH . "{$this->_themes_folder}/{$folder}/manifest.json")) {
					$folders[$folder] = $this->__get_theme_details($folder);
				}
				unset($folders[$key]);
			}
		}

		// Now we return the final result.
		return $folders;
	}

	/**
	 * Return details about a given theme.
	 * @access 	private
	 * @param 	string 	$theme 	the theme's folder name.
	 * @return 	object if found or false.
	 */
	private function __get_theme_details($folder)
	{
		// Prepare the path to the manifest.json file.
		$theme_info = FCPATH . "{$this->_themes_folder}/{$folder}/manifest.json";

		// Make sure the file exists.
		if (!is_file($theme_info)) {
			show_error("Unable to locate the theme's info file: {$theme_info}");
		}

		// Get the manifest.json file content na json_decode it.
		$manifest = file_get_contents($theme_info);
		$manifest = json_decode($manifest, true);

		// If it's no a valid array.
		if (!is_array($manifest))
		{
			show_error("The 'manifest.json' file of the theme '{$folder}' does not contain a valid array.");
		}

		/**
		 * If the theme preview (default: screenshot.jpg) is
		 * set but not a valid URL, we set it.
		 */
		if (isset($manifest['screenshot'])
			&& false === filter_var($manifest['screenshot'], FILTER_VALIDATE_URL)) {
			$manifest['screenshot'] = $this->_themes_url("{$folder}/{$manifest['screenshot']}");
		}
		/**
		 * In case it was not set but if preview file
		 * exists, we add it automatically.
		 */
		elseif (!isset($manifest['screenshot'])
			&& false !== ($this->_theme_path('screenshot.jpg'))) {
			$manifest['screenshot'] = $this->_themes_url('screenshot.jpg');
		}
		// Otherwise, set it to false for later use.
		else {
			$manifest['screenshot'] = false;
		}

		// Always add the folder name to the array.
		$manifest['folder'] = $folder;

		// Prepare array of default headers.
		$defaults = array(
			'name'         => null,
			'folder'       => null,
			'theme_uri'    => null,
			'description'  => null,
			'version'      => null,
			'license'      => null,
			'license_uri'  => null,
			'author'       => null,
			'author_uri'   => null,
			'author_email' => null,
			'tags'         => null,
			'screenshot'   => null,
		);

		// Replace defaults and return the result.
		return array_replace($defaults, $manifest);
	}

	/**
	 * Returns the theme's details.
	 * @access 	public
	 * @param 	string 	$key 	to return a single item.
	 * @return 	object|string
	 */
	public function theme_details($key = null)
	{
		if (isset($this->_theme_details)) {
			$return = $this->_theme_details;
		} else {
			$return = $this->__get_theme_details($this->_theme);
		}

		return (isset($return->{$key})) ? $return->{$key} : $return;
	}

	// --------------------------------------------------------------------
	// Setters
	// --------------------------------------------------------------------

	/**
	 * Add variables to views.
	 * @access 	public
	 * @param 	string 	$name 	variable's name.
	 * @param 	mixed 	$value 	variable's value.
	 * @param 	bool 	$global 	whether to make it global or not.
	 * @return 	object
	 */
	public function set($name, $value = null, $global = false)
	{
		/**
		 * In case of multiple items to be set, $value will be
		 * treated as $global and this one is simply ignored.
		 */
		if (is_array($name)) {
			$global = (bool) $value;

			foreach ($name as $key => $val) {
				$this->set($key, $val, $global);
			}

			return $this;
		}

		if ($global === true) {
			$this->_ci->load->vars($name, $value);
			return $this;
		}

		$this->_data[$name] = $value;
		return $this;
	}

	// --------------------------------------------------------------------
	// Theme Functions
	// --------------------------------------------------------------------

	/**
	 * Returns path to where themes are located.
	 * @access 	protected
	 * @param 	string 	$uri
	 * @return 	string if valid, else false.
	 */
	protected function _themes_path($uri = '')
	{
		if ($uri == '') {
			return realpath(FCPATH . "{$this->_themes_folder}/{$uri}") . DS;
		}

		return realpath(FCPATH . "{$this->_themes_folder}/{$uri}");
	}

	/**
	 * Returns URI to the folder containing themes.
	 * @access 	protected
	 * @param 	none
	 * @return 	string
	 */
	protected function _themes_url($uri = '')
	{
		return base_url("{$this->_themes_folder}/{$uri}");
	}

	/**
	 * Changes the currently used theme.
	 * @access 	protected
	 * @param 	string 	$theme 	the theme's name.
	 * @return 	object
	 */
	protected function _set_theme($theme = 'default')
	{
		// Reset all.
		$this->_reset();

		// Change config item.
		$this->_ci->config->set_item('theme', $theme);
		return $this;
	}

	/**
	 * Returns the current theme's name.
	 * @access 	protected
	 * @return 	string.
	 */
	protected function _get_theme()
	{
		return $this->_theme;
	}

	/**
	 * Returns theme url.
	 * @access 	protected
	 * @param 	string 	$uri 	uri to append to url.
	 * @return 	string.
	 */
	protected function _theme_url($uri = '')
	{
		if (true === $this->cdn_enabled()) {
			return "{$this->_cdn_server}{$this->_themes_folder}/{$this->_theme}/{$uri}";
		}

		return base_url("{$this->_themes_folder}/{$this->_theme}/{$uri}");
	}

	/**
	 * Returns a path to a folder or file in theme's folder.
	 * @access 	protected
	 * @param 	string 	$uri
	 * @return 	string if found, else false.
	 */
	protected function _theme_path($uri = '')
	{
		return realpath("{$this->_theme_path}/$uri");
	}

	// --------------------------------------------------------------------
	// Uploads and Common URLs and Path
	// --------------------------------------------------------------------

	/**
	 * Return a URL to the uploads folder.
	 * @access 	protected
	 * @param 	string 	$uri
	 * @return 	string
	 */
	protected function _upload_url($uri = '')
	{
		if (true === $this->cdn_enabled()) {
			return "{$this->_cdn_server}{$this->_uploads_folder}/{$uri}";
		}

		return base_url("{$this->_uploads_folder}/{$uri}");
	}

	/**
	 * Returns the realpath to the uploads folder.
	 * @access 	protected
	 * @param 	string 	$uri
	 * @return 	string if found, else false.
	 */
	protected function _upload_path($uri = '')
	{
		return realpath(FCPATH . "{$this->_uploads_folder}/{$uri}");
	}

	/**
	 * Return a URL to the common folder.
	 * @access 	protected
	 * @param 	string 	$uri
	 * @return 	string
	 */
	protected function _common_url($uri = '')
	{
		if (true === $this->cdn_enabled()) {
			return "{$this->_cdn_server}{$this->_common_folder}/{$uri}";
		}

		return base_url("{$this->_common_folder}/{$uri}");
	}

	/**
	 * Returns the realpath to the common folder.
	 * @access 	protected
	 * @param 	string 	$uri
	 * @return 	string if found, else false.
	 */
	protected function _common_path($uri = '')
	{
		return realpath(FCPATH . "{$this->_common_folder}/{$uri}");
	}

	// --------------------------------------------------------------------
	// Layout Setter and Getter.
	// --------------------------------------------------------------------

	/**
	 * Changes the currently used layout.
	 * @access 	protected
	 * @param 	string 	$layout 	the layout's name.
	 * @return 	object
	 */
	protected function _set_layout($layout = 'default')
	{
		$this->_layout = $layout;
		return $this;
	}

	/**
	 * Returns the current layout's name.
	 * @access 	protected
	 * @return 	string.
	 */
	protected function _get_layout()
	{
		$this->_layout = apply_filters('theme_layout', $this->_layout);

		return $this->_layout;
	}

	// --------------------------------------------------------------------
	// View file Setter and Getter.
	// --------------------------------------------------------------------

	/**
	 * Changes the currently used view.
	 * @access 	protected
	 * @param 	string 	$view 	the view's name.
	 * @return 	object
	 */
	protected function _set_view($view = null)
	{
		$this->_view = $view;
		return $this;
	}

	/**
	 * Returns the current view's name.
	 * @access 	protected
	 * @return 	string.
	 */
	protected function _get_view()
	{
		// Make sure the view is set.
		(isset($this->_view)) OR $this->_view = $this->__guess_view();

		// See if there are any filters applied here.
		$this->_view = apply_filters('theme_view', $this->_view);

		return $this->_view;
	}

	/**
	 * Attempt to guess the view file.
	 * @access 	private
	 * @return 	string.
	 */
	private function __guess_view()
	{
		$view = "{$this->controller}/{$this->method}";

		if (isset($this->module) 
			&& $this->module !== null 
			&& $this->module <> $this->controller) {
			$view = "{$this->module}/{$view}";
		}

		return $view;
	}

	// --------------------------------------------------------------------
	// Cache setter.
	// --------------------------------------------------------------------

	/**
	 * Set cache time.
	 * @access 	protected
	 * @param 	int 	$minutes
	 * @return 	object
	 */
	protected function _set_cache($minutes = 0)
	{
		add_action('init', function() use ($minutes)
		{
			$this->_cache_lifetime = $minutes;
		});
		return $this;
	}

	// --------------------------------------------------------------------
	// Title Setter and Getter
	// --------------------------------------------------------------------

	/**
	 * Sets the page title.
	 * @access 	protected
	 * @param 	string 	$title
	 * @return 	object
	 */
	protected function _set_title()
	{
		$args = func_get_args();
		if ( ! empty($args))
		{
			(is_array($args[0])) && $args = $args[0];
			$this->_title = implode(': ', $args);
		}
		return $this;
	}

	/**
	 * Returns the current page's title.
	 * @access 	protected
	 * @param 	string 	$before 	string to be prepended.
	 * @param 	string 	$after 		string to be appended.
	 * @return 	string
	 */
	protected function _get_title($before = null, $after = null)
	{
		(is_array($this->_title)) OR $this->_title = array(
			$this->_title
		);

		$this->_title = array_filter($this->_title);

		// If the title is empty, we guess.
		(empty($this->_title)) && $this->_title = $this->__guess_title();

		// Apply filter if there are any.
		$this->_title = apply_filters('the_title', $this->_title);

		if ($before !== null) {
			array_unshift($this->_title, $before);
		}

		if ($after !== null) {
			$this->_title[] = $after;
		}

		// Create the title string.
		$this->_title = implode($this->_title_sep, $this->_title);

		// Return the title.
		return $before . $this->_title . $after;
	}

	/**
	 * Attempt to guess the title if it's not set.
	 * @access 	private
	 * @return 	array
	 */
	private function __guess_title()
	{
		$temp_title = array(
			$this->method
		);


		if ($this->controller != $this->method) {
			array_unshift($temp_title, $this->controller);
		}

		if (isset($this->module) && $this->module !== null && $this->module <> $this->controller) {
			array_unshift($temp_title, $this->module);
		}

		$temp_title = array_filter(array_map('ucwords', $temp_title));
		$title      = implode($this->_title_sep, $temp_title);
		return array(
			$title
		);
	}

	// --------------------------------------------------------------------
	// Metadata Functions
	// --------------------------------------------------------------------

	/**
	 * Appends meta tags
	 * @access 	protected
	 * @param 	mixed 	$name 	meta tag's name
	 * @param 	mixed 	$content
	 * @return 	object
	 */
	protected function _add_meta($name, $content = null, $type = 'meta', $attrs = array())
	{
		// In case of multiple elements
		if (is_array($name)) {
			foreach ($name as $key => $val) {
				$this->add_meta($key, $val, $type, $attrs);
			}

			return $this;
		}

		$this->_metadata[$type . '::' . $name] = array(
			'content' => $content
		);
		(empty($attrs)) OR $this->_metadata[$type . '::' . $name]['attrs'] = $attrs;

		return $this;
	}

	/**
	 * Returns all cached metadata.
	 * @access 	protected
	 * @return 	array
	 */
	protected function _get_meta()
	{
		return $this->_metadata;
	}

	/**
	 * Takes all site meta tags and prepare the output string.
	 * @access 	protected
	 * @return 	string
	 */
	protected function _output_metadata()
	{
		// If there are any 'before_metadata', apply them.
		$metadata = apply_filters('before_metadata', '');

		// Append our output metadata.
		$metadata .= $this->__render_metadata();

		// If there are any 'after_metadata', apply them.
		$metadata = apply_filters('after_metadata', $metadata);

		return $metadata;
	}

	/**
	 * Collectes all additional metadata and prepare them for output
	 * @access 	private
	 * @param 	none
	 * @return 	string
	 */
	private function __render_metadata()
	{
		// If there are any enqueued meta tags from functions, add them.
		do_action('enqueue_metadata');

		// Kick off with an empty output.
		$output = '';

		$i = 1;
		$j = count($this->_metadata);

		foreach ($this->_metadata as $key => $val) {
			list($type, $name) = explode('::', $key);
			$content = isset($val['content']) ? $val['content'] : null;
			$attrs   = isset($val['attrs']) ? $val['attrs'] : null;
			$output .= meta_tag($name, $content, $type, $attrs).($i === $j ? '' : "\n\t");

			$i++;
		}

		return $output;
	}

	// --------------------------------------------------------------------
	// Assets Handlers.
	// --------------------------------------------------------------------

	/**
	 * Add any type of CSS of JS files.
	 * @access 	public
	 * @param 	string 	$type 		type of file to add.
	 * @param 	string 	$file 		the file to add.
	 * @param 	string 	$handle 	the ID of the file.
	 * @param 	int 	$ver 		the version of the file.
	 * @param 	bool 	$prepend 	the file should be appended or prepended
	 * @return 	object 	instance of this class.
	 */
	public function add($type = 'css', $file = null, $handle = null, $ver = null, $prepend = false, array $attrs = array())
	{
		// If no file provided, nothing to do.
		if (empty($file)) {
			return $this;
		}

		// We start by removing the extension.
		$file = $this->__remove_extension($file, $type);

		// If the $handle is not provided, we generate it.
		if (empty($handle)) {
			// We remplace all dots by dashes.
			$handle = preg_replace('/\./', '-', basename($file));
			$handle = preg_replace("/-{$type}$/", '', $handle) . "-{$type}";
		} else {
			$handle           = preg_replace("/-{$type}$/", '', $handle) . "-{$type}";
			$attributes['id'] = $handle;
		}

		/**
		 * If the file is a full url (cdn or using get_theme_url(..))
		 * we use as it is, otherwise, we force get_theme_url()
		 */
		if (false === filter_var($file, FILTER_VALIDATE_URL)) {
			$file = $this->_theme_url($file);
		}

		// If the version is provided, use it.
		if (!empty($ver)) {
			$file .= "?ver={$ver}";
		}

		if ($type == 'css') {
			$attributes['rel']  = 'stylesheet';
			$attributes['type'] = 'text/css';
			$attributes['href'] = $file;
		} else // js file.
			{
			$attributes['type'] = 'text/javascript';
			$attributes['src']  = $file;
		}

		// Merge any additional attributes.
		$attributes = array_replace_recursive($attributes, $attrs);

		// Files to target.
		$files = ('css' == $type) ? '_styles' : '_scripts';

		// Prepended files to target.
		$prepended = ('css' == $type) ? '_prepended_styles' : '_prepended_scripts';

		// Should the file be prepended.
		if (true === $prepend OR 'jquery-js' == $handle) {
			// We first add it to the $prepended_xx array.
			$this->{$prepended}[$handle] = $attributes;

			// We merge everything.
			$this->{$files} = array_replace_recursive($this->{$prepended}, (array) $this->{$files});

			// Don't go further.
			return $this;
		}

		$this->{$files}[$handle] = $attributes;
		return $this;
	}

	/**
	 * Simply remove any added files.
	 * @access 	public
	 * @param 	string 	$type 		the file's type to remove.
	 * @param 	string 	$handle 	the file key.
	 * @param 	string 	$group 		what group to target.
	 * @return 	void
	 */
	public function remove($type = 'css', $handle = null)
	{
		// If no $handle provided, nothing to do, sorry!
		if (empty($handle)) {
			return $this;
		}

		// Let's make $handle nicer :)/
		$handle = preg_replace("/-{$type}$/", '', $handle) . "-{$type}";

		if ($type == 'css') {
			$this->_removed_styles[] = $handle;
			unset($this->_styles[$handle]);
		} else {
			$this->_removed_scripts[] = $handle;
			unset($this->_scripts[$handle]);
		}


		return $this;
	}

	/**
	 * Remplaces any file by another.
	 * @access 	public
	 * @param 	string 	$type 		type of file to add.
	 * @param 	string 	$file 		the file to add.
	 * @param 	string 	$handle 	the ID of the file.
	 * @param 	int 	$ver 		the version of the file.
	 * @param 	bool 	$attrs 		new files attributes.
	 * @return 	object 	instance of this class.
	 */
	/**
	 * Replaces a file with another one.
	 */
	public function replace($type = 'css', $file = null, $handle = null, $ver = null, array $attrs = array())
	{
		// If no file provided, nothing to do.
		if (empty($file)) {
			return $this;
		}

		// We start by removing the extension.
		$file = $this->__remove_extension($file, $type);

		// If the $handle is not provided, we generate it.
		if (empty($handle)) {
			// We remplace all dots by dashes.
			$handle = preg_replace('/\./', '-', basename($file));
			$handle = preg_replace("/-{$type}$/", '', $handle) . "-{$type}";
		} else {
			$handle           = preg_replace("/-{$type}$/", '', $handle) . "-{$type}";
			$attributes['id'] = $handle;
		}

		/**
		 * If the file is a full url (cdn or using get_theme_url(..))
		 * we use as it is, otherwise, we force get_theme_url()
		 */
		if (false === filter_var($file, FILTER_VALIDATE_URL)) {
			$file = $this->_theme_url($file);
		}

		// If the version is provided, use it.
		if (!empty($ver)) {
			$file .= "?ver={$ver}";
		}

		if ($type == 'css') {
			$attributes['rel']  = 'stylesheet';
			$attributes['type'] = 'text/css';
			$attributes['href'] = $file;
		} else // js file.
			{
			$attributes['type'] = 'text/javascript';
			$attributes['src']  = $file;
		}

		// Merge any additional attributes.
		$attributes = array_replace_recursive($attributes, $attrs);

		// We replace the file if found.

		if ($type == 'css') {
			$this->_styles[$handle] = $attributes;
		} else {
			$this->_scripts[$handle] = $attributes;
		}
		return $this;
	}

	/**
	 * Allows user to add inline elements (CSS or JS)
	 * @access 	public
	 * @param 	string 	$type 		the file's type to add.
	 * @param 	string 	$content 	the inline content.
	 * @param 	string 	$handle 	before which handle the content should be output.
	 * @return 	object
	 */
	public function add_inline($type = 'css', $content = '', $handle = null)
	{
		$handle = preg_replace("/-{$type}$/", '', $handle) . "-{$type}";

		// In case of inline styles.
		if ('css' == $type) {
			$this->_inline_styles[$handle] = $content;
		}

		// In case of inline scripts.
		elseif ('js' == $type) {
			$this->_inline_scripts[$handle] = $content;
		}

		return $this;
	}

	// --------------------------------------------------------------------
	// CSS Functions
	// --------------------------------------------------------------------

	/**
	 * Returns the array of loaded CSS files
	 * @access 	protected
	 * @param 	none
	 * @return 	array
	 */
	protected function _get_css()
	{
		return $this->_styles;
	}

	/**
	 * Outputs all site stylesheets and inline styes string.
	 * @return 	string
	 */
	protected function _output_styles()
	{
		$styles = '';

		// Any before styles filters?
		$styles = apply_filters('before_styles', $styles);

		// Render all enqueued ones.
		$styles .= $this->__render_styles();

		// Any after styles filters?
		$styles = apply_filters('after_styles', $styles);

		return $styles;
	}

	/**
	 * Collect all additional CSS files and prepare them for output
	 * @access 	private
	 * @param 	none
	 * @return 	string
	 */
	private function __render_styles()
	{
		$output = '';

		do_action('enqueue_styles');

		$i = 1;
		$j = count($this->_styles);
		foreach ($this->_styles as $handle => $file) {
			if (isset($this->_inline_styles[$handle])) {
				$output .= $this->_inline_styles[$handle] . "\n\t";
				unset($this->_inline_styles[$handle]);
			}

			if (false !== $file) {
				$output .= '<link' . _stringify_attributes($file) . ' />' . ($i === $j ? '' : "\n\t");
			}
			$i++;
		}

		if (!empty($this->_inline_styles)) {
			$output .= implode("\n\t", $this->_inline_styles);
		}

		return $output;
	}

	// --------------------------------------------------------------------
	// JS Functions
	// --------------------------------------------------------------------

	/**
	 * Returns the array of loaded JS files
	 * @access 	protected
	 * @param 	none
	 * @return 	array
	 */
	protected function _get_js()
	{
		return $this->_scripts;
	}

	/**
	 * Outputs all script tags and inline scripts.
	 * @access 	protected
	 * @return 	string
	 */
	protected function _output_scripts()
	{
		$scripts = '';

		// Any before scripts filters?
		$scripts = apply_filters('before_scripts', $scripts) . "\t";

		// Render all enqueued ones.
		$scripts .= $this->__render_scripts();

		// Any after scripts filters?
		$scripts = apply_filters('after_scripts', $scripts) . "\t";

		return $scripts;
	}

	/**
	 * Collect all additional JS files and prepare them for output
	 * @access 	private
	 * @param 	none
	 * @return 	string
	 */
	private function __render_scripts()
	{
		$output = '';

		do_action('enqueue_scripts');

		$i = 1;
		$j = count($this->_scripts);

		if (!empty($this->_scripts)) {
			foreach ($this->_scripts as $handle => $file) {
				if (isset($this->_inline_scripts[$handle])) {
					$output .= $this->_inline_scripts[$handle] . "\n\t";
					unset($this->_inline_scripts[$handle]);
				}

				if (false !== $file) {
					$output .= '<script' . _stringify_attributes($file) . '></script>' . ($i === $j ? '' : "\n\t");
				}

				$i++;
			}
		}

		if (!empty($this->_inline_scripts)) {
			$output .= implode("\n\t", $this->_inline_scripts);
		}

		return $output;
	}

	// --------------------------------------------------------------------
	// Google Analytics Output
	// --------------------------------------------------------------------

	/**
	 * Outputs the default google analytics code.
	 * @access 	protected
	 * @param 	string 	$site_id 	Google Analytics ID
	 * @return 	string
	 */
	protected function _output_analytics($site_id = null)
	{
		// Get the default Google analytics ID.
		($site_id) OR $site_id = $this->_ci->config->item('google_analytics_id');
		$output = "";
		if ($site_id !== 'UA-XXXXX-Y' && $site_id !== null) {
			$output = str_replace('{site_id}', $site_id, $this->_template_google_analytics) . "\n";
		}
		return $output;
	}

	// --------------------------------------------------------------------
	// Extra head function.
	// --------------------------------------------------------------------

	/**
	 * Outputs all additional head string.
	 * @access 	protected
	 * @return 	string
	 */
	protected function _output_extra_head()
	{
		// If there any extra head filters, add them.
		return apply_filters('extra_head', "\n");
	}

	// --------------------------------------------------------------------
	// Partial Views Functions
	// --------------------------------------------------------------------

	/**
	 * Adds partial view
	 * @access 	protected
	 * @param 	string 	$view 	view file to load
	 * @param 	array 	$data 	array of data to pass
	 * @param 	string 	$name 	name of the variable to use
	 */
	protected function _add_partial($view, $data = array(), $name = null)
	{
		// If $name is not set, we take the last string.
		(empty($name)) && $name = basename($view);

		$this->_partials[$name] = $this->__load_file($view, $data, 'partial');

		return $this;
	}

	/**
	 * Displays a partial view alone.
	 * @access 	protected
	 * @param 	string 	$view 	the partial view name
	 * @param 	array 	$data 	array of data to pass
	 * @param 	bool 	$load 	load it if not cached?
	 * @param 	bool 	$return whether to return or output
	 * @return 	mixed
	 */
	protected function _get_partial($view, $data = array(), $load = true)
	{
		// If partial view is already loaded, return it.
		$name = basename($view);
		if (isset($this->_partials[$name])) {
			return $this->_partials[$name];
		}

		if ($load === true) {
			return $this->__load_file($view, $data, 'partial');
		}

		return null;
	}

	// --------------------------------------------------------------------
	// Header and footer functions
	// --------------------------------------------------------------------

	/**
	 * Returns or ouputs the header file or provided template.
	 * @access 	protected
	 * @param 	string 	$file 	optional header file.
	 * @param 	bool 	$echo 	whether to echo our return.
	 * @return 	string
	 */
	protected function _get_header($file = null)
	{
		/**
		 * If the header file exists, we use it.
		 * This allows the user to override the default
		 * header template provided by the theme
		 */
		($file === null) && $file = 'header';
		$header_file = $this->theme_path(preg_replace('/.php$/', '', $file) . '.php');

		if (file_exists($header_file)) {
			$output = $this->_ci->load->file($header_file, true);
		}

		/**
		 * If the header file is not found, we proceed
		 * to replacements and prepare our output.
		 */
		else {
			// Base url
			$replace['base_url'] = base_url();

			// <html> class.
			$replace['html_class'] = $this->_get_html_class();

			// Language attributes.
			$replace['language_attributes'] = $this->_get_language_attributes();

			// Charset.
			$replace['charset'] = $this->_charset();

			// Page title.
			$replace['title'] = $this->_get_title();

			// Let's add <meta> tags now;
			$replace['metadata'] = $this->_output_metadata();

			// Prepare all stylesheets.
			$replace['stylesheets'] = $this->_output_styles();

			// Any additional extra head?
			$replace['extra_head'] = $this->_output_extra_head();

			// Prepare body class.
			$replace['body_class'] = $this->_body_class();

			$output = $this->_template_header;

			foreach ($replace as $key => $val) {
				$output = str_replace('{' . $key . '}', $val, $output);
			}
		}

		// Change the flag status
		$this->_header_called = true;

		return $output;
	}

	/**
	 * Returns or ouputs the footer file or provided template.
	 * @access 	protected
	 * @param 	string 	$file 	optional footer file.
	 * @param 	bool 	$echo 	whether to echo our return.
	 * @return 	string
	 */
	protected function _get_footer($file = null)
	{
		/**
		 * Let's first add our default javascripts which
		 * can be overriden by on functions.php by whether
		 * replace_js, remove_js or even add_js if the given
		 * $handle is the same.
		 */

		// Add modernizr if not targetted for remove.
		if (isset($this->_removed_scripts) && !in_array('modernizr-js', $this->_removed_scripts)) {
			$modernizr_url = (true === $this->cdn_enabled(false)) ? 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js' : $this->_common_url('js/modernizr-2.8.3.min.js');

			$this->add('js', $modernizr_url, 'modernizr', null, true);

			unset($modernizr_url);
		}

		// Add jQuery if not targetted for remove.
		if (is_array($this->_removed_scripts) && !in_array('jquery-js', $this->_removed_scripts)) {
			$jquery_url = (true === $this->cdn_enabled(false)) ? 'https://code.jquery.com/jquery-3.2.1.min.js' : $this->_common_url('js/jquery-3.2.1.min.js');

			$this->add('js', $jquery_url, 'jquery', null, true);

			unset($jquery_url);
		}

		/**
		 * If the footer file exists, we use it.
		 * This allows the user to override the default
		 * footer template provided by the class.
		 */
		($file === null) && $file = 'footer';
		$footer_file = $this->_theme_path(preg_replace('/.php$/', '', $file) . '.php');

		if (file_exists($footer_file)) {
			$output = $this->_ci->load->file($footer_file, true);
		}
		/**
		 * If the footer file is not found, we proceed
		 * to replacements and prepare our output.
		 */
		else {
			$output = str_replace(array(
				'{javascripts}',
				'{analytics}'
			), array(
				$this->_output_scripts(),
				$this->_output_analytics()
			), $this->_template_footer);
		}

		// Change the flag status
		$this->_footer_called = true;

		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * Return the string to use for get_html_class()
	 * @access 	protected
	 * @param 	string 	$class to add.
	 * @return 	string
	 */
	protected function _get_html_class($class = null)
	{
		// Apply any filters targetting this class.
		$this->_html_classes = apply_filters('html_class', $this->_html_classes);

		// If any class is provided, add it.
		if ($class !== null) {
			$this->_html_classes[] = $class;
		}

		/**
		 * By using the following, we make sure to trim spaces
		 * and remove any duplicate classes.
		 */
		if (!empty($this->_html_classes) && is_array($this->_html_classes)) {
			$this->_html_classes = array_unique(array_map('trim', $this->_html_classes));
		}

		// If there are any classes, we build the attribute.
		if (!empty($this->_html_classes)) {
			return ' class="' . implode(' ', $this->_html_classes) . '"';
		}

		return null;
	}

	// --------------------------------------------------------------------

	/**
	 * Set <html> language attributes.
	 * @access 	protected
	 * @param 	array 	$attributes
	 * @return 	string
	 */
	protected function _get_language_attributes(string $attributes = null)
	{
		// Add the first attributes which is the language set in config.
		$attrs = array(
			substr($this->_ci->config->item('language'), 0, 2)
		);

		// Apply any filters targetting these attributes.
		$attrs = apply_filters('language_attributes', $attrs);

		// If there are any extra attributes, we add them.
		if ($attributes !== null) {
			$attrs[] = $attributes;
		}

		// Trim spaces and remove duplicates.
		$attrs = array_unique(array_map('trim', $attrs));

		// If there are any attributes, we return them.
		if (!empty($attrs)) {
			return ' lang="' . implode(' ', $attrs) . '"';
		}

		return null;
	}

	// --------------------------------------------------------------------

	/**
	 * Return the string to use for get_body_class()
	 * @access 	protected
	 * @param 	string 	$class 	class to add.
	 * @return 	string
	 */
	protected function _body_class($class = null)
	{
		// Apply any filters targetting this class.
		$this->_body_classes = apply_filters('body_class', $this->_body_classes);

		// If any class is provided, add it.
		if ($class !== null) {
			$this->_body_classes[] = $class;
		}

		/**
		 * By using the following, we make sure to trim spaces
		 * and remove any duplicate classes.
		 */
		$this->_body_classes = array_unique(array_map('trim', $this->_body_classes));

		// If there are any classes, we build the attribute.
		if (!empty($this->_body_classes)) {
			return ' class="' . implode(' ', $this->_body_classes) . '"';
		}

		return null;
	}

	/**
	 * Returns the array of body classes.
	 * @access 	protected
	 * @param 	none
	 * @return 	array
	 */
	protected function _get_body_class()
	{
		return $this->_body_classes;
	}

	/**
	 * Returns the <meta> charset tag.
	 * @access 	protected
	 * @param 	string 	$charset
	 * @return 	string 	the full <meta> tag.
	 */
	protected function _charset($charset = null)
	{
		// Let's apply filters targetting it.
		$this->_charsets = apply_filters('the_charset', $this->_charsets);

		// If there are any additional $charset,add it.
		if ($charset !== null) {
			$this->_charsets[] = $charset;
		}

		// Trim space and remplace duplicates.
		$this->_charsets = array_unique(array_map('trim', $this->_charsets));

		if (!empty($this->_charsets)) {
			return '<meta charset="' . implode(' ', $this->_charsets) . '">';
		}

		return null;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns the array of site's charsets.
	 * @access 	protected
	 * @param 	none
	 * @return 	array
	 */
	protected function _get_charset()
	{
		return $this->_charsets;
	}

	// --------------------------------------------------------------------
	// Content functions
	// --------------------------------------------------------------------

	/**
	 * Returns the current view file content.
	 */
	protected function _output_content()
	{
		return $this->_the_content;
	}

	// --------------------------------------------------------------------

	/**
	 * Allow themes to be translated.
	 * @access 	protected
	 * @param 	string 	$path 	folder where language files are located.
	 * @param 	string 	$index 	unique identifier to retrieve translations.
	 * @return 	void
	 */
	protected function _load_translation($path, $index = null)
	{
		// Format the path.
		$path = $this->_theme_path(str_replace($this->_theme_path, '', $path));

		$index = apply_filters('theme_translation_index', $index);

		// The folder does not exist? Nothing to do.
		if (false === $path) {
			return;
		}

		// Make sure to put .htaccess
		($path) && $this->__check_htaccess($path);

		// Make sure the english version exists!
		$english_file = $path.DS.'english.php';
		if (!is_file($english_file)) {
			return;
		}

		// Include the english version first make sure it's valid.
		include($english_file);

		// Was the language array updated?
		$full_lang = (isset($lang)) ? $lang : array();
		unset($lang);

		// Catch the currently used language.
		$site_lang = $this->_ci->config->item('language');

		// Now we load the current language file.
		if ($site_lang <> 'english') {
			$lang_file = $path.DS.$site_lang.'.php';

			// Load the file only if it exists.
			if (is_file($lang_file)) {
				include($lang_file);
				(isset($lang)) && $full_lang = array_replace_recursive($full_lang, $lang);
			}
		}

		// Now we add the language array to the global array.
		if (!empty($full_lang)){

			// Adding an index?
			if ($index !== null)
			{
				// Set theme language index.
				$this->_theme_language_index = $index;

				// Add the index to translation.
				$full_lang = array($index => $full_lang);
			}

			// Merge all.
			$this->_ci->lang->language = array_replace_recursive(
				$this->_ci->lang->language,
				$full_lang
			);
		}

		$this->_theme_lang_loaded = true;
	}

	// --------------------------------------------------------------------

	/**
	 * Return the current theme's language index.
	 * @access 	public
	 * @return 	string
	 */
	public function theme_domain()
	{
		return $this->_theme_language_index;
	}

	// --------------------------------------------------------------------
	// Alert messages functions
	// --------------------------------------------------------------------

	/**
	 * Stores alert messages in flashdata.
	 * @access 	protected
	 * @param 	mixed 	$message 	message or array of $type => $message
	 * @param 	string 	$type 		type to use for a single message.
	 * @return 	void.
	 */
	protected function _set_alert($message, $type = 'info')
	{
		// If no message is set, nothing to do.
		if (empty($message)) {
			return;
		}

		(is_array($message)) OR $message = array(
			$type => $message
		);

		// Prepare out empty messages array.
		(is_array($this->_messages)) OR $this->_messages = array();

		foreach ($message as $key => $val) {
			$this->_messages[] = array(
				$key => $val
			);
		}

		// Make sure the session library is loaded.
		(class_exists('CI_Session', false)) OR $this->_ci->load->library('session');

		// Set the flash data.
		return $this->_ci->session->set_flashdata('__ci_alert', $this->_messages);
	}

	/**
	 * Returns all available alert messages.
	 * @access 	protected
	 * @return 	string.
	 */
	protected function _get_alert()
	{
		// Were the messages not cached?
		if (empty($this->_messages)) {
			// Make sure the session library is loaded.
			(class_exists('CI_Session', false)) OR $this->_ci->load->library('session');

			$this->_messages = $this->_ci->session->flashdata('__ci_alert');
		}

		// If there are still no messages, nothing to do.
		if (empty($this->_messages)) {
			return '';
		}

		// Prepare the alert template.
		$this->_template_alert = apply_filters('alert_template', $this->_template_alert);

		// Now we prepare alert classes.
		$this->_alert_classes = apply_filters('alert_classes', $this->_alert_classes);

		$output = '';

		foreach ($this->_messages as $message) {
			reset($message);
			$key = key($message);

			$output .= str_replace(array(
				'{class}',
				'{message}'
			), array(
				$this->_alert_classes[$key],
				$message[$key]
			), $this->_template_alert);
		}

		return $output;
	}

	/**
	 * Prints an alert.
	 * @access 	protected
	 * @param 	string 	$message 	the message to print.
	 * @param 	string 	$type 		the message's type.
	 * @return 	string.
	 */
	protected function _print_alert($message = null, $type = 'info', $js = false)
	{
		// If no message is set, we return nothing.
		if (empty($message)) {
			return '';
		}

		// Prepare the alert template.
		if ($js === true)
		{
			$template = apply_filters('alert_template_js', $this->_template_alert_js);
		}
		else
		{
			$template = apply_filters('alert_template', $this->_template_alert);
		}

		// Now we prepare alert classes.
		$this->_alert_classes = apply_filters('alert_classes', $this->_alert_classes);

		$output = str_replace(array(
			'{class}',
			'{message}'
		), array(
			$this->_alert_classes[$type],
			$message
		), $template);

		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * Instead of chaining this class methods or calling them one by one,
	 * this method is a shortcut to do anything you want in a single call.
	 * @access 	public
	 * @param 	array 	$data 		array of data to pass to view
	 * @param 	string 	$title 		page's title
	 * @param 	string 	$options 	associative array of options to apply first
	 * @param 	bool 	$return 	whether to output or simply build
	 */
	protected function _render($data = array(), $title = null, $options = array(), $return = false)
	{
		// Start benchmark
		$this->_ci->benchmark->mark('theme_render_start');

		// Load the language file only if it was not loaded.
		$theme_lang = apply_filters('theme_translation', false);
		if (false !== $theme_lang && $this->_theme_lang_loaded === false) {
			$this->_load_translation($theme_lang);
		}

		/**
		 * In case $title is an array, it will be used as $options.
		 * If then $options is a boolean, it will be used for $return.
		 */
		if (is_array($title)) {
			$return  = (bool) $options;
			$options = $title;
			$title   = null;
		}

		// Loop through all options now.
		foreach ($options as $key => $val) {
			// add_css and add_js are the only distinct methods.
			if (in_array($key, array(
				'css',
				'js'
			))) {
				$this->add($key, $val);
			}

			// We call the method only if it exists.
			elseif (method_exists($this, '_set_' . $key)) {
				call_user_func_array(array(
					$this,
					'_set_' . $key
				), (array) $val);
			}

			// Otherwise we set variables to views.
			else {
				$this->set($key, $val);
			}
		}

		// Now we render the final output.
		$output = $this->__load($this->_get_view(), $data);

		// Start benchmark
		$this->_ci->benchmark->mark('theme_render_end');

		// Pass elapsed time to views.
		if ($this->_ci->output->parse_exec_vars === true) {
			$output = str_replace('{theme_time}', $this->_ci->benchmark->elapsed_time('theme_render_start', 'theme_render_end'), $output);
		}

		if ($return === true) {
			return $output;
		}

		$this->_ci->output->set_output($output);
	}

	/**
	 * Unlike the method above it, this one builts the output and does not
	 * display it. You would have to echo it.
	 * @access 	public
	 * @param 	array 	$data 		array of data to pass to view
	 * @param 	string 	$title 		page's title
	 * @param 	string 	$options 	associative array of options to apply first
	 */
	protected function _build($data = array(), $title = null, $options = array())
	{
		return $this->_render($data, $title, $options, true);
	}

	// --------------------------------------------------------------------

	/**
	 * Returns an array of client's details: browser's name
	 * and version, as well as the platform.
	 *
	 * @return 	array.
	 */
	protected function _client($key = null)
	{
		/**
		 * If not details were cached, it means that
		 * this config item is turn OFF, so we make
		 * sure to turn it on first and then collect
		 * all details.
		 */
		if (empty($this->_client)) {
			$this->_detect_browser = true;
			$this->__detect_browser();
		}

		return ($key !== null && isset($this->_client[$key])) ? $this->_client[$key] : $this->_client;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns true if CDN use is enable and
	 * a CDN url is set.
	 * @access 	public
	 * @param 	bool 	$check_server 	whether to check your provided CDN or not.
	 * @return 	bool
	 */
	public function cdn_enabled($check_server = true)
	{
		if (false === $check_server) {
			return (true === $this->_cdn_enabled);
		}

		return (true === $this->_cdn_enabled && !empty($this->_cdn_server));
	}

	// --------------------------------------------------------------------

	/**
	 * Returns true if on mobile.
	 * @access 	protected
	 * @return 	boolean
	 */
	protected function _is_mobile()
	{
		return $this->_is_mobile;
	}

	// --------------------------------------------------------------------

	/**
	 * Loads a file.
	 * @access 	private
	 * @param 	string 	$file
	 * @param 	array 	$data
	 * @param 	string 	$type
	 * @return 	string if found, else false.
	 */
	private function __load_file($file, $data = array(), $type = 'view')
	{
		// Remove extension and prepare empty output.
		$file   = preg_replace('/.php$/', '', $file) . '.php';
		$output = '';

		$alt_file  = null;					// Alternative file.
		$fallback  = null;					// Fallback template.
		$full_path = $this->_theme_path;	// Full path to theme's folder.
		$alt_path  = KBPATH.'views/';		// Full path to default CodeIgniter views folder.

		switch ($type) {
			// In case of a partial view.
			case 'partial':

				/**
				 * Alterative file just in case.
				 */
				$alt_file = apply_filters('theme_partial_fallback', $alt_file);

				/**
				 * We are settings the fallback partial to $_template_partial
				 * even if it does not exist.
				 */
				$fallback = 'partial';

				/**
				 * By adding this hook, we let the user handle
				 * the path to partial views.
				 */
				$full_path = apply_filters('theme_partials_path', $full_path);

				// Alternative path to partials file.
				$alt_path .= 'partials/';

				break;

			// --------------------------------------------------------------------

			// In case of a layout.
			case 'layout':

				/**
				 * If the layout file is not found, we let the user
				 * choose a fallback file if there is one.
				 * By default, it should be an index.php inside
				 * the theme's folder.
				 */
				$alt_file = 'index.php';
				$alt_file = apply_filters('theme_layout_fallback', $alt_file);

				// The fallback is $_template_layout property.
				$fallback = 'layout';

				/**
				 * By adding this hook, we let the user handle
				 * the path to layouts files.
				 */
				$full_path = apply_filters('theme_layouts_path', $full_path);

				// Alternative path to layouts files.
				$alt_path .= 'layouts/';

				break;

			// --------------------------------------------------------------------

			// In case of a single view file.
			case 'view':

				/**
				 * Alterative file just in case.
				 */
				$alt_file = apply_filters('theme_view_fallback', $alt_file);

				/**
				 * We are settings the fallback partial to $_template_view
				 * even if it does not exist.
				 */
				$fallback = 'view';

				/**
				 * By adding this hook, we let the user handle
				 * the path to view views.
				 */
				$full_path = apply_filters('theme_views_path', $full_path);

				break;
		}

		// Format $file.
		$file = str_replace('/', DS, $file);

		// Generate the full path if it's not provided.
		if ( ! is_file($file))
		{
			/**
			 * Let's holds the full path to the requested file as well as
			 * the path to the alternative file (in CodeIgnier VIEWPATH).
			 */
			$file_path     = realpath("{$full_path}/{$file}");
			$alt_file_path = realpath("{$alt_path}/{$file}");
		}
		// $file is a full path? Use as-is.
		else
		{
			$file_path     = $file;
			$alt_file_path = false;
		}

		// If the file exists, we use it.
		if (false !== $file_path) {
			// Make sure to create the .htaccess file.
			$this->__check_htaccess($full_path);

			// If there are any vars to pass, use them.
			(empty($data)) OR $this->_ci->load->vars($data);

			// Let's prepare the output.
			$output = $this->_ci->load->file($file_path, true);
		}
		// If there an alt_file file set by the theme and it exists:
		elseif (null !== $alt_file && is_file($this->_theme_path($alt_file))) {
			// Change the full path to the new file.
			$file_path = $this->_theme_path($alt_file);

			// If there are any vars, use them.
			(empty($data)) OR $this->_ci->load->vars($data);

			// Prepare the output.
			$output = $this->_ci->load->file($file_path, true);
		}
		// No alternative file set by the theme? Try with default one.
		elseif (false !== $alt_file_path && is_file($alt_file_path)) {
			// If there are any vars to pass, use them.
			(empty($data)) OR $this->_ci->load->vars($data);

			// Let's prepare the output.
			$output = $this->_ci->load->file($alt_file_path, true);
		}
		// If it doesn't, is there a fallback template for it?
		elseif (null !== $fallback && isset($this->{"_template_{$fallback}"})) {
			// Let's prepare things we are about to change.
			$search = array_map(function(&$val)
			{
				return "{{$val}}";
			}, array_keys($data));

			/**
			 * Because the layout fallback container {navbar}, {sidebar} && {footer}
			 * placeholders, we make sure to either load them OR remplace them with
			 * empty elements.
			 */
			if ('layout' === $fallback)
			{
				array_unshift($search, '{navbar}');
				$search[] = '{sidebar}';
				$search[] = '{footer}';
			}

			// Things we use to replace.
			$replace = array_values($data);

			// We prepare the final output.
			$output = str_replace($search, $replace, $this->{"_template_{$fallback}"});
		}
		else
		{
			show_error("The following view file could not be found anywhere in your theme folder: <br />{$file_path}\\{$file}");
		}

		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * Loads view file
	 * @access 	private
	 * @param 	string 	$view 		view to load
	 * @param 	array 	$data 		array of data to pass to view
	 * @param 	bool 	$return 	whether to output view or not
	 * @param 	string 	$master 	in case you use a distinct master view
	 * @return  void
	 */
	private function __load($view, $data = array())
	{
		// Done after theme setup and theme menus.
		do_action('after_theme_setup');
		do_action('theme_menus');

		// Prepare our empty layout array.
		$layout = array();

		// If there are any partial views enqueued, load theme.
		do_action('enqueue_partials');

		if (isset($this->_partials) && is_array($this->_partials)) {
			foreach ($this->_partials as $name => $partial) {
				$layout[$name] = $partial;
			}
		}

		// Pass all given $data to the requested view file then load it.
		$this->_the_content = $layout['content'] = $this->__load_file($view, $data, 'view');

		// If there are any filter applied to it, use them.
		$this->_the_content = apply_filters('the_content', $this->_the_content);

		/**
		 * Let's now prepare the layout file to load.
		 * It is possible to change the layout on functions.php
		 * by using the 'theme_layout' filter.
		 */
		$this->_layout = apply_filters('theme_layout', $this->_layout);

		// Use the default layout if not found.
		(null === $this->_layout) && $this->_layout = 'default';

		/**
		 * Disable sodding IE7's constant cacheing!!
		 * @author 	Philip Sturgeon
		 * @see 	https://forum.codeigniter.com/archive/index.php?thread-24161.html
		 */
		$this->_ci->output->set_header('HTTP/1.0 200 OK');
		$this->_ci->output->set_header('HTTP/1.1 200 OK');
		$this->_ci->output->set_header('Expires: Sat, 01 Jan 2000 00:00:01 GMT');
		$this->_ci->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->_ci->output->set_header('Cache-Control: post-check=0, pre-check=0, max-age=0');
		$this->_ci->output->set_header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		$this->_ci->output->set_header('Pragma: no-cache');

		// Let CI do the caching instead of the browser
		$this->_ci->output->cache($this->_cache_lifetime);

		// Load the layout file.
		$output = $this->__load_file($this->_layout, $layout, 'layout');

		// If the header file was not called, make sure to call it.
		if ($this->_header_called === false) {
			$output = $this->_get_header() . $output;
		}

		// If the footer file was not called, make sure to call it.
		if ($this->_footer_called === false) {
			$output = $output .PHP_EOL.$this->_get_footer();
		}

		// Should we compress the output?
		if ($this->_compress === true) {
			$output = $this->__compress_output($output);
		}

		return $output;
	}

	// --------------------------------------------------------------------
	// Utilities
	// --------------------------------------------------------------------

	/**
	 * Whether to use __remove_extension or not.
	 * @var bool
	 */
	private $_remove_extension = true;

	/**
	 * Disable the use of __remove_extension method.
	 * @access 	public
	 * @return 	object
	 */
	public function no_extension()
	{
		$this->_remove_extension = false;
		return $this;
	}

	/**
	 * Removes files extension
	 * @access 	protected
	 * @param 	mixed 	string or array
	 * @return 	mixed 	string or array
	 */
	protected function __remove_extension($file, $ext = 'css')
	{
		// In case of multiple items
		if (is_array($file)) {
			$temp_files = array();
			foreach ($file as $index => $single_file) {
				$temp_files[$index] = $this->__remove_extension($single_file, $ext);
			}
			return $temp_files;
		}

		// Removing extension is disabled? Return the file as-is.
		if ($this->_remove_extension === false) {
			return $file;
		}

		// Let's make sure to remove all dots first.
		$ext = preg_replace("/^\.+|\.+$/", '', strtolower($ext));

		/**
		 * Let's first check if the file extension is
		 * present or not. If not, add it.
		 */
		$found_ext = pathinfo($file, PATHINFO_EXTENSION);

		($found_ext == $ext) OR $file = $file . '.' . $ext;

		return $file;
	}

	/**
	 * Make sure the .htaccess file that denies direct
	 * access to folder is present.
	 *
	 * @access 	private
	 * @param 	string 	$path 	the path to check/create .htaccess
	 * @return 	void
	 */
	private function __check_htaccess($path)
	{
		/**
		 * If the selected path is not valid, or is not writtable
		 * or the .htaccess file is already there, nothing to do.
		 */
		if (false === realpath($path) OR !is_writable($path) OR is_file($path . DS . '.htaccess')) {
			return;
		}

		$_htaccess_content = <<<EOT
<IfModule authz_core_module>
	Require all denied
</IfModule>
<IfModule !authz_core_module>
	Deny from all
</IfModule>
EOT;
		$_htaccess_file    = fopen($path . DS . '.htaccess', 'w');
		fwrite($_htaccess_file, $_htaccess_content);
		fclose($_htaccess_file);
	}

	// --------------------------------------------------------------------

	/**
	 * Detect browser details.
	 * @access 	private
	 * @param 	none
	 * @return 	void
	 */
	private function __detect_browser()
	{
		// If it's not enabled, nothing to do.
		if ($this->_detect_browser !== true) {
			return;
		}

		// Make sure to load user_agent library if not loaded.
		if (!class_exists('CI_User_agent', false)) {
			$this->_ci->load->library('user_agent');
		}

		// Get the browser's name.
		$this->_client['browser'] = ($this->_is_mobile === true) ? $this->_ci->agent->mobile() : $this->_ci->agent->browser();

		// Add browse's version.
		$this->_client['version'] = $this->_ci->agent->version();

		// Collect accepted languages.
		$this->_client['languages'] = array_values(array_filter($this->_ci->agent->languages(), function($lang)
		{
			return strlen($lang) <= 3;
		}));

		// Set the client used platform (Windows, IOs, Unix ...).
		$this->_client['platform'] = $this->_ci->agent->platform();
	}

	// --------------------------------------------------------------------

	/**
	 * Handles site's internationalization.
	 * @access 	private
	 * @param 	none
	 * @return 	void
	 */
	private function __i18n()
	{
		// If the I18n is disable, nothing to do.
		if ($this->_i18n_enabled !== true) {
			return;
		}

		// Set our current language to default one set in config.
		$current = $default = $this->_ci->config->item('language');

		// Grab all clients supported languages.
		$client = $this->_client('languages');

		/**
		 * Now we loop through client's supported languages
		 * one by one in order, and whenever an available
		 * language is found, we use it.
		 */
		foreach ($client as $code) {
			if (in_array($this->_languages[$code], $this->_i18n_available)) {
				/**
				 * $current was formarly set to $default, but if
				 * a match is found, its value will be changed.
				 */
				$current = $this->_languages[$code];
				break;
			}
		}

		// You can guess why I used this check!
		if ($current != $default) {
			$this->_ci->config->set_item('language', $current);
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Compresses the HTML output
	 * @access 	private
	 * @param 	string 	$output 	the html output to compress
	 * @return 	string 	the minified version of $output
	 */
	private function __compress_output($output)
	{
		// Make sure $output is always a string
		is_string($output) or $output = (string) $output;

		// In orders, we are searching for
		// 1. White-spaces after tags, except space.
		// 2. White-spaces before tags, except space.
		// 3. Multiple white-spaces sequences.
		// 4. HTML comments
		// 5. CDATA

		// We return the minified $output
		$output = preg_replace(array(
			'/\>[^\S ]+/s',
			'/[^\S ]+\</s',
			'/(\s)+/s',
			'/<!--(?!<!)[^\[>].*?-->/s',
			'#(?://)?<!\[CDATA\[(.*?)(?://)?\]\]>#s'
		), array(
			'>',
			'<',
			'\\1',
			'',
			"//&lt;![CDATA[\n" . '\1' . "\n//]]>"
		), $output);

		return $output;
	}

}

// --------------------------------------------------------------------
// HELPERS
// --------------------------------------------------------------------

if (!function_exists('is_cdn_enabled')) {
	/**
	 * Returns true if the CDN is enabled.
	 * @return boolean
	 */
	function is_cdn_enabled($check_server = true)
	{
		return get_instance()->theme->cdn_enabled($check_server);
	}
}

/*=================================================================
=            MODULES, CONTROLLERS AND METHODS CHECKERS            =
=================================================================*/

if (!function_exists('is_module')) {
	/**
	 * Checks if the page belongs to a given module.
	 * If no argument is passed, it checks if we are
	 * using a module.
	 * You may pass a single string, mutliple comma-
	 * separated string or an array.
	 * @param   string|array.
	 */
	function is_module($modules = null)
	{
		if ($modules === null) {
			return (get_instance()->theme->module !== null);
		}

		/**
		 * Doing the following makes it possible to
		 * check for multiple modules.
		 */
		if (!is_array($modules)) {
			$modules = array_map('trim', explode(',', $modules));
		}

		// Compare between modules names.
		return (in_array(get_instance()->theme->module, $modules));
	}
}

// --------------------------------------------------------------------

if (!function_exists('is_controller')) {
	/**
	 * Checks if the page belongs to a given controller.
	 */
	function is_controller($controllers = null)
	{
		if (!is_array($controllers)) {
			$controllers = array_map('trim', explode(',', $controllers));
		}

		// Compare between controllers names.
		return (in_array(get_instance()->theme->controller, $controllers));
	}
}

// --------------------------------------------------------------------

if (!function_exists('is_method')) {
	/**
	 * Checks if the page belongs to a given method.
	 */
	function is_method($methods = null)
	{
		if (!is_array($methods)) {
			$methods = array_map('trim', explode(',', $methods));
		}

		// Compare between methods names.
		return (in_array(get_instance()->theme->method, $methods));
	}
}

/*================================================================
=            MODULES, CONTROLLERS AND METHODS GETTERS            =
================================================================*/

if (!function_exists('get_the_module')) {
	/**
	 * Returns the current module's name.
	 */
	function get_the_module()
	{
		return get_instance()->theme->module;
	}
}

// --------------------------------------------------------------------

if (!function_exists('the_module')) {
	/**
	 * Returns the current module's name.
	 */
	function the_module()
	{
		echo get_instance()->theme->module;
	}
}

// --------------------------------------------------------------------

if (!function_exists('get_the_controller')) {
	/**
	 * Returns the current controller's name.
	 */
	function get_the_controller()
	{
		return get_instance()->theme->controller;
	}
}

// --------------------------------------------------------------------

if (!function_exists('the_controller')) {
	/**
	 * Returns the current controller's name.
	 */
	function the_controller()
	{
		echo get_instance()->theme->controller;
	}
}

// --------------------------------------------------------------------

if (!function_exists('get_the_method')) {
	/**
	 * Returns the current method's name.
	 */
	function get_the_method()
	{
		return get_instance()->theme->method;
	}
}

// --------------------------------------------------------------------

if (!function_exists('the_method')) {
	/**
	 * Returns the current method's name.
	 */
	function the_method()
	{
		echo get_instance()->theme->method;
	}
}

// --------------------------------------------------------------------

if (!function_exists('is_layout')) {
	function is_layout($layout = null)
	{
		return ($layout == get_instance()->theme->get_layout());
	}
}

/*================================================
=            CLIENT'S BROWSER METHIDS            =
================================================*/

if (!function_exists('is_mobile')) {
	/**
	 * Returns true if on mobile device.
	 */
	function is_mobile()
	{
		return get_instance()->theme->is_mobile();
	}
}

/*========================================================
=            HTML PRIMARY ATTRIBUTES AND TAGS            =
========================================================*/

if (!function_exists('html_class')) {
	/**
	 * Displays and applies classes to <html> tag.
	 */
	function html_class($class = null, $echo = true)
	{
		$classes = get_instance()->theme->get_html_class($class);
		if (false === $echo) {
			return $classes;
		}
		echo $classes;
	}
}

// --------------------------------------------------------------------

if (!function_exists('language_attributes')) {
	/**
	 * Displays and applies classes to <html> tag.
	 */
	function language_attributes($attributes = null, $echo = true)
	{
		$attrs = get_instance()->theme->get_language_attributes($attributes);
		if (false === $echo) {
			return $attrs;
		}
		echo $attrs;
	}
}

// --------------------------------------------------------------------

if (!function_exists('the_charset')) {
	/**
	 * Outputs the meta charset tag.
	 * @param   string  $charset    in case you want to override it.
	 * @param   bool    $echo       whether to echo or not.
	 */
	function the_charset($charset = null)
	{
		echo get_instance()->theme->charset($charset);
	}
}

// --------------------------------------------------------------------

if (!function_exists('get_the_charset')) {
	/**
	 * Returns the array of site's charset.
	 * @return array
	 */
	function get_the_charset()
	{
		return get_instance()->theme->get_charset();
	}
}

// --------------------------------------------------------------------

if (!function_exists('body_class')) {
	/**
	 * Displays and applies classes to <body> tag.
	 */
	function body_class($class = null)
	{
		echo get_instance()->theme->body_class($class);
	}
}

// --------------------------------------------------------------------

if (!function_exists('get_body_class')) {
	/**
	 * Returns the array of all body classes.
	 * @return array
	 */
	function get_body_class()
	{
		return get_instance()->theme->get_body_class();
	}
}

/*====================================================
=            THEME PATH AND URL FUNCTIONS            =
====================================================*/

if (!function_exists('get_theme_url')) {
	/**
	 * Returns the URL to the theme folder.
	 * @param   string  $uri    string to be appended.
	 * @return  string.
	 */
	function get_theme_url($uri = '')
	{
		return get_instance()->theme->theme_url($uri);
	}
}

// --------------------------------------------------------------------

if (!function_exists('theme_url')) {
	/**
	 * Unlike the function above, this one echoes the URL.
	 * @param   string  $uri    string to be appended.
	 */
	function theme_url($uri = '')
	{
		echo get_instance()->theme->theme_url($uri);
	}
}

// --------------------------------------------------------------------

if (!function_exists('get_theme_path')) {
	/**
	 * Returns the URL to the theme folder.
	 * @param   string  $uri    string to be appended.
	 * @return  string.
	 */
	function get_theme_path($uri = '')
	{
		return get_instance()->theme->theme_path($uri);
	}
}

// --------------------------------------------------------------------

if (!function_exists('theme_path')) {
	/**
	 * Unlike the function above, this one echoes the URL.
	 * @param   string  $uri    string to be appended.
	 */
	function theme_path($uri = '')
	{
		echo get_instance()->theme->theme_path($uri);
	}
}

/*=====================================================
=            UPLOAD PATH AND URL FUNCTIONS            =
=====================================================*/

if (!function_exists('get_upload_url')) {
	/**
	 * Returns the URL to the uploads folder.
	 * @param   string  $uri    string to be appended.
	 * @return  string.
	 */
	function get_upload_url($uri = '')
	{
		return get_instance()->theme->upload_url($uri);
	}
}

// --------------------------------------------------------------------

if (!function_exists('upload_url')) {
	/**
	 * Unlike the function above, this one echoes the URL.
	 * @param   string  $uri    string to be appended.
	 */
	function upload_url($uri = '')
	{
		echo get_instance()->theme->upload_url($uri);
	}
}

// --------------------------------------------------------------------

if (!function_exists('get_upload_path')) {
	/**
	 * Returns the URL to the uploads folder.
	 * @param   string  $uri    string to be appended.
	 * @return  string.
	 */
	function get_upload_path($uri = '')
	{
		return get_instance()->theme->upload_path($uri);
	}
}

// --------------------------------------------------------------------

if (!function_exists('upload_path')) {
	/**
	 * Unlike the function above, this one echoes the URL.
	 * @param   string  $uri    string to be appended.
	 */
	function upload_path($uri = '')
	{
		echo get_instance()->theme->upload_path($uri);
	}
}

/*=====================================================
=            COMMON PATH AND URL FUNCTIONS            =
=====================================================*/

if (!function_exists('get_common_url')) {
	/**
	 * Returns the URL to the commons folder.
	 * @param   string  $uri    string to be appended.
	 * @return  string.
	 */
	function get_common_url($uri = '')
	{
		return get_instance()->theme->common_url($uri);
	}
}

// --------------------------------------------------------------------

if (!function_exists('common_url')) {
	/**
	 * Unlike the function above, this one echoes the URL.
	 * @param   string  $uri    string to be appended.
	 */
	function common_url($uri = '')
	{
		echo get_instance()->theme->common_url($uri);
	}
}

// --------------------------------------------------------------------

if (!function_exists('get_common_path')) {
	/**
	 * Returns the URL to the commons folder.
	 * @param   string  $uri    string to be appended.
	 * @return  string.
	 */
	function get_common_path($uri = '')
	{
		return get_instance()->theme->common_path($uri);
	}
}

// --------------------------------------------------------------------

if (!function_exists('common_path')) {
	/**
	 * Unlike the function above, this one echoes the URL.
	 * @param   string  $uri    string to be appended.
	 */
	function common_path($uri = '')
	{
		echo get_instance()->theme->common_path($uri);
	}
}

/*==========================================
=            GENERAL ASSETS URL            =
==========================================*/

if (!function_exists('assets_url')) {
	function assets_url($file = null, $common = false)
	{
		// If a full link is passed, return it as it is.
		if (filter_var($file, FILTER_VALIDATE_URL) !== false) {
			return $file;
		} elseif ($common === true) {
			return get_common_url($file);
		} else {
			return get_theme_url($file);
		}
	}
}

// --------------------------------------------------------------------

if (!function_exists('img_alt')) {
	/**
	 * Displays an alternative image using placehold.it website.
	 *
	 * @return  string
	 */
	function img_alt($width, $height = null, $text = null, $background = null, $foreground = null)
	{
		$params = array();
		if (is_array($width)) {
			$params = $width;
		} else {
			$params['width']      = $width;
			$params['height']     = $height;
			$params['text']       = $text;
			$params['background'] = $background;
			$params['foreground'] = $foreground;
		}

		$params['height']     = (empty($params['height'])) ? $params['width'] : $params['height'];
		$params['text']       = (empty($params['text'])) ? $params['width'] . ' x ' . $params['height'] : $params['text'];
		$params['background'] = (empty($params['background'])) ? 'CCCCCC' : $params['height'];
		$params['foreground'] = (empty($params['foreground'])) ? '969696' : $params['foreground'];
		return '<img src="http://placehold.it/' . $params['width'] . 'x' . $params['height'] . '/' . $params['background'] . '/' . $params['foreground'] . '&text=' . $params['text'] . '" alt="Placeholder">';
	}
}

/*=======================================
=            TITLE FUNCTIONS            =
=======================================*/

if (!function_exists('the_title')) {
	/**
	 * Echoes the page title.
	 * @param   string  $before     string to prepend to title.
	 * @param   string  $after      string to append to title.
	 * @param   bool    $echo       whether to echo or not.
	 * @return  string
	 */
	function the_title($before = null, $after = null, $echo = true)
	{
		if ($echo === false) {
			return get_instance()->theme->get_title($before, $after);
		}

		echo get_instance()->theme->get_title($before, $after);
	}
}

// --------------------------------------------------------------------

if (!function_exists('the_extra_head')) {
	function the_extra_head($echo = true)
	{
		if ($echo === false) {
			return get_instance()->theme->output_extra_head();
		}

		echo get_instance()->theme->output_extra_head();
	}
}

// --------------------------------------------------------------------

if (!function_exists('add_ie9_support')) {
	function add_ie9_support(&$output, $remote = true)
	{
		$html5shiv = 'https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js';
		$respond   = 'https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js';

		if ($remote === false) {
			$html5shiv = get_common_url('js/html5shiv-3.7.3.min.js');
			$respond   = get_common_url('js/respond-1.4.2.min.js');
		}
		$output .= <<<EOT
	<!--[if lt IE 9]>
    <script type="text/javascript" src="{$html5shiv}"></script>
    <script type="text/javascript" src="{$respond}"></script>
    <![endif]-->
EOT;
	}
}

// --------------------------------------------------------------------

if (!function_exists('the_content')) {
	function the_content($echo = true)
	{
		if ($echo === false) {
			return get_instance()->theme->output_content();
		}

		echo get_instance()->theme->output_content();
	}
}

// --------------------------------------------------------------------

if (!function_exists('the_analytics')) {
	function the_analytics($site_id = null)
	{
		echo get_instance()->theme->output_analytics($site_id);
	}
}

// --------------------------------------------------------------------

if (!function_exists('get_the_analytics')) {
	function get_the_analytics($site_id = null)
	{
		return get_instance()->theme->output_analytics($site_id);
	}
}

/*==========================================
=            METADATA FUNCTIONS            =
==========================================*/

if (!function_exists('meta_tag')): /**
 * Output a <meta> tag of almost any type.
 * @param   mixed   $name   the meta name or array of meta.
 * @param   string  $content    the meta tag content.
 * @param   string  $type       the type of meta tag.
 * @param   mixed   $attrs      array of string of attributes.
 * @return  string
 */
	function meta_tag($name, $content = null, $type = 'meta', $attrs = array())
	{
		// Loop through multiple meta tags
		if (is_array($name)) {
			$meta = array();
			foreach ($name as $key => $val) {
				$meta[] = meta_tag($key, $val, $type, $attrs);
			}

			return implode("\n\t", $meta);
		}

		$attributes = array();
		switch ($type) {
			case 'rel':
				$tag                = 'link';
				$attributes['rel']  = $name;
				$attributes['href'] = $content;
				break;

			// In case of a meta tag.
			case 'meta':
			default:
				if ($name == 'charset') {
					return "<meta charset=\"{$content}\" />";
				}

				if ($name == 'base') {
					return "<base href=\"{$content}\" />";
				}

				// The tag by default is "meta"

				$tag = 'meta';

				// In case of using Open Graph tags,
				// we user 'property' instead of 'name'.

				$type = (false !== strpos($name, 'og:')) ? 'property' : 'name';

				if ($content === null) {
					$attributes[$type] = $name;
				} else {
					$attributes[$type]     = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
					$attributes['content'] = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
				}

				break;
		}

		$attributes = (is_array($attrs))
			? _stringify_attributes(array_merge($attributes, $attrs))
			: _stringify_attributes($attributes) . ' ' . $attrs;

		return "<{$tag}{$attributes}/>";
	}
endif;

// --------------------------------------------------------------------

if (!function_exists('the_metadata')) {
	/**
	 * Ouputs site <meta> tags.
	 * @param   bool    $echo   whether to return or echo.
	 */
	function the_metadata($echo = true)
	{
		if ($echo === false) {
			return get_instance()->theme->output_metadata();
		}

		echo get_instance()->theme->output_metadata();
	}
}

// --------------------------------------------------------------------

if (!function_exists('add_metadata')) {
	/**
	 * Allow the user to add <meta> tags.
	 * @param   mixed   $name   meta tag's name
	 * @param   mixed   $content
	 * @return  object
	 */
	function add_metadata($name, $content = null, $type = 'meta', $attrs = array())
	{
		return get_instance()->theme->add_meta($name, $content, $type, $attrs);
	}
}

/*=======================================================
=            STYLES AND STYLSHEETS FUNCTIONS            =
=======================================================*/

if (!function_exists('css')) {
	/**
	 * Outputs a full CSS <link> tag.
	 * @param   string  $file   the file name.
	 * @param   string  $cdn    the cdn file to use.
	 * @param   array   $attrs  array of additional attributes.
	 * @param   bool    $common in case of a js file in the common folder.
	 */
	function css($file, $cdn = null, $attrs = array(), $common = false)
	{
		if ($file) {
			$attributes = array(
				'rel' => 'stylesheet',
				'type' => 'text/css'
			);

			$file = ($common === true) ? get_common_url($file) : get_theme_url($file);

			$file               = preg_replace('/.css$/', '', $file) . '.css';
			$attributes['href'] = $file;

			// Are there any other attributes to use?
			if (is_array($attrs)) {
				$attributes = array_replace_recursive($attributes, $attrs);
				return '<link' . _stringify_attributes($attributes) . '/>' . "\n";
			}

			$attributes = _stringify_attributes($attributes) . " {$attrs}";
			return '<link' . $attributes . ' />' . "\n\t";
		}

		return null;
	}
}

// --------------------------------------------------------------------

if (!function_exists('the_stylesheets')) {
	/**
	 * Outputs css link tags and inline stypes.
	 * @param   bool    $echo   whether to echo or not
	 * @return  string
	 */
	function the_stylesheets($echo = true)
	{
		if ($echo === false) {
			return get_instance()->theme->output_styles();
		}

		echo get_instance()->theme->output_styles();
	}
}

// --------------------------------------------------------------------

if (!function_exists('add_style')) {
	/**
	 * Adds stylesheets to view.
	 * @param   string  $handle     used as identifier.
	 * @param   string  $file       the css file.
	 * @param   int     $ver        the file's version.
	 * @param   bool    $prepend    whether to put the file at the beggining or not
	 * @param   array   $attrs      array of attributes to add.
	 * @return  object
	 */
	function add_style($handle = '', $file = null, $ver = null, $prepend = false, $attrs = array())
	{
		return get_instance()->theme->add('css', $file, $handle, $ver, $prepend, $attrs);
	}
}

// --------------------------------------------------------------------

if (!function_exists('add_inline_style')) {
	/**
	 * Allows the user to add an inline styles that can even
	 * be put before $handle if provided.
	 * @param   string  $content    the full style content.
	 * @param   string  $handle     the handle before which it should be put.
	 * @return  object
	 */
	function add_inline_style($content, $handle = null)
	{
		return get_instance()->theme->add_inline('css', $content, $handle);
	}
}

// --------------------------------------------------------------------

if (!function_exists('remove_style')) {
	/**
	 * Removes a give file by its handle.
	 */
	function remove_style($handle)
	{
		return get_instance()->theme->remove('css', $handle);
	}
}


// --------------------------------------------------------------------

if (!function_exists('replace_style')) {
	/**
	 * Simply replaces an existing file with another.
	 */
	function replace_style($handle = null, $file = null, $ver = null)
	{
		return get_instance()->theme->replace('css', $handle, $file, $ver);
	}
}

/*=============================================
=            JAVASCRIPTS FUNCTIONS            =
=============================================*/

if (!function_exists('js')) {
	/**
	 * Outputs a full <script> tag.
	 * @param   string  $file   the file name.
	 * @param   string  $cdn    the cdn file to use.
	 * @param   array   $attrs  array of additional attributes.
	 * @param   bool    $common in case of a js file in the common folder.
	 */
	function js($file, $cdn = null, $attrs = array(), $common = false)
	{
		if ($file) {
			$attributes['type'] = 'text/javascript';

			$file = ($common === true) ? get_common_url($file) : get_theme_url($file);

			$file              = preg_replace('/.js$/', '', $file) . '.js';
			$attributes['src'] = $file;

			// Are there any other attributes to use?
			if (is_array($attrs)) {
				$attributes = array_replace_recursive($attributes, $attrs);
				return '<link' . _stringify_attributes($attributes) . '/>' . "\n";
			}

			$attributes = _stringify_attributes($attributes) . " {$attrs}";
			return '<script' . $attributes . '></script>' . "\n";
		}

		return null;
	}
}

// --------------------------------------------------------------------

if (!function_exists('the_javascripts')) {
	/**
	 * Returns or echoes all javascripts files and inline scrips.
	 * @param   bool    $echo   whether to echo or not.
	 * @return  string
	 */
	function the_javascripts($echo = true)
	{
		if ($echo === false) {
			return get_instance()->theme->output_scripts();
		}

		echo get_instance()->theme->output_scripts();
	}
}

// --------------------------------------------------------------------

if (!function_exists('add_script')) {
	/**
	 * Adds javascript files to view.
	 */
	function add_script($handle = '', $file = null, $ver = null, $prepend = false, $attrs = array())
	{
		return get_instance()->theme->add('js', $file, $handle, $ver, $prepend, $attrs);
	}
}

// --------------------------------------------------------------------

if (!function_exists('add_inline_script')) {
	/**
	 * Allows the user to add an inline scripts that can even
	 * be put before $handle if provided.
	 * @param   string  $content    the full script content.
	 * @param   string  $handle     the handle before which it should be put.
	 * @return  object
	 */
	function add_inline_script($content, $handle = null)
	{
		return get_instance()->theme->add_inline('js', $content, $handle);
	}
}

// --------------------------------------------------------------------

if (!function_exists('remove_script')) {
	/**
	 * Removes a give file by its handle.
	 */
	function remove_script($handle)
	{
		return get_instance()->theme->remove('js', $handle);
	}
}

// --------------------------------------------------------------------

if (!function_exists('replace_script')) {
	/**
	 * Simply replaces an existing file with another.
	 */
	function replace_script($handle = null, $file = null, $ver = null)
	{
		return get_instance()->theme->replace('js', $file, $handle, $ver);
	}
}

/*=====================================
=            VIEWS RENDERES            =
=====================================*/

if (!function_exists('render')) {
	/**
	 * Instead of chaining this class methods or calling them one by one,
	 * this method is a shortcut to do anything you want in a single call.
	 * @param   array   $data       array of data to pass to view
	 * @param   string  $view       the view file to load
	 * @param   string  $title      page's title
	 * @param   string  $options    associative array of options to apply first
	 * @param   bool    $return     whether to output or simply build
	 * NOTE: you can pass $options instead of $title like so:
	 *      $this->_theme->render('view', $data, $options, $return);
	 */
	function render($data = array(), $title = null, $options = array(), $return = false)
	{
		return get_instance()->theme->render($data, $title, $options, $return);
	}
}

/*===========================================================
=            HEADER,FOOTER AND PARTIALS GETTERS            =
===========================================================*/

if (!function_exists('get_header')) {
	/**
	 * Load the theme header file.
	 */
	function get_header($file = null, $echo = true)
	{
		if ($echo === false) {
			return get_instance()->theme->get_header($file);
		}

		echo get_instance()->theme->get_header($file);
	}
}

// --------------------------------------------------------------------

if (!function_exists('get_footer')) {
	/**
	 * Load the theme footer file.
	 */
	function get_footer($file = null)
	{
		echo get_instance()->theme->get_footer($file);
	}
}

if (!function_exists('add_partial')) {
	/**
	 * This function allow you to enqueue any additional
	 * partial views and you can even override existing
	 * ones by providing the same name as the target.
	 * @param   string  $file   the view file to load.
	 * @param   array   $data   array of data to pass to view.
	 * @param   string  $name   the name of the partial view.
	 */
	function add_partial($file, $data = array(), $name = null)
	{
		return get_instance()->theme->add_partial($file, $data, $name);
	}
}

// --------------------------------------------------------------------

if (!function_exists('get_partial')) {
	/**
	 * This function load a partial view located under
	 * theme folder/views/_partials/..
	 * @param   string  $file   the file to load.
	 * @param   array   $data   array of data to pass to view.
	 * @return  string.
	 */
	function get_partial($file, $data = array(), $load = true)
	{
		return get_instance()->theme->get_partial($file, $data, $load);
	}
}

/*===============================================
=            THEME SETTER AND GETTER            =
===============================================*/

if (!function_exists('theme_set_var')) {
	/**
	 * With function you can set variables (global or not) that
	 * you can use anywhere in your theme files.
	 * @param   mixed   $name       property's name or associative array
	 * @param   mixed   $val        property's value or null if $var is array
	 * @return  instance of theme class.
	 */
	function theme_set_var($name, $value = null, $global = false)
	{
		return get_instance()->theme->set($name, $value, $global);
	}
}

// --------------------------------------------------------------------

if (!function_exists('theme_get_var')) {
	/**
	 * Returns a data store in class Config property
	 * @param   string  $name
	 * @param   string  $index
	 * @return  mixed
	 */
	function theme_get_var($name, $index = null)
	{
		return get_instance()->theme->get($name, $index);
	}
}

/*==============================================
=            FLASH ALERTS FUNCTIONS            =
==============================================*/

if (!function_exists('set_alert')) {
	/**
	 * Sets a flash alert.
	 * @param   mixed   $message    message or array of $type => $message
	 * @param   string  $type       type to use for a single message.
	 * @return  void.
	 */
	function set_alert($message, $type = 'info')
	{
		return get_instance()->theme->set_alert($message, $type);
	}
}

// --------------------------------------------------------------------

if (!function_exists('the_alert')) {
	/**
	 * Echoes any set flash messages.
	 * @return  string
	 */
	function the_alert()
	{
		echo get_instance()->theme->get_alert();
	}
}

if (!function_exists('print_alert')) {
	/**
	 * Displays a flash alert.
	 * @param  string $message the message to display.
	 * @param  string $type    the message type.
	 * @param  bool 	$js 	html or js
	 * @return string
	 */
	function print_alert($message = null, $type = 'info', $js = false)
	{
		echo get_instance()->theme->print_alert($message, $type, $js);
	}
}

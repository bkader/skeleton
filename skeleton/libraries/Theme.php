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
 * @link 		https://goo.gl/wGXHO9
 * @since 		1.0.0
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
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @since 		1.3.3 	changed "metadata" to "meta_tags" to avoid conflict with
 *          			the "Kbcore_metadata" library and added themes count.
 * @since 		1.4.0 	Added "the_doctype" filter and moved down body class filters.
 * @since 		1.4.1 	All HTML is compressed except for <pre> tags content.
 * @version 	1.4.1
 */
class Theme
{
	/**
	 * CodeIgniter Skeleton copyright.
	 * @var string
	 */
	private $_skeleton_copyright = <<<EOT
\n<!--
This website is proudly powered by: CodeIgniter Skeleton (https://goo.gl/wGXHO9/skeleton)
A project developed and maintained by: Kader Bouyakoub (https://goo.gl/wGXHO9)
-->
EOT;
	/**
	 * Header template
	 * @var string
	 */
	private $_template_header = <<<EOT
{doctype}{skeleton_copyright}
<html{html_class}{language_attributes}>
<head>
	<meta charset="{charset}">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{title}</title>
    {meta_tags}
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
<div class="{class} alert-dismissible fade show" role="alert">
	{message}
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
EOT;

	/**
	 * JavaSript alert template.
	 */
	private $_template_alert_js = <<<EOT
'<div class="{class} alert-dismissible fade show" role="alert">'
+ '{message}'
+ '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
+ '<span aria-hidden="true">&times;</span>'
+ '</button>'
+ '</div>'
EOT;

	/**
	 * Array of default alerts classes.
	 * @var  array
	 */
	private $_alert_classes = array(
		'info'    => 'alert alert-info',
		'error'   => 'alert alert-danger',
		'warning' => 'alert alert-warning',
		'success' => 'alert alert-success',
	);

	/**
	 * Instance of CI object
	 * @var 	object
	 */
	private $ci;

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
	private $_themes_dir = 'themes';

	/**
	 * Holds the count of available valid themes.
	 *
	 * @since 	1.3.3
	 * @var 	integer
	 */
	private $_themes = 0;

	/**
	 * Holds the current theme's name.
	 * @var string
	 */
	private $_theme = null;

	/**
	 * Array of headers used to fetch theme's data.
	 * @since 	1.3.4
	 * @var 	array
	 */
	private $_css_headers = array(
		'Theme Name',
		'Theme URI',
		'Description',
		'Version',
		'License',
		'License URI',
		'Author',
		'Author URI',
		'Author Email',
		'Tags',
		'Screenshot',
		'Language Folder',
		'Language Index',
	);

	/**
	 * Array that holds theme details, combined with details got
	 * from theme's CSS file ($_css_headers).
	 * @since 	1.3.4
	 * @var 	array
	 */
	private $_default_headers = array(
		'name',
		'theme_uri',
		'description',
		'version',
		'license',
		'license_uri',
		'author',
		'author_uri',
		'author_email',
		'tags',
		'screenshot',
		'language',
		'index',
	);

	/**
	 * Array of extensions allowed for themes previews.
	 * @since 	1.3.4
	 * @var 	array
	 */
	private $_screenshot_ext = array('.png', '.jpg', '.jpeg', '.gif');

	/**
	 * Holds the current theme's language index.
	 * @var string
	 */
	private $_theme_language_index = '';

	/**
	 * Set to true if the language file was loaded.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Renamed.
	 * @var 	bool
	 */
	private $_translation_loaded = false;

	/**
	 * Holds the currently used language details.
	 * @var array
	 */
	private $_language;

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
	 * Holds the current page's title.
	 * @var  string
	 */
	private $_title;

	/**
	 * Holds the page's title parts separator.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Changed.
	 * @var 	string
	 */
	private $_title_sep = '&#8212;';

	/**
	 * Holds an array of all <meta> tags.
	 * @var  array
	 */
	private $_meta_tags = array();

	/**
	 * Array of StyleSheets to add first.
	 * @var array
	 */
	private $_prepended_styles = array();

	/**
	 * Array of StyleSheets
	 * @var array
	 */
	private $_styles = array();

	/**
	 * Array of in-line styles.
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
	 * Array of in-line scripts to output.
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
	 * Set to true if in dashboard area.
	 * @var boolean
	 */
	private $_is_admin = false;

	/**
	 * Put default preferences into class' property so
	 * they can be overriden later.
	 * @var array
	 */
	private $_defaults = array(
		'themes_dir'       => 'content/themes',
		'common_dir'       => 'content/common',
		'cache_dir'        => 'content/cache',
		'theme'            => 'default',
		'title_sep'        => '&#150;',
		'compress'         => false,
		'cache_lifetime'   => 0,
		'cdn_enabled'      => false,
		'cdn_server'       => null,
		'site_name'        => 'CI-Theme',
		'site_description' => 'Simply makes your CI-based applications themable. Easy and fun to use.',
		'site_keywords'    => 'codeigniter, themes, libraries, bkader, bouyakoub'
	);

	/**
	 * Constructor
	 */
	public function __construct($config = array())
	{
		// Prepare instance of CI object
		$this->ci =& get_instance();

		// Initialize class preferences.
		if (is_array($config) && ! empty($config))
		{
			$this->initialize($config);
		}

		log_message('info', 'Theme Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize class preferences.
	 *
	 * @param 	array 	$config
	 * @return 	void
	 */
	public function initialize($config = array())
	{
		$this->ci->benchmark->mark('theme_initialize_start');

		// Make sure URL helper is load then we load our helper
		(function_exists('base_url')) OR $this->ci->load->helper('url');

		// Let's set class preferences.
		$this->_config = array_replace_recursive($this->_defaults, $config);

		// See if any parameter was overridden.
		foreach ($this->_defaults as $key => $val)
		{
			if ($item = $this->ci->config->item($key))
			{
				$this->_config[$key] = $item;
			}
		}
		unset($key, $val, $item);

		// Create class properties.
		foreach ($this->_config as $key => $val)
		{
			// Just to add spaces before
			// and after title separator.
			if ($key == 'title_sep')
			{
				$this->_title_sep = ' '.trim($val).' ';
			}
			else
			{
				$this->{'_'.$key} = $val;
			}
		}

		// Let's store accessed module, controller and methods.
		$this->module     = (method_exists($this->ci->router, 'fetch_module')) ? $this->ci->router->fetch_module() : null;
		$this->controller = $this->ci->router->fetch_class();
		$this->method     = $this->ci->router->fetch_method();

		global $back_contexts, $csk_modules;
		if (in_array($this->controller, $back_contexts) 
			OR in_array($this->controller, $csk_modules)
			OR 'admin' === $this->controller 
			OR 'admin' === $this->ci->uri->segment(1))
		{
			$this->_is_admin = true;
		}

		// We store the real path to theme's folder.
		$theme_path = FCPATH.$this->_themes_dir.'/'.$this->_theme;
		if (true !== is_dir($theme_path) 
			&& false === mkdir($theme_path, 0755, true))
		{
			return false;
		}

		$this->_theme_path = realpath($theme_path).DS;

		// Define a constant that can be used everywhere.
		defined('THEME_PATH') OR define('THEME_PATH', $this->_theme_path);

		// Check if it's a mobile client.
		(class_exists('CI_User_agent', false)) OR $this->ci->load->library('user_agent');
		$this->_is_mobile = $this->ci->agent->is_mobile();

		// Let's detect client browser's details.
		$this->_detect_browser();

		if (false === ($functions = $this->theme_path('functions.php')))
		{
			log_message('error', "Unable to locate the theme's 'functions.php' file: {$this->_theme}");
			show_error("Unable to locate the theme's 'functions.php' file.");
		}

		require_once($functions);

		$this->_uploads_dir = $this->ci->config->item('upload_path');
		$this->_common_dir  = apply_filters('common_dir', $this->_common_dir);

		// A default variables that you can use on your views.
		$this->set('uri_string', uri_string(), true);

		// Benchmark for eventual use.
		$this->ci->benchmark->mark('theme_initialize_end');
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
		$themes_path = $this->themes_path();
		if ($handle = opendir($themes_path))
		{
			$_to_eliminate = array(
				'.',
				'..',
				'index.html',
				'.htaccess',
				'__MACOSX', // Added as of v1.3.4
			);

			while (false !== ($file = readdir($handle)))
			{
				if (true === is_dir($themes_path.DS.$file) 
					&& ! in_array($file, $_to_eliminate))
				{
					$folders[] = $file;
				}
			}
		}

		// If there are any folders present, we get themes details.
		if ( ! empty($folders))
		{
			foreach ($folders as $index => $folder)
			{
				// Change to use style.css file instead of manifest.json.
				if (false !== is_file($themes_path.DS.$folder.DS.'style.css'))
				{
					$folders[$folder] = $this->_get_theme_details($folder);
					$this->_themes++;
				}
				unset($folders[$index]);
			}

			/**
			 * Fires onces all themes details were retrieved.
			 * @since 	1.4.0
			 */
			$folders = apply_filters('get_themes', $folders);
		}

		// Now we return the final result.
		return $folders;
	}

	// --------------------------------------------------------------------

	/**
	 * Return details about a given theme.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.4 	We no longer need manifest.json, we will use style.css
	 * 
	 * @access 	private
	 * @param 	string 	$theme 	the theme's folder name.
	 * @return 	object if found or false.
	 */
	private function _get_theme_details($folder)
	{
		// Prepare the path to the "style.css" file and make sure it exists.
		$theme_css = realpath(FCPATH."{$this->_themes_dir}/{$folder}/style.css");
		if (false === $theme_css)
		{
			show_error("Theme missing CSS file: {$folder}.");
		}

		// Load our custom files helper to get file info.
		(function_exists('get_file_data')) OR $this->ci->load->helper('file');
		$css_headers = get_file_data($theme_css, $this->_css_headers);

		// We make sure to have at least something.
		$css_headers = array_clean($css_headers);
		if (empty($css_headers))
		{
			log_message('error', 'Theme CSS file is missing details: {$folder}.');
			show_error("Theme CSS file is missing details: {$folder}.");
		}

		// Prepare theme file headers and fill them.
		$headers = array_fill_keys($this->_default_headers, false);
		foreach ($css_headers as $index => $value)
		{
			$headers[$this->_default_headers[$index]] = $value;
		}

		// If the screenshot was not provided, we generate URL for it.
		if (empty($headers['screenshot']))
		{
			$headers['screenshot'] = $this->common_url('img/theme-blank.png');
			foreach ($this->_screenshot_ext as $ext)
			{
				if (false !== $this->themes_path($folder.'/screenshot'.$ext))
				{
					$headers['screenshot'] = $this->themes_url("{$folder}/screenshot{$ext}");
					break;
				}
			}
		}
		// If the screenshot was provided, we make sure it points to the URL.
		elseif (false === filter_var($headers['screenshot'], FILTER_VALIDATE_URL))
		{
			$headers['screenshot'] = $this->themes_url($folder.'/'.$headers['screenshot']);
		}

		// We make sure to finally add the folder name and path to headers.
		$headers['folder'] = $folder;
		$headers['full_pah'] = $this->themes_path($folder).DS;		

		// Let's see if we shall translate the name and description.
		(empty($headers['language'])) && $headers['language'] = 'language';
		(empty($headers['index'])) && $headers['index'] = $folder;
		$english = $this->theme_path($headers['language'].'/english.php');
		if (false === $english)
		{
			return $headers;
		}

		require_once($english);
		$full_lang = (isset($lang)) ? $lang : array();
		unset($lang);

		// If the current language different?
		$language = $this->ci->config->item('language');
		if ('english' !== $language 
			&& false !== $current = $this->theme_path($headers['language']."/{$language}.php"))
		{
			require_once($current);
			(isset($lang)) && $full_lang = array_replace_recursive($full_lang, $lang);
		}

		// Shall we translate the name?
		if (isset($lang) && isset($lang['theme_name']))
		{
			$headers['name'] = $lang['theme_name'];
		}
		// Shall we translate the the description?
		if (isset($lang) && isset($lang['theme_name']))
		{
			$headers['name'] = $lang['theme_name'];
		}

		return $headers;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the count of available valid themes.
	 *
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	int
	 */
	public function count()
	{
		// We make sure to get themes so the count is incremented.
		$this->get_themes();

		// We then return the full count.
		return $this->_themes;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns the theme's details.
	 * @access 	public
	 * @param 	string 	$key 	to return a single item.
	 * @return 	object|string
	 */
	public function theme_details($key = null)
	{
		// Already cached? Use it.
		if (isset($this->_theme_details))
		{
			$return = $this->_theme_details;
		}
		else
		{
			$this->_theme_details = $this->_get_theme_details($this->_theme);
			$return = $this->_theme_details;
		}

		if (false !== $return)
		{
			return (isset($return[$key])) ? $return[$key] : $return;
		}

		return false;
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
		if (is_array($name))
		{
			$global = (bool) $value;

			foreach ($name as $key => $val)
			{
				$this->set($key, $val, $global);
			}

			return $this;
		}

		if ($global === true)
		{
			$this->ci->load->vars($name, $value);
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
	public function themes_path($uri = '')
	{
		$path = FCPATH.$this->_themes_dir;
		(empty($uri)) OR $path .= '/'.$uri;
		return realpath($path);
	}

	// --------------------------------------------------------------------

	/**
	 * Returns URI to the folder containing themes.
	 * @access 	protected
	 * @param 	none
	 * @return 	string
	 */
	public function themes_url($uri = '')
	{
		return base_url("{$this->_themes_dir}/{$uri}");
	}

	// --------------------------------------------------------------------

	/**
	 * Changes the currently used theme.
	 * @access 	protected
	 * @param 	string 	$theme 	the theme's name.
	 * @return 	object
	 */
	public function set_theme($theme = 'default')
	{
		$this->_theme = $theme;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns the current theme's name.
	 * @access 	protected
	 * @return 	string.
	 */
	public function get_theme()
	{
		return $this->_theme;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns theme url.
	 * @access 	protected
	 * @param 	string 	$uri 	uri to append to url.
	 * @return 	string.
	 */
	public function theme_url($uri = '')
	{
		$base_url = ($this->cdn_enabled()) ? $this->_cdn_server : base_url();
		$base_url .= $this->_themes_dir.'/'.$this->_theme.'/'.$uri;
		return $base_url;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns a path to a folder or file in theme's folder.
	 *
	 * @since 	1.0.0
	 * @since 	1.4.0 	No need to use realpath again, if was already used all above.
	 * @access 	protected
	 * @param 	string 	$uri
	 * @return 	string if found, else false.
	 */
	public function theme_path($uri = '')
	{
		return realpath($this->_theme_path.$uri);
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
	public function upload_url($uri = '')
	{
		$base_url = ($this->cdn_enabled()) ? $this->_cdn_server : base_url();
		$base_url .= $this->_uploads_dir.'/'.$uri;
		return $base_url;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns the realpath to the uploads folder.
	 *
	 * @since 	1.0.0
	 * @since 	1.4.0 	Because we added "upload_dir" filter, we make sure 
	 *         			to create the directory if it does not exits.
	 * @access 	protected
	 * @param 	string 	$uri
	 * @return 	string if found, else false.
	 */
	public function upload_path($uri = '')
	{
		$upload_path = FCPATH.$this->_uploads_dir;

		// Attempt to create the directory.
		if (true !== is_dir($upload_path) 
			&& false === mkdir($upload_path, 0755, true))
		{
			return false;
		}

		return realpath($upload_path.'/'.$uri);
	}

	// --------------------------------------------------------------------

	/**
	 * Return a URL to the common folder.
	 * @access 	protected
	 * @param 	string 	$uri
	 * @return 	string
	 */
	public function common_url($uri = '')
	{
		$base_url = ($this->cdn_enabled()) ? $this->_cdn_server : base_url();
		$base_url .= $this->_common_dir.'/'.$uri;
		return $base_url;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns the realpath to the common folder.
	 * @access 	protected
	 * @param 	string 	$uri
	 * @return 	string if found, else false.
	 */
	public function common_path($uri = '')
	{
		return realpath(FCPATH.$this->_common_dir.'/'.$uri);
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
	public function set_layout($layout = 'default')
	{
		$this->_layout = $layout;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns the current layout's name.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Separated dashboard and front-end hooks.
	 * 
	 * @access 	protected
	 * @return 	string.
	 */
	public function get_layout()
	{
		$this->_layout = (true === $this->_is_admin)
			? apply_filters('admin_layout', $this->_layout)
			: apply_filters('theme_layout', $this->_layout);

		return $this->_layout;
	}

	// ------------------------------------------------------------------------

	/**
	 * layout_exists
	 *
	 * Method for checking the existence of the layout.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$layout 	The layout to check (Optional).
	 * @return 	bool 	true if the layout exists, else false.
	 */
	public function layout_exists($layout = null)
	{
		$layout OR $layout = $this->get_layout();
		$layout = preg_replace('/.php$/', '', $layout).'.php';
		$full_path = apply_filters('theme_layouts_path', $this->theme_path());

		return (false !== is_file($full_path.DS.$layout));
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
	public function set_view($view = null)
	{
		$this->_view = $view;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns the current view's name.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Separated dashboard and front-end hooks.
	 * 
	 * @access 	protected
	 * @return 	string.
	 */
	public function get_view()
	{
		// Make sure the view is set.
		(isset($this->_view)) OR $this->_view = $this->_guess_view();

		// Are we on the front-end?
		if (true !== $this->_is_admin)
		{
			$this->_view = apply_filters('theme_view', $this->_view);
			return $this->_view;
		}

		if (null !== $this->module)
		{
			$this->_view = preg_replace("/{$this->module}\//", '', $this->_view);
			return $this->_view;
		}

		// There is no admin filter?
		if (false === has_filter('admin_view'))
		{
			// Are we on a module that exists?
			if (null !== $this->module 
				&& false !== $module_path = $this->ci->router->module_path($this->module))
			{
				$view = (isset($this->_view)) ? $this->_view : $this->method;
				$this->_view = ('admin' === $this->module)
					? $module_path.'views/'.str_replace('admin/', '', $view)
					: $module_path.'views/admin/'.$view;
			}

			return $this->_view;
		}

		// Otherwise, apply the filter and return the view.
		$this->_view = apply_filters('admin_view', $this->_view);
		return $this->_view;
	}

	// ------------------------------------------------------------------------

	/**
	 * view_exists
	 *
	 * Method for checking the existence of the current view.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @access 	public
	 * @param 	string 	$view 	The view to check (optional).
	 * @return 	bool 	true if the view is found, else false.
	 */
	public function view_exists($view = null)
	{
		$view OR $view = $this->get_view();
		$view = preg_replace('/.php$/', '', $view).'.php';
		$full_path = apply_filters('theme_views_path', $this->theme_path());

		return (false !== is_file($full_path.DS.$view));
	}

	// --------------------------------------------------------------------

	/**
	 * Attempt to guess the view file.
	 * @access 	private
	 * @return 	string.
	 */
	private function _guess_view()
	{
		$view = $this->controller.'/'.$this->method;

		if ('admin' === $this->ci->uri->segment(1) && null === $this->module)
		{
			$view = 'admin/'.str_replace('admin/', '', $view);
		}
		elseif (null !== $this->module && $this->module !== $this->controller)
		{
			$view = $this->module.'/'.$view;
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
	public function set_cache($minutes = 0)
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
	public function set_title()
	{
		$args = func_get_args();
		if ( ! empty($args))
		{
			(is_array($args[0])) && $args = $args[0];
			$this->_title = implode($this->_title_sep, $args);
		}
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns the current page's title.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Separated dashboard and front-end hooks.
	 * 
	 * @access 	protected
	 * @param 	string 	$before 	string to be prepended.
	 * @param 	string 	$after 		string to be appended.
	 * @return 	string
	 */
	public function get_title($before = null, $after = null)
	{
		// The title not set? Guess it.
		(isset($this->_title)) OR $this->_title = $this->_guess_title();

		// We make sure the title is an array.
		(is_array($this->_title)) OR $this->_title = (array) $this->_title;

		// we apply filter to it.
		$this->_title = (true === $this->_is_admin)
			? apply_filters('admin_title', $this->_title)
			: apply_filters('the_title', $this->_title);

		// Something to put before or after?
		(null !== $before) && array_unshift($this->_title, $before);
		(null !== $after) && array_push($this->_title, $after);

		// We trim then remove empty elements and duplicates.
		$this->_title  = array_map('trim', $this->_title);
		$this->_title = array_unique(array_filter($this->_title), SORT_STRING);

		// Create the title string.
		$this->_title = implode($this->_title_sep, $this->_title);

		// We add "Skeleton" to the end only on the dashboard.
		if (true === $this->_is_admin)
		{
			$this->_title .= apply_filters('skeleton_title', ' &lsaquo; Skeleton');

			// We add site name to the end.
			if (null !== $site_name = $this->ci->config->item('site_name'))
			{
				$this->_title .= $this->_title_sep.$site_name;
			}
		}

		// Return the title.
		return $this->_title;
	}

	// --------------------------------------------------------------------

	/**
	 * Attempt to guess the title if it's not set.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Enhanced.
	 * 
	 * @access 	private
	 * @return 	array
	 */
	private function _guess_title()
	{
		$temp_title = ('index' !== $this->method) ? $this->method : array();
		is_array($temp_title) OR $temp_title = array($temp_title);

		// Controller has same module's name or module is null?
		if (null === $this->module)
		{
			array_unshift($temp_title, $this->controller);
		}
		// Admin? We put "Admin" first.
		elseif (true === $this->_is_admin)
		{
			array_unshift($temp_title, 'admin', $this->module);
		}
		else
		{
			array_unshift($temp_title, $this->module, $this->controller);
		}

		return array_filter(array_map('ucwords', $temp_title));
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
	public function add_meta($name, $content = null, $type = 'meta', $attrs = array())
	{
		// In case of multiple elements
		if (is_array($name))
		{
			foreach ($name as $key => $val)
			{
				$this->add_meta($key, $val, $type, $attrs);
			}

			return $this;
		}

		$this->_meta_tags[$type.'::'.$name] = array(
			'content' => $content
		);
		(empty($attrs)) OR $this->_meta_tags[$type.'::'.$name]['attrs'] = $attrs;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns all cached meta_tags.
	 * @access 	protected
	 * @return 	array
	 */
	public function get_meta()
	{
		return $this->_meta_tags;
	}

	// --------------------------------------------------------------------

	/**
	 * Takes all site meta tags and prepare the output string.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Separated dashboard and front-end hooks.
	 * 
	 * @access 	protected
	 * @return 	string
	 */
	public function print_meta_tags()
	{
		// Prepare filters.
		$before_filter = 'before_meta';
		$after_filter  = 'after_meta';

		// On dashboard?
		if (true === $this->_is_admin)
		{
			$before_filter = 'before_admin_meta';
			$after_filter  = 'after_admin_meta';
		}

		// If there are any 'before_meta', apply them.
		$meta_tags = apply_filters($before_filter, '');

		// Append our output meta_tags.
		$meta_tags .= $this->_render_meta_tags();

		// If there are any 'after_meta', apply them.
		$meta_tags = apply_filters($after_filter, $meta_tags);

		return $meta_tags;
	}

	// --------------------------------------------------------------------

	/**
	 * Collects all additional meta_tags and prepare them for output
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Separated dashboard and front-end hooks.
	 * 
	 * @access 	private
	 * @param 	none
	 * @return 	string
	 */
	private function _render_meta_tags()
	{
		// Prepare the action to be done.
		$action = 'enqueue_admin_meta';

		// On the front-end?
		if ('admin' !== $this->controller)
		{
			$action = 'enqueue_meta';

			// Add our generator tag if not empty.
			$generator = apply_filters('skeleton_generator', 'CodeIgniter Skeleton '.KB_VERSION);
			(empty($generator)) OR $this->add_meta('generator', $generator);
		}

		// Do the action.
		do_action($action);

		// Kick off with an empty output.
		$output = '';

		$i = 1;
		$j = count($this->_meta_tags);

		foreach ($this->_meta_tags as $key => $val)
		{
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
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Lowercase $handle and turn back on removing extension.
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
		if (empty($file))
		{
			return $this;
		}

		// In case of an array.
		if (is_array($file))
		{
			foreach ($file as $_file => $_url)
			{
				if (is_int($_file) && is_string($_url))
				{
					$this->add($type, $_url, null, $ver, $prepend);
				}
				else
				{
					$this->add($type, $_url, $_file, $ver, $prepend);
				}
			}

			return $this;
		}

		// We start by removing the extension.
		$file = $this->_remove_extension($file, $type);

		// If the $handle is not provided, we generate it.
		if (empty($handle))
		{
			// We remplace all dots by dashes.
			$handle = preg_replace('/\./', '-', basename($file));
			$handle = preg_replace("/-{$type}$/", '', $handle)."-{$type}";
		}
		else
		{
			$handle           = preg_replace("/-{$type}$/", '', $handle)."-{$type}";
			$attributes['id'] = $handle;
		}

		// We make sure $handle is always lowercased.
		$handle = strtolower($handle);

		/**
		 * If the file is a full url (cdn or using get_theme_url(..))
		 * we use as it is, otherwise, we force get_theme_url()
		 */
		if (false === filter_var($file, FILTER_VALIDATE_URL))
		{
			$func = 'theme';
			if (false !== strpos($file, ':'))
			{
				list($func, $file) = explode(':', $file);
			}

			$file = $this->{$func.'_url'}($file);
		}

		// If the version is provided, use it.
		if ( ! empty($ver))
		{
			$file .= "?ver={$ver}";
		}

		if ($type == 'css')
		{
			$attributes['rel']  = 'stylesheet';
			$attributes['type'] = 'text/css';
			$attributes['href'] = $file;
		}
		else // js file.
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
		if (true === $prepend OR 'jquery-js' == $handle)
		{
			// We first add it to the $prepended_xx array.
			$this->{$prepended}[$handle] = $attributes;

			// We merge everything.
			$this->{$files} = array_replace_recursive($this->{$prepended}, (array) $this->{$files});

			// Don't go further.
			return $this;
		}

		$this->{$files}[$handle] = $attributes;
		$this->_remove_extension = true;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Simply remove any added files.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Updated to accept multiple arguments.
	 * 
	 * @access 	public
	 * @return 	void
	 */
	public function remove()
	{
		// We collect method arguments and make sure we provided some.
		$args = func_get_args();
		if (empty($args))
		{
			return $this;
		}

		// The type of file to remove is always the first argument.
		$type = array_shift($args);

		// If not valid, we skip.
		if ( ! in_array($type, array('css', 'js')))
		{
			return $this;
		}

		if ( ! empty($args))
		{
			// We get rid of nasty deep array.
			(is_array($args[0])) && $args = $args[0];

			// We loop through files and remove them.
			foreach ($args as $arg)
			{
				// Just to reset.
				$handle = strtolower($arg);
			
				// Let's make $handle nicer :)/
				$handle = preg_replace("/-{$type}$/", '', $handle)."-{$type}";

				if ($type == 'css')
				{
					$this->_removed_styles[] = $handle;
					unset($this->_styles[$handle]);
				}
				else
				{
					$this->_removed_scripts[] = $handle;
					unset($this->_scripts[$handle]);
				}
			}
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Remplaces any file by another.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Lowercase $handle and turn back on removing extension.
	 * 
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
		if (empty($file))
		{
			return $this;
		}

		// We start by removing the extension.
		$file = $this->_remove_extension($file, $type);

		// If the $handle is not provided, we generate it.
		if (empty($handle))
		{
			// We remplace all dots by dashes.
			$handle = preg_replace('/\./', '-', basename($file));
			$handle = preg_replace("/-{$type}$/", '', $handle)."-{$type}";
		}
		else
		{
			$handle           = preg_replace("/-{$type}$/", '', $handle)."-{$type}";
			$attributes['id'] = $handle;
		}

		// We make sure $handle is always lowercased.
		$handle = strtolower($handle);

		/**
		 * If the file is a full url (cdn or using get_theme_url(..))
		 * we use as it is, otherwise, we force get_theme_url()
		 */
		if (false === filter_var($file, FILTER_VALIDATE_URL))
		{
			$file = $this->theme_url($file);
		}

		// If the version is provided, use it.
		if ( ! empty($ver))
		{
			$file .= "?ver={$ver}";
		}

		if ($type == 'css')
		{
			$attributes['rel']  = 'stylesheet';
			$attributes['type'] = 'text/css';
			$attributes['href'] = $file;
		}
		else // js file.
		{
			$attributes['type'] = 'text/javascript';
			$attributes['src']  = $file;
		}

		// Merge any additional attributes.
		$attributes = array_replace_recursive($attributes, $attrs);

		// We replace the file if found.

		if ($type == 'css')
		{
			$this->_styles[$handle] = $attributes;
		}
		else
		{
			$this->_scripts[$handle] = $attributes;
		}

		$this->_remove_extension = true;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Allows user to add in-line elements (CSS or JS)
	 * @access 	public
	 * @param 	string 	$type 		the file's type to add.
	 * @param 	string 	$content 	the in-line content.
	 * @param 	string 	$handle 	before which handle the content should be output.
	 * @return 	object
	 */
	public function add_inline($type = 'css', $content = '', $handle = null)
	{
		$handle = preg_replace("/-{$type}$/", '', $handle)."-{$type}";

		// In case of in-line styles.
		if ('css' == $type)
		{
			$this->_inline_styles[$handle] = $content;
		}

		// In case of in-line scripts.
		elseif ('js' == $type)
		{
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
	public function get_css()
	{
		return $this->_styles;
	}

	// --------------------------------------------------------------------

	/**
	 * Outputs all site StyleSheets and in-line styles string.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Renamed and separated dashboard and front-end hooks.
	 *
	 * @access 	public
	 * @return 	string
	 */
	public function print_styles()
	{
		$styles = '';

		// Prepare filters.
		$before_filter = 'before_styles';
		$after_filter  = 'after_styles';

		// On dashboard?
		if (true === $this->_is_admin)
		{
			$before_filter = 'before_admin_styles';
			$after_filter  = 'after_admin_styles';
		}

		// Any before styles filters?
		$styles = apply_filters($before_filter, $styles);

		// Render all enqueued ones.
		$styles .= $this->_render_styles();

		// Any after styles filters?
		$styles = apply_filters($after_filter, $styles);

		return $styles;
	}

	// --------------------------------------------------------------------

	/**
	 * Collect all additional CSS files and prepare them for output
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Separated dashboard and front-end hooks.
	 * 
	 * @access 	private
	 * @param 	none
	 * @return 	string
	 */
	private function _render_styles()
	{
		// Prepare our action and filter.
		$action = 'enqueue_styles';
		$filter = 'print_styles';

		// On dashboard?
		if (true === $this->_is_admin)
		{
			$action = 'enqueue_admin_styles';
			$filter = 'admin_print_styles';
		}

		// Do the action.
		do_action($action);

		/**
		 * Here we are allowing themes, plugins or other resources
		 * to alter the behavior of this method.
		 */
		$_temp_output = apply_filters($filter, array(
			'inline' => $this->_inline_styles,
			'styles' => $this->_styles,
			'output' => null,
		));

		// An output was created? Return it
		if (is_string($_temp_output))
		{
			return $_temp_output;
		}

		$output = '';

		$i = 1;
		$j = count($this->_styles);
		foreach ($this->_styles as $handle => $file)
		{
			if (isset($this->_inline_styles[$handle]))
			{
				$output .= $this->_inline_styles[$handle]."\n\t";
				unset($this->_inline_styles[$handle]);
			}

			if (false !== $file)
			{
				$output .= '<link'._stringify_attributes($file).' />'.($i === $j ? '' : "\n\t");
			}
			$i++;
		}

		if ( ! empty($this->_inline_styles))
		{
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
	public function get_js()
	{
		return $this->_scripts;
	}

	// --------------------------------------------------------------------

	/**
	 * Outputs all script tags and in-line scripts.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Renamed and separated dashboard and front-end hooks.
	 * 
	 * @access 	protected
	 * @return 	string
	 */
	public function print_scripts()
	{
		// Prepare before and after filters.
		$before_filter = 'before_scripts';
		$after_filter  = 'after_scripts';

		// On dashboard?
		if (true === $this->_is_admin)
		{
			$before_filter = 'before_admin_scripts';
			$after_filter  = 'after_admin_scripts';
		}

		$scripts = '';

		// Any before scripts filters?
		$scripts = apply_filters($before_filter, $scripts)."\t";

		// Render all enqueued ones.
		$scripts .= $this->_render_scripts();

		// Any after scripts filters?
		$scripts = apply_filters($after_filter, $scripts)."\t";

		return $scripts;
	}

	// --------------------------------------------------------------------

	/**
	 * Collect all additional JS files and prepare them for output
	 * @access 	private
	 * @param 	none
	 * @return 	string
	 */
	private function _render_scripts()
	{
		// Prepare the action and filter.
		$action = 'enqueue_scripts';
		$filter = 'print_scripts';

		// On dashboard?
		if (true === $this->_is_admin)
		{
			$action = 'enqueue_admin_scripts';
			$filter = 'admin_print_scripts';
		}

		// Do the action.
		do_action($action);

		/**
		 * Here we are allowing themes, plugins or other resources
		 * to alter the behavior of this method.
		 */
		$_temp_output = apply_filters($filter, array(
			'inline'  => $this->_inline_scripts,
			'scripts' => $this->_scripts,
			'output'  => null,
		));

		// An output was created? Return it
		if (is_string($_temp_output))
		{
			return $_temp_output;
		}

		$output = '';

		$i = 1;
		$j = count($this->_scripts);

		if ( ! empty($this->_scripts))
		{
			foreach ($this->_scripts as $handle => $file)
			{
				if (isset($this->_inline_scripts[$handle]))
				{
					$output .= $this->_inline_scripts[$handle]."\n\t";
					unset($this->_inline_scripts[$handle]);
				}

				if (false !== $file)
				{
					$output .= '<script'._stringify_attributes($file).'></script>'.($i === $j ? '' : "\n\t");
				}

				$i++;
			}
		}

		if ( ! empty($this->_inline_scripts))
		{
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
	public function print_analytics($site_id = null)
	{
		// No $site_id provided? Get it from configuration.
		if (null === $site_id)
		{
			$site_id = $this->ci->config->item('google_analytics_id');
		}
		
		// Prepare the output.
		$output = '';

		// Valid $site_id? Use it.
		if ('UA-XXXXX-Y' !== $site_id && null !== $site_id)
		{
			// We pass our analytics template to filter.
			$temp_analytics = (true === $this->_is_admin)
				? apply_filters('admin_google_analytics', $this->_template_google_analytics)
				: apply_filters('google_analytics', $this->_template_google_analytics);

			// We replace placeholder.
			$output = str_replace('{site_id}', $site_id, $temp_analytics)."\n";
		}
		return $output;
	}

	// --------------------------------------------------------------------
	// Extra head function.
	// --------------------------------------------------------------------

	/**
	 * Outputs all additional head string.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Added the "admin_head" filter to admin section.
	 * 
	 * @access 	protected
	 * @param 	string 	$content
	 * @return 	string
	 */
	public function print_extra_head($content = "\n")
	{
		$content = (true === $this->_is_admin)
			? apply_filters('admin_head', $content)
			: apply_filters('extra_head', $content);

		return $content;
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
	public function add_partial($view, $data = array(), $name = null)
	{
		// If $name is not set, we take the last string.
		(empty($name)) && $name = basename($view);

		// Add it only if it's not set.
		if ( ! isset($this->_partials[$name]))
		{
			$this->_partials[$name] = $this->_load_file($view, $data, 'partial');
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Displays a partial view alone.
	 * @access 	protected
	 * @param 	string 	$view 	the partial view name
	 * @param 	array 	$data 	array of data to pass
	 * @param 	bool 	$load 	load it if not cached?
	 * @return 	mixed
	 */
	public function get_partial($view, $data = array(), $load = true)
	{
		$name = basename($view);

		/**
		 * Fires before a partial is loaded.
		 * @since 	1.4.0
		 */
		do_action('get_partial', $name);

		// Already cached? Use it
		if (isset($this->_partials[$name]))
		{
			return $this->_partials[$name];
		}

		return (true !== $load) ? null : $this->_load_file($view, $data, 'partial');
	}

	// --------------------------------------------------------------------
	// Header and footer functions
	// --------------------------------------------------------------------

	/**
	 * Returns or ouputs the header file or provided template.
	 * @access 	protected
	 * @param 	string 	$name 	optional header file.
	 * @param 	bool 	$echo 	whether to echo our return.
	 * @return 	string
	 */
	public function get_header($name = null)
	{
		/**
		 * Fires before the header template file is loaded.
		 * @since 	1.4.0
		 * @param 	string 	
		 */
		do_action('get_header', $name);

		/**
		 * If the header file exists, we use it.
		 * This allows the user to override the default
		 * header template provided by the theme
		 */
		$file = $backup_file = 'header.php';
		(null !== $name) && $file = 'header-'.$name;
		$file = preg_replace('/.php$/', '', $file).'.php';

		// Depending on the context.
		$header_file = ('admin' !== $this->controller && 'admin' !== $this->module)
			? $this->theme_path($file)
			: realpath(KBPATH.'views/admin/partials/'.$file);

		// If the file is not found, fallback to "header.php".
		if ($file === $backup_file && false === $header_file)
		{
			$header_file = ('admin' !== $this->controller && 'admin' !== $this->module)
				? $this->theme_path($backup_file)
				: realpath(KBPATH.'views/admin/partials/'.$backup_file);
		}

		// The file exists? Load it.
		if (file_exists($header_file))
		{
			$output = $this->ci->load->file($header_file, true);
		}

		/**
		 * If the header file is not found, we proceed
		 * to replacements and prepare our output.
		 */
		else
		{
			// New filter to dynamically generate the DOCTYPE.
			$replace['doctype'] = apply_filters('the_doctype', '<!DOCTYPE html>');

			// Skeleton Copyright.
			$replace['skeleton_copyright'] = apply_filters('skeleton_copyright', $this->_skeleton_copyright);

			// Base url
			$replace['base_url'] = base_url();

			// <html> class.
			$replace['html_class'] = $this->html_class();

			// Language attributes.
			$replace['language_attributes'] = $this->language_attributes();

			// Charset.
			$replace['charset'] = $this->ci->config->item('charset');

			// Page title.
			$replace['title'] = $this->get_title();

			// Let's add <meta> tags now;
			$replace['meta_tags'] = $this->print_meta_tags();

			// Prepare all StyleSheets.
			$replace['stylesheets'] = $this->print_styles();

			// Any additional extra head?
			$replace['extra_head'] = $this->print_extra_head();

			// Prepare body class.
			$replace['body_class'] = $this->body_class();

			$output = $this->_template_header;

			foreach ($replace as $key => $val)
			{
				$output = str_replace('{'.$key.'}', $val, $output);
			}
		}

		// Change the flag status
		$this->_header_called = true;

		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns or ouputs the footer file or provided template.
	 * @access 	protected
	 * @param 	string 	$name 	optional footer file.
	 * @param 	bool 	$echo 	whether to echo our return.
	 * @return 	string
	 */
	public function get_footer($name = null)
	{
		/**
		 * Let's first add our default JavaScripts which
		 * can be overridden by on functions.php by whether
		 * replace_js, remove_js or even add_js if the given
		 * $handle is the same.
		 */
		if (isset($this->_removed_scripts))
		{
			// We start with Modernizr.
			if ( ! in_array('modernizr-js', $this->_removed_scripts))
			{
				// Default is from CDN.
				$modernizr_url = 'https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js';
				if (false === $this->cdn_enabled(false) OR 'development' === ENVIRONMENT)
				{
					$modernizr_url = $this->common_url('js/modernizr-2.8.3.min.js');
				}
				$this->add('js', $modernizr_url, 'modernizr', null, true);
			}
			
			// We now add jQuery.
			if ( ! in_array('jquery-js', $this->_removed_scripts))
			{
				$jquery_url = 'https://code.jquery.com/jquery-3.2.1.min.js';
				if (false === $this->cdn_enabled(false) OR 'development' === ENVIRONMENT)
				{
					$jquery_url = $this->common_url('js/jquery-3.2.1.min.js');
				}
				$this->add('js', $jquery_url, 'jquery', null, true);
			}
		}

		/**
		 * Fires before the footer template file is loaded.
		 * @since 	1.4.0
		 * @param 	string 	
		 */
		do_action('get_footer', $name);

		/**
		 * If the footer file exists, we use it.
		 * This allows the user to override the default
		 * footer template provided by the theme
		 */
		$file = $backup_file = 'footer.php';
		(null !== $name) && $file = 'footer-'.$name;
		$file = preg_replace('/.php$/', '', $file).'.php';

		// Depending on the context.
		$footer_file = ('admin' !== $this->controller && 'admin' !== $this->module)
			? $this->theme_path($file)
			: realpath(KBPATH.'views/admin/partials/'.$file);

		// If the file is not found, fallback to "footer.php".
		if ($file === $backup_file && false === $footer_file)
		{
			$footer_file = ('admin' !== $this->controller && 'admin' !== $this->module)
				? $this->theme_path($backup_file)
				: realpath(KBPATH.'views/admin/partials/'.$backup_file);
		}

		// The file exists? Load it.
		if (file_exists($footer_file))
		{
			$output = $this->ci->load->file($header_file, true);
		}

		/**
		 * If the footer file is not found, we proceed
		 * to replacements and prepare our output.
		 */
		else
		{
			$output = str_replace(array(
				'{javascripts}',
				'{analytics}'
			), array(
				$this->print_scripts(),
				$this->print_analytics()
			), $this->_template_footer);
		}

		// Change the flag status
		$this->_footer_called = true;

		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * Return the string to use for html_class()
	 * @access 	protected
	 * @param 	string 	$class to add.
	 * @return 	string
	 */
	public function html_class($class = null)
	{
		// Initial output.
		$output = '';

		// Apply any filters targeting this class.
		$this->_html_classes = (true === $this->_is_admin)
			? apply_filters('admin_html_class', $this->_html_classes)
			: apply_filters('html_class', $this->_html_classes);

		// If any class is provided, add it.
		(null !== $class) && array_unshift($this->_html_classes, $class);

		// We proceed only if there are some classes.
		if ( ! empty($this->_html_classes) && is_array($this->_html_classes))
		{
			// We make sure classes are in an array
			(is_array($this->_html_classes)) OR $this->_html_classes = (array) $this->_html_classes;

			// We remove empty elements, trim spaces, and keep only unique classes.
			$this->_html_classes = array_filter($this->_html_classes);
			$this->_html_classes = array_map('trim', $this->_html_classes);
			$this->_html_classes = array_unique($this->_html_classes);

			// Stile not empty? Add everything.
			if ( ! empty($this->_html_classes))
			{
				$output .= ' class="'.implode(' ', $this->_html_classes).'"';
			}
		}

		// Return the final output.
		return $output;
	}

	// -------------------------------------------------------------------

	/**
	 * Returns the array of html classes.
	 *
	 * @since 	1.3.3
	 * 
	 * @access 	protected
	 * @param 	none
	 * @return 	array
	 */
	public function get_html_class()
	{
		return $this->_html_classes;
	}

	// ------------------------------------------------------------------------

	/**
	 * Quick add classes to html class.
	 *
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	mixed
	 * @return 	Theme
	 */
	public function set_html_class()
	{
		// Collect arguments an proceed if there are any.
		$args = func_get_args();
		if ( ! empty($args))
		{
			// We get rid of deep nasty array.
			(is_array($args[0])) && $args = $args[0];

			// We add them to html classes.
			$this->_html_classes = array_merge($this->_html_classes, $args);
		}

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set <html> language attributes.
	 * @access 	protected
	 * @param 	array 	$attributes
	 * @return 	string
	 */
	public function language_attributes(string $attributes = null)
	{
		// Initial output.
		$output = '';

		// Add the first attributes which is the language set in config.
		$attrs = array($this->language('code'));

		// Apply any filters targeting these attributes only.
		$attrs = (true === $this->_is_admin)
			? apply_filters('admin_language_attributes', $attrs)
			: apply_filters('language_attributes', $attrs);

		// If there are any extra attributes, we add them.
		if ($attributes !== null)
		{
			$attrs[] = $attributes;
		}

		// We remove empty elements, trim spaces and keep only unique elements.
		$attrs = array_filter($attrs);
		$attrs = array_map('trim', $attrs);
		$attrs = array_unique($attrs);

		// If there are any attributes, we return them.
		if ( ! empty($attrs))
		{
			$output .= ' lang="'.implode(' ', $attrs).'"';
		}

		if ('rtl' === $this->language('direction'))
		{
			$output .= ' dir="rtl"';
		}

		// Return the final output.
		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * Return the string to use for get_body_class()
	 * @access 	protected
	 * @param 	string 	$class 	class to add.
	 * @return 	string
	 */
	public function body_class(string $class = null)
	{
		// Initial output.
		$output = '';

		// If any class is provided, add it.
		(null !== $class) && array_unshift($this->_body_classes, $class);

		// We make sure classes are in an array
		(is_array($this->_body_classes)) OR $this->_body_classes = (array) $this->_body_classes;

		/**
		 * Skeleton custom body class made available for
		 * themes to target and interact with.
		 */
		$classes = array();

		// Are we on the home page?
		(null === $this->ci->uri->segment(1)) && $classes[] = 'csk-home';

		// Are we on the dashboard?
		if (true === $this->_is_admin)
		{
			$classes[] = 'csk-admin';
			$classes[] = 'ver-'.str_replace('.', '-', KB_VERSION);
			$classes[] = 'locale-'.strtolower($this->language('locale'));

			(null !== $this->module) && $classes[] = 'csk-'.$this->module;
		}
		else
		{
			(null !== $this->module) && $classes[] = 'csk-'.$this->module;
			$classes[] = 'csk-'.$this->controller;
		}

		// We add the module, controller and method.
		('index' !== $this->method) && $classes[] = 'csk-'.$this->method;

		('rtl' === $this->language('direction')) && $classes[] = 'rtl';
		// We add the current language.
		
		// Merge things.
		$this->_body_classes = array_merge($this->_body_classes, $classes);

		// Apply any filters targeting this class.
		$this->_body_classes = ('admin' === $this->controller OR 'admin' === $this->module)
			? apply_filters('admin_body_class', $this->_body_classes)
			: apply_filters('body_class', $this->_body_classes);

		// We make sure to clear classes.
		$this->_body_classes = array_clean($this->_body_classes);

		// Stile not empty? Add everything.
		if ( ! empty($this->_body_classes))
		{
			$output .= ' class="'.implode(' ', $this->_body_classes).'"';
		}

		// Return the final output.
		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * Returns the array of body classes.
	 * @access 	protected
	 * @param 	none
	 * @return 	array
	 */
	public function get_body_class()
	{
		return $this->_body_classes;
	}

	// ------------------------------------------------------------------------

	/**
	 * Quick add classes to body class.
	 *
	 * @since 	1.3.3
	 *
	 * @access 	public
	 * @param 	mixed
	 * @return 	Theme
	 */
	public function set_body_class()
	{
		// Collect arguments an proceed if there are any.
		$args = func_get_args();
		if ( ! empty($args))
		{
			// We get rid of deep nasty array.
			(is_array($args[0])) && $args = $args[0];

			// We add them to body classes.
			$this->_body_classes = array_merge($this->_body_classes, $args);
		}

		return $this;
	}

	// --------------------------------------------------------------------
	// Content functions
	// --------------------------------------------------------------------

	/**
	 * Returns the current view file content.
	 */
	public function print_content()
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
	public function load_translation($path = 'language', $index = null)
	{
		// Already loaded? Nothing to do.
		if (true === $this->_translation_loaded)
		{
			return;
		}

		// Get the path to theme translations.
		$path = $this->theme_path(str_replace($this->_theme_path, '', $path));

		// The folder does not exist? Nothing to do.
		if (false === $path)
		{
			return;
		}

		// Make sure to put .htaccess
		(false !== $path) && $this->_check_htaccess($path);

		// Make sure the English version exists!
		if (false === $english = realpath($path.DS.'english.php'))
		{
			return;
		}

		// Include the english version first make sure it's valid.
		require_once($english);

		// Was the language array updated?
		$full_lang = (isset($lang)) ? $lang : array();
		unset($lang);

		// Catch the currently used language.
		$language = $this->ci->config->item('language');

		// Now we load the current language file.
		if ('english' !== $language 
			&& false !== $current = realpath($path.DS.$language.'.php'))
		{
			require_once($current);
			(isset($lang)) && $full_lang = array_replace_recursive($full_lang, $lang);
		}

		// Now we add the language array to the global array.
		if ( ! empty($full_lang))
		{
			// Set theme language index.
			$this->_theme_language_index = apply_filters('theme_translation_index', $index);
			if (empty($this->_theme_language_index))
			{
				$this->_theme_language_index = $this->_theme;
			}

			// Merge all.
			$this->ci->lang->language[$this->_theme_language_index] = $full_lang;
		}

		$this->_translation_loaded = true;
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

	/**
	 * Return the currently used language details.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Fixed issue with language details.
	 * 
	 * @access 	public
	 * @param 	string 	$key 	The key to return.
	 * @return 	mixed 	Array if no key provided/found or string.
	 */
	public function language($key = null)
	{
		// Get the folder of the language first.
		$folder = ($this->ci->session->language)
			? $this->ci->session->language
			: $this->ci->config->item('language');

		$return = $this->ci->lang->languages($folder);
		return (isset($return[$key])) ? $return[$key] : $return;
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
	public function set_alert($message, $type = 'info')
	{
		// If no message is set, nothing to do.
		if (empty($message))
		{
			return;
		}

		// We turn things into an array.
		(is_array($message)) OR $message = array($type => $message);

		// Prepare out empty messages array.
		(is_array($this->_messages)) OR $this->_messages = array();

		foreach ($message as $key => $val)
		{
			$this->_messages[] = array($key => $val);
		}

		// Make sure the session library is loaded.
		(class_exists('CI_Session', false)) OR $this->ci->load->library('session');

		// Set the flash data.
		return $this->ci->session->set_flashdata('__ci_alert', $this->_messages);
	}

	// --------------------------------------------------------------------

	/**
	 * Returns all available alert messages.
	 * @access 	protected
	 * @return 	string.
	 */
	public function get_alert()
	{
		// Were the messages not cached?
		if (empty($this->_messages))
		{
			// Make sure the session library is loaded.
			(class_exists('CI_Session', false)) OR $this->ci->load->library('session');

			$this->_messages = $this->ci->session->flashdata('__ci_alert');
		}

		// If there are still no messages, nothing to do.
		if (empty($this->_messages))
		{
			return '';
		}

		// On the front-end only.
		if ('admin' !== $this->controller)
		{
			// Prepare the alert template.
			$this->_template_alert = apply_filters('alert_template', $this->_template_alert);
			
			// Now we prepare alert classes.
			$this->_alert_classes = apply_filters('alert_classes', $this->_alert_classes);
		}

		// Initial output.
		$output = '';

		foreach ($this->_messages as $index => $message)
		{
			$key = key($message);
			$output .= str_replace(array(
				'{class}',
				'{message}'
			), array(
				$this->_alert_classes[$key],
				$message[$key]
			), $this->_template_alert);

			// Remove it.
			unset($this->_messages[$index]);
		}

		// Return the final output.
		return $output;
	}

	// --------------------------------------------------------------------

	/**
	 * Prints an alert.
	 * @access 	protected
	 * @param 	string 	$message 	the message to print.
	 * @param 	string 	$type 		the message's type.
	 * @return 	string.
	 */
	public function print_alert($message = null, $type = 'info', $js = false)
	{
		// If no message is set, we return nothing.
		if (empty($message))
		{
			return '';
		}

		// Prepare the alert template.
		$template = (true === $js) ? $this->_template_alert_js : $this->_template_alert;

		// On front-end?
		if ('admin' !== $this->controller)
		{
			$template = (true === $js)
				? apply_filters('alert_template_js', $this->_template_alert_js)
				: apply_filters('alert_template', $this->_template_alert);
			
			// We apply filter on alerts classes.
			$this->_alert_classes = apply_filters('alert_classes', $this->_alert_classes);
		}

		// Replace things.
		$output = str_replace(array(
			'{class}',
			'{message}'
		), array(
			$this->_alert_classes[$type],
			$message
		), $template);

		// Return the final output.
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
	public function render($data = array(), $title = null, $options = array(), $return = false)
	{
		// Make sure the theme path is set correctly.
		if (false === $this->_theme_path && 'admin' !== $this->controller)
		{
			die();
		}

		// Start benchmark
		$this->ci->benchmark->mark('theme_render_start');

		// Load the language file only if it was not loaded.
		if (false === $this->_translation_loaded 
			&& null !== $theme_lang = apply_filters('theme_translation', null))
		{
			$this->load_translation($theme_lang);
		}

		/**
		 * In case $title is an array, it will be used as $options.
		 * If then $options is a boolean, it will be used for $return.
		 */
		if (is_array($title))
		{
			$return  = (bool) $options;
			$options = $title;
			$title   = null;
		}

		// Loop through all options now.
		foreach ($options as $key => $val)
		{
			// add_css and add_js are the only distinct methods.
			if (in_array($key, array('css', 'js')))
			{
				$this->add($key, $val);
			}

			// We call the method only if it exists.
			elseif (method_exists($this, 'set_'.$key))
			{
				call_user_func_array(array($this, 'set_'.$key), (array) $val);
			}

			// Otherwise we pass variables to views.
			else
			{
				$this->set($key, $val);
			}
		}

		// Now we render the final output.
		$output = $this->_load($this->get_view(), $data);

		// Start benchmark
		$this->ci->benchmark->mark('theme_render_end');

		// Pass elapsed time to views.
		if ($this->ci->output->parse_exec_vars === true)
		{
			$output = str_replace('{theme_time}', $this->ci->benchmark->elapsed_time('theme_render_start', 'theme_render_end'), $output);
		}

		if ($return === true)
		{
			return $output;
		}

		$this->ci->output->set_output($output);
	}

	// --------------------------------------------------------------------

	/**
	 * Unlike the method above it, this one builts the output and does not
	 * display it. You would have to echo it.
	 * @access 	public
	 * @param 	array 	$data 		array of data to pass to view
	 * @param 	string 	$title 		page's title
	 * @param 	string 	$options 	associative array of options to apply first
	 */
	public function build($data = array(), $title = null, $options = array())
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
	public function client($key = null)
	{
		/**
		 * If not details were cached, it means that
		 * this config item is turn OFF, so we make
		 * sure to turn it on first and then collect
		 * all details.
		 */
		if (empty($this->_client))
		{
			$this->_detect_browser = true;
			$this->_detect_browser();
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
		if (false === $check_server)
		{
			return (true === $this->_cdn_enabled);
		}

		return (true === $this->_cdn_enabled && ! empty($this->_cdn_server));
	}

	// --------------------------------------------------------------------

	/**
	 * Returns true if on mobile.
	 * @access 	protected
	 * @return 	boolean
	 */
	public function is_mobile()
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
	private function _load_file($file, $data = array(), $type = 'view')
	{
		// Remove extension and prepare empty output.
		$file   = preg_replace('/.php$/', '', $file).'.php';
		$output = '';

		$alt_file  = null; // Alternative file.
		$fallback  = null; // Fallback template.
		$full_path = $this->_theme_path; // Full path to theme's folder.
		$alt_path  = KBPATH.'views/'; // Full path to default CodeIgniter views folder.

		switch ($type)
		{
			// In case of a partial view.
			case 'partial':

				/**
				 * Alterative file just in case.
				 */
				if (null !== $this->module 
					&& false !== ($path = $this->ci->router->module_path($this->module)))
				{
					$alt_file = $path.'views/partials/'.$file;
				}
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
				$full_path = (true === $this->_is_admin)
					? realpath(KBPATH.'views/admin/partials/')
					: apply_filters('theme_partials_path', $full_path);

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
				$alt_file = apply_filters('theme_layout_fallback', $this->theme_path('index.php'));

				// The fallback is $_template_layout property.
				$fallback = 'layout';

				/**
				 * By adding this hook, we let the user handle
				 * the path to layouts files.
				 */
				$full_path = (true == $this->_is_admin)
					? realpath(KBPATH.'views/admin/layouts/')
					: apply_filters('theme_layouts_path', $full_path);

				// Alternative path to layouts files.
				$alt_path .= 'layouts/';

				break;

			// --------------------------------------------------------------------

			// In case of a single view file.
			case 'view':

				/**
				 * Alterative file just in case.
				 */
				if (null !== $this->module 
					&& false !== $module_path = $this->ci->router->module_path($this->module))
				{
					$alt_file = $module_path.str_replace($this->module, 'views', $file);
				}

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
				if (true === $this->_is_admin)
				{
					$_path = (null === $this->module)
						? KBPATH.'views/admin/'
						: $this->ci->router->module_path($this->module).'views/';
					$full_path = realpath($_path);
				}
				else
				{
					$full_path = apply_filters('theme_views_path', $full_path);
				}

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

			if (false === $alt_file && null !== $this->module)
			{
				$alt_file_path = $this->ci->router->module_path($this->module);
				$alt_file_path .= 'views/'.('view' === $type ? '' : plural($type).'/').$file;
			}
		}
		// $file is a full path? Use as-is.
		else
		{
			$file_path     = $file;
			$alt_file_path = false;
		}

		// If the file exists, we use it.
		if (false !== $file_path)
		{
			// Make sure to create the .htaccess file.
			$this->_check_htaccess($full_path);

			// If there are any vars to pass, use them.
			(empty($data)) OR $this->ci->load->vars($data);

			// Let's prepare the output.
			$output = $this->ci->load->file($file_path, true);
		}
		// If there an alt_file file set by the theme and it exists:
		elseif (null !== $alt_file && is_file($alt_file))
		{
			// Change the full path to the new file.
			$file_path = $alt_file;

			// If there are any vars, use them.
			(empty($data)) OR $this->ci->load->vars($data);

			// Prepare the output.
			$output = $this->ci->load->file($file_path, true);
		}
		// No alternative file set by the theme? Try with default one.
		elseif (false !== $alt_file_path && is_file($alt_file_path))
		{
			// If there are any vars to pass, use them.
			(empty($data)) OR $this->ci->load->vars($data);

			// Let's prepare the output.
			$output = $this->ci->load->file($alt_file_path, true);
		}
		// If it doesn't, is there a fallback template for it?
		elseif (null !== $fallback && isset($this->{"_template_{$fallback}"}))
		{
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
	private function _load($view, $data = array())
	{
		// Done after theme setup and theme menus.
		$this->_is_admin OR do_action('after_theme_setup');

		// We add theme menus.
		(false !== has_action('theme_menus')) && do_action('theme_menus');

		// We add themes images sizes.
		if (has_action('theme_images'))
		{
			do_action('theme_images');

			// INTERNAL ACTION! DON'T REMOVE IT AND NEVER USE IT.
			do_action('_set_images_sizes');
		}

		// Prepare our empty layout array.
		$layout = array();

		// If there are any partial views enqueued, load theme.
		$_partials_action = $this->_is_admin ? 'enqueue_admin_partials' : 'enqueue_partials';
		do_action($_partials_action);

		if (isset($this->_partials) && is_array($this->_partials))
		{
			foreach ($this->_partials as $name => $partial)
			{
				$layout[$name] = $partial;
			}
		}

		// Pass all given $data to the requested view file then load it.
		$this->_the_content = $layout['content'] = $this->_load_file($view, $data, 'view');

		// If there are any filter applied to it, use them.
		if ('admin' !== $this->controller)
		{
			$this->_the_content = apply_filters('the_content', $this->_the_content);
		}

		/**
		 * Let's now prepare the layout file to load.
		 * It is possible to change the layout on functions.php
		 * by using the 'theme_layout' filter.
		 */
		(isset($this->_layout)) OR $this->_layout = $this->get_layout();

		// Use the default layout if not found.
		(null === $this->_layout) && $this->_layout = 'default';

		/**
		 * Disable sodding IE7's constant cacheing!!
		 * @author 	Philip Sturgeon
		 * @see 	https://forum.codeigniter.com/archive/index.php?thread-24161.html
		 */
		$this->ci->output->set_header('HTTP/1.0 200 OK');
		$this->ci->output->set_header('HTTP/1.1 200 OK');
		$this->ci->output->set_header('Expires: Sat, 01 Jan 2000 00:00:01 GMT');
		$this->ci->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->ci->output->set_header('Cache-Control: post-check=0, pre-check=0, max-age=0');
		$this->ci->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		$this->ci->output->set_header('Pragma: no-cache');

		// Let CI do the caching instead of the browser
		$this->ci->output->cache($this->_cache_lifetime);

		// Load the layout file.
		$output = $this->_load_file($this->_layout, $layout, 'layout');

		// Additional filters.
		$output = (true === $this->_is_admin)
			? apply_filters('admin_output', $output)
			: apply_filters('the_output', $output);

		// If the header file was not called, make sure to call it.
		if ($this->_header_called === false)
		{
			$output = $this->get_header().PHP_EOL.$output;
		}

		// If the footer file was not called, make sure to call it.
		if ($this->_footer_called === false)
		{
			$output = $output.PHP_EOL.$this->get_footer();
		}

		// Should we compress the output?
		if ($this->_compress === true)
		{
			$output = $this->compress_output($output);
		}

		return $output;
	}

	// --------------------------------------------------------------------
	// Utilities
	// --------------------------------------------------------------------

	/**
	 * Whether to use _remove_extension or not.
	 * @var bool
	 */
	private $_remove_extension = true;

	/**
	 * Disable the use of _remove_extension method.
	 * @access 	public
	 * @return 	object
	 */
	public function no_extension()
	{
		$this->_remove_extension = false;
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * do_extension
	 *
	 * Method for making sure this library puts back files extensions in case
	 * the "no_extension" was called. Make sure to call it right after you
	 * call the late one.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.5.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function do_extension()
	{
		$this->_remove_extension = true;
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Removes files extension
	 * @access 	protected
	 * @param 	mixed 	string or array
	 * @return 	mixed 	string or array
	 */
	public function _remove_extension($file, $ext = 'css')
	{
		// In case of multiple items
		if (is_array($file))
		{
			$temp_files = array();
			foreach ($file as $index => $single_file)
			{
				$temp_files[$index] = $this->_remove_extension($single_file, $ext);
			}
			return $temp_files;
		}

		// Removing extension is disabled? Return the file as-is.
		if ($this->_remove_extension === false)
		{
			return $file;
		}

		// Let's make sure to remove all dots first.
		$ext = preg_replace("/^\.+|\.+$/", '', strtolower($ext));

		// Use minified versions on production.
		('production' === ENVIRONMENT) && $file .= '.min';

		/**
		 * Let's first check if the file extension is
		 * present or not. If not, add it.
		 */
		$found_ext = pathinfo($file, PATHINFO_EXTENSION);

		($found_ext === $ext) OR $file = $file.'.'.$ext;

		return $file;
	}

	// --------------------------------------------------------------------

	/**
	 * Make sure the .htaccess file that denies direct
	 * access to folder is present.
	 *
	 * @access 	private
	 * @param 	string 	$path 	the path to check/create .htaccess
	 * @return 	void
	 */
	private function _check_htaccess($path)
	{
		/**
		 * To create the .htaccess, we need to check few things:
		 * 1. The path is valid.
		 * 2. The path is writable.
		 * 3. The .htaccess does not exists.
		 * 4. NEVER EVER, write to themes folder.
		 * If the selected path is not valid, or is not writtable
		 * or the .htaccess file is already there, nothing to do.
		 */
		if ($path == $this->_theme_path
			OR false === realpath($path)
			OR !is_writable($path)
			OR is_file($path.DS.'.htaccess'))
		{
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
		$_htaccess_file    = fopen($path.DS.'.htaccess', 'w');
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
	private function _detect_browser()
	{
		// If it's not enabled, nothing to do.
		if ($this->_detect_browser !== true)
		{
			return;
		}

		// Make sure to load user_agent library if not loaded.
		if ( ! class_exists('CI_User_agent', false))
		{
			$this->ci->load->library('user_agent');
		}

		// Get the browser's name.
		$this->_client['browser'] = ($this->_is_mobile === true) ? $this->ci->agent->mobile() : $this->ci->agent->browser();

		// Add browse's version.
		$this->_client['version'] = $this->ci->agent->version();

		// Collect accepted languages.
		$this->_client['languages'] = array_values(array_filter(
			$this->ci->agent->languages(),
			function($lang)
			{
				return strlen($lang) <= 3;
			}
		));

		// Set the client used platform (Windows, IOs, Unix ...).
		$this->_client['platform'] = $this->ci->agent->platform();
	}

	// --------------------------------------------------------------------
	// Output Compression.
	// --------------------------------------------------------------------

	/**
	 * Compresses the HTML output
	 *
	 * @since 	1.0.0
	 * @since 	1.4.1 	All HTML is compressed except for <pre> tags content.
	 * 
	 * @access 	private
	 * @param 	string 	$output 	the html output to compress
	 * @return 	string 	the minified version of $output
	 */
	public function compress_output($output)
	{
		// Make sure $output is always a string
		(is_string($output)) OR $output = (string) $output;
		
		// Nothing? Don't process.
		if ('' === trim($output))
		{
			return '';
		}

		// Conserve <pre> tags.
		$pre_tags = array();

		if (false !== strpos($output, '<pre'))
		{
			// We explode the output and always keep the last part.
			$parts     = explode('</pre>', $output);
			$last_part = array_pop($parts);

			// Reset output.
			$output = '';

			// Marker used to identify <pre> tags.
			$i = 0;

			foreach ($parts as $part)
			{
				$start = strpos($part, '<pre');

				// Malformed? Add it as it is.
				if (false === $start)
				{
					$output .= $part;
					continue;
				}

				// Identify the pre tag and keep it.
				$name = "<pre csk-pre-tag-{$i}></pre>";
				$pre_tags[$name] = substr($part, $start).'</pre>';
				$output .= substr($part, 0, $start).$name;
				$i++;
			}

			// Always add the last part.
			$output .= $last_part;
		}

		// Compress the final output.
		$output = $this->_compress_output($output);

		// If we have <pre> tags, add them.
		if ( ! empty($pre_tags))
		{
			$output = str_replace(array_keys($pre_tags), array_values($pre_tags), $output);
		}

		// Return the final output.
		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * _compress_output
	 *
	 * The real method behind final output compression.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.1
	 *
	 * @access 	private
	 * @param 	string 	$output 	The final output.
	 * @return 	string 	The final output after compression.
	 */
	private function _compress_output($output)
	{
		// In orders, we are searching for
		// 1. White-spaces after tags, except space.
		// 2. White-spaces before tags, except space.
		// 3. Multiple white-spaces sequences.
		// 4. HTML comments
		// 5. CDATA
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
			"//&lt;![CDATA[\n".'\1'."\n//]]>"
		), $output);

		// We return the minified $output
		return $output;
	}

}

// --------------------------------------------------------------------
// HELPERS
// --------------------------------------------------------------------

if ( ! function_exists('is_cdn_enabled'))
{
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

if ( ! function_exists('is_module'))
{
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
		// Make sure the fetch_module exists.
		if ( ! method_exists(get_instance()->router, 'fetch_module'))
		{
			return false;
		}

		// If no modules provided, we make sure we are on a module.
		if ($modules === null)
		{
			return (get_instance()->theme->module !== null);
		}

		/**
		 * Doing the following makes it possible to
		 * check for multiple modules.
		 */
		if ( ! is_array($modules))
		{
			$modules = array_map('trim', explode(',', $modules));
		}

		// Compare between modules names.
		return (in_array(get_instance()->router->fetch_module(), $modules));
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('is_controller'))
{
	/**
	 * Checks if the page belongs to a given controller.
	 * @return 	bool
	 */
	function is_controller($controllers = null)
	{
		if ( ! is_array($controllers))
		{
			$controllers = array_map('trim', explode(',', $controllers));
		}

		// Compare between controllers names.
		return (in_array(get_instance()->router->fetch_class(), $controllers));
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('is_method'))
{
	/**
	 * Checks if the page belongs to a given method.
	 * @return 	bool
	 */
	function is_method($methods = null)
	{
		if ( ! is_array($methods))
		{
			$methods = array_map('trim', explode(',', $methods));
		}

		// Compare between methods names.
		return (in_array(get_instance()->router->fetch_method(), $methods));
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('is_admin'))
{
	/**
	 * This function returns TRUE if we are on the admin controller.
	 * @since 	1.0.0
	 * @since 	2.0.0 	Updated because we added more contexts.
	 * @return boolean
	 */
	function is_admin()
	{
		$CI =& get_instance();
		
		global $back_contexts, $csk_modules;

		$is_admin = false;
		$controller = $CI->router->fetch_class();

		if (in_array($controller, $back_contexts)
			OR in_array($controller, $csk_modules)
			OR 'admin' === $controller
			OR 'admin' === $CI->uri->segment(1))
		{
			$is_admin = true;
		}

		return $is_admin;
	}
}

/*================================================================
=            MODULES, CONTROLLERS AND METHODS GETTERS            =
================================================================*/

if ( ! function_exists('get_the_module'))
{
	/**
	 * Returns the current module's name.
	 * @return 	string
	 */
	function get_the_module()
	{
		$CI =& get_instance();

		return (method_exists($CI->router, 'fetch_module'))
			? $CI->router->fetch_module()
			: null;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('the_module'))
{
	/**
	 * Returns the current module's name.
	 * @return 	void
	 */
	function the_module()
	{
		echo get_the_module();
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('get_the_controller'))
{
	/**
	 * Returns the current controller's name.
	 * @return 	string
	 */
	function get_the_controller()
	{
		return get_instance()->router->fetch_class();
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('the_controller'))
{
	/**
	 * Returns the current controller's name.
	 * @return 	void
	 */
	function the_controller()
	{
		echo get_the_controller();
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('get_the_method'))
{
	/**
	 * Returns the current method's name.
	 * @return 	string
	 */
	function get_the_method()
	{
		return get_instance()->router->fetch_method();
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('the_method'))
{
	/**
	 * Returns the current method's name.
	 * @return 	void
	 */
	function the_method()
	{
		echo get_the_method();
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('is_layout'))
{
	/**
	 * This function is used to check the current theme's layout.
	 * @param 	string 	$layout 	The layout to check.
	 * @return 	bool
	 */
	function is_layout($layout = null)
	{
		return ($layout == get_instance()->theme->get_layout());
	}
}

/*================================================
=            CLIENT'S BROWSER METHIDS            =
================================================*/

if ( ! function_exists('is_mobile'))
{
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

if ( ! function_exists('html_class'))
{
	/**
	 * Displays and applies classes to <html> tag.
	 */
	function html_class($class = null, $echo = true)
	{
		$classes = get_instance()->theme->html_class($class);
		if (false === $echo)
		{
			return $classes;
		}
		echo $classes;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('language_attributes'))
{
	/**
	 * Displays and applies classes to <html> tag.
	 */
	function language_attributes($attributes = null, $echo = true)
	{
		$attrs = get_instance()->theme->language_attributes($attributes);
		if (false === $echo)
		{
			return $attrs;
		}
		echo $attrs;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('body_class'))
{
	/**
	 * Displays and applies classes to <body> tag.
	 */
	function body_class($class = null)
	{
		echo get_instance()->theme->body_class($class);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('get_body_class'))
{
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

if ( ! function_exists('get_theme_url'))
{
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

if ( ! function_exists('theme_url'))
{
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

if ( ! function_exists('get_theme_path'))
{
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

if ( ! function_exists('theme_path'))
{
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

if ( ! function_exists('get_upload_url'))
{
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

if ( ! function_exists('upload_url'))
{
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

if ( ! function_exists('get_upload_path'))
{
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

if ( ! function_exists('upload_path'))
{
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

if ( ! function_exists('get_common_url'))
{
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

if ( ! function_exists('common_url'))
{
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

if ( ! function_exists('get_common_path'))
{
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

if ( ! function_exists('common_path'))
{
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

if ( ! function_exists('assets_url'))
{
	/**
	 * You should use "theme_url" or "common_url" to return
	 * URLs to your asset files. This function is here only 
	 * if you want to use a different approach.
	 * @param 	string 	$file 		The file your want to generate URL to.
	 * @param 	bool 	$common 	Load it from common or theme folder.
	 * @return 	string 	The full URL to the file.
	 */
	function assets_url($file = null, $common = false)
	{
		// If a full link is passed, return it as it is.
		if (filter_var($file, FILTER_VALIDATE_URL) !== false)
		{
			return $file;
		}

		return ($common === true)
			? get_common_url($file)
			: get_theme_url($file);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('img_alt'))
{
	/**
	 * Displays an alternative image using placehold.it website.
	 *
	 * @return  string
	 */
	function img_alt($width, $height = null, $text = null, $background = null, $foreground = null)
	{
		$params = array();
		if (is_array($width))
		{
			$params = $width;
		}
		else
		{
			$params['width']      = $width;
			$params['height']     = $height;
			$params['text']       = $text;
			$params['background'] = $background;
			$params['foreground'] = $foreground;
		}

		$params['height']     = (empty($params['height'])) ? $params['width'] : $params['height'];
		$params['text']       = (empty($params['text'])) ? $params['width'].' x '.$params['height'] : $params['text'];
		$params['background'] = (empty($params['background'])) ? 'CCCCCC' : $params['height'];
		$params['foreground'] = (empty($params['foreground'])) ? '969696' : $params['foreground'];
		return '<img src="http://placehold.it/'.$params['width'].'x'.$params['height'].'/'.$params['background'].'/'.$params['foreground'].'&text='.$params['text'].'" alt="Placeholder">';
	}
}

/*=======================================
=            TITLE FUNCTIONS            =
=======================================*/

if ( ! function_exists('the_title'))
{
	/**
	 * Echoes the page title.
	 * @param   string  $before     string to prepend to title.
	 * @param   string  $after      string to append to title.
	 * @param   bool    $echo       whether to echo or not.
	 * @return  string
	 */
	function the_title($before = null, $after = null, $echo = true)
	{
		if ($echo === false)
		{
			return get_instance()->theme->get_title($before, $after);
		}

		echo get_instance()->theme->get_title($before, $after);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('the_extra_head'))
{
	/**
	 * This function is used to return/output the extra head content
	 * part. It should be used right before the closing </head> tag.
	 * @param 	string 	$content 	The content you want to output.
	 * @param 	bool 	$echo 		Whether to echo or return.
	 * @return 	string
	 */
	function the_extra_head($content = null, $echo = true)
	{
		// Should we return it instead?
		if ($echo === false)
		{
			return get_instance()->theme->print_extra_head($content);
		}

		echo get_instance()->theme->print_extra_head($content);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('add_ie9_support'))
{
	/**
	 * This function is used alongside the "extra_head" filter in order
	 * to add support for old browsers (Internet Explorer)
	 * @param 	string 	$output 	The extra head content.
	 * @param 	bool 	$remote 	Whether to load from CDN or use local files.
	 * @return 	void
	 */
	function add_ie9_support(&$output, $remote = true)
	{
		$html5shiv = 'https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js';
		$respond   = 'https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js';

		if ($remote === false)
		{
			$html5shiv = get_common_url('js/html5shiv-3.7.3.min.js');
			$respond   = get_common_url('js/respond-1.4.2.min.js');
		}
		$output .= <<<EOT
	<!--[if lt IE 9]>
    <script type="text/JavaScript" src="{$html5shiv}"></script>
    <script type="text/JavaScript" src="{$respond}"></script>
    <![endif]-->
EOT;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('the_content'))
{
	/**
	 * This function output/echoes the loaded view file content.
	 * @param 	bool 	$echo 	whether to output or return the content.
	 * @return 	string
	 */
	function the_content($echo = true)
	{
		if ($echo === false)
		{
			return get_instance()->theme->print_content();
		}

		echo get_instance()->theme->print_content();
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('the_analytics'))
{
	/**
	 * This function is used to output the full Google Analytics code.
	 * You may want to use it right before the closing </body> tag.
	 * @param 	string 	$site_id 	Google Analytics ID.
	 * @return 	void
	 */
	function the_analytics($site_id = null)
	{
		echo get_instance()->theme->print_analytics($site_id);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('get_the_analytics'))
{
	/**
	 * This function is similar to the "the_analytics" function, the
	 * only different is that is returns the code instead of output.
	 * @param 	string 	$site_id 	Google Analytics ID.
	 * @return 	string
	 */
	function get_the_analytics($site_id = null)
	{
		return get_instance()->theme->print_analytics($site_id);
	}
}

/*==========================================
=            METADATA FUNCTIONS            =
==========================================*/

if ( ! function_exists('meta_tag')):
	/**
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
		if (is_array($name))
		{
			$meta = array();
			foreach ($name as $key => $val)
			{
				$meta[] = meta_tag($key, $val, $type, $attrs);
			}

			return implode("\n\t", $meta);
		}

		$attributes = array();
		switch ($type)
		{
			case 'rel':
				$tag                = 'link';
				$attributes['rel']  = $name;
				$attributes['href'] = $content;
				break;

			// In case of a meta tag.
			case 'meta':
			default:
				if ($name == 'charset')
				{
					return "<meta charset=\"{$content}\" />";
				}

				if ($name == 'base')
				{
					return "<base href=\"{$content}\" />";
				}

				// The tag by default is "meta"

				$tag = 'meta';

				// In case of using Open Graph tags,
				// we user 'property' instead of 'name'.

				$type = (false !== strpos($name, 'og:')) ? 'property' : 'name';

				if ($content === null)
				{
					$attributes[$type] = $name;
				}
				else
				{
					$attributes[$type]     = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
					$attributes['content'] = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
				}

				break;
		}

		$attributes = (is_array($attrs)) ? _stringify_attributes(array_merge($attributes, $attrs)) : _stringify_attributes($attributes).' '.$attrs;

		return "<{$tag}{$attributes}/>";
	}
endif;

// --------------------------------------------------------------------

if ( ! function_exists('the_meta_tags'))
{
	/**
	 * Ouputs site <meta> tags.
	 * @param   bool    $echo   whether to return or echo.
	 */
	function the_meta_tags($echo = true)
	{
		if ($echo === false)
		{
			return get_instance()->theme->print_meta_tags();
		}

		echo get_instance()->theme->print_meta_tags();
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('add_meta_tag'))
{
	/**
	 * Allow the user to add <meta> tags.
	 * @param   mixed   $name   meta tag's name
	 * @param   mixed   $content
	 * @return  object
	 */
	function add_meta_tag($name, $content = null, $type = 'meta', $attrs = array())
	{
		return get_instance()->theme->add_meta($name, $content, $type, $attrs);
	}
}

/*=======================================================
=            STYLES AND STYLSHEETS FUNCTIONS            =
=======================================================*/

if ( ! function_exists('css'))
{
	/**
	 * Outputs a full CSS <link> tag.
	 * @param   string  $file   the file name.
	 * @param   string  $cdn    the cdn file to use.
	 * @param   array   $attrs  array of additional attributes.
	 * @param   bool    $common in case of a js file in the common folder.
	 */
	function css($file, $cdn = null, $attrs = array(), $common = false)
	{
		if ($file)
		{
			$attributes = array(
				'rel' => 'stylesheet',
				'type' => 'text/css'
			);

			$file = ($common === true) ? get_common_url($file) : get_theme_url($file);

			$file               = preg_replace('/.css$/', '', $file).'.css';
			$attributes['href'] = $file;

			// Are there any other attributes to use?
			if (is_array($attrs))
			{
				$attributes = array_replace_recursive($attributes, $attrs);
				return '<link'._stringify_attributes($attributes).'/>'."\n";
			}

			$attributes = _stringify_attributes($attributes)." {$attrs}";
			return '<link'.$attributes.' />'."\n\t";
		}

		return null;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('the_stylesheets'))
{
	/**
	 * Outputs css link tags and in-line stypes.
	 * @param   bool    $echo   whether to echo or not
	 * @return  string
	 */
	function the_stylesheets($echo = true)
	{
		if ($echo === false)
		{
			return get_instance()->theme->print_styles();
		}

		echo get_instance()->theme->print_styles();
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('add_style'))
{
	/**
	 * Adds StyleSheets to view.
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

if ( ! function_exists('add_inline_style'))
{
	/**
	 * Allows the user to add an in-line styles that can even
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

if ( ! function_exists('remove_style'))
{
	/**
	 * Removes a given file by its handle.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Update to format arguments.
	 */
	function remove_style()
	{
		// We make sure to collect arguments and format them.
		$args = func_get_args();
		(is_array($args[0])) && $args = $args[0];

		return get_instance()->theme->remove('css', $args);
	}
}


// --------------------------------------------------------------------

if ( ! function_exists('replace_style'))
{
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

if ( ! function_exists('js'))
{
	/**
	 * Outputs a full <script> tag.
	 * @param   string  $file   the file name.
	 * @param   string  $cdn    the cdn file to use.
	 * @param   array   $attrs  array of additional attributes.
	 * @param   bool    $common in case of a js file in the common folder.
	 */
	function js($file, $cdn = null, $attrs = array(), $common = false)
	{
		if ($file)
		{
			$attributes['type'] = 'text/JavaScript';

			$file = ($common === true) ? get_common_url($file) : get_theme_url($file);

			$file              = preg_replace('/.js$/', '', $file).'.js';
			$attributes['src'] = $file;

			// Are there any other attributes to use?
			if (is_array($attrs))
			{
				$attributes = array_replace_recursive($attributes, $attrs);
				return '<link'._stringify_attributes($attributes).'/>'."\n";
			}

			$attributes = _stringify_attributes($attributes)." {$attrs}";
			return '<script'.$attributes.'></script>'."\n";
		}

		return null;
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('the_javascripts'))
{
	/**
	 * Returns or echoes all JavaScripts files and in-line scrips.
	 * @param   bool    $echo   whether to echo or not.
	 * @return  string
	 */
	function the_javascripts($echo = true)
	{
		if ($echo === false)
		{
			return get_instance()->theme->print_scripts();
		}

		echo get_instance()->theme->print_scripts();
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('add_script'))
{
	/**
	 * Adds JavaScript files to view.
	 */
	function add_script($handle = '', $file = null, $ver = null, $prepend = false, $attrs = array())
	{
		return get_instance()->theme->add('js', $file, $handle, $ver, $prepend, $attrs);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('add_inline_script'))
{
	/**
	 * Allows the user to add an in-line scripts that can even
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

if ( ! function_exists('remove_script'))
{
	/**
	 * Removes a given file by its handle.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Update to format arguments.
	 */
	function remove_script()
	{
		// We make sure to collect arguments and format them.
		$args = func_get_args();
		(is_array($args[0])) && $args = $args[0];

		return get_instance()->theme->remove('js', $args);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('replace_script'))
{
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

if ( ! function_exists('render'))
{
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

if ( ! function_exists('get_header'))
{
	/**
	 * Load the theme header file.
	 */
	function get_header($file = null, $echo = true)
	{
		if ($echo === false)
		{
			return get_instance()->theme->get_header($file);
		}

		echo get_instance()->theme->get_header($file);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('get_footer'))
{
	/**
	 * Load the theme footer file.
	 */
	function get_footer($file = null)
	{
		echo get_instance()->theme->get_footer($file);
	}
}

if ( ! function_exists('add_partial'))
{
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

if ( ! function_exists('get_partial'))
{
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

if ( ! function_exists('theme_set_var'))
{
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

if ( ! function_exists('theme_get_var'))
{
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

/*==========================================
=            LANGUAGE FUNCTIONS            =
==========================================*/

if ( ! function_exists('langinfo'))
{
	/**
	 * Return details about the current language.
	 * @param 	string
	 * @return 	mixed 	Array of language details or selected key.
	 */
	function langinfo($key = null)
	{
		return get_instance()->theme->language($key);
	}
}

/*==============================================
=            FLASH ALERTS FUNCTIONS            =
==============================================*/

if ( ! function_exists('set_alert'))
{
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

if ( ! function_exists('the_alert'))
{
	/**
	 * Echoes any set flash messages.
	 * @return  string
	 */
	function the_alert()
	{
		echo get_instance()->theme->get_alert();
	}
}

if ( ! function_exists('print_alert'))
{
	/**
	 * Displays a flash alert.
	 * @param  string $message the message to display.
	 * @param  string $type    the message type.
	 * @param  bool 	$js 	html or js
	 * @return string
	 */
	function print_alert($message = null, $type = 'info', $js = false, $echo = true)
	{
		$alert = get_instance()->theme->print_alert($message, $type, $js);
		if ($echo === false)
		{
			return $alert;
		}

		echo $alert;
	}
}

// ------------------------------------------------------------------------
// Utilities.
// ------------------------------------------------------------------------

if ( ! function_exists('array_clean'))
{
	/**
	 * array_clean
	 *
	 * Create specially for this library but it can be used anywhere.
	 * It make sure to trim array elements first, them remove empty
	 * element and final keep only unique ones.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 * 
	 * @param 	array
	 * @return 	void
	 */
	function array_clean($array)
	{
		if (is_array($array))
		{
			$array = array_map('trim', $array);
			$array = array_filter($array);
			$array = array_unique($array);
		}

		return $array;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('compress_html'))
{
	/**
	 * compress_html
	 *
	 * Uses the Theme::compress_output method to compress the given string.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.1
	 *
	 * @param 	string 	$html 	The HTML string to compress.
	 * @return 	string 	The HTML string after being compressed.
	 */
	function compress_html($html)
	{
		return get_instance()->theme->compress_output($html);
	}
}

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
 * Theme Library
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Packages\Libraries
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.1.6
 */
class Theme {

	/**
	 * CodeIgniter Skeleton copyright.
	 * @var string
	 */
	protected $skeleton_copyright =<<<EOT
\n<!--nocompress--><!--
Website proudly powered by CodeIgniter Skeleton (https://goo.gl/jb4nQC).
Project developed and maintained by Kader Bouyakoub (https://goo.gl/wGXHO9).
--><!--/nocompress-->
EOT;
	/**
	 * Header template
	 * @var string
	 */
	protected $template_header = <<<EOT
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
	protected $template_footer = <<<EOT
	{javascripts}
	{analytics}
</body>
</html>
EOT;

	/**
	 * Google analytics template.
	 * @var string
	 */
	protected $template_google_analytics = <<<EOT
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
	protected $template_layout = <<<EOT
<div class="container">
	{content}
</div><!-- /.container -->
EOT;

	/**
	 * Default alert message template to use
	 * as a fallback if none is provided.
	 */
	protected $template_alert = <<<EOT
<div class="{class} alert-dismissible fade show" role="alert">
	{message}
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
EOT;

	/**
	 * JavaSript alert template.
	 */
	protected $template_alert_js = <<<EOT
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
	protected $alert_classes = array(
		'info'    => 'alert alert-info',
		'error'   => 'alert alert-danger',
		'warning' => 'alert alert-warning',
		'success' => 'alert alert-success',
	);

	/**
	 * Holds and instance of CI object.
	 * @var object
	 */
	protected $CI;

	/**
	 * Flag to tell whether the user is a robot.
	 * @var bool
	 */
	public $is_robot = false;

	/**
	 * Flag to tell whether we are on the back-end or the front-end.
	 * @var bool
	 */
	public $is_admin = false;

	/**
	 * Flag to tell whether the user is on a mobile device.
	 * @var bool
	 */
	public $is_mobile = false;

	/**
	 * Holds an array of details about user's browser.
	 * @var array
	 */
	public $user_agent = array();

	/**
	 * Holds the current active theme.
	 * @var string
	 */
	protected $current_theme;

	/**
	 * Holds the active front-end theme.
	 * @var string
	 */
	protected $public_theme;

	/**
	 * Holds the currently used module's name (folder).
	 * @var string
	 */
	protected $module = null;

	/**
	 * Holds the currently accessed controller.
	 * @var string
	 */
	protected $controller = null;

	/**
	 * Holds the currently accessed controller's method.
	 * @var string
	 */
	protected $method = null;

	/**
	 * Holds the active back-end theme.
	 * @var string
	 */
	protected $admin_theme;

	/**
	 * Holds the path to the folder containing the current theme's layouts files.
	 * @var string
	 */
	protected $layouts_path;

	/**
	 * Holds the path to the folder containing the current theme's partials views.
	 * @var string
	 */
	protected $partials_path;

	/**
	 * Holds the path to the folder containing the current theme's views.
	 * @var string
	 */
	protected $views_path;

	/**
	 * Holds the currently used layout.
	 * @var string
	 */
	protected $layout = 'default';

	/**
	 * Holds the currently loaded view.
	 * @var string
	 */
	protected $view;

	/**
	 * Holds an array of loaded partial views.
	 * @var array
	 */
	protected $partials = array();

	/**
	 * Holds an array of data to be passed to views.
	 * @var array
	 */
	protected $data = array();

	/**
	 * Holds the array of <html> tag classes.
	 * @var array
	 */
	protected $html_classes = array();

	/**
	 * Holds the array of <body> tag classes.
	 * @var array
	 */
	protected $body_classes = array();

	/**
	 * Holds the current page's title.
	 * @var string
	 */
	protected $title;

	/**
	 * Holds the page's title parts separator.
	 * @var string
	 */
	protected $title_separator = ' &#8212; ';

	/**
	 * Holds an array of all meta tags.
	 * @var array
	 */
	protected $meta_tags = array();

	/**
	 * Holds the array of styles to be put first.
	 * @var array
	 */
	protected $prepended_styles = array();

	/**
	 * Holds the array of enqueued styles.
	 * @var array
	 */
	protected $styles = array();

	/**
	 * Holds the array of inline styles.
	 * @var array
	 */
	protected $inline_styles = array();

	/**
	 * Holds the array of removed styles.
	 * @var array
	 */
	protected $removed_styles = array();

	/**
	 * Holds the array of scripts to be put first.
	 * @var array
	 */
	protected $prepended_scripts = array();

	/**
	 * Holds the array of enqueued scripts.
	 * @var array
	 */
	protected $scripts = array();

	/**
	 * Holds the array of inline scripts.
	 * @var array
	 */
	protected $inline_scripts = array();

	/**
	 * Holds the array of removed scripts.
	 * @var array
	 */
	protected $removed_scripts = array();

	/**
	 * Holds extra content to be put before the closing </head> tag.
	 * @var string
	 */
	protected $extra_head = null;

	/**
	 * Flag to tell whether the header was called or not so we call it.
	 * @var boolean
	 */
	protected $header_called = false;

	/**
	 * Flag to tell whether the footer was called or not so we call it.
	 * @var boolean
	 */
	protected $footer_called = false;

	/**
	 * Holds the current view content.
	 * @var string
	 */
	protected $content;

	/**
	 * Holds the time for which content is cached. Default: 0
	 * @var integer
	 */
	protected $cache_lifetime = 0;

	/**
	 * Whether to compress the final output or not.
	 * @var boolean
	 */
	protected $compress = false;

	/**
	 * Holds the array of enqueued alert messages.
	 * @var array
	 */
	protected $messages = array();

	/**
	 * Holds the current URI segments.
	 * @var array
	 */
	protected $uri = array();

	/**
	 * Class constructor.
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	public function __construct()
	{
		$this->CI =& get_instance();

		$this->uri = $this->CI->uri->segment_array();

		$this->CI->config->load('theme');
	}

	// ------------------------------------------------------------------------

	/**
	 * Initializes class preferences.
	 * @access 	public
	 * @param 	array 	$config
	 * @return 	void
	 */
	public function initialize()
	{
		// Start our class initialization benchmark.
		$this->CI->benchmark->mark('theme_initialize_start');

		// Load all dependencies.
		$this->_load_dependencies();

		/**
		 * We define the constant that stores the path to the currently active
		 * theme, whether it's the front-end or the back-end theme.
		 */
		defined('THEME_PATH') OR define('THEME_PATH', $this->theme_path());

		// Store information about module, controller and method.
		$this->module     = $this->CI->router->fetch_module();
		$this->controller = $this->CI->router->fetch_class();
		$this->method     = $this->CI->router->fetch_method();

		// Check if the user is a robot.
		$this->is_robot = $this->CI->agent->is_robot();

		// Whether we are on the front-end or the back-end.
		$this->is_admin = $this->_is_admin();

		// Check if the user is on a mobile device.
		$this->is_mobile = $this->CI->agent->is_mobile();

		// We detect user's browser details.
		$this->user_agent = $this->_set_user_agent();

		// Overridden title separator.
		if (null !== ($title_separator = $this->CI->config->item('title_separator')))
		{
			$this->title_separator = $title_separator;
		}
		$this->title_separator = ' '.trim($this->title_separator).' ';

		// Overridden output compression.
		$this->compress = $this->CI->config->item('theme_compress');
		is_bool($this->compress) OR $this->compress = (ENVIRONMENT !== 'development');

		// Overridden cache lifetime.
		if (null !== ($cache_lifetime = $this->CI->config->item('cache_lifetime')))
		{
			$this->cache_lifetime = intval($cache_lifetime);
		}

		// Load the current theme's functions.php file.
		if (false === $this->theme_path('functions.php'))
		{
			log_message('error', 'Unable to locate the theme\'s "functions.php" file: '.$this->current_theme());
			show_error(sprintf(__('theme_missing_functions'), $this->current_theme()));
		}

		require_once($this->theme_path('functions.php'));

		// Set paths to layouts, partials and views.
		$this->layouts_path  = $this->apply_filters('theme_layouts_path', $this->theme_path('templates/layouts'));
		$this->partials_path = $this->apply_filters('theme_partials_path', $this->theme_path('templates/partials'));
		$this->views_path    = $this->apply_filters('theme_views_path', $this->theme_path('templates'));

		// A default variable that can be used to set active URI.
		$uri_string = uri_string(true);
		$this->CI->load->vars('uri_string', uri_string(true));

		// ENd of our class initialization benchmark.
		$this->CI->benchmark->mark('theme_initialize_end');
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns an array of available themes with optional details.
	 * @access 	public
	 * @param 	bool 	$details 	Whether to retrieve themes details.
	 * @return 	array 	Array of themes folder if $details is set to false, else
	 * array of available themes with their details.
	 */
	public function get_themes($details = false)
	{
		static $themes;

		if (is_null($themes))
		{
			$themes = array();
			$themes_path = $this->themes_path();

			if (false !== ($handle = opendir($themes_path)))
			{
				$ignored = array('.', '..', 'index.html', 'index.php', '.htaccess', '__MACOSX');

				while(false !== ($file = readdir($handle)))
				{
					if (is_dir($themes_path.'/'.$file) && ! in_array($file, $ignored))
					{
						$themes[] = $file;
					}
				}
			}
		}

		$return = $themes;

		if ($details && ! empty($themes))
		{
			foreach ($return as $i => $folder)
			{
				if (false !== ($details = $this->get_theme_details($folder)))
				{
					$return[$folder] = $details;
				}

				unset($return[$i]);
			}

			$return = $this->apply_filters('get_themes', $return);
		}

		return $return;
	}

	// ------------------------------------------------------------------------
	// Paths methods.
	// ------------------------------------------------------------------------

	/**
	 * Returns path to where themes are located.
	 * @access 	public
	 * @param 	string 	$uri 	The URI to append to the path.
	 * @return 	string 	The path after being normalized if found, else false.
	 */
	public function themes_path($uri = '')
	{
		static $path, $cached_paths = array();
		empty($path) && $path = FCPATH.'content/themes';

		$return = $path;

		if ( ! empty($uri))
		{
			if ( ! isset($cached_paths[$uri]))
			{
				$return = file_exists($path.'/'.$uri) ? normalize_path($path.'/'.$uri) : false;
				$cached_paths[$uri] = $return;
			}

			$return = $cached_paths[$uri];
		}
		else
		{
			$return = file_exists($path) ? normalize_path($path) : false;
		}

		return $return;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the full path to the currently active theme, whether it's the 
	 * front-end theme or dashboard theme.
	 * @access 	public
	 * @param 	string 	$uri
	 * @return 	mixed 	String if valid, else false.
	 */
	public function theme_path($uri = '', $theme = null)
	{
		static $path, $cached_paths = array();

		$theme OR $theme = $this->current_theme();

		if (is_null($path))
		{
			$path = path_join(FCPATH.'content/themes', $theme);
		}

		$return = $path;

		if ( ! empty($uri))
		{
			if ( ! isset($cached_paths[$uri]))
			{
				$return = file_exists($path.'/'.$uri) ? normalize_path($path.'/'.$uri) : false;
				$cached_paths[$uri] = $return;
			}

			$return = $cached_paths[$uri];
		}
		else
		{
			$return = file_exists($path) ? normalize_path($path) : false;
		}

		return $return;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the full path to uploads folder.
	 * @access 	public
	 * @param 	string 	$uri
	 * @return 	mixed 	String if valid path, else false.
	 */
	public function upload_path($uri = '')
	{
		static $path, $cached_paths = array();

		is_null($path) && $path = FCPATH.'content/uploads';

		$return = $path;

		if ( ! empty($uri))
		{
			if ( ! isset($cached_paths[$uri]))
			{
				$return = file_exists($path.'/'.$uri) ? normalize_path($path.'/'.$uri) : false;
				$cached_paths[$uri] = $return;
			}

			$return = $cached_paths[$uri];
		}
		else
		{
			$return = file_exists($path) ? normalize_path($path) : false;
		}

		return $return;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the full path to the common folder.
	 * @access 	public
	 * @param 	string 	$uri
	 * @return 	mixed 	String if valid path, else false.
	 */
	public function common_path($uri = '')
	{
		static $path, $cached_paths = array();

		is_null($path) && $path = FCPATH.'content/common';

		$return = $path;

		if ( ! empty($uri))
		{
			if ( ! isset($cached_paths[$uri]))
			{
				$return = file_exists($path.'/'.$uri) ? normalize_path($path.'/'.$uri) : false;
				$cached_paths[$uri] = $return;
			}

			$return = $cached_paths[$uri];
		}
		else
		{
			$return = file_exists($path) ? normalize_path($path) : false;
		}

		return $return;
	}

	// ------------------------------------------------------------------------
	// URLs methods.
	// ------------------------------------------------------------------------

	/**
	 * Returns the URL to the themes folder.
	 * @access 	public
	 * @param 	string 	$uri
	 * @param 	string 	$protocol
	 * @return 	string
	 */
	public function themes_url($uri = '', $protocol = null)
	{
		return base_url('content/themes/'.$uri, $protocol);
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the URL to the currently active theme, whether it's the front-end
	 * theme or the dashboard theme.
	 * @access 	public
	 * @param 	string 	$uri
	 * @param 	string 	$protocol
	 * @return 	string
	 */
	public function theme_url($uri = '', $protocol = null)
	{
		static $base_url, $_protocol, $cached_uris;

		if (empty($base_url) OR $_protocol !== $protocol)
		{
			$_protocol = $protocol;
			$base_url = path_join(base_url('content/themes', $_protocol), $this->current_theme());
		}

		$return = $base_url;

		if ( ! empty($uri))
		{
			if ( ! isset($cached_uris[$uri]))
			{
				$cached_uris[$uri] = $return.'/'.$uri;
			}

			$return = $cached_uris[$uri];
		}

		return $return;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the URL to the uploads folder.
	 * @access 	public
	 * @param 	string 	$uri
	 * @param 	string 	$protocol
	 * @return 	string
	 */
	public function upload_url($uri = '', $protocol = null)
	{
		static $base_url, $_protocol, $cached_uris;

		if (empty($base_url) OR $_protocol !== $protocol)
		{
			$_protocol = $protocol;

			$base_url = base_url('content/uploads', $_protocol);
		}

		$return = $base_url;

		if ( ! empty($uri))
		{
			if ( ! isset($cached_uris[$uri]))
			{
				$cached_uris[$uri] = $base_url.'/'.$uri;
			}

			$return = $cached_uris[$uri];
		}

		return $return;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the URL to the common folder.
	 * @access 	public
	 * @param 	string 	$uri
	 * @param 	string 	$protocol
	 * @return 	string
	 */
	public function common_url($uri = '', $protocol = null)
	{
		static $base_url, $_protocol, $cached_uris;

		if (empty($base_url) OR $_protocol !== $protocol)
		{
			$_protocol = $protocol;
			$base_url = base_url('content/common', $_protocol);
		}

		$return = $base_url;

		if ( ! empty($uri))
		{
			if ( ! isset($cached_uris[$uri]))
			{
				$cached_uris[$uri] = $base_url.'/'.$uri;
			}

			$return = $cached_uris[$uri];
		}

		return $return;
	}

	// ------------------------------------------------------------------------
	// Current theme methods.
	// ------------------------------------------------------------------------

	/**
	 * Returns the currently active theme depending on the site area.
	 * @access 	public
	 * @param 	none
	 * @return 	string
	 */
	public function current_theme()
	{
		// For the moment, dashboard themes are not separated, but they will be.
		return $this->public_theme();
		// return $this->public_theme();
		if ( ! isset($this->current_theme))
		{
			$this->current_theme = $this->_is_admin()
				? $this->admin_theme()
				: $this->public_theme();
		}

		return $this->current_theme;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the currently active front-end theme.
	 * @access 	public
	 * @param 	none
	 * @return 	string
	 */
	public function public_theme()
	{
		if ( ! isset($this->public_theme))
		{
			$this->public_theme = $this->CI->config->item('theme');
			$this->public_theme OR $this->public_theme = 'default';
		}

		return $this->public_theme;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the currently active dashboard theme.
	 * @access 	public
	 * @param 	none
	 * @return 	string
	 */
	public function admin_theme()
	{
		if ( ! isset($this->admin_theme))
		{
			$this->admin_theme = $this->CI->config->item('admin_theme');
			$this->admin_theme OR $this->admin_theme = 'osiris';
		}

		return $this->admin_theme;
	}

	// ------------------------------------------------------------------------

	/**
	 * Dynamically sets the current theme.
	 * @access 	public
	 * @param 	string 	$theme 	The theme's folder name.
	 * @return 	Theme
	 */
	public function set_theme($theme = null)
	{
		if (null !== $theme)
		{
			if ( ! isset($this->current_theme))
			{
				$this->current_theme = $this->current_theme();
			}

			if ($theme === $this->current_theme)
			{
				return $this;
			}

			if ($this->_is_admin())
			{
				$details = $this->get_theme_details($theme);

				if ( ! isset($details['admin']) OR true !== $details['admin'])
				{
					return $this;
				}
			}

			$this->current_theme = $theme;
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the currently active theme (For backward compatibility).
	 * @access 	public
	 * @param 	none
	 * @return 	string
	 */
	public function get_theme()
	{
		return $this->current_theme();
	}

	// ------------------------------------------------------------------------
	// Theme details.
	// ------------------------------------------------------------------------

	/**
	 * Returns details about the given theme.
	 * @access 	public
	 * @param 	string 	$folder 	The theme's folder name.
	 * @return 	mixed 	Array of details if valid, else false.
	 */
	public function get_theme_details($folder = null)
	{
		static $cached = array();
		$folder OR $folder = $this->current_theme();

		if ( ! isset($cached[$folder]))
		{
			if ( ! $folder)
			{
				return false;
			}

			$manifest_file = 'manifest.json';
			$manifest_dist = 'manifest.json.dist';

			$found = false;
			if (false !== is_file($manifest = $this->themes_path($folder.'/'.$manifest_file)))
			{
				$manifest = json_read_file($manifest);
				$found = true;

				// Create the distribution file just in case the file was edited.
				if (false === $this->themes_path($folder.'/'.$manifest_dist))
				{
					$theme_path = $this->themes_path($folder);
					@copy($theme_path.'/'.$manifest_file, $theme_path.'/'.$manifest_dist);
				}
			}

			if (true !== $found 
				&& false !== is_file($manifest = $this->themes_path($folder.'/'.$manifest_dist)))
			{
				$manifest = json_read_file($manifest);
				$found = true;

				// Copy the distribution file.
				if (false === $this->themes_path($folder.'/'.$manifest_file))
				{
					$theme_path = $this->themes_path($folder);
					@copy($theme_path.'/'.$manifest_dist, $theme_path.'/'.$manifest_file);
				}
			}

			if (true !== $found OR false === $manifest)
			{
				return false;
			}

			$details = $this->_details();
			foreach ($details as $key => $val)
			{
				if (isset($manifest[$key]))
				{
					$details[$key] = $manifest[$key];
				}
			}

			if (empty($details['screenshot']))
			{
				$details['screenshot'] = $this->common_url('img/theme-blank.png');
				foreach (array('.png', '.jpg', '.jpeg', '.gif') as $ext)
				{
					if (false !== $this->themes_path($folder.'/screenshot'.$ext))
					{
						$details['screenshot'] = $this->themes_url($folder.'/screenshot'.$ext);
						break;
					}
				}
			}

			// Add extra stuff.
			$details['folder'] = $folder;
			$details['full_path'] = $this->themes_path($folder);
			empty($details['textdomain']) && $details['textdomain'] = $folder;
			empty($details['domainpath']) && $details['domainpath'] = 'language';

			// Cache it first.
			$cached[$folder] = $details;
		}

		return $cached[$folder];
	}

	// ------------------------------------------------------------------------
	// Layout methods.
	// ------------------------------------------------------------------------

	/**
	 * Changes the currently used layout.
	 * @access 	public
	 * @param 	string 	$layout 	the layout's name.
	 * @return 	object
	 */
	public function set_layout($layout = 'default')
	{
		empty($layout) && $layout = 'default';
		$this->layout = $layout;
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the current layout's name.
	 * @access 	public
	 * @param 	none
	 * @return 	string.
	 */
	public function get_layout()
	{
		$this->layout = $this->apply_filters(
			$this->_is_admin() ? 'admin_layout' : 'theme_layout',
			$this->layout
		);

		return $this->layout;
	}

	// ------------------------------------------------------------------------

	/**
	 * layout_exists
	 *
	 * Method for checking the existence of the layout.
	 * 
	 * @access 	public
	 * @param 	string 	$layout 	The layout to check (Optional).
	 * @return 	bool 	true if the layout exists, else false.
	 */
	public function layout_exists($layout = null)
	{
		empty($layout) && $layout = $this->get_layout();
		
		$layout = preg_replace('/.php$/', '', $layout).'.php';
		
		$full_path = $this->apply_filters(
			$this->_is_admin() ? 'admin_layouts_path' : 'theme_layouts_path',
			$this->theme_path()
		);

		return is_file($full_path.'/'.$layout);
	}

	// ------------------------------------------------------------------------
	// Partials methods.
	// ------------------------------------------------------------------------

	/**
	 * Adds partial view
	 * @access 	public
	 * @param 	string 	$view 	view file to load
	 * @param 	array 	$data 	array of data to pass
	 * @param 	string 	$name 	name of the variable to use
	 */
	public function add_partial($view, $data = array(), $name = null)
	{
		empty($name) && $name = basename($view);

		if ( ! isset($this->partials[$name]))
		{
			$this->partials[$name] = $this->_load_file($view, $data, 'partial');
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Displays a partial view alone.
	 * @access 	public
	 * @param 	string 	$view 	the partial view name
	 * @param 	array 	$data 	array of data to pass
	 * @param 	bool 	$load 	load it if not cached?
	 * @return 	mixed
	 */
	public function get_partial($view, $data, $load = true)
	{
		$name = basename($view);

		$this->do_action('get_partial_'.$name);

		if (isset($this->partials[$name]))
		{
			return $this->partials[$name];
		}

		return $load ? null : $this->_load_file($view, $data, 'partial');
	}

	// ------------------------------------------------------------------------

	/**
	 * Checks whether the partial file exists or not.
	 * @access 	public
	 * @param 	string 	$partial 	The partial file to check.
	 * @return 	bool 	true if the view is found, else false.
	 */
	public function partial_exists($partial = null)
	{
		if ( ! empty($partial))
		{
			$partial = preg_replace('/.php$/', '', $partial).'.php';

			$full_path = $this->apply_filters(
				$this->is_admin() ? 'admin_partials_path' : 'theme_partials_path',
				$this->theme_path()
			);

			return is_file($full_path.'/'.$partial);
		}

		return false;
	}

	// ------------------------------------------------------------------------
	// Views methods.
	// ------------------------------------------------------------------------

	/**
	 * Changes the currently used view.
	 * @access 	public
	 * @param 	string 	$view 	the view's name.
	 * @return 	object
	 */
	public function set_view($view = null)
	{
		$this->view = empty($view) ? $this->_guess_view() : $view;
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the current view's name.
	 * @access 	public
	 * @param 	none
	 * @return 	string.
	 */
	public function get_view()
	{
		isset($this->view) OR $this->view = $this->_guess_view();

		// Front-end view.
		if ( ! $this->_is_admin())
		{
			$this->view = $this->apply_filters('theme_view', $this->view);
			return $this->view;
		}

		if ($this->module)
		{
			$this->view = preg_replace("/{$this->module}\//", '', $this->view);
			return $this->view;
		}

		if (has_filter('admin_view'))
		{
			$this->view = $this->apply_filters('admin_view', $this->view);
			return $this->view;
		}

		if ($this->_is_admin())
		{
			$view = str_replace('admin/', '', isset($this->view) ? $this->view : $this->method);
			$this->view = ($this->module && false !== ($modpath = $this->CI->router->module_path($this->module))) 
				? 'admin/'.$view : $view;
		}

		return $this->view;
	}

	// ------------------------------------------------------------------------

	/**
	 * Checks whether the view file exists or not.
	 * @access 	public
	 * @param 	string 	$view 	The view file to check.
	 * @return 	bool 	true if the view is found, else false.
	 */
	public function view_exists($view = null)
	{
		empty($view) && $view = $this->get_view();
		
		$view = preg_replace('/.php$/', '', $view).'.php';
		
		$full_path = $this->apply_filters(
			$this->_is_admin() ? 'admin_views_path' : 'theme_views_path',
			$this->theme_path()
		);

		return is_file($full_path.'/'.$view);
	}

	// ------------------------------------------------------------------------

	/**
	 * Attempts to guess the view load.
	 * @access 	protected
	 * @param 	none
	 * @return 	string
	 */
	protected function _guess_view()
	{
		$view = array();

		if ($this->_is_admin() OR KB_ADMIN === $this->CI->uri->segment(1))
		{
			$view[] = 'admin';
		}

		if ($this->module !== $this->controller)
		{
			$view[] = $this->module;
			$view[] = $this->controller;
		}

		$view[] = $this->method;

		return implode('/', array_clean($view));
	}

	// ------------------------------------------------------------------------
	// Data setter
	// ------------------------------------------------------------------------

	/**
	 * Add variables to views.
	 * @access 	public
	 * @param 	string 	$name 	Variable's name.
	 * @param 	mixed 	$value 	Variable's value.
	 * @param 	bool 	$global Whether to make it global or not.
	 * @return 	object
	 */
	public function set($name, $value = null, $global = false)
	{
		if (is_array($name))
		{
			$global = (bool) $value;

			foreach ($name as $key => $val)
			{
				$this->set($key, $val, $global);
			}

			return $this;
		}

		if (true !== $global)
		{
			$this->data[$name] = $value;
		}
		else
		{
			$this->CI->load->vars($name, $value);
		}

		return $this;
	}

	// ------------------------------------------------------------------------
	// Title methods.
	// ------------------------------------------------------------------------

	/**
	 * Sets the page title.
	 * @access 	public
	 * @param 	string 	$title
	 * @return 	object
	 */
	public function set_title()
	{
		$args = func_get_args();

		if ( ! empty($args))
		{
			is_array($args[0]) && $args = $args[0];
			$this->title = implode($this->title_separator, $args);
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the current page's title.
	 * @access 	public
	 * @param 	string 	$before 	string to be prepended.
	 * @param 	string 	$after 		string to be appended.
	 * @return 	string
	 */
	public function get_title($before = null, $after = null)
	{
		isset($this->title) OR $this->title = $this->_guess_title();
		is_array($this->title) OR $this->title = (array) $this->title;

		$this->title = $this->apply_filters(
			$this->_is_admin() ? 'admin_title' : 'the_title',
			$this->title
		);

		empty($before) OR array_unshift($this->title, $before);
		empty($before) OR array_push($this->title, $before);

		$this->title = implode($this->title_separator, array_clean($this->title));

		if ($this->_is_admin())
		{
			$skeleton_title = $this->apply_filters('skeleton_title', ' &lsaquo; '.__('CSK_SKELETON'));
			empty($skeleton_title) OR $this->title .= $skeleton_title;

			if (null !== ($site_name = $this->CI->config->item('site_name')))
			{
				$this->title .= $this->title_separator.$site_name;
			}
		}

		return $this->title;
	}

	// ------------------------------------------------------------------------

	/**
	 * Attempt to guess the title if it's not set.
	 * @access 	protected
	 * @param 	none
	 * @return 	array
	 */
	protected function _guess_title()
	{
		$title = array();

		$this->_is_admin() && $title[] = KB_ADMIN;

		$title[] = $this->module;
		$title[] = $this->controller;

		($this->method !== 'index') && $title[] = $this->method;

		$title = array_clean(array_map('ucwords', $title));

		$title = $this->apply_filters('guess_title', $title);

		return $title;
	}

	// ------------------------------------------------------------------------
	// Meta tags methods.
	// ------------------------------------------------------------------------

	/**
	 * Appends meta tags
	 * @access 	public
	 * @param 	mixed 	$name 	meta tag's name
	 * @param 	mixed 	$content
	 * @return 	object
	 */
	public function add_meta($name, $content = null, $type = 'meta', $attrs = array())
	{
		if (is_array($name))
		{
			foreach ($name as $key => $val)
			{
				$this->add_meta($key, $val, $type, $attrs);
			}

			return $this;
		}

		$this->meta_tags[$type.'::'.$name] = array('content' => $content);
		empty($attrs) OR $this->meta_tags[$type.'::'.$name]['attrs'] = $attrs;
		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns all cached meta_tags.
	 * @access 	public
	 * @return 	array
	 */
	public function get_meta()
	{
		return $this->meta_tags;
	}

	// ------------------------------------------------------------------------

	/**
	 * Takes all site meta tags and prepare the output string.
	 * @access 	public
	 * @return 	string
	 */
	public function print_meta_tags()
	{
		$before_filter = 'before_meta';
		$after_filter  = 'after_meta';

		if ($this->_is_admin())
		{
			$before_filter = 'before_admin_meta';
			$after_filter  = 'after_admin_meta';
		}

		$meta_tags = $this->apply_filters($before_filter, '');
		$meta_tags .= $this->_render_meta_tags();
		$meta_tags = $this->apply_filters($after_filter, $meta_tags);

		return $meta_tags;
	}

	// ------------------------------------------------------------------------

	/**
	 * Collects all additional meta_tags and prepare them for output
	 * @access 	protected
	 * @param 	none
	 * @return 	string
	 */
	protected function _render_meta_tags()
	{
		$action = 'enqueue_admin_meta';
		$filter = 'render_admin_meta_tags';

		if ( ! $this->_is_admin())
		{
			$action = 'enqueue_meta';
			$filter = 'render_meta_tags';

			$generator = $this->apply_filters('skeleton_generator', 'CodeIgniter Skeleton '.KB_VERSION);
			empty($generator) OR $this->add_meta('generator', $generator);
		}

		$this->do_action($action);

		$output = '';

		$i = 1;
		$j = count($this->meta_tags);

		foreach ($this->meta_tags as $key => $val)
		{
			list($type, $name) = explode('::', $key);
			$content = isset($val['content']) ? deep_htmlentities($val['content']) : null;
			$attrs   = isset($val['attrs']) ? $val['attrs'] : null;

			$output = meta_tag($name, $content, $type, $attrs).($i === $j ? '' : "\n\t");

			$i++;
		}

		return $this->apply_filters($filter, $output);
	}

	// ------------------------------------------------------------------------
	// Assets handlers.
	// ------------------------------------------------------------------------

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
		if (empty($file) OR ! in_array($type, array('css', 'js')))
		{
			return $this;
		}

		if (is_array($file))
		{
			foreach ($file as $_handle => $_file)
			{
				if (is_int($_handle) && is_string($_file))
				{
					$this->add($type, $_file, null, $ver, $prepend, $attrs);
				}
				else
				{
					$this->add($type, $_file, $_handle, $ver, $prepend);
				}
			}

			return $this;
		}

		if (empty($handle))
		{
			$handle = preg_replace('/\./', '-', basename($file));
			$handle = preg_replace("/-{$type}$/", '', $handle)."-{$type}";
		}
		else
		{
			$handle = preg_replace("/-{$type}$/", '', $handle)."-{$type}";
			$attributes['id'] = $handle;
		}

		$handle = strtolower($handle);

		empty($ver) OR $file .= '?ver='.$ver;

		if ('css' === $type)
		{
			$attributes['rel']  = 'stylesheet';
			$attributes['type'] = 'text/css';
			$attributes['href'] = $file;
		}
		else
		{
			$attributes['type'] = 'text/javascript';
			$attributes['src']  = $file;
		}

		$attributes = array_replace_recursive($attributes, $attrs);

		if ('css' === $type)
		{
			$files = 'styles';
			$prepended = 'prepended_styles';
		}
		else
		{
			$files = 'scripts';
			$prepended = 'prepended_scripts';
		}

		if (true === $prepend OR 'jquery-js' === $handle)
		{
			$this->{$prepended}[$handle] = $attributes;

			$this->{$files} = array_replace_recursive($this->{$prepended}, $this->{$files});
		}
		else
		{
			$this->{$files}[$handle] = $attributes;
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Quick add styles.
	 * @access 	public
	 * @param 	string 	$file 		the file to add.
	 * @param 	string 	$handle 	the ID of the file.
	 * @param 	int 	$ver 		the version of the file.
	 * @param 	bool 	$prepend 	the file should be appended or prepended
	 * @return 	object 	instance of this class.
	 */
	public function add_style($file, $handle = null, $ver = null, $prepend = false, array $attrs = array())
	{
		return $this->add('css', $file, $handle, $ver, $prepend, $attrs);
	}

	// ------------------------------------------------------------------------

	/**
	 * Quick add scripts.
	 * @access 	public
	 * @param 	string 	$file 		the file to add.
	 * @param 	string 	$handle 	the ID of the file.
	 * @param 	int 	$ver 		the version of the file.
	 * @param 	bool 	$prepend 	the file should be appended or prepended
	 * @return 	object 	instance of this class.
	 */
	public function add_script($file, $handle = null, $ver = null, $prepend = false, array $attrs = array())
	{
		return $this->add('js', $file, $handle, $ver, $prepend, $attrs);
	}

	// ------------------------------------------------------------------------

	/**
	 * Simply remove any added files.
	 * @access 	public
	 * @param 	mixed
	 * @return 	void
	 */
	public function remove()
	{
		$args = func_get_args();
		if (empty($args))
		{
			return $this;
		}

		$type = array_shift($args);

		if ( ! in_array($type, array('css', 'js')))
		{
			return $this;
		}

		if ( ! empty($args))
		{
			is_array($args[0]) && $args = $args[0];

			foreach ($args as $handle)
			{
				$handle = preg_replace("/-{$type}$/", '', strtolower($handle))."-{$type}";

				if ($type === 'css')
				{
					$this->removed_styles[] = $handle;
					unset(
						$this->styles[$handle],
						$this->prepended_styles[$handle]
					);
				}
				else
				{
					$this->removed_scripts[] = $handle;
					unset(
						$this->scripts[$handle],
						$this->prepended_scripts[$handle]
					);
				}
			}
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Replaces any file by another.
	 * @access 	public
	 * @param 	string 	$type 		type of file to add.
	 * @param 	string 	$file 		the file to add.
	 * @param 	string 	$handle 	the ID of the file.
	 * @param 	int 	$ver 		the version of the file.
	 * @param 	bool 	$attrs 		new files attributes.
	 * @return 	object 	instance of this class.
	 */
	public function replace($type = 'css', $file = null, $handle = null, $ver = null, array $attrs = array())
	{
		if (empty($file) OR empty($handle))
		{
			return $this;
		}

		return $this->add($type, $file, $handle, $ver, false, $attrs);
	}

	// ------------------------------------------------------------------------

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
		if ( ! in_array($type, array('css', 'js')) OR empty(trim($content)))
		{
			return $this;
		}

		$handle = preg_replace("/-{$type}$/", '', $handle)."-{$type}";

		if ($type === 'css')
		{
			$this->inline_styles[$handle] = $content;
		}
		else
		{
			$this->inline_scripts[$handle] = $content;
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Quick add in-line styles.
	 * @access 	public
	 * @param 	string 	$content 	the in-line content.
	 * @param 	string 	$handle 	before which handle the content should be output.
	 * @return 	object
	 */
	public function add_inline_style($content = '', $handle = null)
	{
		return $this->add_inline('css', $content, $handle);
	}

	// ------------------------------------------------------------------------

	/**
	 * Quick add in-line scripts.
	 * @access 	public
	 * @param 	string 	$content 	the in-line content.
	 * @param 	string 	$handle 	before which handle the content should be output.
	 * @return 	object
	 */
	public function add_inline_script($content = '', $handle = null)
	{
		return $this->add_inline('js', $content, $handle);
	}

	// ------------------------------------------------------------------------

	/**
	 * Outputs all site StyleSheets and in-line styles string.
	 * @access 	public
	 * @param 	none
	 * @return 	string
	 */
	public function print_styles()
	{
		$styles = '';

		$before_filter = 'before_styles';
		$after_filter  = 'after_styles';

		if ($this->_is_admin())
		{
			$before_filter = 'before_admin_styles';
			$after_filter  = 'after_admin_styles';
		}

		$styles = $this->apply_filters($before_filter, $styles);

		$styles .= $this->_render_styles();

		$styles = $this->apply_filters($after_filter, $styles);

		return $styles;
	}

	// ------------------------------------------------------------------------

	/**
	 * Collects all additional CSS files and prepare them for output
	 * @access 	protected
	 * @param 	none
	 * @return 	string
	 */
	protected function _render_styles()
	{
		$action = 'enqueue_styles';
		$filter = 'print_styles';

		if ($this->_is_admin())
		{
			$action = 'enqueue_admin_styles';
			$filter = 'admin_print_styles';
		}

		$this->do_action($action);

		$temp_output = $this->apply_filters($filter, array(
			'inline' => $this->inline_styles,
			'styles' => $this->styles,
			'output' => null,
		));

		if (is_string($temp_output))
		{
			return $temp_output;
		}

		$output = '';

		$i = 1;
		$j = count($this->styles);
		foreach ($this->styles as $handle => $file)
		{
			if (isset($this->inline_styles[$handle]))
			{
				$output .= $this->inline_styles[$handle]."\n\t";
				unset($this->inline_styles[$handle]);
			}

			if (false !== $file)
			{
				$output .= '<link'._stringify_attributes($file).' />'.($i === $j ? '' : "\n\t");
			}
			$i++;
		}

		if ( ! empty($this->inline_styles))
		{
			$output .= implode("\n\t", $this->inline_styles);
		}

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * Outputs all script tags and in-line scripts.
	 * @access 	public
	 * @param 	none
	 * @return 	string
	 */
	public function print_scripts()
	{
		$before_filter = 'before_scripts';
		$after_filter  = 'after_scripts';

		if ($this->_is_admin())
		{
			$before_filter = 'before_admin_scripts';
			$after_filter  = 'after_admin_scripts';
		}

		$scripts = '';

		$scripts = $this->apply_filters($before_filter, $scripts)."\t";

		$scripts .= $this->_render_scripts();

		$scripts = $this->apply_filters($after_filter, $scripts)."\t";

		return $scripts;
	}

	// ------------------------------------------------------------------------

	/**
	 * Collect all additional JS files and prepare them for output
	 * @access 	protected
	 * @param 	none
	 * @return 	string
	 */
	protected function _render_scripts()
	{
		$action = 'enqueue_scripts';
		$filter = 'print_scripts';

		// On dashboard?
		if ($this->_is_admin())
		{
			$action = 'enqueue_admin_scripts';
			$filter = 'admin_print_scripts';
		}

		$this->do_action($action);

		$temp_output = $this->apply_filters($filter, array(
			'inline'  => $this->inline_scripts,
			'scripts' => $this->scripts,
			'output'  => null,
		));

		// An output was created? Return it
		if (is_string($temp_output))
		{
			return $temp_output;
		}

		$output = '';

		$i = 1;
		$j = count($this->scripts);

		if ( ! empty($this->scripts))
		{
			foreach ($this->scripts as $handle => $file)
			{
				if (isset($this->inline_scripts[$handle]))
				{
					$output .= $this->inline_scripts[$handle]."\n\t";
					unset($this->inline_scripts[$handle]);
				}

				if (false !== $file)
				{
					$output .= '<script'._stringify_attributes($file).'></script>'.($i === $j ? '' : "\n\t");
				}

				$i++;
			}
		}

		if ( ! empty($this->inline_scripts))
		{
			$output .= implode("\n\t", $this->inline_scripts);
		}

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * Outputs all additional head string.
	 * @access 	public
	 * @param 	string 	$content
	 * @return 	string
	 */
	public function print_extra_head($content = "\n")
	{
		return $this->apply_filters($this->_is_admin() ? 'admin_head' : 'extra_head', $content);
	}

	// ------------------------------------------------------------------------

	/**
	 * Outputs the default google analytics code.
	 * @access 	public
	 * @param 	string 	$site_id 	Google Analytics ID
	 * @return 	string
	 */
	public function print_analytics($site_id = null)
	{
		$site_id OR $site_id = $this->CI->config->item('google_analytics_id');
		
		$output = '';

		if ($site_id && 'UA-XXXXX-Y' !== $site_id)
		{
			$temp_analytics = $this->apply_filters(
				$this->_is_admin() ? 'admin_google_analytics' : 'google_analytics',
				$this->template_google_analytics
			);

			$output = str_replace('{site_id}', $site_id, $temp_analytics)."\n";
		}

		return $output;
	}

	// ------------------------------------------------------------------------
	// HTML and Body classes methods.
	// ------------------------------------------------------------------------

	/**
	 * Return the string to use for html_class()
	 * @access 	public
	 * @param 	string 	$class to add.
	 * @return 	string
	 */
	public function html_class($class = null)
	{
		$output = '';

		$this->html_classes = $this->apply_filters(
			$this->_is_admin() ? 'admin_html_class' : 'html_class',
			$this->html_classes
		);

		is_array($this->html_classes) OR $this->html_classes = (array) $this->html_classes;

		$class && array_unshift($this->html_classes, $class);

		$this->html_classes = array_clean($this->html_classes);

		if ( ! empty($this->html_classes))
		{
			$output .= ' class="'.implode(' ', $this->html_classes).'"';
		}

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * Return the string to use for get_body_class()
	 * @access 	public
	 * @param 	string 	$class 	class to add.
	 * @return 	string
	 */
	public function body_class($class = null)
	{
		$output = '';

		is_array($this->body_classes) OR $this->body_classes = (array) $this->body_classes;

		$class && array_unshift($this->body_classes, $class);

		if ($this->_is_admin())
		{
			$this->body_classes[] = 'csk-admin';
			$this->body_classes[] = 'ver-'.str_replace('.', '-', KB_VERSION);
			$this->body_classes[] = 'locale-'.strtolower($this->language('locale'));
		}

		$this->module && $this->body_classes[] = 'csk-'.$this->module;
		$this->body_classes[] = 'csk-'.$this->controller;
		('index' !== $this->method) && $this->body_classes[] = 'csk-'.$this->method;

		if ('login' !== $this->controller && 'rtl' === $this->language('direction'))
		{
			$this->body_classes[] = 'rtl';
		}

		$this->body_classes = array_clean($this->body_classes);

		$this->body_classes = $this->apply_filters(
			$this->_is_admin() ? 'admin_body_class' : 'body_class',
			$this->body_classes
		);

		empty($this->body_classes) OR $output .= ' class="'.implode(' ', $this->body_classes).'"';

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * Quick add classes to <html> tag.
	 * @access 	public
	 * @param 	mixed
	 * @return 	Theme
	 */
	public function set_html_class()
	{
		$classes = func_get_args();

		if ( ! empty($args))
		{
			is_array($args[0]) && $args = $args[0];

			$this->html_classes = array_clean(array_merge($this->html_classes, $args));
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Quick add classes to <body> tag.
	 * @access 	public
	 * @param 	mixed
	 * @return 	Theme
	 */
	public function set_body_class()
	{
		$classes = func_get_args();

		if ( ! empty($args))
		{
			is_array($args[0]) && $args = $args[0];

			$this->body_classes = array_clean(array_merge($this->body_classes, $args));
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the array of html classes.
	 * @access 	public
	 * @param 	none
	 * @return 	array
	 */
	public function get_html_class()
	{
		return $this->html_classes;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the array of body classes.
	 * @access 	public
	 * @param 	none
	 * @return 	array
	 */
	public function get_body_class()
	{
		return $this->body_classes;
	}

	// ------------------------------------------------------------------------
	// Language method.
	// ------------------------------------------------------------------------

	/**
	 * Returns details about the currently used language.
	 * @access 	public
	 * @param 	string 	$key 	The key to return.
	 * @return 	mixed 	Array of no key provided, else string
	 */
	public function language($key = null)
	{
		/**
		 * Make sure the method remembers the current language to reduce
		 * calling config class each time we use it.
		 * @var array
		 */
		static $language;
		is_null($language) && $language = $this->CI->config->item('current_language');
		return ($key && isset($language[$key])) ? $language[$key] : $language;
	}

	// ------------------------------------------------------------------------

	/**
	 * Set <html> language attributes.
	 * @access 	public
	 * @param 	array 	$attributes
	 * @return 	string
	 */
	public function language_attributes(array $attributes = null)
	{
		$output = '';

		$attrs = array($this->language('code'));

		$attrs = $this->apply_filters(
			$this->_is_admin() ? 'admin_language_attributes' : 'language_attributes',
			$attrs
		);

		empty($attributes) OR $attrs = array_merge($attributes, $attrs);

		$attrs = array_clean($attrs);

		empty($attrs) OR $output .= ' lang="'.implode(' ', $attrs).'"';

		if ('login' !== $this->controller && 'rtl' === $this->language('direction'))
		{
			$output .= ' dir="rtl"';
		}

		return $output;
	}

	// ------------------------------------------------------------------------
	// Rendering methods.
	// ------------------------------------------------------------------------

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
		$this->CI->benchmark->mark('theme_render_start');
		if ($this->_is_admin() && ! $this->theme_path())
		{
			die();
		}

		$this->load_translation();

		if (is_array($title))
		{
			$return  = (bool) $options;
			$options = $title;
			$title   = null;
		}
		elseif ( ! empty($title))
		{
			$options['title'] = $title;
		}

		foreach ($options as $key => $val)
		{
			if (in_array($key, array('css', 'js')))
			{
				$this->add($key, $val);
				continue;
			}

			if (method_exists($this, 'set_'.$key))
			{
				$this->{'set_'.$key}($val);
				continue;
			}

			$this->set($key, $val);
		}

		$output = $this->_load($this->get_view(), $data);

		$this->CI->benchmark->mark('theme_render_end');

		if ($this->CI->output->parse_exec_vars)
		{
			$output = str_replace(
				'{theme_time}',
				$this->CI->benchmark->elapsed_time('theme_render_start', 'theme_render_end'),
				$output
			);
		}

		if ($return)
		{
			return $output;
		}

		$this->CI->output->set_output($output);
	}

	// --------------------------------------------------------------------

	/**
	 * Loads view file
	 * @access 	protected
	 * @param 	string 	$view 		view to load
	 * @param 	array 	$data 		array of data to pass to view
	 * @param 	bool 	$return 	whether to output view or not
	 * @param 	string 	$master 	in case you use a distinct master view
	 * @return  void
	 */
	protected function _load($view, $data = array())
	{
		$this->_is_admin() OR $this->do_action('after_theme_setup');

		has_action('theme_menus') && $this->do_action('theme_menus');

		if (has_action('theme_images'))
		{
			$this->do_action('theme_images');
			$this->do_action('_set_images_sizes');
		}

		$layout = array();

		$this->do_action($this->_is_admin() ? 'enqueue_admin_partials' : 'enqueue_partials');

		if ( ! empty($this->partials))
		{
			foreach ($this->partials  as $name => $content)
			{
				$layout[$name] = $content;
			}
		}

		$this->content = $this->_load_file($view, $data, 'view');

		$this->content = $this->apply_filters(
			$this->_is_admin() ? 'admin_content' : 'the_content',
			$this->content
		);

		$layout['content'] = $this->content;

		isset($this->layout) OR $this->layout = $this->get_layout();

		$this->CI->output->set_header('HTTP/1.0 200 OK');
		$this->CI->output->set_header('HTTP/1.1 200 OK');
		$this->CI->output->set_header('Expires: Sat, 01 Jan 2000 00:00:01 GMT');
		$this->CI->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->CI->output->set_header('Cache-Control: post-check=0, pre-check=0, max-age=0');
		$this->CI->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
		$this->CI->output->set_header('Pragma: no-cache');

		if (is_int($this->cache_lifetime) && $this->cache_lifetime > 0)
		{
			$this->CI->output->cache($this->cache_lifetime);
		}

		$output = $this->_load_file($this->layout, $layout, 'layout');
		$output = $this->apply_filters($this->_is_admin() ? 'admin_output' : 'theme_output', $output);

		$output = $this->get_header().$output.$this->get_footer();

		$this->compress && $output = $this->compress_output($output);

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * Loads a file.
	 * @access 	protected
	 * @param 	string 	$file
	 * @param 	array 	$data
	 * @param 	string 	$type
	 * @return 	string if found, else false.
	 */
	protected function _load_file($file, $data = array(), $type = 'view')
	{
		$file = preg_replace('/.php$/', '', $file).'.php';
		$alt_path = KBPATH.'views/';
		$this->_is_admin() && $alt_path .= 'admin/';
		$alt_path = normalize_path($alt_path);
		
		$output = '';

		switch ($type) {
			case 'partial':
			case 'partials':
				$folder     = 'partials/';
				$filter     = $this->_is_admin() ? 'admin_partials_path' : 'theme_partials_path';
				$alt_filter = $this->_is_admin() ? 'admin_partial_fallback' : 'theme_partial_fallback';
				break;
			case 'layout':
			case 'layouts':
				$folder     = 'layouts/';
				$filter     = $this->_is_admin() ? 'admin_layouts_path' : 'theme_layouts_path';
				$alt_filter = $this->_is_admin() ? 'admin_layout_fallback' : 'theme_layout_fallback';
				break;
			
			case 'view':
			case 'views':
			default:
				$folder     = 'views/';
				$filter     = $this->_is_admin() ? 'admin_views_path' : 'theme_views_path';
				$alt_filter = $this->_is_admin() ? 'admin_view_fallback' : 'theme_view_fallback';
				break;
		}

		if ( ! $this->_is_admin() OR 'view' !== $type)
		{
			$alt_path .= $folder;
		}
		$alt_path = $this->apply_filters($filter, $alt_path);

		// Alternative file.
		$alt_file = $this->apply_filters($alt_filter, null);

		// Fall-back file.
		$fallback = singular($type);

		// Full path to file.
		if ( ! $this->module)
		{
			$full_path = $alt_path;
		}
		elseif (false !== ($modpath = $this->CI->router->module_path($this->module)))
		{
			$full_path = $modpath.$folder;
			if ('view' === $type && $this->_is_admin())
			{
				global $back_contexts;
				if (isset($this->uri[2]) && in_array($this->uri[2], $back_contexts))
				{
					$full_path .= $this->uri[2];
					$file = ltrim(str_replace(array($this->uri[1], $this->uri[2]), '', $file), '/');
				}
			}

		}

		$file_path = normalize_path($full_path.'/'.$file);
		$alt_file_path = normalize_path($alt_path.'/'.$file);

		if ( ! is_file($alt_file) && $this->module)
		{
			isset($modpath) OR $modpath = $this->CI->router->module_path($this->module);

			// Attempt to guess the folder from module's contexts.
			if ('view' === $type && $this->_is_admin())
			{
				global $back_contexts;
				if (isset($this->uri[2]) && in_array($this->uri[2], $back_contexts))
				{
					$folder .= $this->uri[2].'/';
				}
				else
				{
					$folder .= 'admin/';
				}
			}
			else
			{
				$folder = 'views/'.$folder;
			}

			$alt_file .= $modpath.$folder.$file;
		}

		if (is_file($file_path))
		{
			$this->_check_htaccess($full_path);

			empty($data) OR $this->CI->load->vars($data);

			$output = $this->CI->load->file($file_path, true);
		}
		elseif ($alt_file && is_file($alt_file))
		{
			$file_path = $alt_file;

			empty($data) OR $this->CI->load->vars($data);

			$output = $this->CI->load->file($file_path, true);
		}
		elseif ($alt_file_path && is_file($alt_file_path))
		{
			empty($data) OR $this->CI->load->vars($data);

			$output = $this->CI->load->file($alt_file_path, true);
		}
		elseif ($fallback && isset($this->{'template_'.$fallback}))
		{
			$search = array_map(function(&$val) {
				return "{{$val}}";
			}, array_keys($data));

			$replace = array_values($data);

			$output = str_replace($search, $replace, $this->{'template_'.$fallback});
		}
		else
		{
			show_error(sprintf(__('theme_missing_file'), normalize_path($full_path.'/'.$file)));
		}

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns the current view file content.
	 * @access 	public
	 * @param 	none
	 * @return 	string
	 */
	public function print_content()
	{
		return $this->content;
	}

	// ------------------------------------------------------------------------

	/**
	 * Alias of the method above.
	 * @access 	public
	 * @param 	none
	 * @return 	string
	 */
	public function the_content()
	{
		return $this->content;
	}

	// ------------------------------------------------------------------------
	// Header and Footer methods.
	// ------------------------------------------------------------------------

	/**
	 * Returns or outputs the header file or provided template.
	 * @access 	public
	 * @param 	string 	$name 	The name of the file to use (Optional).
	 * @return 	string
	 */
	public function get_header($name = null)
	{
		static $cached = array();

		if (isset($cached[$name]))
		{
			return $cached[$name];
		}

		$this->do_action('get_header', $name);

		$file = $backup_file = 'header.php';
		$name && $file = 'header-'.$name;
		$file = preg_replace('/.php$/', '', $file).'.php';

		$header_file = $this->theme_path($file);

		if ($header_file)
		{
			$output = $this->CI->load->file($header_file, true);
		}
		else
		{
			$replace['doctype']             = $this->apply_filters('the_doctype', '<!DOCTYPE html>');
			$replace['skeleton_copyright']  = $this->apply_filters('skeleton_copyright', $this->skeleton_copyright);
			$replace['base_url']            = base_url();
			$replace['html_class']          = $this->html_class();
			$replace['language_attributes'] = $this->language_attributes();
			$replace['charset']             = $this->CI->config->item('charset');
			$replace['title']               = $this->get_title();
			$replace['meta_tags']           = $this->print_meta_tags();
			$replace['stylesheets']         = $this->print_styles();
			$replace['extra_head']          = $this->print_extra_head();
			$replace['body_class']          = $this->body_class();

			$output = $this->template_header;

			foreach ($replace as $key => $val)
			{
				$output = str_replace('{'.$key.'}', $val, $output);
			}
		}

		$cached[$name] = $output;
		return $cached[$name];
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns or outputs the footer file or provided template.
	 * @access 	public
	 * @param 	string 	$name 	The name of the file to use (Optional).
	 * @return 	string
	 */
	public function get_footer($name = null)
	{
		static $cached = array();

		if (isset($cached[$name]))
		{
			return $cached[$name];
		}

		if (isset($this->removed_scripts))
		{
			// We start with Modernizr.
			if ( ! in_array('modernizr-js', $this->removed_scripts))
			{
				// Default is from CDN.
				$modernizr_url = ('development' === ENVIRONMENT)
					? $this->common_url('js/modernizr-2.8.3.min.js', '')
					: '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js';
				$this->add('js', $modernizr_url, 'modernizr', null, true);
			}
			
			// We now add jQuery.
			if ( ! in_array('jquery-js', $this->removed_scripts))
			{
				$jquery_url = ('development' === ENVIRONMENT)
					? $this->common_url('js/jquery-3.2.1.min.js', '')
					: '//code.jquery.com/jquery-3.2.1.min.js';
				$this->add('js', $jquery_url, 'jquery', null, true);
			}
		}

		$this->do_action('get_footer', $name);

		$file = $backup_file = 'footer.php';
		$name && $file = 'footer-'.$name;
		$file = preg_replace('/.php$/', '', $file).'.php';

		$footer_file = $this->theme_path($file);

		if ($footer_file)
		{
			$output = $this->CI->load->file($footer_file, true);
		}
		else
		{
			$output = str_replace(
				array('{javascripts}', '{analytics}'),
				array($this->print_scripts(), $this->print_analytics()),
				$this->template_footer
			);
		}

		$cached[$name] = $output;
		return $cached[$name];
	}

	// ------------------------------------------------------------------------
	// Alerts methods.
	// ------------------------------------------------------------------------

	/**
	 * Sets alert message by storing them in $messages property and session.
	 * @access 	public
	 * @param 	mixed 	$message 	Message string or associative array.
	 * @return 	object
	 */
	public function set_alert($message, $type = 'info')
	{
		if ( ! empty($message))
		{
			is_array($message) OR $message = array($type => $message);

			foreach ($message as $key => $val)
			{
				$this->messages[] = array($key => $val);
			}

			$this->CI->session->set_flashdata('__ci_alert', $this->messages);
		}

		return $this;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns all registered alerts.
	 * @access 	public
	 * @param 	none
	 * @return 	string
	 */
	public function get_alert()
	{
		$output = '';
		
		empty($this->messages) && $this->messages = $this->CI->session->flashdata('__ci_alert');

		if ( ! empty($this->messages))
		{
			if ( ! $this->_is_admin())
			{
				$this->template_alert = $this->apply_filters('alert_template', $this->template_alert);
				$this->alert_classes  = $this->apply_filters('alert_classes', $this->alert_classes);
			}

			foreach ($this->messages as $index => $message)
			{
				$key = key($message);

				$output .= str_replace(
					array('{class}', '{message}'),
					array($this->alert_classes[$key], $message[$key]),
					$this->template_alert
				);
			}
		}

		return $output;
	}

	// ------------------------------------------------------------------------

	/**
	 * Displays an alert.
	 * @access 	public
	 * @param 	string 	$message 	The message to display.
	 * @param 	string 	$type 		The type of the alert.
	 * @param 	bool 	$js 		Whether to use the JS template.
	 * @return 	string
	 */
	public function print_alert($message, $type = 'info', $js = false)
	{
		if (empty($message))
		{
			return '';
		}

		$template = (true === $js) ? $this->template_alert_js : $this->template_alert;

		if ( ! $this->_is_admin())
		{
			$template = (true === $js)
				? $this->apply_filters('alert_template_js', $this->template_alert_js)
				: $this->apply_filters('alert_template', $this->template_alert);
			
			$this->alert_classes = $this->apply_filters('alert_classes', $this->alert_classes);
		}

		$output = str_replace(
			array('{class}', '{message}'),
			array($this->alert_classes[$type], $message),
			$template
		);

		return $output;
	}

	// ------------------------------------------------------------------------
	// Theme translation methods.
	// ------------------------------------------------------------------------

	/**
	 * Allows themes to be translatable by loading their language files.
	 * @access 	public
	 * @param 	string 	$path 	The path to the theme's folder.
	 * @param 	string 	$index 	Unique identifier to retrieve language lines.
	 * @return 	void
	 */
	public function load_translation($path = null, $index = null)
	{
		/**
		 * Checks whether translations were already loaded or not.
		 * @var boolean
		 */
		static $loaded;

		if (true === $loaded)
		{
			return;
		}

		if (empty($path))
		{
			$path = $this->apply_filters('theme_translation', $this->theme_path('language'));
		}

		if ( ! $path)
		{
			return;
		}

		// Prepare our array of language lines.
		$full_lang = array();

		// We make sure the check the english version.
		$english_file = $path.'/english.php';

		if (false !== is_file($english_file))
		{
			require_once($english_file);

			if (isset($lang))
			{
				$full_lang = array_replace_recursive($full_lang, $lang);
				unset($lang);
			}
		}

		if ('english' !== ($language = $this->language('folder')) 
			&& false !== is_file($language_file = $path.'/'.$language.'.php'))
		{
			require_once($language_file);
			isset($lang) && $full_lang = array_replace_recursive($full_lang, $lang);
		}

		$full_lang = array_clean($full_lang);

		if ( ! empty($full_lang))
		{
			$textdomain = $this->apply_filters('theme_translation_index', $index);
			empty($textdomain) && $textdomain = $this->current_theme();

			$this->CI->lang->language[$textdomain] = $full_lang;
		}

		$loaded = true;
	}

	// ------------------------------------------------------------------------
	// Cache methods.
	// ------------------------------------------------------------------------

	/**
	 * Dynamically sets cache time.
	 * @access 	public
	 * @param 	int 	$minutes
	 * @return 	object
	 */
	public function set_cache($minutes = 0)
	{
		$this->cache_lifetime = $minutes;
		return $this;
	}

	// ------------------------------------------------------------------------
	// Output compression.
	// ------------------------------------------------------------------------

	/**
	 * Compresses the HTML output
	 *
	 * @since 	1.0.0
	 * @since 	1.4.1 	All HTML is compressed except for <pre> tags content.
	 * 
	 * @access 	protected
	 * @param 	string 	$output 	the html output to compress
	 * @return 	string 	the minified version of $output
	 */
	public function compress_output($output)
	{
		// Make sure $output is always a string
		is_string($output) OR $output = (string) $output;
		
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

		// Conserve <!--nocompress--> tags.
		$nocompress = array();

		if (false !== strpos($output, '<!--nocompress'))
		{
			// We explode the output and always keep the last part.
			$parts     = explode('<!--/nocompress-->', $output);
			$last_part = array_pop($parts);

			// Reset output.
			$output = '';

			// Marker used to identify <!--nocompress-->> tags.
			$i = 0;

			foreach ($parts as $part)
			{
				$start = strpos($part, '<!--nocompress');

				// Malformed? Add it as it is.
				if (false === $start)
				{
					$output .= $part;
					continue;
				}

				// Identify the nocompress tag and keep it.
				$name = "<nocompress csk-nocompress-tag-{$i}></nocompress>";
				$nocompress[$name] = substr($part, $start).'<!--/nocompress-->';
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

		// If we have <!--nocompress--> tags, add them.
		if ( ! empty($nocompress))
		{
			$output = str_replace(array_keys($nocompress), array_values($nocompress), $output);
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
	 * @link 	https://github.com/bkader
	 * @since 	1.4.1
	 *
	 * @access 	protected
	 * @param 	string 	$output 	The final output.
	 * @return 	string 	The final output after compression.
	 */
	protected function _compress_output($output)
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

	// ------------------------------------------------------------------------
	// Private methods.
	// ------------------------------------------------------------------------

	/**
	 * Loads all application dependencies.
	 * @access 	protected
	 * @param 	none
	 * @return 	void
	 */
	protected function _load_dependencies()
	{
		// URL helper.
		function_exists('base_url') OR $this->CI->load->helper('url');

		// Inflector helper.
		function_exists('plural') OR $this->CI->load->helper('inflector');

		// HTML helper.
		function_exists('html_tag') OR $this->CI->load->helper('html');

		// User Agent library.
		class_exists('CI_User_agent', false) OR $this->CI->load->library('user_agent');

		// Session library.
		class_exists('CI_Session', false) OR $this->CI->load->library('session');

		// Load language file.
		$this->CI->load->language('theme');

		// Load theme helper.
		function_exists('compress_html') OR $this->CI->load->helper('theme');
	}

	// ------------------------------------------------------------------------

	/**
	 * Wrapper for KB_Router::is_admin.
	 * @access 	public
	 * @param 	none
	 * @return 	bool 	true if in dashboard area, else false.
	 */
	protected function _is_admin()
	{
		/**
		 * We make sure the method remembers the status to reduce
		 * calling KB_Router each time we use it.
		 * @var boolean
		 */
		static $is_admin;
		is_null($is_admin) && $is_admin = $this->CI->router->is_admin();
		return $is_admin;
	}

	// ------------------------------------------------------------------------

	/**
	 * Set details about the user's browser.
	 * @access 	protected
	 * @param 	none
	 * @return 	array
	 */
	protected function _set_user_agent()
	{
		// We store details in session.
		if ( ! $this->CI->session->user_agent)
		{
			// Get the browser's nae.
			$user_agent['browser'] = $this->is_mobile
				? $this->CI->agent->mobile()
				: $this->CI->agent->browser();

			// Browser's version.
			$user_agent['version'] = $this->CI->agent->version();

			// Browser's accepted languages.
			$user_agent['languages'] = array_values(array_filter(
				$this->CI->agent->languages(),
				function($lang) {
					return strlen($lang) <= 3;
				}
			));

			// Client's used platform (Window, iOS, Unix...).
			$user_agent['platform'] = $this->CI->agent->platform();

			// Set the session now.
			$this->CI->session->set_userdata('user_agent', $user_agent);
		}

		return $this->CI->session->user_agent;
	}

	// ------------------------------------------------------------------------

	/**
	 * Returns array of default themes details.
	 * @access 	protected
	 * @param 	none
	 * @return 	array
	 */
	protected function _details()
	{
		static $details;

		if (is_null($details))
		{
			// Default theme details.
			$default = array(
				'name'         => null,
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
				'textdomain'   => null,
				'domainpath'   => null,
				'admin'        => false,
			);

			/**
			 * Allow users to filter default themes details.
			 * @since 	2.1.2
			 */
			$details = $this->apply_filters('themes_details', $default);

			// We fall-back to default details if empty.
			empty($details) && $details = $default;
		}

		return $details;
	}

	// ------------------------------------------------------------------------

	/**
	 * Makes sure the ".htaccess" file that denies direct access is present.
	 * @access 	protected
	 * @param 	string 	$path 	The path to check/create .htaccess.
	 * @return 	void
	 */
	protected function _check_htaccess($path)
	{
		if ($path == $this->theme_path()
			OR ! is_dir($path)
			OR ! is_writable($path)
			OR is_file($path.'.htaccess'))
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
		$_htaccess_file = fopen(normalize_path($path.'/.htaccess'), 'w');
		fwrite($_htaccess_file, $_htaccess_content);
		fclose($_htaccess_file);
	}

	// ------------------------------------------------------------------------
	// Filters and actions.
	// ------------------------------------------------------------------------

	/**
	 * Because this package can be used elsewhere, not only on Skeleton,
	 * we make sure to check if we are using the custom hooks system or not.
	 * If it is found, we use, otherwise, we see if the filter is a callable.
	 * @access 	protected
	 * @param 	string 	$filter 	The filter or the function to use instead.
	 * @param 	mixed 	$args 		Arguments on which we apply filters.
	 * @return 	mixed
	 */
	protected function apply_filters($filter, $args = null)
	{
		static $use_hooks, $cached_callbacks = array();
		
		is_null($use_hooks) && $use_hooks = function_exists('apply_filters');

		if (true === $use_hooks)
		{
			return apply_filters($filter, $args);
		}

		if ( ! isset($cached_callbacks[$filter]))
		{
			$cached_callbacks[$filter] = is_callable($filter);
		}

		$cached_callbacks[$filter] && $args = call_user_func($filter, $args);

		return $args;
	}

	// ------------------------------------------------------------------------

	/**
	 * Do actions if found.
	 * @access 	protected
	 * @param 	mixed 	$action 	THe action or callback.
	 * @return 	void
	 */
	protected function do_action($action)
	{
		static $use_hooks;
		
		is_null($use_hooks) && $use_hooks = function_exists('do_action');

		if (true === $use_hooks)
		{
			do_action($action);
			return;
		}

		is_callable($action) && call_user_func($action);
	}

}

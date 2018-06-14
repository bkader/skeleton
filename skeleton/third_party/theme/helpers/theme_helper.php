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
 * Theme Helper
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Packages\Helpers
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.1.3
 */

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
	 * @param   string  $protocol
	 * @return  string.
	 */
	function get_theme_url($uri = '', $protocol = null)
	{
		return get_instance()->theme->theme_url($uri, $protocol);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('theme_url'))
{
	/**
	 * Unlike the function above, this one echoes the URL.
	 * @param   string  $uri    string to be appended.
	 * @param   string  $protocol
	 */
	function theme_url($uri = '', $protocol = null)
	{
		echo get_instance()->theme->theme_url($uri, $protocol);
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
	 * @param   string  $protocol
	 * @return  string.
	 */
	function get_upload_url($uri = '', $protocol = null)
	{
		return get_instance()->theme->upload_url($uri, $protocol);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('upload_url'))
{
	/**
	 * Unlike the function above, this one echoes the URL.
	 * @param   string  $uri    string to be appended.
	 * @param   string  $protocol
	 */
	function upload_url($uri = '', $protocol = null)
	{
		echo get_instance()->theme->upload_url($uri, $protocol);
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
	 * @param   string  $protocol
	 * @return  string.
	 */
	function get_common_url($uri = '', $protocol = null)
	{
		return get_instance()->theme->common_url($uri, $protocol);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('common_url'))
{
	/**
	 * Unlike the function above, this one echoes the URL.
	 * @param   string  $uri    string to be appended.
	 * @param   string  $protocol
	 */
	function common_url($uri = '', $protocol = null)
	{
		echo get_instance()->theme->common_url($uri, $protocol);
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
	 * @param   string  $protocol
	 * @return 	string 	The full URL to the file.
	 */
	function assets_url($file = null, $common = false, $protocol = null)
	{
		// If a full link is passed, return it as it is.
		if (path_is_url($file))
		{
			return $file;
		}

		return ($common === true)
			? get_common_url($file, $protocol)
			: get_theme_url($file, $protocol);
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
		$html5shiv = '//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js';
		$respond   = '//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js';

		if ($remote === false)
		{
			$html5shiv = get_common_url('js/html5shiv-3.7.3.min.js', '');
			$respond   = get_common_url('js/respond-1.4.2.min.js', '');
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

if ( ! function_exists('compress_html'))
{
	/**
	 * compress_html
	 *
	 * Uses the Theme::compress_output method to compress the given string.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
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

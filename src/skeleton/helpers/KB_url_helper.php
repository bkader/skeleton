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
 * KB_url_helper
 *
 * Extending and overriding some of CodeIgniter url function.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Helpers
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * 
 * @since 		1.0.0
 * @since 		1.3.3 	Added both AJAX and API functions.
 * @since 		1.3.4 	Anchor are automatically translated if the title contains "lang:" at the beginning.
 * 
 * @version 	1.3.4
 */

if ( ! function_exists('anchor'))
{
	/**
	 * Anchor Link
	 *
	 * Creates an anchor based on the local URL.
	 *
	 * @param	string	the URL
	 * @param	string	the link title
	 * @param	mixed	any attributes
	 * @return	string
	 */
	function anchor($uri = '', $title = '', $attributes = '')
	{
		$title = (string) $title;

		$site_url = is_array($uri)
			? site_url($uri)
			: (preg_match('#^(\w+:)?//#i', $uri) ? $uri : site_url($uri));

		if ($title === '')
		{
			$title = $site_url;
		}
		elseif (1 === sscanf($title, 'lang:%s', $line))
		{
			$title = (function_exists('lang')) ? lang($line) : get_instance()->lang->line($line);
		}

		if ($attributes !== '')
		{
			$attributes = _stringify_attributes($attributes);
		}

		return '<a href="'.$site_url.'"'.$attributes.'>'.$title.'</a>';
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('anchor_popup'))
{
	/**
	 * Anchor Link - Pop-up version
	 *
	 * Creates an anchor based on the local URL. The link
	 * opens a new window based on the attributes specified.
	 *
	 * @param	string	the URL
	 * @param	string	the link title
	 * @param	mixed	any attributes
	 * @return	string
	 */
	function anchor_popup($uri = '', $title = '', $attributes = FALSE)
	{
		$title = (string) $title;
		$site_url = preg_match('#^(\w+:)?//#i', $uri) ? $uri : site_url($uri);

		if ($title === '')
		{
			$title = $site_url;
		}
		elseif (1 === sscanf($title, 'lang:%s', $line))
		{
			$title = (function_exists('lang')) ? lang($line) : get_instance()->lang->line($line);
		}

		if ($attributes === FALSE)
		{
			return '<a href="'.$site_url.'" onclick="window.open(\''.$site_url."', '_blank'); return false;\">".$title.'</a>';
		}

		if ( ! is_array($attributes))
		{
			$attributes = array($attributes);

			// Ref: http://www.w3schools.com/jsref/met_win_open.asp
			$window_name = '_blank';
		}
		elseif ( ! empty($attributes['window_name']))
		{
			$window_name = $attributes['window_name'];
			unset($attributes['window_name']);
		}
		else
		{
			$window_name = '_blank';
		}

		foreach (array('width' => '800', 'height' => '600', 'scrollbars' => 'yes', 'menubar' => 'no', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '0', 'screeny' => '0') as $key => $val)
		{
			$atts[$key] = isset($attributes[$key]) ? $attributes[$key] : $val;
			unset($attributes[$key]);
		}

		$attributes = _stringify_attributes($attributes);

		return '<a href="'.$site_url
			.'" onclick="window.open(\''.$site_url."', '".$window_name."', '"._stringify_attributes($atts, TRUE)."'); return false;\""
			.$attributes.'>'.$title.'</a>';
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('current_url'))
{
	/**
	 * Current URL
	 *
	 * Returns the full URL (including segments) of the page where this
	 * function is placed
	 *
	 * @return	string
	 */
	function current_url()
	{
		$CI =& get_instance();
		$current_url = $CI->config->site_url($CI->uri->uri_string());
		$params = $_SERVER['QUERY_STRING'];
		return (empty($params)) ? $current_url : $current_url.'?'.$params;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('trace_url'))
{
    /**
     * Adds a $_GET tracker to URL
     *
     * @param   string  $uri    uri to build
     * @param   string  $trk    click track position
     * @return  string
     */
    function trace_url($uri = '', $trk = '')
    {
    	$url = site_url($uri);

    	$key = get_instance()->config->item('trace_url_key');

    	if (empty($trk) OR empty($key))
    	{
    		return $url;
    	}

    	$url .= (isset(parse_url($url)['query']))
    		? "&amp;{$key}=".$trk
    		: "?{$key}=".$trk;
        return $url;
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('trace_anchor'))
{
    /**
     * Returns an anchor tag with optional track & attributes
     * @param   string  $uri            the URI to append
     * @param   string  $title          The title to use for our anchor
     * @param   string  $trk            the track argument to append to URL
     * @param   mixed   $attributes     string or array of attributes
     * @return  string  html anchor tag
     */
    function trace_anchor($uri = '', $title = '', $trk = '', $attributes = '')
    {
		$title = (string) $title;

		$site_url = is_array($uri)
			? trace_url($uri, $trk)
			: (preg_match('#^(\w+:)?//#i', $uri) ? $uri : trace_url($uri, $trk));

		if ($title === '')
		{
			$title = $site_url;
		}
		elseif (1 === sscanf($title, 'lang:%s', $line))
		{
			$title = (function_exists('lang')) ? lang($line) : get_instance()->lang->line($line);
		}

		if ($attributes !== '')
		{
			$attributes = _stringify_attributes($attributes);
		}

		return '<a href="'.$site_url.'"'.$attributes.'>'.$title.'</a>';
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('safe_url'))
{
	/**
	 * Safe URL
	 *
	 * Generate Safe URL with timestamp and a security token.
	 *
	 * @param   string
	 * @return  string
	 */
	function safe_url($uri = '')
	{
		// Make sure security helper is loaded
		if ( ! function_exists('generate_safe_token'))
		{
			get_instance()->load->helper('security');
		}

		$url    = site_url($uri);
		$params = parse_url($url);
		$query  = array();

		if (isset($params['query']))
		{
			parse_str($params['query'], $query);
		}

		$time           = time();
		$token['token'] = generate_safe_token($time);
		$token['ts']    = $time;
		$token          = array_merge($query, $token);
		$query          = http_build_query($token);

		$params['query'] = $query;
		return build_safe_url($params);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('safe_anchor'))
{
	/**
	 * Safe Anchor
	 *
	 * Generates a safe anchor using codeigniter built in
	 * 'anchor' function combined with our safe url builder.
	 *
	 * @param   string
	 * @param   string
	 * @param   mixed
	 * @retur   string
	 */
	function safe_anchor($uri = '', $title = '', $attrs = '')
	{
		$title = (string) $title;
		$safe_url = (preg_match('#^(\w+:)?//#i', $uri)) ? $uri : safe_url($uri);

		if ($title === '')
		{
			$title = $safe_url;
		}
		elseif (1 === sscanf($title, 'lang:%s', $line))
		{
			$title = (function_exists('lang')) ? lang($line) : get_instance()->lang->line($line);
		}

		($attrs !== '') && $attrs = _stringify_attributes($attrs);
		return '<a href="'.$safe_url.'"'.$attrs.'>'.$title.'</a>';
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('admin_url'))
{
	/**
	 * Admin URL
	 *
	 * Returns the full URL to admin sections of the site.
	 *
	 * @param 	string 	$uri
	 * @return 	string
	 */
	function admin_url($uri = '')
	{
		$uri = ($uri == '') ? 'admin' : 'admin/'.$uri;
		return site_url($uri);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('admin_anchor'))
{
	/**
	 * Admin Anchor
	 *
	 * Creates and anchor that links to an admin section.
	 *
	 * @param  string 	$uri 	the section to link to.
	 * @param  string 	$title 	the string to display.
	 * @param  string 	$attrs 	attribites to add to anchor.
	 * @return string
	 */
	function admin_anchor($uri = '', $title = '', $attrs = '')
	{
		$uri = ($uri == '') ? 'admin' : 'admin/'.$uri;
		return anchor($uri, $title, $attrs);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('safe_admin_url'))
{
	/**
	 * Safe Admin URL
	 *
	 * Generates a secured URL with prepended admin URI
	 *
	 * @param 	string 	$uri
	 * @return 	string
	 */
	function safe_admin_url($uri = '')
	{
		$uri = ($uri == '') ? 'admin' : 'admin/'.$uri;
		return safe_url($uri);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('safe_admin_anchor'))
{
	/**
	 * Safe Admin Anchor
	 *
	 * Generates a secured admin anchor.
	 *
	 * @param 	string 	$uri
	 * @param 	string 	$title
	 * @param 	string 	$attrs
	 * @return 	string
	 */
	function safe_admin_anchor($uri = '', $title = '', $attrs = '')
	{
		$uri = ($uri == '') ? 'admin' : 'admin/'.$uri;
		return safe_anchor($uri, $title, $attrs);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('process_url'))
{
	/**
	 * Process URL
	 *
	 * Returns the full URL to process sections of the site.
	 *
	 * @param 	string 	$uri
	 * @return 	string
	 */
	function process_url($uri = '')
	{
		$uri = ($uri == '') ? 'process' : 'process/'.$uri;
		return site_url($uri);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('process_anchor'))
{
	/**
	 * Process Anchor
	 *
	 * Creates and anchor that links to an process section.
	 *
	 * @param  string 	$uri 	the section to link to.
	 * @param  string 	$title 	the string to display.
	 * @param  string 	$attrs 	attribites to add to anchor.
	 * @return string
	 */
	function process_anchor($uri = '', $title = '', $attrs = '')
	{
		$uri = ($uri == '') ? 'process' : 'process/'.$uri;
		return anchor($uri, $title, $attrs);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('safe_process_url'))
{
	/**
	 * Safe Process URL
	 *
	 * Generates a secured URL with prepended process URI
	 *
	 * @param 	string 	$uri
	 * @return 	string
	 */
	function safe_process_url($uri = '')
	{
		$uri = ($uri == '') ? 'process' : 'process/'.$uri;
		return safe_url($uri);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('safe_process_anchor'))
{
	/**
	 * Safe Process Anchor
	 *
	 * Generates a secured process anchor.
	 *
	 * @param 	string 	$uri
	 * @param 	string 	$title
	 * @param 	string 	$attrs
	 * @return 	string
	 */
	function safe_process_anchor($uri = '', $title = '', $attrs = '')
	{
		$uri = ($uri == '') ? 'process' : 'process/'.$uri;
		return safe_anchor($uri, $title, $attrs);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('ajax_url'))
{
	/**
	 * AJAX URL
	 *
	 * Returns the full URL to ajax sections of the site.
	 *
	 * @param 	string 	$uri
	 * @return 	string
	 */
	function ajax_url($uri = '')
	{
		$uri = ($uri == '') ? 'ajax' : 'ajax/'.$uri;
		return site_url($uri);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('ajax_anchor'))
{
	/**
	 * AJAX Anchor
	 *
	 * Creates and anchor that links to an ajax section.
	 *
	 * @param  string 	$uri 	the section to link to.
	 * @param  string 	$title 	the string to display.
	 * @param  string 	$attrs 	attribites to add to anchor.
	 * @return string
	 */
	function ajax_anchor($uri = '', $title = '', $attrs = '')
	{
		$uri = ($uri == '') ? 'ajax' : 'ajax/'.$uri;
		return anchor($uri, $title, $attrs);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('safe_ajax_url'))
{
	/**
	 * Safe AJAX URL
	 *
	 * Generates a secured URL with prepended ajax URI
	 *
	 * @param 	string 	$uri
	 * @return 	string
	 */
	function safe_ajax_url($uri = '')
	{
		$uri = ($uri == '') ? 'ajax' : 'ajax/'.$uri;
		return safe_url($uri);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('safe_ajax_anchor'))
{
	/**
	 * Safe AJAX Anchor
	 *
	 * Generates a secured ajax anchor.
	 *
	 * @param 	string 	$uri
	 * @param 	string 	$title
	 * @param 	string 	$attrs
	 * @return 	string
	 */
	function safe_ajax_anchor($uri = '', $title = '', $attrs = '')
	{
		$uri = ($uri == '') ? 'ajax' : 'ajax/'.$uri;
		return safe_anchor($uri, $title, $attrs);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('api_url'))
{
	/**
	 * API URL
	 *
	 * Returns the full URL to api sections of the site.
	 *
	 * @param 	string 	$uri
	 * @return 	string
	 */
	function api_url($uri = '')
	{
		$uri = ($uri == '') ? 'api' : 'api/'.$uri;
		return site_url($uri);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('api_anchor'))
{
	/**
	 * API Anchor
	 *
	 * Creates and anchor that links to an api section.
	 *
	 * @param  string 	$uri 	the section to link to.
	 * @param  string 	$title 	the string to display.
	 * @param  string 	$attrs 	attribites to add to anchor.
	 * @return string
	 */
	function api_anchor($uri = '', $title = '', $attrs = '')
	{
		$uri = ($uri == '') ? 'api' : 'api/'.$uri;
		return anchor($uri, $title, $attrs);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('safe_api_url'))
{
	/**
	 * Safe API URL
	 *
	 * Generates a secured URL with prepended api URI
	 *
	 * @param 	string 	$uri
	 * @return 	string
	 */
	function safe_api_url($uri = '')
	{
		$uri = ($uri == '') ? 'api' : 'api/'.$uri;
		return safe_url($uri);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('safe_api_anchor'))
{
	/**
	 * Safe API Anchor
	 *
	 * Generates a secured api anchor.
	 *
	 * @param 	string 	$uri
	 * @param 	string 	$title
	 * @param 	string 	$attrs
	 * @return 	string
	 */
	function safe_api_anchor($uri = '', $title = '', $attrs = '')
	{
		$uri = ($uri == '') ? 'api' : 'api/'.$uri;
		return safe_anchor($uri, $title, $attrs);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('build_safe_url'))
{
	/**
	 * Build a safe URL
	 *
	 * @param   array
	 * @return  string
	 */
	function build_safe_url($args)
	{
		$string = isset($args['scheme']) ? "{$args['scheme']}://": '';
		$string .= isset($args['host']) ? "{$args['host']}": '';
		$string .= isset($args['port']) ? ":{$args['port']}": '';
		$string .= isset($args['path']) ? "{$args['path']}": '';
		$string .= isset($args['query']) ? "?{$args['query']}": '';
		return htmlentities($string, ENT_QUOTES, 'UTF-8');
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('check_safe_url'))
{
	/**
	 * Check Safe URL
	 *
	 * Checks a safe url
	 *
	 * @param   string
	 * @return  boolean
	 */
	function check_safe_url($url = null)
	{
		($url === null) && $url = current_url();
		// Make sure security helper is loaded
		if ( ! function_exists('generate_safe_token'))
		{
			get_instance()->load->helper('security');
		}

		$args = parse_url($url, PHP_URL_QUERY);
		parse_str($args);
		if (empty($ts) OR empty($token))
		{
			return false;
		}

		$_token = generate_safe_token($ts);
		return ($token === $_token);
	}
}

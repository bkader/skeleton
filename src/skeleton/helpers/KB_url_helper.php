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
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */

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

		if ($attributes !== '')
		{
			$attributes = _stringify_attributes($attributes);
		}

		return '<a href="'.$site_url.'"'.$attributes.'>'.$title.'</a>';
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
		($title === '') && $title = $safe_url;
		($attrs !== '') && $attrs = _stringify_attributes($attrs);
		return '<a href="'.$safe_url.'"'.$attrs.'>'.$title.'</a>';
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

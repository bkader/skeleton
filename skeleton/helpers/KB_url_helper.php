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
 * KB_url_helper
 *
 * Extending and overriding some of CodeIgniter url function.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Helpers
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.1.1
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
			$title = __($line);
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
			$title = __($line);
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
	 * @param 	bool 	$query_string 	Whether to add QUERY STRING.
	 * @return	string
	 */
	function current_url($query_string = true)
	{
		$CI =& get_instance();
		$url = $CI->config->site_url($CI->uri->uri_string());
		
		if ($query_string && ! empty($_SERVER['QUERY_STRING']))
		{
			$url .= '?'.$_SERVER['QUERY_STRING'];
		}

		return $url;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('previous_url'))
{
	/**
	 * Returns the last page the user visited.
	 *
	 * @param 	string 	$default 	Default value if no lat page exists.
	 * @param 	bool 	$uri_only 	Whether to return only the URI.
	 * @return 	bool
	 */
	function previous_url($default = null, $uri_only = false)
	{
		$prev_url = $default;

		if (isset($_SERVER['HTTP_REFERER']) 
			&& $_SERVER['HTTP_REFERER'] != current_url() 
			// We make sure the previous URL from the same site.
			&& false !== preg_match('#^'.site_url().'#', $prev_url))
		{
			$prev_url = $_SERVER['HTTP_REFERER'];
		}

		if ($prev_url)
		{
			$prev_url = (true === $uri_only)
				? str_replace(site_url(), '', $prev_url)
				: site_url($prev_url);
		}

		return $prev_url;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('uri_string'))
{
	/**
	 * URL String
	 *
	 * Overrides CodeIgniter default function in order to optionally
	 * include GET parameters.
	 *
	 * @since 	2.1.1
	 *
	 * @param 	bool 	$include_get 	Whether to include GET parameters.
	 * @return 	string
	 */
	function uri_string($include_get = false)
	{
		return get_instance()->uri->uri_string($include_get);
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
     * @param   string  $$protocol
     * @return  string
     */
    function trace_url($uri = '', $trk = '', $protocol = null)
    {
    	$url = site_url($uri, $protocol);

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
			$title = __($line);
		}

		if ($attributes !== '')
		{
			$attributes = _stringify_attributes($attributes);
		}

		return '<a href="'.$site_url.'"'.$attributes.'>'.$title.'</a>';
    }
}

// ------------------------------------------------------------------------

if ( ! function_exists('nonce_url'))
{
	/**
	 * nonce_url
	 *
	 * Function for generating site URLs with appended security nonce.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 *
	 * @since 	1.5.0
	 *
	 * @param 	string 	$uri 		The URI used to generate the URL.
	 * @param 	mixed 	$action 	Action to attach to the URL.
	 * @return 	string
	 */
	function nonce_url($uri = '', $action = -1)
	{
		$uri    = str_replace('&amp;', '&', $uri);
		$url    = site_url($uri);
		$params = parse_url($url);

		// Prepare URL query string then add the nonce token.
		$query  = array();
		(isset($params['query'])) && parse_str($params['query'], $query);
		$query['_csknonce'] = create_nonce($action);

		// Build the query then add it to params group.
		$query = http_build_query($query);
		$params['query'] = $query;

		// We build the final URL.
		$output = (isset($params['scheme'])) ? "{$params['scheme']}://": '';
		$output .= (isset($params['host'])) ? "{$params['host']}": '';
		$output .= (isset($params['port'])) ? ":{$params['port']}": '';
		$output .= (isset($params['path'])) ? "{$params['path']}": '';
		$output .= (isset($params['query'])) ? "?{$params['query']}": '';
		return htmlentities($output, ENT_QUOTES, 'UTF-8');
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('safe_url'))
{
	/**
	 * Function for generating site URLs with appended security nonce.
	 * @deprecated 1.5.0 	Kept for backward compatibility.
	 * @return 	string
	 */
	function safe_url($uri = '', $action = -1)
	{
		return nonce_url($uri, $action);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('nonce_anchor'))
{
	/**
	 * nonce_anchor
	 *
	 * Function for generating anchor using CodeIgniter built-in anchor
	 * function but using our custom "nonce_url" function generate a full
	 * URL with security nonce.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 *
	 *  @since 	1.0.0
	 *  @since 	1.4.0 	Rewritten because the "nonce_url" was rewritten as well.
	 *
	 * @param 	string 	$uri 	The URI used to generate the URL.
	 * @param 	string 	$action The action to attach to the URL.
	 * @param 	string 	$title 	The anchor text.
	 * @param 	mixed 	$attrs 	Links attributes.
	 * @return 	string 	The full anchor tag.
	 */
	function nonce_anchor($uri = '', $action = -1, $title = '', $attrs = '')
	{
		// Prepare the URL first.
		$url = nonce_url($uri, $action);

		// Format the title an see if it should be translated.
		$title = (string) $title;
		if ($title === '')
		{
			$title = $url;
		}
		elseif (1 === sscanf($title, 'lang:%s', $line))
		{
			$title = __($line);
		}

		$attrs = (is_array($attrs)) ? _stringify_attributes($attrs) : ' '.$attrs;

		return '<a href="'.$url.'"'.$attrs.'>'.$title.'</a>';
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('safe_anchor'))
{
	/**
	 * Function for generating anchor using CodeIgniter built-in anchor
	 * function but using our custom "safe_url" function generate a full
	 * URL with security nonce.
	 * @deprecated 	1.5.0 	Kept for backward compatibility.
	 * @return 	string 	The full anchor tag.
	 */
	function safe_anchor($uri = '', $action = -1, $title = '', $attrs = '')
	{
		return nonce_anchor($uri, $action, $title, $attrs);
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
	 * @param 	string 	$protocol
	 * @return 	string
	 */
	function admin_url($uri = '', $protocol = null)
	{
		if ('' === $uri)
		{
			return site_url(KB_ADMIN, $protocol);
		}

		$CI =& get_instance();

		$exp = explode('/', $uri);

		if (count($exp) === 1)
		{
			list($module, $method, $controller) = array_pad($exp, 3, null);

			if ( ! empty($contexts = $CI->router->module_contexts(strtok($module, '?'))))
			{
				foreach ($contexts as $context => $status)
				{
					if ('admin' !== $context && true === $status)
					{
						$uri = $context.'/'.ltrim(str_replace($context, '', $uri), '/');
						break;
					}
				}
			}
		}

		return site_url(KB_ADMIN.'/'.$uri, $protocol);
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
		if ('' === $uri)
		{
			return anchor(KB_ADMIN, $title, $attrs);
		}

		$CI =& get_instance();

		$exp = explode('/', $uri);

		if (count($exp) === 1)
		{
			list($module, $method, $controller) = array_pad($exp, 3, null);

			if ( ! empty($contexts = $CI->router->module_contexts(strtok($module, '?'))))
			{
				foreach ($contexts as $context => $status)
				{
					if ('admin' !== $context && true === $status)
					{
						$uri = $context.'/'.ltrim(str_replace($context, '', $uri), '/');
						break;
					}
				}
			}
		}

		return anchor(KB_ADMIN.'/'.$uri, $title, $attrs);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('nonce_admin_url'))
{
	/**
	 * nonce_admin_url
	 *
	 * Function for creating nonce URLs for the dashboard area.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * 
	 * @since 	1.5.0
	 * @since 	2.0.1 	Added automatic context guess.
	 *
	 * @param 	string 	$uri 	The URI used to generate the URL.
	 * @return 	string 	$action The action to attach to the URL.
	 */
	function nonce_admin_url($uri = '', $action = -1)
	{
		if ('' === $uri)
		{
			return nonce_url(KB_ADMIN, $action);
		}

		$CI =& get_instance();

		$exp = explode('/', $uri);

		if (count($exp) === 1)
		{
			list($module, $method, $controller) = array_pad($exp, 3, null);

			if ( ! empty($contexts = $CI->router->module_contexts(strtok($module, '?'))))
			{
				foreach ($contexts as $context => $status)
				{
					if ('admin' !== $context && true === $status)
					{
						$uri = $context.'/'.ltrim(str_replace($context, '', $uri), '/');
						break;
					}
				}
			}
		}

		return nonce_url(KB_ADMIN.'/'.$uri, $action);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('safe_admin_url'))
{
	/**
	 * Function for creating safe URLs for the dashboard area.
	 * @deprecated 	1.5.0 	Kept for backward compatibility.
	 * @return 	string 	$action The action to attach to the URL.
	 */
	function safe_admin_url($uri = '', $action = -1)
	{
		return nonce_admin_url($uri, $action);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('nonce_admin_anchor'))
{
	/**
	 * nonce_admin_anchor
	 *
	 * Function for creating secured anchor tags for the dashboard area.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * 
	 * @since 	1.5.0
	 * @since 	2.0.1 	Added automatic context guess.
	 *
	 * @param 	string 	$uri 	The URI used to generate the URL.
	 * @param 	mixed 	$action The action attached to the URL.
	 * @param 	string 	$title 	The anchor text.
	 * @param 	mixed 	$attrs 	Anchor html attributes.
	 * @return 	string
	 */
	function nonce_admin_anchor($uri = '', $action = -1, $title = '', $attrs = '')
	{
		if ('' === $uri)
		{
			return nonce_anchor(KB_ADMIN, $action, $title, $attrs);
		}

		$CI =& get_instance();

		$exp = explode('/', $uri);

		if (count($exp) === 1)
		{
			list($module, $method, $controller) = array_pad($exp, 3, null);

			if ( ! empty($contexts = $CI->router->module_contexts(strtok($module, '?'))))
			{
				foreach ($contexts as $context => $status)
				{
					if ('admin' !== $context && true === $status)
					{
						$uri = $context.'/'.ltrim(str_replace($context, '', $uri), '/');
						break;
					}
				}
			}
		}

		return nonce_anchor(KB_ADMIN.'/'.$uri, $action, $title, $attrs);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('safe_admin_anchor'))
{
	/**
	 * Function for creating secured anchor tags for the dashboard area.
	 * @deprecated 	1.5.0 	Kept for backward compatibility.
	 * @return 	string
	 */
	function safe_admin_anchor($uri = '', $action = -1, $title = '', $attrs = '')
	{
		return nonce_admin_anchor($uri, $action, $title, $attrs);
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
	 * @param 	string 	$protocol
	 * @return 	string
	 */
	function process_url($uri = '', $protocol = null)
	{
		$uri = ($uri == '') ? 'process' : 'process/'.$uri;
		return site_url($uri, $protocol);
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

if ( ! function_exists('nonce_process_url'))
{
	/**
	 * nonce_process_url
	 *
	 * Function for creating nonce URLs for the process context.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * 
	 * @since 	1.5.0
	 *
	 * @param 	string 	$uri 	The URI used to generate the URL
	 * @param 	mixed 	$action The action to attach to the URL.
	 * @return 	string
	 */
	function nonce_process_url($uri = '', $action = -1)
	{
		$uri = ($uri == '') ? 'process' : 'process/'.$uri;
		return nonce_url($uri, $action);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('safe_process_url'))
{
	/**
	 * Function for creating safe URLs for the process context.
	 * @deprecated 	1.5.0 	Kept for backward compatibility.
	 * @return 	string
	 */
	function safe_process_url($uri = '', $action = -1)
	{
		return nonce_process_url($uri, $action);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('nonce_process_anchor'))
{
	/**
	 * nonce_process_anchor
	 *
	 * Function for create nonce process anchor.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * 
	 * @since 	1.5.0
	 *
	 * @param 	string 	$uri 	The URI used to generate the URL.
	 * @param 	mixed 	$action The action to attach to the URL.
	 * @param 	string 	$title 	The anchor text.
	 * @param 	mixed 	$attrs 	The anchor attributes.
	 * @return 	string
	 */
	function nonce_process_anchor($uri = '', $action = -1, $title = '', $attrs = '')
	{
		$uri = ($uri == '') ? 'process' : 'process/'.$uri;
		return nonce_anchor($uri, $action, $title, $attrs);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('safe_process_anchor'))
{
	/**
	 * Function for create safe process anchor.
	 * @deprecated 	1.5.0 	Kept for backward compatibility.
	 * @return 	string
	 */
	function safe_process_anchor($uri = '', $action = -1, $title = '', $attrs = '')
	{
		return nonce_process_anchor($uri, $action, $title, $attrs);
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
	 * @param 	string 	$protocol
	 * @return 	string
	 */
	function ajax_url($uri = '', $protocol = null)
	{
		$uri = ($uri == '') ? 'ajax' : 'ajax/'.$uri;
		return site_url($uri, $protocol);
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

if ( ! function_exists('nonce_ajax_url'))
{
	/**
	 * nonce_ajax_anchor
	 *
	 * Function for creating nonce URLs for Ajax context.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * 
	 * @since 	1.5.0
	 *
	 * @param 	string 	$uri 	The URI used to generate the URL.
	 * @param 	mixed 	$action The action to attach to the URL.
	 * @return 	string
	 */
	function nonce_ajax_url($uri = '', $action = -1)
	{
		$uri = ($uri == '') ? 'ajax' : 'ajax/'.$uri;
		return nonce_url($uri, $action);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('safe_ajax_url'))
{
	/**
	 * Function for creating safe URLs for Ajax context.
	 * @deprecated 	1.5.0 	Kept for backward compatibility.
	 * @return 	string
	 */
	function safe_ajax_url($uri = '', $action = -1)
	{
		return nonce_ajax_url($uri, $action);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('nonce_ajax_anchor'))
{
	/**
	 * nonce_ajax_anchor
	 *
	 * Function for creating nonce anchors for the AJAX context.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * 
	 * @since 	1.5.0
	 *
	 * @param 	string 	$uri 	The URI used to generate the URL.
	 * @param 	mixed 	$action The action to attach to the URL.
	 * @param 	string 	$title 	The anchor text.
	 * @param 	mixed 	$attrs 	The anchor attributes.
	 * @return 	string
	 */
	function nonce_ajax_anchor($uri = '', $action = -1, $title = '', $attrs = '')
	{
		$uri = ($uri == '') ? 'ajax' : 'ajax/'.$uri;
		return nonce_anchor($uri, $action, $title, $attrs);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('safe_ajax_anchor'))
{
	/**
	 * Function for creating safe anchors for the AJAX context.
	 * @deprecated 	1.5.0 	Kept for backward compatibility.
	 * @return 	string
	 */
	function safe_ajax_anchor($uri = '', $action = -1, $title = '', $attrs = '')
	{
		return nonce_ajax_anchor($uri, $action, $title, $attrs);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('check_nonce_url'))
{
	/**
	 * check_nonce_url
	 *
	 * Function for checking the selected URL noncety.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * 
	 * @since 	1.5.0
	 *
	 * @param 	string 	$action
	 * @param 	string 	$url
	 * @return 	bool
	 */
	function check_nonce_url($action = -1, $url = null)
	{
		// If no URL provided, we use the current one, then format it.
		(null === $url) && $url = current_url();
		$url = str_replace('&amp;', '&', $url);

		$args = parse_url($url, PHP_URL_QUERY);
		parse_str($args, $query);

		if ( ! isset($query['_csknonce']))
		{
			return false;
		}

		return verify_nonce($query['_csknonce'], $action);
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('check_safe_url'))
{
	/**
	 * Function for checking the selected URL safety.
	 * @deprecated 	1.5.0 	Kept for backward compatibility.
	 * @return 	bool
	 */
	function check_safe_url($action = -1, $url = null)
	{
		return check_nonce_url($url, $action);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('module_url'))
{
	/**
	 * modules_url
	 *
	 * Returns the URL to the public modules folder.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.5.0
	 *
	 * @param 	string
	 * @return 	string
	 */
	function modules_url($uri = '')
	{
		return base_url('content/modules/'.$uri);
	}
}

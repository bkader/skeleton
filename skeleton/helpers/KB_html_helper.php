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
 * @since 		Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * KB_html_helper
 *
 * Extending and overriding some of CodeIgniter html function.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Helpers
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */

if ( ! function_exists('img'))
{
	/**
	 * We simply inverted $attributes and $index_page
	 *
	 * Generates an <img /> element
	 *
	 * @param	mixed
	 * @param	mixed
	 * @param	bool
	 * @return	string
	 */
	function img($src = '', $attributes = '', $index_page = false)
	{
		if ( ! is_array($src) )
		{
			$src = array('src' => $src);
		}

		// If there is no alt attribute defined, set it to an empty string
		if ( ! isset($src['alt']))
		{
			$src['alt'] = '';
		}

		$img = '<img';

		foreach ($src as $k => $v)
		{
			if ($k === 'src' && ! preg_match('#^(data:[a-z,;])|(([a-z]+:)?(?<!data:)//)#i', $v))
			{
				if ($index_page === true)
				{
					$img .= ' src="'.get_instance()->config->site_url($v).'"';
				}
				else
				{
					$img .= ' src="'.get_instance()->config->slash_item('base_url').$v.'"';
				}
			}
			else
			{
				$img .= ' '.$k.'="'.$v.'"';
			}
		}

		return $img._stringify_attributes($attributes).' />';
	}
}

// ------------------------------------------------------------------------

/**
 * Create a XHTML tag
 *
 * @param	string			The tag name
 * @param	array|string	The tag attributes
 * @param	string|bool		The content to place in the tag, or false for no closing tag
 * @return	string
 */
if ( ! function_exists('html_tag'))
{
	function html_tag($tag, $attr = array(), $content = false)
	{
		if (empty($tag))
		{
			return $content;
		}

		// list of void elements (tags that can not have content)
		static $void_elements = array(
			// html4
			"area","base","br","col","hr","img","input","link","meta","param",
			// html5
			"command","embed","keygen","source","track","wbr",
			// html5.1
			"menuitem",
		);

		/**
		 * Add a custom tag so we can define language direction.
		 * @since	 2.0.0
		 */
		if ('login' !== get_instance()->router->fetch_class() 
			&& 'rtl' === get_instance()->lang->lang('direction') 
			&& ('input' === $tag OR ! in_array($tag, $void_elements)))
		{
			if (is_array($attr) && ! isset($attr['dir']))
			{
				$attr['dir'] = 'rtl';
			}
			elseif (is_string($attr) && false === stripos($attr, 'dir="'))
			{
				$attr .= ' dir="rtl"';
			}
		}

		// construct the HTML
		$html = '<'.$tag;
		$html .= ( ! empty($attr)) ? (is_array($attr) ? _stringify_attributes($attr) : ' '.$attr) : '';

		// a void element?
		if (in_array(strtolower($tag), $void_elements))
		{
			// these can not have content
			$html .= ' />';
		}
		else
		{
			// add the content and close the tag
			$html .= '>'.$content.'</'.$tag.'>';
		}

		return $html;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('build_list'))
{
	function build_list($type = 'ul', array $list = array(), $attr = array(), $indent = '')
	{
		if ( ! is_array($list))
		{
			$result = false;
		}

		$output = '';

		foreach ($list as $key => $value)
		{
			if ( ! is_array($value))
			{
				$output .= $indent."\t".html_tag('li', null, $value).PHP_EOL;
			}
			else
			{
				$output .= $indent."\t".html_tag('li', null, build_list($type, $value, null, $indent."\t\t")).PHP_EOL;
			}
		}

		$result = $indent.html_tag($type, $attr, PHP_EOL.$output.$indent).PHP_EOL;
		return $result;
	}
}

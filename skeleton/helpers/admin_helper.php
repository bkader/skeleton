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
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('label_condition'))
{
	/**
	 * This is a dummy function used to display Boostrap labels
	 * depending on a given condition.
	 *
	 * @since 	1.0.0
	 * @since 	1.3.3 	Fixed issue with translation.
	 *
	 * @param 	bool 	$cond 	The conditions result.
	 * @param 	string 	$true 	String to output if true.
	 * @param 	string 	$false 	String to output if false.
	 * @return 	string
	 */
	function label_condition($cond, $true = 'lang:CSK_ADMIN_YES', $false = 'lang:CSK_ADMIN_NO')
	{
		// Prepare the empty label.
		$label = '<span class="badge badge-%s">%s</span>';

		// Should strings be translated?
		if (sscanf($true, 'lang:%s', $true_line) === 1)
		{
			$true = lang($true_line);
		}
		if (sscanf($false, 'lang:%s', $false_line) === 1)
		{
			$false = lang($false_line);
		}

		return ($cond === true)
			? sprintf($label, 'success', $true)
			: sprintf($label, 'danger', $false);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('fa_icon'))
{
	/**
	 * fa_icon
	 *
	 * Function for generating FontAwesome icons.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	function fa_icon($class = '')
	{
		return "<i class=\"fa fa-fw fa-{$class}\"></i>";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('bs_button'))
{
	/**
	 * bs_button
	 *
	 * Function for generating a Bootstrap 4 button.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	string 	$title 	The text to display within the button.
	 * @param 	string 	$type 	The type of button.
	 * @param 	string 	$href 	URL in case of using an anchor.
	 * @param 	string 	$icon 	Whether to add an icon.
	 * @param 	mixed 	$attrs 	Array of extra attributes.
	 * @return 	string
	 */
	function bs_button(
		$title,
		$type = 'default', 	// You can add sizes classes: "default btn-sm"
		$href = null,
		$icon = null, 		// Check font-awesome icons.
		$attrs = array())
	{
		// No title provided? Nothing to do...
		if (empty($title))
		{
			return null;
		}

		// Always add the button role attribute.
		$attributes['role'] = 'button';

		// In case of an anchor.
		if (null !== $href)
		{
			$tag = 'a';
			$attributes['href'] = $href;
		}
		// In case of a button.
		else
		{
			$tag = 'button';
			$attributes['type'] = 'button';
		}

		$attributes['class'] = "btn btn-{$type}";

		if (null !== $icon)
		{
			$attributes['class'] .= ' btn-icon';
			$title = fa_icon($icon).$title;
		}

		empty($attrs) OR $attributes = arra_merge($attributes, $attrs);

		return html_tag($tag, $attributes, $title);
	}
}

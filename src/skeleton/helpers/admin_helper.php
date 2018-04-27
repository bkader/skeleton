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
	function label_condition($cond, $true = 'lang:yes', $false = 'lang:no')
	{
		// Prepare the empty label.
		$label = '<span class="label label-%s">%s</span>';

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
	 * @link 	https://github.com/bkader
	 * @since 	1.4.0
	 *
	 * @access 	public
	 * @param 	none
	 * @return 	void
	 */
	function fa_icon($class = '')
	{
		return "<i class=\"fa fa-{$class}\"></i>";
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('module_menu'))
{
	/**
	 * module_menu
	 *
	 * Function for generating an admin menu link for the selected module.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://github.com/bkader
	 * @since 	1.4.0
	 *
	 * @param 	mixed 	$module 	The module's name or array.
	 * @param 	bool 	$echo 		Whether to echo the output.
	 * @return 	string
	 */
	function module_menu($module, $echo = true)
	{
		// We make sure we have the module's details array.
		if ( ! is_array($module))
		{
			$module = get_instance()->router->module_details($module);
			if ( ! is_array($module))
			{
				return '';
			}
		}
		
		// Start the output.
		$output = '<li';

		// Add the "active" class if needed.
		if (strpos(uri_string(), $module['folder']) !== false)
		{
			$output .= ' class="active"';
		}

		// Close the opening tag.
		$output .= '>';

		// Get the current language to see if we need to translate things.
		$lang = config_item('language');

		// Shall we translate the link text?
		$p_title = (isset($module['translations']['admin_menu'][$lang]))
			? $module['translations']['admin_menu'][$lang]
			: $module['admin_menu'];

		// Add the admin anchor.
		$output .= admin_anchor($module['folder'], $p_title);

		// Does it have a sub-elements?
		if (isset($module['submenu']))
		{
			// The list opening tag.
			$output .= '<ul class="submenu">';

			// Loop through items and display them.
			foreach ($module['submenu'] as $uri => $c_title)
			{
				// Do we need to translate the title?
				$c_title = (isset($module['translations'][$uri][$lang]))
					? $module['translations'][$uri][$lang]
					: $c_title;

				// Add the anchor.
				$output .= '<li>'.admin_anchor($module['folder'].'/'.$uri, $c_title).'</li>';
			}

			// Close the child menu item.
			$output .= '</ul>';
		}

		// The menu link closing tag.
		$output .= '</li>';

		// Return instead of echo?
		if (true !== $echo)
		{
			return $output;
		}

		echo $output;
	}
}

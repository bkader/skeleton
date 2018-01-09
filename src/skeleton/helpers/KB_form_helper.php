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
 * KB_form_helper
 *
 * Extending and overriding some of CodeIgniter form function.
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

if ( ! function_exists('print_input'))
{
	/**
	 * Prints a form input with possibility to add extra
	 * attributes instead of using array_merge on views.
	 * @param 	array 	$input 	form input details.
	 * @param 	array 	$attrs 	additional attributes.
	 * @return 	string 	the full form input string.
	 */
	function print_input($input = array(), array $attrs = array())
	{
		// If $input is empty, nothing to do.
		if ( ! is_array($input) OR empty($input))
		{
			return '';
		}

		// Merge all attributes if there any.
		if ( !empty($attrs))
		{
			$input = array_merge($input, $attrs);
		}

		if (isset($input['type']))
		{
			switch ($input['type'])
			{

				case 'password':
					unset($input['type']);
					return form_password($input);
					break;

				case 'textarea':
					unset($input['type']);
					return form_textarea($input);
					break;

				case 'select':
				case 'dropdown':
					$name = $input['name'];
					$options = $input['options'];
					unset($input['name'], $input['options']);
					if (isset($input['selected']))
					{
						$selected = $input['selected'];
						unset($input['selected']);
					}
					else
					{
						$selected = array();
					}
					return form_dropdown($name, $options, $selected, $input);
					break;

				default:
					return form_input($input);
					break;
			}
		}

		// Fallback to form input.
		return form_input($input);
	}
}

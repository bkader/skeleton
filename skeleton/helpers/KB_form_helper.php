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
 * KB_form_helper
 *
 * Extending and overriding some of CodeIgniter form function.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Helpers
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.1.3
 */

if ( ! function_exists('form_nonce'))
{
	/**
	 * form_nonce
	 *
	 * Function for creating hidden nonce fields for form.
	 *
	 * The once field is used to make sure that the contents of the form came
	 * from the location on the current site and not from somewhere else. This
	 * is not an absolute protection option, but bu should protect against most
	 * cases. Make sure to always use it for forms you want to protect.
	 *
	 * Both $action and $name are optional, but it is highly recommended that
	 * you provide them. Anyone who inspects your code (PHP) would simply guess
	 * what should be used to cause damage. So please, provide them.
	 *
	 * Make sure to always check again your fields values after submission before
	 * your process.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @param 	string 	$action 	The action used to generate nonce.
	 * @param 	string 	$name 		The name of the nonce field.
	 * @param 	bool 	$referrer 	Whether to add the referrer field.
	 * @return 	string
	 */
	function form_nonce($action = -1, $name = '_csknonce', $referrer = true)
	{
		empty($name) && $name = '_csknonce';

		$output = '<input type="hidden" id="'.$name.'" name="'.$name.'" value="'.html_escape(create_nonce($action)).'" />';

		(true === $referrer) && $output .= form_referrer();

		return $output;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('form_referrer'))
{
	/**
	 * form_referrer
	 *
	 * Function for creating HTTP referrer hidden field for forms.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 * @since 	2.0.0 	Remove GET parameters from URI.
	 *
	 * @param 	string 	$name 	Optional field name.
	 * @return 	string
	 */
	function form_referrer($name = '_csk_http_referrer')
	{
		empty($name) && $name = '_csk_http_referrer';
		$uri = strtok($_SERVER['REQUEST_URI'], '?');
		return form_hidden($name, $uri);
	}
}

// ------------------------------------------------------------------------

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
		if ( ! empty($attrs))
		{
			foreach ($attrs as $key => $val)
			{
				if (is_int($key))
				{
					$input[$val] = $val;
					continue;
				}

				/**
				 * We make sure to concatenate CSS classes.
				 * @since 	2.1.3
				 */
				if ('class' === $key && isset($input['class']))
				{
					$input['class'] = trim($input['class'].' '.$val);
					continue;
				}

				$input[$key] = $val;
			}
		}

		// Array of attributes not to transfigure.
		$_ignored = array(
			'autocomplete', 'autofocus',
			'disabled',
			'form', 'formaction', 'formenctype', 'formmethod', 'formtarget',
			'list',
			'multiple',
			'readonly', 'rel', 'required',
			'step',
		);
		array_walk($input, function(&$val, $key) use ($_ignored) {
			(in_array($key, $_ignored)) OR $val = _transfigure($val);
		});

		/**
		 * Here we loop through all input elements only if it's found,
		 * otherwise, it will simply fall back to "form_input".
		 */
		if (isset($input['type']))
		{
			switch ($input['type'])
			{
				// In case of a textarea.
				case 'textarea':
					unset($input['type']);
					return form_textarea($input);
					break;

				// In case of a dropdwn/select.
				case 'select':
				case 'dropdown':
					$name = $input['name'];
					$options = array_map('_translate', $input['options']);
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

				// Default one.
				default:
					return form_input($input);
					break;
			}
		}

		// Fall-back to form input.
		return form_input($input);
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('validation_errors_list'))
{
	/**
	 * Return form validation errors in custom HTML list.
	 * Default: unordered list.
	 * @access 	public
	 * @return 	string 	if found, else empty string.
	 */
	function validation_errors_list()
	{
		return (FALSE === ($OBJ =& _get_validation_object()))
			? ''
			: $OBJ->validation_errors_list();
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_translate'))
{
	/**
	 * _translate
	 *
	 * Function for translating the selected string if it contains the
	 * "lang:" keyword at the beginning.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.0.0
	 *
	 * @param 	string 	$string
	 * @return 	string
	 */
	function _translate($string)
	{
		return (is_string($string) && sscanf($string, 'lang:%s', $line) === 1) ? __($line) : $string;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_configure'))
{
	/**
	 * _configure
	 *
	 * Function for getting the config value of the selected string if 
	 * it contains the "config:" keyword at the beginning.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @param 	string 	$string 	The string to run test on.
	 * @return 	string
	 */
	function _configure($string)
	{
		return (is_string($string) && sscanf($string, 'config:%s', $config) === 1) 
			? get_option($config, $string)
			: $string;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_transfigure'))
{
	/**
	 * _transfigure
	 *
	 * This function's name doesn't really mean the verb "transfigure", yet,
	 * it does transfigure the string. It checks if the string contains the
	 * "config:" keywords first, then the "lang:" if the first one was not
	 * found. In fact, it does both "_translate" and "_configure" functions.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @param 	string 	$string 	The string to run test on.
	 * @return 	string
	 */
	function _transfigure($string)
	{
		if (is_string($string) && sscanf($string, 'config:%s', $config) === 1)
		{
			$string = get_option($config, $string);
		}
		elseif (is_string($string) && sscanf($string, 'lang:%s', $lang) === 1)
		{
			$string = __($lang);
		}

		return $string;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('has_error'))
{
	/**
	 * has_error
	 *
	 * Function for checking whether the selected field has any errors.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	1.4.0
	 *
	 * @access 	public
	 * @param 	string 	$field 	The field's name to check.
	 * @return 	bool 	true if there are error, else false.
	 */
	function has_error($field = NULL)
	{
		return ( ! empty(form_error($field)));
	}
}

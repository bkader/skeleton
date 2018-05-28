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
	function label_condition($cond, $true = 'lang:CSK_YES', $false = 'lang:CSK_NO')
	{
		// Prepare the empty label.
		$label = '<span class="badge badge-%s">%s</span>';

		// Should strings be translated?
		if (sscanf($true, 'lang:%s', $true_line) === 1)
		{
			$true = __($true_line);
		}
		if (sscanf($false, 'lang:%s', $false_line) === 1)
		{
			$false = __($false_line);
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

if ( ! function_exists('submit_button'))
{
	/**
	 * submit_button
	 *
	 * Function display a submit button.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	string 	$text
	 * @param 	mixed 	$type
	 * @param 	string 	$name
	 * @param 	bool 	$wrap
	 * @param 	array 	$attrs
	 * @return 	string
	 */
	function submit_button($text = '', $type = 'primary btn-sm', $name = 'submit', $wrap = true, $attrs = '')
	{
		// Make sure to explode types if string.
		is_array($type) OR $type = explode(' ', $type);

		// Array of Skeleton available button.
		$types = _dashboard_buttons();

		$classes = array('btn');
		foreach ($type as $t) {
			if (('secondary' === $t OR 'btn-secondary' === $t)
				OR ('default' === $t OR 'btn-default' === $t)) {
				continue;
			}

			$classes[] = in_array($t, $types) ? 'btn-'.$t : $t;
		}

		if (function_exists('array_clean')) {
			$classes = array_clean($classes);
		} else {
			$classes = array_unique(array_filter(array_map('trim', $classes)));
		}

		// See if we provide a size.
		if (false !== ($i = array_search('tiny', $classes))) {
			$classes[$i] = 'btn-xs';
		} elseif (false !== ($i = array_search('small', $classes))) {
			$classes[$i] = 'btn-sm';
		} elseif (false !== ($i = array_search('large', $classes))) {
			$classes[$i] = 'btn-lg';
		}

		// Shall we use an icon?
		$icon = null;
		foreach ($classes as $k => $v) {
			if (1 === sscanf($v, 'icon:%s', $i)) {
				$icon = fa_icon($i);
				$classes[$k] = 'btn-icon';
				break;
			}
		}

		// Possibility to disable to wrap.
		if (false !== ($w = array_search('nowrap', $classes))) {
			$wrap = false;
			unset($classes[$w]);
		}

		// Add the default submit button.
		$attributes['type'] = 'submit';

		// Prepare button class.
		$attributes['class'] = implode(' ', $classes);

		/**
		 * Prepare text to be used.
		 * 1. If nothing provided, we use default "Save Changes".
		 * 2. If it starts with "lang:", we try to translate it.
		 * 3. If it starts with "config:" we try to get config item.
		 */
		if (empty($text)) { // Use default "Save Changes"
			$text = __('CSK_BTN_SAVE_CHANGES');
		} elseif (1 === sscanf($text, 'lang:%s', $line)) {
			$text = __($line);
		} elseif (1 === sscanf($text, 'config:%s', $item)) {
			$text = config_item($item);

			// In case the item was not found, we use default text.
			$text OR $text = __('CSK_BTN_SAVE_CHANGES');
		}

		empty($icon) OR $text = $icon.$text;

		// Use the $name as the default id unless provided in $attrs.
		$attributes['name'] = $name;
		$attributes['id']   = $name;
		if (is_array($attrs) && isset($attrs['id'])) {
			$attributes['id'] = $attrs['id'];
			unset($attrs['id']);
		}

		if (is_array($attrs) && ! empty($attrs)) {
			$attributes = array_merge($attributes, $attrs);
		}

		if (null === $icon) {
			$tag                = 'input';
			$attributes['type'] = 'submit';
			$attributes['value'] = $text;
		} else {
			$tag = 'button';
		}

		function_exists('html_tag') OR get_instance()->load->helper('html');

		$button = html_tag($tag, $attributes, $text);

		$output = $wrap ? '<div class="form-group">'.$button.'</div>' : $button;

		return $output;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('_dashboard_buttons'))
{
	/**
	 * _dashboard_buttons
	 *
	 * Function for returning an array of dashboard available buttons colors.
	 *
	 * @author 	Kader Bouyakoub
	 * @link 	https://goo.gl/wGXHO9
	 * @since 	2.0.0
	 *
	 * @param 	none
	 * @return 	array
	 */
	function _dashboard_buttons()
	{
		static $dashboard_buttons = null;

		if (null === $dashboard_buttons)
		{
			$dashboard_buttons = array(
				'add', 'apply',
				'black', 'blue', 'brown',
				'create',
				'danger', 'default', 'delete', 'donate',
				'green', 'grey',
				'info',
				'new',
				'olive', 'orange',
				'pink', 'primary', 'purple',
				'red', 'remove',
				'save', 'secondary', 'submit', 'success',
				'teal',
				'update',
				'violet',
				'warning', 'white',
				'yellow',
			);
		}

		return $dashboard_buttons;
	}
}

// ------------------------------------------------------------------------

if ( ! function_exists('info_box'))
{
	/**
	 * Generates an info box
	 *
	 * @since 	2.0.1
	 *
	 * @param 	string 	$head
	 * @param 	string 	$text
	 * @param 	string 	$icon
	 * @param 	string 	$url
	 * @param 	string 	$color
	 * @return 	string
	 */
	function info_box($head = null, $text = null, $icon = null, $url = null, $color = 'primary')
	{
		$color && $color = ' bg-'.$color;

		// Opening tag.
		$output = "<div class=\"info-box{$color}\">";

		// Info box content.
		if ($head OR $text)
		{
			$output .= '<div class="inner">';
			$head && $output .= '<h3>'.$head.'</h3>';
			$text && $output .= '<p>'.$text.'</p>';
			$output .= '</div>';
		}

		// Add the icon.
		$icon && $output .= '<div class="icon">'.fa_icon($icon).'</div>';

		if ($url)
		{
			$output .= html_tag('a', array(
				'href'  => $url,
				'class' => 'info-box-footer',
			), __('CSK_BTN_MANAGE').fa_icon('arrow-circle-right ml-1'));
		}

		// Closing tag.
		$output .= '</div>';

		return $output;
	}
}

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
 * Plugin Name: Extra Profile Fields
 * Description: This plugin adds extra fields to users profiles.
 * Version: 0.3.0
 * Author: Kader Bouyakoub
 * Author URI: https://github.com/bkader
 * Author Email: bkader@mail.com
 * Tags: skeleton, profile, fields, extra
 * 
 * Extra Profile Fields
 *
 * This plugin adds extra fields to users profiles.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Plugins
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */

// Action to do after plugin's activation.
add_action('plugin_activate_extra-profile-fields', function() {
	return true;
});

// Action to do after plugin's deactivation.
add_action('plugin_deactivate_extra-profile-fields', function() {
	return true;
});

/**
 * SEO plugin dummy class.
 */
class KB_extra_profile_fields
{
	/**
	 * Initializing plugin's action.
	 */
	public static function init()
	{
		add_filter('users_fields', function($fields) {

			/**
			 * Here we are adding in order:
			 * 1. Company name.
			 * 2. Phone number.
			 * 3. Facebook profile URL.
			 */
			array_push(
				$fields,
				'company',
				'horuk',
				'phone',
				array(	// Facebook.
					'name' => 'facebook',
					'id' => 'facebook',
					'placeholder' => 'Facebook',
					'value' => set_value('facebook')
				)
			);
			return $fields;
		});
	}
}
// Action to do if the plugin is used.
add_action('plugin_install_extra-profile-fields', 'KB_extra_profile_fields::init', 0);

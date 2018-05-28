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
 * @since 		2.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Users Controller - Default registration view.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Views
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */

// Form opening tag and nonce.
echo form_open('register', 'role="form" id="register"'),
form_nonce('user-register'),

// First name
'<div class="form-group">',
print_input($first_name, array(
	'class' => 'form-control form-control-sm'.(has_error('first_name') ? ' is-invalid' : '')
)),
form_error('first_name', '<div class="form-text invalid-feedback">', '</div>'),
'</div>',

// Last name
'<div class="form-group">',
print_input($last_name, array(
	'class' => 'form-control form-control-sm'.(has_error('last_name') ? ' is-invalid' : '')
)),
form_error('last_name', '<div class="form-text invalid-feedback">', '</div>'),
'</div>',

// Email address
'<div class="form-group">',
print_input($email, array(
	'class' => 'form-control form-control-sm'.(has_error('email') ? ' is-invalid' : '')
)),
form_error('email', '<div class="form-text invalid-feedback">', '</div>'),
'</div>',

// Username.
'<div class="form-group">',
print_input($username, array(
	'class' => 'form-control form-control-sm'.(has_error('username') ? ' is-invalid' : '')
)),
form_error('username', '<div class="form-text invalid-feedback">', '</div>'),
'</div>',

// Password.
'<div class="form-group">',
print_input($password, array(
	'class' => 'form-control form-control-sm'.(has_error('password') ? ' is-invalid' : '')
)),
form_error('password', '<div class="form-text invalid-feedback">', '</div>'),
'</div>',

// Confirm password.
'<div class="form-group">',
print_input($cpassword, array(
	'class' => 'form-control form-control-sm'.(has_error('cpassword') ? ' is-invalid' : '')
)),
form_error('cpassword', '<div class="form-text invalid-feedback">', '</div>'),
'</div>',

// Gender.
'<div class="form-group form-check form-check-inline">',

	// Male.
	'<label for="male">',
		form_radio('gender', 'male', set_radio('gender', 'male'), 'id="male"'),
		line('CSK_INPUT_MALE', null, '&nbsp;'),
	'</label>',

	// Female.
	'<label for="female" class="ml-3">',
		form_radio('gender', 'female', set_radio('gender', 'female'), 'id="female"'),
		line('CSK_INPUT_FEMALE', null, '&nbsp;'),
	'</label>',
	form_error('gender', '<div class="form-text invalid-feedback">', '</div>'),
'</div>';

// Captcha field.
if (false !== get_option('use_captcha', false)) {
	echo '<div class="form-group">';
	if (false !== get_option('use_recaptcha', false)) {
		echo $captcha;
	} else {
		echo '<div class="input-group">', 
		'<div class="input-group-prepend ofy-h" tabindex="-1">', $captcha_image, '</div>',
			print_input($captcha, array(
				'class' => 'form-control form-control-sm'.(has_error('identity') ? ' is-invalid' : '')
			)),
		form_error('captcha', '<div class="form-text invalid-feedback">', '</div>'),
		'</div>';
	}
	echo '</div>';
}

// Submit and login button.
echo '<div class="form-group mb-0">',

html_tag('button', array(
	'type' => 'submit',
	'class' => 'btn btn-primary btn-sm pull-right',
), line('CSK_BTN_CREATE_ACCOUNT')),

html_tag('a', array(
	'href' => site_url('login'),
	'class' => 'btn btn-default btn-sm'
), line('CSK_BTN_LOGIN')),

'</div>';

/**
 * Fires before the closing registration form tag.
 * @since 	2.0.0
 */
do_action('register_form');

// Form closing tag.
echo form_close();

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
 * Users Controller - Default reset password view.
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
echo form_open('reset-password?code='.$code, 'role="form" id="reset"'),
form_nonce('user-reset-password_'.$code),

// New password field.
'<div class="form-group">',
print_input($npassword, array(
	'class' => 'form-control form-control-sm'.(has_error('npassword') ? ' is-invalid' : '')
)),
form_error('npassword', '<div class="form-text invalid-feedback">', '</div>'),
'</div>',

// Confirm password field.
'<div class="form-group">',
print_input($cpassword, array(
	'class' => 'form-control form-control-sm'.(has_error('cpassword') ? ' is-invalid' : '')
)),
form_error('cpassword', '<div class="form-text invalid-feedback">', '</div>'),
'</div>',

// Submit button and login anchor.
'<div class="form-group mb-0">',

// Submit button.
html_tag('button', array(
	'type' => 'submit',
	'class' => 'btn btn-primary btn-sm btn-icon pull-right'
), fa_icon('lock').line('CSK_BTN_RESET_PASSWORD')),

// Login button.
html_tag('a', array(
	'href' => site_url('login'),
	'class' => 'btn btn-default btn-icon btn-sm',
), fa_icon('sign-in').line('CSK_BTN_LOGIN')),

'</div>';

/**
 * Fires before the closing reset password form tag.
 * @since 	2.0.0
 */
do_action('reset_password_form');

// Form closing tag.
echo form_close();

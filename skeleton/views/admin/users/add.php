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
 * @link 		https://github.com/bkader
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Users module - Admin: Add new user.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	2.0.0
 */
echo '<div class="row justify-content-center">',
'<div class="col-xs-12 col-sm-8 col-md-6 col-lg-4">',

// Form opening tag and nonce.
form_open(KB_ADMIN.'/users/add', 'role="form" id="add-user"'),
form_nonce('add-user'),

// First name.
'<div class="form-group">',

	html_tag('label', array(
		'for'   => 'first_name',
		'class' => 'sr-only',
	), __('CSK_INPUT_FIRST_NAME')),

	print_input($first_name, array(
		'autofocus' => 'autofocus', 
		'class' => 'form-control'.(has_error('first_name') ? ' is-invalid' : ''),
	)),

	form_error('first_name', '<div class="form-text invalid-feedback">', '</div>'),

'</div>',

// Last name.
'<div class="form-group">',

	html_tag('label', array(
		'for'   => 'last_name',
		'class' => 'sr-only',
	), __('CSK_INPUT_LAST_NAME')),

	print_input($last_name, array(
		'class' => 'form-control'.(has_error('last_name') ? ' is-invalid' : ''),
	)),

	form_error('last_name', '<div class="form-text invalid-feedback">', '</div>'),

'</div>',

// Email address
'<div class="form-group">',

	html_tag('label', array(
		'for'   => 'email',
		'class' => 'sr-only',
	), __('CSK_INPUT_EMAIL_ADDRESS')),

	print_input($email, array(
		'class' => 'form-control'.(has_error('email') ? ' is-invalid' : ''),
	)),

	form_error('email', '<div class="form-text invalid-feedback">', '</div>'),

'</div>',

// Last name.
'<div class="form-group">',

	html_tag('label', array(
		'for'   => 'username',
		'class' => 'sr-only',
	), __('CSK_INPUT_USERNAME')),

	print_input($username, array(
		'class' => 'form-control'.(has_error('username') ? ' is-invalid' : ''),
	)),

	form_error('username', '<div class="form-text invalid-feedback">', '</div>'),

'</div>',

// Password
'<div class="form-group">',

	html_tag('label', array(
		'for'   => 'password',
		'class' => 'sr-only',
	), __('CSK_INPUT_PASSWORD')),

	print_input($password, array(
		'class' => 'form-control'.(has_error('password') ? ' is-invalid' : ''),
	)),

	form_error('password', '<div class="form-text invalid-feedback">', '</div>'),

'</div>',

// Confirm password.
'<div class="form-group">',

	html_tag('label', array(
		'for'   => 'cpassword',
		'class' => 'sr-only',
	), __('CSK_INPUT_CONFIRM_PASSWORD')),

	print_input($cpassword, array(
		'class' => 'form-control'.(has_error('cpassword') ? ' is-invalid' : ''),
	)),

	form_error('cpassword', '<div class="form-text invalid-feedback">', '</div>'),

'</div>',

'<div class="form-group">',

// Account status
form_checkbox('enabled', 1, set_checkbox('enabled', '1', false), 'id="enabled"'),
html_tag('label', array(
	'for' => 'enabled',
), __('CSK_USERS_ACTIVE')),

// Account type.
'<span class="float-right">',
form_checkbox('admin', 1, set_checkbox('admin', '1', false), 'id="admin"'),
html_tag('label', array(
	'for' => 'admin',
), __('CSK_USERS_ROLE_ADMIN')),
'</span>',
'</div>',

// Submit button and cancel.
'<div class="form-group mb-0">',
html_tag('button', array(
	'type' => 'submit',
	'class' => 'btn btn-primary float-right'
), __('CSK_USERS_ADD_USER')),
html_tag('a', array(
	'href'  => admin_url('users'),
	'class' => 'btn btn-white',
), __('CSK_BTN_CANCEL')),
'</div>',

// Form closing tag.
form_close(),

// End of column
'</div>',

// End of row.
'</div>';

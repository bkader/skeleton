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
 * Dashboard login view.
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

// Form open tag.
echo form_open('admin-login', 'id="login"'),
form_nonce('admin-login');

// Username form.
echo '<div class="form-group">',
print_input($username, array(
	'class' => 'form-control form-control-sm'.(has_error('username') ? ' is-invalid' : '')
)),
form_error('username', '<div class="form-text invalid-feedback">', '</div>'),
'</div>';

// Password field.
echo '<div class="form-group">',
print_input($password, array(
	'class' => 'form-control form-control-sm'.(has_error('password') ? ' is-invalid' : '')
)),
form_error('password', '<div class="form-text invalid-feedback">', '</div>'),
'</div>';

if (null !== $languages)
{
	echo '<div class="form-group">',
	print_input($languages, array('class' => 'form-control form-control-sm')),
	'</div>';
}

// Login button.
echo '<div class="form-group clearfix mb-0">',
html_tag('button', array(
	'type' => 'submit',
	'class' => 'btn btn-primary btn-sm btn-icon pull-right',
), '<i class="fa fa-fw fa-sign-in"></i>'.__('CSK_BTN_LOGIN'));

// Lost password button.
$recover_text = apply_filters('login_recover_text', __('CSK_BTN_LOST_PASSWORD'));
$recover_link = apply_filters('login_recover_link', site_url('lost-password'));

if ( ! empty($recover_link)) {
	echo html_tag('a', array(
		'role'     =>'button',
		'href'     => $recover_link,
		'class'    => 'btn btn-default btn-sm btn-icon',
		'tabindex' => '-1',
	), '<i class="fa fa-fw fa-question-circle"></i>'.$recover_text);
}

echo '</div>',
form_close();

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
 * Users Controller - Default restore account view.
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

// Restore tip.
echo '<p class="mb-3">', line('CSK_USERS_RESTORE_TIP'), '</p>',

// Form opening tag and nonce.
form_open('restore-account', 'role="form" id="restore"'),
form_nonce('user-restore'),

// Identity field.
'<div class="form-group">',
print_input($identity, array(
	'class' => 'form-control form-control-sm'.(has_error('identity') ? ' is-invalid' : '')
)),
form_error('identity', '<div class="form-text invalid-feedback">', '</div>'),
'</div>',

// Password field.
'<div class="form-group">',
print_input($password, array(
	'class' => 'form-control form-control-sm'.(has_error('password') ? ' is-invalid' : '')
)),
form_error('password', '<div class="form-text invalid-feedback">', '</div>'),
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
	'class' => 'btn btn-primary btn-sm btn-icon pull-right',
), fa_icon('unlock-alt').line('CSK_BTN_RESTORE_ACCOUNT')),

html_tag('a', array(
	'href' => site_url('login'),
	'class' => 'btn btn-default btn-sm btn-icon'
), fa_icon('sign-in').line('CSK_BTN_LOGIN')),

'</div>';

/**
 * Fires before the closing restore account form tag.
 * @since 	2.0.0
 */
do_action('restore_account_form');

// Form closing tag.
echo form_close();

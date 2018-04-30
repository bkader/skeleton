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
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Settings Module - Admin: Captcha Settings.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.5.0
 */
?><h2 class="page-header"><?php _e('captcha_settings') ?></h2>

<ul class="nav nav-tabs" role="tablist">
	<li role="presentation"><?php echo admin_anchor('settings', lang('general'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/users', lang('users'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/email', lang('email'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/uploads', lang('uploads'), 'role="tab"') ?></li>
	<li role="presentation" class="active"><?php echo admin_anchor('settings/captcha', lang('captcha'), 'role="tab"') ?></li>
</ul>

<div class="tab-content tab-settings">
	<div class="tab-pane active" role="tabpanel" id="general">
		<?php
		echo form_open('admin/settings/captcha', 'role="form" class="form-horizontal" id="settings-email"');
		echo form_nonce('admin_settings_captcha');
		?>
			<fieldset>
				<!-- Use captcha -->
				<div class="form-group<?php echo form_error('use_captcha') ? ' has-error' : ''?>">
					<label for="use_captcha" class="col-sm-2 control-label"><?php _e('set_use_captcha') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($use_captcha, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('use_captcha') ?: lang('set_use_captcha_tip') ?></div>
					</div>
				</div>

				<!-- Use reCAPTCHA -->
				<div class="form-group<?php echo form_error('use_recaptcha') ? ' has-error' : ''?>">
					<label for="use_recaptcha" class="col-sm-2 control-label"><?php _e('set_use_recaptcha') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($use_recaptcha, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('use_recaptcha') ?: lang('set_use_recaptcha_tip') ?></div>
					</div>
				</div>

				<!-- reCAPTCHA site key -->
				<div class="form-group<?php echo form_error('recaptcha_site_key') ? ' has-error' : ''?>">
					<label for="recaptcha_site_key" class="col-sm-2 control-label"><?php _e('set_recaptcha_site_key') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($recaptcha_site_key, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('recaptcha_site_key') ?: lang('set_recaptcha_site_key_tip') ?></div>
					</div>
				</div>

				<!-- reCAPTCHA private key -->
				<div class="form-group<?php echo form_error('recaptcha_private_key') ? ' has-error' : ''?>">
					<label for="recaptcha_private_key" class="col-sm-2 control-label"><?php _e('set_recaptcha_private_key') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($recaptcha_private_key, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('recaptcha_private_key') ?: lang('set_recaptcha_private_key_tip') ?></div>
					</div>
				</div>

				<div class="text-right">
					<button class="btn btn-primary btn-sm" type="submit"><?php _e('save_changes') ?></button>
				</div>
			</fieldset>

		<?php echo form_close() ?>
	</div>
</div>

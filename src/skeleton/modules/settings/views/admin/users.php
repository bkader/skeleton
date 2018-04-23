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
 * Settings Module - Admin: Users Settings.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.4.0
 */
?><h2 class="page-header"><?php _e('users_settings') ?></h2>

<ul class="nav nav-tabs" role="tablist">
	<li role="presentation"><?php echo admin_anchor('settings', lang('general'), 'role="tab"') ?></li>
	<li role="presentation" class="active"><?php echo admin_anchor('settings/users', lang('users'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/email', lang('email'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/uploads', lang('uploads'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/captcha', lang('captcha'), 'role="tab"') ?></li>
</ul>

<div class="tab-content tab-settings">
	<div class="tab-pane active" role="tabpanel" id="general">
		<?php
		echo form_open('admin/settings/users', 'role="form" class="form-horizontal"');
		echo form_nonce('admin_settings_users');
		?>
			<fieldset>
				<!-- Allow registrations -->
				<div class="form-group<?php echo form_error('allow_registration') ? ' has-error' : ''?>">
					<label for="allow_registration" class="col-sm-2 control-label"><?php _e('set_allow_registration') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($allow_registration, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('allow_registration') ?: lang('set_allow_registration_tip') ?></div>
					</div>
				</div>

				<!-- Email activation -->
				<div class="form-group<?php echo form_error('email_activation') ? ' has-error' : ''?>">
					<label for="email_activation" class="col-sm-2 control-label"><?php _e('set_email_activation') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($email_activation, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('email_activation') ?: lang('set_email_activation_tip') ?></div>
					</div>
				</div>

				<!-- Manual activation -->
				<div class="form-group<?php echo form_error('manual_activation') ? ' has-error' : ''?>">
					<label for="manual_activation" class="col-sm-2 control-label"><?php _e('set_manual_activation') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($manual_activation, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('manual_activation') ?: lang('set_manual_activation_tip') ?></div>
					</div>
				</div>

				<!-- Login type -->
				<div class="form-group<?php echo form_error('login_type') ? ' has-error' : ''?>">
					<label for="login_type" class="col-sm-2 control-label"><?php _e('set_login_type') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($login_type, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('login_type') ?: lang('set_login_type_tip') ?></div>
					</div>
				</div>

				<!-- Multiple sessions -->
				<div class="form-group<?php echo form_error('allow_multi_session') ? ' has-error' : ''?>">
					<label for="allow_multi_session" class="col-sm-2 control-label"><?php _e('set_allow_multi_session') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($allow_multi_session, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('allow_multi_session') ?: lang('set_allow_multi_session_tip') ?></div>
					</div>
				</div>

				<!-- Use Gravatar -->
				<div class="form-group<?php echo form_error('use_gravatar') ? ' has-error' : ''?>">
					<label for="use_gravatar" class="col-sm-2 control-label"><?php _e('set_use_gravatar') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($use_gravatar, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('use_gravatar') ?: lang('set_use_gravatar_tip') ?></div>
					</div>
				</div>

				<div class="text-right">
					<button class="btn btn-primary btn-sm" type="submit"><?php _e('save_changes') ?></button>
				</div>
			</fieldset>
		<?php echo form_close() ?>
	</div>
</div>

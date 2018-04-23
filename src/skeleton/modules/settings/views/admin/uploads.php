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
 * Settings Module - Admin: Upload Settings.
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
?><h2 class="page-header"><?php _e('upload_settings') ?></h2>

<ul class="nav nav-tabs" role="tablist">
	<li role="presentation"><?php echo admin_anchor('settings', lang('general'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/users', lang('users'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/email', lang('email'), 'role="tab"') ?></li>
	<li role="presentation" class="active"><?php echo admin_anchor('settings/uploads', lang('uploads'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/captcha', lang('captcha'), 'role="tab"') ?></li>
</ul>

<div class="tab-content tab-settings">
	<div class="tab-pane active" role="tabpanel" id="general">
		<?php
		echo form_open('admin/settings/uploads', 'role="form" class="form-horizontal"');
		echo form_nonce('admin_settings_uploads');
		?>
			<fieldset>
				<!-- Uploads path -->
				<div class="form-group<?php echo form_error('upload_path') ? ' has-error' : ''?>">
					<label for="upload_path" class="col-sm-2 control-label"><?php _e('set_upload_path') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($upload_path, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('upload_path') ?: lang('set_upload_path_tip') ?></div>
					</div>
				</div>

				<!-- Allowed file types -->
				<div class="form-group<?php echo form_error('allowed_types') ? ' has-error' : ''?>">
					<label for="allowed_types" class="col-sm-2 control-label"><?php _e('set_allowed_types') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($allowed_types, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('allowed_types') ?: lang('set_allowed_types_tip') ?></div>
					</div>
				</div>

				<div class="text-right">
					<button class="btn btn-primary btn-sm" type="submit"><?php _e('save_changes') ?></button>
				</div>
			</fieldset>
		<?php echo form_close() ?>
	</div>
</div>

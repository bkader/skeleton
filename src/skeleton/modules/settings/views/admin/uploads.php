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
 * @version 	1.4.2
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
		echo form_open('admin/settings/uploads', 'role="form" class="form-horizontal" id="settings-uploads"');
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

				<!-- Date/Month folders -->
				<div class="form-group<?php echo form_error('upload_year_month') ? ' has-error' : ''?>">
					<label for="upload_year_month" class="col-sm-2 control-label"><?php _e('set_upload_year_month') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($upload_year_month, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('upload_year_month') ?: lang('set_upload_year_month_tip') ?></div>
					</div>
				</div>

				<!-- Max file size -->
				<div class="form-group<?php echo form_error('max_size') ? ' has-error' : ''?>">
					<label for="max_size" class="col-sm-2 control-label"><?php _e('set_max_size') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($max_size, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('max_size') ?: lang('set_max_size_tip') ?></div>
					</div>
				</div>

				<!-- Minimum image width/height -->
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php _e('set_min_image_size') ?></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-xs-6<?php echo form_error('min_width') ? ' has-error' : ''?>">
								<?php echo print_input($min_width, array('class' => 'form-control')) ?>
								<div class="help-block"><?php echo form_error('min_width') ?: lang('set_min_width_tip') ?></div>
							</div>
							<div class="col-xs-6<?php echo form_error('min_height') ? ' has-error' : ''?>">
								<?php echo print_input($min_height, array('class' => 'form-control')) ?>
								<div class="help-block"><?php echo form_error('min_height') ?: lang('set_min_height_tip') ?></div>
							</div>
						</div>
					</div>
				</div>

				<!-- Maximum image width/height -->
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php _e('set_max_image_size') ?></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-xs-6<?php echo form_error('max_width') ? ' has-error' : ''?>">
								<?php echo print_input($max_width, array('class' => 'form-control')) ?>
								<div class="help-block"><?php echo form_error('max_width') ?: lang('set_max_width_tip') ?></div>
							</div>
							<div class="col-xs-6<?php echo form_error('max_height') ? ' has-error' : ''?>">
								<?php echo print_input($max_height, array('class' => 'form-control')) ?>
								<div class="help-block"><?php echo form_error('max_height') ?: lang('set_max_height_tip') ?></div>
							</div>
						</div>
					</div>
				</div>

				<!-- Thumbnail Size -->
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6 col-md-12">
							<label class="col-sm-2 control-label"><?php _e('set_image_thumbnail') ?></label>
							<div class="col-sm-10">
								<div class="row">
									<div class="col-xs-6<?php echo form_error('image_thumbnail_w') ? ' has-error' : ''?>">
										<?php echo print_input($image_thumbnail_w, array('class' => 'form-control')) ?>
										<div class="help-block"><?php echo form_error('image_thumbnail_w') ?: lang('set_image_thumbnail_w_tip') ?></div>
									</div>
									<div class="col-xs-6<?php echo form_error('image_thumbnail_h') ? ' has-error' : ''?>">
										<?php echo print_input($image_thumbnail_h, array('class' => 'form-control')) ?>
										<div class="help-block"><?php echo form_error('image_thumbnail_h') ?: lang('set_image_thumbnail_h_tip') ?></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-12">
							<label class="col-sm-2 control-label"><?php _e('set_image_thumbnail_crop') ?></label>
							<div class="col-sm-10">
								<?php echo print_input($image_thumbnail_crop, array('class' => 'form-control')) ?>
								<div class="help-block"><?php echo form_error('image_thumbnail_crop') ?: lang('set_image_thumbnail_crop_tip') ?></div>
							</div>
						</div>
					</div>
				</div>

				<!-- Medium image width/height -->
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php _e('set_image_medium') ?></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-xs-6<?php echo form_error('image_medium_w') ? ' has-error' : ''?>">
								<?php echo print_input($image_medium_w, array('class' => 'form-control')) ?>
								<div class="help-block"><?php echo form_error('image_medium_w') ?: lang('set_image_medium_w_tip') ?></div>
							</div>
							<div class="col-xs-6<?php echo form_error('image_medium_h') ? ' has-error' : ''?>">
								<?php echo print_input($image_medium_h, array('class' => 'form-control')) ?>
								<div class="help-block"><?php echo form_error('image_medium_h') ?: lang('set_image_medium_h_tip') ?></div>
							</div>
						</div>
					</div>
				</div>

				<!-- Large image width/height -->
				<div class="form-group">
					<label class="col-sm-2 control-label"><?php _e('set_image_large') ?></label>
					<div class="col-sm-10">
						<div class="row">
							<div class="col-xs-6<?php echo form_error('image_large_w') ? ' has-error' : ''?>">
								<?php echo print_input($image_large_w, array('class' => 'form-control')) ?>
								<div class="help-block"><?php echo form_error('image_large_w') ?: lang('set_image_large_w_tip') ?></div>
							</div>
							<div class="col-xs-6<?php echo form_error('image_large_h') ? ' has-error' : ''?>">
								<?php echo print_input($image_large_h, array('class' => 'form-control')) ?>
								<div class="help-block"><?php echo form_error('image_large_h') ?: lang('set_image_large_h_tip') ?></div>
							</div>
						</div>
					</div>
				</div>

				<div class="text-right">
					<button class="btn btn-primary btn-sm" type="submit"><?php _e('save_changes') ?></button>
				</div>
			</fieldset>
		<?php echo form_close() ?>
	</div>
</div>

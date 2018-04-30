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
 * Users module - Admin: Add new user.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.4.0
 */
?><h2 class="page-header clearfix"><?php _e('add_user') ?> <?php echo admin_anchor('users', line('us_manage_users'), 'class="btn btn-primary btn-sm pull-right"') ?></h2>
<div class="row">
	<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
		<div class="panel panel-default">
			<div class="panel-body">
				<?php
				echo form_open('admin/users/add', 'role="form" id="add-user"');
				echo form_nonce('add-user');
				?>
					<div class="form-group<?php echo form_error('first_name') ? ' has-error' : '' ?>">
						<label for="first_name" class="sr-only"><?php _e('first_name') ?></label>
						<?php echo print_input($first_name, array('class' => 'form-control', 'autofocus' => 'autofocus')) ?>
						<?php echo form_error('first_name', '<small class="help-block">', '</small>')?>
					</div>
					<div class="form-group<?php echo form_error('last_name') ? ' has-error' : '' ?>">
						<label for="last_name" class="sr-only"><?php _e('last_name') ?></label>
						<?php echo print_input($last_name, array('class' => 'form-control')) ?>
						<?php echo form_error('last_name', '<small class="help-block">', '</small>')?>
					</div>
					<div class="form-group<?php echo form_error('email') ? ' has-error' : '' ?>">
						<label for="email" class="sr-only"><?php _e('email_address') ?></label>
						<?php echo print_input($email, array('class' => 'form-control')) ?>
						<?php echo form_error('email', '<small class="help-block">', '</small>')?>
					</div>
					<div class="form-group<?php echo form_error('username') ? ' has-error' : '' ?>">
						<label for="username" class="sr-only"><?php _e('username') ?></label>
						<?php echo print_input($username, array('class' => 'form-control')) ?>
						<?php echo form_error('username', '<small class="help-block">', '</small>')?>
					</div>
					<div class="form-group<?php echo form_error('password') ? ' has-error' : '' ?>">
						<label for="password" class="sr-only"><?php _e('password') ?></label>
						<?php echo print_input($password, array('class' => 'form-control')) ?>
						<?php echo form_error('password', '<small class="help-block">', '</small>')?>
					</div>
					<div class="form-group<?php echo form_error('cpassword') ? ' has-error' : '' ?>">
						<label for="cpassword" class="sr-only"><?php _e('confirm_password') ?></label>
						<?php echo print_input($cpassword, array('class' => 'form-control')) ?>
						<?php echo form_error('cpassword', '<small class="help-block">', '</small>')?>
					</div>
					<div class="form-group">
						<input type="checkbox" name="enabled" id="enabled" value="1" <?php echo set_checkbox('enabled', '1', true) ?>>&nbsp;<label for="enabled"><?php _e('active') ?></label>
						<span class="pull-right">
							<input type="checkbox" name="admin" id="admin" value="1" <?php echo set_checkbox('admin', '1', false) ?>>&nbsp;<label for="admin"><?php _e('admin') ?></label>
						</span>
					</div>

					<button type="submit" class="btn btn-primary btn-sm btn-block"><?php _e('add_user') ?></button>
				<?php echo form_close() ?>
			</div>
		</div>
	</div>
</div>

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
 * Menus module - Admin: edit menu.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.3.0
 */
?><h2 class="page-header clearfix">
	<?php _e('edit_menu'); ?>: <?php echo $menu->name; ?>
	<?php echo admin_anchor('menus', lang('manage_menus'), 'class="btn btn-primary btn-sm pull-right"') ?>
</h2>
<div class="row">
	<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
		<div class="panel panel-default">
			<div class="panel-body">
				<?php echo form_open('admin/menus/edit/menu/'.$menu->id, 'role="form"', $hidden); ?>

					<div class="form-group<?php echo (form_error('name')) ? ' has-error' : ''; ?>">
						<label for="name"><?php _e('menu_name'); ?></label>
						<?php echo print_input($name, array('class' => 'form-control', 'autofocus' => 'autofocus')); ?>
						<?php echo form_error('name', '<p class="help-block">', '</p>') ?: '<p class="help-block">'.lang('menu_name_tip').'</p>' ?>
					</div>

					<div class="form-group<?php echo (form_error('username')) ? ' has-error' : ''; ?>">
						<label for="username"><?php _e('menu_slug'); ?></label>
						<?php echo print_input($username, array('class' => 'form-control', 'autofocus' => 'autofocus')); ?>
						<?php echo form_error('username', '<p class="help-block">', '</p>') ?: '<p class="help-block">'.lang('menu_slug_tip').'</p>' ?>
					</div>

					<div class="form-group<?php echo (form_error('menu_description')) ? ' has-error' : ''; ?>">
						<label for="description"><?php _e('menu_description'); ?></label>
						<?php echo print_input($description, array('class' => 'form-control', 'rows' => 3)); ?>
						<p class="help-block"><?php _e('menu_description_tip'); ?></p>
					</div>

					<button type="submit" class="btn btn-primary btn-sm pull-right"><?php _e('save_menu'); ?></button>
					<?php echo anchor('admin/menus', lang('cancel'), 'class="btn btn-default btn-sm"'); ?>

				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

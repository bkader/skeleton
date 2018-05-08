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
 * @link 		https://goo.gl/wGXHO9
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Menus module - Admin: locations.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	1.4.0
 */
?><h3 class="page-header clearfix"><?php

// Page header.
_e('smn_manage_locations');

// Manage menus anchor.
echo admin_anchor('menus', lang('smn_manage_menus'), 'class="btn btn-default btn-sm pull-right"');

?></h3>
<div class="row">
	<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-body">
			<?php if (count($locations) > 0): ?>
				<p><?php printf(lang('smn_theme_locations'), count($locations)); ?></p>
				<br />
				<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
				<?php

				// Form opening tag.
				echo form_open('admin/menus/locations', 'role="form" rel="persist" class="form-horizontal"');

				// Security nonce.
				echo form_nonce('edit_locations');
				?>
				<?php foreach ($locations as $slug => $location): ?>
					<div class="form-group">
						<label for="location-<?php echo $slug; ?>" class="col-sm-4 control-label"><?php echo $location; ?></label>
						<div class="col-sm-8">
							<select name="menu_location[<?php echo $slug; ?>]" id="location-<?php echo $slug; ?>" class="form-control input-sm">
								<option value="0"><?php _e('smn_select_menu'); ?></option>
							<?php foreach ($menus as $menu): ?>
								<option value="<?php echo $menu->id; ?>"<?php if ($menu->menu_location === $slug): ?> selected="selected"<?php endif; ?>><?php echo $menu->name; ?></option>
							<?php endforeach; unset($menu); ?>
							</select>
						</div>
					</div>
				<?php endforeach; ?>
				<div class="form-group">
					<div class="col-sm-8 col-sm-offset-4">
						<button type="submit" class="btn btn-primary btn-sm btn-block"><?php _e('CSK_ADMIN_BTN_SAVE_CHANGES'); ?></button>
					</div>
				</div>
				<?php echo form_close(); ?>
			<?php else: ?>
				<p><?php printf(lang('smn_theme_locations_none'), count($locations)); ?></p>
			<?php endif; ?>
			</div>
		</div>
	</div>
</div>

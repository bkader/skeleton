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
 * Menus module - Admin: list menus.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.3.3
 */
?><h2 class="page-header clearfix"><?php _e('smn_manage_menus'); ?><span class="pull-right"><?php

// Add menu anchor:
echo admin_anchor('menus/add', lang('smn_add_menu'), 'class="btn btn-primary btn-sm"');

// Manage locations anchor.
echo '&nbsp;'.admin_anchor('menus/locations', lang('smn_manage_locations'), 'class="btn btn-default btn-sm"');

?></span></h2>
<div class="panel panel-default">
	<div class="table-responsive">
		<table class="table table-hover table-condensed">
			<thead>
				<tr>
					<th><?php _e('name') ?></th>
					<th><?php _e('slug') ?></th>
					<th><?php _e('description') ?></th>
					<th><?php _e('location') ?></th>
					<th class="text-right"><?php _e('action') ?></th>
				</tr>
			</thead>
			<tbody>
		<?php if ($menus): ?>
			<?php foreach ($menus as $menu): ?>
				<tr id="menu-<?php echo $menu->id; ?>">
					<td><?php echo $menu->name ?></td>
					<td><?php echo $menu->username ?></td>
					<td><?php echo $menu->description ?></td>
					<td><?php echo $menu->location_name ?></td>
					<td class="text-right">
						<a class="btn btn-default btn-xs" href="<?php echo admin_url('menus/edit/'.$menu->id) ?>" title="<?php _e('smn_edit_menu') ?>"><i class="fa fa-edit"></i></a>&nbsp;
						<a class="btn btn-primary btn-xs" href="<?php echo admin_url('menus/items/'.$menu->id) ?>" title="<?php _e('smn_menu_items') ?>"><i class="fa fa-list-ul"></i></a>&nbsp;
						<a href="<?php echo safe_admin_url('menus/delete/menu/'.$menu->id) ?>" data-menu-id="<?php echo $menu->id; ?>" class="btn btn-danger btn-xs menu-delete" title="<?php _e('smn_delete_menu') ?>"><i class="fa fa-trash-o"></i></a>
					</td>
				</tr>
			<?php endforeach; ?>
		<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

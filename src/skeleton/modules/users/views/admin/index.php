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
 * Users module - Admin: list users.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.0.0
 */
?><h2 class="page-header"><?php _e('us_manage_users') ?> <?php echo admin_anchor('users/add', lang('add_user'), 'class="btn btn-primary btn-sm pull-right"') ?></h2>
<div class="panel panel-default">
	<div class="panel-body">
		<table class="table table-hover table-condensed">
			<thead>
				<tr>
					<th class="col-xs-1">ID</th>
					<th class="col-xs-2"><?php _e('full_name') ?></th>
					<th class="col-xs-2"><?php _e('username') ?></th>
					<th class="col-xs-3"><?php _e('email_address') ?></th>
					<th class="col-xs-1"><?php _e('role') ?></th>
					<th class="col-xs-1"><?php _e('status') ?></th>
					<th class="col-xs-2 text-right"><?php _e('action') ?></th>
				</tr>
			</thead>
			<tbody>
		<?php foreach ($users as $user): ?>
				<tr id="row-<?php echo $user->id; ?>">
					<td><?php echo $user->id ?></td>
					<td><i class="fa fa-<?php echo $user->gender ?>" title="<?php _e($user->gender) ?>"></i> <?php echo $user->first_name, ' ', $user->last_name ?></td>
					<td><?php echo anchor($user->username, $user->username, 'target="_blank"') ?></td>
					<td><?php echo $user->email ?></td>
					<td><?php _e($user->subtype) ?></td>
					<td><?php echo ($user->enabled == 1) ? '<span class="label label-success">'.lang('active').'</span>' : '<span class="label label-danger">'.lang('inactive').'</span>' ?></td>
					<td class="text-right">
						<a class="btn btn-default btn-xs" target="_blank" href="<?php echo site_url($user->username) ?>" title="<?php _e('view_profile') ?>"><i class="fa fa-eye"></i></a>&nbsp;
						<a class="btn btn-primary btn-xs" href="<?php echo admin_url('users/edit/'.$user->id) ?>" title="<?php _e('edit_user') ?>"><i class="fa fa-edit"></i></a>&nbsp;
						<a class="btn btn-danger btn-xs" href="#" rel="async" ajaxify="<?php echo safe_ajax_url('users/delete/'.$user->id) ?>" title="<?php _e('delete_user') ?>"><i class="fa fa-times"></i></a>&nbsp;
					<?php if ($user->enabled == 0): ?>
						<a class="btn btn-success btn-xs" href="#" rel="async" ajaxify="<?php echo safe_ajax_url('users/activate/'.$user->id) ?>" data-action="activate" data-id="<?php echo $user->id; ?>" title="<?php _e('activate') ?>"><i class="fa fa-unlock-alt"></i></a>
					<?php else: ?>
						<a class="btn btn-warning btn-xs" href="#" rel="async" ajaxify="<?php echo safe_ajax_url('users/deactivate/'.$user->id) ?>" data-action="deactivate" data-confirm="Do you really?" title="<?php _e('deactivate') ?>"><i class="fa fa-lock"></i></a>
					<?php endif; ?>
					</td>
				</tr>
		<?php endforeach; ?>
			</tbody>
		</table>

		<?php echo $pagination ?>
	</div>
</div>

<a class="btn btn-app">
	<span class="badge bg-warning">3</span>
	<i class="fa fa-bullhorn"></i> Notifications
</a>


<a class="btn btn-app">
                <span class="badge bg-green">300</span>
                <i class="fa fa-barcode"></i> Products
              </a>

<a class="btn btn-app">
                <span class="badge bg-purple">891</span>
                <i class="fa fa-users"></i> Users
              </a>

<a class="btn btn-app">
                <span class="badge bg-teal">67</span>
                <i class="fa fa-inbox"></i> Orders
              </a>

<a class="btn btn-app">
                <span class="badge bg-aqua">12</span>
                <i class="fa fa-envelope"></i> Inbox
              </a>
<a class="btn btn-app">
                <span class="badge bg-red">531</span>
                <i class="fa fa-heart-o"></i> Likes
              </a>
<?php
/* End of file index.php */
/* Location: ./content/modules/users/views/admin/index.php */

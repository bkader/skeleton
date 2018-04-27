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
 * Users module - Admin: list users.
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
?><h2 class="page-header clearfix"><?php _e('us_manage_users') ?> <?php echo admin_anchor('users/add', line('add_user'), 'class="btn btn-primary btn-sm pull-right"') ?></h2>
<div class="panel panel-default">
	<div class="table-responsive">
		<table class="table table-hover table-condensed table-striped" id="users-list">
			<thead>
				<tr>
					<th class="col-xs-1">ID</th>
					<th class="col-xs-2"><?php _e('full_name') ?></th>
					<th class="col-xs-2"><?php _e('username') ?></th>
					<th class="col-xs-2"><?php _e('email_address') ?></th>
					<th class="col-xs-1"><?php _e('role') ?></th>
					<th class="col-xs-2"><?php _e('status') ?></th>
					<th class="col-xs-2 text-right"><?php _e('action') ?></th>
				</tr>
			</thead>
		<?php if ($users): ?>
			<tbody>
			<?php foreach ($users as $user): ?>
				<tr id="user-<?php echo $user->id; ?>">
					<td><?php echo $user->id ?></td>
					<td><i class="fa fa-fw fa-<?php echo $user->gender ?>" title="<?php _e($user->gender) ?>"></i> <?php echo $user->full_name ?></td>
					<td><?php echo anchor($user->username, $user->username, 'target="_blank"') ?></td>
					<td><?php echo $user->email ?></td>
					<td><?php _e($user->subtype) ?></td>
					<td><?php echo label_condition((1 == $user->enabled), 'lang:active', 'lang:inactive'); ?>&nbsp;<?php echo label_condition((0 == $user->deleted), null, 'lang:deleted'); ?></td>
					<td class="text-right">
					<?php
					/**
					 * Fire before default users actions.
					 * @since 	1.4.0
					 */
					do_action('admin_users_action', $user);

					// View user's profile.
					echo admin_anchor(
						$user->username,
						'<i class="fa fa-fw fa-eye"></i>',
						array(
							'class' => 'btn btn-default btn-xs ml5',
							'target' => '_blank',
							'title' => line('view_user'),
						)
					);
					// Edit user button.
					echo admin_anchor(
						'users/edit/'.$user->id,
						'<i class="fa fa-fw fa-edit"></i>',
						array(
							'class'   => 'btn btn-primary btn-xs ml5',
							'data-id' => $user->id,
							'title'   => line('edit_user'),
						)
					);
					// Activate/deactivate user.
					if (1 == $user->enabled) {
						echo safe_ajax_anchor(
							'users/deactivate/'.$user->id,
							'deactivate-user_'.$user->id,
							'<i class="fa fa-fw fa-lock"></i>',
							array(
								'class'   => 'btn btn-warning btn-xs ml5 user-deactivate',
								'data-id' => $user->id,
								'title'   => line('deactivate_user'),
							)
						);
					} else {
						echo safe_ajax_anchor(
							'users/activate/'.$user->id,
							'activate-user_'.$user->id,
							'<i class="fa fa-fw fa-unlock-alt"></i>',
							array(
								'class'   => 'btn btn-success btn-xs ml5 user-activate',
								'data-id' => $user->id,
								'title'   => line('activate_user'),
							)
						);
					}
					?>
						<div class="btn-group btn-group-xs ml5">
							<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php _e('more'); ?>"><i class="fa fa-fw fa-caret-down"></i></button>
							<ul class="dropdown-menu dropdown-menu-right">
							<?php
							if (1 == $user->deleted) {
								echo '<li>', safe_ajax_anchor(
									'users/restore/'.$user->id,
									'restore-user_'.$user->id,
									line('restore_user'),
									array(
										'class'   => 'user-restore',
										'data-id' => $user->id,
									)
								), '</li>';
							} else {
								echo '<li>', safe_ajax_anchor(
									'users/delete/'.$user->id,
									'delete-user_'.$user->id,
									line('delete_user'),
									array(
										'class'   => 'user-delete',
										'data-id' => $user->id,
									)
								), '</li>';
							}

							echo '<li role="separator" class="divider"></li>';

							// Permanently delete user.
							echo '<li>', safe_ajax_anchor(
								'users/remove/'.$user->id,
								'remove-user_'.$user->id,
								line('remove_user'),
								array(
									'class'   => 'user-remove',
									'data-id' => $user->id,
								)
							), '</li>';
							?>
							</ul>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		<?php endif; ?>
		</table>
	</div>
</div>
<?php echo $pagination ?>

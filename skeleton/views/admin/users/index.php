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
 * Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
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
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @copyright	Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://goo.gl/wGXHO9
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard users list.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Views
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.0.0
 */
?>
<div class="panel panel-default">
	<div class="box">
		<table class="table table-sm table-hover table-striped mb-0">
			<thead>
				<tr>
					<th class="w-5">ID</th>
					<th class="w-20"><?php _e('CSK_INPUT_FULL_NAME') ?></th>
					<th class="w-15"><?php _e('CSK_INPUT_USERNAME') ?></th>
					<th class="w-15"><?php _e('CSK_INPUT_EMAIL_ADDRESS') ?></th>
					<th class="w-10"><?php _e('CSK_USERS_ROLE') ?></th>
					<th class="w-15"><?php _e('CSK_ADMIN_STATUS') ?></th>
					<th class="w-20 text-right"><?php _e('CSK_ADMIN_ACTIONS') ?></th>
				</tr>
			</thead>
			<tbody id="users-list">
			<?php if ($users): foreach ($users as $user): ?>
				<tr id="user-<?php echo $user->id; ?>" data-id="<?php echo $user->id; ?>" data-name="<?php echo $user->username; ?>">
				<?php

				// User's ID.
				echo html_tag('td', null, $user->id),

				// Full name, username and email address.
				html_tag('td', null, fa_icon($user->gender.' mr-1').$user->full_name),
				html_tag('td', null, $user->username),
				html_tag('td', null, $user->email),
				html_tag('td', null, __('CSK_USERS_ROLE_'.$user->subtype)),

				// Status.
				'<td>';
				if ($user->enabled > 0) {
					echo html_tag('span', array(
						'class' => 'badge badge-success'
					), __('CSK_USERS_ACTIVE'));
				} else {
					echo html_tag('span', array(
						'class' => 'badge badge-warning'
					), __('CSK_USERS_INACTIVE'));
				}

				if (0 <> $user->deleted) {
					echo html_tag('span', array(
						'class' => 'badge badge-danger ml-1'
					), __('CSK_USERS_DELETED'));
				}

				// User actions.
				echo '<td class="text-right">';
					/**
					 * Fire before default users actions.
					 * @since 	1.4.0
					 */
					do_action('admin_users_action', $user);

						// View user's profile.
						echo html_tag('a', array(
							'href'   => site_url($user->username),
							'class'  => 'btn btn-default btn-xs',
							'rel'    => 'tooltip',
							'title'  => __('CSK_BTN_VIEW_PROFILE'),
							'target' => '_blank',
						), fa_icon('eye')),

						// Edit user button.
						html_tag('a', array(
							'href'   => admin_url('users/edit/'.$user->id),
							'class'  => 'btn btn-default btn-xs ml-2',
							'rel'    => 'tooltip',
							'title'  => __('CSK_USERS_EDIT_USER'),
						), fa_icon('edit text-primary'));

						// Activate/deactivate user.
						if (1 == $user->enabled) {
							echo html_tag('button', array(
								'type'          => 'button',
								'data-endpoint' => esc_url(nonce_admin_url("users?action=deactivate&amp;user={$user->id}&amp;next=".rawurlencode($uri_string), "user-deactivate_{$user->id}")),
								'class'         => 'btn btn-default btn-xs user-deactivate ml-2',
								'rel'           => 'tooltip',
								'title'         => __('CSK_USERS_DEACTIVATE_USER'),
							), fa_icon('lock'));
						} else {
							echo html_tag('button', array(
								'type'          => 'button',
								'data-endpoint' => esc_url(nonce_admin_url("users?action=activate&amp;user={$user->id}&amp;next=".rawurlencode($uri_string), "user-activate_{$user->id}")),
								'class'         => 'btn btn-default btn-xs user-activate ml-2',
								'rel'           => 'tooltip',
								'title'         => __('CSK_USERS_ACTIVATE_USER'),
							), fa_icon('unlock-alt text-success'));
						}

						// Already deleted?
						if (1 == $user->deleted)
						{
							echo html_tag('button', array(
								'type'          => 'button',
								'data-endpoint' => esc_url(nonce_admin_url("users?action=restore&amp;user={$user->id}&amp;next=".rawurlencode($uri_string), "user-restore_{$user->id}")),
								'class'         => 'btn btn-default btn-xs user-restore ml-2',
								'rel'           => 'tooltip',
								'title'         => __('CSK_USERS_RESTORE_USER'),
							), fa_icon('history'));
						}
						else
						{
							echo html_tag('button', array(
								'type'          => 'button',
								'data-endpoint' => esc_url(nonce_admin_url("users?action=delete&amp;user={$user->id}&amp;next=".rawurlencode($uri_string), "user-delete_{$user->id}")),
								'class'         => 'btn btn-default btn-xs user-delete ml-2',
								'rel'           => 'tooltip',
								'title'         => __('CSK_USERS_DELETE_USER'),
							), fa_icon('times text-danger'));
						}

						echo html_tag('button', array(
							'type'          => 'button',
							'data-endpoint' => esc_url(nonce_admin_url("users?action=remove&amp;user={$user->id}&amp;next=".rawurlencode($uri_string), "user-remove_{$user->id}")),
							'class'         => 'btn btn-danger btn-xs user-remove ml-2',
							'rel'           => 'tooltip',
							'title'         => __('CSK_USERS_REMOVE_USER'),
						), fa_icon('trash-o'));

				echo '</td>';

				?>
				</tr>
			<?php endforeach; endif; ?>
			</tbody>
		</table>
	</div>
</div>
<?php
// Display the pagination.
echo $pagination;

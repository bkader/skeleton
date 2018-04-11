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
 * Activities Module - List Activities
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.3.3
 * @version 	1.3.3
 */
?><h2 class="page-header clearfix"><?php _e('activity_log'); ?><?php echo $back_anchor; ?></h2>
<div class="panel panel-default">
	<div class="table-responsive">
		<table class="table table-hover table-condensed table-striped">
			<thead>
				<tr>
					<th class="col-xs-2"><?php _e('user'); ?></th>
					<th class="col-xs-1"><?php _e('module'); ?></th>
					<th class="col-xs-4"><?php _e('activity'); ?></th>
					<th class="col-xs-2"><?php _e('ip_address'); ?></th>
					<th class="col-xs-2"><?php _e('date'); ?></th>
					<th class="col-xs-1 text-right"><?php _e('action'); ?></th>
				</tr>
			</thead>
<?php if ($activities): ?>
			<tbody>
				<?php foreach ($activities as $activity): ?>
				<tr id="activity-<?php echo $activity->id; ?>">
					<td><?php echo $activity->user_anchor; ?></td>
					<td><?php echo $activity->module_anchor; ?></td>
					<td><?php echo $activity->activity; ?></td>
					<td><?php echo $activity->ip_address; ?></td>
					<td><?php echo date('Y/m/d H:i', $activity->created_at); ?></td>
					<td class="text-right">
						<a href="#" data-href="<?php echo safe_admin_url('activities/delete/'.$activity->id); ?>" data-id="<?php echo $activity->id; ?>" class="btn btn-danger btn-xs delete-activity"><i class="fa fa-times"></i></a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
<?php endif; ?>
		</table>
	</div>
</div>
<?php echo $pagination; ?>

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
 * Plugins module - Admin: list plugins.
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
	<?php _e('spg_manage_plugins'); ?>
	<span class="pull-right"><div class="btn-group btn-group-sm"><?php

echo admin_anchor('plugins', sprintf(lang('spg_all'), $count_all), 'class="btn btn-'.(null === $filter ? 'primary' : 'default').'"').'&nbsp;';

echo admin_anchor('plugins?status=active', sprintf(lang('spg_active'), $count_active), 'class="btn btn-'.('active' === $filter ? 'primary' : 'default').'"').'&nbsp;';

echo admin_anchor('plugins?status=inactive', sprintf(lang('spg_inactive'), $count_inactive), 'class="btn btn-'.('inactive' === $filter ? 'primary' : 'default').'"');

	?></div><?php echo admin_anchor('plugins/install', lang('spg_plugin_add'), 'class="btn btn-primary btn-sm"'); ?></span>
</h2>
<div class="panel panel-default">
	<div class="table-responsive">
		<table class="table table-hover table-condensed">
			<thead>
				<tr>
					<th class="col-md-3"><?php _e('spg_plugin') ?></th>
					<th class="col-md-9"><?php _e('spg_description') ?></th>
				</tr>
			</thead>
		<?php if ($plugins): ?>
			<tbody>
		<?php foreach ($plugins as $slug => $plugin): ?>
				<tr id="plugin-<?php echo $slug; ?>">
					<td>
						<?php echo ($plugin['enabled']) ? '<strong>'.$plugin['name'].'</strong>' : $plugin['name']; ?><br />
						<small><?php echo implode('&nbsp;&#124;&nbsp;', $plugin['actions']); ?></small>
					</td>
					<td>
						<p><?php echo $plugin['description']; ?></p>
						<small><?php echo implode(' &#124; ', $plugin['details']); ?></small>
					</td>
				</tr>
		<?php endforeach; ?>
			</tbody>
		<?php endif; ?>
		</table>
	</div>
</div>

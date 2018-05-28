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
 * @since 		2.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * System Information Page.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Views
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */
?>
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="nav-item"><a href="#sysinfo" class="nav-link active" aria-controls="sysinfo" role="tab" data-toggle="tab"><?php _e('CSK_SETTINGS_SYSTEM_INFORMATION'); ?></a></li>
	<li role="presentation" class="nav-item"><a href="#phpset" class="nav-link" aria-controls="phpset" role="tab" data-toggle="tab"><?php _e('CSK_SETTINGS_PHP_SETTINGS'); ?></a></li>
	<li role="presentation" class="nav-item"><a href="#phpinfo" class="nav-link" aria-controls="phpinfo" role="tab" data-toggle="tab"><?php _e('CSK_SETTINGS_PHP_INFO'); ?></a></li>
</ul>
<div class="tab-content">
	<div role="tabpanel" class="box box-borderless tab-pane active" id="sysinfo">
		<div class="table-responsive-sm">
			<table class="table table-sm table-hover table-striped">
				<thead><tr><th class="w-25"><?php _e('CSK_SETTINGS_SETTING'); ?></th><th><?php _e('CSK_SETTINGS_VALUE'); ?></th></tr></thead>
				<tbody>
				<?php foreach ($info as $i_key => $i_val): ?>
					<tr><th><?php _e('CSK_SETTINGS_'.strtoupper($i_key)); ?></th><td><?php echo $i_val; ?></td></tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div role="tabpanel" class="box box-borderless tab-pane" id="phpset">
		<div class="table-responsive-sm">
			<table class="table table-sm table-hover table-striped">
				<thead><tr><th class="w-25"><?php _e('CSK_SETTINGS_SETTING'); ?></th><th><?php _e('CSK_SETTINGS_VALUE'); ?></th></tr></thead>
				<tbody>
				<?php foreach ($php as $p_key => $p_val): ?>
					<tr>
						<th><?php _e('CSK_SETTINGS_'.strtoupper($p_key)); ?></th>
						<td><?php
						switch ($p_val) {
							case '1':
								_e('CSK_ON');
								break;
							case '0':
								_e('CSK_OFF');
								break;
							case null:
							case empty($p_val):
								_e('CSK_NONE');
								break;
							default:
								echo $p_val;
								break;
						}
						?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div role="tabpanel" class="box box-borderless tab-pane" id="phpinfo">
		<div class="table-responsive-sm"><?php echo $phpinfo; ?></table>
		</div>
	</div>
</div>

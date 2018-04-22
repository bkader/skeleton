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
 * Language Module - Admin
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.3.3
 * @version 	1.4.0
 */
?><h2 class="page-header clearfix"><?php _e('sln_manage_languages'); ?></h2>
<div class="panel panel-default">
	<div class="table-responsive">
		<table class="table table-condensed">
			<caption><?php _e('sln_manage_languages_tip'); ?></caption>
			<thead>
				<tr>
					<th class="col-xs-3"><?php _e('language'); ?></th>
					<th class="col-xs-2"><?php _e('sln_abbreviation'); ?></th>
					<th class="col-xs-2"><?php _e('sln_folder'); ?></th>
					<th class="col-xs-1"><?php _e('sln_is_default'); ?></th>
					<th class="col-xs-1"><?php _e('sln_enabled'); ?></th>
					<th class="col-xs-3 text-right"><?php _e('action'); ?></th>
				</tr>
			</thead>
		<?php if ($languages): ?>
			<tbody>
			<?php foreach ($languages as $folder => $lang): ?>
				<tr id="lang-<?php echo $folder; ?>">
					<?php if (true === $lang['available']): ?>
					<td><?php echo $lang['name_en']; ?>&nbsp;<small class="text-muted"><?php echo $lang['name']; ?></small></td>
					<?php else: ?>
					<td><del title="<?php _e('sln_language_missing_folder'); ?>" class="text-danger"><?php echo $lang['name_en']; ?>&nbsp;<small class="text-muted"><?php echo $lang['name']; ?></small></del></td>
					<?php endif; ?>
					<td><?php echo $lang['code']; ?>&nbsp;<small class="text-muted"><?php echo $lang['locale']; ?></small></td>
					<td><?php echo $folder; ?></td>
					<td><?php echo label_condition($folder === $language); ?></td>
					<td><?php echo label_condition(in_array($folder, $available_languages)); ?></td>
					<td class="text-right">
						<?php if ($folder <> $language): ?>
						<!-- Make default action -->
						<a href="#" ajaxify="<?php echo safe_ajax_url('language/make_default/'.$folder, 'default_language_'.$folder); ?>" data-lang="<?php echo $folder; ?>" class="btn btn-xs btn-default lang-default"><?php _e('sln_make_default'); ?></a>&nbsp;
						<?php endif; ?>
						<?php if (null !== $lang['action']): ?>
							<a href="#" ajaxify="<?php echo safe_ajax_url("language/{$lang['action']}/{$folder}", $lang['action'].'_language_'.$folder); ?>" data-lang="<?php echo $folder; ?>" class="btn btn-xs <?php echo ('enable' == $lang['action']) ? 'btn-success lang-enable' : 'btn-danger lang-disable'; ?>"><?php _e($lang['action']); ?></a>&nbsp;
						<?php endif; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		<?php endif; ?>
		</table>
	</div>
</div>

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
 * Language Module - Admin
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	1.3.3
 * @version 	2.0.0
 */
?>
	<p class="mb-3"><?php _e('sln_manage_languages_tip'); ?></p>
	<div class="table-responsive-sm">
		<table class="table table-striped table-hover table-sm">
			<thead>
				<tr>
					<th class="w-25"><?php _e('language'); ?></th>
					<th class="w-15"><?php _e('sln_abbreviation'); ?></th>
					<th class="w-15"><?php _e('sln_folder'); ?></th>
					<th class="w-10"><?php _e('sln_is_default'); ?></th>
					<th class="w-10"><?php _e('sln_enabled'); ?></th>
					<th class="w-25 text-right"><?php _e('action'); ?></th>
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
					<?php
					/**
					 * Make sure language default.
					 * @since 	1.0.0
					 */
					if ($folder !== $language) {
						echo html_tag('a', array(
							'href'      => nonce_ajax_url('language/make_default/'.$folder, 'default-language-'.$folder),
							'data-lang' => $folder,
							'class'     => 'mr-2 btn btn-default btn-xs lang-default',
						), line('sln_make_default'));
					}

					/**
					 * Enabled/Disable action.
					 * @since 	1.0.0
					 */
					if (null !== $lang['action']) {
						echo html_tag('a', array(
							'href'      => nonce_ajax_url("language/{$lang['action']}/{$folder}", $lang['action'].'-language_'.$folder),
							'data-lang' => $folder,
							'class'     => 'btn btn-xs btn-'.$lang['action'].' btn-'.('enable' === $lang['action'] ? 'success' : 'danger'),
						), line($lang['action']));
					}
					?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		<?php endif; ?>
		</table>
	</div>
</div>

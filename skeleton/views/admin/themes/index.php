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
 * Themes Module - List Themes.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.0.0
 */

$theme_item_temp =<<<EOT
<div class="col-sm-6 col-md-4 theme-item" id="theme-{folder}" data-name="{name}">
	<div class="card theme-inner">
		<img src="{screenshot}" alt="{name}" class="theme-screenshot img-fluid" />
		<div class="theme-caption clearfix p-2">
			<h3 class="theme-title m-0">{name}<span class="theme-action pull-right">{actions}</span></h3>
		</div>
	</div>
</div>
EOT;

if ($themes)
{
	echo '<div class="row" id="themes-list">';
	foreach ($themes as $folder => $t) {
		$t['actions'] = implode('', $t['actions']);
		echo str_replace(
			array('{folder}', '{name}', '{screenshot}', '{actions}'),
			array($folder, $t['name'], $t['screenshot'], $t['actions']),
			$theme_item_temp
		);
	}
	echo '</div>';
}

echo '<div id="theme-details">';
if (isset($theme) && null !== $theme): ?>
<div class="modal fade" tabindex="-1" role="dialog" id="theme-modal" tabindex="-1">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header clearfix">
				<h2 class="modal-title"><?php printf(lang('CSK_THEMES_THEME_DETAILS_NAME'), $theme['name']); ?></h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-md-7">
						<img src="<?php echo $theme['screenshot']; ?>" alt="<?php echo $theme['name']; ?>" class="img-fluid" data-action="zoom">
					</div>
					<div class="col-sm-12 col-md-5">
						<h2 class="page-header clearfix"><?php echo $theme['name_uri']; ?> <small class="text-muted"><?php echo $theme['version']; ?></small><small class="pull-right"><?php echo label_condition($theme['enabled'], 'lang:CSK_ADMIN_ACTIVE', ''); ?></small></h2>
						<p><?php echo $theme['description']; ?></p><br />
						<div class="table-responsive-sm">
							<table class="table table-sm table-condensed table-striped">
								<tr><th class="w-35"><?php _e('CSK_THEMES_AUTHOR'); ?></th><td><?php echo $theme['author']; ?></td></tr>
								<?php if ($theme['author_email']): ?>
								<tr><th><?php _e('CSK_THEMES_AUTHOR_EMAIL'); ?></th><td><?php echo $theme['author_email']; ?></td></tr>
								<?php endif; ?>
								<tr><th><?php _e('CSK_THEMES_LICENSE'); ?></th><td><?php echo $theme['license']; ?></td></tr>
								<tr><th><?php _e('CSK_THEMES_TAGS'); ?></th><td><?php echo $theme['tags']; ?></td></tr>
							</table>
						</div>
						<?php if (true !== $theme['enabled']): ?>
						<p class="clearfix"><?php echo $theme['action_activate'], $theme['action_delete']; ?></p>
					<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif;
echo '</div>';

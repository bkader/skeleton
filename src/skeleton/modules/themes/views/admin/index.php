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
 * Themes Module - List Themes.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.3.2
 */
?><h2 class="page-header clearfix">
	<?php _e('theme_settings') ?>
	<span class="pull-right"><?php echo admin_anchor('themes/add', lang('add_theme'), 'class="btn btn-primary btn-sm"'); ?></span>
</h2>

<?php if ($themes): ?>
<div class="row">
<?php foreach ($themes as $theme): ?>
	<div class="col-sm-6 col-md-4" id="theme-<?php echo $theme['folder'] ?>">
		<div class="thumbnail">
			<img src="<?php echo $theme['screenshot'] ?>" alt="<?php echo $theme['name'] ?>" class="img-responsive" data-action="zoom">
			<div class="caption">
				<h3><a href="<?php echo $theme['theme_uri'] ?>"><?php echo $theme['name'] ?></a> <?php echo $theme['enabled'] ? '<small>('.lang('active').')</small>' : '' ?></h3>
				<p><?php echo $theme['description'] ?></p><br>
				<table class="table table-condensed table-striped mb0">
					<tr><th class="col-xs-5"><?php _e('author'); ?></th><td><a href="<?php echo $theme['author_uri'] ?>" target="_blank"><?php echo $theme['author'] ?></a></td></tr>
					<tr><th><?php _e('author_email'); ?></th><td><a href="mailto:<?php echo $theme['author_email'] ?>" target="_blank"><?php echo $theme['author_email'] ?></a></td></tr>
					<tr><th><?php _e('version') ?></th><td><?php echo $theme['version'] ?></td></tr>
					<tr><th><?php _e('license') ?></th><td><a href="<?php echo $theme['license_uri'] ?>" target="_blank"><?php echo $theme['license'] ?></a></td></tr>
					<tr><th><?php _e('tags') ?></th><td><small><?php echo $theme['tags'] ?></small></td></tr>
				</table>
			<?php if ($theme['folder'] <> get_option('theme')): ?><br>
				<?php echo safe_admin_anchor("themes/activate/{$theme['folder']}", lang('enable'), 'class="btn btn-primary btn-block"') ?>
			<?php endif; ?>
			</div>
		</div>
	</div>
<?php endforeach; ?>
</div>
<?php endif; ?>

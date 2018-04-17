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
 * Themes Module - List Themes.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.3.4
 */
?><h2 class="page-header clearfix"><?php

// Page header.
_e('sth_theme_settings');

// Add theme anchor.
echo admin_anchor('themes/install', lang('sth_theme_add'), 'class="btn btn-primary btn-sm pull-right"');

?></h2>
<?php if ($themes): ?>
<div class="row">
<?php foreach ($themes as $t): ?>
	<div class="col-sm-6 col-md-4" id="theme-<?php echo $t['folder'] ?>">
		<div class="theme-item thumbnail">
			<img src="<?php echo $t['screenshot'] ?>" alt="<?php echo $t['name'] ?>" class="theme-screenshot img-responsive">
			<div class="theme-caption caption clearfix">
				<h4 class="theme-title"><?php echo $t['name']; ?><span class="theme-actions pull-right"><?php

// Activate button.
if (true !== $t['enabled'])
{
	echo safe_ajax_anchor(
		'themes/activate/'.$t['folder'],
		lang('sth_theme_activate'),
		'class="theme-activate btn btn-default btn-sm"'
	).'&nbsp;';
}

// Details anchor.
echo admin_anchor(
	'themes/?theme='.$t['folder'],
	lang('sth_theme_details'),
	'class="theme-details btn btn-primary btn-sm"'
);
				?></span></h4>
			</div><!--/.caption-->
		</div><!--thumbnail-->
	</div><!--/.column-->
<?php endforeach; ?>
</div>
<?php endif; ?>
<div id="theme-modal-container">
	<?php if (null !== $theme): ?>
	<div class="modal fade" tabindex="-1" role="dialog" id="theme-modal" tabindex="-1">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header clearfix">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fa fa-times"></i></span></button>
					<h4 class="modal-title"><?php printf(lang('sth_details_name'), $theme['name']); ?></h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12 col-md-7">
							<img src="<?php echo $theme['screenshot']; ?>" alt="<?php echo $theme['name']; ?>">
						</div>
						<div class="col-sm-12 col-md-5">
							<h2 class="page-header clearfix"><?php echo $theme['name_uri']; ?> <small class="text-muted"><?php echo $theme['version']; ?></small><small class="pull-right"><?php echo label_condition($theme['enabled'], 'lang:active', ''); ?></small></h2>
							<p><?php echo $theme['description']; ?></p><br />
							<table class="table table-condensed table-striped">
								<tr><th><?php _e('sth_author'); ?></th><td><?php echo $theme['author']; ?></td></tr>
								<?php if ($theme['author_email']): ?>
								<tr><th><?php _e('sth_author_email'); ?></th><td><small><?php echo $theme['author_email']; ?></small></td></tr>
								<?php endif; ?>
								<tr><th><?php _e('sth_license'); ?></th><td><?php echo $theme['license']; ?></td></tr>
								<tr><th><?php _e('sth_tags'); ?></th><td><small><?php echo $theme['tags']; ?></small></td></tr>
							</table>
							<?php if (true !== $theme['enabled']): ?>
							<p class="clearfix">
								<a href="<?php echo safe_ajax_url('themes/activate/'.$theme['folder']); ?>" class="theme-activate btn btn-primary btn-sm" data-theme="<?php echo $theme['folder']; ?>"><?php _e('sth_theme_activate'); ?></a>
								<a href="<?php echo safe_ajax_url('themes/delete/'.$theme['folder']); ?>" class="theme-delete btn btn-danger btn-sm pull-right" data-theme="<?php echo $theme['folder']; ?>"><?php _e('sth_theme_delete'); ?></a></p>
						<?php endif; ?>
						</div>
					</div><!--/.row-->
				</div><!--/modal-body-->
			</div><!--/.modal-content-->
		</div><!--/.modal-dialog-->
	</div><!--/.modal-->
	<?php endif; ?>
</div><!--/#theme-modal-container-->

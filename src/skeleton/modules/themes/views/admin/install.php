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
 * @since 		1.3.4
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Themes Module - Install Themes
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.3.4
 * @version 	1.4.0
 */
?><h2 class="page-header clearfix"><?php _e('sth_theme_add'); ?><span class="pull-right"><?php echo admin_anchor('themes', 'lang:back', 'class="btn btn-default btn-sm"'); ?> <button role="button" class="btn btn-primary btn-sm" data-toggle="collapse" data-target="#theme-install"><?php _e('sth_theme_upload'); ?></button></span></h2>
<div class="row<?php if ( ! form_error('themezip')): ?> collapse<?php endif; ?>" id="theme-install">
	<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 text-center">
		<p><?php _e('sth_theme_upload_tip'); ?></p><br>
		<div class="well">
			<?php echo form_open_multipart(
				'admin/themes/upload',
				array( // Attributes.
					'class' => 'form-inline'.(has_error('themezip') ? ' has_error' : ''),
					'id' => 'theme-upload',
				)
			); ?>
			<?php echo form_nonce('theme_upload'); ?>
				<div class="form-group"><?php echo form_upload('themezip', null, 'id="themezip"'); ?></div><?php
				echo form_error('themezip', '<div class="help-block">', '</div>');
				?><button type="submit" name="theme-install" class="btn btn-primary btn-sm theme-install"><?php _e('sth_theme_install'); ?></button>
			</form>
		</div>
	</div>
</div>
<nav class="navbar navbar-default" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<p class="navbar-text"><span class="badge">0</span></p>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav">
			<li><a href="#" data-sort="featured"><?php _e('sth_theme_featured'); ?></a></li>
			<li><a href="#" data-sort="popular"><?php _e('sth_theme_popular'); ?></a></li>
			<li><a href="#" data-sort="new"><?php _e('sth_theme_new'); ?></a></li>
		</ul>
		<div class="navbar-right">
			<form class="navbar-form navbar-left" role="search" action="javascript:void(0)">
				<div class="form-group">
					<input type="text" class="form-control" placeholder="<?php _e('sth_theme_search'); ?>">
				</div>
			</form>
		</div>
	</div><!-- /.navbar-collapse -->
</nav>
<div class="alert alert-info"><strong>NOTE</strong>: This section will be developed soon.</div>
<div id="theme-modal-container"></div>

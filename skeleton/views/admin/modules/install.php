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
 * @since 		1.3.4
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Plugins Module - Install Plugins
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.3.4
 * @version 	1.3.4
 */
?>
<div class="row<?php if ( ! form_error('pluginzip')): ?> -collapse<?php endif; ?> justify-content-md-center" id="plugin-install">
	<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 text-center">
		<p><?php _e('spg_plugin_upload_tip'); ?></p><br>
		<div class="card">
			<div class="card-body text-center">
				<?php
				echo form_open_multipart(
					'admin/plugins/upload',
					'class="form-inline'.(form_error('pluginzip') ? ' has-error' : '').'" id="plugin-upload"',
					$hidden),
				form_upload('pluginzip', null, 'id="pluginzip"'),
				form_error('pluginzip', '<div class="help-block">', '</div>'),
				form_submit('plugin-install', line('spg_plugin_install'), array(
					'class' => 'btn btn-primary btn-sm'
				));
				?>
				</form>
			</div>
		</div>
	</div>
</div>
<nav class="navbar navbar-default" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<p class="navbar-text"><span class="badge">0</span></p>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav">
			<li><a href="#" data-sort="featured"><?php _e('spg_featured'); ?></a></li>
			<li><a href="#" data-sort="recommended"><?php _e('spg_recommended'); ?></a></li>
			<li><a href="#" data-sort="popular"><?php _e('spg_popular'); ?></a></li>
			<li><a href="#" data-sort="new"><?php _e('spg_new'); ?></a></li>
		</ul>
		<div class="navbar-right">
			<form class="navbar-form navbar-left" role="search" method="get">
				<div class="form-group">
					<select name="type" id="type" class="form-control">
						<option value="name" selected="selected"><?php _e('spg_name'); ?></option>
						<option value="tags"><?php _e('spg_tags'); ?></option>
						<option value="author"><?php _e('spg_author'); ?></option>
					</select>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" id="search" name="search" placeholder="<?php _e('spg_search'); ?>">
				</div>
			</form>
		</div>
	</div><!-- /.navbar-collapse -->
</nav>
<div class="alert alert-info"><strong>NOTE</strong>: This section will be developed soon.</div>
<div id="plugin-modal-container"></div>

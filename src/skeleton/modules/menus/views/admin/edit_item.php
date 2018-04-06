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
 * Menus module - Admin: edit menu item.
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
?><h2 class="page-header"><?php _e('edit_item'); ?></h2>
<div class="row">
	<div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading clearfix text-right">
				<a href="#advanced" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="advanced"><?php _e('advanced'); ?></a>
			</div>
			<div class="panel-body">
				<?php echo form_open('admin/menus/edit/item/'.$item->id, 'role="form"', $hidden); ?>

					<div class="form-group<?php echo form_error('name') ? ' has-error' : ''; ?>">
						<label for="name" class="sr-only"><?php _e('item_title'); ?></label>
						<?php echo print_input($title, array('class' => 'form-control', 'value' => htmlspecialchars_decode($item->name), 'autofocus' => 'autofocus')); ?>
						<?php echo form_error('name', '<p class="help-block">', '</p>') ?: '<p class="help-block">'.lang('item_title_tip').'</p>' ?>
					</div>

					<div class="form-group<?php echo form_error('href') ? ' has-error' : ''; ?>">
						<label for="href" class="sr-only"><?php _e('item_title'); ?></label>
						<?php echo print_input($href, array('class' => 'form-control', 'value' => $item->content)); ?>
						<?php echo form_error('href', '<p class="help-block">', '</p>') ?: '<p class="help-block">'.lang('item_href_tip').'</p>' ?>
					</div>

					<div class="collapse" id="advanced">
						<!-- Title attribute -->
						<div class="form-group">
							<label for="attrs_title" class="sr-only"><?php _e('title_attr'); ?></label>
							<input type="text" name="attrs[title]" id="attrs_title" placeholder="<?php _e('title_attr'); ?>" value="<?php echo set_value('attrs["title"]', @$item->attributes['title']); ?>" class="form-control input-sm">
						</div>
						<!-- CSS Classes -->
						<div class="form-group">
							<label for="attrs_class" class="sr-only"><?php _e('css_classes'); ?></label>
							<input type="text" name="attrs[class]" id="attrs_class" placeholder="<?php _e('css_classes'); ?>" value="<?php echo set_value('attrs["css_classes"]', @$item->attributes['class']); ?>" class="form-control input-sm">
						</div>
						<!-- CSS Classes -->
						<div class="form-group">
							<label for="attrs_rel" class="sr-only"><?php _e('link_relation'); ?></label>
							<input type="text" name="attrs[rel]" id="attrs_rel" placeholder="<?php _e('link_relation'); ?>" value="<?php echo set_value('attrs["rel"]', @$item->attributes['rel']); ?>" class="form-control input-sm">
						</div>
						<!-- Link target -->
						<div class="form-group">
							<label class="text-small text-normal"><input type="checkbox" name="attrs[target]" id="attrs_target" value="1" <?php echo set_checkbox('attrs_target', '1', isset($item->attributes['target'])); ?>>&nbsp;<?php _e('link_target_tip'); ?></label>
						</div>
					</div>

					<div class="form-group<?php echo form_error('description') ? ' has-error' : ''; ?>">
						<label for="description" class="sr-only"><?php _e('item_title'); ?></label>
						<?php echo print_input($description, array('class' => 'form-control', 'rows' => 2, 'value' => $item->description)); ?>
						<?php echo form_error('description', '<p class="help-block">', '</p>') ?: '<p class="help-block">'.lang('item_description_tip').'</p>' ?>
					</div>

					<button type="submit" class="btn btn-primary btn-sm pull-right"><?php _e('save_item'); ?></button>
					<?php echo anchor('admin/menus/items/'.$item->owner_id, lang('cancel'), 'class="btn btn-default btn-sm"'); ?>

				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

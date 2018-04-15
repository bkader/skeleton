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
 * Menus module - Admin: list menu items.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.3.3
 */
?><h2 class="page-header clearfix"><?php

// Page header.
printf(lang('smn_menu_items_name'), $menu->name);

// Manage menus anchor.
echo admin_anchor('menus', lang('smn_manage_menus'), 'class="btn btn-default btn-sm pull-right"');

?></h2>
<div class="row">
	<div class="col-sm-12 col-md-9 col-md-push-3">
		<?php echo form_open('admin/menus/update/'.$menu->id, 'class="panel panel-default"'); ?>
			<div class="panel-body">
				<h4 class="clearfix">
					<?php _e('smn_menu_structure'); ?> &nbsp;<small><?php _e('smn_menu_structure_tip'); ?></small>
					<span class="pull-right">
						<button type="submit" class="btn btn-primary btn-sm"><?php _e('smn_save_menu'); ?></button>
					</span>
				</h4>
			<?php if ($items): ?>
				<div class="menu-order" id="menu-order">
					<?php foreach ($items as $item): ?>
					<div class="menu-item" id="menu-item-<?php echo $item->id; ?>" data-item-id="<?php echo $item->id; ?>">
						<div class="menu-item-bar">
							<span class="menu-item-title"><?php echo $item->name; ?></span>
							<span class="menu-item-controls">
								<a href="#" class="item-edit" data-toggle="collapse" data-target="#menu-item-settings-<?php echo $item->id; ?>" title="<?php _e('smn_edit_item'); ?>"><i class="fa fa-edit"></i></a>
								<a href="<?php echo safe_ajax_url('menus/delete/item/'.$item->id); ?>" data-item-id="<?php echo $item->id; ?>" class="item-delete" title="<?php _e('smn_delete_item'); ?>" tabindex="-1"><i class="fa fa-trash-o"></i></a>
							</span>
						</div>
						<div class="menu-item-settings collapse" id="menu-item-settings-<?php echo $item->id; ?>">
							<div class="form-group">
								<label for="menu-item-url-<?php echo $item->id; ?>"><?php _e('smn_item_url'); ?></label>
								<input type="text" name="menu-item[<?php echo $item->id; ?>][content]" id="menu-item-url-<?php echo $item->id; ?>" class="form-control input-sm" value="<?php echo $item->content; ?>">
							</div>
							<div class="form-group">
								<label for="menu-item-title-<?php echo $item->id; ?>"><?php _e('smn_item_title'); ?></label>
								<input type="text" name="menu-item[<?php echo $item->id; ?>][name]" id="menu-item-title-<?php echo $item->id; ?>" class="form-control input-sm" value="<?php echo $item->name; ?>">
							</div>
							<div class="collapse" id="menu-item-advanced-<?php echo $item->id; ?>" >
								<div class="form-group">
									<label for="menu-item-attrs-title-<?php echo $item->id; ?>"><?php _e('smn_item_attribute_title'); ?></label>
									<input type="text" name="menu-item[<?php echo $item->id; ?>][attributes][title]" id="menu-item-attrs-title-<?php echo $item->id; ?>" placeholder="<?php _e('smn_item_attribute_title'); ?>" value="<?php echo @$item->attributes['title']; ?>" class="form-control input-sm input-sm">
								</div>
								<div class="form-group">
									<label for="menu-item-attrs-class-<?php echo $item->id; ?>"><?php _e('smn_item_attribute_class'); ?></label>
									<input type="text" name="menu-item[<?php echo $item->id; ?>][attributes][class]" id="menu-item-attrs-class-<?php echo $item->id; ?>" placeholder="<?php _e('smn_item_attribute_class'); ?>" value="<?php echo @$item->attributes['class']; ?>" class="form-control input-sm input-sm">
								</div>
								<div class="form-group">
									<label for="menu-item-attrs-rel-<?php echo $item->id; ?>"><?php _e('smn_item_attribute_rel'); ?></label>
									<input type="text" name="menu-item[<?php echo $item->id; ?>][attributes][rel]" id="menu-item-attrs-rel-<?php echo $item->id; ?>" placeholder="<?php _e('smn_item_attribute_rel'); ?>" value="<?php echo @$item->attributes['rel']; ?>" class="form-control input-sm input-sm">
								</div>
								<div class="form-group">
									<label class="text-small text-normal"><input type="checkbox" name="menu-item[<?php echo $item->id; ?>][attributes][target]" value="1">&nbsp;<?php _e('smn_item_attribute_target') ?></label>
								</div>
							</div>
							<div class="form-group">
								<label for="menu-item-description-<?php echo $item->id; ?>"><?php _e('smn_item_description'); ?></label>
								<textarea type="text" name="menu-item[<?php echo $item->id; ?>][description]" id="menu-item-description-<?php echo $item->id; ?>" class="form-control input-sm"><?php echo $item->description; ?></textarea>
								<div class="help-block"><?php _e('smn_item_description_tip'); ?></div>
							</div>
							<input type="hidden" class="hidden" hidden="hidden" id="order-menu-item-<?php echo $item->id; ?>" value="<?php echo $item->order; ?>" name="menu-item[<?php echo $item->id; ?>][order]">
							<div class="form-group">
								<a href="#" data-toggle="collapse" data-target="#menu-item-advanced-<?php echo $item->id; ?>" class="btn btn-default btn-sm pull-right"><?php _e('advanced'); ?></a>
								</span>
								<a href="<?php echo safe_ajax_url('menus/delete/item/'.$item->id); ?>" data-item-id="<?php echo $item->id; ?>" class="btn btn-danger btn-sm item-delete" tabindex="-1"><?php _e('delete'); ?></a>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
				<div class="form-group text-right">
					<button type="submit" class="btn btn-primary btn-sm"><?php _e('smn_save_menu'); ?></button>
				</div>
			<?php endif; ?>
			</div>
		</form>
	</div>
	<div class="col-sm-12 col-md-3 col-md-pull-9">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">
					<?php _e('smn_add_item'); ?>
					<small class="pull-right">
						<a href="#advanced" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="advanced"><?php _e('advanced'); ?></a>
					</small>
				</div>
			</div>
			<div class="panel-body">
				<?php echo form_open('admin/menus/items/'.$menu->id, 'role="form"', $hidden); ?>
					<div class="form-group<?php echo form_error('name') ? ' has-error' : ''; ?>">
						<label for="name" class="sr-only"><?php _e('smn_item_title'); ?></label>
						<?php echo print_input($title, array('class' => 'form-control input-sm')); ?>
						<?php echo form_error('name', '<p class="help-block">', '</p>') ?: '<p class="help-block">'.lang('smn_item_title_tip').'</p>' ?>
					</div>
					<div class="form-group<?php echo form_error('href') ? ' has-error' : ''; ?>">
						<label for="href" class="sr-only"><?php _e('smn_item_title'); ?></label>
						<?php echo print_input($href, array('class' => 'form-control input-sm')); ?>
						<?php echo form_error('href', '<p class="help-block">', '</p>') ?: '<p class="help-block">'.lang('smn_item_url_tip').'</p>' ?>
					</div>
					<div class="collapse" id="advanced">
						<div class="form-group">
							<label for="attrs_title" class="sr-only"><?php _e('smn_item_attribute_title'); ?></label>
							<input type="text" name="attrs[title]" id="attrs_title" placeholder="<?php _e('smn_item_attribute_title'); ?>" value="<?php echo set_value('attrs["title"]'); ?>" class="form-control input-sm">
						</div>
						<div class="form-group">
							<label for="attrs_class" class="sr-only"><?php _e('smn_item_attribute_class'); ?></label>
							<input type="text" name="attrs[class]" id="attrs_class" placeholder="<?php _e('smn_item_attribute_class'); ?>" value="<?php echo set_value('attrs["css_classes"]'); ?>" class="form-control input-sm">
						</div>
						<div class="form-group">
							<label for="attrs_rel" class="sr-only"><?php _e('smn_item_attribute_rel'); ?></label>
							<input type="text" name="attrs[rel]" id="attrs_rel" placeholder="<?php _e('smn_item_attribute_rel'); ?>" value="<?php echo set_value('attrs["rel"]'); ?>" class="form-control input-sm">
						</div>
						<div class="form-group">
							<label class="text-small text-normal"><input type="checkbox" name="attrs[target]" id="attrs_target" value="1" <?php echo set_checkbox('attrs_target', '1', false); ?>>&nbsp;<?php _e('smn_item_attribute_target'); ?></label>
						</div>
					</div>
					<div class="form-group<?php echo form_error('description') ? ' has-error' : ''; ?>">
						<label for="description" class="sr-only"><?php _e('smn_item_title'); ?></label>
						<?php echo print_input($description, array('class' => 'form-control input-sm', 'rows' => 2)); ?>
						<?php echo form_error('description', '<p class="help-block">', '</p>') ?: '<p class="help-block">'.lang('smn_item_description_tip').'</p>' ?>
					</div>
					<button type="submit" class="btn btn-primary btn-block btn-sm"><?php _e('smn_add_item'); ?></button>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

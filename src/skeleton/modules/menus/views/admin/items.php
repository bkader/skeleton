<h2 class="page-header">
	<?php _e('menu_items'); ?>: <?php echo $menu->name; ?>
	<span class="pull-right"><?php echo admin_anchor('menus', lang('manage_menus'), 'class="btn btn-default btn-sm"'); ?></span>
</h2>

<div class="row">
	<!-- Menus items -->
	<div class="col-sm-12 col-md-9 col-md-push-3">

		<div class="panel panel-default">
			<div class="panel-body">
			<h4><?php _e('menu_structure'); ?> &nbsp;<small><?php _e('menu_structure_tip'); ?></small><span class="pull-right"><button class="btn btn-primary btn-sm" id="save-menu"><?php _e('save_menu'); ?></button></span></h4><br />
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th class="col-md-3"><?php _e('title') ?></th>
							<th class="col-md-6"><?php _e('description') ?></th>
							<th class="col-md-3 text-right"><?php _e('action') ?></th>
						</tr>
					</thead>
				<?php if ($items): ?>
					<tbody id="sortable">
				<?php foreach ($items as $item): ?>
						<tr id="item-<?php echo $item->id; ?>">
							<td><?php echo htmlspecialchars_decode($item->title) ?><br><small><em><?php echo anchor($item->href, null, 'target="_blank"') ?></em></small></td>
							<td><?php echo $item->description ?></td>
							<td class="text-right">
								<a class="btn btn-default btn-xs" href="<?php echo admin_url('menus/edit/item/'.$item->id) ?>" title="<?php _e('edit_menu') ?>"><i class="fa fa-edit"></i></a>&nbsp;
								<a class="btn btn-danger btn-xs" href="#" data-confirm="<?php printf(line('are_you_sure'), line('delete_item')) ?>" data-href="<?php echo safe_admin_url('menus/delete/item/'.$item->id) ?>" title="<?php _e('delete_item') ?>"><i class="fa fa-times"></i></a>
							</td>
						</tr>
				<?php endforeach; ?>
					</tbody>
				<?php endif; ?>
				</table>
			</div>
		</div>
	</div>
	<!-- Add items. -->
	<div class="col-sm-12 col-md-3 col-md-pull-9">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">
					<?php _e('add_item'); ?>
					<small class="pull-right">
						<a href="#advanced" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="advanced"><?php _e('advanced'); ?></a>
					</small>
				</div>
			</div>
			<div class="panel-body">
				<?php echo form_open('admin/menus/items/'.$menu->id, 'role="form"', $hidden); ?>

					<div class="form-group<?php echo form_error('name') ? ' has-error' : ''; ?>">
						<label for="name" class="sr-only"><?php _e('item_title'); ?></label>
						<?php echo print_input($title, array('class' => 'form-control input-sm')); ?>
						<?php echo form_error('name', '<p class="help-block">', '</p>') ?: '<p class="help-block">'.lang('item_title_tip').'</p>' ?>
					</div>

					<div class="form-group<?php echo form_error('href') ? ' has-error' : ''; ?>">
						<label for="href" class="sr-only"><?php _e('item_title'); ?></label>
						<?php echo print_input($href, array('class' => 'form-control input-sm')); ?>
						<?php echo form_error('href', '<p class="help-block">', '</p>') ?: '<p class="help-block">'.lang('item_href_tip').'</p>' ?>
					</div>

					<div class="collapse" id="advanced">
						<!-- Title attribute -->
						<div class="form-group">
							<label for="attrs_title" class="sr-only"><?php _e('title_attr'); ?></label>
							<input type="text" name="attrs[title]" id="attrs_title" placeholder="<?php _e('title_attr'); ?>" value="<?php echo set_value('attrs["title"]'); ?>" class="form-control input-sm">
						</div>
						<!-- CSS Classes -->
						<div class="form-group">
							<label for="attrs_class" class="sr-only"><?php _e('css_classes'); ?></label>
							<input type="text" name="attrs[class]" id="attrs_class" placeholder="<?php _e('css_classes'); ?>" value="<?php echo set_value('attrs["css_classes"]'); ?>" class="form-control input-sm">
						</div>
						<!-- Rel attribute -->
						<div class="form-group">
							<label for="attrs_rel" class="sr-only"><?php _e('link_relation'); ?></label>
							<input type="text" name="attrs[rel]" id="attrs_rel" placeholder="<?php _e('link_relation'); ?>" value="<?php echo set_value('attrs["rel"]'); ?>" class="form-control input-sm">
						</div>
						<!-- Link target -->
						<div class="form-group">
							<label class="text-small text-normal"><input type="checkbox" name="attrs[target]" id="attrs_target" value="1" <?php echo set_checkbox('attrs_target', '1', false); ?>>&nbsp;<?php _e('link_target_tip'); ?></label>
						</div>
					</div>

					<div class="form-group<?php echo form_error('description') ? ' has-error' : ''; ?>">
						<label for="description" class="sr-only"><?php _e('item_title'); ?></label>
						<?php echo print_input($description, array('class' => 'form-control input-sm', 'rows' => 2)); ?>
						<?php echo form_error('description', '<p class="help-block">', '</p>') ?: '<p class="help-block">'.lang('item_description_tip').'</p>' ?>
					</div>

					<button type="submit" class="btn btn-primary btn-block btn-sm"><?php _e('add_item'); ?></button>

				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>


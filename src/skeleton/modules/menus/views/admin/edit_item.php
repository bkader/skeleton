<h3 class="page-header"><?php _e('edit_item'); ?></h3>

<div class="row">
	<div class="col-sm-12 col-md-4 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title">
					<?php _e('edit_item'); ?>
					<small class="pull-right">
						<a href="#advanced" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="advanced"><?php _e('advanced'); ?></a>
					</small>
				</div>
			</div>
			<div class="panel-body">
				<?php echo form_open('admin/menus/edit/item/'.$item->id, 'role="form"', $hidden); ?>

					<div class="form-group<?php echo form_error('name') ? ' has-error' : ''; ?>">
						<label for="name" class="sr-only"><?php _e('item_title'); ?></label>
						<?php echo print_input($title, array('class' => 'form-control', 'value' => htmlspecialchars_decode($item->title), 'autofocus' => 'autofocus')); ?>
						<?php echo form_error('name', '<p class="help-block">', '</p>') ?: '<p class="help-block">'.lang('item_title_tip').'</p>' ?>
					</div>

					<div class="form-group<?php echo form_error('href') ? ' has-error' : ''; ?>">
						<label for="href" class="sr-only"><?php _e('item_title'); ?></label>
						<?php echo print_input($href, array('class' => 'form-control', 'value' => $item->href)); ?>
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
					</div>

					<div class="form-group<?php echo form_error('description') ? ' has-error' : ''; ?>">
						<label for="description" class="sr-only"><?php _e('item_title'); ?></label>
						<?php echo print_input($description, array('class' => 'form-control', 'rows' => 2, 'value' => $item->description)); ?>
						<?php echo form_error('description', '<p class="help-block">', '</p>') ?: '<p class="help-block">'.lang('item_description_tip').'</p>' ?>
					</div>

					<button type="submit" class="btn btn-primary pull-right"><?php _e('save_item'); ?></button>
					<?php echo anchor('admin/menus/items/'.$item->menu_id, lang('cancel'), 'class="btn btn-default"'); ?>

				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

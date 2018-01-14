<h2 class="page-header"><?php _e('add_menu') ?> <?php echo admin_anchor('menus', lang('manage_menus'), 'class="btn btn-primary btn-sm pull-right"') ?></h2>

<div class="row">
	<div class="col-sm-12 col-md-4 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-body">
				<?php echo form_open('admin/menus/add', 'role="form"', $hidden); ?>

					<div class="form-group<?php echo (form_error('name')) ? ' has-error' : ''; ?>">
						<label for="name"><?php _e('menu_name'); ?></label>
						<?php echo print_input($name, array('class' => 'form-control', 'autofocus' => 'autofocus')); ?>
						<?php echo form_error('name', '<p class="help-block">', '</p>') ?: '<p class="help-block">'.lang('menu_name_tip').'</p>' ?>
					</div>

					<div class="form-group<?php echo (form_error('menu_description')) ? ' has-error' : ''; ?>">
						<label for="description"><?php _e('menu_description'); ?></label>
						<?php echo print_input($description, array('class' => 'form-control', 'rows' => 3)); ?>
						<p class="help-block"><?php _e('menu_description_tip'); ?></p>
					</div>

					<button type="submit" class="btn btn-primary btn-sm pull-right"><?php _e('add_menu'); ?></button>
					<?php echo anchor('admin/menus', lang('cancel'), 'class="btn btn-default btn-sm"'); ?>

				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>

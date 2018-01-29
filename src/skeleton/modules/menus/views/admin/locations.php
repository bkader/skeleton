<h3 class="page-header">
	<?php _e('manage_locations'); ?>
	<span class="pull-right"><?php echo admin_anchor('menus', lang('manage_menus'), 'class="btn btn-default btn-sm"'); ?></span>
</h3>

<div class="row">
	<div class="col-sm-12 col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-body">
<?php if (count($locations) > 0): ?>
					<p><?php printf(lang('theme_locations_tip'), count($locations)); ?></p>
					<br />
					<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
					<?php echo form_open('admin/menus/locations', 'role="form" class="form-horizontal"', $hidden); ?>

					<?php foreach ($locations as $slug => $location): ?>
						<div class="form-group">
							<label for="location-<?php echo $slug; ?>" class="col-sm-4 control-label"><?php echo $location; ?></label>
							<div class="col-sm-8">
								<select name="menu_location[<?php echo $slug; ?>]" id="location-<?php echo $slug; ?>" class="form-control input-sm">
									<option value="0"><?php _e('select_menu'); ?></option>
								<?php foreach ($menus as $menu): ?>
									<option value="<?php echo $menu->id; ?>"<?php if ($menu->location === $slug): ?> selected="selected"<?php endif; ?>><?php echo $menu->name; ?></option>
								<?php endforeach; unset($menu); ?>
								</select>
							</div>
						</div>
					<?php endforeach; ?>

					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-4">
							<button type="submit" class="btn btn-primary btn-sm"><?php _e('save_changes'); ?></button>
						</div>
					</div>

					<?php echo form_close(); ?>
<?php else: ?>
					<p><?php printf(lang('theme_locations_none'), count($locations)); ?></p>
<?php endif; ?>
				</div>
			</div>
	</div>
</div>

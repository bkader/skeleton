<h2 class="page-header">
	<?php _e('manage_menus'); ?>
	<span class="pull-right">
		<?php echo admin_anchor('menus/add', lang('add_menu'), 'class="btn btn-primary btn-sm"'); ?>&nbsp;<?php echo admin_anchor('menus/locations', lang('manage_locations'), 'class="btn btn-default btn-sm"'); ?>
	</span>
</h2>

<table class="table table-hover table-condensed">
	<thead>
		<tr>
			<th><?php _e('name') ?></th>
			<th><?php _e('slug') ?></th>
			<th><?php _e('description') ?></th>
			<th><?php _e('location') ?></th>
			<th class="text-right"><?php _e('action') ?></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($menus as $menu): ?>
		<tr id="menu-<?php echo $menu->id; ?>">
			<td><?php echo $menu->name ?></td>
			<td><?php echo $menu->slug ?></td>
			<td><?php echo $menu->description ?></td>
			<td><?php echo $menu->location_name ?></td>
			<td class="text-right">
				<a class="btn btn-default btn-xs" href="<?php echo admin_url('menus/edit/menu/'.$menu->id) ?>" title="<?php _e('edit_menu') ?>"><i class="fa fa-edit"></i></a>&nbsp;
				<a class="btn btn-primary btn-xs" href="<?php echo admin_url('menus/items/'.$menu->id) ?>" title="<?php _e('menu_items') ?>"><i class="fa fa-list-ul"></i></a>&nbsp;
				<a class="btn btn-danger btn-xs" onclick="return confirm('<?php _e('are_your_sure', lang('delete_menu')) ?>');" href="<?php echo safe_admin_url('menus/delete/menu/'.$menu->id) ?>" title="<?php _e('delete_menu') ?>"><i class="fa fa-times"></i></a>&nbsp;
			</td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>

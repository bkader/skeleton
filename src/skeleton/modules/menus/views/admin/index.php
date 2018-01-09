<h2 class="page-header">
	<?php _e('manage_menus'); ?>
	<span class="pull-right">
		<?php echo admin_anchor('menus/add', lang('add_menu'), 'class="btn btn-primary btn-sm"'); ?>&nbsp;<?php echo admin_anchor('menus/locations', lang('manage_locations'), 'class="btn btn-default btn-sm"'); ?>
	</span>
</h2>

<table class="table table-hover table-condensed">
	<thead>
		<tr>
			<th><?= __('name') ?></th>
			<th><?= __('slug') ?></th>
			<th><?= __('description') ?></th>
			<th><?= __('location') ?></th>
			<th class="text-right"><?= __('action') ?></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($menus as $menu): ?>
		<tr id="menu-<?php echo $menu->id; ?>">
			<td><?= $menu->name ?></td>
			<td><?= $menu->slug ?></td>
			<td><?= $menu->description ?></td>
			<td><?= $menu->location_name ?></td>
			<td class="text-right">
				<a class="btn btn-default btn-xs" href="<?= admin_url('menus/edit/menu/'.$menu->id) ?>" title="<?= __('edit_menu') ?>"><i class="fa fa-edit"></i></a>&nbsp;
				<a class="btn btn-primary btn-xs" href="<?= admin_url('menus/items/'.$menu->id) ?>" title="<?= __('menu_items') ?>"><i class="fa fa-list-ul"></i></a>&nbsp;
				<a class="btn btn-danger btn-xs" onclick="return confirm('<?= __('are_your_sure', __('delete_menu')) ?>');" href="<?= safe_admin_url('menus/delete/menu/'.$menu->id) ?>" title="<?= __('delete_menu') ?>"><i class="fa fa-times"></i></a>&nbsp;
			</td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>

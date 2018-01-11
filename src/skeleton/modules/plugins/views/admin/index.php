<h2 class="page-header"><?php _e('manage_plugins'); ?></h2>

<table class="table table-hover table-condensed">
	<thead>
		<tr>
			<th class="col-md-3"><?php _e('plugin') ?></th>
			<th class="col-md-9"><?php _e('description') ?></th>
		</tr>
	</thead>
<?php if ($plugins): ?>
	<tbody>
<?php foreach ($plugins as $plugin): ?>
		<tr>
			<td>
				<?php echo ($plugin['enabled']) ? '<strong>'.$plugin['name'].'</strong>' : $plugin['name']; ?><br /><small>
				<?php if ($plugin['enabled']): ?>
					<a href="<?php echo safe_admin_url('plugins/deactivate/'.$plugin['folder']); ?>"><?php _e('deactivate'); ?></a>&nbsp;&#124;&nbsp;
				<?php else: ?>
					<a href="<?php echo safe_admin_url('plugins/activate/'.$plugin['folder']); ?>"><?php _e('deactivate'); ?></a>&nbsp;&#124;&nbsp;
				<?php endif; ?><a class="text-danger" onclick="return confirm('<?php printf(line('are_you_sure'), line('delete_plugin')) ?>');" href="<?php echo safe_admin_url('plugins/delete/'.$plugin['folder']); ?>"><?php _e('delete'); ?></a></small>
			</td>
			<td>
				<p><?php echo $plugin['description']; ?></p>
				<small>
					<?php echo $plugin['version'] ? 'Version: '.$plugin['version']: ''; ?>&nbsp;&#124;&nbsp;<?php echo ($plugin['author_uri']) ? anchor($plugin['author_uri'], $plugin['author'], 'target="_blank" rel="nofollow"') : $plugin['author']; ?>
					<?php if ($plugin['license']): ?>&nbsp;&#124;&nbsp;License:
						<?php echo ($plugin['license_uri']) ? anchor($plugin['license_uri'], $plugin['license'], 'target="_blank" rel="nofollow"') : $plugin['license']; ?>
					<?php endif; ?>
				</small>
			</td>
		</tr>
<?php endforeach; ?>
	</tbody>
<?php endif; ?>
</table>

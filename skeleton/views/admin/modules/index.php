<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="table-responsive-md">
	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<th class="w-25"><?php _e('module') ?></th>
				<th class="w-75"><?php _e('description') ?></th>
			</tr>
		</thead>
	<?php if ($modules): ?>
		<tbody>
	<?php foreach ($modules as $folder => $module): ?>
			<tr id="module-<?php echo $folder; ?>" data-module="<?php echo $folder; ?>">
				<td>
				<?php
				echo html_tag(($module['enabled'] ? 'strong' : 'span'), array(
					'data-module' => $folder,
				), $module['name']),
				'<br />',
				implode(' &#124; ', $module['actions']);
				?>
				</td>
				<td>
				<?php
				echo '<p>', $module['description'],'</p>',
				implode(' &#124; ', $module['details']);
				?>
				</td>
			</tr>
	<?php endforeach; ?>
		</tbody>
	<?php endif; ?>
	</table>
</div>

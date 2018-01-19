<h2 class="page-header"><?php _e('manage_languages'); ?></h2>

<div class="panel panel-default">
	<div class="panel-body">
		<p class="text-muted"><?php _e('manage_languages_tip'); ?></p><br>
		<table class="table table-condensed">
			<tbody>
				<tr>
					<th><?php _e('language'); ?></th>
					<th><?php _e('abbreviation'); ?></th>
					<th><?php _e('folder'); ?></th>
					<th><?php _e('is_default'); ?></th>
					<th><?php _e('enabled'); ?></th>
					<th class="text-right"><?php _e('action'); ?></th>
				</tr>
		<?php foreach ($languages as $lang): ?>
				<tr>
					<td><?php echo $lang['name_en']; ?>&nbsp;<small class="text-muted"><?php echo $lang['name']; ?></small></td>
					<td><?php echo $lang['code']; ?>&nbsp;<small class="text-muted"><?php echo $lang['locale']; ?></small></td>
					<td><?php echo $lang['folder']; ?></td>
					<td><?php echo label_condition($lang['folder'] === $language); ?></td>
					<td><?php echo label_condition(in_array($lang['folder'], $available_languages)); ?></td>
					<td class="text-right">
						<?php if ($lang['folder'] !== $language): ?>
						<!-- Make default action -->
						<?php echo safe_admin_anchor('language/make_default/'.$lang['folder'], lang('make_default'), 'class="btn btn-default btn-xs"'); ?>&nbsp;
						<?php endif; ?>
					<?php if ($lang['folder'] !== 'english'): ?>
						<?php if ( ! in_array($lang['folder'], $available_languages)): ?>
						<?php echo safe_admin_anchor('language/enable/'.$lang['folder'], lang('enable'), 'class="btn btn-success btn-xs"'); ?>&nbsp;
						<?php else: ?>
						<?php echo safe_admin_anchor('language/disable/'.$lang['folder'], lang('disable'), 'class="btn btn-danger btn-xs"'); ?>&nbsp;
						<?php endif; ?>
					<?php endif; ?>
					</td>
				</tr>
		<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

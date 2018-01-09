<h2 class="page-header"><?= __('us_manage_users') ?> <?= admin_anchor('users/add', __('add_user'), 'class="btn btn-primary btn-sm pull-right"') ?></h2>

<table class="table table-hover table-condensed">
	<thead>
		<tr>
			<th width="20">ID</th>
			<th><?= __('full_name') ?></th>
			<th><?= __('username') ?></th>
			<th><?= __('email_address') ?></th>
			<th><?= __('role') ?></th>
			<th><?= __('status') ?></th>
			<th class="text-right"><?= __('action') ?></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($users as $user): ?>
		<tr>
			<td><?= $user->id ?></td>
			<td><i class="fa fa-<?= $user->gender ?>" title="<?= __($user->gender) ?>"></i> <?= $user->first_name, ' ', $user->last_name ?></td>
			<td><?= anchor($user->username, $user->username, 'target="_blank"') ?></td>
			<td><?= $user->email ?></td>
			<td><?= __($user->subtype) ?></td>
			<td><?= ($user->enabled == 1) ? '<span class="label label-success">'.__('active').'</span>' : '<span class="label label-danger">'.__('inactive').'</span>' ?></td>
			<td class="text-right">
				<a class="btn btn-default btn-xs" target="_blank" href="<?= site_url($user->username) ?>" title="<?= __('view_profile') ?>"><i class="fa fa-eye"></i></a>&nbsp;
				<a class="btn btn-primary btn-xs" href="<?= admin_url('users/edit/'.$user->id) ?>" title="<?= __('edit_user') ?>"><i class="fa fa-edit"></i></a>&nbsp;
				<a class="btn btn-danger btn-xs" onclick="return confirm('<?= __('are_your_sure', __('delete_user')) ?>');" href="<?= safe_admin_url('users/delete/'.$user->id) ?>" title="<?= __('delete_user') ?>"><i class="fa fa-times"></i></a>&nbsp;
			<?php if ($user->enabled == 0): ?>
				<a class="btn btn-success btn-xs" href="<?= safe_admin_url('users/activate/'.$user->id) ?>" title="<?= __('activate') ?>"><i class="fa fa-unlock-alt"></i></a>
			<?php else: ?>
				<a class="btn btn-warning btn-xs" href="<?= safe_admin_url('users/deactivate/'.$user->id) ?>" title="<?= __('deactivate') ?>"><i class="fa fa-lock"></i></a>
			<?php endif; ?>
			</td>
		</tr>
<?php endforeach; ?>
	</tbody>
</table>

<?= $pagination ?>

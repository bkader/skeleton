<h2 class="page-header"><?php _e('us_manage_users') ?> <?php echo admin_anchor('users/add', lang('add_user'), 'class="btn btn-primary btn-sm pull-right"') ?></h2>

<div class="panel panel-default">
	<div class="panel-body">
		<table class="table table-hover table-condensed">
			<thead>
				<tr>
					<th class="col-xs-1">ID</th>
					<th class="col-xs-2"><?php _e('full_name') ?></th>
					<th class="col-xs-2"><?php _e('username') ?></th>
					<th class="col-xs-3"><?php _e('email_address') ?></th>
					<th class="col-xs-1"><?php _e('role') ?></th>
					<th class="col-xs-1"><?php _e('status') ?></th>
					<th class="col-xs-2 text-right"><?php _e('action') ?></th>
				</tr>
			</thead>
			<tbody>
		<?php foreach ($users as $user): ?>
				<tr id="row-<?php echo $user->id; ?>">
					<td><?php echo $user->id ?></td>
					<td><i class="fa fa-<?php echo $user->gender ?>" title="<?php _e($user->gender) ?>"></i> <?php echo $user->first_name, ' ', $user->last_name ?></td>
					<td><?php echo anchor($user->username, $user->username, 'target="_blank"') ?></td>
					<td><?php echo $user->email ?></td>
					<td><?php _e($user->subtype) ?></td>
					<td><?php echo ($user->enabled == 1) ? '<span class="label label-success">'.lang('active').'</span>' : '<span class="label label-danger">'.lang('inactive').'</span>' ?></td>
					<td class="text-right">
						<a class="btn btn-default btn-xs" target="_blank" href="<?php echo site_url($user->username) ?>" title="<?php _e('view_profile') ?>"><i class="fa fa-eye"></i></a>&nbsp;
						<a class="btn btn-primary btn-xs" href="<?php echo admin_url('users/edit/'.$user->id) ?>" title="<?php _e('edit_user') ?>"><i class="fa fa-edit"></i></a>&nbsp;
						<a class="btn btn-danger btn-xs" href="#" data-confirm="<?php printf(line('are_you_sure'), line('delete_user')) ?>" data-href="<?php echo safe_admin_url('users/delete/'.$user->id) ?>" title="<?php _e('delete_user') ?>"><i class="fa fa-times"></i></a>&nbsp;
					<?php if ($user->enabled == 0): ?>
						<a class="btn btn-success btn-xs" href="#" rel="async" ajaxify="<?php echo safe_ajax_url('users/activate/'.$user->id) ?>" title="<?php _e('activate') ?>"><i class="fa fa-unlock-alt"></i></a>
					<?php else: ?>
						<a class="btn btn-warning btn-xs" href="#" rel="async" ajaxify="<?php echo safe_ajax_url('users/deactivate/'.$user->id) ?>" title="<?php _e('deactivate') ?>"><i class="fa fa-lock"></i></a>
					<?php endif; ?>
					</td>
				</tr>
		<?php endforeach; ?>
			</tbody>
		</table>

		<?php echo $pagination ?>
	</div>
</div>

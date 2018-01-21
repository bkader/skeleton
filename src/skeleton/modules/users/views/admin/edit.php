<h2 class="page-header"><?php _e('edit_user') ?>: <?php echo $user->username; ?> <?php echo admin_anchor('users', lang('us_manage_users'), 'class="btn btn-primary btn-sm pull-right"') ?></h2>
<?php echo print_d($this->session->all_userdata()); ?>
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-body">
				<?php echo form_open('admin/users/edit/'.$user->id, 'role="form"', $hidden) ?>
				<?php foreach ($inputs as $key => $input): ?>
					<div class="form-group<?php echo form_error($key) ? ' has-error' : '' ?>">
						<?php echo print_input($input, array('class' => 'form-control', 'autofocus' => 'autofocus')) ?>
						<?php echo form_error($key, '<small class="help-block">', '</small>')?>
					</div>
				<?php endforeach; ?>
					<div class="form-group">
						<input type="checkbox" name="enabled" id="enabled" value="1"<?php echo ($user->enabled == 1) ? ' checked="checked"' : '' ?>>&nbsp;<label for="enabled"><?php _e('active') ?></label>
						<span class="pull-right">
							<input type="checkbox" name="admin" id="admin" value="1"<?php echo ($user->admin == 1) ? ' checked="checked"' : '' ?>>&nbsp;<label for="admin"><?php _e('admin') ?></label>
						</span>
					</div>

					<button type="submit" class="btn btn-primary btn-sm btn-block"><?php _e('edit_user') ?></button>
					</fieldset>
				<?php echo form_close() ?>
			</div>
		</div>
	</div>
</div><!--/.row-->

<h2 class="page-header"><?= __('edit_user') ?>: <?php echo $user->username; ?> <?= admin_anchor('users', __('us_manage_users'), 'class="btn btn-primary btn-sm pull-right"') ?></h2>

<div class="row">
	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title"><?= __('edit_user') ?></h3></div>
			<div class="panel-body">
				<?= form_open('admin/users/edit/'.$user->id, 'role="form"', @$hidden) ?>
					<fieldset>
						<div class="form-group<?= form_error('first_name') ? ' has-error' : '' ?>">
							<label for="first_name" class="sr-only"><?= __('first_name') ?></label>
							<?= print_input($first_name, array('class' => 'form-control', 'autofocus' => 'autofocus')) ?>
							<?= form_error('first_name', '<small class="help-block">', '</small>')?>
						</div>
						<div class="form-group<?= form_error('last_name') ? ' has-error' : '' ?>">
							<label for="last_name" class="sr-only"><?= __('last_name') ?></label>
							<?= print_input($last_name, array('class' => 'form-control')) ?>
							<?= form_error('last_name', '<small class="help-block">', '</small>')?>
						</div>
						<div class="form-group<?= form_error('email') ? ' has-error' : '' ?>">
							<label for="email" class="sr-only"><?= __('email_address') ?></label>
							<?= print_input($email, array('class' => 'form-control')) ?>
							<?= form_error('email', '<small class="help-block">', '</small>')?>
						</div>
						<div class="form-group<?= form_error('username') ? ' has-error' : '' ?>">
							<label for="username" class="sr-only"><?= __('username') ?></label>
							<?= print_input($username, array('class' => 'form-control')) ?>
							<?= form_error('username', '<small class="help-block">', '</small>')?>
						</div>
						<div class="form-group<?= form_error('password') ? ' has-error' : '' ?>">
							<label for="password" class="sr-only"><?= __('password') ?></label>
							<?= print_input($password, array('class' => 'form-control')) ?>
							<?= form_error('password', '<small class="help-block">', '</small>')?>
						</div>
						<div class="form-group<?= form_error('cpassword') ? ' has-error' : '' ?>">
							<label for="cpassword" class="sr-only"><?= __('confirm_password') ?></label>
							<?= print_input($cpassword, array('class' => 'form-control')) ?>
							<?= form_error('cpassword', '<small class="help-block">', '</small>')?>
						</div>
						<div class="form-group">
							<label for="gender" class="sr-only"><?= __('gender') ?></label>
							<?= print_input($gender, array('class' => 'form-control')) ?>
						</div>
						<div class="form-group">
							<input type="checkbox" name="enabled" id="enabled" value="1"<?= ($user->enabled == 1) ? ' checked="checked"' : '' ?>>&nbsp;<label for="enabled"><?= __('active') ?></label>
							<span class="pull-right">
								<input type="checkbox" name="admin" id="admin" value="1"<?= ($user->admin == 1) ? ' checked="checked"' : '' ?>>&nbsp;<label for="admin"><?= __('admin') ?></label>
							</span>
						</div>

						<button type="submit" class="btn btn-primary btn-block"><?= __('edit_user') ?></button>
					</fieldset>
				<?= form_close() ?>
			</div>
		</div>
	</div>
</div><!--/.row-->

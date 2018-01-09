<div class="row">
	<div class="col-xs-12 col-sm-8 col-sm-push-4 col-md-9 col-md-push-3">
		<div class="panel panel-default">
			<div class="panel-heading"><h1 class="panel-title"><?= __('set_profile_heading') ?></h1></div>
			<div class="panel-body">
				<?= form_open('settings/profile', 'role="form" class="form-horizontal"', $hidden) ?>

					<!-- First name and last name fields. -->
					<div class="form-group">
						<label class="col-sm-2 control-label"><?= __('full_name') ?></label>
						<div class="col-sm-8">
							<div class="row">
								<div class="col-sm-6<?= form_error('first_name') ? ' has-error': '' ?>">
									<?= print_input($first_name, array('class' => 'form-control')) ?>
									<?= form_error('first_name', '<small class="help-block">', '</small>') ?>
								</div>
								<div class="col-sm-6<?= form_error('last_name') ? ' has-error': '' ?>">
									<?= print_input($last_name, array('class' => 'form-control')) ?>
									<?= form_error('last_name', '<small class="help-block">', '</small>') ?>
								</div>
							</div>
						</div>
					</div>

					<!-- Company field -->
					<div class="form-group<?= form_error('company') ? ' has-error': '' ?>">
						<label for="company" class="col-sm-2 control-label"><?= __('company') ?></label>
						<div class="col-sm-8">
							<?= print_input($company, array('class' => 'form-control')) ?>
							<?= form_error('company', '<small class="help-block">', '</small>') ?>
						</div>
					</div>

					<!-- Phone field -->
					<div class="form-group<?= form_error('phone') ? ' has-error': '' ?>">
						<label for="phone" class="col-sm-2 control-label"><?= __('phone') ?></label>
						<div class="col-sm-8">
							<?= print_input($phone, array('class' => 'form-control')) ?>
							<?= form_error('phone', '<small class="help-block">', '</small>') ?>
						</div>
					</div>

					<!-- Company field -->
					<div class="form-group<?= form_error('location') ? ' has-error': '' ?>">
						<label for="location" class="col-sm-2 control-label"><?= __('location') ?></label>
						<div class="col-sm-8">
							<?= print_input($location, array('class' => 'form-control')) ?>
							<?= form_error('location', '<small class="help-block">', '</small>') ?>
						</div>
					</div>

					<div class="col-sm-6 col-sm-offset-2">
						<button type="submit" class="btn btn-primary"><?= __('save_changes') ?></button>
					</div>

				<?= form_close() ?>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-4 col-sm-pull-8 col-md-3 col-md-pull-9">
		<div class="list-group">
			<?= anchor('settings/profile', __('set_profile_title'), 'class="list-group-item active"') ?>
		<?php if (get_option('use_gravatar', false) == false): ?>
			<?= anchor('settings/avatar', __('set_avatar_title'), 'class="list-group-item"') ?>
		<?php endif; ?>
			<?= anchor('settings/password', __('set_password_title'), 'class="list-group-item"') ?>
			<?= anchor('settings/email', __('set_email_title'), 'class="list-group-item"') ?>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-8 col-sm-push-4 col-md-9 col-md-push-3">
		<div class="panel panel-default">
			<div class="panel-heading"><h1 class="panel-title"><?php _e('set_profile_heading') ?></h1></div>
			<div class="panel-body">
				<?php
				echo form_open('settings/profile', 'role="form" class="form-horizontal"');
				echo form_nonce('update_settings_profile_'.$c_user->id);
				?>
					<!-- First name and last name fields. -->
					<div class="form-group">
						<label class="col-sm-2 control-label"><?php _e('full_name') ?></label>
						<div class="col-sm-8">
							<div class="row">
								<div class="col-sm-6<?php echo form_error('first_name') ? ' has-error': '' ?>">
									<?php echo print_input($first_name, array('class' => 'form-control')) ?>
									<?php echo form_error('first_name', '<small class="help-block">', '</small>') ?>
								</div>
								<div class="col-sm-6<?php echo form_error('last_name') ? ' has-error': '' ?>">
									<?php echo print_input($last_name, array('class' => 'form-control')) ?>
									<?php echo form_error('last_name', '<small class="help-block">', '</small>') ?>
								</div>
							</div>
						</div>
					</div>

					<!-- Company field -->
					<div class="form-group<?php echo form_error('company') ? ' has-error': '' ?>">
						<label for="company" class="col-sm-2 control-label"><?php _e('company') ?></label>
						<div class="col-sm-8">
							<?php echo print_input($company, array('class' => 'form-control')) ?>
							<?php echo form_error('company', '<small class="help-block">', '</small>') ?>
						</div>
					</div>

					<!-- Phone field -->
					<div class="form-group<?php echo form_error('phone') ? ' has-error': '' ?>">
						<label for="phone" class="col-sm-2 control-label"><?php _e('phone') ?></label>
						<div class="col-sm-8">
							<?php echo print_input($phone, array('class' => 'form-control')) ?>
							<?php echo form_error('phone', '<small class="help-block">', '</small>') ?>
						</div>
					</div>

					<!-- Company field -->
					<div class="form-group<?php echo form_error('location') ? ' has-error': '' ?>">
						<label for="location" class="col-sm-2 control-label"><?php _e('location') ?></label>
						<div class="col-sm-8">
							<?php echo print_input($location, array('class' => 'form-control')) ?>
							<?php echo form_error('location', '<small class="help-block">', '</small>') ?>
						</div>
					</div>

					<div class="col-sm-6 col-sm-offset-2">
						<button type="submit" class="btn btn-primary"><?php _e('CSK_BTN_SAVE_CHANGES') ?></button>
					</div>

				<?php echo form_close() ?>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-4 col-sm-pull-8 col-md-3 col-md-pull-9">
		<div class="list-group">
			<?php echo anchor('settings/profile', lang('set_profile_title'), 'class="list-group-item active"') ?>
		<?php if (get_option('use_gravatar', false) == false): ?>
			<?php echo anchor('settings/avatar', lang('set_avatar_title'), 'class="list-group-item"') ?>
		<?php endif; ?>
			<?php echo anchor('settings/password', lang('set_password_title'), 'class="list-group-item"') ?>
			<?php echo anchor('settings/email', lang('set_email_title'), 'class="list-group-item"') ?>
		</div>
	</div>
</div>

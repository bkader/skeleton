<div class="row">
	<div class="col-xs-12 col-sm-6 col-sm-push-4 col-md-9 col-md-push-3">
		<div class="panel panel-default">
			<div class="panel-heading"><h1 class="panel-title"><?php _e('set_password_title') ?></h1></div>
			<div class="panel-body">
				<?php
				echo form_open('settings/password', 'role="form" class="form-horizontal"');
				echo form_nonce('update_settings_password_'.$c_user->id);
				?>
					<!-- New password field -->
					<div class="form-group<?php echo form_error('npassword') ? ' has-error': '' ?>">
						<label for="npassword" class="col-sm-3 control-label"><?php _e('new_password') ?></label>
						<div class="col-sm-6">
							<?php echo print_input($npassword, array('class' => 'form-control', 'required')) ?>
							<?php echo form_error('npassword', '<small class="help-block">', '</small>') ?>
						</div>
					</div>

					<!-- Confirm password field -->
					<div class="form-group<?php echo form_error('cpassword') ? ' has-error': '' ?>">
						<label for="cpassword" class="col-sm-3 control-label"><?php _e('confirm_password') ?></label>
						<div class="col-sm-6">
							<?php echo print_input($cpassword, array('class' => 'form-control')) ?>
							<?php echo form_error('cpassword', '<small class="help-block">', '</small>') ?>
						</div>
					</div>

					<!-- Current password field -->
					<div class="form-group<?php echo form_error('opassword') ? ' has-error': '' ?>">
						<label for="opassword" class="col-sm-3 control-label"><?php _e('current_password') ?></label>
						<div class="col-sm-6">
							<?php echo print_input($opassword, array('class' => 'form-control')) ?>
							<?php echo form_error('opassword', '<small class="help-block">', '</small>') ?>
						</div>
					</div>

					<div class="col-sm-6 col-sm-offset-3">
						<button type="submit" class="btn btn-primary"><?php _e('set_password_title') ?></button>
					</div>

				<?php echo form_close() ?>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-4 col-sm-pull-8 col-md-3 col-md-pull-9">
		<div class="list-group">
			<?php echo anchor('settings/profile', lang('set_profile_title'), 'class="list-group-item"') ?>
		<?php if (get_option('use_gravatar', false) == false): ?>
			<?php echo anchor('settings/avatar', lang('set_avatar_title'), 'class="list-group-item"') ?>
		<?php endif; ?>
			<?php echo anchor('settings/password', lang('set_password_title'), 'class="list-group-item active"') ?>
			<?php echo anchor('settings/email', lang('set_email_title'), 'class="list-group-item"') ?>
		</div>
	</div>
</div>

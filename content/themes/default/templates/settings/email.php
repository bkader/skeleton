<div class="row">
	<div class="col-xs-12 col-sm-6 col-sm-push-4 col-md-9 col-md-push-3">
		<div class="panel panel-default">
			<div class="panel-heading"><h1 class="panel-title"><?php _e('set_email_title') ?></h1></div>
			<div class="panel-body">
				<?php
				echo form_open('settings/email', 'role="form" class="form-horizontal"');
				echo form_nonce('update_settings_email_'.$c_user->id);
				?>

					<div class="form-group">
						<label class="col-sm-3 control-label"><?php _e('email_address'); ?></label>
						<div class="col-sm-6">
							<p class="form-control-static"><?php echo $c_user->email; ?></p>
						</div>
					</div>

					<!-- New email field -->
					<div class="form-group<?php echo form_error('nemail') ? ' has-error': '' ?>">
						<label for="nemail" class="col-sm-3 control-label"><?php _e('new_email_address') ?></label>
						<div class="col-sm-6">
							<?php echo print_input($nemail, array('class' => 'form-control')) ?>
							<?php echo form_error('nemail', '<small class="help-block">', '</small>') ?>
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
						<button type="submit" class="btn btn-primary"><?php _e('set_email_title') ?></button>
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
			<?php echo anchor('settings/password', lang('set_password_title'), 'class="list-group-item"') ?>
			<?php echo anchor('settings/email', lang('set_email_title'), 'class="list-group-item active"') ?>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12 col-sm-8 col-sm-push-4 col-md-9 col-md-push-3">
		<div class="panel panel-default">
			<div class="panel-heading"><h1 class="panel-title"><?php _e('set_avatar_heading') ?></h1></div>
			<div class="panel-body">
				<?php
				echo form_open_multipart('settings/avatar', 'role="form" class="form-horizontal"');
				echo form_nonce('update_settings_avatar_'.$c_user->id);
				?>
					<!-- Avatar field. -->
					<div class="form-group">
						<label for="avatar" class="col-sm-2 control-label"><?php _e('avatar'); ?></label>
						<div class="col-sm-6">
							<div class="media">
								<div class="media-left">
									<?php echo user_avatar(50, $c_user->id, 'class="media-object"'); ?>
								</div>
								<div class="media-body">
									<?php echo lang('add_image', 'avatar', 'class="btn btn-default btn-sm"'); ?>
									<?php echo form_upload('avatar', null, 'id="avatar" class="hidden" hidden="hidden"'); ?>
								</div>
							</div>
						</div>
					</div>

					<!-- Use Gravatar checkbox -->
					<div class="form-group">
						<div class="col-sm-6 col-sm-offset-2">
							<div class="checkbox-inline">
								<input type="checkbox" name="gravatar" id="gravatar" value="1">
								<?php echo lang('use_gravatar', 'gravatar'); ?>
								<div class="help-block"><?php printf(lang('use_gravatar_notice'), 'https://www.gravatar.com/'); ?></div>
							</div>
						</div>
					</div>

					<div class="col-sm-6 col-sm-offset-2">
						<button type="submit" class="btn btn-primary"><?php _e('update_avatar') ?></button>
					</div>

				<?php echo form_close() ?>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-4 col-sm-pull-8 col-md-3 col-md-pull-9">
		<div class="list-group">
			<?php echo anchor('settings/profile', lang('set_profile_title'), 'class="list-group-item"') ?>
		<?php if (get_option('use_gravatar', false) == false): ?>
			<?php echo anchor('settings/avatar', lang('set_avatar_title'), 'class="list-group-item active"') ?>
		<?php endif; ?>
			<?php echo anchor('settings/password', lang('set_password_title'), 'class="list-group-item"') ?>
			<?php echo anchor('settings/email', lang('set_email_title'), 'class="list-group-item"') ?>
		</div>
	</div>
</div>

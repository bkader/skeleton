<h2 class="page-header"><?php _e('users_settings') ?></h2>

<!-- nav-tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation"><?php echo admin_anchor('settings', lang('general'), 'role="tab"') ?></li>
	<li role="presentation" class="active"><?php echo admin_anchor('settings/users', lang('users'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/email', lang('email'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/uploads', lang('uploads'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/captcha', lang('captcha'), 'role="tab"') ?></li>
</ul>
<!-- /nav-tabs -->
<!-- tab-content -->
<div class="tab-content tab-settings">
	<div class="tab-pane active" role="tabpanel" id="general">
		<?php echo form_open('admin/settings/users', 'role="form" class="form-horizontal"', $hidden) ?>
			<fieldset>

				<!-- Allow registrations -->
				<div class="form-group<?php echo form_error('allow_registration') ? ' has-error' : ''?>">
					<label for="allow_registration" class="col-sm-2 control-label"><?php _e('set_allow_registration') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($allow_registration, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('allow_registration') ?: lang('set_allow_registration_tip') ?></div>
					</div>
				</div>

				<!-- Email activation -->
				<div class="form-group<?php echo form_error('email_activation') ? ' has-error' : ''?>">
					<label for="email_activation" class="col-sm-2 control-label"><?php _e('set_email_activation') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($email_activation, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('email_activation') ?: lang('set_email_activation_tip') ?></div>
					</div>
				</div>

				<!-- Manual activation -->
				<div class="form-group<?php echo form_error('manual_activation') ? ' has-error' : ''?>">
					<label for="manual_activation" class="col-sm-2 control-label"><?php _e('set_manual_activation') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($manual_activation, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('manual_activation') ?: lang('set_manual_activation_tip') ?></div>
					</div>
				</div>

				<!-- Login type -->
				<div class="form-group<?php echo form_error('login_type') ? ' has-error' : ''?>">
					<label for="login_type" class="col-sm-2 control-label"><?php _e('set_login_type') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($login_type, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('login_type') ?: lang('set_login_type_tip') ?></div>
					</div>
				</div>

				<!-- Multiple sessions -->
				<div class="form-group<?php echo form_error('allow_multi_session') ? ' has-error' : ''?>">
					<label for="allow_multi_session" class="col-sm-2 control-label"><?php _e('set_allow_multi_session') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($allow_multi_session, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('allow_multi_session') ?: lang('set_allow_multi_session_tip') ?></div>
					</div>
				</div>

				<!-- Use Gravatar -->
				<div class="form-group<?php echo form_error('use_gravatar') ? ' has-error' : ''?>">
					<label for="use_gravatar" class="col-sm-2 control-label"><?php _e('set_use_gravatar') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($use_gravatar, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('use_gravatar') ?: lang('set_use_gravatar_tip') ?></div>
					</div>
				</div>

				<div class="text-right">
					<button class="btn btn-primary" type="submit"><?php _e('save_changes') ?></button>
				</div>
			</fieldset>

		<?php echo form_close() ?>
	</div><!--/.tab-pane-->
</div><!--/.tab-content-->

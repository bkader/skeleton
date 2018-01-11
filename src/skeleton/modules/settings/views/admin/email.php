<h2 class="page-header"><?php _e('email_settings') ?></h2>

<!-- nav-tabs -->
<ul class="nav nav-pills">
	<li role="presentation"><?php echo admin_anchor('settings', lang('general')) ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/users', lang('users')) ?></li>
	<li role="presentation" class="active"><?php echo admin_anchor('settings/email', lang('email')) ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/uploads', lang('uploads')) ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/captcha', lang('captcha')) ?></li>
</ul><hr />
<!-- /nav-tabs -->
<!-- tab-content -->
<?php echo form_open('admin/settings/email', 'role="form" class="form-horizontal"', $hidden) ?>
	<fieldset>

		<!-- Admin email -->
		<div class="form-group<?php echo form_error('admin_email') ? ' has-error' : ''?>">
			<label for="admin_email" class="col-sm-2 control-label"><?php _e('set_admin_email') ?></label>
			<div class="col-sm-10">
				<?php echo print_input($admin_email, array('class' => 'form-control')) ?>
				<div class="help-block"><?php echo form_error('admin_email') ?: lang('set_admin_email_tip') ?></div>
			</div>
		</div>

		<!-- Main protocol -->
		<div class="form-group<?php echo form_error('mail_protocol') ? ' has-error' : ''?>">
			<label for="mail_protocol" class="col-sm-2 control-label"><?php _e('set_mail_protocol') ?></label>
			<div class="col-sm-10">
				<?php echo print_input($mail_protocol, array('class' => 'form-control')) ?>
				<div class="help-block"><?php echo form_error('mail_protocol') ?: lang('set_mail_protocol_tip') ?></div>
			</div>
		</div>

		<!-- Sendmail path -->
		<div class="form-group<?php echo form_error('sendmail_path') ? ' has-error' : ''?>">
			<label for="sendmail_path" class="col-sm-2 control-label"><?php _e('set_sendmail_path') ?></label>
			<div class="col-sm-10">
				<?php echo print_input($sendmail_path, array('class' => 'form-control')) ?>
				<div class="help-block"><?php echo form_error('sendmail_path') ?: lang('set_sendmail_path_tip') ?></div>
			</div>
		</div>

		<!-- Server email -->
		<div class="form-group<?php echo form_error('server_email') ? ' has-error' : ''?>">
			<label for="server_email" class="col-sm-2 control-label"><?php _e('set_server_email') ?></label>
			<div class="col-sm-10">
				<?php echo print_input($server_email, array('class' => 'form-control')) ?>
				<div class="help-block"><?php echo form_error('server_email') ?: lang('set_server_email_tip') ?></div>
			</div>
		</div>

		<!-- SMTP host -->
		<div class="form-group<?php echo form_error('smtp_host') ? ' has-error' : ''?>">
			<label for="smtp_host" class="col-sm-2 control-label"><?php _e('set_smtp_host') ?></label>
			<div class="col-sm-10">
				<?php echo print_input($smtp_host, array('class' => 'form-control')) ?>
				<div class="help-block"><?php echo form_error('smtp_host') ?: lang('set_smtp_host_tip') ?></div>
			</div>
		</div>

		<!-- SMTP port -->
		<div class="form-group<?php echo form_error('smtp_port') ? ' has-error' : ''?>">
			<label for="smtp_port" class="col-sm-2 control-label"><?php _e('set_smtp_port') ?></label>
			<div class="col-sm-10">
				<?php echo print_input($smtp_port, array('class' => 'form-control')) ?>
				<div class="help-block"><?php echo form_error('smtp_port') ?: lang('set_smtp_port_tip') ?></div>
			</div>
		</div>

		<!-- SMTP crypto -->
		<div class="form-group<?php echo form_error('smtp_crypto') ? ' has-error' : ''?>">
			<label for="smtp_crypto" class="col-sm-2 control-label"><?php _e('set_smtp_crypto') ?></label>
			<div class="col-sm-10">
				<?php echo print_input($smtp_crypto, array('class' => 'form-control')) ?>
				<div class="help-block"><?php echo form_error('smtp_crypto') ?: lang('set_smtp_crypto_tip') ?></div>
			</div>
		</div>

		<!-- SMTP user -->
		<div class="form-group<?php echo form_error('smtp_user') ? ' has-error' : ''?>">
			<label for="smtp_user" class="col-sm-2 control-label"><?php _e('set_smtp_user') ?></label>
			<div class="col-sm-10">
				<?php echo print_input($smtp_user, array('class' => 'form-control')) ?>
				<div class="help-block"><?php echo form_error('smtp_user') ?: lang('set_smtp_user_tip') ?></div>
			</div>
		</div>

		<!-- SMTP pass -->
		<div class="form-group<?php echo form_error('smtp_pass') ? ' has-error' : ''?>">
			<label for="smtp_pass" class="col-sm-2 control-label"><?php _e('set_smtp_pass') ?></label>
			<div class="col-sm-10">
				<?php echo print_input($smtp_pass, array('class' => 'form-control')) ?>
				<div class="help-block"><?php echo form_error('smtp_pass') ?: lang('set_smtp_pass_tip') ?></div>
			</div>
		</div>

		<div class="text-right">
			<button class="btn btn-primary" type="submit"><?php _e('save_changes') ?></button>
		</div>
	</fieldset>

<?php echo form_close() ?>

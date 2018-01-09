<h2 class="page-header"><?= __('email_settings') ?></h2>

<!-- nav-tabs -->
<ul class="nav nav-pills">
	<li role="presentation"><?= admin_anchor('settings', __('general')) ?></li>
	<li role="presentation"><?= admin_anchor('settings/users', __('users')) ?></li>
	<li role="presentation" class="active"><?= admin_anchor('settings/email', __('email')) ?></li>
	<li role="presentation"><?= admin_anchor('settings/uploads', __('uploads')) ?></li>
	<li role="presentation"><?= admin_anchor('settings/captcha', __('captcha')) ?></li>
</ul><hr />
<!-- /nav-tabs -->
<!-- tab-content -->
<?= form_open('admin/settings/email', 'role="form" class="form-horizontal"', $hidden) ?>
	<fieldset>

		<!-- Admin email -->
		<div class="form-group<?= form_error('admin_email') ? ' has-error' : ''?>">
			<label for="admin_email" class="col-sm-2 control-label"><?= __('set_admin_email') ?></label>
			<div class="col-sm-10">
				<?= print_input($admin_email, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('admin_email') ?: __('set_admin_email_tip') ?></div>
			</div>
		</div>

		<!-- Main protocol -->
		<div class="form-group<?= form_error('mail_protocol') ? ' has-error' : ''?>">
			<label for="mail_protocol" class="col-sm-2 control-label"><?= __('set_mail_protocol') ?></label>
			<div class="col-sm-10">
				<?= print_input($mail_protocol, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('mail_protocol') ?: __('set_mail_protocol_tip') ?></div>
			</div>
		</div>

		<!-- Sendmail path -->
		<div class="form-group<?= form_error('sendmail_path') ? ' has-error' : ''?>">
			<label for="sendmail_path" class="col-sm-2 control-label"><?= __('set_sendmail_path') ?></label>
			<div class="col-sm-10">
				<?= print_input($sendmail_path, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('sendmail_path') ?: __('set_sendmail_path_tip') ?></div>
			</div>
		</div>

		<!-- Server email -->
		<div class="form-group<?= form_error('server_email') ? ' has-error' : ''?>">
			<label for="server_email" class="col-sm-2 control-label"><?= __('set_server_email') ?></label>
			<div class="col-sm-10">
				<?= print_input($server_email, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('server_email') ?: __('set_server_email_tip') ?></div>
			</div>
		</div>

		<!-- SMTP host -->
		<div class="form-group<?= form_error('smtp_host') ? ' has-error' : ''?>">
			<label for="smtp_host" class="col-sm-2 control-label"><?= __('set_smtp_host') ?></label>
			<div class="col-sm-10">
				<?= print_input($smtp_host, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('smtp_host') ?: __('set_smtp_host_tip') ?></div>
			</div>
		</div>

		<!-- SMTP port -->
		<div class="form-group<?= form_error('smtp_port') ? ' has-error' : ''?>">
			<label for="smtp_port" class="col-sm-2 control-label"><?= __('set_smtp_port') ?></label>
			<div class="col-sm-10">
				<?= print_input($smtp_port, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('smtp_port') ?: __('set_smtp_port_tip') ?></div>
			</div>
		</div>

		<!-- SMTP crypto -->
		<div class="form-group<?= form_error('smtp_crypto') ? ' has-error' : ''?>">
			<label for="smtp_crypto" class="col-sm-2 control-label"><?= __('set_smtp_crypto') ?></label>
			<div class="col-sm-10">
				<?= print_input($smtp_crypto, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('smtp_crypto') ?: __('set_smtp_crypto_tip') ?></div>
			</div>
		</div>

		<!-- SMTP user -->
		<div class="form-group<?= form_error('smtp_user') ? ' has-error' : ''?>">
			<label for="smtp_user" class="col-sm-2 control-label"><?= __('set_smtp_user') ?></label>
			<div class="col-sm-10">
				<?= print_input($smtp_user, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('smtp_user') ?: __('set_smtp_user_tip') ?></div>
			</div>
		</div>

		<!-- SMTP pass -->
		<div class="form-group<?= form_error('smtp_pass') ? ' has-error' : ''?>">
			<label for="smtp_pass" class="col-sm-2 control-label"><?= __('set_smtp_pass') ?></label>
			<div class="col-sm-10">
				<?= print_input($smtp_pass, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('smtp_pass') ?: __('set_smtp_pass_tip') ?></div>
			</div>
		</div>

		<div class="text-right">
			<button class="btn btn-primary" type="submit"><?= __('save_changes') ?></button>
		</div>
	</fieldset>

<?= form_close() ?>

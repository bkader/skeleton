<h2 class="page-header"><?= __('users_settings') ?></h2>

<!-- nav-tabs -->
<ul class="nav nav-pills">
	<li role="presentation"><?= admin_anchor('settings', __('general')) ?></li>
	<li role="presentation" class="active"><?= admin_anchor('settings/users', __('users')) ?></li>
	<li role="presentation"><?= admin_anchor('settings/email', __('email')) ?></li>
	<li role="presentation"><?= admin_anchor('settings/uploads', __('uploads')) ?></li>
	<li role="presentation"><?= admin_anchor('settings/captcha', __('captcha')) ?></li>
</ul><hr />
<!-- /nav-tabs -->
<!-- tab-content -->
<?= form_open('admin/settings/users', 'role="form" class="form-horizontal"', $hidden) ?>
	<fieldset>

		<!-- Allow registrations -->
		<div class="form-group<?= form_error('allow_registration') ? ' has-error' : ''?>">
			<label for="allow_registration" class="col-sm-2 control-label"><?= __('set_allow_registration') ?></label>
			<div class="col-sm-10">
				<?= print_input($allow_registration, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('allow_registration') ?: __('set_allow_registration_tip') ?></div>
			</div>
		</div>

		<!-- Email activation -->
		<div class="form-group<?= form_error('email_activation') ? ' has-error' : ''?>">
			<label for="email_activation" class="col-sm-2 control-label"><?= __('set_email_activation') ?></label>
			<div class="col-sm-10">
				<?= print_input($email_activation, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('email_activation') ?: __('set_email_activation_tip') ?></div>
			</div>
		</div>

		<!-- Manual activation -->
		<div class="form-group<?= form_error('manual_activation') ? ' has-error' : ''?>">
			<label for="manual_activation" class="col-sm-2 control-label"><?= __('set_manual_activation') ?></label>
			<div class="col-sm-10">
				<?= print_input($manual_activation, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('manual_activation') ?: __('set_manual_activation_tip') ?></div>
			</div>
		</div>

		<!-- Login type -->
		<div class="form-group<?= form_error('login_type') ? ' has-error' : ''?>">
			<label for="login_type" class="col-sm-2 control-label"><?= __('set_login_type') ?></label>
			<div class="col-sm-10">
				<?= print_input($login_type, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('login_type') ?: __('set_login_type_tip') ?></div>
			</div>
		</div>

		<!-- Use Gravatar -->
		<div class="form-group<?= form_error('use_gravatar') ? ' has-error' : ''?>">
			<label for="use_gravatar" class="col-sm-2 control-label"><?= __('set_use_gravatar') ?></label>
			<div class="col-sm-10">
				<?= print_input($use_gravatar, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('use_gravatar') ?: __('set_use_gravatar_tip') ?></div>
			</div>
		</div>

		<div class="text-right">
			<button class="btn btn-primary" type="submit"><?= __('save_changes') ?></button>
		</div>
	</fieldset>

<?= form_close() ?>

<h2 class="page-header"><?= __('captcha_settings') ?></h2>

<!-- nav-tabs -->
<ul class="nav nav-pills">
	<li role="presentation"><?= admin_anchor('settings', __('general')) ?></li>
	<li role="presentation"><?= admin_anchor('settings/users', __('users')) ?></li>
	<li role="presentation"><?= admin_anchor('settings/email', __('email')) ?></li>
	<li role="presentation"><?= admin_anchor('settings/uploads', __('uploads')) ?></li>
	<li role="presentation" class="active"><?= admin_anchor('settings/captcha', __('captcha')) ?></li>
</ul><hr />
<!-- /nav-tabs -->
<!-- tab-content -->
<?= form_open('admin/settings/captcha', 'role="form" class="form-horizontal"', $hidden) ?>
	<fieldset>

		<!-- Use captcha -->
		<div class="form-group<?= form_error('use_captcha') ? ' has-error' : ''?>">
			<label for="use_captcha" class="col-sm-2 control-label"><?= __('set_use_captcha') ?></label>
			<div class="col-sm-10">
				<?= print_input($use_captcha, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('use_captcha') ?: __('set_use_captcha_tip') ?></div>
			</div>
		</div>

		<!-- Use reCAPTCHA -->
		<div class="form-group<?= form_error('use_recaptcha') ? ' has-error' : ''?>">
			<label for="use_recaptcha" class="col-sm-2 control-label"><?= __('set_use_recaptcha') ?></label>
			<div class="col-sm-10">
				<?= print_input($use_recaptcha, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('use_recaptcha') ?: __('set_use_recaptcha_tip') ?></div>
			</div>
		</div>

		<!-- reCAPTCHA site key -->
		<div class="form-group<?= form_error('recaptcha_site_key') ? ' has-error' : ''?>">
			<label for="recaptcha_site_key" class="col-sm-2 control-label"><?= __('set_recaptcha_site_key') ?></label>
			<div class="col-sm-10">
				<?= print_input($recaptcha_site_key, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('recaptcha_site_key') ?: __('set_recaptcha_site_key_tip') ?></div>
			</div>
		</div>

		<!-- reCAPTCHA private key -->
		<div class="form-group<?= form_error('recaptcha_private_key') ? ' has-error' : ''?>">
			<label for="recaptcha_private_key" class="col-sm-2 control-label"><?= __('set_recaptcha_private_key') ?></label>
			<div class="col-sm-10">
				<?= print_input($recaptcha_private_key, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('recaptcha_private_key') ?: __('set_recaptcha_private_key_tip') ?></div>
			</div>
		</div>

		<div class="text-right">
			<button class="btn btn-primary" type="submit"><?= __('save_changes') ?></button>
		</div>
	</fieldset>

<?= form_close() ?>

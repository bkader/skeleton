<h2 class="page-header"><?= __('upload_settings') ?></h2>

<!-- nav-tabs -->
<ul class="nav nav-pills">
	<li role="presentation"><?= admin_anchor('settings', __('general')) ?></li>
	<li role="presentation"><?= admin_anchor('settings/users', __('users')) ?></li>
	<li role="presentation"><?= admin_anchor('settings/email', __('email')) ?></li>
	<li role="presentation" class="active"><?= admin_anchor('settings/uploads', __('uploads')) ?></li>
	<li role="presentation"><?= admin_anchor('settings/captcha', __('captcha')) ?></li>
</ul><hr />
<!-- /nav-tabs -->
<!-- tab-content -->
<?= form_open('admin/settings/uploads', 'role="form" class="form-horizontal"', $hidden) ?>
	<fieldset>

		<!-- Uploads path -->
		<div class="form-group<?= form_error('upload_path') ? ' has-error' : ''?>">
			<label for="upload_path" class="col-sm-2 control-label"><?= __('set_upload_path') ?></label>
			<div class="col-sm-10">
				<?= print_input($upload_path, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('upload_path') ?: __('set_upload_path_tip') ?></div>
			</div>
		</div>

		<!-- Allowed file types -->
		<div class="form-group<?= form_error('allowed_types') ? ' has-error' : ''?>">
			<label for="allowed_types" class="col-sm-2 control-label"><?= __('set_allowed_types') ?></label>
			<div class="col-sm-10">
				<?= print_input($allowed_types, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('allowed_types') ?: __('set_allowed_types_tip') ?></div>
			</div>
		</div>

		<div class="text-right">
			<button class="btn btn-primary" type="submit"><?= __('save_changes') ?></button>
		</div>
	</fieldset>

<?= form_close() ?>

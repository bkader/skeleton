<h2 class="page-header"><?= __('site_settings') ?></h2>

<!-- nav-tabs -->
<ul class="nav nav-pills">
	<li role="presentation" class="active"><?= admin_anchor('settings', __('general')) ?></li>
	<li role="presentation"><?= admin_anchor('settings/users', __('users')) ?></li>
	<li role="presentation"><?= admin_anchor('settings/email', __('email')) ?></li>
	<li role="presentation"><?= admin_anchor('settings/uploads', __('uploads')) ?></li>
	<li role="presentation"><?= admin_anchor('settings/captcha', __('captcha')) ?></li>
</ul><hr />
<!-- /nav-tabs -->
<!-- tab-content -->
<?= form_open('admin/settings', 'role="form" class="form-horizontal"', $hidden) ?>
	<fieldset>
		<!-- Site name -->
		<div class="form-group<?= form_error('site_name') ? ' has-error' : ''?>">
			<label for="site_name" class="col-sm-2 control-label"><?= __('set_site_name') ?></label>
			<div class="col-sm-10">
				<?= print_input($site_name, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('site_name') ?: __('set_site_name_tip') ?></div>
			</div>
		</div>

		<!-- Site description -->
		<div class="form-group<?= form_error('site_description') ? ' has-error' : ''?>">
			<label for="site_description" class="col-sm-2 control-label"><?= __('set_site_description') ?></label>
			<div class="col-sm-10">
				<?= print_input($site_description, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('site_description') ?: __('set_site_description_tip') ?></div>
			</div>
		</div>

		<!-- Site keywords -->
		<div class="form-group<?= form_error('site_keywords') ? ' has-error' : ''?>">
			<label for="site_keywords" class="col-sm-2 control-label"><?= __('set_site_keywords') ?></label>
			<div class="col-sm-10">
				<?= print_input($site_keywords, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('site_keywords') ?: __('set_site_keywords_tip') ?></div>
			</div>
		</div>

		<!-- Site author -->
		<div class="form-group<?= form_error('site_author') ? ' has-error' : ''?>">
			<label for="site_author" class="col-sm-2 control-label"><?= __('set_site_author') ?></label>
			<div class="col-sm-10">
				<?= print_input($site_author, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('site_author') ?: __('set_site_author_tip') ?></div>
			</div>
		</div>

		<!-- Per page -->
		<div class="form-group<?= form_error('per_page') ? ' has-error' : ''?>">
			<label for="per_page" class="col-sm-2 control-label"><?= __('set_per_page') ?></label>
			<div class="col-sm-10">
				<?= print_input($per_page, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('per_page') ?: __('set_per_page_tip') ?></div>
			</div>
		</div>
	</fieldset>

	<fieldset>
		<!-- Google analytics ID -->
		<div class="form-group<?= form_error('google_analytics_id') ? ' has-error' : ''?>">
			<label for="google_analytics_id" class="col-sm-2 control-label"><?= __('set_google_analytics_id') ?></label>
			<div class="col-sm-10">
				<?= print_input($google_analytics_id, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('google_analytics_id') ?: __('set_google_analytics_id_tip') ?></div>
			</div>
		</div>
		<!-- Google site verification -->
		<div class="form-group<?= form_error('google_site_verification') ? ' has-error' : ''?>">
			<label for="google_site_verification" class="col-sm-2 control-label"><?= __('set_google_site_verification') ?></label>
			<div class="col-sm-10">
				<?= print_input($google_site_verification, array('class' => 'form-control')) ?>
				<div class="help-block"><?= form_error('google_site_verification') ?: __('set_google_site_verification_tip') ?></div>
			</div>
		</div>
	</fieldset>

	<div class="text-right">
		<button class="btn btn-primary" type="submit"><?= __('save_changes') ?></button>
	</div>

<?= form_close() ?>

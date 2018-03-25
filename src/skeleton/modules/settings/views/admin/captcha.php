<h2 class="page-header"><?php _e('captcha_settings') ?></h2>

<!-- nav-tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation"><?php echo admin_anchor('settings', lang('general'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/users', lang('users'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/email', lang('email'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/uploads', lang('uploads'), 'role="tab"') ?></li>
	<li role="presentation" class="active"><?php echo admin_anchor('settings/captcha', lang('captcha'), 'role="tab"') ?></li>
</ul>
<!-- /nav-tabs -->
<!-- tab-content -->
<div class="tab-content tab-settings">
	<div class="tab-pane active" role="tabpanel" id="general">
		<?php echo form_open('admin/settings/captcha', 'role="form" class="form-horizontal"', $hidden) ?>
			<fieldset>

				<!-- Use captcha -->
				<div class="form-group<?php echo form_error('use_captcha') ? ' has-error' : ''?>">
					<label for="use_captcha" class="col-sm-2 control-label"><?php _e('set_use_captcha') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($use_captcha, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('use_captcha') ?: lang('set_use_captcha_tip') ?></div>
					</div>
				</div>

				<!-- Use reCAPTCHA -->
				<div class="form-group<?php echo form_error('use_recaptcha') ? ' has-error' : ''?>">
					<label for="use_recaptcha" class="col-sm-2 control-label"><?php _e('set_use_recaptcha') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($use_recaptcha, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('use_recaptcha') ?: lang('set_use_recaptcha_tip') ?></div>
					</div>
				</div>

				<!-- reCAPTCHA site key -->
				<div class="form-group<?php echo form_error('recaptcha_site_key') ? ' has-error' : ''?>">
					<label for="recaptcha_site_key" class="col-sm-2 control-label"><?php _e('set_recaptcha_site_key') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($recaptcha_site_key, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('recaptcha_site_key') ?: lang('set_recaptcha_site_key_tip') ?></div>
					</div>
				</div>

				<!-- reCAPTCHA private key -->
				<div class="form-group<?php echo form_error('recaptcha_private_key') ? ' has-error' : ''?>">
					<label for="recaptcha_private_key" class="col-sm-2 control-label"><?php _e('set_recaptcha_private_key') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($recaptcha_private_key, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('recaptcha_private_key') ?: lang('set_recaptcha_private_key_tip') ?></div>
					</div>
				</div>

				<div class="text-right">
					<button class="btn btn-primary btn-sm" type="submit"><?php _e('save_changes') ?></button>
				</div>
			</fieldset>

		<?php echo form_close() ?>
	</div><!--/.tab-pane-->
</div><!--/.tab-content-->

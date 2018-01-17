<h2 class="page-header"><?php _e('upload_settings') ?></h2>

<!-- nav-tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation"><?php echo admin_anchor('settings', lang('general'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/users', lang('users'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/email', lang('email'), 'role="tab"') ?></li>
	<li role="presentation" class="active"><?php echo admin_anchor('settings/uploads', lang('uploads'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/captcha', lang('captcha'), 'role="tab"') ?></li>
</ul>
<!-- /nav-tabs -->
<!-- tab-content -->
<div class="tab-content tab-settings">
	<div class="tab-pane active" role="tabpanel" id="general">
		<?php echo form_open('admin/settings/uploads', 'role="form" class="form-horizontal"', $hidden) ?>
			<fieldset>

				<!-- Uploads path -->
				<div class="form-group<?php echo form_error('upload_path') ? ' has-error' : ''?>">
					<label for="upload_path" class="col-sm-2 control-label"><?php _e('set_upload_path') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($upload_path, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('upload_path') ?: lang('set_upload_path_tip') ?></div>
					</div>
				</div>

				<!-- Allowed file types -->
				<div class="form-group<?php echo form_error('allowed_types') ? ' has-error' : ''?>">
					<label for="allowed_types" class="col-sm-2 control-label"><?php _e('set_allowed_types') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($allowed_types, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('allowed_types') ?: lang('set_allowed_types_tip') ?></div>
					</div>
				</div>

				<div class="text-right">
					<button class="btn btn-primary btn-sm" type="submit"><?php _e('save_changes') ?></button>
				</div>
			</fieldset>

		<?php echo form_close() ?>
	</div><!--/.tab-pane-->
</div><!--/.tab-content-->

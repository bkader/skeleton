<h2 class="page-header"><?php _e('site_settings') ?></h2>

<!-- nav-tabs -->
<ul class="nav nav-tabs" role="tablist">
	<li role="presentation" class="active"><?php echo admin_anchor('settings', lang('general'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/users', lang('users'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/email', lang('email'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/uploads', lang('uploads'), 'role="tab"') ?></li>
	<li role="presentation"><?php echo admin_anchor('settings/captcha', lang('captcha'), 'role="tab"') ?></li>
</ul>
<!-- /nav-tabs -->
<!-- tab-content -->
<div class="tab-content tab-settings">
	<div class="tab-pane active" role="tabpanel" id="general">
		<?php echo form_open('admin/settings', 'role="form" class="form-horizontal"', $hidden) ?>
			<fieldset>
				<!-- Site name -->
				<div class="form-group<?php echo form_error('site_name') ? ' has-error' : ''?>">
					<label for="site_name" class="col-sm-2 control-label"><?php _e('set_site_name') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($site_name, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('site_name') ?: lang('set_site_name_tip') ?></div>
					</div>
				</div>

				<!-- Site description -->
				<div class="form-group<?php echo form_error('site_description') ? ' has-error' : ''?>">
					<label for="site_description" class="col-sm-2 control-label"><?php _e('set_site_description') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($site_description, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('site_description') ?: lang('set_site_description_tip') ?></div>
					</div>
				</div>

				<!-- Site keywords -->
				<div class="form-group<?php echo form_error('site_keywords') ? ' has-error' : ''?>">
					<label for="site_keywords" class="col-sm-2 control-label"><?php _e('set_site_keywords') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($site_keywords, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('site_keywords') ?: lang('set_site_keywords_tip') ?></div>
					</div>
				</div>

				<!-- Site author -->
				<div class="form-group<?php echo form_error('site_author') ? ' has-error' : ''?>">
					<label for="site_author" class="col-sm-2 control-label"><?php _e('set_site_author') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($site_author, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('site_author') ?: lang('set_site_author_tip') ?></div>
					</div>
				</div>

				<!-- Base controller -->
				<div class="form-group<?php echo form_error('base_controller') ? ' has-error' : ''?>">
					<label for="base_controller" class="col-sm-2 control-label"><?php _e('set_base_controller') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($base_controller, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('base_controller') ?: lang('set_base_controller_tip') ?></div>
					</div>
				</div>

				<!-- Per page -->
				<div class="form-group<?php echo form_error('per_page') ? ' has-error' : ''?>">
					<label for="per_page" class="col-sm-2 control-label"><?php _e('set_per_page') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($per_page, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('per_page') ?: lang('set_per_page_tip') ?></div>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<!-- Google analytics ID -->
				<div class="form-group<?php echo form_error('google_analytics_id') ? ' has-error' : ''?>">
					<label for="google_analytics_id" class="col-sm-2 control-label"><?php _e('set_google_analytics_id') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($google_analytics_id, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('google_analytics_id') ?: lang('set_google_analytics_id_tip') ?></div>
					</div>
				</div>
				<!-- Google site verification -->
				<div class="form-group<?php echo form_error('google_site_verification') ? ' has-error' : ''?>">
					<label for="google_site_verification" class="col-sm-2 control-label"><?php _e('set_google_site_verification') ?></label>
					<div class="col-sm-10">
						<?php echo print_input($google_site_verification, array('class' => 'form-control')) ?>
						<div class="help-block"><?php echo form_error('google_site_verification') ?: lang('set_google_site_verification_tip') ?></div>
					</div>
				</div>
			</fieldset>

			<div class="text-right">
				<button class="btn btn-primary btn-sm" type="submit"><?php _e('save_changes') ?></button>
			</div>

		<?php echo form_close() ?>
		</div>
	</div><!--/.tab-pane-->
</div><!--/.tab-content-->

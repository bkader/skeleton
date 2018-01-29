<div class="row">
	<div class="col-xs-12 col-sm-6 col-sm-push-3 col-md-4 col-md-push-4">
		<h1 class="text-center"><?php _e('us_resend_heading') ?></h1>
		<div class="panel panel-default">
			<div class="panel-body">
				<p class="text-muted"><?php _e('us_resend_notice') ?></p><br />
				<?php echo form_open('register/resend', 'role="form" autocomplete="off"', $hidden) ?>
					<div class="form-group<?php echo form_error('identity') ? ' has-error' : '' ?>">
						<label for="identity" class="sr-only"><?php _e('identity') ?></label>
						<?php echo print_input($identity, array('class' => 'form-control', 'autofocus' => 'autofocus')) ?>
						<?php echo form_error('identity', '<small class="help-block">', '</small>') ?>
					</div>
				<?php if (get_option('use_captcha', false) === true): ?>
					<div class="form-group<?php echo form_error('captcha') ? ' has-error' : '' ?>">
					<?php if (get_option('use_recaptcha', false) === true): ?>
							<?php echo $captcha ?>
					<?php else: ?>
						<div class="row">
							<div class="col-xs-12 col-sm-6"><?php echo $captcha_image ?></div>
							<div class="col-xs-12 col-sm-6"><?php echo print_input($captcha, array('class' => 'form-control')) ?></div>
						</div>
					<?php endif; ?>
						<?php echo form_error('captcha', '<small class="help-block">', '</small>') ?>
					</div>
				<?php endif; ?>
					<button type="submit" class="btn btn-primary btn-block"><?php _e('resend_link') ?></button>
				<?php echo form_close() ?>
			</div>
			<div class="panel-footer">
					<?php echo anchor('login', lang('login'), 'class="btn btn-default"') ?>
					<?php echo anchor('register', lang('create_account'), 'class="btn btn-default pull-right"') ?>
			</div>
		</div>
	</div>
</div>

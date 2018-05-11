<div class="row">
	<div class="col-xs-12 col-sm-6 col-sm-push-3 col-md-4 col-md-push-4">
		<h1 class="text-center"><?php _e('CSK_USERS_RESTORE_ACCOUNT') ?></h1>
		<div class="panel panel-default">
			<div class="panel-body">
				<p class="text-muted"><?php _e('CSK_USERS_RESTORE_TIP') ?></p><br />
				<?php echo form_open('login/restore', 'role="form" id="restore"'), form_nonce('user-restore'); ?>
					<div class="form-group<?php echo form_error('identity') ? ' has-error' : '' ?>">
						<label for="identity" class="sr-only"><?php _e('CSK_INPUT_IDENTITY') ?></label>
						<?php echo print_input($identity, array('class' => 'form-control', 'autofocus' => 'autofocus')) ?>
						<?php echo form_error('identity', '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?php echo form_error('password') ? ' has-error' : '' ?>">
						<label for="password" class="sr-only"><?php _e('CSK_INPUT_PASSWORD') ?></label>
						<?php echo print_input($password, array('class' => 'form-control', 'autofocus' => 'autofocus')) ?>
						<?php echo form_error('password', '<small class="help-block">', '</small>') ?>
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
					<button type="submit" class="btn btn-primary btn-block"><?php _e('CSK_BTN_RESTORE_ACCOUNT') ?></button>
				<?php echo form_close() ?>
			</div>
			<div class="panel-footer">
					<?php echo anchor('login', line('CSK_BTN_LOGIN'), 'class="btn btn-default"') ?>
					<?php echo anchor('register', line('CSK_BTN_CREATE_ACCOUNT'), 'class="btn btn-default pull-right"') ?>
			</div>
		</div>
	</div>
</div>

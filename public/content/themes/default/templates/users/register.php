<div class="row">
	<div class="col-xs-12 col-sm-6 col-sm-push-3 col-md-4 col-md-push-4">
		<h1 class="text-center"><?php _e('us_register_heading') ?></h1>
		<div class="panel panel-default">
			<div class="panel-body">
				<?php echo form_open('register', 'role="form"', @$hidden) ?>
					<div class="form-group<?php echo form_error('first_name') ? ' has-error' : '' ?>">
						<label for="first_name" class="sr-only"><?php _e('first_name') ?></label>
						<?php echo print_input($first_name, array('class' => 'form-control', 'autofocus' => 'autofocus')) ?>
						<?php echo form_error('first_name', '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?php echo form_error('last_name') ? ' has-error' : '' ?>">
						<label for="last_name" class="sr-only"><?php _e('last_name') ?></label>
						<?php echo print_input($last_name, array('class' => 'form-control')) ?>
						<?php echo form_error('last_name', '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?php echo form_error('email') ? ' has-error' : '' ?>">
						<label for="email" class="sr-only"><?php _e('email_address') ?></label>
						<?php echo print_input($email, array('class' => 'form-control')) ?>
						<?php echo form_error('email', '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?php echo form_error('username') ? ' has-error' : '' ?>">
						<label for="username" class="sr-only"><?php _e('username') ?></label>
						<?php echo print_input($username, array('class' => 'form-control')) ?>
						<?php echo form_error('username', '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?php echo form_error('password') ? ' has-error' : '' ?>">
						<label for="password" class="sr-only"><?php _e('password') ?></label>
						<?php echo print_input($password, array('class' => 'form-control')) ?>
						<?php echo form_error('password', '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?php echo form_error('cpassword') ? ' has-error' : '' ?>">
						<label for="cpassword" class="sr-only"><?php _e('confirm_password') ?></label>
						<?php echo print_input($cpassword, array('class' => 'form-control')) ?>
						<?php echo form_error('cpassword', '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?php echo form_error('gender') ? ' has-error' : '' ?>">
						<label for="male" class="radio-inline"><input type="radio" name="gender" id="male" value="male" <?php echo set_radio('gender', 'male') ?>> <?php _e('male') ?></label>
						<label for="female" class="radio-inline"><input type="radio" name="gender" id="female" value="female" <?php echo set_radio('gender', 'female') ?>> <?php _e('female') ?></label>
						<?php echo form_error('gender', '<small class="help-block">', '</small>') ?>
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
					<button type="submit" class="btn btn-primary pull-right"><?php _e('create_account') ?></button>
					<?php echo anchor('login', lang('login'), 'class="btn btn-default" tabindex="-1"') ?>
				<?php echo form_close() ?>
			</div>
		</div>
	</div>
</div>

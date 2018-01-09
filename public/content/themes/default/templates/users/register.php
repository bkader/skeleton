<div class="row">
	<div class="col-xs-12 col-sm-6 col-sm-push-3 col-md-4 col-md-push-4">
		<h1 class="text-center"><?= __('us_register_heading') ?></h1>
		<div class="panel panel-default">
			<div class="panel-body">
				<?= form_open('register', 'role="form"', @$hidden) ?>
					<div class="form-group<?= form_error('first_name') ? ' has-error' : '' ?>">
						<label for="first_name" class="sr-only"><?= __('first_name') ?></label>
						<?= print_input($first_name, array('class' => 'form-control', 'autofocus' => 'autofocus')) ?>
						<?= form_error('first_name', '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?= form_error('last_name') ? ' has-error' : '' ?>">
						<label for="last_name" class="sr-only"><?= __('last_name') ?></label>
						<?= print_input($last_name, array('class' => 'form-control')) ?>
						<?= form_error('last_name', '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?= form_error('email') ? ' has-error' : '' ?>">
						<label for="email" class="sr-only"><?= __('email_address') ?></label>
						<?= print_input($email, array('class' => 'form-control')) ?>
						<?= form_error('email', '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?= form_error('username') ? ' has-error' : '' ?>">
						<label for="username" class="sr-only"><?= __('username') ?></label>
						<?= print_input($username, array('class' => 'form-control')) ?>
						<?= form_error('username', '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?= form_error('password') ? ' has-error' : '' ?>">
						<label for="password" class="sr-only"><?= __('password') ?></label>
						<?= print_input($password, array('class' => 'form-control')) ?>
						<?= form_error('password', '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?= form_error('cpassword') ? ' has-error' : '' ?>">
						<label for="cpassword" class="sr-only"><?= __('confirm_password') ?></label>
						<?= print_input($cpassword, array('class' => 'form-control')) ?>
						<?= form_error('cpassword', '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?= form_error('gender') ? ' has-error' : '' ?>">
						<label for="male" class="radio-inline"><input type="radio" name="gender" id="male" value="male" <?= set_radio('gender', 'male') ?>> <?= __('male') ?></label>
						<label for="female" class="radio-inline"><input type="radio" name="gender" id="female" value="female" <?= set_radio('gender', 'female') ?>> <?= __('female') ?></label>
						<?= form_error('gender', '<small class="help-block">', '</small>') ?>
					</div>
				<?php if (get_option('use_captcha', false) === true): ?>
					<div class="form-group<?= form_error('captcha') ? ' has-error' : '' ?>">
					<?php if (get_option('use_recaptcha', false) === true): ?>
							<?= $captcha ?>
					<?php else: ?>
						<div class="row">
							<div class="col-xs-12 col-sm-6"><?= $captcha_image ?></div>
							<div class="col-xs-12 col-sm-6"><?= print_input($captcha, array('class' => 'form-control')) ?></div>
						</div>
					<?php endif; ?>
						<?= form_error('captcha', '<small class="help-block">', '</small>') ?>
					</div>
				<?php endif; ?>
					<button type="submit" class="btn btn-primary pull-right"><?= __('create_account') ?></button>
					<?= anchor('login', __('login'), 'class="btn btn-default" tabindex="-1"') ?>
				<?= form_close() ?>
			</div>
		</div>
	</div>
</div>

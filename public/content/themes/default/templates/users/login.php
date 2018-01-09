<div class="row">
	<div class="col-xs-12 col-sm-6 col-sm-push-3 col-md-4 col-md-push-4">
		<h1 class="text-center"><?= __('login') ?></h1>
		<div class="panel panel-default">
			<div class="panel-body">
				<?= form_open('login', 'role="form" autocomplete="off"', @$hidden) ?>
					<div class="form-group<?= form_error($login_type) ? ' has-error' : '' ?>">
						<label for="login" class="sr-only"><?= __($login_type) ?></label>
						<?= print_input($login, array('class' => 'form-control', 'autofocus' => 'autofocus')) ?>
						<?= form_error($login_type, '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?= form_error('password') ? ' has-error' : '' ?>">
						<label for="password" class="sr-only"><?= __('password') ?></label>
						<?= print_input($password, array('class' => 'form-control')) ?>
						<?= form_error('password', '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?= form_error('gender') ? ' has-error' : '' ?>">
						<input type="checkbox" name="remember" id="remember" value="1">&nbsp;
						<label for="remember"><?= __('remember_me') ?></label>
					</div>
					<button type="submit" class="btn btn-primary btn-block"><?= __('login') ?>&nbsp;<i class="fa fa-unlock-alt"></i></button>
				<?= form_close() ?>
			</div>
			<div class="panel-footer">
				<?php if (get_option('allow_registration', false) === true): ?>
					<?= anchor('register', __('create_account'), 'class="btn btn-default pull-right"') ?>
				<?php endif; ?>
					<?= anchor('login/recover', __('forgot_password'), 'class="btn btn-default"') ?>
			</div>
		</div>
	</div>
</div>

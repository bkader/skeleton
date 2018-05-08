<div class="row">
	<div class="col-xs-12 col-sm-6 col-sm-push-3 col-md-4 col-md-push-4">
		<h1 class="text-center"><?php _e('login') ?></h1>
		<div class="panel panel-default">
			<div class="panel-body">
				<?php echo form_open('login', 'role="form" autocomplete="off"', @$hidden) ?>
					<div class="form-group<?php echo form_error($login_type) ? ' has-error' : '' ?>">
						<label for="login" class="sr-only"><?php _e($login_type) ?></label>
						<?php echo print_input($login, array('class' => 'form-control', 'autofocus' => 'autofocus')) ?>
						<?php echo form_error($login_type, '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?php echo form_error('password') ? ' has-error' : '' ?>">
						<label for="password" class="sr-only"><?php _e('password') ?></label>
						<?php echo print_input($password, array('class' => 'form-control')) ?>
						<?php echo form_error('password', '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?php echo form_error('gender') ? ' has-error' : '' ?>">
						<input type="checkbox" name="remember" id="remember" value="1">&nbsp;
						<label for="remember"><?php _e('remember_me') ?></label>
					</div>
					<button type="submit" class="btn btn-primary btn-block"><?php _e('login') ?>&nbsp;<i class="fa fa-unlock-alt"></i></button>
				<?php echo form_close() ?>
			</div>
			<div class="panel-footer">
				<?php if (get_option('allow_registration', false) === true): ?>
					<?php echo anchor('register', lang('create_account'), 'class="btn btn-default pull-right"') ?>
				<?php endif; ?>
					<?php echo anchor('login/recover', lang('forgot_password'), 'class="btn btn-default"') ?>
			</div>
		</div>
	</div>
</div>

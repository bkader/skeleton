<div class="row">
	<div class="col-xs-12 col-sm-6 col-sm-push-3 col-md-4 col-md-push-4">
		<h1 class="text-center"><?= __('us_reset_heading') ?></h1>
		<div class="panel panel-default">
			<div class="panel-body">
				<?= form_open('login/reset/'.$code, 'role="form"', $hidden) ?>
					<div class="form-group<?= form_error('npassword') ? ' has-error' : '' ?>">
						<label for="npassword" class="sr-only"><?= __('npassword') ?></label>
						<?= print_input($npassword, array('class' => 'form-control', 'autofocus' => 'autofocus')) ?>
						<?= form_error('npassword', '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?= form_error('cpassword') ? ' has-error' : '' ?>">
						<label for="cpassword" class="sr-only"><?= __('confirm_password') ?></label>
						<?= print_input($cpassword, array('class' => 'form-control')) ?>
						<?= form_error('cpassword', '<small class="help-block">', '</small>') ?>
					</div>
					<button type="submit" class="btn btn-primary pull-right"><?= __('us_reset_title') ?></button>
					<?= anchor('login', __('login'), 'class="btn btn-default" tabindex="-1"') ?>
				<?= form_close() ?>
			</div>
		</div>
	</div>
</div>

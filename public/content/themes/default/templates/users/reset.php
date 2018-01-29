<div class="row">
	<div class="col-xs-12 col-sm-6 col-sm-push-3 col-md-4 col-md-push-4">
		<h1 class="text-center"><?php _e('us_reset_heading') ?></h1>
		<div class="panel panel-default">
			<div class="panel-body">
				<?php echo form_open('login/reset/'.$code, 'role="form"', $hidden) ?>
					<div class="form-group<?php echo form_error('npassword') ? ' has-error' : '' ?>">
						<label for="npassword" class="sr-only"><?php _e('npassword') ?></label>
						<?php echo print_input($npassword, array('class' => 'form-control', 'autofocus' => 'autofocus')) ?>
						<?php echo form_error('npassword', '<small class="help-block">', '</small>') ?>
					</div>
					<div class="form-group<?php echo form_error('cpassword') ? ' has-error' : '' ?>">
						<label for="cpassword" class="sr-only"><?php _e('confirm_password') ?></label>
						<?php echo print_input($cpassword, array('class' => 'form-control')) ?>
						<?php echo form_error('cpassword', '<small class="help-block">', '</small>') ?>
					</div>
					<button type="submit" class="btn btn-primary pull-right"><?php _e('us_reset_title') ?></button>
					<?php echo anchor('login', lang('login'), 'class="btn btn-default" tabindex="-1"') ?>
				<?php echo form_close() ?>
			</div>
		</div>
	</div>
</div>

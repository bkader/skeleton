<?= get_partial('navbar') ?>
<?= get_partial('sidebar') ?>
<div class="content-wrap">
	<div class="container-fluid">
		<?php the_alert(); ?>
		<?php the_content(); ?>
	</div>
</div>
<?= get_partial('footer') ?>

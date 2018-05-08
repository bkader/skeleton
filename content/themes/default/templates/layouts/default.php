<?php echo get_partial('navbar'); ?> 
<div class="container wrapper">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-9">
			<?php the_alert(); ?> 
			<?php the_content(); ?> 
		</div>
		<div class="col-xs-12 col-sm-6 col-md-3"><?php echo get_partial('sidebar'); ?> </div>
	</div>
</div>
<?php echo get_partial('footer'); ?> 

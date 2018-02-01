<h2 class="page-header"><?php _e('media_library'); ?></h2>

<div class="row attachments">
<?php if ($media): ?>
<?php foreach ($media as $item): ?>
	<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 attachment">
		<a href="<?php echo admin_url('media/edit/'.$item->id); ?>" style="background-image: url('<?php echo $item->username; ?>');"></a>
	</div>
<?php endforeach; ?>
<?php endif; ?>
</div>

<h2 class="page-header"><?php _e('media_library'); ?></h2>

<div data-dropzone data-upload-url="<?php echo admin_url('media/create'); ?>">
	<div class="row attachments">
	<?php if ($media): ?>
	<?php foreach ($media as $item): ?>
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 attachment" id="media-<?php echo $item->id; ?>">
			<div class="attachment-inner" style="background-image: url('<?php echo $item->username; ?>');">
				<div class="attachment-action">
					<button class="btn btn-primary btn-sm" data-show data-mid="<?php echo $item->id; ?>" ajaxify="<?php echo safe_admin_url('media/'.$item->id); ?>"><i class="fa fa-eye"></i></button>
					<a href="<?php echo admin_url("media/{$item->id}/edit"); ?>" class="btn btn-default btn-sm"><i class="fa fa-pencil"></i></a>
					<button class="btn btn-danger btn-sm" data-delete data-mid="<?php echo $item->id; ?>" ajaxify="<?php echo safe_admin_url('media/delete/'.$item->id); ?>"><i class="fa fa-times"></i></button>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	<?php else: ?>
		<p class="text-center" style="margin-bottom: 30px;"><?php _e('drop_media'); ?></p>
	<?php endif; ?>
	</div>
</div>

<script type="text/x-handlebars-template" id="tpl-media-item">
	<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 attachment">
		<a href="<?php echo admin_url('media/edit'); ?>/{{id}}" style="background-image: url('{{src}}');"></a>
	</div>
</script>

<script type="text/plain" id="tpl-delete-alert"><?php _e('media_delete_alert'); ?></script>

<script type="text/x-handlebars-template" id="tpl-media-show">
	<div class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Attachment Details</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-sm-12 col-md-7">
							<img src="{{username}}" alt="{{name}}">
						</div>
						<div class="col-sm-12 col-md-5">
							<dl class="dl-horizontal">
								<dt>File name:</dt><dd class="txof">{{details.file_name}}</dd>
								<dt>File type:</dt><dd class="txof">{{details.file_mime}}</dd>
								<dt>Uploaded on:</dt><dd class="txof">{{created_at}}</dd>
								<dt>File size:</dt><dd class="txof">{{details.file_size}}</dd>
								<dt>Dimensions:</dt><dd class="txof">{{details.width}} x {{details.height}}</dd>
							</dl>
							<hr />

							<?php echo form_open('admin/media/update/{{id}}', 'role="form" data-update'); ?>
								<div class="form-group">
									<label>URL</label>
									<input class="form-control" type="text" disabled="disabled" value="{{username}}">
								</div>
								<div class="form-group">
									<label for="title">Title</label>
									<input class="form-control" type="text" name="name" id="name" value="{{name}}">
								</div>
								<div class="form-group">
									<label for="description">Description</label>
									<textarea class="form-control" type="text" name="description" id="description">{{description}}</textarea>
								</div>

								<button type="submit" class="btn btn-primary btn-sm">Update</button>&nbsp;&#124;&nbsp;<a href="<?php echo admin_url("media/{$item->id}/edit"); ?>">Edit</a>&nbsp;&#124;&nbsp;<a href="#" class="text-danger" data-delete data-mid="<?php echo $item->id; ?>" ajaxify="<?php echo safe_admin_url('media/delete/'.$item->id); ?>">Delete</i></button>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

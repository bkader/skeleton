<?php
/**
 * CodeIgniter Skeleton
 *
 * A ready-to-use CodeIgniter skeleton  with tons of new features
 * and a whole new concept of hooks (actions and filters) as well
 * as a ready-to-use and application-free theme and plugins system.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2018, Kader Bouyakoub <bkader@mail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package 	CodeIgniter
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @copyright	Copyright (c) 2018, Kader Bouyakoub <bkader@mail.com>
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://github.com/bkader
 * @since 		Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Media module - Admin: list media.
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Views
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.3.0
 */
?><h2 class="page-header"><?php _e('media_library'); ?></h2>
<div data-dropzone data-upload-url="<?php echo admin_url('media/create'); ?>">
	<div class="row attachments">
	<?php if ($media): ?>
	<?php foreach ($media as $m): ?>
		<div class="col-xs-6 col-sm-4 col-md-3 col-lg-2 attachment" id="media-<?php echo $m->id; ?>">
			<div class="attachment-inner" style="background-image: url('<?php echo $m->username; ?>');">
				<div class="attachment-action">
					<a href="#" class="btn btn-primary btn-sm media-view" data-href="<?php echo admin_url('media?item='.$m->id); ?>"><i class="fa fa-eye"></i></a>
					<a href="#" class="btn btn-danger btn-sm media-delete" data-alert="<?php _e('media_delete_confirm'); ?>" data-href="<?php echo admin_url('media/delete/'.$m->id); ?>"><i class="fa fa-times"></i></a>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
	<?php else: ?>
		<p class="text-center" style="margin-bottom: 30px;"><?php _e('drop_media'); ?></p>
	<?php endif; ?>
	</div>
</div>

<?php if ($item !== null): ?>
<div class="modal fade" tabindex="-1" role="dialog" id="media-modal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header clearfix">
				<a type="button" href="#" class="close media-close" aria-hidden="true"><i class="fa fa-times"></i></a>
				<h4 class="modal-title"><?php _e('media_details'); ?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12 col-md-7">
						<img src="<?php echo $item->username; ?>" alt="<?php echo $item->name; ?>">
					</div>
					<div class="col-sm-12 col-md-5">
							<strong><?php _e('media_file_name'); ?></strong>: <span class="txof"><?php echo $item->details['file_name']; ?></span><br />
							<strong><?php _e('media_file_type'); ?></strong>: <span class="txof"><?php echo $item->details['file_mime']; ?></span><br />
							<strong><?php _e('media_created_at'); ?></strong>: <span class="txof"><?php echo $item->created_at; ?></span><br />
							<strong><?php _e('media_file_size'); ?></strong>: <span class="txof"><?php echo $item->file_size; ?></span><br />
							<strong><?php _e('media_dimensions'); ?></strong>: <span class="txof"><?php echo $item->details['width']; ?> x <?php echo $item->details['height']; ?></span>
						<hr />

						<?php echo form_open('admin/media/update/'.$item->id, 'role="form" data-update'); ?>
							<div class="form-group">
								<label>URL</label>
								<p class="well well-sm txof" data-toggle="tooltip" title="<?php _e("media_copy_clipboard"); ?>" onclick="window.prompt('<?php _e("media_copy_clipboard"); ?>', '<?php echo $item->username; ?>');"><?php echo $item->username; ?></p>
							</div>
							<div class="form-group">
								<label for="title"><?php _e('title'); ?></label>
								<input class="form-control" type="text" name="name" id="name" value="<?php echo $item->name; ?>">
							</div>
							<div class="form-group">
								<label for="description"><?php _e('description'); ?></label>
								<textarea class="form-control" type="text" name="description" id="description"><?php echo $item->description; ?></textarea>
							</div>

							<button type="submit" class="btn btn-primary btn-sm"><?php _e('update'); ?></button> &#124; <a href="<?php echo admin_url("media/{$item->id}/edit"); ?>"><?php _e('edit'); ?></a> &#124; <a href="#" class="text-danger media-delete" data-alert="<?php _e('media_delete_confirm'); ?>" data-href="<?php echo admin_url('media/delete/'.$m->id); ?>"><?php _e('delete'); ?></i></a>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

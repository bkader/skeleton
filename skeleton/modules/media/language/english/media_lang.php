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
 * @link 		https://goo.gl/wGXHO9
 * @since 		Version 1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Media module language file (English)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		Version 1.0.0
 * @version 	1.3.0
 */

$lang['smd_media'] = 'Media';
$lang['smd_library'] = 'Library';

// Media page heading.
$lang['smd_media_library'] = 'Media Library';

// Drop zone tip.
$lang['smd_media_drop'] = 'Drop files here to upload.';

// Media details.
$lang['smd_media_details']     = 'Attachment Details';
$lang['smd_media_title']       = 'Title';
$lang['smd_media_description'] = 'Description';
$lang['smd_media_url']         = 'URL';
$lang['smd_media_dimensions']  = 'Dimensions';
$lang['smd_media_file_name']   = 'File Name';
$lang['smd_media_file_size']   = 'File Size';
$lang['smd_media_file_type']   = 'File Type';
$lang['smd_media_created_at']  = 'Uploaded On';

// Copy media link to clipboard.
$lang['smd_media_clipboard'] = 'Copy to clipboard: Ctrl+C';

// Success messages.
$lang['smd_media_upload_success'] = 'Media successfully uploaded.';
$lang['smd_media_delete_success'] = 'Media item successfully deleted.';
$lang['smd_media_update_success'] = 'Media item successfully updated.';

// Error messages.
$lang['smd_media_upload_error'] = 'Unable to upload media.';
$lang['smd_media_delete_error'] = 'Unable to delete media item.';
$lang['smd_media_update_error'] = 'Unable to update media item.';

// Missing media.
$lang['smd_media_missing'] = 'No media file found.';

// Media permissions.
$lang['smd_media_update_permission'] = 'Only an admin or the owner of this item can update it.';
$lang['smd_media_delete_permission'] = 'Only an admin or the owner of this item can delete it.';

// Confirmation messages.
$lang['smd_media_delete_confirm']      = "You are about to permanently delete this item from your site.<br />This action cannot be undone.<br />'Cancel' to stop, 'OK' to delete.";
$lang['smd_media_delete_bulk_confirm'] = "You are about to permanently delete these items from your site.<br />This action cannot be undone.<br />'Cancel' to stop, 'OK' to delete.";

// Add and selection action.
$lang['smd_media_add']     = 'Add Media';
$lang['smd_select_toggle'] = 'Bulk Select';
$lang['smd_select_cancel'] = 'Cancel Selection';
$lang['smd_select_delete'] = 'Delete Selected';

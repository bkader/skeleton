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
 * Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
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
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @copyright	Copyright (c) 2018, Kader Bouyakoub <bkader[at]mail[dot]com>
 * @license 	http://opensource.org/licenses/MIT	MIT License
 * @link 		https://goo.gl/wGXHO9
 * @since 		2.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modules language file (English)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */

$lang['CSK_MODULES']         = 'Modules';
$lang['CSK_MODULES_MODULE']  = 'Module';
$lang['CSK_MODULES_MODULES'] = 'Modules';

// Modules actions.
$lang['CSK_MODULES_ACTIVATE']   = 'Activate';
$lang['CSK_MODULES_ADD']        = 'Add Module';
$lang['CSK_MODULES_DEACTIVATE'] = 'Deactivate';
$lang['CSK_MODULES_DELETE']     = 'Delete';
$lang['CSK_MODULES_DETAILS']    = 'Details';
$lang['CSK_MODULES_INSTALL']    = 'Install Module';
$lang['CSK_MODULES_SETTINGS']   = 'Settings';
$lang['CSK_MODULES_UPLOAD']     = 'Upload Module';

// Upload tip.
$lang['CSK_MODULES_UPLOAD_TIP'] = 'If you have a module in a .zip format, you may install it by uploading it here.';

// Confirmation messages.
$lang['CSK_MODULES_CONFIRM_ACTIVATE']   = 'Are you sure you want to activate %s module?';
$lang['CSK_MODULES_CONFIRM_DEACTIVATE'] = 'Are you sure you want to deactivate %s module?';
$lang['CSK_MODULES_CONFIRM_DELETE']     = 'Are you sure you want to delete %s module and all its data?';

// Success messages.
$lang['CSK_MODULES_SUCCESS_ACTIVATE']   = '%s module successfully activated.';
$lang['CSK_MODULES_SUCCESS_DEACTIVATE'] = '%s module successfully deactivated.';
$lang['CSK_MODULES_SUCCESS_DELETE']     = '%s module successfully delete.';
$lang['CSK_MODULES_SUCCESS_INSTALL']    = 'Module successfully installed.';
$lang['CSK_MODULES_SUCCESS_UPLOAD']     = 'Module successfully uploaded.';

// Error messages.
$lang['CSK_MODULES_ERROR_ACTIVATE']      = 'Unable to activate %s module.';
$lang['CSK_MODULES_ERROR_DEACTIVATE']    = 'Unable to deactivate %s module.';
$lang['CSK_MODULES_ERROR_DELETE']        = 'Unable to delete %s module.';
$lang['CSK_MODULES_ERROR_INSTALL']       = 'Unable to install module.';
$lang['CSK_MODULES_ERROR_UPLOAD']        = 'Unable to upload module.';
$lang['CSK_MODULES_ERROR_DELETE_ACTIVE'] = 'You must disable the %s module before deleting it.';

// Errors when performing actions.
$lang['CSK_MODULES_ERROR_MODULE_MISSING'] = 'This module does not exist.';

// Module upload location.
$lang['CSK_MODULES_LOCATION_SELECT']      = '&#151; Select location &#151;';
$lang['CSK_MODULES_LOCATION_PUBLIC']      = 'Public';
$lang['CSK_MODULES_LOCATION_APPLICATION'] = 'Application';

// Module details.
$lang['CSK_MODULES_DETAILS']      = 'Module Details';
$lang['CSK_MODULES_NAME']         = 'Name';
$lang['CSK_MODULES_FOLDER']       = 'Folder';
$lang['CSK_MODULES_URI']          = 'Module URI';
$lang['CSK_MODULES_DESCRIPTION']  = 'Description';
$lang['CSK_MODULES_VERSION']      = 'Version';
$lang['CSK_MODULES_LICENSE']      = 'License';
$lang['CSK_MODULES_LICENSE_URI']  = 'License URI';
$lang['CSK_MODULES_AUTHOR']       = 'Author';
$lang['CSK_MODULES_AUTHOR_URI']   = 'Author URI';
$lang['CSK_MODULES_AUTHOR_EMAIL'] = 'Author Email';
$lang['CSK_MODULES_TAGS']         = 'Tags';
$lang['CSK_MODULES_ZIP']          = 'Module ZIP Archive';

// With extra string after.
$lang['CSK_MODULES_DETAILS_NAME'] = 'Module Details: %s';
$lang['CSK_MODULES_VERSION_NUM']  = 'Version: %s';
$lang['CSK_MODULES_LICENSE_NAME'] = 'License: %s';
$lang['CSK_MODULES_AUTHOR_NAME']  = 'By %s';
$lang['CSK_MODULES_TAGS_LIST']    = 'Tags: %s';

// Module install filters.
$lang['CSK_MODULES_FILTER_FEATURED']    = 'Featured';
$lang['CSK_MODULES_FILTER_POPULAR']     = 'Popular';
$lang['CSK_MODULES_FILTER_RECOMMENDED'] = 'Recommended';
$lang['CSK_MODULES_FILTER_NEW']         = 'New';
$lang['CSK_MODULES_SEARCH']             = 'Search modules...';

// Module details with links.
$lang['CSK_MODULES_LICENSE_URI']  = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['CSK_MODULES_AUTHOR_URI']   = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['CSK_MODULES_AUTHOR_EMAIL_URI'] = '<a href="mailto:%1$s?subject=%2$s" target="_blank" rel="nofollow">Support</a>';

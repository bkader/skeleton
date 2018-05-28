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
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Plugins language file (English)
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

// Main lines.
$lang['CSK_PLUGINS']         = 'Plugins';
$lang['CSK_PLUGINS_PLUGIN']  = 'Plugin';
$lang['CSK_PLUGINS_PLUGINS'] = 'Plugins';

// Settings lines.
$lang['CSK_PLUGINS_SETTINGS']      = 'Plugin Settings';
$lang['CSK_PLUGINS_SETTINGS_NAME'] = 'Plugin Settings: %s';

// Plugins actions.
$lang['CSK_PLUGINS_ACTIVATE']   = 'Activate';
$lang['CSK_PLUGINS_ADD']        = 'Add Plugin';
$lang['CSK_PLUGINS_DEACTIVATE'] = 'Deactivate';
$lang['CSK_PLUGINS_DELETE']     = 'Delete';
$lang['CSK_PLUGINS_DETAILS']    = 'Details';
$lang['CSK_PLUGINS_INSTALL']    = 'Install Plugin';
$lang['CSK_PLUGINS_SETTINGS']   = 'Settings';
$lang['CSK_PLUGINS_UPLOAD']     = 'Upload Plugin';

// Upload tip.
$lang['CSK_PLUGINS_UPLOAD_TIP'] = 'If you have a plugin in a .zip format, you may install it by uploading it here.';

// Confirmation messages.
$lang['CSK_PLUGINS_CONFIRM_ACTIVATE']   = 'Are you sure you want to activate %s plugin?';
$lang['CSK_PLUGINS_CONFIRM_DEACTIVATE'] = 'Are you sure you want to deactivate %s plugin?';
$lang['CSK_PLUGINS_CONFIRM_DELETE']     = 'Are you sure you want to delete %s plugin and its data?';

// Success messages.
$lang['CSK_PLUGINS_SUCCESS_ACTIVATE']        = '%s plugin successfully activated.';
$lang['CSK_PLUGINS_SUCCESS_DEACTIVATE']      = '%s plugin successfully deactivated.';
$lang['CSK_PLUGINS_SUCCESS_DELETE']          = '%s plugin successfully delete.';
$lang['CSK_PLUGINS_SUCCESS_INSTALL']         = 'Plugin successfully installed.';
$lang['CSK_PLUGINS_SUCCESS_SETTINGS']        = 'Plugin settings successfully updated.';
$lang['CSK_PLUGINS_SUCCESS_UPLOAD']          = 'Plugin successfully uploaded.';
$lang['CSK_PLUGINS_SUCCESS_BULK_ACTIVATE']   = 'Selected plugins successfully activated.';
$lang['CSK_PLUGINS_SUCCESS_BULK_DEACTIVATE'] = 'Selected plugins successfully deactivated.';
$lang['CSK_PLUGINS_SUCCESS_BULK_DELETE']     = 'Selected plugins successfully delete.';

// Error messages.
$lang['CSK_PLUGINS_ERROR_ACTIVATE']        = 'Unable to activate %s plugin.';
$lang['CSK_PLUGINS_ERROR_DEACTIVATE']      = 'Unable to deactivate %s plugin.';
$lang['CSK_PLUGINS_ERROR_DELETE']          = 'Unable to delete %s plugin.';
$lang['CSK_PLUGINS_ERROR_INSTALL']         = 'Unable to install plugin.';
$lang['CSK_PLUGINS_ERROR_SETTINGS']        = 'Unable to update plugin settings.';
$lang['CSK_PLUGINS_ERROR_UPLOAD']          = 'Unable to upload plugin.';
$lang['CSK_PLUGINS_ERROR_BULK_ACTIVATE']   = 'Unable to activate selected plugins.';
$lang['CSK_PLUGINS_ERROR_BULK_DEACTIVATE'] = 'Unable to deactivate selected plugins.';
$lang['CSK_PLUGINS_ERROR_BULK_DELETE']     = 'Unable to delete selected plugins.';

// Errors when performing actions.
$lang['CSK_PLUGINS_ERROR_PLUGIN_MISSING']    = 'This plugin does not exist.';
$lang['CSK_PLUGINS_ERROR_SETTINGS_DISABLED'] = 'You can only update settings of activated plugins.';
$lang['CSK_PLUGINS_ERROR_SETTINGS_MISSING']  = 'This plugin does not have a settings page.';

// Plugin details.
$lang['CSK_PLUGINS_DETAILS']      = 'Plugin Details';
$lang['CSK_PLUGINS_NAME']         = 'Name';
$lang['CSK_PLUGINS_FOLDER']       = 'Folder';
$lang['CSK_PLUGINS_URI']          = 'Plugin URI';
$lang['CSK_PLUGINS_DESCRIPTION']  = 'Description';
$lang['CSK_PLUGINS_VERSION']      = 'Version';
$lang['CSK_PLUGINS_LICENSE']      = 'License';
$lang['CSK_PLUGINS_LICENSE_URI']  = 'License URI';
$lang['CSK_PLUGINS_AUTHOR']       = 'Author';
$lang['CSK_PLUGINS_AUTHOR_URI']   = 'Author URI';
$lang['CSK_PLUGINS_AUTHOR_EMAIL'] = 'Author Email';
$lang['CSK_PLUGINS_TAGS']         = 'Tags';
$lang['CSK_PLUGINS_ZIP']          = 'Plugin ZIP Archive';

// With extra string after.
$lang['CSK_PLUGINS_DETAILS_NAME'] = 'Plugin Details: %s';
$lang['CSK_PLUGINS_VERSION_NUM']  = 'Version: %s';
$lang['CSK_PLUGINS_LICENSE_NAME'] = 'License: %s';
$lang['CSK_PLUGINS_AUTHOR_NAME']  = 'By %s';
$lang['CSK_PLUGINS_TAGS_LIST']    = 'Tags: %s';

// Plugins filters.
$lang['CSK_PLUGINS_FILTER_ALL']      = 'All (%s)';
$lang['CSK_PLUGINS_FILTER_ACTIVE']   = 'Active (%s)';
$lang['CSK_PLUGINS_FILTER_INACTIVE'] = 'Inactive (%s)';

// Plugin install filters.
$lang['CSK_PLUGINS_FILTER_FEATURED']    = 'Featured';
$lang['CSK_PLUGINS_FILTER_POPULAR']     = 'Popular';
$lang['CSK_PLUGINS_FILTER_RECOMMENDED'] = 'Recommended';
$lang['CSK_PLUGINS_FILTER_NEW']         = 'New';
$lang['CSK_PLUGINS_SEARCH']             = 'Search plugins...';

// Plugin details with links.
$lang['CSK_PLUGINS_LICENSE_URI']  = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['CSK_PLUGINS_AUTHOR_URI']   = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['CSK_PLUGINS_AUTHOR_EMAIL_URI'] = '<a href="mailto:%1$s?subject=%2$s" target="_blank" rel="nofollow">Support</a>';

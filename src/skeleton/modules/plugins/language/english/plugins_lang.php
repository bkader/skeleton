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
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Plugins Module - Admin Language (English)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @version 	1.3.4
 */

// Plugin: singular and plural forms.
$lang['spg_plugin']  = 'Plugin';
$lang['spg_plugins'] = 'Plugins';

// Dashboard title.
$lang['spg_manage_plugins'] = 'Manage Plugins';

// Plugin' settings page.
$lang['spg_plugin_settings']      = 'Plugin Settings';
$lang['spg_plugin_settings_name'] = 'Plugin Settings: %s';

// Plugins actions.
$lang['spg_plugin_activate']   = 'Activate';
$lang['spg_plugin_add']        = 'Add Plugin';
$lang['spg_plugin_deactivate'] = 'Deactivate';
$lang['spg_plugin_delete']     = 'Delete';
$lang['spg_plugin_details']    = 'Details';
$lang['spg_plugin_install']    = 'Install Plugin';
$lang['spg_plugin_settings']   = 'Settings';
$lang['spg_plugin_upload']     = 'Upload Plugin';

$lang['spg_plugin_upload_tip'] = 'If you have a plugin in a .zip format, you may install it by uploading it here.';

// Confirmation messages.
$lang['spg_plugin_delete_confirm'] = 'Are you sure you want to delete this plugin and its data?';

// Success messages.
$lang['spg_plugin_activate_success']   = 'Plugin successfully activated.';
$lang['spg_plugin_deactivate_success'] = 'Plugin successfully deactivated.';
$lang['spg_plugin_delete_success']     = 'Plugin successfully delete.';
$lang['spg_plugin_install_success']    = 'Plugin successfully installed.';
$lang['spg_plugin_settings_success']   = 'Plugin settings successfully updated.';
$lang['spg_plugin_upload_success']     = 'Plugin successfully uploaded.';

// Error messages.
$lang['spg_plugin_activate_error']   = 'Unable to activate plugin.';
$lang['spg_plugin_deactivate_error'] = 'Unable to deactivate plugin.';
$lang['spg_plugin_delete_error']     = 'Unable to delete plugin.';
$lang['spg_plugin_install_error']    = 'Unable to install plugin.';
$lang['spg_plugin_settings_error']   = 'Unable to update plugin settings.';
$lang['spg_plugin_upload_error']     = 'Unable to upload plugin.';

// Errors when performing actions.
$lang['spg_plugin_missing']           = 'This plugin does not exist.';
$lang['spg_plugin_settings_disabled'] = 'You can only update settings of activated plugins.';
$lang['spg_plugin_settings_missing']  = 'This plugin does not have a settings page.';

// Plugin details.
$lang['spg_details']      = 'Plugin Details';
$lang['spg_name']         = 'Name';
$lang['spg_folder']       = 'Folder';
$lang['spg_plugin_uri']   = 'Plugin URI';
$lang['spg_description']  = 'Description';
$lang['spg_version']      = 'Version';
$lang['spg_license']      = 'License';
$lang['spg_license_uri']  = 'License URI';
$lang['spg_author']       = 'Author';
$lang['spg_author_uri']   = 'Author URI';
$lang['spg_author_email'] = 'Author Email';
$lang['spg_tags']         = 'Tags';
$lang['spg_plugin_zip']   = 'Plugin ZIP Archive';

// With extra string after.
$lang['spg_details_name'] = 'Plugin Details: %s';
$lang['spg_version_num']  = 'Version: %s';
$lang['spg_license_name'] = 'License: %s';
$lang['spg_author_name']  = 'By %s';
$lang['spg_tags_list']    = 'Tags: %s';

// Plugins filters.
$lang['spg_all']     = 'All (%s)';
$lang['spg_active']  = 'Active (%s)';
$lang['spg_inactive'] = 'Inactive (%s)';

// Plugin install filters.
$lang['spg_featured']    = 'Featured';
$lang['spg_popular']     = 'Popular';
$lang['spg_recommended'] = 'Recommended';
$lang['spg_new']         = 'New';
$lang['spg_search']      = 'Search plugins...';

// Plugin details with links.
$lang['spg_plugin_author_uri']   = '<a href="%1$s" target="_blank" rel="nofollow">Website</a>';
$lang['spg_plugin_license']      = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['spg_plugin_author']       = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';
$lang['spg_plugin_author_email'] = '<a href="mailto:%1$s?subject=%2$s" target="_blank" rel="nofollow">Support</a>';

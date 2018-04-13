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
 * @version 	1.3.3
 */

// Dashboard title.
$lang['spg_manage_plugins'] = 'Manage Plugisn';

// Plugin' settings page.
$lang['spg_plugin_settings']      = 'Plugin Settings';
$lang['spg_plugin_settings_name'] = 'Plugin Settings: %s';

// Plugin: singular and plural forms.
$lang['spg_plugin']  = 'Plugin';
$lang['spg_plugins'] = 'Plugins';

// Success messages.
$lang['spg_plugin_activate_success']   = 'Plugin successfully activated.';
$lang['spg_plugin_deactivate_success'] = 'Plugin successfully deactivated.';
$lang['spg_plugin_delete_success']    = 'Plugin successfully delete.';
$lang['spg_plugin_uploaded_success']   = 'Plugin successfully uploaded.';
$lang['spg_plugin_settings_success']   = 'Plugin settings successfully updated.';

// Error messages.
$lang['spg_plugin_activate_error']   = 'Unable to activate plugin.';
$lang['spg_plugin_deactivate_error'] = 'Unable to deactivate plugin.';
$lang['spg_plugin_delete_error']    = 'Unable to deleted plugin.';
$lang['spg_plugin_uploaded_error']   = 'Unable to uploaded plugin.';
$lang['spg_plugin_settings_error']   = 'Unable to update plugin settings.';

// Confirmation messages.
$lang['spg_plugin_delete_confirm'] = 'Are you sure you want to delete this plugin and its data?';

// Plugins actions.
$lang['spg_activate']   = 'Activate';
$lang['spg_deactivate'] = 'Deactivate';
$lang['spg_delete']     = 'Delete';
$lang['spg_settings']   = 'Settings';

// Plugins filters.
$lang['spg_all']     = 'All (%s)';
$lang['spg_active']  = 'Active (%s)';
$lang['spg_inactive'] = 'Inactive (%s)';

// Actions errors
$lang['spg_plugin_missing']           = 'This plugin does not exist.';
$lang['spg_plugin_settings_disabled'] = 'You can only update settings of activated plugins.';
$lang['spg_plugin_settings_missing']  = 'This plugin does not have a settings page.';

// Plugin details.
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
$lang['spg_tags']         = 'Author Email';

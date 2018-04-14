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
 * Activities language file (English)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.3.3
 * @version 	1.0.0
 */

$lang['sac_activities'] = 'Activities';
$lang['sac_activity'] = 'Activity';

// Dashboard title;
$lang['sac_activity_log'] = 'Activity Log';

// Activities table headings.
$lang['sac_user']       = 'User';
$lang['sac_module']     = 'Module';
$lang['sac_method']     = 'Method';
$lang['sac_ip_address'] = 'IP Address';
$lang['sac_date']       = 'Date';
$lang['sac_action']     = 'Action';

// Activities delete messages.
$lang['sac_activity_delete_confirm'] = 'Are you sure you want to delete this activity log?';
$lang['sac_activity_delete_success'] = 'Activity successfully deleted.';
$lang['sac_activity_delete_error']   = 'Unable to delete activity.';

// ------------------------------------------------------------------------
// Modules activities lines.
// ------------------------------------------------------------------------

// Language module.
$lang['act_language_enable'] = 'Enabled language: %s.';
$lang['act_language_disable'] = 'Disabled language: %s.';
$lang['act_language_default'] = 'Set %s as default language.';

// Media module.
$lang['act_media_upload'] = 'Uploaded media: #%s';
$lang['act_media_update'] = 'Updated media: #%s';
$lang['act_media_delete'] = 'Deleted media: #%s';

// Users module.
$lang['act_user_register']  = 'Joined the site.';
$lang['act_user_resend']    = 'Requested activation code: <abbr title="%s">%s</abbr>';
$lang['act_user_restore']   = 'Restored account.';
$lang['act_user_activated'] = 'Email activation.';
$lang['act_user_recover']   = 'Requested password code: <abbr title="%s">%s</abbr>';
$lang['act_user_reset']     = 'Reset password.';
$lang['act_user_login']     = 'Logged in.';

$lang['act_user_create']     = 'Created user: #%s';
$lang['act_user_update']     = 'Updated user: #%s';
$lang['act_user_activate']   = 'Activated user: #%s';
$lang['act_user_deactivate'] = 'Deactivated user: #%s';
$lang['act_user_delete']     = 'Deleted user: #%s';
$lang['act_user_restore']    = 'Restored user: #%s';
$lang['act_user_remove']     = 'Removed user: #%s';

// Menus module.
$lang['act_menus_add_menu']         = 'Added menu: #%s';
$lang['act_menus_edit_menu']        = 'Edited menu: #%s';
$lang['act_menus_update_locations'] = 'Updated menus location.';
$lang['act_menus_add_item']         = 'Added menu item: #%s';
$lang['act_menus_update_items']     = 'Updated menu items: #%s';
$lang['act_menus_delete_menu']      = 'Deleted menu: #%s';
$lang['act_menus_delete_item']      = 'Deleted menu item: #%s';

// Plugins Module.
$lang['act_plugin_activate']   = 'Activated plugin: %s';
$lang['act_plugin_deactivate'] = 'Deactivated plugin: %s';
$lang['act_plugin_delete']     = 'Deleted plugin: %s';

// Themes plugin.
$lang['act_themes_activate'] = 'Activated theme: %s';
$lang['act_themes_delete']   = 'Activated theme: %s';
$lang['act_themes_install']  = 'Installed theme: %s';
$lang['act_themes_upload']   = 'Uploaded theme: %s';

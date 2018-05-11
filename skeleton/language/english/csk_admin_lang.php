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
 * @since 		2.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard main language file (English)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */
// ------------------------------------------------------------------------
// Navbar items.
// ------------------------------------------------------------------------

$lang['CSK_ADMIN_DASHBOARD']   = 'Dashboard';
$lang['CSK_ADMIN_ADMIN_PANEL'] = 'Admin Panel';

// System menu.
$lang['CSK_ADMIN_SYSTEM']             = 'System';
$lang['CSK_ADMIN_GLOBAL_SETTINGS']    = 'Global Settings';
$lang['CSK_ADMIN_SYSTEM_INFORMATION'] = 'System Information';

// Users menu.
$lang['CSK_ADMIN_USERS']        = 'Users';
$lang['CSK_ADMIN_USERS_MANAGE'] = 'Manage Users';
$lang['CSK_ADMIN_USERS_GROUPS'] = 'Groups';
$lang['CSK_ADMIN_USERS_LEVELS'] = 'Access Levels';

// Content menu.
$lang['CSK_ADMIN_CONTENT'] = 'Content';

// Components Menu.
$lang['CSK_ADMIN_COMPONENTS'] = 'Components';

// Extensions menu.
$lang['CSK_ADMIN_EXTENSIONS']        = 'Extensions';
$lang['CSK_ADMIN_MODULES']           = 'Modules';
$lang['CSK_ADMIN_PLUGINS']           = 'Plugins';
$lang['CSK_ADMIN_THEMES']            = 'Themes';
$lang['CSK_ADMIN_LANGUAGES']         = 'Languages';
$lang['CSK_ADMIN_LANGUAGES_DEFAULT'] = 'Language - Default';

// Reports menu.
$lang['CSK_ADMIN_REPORTS'] = 'Reports';

// Help menu.
$lang['CSK_ADMIN_HELP']          = 'Help';
$lang['CSK_ADMIN_DOCUMENTATION'] = 'Documentation';
$lang['CSK_ADMIN_TRANSLATIONS']  = 'Translations';
$lang['CSK_ADMIN_SKELETON_SHOP'] = 'Skeleton Shop';

// ------------------------------------------------------------------------
// Footer section.
// ------------------------------------------------------------------------

$lang['CSK_ADMIN_FOOTER_TEXT']  = 'Thank your for creating with <a href="%s" target="_blank">CodeIgniter Skeleton</a>.';
$lang['CSK_ADMIN_VERSION_TEXT'] = 'Version: <strong>%s</strong> &#124; {elapsed_time}';

// ------------------------------------------------------------------------
// Manifest files.
// ------------------------------------------------------------------------

// manifest.json error.
$lang['CSK_ADMIN_MANIFEST_MISSING']   = 'This component\'s "manifest.json" file is either missing or badly formatted.';
$lang['CSK_ADMIN_COMPONENT_DISABLED'] = 'This component is disabled. Enable it on the dashboard in order to use it.';

// ------------------------------------------------------------------------
// Misc.
// ------------------------------------------------------------------------

// Anchors.
$lang['CSK_ADMIN_ANCHOR_TEMPLATE']          = '<a href="%2$s">%1$s</a>';
$lang['CSK_ADMIN_ANCHOR_TEMPLATE_NOFOLLOW'] = '<a href="%2$s" target="_blank" rel="nofollow">%1$s</a>';

// Application buttons.
$lang['CSK_ADMIN_ACTION']  = 'Action';
$lang['CSK_ADMIN_ACTIONS'] = 'Actions';

$lang['CSK_ADMIN_NO']  = 'NO';
$lang['CSK_ADMIN_YES'] = 'Yes';

$lang['CSK_ADMIN_OFF'] = 'Off';
$lang['CSK_ADMIN_ON']  = 'On';

$lang['CSK_ADMIN_ALL']  = 'All';
$lang['CSK_ADMIN_BOTH'] = 'Both';
$lang['CSK_ADMIN_NONE'] = 'None';

$lang['CSK_ADMIN_BTN_ADD']     = 'Add';
$lang['CSK_ADMIN_BTN_NEW']     = 'New';
$lang['CSK_ADMIN_BTN_ADD_NEW'] = 'Add New';
$lang['CSK_ADMIN_BTN_CREATE']  = 'Create';

$lang['CSK_ADMIN_BTN_EDIT']       = 'Edit';
$lang['CSK_ADMIN_BTN_EDIT_COM']   = 'Edit %s';

$lang['CSK_ADMIN_BTN_SAVE']       = 'Save';
$lang['CSK_ADMIN_BTN_SAVE_COM']   = 'Save %s';
$lang['CSK_ADMIN_BTN_UPDATE']     = 'Update';
$lang['CSK_ADMIN_BTN_UPDATE_COM'] = 'Update %s';

$lang['CSK_ADMIN_BTN_DISCARD_CHANGES'] = 'Discard Changes';
$lang['CSK_ADMIN_BTN_SAVE_CHANGES']    = 'Save Changes';

$lang['CSK_ADMIN_BTN_DELETE']     = 'Delete';
$lang['CSK_ADMIN_BTN_DELETE_COM'] = 'Delete %s';

$lang['CSK_ADMIN_BTN_REMOVE']     = 'Remove';
$lang['CSK_ADMIN_BTN_REMOVE_COM'] = 'Remove %s';

$lang['CSK_ADMIN_BTN_APPLY']   = 'Apply';
$lang['CSK_ADMIN_BTN_DONATE']  = 'Donate';
$lang['CSK_ADMIN_BTN_SUPPORT'] = 'Support';
$lang['CSK_ADMIN_BTN_WEBSITE'] = 'Website';

$lang['CSK_ADMIN_BTN_ENABLE']      = 'Enable';
$lang['CSK_ADMIN_BTN_ENABLE_COM']  = 'Enable %s';
$lang['CSK_ADMIN_BTN_DISABLE']     = 'Disable';
$lang['CSK_ADMIN_BTN_DISABLE_COM'] = 'Disable %s';

$lang['CSK_ADMIN_BTN_ACTIVATE']       = 'Activate';
$lang['CSK_ADMIN_BTN_ACTIVATE_COM']   = 'Activate %s';
$lang['CSK_ADMIN_BTN_DEACTIVATE']     = 'Deactivate';
$lang['CSK_ADMIN_BTN_DEACTIVATE_COM'] = 'Deactivate %s';

$lang['CSK_ADMIN_BTN_SETTINGS']     = 'Settings';
$lang['CSK_ADMIN_BTN_SETTINGS_COM'] = '%s Settings';

$lang['CSK_ADMIN_BTN_ADVANCED'] = 'Advanced';
$lang['CSK_ADMIN_BTN_BACK']     = 'Back';
$lang['CSK_ADMIN_BTN_CANCEL']   = 'Cancel';

// ------------------------------------------------------------------------
// Different statuses.
// ------------------------------------------------------------------------
$lang['CSK_ADMIN_STATUS']   = 'Status';
$lang['CSK_ADMIN_STATUSES'] = 'Statuses';

$lang['CSK_ADMIN_ACTIVATED']   = 'Activated';
$lang['CSK_ADMIN_ACTIVE']      = 'Active';
$lang['CSK_ADMIN_ADDED']       = 'Added';
$lang['CSK_ADMIN_CANCELED']    = 'Canceled';
$lang['CSK_ADMIN_CREATED']     = 'Created';
$lang['CSK_ADMIN_DEACTIVATED'] = 'Deactivated';
$lang['CSK_ADMIN_DELETED']     = 'Deleted';
$lang['CSK_ADMIN_DISABLED']    = 'Disabled';
$lang['CSK_ADMIN_EDITED']      = 'Edited';
$lang['CSK_ADMIN_ENABLED']     = 'Enabled';
$lang['CSK_ADMIN_INACTIVE']    = 'Inactive';
$lang['CSK_ADMIN_REMOVED']     = 'Removed';
$lang['CSK_ADMIN_SAVED']       = 'Saved';
$lang['CSK_ADMIN_UPDATED']     = 'Updated';

// ------------------------------------------------------------------------
// Components Details.
// ------------------------------------------------------------------------
$lang['CSK_ADMIN_DETAILS']          = 'Details';
$lang['CSK_ADMIN_COM_DETAILS']      = '%s Details';
$lang['CSK_ADMIN_COM_DETAILS_NAME'] = '%s Details: %s';
$lang['CSK_ADMIN_COM_AUTHOR']       = 'Author';
$lang['CSK_ADMIN_COM_AUTHOR_EMAIL'] = 'Author Email';
$lang['CSK_ADMIN_COM_AUTHOR_URI']   = 'Author URI';
$lang['CSK_ADMIN_COM_CONTENT']      = 'Content';
$lang['CSK_ADMIN_COM_DESCRIPTION']  = 'Description';
$lang['CSK_ADMIN_COM_FOLDER']       = 'Folder';
$lang['CSK_ADMIN_COM_LICENSE']      = 'License';
$lang['CSK_ADMIN_COM_LICENSE_URI']  = 'License URI';
$lang['CSK_ADMIN_COM_NAME']         = 'Name';
$lang['CSK_ADMIN_COM_SCREENSHOT']   = 'Screenshot';
$lang['CSK_ADMIN_COM_SLUG']         = 'Slug';
$lang['CSK_ADMIN_COM_TAGS']         = 'Tags';
$lang['CSK_ADMIN_COM_TITLE']        = 'Title';
$lang['CSK_ADMIN_COM_URI']          = '%s URI';
$lang['CSK_ADMIN_COM_URL']          = 'URL';
$lang['CSK_ADMIN_COM_VERSION']      = 'Version';
$lang['CSK_ADMIN_COM_ZIP']          = '%s ZIP Archive';

// Details with extra.
$lang['CSK_ADMIN_AUTHOR_NAME']  = 'Author: %s';
$lang['CSK_ADMIN_VERSION_NUM']  = 'Version: %s';
$lang['CSK_ADMIN_LICENSE_NAME'] = 'License: %s';

// ------------------------------------------------------------------------
// Confirmation messages.
// ------------------------------------------------------------------------
$lang['CSK_ADMIN_CONFIRM_ENABLE']     = 'Are you sure you want to enable this %s?';
$lang['CSK_ADMIN_CONFIRM_DISABLE']    = 'Are you sure you want to disable this %s?';
$lang['CSK_ADMIN_CONFIRM_ACTIVATE']   = 'Are you sure you want to activate this %s?';
$lang['CSK_ADMIN_CONFIRM_DEACTIVATE'] = 'Are you sure you want to deactivate this %s?';
$lang['CSK_ADMIN_CONFIRM_DELETE']     = 'Are you sure you want to delete this %s?';
$lang['CSK_ADMIN_CONFIRM_REMOVE']     = 'Are you sure you want to permanently delete this %s?';

// ------------------------------------------------------------------------
// Success messages.
// ------------------------------------------------------------------------
$lang['CSK_ADMIN_SUCCESS_ACTIVATE']   = '%s successfully activated.';
$lang['CSK_ADMIN_SUCCESS_ADD']        = '%s successfully added.';
$lang['CSK_ADMIN_SUCCESS_CREATE']     = '%s successfully created.';
$lang['CSK_ADMIN_SUCCESS_DEACTIVATE'] = '%s successfully deactivated.';
$lang['CSK_ADMIN_SUCCESS_DELETE']     = '%s successfully deleted.';
$lang['CSK_ADMIN_SUCCESS_DISABLE']    = '%s successfully disabled.';
$lang['CSK_ADMIN_SUCCESS_EDIT']       = '%s successfully edited.';
$lang['CSK_ADMIN_SUCCESS_ENABLE']     = '%s successfully enabled.';
$lang['CSK_ADMIN_SUCCESS_REMOVE']     = '%s permanently deleted.';
$lang['CSK_ADMIN_SUCCESS_SAVE']       = '%s successfully saved.';
$lang['CSK_ADMIN_SUCCESS_UPDATE']     = '%s successfully updated.';

// ------------------------------------------------------------------------
// Error messages.
// ------------------------------------------------------------------------
$lang['CSK_ADMIN_ERROR_ACTIVATE']   = 'Unable to activate %s.';
$lang['CSK_ADMIN_ERROR_ADD']        = 'Unable to add %s.';
$lang['CSK_ADMIN_ERROR_CREATE']     = 'Unable to create %s.';
$lang['CSK_ADMIN_ERROR_DEACTIVATE'] = 'Unable to deactivate %s.';
$lang['CSK_ADMIN_ERROR_DELETE']     = 'Unable to delete %s.';
$lang['CSK_ADMIN_ERROR_DISABLE']    = 'Unable to disable %s.';
$lang['CSK_ADMIN_ERROR_EDIT']       = 'Unable to edit %s.';
$lang['CSK_ADMIN_ERROR_ENABLE']     = 'Unable to enable %s.';
$lang['CSK_ADMIN_ERROR_REMOVE']     = 'Unable to permanently delete %s.';
$lang['CSK_ADMIN_ERROR_SAVE']       = 'Unable to save %s.';
$lang['CSK_ADMIN_ERROR_UPDATE']     = 'Unable to update %s.';

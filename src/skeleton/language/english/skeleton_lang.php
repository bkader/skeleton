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
 * Main application language file (English)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		Version 1.0.0
 * @version 	1.3.3
 */

// ------------------------------------------------------------------------
// General Buttons and Links.
// ------------------------------------------------------------------------
$lang['home']       = 'Home';
$lang['click_here'] = 'Click Here';
$lang['settings']   = 'Settings';

// ------------------------------------------------------------------------
// Forms Input.
// ------------------------------------------------------------------------

$lang['name']        = 'Name';
$lang['title']       = 'Title';
$lang['description'] = 'Description';
$lang['content']     = 'Content';
$lang['unspecified'] = 'Unspecified';
$lang['slug']        = 'Slug';
$lang['order']       = 'Order';
$lang['url']         = 'URL';

$lang['meta_title']       = 'Meta Title';
$lang['meta_description'] = 'Meta Description';
$lang['meta_keywords']    = 'Meta Keywords';

$lang['email']   = 'Email';
$lang['captcha'] = 'Captcha';
$lang['upload']  = 'Upload';
$lang['uploads'] = 'Uploads';

// Selection options.
$lang['none'] = 'None';
$lang['both'] = 'Both';
$lang['all']  = 'All';

// "More" links.
$lang['more']         = 'More';
$lang['more_details'] = 'More Details';
$lang['view_more']    = 'View More';

// Yes and No.
$lang['no']  = 'No';
$lang['yes'] = 'Yes';

// ------------------------------------------------------------------------
// Application buttons.
// ------------------------------------------------------------------------
$lang['action']  = 'Action';
$lang['actions'] = 'Actions';

$lang['add']    = 'Add';
$lang['new']    = 'new';
$lang['create'] = 'Create';

$lang['edit']   = 'Edit';
$lang['update'] = 'Update';
$lang['save']   = 'Save';

$lang['delete'] = 'Delete';
$lang['remove'] = 'Remove';

$lang['activate']   = 'Activate';
$lang['deactivate'] = 'Deactivate';

$lang['enable']  = 'Enable';
$lang['disable'] = 'Disable';

$lang['back']   = 'Back';
$lang['cancel'] = 'Cancel';

$lang['advanced'] = 'Advanced';

// Changes buttons.
$lang['discard_changed'] = 'Discard Changes';
$lang['save_changes']    = 'Save Changes';

// Different statuses.
$lang['status']   = 'Status';
$lang['statuses'] = 'Statuses';

$lang['added']   = 'Added';
$lang['created'] = 'Created';

$lang['edited']  = 'Edited';
$lang['updated'] = 'Updated';
$lang['saved']   = 'Saved';

$lang['deleted'] = 'Deleted';
$lang['removed'] = 'Removed';

$lang['activated']   = 'Activated';
$lang['deactivated'] = 'Deactivated';

$lang['active']   = 'Active';
$lang['inactive'] = 'Inactive';

$lang['enabled']  = 'Enabled';
$lang['disabled'] = 'Disabled';

$lang['canceled'] = 'Canceled';

// Actions performed by.
$lang['created_by']     = 'Created by';
$lang['updated_by']     = 'Updated by';
$lang['deleted_by']     = 'Deleted by';
$lang['removed_by']     = 'Removed by';
$lang['activated_by']   = 'Activated by';
$lang['deactivated_by'] = 'Deactivated by';
$lang['enabled_by']     = 'Enabled by';
$lang['disabled_by']    = 'Disabled by';
$lang['canceled_by']    = 'Canceled by';

// ------------------------------------------------------------------------
// General notices and messages.
// ------------------------------------------------------------------------

// Error messages.
$lang['error_csrf']              = 'This form did not pass our security controls.';
$lang['error_safe_url']          = 'This action did not pass our security controls.';
$lang['error_captcha']           = 'The captcha code your entered is incorrect.';
$lang['error_fields_required']   = 'All fields are required.';
$lang['error_permission']        = 'You do not have permission to access this page.';
$lang['error_logged_in']         = 'You are already logged in.';
$lang['error_logged_out']        = 'You must be logged in to access this page.';
$lang['error_account_missing']   = 'That user does not exist.';
$lang['error_action_permission'] = 'You do not have permission to perform this action.';

// ------------------------------------------------------------------------
// Form validation lines.
// ------------------------------------------------------------------------

$lang['form_validation_alpha_extra']       = 'The {field} may contain only alpha-numeric characters, spaces, periods, underscores and dashes.';
$lang['form_validation_check_credentials'] = 'Invalid username/email address and/or password.';
$lang['form_validation_current_password']  = 'Your current password in incorrect.';
$lang['form_validation_unique_email']      = 'This email address is alraedy in use.';
$lang['form_validation_unique_username']   = 'This username is not available.';
$lang['form_validation_user_exists']       = 'No user was found with that username or email address.';


// ========================================================================
// Dashboard Lines.
// ========================================================================

$lang['admin_panel'] = 'Admin Panel';
$lang['dashboard']   = 'Dashboard';
$lang['view_site']   = 'View Site';

// Confirmation before action.
$lang['are_you_sure'] = 'Are you sure you want to %s?';

// ------------------------------------------------------------------------
// Dashboard sections (singular and plural forms).
// ------------------------------------------------------------------------

// Users.
$lang['user']  = 'User';
$lang['users'] = 'Users';

// Media.
$lang['media']   = 'Media';
$lang['library'] = 'Library';

// Themes.
$lang['theme']  = 'Theme';
$lang['themes'] = 'Themes';

// Menus.
$lang['menu']  = 'Menu';
$lang['menus'] = 'Menus';

// Menus.
$lang['plugin']  = 'Plugin';
$lang['plugins'] = 'Plugins';

// Languages.
$lang['language']  = 'Language';
$lang['languages'] = 'Languages';

// Activities.
$lang['activity']   = 'Activity';
$lang['activities'] = 'Activities';

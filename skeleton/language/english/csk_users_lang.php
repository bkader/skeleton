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
 * Users language file (English)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		1.0.0
 * @version 	2.0.0
 */

$lang['CSK_USERS_MANAGE_USERS'] = 'Manage Users';
$lang['CSK_USERS_MEMBER_LOGIN'] = 'Member Login';

// Users actions.
$lang['CSK_USERS_ADD_USER']  = 'Add User';
$lang['CSK_USERS_ADD_GROUP'] = 'Add Group';
$lang['CSK_USERS_ADD_LEVEL'] = 'Add Access Level';

$lang['CSK_USERS_EDIT_USER']  = 'Edit User';
$lang['CSK_USERS_EDIT_GROUP'] = 'Edit Group';
$lang['CSK_USERS_EDIT_LEVEL'] = 'Edit Access Level';

$lang['CSK_USERS_DELETE_USER']  = 'Delete User';
$lang['CSK_USERS_DELETE_GROUP'] = 'Delete Group';
$lang['CSK_USERS_DELETE_LEVEL'] = 'Delete Access Level';

$lang['CSK_USERS_ACTIVATE_USER']   = 'Activate User';
$lang['CSK_USERS_DEACTIVATE_USER'] = 'Deactivate User';
$lang['CSK_USERS_RESTORE_USER']    = 'Restore User';
$lang['CSK_USERS_REMOVE_USER']     = 'Delete Permanently';

// Actions with name.
$lang['CSK_USERS_EDIT_USER_NAME']       = 'Edit User: %s';
$lang['CSK_USERS_DELETE_USER_NAME']     = 'Delete User: %s';
$lang['CSK_USERS_ACTIVATE_USER_NAME']   = 'Activate User: %s';
$lang['CSK_USERS_DEACTIVATE_USER_NAME'] = 'Deactivate User: %s';

// Users roles.
$lang['CSK_USERS_ROLE']  = 'Role';
$lang['CSK_USERS_ROLES'] = 'Roles';

$lang['CSK_USERS_ROLE_REGULAR']   = 'Regular';		// Level: 1
$lang['CSK_USERS_ROLE_PREMIUM']   = 'Premium';		// Level: 2
$lang['CSK_USERS_ROLE_AUTHOR']    = 'Author';		// Level: 3
$lang['CSK_USERS_ROLE_EDITOR']    = 'Editor';		// Level: 4
$lang['CSK_USERS_ROLE_MANAGER']   = 'Manager'; 		// Level: 6
$lang['CSK_USERS_ROLE_ADMIN']     = 'Admin';		// Level: 9
$lang['CSK_USERS_ROLE_OWNER']     = 'Owner';		// Level: 10

$lang['CSK_USERS_ROLE_ADMINISTRATOR'] = 'Admin'; // Alias of Admin.

// Users statuses.
$lang['CSK_USERS_ACTIVE']   = 'Active';
$lang['CSK_USERS_INACTIVE'] = 'Inactive';
$lang['CSK_USERS_DELETED']  = 'Deleted';

// Confirmation messages.
$lang['CSK_USERS_ADMIN_CONFIRM_ACTIVATE']   = 'Are you sure you want to activate this user?';
$lang['CSK_USERS_ADMIN_CONFIRM_DEACTIVATE'] = 'Are you sure you want to deactivate this user?';
$lang['CSK_USERS_ADMIN_CONFIRM_DELETE']     = 'Are you sure you want to delete this user?';
$lang['CSK_USERS_ADMIN_CONFIRM_RESTORE']    = 'Are you sure you want to restore this user?';
$lang['CSK_USERS_ADMIN_CONFIRM_REMOVE']     = 'Are you sure you want to permanently delete this user and all his/her data?';

// Success messages.
$lang['CSK_USERS_ADMIN_SUCCESS_ADD']        = 'User successfully created.';
$lang['CSK_USERS_ADMIN_SUCCESS_EDIT']       = 'User successfully updated.';
$lang['CSK_USERS_ADMIN_SUCCESS_ACTIVATE']   = 'User successfully activated.';
$lang['CSK_USERS_ADMIN_SUCCESS_DEACTIVATE'] = 'User successfully deactivated.';
$lang['CSK_USERS_ADMIN_SUCCESS_DELETE']     = 'User successfully deleted.';
$lang['CSK_USERS_ADMIN_SUCCESS_RESTORE']    = 'User successfully restored.';
$lang['CSK_USERS_ADMIN_SUCCESS_REMOVE']     = 'User and all his/her data permanently deleted.';

// Error messages.
$lang['CSK_USERS_ADMIN_ERROR_ADD']        = 'Unable to create user.';
$lang['CSK_USERS_ADMIN_ERROR_EDIT']       = 'Unable to update user.';
$lang['CSK_USERS_ADMIN_ERROR_ACTIVATE']   = 'Unable to activate user.';
$lang['CSK_USERS_ADMIN_ERROR_DEACTIVATE'] = 'Unable to deactivate user.';
$lang['CSK_USERS_ADMIN_ERROR_DELETE']     = 'Unable to delete user.';
$lang['CSK_USERS_ADMIN_ERROR_RESTORE']    = 'Unable to restore user.';
$lang['CSK_USERS_ADMIN_ERROR_REMOVE']     = 'Unable to permanently delete user and all his/her data.';

// Messages on own account.
$lang['CSK_USERS_ADMIN_ERROR_ACTIVATE_OWN']   = 'You cannot activate your own account.';
$lang['CSK_USERS_ADMIN_ERROR_DEACTIVATE_OWN'] = 'You cannot deactivate your own account.';
$lang['CSK_USERS_ADMIN_ERROR_DELETE_OWN']     = 'You cannot delete your own account.';
$lang['CSK_USERS_ADMIN_ERROR_RESTORE_OWN']    = 'You cannot restore your own account.';
$lang['CSK_USERS_ADMIN_ERROR_REMOVE_OWN']     = 'You cannot remove your own account.';

// ------------------------------------------------------------------------
// Account creation.
// ------------------------------------------------------------------------

// Success messages.
$lang['CSK_USERS_SUCCESS_CREATE']       = 'Account successfully created.';
$lang['CSK_USERS_SUCCESS_CREATE_LOGIN'] = 'Account successfully created. You may now login.';

// Info messages.
$lang['CSK_USERS_INFO_CREATE']        = 'Account successfully created. The activation link was sent to you.';
$lang['CSK_USERS_INFO_CREATE_MANUAL'] = 'All accounts require approval by a site administrator before being active. You will receive an email once approved.';

// Error messages.
$lang['CSK_USERS_ERROR_CREATE'] = 'Unable to create user account.';

// ------------------------------------------------------------------------
// Account activation.
// ------------------------------------------------------------------------

// Success messages.
$lang['CSK_USERS_SUCCESS_ACTIVATE']       = 'Account successfully activated.';
$lang['CSK_USERS_SUCCESS_ACTIVATE_LOGIN'] = 'Account successfully activated. You may now login.';

// Error messages.
$lang['CSK_USERS_ERROR_ACTIVATE']         = 'Unable to activate user account.';
$lang['CSK_USERS_ERROR_ACTIVATE_ALREADY'] = 'This account is already active.';
$lang['CSK_USERS_ERROR_ACTIVATE_CODE']    = 'This account activation link is no longer valid.';

// ------------------------------------------------------------------------
// Resend activation link.
// ------------------------------------------------------------------------
$lang['CSK_USERS_RESEND_LINK'] = 'Resend Activation Link';
$lang['CSK_USERS_RESEND_TIP']  = 'Enter your username or email address and we will send you a link to activate your account.';

// Success messages.
$lang['CSK_USERS_SUCCESS_RESEND'] = 'Account activation link successfully resent. Check your inbox or spam.';

// Error message.
$lang['CSK_USERS_ERROR_RESEND'] = 'Unable to resend account activation link.';

// ------------------------------------------------------------------------
// Member login.
// ------------------------------------------------------------------------
$lang['CSK_USERS_REMEMBER_ME'] = 'Remember me';

// Error messages.
$lang['CSK_USERS_ERROR_ACCOUNT_MISSING']       = 'This user does not exist.';
$lang['CSK_USERS_ERROR_ACCOUNT_INACTIVE']      = 'You account is not yet active. Use the link that was sent to you or %s to receive a new one.';
$lang['CSK_USERS_ERROR_ACCOUNT_BANNED']        = 'This user is banned from the site.';
$lang['CSK_USERS_ERROR_ACCOUNT_DELETED']       = 'Your account has been deleted but not yet removed from database. %s if you wish to restore it.';
$lang['CSK_USERS_ERROR_ACCOUNT_DELETED_ADMIN'] = 'Your account has been deleted by an administrator thus you cannot restore it. Feel free to contact us for more details.';

$lang['CSK_USERS_ERROR_LOGIN_CREDENTIALS'] = 'Invalid username/email address and/or password.';

// ------------------------------------------------------------------------
// Lost password section.
// ------------------------------------------------------------------------
$lang['CSK_USERS_RECOVER_TIP'] = 'Enter your username or email address and we will send you a link to activate your account.';

// Success messages.
$lang['CSK_USERS_SUCCESS_RECOVER'] = 'Password reset link successfully sent.';

// Error messages.
$lang['CSK_USERS_ERROR_RECOVER']         = 'Unable to send password reset link.';
$lang['CSK_USERS_ERROR_RECOVER_DELETED'] = 'Your account has been deleted but not yet removed from database. Contact us if you want it restored.';

// ------------------------------------------------------------------------
// Password reset section.
// ------------------------------------------------------------------------

// Success messages.
$lang['CSK_USERS_SUCCESS_RESET'] = 'Password successfully reset.';

// Error messages.
$lang['CSK_USERS_ERROR_RESET']      = 'Unable to reset password.';
$lang['CSK_USERS_ERROR_RESET_CODE'] = 'This password reset link is no longer valid.';

// ------------------------------------------------------------------------
// Restore account section.
// ------------------------------------------------------------------------

$lang['CSK_USERS_RESTORE_ACCOUNT'] = 'Restore Account';
$lang['CSK_USERS_RESTORE_TIP'] = 'Enter your username/email address and password to restore your account.';

// Success messages.
$lang['CSK_USERS_SUCCESS_RESTORE'] = 'Account successfully restored.';

// Error messages.
$lang['CSK_USERS_ERROR_RESTORE']         = 'Unable to restore account.';
$lang['CSK_USERS_ERROR_RESTORE_DELETED'] = 'Only deleted accounts can be restored.';

// ------------------------------------------------------------------------
// Users emails subjects.
// ------------------------------------------------------------------------
$lang['CSK_USERS_EMAIL_ACTIVATED']         = 'Account Activated';
$lang['CSK_USERS_EMAIL_EMAIL']             = 'Email Address changed';
$lang['CSK_USERS_EMAIL_EMAIL_PREP']        = 'Email Change Request';
$lang['CSK_USERS_EMAIL_MANUAL_ACTIVATION'] = 'Manual Activation';
$lang['CSK_USERS_EMAIL_PASSWORD']          = 'Password Changed';
$lang['CSK_USERS_EMAIL_RECOVER']           = 'Lost Password';
$lang['CSK_USERS_EMAIL_REGISTER']          = 'Account Activation';
$lang['CSK_USERS_EMAIL_RESEND']            = 'New Activation Link';
$lang['CSK_USERS_EMAIL_RESTORE']           = 'Account Restored';
$lang['CSK_USERS_EMAIL_WELCOME']           = 'Welcome to {site_name}';

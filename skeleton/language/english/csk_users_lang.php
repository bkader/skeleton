<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

// Users roles.
$lang['CSK_USERS_ROLE']  = 'Role';
$lang['CSK_USERS_ROLES'] = 'Roles';

$lang['CSK_USERS_ROLE_REGULAR']   = 'Regular';		// Level: 1
$lang['CSK_USERS_ROLE_PREMIUM']   = 'Premium';		// Level: 2
$lang['CSK_USERS_ROLE_AUTHOR']    = 'Author';		// Level: 3
$lang['CSK_USERS_ROLE_EDITOR']    = 'Editor';		// Level: 4
$lang['CSK_USERS_ROLE_PUBLISHER'] = 'Publisher'; 	// Level: 5
$lang['CSK_USERS_ROLE_MANAGER']   = 'Manager'; 		// Level: 6
$lang['CSK_USERS_ROLE_ADMIN']     = 'Admin';		// Level:  9
$lang['CSK_USERS_ROLE_OWNER']     = 'Owner';		// Level: 10

// Users statuses.
$lang['CSK_USERS_ACTIVE']   = 'Active';
$lang['CSK_USERS_INACTIVE'] = 'Inactive';

// Confirmation messages.
$lang['CSK_USERS_ADMIN_ACTIVATE_CONFIRM']   = 'Are you sure you want to activate this user?';
$lang['CSK_USERS_ADMIN_DEACTIVATE_CONFIRM'] = 'Are you sure you want to deactivate this user?';
$lang['CSK_USERS_ADMIN_DELETE_CONFIRM']     = 'Are you sure you want to delete this user?';
$lang['CSK_USERS_ADMIN_RESTORE_CONFIRM']    = 'Are you sure you want to restore this user?';
$lang['CSK_USERS_ADMIN_REMOVE_CONFIRM']     = 'Are you sure you want to remove this user and all related data?';

// Success messages.
$lang['CSK_USERS_ADMIN_ADD_SUCCESS']        = 'User successfully created.';
$lang['CSK_USERS_ADMIN_EDIT_SUCCESS']       = 'User successfully updated.';
$lang['CSK_USERS_ADMIN_ACTIVATE_SUCCESS']   = 'User successfully activated.';
$lang['CSK_USERS_ADMIN_DEACTIVATE_SUCCESS'] = 'User successfully deactivated.';
$lang['CSK_USERS_ADMIN_DELETE_SUCCESS']     = 'User successfully deleted.';
$lang['CSK_USERS_ADMIN_RESTORE_SUCCESS']    = 'User successfully restored.';
$lang['CSK_USERS_ADMIN_REMOVE_SUCCESS']     = 'User and related data successfully removed.';

// Error messages.
$lang['CSK_USERS_ADMIN_ADD_ERROR']        = 'Unable to create user.';
$lang['CSK_USERS_ADMIN_EDIT_ERROR']       = 'Unable to update user.';
$lang['CSK_USERS_ADMIN_ACTIVATE_ERROR']   = 'Unable to activate user.';
$lang['CSK_USERS_ADMIN_DEACTIVATE_ERROR'] = 'Unable to deactivate user.';
$lang['CSK_USERS_ADMIN_DELETE_ERROR']     = 'Unable to delete user.';
$lang['CSK_USERS_ADMIN_RESTORE_ERROR']    = 'Unable to restore user.';
$lang['CSK_USERS_ADMIN_REMOVE_ERROR']     = 'Unable to remove user and all related data.';

// Messages on own account.
$lang['CSK_USERS_ADMIN_ACTIVATE_ERROR_OWN']   = 'You cannot activate your own account.';
$lang['CSK_USERS_ADMIN_DEACTIVATE_ERROR_OWN'] = 'You cannot deactivate your own account.';
$lang['CSK_USERS_ADMIN_DELETE_ERROR_OWN']     = 'You cannot delete your own account.';
$lang['CSK_USERS_ADMIN_RESTORE_ERROR_OWN']    = 'You cannot restore your own account.';
$lang['CSK_USERS_ADMIN_REMOVE_ERROR_OWN']     = 'You cannot remove your own account.';

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

$lang['CSK_USERS_RESTORE_ACCOUNT']     = 'Restore Account';
$lang['CSK_USERS_RESTORE_TIP'] = 'Enter your username/email address and password to restore your account.';

// Success messages.
$lang['CSK_USERS_SUCCESS_RESTORE'] = 'Account successfully restored.';

// Error messages.
$lang['CSK_USERS_ERROR_RESTORE']         = 'Unable to restore account.';
$lang['CSK_USERS_ERROR_RESTORE_DELETED'] = 'Only deleted accounts can be restored.';

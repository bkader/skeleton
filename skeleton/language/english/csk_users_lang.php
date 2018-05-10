<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['CSK_USERS_CREATE_ACCOUNT']  = 'Create Account';
$lang['CSK_USERS_FORGOT_PASSWORD'] = 'Forgot password?';
$lang['CSK_USERS_LOST_PASSWORD']   = 'Lost password';
$lang['CSK_USERS_RESTORE_ACCOUNT'] = 'Restore account';

$lang['CSK_USERS_PROFILE']      = 'Profile';
$lang['CSK_USERS_VIEW_PROFILE'] = 'View Profile';
$lang['CSK_USERS_EDIT_PROFILE'] = 'Edit Profile';

// ------------------------------------------------------------------------

$lang['CSK_USERS_MANAGE_USERS'] = 'Manage Users';

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

// ========================================================================
// Users settings lines.
// ========================================================================

// Pages titles.
$lang['set_profile_title']  = 'Update Profile';
$lang['set_avatar_title']   = 'Update Avatar';
$lang['set_password_title'] = 'Change Password';
$lang['set_email_title']    = 'Change Email';

// Pages headings.
$lang['set_profile_heading']  = $lang['set_profile_title'];
$lang['set_avatar_heading']   = $lang['set_avatar_title'];
$lang['set_password_heading'] = $lang['set_password_title'];
$lang['set_email_heading']    = $lang['set_email_title'];

// Success messages.
$lang['set_profile_success']  = 'Profile successfully updated.';
$lang['set_avatar_success']   = 'Avatar successfully updated.';
$lang['set_password_success'] = 'Password successfully changed.';
$lang['set_email_success']    = 'Email address successfully changed.';

// Error messages.
$lang['set_profile_error']     = 'Unable to update profile.';
$lang['set_avatar_error']      = 'Unable to update avatar.';
$lang['set_password_error']    = 'Unable to change password.';
$lang['set_email_error']       = 'Unable to change email address.';
$lang['set_email_invalid_key'] = 'This new email link is no longer valid.';

// Info messages.
$lang['set_email_info'] = 'A link to change your email address has been sent to your new address.';

// Avatar extra lines.
$lang['update_avatar']       = 'Update Avatar';
$lang['add_image']           = 'Add Image';
$lang['use_gravatar']        = 'Use Gravatar';
$lang['use_gravatar_notice'] = 'If you check this option, your uploaded profile picture will be deleted and your <a href="%s" target="_blank">Gravatar</a> image will be used instead.';

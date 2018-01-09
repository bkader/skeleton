<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Users Module - Users Language File (English)
 *
 * @package 	CodeIgniter
 * @subpackage 	Modules
 * @category 	Languages
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */

// ------------------------------------------------------------------------
// Users Buttons.
// ------------------------------------------------------------------------
$lang['login']           = 'Sign In';
$lang['logout']          = 'Sign Out';
$lang['register']        = 'Register';
$lang['create_account']  = 'Create Account';
$lang['forgot_password'] = 'Forgot password?';
$lang['lost_password']   = 'Lost password';
$lang['send_link']       = 'Send link';
$lang['resend_link']     = 'Resend link';
$lang['restore_account'] = 'Restore account';

// ------------------------------------------------------------------------
// General Inputs and Label.
// ------------------------------------------------------------------------
$lang['username']          = 'Username';
$lang['identity']          = 'Username or email address';

$lang['email_address']     = 'Email address';
$lang['new_email_address'] = 'New email address';

$lang['password']          = 'Password';
$lang['new_password']      = 'New password';
$lang['confirm_password']  = 'Confirm password';
$lang['current_password']  = 'Current password';

$lang['first_name']        = 'First name';
$lang['last_name']         = 'Last name';
$lang['full_name']         = 'Full name';

$lang['gender']            = 'Gender';
$lang['male']              = 'Male';
$lang['female']            = 'Female';

$lang['company']  = 'Company';
$lang['phone']    = 'Phone';
$lang['address']  = 'Address';
$lang['location'] = 'Location';

// ------------------------------------------------------------------------
// Registration page.
// ------------------------------------------------------------------------
$lang['us_register_title'] = 'Register';
$lang['us_register_heading'] = 'Create Account';

$lang['us_register_success'] = 'Account successfully created. You may now login.';
$lang['us_register_info']    = 'Account successfully created. The activation link was sent to you.';
$lang['us_register_error']   = 'Unable to create account.';

// ------------------------------------------------------------------------
// Account activation.
// ------------------------------------------------------------------------
$lang['us_activate_invalid_key'] = 'This account activation link is no longer valid.';
$lang['us_activate_error']       = 'Unable to activate account.';
$lang['us_activate_success']     = 'Account successfully activated. You may now login';

// ------------------------------------------------------------------------
// Resend activation link.
// ------------------------------------------------------------------------
$lang['us_resend_title'] = 'Resend Activation Link';
$lang['us_resend_heading'] = 'Resend Link';

$lang['us_resend_notice']  = 'Enter your username or email address and we will send you a link to activate your account.';
$lang['us_resend_error']   = 'Unable to resend account activation link.';
$lang['us_resend_enabled'] = 'This account is already enabled.';
$lang['us_resend_success'] = 'Account activation link successfully resent. Check your inbox or spam.';

// ------------------------------------------------------------------------
// Login page.
// ------------------------------------------------------------------------
$lang['us_login_title']   = 'Sign In';
$lang['us_login_heading'] = 'Member Login';
$lang['remember_me']      = 'Remember me';

$lang['us_wrong_credentials'] = 'Invalid username/email address and/or password.';
$lang['us_account_disabled']  = 'You account is not yet active. Use the link that was sent to you or %s to receive a new one.';
$lang['us_account_banned']    = 'This user is banned from the site.';
$lang['us_account_deleted']   = 'Your account has been deleted by not yet removed from database. %s if you wish to restore it.';

// ------------------------------------------------------------------------
// Lost password page.
// ------------------------------------------------------------------------
$lang['us_recover_title']   = 'Lost Password';
$lang['us_recover_heading'] = 'Lost Password';

$lang['us_recover_notice']  = 'Enter your username or email address and we will send you a link to reset your password.';
$lang['us_recover_success'] = 'Password reset link successfully sent.';
$lang['us_recover_error']   = 'Unable to send password reset link.';


// ------------------------------------------------------------------------
// Reset password page.
// ------------------------------------------------------------------------
$lang['us_reset_title']   = 'Reset Password';
$lang['us_reset_heading'] = 'Reset Password';

$lang['us_reset_invalid_key'] = 'This password reset link is no longer valid.';
$lang['us_reset_error']       = 'Unable to reset password.';
$lang['us_reset_success']     = 'Password successfully reset.';

// ------------------------------------------------------------------------
// Restore account page.
// ------------------------------------------------------------------------
$lang['us_restore_title']   = 'Restore Account';
$lang['us_restore_heading'] = 'Restore Account';

$lang['us_restore_notice']  = 'Enter your username/email address and password to restore your account.';
$lang['us_restore_deleted'] = 'Only deleted accounts can be restored.';
$lang['us_restore_error']   = 'Unable to restore account.';
$lang['us_restore_success'] = 'Account successfully restored. Welcome back!';

// ------------------------------------------------------------------------
// Admin Panel
// ------------------------------------------------------------------------
$lang['users'] = 'Users';
$lang['us_manage_users'] = 'Manage Users';

$lang['profile']      = 'Profile';
$lang['view_profile'] = 'View Profile';
$lang['edit_profile'] = 'Edit Profile';

$lang['delete_user'] = 'Delete User';
$lang['view_user']   = 'View User';

$lang['role']  = 'Role';
$lang['roles'] = 'Roles';

$lang['regular'] = 'Regular';
$lang['premium'] = 'Premium';
$lang['author']  = 'Author';
$lang['editor']  = 'Editor';
$lang['admin']   = 'Administrator';

$lang['active']   = 'Active';
$lang['inactive'] = 'Inactive';

// ------------------------------------------------------------------------

// Add user.
$lang['add_user']             = 'Add User';
$lang['us_admin_add_success'] = 'User successfully created.';
$lang['us_admin_add_error']   = 'Unable to create user.';

// ------------------------------------------------------------------------

// Edit user.
$lang['edit_user']             = 'Edit User';
$lang['us_admin_edit_success'] = 'Account successfully updated.';
$lang['us_admin_edit_error']   = 'Unable to update account.';

// ------------------------------------------------------------------------

// Activate user.
$lang['us_admin_activate_success'] = 'User successfully activated.';
$lang['us_admin_activate_error']   = 'Unable to activate user.';

// ------------------------------------------------------------------------

// Deactivate user.
$lang['us_admin_deactivate_success'] = 'User successfully deactivated.';
$lang['us_admin_deactivate_error']   = 'Unable to deactivate user.';

// ------------------------------------------------------------------------

// Delete user.
$lang['us_admin_delete_success'] = 'User successfully deleted.';
$lang['us_admin_delete_error']   = 'Unable to delete user.';

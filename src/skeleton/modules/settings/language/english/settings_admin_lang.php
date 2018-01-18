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
 * Settings Module - Admin language (English)
 *
 * @package 	CodeIgniter
 * @subpackage 	Modules
 * @category 	Language
 * @author 	Kader Bouyakoub <bkader@mail.com>
 * @link 	https://github.com/bkader
 */

$lang['settings'] = 'Settings';

$lang['set_update_error']   = 'Unable to update settings.';
$lang['set_update_success'] = 'Settings successfully updated.';

// ------------------------------------------------------------------------
// General Settings.
// ------------------------------------------------------------------------
$lang['general'] = 'General';
$lang['site_settings'] = 'Site Settings';

// Site name.
$lang['set_site_name']     = 'Site Name';
$lang['set_site_name_tip'] = 'Enter the name of your website.';

// Site description.
$lang['set_site_description']     = 'Site Description';
$lang['set_site_description_tip'] = 'Enter a short description for your website.';

// Site keywords.
$lang['set_site_keywords']     = 'Site Keywords';
$lang['set_site_keywords_tip'] = 'Enter your comma-separated site keywords.';

// Site author.
$lang['set_site_author']     = 'Site Author';
$lang['set_site_author_tip'] = 'Enter the site author if your want to add the author meta tag.';

// Per page.
$lang['set_per_page']     = 'Per Page';
$lang['set_per_page_tip'] = 'How many items are shown on pages using pagination.';

// Google analytics.
$lang['set_google_analytics_id'] = 'Google Anaytilcs ID';
$lang['set_google_analytics_id_tip'] = 'Enter your Google Anaytilcs ID';

// Google site verification.
$lang['set_google_site_verification'] = 'Google Site Verification';
$lang['set_google_site_verification_tip'] = 'Enter your Google site verification code.';

// ------------------------------------------------------------------------
// Users Settings.
// ------------------------------------------------------------------------
$lang['users_settings'] = 'Users Settings';

// Allow registration.
$lang['set_allow_registration']     = 'Allow Registration';
$lang['set_allow_registration_tip'] = 'Whether to allow users to create account on your site.';

// Email activation.
$lang['set_email_activation']     = 'Email Activation';
$lang['set_email_activation_tip'] = 'Whether to force users to verify their email addresses before being allowed to log in.';

// Manual activation.
$lang['set_manual_activation']     = 'Manual Activation';
$lang['set_manual_activation_tip'] = 'Whether to manually verify users accounts.';

// Login type.
$lang['set_login_type']     = 'Login Type';
$lang['set_login_type_tip'] = 'Users may log in using usernames, email addresses or both.';

// Allow multi sessions.
$lang['set_allow_multi_session']     = 'Allow Multi Sessions';
$lang['set_allow_multi_session_tip'] = 'Whether to allow multiple users to login to the same account at the same time.';

// Use Gravatar.
$lang['set_use_gravatar']     = 'Use Gravatar';
$lang['set_use_gravatar_tip'] = 'Use gravatar or allow users to upload their avatars.';

// ------------------------------------------------------------------------
// Email Settings
// ------------------------------------------------------------------------
$lang['email_settings'] = 'Email Settings';

// Admin email.
$lang['set_admin_email']     = 'Admin Email';
$lang['set_admin_email_tip'] = 'The email address to which site notices are sent.';

// Server email.
$lang['set_server_email']     = 'Server Email';
$lang['set_server_email_tip'] = 'The email address used to send emails to users. Set as "From". You can use "noreply@..." or an existing email address.';

// Mail protocol.
$lang['set_mail_protocol'] = 'Mail Protocol';
$lang['set_mail_protocol_tip'] = 'Choose the mail protocol you want to send emails with.';

// Sendmail Path.
$lang['set_sendmail_path'] = 'Sendmail Path';
$lang['set_sendmail_path_tip'] = 'Enter the sendmail path. Default: /usr/sbin/sendmail. Required only if using Sendmail protocol.';

// SMTP host.
$lang['set_smtp_host'] = 'SMTP Host';
$lang['set_smtp_host_tip'] = 'Enter the SMTP host name (i.e: smtp.gmail.com). Required only if using SMTP protocol.';

// SMTP port.
$lang['set_smtp_port'] = 'SMTP Port';
$lang['set_smtp_port_tip'] = 'Enter the SMTP port number provided by your host. Required only if using SMTP protocol.';

// SMTP crypt.
$lang['set_smtp_crypto'] = 'SMTP Encryption';
$lang['set_smtp_crypto_tip'] = 'Choose the SMTP encryption.';

// SMTP user.
$lang['set_smtp_user'] = 'SMTP Username';
$lang['set_smtp_user_tip'] = 'Enter the username of your SMTP account.';

// SMTP pass.
$lang['set_smtp_pass'] = 'SMTP Password';
$lang['set_smtp_pass_tip'] = 'Enter the password of your SMTP account.';

// ------------------------------------------------------------------------
// Upload settings
// ------------------------------------------------------------------------
$lang['upload_settings'] = 'Upload Settings';

// Upload path.
$lang['set_upload_path'] = 'Upload Path';
$lang['set_upload_path_tip'] = 'The path where different allowed files are uploaded to. Default: content/uploads/';

// Allowed file types.
$lang['set_allowed_types'] = 'Allowed Files';
$lang['set_allowed_types_tip'] = 'List of files that are allowed to be uploaded. Use "&#124;" to separate between types.';

// ------------------------------------------------------------------------
// Captcha Settings.
// ------------------------------------------------------------------------
$lang['captcha_settings'] = 'Captcha settings';

// Use captcha.
$lang['set_use_captcha'] = 'Use captcha';
$lang['set_use_captcha_tip'] = 'Whether to enable captcha on some site forms.';

// Use reCAPTCHA.
$lang['set_use_recaptcha'] = 'Use reCAPTCHA';
$lang['set_use_recaptcha_tip'] = 'Use Google reCAPTCHA if enabled, otherwise use CodeIgniter built-in captcha if Use captcha is set to Yes.';

// reCAPTCHA site key.
$lang['set_recaptcha_site_key'] = 'reCAPTCHA Site Key';
$lang['set_recaptcha_site_key_tip'] = 'Enter the reCAPTCHA site key provided by Google.';

// reCAPTCHA private key.
$lang['set_recaptcha_private_key'] = 'reCAPTCHA Private Key';
$lang['set_recaptcha_private_key_tip'] = 'Enter the reCAPTCHA private key provided by Google.';

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
 * @since 		2.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Global settings language (English')
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Language
 * @author 		Kader Bouyakoub <bkader[at]mail[dot]com>
 * @link 		https://goo.gl/wGXHO9
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://goo.gl/wGXHO9)
 * @since 		2.0.0
 * @version 	2.0.0
 */

// ------------------------------------------------------------------------
// Tabs sections.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_SYSTEM_INFORMATION'] = 'System Information';
$lang['CSK_SETTINGS_PHP_SETTINGS']       = 'PHP Settings';
$lang['CSK_SETTINGS_PHP_INFO']           = 'PHP Information';

// ------------------------------------------------------------------------
// Table headings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_SETTING'] = 'Setting';
$lang['CSK_SETTINGS_VALUE']   = 'Value';

// ------------------------------------------------------------------------
// System information.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_PHP_BUILT_ON']     = 'PHP Built On';
$lang['CSK_SETTINGS_PHP_VERSION']      = 'PHP Version';
$lang['CSK_SETTINGS_DATABASE_TYPE']    = 'Database Type';
$lang['CSK_SETTINGS_DATABASE_VERSION'] = 'Database Version';
$lang['CSK_SETTINGS_WEB_SERVER']       = 'Web Server';
$lang['CSK_SETTINGS_SKELETON_VERSION'] = 'Skeleton Version';
$lang['CSK_SETTINGS_USER_AGENT']       = 'User Agent';

// ------------------------------------------------------------------------
// PHP Settings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_SAFE_MODE']          = 'Safe Mode';
$lang['CSK_SETTINGS_DISPLAY_ERRORS']     = 'Display Errors';
$lang['CSK_SETTINGS_SHORT_OPEN_TAG']     = 'Short Open Tag';
$lang['CSK_SETTINGS_FILE_UPLOADS']       = 'File Uploads';
$lang['CSK_SETTINGS_MAGIC_QUOTES_GPC']   = 'Magic Quotes';
$lang['CSK_SETTINGS_REGISTER_GLOBALS']   = 'Register Globals';
$lang['CSK_SETTINGS_OUTPUT_BUFFERING']   = 'Output Buffering';
$lang['CSK_SETTINGS_OPEN_BASEDIR']       = 'Open basedir';
$lang['CSK_SETTINGS_SESSION.SAVE_PATH']  = 'Session Save Path';
$lang['CSK_SETTINGS_SESSION.AUTO_START'] = 'Session Auto Start';
$lang['CSK_SETTINGS_DISABLE_FUNCTIONS']  = 'Disabled Functions';
$lang['CSK_SETTINGS_XML']                = 'XML Enabled';
$lang['CSK_SETTINGS_ZLIB']               = 'Zlib Enabled';
$lang['CSK_SETTINGS_ZIP']                = 'Native ZIP Enabled';
$lang['CSK_SETTINGS_MBSTRING']           = 'Multibyte String (mbstring) Enabled';
$lang['CSK_SETTINGS_ICONV']              = 'Iconv Available';
$lang['CSK_SETTINGS_MAX_INPUT_VARS']     = 'Maximum Input Variables';

// ------------------------------------------------------------------------
// General Settings
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_TAB_GENERAL'] = 'General';

// Site name.
$lang['CSK_SETTINGS_SITE_NAME']     = 'Site Name';
$lang['CSK_SETTINGS_SITE_NAME_TIP'] = 'Enter the name of your website.';

// Site description.
$lang['CSK_SETTINGS_SITE_DESCRIPTION']     = 'Site Description';
$lang['CSK_SETTINGS_SITE_DESCRIPTION_TIP'] = 'Enter a short description for your website.';

// Site keywords.
$lang['CSK_SETTINGS_SITE_KEYWORDS']     = 'Site Keywords';
$lang['CSK_SETTINGS_SITE_KEYWORDS_TIP'] = 'Enter your comma-separated site keywords.';

// Site author.
$lang['CSK_SETTINGS_SITE_AUTHOR']     = 'Site Author';
$lang['CSK_SETTINGS_SITE_AUTHOR_TIP'] = 'Enter the site author if your want to add the author meta tag.';

// Site favicon.
$lang['CSK_SETTINGS_SITE_FAVICON']     = 'Site Favicon';
$lang['CSK_SETTINGS_SITE_FAVICON_TIP'] = 'Enter the URL to the image or icon you want to use as your site\'s favicon.';

// Base controller.
$lang['CSK_SETTINGS_BASE_CONTROLLER']     = 'Base Controller';
$lang['CSK_SETTINGS_BASE_CONTROLLER_TIP'] = 'The controller used as your default homepage.';

// Per page.
$lang['CSK_SETTINGS_PER_PAGE']     = 'Per Page';
$lang['CSK_SETTINGS_PER_PAGE_TIP'] = 'How many items are shown on pages using pagination.';

// Google analytics.
$lang['CSK_SETTINGS_GOOGLE_ANALYTICS_ID'] = 'Google Analytics ID';
$lang['CSK_SETTINGS_GOOGLE_ANALYTICS_ID_TIP'] = 'Enter your Google Analytics ID';

// Google site verification.
$lang['CSK_SETTINGS_GOOGLE_SITE_VERIFICATION'] = 'Google Site Verification';
$lang['CSK_SETTINGS_GOOGLE_SITE_VERIFICATION_TIP'] = 'Enter your Google site verification code.';

// ------------------------------------------------------------------------
// Captcha Settings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_TAB_CAPTCHA'] = 'Captcha';

// Use captcha.
$lang['CSK_SETTINGS_USE_CAPTCHA'] = 'Use captcha';
$lang['CSK_SETTINGS_USE_CAPTCHA_TIP'] = 'Whether to enable captcha on some site forms.';

// Use reCAPTCHA.
$lang['CSK_SETTINGS_USE_RECAPTCHA'] = 'Use reCAPTCHA';
$lang['CSK_SETTINGS_USE_RECAPTCHA_TIP'] = 'Use Google reCAPTCHA if enabled, otherwise use CodeIgniter built-in captcha if Use captcha is set to Yes.';

// reCAPTCHA site key.
$lang['CSK_SETTINGS_RECAPTCHA_SITE_KEY'] = 'reCAPTCHA Site Key';
$lang['CSK_SETTINGS_RECAPTCHA_SITE_KEY_TIP'] = 'Enter the reCAPTCHA site key provided by Google.';

// reCAPTCHA private key.
$lang['CSK_SETTINGS_RECAPTCHA_PRIVATE_KEY'] = 'reCAPTCHA Private Key';
$lang['CSK_SETTINGS_RECAPTCHA_PRIVATE_KEY_TIP'] = 'Enter the reCAPTCHA private key provided by Google.';

// ------------------------------------------------------------------------
// Email Settings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_TAB_EMAIL'] = 'Email';

// Admin email.
$lang['CSK_SETTINGS_ADMIN_EMAIL']     = 'Admin Email';
$lang['CSK_SETTINGS_ADMIN_EMAIL_TIP'] = 'The email address to which site notices are sent.';

// Server email.
$lang['CSK_SETTINGS_SERVER_EMAIL']     = 'Server Email';
$lang['CSK_SETTINGS_SERVER_EMAIL_TIP'] = 'The email address used to send emails to users. Set as "From". You can use "noreply@..." or an existing email address.';

// Mail protocol.
$lang['CSK_SETTINGS_MAIL_PROTOCOL'] = 'Mail Protocol';
$lang['CSK_SETTINGS_MAIL_PROTOCOL_TIP'] = 'Choose the mail protocol you want to send emails with.';

// Sendmail Path.
$lang['CSK_SETTINGS_SENDMAIL_PATH'] = 'Sendmail Path';
$lang['CSK_SETTINGS_SENDMAIL_PATH_TIP'] = 'Enter the sendmail path. Default: /usr/sbin/sendmail. Required only if using Sendmail protocol.';

// SMTP host.
$lang['CSK_SETTINGS_SMTP_HOST'] = 'SMTP Host';
$lang['CSK_SETTINGS_SMTP_HOST_TIP'] = 'Enter the SMTP host name (i.e: smtp.gmail.com). Required only if using SMTP protocol.';

// SMTP port.
$lang['CSK_SETTINGS_SMTP_PORT'] = 'SMTP Port';
$lang['CSK_SETTINGS_SMTP_PORT_TIP'] = 'Enter the SMTP port number provided by your host. Required only if using SMTP protocol.';

// SMTP crypt.
$lang['CSK_SETTINGS_SMTP_CRYPTO'] = 'SMTP Encryption';
$lang['CSK_SETTINGS_SMTP_CRYPTO_TIP'] = 'Choose the SMTP encryption.';

// SMTP user.
$lang['CSK_SETTINGS_SMTP_USER'] = 'SMTP Username';
$lang['CSK_SETTINGS_SMTP_USER_TIP'] = 'Enter the username of your SMTP account.';

// SMTP pass.
$lang['CSK_SETTINGS_SMTP_PASS'] = 'SMTP Password';
$lang['CSK_SETTINGS_SMTP_PASS_TIP'] = 'Enter the password of your SMTP account.';

// ------------------------------------------------------------------------
// Upload Settings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_TAB_UPLOAD'] = 'Uploads';

// Upload path.
$lang['CSK_SETTINGS_UPLOAD_PATH'] = 'Upload Path';
$lang['CSK_SETTINGS_UPLOAD_PATH_TIP'] = 'The path where different allowed files are uploaded to. Default: content/uploads/';

// Allowed file types.
$lang['CSK_SETTINGS_ALLOWED_TYPES'] = 'Allowed Files';
$lang['CSK_SETTINGS_ALLOWED_TYPES_TIP'] = 'List of files that are allowed to be uploaded. Use "&#124;" to separate between types.';

// Max file sizes.
$lang['CSK_SETTINGS_MAX_SIZE']     = 'Max File Size';
$lang['CSK_SETTINGS_MAX_SIZE_TIP'] = 'The maximum size (in kilobytes) that the file can be. Set to zero for no limit.';

// Images min width and height
$lang['CSK_SETTINGS_MIN_WIDTH']      = 'Min width';
$lang['CSK_SETTINGS_MIN_WIDTH_TIP']  = 'The minimum width in pixels. Set to zero for no limit.';
$lang['CSK_SETTINGS_MIN_HEIGHT']     = 'Min Height';
$lang['CSK_SETTINGS_MIN_HEIGHT_TIP'] = 'The minimum height in pixels. Set to zero for no limit.';

// Images max width and height
$lang['CSK_SETTINGS_MAX_WIDTH']      = 'Max width';
$lang['CSK_SETTINGS_MAX_WIDTH_TIP']  = 'The maximum width in pixels. Set to zero for no limit.';
$lang['CSK_SETTINGS_MAX_HEIGHT']     = 'Max Height';
$lang['CSK_SETTINGS_MAX_HEIGHT_TIP'] = 'The maximum height in pixels. Set to zero for no limit.';

// ------------------------------------------------------------------------
// Users Settings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_TAB_USERS'] = 'Users';

// Allow registration.
$lang['CSK_SETTINGS_ALLOW_REGISTRATION']     = 'Allow Registration';
$lang['CSK_SETTINGS_ALLOW_REGISTRATION_TIP'] = 'Whether to allow users to create account on your site.';

// Email activation.
$lang['CSK_SETTINGS_EMAIL_ACTIVATION']     = 'Email Activation';
$lang['CSK_SETTINGS_EMAIL_ACTIVATION_TIP'] = 'Whether to force users to verify their email addresses before being allowed to log in.';

// Manual activation.
$lang['CSK_SETTINGS_MANUAL_ACTIVATION']     = 'Manual Activation';
$lang['CSK_SETTINGS_MANUAL_ACTIVATION_TIP'] = 'Whether to manually verify users accounts.';

// Login type.
$lang['CSK_SETTINGS_LOGIN_TYPE']     = 'Login Type';
$lang['CSK_SETTINGS_LOGIN_TYPE_TIP'] = 'Users may log in using usernames, email addresses or both.';

// Allow multi sessions.
$lang['CSK_SETTINGS_ALLOW_MULTI_SESSION']     = 'Allow Multi Sessions';
$lang['CSK_SETTINGS_ALLOW_MULTI_SESSION_TIP'] = 'Whether to allow multiple users to login to the same account at the same time.';

// Use Gravatar.
$lang['CSK_SETTINGS_USE_GRAVATAR']     = 'Use Gravatar';
$lang['CSK_SETTINGS_USE_GRAVATAR_TIP'] = 'Use gravatar or allow users to upload their avatars.';

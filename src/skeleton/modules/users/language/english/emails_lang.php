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
 * @since 		1.3.3
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Users Module - Emails Language (English)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.3.3
 * @version 	1.3.3
 */

// ========================================================================
// User registration.
// ========================================================================

// -------------------------------------------------------------------
// Welcome message.
// -------------------------------------------------------------------
$lang['us_email_welcome_subject'] = 'Welcome to {site_name}';
$lang['us_email_welcome_message'] = <<<EOT
Hello {name},

Most people have really long welcome email sequences after you register on their site.

Good news: we aren't most people.
But, we want to welcome you anyways, and thank you for joining us at {site_link}.

Hoping you enjoy your stay, please accept our kind regards.

-- {site_name} Team.
EOT;

// -------------------------------------------------------------------
// Manual activation message.
// -------------------------------------------------------------------
$lang['us_email_manual_subject'] = 'Manual Activation';
$lang['us_email_manual_message'] = <<<EOT
Hello {name},

Thank you for joining us at {site_link}. Your account is created but needs approval by a site admin before being active.
We sincerely apologies for this crucial step, but it is only for security purposes.

You will receive a confirmation email as soon as your account is approved.

Hoping you enjoy your stay, please accept our kind regards.

-- {site_name} Team.
EOT;

// -------------------------------------------------------------------
// Account activation email.
// -------------------------------------------------------------------
$lang['us_email_activation_subject'] = 'Account Activation';
$lang['us_email_activation_message'] = <<<EOT
Hello {name},

Thank you for registering at {site_link}. Your account is created and must be activated before you can use it.

To activate your account click on the following link or copy-paste it in your browser:
{link}

Very kind regards,
-- {site_name} Team.
EOT;

// -------------------------------------------------------------------
// Account activated email.
// -------------------------------------------------------------------
$lang['us_email_activated_subject'] = 'Account Activated';
$lang['us_email_activated_message'] = <<<EOT
Hello {name},

Your account at {site_link} was successfully activated. You may now <a href="{login_url}" target="_blank">login</a> anytime you want.

Hoping you enjoy your stay, please accept our kind regards.

-- {site_name} Team.
EOT;

// -------------------------------------------------------------------
// New activation link email.
// -------------------------------------------------------------------
$lang['us_email_new_activation_subject'] = 'New Activation Link';
$lang['us_email_new_activation_message'] = <<<EOT
Hello {name},

You have recently requested a new activation link on {site_link} because your account was not active.
To activate your account click on the following link or copy-paste it in your browser:
{link}

If you did not request this, no further action is required.

This action was requested from this IP address: {ip_link}.

Very kind regards,
-- {site_name} Team.
EOT;

// -------------------------------------------------------------------
// Password recover email.
// -------------------------------------------------------------------
$lang['us_email_recover_subject'] = 'Password Reset';
$lang['us_email_recover_message'] = <<<EOT
Hello {name},

You are receiving this email because we received a password reset request for your account on {site_link}.

Click on the following link or copy-paste it in your browser if you wish to proceed:
{link}

If you did not request a password reset, no further action is required.

This action was requested from this IP address: {ip_link}.

Kind regards,
-- {site_name} Team.
EOT;

// -------------------------------------------------------------------
// Password reset/change email.
// -------------------------------------------------------------------
$lang['us_email_password_subject'] = 'Password Changed';
$lang['us_email_password_message'] = <<<EOT
Hello {name},

This email confirms that your password at {site_link} has been successfully changed. You may now <a href="{login_url}" target="_blank">login</a> using the new one.

If you did not perform this action, please contact us as quick as possible to resolve this issue.

This action was performed from this IP address: {ip_link}.

Kind regards,
-- {site_name} Team.
EOT;

// -------------------------------------------------------------------
// Restored account email.
// -------------------------------------------------------------------
$lang['us_email_restore_subject'] = 'Account Restored';
$lang['us_email_restore_message'] = <<<EOT
Hello {name},

This email confirms that your account at {site_link} has been successfully restored.

Welcome back with us and we hope this time you will enjoy your stay.

Kind regards,
-- {site_name} Team.
EOT;

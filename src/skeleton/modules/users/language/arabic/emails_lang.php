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
 * Users Module - Emails Language (Arabic)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright 	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.3.3
 * @version 	1.4.0
 */

// ========================================================================
// User registration.
// ========================================================================

// -------------------------------------------------------------------
// Welcome message.
// -------------------------------------------------------------------
$lang['us_email_welcome_subject'] = 'مرحبًا بك في {site_name}';
$lang['us_email_welcome_message'] = <<<EOT
مرحبًا {name}،

معظم الناس لديهم رسائل ترحيب طويلة حقا بعد التسجيل في موقعهم.

خبر سار: لسنا معظم الناس.
ولكننا نريد أن نرحب بك على أي حال، ونشكرك على انضمامك إلينا على {site_link}.

على أمل التمتع بإقامتك، يرجى قبول تحياتنا.

-- فريق {site_name}.
EOT;

// -------------------------------------------------------------------
// Manual activation message.
// -------------------------------------------------------------------
$lang['us_email_manual_subject'] = 'تفعيل يدوي';
$lang['us_email_manual_message'] = <<<EOT
مرحبًا {name}،

نشكرك على الانضمام إلينا في {site_link}. تم إنشاء حسابك ولكن يحتاج إلى موافقة من قبل مسؤول الموقع قبل أن يكون نشطًا. نعتذر بشدة عن هذه الخطوة ولكنها لأغراض أمنية فقط.

ستتلقى رسالة تأكيد بمجرد تنشيطه حسابك.

على أمل التمتع بإقامتك، يرجى قبول تحياتنا.

-- فريق {site_name}.
EOT;

// -------------------------------------------------------------------
// Account activation email.
// -------------------------------------------------------------------
$lang['us_email_activation_subject'] = 'تنشيط الحساب';
$lang['us_email_activation_message'] = <<<EOT
مرحبًا {name}،

شكرًا لك على التسجيل في {site_link}. تم إنشاء حسابك ويجب تنشيطه قبل أن تتمكن من استخدامه.

لتنشيط حسابك، انقر على الرابط التالي أو انسخه في متصفحك:
{link}

مع أطيب التحيات،
-- فريق {site_name}.
EOT;

// -------------------------------------------------------------------
// Account activated email.
// -------------------------------------------------------------------
$lang['us_email_activated_subject'] = 'تم تنشيط الحساب';
$lang['us_email_activated_message'] = <<<EOT
مرحبًا {name}،

تم تفعيل حسابك في {site_link} بنجاح. يمكنك الآن <a href="{login_url}" target="_blank">تسجيل الدخول</a>.

على أمل التمتع بإقامتك، يرجى قبول تحياتنا.

-- فريق {site_name}.
EOT;

// -------------------------------------------------------------------
// New activation link email.
// -------------------------------------------------------------------
$lang['us_email_new_activation_subject'] = 'رابط تنشيط الجديد';
$lang['us_email_new_activation_message'] = <<<EOT
مرحبًا {name}،

لقد طلبت مؤخرًا رابطاً جديداً لتنشيط حسابك على {site_link} لأن حسابك لم يكن مفعلاً.
لتنشيط حسابك، انقر على الرابط التالي أو انسخه في متصفحك:
{link}

إذا لم تطلب ذلك، الرجاء تجاهل هذه الرسالة..

تم طلب هذا الإجراء من عنوان IP هذا: {ip_link}.

مع أطيب التحيات،
-- فريق {site_name}.
EOT;

// -------------------------------------------------------------------
// Password recover email.
// -------------------------------------------------------------------
$lang['us_email_recover_subject'] = 'إعادة تعيين كلمة المرور';
$lang['us_email_recover_message'] = <<<EOT
مرحبًا {name}،

لقد تلقيت هذه الرسالة الإلكترونية لأننا تلقينا طلبًا لإعادة تعيين كلمة المرور لحسابك على {site_link}.

انقر فوق الرابط التالي أو قم بنسخه ولصقه في المستعرض الخاص بك إذا كنت ترغب في المتابعة:
{link}

إذا لم تطلب إعادة تعيين كلمة المرور، الرجاء تجاهل هذه الرسالة..

تم طلب هذا الإجراء من عنوان IP هذا: {ip_link}.

أطيب التحيات،
-- فريق {site_name}.
EOT;

// -------------------------------------------------------------------
// Password reset/change email.
// -------------------------------------------------------------------
$lang['us_email_password_subject'] = 'تم تغيير كلمة السر';
$lang['us_email_password_message'] = <<<EOT
مرحبًا {name}،

تؤكد هذه الرسالة الإلكترونية أنه تم تغيير كلمة مرورك على الموقع {site_link} بنجاح. يمكنك الآن <a href="{login_url}" target="_blank">تسجيل الدخول</a> باستخدام كلمات السر الجديدة.

إذا لم تقم بتنفيذ هذا الإجراء، فالرجاء الاتصال بنا في أسرع وقت ممكن لحل هذه المشكلة.

تم تنفيذ هذا الإجراء من عنوان IP هذا: {ip_link}.

أطيب التحيات،
-- فريق {site_name}.
EOT;

// -------------------------------------------------------------------
// Restored account email.
// -------------------------------------------------------------------
$lang['us_email_restore_subject'] = 'تم إستعادة الحساب';
$lang['us_email_restore_message'] = <<<EOT
مرحبًا {name}،

تؤكد هذه الرسالة الإلكترونية أنه تمت استعادة حسابك على الموقع {site_link} بنجاح.

مرحبًا بك مرة أخرى ونأمل أن تستمتع بإقامتك في هذا المرة.

أطيب التحيات،
-- فريق {site_name}.
EOT;

// ------------------------------------------------------------------------
// Email change request.
// ------------------------------------------------------------------------
$lang['us_email_prep_email_subject'] = 'طلب تغيير البريد الالكتروني';
$lang['us_email_prep_email_message'] = <<<EOT
مرحبًا {name}،

لقد تلقيت هذه الرسالة الإلكترونية لأننا تلقينا طلبًا لتغيير عنوان بريدك الالكتروني لحسابك على {site_link}.

انقر فوق الرابط التالي أو قم بنسخه ولصقه في المستعرض الخاص بك إذا كنت ترغب في المتابعة:
{link}

إذا لم تطلب تغيير عنوان بريدك الالكتروني، الرجاء تجاهل هذه الرسالة.

تم طلب هذا الإجراء من عنوان IP هذا: {ip_link}.

أطيب التحيات،
-- فريق {site_name}.
EOT;

// ------------------------------------------------------------------------
// Email changed.
// ------------------------------------------------------------------------
$lang['us_email_email_subject'] = 'تم تغيير البريد الالكتروني';
$lang['us_email_email_message'] = <<<EOT
مرحبًا {name}،

تؤكد هذه الرسالة الإلكترونية أنه تم تغيير عنوان بريدك الالكتروني على الموقع {site_link} بنجاح.

إذا لم تقم بتنفيذ هذا الإجراء، فالرجاء الاتصال بنا في أسرع وقت ممكن لحل هذه المشكلة.

تم تنفيذ هذا الإجراء من عنوان IP هذا: {ip_link}.

أطيب التحيات،

-- فريق {site_name}.
EOT;

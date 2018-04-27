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
 * @since 		1.0.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Settings Module - Admin Language (Arabic)
 *
 * @package 	CodeIgniter
 * @subpackage 	Skeleton
 * @category 	Modules\Language
 * @author 		Kader Bouyakoub <bkader@mail.com>
 * @link 		https://github.com/bkader
 * @copyright	Copyright (c) 2018, Kader Bouyakoub (https://github.com/bkader)
 * @since 		1.0.0
 * @since 		1.3.3 	Renamed to "settings_lang" because the other file was merged
 *          			into "users_lang" file.
 *
 * @version 	1.3.3
 */

$lang['settings'] = 'الإعدادات';

$lang['set_update_error']   = 'تعذر تحديث الإعدادات.';
$lang['set_update_success'] = 'تم تحديث الإعدادات بنجاح.';

// ------------------------------------------------------------------------
// General Settings.
// ------------------------------------------------------------------------
$lang['general'] = 'الاعدادات العامة';
$lang['site_settings'] = 'إعدادات الموقع';

// Site name.
$lang['set_site_name']     = 'اسم الموقع';
$lang['set_site_name_tip'] = 'أدخل اسما لموقعك.';

// Site description.
$lang['set_site_description']     = 'وصف الموقع';
$lang['set_site_description_tip'] = 'أدخل وصفا موجزا لموقعك.';

// Site keywords.
$lang['set_site_keywords']     = 'الكلمات الرئيسية للموقع';
$lang['set_site_keywords_tip'] = 'أدخل كلماتك الرئيسية المفصولة بفواصل.';

// Site author.
$lang['set_site_author']     = 'مؤلف الموقع';
$lang['set_site_author_tip'] = 'أدخل مؤلف الموقع إذا كنت تريد إضافة العلامة الوصفية للمؤلف &lt;meta&gt;.';

// Base controller.
$lang['set_base_controller']     = 'النموذج الرئيسي';
$lang['set_base_controller_tip'] = 'النموذج المستخدم لعرض الصفحة الرئيسية.';

// Per page.
$lang['set_per_page']     = 'لكل صفحة';
$lang['set_per_page_tip'] = 'عدد العناصر التي يتم عرضها على الصفحات المجزأة.';

// Google analytics.
$lang['set_google_analytics_id'] = 'Google Analytics ID';
$lang['set_google_analytics_id_tip'] = 'أدخل Google Analytics ID.';

// Google site verification.
$lang['set_google_site_verification'] = 'Google Site Verification';
$lang['set_google_site_verification_tip'] = 'أدخل رمز التحقق من موقع غوغل.';

// ------------------------------------------------------------------------
// Users Settings.
// ------------------------------------------------------------------------
$lang['users_settings'] = 'إعدادات المستخدمين';

// Allow registration.
$lang['set_allow_registration']     = 'السماح بالتسجيل';
$lang['set_allow_registration_tip'] = 'ما إذا كان سيتم السماح للمستخدمين بإنشاء حساب على موقعك أم لا.';

// Email activation.
$lang['set_email_activation']     = 'تنشيط البريد الإلكتروني';
$lang['set_email_activation_tip'] = 'ما إذا كان يلزم على المستخدمين التحقق من عناوين بريدهم الإلكتروني قبل السماح لهم بتسجيل الدخول.';

// Manual activation.
$lang['set_manual_activation']     = 'تشغيل يدوي';
$lang['set_manual_activation_tip'] = 'ما إذا كان سيتم التحقق من حسابات المستخدمين يدويا أم لا.';

// Login type.
$lang['set_login_type']     = 'نوع تسجيل الدخول';
$lang['set_login_type_tip'] = 'يمكن للمستخدمين تسجيل الدخول باستخدام أسماء المستخدمين وعناوين البريد الإلكتروني أو كليهما.';

// Allow multi sessions.
$lang['set_allow_multi_session']     = 'السماح بالجلسات المتعددة';
$lang['set_allow_multi_session_tip'] = 'السماح لعدة مستخدمين بتسجيل الدخول إلى نفس الحساب في نفس الوقت.';

// Use Gravatar.
$lang['set_use_gravatar']     = 'استخدام غرافاتار';
$lang['set_use_gravatar_tip'] = 'استخدام غرافاتار أو السماح للمستخدمين بتحميل الصور الخاصة بهم.';

// ------------------------------------------------------------------------
// Email Settings
// ------------------------------------------------------------------------
$lang['email_settings'] = 'إعدادات البريد الإلكتروني';

// Admin email.
$lang['set_admin_email']     = 'البريد الإلكتروني للمشرف';
$lang['set_admin_email_tip'] = 'عنوان البريد الإلكتروني الذي يتم إرسال إشعارات الموقع إليه.';

// Server email.
$lang['set_server_email']     = 'البريد الإلكتروني للخادم';
$lang['set_server_email_tip'] = 'عنوان البريد الإلكتروني المستخدم لإرسال رسائل إلكترونية إلى المستخدمين. يمكنك استخدام "noreply@ ..." أو عنوان بريد إلكتروني موجود.';

// Mail protocol.
$lang['set_mail_protocol'] = 'بروتوكول البريد';
$lang['set_mail_protocol_tip'] = 'اختر بروتوكول البريد الذي تريد إرسال رسائل البريد الإلكتروني به.';

// Sendmail Path.
$lang['set_sendmail_path'] = 'مسار Sendmail';
$lang['set_sendmail_path_tip'] = 'أدخل مسار Sendmail. الافتراضي: " /usr/sbin/sendmail". مطلوب فقط في حالة استخدام بروتوكول Sendmail.';

// SMTP host.
$lang['set_smtp_host'] = 'مضيف SMTP';
$lang['set_smtp_host_tip'] = 'أدخل اسم مضيف SMTP (على سبيل المثال: smtp.gmail.com). مطلوب فقط عند استخدام بروتوكول SMTP.';

// SMTP port.
$lang['set_smtp_port'] = 'منفذ SMTP';
$lang['set_smtp_port_tip'] = 'أدخل رقم منفذ SMTP الذي يقدمه المضيف. مطلوب فقط عند استخدام بروتوكول SMTP.';

// SMTP crypt.
$lang['set_smtp_crypto'] = 'تشفير SMTP';
$lang['set_smtp_crypto_tip'] = 'اختر تشفير SMTP.';

// SMTP user.
$lang['set_smtp_user'] = 'اسم مستخدم SMTP';
$lang['set_smtp_user_tip'] = 'أدخل اسم المستخدم لحساب SMTP.';

// SMTP pass.
$lang['set_smtp_pass'] = 'كلمة مرور SMTP';
$lang['set_smtp_pass_tip'] = 'أدخل كلمة المرور لحساب SMTP.';

// ------------------------------------------------------------------------
// Upload settings
// ------------------------------------------------------------------------
$lang['upload_settings'] = 'إعدادات التحميل';

// Upload path.
$lang['set_upload_path'] = 'مسار التحميل';
$lang['set_upload_path_tip'] = 'The path where different allowed files are uploaded to. Default: content/uploads/';
$lang['set_upload_path_tip'] = 'المسار الذي يتم تحميل الملفات المسموح بها إليه. الافتراضي: content/uploads/';

// Allowed file types.
$lang['set_allowed_types'] = 'الملفات المسموح بها';
$lang['set_allowed_types_tip'] = 'قائمة الملفات التي يسمح بتحميلها. استخدم "|" للفصل بين الأنواع.';

// Date/month folder.
$lang['set_upload_year_month'] = 'تنظيم الملفات';
$lang['set_upload_year_month_tip'] = 'تنظيم التحميلات في مجلدات شهرية وسنوية.';

// Max file sizes.
$lang['set_max_size'] = 'الحد الأقصى لحجم الملف';
$lang['set_max_size_tip'] = 'الحجم الأقصى للملفات بالكيلوبايت. صفر لإزالة الحدود.';

// Images max width and height
$lang['set_min_image_size'] = 'الحد الأدنى لأبعاد الصور';
$lang['set_min_height']     = 'أدنى ارتفاع';
$lang['set_min_width']      = 'أدنى عرض';
$lang['set_min_width_tip']  = 'أدنى عرض بالبكسل. صفر بلا حدود.';
$lang['set_min_height_tip'] = 'أدنى ارتفاع بالبكسل. صفر لإزالة الحدود.';


// Images max width and height
$lang['set_max_image_size'] = 'أبعاد الصور القصوى';
$lang['set_max_height']     = 'أقصى ارتفاع';
$lang['set_max_width']      = 'أقصى عرض';
$lang['set_max_width_tip']  = 'أقصى عرض بالبكسل. صفر لإزالة الحدود.';
$lang['set_max_height_tip'] = 'أقصى ارتفاع بالبكسل. صفر لإزالة الحدود.';

// Small thumbnails with and height.
$lang['set_image_thumbnail']       = 'الصور المصغرة';
$lang['set_image_thumbnail_h']     = 'الارتفاع بالبكسل';
$lang['set_image_thumbnail_w']     = 'العرض بالبكسل';
$lang['set_image_thumbnail_h_tip'] = 'الارتفاع الصور المصغرة.';
$lang['set_image_thumbnail_w_tip'] = 'العرض الصور المصغرة.';

// Thumbnails crop.
$lang['set_image_thumbnail_crop']     = 'قص المصغارت';
$lang['set_image_thumbnail_crop_tip'] = 'قص المصغرة للحجم المحدد.';

// Medium size images width and height.
$lang['set_image_medium']       = 'الصور لمتوسطة';
$lang['set_image_medium_h']     = 'الارتفاع بالبكسل';
$lang['set_image_medium_w']     = 'العرض بالبكسل';
$lang['set_image_medium_h_tip'] = 'ارتفاع الصور المتوسطة.';
$lang['set_image_medium_w_tip'] = 'عرض الصور المتوسطة.';

// Large images width and height
$lang['set_image_large']       = 'الصور الكبيرة';
$lang['set_image_large_h']     = 'الارتفاع بالبكسل';
$lang['set_image_large_w']     = 'العرض بالبكسل';
$lang['set_image_large_h_tip'] = 'ارتفاع الصور الكبيرة.';
$lang['set_image_large_w_tip'] = 'عرض الصور الكبيرة.';

// ------------------------------------------------------------------------
// Captcha Settings.
// ------------------------------------------------------------------------
$lang['captcha_settings'] = 'إعدادات كابتشا';

// Use captcha.
$lang['set_use_captcha'] = 'استخدام كابتشا';
$lang['set_use_captcha_tip'] = 'ما إذا كان سيتم تمكين كابتشا في بعض نماذج المواقع.';

// Use reCAPTCHA.
$lang['set_use_recaptcha'] = 'استخدام reCAPTCHA';
$lang['set_use_recaptcha_tip'] = 'استخدم غوغل reCAPTCHA في حالة تمكينه، وإلا استخدم كابتشا المدمج في CodeIgniter إذا تم تعيين كابتشا على نعم.';

// reCAPTCHA site key.
$lang['set_recaptcha_site_key'] = 'مفتاح الموقع reCAPTCHA';
$lang['set_recaptcha_site_key_tip'] = 'أدخل مفتاح موقع reCAPTCHA الذي وفره غوغل لك.';

// reCAPTCHA private key.
$lang['set_recaptcha_private_key'] = 'مفتاح خاص reCAPTCHA';
$lang['set_recaptcha_private_key_tip'] = 'أدخل المفتاح الخاص reCAPTCHA الذي وفره غوغل لك.';

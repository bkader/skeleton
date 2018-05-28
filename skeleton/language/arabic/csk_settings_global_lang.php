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
$lang['CSK_SETTINGS_SYSTEM_INFORMATION'] = 'معلومات النظام';
$lang['CSK_SETTINGS_PHP_SETTINGS']       = 'إعدادات PHP';
$lang['CSK_SETTINGS_PHP_INFO']           = 'معلومات PHP';

// ------------------------------------------------------------------------
// Table headings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_SETTING'] = 'الوضع';
$lang['CSK_SETTINGS_VALUE']   = 'القيمة';

// ------------------------------------------------------------------------
// System information.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_PHP_BUILT_ON']     = 'معلومات نظام التشغيل';
$lang['CSK_SETTINGS_PHP_VERSION']      = 'نسخة PHP';
$lang['CSK_SETTINGS_DATABASE_TYPE']    = 'نوع قاعدة البيانات';
$lang['CSK_SETTINGS_DATABASE_VERSION'] = 'نسخة قاعدة البيانات';
$lang['CSK_SETTINGS_WEB_SERVER']       = 'السيرفر';
$lang['CSK_SETTINGS_SKELETON_VERSION'] = 'نسخة سكلتون';
$lang['CSK_SETTINGS_USER_AGENT']       = 'متصفح المستخدم';

// ------------------------------------------------------------------------
// PHP Settings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_SAFE_MODE']          = 'الوضع الآمن Safe Mode';
$lang['CSK_SETTINGS_DISPLAY_ERRORS']     = 'عرض الأخطاء';
$lang['CSK_SETTINGS_SHORT_OPEN_TAG']     = 'الوسوم القصيرة المفتوحة Short Open Tags';
$lang['CSK_SETTINGS_FILE_UPLOADS']       = 'رفع الملفات';
$lang['CSK_SETTINGS_MAGIC_QUOTES_GPC']   = 'الإقتباسات السحرية Magic Quotes';
$lang['CSK_SETTINGS_REGISTER_GLOBALS']   = 'التسجيل العام Register Globals';
$lang['CSK_SETTINGS_OUTPUT_BUFFERING']   = 'تخزين المخرجات Output Buffering';
$lang['CSK_SETTINGS_OPEN_BASEDIR']       = 'مجلد الدليل الأساسي المفتوح (الموقع) Open basedir';
$lang['CSK_SETTINGS_SESSION.SAVE_PATH']  = 'مسار حفظ الجلسة Session save path';
$lang['CSK_SETTINGS_SESSION.AUTO_START'] = 'بداية تلقائية للجلسة Session auto start';
$lang['CSK_SETTINGS_DISABLE_FUNCTIONS']  = 'الوظائف المعطلة';
$lang['CSK_SETTINGS_XML']                = 'تفعيل XML';
$lang['CSK_SETTINGS_ZLIB']               = 'تفعيل Zlib';
$lang['CSK_SETTINGS_ZIP']                = 'قابلية ضغط الملفات مفعلة';
$lang['CSK_SETTINGS_MBSTRING']           = 'تمكين الجمل متعددة البايتات Mbstring Enabled';
$lang['CSK_SETTINGS_ICONV']              = 'Iconv متاح';
$lang['CSK_SETTINGS_MAX_INPUT_VARS']     = 'متغيرات الإدخال القصوى';

// ------------------------------------------------------------------------
// General Settings
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_TAB_GENERAL'] = 'العامة';

// Site name.
$lang['CSK_SETTINGS_SITE_NAME']     = 'اسم الموقع';
$lang['CSK_SETTINGS_SITE_NAME_TIP'] = 'أدخل اسما لموقعك.';

// Site description.
$lang['CSK_SETTINGS_SITE_DESCRIPTION']     = 'وصف الموقع';
$lang['CSK_SETTINGS_SITE_DESCRIPTION_TIP'] = 'أدخل وصفا موجزا لموقعك.';

// Site keywords.
$lang['CSK_SETTINGS_SITE_KEYWORDS']     = 'الكلمات الرئيسية للموقع';
$lang['CSK_SETTINGS_SITE_KEYWORDS_TIP'] = 'أدخل كلماتك الرئيسية المفصولة بفواصل.';

// Site author.
$lang['CSK_SETTINGS_SITE_AUTHOR']     = 'مؤلف الموقع';
$lang['CSK_SETTINGS_SITE_AUTHOR_TIP'] = 'أدخل مؤلف الموقع إذا كنت تريد إضافة العلامة الوصفية للمؤلف &lt;meta&gt;.';

// Site favicon.
$lang['CSK_SETTINGS_SITE_FAVICON']     = 'فافيكون الموقع';
$lang['CSK_SETTINGS_SITE_FAVICON_TIP'] = 'أدخل عنوان URL للصورة أو الرمز الذي تريد استخدامه كرمز favicon لموقعك.';

// Base controller.
$lang['CSK_SETTINGS_BASE_CONTROLLER']     = 'النموذج الرئيسي';
$lang['CSK_SETTINGS_BASE_CONTROLLER_TIP'] = 'النموذج المستخدم لعرض الصفحة الرئيسية.';

// Per page.
$lang['CSK_SETTINGS_PER_PAGE']     = 'لكل صفحة';
$lang['CSK_SETTINGS_PER_PAGE_TIP'] = 'عدد العناصر التي يتم عرضها على الصفحات المجزأة.';

// Google analytics.
$lang['CSK_SETTINGS_GOOGLE_ANALYTICS_ID'] = 'Google Analytics ID';
$lang['CSK_SETTINGS_GOOGLE_ANALYTICS_ID_TIP'] = 'أدخل Google Analytics ID.';

// Google site verification.
$lang['CSK_SETTINGS_GOOGLE_SITE_VERIFICATION'] = 'Google Site Verification';
$lang['CSK_SETTINGS_GOOGLE_SITE_VERIFICATION_TIP'] = 'أدخل رمز التحقق من موقع غوغل.';

// ------------------------------------------------------------------------
// Captcha Settings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_TAB_CAPTCHA'] = 'كابتشا';

// Use captcha.
$lang['CSK_SETTINGS_USE_CAPTCHA'] = 'استخدام كابتشا';
$lang['CSK_SETTINGS_USE_CAPTCHA_TIP'] = 'ما إذا كان سيتم تمكين كابتشا في بعض نماذج المواقع.';

// Use reCAPTCHA.
$lang['CSK_SETTINGS_USE_RECAPTCHA'] = 'استخدام reCAPTCHA';
$lang['CSK_SETTINGS_USE_RECAPTCHA_TIP'] = 'استخدم غوغل reCAPTCHA في حالة تمكينه، وإلا استخدم كابتشا المدمج في CodeIgniter إذا تم تعيين كابتشا على نعم.';

// reCAPTCHA site key.
$lang['CSK_SETTINGS_RECAPTCHA_SITE_KEY'] = 'مفتاح الموقع reCAPTCHA';
$lang['CSK_SETTINGS_RECAPTCHA_SITE_KEY_TIP'] = 'أدخل مفتاح موقع reCAPTCHA الذي وفره غوغل لك.';

// reCAPTCHA private key.
$lang['CSK_SETTINGS_RECAPTCHA_PRIVATE_KEY'] = 'مفتاح خاص reCAPTCHA';
$lang['CSK_SETTINGS_RECAPTCHA_PRIVATE_KEY_TIP'] = 'أدخل المفتاح الخاص reCAPTCHA الذي وفره غوغل لك.';

// ------------------------------------------------------------------------
// Email Settings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_TAB_EMAIL'] = 'البريد';

// Admin email.
$lang['CSK_SETTINGS_ADMIN_EMAIL']     = 'البريد الإلكتروني للمشرف';
$lang['CSK_SETTINGS_ADMIN_EMAIL_TIP'] = 'عنوان البريد الإلكتروني الذي يتم إرسال إشعارات الموقع إليه.';

// Server email.
$lang['CSK_SETTINGS_SERVER_EMAIL']     = 'البريد الإلكتروني للخادم';
$lang['CSK_SETTINGS_SERVER_EMAIL_TIP'] = 'عنوان البريد الإلكتروني المستخدم لإرسال رسائل إلكترونية إلى المستخدمين. يمكنك استخدام "noreply@ ..." أو عنوان بريد إلكتروني موجود.';

// Mail protocol.
$lang['CSK_SETTINGS_MAIL_PROTOCOL'] = 'بروتوكول البريد';
$lang['CSK_SETTINGS_MAIL_PROTOCOL_TIP'] = 'اختر بروتوكول البريد الذي تريد إرسال رسائل البريد الإلكتروني به.';

// Sendmail Path.
$lang['CSK_SETTINGS_SENDMAIL_PATH'] = 'مسار Sendmail';
$lang['CSK_SETTINGS_SENDMAIL_PATH_TIP'] = 'أدخل مسار Sendmail. الافتراضي: " /usr/sbin/sendmail". مطلوب فقط في حالة استخدام بروتوكول Sendmail.';

// SMTP host.
$lang['CSK_SETTINGS_SMTP_HOST'] = 'مضيف SMTP';
$lang['CSK_SETTINGS_SMTP_HOST_TIP'] = 'أدخل اسم مضيف SMTP (على سبيل المثال: smtp.gmail.com). مطلوب فقط عند استخدام بروتوكول SMTP.';

// SMTP port.
$lang['CSK_SETTINGS_SMTP_PORT'] = 'منفذ SMTP';
$lang['CSK_SETTINGS_SMTP_PORT_TIP'] = 'أدخل رقم منفذ SMTP الذي يقدمه المضيف. مطلوب فقط عند استخدام بروتوكول SMTP.';

// SMTP crypt.
$lang['CSK_SETTINGS_SMTP_CRYPTO'] = 'تشفير SMTP';
$lang['CSK_SETTINGS_SMTP_CRYPTO_TIP'] = 'اختر تشفير SMTP.';

// SMTP user.
$lang['CSK_SETTINGS_SMTP_USER'] = 'اسم مستخدم SMTP';
$lang['CSK_SETTINGS_SMTP_USER_TIP'] = 'أدخل اسم المستخدم لحساب SMTP.';

// SMTP pass.
$lang['CSK_SETTINGS_SMTP_PASS'] = 'كلمة مرور SMTP';
$lang['CSK_SETTINGS_SMTP_PASS_TIP'] = 'أدخل كلمة المرور لحساب SMTP.';

// ------------------------------------------------------------------------
// Upload Settings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_TAB_UPLOAD'] = 'التحميلات';

// Upload path.
$lang['CSK_SETTINGS_UPLOAD_PATH'] = 'مسار التحميل';
$lang['CSK_SETTINGS_UPLOAD_PATH_TIP'] = 'المسار الذي يتم تحميل الملفات المسموح بها إليه. الافتراضي: content/uploads/';

// Allowed file types.
$lang['CSK_SETTINGS_ALLOWED_TYPES'] = 'الملفات المسموح بها';
$lang['CSK_SETTINGS_ALLOWED_TYPES_TIP'] = 'قائمة الملفات التي يسمح بتحميلها. استخدم "|" للفصل بين الأنواع.';

// Max file sizes.
$lang['CSK_SETTINGS_MAX_SIZE'] = 'الحد الأقصى لحجم الملف';
$lang['CSK_SETTINGS_MAX_SIZE_TIP'] = 'الحجم الأقصى للملفات بالكيلوبايت. صفر لإزالة الحدود.';

// Images min width and height
$lang['CSK_SETTINGS_MIN_WIDTH']      = 'أدنى عرض';
$lang['CSK_SETTINGS_MIN_WIDTH_TIP']  = 'أدنى عرض بالبكسل. صفر بلا حدود.';
$lang['CSK_SETTINGS_MIN_HEIGHT']     = 'أدنى ارتفاع';
$lang['CSK_SETTINGS_MIN_HEIGHT_TIP'] = 'أدنى ارتفاع بالبكسل. صفر لإزالة الحدود.';

// Images max width and height
$lang['CSK_SETTINGS_MAX_WIDTH']      = 'أقصى عرض';
$lang['CSK_SETTINGS_MAX_WIDTH_TIP']  = 'أقصى عرض بالبكسل. صفر لإزالة الحدود.';
$lang['CSK_SETTINGS_MAX_HEIGHT']     = 'أقصى ارتفاع';
$lang['CSK_SETTINGS_MAX_HEIGHT_TIP'] = 'أقصى ارتفاع بالبكسل. صفر لإزالة الحدود.';

// ------------------------------------------------------------------------
// Users Settings.
// ------------------------------------------------------------------------
$lang['CSK_SETTINGS_TAB_USERS'] = 'المستخدمون';

// Allow registration.
$lang['CSK_SETTINGS_ALLOW_REGISTRATION']     = 'السماح بالتسجيل';
$lang['CSK_SETTINGS_ALLOW_REGISTRATION_TIP'] = 'ما إذا كان سيتم السماح للمستخدمين بإنشاء حساب على موقعك أم لا.';

// Email activation.
$lang['CSK_SETTINGS_EMAIL_ACTIVATION']     = 'تنشيط البريد الإلكتروني';
$lang['CSK_SETTINGS_EMAIL_ACTIVATION_TIP'] = 'ما إذا كان يلزم على المستخدمين التحقق من عناوين بريدهم الإلكتروني قبل السماح لهم بتسجيل الدخول.';

// Manual activation.
$lang['CSK_SETTINGS_MANUAL_ACTIVATION']     = 'تشغيل يدوي';
$lang['CSK_SETTINGS_MANUAL_ACTIVATION_TIP'] = 'ما إذا كان سيتم التحقق من حسابات المستخدمين يدويا أم لا.';

// Login type.
$lang['CSK_SETTINGS_LOGIN_TYPE']     = 'نوع تسجيل الدخول';
$lang['CSK_SETTINGS_LOGIN_TYPE_TIP'] = 'يمكن للمستخدمين تسجيل الدخول باستخدام أسماء المستخدمين وعناوين البريد الإلكتروني أو كليهما.';

// Allow multi sessions.
$lang['CSK_SETTINGS_ALLOW_MULTI_SESSION']     = 'السماح بالجلسات المتعددة';
$lang['CSK_SETTINGS_ALLOW_MULTI_SESSION_TIP'] = 'السماح لعدة مستخدمين بتسجيل الدخول إلى نفس الحساب في نفس الوقت.';

// Use Gravatar.
$lang['CSK_SETTINGS_USE_GRAVATAR']     = 'استخدام غرافاتار';
$lang['CSK_SETTINGS_USE_GRAVATAR_TIP'] = 'استخدام غرافاتار أو السماح للمستخدمين بتحميل الصور الخاصة بهم.';
